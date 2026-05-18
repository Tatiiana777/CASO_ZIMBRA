<?php
require_once('conexion.php');
require_once('campaña.php');

class campaña_crud {
    public function __construct() {}

    public function create($campaña) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO campaña (nombre, descripcion, fecha_inicio, fecha_fin, presupuesto, estado) VALUES (:nombre, :descripcion, :fecha_inicio, :fecha_fin, :presupuesto, :estado)');
        $crear->bindValue(':nombre', $campaña->getNombre());
        $crear->bindValue(':descripcion', $campaña->getDescripcion());
        $crear->bindValue(':fecha_inicio', $campaña->getFechaInicio());
        $crear->bindValue(':fecha_fin', $campaña->getFechaFin());
        $crear->bindValue(':presupuesto', $campaña->getPresupuesto());
        $crear->bindValue(':estado', $campaña->getEstado());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM campaña');

        foreach ($mostrar->fetchAll() as $registro) {
            $nuevo = new campaña();

            $nuevo->setIdCampaña($registro['id_campaña']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setDescripcion($registro['descripcion']);
            $nuevo->setFechaInicio($registro['fecha_inicio']);
            $nuevo->setFechaFin($registro['fecha_fin']);
            $nuevo->setPresupuesto($registro['presupuesto']);
            $nuevo->setEstado($registro['estado']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_campaña) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM campaña WHERE id_campaña = :id_campaña');

        $mostrar->bindValue(':id_campaña', $id_campaña);
        $mostrar->execute();

        $registro = $mostrar->fetch();

        $nuevo = new campaña();

        $nuevo->setIdCampaña($registro['id_campaña']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setDescripcion($registro['descripcion']);
        $nuevo->setFechaInicio($registro['fecha_inicio']);
        $nuevo->setFechaFin($registro['fecha_fin']);
        $nuevo->setPresupuesto($registro['presupuesto']);
        $nuevo->setEstado($registro['estado']);

        return $nuevo;
    }

    public function update($campaña) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE campaña
            SET nombre = :nombre, descripcion = :descripcion, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, presupuesto = :presupuesto, estado = :estado
            WHERE id_campaña = :id_campaña'
        );

        $actualizar->bindValue(':id_campaña', $campaña->getIdCampaña());
        $actualizar->bindValue(':nombre', $campaña->getNombre());
        $actualizar->bindValue(':descripcion', $campaña->getDescripcion());
        $actualizar->bindValue(':fecha_inicio', $campaña->getFechaInicio());
        $actualizar->bindValue(':fecha_fin', $campaña->getFechaFin());
        $actualizar->bindValue(':presupuesto', $campaña->getPresupuesto());
        $actualizar->bindValue(':estado', $campaña->getEstado());

        $actualizar->execute();
    }

    public function delete($id_campaña) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM campaña WHERE id_campaña = :id_campaña');
        $eliminar->bindValue(':id_campaña', $id_campaña);
        $eliminar->execute();
    }
}