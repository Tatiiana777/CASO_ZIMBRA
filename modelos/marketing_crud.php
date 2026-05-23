<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/marketing.php');

class Marketing_crud {
    public function __construct() {}

    public function create($marketing) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO marketing (nombre, descripcion, presupuesto, fecha_creacion, id_empresa) VALUES (:nombre, :descripcion, :presupuesto, :fecha_creacion, :id_empresa)');
        $crear->bindValue(':nombre', $marketing->getNombre());
        $crear->bindValue(':descripcion', $marketing->getDescripcion());
        $crear->bindValue(':presupuesto', $marketing->getPresupuesto());
        $crear->bindValue(':fecha_creacion', $marketing->getFechaCreacion());
        $crear->bindValue(':id_empresa', $marketing->getIdEmpresa());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM marketing');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Marketing();

            $nuevo->setIdMarketing($registro['id_marketing']);
            $nuevo->setNombre($registro['nombre']);
            $nuevo->setDescripcion($registro['descripcion']);
            $nuevo->setPresupuesto($registro['presupuesto']);
            $nuevo->setFechaCreacion($registro['fecha_creacion']);
            $nuevo->setIdEmpresa($registro['id_empresa']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_marketing) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM marketing WHERE id_marketing = :id_marketing');

        $mostrar->bindValue(':id_marketing', $id_marketing);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Marketing();

        $nuevo->setIdMarketing($registro['id_marketing']);
        $nuevo->setNombre($registro['nombre']);
        $nuevo->setDescripcion($registro['descripcion']);
        $nuevo->setPresupuesto($registro['presupuesto']);
        $nuevo->setFechaCreacion($registro['fecha_creacion']);
        $nuevo->setIdEmpresa($registro['id_empresa']);

        return $nuevo;
    }

    public function update($marketing) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE marketing
            SET nombre = :nombre, descripcion = :descripcion, presupuesto = :presupuesto, fecha_creacion = :fecha_creacion, id_empresa = :id_empresa
            WHERE id_marketing = :id_marketing'
        );

        $actualizar->bindValue(':id_marketing', $marketing->getIdMarketing());
        $actualizar->bindValue(':nombre', $marketing->getNombre());
        $actualizar->bindValue(':descripcion', $marketing->getDescripcion());
        $actualizar->bindValue(':presupuesto', $marketing->getPresupuesto());
        $actualizar->bindValue(':fecha_creacion', $marketing->getFechaCreacion());
        $actualizar->bindValue(':id_empresa', $marketing->getIdEmpresa());

        $actualizar->execute();
    }

    public function delete($id_marketing) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM marketing WHERE id_marketing = :id_marketing');
        $eliminar->bindValue(':id_marketing', $id_marketing);
        $eliminar->execute();
    }
}
