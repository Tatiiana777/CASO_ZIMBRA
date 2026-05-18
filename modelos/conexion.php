<?php
class Conexion {
    private static $conexion = null;
    
    public static function conectar() {
        if (self::$conexion == null) {
            $config = parse_ini_file(__DIR__ . '/../.env');

            try {
                self::$conexion = new PDO(
                    "mysql:host=" . $config['DB_HOST'] .
                    ";port=" . $config['DB_PORT'] .
                    ";dbname=" . $config['DB_NAME'],
                    $config['DB_USER'],
                    $config['DB_PASS']
                );
                self::$conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error al conectarse con la base de datos: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }

    public static function desconectar() {
        self::$conexion = null;
    }
}
?>