<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once '../database/Conexao.php';
require_once 'Post.php';
require_once 'PostDao.php';

$conexao = new Conexao();
$db = $conexao->getConnection();

$postDao = new PostDao($db);

$method = $_SERVER['REQUEST_METHOD'];

$action = $_GET['action'] ?? '';

$data = json_decode(file_get_contents('php://input'));

switch ($action) {
    case 'create':
        if ($method == 'POST') {
            $post = new Post($data->mensagem, $data->status, $data->data_criacao);
            
            if ($postDao->create($post)) {
                http_response_code(204);
                exit;
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Erro ao criar post.']);
            }
        }
        break;
        
    case 'readAll':
        if ($method == 'GET') {
            $posts = $postDao->readAll();
            echo json_encode($posts);
        }
    break;
            
    case 'readOne':
        if ($method == 'GET' && isset($_GET['id'])) {
            $post = $postDao->readOne($_GET['id']);
            if($post) {
                echo json_encode($post);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Post não encontrado.']);
            }
        }
    break;
                
    case 'favorite':
        if ($method == 'POST') {
            $id = $data->id;
            $post = $postDao->readOne($id);
            $post->toggleStatus();
            
            if ($postDao->update($post)) {
                http_response_code(204);
                exit;
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Erro ao favoritar post.']);
            }
        }
    break;

    case 'update':
        if ($method == 'POST') { 
            $post = new Post($data->mensagem, $data->status, $data->data_criacao, $data->id);
            
            if ($postDao->update($post)) {
                http_response_code(204);
                exit;
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Erro ao atualizar post.']);
            }
        }
    break;
                        
    case 'delete':
        if ($method == 'POST') {
            $id = $data->id;
            if ($postDao->delete($id)) {
                http_response_code(204);
                exit;
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Erro ao deletar post.']);
            }
        }
    break;
                            
    default:
        http_response_code(400);
        echo json_encode(['message' => 'Ação inválida.']);
    break;
}
?>