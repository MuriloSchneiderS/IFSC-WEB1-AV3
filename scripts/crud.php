<?php
session_start();
require 'conexao.php';
if(isset($_POST['salvar_post'])){
    $mensagem = mysqli_real_escape_string($conexao, $_POST['mensagem']);
    $sql = "INSERT INTO recados (mensagem, status, data_criacao) VALUES ('$mensagem', '1', NOW())";
    if(mysqli_query($conexao, $sql)){
        // Sucesso
        header('Location: ../pages/index.php');
        exit();
    } else {
        // Erro
        echo 'Erro ao salvar o post: ' . mysqli_error($conexao);
    }
}
if(isset($_POST['editar_post'])){
    $id = mysqli_real_escape_string($conexao, $_POST['id_post']);
    $mensagem = mysqli_real_escape_string($conexao, $_POST['mensagem']);
    
    $sql = "UPDATE recados SET mensagem='$mensagem' WHERE id=$id";
    if(mysqli_query($conexao, $sql)){
        // Sucesso
        header('Location: ../pages/index.php');
        exit();
    } else {
        // Erro
        echo 'Erro ao editar o post: ' . mysqli_error($conexao);
    }
}
if(isset($_POST['excluir_post'])){
    $id = mysqli_real_escape_string($conexao, $_POST['id_post']);
    $sql = "DELETE FROM recados WHERE id=$id";
    if(mysqli_query($conexao, $sql)){
        // Sucesso
        header('Location: ../pages/index.php');
        exit();
    } else {
        // Erro
        echo 'Erro ao excluir o post: ' . mysqli_error($conexao);
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