<?php
session_start();
require 'conexao.php';

if(isset($_POST['salvar_post'])){
    $id_post = isset($_POST['id_post']) ? $_POST['id_post'] : null;//Verifica se é edição(ja tem id) ou criação(id vazio)
    $mensagem = mysqli_real_escape_string($conexao, $_POST['mensagem']);//Escapa caracteres especiais para evitar SQL Injection

    if (!$conexao)
        die("Tentativa de conexao falha: " . mysqli_connect_error());
    if ($id_post) {
        //Atualizar
        $stmt = $conexao->prepare("UPDATE recados SET mensagem = ? WHERE id = ?");
        $stmt->bind_param("si", $mensagem, $id_post);
        $stmt->execute();
    } else {
        //Criar
        $stmt = $conexao->prepare("INSERT INTO recados (mensagem) VALUES (?)");
        $stmt->bind_param("s", $mensagem);
        $stmt->execute();
    }

    header('Location: ../pages/index.php');
    exit();
}

if(isset($_POST['editar_post'])){
    $id = mysqli_real_escape_string($conexao, $_POST['id_post']);
    //Salva o id do post e redireciona a mensagem para o campo de edição com o ID do post
    header("Location: ../pages/index.php?id=$id");
    exit();
}

if (isset($_POST['excluir_post'])) {
    if (!$conexao)
        die("Tentativa de conexao falha: " . mysqli_connect_error());
    //Salva e valida o id do post a ser deletado
    $id = mysqli_real_escape_string($conexao, $_POST['id_post']);
    if (!is_numeric($id)||$id<=0) {
        echo "Id invalido.";
        exit();
    }

    $stmt = $conexao->prepare("DELETE FROM recados WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        //Sucesso
        header('Location: ../pages/index.php');
        exit();
    } else {
        //Erro
        echo 'Erro ao deletar post: ' . $stmt->error;
    }
}


if (isset($_POST['favoritar_post'])) {
    if (!$conexao)
        die("Tentativa de conexao falha: " . mysqli_connect_error());

    $id = mysqli_real_escape_string($conexao, $_POST['id_post']);
    if (!is_numeric($id)||$id<=0) {
        echo "Id invalido.";
        exit();
    }

    if ($stmt = $conexao->prepare("SELECT status FROM recados WHERE id = ?")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && ($data = $result->fetch_assoc())) {
            $current_status = (int)$data['status'];

            //Alterna status entre 0 e 1
            $novo_status = ($current_status === 1)?0:1;

            if ($update_stmt = $conexao->prepare("UPDATE recados SET status = ? WHERE id = ?")) {
                $update_stmt->bind_param("ii", $novo_status, $id);
                if ($update_stmt->execute()) {
                    //Sucesso
                    header('Location: ../pages/index.php');
                    exit();
                } else {
                    //Erro
                    echo 'Erro ao atualizar o post: ' . $update_stmt->error;
                    exit();
                }
            }
        } else {
            echo 'Erro ao retornar o post: ' . $conexao->error;
            exit();
        }
    }
}

/*
CRUD de posts:
1. Deve ser uma área antes de todos os posts para criação e edição dos posts, caso
eu selecione para editar um post, o formulário deve se auto preencher com os
conteúdos para edição.
2. Quando eu criar ou editar um novo post não deve acontecer nenhum carregamento
na tela, a lista de posts deve ser atualizada de forma fluida.

Lista de posts:
1. Abaixo do CRUD de posts deve haver uma lista dos posts já cadastrados, cada um
com seu título, conteúdo, botão de editar e de excluir, a data de postagem, e algum
sinal que possa ser categorizado como lido ou favorito(uma estrela, ou sinal para
favoritar), e deve atualizar o banco de dados.
2. A lista deve carregar junto com a página de forma fluida.
3. O design de cada post deve ser no mínimo com bordas arredondadas e uma cor
diferente entre o título e corpo do texto.
4. Caso aperte no botão de excluir, deve solicitar uma confirmação se você quer
apagar este post.
5. Qualquer alteração nos posts(inserção, edição, exclusão) devem atualizar a tabela.
6. Deve estar listado como as favoritas em primeiro lugar seguido de outros posts
*/
?>