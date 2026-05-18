<?php
require_once('conexion.php');
require_once('rol.php');

class Rol_crud {
    public function __construct() {}

    public function create($rol) {
        $db = Conexion::conectar();

        $crear = $db -> prepare(
            'INSERT INTO rol (nombre_rol)
            VALUE (:nombre_rol)'
        );

        $crear -> bindValue(':nombre_rol', $rol -> getNombre_rol());  
        $crear -> execute();
    }

    public function read() {
        $db = Conexion::conectar();     $lista_roles = [];

        $mostrar = $db -> query( 'SELECT * FROM rol' );

        foreach ($mostrar->fetchAll() as $rol) {
            $nuevo_rol = new Rol();

            $nuevo_rol -> setId_rol($rol['id_rol']);
            $nuevo_rol -> setNombre_rol($rol['nombre_rol']);

            $lista_roles[] = $nuevo_rol;
        }

        return $lista_roles;
    }

    public function getId($id_rol) {
        $db = Conexion::conectar();

        $mostrar = $db -> prepare( 'SELECT * FROM rol WHERE id_rol = :id_rol' );

        $mostrar -> bindValue(':id_rol', $id_rol);
        $mostrar -> execute();

        $rol = $mostrar -> fetch();

        $nuevo_rol = new Rol();

        $nuevo_rol -> setId_rol($rol['id_rol']);
        $nuevo_rol -> setNombre_rol($rol['nombre_rol']);

        return $nuevo_rol;
    }

    public function update($rol) {
        $db = Conexion::conectar();

        $actualizar = $db -> prepare(
            'UPDATE rol
            SET nombre_rol = :nombre_rol
            WHERE id_rol = :id_rol'
            );

        $actualizar -> bindValue(':id_rol', $rol -> getId_rol());
        $actualizar -> bindValue(':nombre_rol', $rol -> getNombre_rol());
        $actualizar -> execute();
    }

    public function delete($id_rol) {
        $db = Conexion::conectar();

        $eliminar = $db -> prepare( 'DELETE FROM rol WHERE id_rol = :id_rol' );

        $eliminar -> bindValue(':id_rol', $id_rol);
        $eliminar  -> execute();
    }
}
?>