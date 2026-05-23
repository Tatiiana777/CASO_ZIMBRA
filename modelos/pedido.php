<?php
class Pedido implements JsonSerializable {
    private $id_pedido;
    private $fecha;
    private $estado;
    private $id_cliente;
    private $id_empleado;
    private $id_propuesta;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_pedido' => $this->id_pedido,
            'fecha' => $this->fecha,
            'estado' => $this->estado,
            'id_cliente' => $this->id_cliente,
            'id_empleado' => $this->id_empleado,
            'id_propuesta' => $this->id_propuesta,
        ];
    }

    public function getIdPedido() { return $this->id_pedido; }

    public function setIdPedido($id_pedido) { $this->id_pedido = $id_pedido; }

    public function getFecha() { return $this->fecha; }

    public function setFecha($fecha) { $this->fecha = $fecha; }

    public function getEstado() { return $this->estado; }

    public function setEstado($estado) { $this->estado = $estado; }

    public function getIdCliente() { return $this->id_cliente; }

    public function setIdCliente($id_cliente) { $this->id_cliente = $id_cliente; }

    public function getIdEmpleado() { return $this->id_empleado; }

    public function setIdEmpleado($id_empleado) { $this->id_empleado = $id_empleado; }

    public function getIdPropuesta() { return $this->id_propuesta; }

    public function setIdPropuesta($id_propuesta) { $this->id_propuesta = $id_propuesta; }

}
