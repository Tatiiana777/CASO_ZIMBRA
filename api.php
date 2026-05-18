<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('modelos/conexion.php');

function pascalCase($string) {
    return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
}

$entidades_permitidas = [
    "rol", "usuario", "seguimiento", "campania",
    "lead", "propuesta", "venta", "auditoria",
    "producto_servicio", "detalle_propuestas"
];

$entidad = isset($_GET['entidad']) ? strtolower($_GET['entidad']) : null;

if (!$entidad || !in_array($entidad, $entidades_permitidas)) {
    echo json_encode([
        "mensaje" => "Entidad no válida o no especificada.",
        "entidades permitidas: " => $entidades_permitidas]);
    exit;
}

$archivo_entidad = "modelos/" . $entidad . ".php";
$archivo_crud = "modelos/" . $entidad . "_crud.php";
$entidad_crud = ucfirst($entidad) . "_crud";
$entidad_modelo = ucfirst($entidad);

require_once($archivo_entidad);
require_once($archivo_crud);

$crud = new $entidad_crud();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'POST':
        $atributo = json_decode(file_get_contents("php://input"), true);
        
        if (!$atributo) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Body JSON inválido o vacío"]);
            exit;
        }

        $agregar = new $entidad_modelo();
        
        foreach ($atributo as $propiedad => $insercion) {
            $metodoSet = 'set' . pascalCase($propiedad);
            $agregar -> $metodoSet($insercion);
        }

        $crud -> create($agregar);

        echo json_encode(["mensaje" => "$entidad ha sido creado"]);
        break;
    
    case 'GET':
        if (isset($_GET['id'])) {
            $atributos = $crud -> getId($_GET['id']);
            
            if ($atributos === null) {
                http_response_code(404);
                echo json_encode(["mensaje" => "Registro no encontrado"]);
            } else {
                echo json_encode($atributos);
            }
        } else {
            echo json_encode($crud -> read());
        }
        break;
    
    case 'PUT':
        $atributo = json_decode(file_get_contents("php://input"), true);
        
        if (!$atributo) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Body JSON inválido o vacío"]);
            exit;
        }
        
        $aEditar = new $entidad_modelo();

        foreach ($atributo as $propiedad => $insercion) {
            $metodoSet = 'set' . pascalCase($propiedad);
            $aEditar -> $metodoSet($insercion);
        }

        $crud -> update($aEditar);

        echo json_encode(["mensaje" => "$entidad ha sido actualizado"]);
        break;
    
    case 'DELETE':
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["mensaje" => "Falta el parámetro id"]);
            exit;
        }
        $crud->delete($_GET['id']);
        
        echo json_encode(["mensaje" => "$entidad ha sido eliminado"]);
        break;
    
    default:
        echo json_encode(["mensaje" => "400 Solicitud incorrecta"]);
        break;
}
?>