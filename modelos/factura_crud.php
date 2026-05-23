<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/factura.php');

class Factura_crud {
    public function __construct() {}

    public function create($factura) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO factura (fecha_emision, total, estado, id_pedido) VALUES (:fecha_emision, :total, :estado, :id_pedido)');
        $crear->bindValue(':fecha_emision', $factura->getFechaEmision());
        $crear->bindValue(':total', $factura->getTotal());
        $crear->bindValue(':estado', $factura->getEstado());
        $crear->bindValue(':id_pedido', $factura->getIdPedido());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM factura');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Factura();

            $nuevo->setIdFactura($registro['id_factura']);
            $nuevo->setFechaEmision($registro['fecha_emision']);
            $nuevo->setTotal($registro['total']);
            $nuevo->setEstado($registro['estado']);
            $nuevo->setIdPedido($registro['id_pedido']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_factura) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM factura WHERE id_factura = :id_factura');

        $mostrar->bindValue(':id_factura', $id_factura);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Factura();

        $nuevo->setIdFactura($registro['id_factura']);
        $nuevo->setFechaEmision($registro['fecha_emision']);
        $nuevo->setTotal($registro['total']);
        $nuevo->setEstado($registro['estado']);
        $nuevo->setIdPedido($registro['id_pedido']);

        return $nuevo;
    }

    public function update($factura) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE factura
            SET fecha_emision = :fecha_emision, total = :total, estado = :estado, id_pedido = :id_pedido
            WHERE id_factura = :id_factura'
        );

        $actualizar->bindValue(':id_factura', $factura->getIdFactura());
        $actualizar->bindValue(':fecha_emision', $factura->getFechaEmision());
        $actualizar->bindValue(':total', $factura->getTotal());
        $actualizar->bindValue(':estado', $factura->getEstado());
        $actualizar->bindValue(':id_pedido', $factura->getIdPedido());

        $actualizar->execute();
    }

    public function delete($id_factura) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM factura WHERE id_factura = :id_factura');
        $eliminar->bindValue(':id_factura', $id_factura);
        $eliminar->execute();
    }
}
