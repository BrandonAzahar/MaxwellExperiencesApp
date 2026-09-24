<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$conn = getDbConnection();

// Obtener paquetes activos
$sql = "SELECT * FROM packages WHERE status = 'active'";
$stmt = $conn->query($sql);
$packages = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'] ?? '';
    $customer_phone = $_POST['customer_phone'] ?? '';
    $customer_email = $_POST['customer_email'] ?? '';
    $package_id = $_POST['package_id'] ?? '';
    $appointment_date = $_POST['appointment_date'] ?? '';
    $time_hour = $_POST['time_hour'] ?? '';
    $time_minute = $_POST['time_minute'] ?? '';
    $time_ampm = $_POST['time_ampm'] ?? '';
    $notes = $_POST['notes'] ?? '';
    
    // Formatear hora a 12 horas ej. "02:30 PM"
    $appointment_time = sprintf("%02d:%02d %s", $time_hour, $time_minute, strtoupper($time_ampm));
    $created_by = $_SESSION['user_id'] ?? null;

    if ($customer_name && $package_id && $appointment_date) {
        $sql = "INSERT INTO appointments (customer_name, customer_phone, customer_email, package_id, appointment_date, appointment_time, notes, created_by) 
                VALUES (:name, :phone, :email, :package, :date, :time, :notes, :created_by)";
        $stmt = $conn->prepare($sql);
        
        try {
            $stmt->execute([
                ':name' => $customer_name,
                ':phone' => $customer_phone,
                ':email' => $customer_email,
                ':package' => $package_id,
                ':date' => $appointment_date,
                ':time' => $appointment_time,
                ':notes' => $notes,
                ':created_by' => $created_by
            ]);
            setFlash('success', 'Cita agendada exitosamente');
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            setFlash('error', 'Error al agendar la cita: ' . $e->getMessage());
        }
    } else {
        setFlash('error', 'Faltan campos obligatorios');
    }
}
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-calendar-plus me-2"></i>Agendar Nueva Cita</h2>
        <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Volver</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="create.php">
            <h5 class="mb-3 border-bottom pb-2">Datos del Cliente</h5>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="customer_name" class="form-label">Nombre Completo *</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="customer_phone" class="form-label">Teléfono *</label>
                    <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="customer_email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="customer_email" name="customer_email">
                </div>
            </div>
            
            <h5 class="mb-3 border-bottom pb-2">Detalles de la Cita</h5>
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label for="package_id" class="form-label">Paquete *</label>
                    <select class="form-select" id="package_id" name="package_id" required>
                        <option value="">Seleccione un paquete...</option>
                        <?php foreach ($packages as $pkg): ?>
                            <option value="<?php echo $pkg['id']; ?>"><?php echo htmlspecialchars($pkg['name']); ?> - $<?php echo number_format($pkg['price'], 2); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="appointment_date" class="form-label">Fecha *</label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Hora (Formato 12 Hrs) *</label>
                    <div class="input-group">
                        <select class="form-select" name="time_hour" required>
                            <?php for($i=1; $i<=12; $i++): ?>
                                <option value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option>
                            <?php endfor; ?>
                        </select>
                        <span class="input-group-text">:</span>
                        <select class="form-select" name="time_minute" required>
                            <option value="00">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>
                        <select class="form-select" name="time_ampm" required>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="notes" class="form-label">Notas Adicionales</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-save me-2"></i>Guardar Cita</button>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
