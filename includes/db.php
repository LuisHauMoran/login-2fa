<?php
/**
 * Database Connection File
 * Archivo de conexión a la base de datos
 */

define('DB_HOST', 'localhost');
define('DB_NAME', '2fadb');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    // Create secure PDO connection / Crear conexión PDO segura
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions / Habilitar excepciones
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Cleaner fetching / Fetch más limpio
        ]
    );
} catch (PDOException $e) {
    // Stop execution on connection fail / Detener ejecución en fallo
    exit("Database connection error / Error de conexión: " . $e->getMessage());
}
?>
