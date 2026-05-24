<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/proveedor.php');

class Proveedor_crud {
    public function __construct() {}

    public function create($proveedor) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO proveedor (nombre, nit, telefono, correo, direccion, activo, id_empresa) VALUES (:nombre, :nit, :telefono, :correo, :direccion, :activo, :id_empresa)');
        $crear->bindValue(':nombre', $proveedor->getNombre());
        $crear->bindValue(':nit', $proveedor->getNit());
        $crear->bindValue(':telefono', $proveedor->getTelefono());
        $crear->bindValue(':correo', $proveedor->getCorreo());
        $crear->bindValue(':direccion', $proveedor->getDireccion());
        $crear->bindValue(':activo', $proveedor->getActivo());
        $crear->bindValue(':id_empresa', $proveedor->getIdEmpresa());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM proveedor');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Proveedor();

            $nuevo->setIdProveedor($registro['id_proveedor']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setNit($registro['nit']);
            $nuevo->setTelefono($registro['telefono']);
            $nuevo->setCorreo($registro['correo']);
            $nuevo->setDireccion($registro['direccion']);
            $nuevo->setActivo($registro['activo']);
            $nuevo->setIdEmpresa($registro['id_empresa']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_proveedor) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM proveedor WHERE id_proveedor = :id_proveedor');

        $mostrar->bindValue(':id_proveedor', $id_proveedor);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Proveedor();

        $nuevo->setIdProveedor($registro['id_proveedor']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setNit($registro['nit']);
        $nuevo->setTelefono($registro['telefono']);
        $nuevo->setCorreo($registro['correo']);
        $nuevo->setDireccion($registro['direccion']);
        $nuevo->setActivo($registro['activo']);
        $nuevo->setIdEmpresa($registro['id_empresa']);

        return $nuevo;
    }

    public function update($proveedor) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE proveedor
            SET nombre = :nombre, nit = :nit, telefono = :telefono, correo = :correo, direccion = :direccion, activo = :activo, id_empresa = :id_empresa
            WHERE id_proveedor = :id_proveedor'
        );

        $actualizar->bindValue(':id_proveedor', $proveedor->getIdProveedor());
        $actualizar->bindValue(':nombre', $proveedor->getNombre());
        $actualizar->bindValue(':nit', $proveedor->getNit());
        $actualizar->bindValue(':telefono', $proveedor->getTelefono());
        $actualizar->bindValue(':correo', $proveedor->getCorreo());
        $actualizar->bindValue(':direccion', $proveedor->getDireccion());
        $actualizar->bindValue(':activo', $proveedor->getActivo());
        $actualizar->bindValue(':id_empresa', $proveedor->getIdEmpresa());

        $actualizar->execute();
    }

    public function delete($id_proveedor) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM proveedor WHERE id_proveedor = :id_proveedor');
        $eliminar->bindValue(':id_proveedor', $id_proveedor);
        $eliminar->execute();
    }
}
