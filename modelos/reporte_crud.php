<?php
require_once(__DIR__ . '/conexion.php');
require_once(__DIR__ . '/reporte.php');

class Reporte_crud {
    public function __construct() {}

    public function create($reporte) {
        $db = Conexion::conectar();
        $crear = $db -> prepare('INSERT INTO reporte (tipo_reporte, periodo_inicio, periodo_fin, fecha_generacion, observaciones, id_usuario) VALUES (:tipo_reporte, :periodo_inicio, :periodo_fin, :fecha_generacion, :observaciones, :id_usuario)');
        $crear->bindValue(':tipo_reporte', $reporte->getTipoReporte());
        $crear->bindValue(':periodo_inicio', $reporte->getPeriodoInicio());
        $crear->bindValue(':periodo_fin', $reporte->getPeriodoFin());
        $crear->bindValue(':fecha_generacion', $reporte->getFechaGeneracion());
        $crear->bindValue(':observaciones', $reporte->getObservaciones());
        $crear->bindValue(':id_usuario', $reporte->getIdUsuario());
        $crear->execute();
    }

    public function read() {
        $db = Conexion::conectar();
        $lista = [];

        $mostrar = $db->query('SELECT * FROM reporte');

        foreach ($mostrar->fetchAll(PDO::FETCH_ASSOC) as $registro) {
            $nuevo = new Reporte();

            $nuevo->setIdReporte($registro['id_reporte']);
            $nuevo->setTipoReporte($registro['tipo_reporte']);
            $nuevo->setPeriodoInicio($registro['periodo_inicio']);
            $nuevo->setPeriodoFin($registro['periodo_fin']);
            $nuevo->setFechaGeneracion($registro['fecha_generacion']);
            $nuevo->setObservaciones($registro['observaciones']);
            $nuevo->setIdUsuario($registro['id_usuario']);

            $lista[] = $nuevo;
        }

        return $lista;
    }

    public function getId($id_reporte) {
        $db = Conexion::conectar();

        $mostrar = $db->prepare('SELECT * FROM reporte WHERE id_reporte = :id_reporte');

        $mostrar->bindValue(':id_reporte', $id_reporte);
        $mostrar->execute();

        $registro = $mostrar->fetch(PDO::FETCH_ASSOC);

        if (!$registro) return null;

        $nuevo = new Reporte();

        $nuevo->setIdReporte($registro['id_reporte']);
        $nuevo->setTipoReporte($registro['tipo_reporte']);
        $nuevo->setPeriodoInicio($registro['periodo_inicio']);
        $nuevo->setPeriodoFin($registro['periodo_fin']);
        $nuevo->setFechaGeneracion($registro['fecha_generacion']);
        $nuevo->setObservaciones($registro['observaciones']);
        $nuevo->setIdUsuario($registro['id_usuario']);

        return $nuevo;
    }

    public function update($reporte) {
        $db = Conexion::conectar();

        $actualizar = $db->prepare(
            'UPDATE reporte
            SET tipo_reporte = :tipo_reporte, periodo_inicio = :periodo_inicio, periodo_fin = :periodo_fin, fecha_generacion = :fecha_generacion, observaciones = :observaciones, id_usuario = :id_usuario
            WHERE id_reporte = :id_reporte'
        );

        $actualizar->bindValue(':id_reporte', $reporte->getIdReporte());
        $actualizar->bindValue(':tipo_reporte', $reporte->getTipoReporte());
        $actualizar->bindValue(':periodo_inicio', $reporte->getPeriodoInicio());
        $actualizar->bindValue(':periodo_fin', $reporte->getPeriodoFin());
        $actualizar->bindValue(':fecha_generacion', $reporte->getFechaGeneracion());
        $actualizar->bindValue(':observaciones', $reporte->getObservaciones());
        $actualizar->bindValue(':id_usuario', $reporte->getIdUsuario());

        $actualizar->execute();
    }

    public function delete($id_reporte) {
        $db = Conexion::conectar();
        $eliminar = $db->prepare('DELETE FROM reporte WHERE id_reporte = :id_reporte');
        $eliminar->bindValue(':id_reporte', $id_reporte);
        $eliminar->execute();
    }
}
