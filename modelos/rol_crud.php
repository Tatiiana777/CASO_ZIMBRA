<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/rol.php');

class Rol_crud {
    public function __construct() {}

    public function create($rol) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO rol (nombre_rol, descripcion) VALUES (:nombre_rol, :descripcion)');
        $crear->bindValue(':nombre_rol', $rol->getNombreRol());
        $crear->bindValue(':descripcion', $rol->getDescripcion());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM rol');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Rol();

            $nuevo->setIdRol($registro['id_rol']);
            $nuevo->setNombreRol($registro['nombre_rol']);
            $nuevo->setDescripcion($registro['descripcion']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_rol) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM rol WHERE id_rol = :id_rol');

        $mostrar->bindValue(':id_rol', $id_rol);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Rol();

        $nuevo->setIdRol($registro['id_rol']);
        $nuevo->setNombreRol($registro['nombre_rol']);
        $nuevo->setDescripcion($registro['descripcion']);

        return $nuevo;
    }

    public function update($rol) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE rol
            SET nombre_rol = :nombre_rol, descripcion = :descripcion
            WHERE id_rol = :id_rol'
        );

        $actualizar->bindValue(':id_rol', $rol->getIdRol());
        $actualizar->bindValue(':nombre_rol', $rol->getNombreRol());
        $actualizar->bindValue(':descripcion', $rol->getDescripcion());

        $actualizar->execute();
    }

    public function delete($id_rol) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM rol WHERE id_rol = :id_rol');
        $eliminar->bindValue(':id_rol', $id_rol);
        $eliminar->execute();
    }
}
