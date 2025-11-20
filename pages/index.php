<?php
session_start();
require '../scripts/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
                <form id="postForm" action="../scripts/crud.php" method="POST">
                    <div class="mb-3">
                        <label for="mensagem" class="form-label">Mensagem</label>
                        <textarea id="mensagem" name="mensagem" class="form-control" rows="2" required><?php 
                        if (isset($_GET['id'])) {//Se tiver o id na URL(retornado pelo editar_post)
                            $id = intval($_GET['id']);
                            $query = "SELECT mensagem FROM recados WHERE id = $id";//Busca a mensagem no banco
                            $result = mysqli_query($conexao, $query);
                            $data = mysqli_fetch_assoc($result);
                            echo htmlspecialchars($data['mensagem']);//Preenche o textarea com a mensagem para edicao
                        }
                        ?></textarea>
                    </div>
                    <input type="hidden" name="id_post" value="<?php echo isset($_GET['id']) ? intval($_GET['id']) : ''; ?>">
                    <button name="salvar_post" type="submit" class="btn btn-success">Salvar Post</button>
                </form>
            </article>
            <article id="listaPosts" class="d-flex flex-column gap-4 mt-5">
                <!-- Posts -->
                <?php
                    $sql = 'SELECT id, mensagem, status, data_criacao FROM recados ORDER BY data_criacao DESC'; 
                    $posts = mysqli_query($conexao, $sql);
                    if(mysqli_num_rows($posts) > 0){
                        foreach($posts as $post){
                ?>
                <div class="post p-3 rounded shadow-sm bg-dark">
                    <div class="post-header d-flex justify-content-between align-items-center mb-2">
                        <small class="text-white-50"><?php echo date('d/m/Y H:i', strtotime($post['data_criacao'])); ?></small>
                        <div>
                            <form action="../scripts/crud.php" method="POST">
                                <input type="hidden" name="id_post" value="<?= htmlspecialchars($post['id']) ?>">
                                <button name="favoritar_post" type="submit" class="btn btn-sm btn-warning me-2">
                                    <!-- Ícone de estrela preenchida se for favorito(bi-star-fill / bi-star) -->
                                    <i class="bi bi-star<?= $post['status']==1? '-fill':'' ?>"></i>
                                </button>
                                <button name="editar_post" class="btn btn-sm btn-primary me-2">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button name="excluir_post" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="post-body">
                        <p class="mb-0"><?php echo htmlspecialchars($post['mensagem']); ?></p>
                    </div>
                </div>
                <?php
                        }
                    } else {
                        echo '<p>Nenhum post encontrado.</p>';
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