<?php
class Cliente_Campania implements JsonSerializable {
    private $id_cliente_campania;
    private $fecha_contacto;
    private $estado;
    private $id_cliente;
    private $id_campania;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_cliente_campania' => $this->id_cliente_campania,
            'fecha_contacto' => $this->fecha_contacto,
            'estado' => $this->estado,
            'id_cliente' => $this->id_cliente,
            'id_campania' => $this->id_campania,
        ];
    }

    public function getIdClienteCampania() { return $this->id_cliente_campania; }

    public function setIdClienteCampania($id_cliente_campania) { $this->id_cliente_campania = $id_cliente_campania; }

    public function getFechaContacto() { return $this->fecha_contacto; }

    public function setFechaContacto($fecha_contacto) { $this->fecha_contacto = $fecha_contacto; }

    public function getEstado() { return $this->estado; }

    public function setEstado($estado) { $this->estado = $estado; }

    public function getIdCliente() { return $this->id_cliente; }

    public function setIdCliente($id_cliente) { $this->id_cliente = $id_cliente; }

    public function getIdCampania() { return $this->id_campania; }

    public function setIdCampania($id_campania) { $this->id_campania = $id_campania; }

}
