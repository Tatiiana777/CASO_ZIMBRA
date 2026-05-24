<?php
class Empresa implements JsonSerializable {
    private $id_empresa;
    private $nombre;
    private $nit;
    private $direccion;
    private $telefono;
    private $sector;
    private $fecha_registro;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_empresa' => $this->id_empresa,
            'nombre' => $this->nombre,
            'nit' => $this->nit,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'sector' => $this->sector,
            'fecha_registro' => $this->fecha_registro,
        ];
    }

    public function getIdEmpresa() { return $this->id_empresa; }

    public function setIdEmpresa($id_empresa) { $this->id_empresa = $id_empresa; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getNit() { return $this->nit; }

    public function setNit($nit) { $this->nit = $nit; }

    public function getDireccion() { return $this->direccion; }

    public function setDireccion($direccion) { $this->direccion = $direccion; }

    public function getTelefono() { return $this->telefono; }

    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getSector() { return $this->sector; }

    public function setSector($sector) { $this->sector = $sector; }

    public function getFechaRegistro() { return $this->fecha_registro; }

    public function setFechaRegistro($fecha_registro) { $this->fecha_registro = $fecha_registro; }

}
