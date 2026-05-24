<?php
class Marketing implements JsonSerializable {
    private $id_marketing;
    private $nombre;
    private $descripcion;
    private $presupuesto;
    private $fecha_creacion;
    private $id_empresa;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_marketing' => $this->id_marketing,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'presupuesto' => $this->presupuesto,
            'fecha_creacion' => $this->fecha_creacion,
            'id_empresa' => $this->id_empresa,
        ];
    }

    public function getIdMarketing() { return $this->id_marketing; }

    public function setIdMarketing($id_marketing) { $this->id_marketing = $id_marketing; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getDescripcion() { return $this->descripcion; }

    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }

    public function getPresupuesto() { return $this->presupuesto; }

    public function setPresupuesto($presupuesto) { $this->presupuesto = $presupuesto; }

    public function getFechaCreacion() { return $this->fecha_creacion; }

    public function setFechaCreacion($fecha_creacion) { $this->fecha_creacion = $fecha_creacion; }

    public function getIdEmpresa() { return $this->id_empresa; }

    public function setIdEmpresa($id_empresa) { $this->id_empresa = $id_empresa; }

}
