<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart — GUF XTORE</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    
    <style>
        .cart-hero {
            background: var(--primary-color);
            color: white;
            padding: 6rem 0 3rem;
            margin-top: 76px;
        }
        
        /* Cart container spacing handled by Bootstrap classes */
        
        .cart-item {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: var(--transition);
        }
        
        .cart-item:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }
        
        .cart-item-image {
            flex-shrink: 0;
            width: 100px;
            height: 100px;
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        
        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .cart-item-details {
            flex: 1;
        }
        
        .cart-item-title {
            font-family: var(--font-primary);
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .cart-item-price {
            color: var(--gray-600);
            margin-bottom: 1rem;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .quantity-btn {
            width: 35px;
            height: 35px;
            border: 1px solid var(--gray-300);
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }
        
        .quantity-btn:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .quantity-display {
            min-width: 40px;
            text-align: center;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .cart-item-total {
            text-align: right;
            flex-shrink: 0;
        }
        
        .subtotal {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .remove-item {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .cart-summary {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2rem;
            position: sticky;
            top: 100px;
        }
        
        .summary-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .summary-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        
        .summary-row:last-child {
            margin-bottom: 0;
        }
        
        .summary-label {
            color: var(--gray-600);
            font-weight: 500;
        }
        
        .summary-value {
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .summary-total {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .shipping-options {
            margin-bottom: 1rem;
        }
        
        .shipping-option {
            margin-bottom: 0.75rem;
        }
        
        .shipping-option input[type="radio"] {
            display: none;
        }
        
        .shipping-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }
        
        .shipping-label:hover {
            border-color: var(--primary-color);
            background: var(--light-color);
        }
        
        .shipping-option input[type="radio"]:checked + .shipping-label {
            border-color: var(--primary-color);
            background: var(--light-color);
        }
        
        .shipping-info h6 {
            margin: 0;
            color: var(--dark-color);
            font-weight: 600;
        }
        
        .shipping-price {
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .coupon-section {
            background: var(--gray-100);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
        }
        
        .coupon-form {
            display: flex;
            gap: 0.5rem;
        }
        
        .coupon-input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--border-radius);
            font-size: 0.9rem;
        }
        
        .coupon-btn {
            padding: 0.75rem 1.5rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
            white-space: nowrap;
        }
        
        .coupon-btn:hover {
            background: var(--secondary-color);
        }
        
        .applied-coupon {
            background: var(--success-color);
            color: white;
            padding: 1rem;
            border-radius: var(--border-radius);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .applied-coupon .coupon-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .remove-coupon-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 50%;
            transition: var(--transition);
        }
        
        .remove-coupon-btn:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .checkout-btn {
            width: 100%;
            padding: 1rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            transition: var(--transition);
            margin-bottom: 1rem;
        }
        
        .checkout-btn:hover:not(:disabled) {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .checkout-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .continue-shopping-btn {
            width: 100%;
            padding: 0.75rem;
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
        }
        
        .continue-shopping-btn:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .empty-cart {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-600);
        }
        
        .empty-cart i {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            color: var(--gray-400);
        }
        
        .empty-cart h3 {
            margin-bottom: 1rem;
            color: var(--dark-color);
        }
        
        .empty-cart p {
            margin-bottom: 2rem;
        }
        
        .clear-cart-btn {
            background: var(--danger-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
            margin-top: 1rem;
        }
        
        .clear-cart-btn:hover {
            background: #d63031;
            transform: translateY(-2px);
        }
        
        .security-badges {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }
        
        .security-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-600);
            font-size: 0.9rem;
        }
        
        .security-badge i {
            color: var(--success-color);
        }
        
        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .cart-item-image {
                width: 150px;
                height: 150px;
                margin: 0 auto;
            }
            
            .cart-item-total {
                text-align: center;
            }
            
            .cart-summary {
                position: static;
                margin-top: 2rem;
            }
            
            .coupon-form {
                flex-direction: column;
            }
            
            .coupon-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body class="cart-page">
    <!-- Preloader -->
    <div id="preloader" class="d-flex align-items-center justify-content-center">
        <div class="preloader-content text-center text-white">
            <div class="fabric-icon fs-1 mb-3">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="loading-text">
                <h3 class="mb-2 display-3">GUF XTORE</h3>
                <p class="fs-5">Loading Cart...</p>
            </div>
            <div class="loading-bar mt-4 w-50 mx-auto">
                <div class="loading-progress"></div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand fw-bold brand-logo" href="index.php">
                <i class="fas fa-tshirt me-2"></i>GUF XTORE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">
                            <i class="fas fa-store me-1"></i>Shop
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">
                            <i class="fas fa-info-circle me-1"></i>About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">
                            <i class="fas fa-envelope me-1"></i>Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active position-relative" href="cart.php" id="cartLink">
                            <i class="fas fa-shopping-cart me-1"></i>Cart
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadge">
                                0
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Hero -->
    <section class="py-5 text-white bg-primary mt-5" style="margin-top: 76px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">Shopping Cart</h1>
                    <p class="lead">Review your items and proceed to checkout</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cart Content -->
    <section class="cart-container">
        <div class="container">
            <!-- Empty Cart Message -->
            <div class="empty-cart" id="emptyCartMessage" style="display: none;">
                <i class="fas fa-shopping-cart"></i>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added any items to your cart yet.</p>
                <a href="shop.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                </a>
            </div>

            <!-- Cart Content -->
            <div id="cartContent">
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Cart Items</h2>
                            <button class="btn btn-outline-danger clear-cart-btn" id="clearCartBtn">
                                <i class="fas fa-trash me-2"></i>Clear Cart
                            </button>
                        </div>
                        
                        <div class="row g-4" id="cartItems">
                            <!-- Cart items will be loaded here -->
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="shop.php" class="btn btn-outline-primary continue-shopping-btn" id="continueShoppingBtn">
                                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h4 class="mb-4">Order Summary</h4>
                            
                            <!-- Applied Coupon -->
                            <div class="applied-coupon" id="appliedCoupon" style="display: none;">
                                <div class="coupon-info">
                                    <i class="fas fa-tag"></i>
                                    <span id="couponCode"></span>
                                    <small>applied</small>
                                </div>
                                <button class="remove-coupon-btn" id="removeCouponBtn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            
                            <!-- Coupon Section -->
                            <div class="coupon-section">
                                <h6 class="mb-3">Have a coupon code?</h6>
                                <form class="coupon-form" id="couponForm">
                                    <input type="text" class="coupon-input" name="couponCode" placeholder="Enter coupon code">
                                    <button type="submit" class="coupon-btn">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Subtotal -->
                            <div class="summary-section">
                                <div class="summary-row">
                                    <span class="summary-label">Subtotal</span>
                                    <span class="summary-value" id="subtotal">₦0</span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-label">Coupon Discount</span>
                                    <span class="summary-value text-success" id="couponDiscount">₦0</span>
                                </div>
                            </div>
                            
                            <!-- Shipping Options -->
                            <div class="summary-section">
                                <h6 class="mb-3">Shipping Options</h6>
                                <div class="shipping-options" id="shippingOptions">
                                    <!-- Shipping options will be loaded here -->
                                </div>
                                <div class="summary-row">
                                    <span class="summary-label">Shipping Cost</span>
                                    <span class="summary-value" id="shippingCost">₦1,500</span>
                                </div>
                            </div>
                            
                            <!-- Tax -->
                            <div class="summary-section">
                                <div class="summary-row">
                                    <span class="summary-label">Tax (5%)</span>
                                    <span class="summary-value" id="taxCost">₦0</span>
                                </div>
                            </div>
                            
                            <!-- Total -->
                            <div class="summary-section">
                                <div class="summary-row">
                                    <span class="summary-label">Total</span>
                                    <span class="summary-total" id="grandTotal">₦0</span>
                                </div>
                            </div>
                            
                            <!-- Checkout Button -->
                            <button class="checkout-btn" id="checkoutBtn" disabled>
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </button>
                            
                            <!-- Security Badges -->
                            <div class="security-badges">
                                <div class="security-badge">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Secure Checkout</span>
                                </div>
                                <div class="security-badge">
                                    <i class="fas fa-lock"></i>
                                    <span>SSL Protected</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5>
                        <i class="fas fa-tshirt me-2"></i>GUF XTORE
                    </h5>
                    <p>Your premier destination for unique and elegant fabrics. Quality you can trust, delivered to your door.</p>
                    <div class="social-links">
                        <a href="https://wa.me/+2348135905887" target="_blank" class="social-link whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://instagram.com/YOUR_HANDLE" target="_blank" class="social-link instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://facebook.com/YOUR_HANDLE" target="_blank" class="social-link facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="shop.php">Shop</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Customer Service</h6>
                    <ul class="list-unstyled">
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="contact.php">Shipping Info</a></li>
                        <li><a href="contact.php">Returns</a></li>
                        <li><a href="contact.php">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Contact Info</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i>+234 813 590 5887</li>
                        <li><i class="fas fa-envelope me-2"></i>info@gufxtore.com</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i>Nigeria</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; 2025 GUF XTORE. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Social Icons -->
    <div class="floating-social">
        <a href="https://wa.me/+2348135905887" target="_blank" class="social-float whatsapp" title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="https://instagram.com/YOUR_HANDLE" target="_blank" class="social-float instagram" title="Instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://facebook.com/YOUR_HANDLE" target="_blank" class="social-float facebook" title="Facebook">
            <i class="fab fa-facebook"></i>
        </a>
    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" title="Back to Top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script src="preloader.js"></script>
    <script src="utils.js"></script>
    <script src="auth.js"></script>
    <script src="main.js"></script>
    <script src="cart.js"></script>
<?php include "auth_modal.php"; ?>
</body>
</html>
