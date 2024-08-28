<?php
require_once 'Conexao.php';
require_once '../model/Alerta.php';

class AlertaDAO {
    private $conexao;

    public function __construct() {
        $this->conexao = Conexao::getConexao();
    }

    public function salvar(Alerta $alerta) {
        $stmt = $this->conexao->prepare("INSERT INTO alertas (id_paciente, id_medicamento, data_alerta, hora_alerta) VALUES (?, ?, ?, ?)");
        $stmt->execute([$alerta->getIdPaciente(), $alerta->getIdMedicamento(), $alerta->getDataAlerta(), $alerta->getHoraAlerta()]);
    }

    public function listar() {
        $stmt = $this->conexao->query("SELECT * FROM alertas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id_alerta) {
        $stmt = $this->conexao->prepare("SELECT * FROM alertas WHERE id_alerta = ?");
        $stmt->execute([$id_alerta]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar(Alerta $alerta) {
        $stmt = $this->conexao->prepare("UPDATE alertas SET id_paciente = ?, id_medicamento = ?, data_alerta = ?, hora_alerta = ? WHERE id_alerta = ?");
        $stmt->execute([$alerta->getIdPaciente(), $alerta->getIdMedicamento(), $alerta->getDataAlerta(), $alerta->getHoraAlerta(), $alerta->getIdAlerta()]);
    }

    public function deletar($id_alerta) {
        $stmt = $this->conexao->prepare("DELETE FROM alertas WHERE id_alerta = ?");
        $stmt->execute([$id_alerta]);
    }

    public function listarAlertasPorPaciente($id_paciente) {
        $stmt = $this->conexao->prepare("SELECT * FROM alertas WHERE id_paciente = ?");
        $stmt->execute([$id_paciente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
