<?php
require_once '../db.php';
require_once 'includes/header.php';

// Handle deletion
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    try {
        // Fetch image path to delete file
        $stmt = $pdo->prepare("SELECT image_path FROM fabrics WHERE id = ?");
        $stmt->execute([$id]);
        $fabric = $stmt->fetch();
        
        if ($fabric) {
             // Delete from DB
            $stmt = $pdo->prepare("DELETE FROM fabrics WHERE id = ?");
            if ($stmt->execute([$id])) {
                // Delete file if it exists and is not a default/shared one if desired. 
                // For now, let's delete it if it's in fabrics/ folder.
                $filepath = '../' . $fabric['image_path'];
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
                echo '<div class="alert alert-success">Fabric deleted successfully.</div>';
            }
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error deleting fabric: ' . $e->getMessage() . '</div>';
    }
}

// Fetch all fabrics
try {
    $stmt = $pdo->query("SELECT * FROM fabrics ORDER BY created_at DESC");
    $fabrics = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error loading fabrics: " . $e->getMessage());
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Fabrics Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="fabrics_add.php" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Fabric
        </a>
    </div>
</div>

<div class="table-responsive bg-white rounded shadow-sm">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th scope="col" class="ps-4">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col" class="text-end pe-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($fabrics)): ?>
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">No fabrics found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($fabrics as $fabric): ?>
                <tr>
                    <td class="ps-4">
                        <img src="../<?php echo htmlspecialchars($fabric['image_path']); ?>" alt="Fabric" 
                             class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($fabric['name']); ?></div>
                        <small class="text-muted"><?php echo substr(htmlspecialchars($fabric['description']), 0, 50); ?>...</small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($fabric['category']); ?></span>
                    </td>
                    <td>₦<?php echo number_format($fabric['price'], 2); ?></td>
                    <td>
                        <?php if ($fabric['in_stock']): ?>
                            <span class="badge bg-success">In Stock</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Out of Stock</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end pe-4">
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this fabric?');" class="d-inline">
                            <input type="hidden" name="delete_id" value="<?php echo $fabric['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>
