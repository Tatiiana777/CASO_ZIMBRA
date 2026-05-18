<?php
class lead implements JsonSerializable {
    private $id_lead;
    private $nombre;
    private $empresa;
    private $correo;
    private $telefono;
    private $pais;
    private $estado_contacto;
    private $id_campania;
    private $id_usuario;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_lead' => $this->id_lead,
            'nombre' => $this->nombre,
            'empresa' => $this->empresa,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'pais' => $this->pais,
            'estado_contacto' => $this->estado_contacto,
            'id_campania' => $this->id_campania,
            'id_usuario' => $this->id_usuario,
        ];
    }

    public function getIdLead() { return $this->id_lead; }

    public function setIdLead($id_lead) { $this->id_lead = $id_lead; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getEmpresa() { return $this->empresa; }

    public function setEmpresa($empresa) { $this->empresa = $empresa; }

    public function getCorreo() { return $this->correo; }

    public function setCorreo($correo) { $this->correo = $correo; }

    public function getTelefono() { return $this->telefono; }

    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getPais() { return $this->pais; }

    public function setPais($pais) { $this->pais = $pais; }

    public function getEstadoContacto() { return $this->estado_contacto; }

    public function setEstadoContacto($estado_contacto) { $this->estado_contacto = $estado_contacto; }

    public function getIdCampania() { return $this->id_campania; }

    public function setIdCampania($id_campania) { $this->id_campania = $id_campania; }

    public function getIdUsuario() { return $this->id_usuario; }

    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

}