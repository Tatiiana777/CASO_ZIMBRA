<?php
class Proveedor implements JsonSerializable {
    private $id_proveedor;
    private $nombre;
    private $nit;
    private $telefono;
    private $correo;
    private $direccion;
    private $activo;
    private $id_empresa;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_proveedor' => $this->id_proveedor,
            'nombre' => $this->nombre,
            'nit' => $this->nit,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'direccion' => $this->direccion,
            'activo' => $this->activo,
            'id_empresa' => $this->id_empresa,
        ];
    }

    public function getIdProveedor() { return $this->id_proveedor; }

    public function setIdProveedor($id_proveedor) { $this->id_proveedor = $id_proveedor; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getNit() { return $this->nit; }

    public function setNit($nit) { $this->nit = $nit; }

    public function getTelefono() { return $this->telefono; }

    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getCorreo() { return $this->correo; }

    public function setCorreo($correo) { $this->correo = $correo; }

    public function getDireccion() { return $this->direccion; }

    public function setDireccion($direccion) { $this->direccion = $direccion; }

    public function getActivo() { return $this->activo; }

    public function setActivo($activo) { $this->activo = $activo; }

    public function getIdEmpresa() { return $this->id_empresa; }

    public function setIdEmpresa($id_empresa) { $this->id_empresa = $id_empresa; }

}
