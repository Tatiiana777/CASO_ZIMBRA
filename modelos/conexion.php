<?php
class Conexion {
    private static $host = "localhost";
    private static $dbname = "ejemplo"/* por definir */;
    private static $user = "root";
    private static $password = "";
    private static $port = "3306"/* por definir */;
    private static $conexion = null;
    
    public static function conectar() {
        if (self::$conexion == null) {
            try {
                self::$conexion = new PDO(
                    "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbname,
                    self::$user,
                    self::$password
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