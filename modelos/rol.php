<?php
class Rol implements JsonSerializable {
    private $id_rol;
    private $nombre_rol;

    function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_rol' => $this->id_rol,
            'nombrerol' => $this->nombre_rol
        ];
    }

    public function getId_rol() { return $this->id_rol; }

    public function setId_rol($id_rol) { $this->id_rol = $id_rol; }

    public function getNombre_rol() { return $this->nombre_rol; }

    public function setNombre_rol($nombre_rol) { $this->nombre_rol = $nombre_rol; }
}
?>