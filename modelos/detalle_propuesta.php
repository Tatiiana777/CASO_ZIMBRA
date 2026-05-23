<?php
class Detalle_Propuesta implements JsonSerializable {
    private $id_detalle_propuesta;
    private $cantidad;
    private $precio_unitario;
    private $descuento;
    private $subtotal;
    private $id_propuesta;
    private $id_producto;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_detalle_propuesta' => $this->id_detalle_propuesta,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $this->precio_unitario,
            'descuento' => $this->descuento,
            'subtotal' => $this->subtotal,
            'id_propuesta' => $this->id_propuesta,
            'id_producto' => $this->id_producto,
        ];
    }

    public function getIdDetallePropuesta() { return $this->id_detalle_propuesta; }

    public function setIdDetallePropuesta($id_detalle_propuesta) { $this->id_detalle_propuesta = $id_detalle_propuesta; }

    public function getCantidad() { return $this->cantidad; }

    public function setCantidad($cantidad) { $this->cantidad = $cantidad; }

    public function getPrecioUnitario() { return $this->precio_unitario; }

    public function setPrecioUnitario($precio_unitario) { $this->precio_unitario = $precio_unitario; }

    public function getDescuento() { return $this->descuento; }

    public function setDescuento($descuento) { $this->descuento = $descuento; }

    public function getSubtotal() { return $this->subtotal; }

    public function setSubtotal($subtotal) { $this->subtotal = $subtotal; }

    public function getIdPropuesta() { return $this->id_propuesta; }

    public function setIdPropuesta($id_propuesta) { $this->id_propuesta = $id_propuesta; }

    public function getIdProducto() { return $this->id_producto; }

    public function setIdProducto($id_producto) { $this->id_producto = $id_producto; }

}
