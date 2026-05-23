<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/empleado.php');

class Empleado_crud {
    public function __construct() {}

    public function create($empleado) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO empleado (nombre, cargo, telefono, correo, id_usuario, id_empresa) VALUES (:nombre, :cargo, :telefono, :correo, :id_usuario, :id_empresa)');
        $crear->bindValue(':nombre', $empleado->getNombre());
        $crear->bindValue(':cargo', $empleado->getCargo());
        $crear->bindValue(':telefono', $empleado->getTelefono());
        $crear->bindValue(':correo', $empleado->getCorreo());
        $crear->bindValue(':id_usuario', $empleado->getIdUsuario());
        $crear->bindValue(':id_empresa', $empleado->getIdEmpresa());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM empleado');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Empleado();

            $nuevo->setIdEmpleado($registro['id_empleado']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setCargo($registro['cargo']);
            $nuevo->setTelefono($registro['telefono']);
            $nuevo->setCorreo($registro['correo']);
            $nuevo->setIdUsuario($registro['id_usuario']);
            $nuevo->setIdEmpresa($registro['id_empresa']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_empleado) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM empleado WHERE id_empleado = :id_empleado');

        $mostrar->bindValue(':id_empleado', $id_empleado);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Empleado();

        $nuevo->setIdEmpleado($registro['id_empleado']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setCargo($registro['cargo']);
        $nuevo->setTelefono($registro['telefono']);
        $nuevo->setCorreo($registro['correo']);
        $nuevo->setIdUsuario($registro['id_usuario']);
        $nuevo->setIdEmpresa($registro['id_empresa']);

        return $nuevo;
    }

    public function update($empleado) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE empleado
            SET nombre = :nombre, cargo = :cargo, telefono = :telefono, correo = :correo, id_usuario = :id_usuario, id_empresa = :id_empresa
            WHERE id_empleado = :id_empleado'
        );

        $actualizar->bindValue(':id_empleado', $empleado->getIdEmpleado());
        $actualizar->bindValue(':nombre', $empleado->getNombre());
        $actualizar->bindValue(':cargo', $empleado->getCargo());
        $actualizar->bindValue(':telefono', $empleado->getTelefono());
        $actualizar->bindValue(':correo', $empleado->getCorreo());
        $actualizar->bindValue(':id_usuario', $empleado->getIdUsuario());
        $actualizar->bindValue(':id_empresa', $empleado->getIdEmpresa());

        $actualizar->execute();
    }

    public function delete($id_empleado) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM empleado WHERE id_empleado = :id_empleado');
        $eliminar->bindValue(':id_empleado', $id_empleado);
        $eliminar->execute();
    }
}
