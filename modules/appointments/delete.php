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
            $sql = "DELETE FROM appointments WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            setFlash('success', 'Cita eliminada exitosamente');
        } catch (PDOException $e) {
            setFlash('error', 'Error al eliminar la cita: ' . $e->getMessage());
        }
    }
}
header('Location: index.php');
exit;
