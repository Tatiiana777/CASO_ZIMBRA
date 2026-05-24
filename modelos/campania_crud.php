<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/campania.php');

class Campania_crud {
    public function __construct() {}

    public function create($campania) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO campania (nombre, descripcion, fecha_inicio, fecha_fin, costo, estado, id_marketing, id_usuario) VALUES (:nombre, :descripcion, :fecha_inicio, :fecha_fin, :costo, :estado, :id_marketing, :id_usuario)');
        $crear->bindValue(':nombre', $campania->getNombre());
        $crear->bindValue(':descripcion', $campania->getDescripcion());
        $crear->bindValue(':fecha_inicio', $campania->getFechaInicio());
        $crear->bindValue(':fecha_fin', $campania->getFechaFin());
        $crear->bindValue(':costo', $campania->getCosto());
        $crear->bindValue(':estado', $campania->getEstado());
        $crear->bindValue(':id_marketing', $campania->getIdMarketing());
        $crear->bindValue(':id_usuario', $campania->getIdUsuario());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM campania');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Campania();

            $nuevo->setIdCampania($registro['id_campania']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setDescripcion($registro['descripcion']);
            $nuevo->setFechaInicio($registro['fecha_inicio']);
            $nuevo->setFechaFin($registro['fecha_fin']);
            $nuevo->setCosto($registro['costo']);
            $nuevo->setEstado($registro['estado']);
            $nuevo->setIdMarketing($registro['id_marketing']);
            $nuevo->setIdUsuario($registro['id_usuario']);

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

        $nuevo = new Campania();

        $nuevo->setIdCampania($registro['id_campania']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setDescripcion($registro['descripcion']);
        $nuevo->setFechaInicio($registro['fecha_inicio']);
        $nuevo->setFechaFin($registro['fecha_fin']);
        $nuevo->setCosto($registro['costo']);
        $nuevo->setEstado($registro['estado']);
        $nuevo->setIdMarketing($registro['id_marketing']);
        $nuevo->setIdUsuario($registro['id_usuario']);

        return $nuevo;
    }

    public function update($campania) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE campania
            SET nombre = :nombre, descripcion = :descripcion, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, costo = :costo, estado = :estado, id_marketing = :id_marketing, id_usuario = :id_usuario
            WHERE id_campania = :id_campania'
        );

        $actualizar->bindValue(':id_campania', $campania->getIdCampania());
        $actualizar->bindValue(':nombre', $campania->getNombre());
        $actualizar->bindValue(':descripcion', $campania->getDescripcion());
        $actualizar->bindValue(':fecha_inicio', $campania->getFechaInicio());
        $actualizar->bindValue(':fecha_fin', $campania->getFechaFin());
        $actualizar->bindValue(':costo', $campania->getCosto());
        $actualizar->bindValue(':estado', $campania->getEstado());
        $actualizar->bindValue(':id_marketing', $campania->getIdMarketing());
        $actualizar->bindValue(':id_usuario', $campania->getIdUsuario());

        $actualizar->execute();
    }

    public function delete($id_campania) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM campania WHERE id_campania = :id_campania');
        $eliminar->bindValue(':id_campania', $id_campania);
        $eliminar->execute();
    }
}
