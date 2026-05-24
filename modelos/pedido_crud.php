<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/pedido.php');

class Pedido_crud {
    public function __construct() {}

    public function create($pedido) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO pedido (fecha, estado, id_cliente, id_empleado, id_propuesta) VALUES (:fecha, :estado, :id_cliente, :id_empleado, :id_propuesta)');
        $crear->bindValue(':fecha', $pedido->getFecha());
        $crear->bindValue(':estado', $pedido->getEstado());
        $crear->bindValue(':id_cliente', $pedido->getIdCliente());
        $crear->bindValue(':id_empleado', $pedido->getIdEmpleado());
        $crear->bindValue(':id_propuesta', $pedido->getIdPropuesta());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM pedido');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Pedido();

            $nuevo->setIdPedido($registro['id_pedido']);
            $nuevo->setFecha($registro['fecha']);
            $nuevo->setEstado($registro['estado']);
            $nuevo->setIdCliente($registro['id_cliente']);
            $nuevo->setIdEmpleado($registro['id_empleado']);
            $nuevo->setIdPropuesta($registro['id_propuesta']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_pedido) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM pedido WHERE id_pedido = :id_pedido');

        $mostrar->bindValue(':id_pedido', $id_pedido);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Pedido();

        $nuevo->setIdPedido($registro['id_pedido']);
        $nuevo->setFecha($registro['fecha']);
        $nuevo->setEstado($registro['estado']);
        $nuevo->setIdCliente($registro['id_cliente']);
        $nuevo->setIdEmpleado($registro['id_empleado']);
        $nuevo->setIdPropuesta($registro['id_propuesta']);

        return $nuevo;
    }

    public function update($pedido) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE pedido
            SET fecha = :fecha, estado = :estado, id_cliente = :id_cliente, id_empleado = :id_empleado, id_propuesta = :id_propuesta
            WHERE id_pedido = :id_pedido'
        );

        $actualizar->bindValue(':id_pedido', $pedido->getIdPedido());
        $actualizar->bindValue(':fecha', $pedido->getFecha());
        $actualizar->bindValue(':estado', $pedido->getEstado());
        $actualizar->bindValue(':id_cliente', $pedido->getIdCliente());
        $actualizar->bindValue(':id_empleado', $pedido->getIdEmpleado());
        $actualizar->bindValue(':id_propuesta', $pedido->getIdPropuesta());

        $actualizar->execute();
    }

    public function delete($id_pedido) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM pedido WHERE id_pedido = :id_pedido');
        $eliminar->bindValue(':id_pedido', $id_pedido);
        $eliminar->execute();
    }
}
