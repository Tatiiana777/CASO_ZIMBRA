<?php
class Empleado implements JsonSerializable {
    private $id_empleado;
    private $nombre;
    private $cargo;
    private $telefono;
    private $correo;
    private $id_usuario;
    private $id_empresa;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_empleado' => $this->id_empleado,
            'nombre' => $this->nombre,
            'cargo' => $this->cargo,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'id_usuario' => $this->id_usuario,
            'id_empresa' => $this->id_empresa,
        ];
    }

    public function getIdEmpleado() { return $this->id_empleado; }

    public function setIdEmpleado($id_empleado) { $this->id_empleado = $id_empleado; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getCargo() { return $this->cargo; }

    public function setCargo($cargo) { $this->cargo = $cargo; }

    public function getTelefono() { return $this->telefono; }

    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getCorreo() { return $this->correo; }

    public function setCorreo($correo) { $this->correo = $correo; }

    public function getIdUsuario() { return $this->id_usuario; }

    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

    public function getIdEmpresa() { return $this->id_empresa; }

    public function setIdEmpresa($id_empresa) { $this->id_empresa = $id_empresa; }

}
