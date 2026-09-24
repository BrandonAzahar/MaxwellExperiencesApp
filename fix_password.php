<?php
require_once __DIR__ . '/config/database.php';

try {
    $conn = getDbConnection();
    $hash = password_hash('1234', PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = :password, username = 'SA' WHERE username = 'SA' OR role = 'admin'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':password' => $hash]);
    echo "<h2>Contraseña actualizada correctamente</h2>";
    echo "<p>El usuario SA ahora tiene la contraseña 1234.</p>";
    echo "<a href='login.php'>Ir al login</a>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
