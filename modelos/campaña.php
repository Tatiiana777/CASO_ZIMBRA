<?php
class campaña implements JsonSerializable {
    private $id_campaña;
    private $nombre;
    private $descripcion;
    private $fecha_inicio;
    private $fecha_fin;
    private $presupuesto;
    private $estado;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_campaña' => $this->id_campaña,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'presupuesto' => $this->presupuesto,
            'estado' => $this->estado,
        ];
    }

    public function getIdCampaña() { return $this->id_campaña; }

    public function setIdCampaña($id_campaña) { $this->id_campaña = $id_campaña; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getDescripcion() { return $this->descripcion; }

    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }

    public function getFechaInicio() { return $this->fecha_inicio; }

    public function setFechaInicio($fecha_inicio) { $this->fecha_inicio = $fecha_inicio; }

    public function getFechaFin() { return $this->fecha_fin; }

    public function setFechaFin($fecha_fin) { $this->fecha_fin = $fecha_fin; }

    public function getPresupuesto() { return $this->presupuesto; }

    public function setPresupuesto($presupuesto) { $this->presupuesto = $presupuesto; }

    public function getEstado() { return $this->estado; }

    public function setEstado($estado) { $this->estado = $estado; }

}