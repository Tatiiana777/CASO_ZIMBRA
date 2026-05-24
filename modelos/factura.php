<?php
class Factura implements JsonSerializable {
    private $id_factura;
    private $fecha_emision;
    private $total;
    private $estado;
    private $id_pedido;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_factura' => $this->id_factura,
            'fecha_emision' => $this->fecha_emision,
            'total' => $this->total,
            'estado' => $this->estado,
            'id_pedido' => $this->id_pedido,
        ];
    }

    public function getIdFactura() { return $this->id_factura; }

    public function setIdFactura($id_factura) { $this->id_factura = $id_factura; }

    public function getFechaEmision() { return $this->fecha_emision; }

    public function setFechaEmision($fecha_emision) { $this->fecha_emision = $fecha_emision; }

    public function getTotal() { return $this->total; }

    public function setTotal($total) { $this->total = $total; }

    public function getEstado() { return $this->estado; }

    public function setEstado($estado) { $this->estado = $estado; }

    public function getIdPedido() { return $this->id_pedido; }

    public function setIdPedido($id_pedido) { $this->id_pedido = $id_pedido; }

}
