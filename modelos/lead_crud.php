<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/lead.php');

class Lead_crud {
    public function __construct() {}

    public function create($lead) {
        $db = Conexion::conectar();

        $crear = $db -> prepare('INSERT INTO `Lead` (nombre, empresa, correo, telefono, pais, estado_contacto, fecha_registro, id_campania, id_usuario) VALUES (:nombre, :empresa, :correo, :telefono, :pais, :estado_contacto, :fecha_registro, :id_campania, :id_usuario)');
        $crear->bindValue(':nombre', $lead->getNombre());
        $crear->bindValue(':empresa', $lead->getEmpresa());
        $crear->bindValue(':correo', $lead->getCorreo());
        $crear->bindValue(':telefono', $lead->getTelefono());
        $crear->bindValue(':pais', $lead->getPais());
        $crear->bindValue(':estado_contacto', $lead->getEstadoContacto());
        $crear->bindValue(':fecha_registro', $lead->getFechaRegistro());
        $crear->bindValue(':id_campania', $lead->getIdCampania());
        $crear->bindValue(':id_usuario', $lead->getIdUsuario());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];


        $mostrar = $db->query('SELECT * FROM `Lead`');


        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Lead();

            $nuevo->setIdLead($registro['id_lead']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setEmpresa($registro['empresa']);
            $nuevo->setCorreo($registro['correo']);
            $nuevo->setTelefono($registro['telefono']);
            $nuevo->setPais($registro['pais']);
            $nuevo->setEstadoContacto($registro['estado_contacto']);
            $nuevo->setFechaRegistro($registro['fecha_registro']);
            $nuevo->setIdCampania($registro['id_campania']);
            $nuevo->setIdUsuario($registro['id_usuario']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_lead) {
        $db = Conexion::conectar();


        $mostrar = $db->prepare('SELECT * FROM `Lead` WHERE id_lead = :id_lead');


        $mostrar->bindValue(':id_lead', $id_lead);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Lead();

        $nuevo->setIdLead($registro['id_lead']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setEmpresa($registro['empresa']);
        $nuevo->setCorreo($registro['correo']);
        $nuevo->setTelefono($registro['telefono']);
        $nuevo->setPais($registro['pais']);
        $nuevo->setEstadoContacto($registro['estado_contacto']);
        $nuevo->setFechaRegistro($registro['fecha_registro']);
        $nuevo->setIdCampania($registro['id_campania']);
        $nuevo->setIdUsuario($registro['id_usuario']);

        return $nuevo;
    }

    public function update($lead) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(

            'UPDATE `Lead`

            SET nombre = :nombre, empresa = :empresa, correo = :correo, telefono = :telefono, pais = :pais, estado_contacto = :estado_contacto, fecha_registro = :fecha_registro, id_campania = :id_campania, id_usuario = :id_usuario
            WHERE id_lead = :id_lead'
        );

        $actualizar->bindValue(':id_lead', $lead->getIdLead());
        $actualizar->bindValue(':nombre', $lead->getNombre());
        $actualizar->bindValue(':empresa', $lead->getEmpresa());
        $actualizar->bindValue(':correo', $lead->getCorreo());
        $actualizar->bindValue(':telefono', $lead->getTelefono());
        $actualizar->bindValue(':pais', $lead->getPais());
        $actualizar->bindValue(':estado_contacto', $lead->getEstadoContacto());
        $actualizar->bindValue(':fecha_registro', $lead->getFechaRegistro());
        $actualizar->bindValue(':id_campania', $lead->getIdCampania());
        $actualizar->bindValue(':id_usuario', $lead->getIdUsuario());

        $actualizar->execute();
    }

    public function delete($id_lead) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM `Lead` WHERE id_lead = :id_lead');

        $eliminar->bindValue(':id_lead', $id_lead);
        $eliminar->execute();
    }
}
