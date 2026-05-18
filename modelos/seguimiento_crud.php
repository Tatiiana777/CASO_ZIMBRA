<?php
require_once('conexion.php');
require_once('seguimiento.php');

class seguimiento_crud {
    public function __construct() {}

    public function create($seguimiento) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO seguimiento (fecha, canal, resultado, proxima_accion, id_lead, id_usuario) VALUES (:fecha, :canal, :resultado, :proxima_accion, :id_lead, :id_usuario)');
        $crear->bindValue(':fecha', $seguimiento->getFecha());
        $crear->bindValue(':canal', $seguimiento->getCanal());
        $crear->bindValue(':resultado', $seguimiento->getResultado());
        $crear->bindValue(':proxima_accion', $seguimiento->getProximaAccion());
        $crear->bindValue(':id_lead', $seguimiento->getIdLead());
        $crear->bindValue(':id_usuario', $seguimiento->getIdUsuario());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM seguimiento');

        foreach ($mostrar->fetchAll() as $registro) {
            $nuevo = new seguimiento();

            $nuevo->setIdSeguimiento($registro['id_seguimiento']);
            $nuevo->setFecha($registro['fecha']);
            $nuevo->setCanal($registro['canal']);
            $nuevo->setResultado($registro['resultado']);
            $nuevo->setProximaAccion($registro['proxima_accion']);
            $nuevo->setIdLead($registro['id_lead']);
            $nuevo->setIdUsuario($registro['id_usuario']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_seguimiento) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM seguimiento WHERE id_seguimiento = :id_seguimiento');

        $mostrar->bindValue(':id_seguimiento', $id_seguimiento);
        $mostrar->execute();

        $registro = $mostrar->fetch();

        $nuevo = new seguimiento();

        $nuevo->setIdSeguimiento($registro['id_seguimiento']);
        $nuevo->setFecha($registro['fecha']);
        $nuevo->setCanal($registro['canal']);
        $nuevo->setResultado($registro['resultado']);
        $nuevo->setProximaAccion($registro['proxima_accion']);
        $nuevo->setIdLead($registro['id_lead']);
        $nuevo->setIdUsuario($registro['id_usuario']);

        return $nuevo;
    }

    public function update($seguimiento) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE seguimiento
            SET fecha = :fecha, canal = :canal, resultado = :resultado, proxima_accion = :proxima_accion, id_lead = :id_lead, id_usuario = :id_usuario
            WHERE id_seguimiento = :id_seguimiento'
        );

        $actualizar->bindValue(':id_seguimiento', $seguimiento->getIdSeguimiento());
        $actualizar->bindValue(':fecha', $seguimiento->getFecha());
        $actualizar->bindValue(':canal', $seguimiento->getCanal());
        $actualizar->bindValue(':resultado', $seguimiento->getResultado());
        $actualizar->bindValue(':proxima_accion', $seguimiento->getProximaAccion());
        $actualizar->bindValue(':id_lead', $seguimiento->getIdLead());
        $actualizar->bindValue(':id_usuario', $seguimiento->getIdUsuario());

        $actualizar->execute();
    }

    public function delete($id_seguimiento) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM seguimiento WHERE id_seguimiento = :id_seguimiento');
        $eliminar->bindValue(':id_seguimiento', $id_seguimiento);
        $eliminar->execute();
    }
}
