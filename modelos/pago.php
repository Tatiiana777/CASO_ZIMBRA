<?php
class Pago implements JsonSerializable {
    private $id_pago;
    private $fecha_pago;
    private $metodo_pago;
    private $valor;
    private $id_factura;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_pago' => $this->id_pago,
            'fecha_pago' => $this->fecha_pago,
            'metodo_pago' => $this->metodo_pago,
            'valor' => $this->valor,
            'id_factura' => $this->id_factura,
        ];
    }

    public function getIdPago() { return $this->id_pago; }

    public function setIdPago($id_pago) { $this->id_pago = $id_pago; }

    public function getFechaPago() { return $this->fecha_pago; }

    public function setFechaPago($fecha_pago) { $this->fecha_pago = $fecha_pago; }

    public function getMetodoPago() { return $this->metodo_pago; }

    public function setMetodoPago($metodo_pago) { $this->metodo_pago = $metodo_pago; }

    public function getValor() { return $this->valor; }

    public function setValor($valor) { $this->valor = $valor; }

    public function getIdFactura() { return $this->id_factura; }

    public function setIdFactura($id_factura) { $this->id_factura = $id_factura; }

}
