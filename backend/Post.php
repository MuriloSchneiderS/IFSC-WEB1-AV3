<?php
class Post{
    private $id;
    private $mensagem;
    private $status;
    private $data_criacao;

    public function __construct($id, $mensagem, $status, $data_criacao){
        $this->id = $id;
        $this->mensagem = $mensagem;
        $this->status = $status;
        $this->data_criacao = $data_criacao;
    }

    public function getId(){
        return $this->id;
    }
    public function getMensagem(){
        return $this->mensagem;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getDataCriacao(){
        return $this->data_criacao;
    }
}
?>