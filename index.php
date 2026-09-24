<?php
/**
 * Dashboard Principal
 * Maxwell Experiences
 */

$pageTitle = 'Dashboard - Maxwell Experiences';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/config/database.php';

$conn = getDbConnection();

// ============================================
// OBTENER ESTADÍSTICAS DEL DASHBOARD
// ============================================

// Total paquetes activos
$sql = "SELECT COUNT(*) as total FROM packages WHERE status = 'active'";
$stmt = $conn->query($sql);
$totalPackages = $stmt->fetch()['total'];

// Citas pendientes
$sql = "SELECT COUNT(*) as total FROM appointments WHERE status = 'pending'";
$stmt = $conn->query($sql);
$pendingAppointments = $stmt->fetch()['total'];

// Citas confirmadas
$sql = "SELECT COUNT(*) as total FROM appointments WHERE status = 'confirmed'";
$stmt = $conn->query($sql);
$confirmedAppointments = $stmt->fetch()['total'];

// Últimas 5 citas
$sql = "SELECT a.*, p.name as package_name 
        FROM appointments a
        JOIN packages p ON a.package_id = p.id
        ORDER BY a.created_at DESC
        LIMIT 5";
$stmt = $conn->query($sql);
$recentAppointments = $stmt->fetchAll();

?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard Maxwell Experiences</h2>
            <span class="text-muted"><?php echo date('d/m/Y'); ?></span>
        </div>
    </div>
</div>

<!-- Tarjetas de Estadísticas -->
<div class="row g-4 mb-4">
    <!-- Paquetes -->
    <div class="col-12 col-md-4">
        <div class="card dashboard-card card-primary-gradient h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label mb-1">Paquetes Disponibles</p>
                        <h3 class="card-value mb-0"><?php echo number_format($totalPackages); ?></h3>
                        <small class="opacity-75">Activos</small>
                    </div>
                    <i class="bi bi-box2-heart card-icon" style="font-size: 2.5rem; opacity: 0.8;"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pb-0">
                <a href="modules/packages/index.php" class="text-white text-decoration-none small">
                    Ver todos <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Citas Pendientes -->
    <div class="col-12 col-md-4">
        <div class="card dashboard-card card-warning-gradient h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label mb-1">Citas Pendientes</p>
                        <h3 class="card-value mb-0"><?php echo number_format($pendingAppointments); ?></h3>
                        <small class="opacity-75">Por confirmar</small>
                    </div>
                    <i class="bi bi-calendar-event card-icon" style="font-size: 2.5rem; opacity: 0.8;"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pb-0">
                <a href="modules/appointments/index.php?status=pending" class="text-dark text-decoration-none small">
                    Ver citas <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Citas Confirmadas -->
    <div class="col-12 col-md-4">
        <div class="card dashboard-card card-success-gradient h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-label mb-1">Citas Confirmadas</p>
                        <h3 class="card-value mb-0"><?php echo number_format($confirmedAppointments); ?></h3>
                        <small class="opacity-75">Listas para experiencia</small>
                    </div>
                    <i class="bi bi-calendar-check card-icon" style="font-size: 2.5rem; opacity: 0.8;"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pb-0">
                <a href="modules/appointments/index.php?status=confirmed" class="text-white text-decoration-none small">
                    Ver citas <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Accesos Rápidos</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="modules/appointments/create.php" class="btn btn-success">
                        <i class="bi bi-calendar-plus me-2"></i>Agendar Nueva Cita
                    </a>
                    <a href="modules/packages/create.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Añadir Nuevo Paquete
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Últimas Citas Agendadas</h5>
                <a href="modules/appointments/index.php" class="btn btn-sm btn-outline-light">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <?php if (count($recentAppointments) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Paquete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentAppointments as $app): ?>
                                    <tr>
                                        <td>
                                            <div><?php echo htmlspecialchars($app['customer_name']); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($app['customer_phone']); ?></small>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($app['appointment_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($app['appointment_time']); ?></td>
                                        <td><span class="badge bg-primary"><?php echo htmlspecialchars($app['package_name']); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-3">No hay citas recientes</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
