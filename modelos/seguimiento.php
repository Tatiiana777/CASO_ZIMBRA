<?php
class seguimiento implements JsonSerializable {
    private $id_seguimiento;
    private $fecha;
    private $canal;
    private $resultado;
    private $proxima_accion;
    private $id_lead;
    private $id_usuario;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_seguimiento' => $this->id_seguimiento,
            'fecha' => $this->fecha,
            'canal' => $this->canal,
            'resultado' => $this->resultado,
            'proxima_accion' => $this->proxima_accion,
            'id_lead' => $this->id_lead,
            'id_usuario' => $this->id_usuario,
        ];
    }

    public function getIdSeguimiento() { return $this->id_seguimiento; }

    public function setIdSeguimiento($id_seguimiento) { $this->id_seguimiento = $id_seguimiento; }

    public function getFecha() { return $this->fecha; }

    public function setFecha($fecha) { $this->fecha = $fecha; }

    public function getCanal() { return $this->canal; }

    public function setCanal($canal) { $this->canal = $canal; }

    public function getResultado() { return $this->resultado; }

    public function setResultado($resultado) { $this->resultado = $resultado; }

    public function getProximaAccion() { return $this->proxima_accion; }

    public function setProximaAccion($proxima_accion) { $this->proxima_accion = $proxima_accion; }

    public function getIdLead() { return $this->id_lead; }

    public function setIdLead($id_lead) { $this->id_lead = $id_lead; }

    public function getIdUsuario() { return $this->id_usuario; }

    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

}