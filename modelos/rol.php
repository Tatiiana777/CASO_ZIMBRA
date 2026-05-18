<?php
class rol implements JsonSerializable {
    private $id_rol;
    private $nombre_rol;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_rol' => $this->id_rol,
            'nombre_rol' => $this->nombre_rol,
        ];
    }

    public function getIdRol() { return $this->id_rol; }

    public function setIdRol($id_rol) { $this->id_rol = $id_rol; }

    public function getNombreRol() { return $this->nombre_rol; }

    public function setNombreRol($nombre_rol) { $this->nombre_rol = $nombre_rol; }

}