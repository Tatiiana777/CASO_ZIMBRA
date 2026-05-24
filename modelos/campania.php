<?php
class Campania implements JsonSerializable {
    private $id_campania;
    private $nombre;
    private $descripcion;
    private $fecha_inicio;
    private $fecha_fin;
    private $costo;
    private $estado;
    private $id_marketing;
    private $id_usuario;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_campania' => $this->id_campania,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'costo' => $this->costo,
            'estado' => $this->estado,
            'id_marketing' => $this->id_marketing,
            'id_usuario' => $this->id_usuario,
        ];
    }

    public function getIdCampania() { return $this->id_campania; }

    public function setIdCampania($id_campania) { $this->id_campania = $id_campania; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getDescripcion() { return $this->descripcion; }

    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }

    public function getFechaInicio() { return $this->fecha_inicio; }

    public function setFechaInicio($fecha_inicio) { $this->fecha_inicio = $fecha_inicio; }

    public function getFechaFin() { return $this->fecha_fin; }

    public function setFechaFin($fecha_fin) { $this->fecha_fin = $fecha_fin; }

    public function getCosto() { return $this->costo; }

    public function setCosto($costo) { $this->costo = $costo; }

    public function getEstado() { return $this->estado; }

    public function setEstado($estado) { $this->estado = $estado; }

    public function getIdMarketing() { return $this->id_marketing; }

    public function setIdMarketing($id_marketing) { $this->id_marketing = $id_marketing; }

    public function getIdUsuario() { return $this->id_usuario; }

    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

}
