<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$conn = getDbConnection();

$statusFilter = $_GET['status'] ?? '';
$whereClause = "";
$params = [];

if ($statusFilter && in_array($statusFilter, ['pending', 'confirmed', 'completed', 'cancelled'])) {
    $whereClause = "WHERE a.status = :status";
    $params[':status'] = $statusFilter;
}

$sql = "SELECT a.*, p.name as package_name, u.full_name as user_name 
        FROM appointments a
        JOIN packages p ON a.package_id = p.id
        LEFT JOIN users u ON a.created_by = u.id
        $whereClause
        ORDER BY a.appointment_date ASC, a.appointment_time ASC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$appointments = $stmt->fetchAll();
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-calendar-heart me-2"></i>Listado de Citas</h2>
        <a href="create.php" class="btn btn-primary"><i class="bi bi-calendar-plus me-2"></i>Agendar Cita</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="index.php" class="row align-items-end g-3">
            <div class="col-md-4">
                <label for="status" class="form-label">Filtrar por Estado</label>
                <select class="form-select" id="status" name="status" onchange="this.form.submit()">
                    <option value="">Todas las citas</option>
                    <option value="pending" <?php echo $statusFilter == 'pending' ? 'selected' : ''; ?>>Pendientes</option>
                    <option value="confirmed" <?php echo $statusFilter == 'confirmed' ? 'selected' : ''; ?>>Confirmadas</option>
                    <option value="completed" <?php echo $statusFilter == 'completed' ? 'selected' : ''; ?>>Completadas</option>
                    <option value="cancelled" <?php echo $statusFilter == 'cancelled' ? 'selected' : ''; ?>>Canceladas</option>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Contacto</th>
                        <th>Paquete</th>
                        <th>Fecha y Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $app): ?>
                        <tr>
                            <td><?php echo $app['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($app['customer_name']); ?></strong></td>
                            <td>
                                <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($app['customer_phone']); ?><br>
                                <small class="text-muted"><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($app['customer_email']); ?></small>
                            </td>
                            <td><span class="badge bg-primary"><?php echo htmlspecialchars($app['package_name']); ?></span></td>
                            <td>
                                <i class="bi bi-calendar"></i> <?php echo date('d/m/Y', strtotime($app['appointment_date'])); ?><br>
                                <i class="bi bi-clock"></i> <strong><?php echo htmlspecialchars($app['appointment_time']); ?></strong>
                            </td>
                            <td>
                                <?php
                                $badgeClass = [
                                    'pending' => 'bg-warning text-dark',
                                    'confirmed' => 'bg-success',
                                    'completed' => 'bg-info text-dark',
                                    'cancelled' => 'bg-danger'
                                ][$app['status']];
                                $statusLabels = [
                                    'pending' => 'Pendiente',
                                    'confirmed' => 'Confirmada',
                                    'completed' => 'Completada',
                                    'cancelled' => 'Cancelada'
                                ];
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusLabels[$app['status']]; ?></span>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo $app['id']; ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="delete.php" style="display:inline-block;" onsubmit="return confirm('¿Seguro que desea eliminar esta cita?');">
                                    <input type="hidden" name="id" value="<?php echo $app['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
