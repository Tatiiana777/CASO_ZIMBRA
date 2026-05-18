<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/campania.php');

class Campania_crud {
    public function __construct() {}

    public function create($campania) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO campania (nombre, descripcion, fecha_inicio, fecha_fin, presupuesto, estado) VALUES (:nombre, :descripcion, :fecha_inicio, :fecha_fin, :presupuesto, :estado)');
        $crear->bindValue(':nombre', $campania->getNombre());
        $crear->bindValue(':descripcion', $campania->getDescripcion());
        $crear->bindValue(':fecha_inicio', $campania->getFechaInicio());
        $crear->bindValue(':fecha_fin', $campania->getFechaFin());
        $crear->bindValue(':presupuesto', $campania->getPresupuesto());
        $crear->bindValue(':estado', $campania->getEstado());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM campania');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new campania();

            $nuevo->setIdCampania($registro['id_campania']);
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

    public function getId($id_campania) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM campania WHERE id_campania = :id_campania');

        $mostrar->bindValue(':id_campania', $id_campania);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new campania();

        $nuevo->setIdCampania($registro['id_campania']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setDescripcion($registro['descripcion']);
        $nuevo->setFechaInicio($registro['fecha_inicio']);
        $nuevo->setFechaFin($registro['fecha_fin']);
        $nuevo->setPresupuesto($registro['presupuesto']);
        $nuevo->setEstado($registro['estado']);

        return $nuevo;
    }

    public function update($campania) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE campania
            SET nombre = :nombre, descripcion = :descripcion, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, presupuesto = :presupuesto, estado = :estado
            WHERE id_campania = :id_campania'
        );

        $actualizar->bindValue(':id_campania', $campania->getIdCampania());
        $actualizar->bindValue(':nombre', $campania->getNombre());
        $actualizar->bindValue(':descripcion', $campania->getDescripcion());
        $actualizar->bindValue(':fecha_inicio', $campania->getFechaInicio());
        $actualizar->bindValue(':fecha_fin', $campania->getFechaFin());
        $actualizar->bindValue(':presupuesto', $campania->getPresupuesto());
        $actualizar->bindValue(':estado', $campania->getEstado());

        $actualizar->execute();
    }

    public function delete($id_campania) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM campania WHERE id_campania = :id_campania');
        $eliminar->bindValue(':id_campania', $id_campania);
        $eliminar->execute();
    }
}
