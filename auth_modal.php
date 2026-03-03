<!-- Authentication Modal -->
<div class="modal fade" id="authModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Authentication Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info border-0 rounded-3 mb-4">
                    <i class="fas fa-info-circle me-2"></i>Please log in to add items to your cart.
                </div>
                <ul class="nav nav-tabs mb-4 border-0" id="authTabs">
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link active w-100 fw-bold border-0 bg-transparent" data-bs-toggle="tab" data-bs-target="#loginTab">Login</button>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link w-100 fw-bold border-0 bg-transparent" data-bs-toggle="tab" data-bs-target="#registerTab">Register</button>
                    </li>
                </ul>
                <div class="tab-content px-2">
                    <div class="tab-pane fade show active" id="loginTab">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control" id="loginEmail" placeholder="name@example.com" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" class="form-control" id="loginPassword" placeholder="Minimum 6 characters" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" id="loginBtn">
                                <i class="fas fa-sign-in-alt me-2"></i>Login securely
                            </button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="registerTab">
                        <form id="registerForm">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" class="form-control" id="regName" placeholder="John Doe" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control" id="regEmail" placeholder="name@example.com" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" class="form-control" id="regPassword" placeholder="Minimum 6 characters" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" id="registerBtn">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Auth Logic specific styles -->
<style>
    #authTabs .nav-link { color: #6c757d; border-bottom: 2px solid transparent !important; }
    #authTabs .nav-link.active { color: var(--primary-color); border-bottom: 2px solid var(--primary-color) !important; background: transparent !important; }
</style>
<script src="auth.js"></script>
