<?php
class Usuario implements JsonSerializable {
    private $id_usuario;
    private $nombre;
    private $correo;
    private $contrasena;
    private $telefono;
    private $activo;
    private $fecha_creacion;
    private $id_empresa;
    private $id_rol;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_usuario' => $this->id_usuario,
            'nombre' => $this->nombre,
            'correo' => $this->correo,
            'contrasena' => $this->contrasena,
            'telefono' => $this->telefono,
            'activo' => $this->activo,
            'fecha_creacion' => $this->fecha_creacion,
            'id_empresa' => $this->id_empresa,
            'id_rol' => $this->id_rol,
        ];
    }

    public function getIdUsuario() { return $this->id_usuario; }

    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getCorreo() { return $this->correo; }

    public function setCorreo($correo) { $this->correo = $correo; }

    public function getContrasena() { return $this->contrasena; }

    public function setContrasena($contrasena) { $this->contrasena = $contrasena; }

    public function getTelefono() { return $this->telefono; }

    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getActivo() { return $this->activo; }

    public function setActivo($activo) { $this->activo = $activo; }

    public function getFechaCreacion() { return $this->fecha_creacion; }

    public function setFechaCreacion($fecha_creacion) { $this->fecha_creacion = $fecha_creacion; }

    public function getIdEmpresa() { return $this->id_empresa; }

    public function setIdEmpresa($id_empresa) { $this->id_empresa = $id_empresa; }

    public function getIdRol() { return $this->id_rol; }

    public function setIdRol($id_rol) { $this->id_rol = $id_rol; }

}
