<?php
class Post{
    private $id;
    private $mensagem;
    private $status;
    private $data_criacao;

    //Construtor com parametro id opcional(para caso de novo post)
    public function __construct(string $mensagem, string $status, string $data_criacao, ?int $id = null){
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
    public function toggleStatus(){
        $this->status = $this->status==1?0:1;
    }
    public function getDataCriacao(){
        return $this->data_criacao;
    }
}
?>