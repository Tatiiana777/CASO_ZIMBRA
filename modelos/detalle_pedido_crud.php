<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/detalle_pedido.php');

class Detalle_Pedido_crud {
    public function __construct() {}

    public function create($detalle_pedido) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO detalle_pedido (cantidad, precio_unitario, subtotal, id_pedido, id_producto) VALUES (:cantidad, :precio_unitario, :subtotal, :id_pedido, :id_producto)');
        $crear->bindValue(':cantidad', $detalle_pedido->getCantidad());
        $crear->bindValue(':precio_unitario', $detalle_pedido->getPrecioUnitario());
        $crear->bindValue(':subtotal', $detalle_pedido->getSubtotal());
        $crear->bindValue(':id_pedido', $detalle_pedido->getIdPedido());
        $crear->bindValue(':id_producto', $detalle_pedido->getIdProducto());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM detalle_pedido');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Detalle_Pedido();

            $nuevo->setIdDetallePedido($registro['id_detalle_pedido']);
            $nuevo->setCantidad($registro['cantidad']);
            $nuevo->setPrecioUnitario($registro['precio_unitario']);
            $nuevo->setSubtotal($registro['subtotal']);
            $nuevo->setIdPedido($registro['id_pedido']);
            $nuevo->setIdProducto($registro['id_producto']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_detalle_pedido) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM detalle_pedido WHERE id_detalle_pedido = :id_detalle_pedido');

        $mostrar->bindValue(':id_detalle_pedido', $id_detalle_pedido);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Detalle_Pedido();

        $nuevo->setIdDetallePedido($registro['id_detalle_pedido']);
        $nuevo->setCantidad($registro['cantidad']);
        $nuevo->setPrecioUnitario($registro['precio_unitario']);
        $nuevo->setSubtotal($registro['subtotal']);
        $nuevo->setIdPedido($registro['id_pedido']);
        $nuevo->setIdProducto($registro['id_producto']);

        return $nuevo;
    }

    public function update($detalle_pedido) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE detalle_pedido
            SET cantidad = :cantidad, precio_unitario = :precio_unitario, subtotal = :subtotal, id_pedido = :id_pedido, id_producto = :id_producto
            WHERE id_detalle_pedido = :id_detalle_pedido'
        );

        $actualizar->bindValue(':id_detalle_pedido', $detalle_pedido->getIdDetallePedido());
        $actualizar->bindValue(':cantidad', $detalle_pedido->getCantidad());
        $actualizar->bindValue(':precio_unitario', $detalle_pedido->getPrecioUnitario());
        $actualizar->bindValue(':subtotal', $detalle_pedido->getSubtotal());
        $actualizar->bindValue(':id_pedido', $detalle_pedido->getIdPedido());
        $actualizar->bindValue(':id_producto', $detalle_pedido->getIdProducto());

        $actualizar->execute();
    }

    public function delete($id_detalle_pedido) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM detalle_pedido WHERE id_detalle_pedido = :id_detalle_pedido');
        $eliminar->bindValue(':id_detalle_pedido', $id_detalle_pedido);
        $eliminar->execute();
    }
}
