<?php
require_once '../../config/database.php';
require_once '../../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $status = $_POST['status'] ?? 'active';

    if ($name) {
        $conn = getDbConnection();
        $sql = "INSERT INTO packages (name, description, price, status) VALUES (:name, :description, :price, :status)";
        $stmt = $conn->prepare($sql);
        
        try {
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':status' => $status
            ]);
            setFlash('success', 'Paquete creado exitosamente');
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            setFlash('error', 'Error al crear el paquete: ' . $e->getMessage());
        }
    } else {
        setFlash('error', 'El nombre del paquete es obligatorio');
    }
}
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-plus-circle me-2"></i>Añadir Nuevo Paquete</h2>
        <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Volver</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="create.php">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre del Paquete *</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-3">
                    <label for="price" class="form-label">Precio ($)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="0.00">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Estado</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active">Activo</option>
                        <option value="inactive">Inactivo</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Guardar Paquete</button>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
