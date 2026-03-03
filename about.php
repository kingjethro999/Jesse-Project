<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About — GUF XTORE</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    
    <style>
        .about-hero {
            background: var(--primary-color);
            color: white;
            padding: 6rem 0 3rem;
            margin-top: 76px;
        }
        
        /* About container spacing handled by Bootstrap classes */
        
        /* Story section spacing handled by Bootstrap classes */
        
        .story-image {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }
        
        .story-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .story-image:hover img {
            transform: scale(1.05);
        }
        
        .story-content {
            padding: 2rem 0;
        }
        
        .story-content h3 {
            font-family: var(--font-primary);
            font-size: 2rem;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
        }
        
        .story-content p {
            color: var(--gray-600);
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }
        
        .values-section {
            background: var(--gray-100);
            padding: 4rem 0;
        }
        
        .value-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2.5rem;
            text-align: center;
            height: 100%;
            transition: var(--transition);
            margin-bottom: 2rem;
        }
        
        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }
        
        .value-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }
        
        .value-title {
            font-family: var(--font-primary);
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .value-description {
            color: var(--gray-600);
            line-height: 1.6;
        }
        
        .team-section {
            padding: 4rem 0;
        }
        
        .team-member {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
            margin-bottom: 2rem;
        }
        
        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .team-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            overflow: hidden;
            border: 4px solid var(--light-color);
        }
        
        .team-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .team-name {
            font-family: var(--font-primary);
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .team-role {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .team-bio {
            color: var(--gray-600);
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .stats-section {
            background: var(--primary-color);
            color: white;
            padding: 4rem 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 1rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .timeline-section {
            padding: 4rem 0;
        }
        
        .timeline {
            position: relative;
            padding: 2rem 0;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary-color);
            transform: translateX(-50%);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 3rem;
            width: 50%;
        }
        
        .timeline-item:nth-child(odd) {
            left: 0;
            padding-right: 3rem;
            text-align: right;
        }
        
        .timeline-item:nth-child(even) {
            left: 50%;
            padding-left: 3rem;
        }
        
        .timeline-content {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2rem;
            position: relative;
        }
        
        .timeline-content::before {
            content: '';
            position: absolute;
            top: 50%;
            width: 0;
            height: 0;
            border: 15px solid transparent;
            transform: translateY(-50%);
        }
        
        .timeline-item:nth-child(odd) .timeline-content::before {
            right: -30px;
            border-left-color: white;
        }
        
        .timeline-item:nth-child(even) .timeline-content::before {
            left: -30px;
            border-right-color: white;
        }
        
        .timeline-date {
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        .timeline-title {
            font-family: var(--font-primary);
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .timeline-description {
            color: var(--gray-600);
            line-height: 1.6;
        }
        
        .timeline-dot {
            position: absolute;
            top: 50%;
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border: 4px solid white;
            border-radius: 50%;
            transform: translateY(-50%);
        }
        
        .timeline-item:nth-child(odd) .timeline-dot {
            right: -11px;
        }
        
        .timeline-item:nth-child(even) .timeline-dot {
            left: -11px;
        }
        
        .cta-section {
            background: var(--gray-100);
            padding: 4rem 0;
            text-align: center;
        }
        
        .cta-content {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .cta-title {
            font-family: var(--font-primary);
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 1rem;
        }
        
        .cta-description {
            font-size: 1.1rem;
            color: var(--gray-600);
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .cta-btn {
            padding: 1rem 2rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .cta-btn-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .cta-btn-primary:hover {
            background: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .cta-btn-outline {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        
        .cta-btn-outline:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        @media (max-width: 768px) {
            .timeline::before {
                left: 20px;
            }
            
            .timeline-item {
                width: 100%;
                left: 0 !important;
                padding-left: 3rem !important;
                padding-right: 0 !important;
                text-align: left !important;
            }
            
            .timeline-item .timeline-content::before {
                left: -30px !important;
                border-left-color: transparent !important;
                border-right-color: white !important;
            }
            
            .timeline-item .timeline-dot {
                left: 9px !important;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .cta-btn {
                width: 200px;
                justify-content: center;
            }
        }
    </style>
</head>
<body class="about-page">
    <!-- Preloader -->
    <div id="preloader" class="d-flex align-items-center justify-content-center">
        <div class="preloader-content text-center text-white">
            <div class="fabric-icon fs-1 mb-3">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="loading-text">
                <h3 class="mb-2 display-3">GUF XTORE</h3>
                <p class="fs-5">Loading About...</p>
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
                        <a class="nav-link active" href="about.php">
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
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadge">
                                0
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Hero -->
    <section class="py-5 text-white bg-primary mt-5" style="margin-top: 76px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">About GUF XTORE</h1>
                    <p class="lead">Where Uniqueness Meets Elegance - Your Premier Fabric Destination</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="story-image">
                        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Our Story" class="img-fluid rounded shadow">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="story-content">
                        <h3 class="display-6 fw-bold text-dark mb-4">Our Story</h3>
                        <p class="lead mb-4">
                            Founded with a passion for quality and elegance, GUF XTORE (Gracious Unique Fabricx) has been 
                            serving customers across Nigeria since our inception. We believe that every piece of fabric 
                            tells a story, and we're here to help you create yours.
                        </p>
                        <p class="text-muted mb-4">
                            Our journey began with a simple vision: to provide premium quality fabrics that combine 
                            traditional craftsmanship with modern elegance. Today, we're proud to be one of Nigeria's 
                            most trusted fabric retailers, known for our exceptional quality, outstanding customer service, 
                            and commitment to excellence.
                        </p>
                        <p class="text-muted">
                            From our carefully curated selection of fabrics to our nationwide delivery service, 
                            we ensure that every customer receives the finest materials for their creative projects.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold text-dark mb-3">Our Values</h2>
                    <p class="lead text-muted">The principles that guide everything we do</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <div class="value-icon mb-3">
                                <i class="fas fa-gem"></i>
                            </div>
                            <h4 class="card-title h5">Quality Excellence</h4>
                            <p class="card-text text-muted">
                                We source only the finest fabrics from trusted suppliers worldwide, ensuring every 
                                piece meets our high standards of quality and durability.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <div class="value-icon mb-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4 class="card-title h5">Customer First</h4>
                            <p class="card-text text-muted">
                                Our customers are at the heart of everything we do. We're committed to providing 
                                exceptional service and support throughout your shopping experience.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <div class="value-icon mb-3">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h4 class="card-title h5">Sustainability</h4>
                            <p class="card-text text-muted">
                                We're committed to sustainable practices, working with suppliers who share our 
                                values of environmental responsibility and ethical sourcing.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h4 class="value-title">Innovation</h4>
                        <p class="value-description">
                            We continuously innovate our product offerings and services to stay ahead of 
                            trends and provide you with the latest in fabric technology.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4 class="value-title">Trust & Reliability</h4>
                        <p class="value-description">
                            We build lasting relationships with our customers through transparency, 
                            honesty, and reliable service that you can count on.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="value-title">Passion for Fashion</h4>
                        <p class="value-description">
                            Our team shares a deep passion for fashion and textiles, bringing expertise 
                            and enthusiasm to help you find the perfect fabric for your project.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <div class="stat-item">
                        <span class="display-4 fw-bold d-block" data-count="5000">0</span>
                        <span class="fs-5">Happy Customers</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <span class="display-4 fw-bold d-block" data-count="1000">0</span>
                        <span class="fs-5">Fabric Varieties</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <span class="display-4 fw-bold d-block" data-count="36">0</span>
                        <span class="fs-5">States Covered</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <span class="display-4 fw-bold d-block" data-count="5">0</span>
                        <span class="fs-5">Years of Excellence</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team section removed -->

    <!-- Timeline -->
    <section class="timeline-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="section-title">Our Journey</h2>
                    <p class="section-subtitle">Key milestones in our growth story</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-date">2019</div>
                                <h4 class="timeline-title">Company Founded</h4>
                                <p class="timeline-description">
                                    GUF XTORE was founded with a mission to provide premium quality fabrics 
                                    to customers across Nigeria, starting with a small collection of luxury fabrics.
                                </p>
                            </div>
                            <div class="timeline-dot"></div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-date">2020</div>
                                <h4 class="timeline-title">Online Platform Launch</h4>
                                <p class="timeline-description">
                                    We launched our online platform, making it easier for customers to browse 
                                    and purchase fabrics from the comfort of their homes.
                                </p>
                            </div>
                            <div class="timeline-dot"></div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-date">2021</div>
                                <h4 class="timeline-title">Nationwide Delivery</h4>
                                <p class="timeline-description">
                                    Expanded our delivery services to cover all 36 states in Nigeria, 
                                    ensuring fast and reliable shipping nationwide.
                                </p>
                            </div>
                            <div class="timeline-dot"></div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-date">2022</div>
                                <h4 class="timeline-title">1000+ Products</h4>
                                <p class="timeline-description">
                                    Reached a milestone of over 1000 fabric varieties in our catalog, 
                                    offering customers an extensive range of choices.
                                </p>
                            </div>
                            <div class="timeline-dot"></div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-date">2023</div>
                                <h4 class="timeline-title">Sustainability Initiative</h4>
                                <p class="timeline-description">
                                    Launched our sustainability program, partnering with eco-friendly suppliers 
                                    and implementing green packaging solutions.
                                </p>
                            </div>
                            <div class="timeline-dot"></div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-date">2025</div>
                                <h4 class="timeline-title">Enhanced Digital Experience</h4>
                                <p class="timeline-description">
                                    Launched our new website with enhanced features, improved user experience, 
                                    and advanced search and filtering capabilities.
                                </p>
                            </div>
                            <div class="timeline-dot"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center">
                <h2 class="display-5 fw-bold text-dark mb-3">Ready to Start Your Fabric Journey?</h2>
                <p class="lead text-muted mb-4">
                    Join thousands of satisfied customers who trust GUF XTORE for their fabric needs. 
                    Browse our collection today and discover the perfect fabric for your next project.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="shop.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Shop Now
                    </a>
                    <a href="contact.php" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i>Get in Touch
                    </a>
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
                    <p class="text-light mb-3">Your premier destination for unique and elegant fabrics. Quality you can trust, delivered to your door.</p>
                    <div class="d-flex gap-3">
                        <a href="https://wa.me/+2348135905887" target="_blank" class="btn btn-success btn-sm rounded-circle">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://instagram.com/YOUR_HANDLE" target="_blank" class="btn btn-danger btn-sm rounded-circle">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://facebook.com/YOUR_HANDLE" target="_blank" class="btn btn-primary btn-sm rounded-circle">
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
                        <li class="mb-2"><a href="contact.php" class="text-light text-decoration-none">Contact Us</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-light text-decoration-none">Shipping Info</a></li>
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
    <script src="main.js"></script>
    <script src="about.js"></script>
</body>
</html>
