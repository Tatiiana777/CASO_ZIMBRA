<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/pago.php');

class Pago_crud {
    public function __construct() {}

    public function create($pago) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO pago (fecha_pago, metodo_pago, valor, id_factura) VALUES (:fecha_pago, :metodo_pago, :valor, :id_factura)');
        $crear->bindValue(':fecha_pago', $pago->getFechaPago());
        $crear->bindValue(':metodo_pago', $pago->getMetodoPago());
        $crear->bindValue(':valor', $pago->getValor());
        $crear->bindValue(':id_factura', $pago->getIdFactura());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM pago');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Pago();

            $nuevo->setIdPago($registro['id_pago']);
            $nuevo->setFechaPago($registro['fecha_pago']);
            $nuevo->setMetodoPago($registro['metodo_pago']);
            $nuevo->setValor($registro['valor']);
            $nuevo->setIdFactura($registro['id_factura']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_pago) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM pago WHERE id_pago = :id_pago');

        $mostrar->bindValue(':id_pago', $id_pago);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Pago();

        $nuevo->setIdPago($registro['id_pago']);
        $nuevo->setFechaPago($registro['fecha_pago']);
        $nuevo->setMetodoPago($registro['metodo_pago']);
        $nuevo->setValor($registro['valor']);
        $nuevo->setIdFactura($registro['id_factura']);

        return $nuevo;
    }

    public function update($pago) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE pago
            SET fecha_pago = :fecha_pago, metodo_pago = :metodo_pago, valor = :valor, id_factura = :id_factura
            WHERE id_pago = :id_pago'
        );

        $actualizar->bindValue(':id_pago', $pago->getIdPago());
        $actualizar->bindValue(':fecha_pago', $pago->getFechaPago());
        $actualizar->bindValue(':metodo_pago', $pago->getMetodoPago());
        $actualizar->bindValue(':valor', $pago->getValor());
        $actualizar->bindValue(':id_factura', $pago->getIdFactura());

        $actualizar->execute();
    }

    public function delete($id_pago) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM pago WHERE id_pago = :id_pago');
        $eliminar->bindValue(':id_pago', $id_pago);
        $eliminar->execute();
    }
}
