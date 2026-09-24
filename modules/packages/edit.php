<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$conn = getDbConnection();

$sql = "SELECT * FROM packages WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);
$package = $stmt->fetch();

if (!$package) {
    setFlash('error', 'Paquete no encontrado');
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $status = $_POST['status'] ?? 'active';

    if ($name) {
        $sql = "UPDATE packages SET name = :name, description = :description, price = :price, status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        try {
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':status' => $status,
                ':id' => $id
            ]);
            setFlash('success', 'Paquete actualizado exitosamente');
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            setFlash('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }
}
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-pencil me-2"></i>Editar Paquete</h2>
        <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Volver</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre del Paquete *</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($package['name']); ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="price" class="form-label">Precio ($)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($package['price']); ?>">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Estado</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active" <?php echo $package['status'] == 'active' ? 'selected' : ''; ?>>Activo</option>
                        <option value="inactive" <?php echo $package['status'] == 'inactive' ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($package['description']); ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Actualizar Paquete</button>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
