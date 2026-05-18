<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/producto_servicio.php');

class Producto_servicio_crud {
    public function __construct() {}

    public function create($producto_servicio) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO producto_servicio (nombre, descripcion, precio_base) VALUES (:nombre, :descripcion, :precio_base)');
        $crear->bindValue(':nombre', $producto_servicio->getNombre());
        $crear->bindValue(':descripcion', $producto_servicio->getDescripcion());
        $crear->bindValue(':precio_base', $producto_servicio->getPrecioBase());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM producto_servicio');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new producto_servicio();

            $nuevo->setIdProductoServicio($registro['id_producto_servicio']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setDescripcion($registro['descripcion']);
            $nuevo->setPrecioBase($registro['precio_base']);

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

        $nuevo = new producto_servicio();

        $nuevo->setIdProductoServicio($registro['id_producto_servicio']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setDescripcion($registro['descripcion']);
        $nuevo->setPrecioBase($registro['precio_base']);

        return $nuevo;
    }

    public function update($producto_servicio) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE producto_servicio
            SET nombre = :nombre, descripcion = :descripcion, precio_base = :precio_base
            WHERE id_producto_servicio = :id_producto_servicio'
        );

        $actualizar->bindValue(':id_producto_servicio', $producto_servicio->getIdProductoServicio());
        $actualizar->bindValue(':nombre', $producto_servicio->getNombre());
        $actualizar->bindValue(':descripcion', $producto_servicio->getDescripcion());
        $actualizar->bindValue(':precio_base', $producto_servicio->getPrecioBase());

        $actualizar->execute();
    }

    public function delete($id_producto_servicio) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM producto_servicio WHERE id_producto_servicio = :id_producto_servicio');
        $eliminar->bindValue(':id_producto_servicio', $id_producto_servicio);
        $eliminar->execute();
    }
}
