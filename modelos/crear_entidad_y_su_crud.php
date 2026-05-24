<?php
$entidades = [
    "Empresa" => [
        "nombre",
        "nit",
        "direccion",
        "telefono",
        "sector",
        "fecha_registro"
    ],
    "Rol" => [
        "nombre_rol",
        "descripcion"
    ],
    "Usuario" => [
        "nombre",
        "correo",
        "contrasena",
        "telefono",
        "activo",
        "fecha_creacion",
        "id_empresa",
        "id_rol"
    ],
    "Auditoria" => [
        "accion",
        "tabla_afectada",
        "fecha",
        "descripcion",
        "id_usuario"
    ],
    // BLOQUE CRM
    "Marketing" => [
        "nombre",
        "descripcion",
        "presupuesto",
        "fecha_creacion",
        "id_empresa"
    ],
    "Campania" => [
        "nombre",
        "descripcion",
        "fecha_inicio",
        "fecha_fin",
        "costo",
        "estado",
        "id_marketing",
        "id_usuario"
    ],
    "Lead" => [
        "nombre",
        "empresa",
        "correo",
        "telefono",
        "pais",
        "estado_contacto",
        "fecha_registro",
        "id_campania",
        "id_usuario"
    ],
    "Seguimiento" => [
        "fecha",
        "canal",
        "resultado",
        "proxima_accion",
        "notas",
        "id_lead",
        "id_usuario"
    ],
    // BLOQUE COMERCIAL
    "Proveedor" => [
        "nombre",
        "nit",
        "telefono",
        "correo",
        "direccion",
        "activo",
        "id_empresa"
    ],
    "Producto_Servicio" => [
        "nombre",
        "descripcion",
        "precio_base",
        "stock",
        "activo",
        "id_proveedor"
    ],
    "Propuesta" => [
        "fecha_creacion",
        "fecha_vigencia",
        "valor_total",
        "estado",
        "observaciones",
        "id_lead",
        "id_usuario"
    ],
    "Detalle_Propuesta" => [
        "cantidad",
        "precio_unitario",
        "descuento",
        "subtotal",
        "id_propuesta",
        "id_producto"
    ],
    // BLOQUE ERP
    "Cliente" => [
        "nombre",
        "apellido",
        "documento",
        "telefono",
        "correo",
        "fecha_conversion",
        "id_empresa",
        "id_lead"
    ],
    "Cliente_Campania" => [
        "fecha_contacto",
        "estado",
        "id_cliente",
        "id_campania"
    ],
    "Empleado" => [
        "nombre",
        "cargo",
        "telefono",
        "correo",
        "id_usuario",
        "id_empresa"
    ],
    "Pedido" => [
        "fecha",
        "estado",
        "id_cliente",
        "id_empleado",
        "id_propuesta"
    ],
    "Detalle_Pedido" => [
        "cantidad",
        "precio_unitario",
        "subtotal",
        "id_pedido",
        "id_producto"
    ],
    "Factura" => [
        "fecha_emision",
        "total",
        "estado",
        "id_pedido"
    ],
    "Pago" => [
        "fecha_pago",
        "metodo_pago",
        "valor",
        "id_factura"
    ],
    "Reporte" => [
        "tipo_reporte",
        "periodo_inicio",
        "periodo_fin",
        "fecha_generacion",
        "observaciones",
        "id_usuario"
    ]
];

function pascalCase($string) {
    return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
}

