<?php
class detalle_propuestas implements JsonSerializable {
    private $id_detalle_propuestas;
    private $id_propuesta;
    private $cantidad;
    private $precio_unitario;
    private $id_producto_servicio;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_detalle_propuestas' => $this->id_detalle_propuestas,
            'id_propuesta' => $this->id_propuesta,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $this->precio_unitario,
            'id_producto_servicio' => $this->id_producto_servicio,
        ];
    }

    public function getIdDetallePropuestas() { return $this->id_detalle_propuestas; }

    public function setIdDetallePropuestas($id_detalle_propuestas) { $this->id_detalle_propuestas = $id_detalle_propuestas; }

    public function getIdPropuesta() { return $this->id_propuesta; }

    public function setIdPropuesta($id_propuesta) { $this->id_propuesta = $id_propuesta; }

    public function getCantidad() { return $this->cantidad; }

    public function setCantidad($cantidad) { $this->cantidad = $cantidad; }

    public function getPrecioUnitario() { return $this->precio_unitario; }

    public function setPrecioUnitario($precio_unitario) { $this->precio_unitario = $precio_unitario; }

    public function getIdProductoServicio() { return $this->id_producto_servicio; }

    public function setIdProductoServicio($id_producto_servicio) { $this->id_producto_servicio = $id_producto_servicio; }

}
