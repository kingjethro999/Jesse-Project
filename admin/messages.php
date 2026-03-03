<?php
require_once '../db.php';
require_once 'includes/header.php';

// Handle Mark as Read / Delete
if (isset($_POST['action'])) {
    $id = $_POST['id'];
    if ($_POST['action'] === 'mark_read') {
        $stmt = $pdo->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Fetch messages
$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Messages</h1>
</div>

<div class="table-responsive bg-white rounded shadow-sm">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th scope="col" class="ps-4">Date</th>
                <th scope="col">Name</th>
                <th scope="col">Subject</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-end pe-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($messages)): ?>
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">No messages found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                <tr class="<?php echo $msg['is_read'] ? '' : 'table-info'; ?>">
                    <td class="ps-4 text-nowrap"><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></td>
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($msg['name']); ?></div>
                        <small class="text-muted"><?php echo htmlspecialchars($msg['email']); ?></small>
                    </td>
                    <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                    <td>
                        <?php if ($msg['is_read']): ?>
                            <span class="badge bg-secondary">Read</span>
                        <?php else: ?>
                            <span class="badge bg-primary">New</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#msgModal<?php echo $msg['id']; ?>">
                            <i class="fas fa-eye"></i>
                        </button>
                        <form method="POST" onsubmit="return confirm('Delete this message?');" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                
                <!-- Message Modal -->
                <div class="modal fade" id="msgModal<?php echo $msg['id']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo htmlspecialchars($msg['subject']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>From:</strong> <?php echo htmlspecialchars($msg['name']); ?> &lt;<?php echo htmlspecialchars($msg['email']); ?>&gt;</p>
                                <p><strong>Date:</strong> <?php echo date('F d, Y h:i A', strtotime($msg['created_at'])); ?></p>
                                <hr>
                                <p class="mb-0"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                            </div>
                            <div class="modal-footer">
                                <?php if (!$msg['is_read']): ?>
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                                    <input type="hidden" name="action" value="mark_read">
                                    <button type="submit" class="btn btn-primary">Mark as Read</button>
                                </form>
                                <?php endif; ?>
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
