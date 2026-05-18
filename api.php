<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('modelos/conexion.php');
$entidad = isset($_GET['entidad']) ? strtolower($_GET['entidad']) : null;

if (!$entidad) {
    echo json_encode(["mensaje" => "Error al especificar la entidad, debeser ?entidad=usuario"]);
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
        
        $agregar = new $entidad_modelo();
        
        foreach ($atributo as $propiedad => $insercion) {
            $metodoSet = 'set' . ucfirst($propiedad);
            $agregar -> $metodoSet($insercion);
        }

        $crud -> create($agregar);

        echo json_encode(["mensaje" => " ha sido creado"]);
        break;
    
    case 'GET':
        if (isset($_GET['id'])) {
            $atributos = $crud -> getId($_GET['id']);
            echo json_encode($atributos);
        } else {
            echo json_encode($crud -> read());
        }
        break;
    
    case 'PUT':
        $atributo = json_decode(file_get_contents("php://input"), true);
        
        $aEditar = new $entidad_modelo();

        foreach ($atributo as $propiedad => $insercion) {
            $metodoSet = 'set' . ucfirst($propiedad);
            $aEditar -> $metodoSet($insercion);
        }

        $crud -> update($aEditar);

        echo json_encode(["mensaje" => " ha sido actualizado"]);
        break;
    
    case 'DELETE':
        $crud->delete($_GET['id']);
        
        echo json_encode(["mensaje" => " ha sido eliminado"]);
        break;
    
    default:
        echo json_encode(["mensaje" => "400 Solicitud incorrecta"]);
        break;
}
?>