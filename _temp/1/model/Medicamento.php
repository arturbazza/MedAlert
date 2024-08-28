<?php
class Medicamento {
    private $id_medicamento;
    private $nome;
    private $descricao;
    private $dosagem;

    public function getIdMedicamento() {
        return $this->id_medicamento;
    }

    public function setIdMedicamento($id_medicamento) {
        $this->id_medicamento = $id_medicamento;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getDosagem() {
        return $this->dosagem;
    }

    public function setDosagem($dosagem) {
        $this->dosagem = $dosagem;
    }
}
?>
