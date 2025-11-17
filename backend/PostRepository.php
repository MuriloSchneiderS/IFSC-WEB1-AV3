<?php
class PostRepository {
    private $conn;
    private $table_name = "recados";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(Post $post) {
        $query = "INSERT INTO " . $this->table_name . " (mensagem, status, data_criacao) VALUES (:mensagem, :status, :data_criacao)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":mensagem", $post->getMensagem());
        $stmt->bindParam(":status", $post->getStatus());
        $stmt->bindParam(":data_criacao", $post->getDataCriacao());

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT id, mensagem, status, data_criacao FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function readOne($id) {
        $query = "SELECT id, mensagem, status, data_criacao FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(Post $post) {
        $query = "UPDATE " . $this->table_name . "
                  SET mensagem = :mensagem, status = :status, data_criacao = :data_criacao
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":mensagem", $post->getMensagem());
        $stmt->bindParam(":status", $post->getStatus());
        $stmt->bindParam(":data_criacao", $post->getDataCriacao());
        $stmt->bindParam(":id", $post->getId());

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>