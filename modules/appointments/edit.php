<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$conn = getDbConnection();

// Obtener la cita
$sql = "SELECT * FROM appointments WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);
$appointment = $stmt->fetch();

if (!$appointment) {
    setFlash('error', 'Cita no encontrada');
    header('Location: index.php');
    exit;
}

// Obtener paquetes
$sql = "SELECT * FROM packages";
$stmt = $conn->query($sql);
$packages = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? $appointment['status'];
    $notes = $_POST['notes'] ?? $appointment['notes'];
    
    $sql = "UPDATE appointments SET status = :status, notes = :notes WHERE id = :id";
    $stmt = $conn->prepare($sql);
    
    try {
        $stmt->execute([
            ':status' => $status,
            ':notes' => $notes,
            ':id' => $id
        ]);
        setFlash('success', 'Cita actualizada exitosamente');
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        setFlash('error', 'Error al actualizar: ' . $e->getMessage());
    }
}
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-pencil me-2"></i>Editar Cita #<?php echo $id; ?></h2>
        <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Volver</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($appointment['customer_name']); ?></p>
                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($appointment['customer_phone']); ?></p>
                    <p><strong>Fecha y Hora:</strong> <?php echo date('d/m/Y', strtotime($appointment['appointment_date'])); ?> a las <?php echo htmlspecialchars($appointment['appointment_time']); ?></p>
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Estado de la Cita</label>
                    <select class="form-select" id="status" name="status">
                        <option value="pending" <?php echo $appointment['status'] == 'pending' ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="confirmed" <?php echo $appointment['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmada</option>
                        <option value="completed" <?php echo $appointment['status'] == 'completed' ? 'selected' : ''; ?>>Completada</option>
                        <option value="cancelled" <?php echo $appointment['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="notes" class="form-label">Notas</label>
                <textarea class="form-control" id="notes" name="notes" rows="4"><?php echo htmlspecialchars($appointment['notes']); ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Actualizar Cita</button>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
