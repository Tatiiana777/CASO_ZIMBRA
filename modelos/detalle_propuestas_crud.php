<?php
require_once('conexion.php');
require_once('detalle_propuestas.php');

class detalle_propuestas_crud {
    public function __construct() {}

    public function create($detalle_propuestas) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO detalle_propuestas (id_propuesta, cantidad, precio_unitario, id_producto_servicio) VALUES (:id_propuesta, :cantidad, :precio_unitario, :id_producto_servicio)');
        $crear->bindValue(':id_propuesta', $detalle_propuestas->getIdPropuesta());
        $crear->bindValue(':cantidad', $detalle_propuestas->getCantidad());
        $crear->bindValue(':precio_unitario', $detalle_propuestas->getPrecioUnitario());
        $crear->bindValue(':id_producto_servicio', $detalle_propuestas->getIdProductoServicio());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM detalle_propuestas');

        foreach ($mostrar->fetchAll() as $registro) {
            $nuevo = new detalle_propuestas();

            $nuevo->setIdDetallePropuestas($registro['id_detalle_propuestas']);
            $nuevo->setIdPropuesta($registro['id_propuesta']);
            $nuevo->setCantidad($registro['cantidad']);
            $nuevo->setPrecioUnitario($registro['precio_unitario']);
            $nuevo->setIdProductoServicio($registro['id_producto_servicio']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_detalle_propuestas) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM detalle_propuestas WHERE id_detalle_propuestas = :id_detalle_propuestas');

        $mostrar->bindValue(':id_detalle_propuestas', $id_detalle_propuestas);
        $mostrar->execute();

        $registro = $mostrar->fetch();

        $nuevo = new detalle_propuestas();

        $nuevo->setIdDetallePropuestas($registro['id_detalle_propuestas']);
        $nuevo->setIdPropuesta($registro['id_propuesta']);
        $nuevo->setCantidad($registro['cantidad']);
        $nuevo->setPrecioUnitario($registro['precio_unitario']);
        $nuevo->setIdProductoServicio($registro['id_producto_servicio']);

        return $nuevo;
    }

    public function update($detalle_propuestas) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE detalle_propuestas
            SET id_propuesta = :id_propuesta, cantidad = :cantidad, precio_unitario = :precio_unitario, id_producto_servicio = :id_producto_servicio
            WHERE id_detalle_propuestas = :id_detalle_propuestas'
        );

        $actualizar->bindValue(':id_detalle_propuestas', $detalle_propuestas->getIdDetallePropuestas());
        $actualizar->bindValue(':id_propuesta', $detalle_propuestas->getIdPropuesta());
        $actualizar->bindValue(':cantidad', $detalle_propuestas->getCantidad());
        $actualizar->bindValue(':precio_unitario', $detalle_propuestas->getPrecioUnitario());
        $actualizar->bindValue(':id_producto_servicio', $detalle_propuestas->getIdProductoServicio());

        $actualizar->execute();
    }

    public function delete($id_detalle_propuestas) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM detalle_propuestas WHERE id_detalle_propuestas = :id_detalle_propuestas');
        $eliminar->bindValue(':id_detalle_propuestas', $id_detalle_propuestas);
        $eliminar->execute();
    }
}
