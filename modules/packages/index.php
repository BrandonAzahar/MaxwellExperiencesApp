<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$conn = getDbConnection();

$sql = "SELECT * FROM packages ORDER BY created_at DESC";
$stmt = $conn->query($sql);
$packages = $stmt->fetchAll();
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-box2-heart me-2"></i>Paquetes Disponibles</h2>
        <a href="create.php" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Añadir Paquete</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($packages as $pkg): ?>
                        <tr>
                            <td><?php echo $pkg['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($pkg['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($pkg['description']); ?></td>
                            <td>$<?php echo number_format($pkg['price'], 2); ?></td>
                            <td>
                                <?php if ($pkg['status'] == 'active'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo $pkg['id']; ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="delete.php" style="display:inline-block;" onsubmit="return confirm('¿Seguro que desea eliminar este paquete?');">
                                    <input type="hidden" name="id" value="<?php echo $pkg['id']; ?>">
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