foreach ($entidades as $entidad => $campos) {
    $tabla = strtolower($entidad);
    $id_primario = "id_" . $tabla;
    
    // Entidad
    $clase = "class $entidad implements JsonSerializable {\n";
    $clase .= "    private \$$id_primario;\n";
    foreach ($campos as $campo) {
        $clase .= "    private \$$campo;\n";
    }
    $clase .= "\n";
    $clase .= "    public function __construct() {}\n";
    $clase .= "\n";
    $clase .= "    #[\ReturnTypeWillChange]\n";
    $clase .= "    public function jsonSerialize() {\n";
    $clase .= "        return [\n";
    $clase .= "            '$id_primario' => \$this->$id_primario,\n";
    foreach ($campos as $campo) {
        $clase .= "            '$campo' => \$this->$campo,\n";
    }
    $clase .= "        ];\n";
    $clase .= "    }\n";
    $clase .= "\n";
    $clase .= "    public function get" . pascalCase($id_primario) . "() { return \$this->$id_primario; }\n";
    $clase .= "\n";
    $clase .= "    public function set" . pascalCase($id_primario) . "(\$$id_primario) { \$this->$id_primario = \$$id_primario; }\n";
    $clase .= "\n";
    foreach ($campos as $campo) {
        $clase .= "    public function get" . pascalCase($campo) . "() { return \$this->$campo; }\n";
        $clase .= "\n";
        $clase .= "    public function set" . pascalCase($campo) . "(\$$campo) { \$this->$campo = \$$campo; }\n";
        $clase .= "\n";
    }
    $clase .= "}\n";

    file_put_contents($tabla . ".php", "<?php\n" . $clase);

    // Crud's
    $crud = "require_once(__DIR__ . '/conexion.php');\n";
    $crud .= "require_once(__DIR__ . '/" . $tabla . ".php');\n";
    $crud .= "\n";
    $crud .= "class " . ucfirst($entidad) . "_crud {\n";
    $crud .= "    public function __construct() {}\n";
    $crud .= "\n";

    // CREATE
    $crud .= "    public function create(\$$tabla) {\n";
    $crud .= "        \$db = Conexion::conectar();\n";
    $crud .= "        \$crear = \$db -> prepare('INSERT INTO $tabla (" . implode(", ", $campos) . ") VALUES (:" . implode(", :", $campos) . ")');\n";
    foreach ($campos as $campo) {
        $crud .= "        \$crear->bindValue(':$campo', \$$tabla" . "->get" . pascalCase($campo) . "());\n";
    }
    $crud .= "        \$crear->execute();\n";
    $crud .= "    }\n";
    $crud .= "\n";

    // READ
    $crud .= "    public function read() {\n";
    $crud .= "        \$db = Conexion::conectar();\n";
    $crud .= "        \$lista = [];\n";
    $crud .= "\n";
    $crud .= "        \$mostrar = \$db->query('SELECT * FROM $tabla');\n";
    $crud .= "\n";
    $crud .= "        foreach (\$mostrar->fetchAll(PDO::FETCH_ASSOC) as \$registro) {\n";
    $crud .= "            \$nuevo = new $entidad();\n";
    $crud .= "\n";
    $crud .= "            \$nuevo->set" . pascalCase($id_primario) . "(\$registro['$id_primario']);\n";
    foreach ($campos as $campo)
        $crud .= "            \$nuevo->set" . pascalCase($campo) . "(\$registro['$campo']);\n";
    $crud .= "\n";
    $crud .= "            \$lista[] = \$nuevo;\n";
    $crud .= "        }\n";
    $crud .= "\n";
    $crud .= "        return \$lista;\n";
    $crud .= "    }\n";
    $crud .= "\n";

    // get id
    $crud .= "    public function getId(\$$id_primario) {\n";
    $crud .= "        \$db = Conexion::conectar();\n";
    $crud .= "\n";
    $crud .= "        \$mostrar = \$db->prepare('SELECT * FROM $tabla WHERE $id_primario = :$id_primario');\n";
    $crud .= "\n";
    $crud .= "        \$mostrar->bindValue(':$id_primario', \$$id_primario);\n";
    $crud .= "        \$mostrar->execute();\n";
    $crud .= "\n";
    $crud .= "        \$registro = \$mostrar->fetch(PDO::FETCH_ASSOC);\n";
    $crud .= "\n";
    $crud .= "        if (!\$registro) return null;\n";
    $crud .= "\n";
    $crud .= "        \$nuevo = new $entidad();\n";
    $crud .= "\n";
    $crud .= "        \$nuevo->set" . pascalCase($id_primario) . "(\$registro['$id_primario']);\n";
    foreach ($campos as $campo) 
        $crud .= "        \$nuevo->set" . pascalCase($campo) . "(\$registro['$campo']);\n";
    $crud .= "\n";
    $crud .= "        return \$nuevo;\n";
    $crud .= "    }\n";
    $crud .= "\n";
    
    // UPDATE
    $sets = [];
    foreach ($campos as $campo) {
        $sets[] = "$campo = :$campo";
    }
    $crud .= "    public function update(\$$tabla) {\n";
    $crud .= "        \$db = Conexion::conectar();\n";
    $crud .= "\n";
    $crud .= "        \$actualizar = \$db->prepare(\n";
    $crud .= "            'UPDATE $tabla\n";
    $crud .= "            SET " . implode(", ", $sets) . "\n";
    $crud .= "            WHERE $id_primario = :$id_primario'\n";
    $crud .= "        );\n";
    $crud .= "\n";
    $crud .= "        \$actualizar->bindValue(':$id_primario', \$$tabla" . "->get" . pascalCase($id_primario) . "());\n";
    foreach ($campos as $campo) {
        $crud .= "        \$actualizar->bindValue(':$campo', \$$tabla" . "->get" . pascalCase($campo) . "());\n";
    }
    $crud .= "\n";
    $crud .= "        \$actualizar->execute();\n";
    $crud .= "    }\n";
    $crud .= "\n";
    
    // DELETE
    $crud .= "    public function delete(\$$id_primario) {\n";
    $crud .= "        \$db = Conexion::conectar();\n";
    $crud .= "        \$eliminar = \$db->prepare('DELETE FROM $tabla WHERE $id_primario = :$id_primario');\n";
    $crud .= "        \$eliminar->bindValue(':$id_primario', \$$id_primario);\n";
    $crud .= "        \$eliminar->execute();\n";
    $crud .= "    }\n";
    $crud .= "}\n";

    file_put_contents($tabla . "_crud.php", "<?php\n" . $crud);
}
