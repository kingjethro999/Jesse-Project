<?php
require_once 'includes/header.php';
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f5f6fa;">
    <div class="card shadow-lg border-0 rounded-lg" style="width: 400px;">
        <div class="card-header bg-primary text-white text-center py-4">
            <h3 class="mb-0 fw-bold">GUF XTORE</h3>
            <p class="mb-0 text-white-50">Admin Login</p>
        </div>
        <div class="card-body p-4">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>
            <form action="login_action.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center py-3 bg-light">
            <small class="text-muted">Protected Area</small>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>
