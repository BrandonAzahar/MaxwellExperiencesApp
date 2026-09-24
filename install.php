<?php
require_once __DIR__ . '/config/database.php';

// Conexión sin especificar base de datos
try {
    $dsn = "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $conn = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("Error de conexión al servidor MySQL: " . $e->getMessage() . "<br>Verifica que XAMPP y MySQL estén ejecutándose.");
}

// Leer el archivo SQL
$sqlFile = __DIR__ . '/create_database.sql';
if (!file_exists($sqlFile)) {
    die("Error: No se encuentra el archivo create_database.sql");
}

$sql = file_get_contents($sqlFile);

try {
    // Ejecutar el script SQL completo
    $conn->exec($sql);
    echo "<h2>¡Base de datos y tablas creadas exitosamente!</h2>";
    echo "<p>El sistema de Maxwell Experiences ha sido instalado correctamente.</p>";
    echo "<p>Puedes iniciar sesión con:<br>Usuario: <b>SA</b><br>Contraseña: <b>1234</b></p>";
    echo "<a href='login.php'>Ir al Login</a>";
} catch (PDOException $e) {
    echo "<h2>Error al crear la base de datos:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
