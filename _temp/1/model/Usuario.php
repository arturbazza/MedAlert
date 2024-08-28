<?php
class Usuario {
    private $id_usuario;
    private $nome;
    private $email;
    private $senha;
    private $telefone;
    private $tipo_usuario;
    private $data_criacao;

    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getTipoUsuario() {
        return $this->tipo_usuario;
    }

    public function setTipoUsuario($tipo_usuario) {
        $this->tipo_usuario = $tipo_usuario;
    }

    public function getDataCriacao() {
        return $this->data_criacao;
    }

    public function setDataCriacao($data_criacao) {
        $this->data_criacao = $data_criacao;
    }
}
?>
