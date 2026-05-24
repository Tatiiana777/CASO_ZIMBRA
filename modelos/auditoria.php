<?php
class Auditoria implements JsonSerializable {
    private $id_auditoria;
    private $accion;
    private $tabla_afectada;
    private $fecha;
    private $descripcion;
    private $id_usuario;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_auditoria' => $this->id_auditoria,
            'accion' => $this->accion,
            'tabla_afectada' => $this->tabla_afectada,
            'fecha' => $this->fecha,
            'descripcion' => $this->descripcion,
            'id_usuario' => $this->id_usuario,
        ];
    }

    public function getIdAuditoria() { return $this->id_auditoria; }

    public function setIdAuditoria($id_auditoria) { $this->id_auditoria = $id_auditoria; }

    public function getAccion() { return $this->accion; }

    public function setAccion($accion) { $this->accion = $accion; }

    public function getTablaAfectada() { return $this->tabla_afectada; }

    public function setTablaAfectada($tabla_afectada) { $this->tabla_afectada = $tabla_afectada; }

    public function getFecha() { return $this->fecha; }

    public function setFecha($fecha) { $this->fecha = $fecha; }

    public function getDescripcion() { return $this->descripcion; }

    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }

    public function getIdUsuario() { return $this->id_usuario; }

    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

}
