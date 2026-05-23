<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/usuario.php');

class Usuario_crud {
    public function __construct() {}

    public function create($usuario) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO usuario (nombre, correo, contrasena, telefono, activo, fecha_creacion, id_empresa, id_rol) VALUES (:nombre, :correo, :contrasena, :telefono, :activo, :fecha_creacion, :id_empresa, :id_rol)');
        $crear->bindValue(':nombre', $usuario->getNombre());
        $crear->bindValue(':correo', $usuario->getCorreo());
        $crear->bindValue(':contrasena', $usuario->getContrasena());
        $crear->bindValue(':telefono', $usuario->getTelefono());
        $crear->bindValue(':activo', $usuario->getActivo());
        $crear->bindValue(':fecha_creacion', $usuario->getFechaCreacion());
        $crear->bindValue(':id_empresa', $usuario->getIdEmpresa());
        $crear->bindValue(':id_rol', $usuario->getIdRol());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM usuario');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Usuario();

            $nuevo->setIdUsuario($registro['id_usuario']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setCorreo($registro['correo']);
            $nuevo->setContrasena($registro['contrasena']);
            $nuevo->setTelefono($registro['telefono']);
            $nuevo->setActivo($registro['activo']);
            $nuevo->setFechaCreacion($registro['fecha_creacion']);
            $nuevo->setIdEmpresa($registro['id_empresa']);
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

        $nuevo = new Usuario();

        $nuevo->setIdUsuario($registro['id_usuario']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setCorreo($registro['correo']);
        $nuevo->setContrasena($registro['contrasena']);
        $nuevo->setTelefono($registro['telefono']);
        $nuevo->setActivo($registro['activo']);
        $nuevo->setFechaCreacion($registro['fecha_creacion']);
        $nuevo->setIdEmpresa($registro['id_empresa']);
        $nuevo->setIdRol($registro['id_rol']);

        return $nuevo;
    }

    public function update($usuario) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE usuario
            SET nombre = :nombre, correo = :correo, contrasena = :contrasena, telefono = :telefono, activo = :activo, fecha_creacion = :fecha_creacion, id_empresa = :id_empresa, id_rol = :id_rol
            WHERE id_usuario = :id_usuario'
        );

        $actualizar->bindValue(':id_usuario', $usuario->getIdUsuario());
        $actualizar->bindValue(':nombre', $usuario->getNombre());
        $actualizar->bindValue(':correo', $usuario->getCorreo());
        $actualizar->bindValue(':contrasena', $usuario->getContrasena());
        $actualizar->bindValue(':telefono', $usuario->getTelefono());
        $actualizar->bindValue(':activo', $usuario->getActivo());
        $actualizar->bindValue(':fecha_creacion', $usuario->getFechaCreacion());
        $actualizar->bindValue(':id_empresa', $usuario->getIdEmpresa());
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
