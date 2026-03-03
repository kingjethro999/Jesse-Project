<?php
require_once '../db.php';
require_once 'includes/header.php';

// Update Status
if (isset($_POST['status']) && isset($_POST['order_id'])) {
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['order_id']]);
}

// Fetch Orders
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Orders</h1>
</div>

<div class="table-responsive bg-white rounded shadow-sm">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th scope="col" class="ps-4">ID</th>
                <th scope="col">Customer</th>
                <th scope="col">Date</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-end pe-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">No orders found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td class="ps-4">#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></td>
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                        <small class="text-muted"><?php echo htmlspecialchars($order['customer_email']); ?></small>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                    <td>₦<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td>
                        <?php 
                        $statusClass = match($order['status']) {
                            'Pending' => 'bg-warning text-dark',
                            'Processing' => 'bg-info text-dark',
                            'Completed' => 'bg-success',
                            'Cancelled' => 'bg-danger',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($order['status']); ?></span>
                    </td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal<?php echo $order['id']; ?>">
                            View Details
                        </button>
                    </td>
                </tr>

                <!-- Order Details Modal -->
                <div class="modal fade" id="orderModal<?php echo $order['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Order #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold">Customer Details</h6>
                                        <p class="mb-0"><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                                        <p class="mb-0"><strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?></p>
                                        <p class="mb-0"><strong>Phone:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                                        <hr class="my-2">
                                        <h6 class="fw-bold">Shipping Address</h6>
                                        <p class="mb-0"><?php echo htmlspecialchars($order['address'] ?? 'N/A'); ?></p>
                                        <p class="mb-0">
                                            <?php echo htmlspecialchars($order['city'] ?? ''); ?>, 
                                            <?php echo htmlspecialchars($order['state'] ?? ''); ?> 
                                            <?php echo htmlspecialchars($order['zip'] ?? ''); ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <h6 class="fw-bold">Order Summary</h6>
                                        <p class="mb-0">Date: <?php echo date('M d, Y h:i A', strtotime($order['created_at'])); ?></p>
                                        <p class="mb-0">Payment Method: <strong><?php echo htmlspecialchars($order['payment_method'] ?? 'N/A'); ?></strong></p>
                                        <p class="mb-0 fw-bold fs-5 text-primary">Total: ₦<?php echo number_format($order['total_amount'], 2); ?></p>
                                    </div>
                                </div>
                                <h6 class="fw-bold mb-3">Order Items</h6>
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Item</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch Items
                                        $stmtItems = $pdo->prepare("
                                            SELECT oi.*, f.name, f.image_path 
                                            FROM order_items oi 
                                            LEFT JOIN fabrics f ON oi.fabric_id = f.id 
                                            WHERE oi.order_id = ?
                                        ");
                                        $stmtItems->execute([$order['id']]);
                                        $items = $stmtItems->fetchAll();
                                        
                                        foreach ($items as $item):
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if($item['image_path']): ?>
                                                    <img src="../<?php echo htmlspecialchars($item['image_path']); ?>" class="rounded me-2" width="40" height="40" style="object-fit: cover;">
                                                    <?php endif; ?>
                                                    <?php echo htmlspecialchars($item['name'] ?? 'Unknown Item'); ?>
                                                </div>
                                            </td>
                                            <td class="text-center"><?php echo $item['quantity']; ?></td>
                                            <td class="text-end">₦<?php echo number_format($item['price'], 2); ?></td>
                                            <td class="text-end">₦<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <form method="POST" class="d-flex align-items-center gap-2">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="form-select form-select-sm" style="width: auto;">
                                        <option value="Pending" <?php echo $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Processing" <?php echo $order['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                        <option value="Completed" <?php echo $order['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                        <option value="Cancelled" <?php echo $order['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Update Status</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>
