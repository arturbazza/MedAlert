<?php
class Alerta {
    private $id_alerta;
    private $id_paciente;
    private $id_medicamento;
    private $data_alerta;
    private $hora_alerta;

    public function getIdAlerta() {
        return $this->id_alerta;
    }

    public function setIdAlerta($id_alerta) {
        $this->id_alerta = $id_alerta;
    }

    public function getIdPaciente() {
        return $this->id_paciente;
    }

    public function setIdPaciente($id_paciente) {
        $this->id_paciente = $id_paciente;
    }

    public function getIdMedicamento() {
        return $this->id_medicamento;
    }

    public function setIdMedicamento($id_medicamento) {
        $this->id_medicamento = $id_medicamento;
    }

    public function getDataAlerta() {
        return $this->data_alerta;
    }

    public function setDataAlerta($data_alerta) {
        $this->data_alerta = $data_alerta;
    }

    public function getHoraAlerta() {
        return $this->hora_alerta;
    }

    public function setHoraAlerta($hora_alerta) {
        $this->hora_alerta = $hora_alerta;
    }
}
?>
