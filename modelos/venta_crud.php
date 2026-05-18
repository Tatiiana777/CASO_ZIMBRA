<?php
require_once('conexion.php');
require_once('venta.php');

class venta_crud {
    public function __construct() {}

    public function create($venta) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO venta (fecha_cierre, valor_final, metodo_pago, id_propuesta, id_usuario, id_lead) VALUES (:fecha_cierre, :valor_final, :metodo_pago, :id_propuesta, :id_usuario, :id_lead)');
        $crear->bindValue(':fecha_cierre', $venta->getFechaCierre());
        $crear->bindValue(':valor_final', $venta->getValorFinal());
        $crear->bindValue(':metodo_pago', $venta->getMetodoPago());
        $crear->bindValue(':id_propuesta', $venta->getIdPropuesta());
        $crear->bindValue(':id_usuario', $venta->getIdUsuario());
        $crear->bindValue(':id_lead', $venta->getIdLead());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM venta');

        foreach ($mostrar->fetchAll() as $registro) {
            $nuevo = new venta();

            $nuevo->setIdVenta($registro['id_venta']);
            $nuevo->setFechaCierre($registro['fecha_cierre']);
            $nuevo->setValorFinal($registro['valor_final']);
            $nuevo->setMetodoPago($registro['metodo_pago']);
            $nuevo->setIdPropuesta($registro['id_propuesta']);
            $nuevo->setIdUsuario($registro['id_usuario']);
            $nuevo->setIdLead($registro['id_lead']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_venta) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM venta WHERE id_venta = :id_venta');

        $mostrar->bindValue(':id_venta', $id_venta);
        $mostrar->execute();

        $registro = $mostrar->fetch();

        $nuevo = new venta();

        $nuevo->setIdVenta($registro['id_venta']);
        $nuevo->setFechaCierre($registro['fecha_cierre']);
        $nuevo->setValorFinal($registro['valor_final']);
        $nuevo->setMetodoPago($registro['metodo_pago']);
        $nuevo->setIdPropuesta($registro['id_propuesta']);
        $nuevo->setIdUsuario($registro['id_usuario']);
        $nuevo->setIdLead($registro['id_lead']);

        return $nuevo;
    }

    public function update($venta) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE venta
            SET fecha_cierre = :fecha_cierre, valor_final = :valor_final, metodo_pago = :metodo_pago, id_propuesta = :id_propuesta, id_usuario = :id_usuario, id_lead = :id_lead
            WHERE id_venta = :id_venta'
        );

        $actualizar->bindValue(':id_venta', $venta->getIdVenta());
        $actualizar->bindValue(':fecha_cierre', $venta->getFechaCierre());
        $actualizar->bindValue(':valor_final', $venta->getValorFinal());
        $actualizar->bindValue(':metodo_pago', $venta->getMetodoPago());
        $actualizar->bindValue(':id_propuesta', $venta->getIdPropuesta());
        $actualizar->bindValue(':id_usuario', $venta->getIdUsuario());
        $actualizar->bindValue(':id_lead', $venta->getIdLead());

        $actualizar->execute();
    }

    public function delete($id_venta) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM venta WHERE id_venta = :id_venta');
        $eliminar->bindValue(':id_venta', $id_venta);
        $eliminar->execute();
    }
}