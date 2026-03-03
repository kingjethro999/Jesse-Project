<?php
require_once '../db.php';
require_once 'includes/header.php';

// Fetch quick stats
try {
    $products_count = $pdo->query("SELECT COUNT(*) FROM fabrics")->fetchColumn();
    $messages_count = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
    $unread_messages = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read = 0")->fetchColumn();
    $orders_count = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    $pending_orders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'Pending'")->fetchColumn();
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error fetching stats: ' . $e->getMessage() . '</div>';
    $products_count = $messages_count = $unread_messages = $orders_count = $pending_orders = 0;
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row g-4 mb-5">
    <!-- Products Card -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100 border-start border-4 border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-primary"><i class="fas fa-tshirt me-2"></i>Fabrics</h5>
                    <span class="badge bg-primary rounded-pill"><?php echo $products_count; ?> Total</span>
                </div>
                <p class="card-text text-muted">Manage your fabric inventory.</p>
                <a href="fabrics.php" class="btn btn-outline-primary btn-sm stretched-link">View All Fabrics</a>
            </div>
        </div>
    </div>

    <!-- Messages Card -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100 border-start border-4 border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-info"><i class="fas fa-envelope me-2"></i>Messages</h5>
                    <span class="badge bg-<?php echo $unread_messages > 0 ? 'danger' : 'secondary'; ?> rounded-pill">
                        <?php echo $unread_messages; ?> Unread
                    </span>
                </div>
                <p class="card-text text-muted"><?php echo $messages_count; ?> Total Messages</p>
                <a href="messages.php" class="btn btn-outline-info btn-sm stretched-link">View Messages</a>
            </div>
        </div>
    </div>

    <!-- Orders Card -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100 border-start border-4 border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-success"><i class="fas fa-shopping-cart me-2"></i>Orders</h5>
                    <span class="badge bg-<?php echo $pending_orders > 0 ? 'warning' : 'secondary'; ?> rounded-pill">
                        <?php echo $pending_orders; ?> Pending
                    </span>
                </div>
                <p class="card-text text-muted"><?php echo $orders_count; ?> Total Orders</p>
                <a href="orders.php" class="btn btn-outline-success btn-sm stretched-link">View Orders</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h4>Recent Activity</h4>
        <div class="alert alert-light border">
            <p class="text-muted mb-0">System initialized successfully.</p>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
