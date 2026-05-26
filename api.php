<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once(__DIR__ . '/modelos/conexion.php');

function responder($datos, $codigo = 200) {
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit;
}

function pascalCase($string) {
    return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
}

function aplicarAtributos($objeto, $atributos) {
    foreach ($atributos as $propiedad => $insercion) {
        $metodoSet = 'set' . pascalCase($propiedad);

        if (method_exists($objeto, $metodoSet)) {
            $objeto->$metodoSet($insercion);
        }
    }
}

$entidades = [
    "auditoria" => ["modelo" => "Auditoria", "crud" => "Auditoria_crud"],
    "campania" => ["modelo" => "Campania", "crud" => "Campania_crud"],
    "cliente" => ["modelo" => "Cliente", "crud" => "Cliente_crud"],
    "cliente_campania" => ["modelo" => "Cliente_Campania", "crud" => "Cliente_Campania_crud"],
    "detalle_pedido" => ["modelo" => "Detalle_Pedido", "crud" => "Detalle_Pedido_crud"],
    "detalle_propuesta" => ["modelo" => "Detalle_Propuesta", "crud" => "Detalle_Propuesta_crud"],
    "empleado" => ["modelo" => "Empleado", "crud" => "Empleado_crud"],
    "empresa" => ["modelo" => "Empresa", "crud" => "Empresa_crud"],
    "factura" => ["modelo" => "Factura", "crud" => "Factura_crud"],
    "lead" => ["modelo" => "Lead", "crud" => "Lead_crud"],
    "marketing" => ["modelo" => "Marketing", "crud" => "Marketing_crud"],
    "pago" => ["modelo" => "Pago", "crud" => "Pago_crud"],
    "pedido" => ["modelo" => "Pedido", "crud" => "Pedido_crud"],
    "producto_servicio" => ["modelo" => "Producto_Servicio", "crud" => "Producto_Servicio_crud"],
    "propuesta" => ["modelo" => "Propuesta", "crud" => "Propuesta_crud"],
    "proveedor" => ["modelo" => "Proveedor", "crud" => "Proveedor_crud"],
    "reporte" => ["modelo" => "Reporte", "crud" => "Reporte_crud"],
    "rol" => ["modelo" => "Rol", "crud" => "Rol_crud"],
    "seguimiento" => ["modelo" => "Seguimiento", "crud" => "Seguimiento_crud"],
    "usuario" => ["modelo" => "Usuario", "crud" => "Usuario_crud"],
];

$aliases = [
    "campana" => "campania",
    "campaña" => "campania",
    "detalle_propuestas" => "detalle_propuesta",
    "productos" => "producto_servicio",
    "ventas" => "pedido",
    "venta" => "pedido",
];

$entidad = isset($_GET['entidad']) ? strtolower($_GET['entidad']) : null;
$accion = isset($_GET['accion']) ? strtolower($_GET['accion']) : null;

if ($accion) {
    $db = Conexion::conectar();

    switch ($accion) {
        case 'dashboard':
            $consulta = $db->query('SELECT * FROM vw_dashboard_comercial');
            responder($consulta->fetch(PDO::FETCH_ASSOC));

        case 'reporte_mensual':
            $periodo = $_GET['periodo'] ?? date('Y-m');
            $stmt = $db->prepare('CALL sp_reporte_mensual(:periodo)');
            $stmt->bindValue(':periodo', $periodo);
            $stmt->execute();
            responder($stmt->fetchAll(PDO::FETCH_ASSOC));

        case 'conversion':
            $stmt = $db->query('SELECT fn_tasa_conversion() AS tasa_conversion');
            responder($stmt->fetch(PDO::FETCH_ASSOC));

        default:
            responder(["mensaje" => "Accion no valida."], 400);
    }
}

if (!$entidad) {
    responder([
        "mensaje" => "Entidad no especificada.",
        "entidades_permitidas" => array_keys($entidades),
        "acciones_permitidas" => ["dashboard", "reporte_mensual", "conversion"],
    ], 400);
}

if (isset($aliases[$entidad])) {
    $entidad = $aliases[$entidad];
}

if (!isset($entidades[$entidad])) {
    responder([
        "mensaje" => "Entidad no valida.",
        "entidades_permitidas" => array_keys($entidades),
    ], 400);
}

$archivo_entidad = __DIR__ . "/modelos/" . $entidad . ".php";
$archivo_crud = __DIR__ . "/modelos/" . $entidad . "_crud.php";

if (!file_exists($archivo_entidad) || !file_exists($archivo_crud)) {
    responder(["mensaje" => "Archivos de la entidad no encontrados."], 500);
}

require_once($archivo_entidad);
require_once($archivo_crud);

$entidad_modelo = $entidades[$entidad]["modelo"];
$entidad_crud = $entidades[$entidad]["crud"];
$crud = new $entidad_crud();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'POST':
        $atributo = json_decode(file_get_contents("php://input"), true);

        if (!$atributo) {
            responder(["mensaje" => "Body JSON invalido o vacio"], 400);
        }

        $agregar = new $entidad_modelo();
        aplicarAtributos($agregar, $atributo);
        $crud->create($agregar);

        responder(["mensaje" => "$entidad ha sido creado"], 201);

    case 'GET':
        if (isset($_GET['id'])) {
            $atributos = $crud->getId($_GET['id']);

            if ($atributos === null) {
                responder(["mensaje" => "Registro no encontrado"], 404);
            }

            responder($atributos);
        }

        responder($crud->read());

    case 'PUT':
        $atributo = json_decode(file_get_contents("php://input"), true);

        if (!$atributo) {
            responder(["mensaje" => "Body JSON invalido o vacio"], 400);
        }

        if (!isset($atributo["id_" . $entidad]) && isset($_GET['id'])) {
            $atributo["id_" . $entidad] = $_GET['id'];
        }

        $aEditar = new $entidad_modelo();
        aplicarAtributos($aEditar, $atributo);
        $crud->update($aEditar);

        responder(["mensaje" => "$entidad ha sido actualizado"]);

    case 'DELETE':
        if (!isset($_GET['id'])) {
            responder(["mensaje" => "Falta el parametro id"], 400);
        }

        $crud->delete($_GET['id']);
        responder(["mensaje" => "$entidad ha sido eliminado"]);

    default:
        responder(["mensaje" => "Metodo no permitido"], 405);
}
?>
