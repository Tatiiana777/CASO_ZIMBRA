<?php
class producto_servicio implements JsonSerializable {
    private $id_producto_servicio;
    private $nombre;
    private $descripcion;
    private $precio_base;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_producto_servicio' => $this->id_producto_servicio,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio_base' => $this->precio_base,
        ];
    }

    public function getIdProductoServicio() { return $this->id_producto_servicio; }

    public function setIdProductoServicio($id_producto_servicio) { $this->id_producto_servicio = $id_producto_servicio; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getDescripcion() { return $this->descripcion; }

    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }

    public function getPrecioBase() { return $this->precio_base; }

    public function setPrecioBase($precio_base) { $this->precio_base = $precio_base; }

}
