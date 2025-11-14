<?php
session_start();
require '../script/conexao.php'
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mural de Recados</title>
</head>
<body>
    <header class="sticky-top shadow-sm">
        <div class="container">
            <h1 class="py-3 mb-0">Mural de Recados</h1>
        </div>
    </header>
    <main class="container my-5">
        <section class="crud-section mb-5">
            <!-- CRUD -->
            <article class="mb-5">
                <h2 class="mb-2">Criar / Editar Post</h2>
                <form id="postForm">
                    <!--titulo não esta presente no banco de dados padrao do trabalho <div class="mb-1">
                        <label for="titulo" class="form-label">Título</label>
                        <input id="titulo" type="text" class="form-control" required>
                    </div>-->
                    <div class="mb-3">
                        <label for="conteudo" class="form-label">Conteúdo</label>
                        <textarea id="conteudo" class="form-control" rows="2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Post</button>
                </form>
            </article>
            <article id="listaPosts" class="d-flex flex-column gap-4 mt-5">
                <!-- Posts -->
                <?php
                    $sql = 'SELECT mensagem, status, data_criacao FROM posts ORDER BY data_postagem DESC'; 
                    $posts = mysqli_query($conexao, $sql);
                    while ($post = mysqli_fetch_assoc($posts)) {
                        $statusClass = $post['status'] ? 'border-success' : 'border-secondary';
                        echo '
                        <div class="card '.$statusClass.'">
                            <div class="card-header bg-light">
                                <strong>Postado em: '.date('d/m/Y H:i', strtotime($post['data_criacao'])).'</strong>
                            </div>
                            <div class="card-body">
                                <p class="card-text">'.$post['mensagem'].'</p>
                            </div>
                        </div>
                        ';
                    }
                ?>
            </article>
        </section>
    </main>
    <footer class="bg-dark text-white text-center py-4 mt-5 position-fixed bottom-0 w-100">
        <p>&copy; 2025 Mural de Recados. Todos os direitos reservados.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!--
A estrutura deve conter 
- um cabeçalho com o título da aplicação, 
- o conteúdo principal contendo os posts e uma área para criação/edição de posts, 
- e um rodapé de direitos reservados

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
-->