<?php
class Paciente {
    private $id_paciente;
    private $nome;
    private $data_nascimento;
    private $sexo;
    private $telefone;

    public function getIdPaciente() {
        return $this->id_paciente;
    }

    public function setIdPaciente($id_paciente) {
        $this->id_paciente = $id_paciente;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDataNascimento() {
        return $this->data_nascimento;
    }

    public function setDataNascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }
}
?>
