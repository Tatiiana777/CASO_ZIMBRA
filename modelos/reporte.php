<?php
class Reporte implements JsonSerializable {
    private $id_reporte;
    private $tipo_reporte;
    private $periodo_inicio;
    private $periodo_fin;
    private $fecha_generacion;
    private $observaciones;
    private $id_usuario;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_reporte' => $this->id_reporte,
            'tipo_reporte' => $this->tipo_reporte,
            'periodo_inicio' => $this->periodo_inicio,
            'periodo_fin' => $this->periodo_fin,
            'fecha_generacion' => $this->fecha_generacion,
            'observaciones' => $this->observaciones,
            'id_usuario' => $this->id_usuario,
        ];
    }

    public function getIdReporte() { return $this->id_reporte; }

    public function setIdReporte($id_reporte) { $this->id_reporte = $id_reporte; }

    public function getTipoReporte() { return $this->tipo_reporte; }

    public function setTipoReporte($tipo_reporte) { $this->tipo_reporte = $tipo_reporte; }

    public function getPeriodoInicio() { return $this->periodo_inicio; }

    public function setPeriodoInicio($periodo_inicio) { $this->periodo_inicio = $periodo_inicio; }

    public function getPeriodoFin() { return $this->periodo_fin; }

    public function setPeriodoFin($periodo_fin) { $this->periodo_fin = $periodo_fin; }

    public function getFechaGeneracion() { return $this->fecha_generacion; }

    public function setFechaGeneracion($fecha_generacion) { $this->fecha_generacion = $fecha_generacion; }

    public function getObservaciones() { return $this->observaciones; }

    public function setObservaciones($observaciones) { $this->observaciones = $observaciones; }

    public function getIdUsuario() { return $this->id_usuario; }

    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

}
