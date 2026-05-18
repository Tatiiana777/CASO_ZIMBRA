<?php
class usuario implements JsonSerializable {
    private $id_usuario;
    private $nombre;
    private $correo;
    private $contrasenia;
    private $telefono;
    private $id_rol;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_usuario' => $this->id_usuario,
            'nombre' => $this->nombre,
            'correo' => $this->correo,
            'contrasenia' => $this->contrasenia,
            'telefono' => $this->telefono,
            'id_rol' => $this->id_rol,
        ];
    }

    public function getIdUsuario() { return $this->id_usuario; }

    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getCorreo() { return $this->correo; }

    public function setCorreo($correo) { $this->correo = $correo; }

    public function getContrasenia() { return $this->contrasenia; }

    public function setContrasenia($contrasenia) { $this->contrasenia = $contrasenia; }

    public function getTelefono() { return $this->telefono; }

    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getIdRol() { return $this->id_rol; }

    public function setIdRol($id_rol) { $this->id_rol = $id_rol; }

}