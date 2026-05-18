<?php
class venta implements JsonSerializable {
    private $id_venta;
    private $fecha_cierre;
    private $valor_final;
    private $metodo_pago;
    private $id_propuesta;
    private $id_usuario;
    private $id_lead;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_venta' => $this->id_venta,
            'fecha_cierre' => $this->fecha_cierre,
            'valor_final' => $this->valor_final,
            'metodo_pago' => $this->metodo_pago,
            'id_propuesta' => $this->id_propuesta,
            'id_usuario' => $this->id_usuario,
            'id_lead' => $this->id_lead,
        ];
    }

    public function getIdVenta() { return $this->id_venta; }

    public function setIdVenta($id_venta) { $this->id_venta = $id_venta; }

    public function getFechaCierre() { return $this->fecha_cierre; }

    public function setFechaCierre($fecha_cierre) { $this->fecha_cierre = $fecha_cierre; }

    public function getValorFinal() { return $this->valor_final; }

    public function setValorFinal($valor_final) { $this->valor_final = $valor_final; }

    public function getMetodoPago() { return $this->metodo_pago; }

    public function setMetodoPago($metodo_pago) { $this->metodo_pago = $metodo_pago; }

    public function getIdPropuesta() { return $this->id_propuesta; }

    public function setIdPropuesta($id_propuesta) { $this->id_propuesta = $id_propuesta; }

    public function getIdUsuario() { return $this->id_usuario; }

    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

    public function getIdLead() { return $this->id_lead; }

    public function setIdLead($id_lead) { $this->id_lead = $id_lead; }

}
