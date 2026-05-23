<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/empresa.php');

class Empresa_crud {
    public function __construct() {}

    public function create($empresa) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO empresa (nombre, nit, direccion, telefono, sector, fecha_registro) VALUES (:nombre, :nit, :direccion, :telefono, :sector, :fecha_registro)');
        $crear->bindValue(':nombre', $empresa->getNombre());
        $crear->bindValue(':nit', $empresa->getNit());
        $crear->bindValue(':direccion', $empresa->getDireccion());
        $crear->bindValue(':telefono', $empresa->getTelefono());
        $crear->bindValue(':sector', $empresa->getSector());
        $crear->bindValue(':fecha_registro', $empresa->getFechaRegistro());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM empresa');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Empresa();

            $nuevo->setIdEmpresa($registro['id_empresa']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setNit($registro['nit']);
            $nuevo->setDireccion($registro['direccion']);
            $nuevo->setTelefono($registro['telefono']);
            $nuevo->setSector($registro['sector']);
            $nuevo->setFechaRegistro($registro['fecha_registro']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_empresa) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM empresa WHERE id_empresa = :id_empresa');

        $mostrar->bindValue(':id_empresa', $id_empresa);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Empresa();

        $nuevo->setIdEmpresa($registro['id_empresa']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setNit($registro['nit']);
        $nuevo->setDireccion($registro['direccion']);
        $nuevo->setTelefono($registro['telefono']);
        $nuevo->setSector($registro['sector']);
        $nuevo->setFechaRegistro($registro['fecha_registro']);

        return $nuevo;
    }

    public function update($empresa) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE empresa
            SET nombre = :nombre, nit = :nit, direccion = :direccion, telefono = :telefono, sector = :sector, fecha_registro = :fecha_registro
            WHERE id_empresa = :id_empresa'
        );

        $actualizar->bindValue(':id_empresa', $empresa->getIdEmpresa());
        $actualizar->bindValue(':nombre', $empresa->getNombre());
        $actualizar->bindValue(':nit', $empresa->getNit());
        $actualizar->bindValue(':direccion', $empresa->getDireccion());
        $actualizar->bindValue(':telefono', $empresa->getTelefono());
        $actualizar->bindValue(':sector', $empresa->getSector());
        $actualizar->bindValue(':fecha_registro', $empresa->getFechaRegistro());

        $actualizar->execute();
    }

    public function delete($id_empresa) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM empresa WHERE id_empresa = :id_empresa');
        $eliminar->bindValue(':id_empresa', $id_empresa);
        $eliminar->execute();
    }
}
