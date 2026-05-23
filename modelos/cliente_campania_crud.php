<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/cliente_campania.php');

class Cliente_Campania_crud {
    public function __construct() {}

    public function create($cliente_campania) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO cliente_campania (fecha_contacto, estado, id_cliente, id_campania) VALUES (:fecha_contacto, :estado, :id_cliente, :id_campania)');
        $crear->bindValue(':fecha_contacto', $cliente_campania->getFechaContacto());
        $crear->bindValue(':estado', $cliente_campania->getEstado());
        $crear->bindValue(':id_cliente', $cliente_campania->getIdCliente());
        $crear->bindValue(':id_campania', $cliente_campania->getIdCampania());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM cliente_campania');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Cliente_Campania();

            $nuevo->setIdClienteCampania($registro['id_cliente_campania']);
            $nuevo->setFechaContacto($registro['fecha_contacto']);
            $nuevo->setEstado($registro['estado']);
            $nuevo->setIdCliente($registro['id_cliente']);
            $nuevo->setIdCampania($registro['id_campania']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_cliente_campania) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM cliente_campania WHERE id_cliente_campania = :id_cliente_campania');

        $mostrar->bindValue(':id_cliente_campania', $id_cliente_campania);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Cliente_Campania();

        $nuevo->setIdClienteCampania($registro['id_cliente_campania']);
        $nuevo->setFechaContacto($registro['fecha_contacto']);
        $nuevo->setEstado($registro['estado']);
        $nuevo->setIdCliente($registro['id_cliente']);
        $nuevo->setIdCampania($registro['id_campania']);

        return $nuevo;
    }

    public function update($cliente_campania) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE cliente_campania
            SET fecha_contacto = :fecha_contacto, estado = :estado, id_cliente = :id_cliente, id_campania = :id_campania
            WHERE id_cliente_campania = :id_cliente_campania'
        );

        $actualizar->bindValue(':id_cliente_campania', $cliente_campania->getIdClienteCampania());
        $actualizar->bindValue(':fecha_contacto', $cliente_campania->getFechaContacto());
        $actualizar->bindValue(':estado', $cliente_campania->getEstado());
        $actualizar->bindValue(':id_cliente', $cliente_campania->getIdCliente());
        $actualizar->bindValue(':id_campania', $cliente_campania->getIdCampania());

        $actualizar->execute();
    }

    public function delete($id_cliente_campania) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM cliente_campania WHERE id_cliente_campania = :id_cliente_campania');
        $eliminar->bindValue(':id_cliente_campania', $id_cliente_campania);
        $eliminar->execute();
    }
}
