<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/detalle_propuesta.php');

class Detalle_Propuesta_crud {
    public function __construct() {}

    public function create($detalle_propuesta) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO Detalle_Propuesta (cantidad, precio_unitario, descuento, id_propuesta, id_producto) VALUES (:cantidad, :precio_unitario, :descuento, :id_propuesta, :id_producto)');
        $crear->bindValue(':cantidad', $detalle_propuesta->getCantidad());
        $crear->bindValue(':precio_unitario', $detalle_propuesta->getPrecioUnitario());
        $crear->bindValue(':descuento', $detalle_propuesta->getDescuento());
        $crear->bindValue(':id_propuesta', $detalle_propuesta->getIdPropuesta());
        $crear->bindValue(':id_producto', $detalle_propuesta->getIdProducto());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM Detalle_Propuesta');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Detalle_Propuesta();

            $nuevo->setIdDetallePropuesta($registro['id_detalle']);
            $nuevo->setCantidad($registro['cantidad']);
            $nuevo->setPrecioUnitario($registro['precio_unitario']);
            $nuevo->setDescuento($registro['descuento']);
            $nuevo->setSubtotal($registro['subtotal']);
            $nuevo->setIdPropuesta($registro['id_propuesta']);
            $nuevo->setIdProducto($registro['id_producto']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_detalle_propuesta) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM Detalle_Propuesta WHERE id_detalle = :id_detalle_propuesta');

        $mostrar->bindValue(':id_detalle_propuesta', $id_detalle_propuesta);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Detalle_Propuesta();

        $nuevo->setIdDetallePropuesta($registro['id_detalle']);
        $nuevo->setCantidad($registro['cantidad']);
        $nuevo->setPrecioUnitario($registro['precio_unitario']);
        $nuevo->setDescuento($registro['descuento']);
        $nuevo->setSubtotal($registro['subtotal']);
        $nuevo->setIdPropuesta($registro['id_propuesta']);
        $nuevo->setIdProducto($registro['id_producto']);

        return $nuevo;
    }

    public function update($detalle_propuesta) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE Detalle_Propuesta
            SET cantidad = :cantidad, precio_unitario = :precio_unitario, descuento = :descuento, id_propuesta = :id_propuesta, id_producto = :id_producto
            WHERE id_detalle = :id_detalle_propuesta'
        );

        $actualizar->bindValue(':id_detalle_propuesta', $detalle_propuesta->getIdDetallePropuesta());
        $actualizar->bindValue(':cantidad', $detalle_propuesta->getCantidad());
        $actualizar->bindValue(':precio_unitario', $detalle_propuesta->getPrecioUnitario());
        $actualizar->bindValue(':descuento', $detalle_propuesta->getDescuento());
        $actualizar->bindValue(':id_propuesta', $detalle_propuesta->getIdPropuesta());
        $actualizar->bindValue(':id_producto', $detalle_propuesta->getIdProducto());

        $actualizar->execute();
    }

    public function delete($id_detalle_propuesta) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM Detalle_Propuesta WHERE id_detalle = :id_detalle_propuesta');
        $eliminar->bindValue(':id_detalle_propuesta', $id_detalle_propuesta);
        $eliminar->execute();
    }
}
