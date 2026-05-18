<?php
require_once('conexion.php');
require_once('propuesta.php');

class propuesta_crud {
    public function __construct() {}

    public function create($propuesta) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO propuesta (fecha_vigencia, valor_total, estado, id_lead, id_usuario) VALUES (:fecha_vigencia, :valor_total, :estado, :id_lead, :id_usuario)');
        $crear->bindValue(':fecha_vigencia', $propuesta->getFechaVigencia());
        $crear->bindValue(':valor_total', $propuesta->getValorTotal());
        $crear->bindValue(':estado', $propuesta->getEstado());
        $crear->bindValue(':id_lead', $propuesta->getIdLead());
        $crear->bindValue(':id_usuario', $propuesta->getIdUsuario());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM propuesta');

        foreach ($mostrar->fetchAll() as $registro) {
            $nuevo = new propuesta();

            $nuevo->setIdPropuesta($registro['id_propuesta']);
            $nuevo->setFechaVigencia($registro['fecha_vigencia']);
            $nuevo->setValorTotal($registro['valor_total']);
            $nuevo->setEstado($registro['estado']);
            $nuevo->setIdLead($registro['id_lead']);
            $nuevo->setIdUsuario($registro['id_usuario']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_propuesta) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM propuesta WHERE id_propuesta = :id_propuesta');

        $mostrar->bindValue(':id_propuesta', $id_propuesta);
        $mostrar->execute();

        $registro = $mostrar->fetch();

        $nuevo = new propuesta();

        $nuevo->setIdPropuesta($registro['id_propuesta']);
        $nuevo->setFechaVigencia($registro['fecha_vigencia']);
        $nuevo->setValorTotal($registro['valor_total']);
        $nuevo->setEstado($registro['estado']);
        $nuevo->setIdLead($registro['id_lead']);
        $nuevo->setIdUsuario($registro['id_usuario']);

        return $nuevo;
    }

    public function update($propuesta) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE propuesta
            SET fecha_vigencia = :fecha_vigencia, valor_total = :valor_total, estado = :estado, id_lead = :id_lead, id_usuario = :id_usuario
            WHERE id_propuesta = :id_propuesta'
        );

        $actualizar->bindValue(':id_propuesta', $propuesta->getIdPropuesta());
        $actualizar->bindValue(':fecha_vigencia', $propuesta->getFechaVigencia());
        $actualizar->bindValue(':valor_total', $propuesta->getValorTotal());
        $actualizar->bindValue(':estado', $propuesta->getEstado());
        $actualizar->bindValue(':id_lead', $propuesta->getIdLead());
        $actualizar->bindValue(':id_usuario', $propuesta->getIdUsuario());

        $actualizar->execute();
    }

    public function delete($id_propuesta) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM propuesta WHERE id_propuesta = :id_propuesta');
        $eliminar->bindValue(':id_propuesta', $id_propuesta);
        $eliminar->execute();
    }
}
