<?php
require_once 'Conexao.php';
require_once '../model/Paciente.php';

class PacienteDAO {
    private $conexao;

    public function __construct() {
        $this->conexao = Conexao::getConexao();
    }

    public function salvar(Paciente $paciente) {
        $stmt = $this->conexao->prepare("INSERT INTO pacientes (nome, data_nascimento, sexo, telefone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$paciente->getNome(), $paciente->getDataNascimento(), $paciente->getSexo(), $paciente->getTelefone()]);
    }

    public function listar() {
        $stmt = $this->conexao->query("SELECT * FROM pacientes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id_paciente) {
        $stmt = $this->conexao->prepare("SELECT * FROM pacientes WHERE id_paciente = ?");
        $stmt->execute([$id_paciente]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar(Paciente $paciente) {
        $stmt = $this->conexao->prepare("UPDATE pacientes SET nome = ?, data_nascimento = ?, sexo = ?, telefone = ? WHERE id_paciente = ?");
        $stmt->execute([$paciente->getNome(), $paciente->getDataNascimento(), $paciente->getSexo(), $paciente->getTelefone(), $paciente->getIdPaciente()]);
    }

    public function deletar($id_paciente) {
        $stmt = $this->conexao->prepare("DELETE FROM pacientes WHERE id_paciente = ?");
        $stmt->execute([$id_paciente]);
    }
}
?>
