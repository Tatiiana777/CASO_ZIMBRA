<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/producto_servicio.php');

class Producto_Servicio_crud {
    public function __construct() {}

    public function create($producto_servicio) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO producto_servicio (nombre, descripcion, precio_base, stock, activo, id_proveedor) VALUES (:nombre, :descripcion, :precio_base, :stock, :activo, :id_proveedor)');
        $crear->bindValue(':nombre', $producto_servicio->getNombre());
        $crear->bindValue(':descripcion', $producto_servicio->getDescripcion());
        $crear->bindValue(':precio_base', $producto_servicio->getPrecioBase());
        $crear->bindValue(':stock', $producto_servicio->getStock());
        $crear->bindValue(':activo', $producto_servicio->getActivo());
        $crear->bindValue(':id_proveedor', $producto_servicio->getIdProveedor());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM producto_servicio');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Producto_Servicio();

            $nuevo->setIdProductoServicio($registro['id_producto_servicio']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setDescripcion($registro['descripcion']);
            $nuevo->setPrecioBase($registro['precio_base']);
            $nuevo->setStock($registro['stock']);
            $nuevo->setActivo($registro['activo']);
            $nuevo->setIdProveedor($registro['id_proveedor']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_producto_servicio) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM producto_servicio WHERE id_producto_servicio = :id_producto_servicio');

        $mostrar->bindValue(':id_producto_servicio', $id_producto_servicio);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Producto_Servicio();

        $nuevo->setIdProductoServicio($registro['id_producto_servicio']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setDescripcion($registro['descripcion']);
        $nuevo->setPrecioBase($registro['precio_base']);
        $nuevo->setStock($registro['stock']);
        $nuevo->setActivo($registro['activo']);
        $nuevo->setIdProveedor($registro['id_proveedor']);

        return $nuevo;
    }

    public function update($producto_servicio) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE producto_servicio
            SET nombre = :nombre, descripcion = :descripcion, precio_base = :precio_base, stock = :stock, activo = :activo, id_proveedor = :id_proveedor
            WHERE id_producto_servicio = :id_producto_servicio'
        );

        $actualizar->bindValue(':id_producto_servicio', $producto_servicio->getIdProductoServicio());
        $actualizar->bindValue(':nombre', $producto_servicio->getNombre());
        $actualizar->bindValue(':descripcion', $producto_servicio->getDescripcion());
        $actualizar->bindValue(':precio_base', $producto_servicio->getPrecioBase());
        $actualizar->bindValue(':stock', $producto_servicio->getStock());
        $actualizar->bindValue(':activo', $producto_servicio->getActivo());
        $actualizar->bindValue(':id_proveedor', $producto_servicio->getIdProveedor());

        $actualizar->execute();
    }

    public function delete($id_producto_servicio) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM producto_servicio WHERE id_producto_servicio = :id_producto_servicio');
        $eliminar->bindValue(':id_producto_servicio', $id_producto_servicio);
        $eliminar->execute();
    }
}
