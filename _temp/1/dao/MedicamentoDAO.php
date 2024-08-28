<?php
require_once 'Conexao.php';
require_once '../model/Medicamento.php';

class MedicamentoDAO {
    private $conexao;

    public function __construct() {
        $this->conexao = Conexao::getConexao();
    }

    public function salvar(Medicamento $medicamento) {
        $stmt = $this->conexao->prepare("INSERT INTO medicamentos (nome, descricao, dosagem) VALUES (?, ?, ?)");
        $stmt->execute([$medicamento->getNome(), $medicamento->getDescricao(), $medicamento->getDosagem()]);
    }

    public function listar() {
        $stmt = $this->conexao->query("SELECT * FROM medicamentos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id_medicamento) {
        $stmt = $this->conexao->prepare("SELECT * FROM medicamentos WHERE id_medicamento = ?");
        $stmt->execute([$id_medicamento]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar(Medicamento $medicamento) {
        $stmt = $this->conexao->prepare("UPDATE medicamentos SET nome = ?, descricao = ?, dosagem = ? WHERE id_medicamento = ?");
        $stmt->execute([$medicamento->getNome(), $medicamento->getDescricao(), $medicamento->getDosagem(), $medicamento->getIdMedicamento()]);
    }

    public function deletar($id_medicamento) {
        $stmt = $this->conexao->prepare("DELETE FROM medicamentos WHERE id_medicamento = ?");
        $stmt->execute([$id_medicamento]);
    }
}
?>
