<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/cliente.php');

class Cliente_crud {
    public function __construct() {}

    public function create($cliente) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO cliente (nombre, apellido, documento, telefono, correo, fecha_conversion, id_empresa, id_lead) VALUES (:nombre, :apellido, :documento, :telefono, :correo, :fecha_conversion, :id_empresa, :id_lead)');
        $crear->bindValue(':nombre', $cliente->getNombre());
        $crear->bindValue(':apellido', $cliente->getApellido());
        $crear->bindValue(':documento', $cliente->getDocumento());
        $crear->bindValue(':telefono', $cliente->getTelefono());
        $crear->bindValue(':correo', $cliente->getCorreo());
        $crear->bindValue(':fecha_conversion', $cliente->getFechaConversion());
        $crear->bindValue(':id_empresa', $cliente->getIdEmpresa());
        $crear->bindValue(':id_lead', $cliente->getIdLead());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM cliente');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Cliente();

            $nuevo->setIdCliente($registro['id_cliente']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setApellido($registro['apellido']);
            $nuevo->setDocumento($registro['documento']);
            $nuevo->setTelefono($registro['telefono']);
            $nuevo->setCorreo($registro['correo']);
            $nuevo->setFechaConversion($registro['fecha_conversion']);
            $nuevo->setIdEmpresa($registro['id_empresa']);
            $nuevo->setIdLead($registro['id_lead']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_cliente) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM cliente WHERE id_cliente = :id_cliente');

        $mostrar->bindValue(':id_cliente', $id_cliente);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Cliente();

        $nuevo->setIdCliente($registro['id_cliente']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setApellido($registro['apellido']);
        $nuevo->setDocumento($registro['documento']);
        $nuevo->setTelefono($registro['telefono']);
        $nuevo->setCorreo($registro['correo']);
        $nuevo->setFechaConversion($registro['fecha_conversion']);
        $nuevo->setIdEmpresa($registro['id_empresa']);
        $nuevo->setIdLead($registro['id_lead']);

        return $nuevo;
    }

    public function update($cliente) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE cliente
            SET nombre = :nombre, apellido = :apellido, documento = :documento, telefono = :telefono, correo = :correo, fecha_conversion = :fecha_conversion, id_empresa = :id_empresa, id_lead = :id_lead
            WHERE id_cliente = :id_cliente'
        );

        $actualizar->bindValue(':id_cliente', $cliente->getIdCliente());
        $actualizar->bindValue(':nombre', $cliente->getNombre());
        $actualizar->bindValue(':apellido', $cliente->getApellido());
        $actualizar->bindValue(':documento', $cliente->getDocumento());
        $actualizar->bindValue(':telefono', $cliente->getTelefono());
        $actualizar->bindValue(':correo', $cliente->getCorreo());
        $actualizar->bindValue(':fecha_conversion', $cliente->getFechaConversion());
        $actualizar->bindValue(':id_empresa', $cliente->getIdEmpresa());
        $actualizar->bindValue(':id_lead', $cliente->getIdLead());

        $actualizar->execute();
    }

    public function delete($id_cliente) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM cliente WHERE id_cliente = :id_cliente');
        $eliminar->bindValue(':id_cliente', $id_cliente);
        $eliminar->execute();
    }
}
