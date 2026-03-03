<?php
require_once '../db.php';
require_once 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $in_stock = isset($_POST['in_stock']) ? 1 : 0;

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../fabrics/';
        if (!is_dir($uploadDir)) {
             mkdir($uploadDir, 0755, true);
        }
        
        $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        
        if (in_array($fileExt, $allowed)) {
            $fileName = uniqid('fabric_') . '.' . $fileExt;
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = 'fabrics/' . $fileName;
                
                try {
                    $stmt = $pdo->prepare("INSERT INTO fabrics (name, image_path, category, price, description, quantity, in_stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $imagePath, $category, $price, $description, $quantity, $in_stock]);
                    $success = 'Fabric added successfully!';
                } catch (PDOException $e) {
                    $error = 'Database error: ' . $e->getMessage();
                }
            } else {
                $error = 'Failed to move uploaded file.';
            }
        } else {
            $error = 'Invalid file type. Allowed: jpg, jpeg, png, webp.';
        }
    } else {
        $error = 'Please upload an image.';
    }
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Fabric</h1>
    <a href="fabrics.php" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Fabric Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="General">General</option>
                                <option value="cotton">Cotton</option>
                                <option value="silk">Silk</option>
                                <option value="wool">Wool</option>
                                <option value="linen">Linen</option>
                                <option value="velvet">Velvet</option>
                                <option value="lace">Lace</option>
                                <option value="luxury">Luxury</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price (₦)</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Fabric Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity (Yards/Pieces)</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="10" required>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="in_stock" name="in_stock" checked>
                                <label class="form-check-label" for="in_stock">In Stock</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Upload Fabric</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
