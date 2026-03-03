<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRACIOUS UNIQUE FABRICX - Where Uniqueness Meets Elegance</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader" class="d-flex align-items-center justify-content-center">
        <div class="preloader-content text-center text-white">
            <div class="fabric-icon fs-1 mb-3">
                <i class="fas fa-tshirt"></i>
            </div>
            <div class="loading-text">
                <h3 class="mb-2 display-3">GUF XTORE</h3>
                <p class="fs-5">Loading Elegance...</p>
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
                        <a class="nav-link active" href="index.php">
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
                        <a class="nav-link position-relative" href="cart.php" id="cartLink">
                            <i class="fas fa-shopping-cart me-1"></i>Cart
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                id="cartBadge">
                                0
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center justify-content-center position-relative">
        <!-- Animated Background Elements -->
        <div class="hero-bg-elements position-absolute w-100 h-100" style="z-index: 0;">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
            <div class="floating-shape shape-4"></div>
        </div>
        
        <div class="hero-content position-relative" style="z-index: 2;">
            <div class="container">
                <div class="row justify-content-center align-items-center text-center">
                    <div class="col-lg-10">
                        <div class="hero-badge animate-fade-in-up mb-4">
                            <span class="badge bg-glass text-white px-4 py-2 rounded-pill">
                                <i class="fas fa-star me-2"></i>Premium Quality Fabrics
                            </span>
                        </div>
                        <h1 class="hero-title animate-fade-in-up delay-1 mb-4 display-1 fw-bold text-premium">
                            Gracious Unique Fabricx
                            <span class="highlight position-relative">!!!</span>
                        </h1>
                        <p class="hero-subtitle animate-fade-in-up delay-2 mb-5 fs-3 text-elegant">
                            Where Uniqueness Meets Elegance...
                            <br><span class="text-accent fw-medium">Shopping at your doorstep!!!</span>
                        </p>
                        <div class="hero-buttons animate-fade-in-up delay-3 d-flex justify-content-center flex-wrap gap-4">
                            <a href="shop.php" class="btn btn-primary btn-lg fs-5 fw-bold animate-shimmer">
                                <i class="fas fa-shopping-bag me-2"></i>Shop Now
                            </a>
                            <a href="about.php" class="btn btn-outline-light btn-lg fs-5 fw-bold">
                                <i class="fas fa-info-circle me-2"></i>Learn More
                            </a>
                        </div>
                        
                        <!-- Trust Indicators -->
                        <div class="hero-trust animate-fade-in-up delay-3 mt-5">
                            <div class="row justify-content-center g-4">
                                <div class="col-auto">
                                    <div class="trust-item d-flex align-items-center">
                                        <i class="fas fa-shipping-fast text-accent me-2"></i>
                                        <span class="text-white-50">Free Delivery</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="trust-item d-flex align-items-center">
                                        <i class="fas fa-shield-alt text-accent me-2"></i>
                                        <span class="text-white-50">Quality Guaranteed</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="trust-item d-flex align-items-center">
                                        <i class="fas fa-heart text-accent me-2"></i>
                                        <span class="text-white-50">Customer Love</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 position-relative" style="background: linear-gradient(135deg, var(--gray-50) 0%, var(--white) 100%);">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <div class="section-badge mb-3">
                        <span class="badge bg-secondary text-white px-3 py-2 rounded-pill">
                            <i class="fas fa-star me-2"></i>Why Choose Us
                        </span>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-3 text-premium">Why Choose GUF XTORE?</h2>
                    <p class="lead text-muted text-elegant">Premium fabrics delivered with exceptional service</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card card h-100 shadow-sm border-0 animate-scale-in">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3 rounded-circle d-flex align-items-center justify-content-center fs-2">
                                <i class="fas fa-truck"></i>
                            </div>
                            <h4 class="card-title h5 fw-bold text-premium">Fast Delivery</h4>
                            <p class="card-text text-muted text-elegant">Quick and reliable delivery to your doorstep within 24-48
                                hours</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card card h-100 shadow-sm border-0 animate-scale-in delay-1">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3 rounded-circle d-flex align-items-center justify-content-center fs-2">
                                <i class="fas fa-gem"></i>
                            </div>
                            <h4 class="card-title h5 fw-bold text-premium">Premium Quality</h4>
                            <p class="card-text text-muted text-elegant">Only the finest fabrics sourced from trusted suppliers
                                worldwide</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card card h-100 shadow-sm border-0 animate-scale-in delay-2">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mb-3 rounded-circle d-flex align-items-center justify-content-center fs-2">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h4 class="card-title h5 fw-bold text-premium">Customer Satisfaction</h4>
                            <p class="card-text text-muted text-elegant">Dedicated customer service ensuring your complete
                                satisfaction</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Preview -->
    <section class="py-5 position-relative" style="background: var(--white);">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <div class="section-badge mb-3">
                        <span class="badge bg-accent text-white px-3 py-2 rounded-pill">
                            <i class="fas fa-fire me-2"></i>Featured Collection
                        </span>
                    </div>
                    <h2 class="display-5 fw-bold text-dark mb-3 text-premium">Featured Fabrics</h2>
                    <p class="lead text-muted fs-5 text-elegant">Discover our most popular fabric collections</p>
                </div>
            </div>
            <div class="row g-4" id="featuredProducts">
                <!-- Products will be loaded dynamically -->
            </div>
            <div class="text-center mt-5">
                <a href="shop.php" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold">
                    <i class="fas fa-eye me-2"></i>View All Products
                </a>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5 position-relative" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="newsletter-content bg-glass rounded-3 p-5 shadow-premium">
                        <div class="newsletter-icon mb-4">
                            <i class="fas fa-envelope-open-text text-accent" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="h2 mb-3 text-white text-premium">Stay Updated</h3>
                        <p class="lead mb-4 text-white-50 text-elegant">Subscribe to our newsletter for exclusive offers and new arrivals</p>
                        <form class="newsletter-form" id="newsletterForm">
                            <div class="input-group input-group-lg">
                                <input type="email" class="form-control form-control-lg" placeholder="Enter your email address" required style="border-radius: var(--radius-lg) 0 0 var(--radius-lg); border: 2px solid var(--glass-border); background: var(--glass-bg); color: var(--white);">
                                <button class="btn btn-secondary btn-lg" type="submit" style="border-radius: 0 var(--radius-lg) var(--radius-lg) 0; border: 2px solid var(--secondary-color);">
                                    <i class="fas fa-paper-plane me-2"></i>Subscribe
                                </button>
                            </div>
                        </form>
                        <p class="small text-white-50 mt-3 mb-0">
                            <i class="fas fa-shield-alt me-1"></i>We respect your privacy. Unsubscribe at any time.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-tshirt me-2"></i>GUF XTORE
                    </h5>
                    <p class="text-light mb-3">Your premier destination for unique and elegant fabrics. Quality you can
                        trust, delivered to your door.</p>
                    <div class="d-flex gap-3">
                        <a href="https://wa.me/+2348135905887" target="_blank"
                            class="btn btn-success btn-sm rounded-circle">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://instagram.com/YOUR_HANDLE" target="_blank"
                            class="btn btn-danger btn-sm rounded-circle">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://facebook.com/YOUR_HANDLE" target="_blank"
                            class="btn btn-primary btn-sm rounded-circle">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php" class="text-light text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="shop.php" class="text-light text-decoration-none">Shop</a></li>
                        <li class="mb-2"><a href="about.php" class="text-light text-decoration-none">About</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-bold mb-3">Customer Service</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="contact.php" class="text-light text-decoration-none">Contact Us</a>
                        </li>
                        <li class="mb-2"><a href="contact.php" class="text-light text-decoration-none">Shipping
                                Info</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-light text-decoration-none">Returns</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-light text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-bold mb-3">Contact Info</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-light"><i class="fas fa-phone me-2"></i>+234 813 590 5887</li>
                        <li class="mb-2 text-light"><i class="fas fa-envelope me-2"></i>info@gufxtore.com</li>
                        <li class="mb-2 text-light"><i class="fas fa-map-marker-alt me-2"></i>Nigeria</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0 text-muted">&copy; 2025 GUF XTORE. All rights reserved.</p>
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
<?php include "auth_modal.php"; ?>
</body>

</html>