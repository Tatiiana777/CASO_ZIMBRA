<?php
require_once('conexion.php');
require_once('auditoria.php');

class auditoria_crud {
    public function __construct() {}

    public function create($auditoria) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO auditoria (accion, fecha, descripcion, id_usuario) VALUES (:accion, :fecha, :descripcion, :id_usuario)');
        $crear->bindValue(':accion', $auditoria->getAccion());
        $crear->bindValue(':fecha', $auditoria->getFecha());
        $crear->bindValue(':descripcion', $auditoria->getDescripcion());
        $crear->bindValue(':id_usuario', $auditoria->getIdUsuario());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM auditoria');

        foreach ($mostrar->fetchAll() as $registro) {
            $nuevo = new auditoria();

            $nuevo->setIdAuditoria($registro['id_auditoria']);
            $nuevo->setAccion($registro['accion']);
            $nuevo->setFecha($registro['fecha']);
            $nuevo->setDescripcion($registro['descripcion']);
            $nuevo->setIdUsuario($registro['id_usuario']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_auditoria) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM auditoria WHERE id_auditoria = :id_auditoria');

        $mostrar->bindValue(':id_auditoria', $id_auditoria);
        $mostrar->execute();

        $registro = $mostrar->fetch();

        $nuevo = new auditoria();

        $nuevo->setIdAuditoria($registro['id_auditoria']);
        $nuevo->setAccion($registro['accion']);
        $nuevo->setFecha($registro['fecha']);
        $nuevo->setDescripcion($registro['descripcion']);
        $nuevo->setIdUsuario($registro['id_usuario']);

        return $nuevo;
    }

    public function update($auditoria) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE auditoria
            SET accion = :accion, fecha = :fecha, descripcion = :descripcion, id_usuario = :id_usuario
            WHERE id_auditoria = :id_auditoria'
        );

        $actualizar->bindValue(':id_auditoria', $auditoria->getIdAuditoria());
        $actualizar->bindValue(':accion', $auditoria->getAccion());
        $actualizar->bindValue(':fecha', $auditoria->getFecha());
        $actualizar->bindValue(':descripcion', $auditoria->getDescripcion());
        $actualizar->bindValue(':id_usuario', $auditoria->getIdUsuario());

        $actualizar->execute();
    }

    public function delete($id_auditoria) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM auditoria WHERE id_auditoria = :id_auditoria');
        $eliminar->bindValue(':id_auditoria', $id_auditoria);
        $eliminar->execute();
    }
}
