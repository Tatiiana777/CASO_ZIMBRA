<?php
class Propuesta implements JsonSerializable {
    private $id_propuesta;
    private $fecha_creacion;
    private $fecha_vigencia;
    private $valor_total;
    private $estado;
    private $observaciones;
    private $id_lead;
    private $id_usuario;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_propuesta' => $this->id_propuesta,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_vigencia' => $this->fecha_vigencia,
            'valor_total' => $this->valor_total,
            'estado' => $this->estado,
            'observaciones' => $this->observaciones,
            'id_lead' => $this->id_lead,
            'id_usuario' => $this->id_usuario,
        ];
    }

    public function getIdPropuesta() { return $this->id_propuesta; }

    public function setIdPropuesta($id_propuesta) { $this->id_propuesta = $id_propuesta; }

    public function getFechaCreacion() { return $this->fecha_creacion; }

    public function setFechaCreacion($fecha_creacion) { $this->fecha_creacion = $fecha_creacion; }

    public function getFechaVigencia() { return $this->fecha_vigencia; }

    public function setFechaVigencia($fecha_vigencia) { $this->fecha_vigencia = $fecha_vigencia; }

    public function getValorTotal() { return $this->valor_total; }

    public function setValorTotal($valor_total) { $this->valor_total = $valor_total; }

    public function getEstado() { return $this->estado; }

    public function setEstado($estado) { $this->estado = $estado; }

    public function getObservaciones() { return $this->observaciones; }

    public function setObservaciones($observaciones) { $this->observaciones = $observaciones; }

    public function getIdLead() { return $this->id_lead; }

    public function setIdLead($id_lead) { $this->id_lead = $id_lead; }

    public function getIdUsuario() { return $this->id_usuario; }

    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

}
