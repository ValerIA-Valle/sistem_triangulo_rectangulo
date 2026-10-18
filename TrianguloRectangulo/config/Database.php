<?php
class Database {
    private static $host = 'localhost';
    private static $db_name = 'triangulo_db'; // Asegúrate de que tu base de datos en phpMyAdmin se llame así o cámbialo aquí
    private static $username = 'root';        // Usuario por defecto de XAMPP
    private static $password = '';            // Contraseña por defecto de XAMPP (vacía)
    private static $conn = null;

    public static function conectar() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8",
                    self::$username,
                    self::$password
                );
                // Configurar para que lance excepciones en caso de errores
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
