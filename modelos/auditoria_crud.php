<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/auditoria.php');

class Auditoria_crud {
    public function __construct() {}

    public function create($auditoria) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO auditoria (accion, tabla_afectada, fecha, descripcion, id_usuario) VALUES (:accion, :tabla_afectada, :fecha, :descripcion, :id_usuario)');
        $crear->bindValue(':accion', $auditoria->getAccion());
        $crear->bindValue(':tabla_afectada', $auditoria->getTablaAfectada());
        $crear->bindValue(':fecha', $auditoria->getFecha());
        $crear->bindValue(':descripcion', $auditoria->getDescripcion());
        $crear->bindValue(':id_usuario', $auditoria->getIdUsuario());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM auditoria');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Auditoria();

            $nuevo->setIdAuditoria($registro['id_auditoria']);
            $nuevo->setAccion($registro['accion']);
            $nuevo->setTablaAfectada($registro['tabla_afectada']);
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

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Auditoria();

        $nuevo->setIdAuditoria($registro['id_auditoria']);
        $nuevo->setAccion($registro['accion']);
        $nuevo->setTablaAfectada($registro['tabla_afectada']);
        $nuevo->setFecha($registro['fecha']);
        $nuevo->setDescripcion($registro['descripcion']);
        $nuevo->setIdUsuario($registro['id_usuario']);

        return $nuevo;
    }

    public function update($auditoria) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE auditoria
            SET accion = :accion, tabla_afectada = :tabla_afectada, fecha = :fecha, descripcion = :descripcion, id_usuario = :id_usuario
            WHERE id_auditoria = :id_auditoria'
        );

        $actualizar->bindValue(':id_auditoria', $auditoria->getIdAuditoria());
        $actualizar->bindValue(':accion', $auditoria->getAccion());
        $actualizar->bindValue(':tabla_afectada', $auditoria->getTablaAfectada());
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
