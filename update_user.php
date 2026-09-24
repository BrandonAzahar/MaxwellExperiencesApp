<?php
require_once __DIR__ . '/config/database.php';
try {
    $conn = getDbConnection();
    // Actualizar usuario existente (admin) a SA y cambiar su contraseña
    $sql = "UPDATE users SET username = 'SA', password = :password WHERE role = 'admin' LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':password' => '$2y$10$XTamFyYTRHkAgPG/m//rYeCwRdT/azRp5O.VQTe0gen/0v7rHDuTi']);
    
    // Si no había ninguno, insertarlo
    if ($stmt->rowCount() == 0) {
        $conn->exec("INSERT INTO users (username, password, full_name, email, role) VALUES ('SA', '\$2y\$10\$XTamFyYTRHkAgPG/m//rYeCwRdT/azRp5O.VQTe0gen/0v7rHDuTi', 'Administrador General', 'admin@maxwellexperiences.com', 'admin')");
    }
    
    echo "Usuario actualizado con éxito.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
