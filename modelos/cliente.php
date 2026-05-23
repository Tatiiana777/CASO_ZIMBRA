<?php
class Cliente implements JsonSerializable {
    private $id_cliente;
    private $nombre;
    private $apellido;
    private $documento;
    private $telefono;
    private $correo;
    private $fecha_conversion;
    private $id_empresa;
    private $id_lead;

    public function __construct() {}

    #[\ReturnTypeWillChange]
    public function jsonSerialize() {
        return [
            'id_cliente' => $this->id_cliente,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'documento' => $this->documento,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'fecha_conversion' => $this->fecha_conversion,
            'id_empresa' => $this->id_empresa,
            'id_lead' => $this->id_lead,
        ];
    }

    public function getIdCliente() { return $this->id_cliente; }

    public function setIdCliente($id_cliente) { $this->id_cliente = $id_cliente; }

    public function getNombre() { return $this->nombre; }

    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getApellido() { return $this->apellido; }

    public function setApellido($apellido) { $this->apellido = $apellido; }

    public function getDocumento() { return $this->documento; }

    public function setDocumento($documento) { $this->documento = $documento; }

    public function getTelefono() { return $this->telefono; }

    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getCorreo() { return $this->correo; }

    public function setCorreo($correo) { $this->correo = $correo; }

    public function getFechaConversion() { return $this->fecha_conversion; }

    public function setFechaConversion($fecha_conversion) { $this->fecha_conversion = $fecha_conversion; }

    public function getIdEmpresa() { return $this->id_empresa; }

    public function setIdEmpresa($id_empresa) { $this->id_empresa = $id_empresa; }

    public function getIdLead() { return $this->id_lead; }

    public function setIdLead($id_lead) { $this->id_lead = $id_lead; }

}
