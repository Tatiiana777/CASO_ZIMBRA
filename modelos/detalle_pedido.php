<?php
class Detalle_Pedido implements JsonSerializable {
    private $id_detalle_pedido;
    private $cantidad;
    private $precio_unitario;
    private $subtotal;
    private $id_pedido;
    private $id_producto;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_detalle_pedido' => $this->id_detalle_pedido,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $this->precio_unitario,
            'subtotal' => $this->subtotal,
            'id_pedido' => $this->id_pedido,
            'id_producto' => $this->id_producto,
        ];
    }

    public function getIdDetallePedido() { return $this->id_detalle_pedido; }

    public function setIdDetallePedido($id_detalle_pedido) { $this->id_detalle_pedido = $id_detalle_pedido; }

    public function getCantidad() { return $this->cantidad; }

    public function setCantidad($cantidad) { $this->cantidad = $cantidad; }

    public function getPrecioUnitario() { return $this->precio_unitario; }

    public function setPrecioUnitario($precio_unitario) { $this->precio_unitario = $precio_unitario; }

    public function getSubtotal() { return $this->subtotal; }

    public function setSubtotal($subtotal) { $this->subtotal = $subtotal; }

    public function getIdPedido() { return $this->id_pedido; }

    public function setIdPedido($id_pedido) { $this->id_pedido = $id_pedido; }

    public function getIdProducto() { return $this->id_producto; }

    public function setIdProducto($id_producto) { $this->id_producto = $id_producto; }

}
