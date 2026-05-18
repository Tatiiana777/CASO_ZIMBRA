<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/usuario.php');

class Usuario_crud {
    public function __construct() {}

    public function create($usuario) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO usuario (nombre, correo, contrasenia, telefono, id_rol) VALUES (:nombre, :correo, :contrasenia, :telefono, :id_rol)');
        $crear->bindValue(':nombre', $usuario->getNombre());
        $crear->bindValue(':correo', $usuario->getCorreo());
        $crear->bindValue(':contrasenia', $usuario->getContrasenia());
        $crear->bindValue(':telefono', $usuario->getTelefono());
        $crear->bindValue(':id_rol', $usuario->getIdRol());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM usuario');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new usuario();

            $nuevo->setIdUsuario($registro['id_usuario']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setCorreo($registro['correo']);
            $nuevo->setContrasenia($registro['contrasenia']);
            $nuevo->setTelefono($registro['telefono']);
            $nuevo->setIdRol($registro['id_rol']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_usuario) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM usuario WHERE id_usuario = :id_usuario');

        $mostrar->bindValue(':id_usuario', $id_usuario);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new usuario();

        $nuevo->setIdUsuario($registro['id_usuario']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setCorreo($registro['correo']);
        $nuevo->setContrasenia($registro['contrasenia']);
        $nuevo->setTelefono($registro['telefono']);
        $nuevo->setIdRol($registro['id_rol']);

        return $nuevo;
    }

    public function update($usuario) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE usuario
            SET nombre = :nombre, correo = :correo, contrasenia = :contrasenia, telefono = :telefono, id_rol = :id_rol
            WHERE id_usuario = :id_usuario'
        );

        $actualizar->bindValue(':id_usuario', $usuario->getIdUsuario());
        $actualizar->bindValue(':nombre', $usuario->getNombre());
        $actualizar->bindValue(':correo', $usuario->getCorreo());
        $actualizar->bindValue(':contrasenia', $usuario->getContrasenia());
        $actualizar->bindValue(':telefono', $usuario->getTelefono());
        $actualizar->bindValue(':id_rol', $usuario->getIdRol());

        $actualizar->execute();
    }

    public function delete($id_usuario) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM usuario WHERE id_usuario = :id_usuario');
        $eliminar->bindValue(':id_usuario', $id_usuario);
        $eliminar->execute();
    }
}
