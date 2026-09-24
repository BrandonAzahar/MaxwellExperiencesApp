<?php
require_once '../../config/database.php';
require_once '../../includes/helpers.php';
require_once '../../includes/auth.php';

requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    if ($id) {
        $conn = getDbConnection();
        try {
            $sql = "DELETE FROM packages WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            setFlash('success', 'Paquete eliminado exitosamente');
        } catch (PDOException $e) {
            // Podría fallar por Foreign Key si hay citas asociadas
            setFlash('error', 'Error al eliminar: Es posible que este paquete tenga citas asociadas.');
        }
    }
}
header('Location: index.php');
exit;
