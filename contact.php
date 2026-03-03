<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact — GUF XTORE</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- All custom CSS replaced with Bootstrap classes -->
    <style>
        /* All custom CSS replaced with Bootstrap classes */

        .contact-info-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2rem;
            height: 100%;
            transition: var(--transition);
        }

        .contact-info-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .contact-info-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: white;
            font-size: 1.5rem;
        }

        .contact-info-title {
            font-family: var(--font-primary);
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .contact-info-text {
            color: var(--gray-600);
            line-height: 1.6;
        }

        .contact-form {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.25);
        }

        .form-control.is-invalid {
            border-color: var(--danger-color);
        }

        .form-control.is-valid {
            border-color: var(--success-color);
        }

        .invalid-feedback {
            display: block;
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .valid-feedback {
            display: block;
            color: var(--success-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            transition: var(--transition);
            width: 100%;
        }

        .submit-btn:hover:not(:disabled) {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .map-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 1.5rem;
            margin-top: 3rem;
        }

        .map-placeholder {
            height: 300px;
            background: var(--gray-200);
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-600);
            font-size: 1.1rem;
        }

        .faq-section {
            background: var(--gray-100);
            padding: 4rem 0;
            margin-top: 4rem;
        }

        .faq-item {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .faq-question {
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .faq-question:hover {
            background: var(--gray-100);
        }

        .faq-question h6 {
            margin: 0;
            color: var(--dark-color);
            font-weight: 600;
        }

        .faq-icon {
            transition: var(--transition);
            color: var(--primary-color);
        }

        .faq-question.active .faq-icon {
            transform: rotate(180deg);
        }

        .faq-answer {
            padding: 0 1.5rem;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-answer.active {
            padding: 0 1.5rem 1.5rem;
            max-height: 200px;
        }

        .faq-answer p {
            margin: 0;
            color: var(--gray-600);
            line-height: 1.6;
        }

        .business-hours {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2rem;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .hours-item:last-child {
            border-bottom: none;
        }

        .hours-day {
            font-weight: 600;
            color: var(--dark-color);
        }

        .hours-time {
            color: var(--gray-600);
        }

        .social-contact {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-contact-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            transition: var(--transition);
            font-size: 1.2rem;
        }

        .social-contact-btn.whatsapp {
            background: #25d366;
        }

        .social-contact-btn.instagram {
            background: #e1306c;
        }

        .social-contact-btn.facebook {
            background: #1877f2;
        }

        .social-contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        @media (max-width: 768px) {
            .contact-container {
                padding: 2rem 0;
            }

            .contact-form {
                padding: 1.5rem;
            }

            .contact-info-card {
                margin-bottom: 2rem;
            }

            .business-hours {
                margin-top: 2rem;
            }
        }
    </style>
</head>

<body class="contact-page">
    <!-- Preloader -->
    <div id="preloader" class="d-flex align-items-center justify-content-center">
        <div class="preloader-content text-center text-white">
            <div class="fabric-icon fs-1 mb-3">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="loading-text">
                <h3 class="mb-2 display-3">GUF XTORE</h3>
                <p class="fs-5">Loading Contact...</p>
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
                        <a class="nav-link active" href="contact.php">
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

    <!-- Contact Hero -->
    <section class="py-5 text-white bg-primary mt-5" style="margin-top: 76px;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">Get In Touch</h1>
                    <p class="lead fs-4">We'd love to hear from you. Send us a message and we'll respond as soon as
                        possible.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="contact-container">
        <div class="container">
            <!-- Contact Info Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body p-4">
                            <div
                                class="contact-info-icon mb-3 bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fs-4">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5 class="card-title fw-bold">Our Location</h5>
                            <p class="card-text text-muted">
                                Lagos, Nigeria<br>
                                We deliver nationwide
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body p-4">
                            <div
                                class="contact-info-icon mb-3 bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fs-4">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h5 class="card-title fw-bold">Phone Number</h5>
                            <p class="card-text text-muted">
                                <a href="tel:+2348135905887" class="text-decoration-none">+234 813 590 5887</a><br>
                                Available 9 AM - 6 PM
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body p-4">
                            <div
                                class="contact-info-icon mb-3 bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fs-4">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5 class="card-title fw-bold">Email Address</h5>
                            <p class="card-text text-muted">
                                <a href="mailto:info@gufxtore.com"
                                    class="text-decoration-none">info@gufxtore.com</a><br>
                                We respond within 24 hours
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4">Send us a Message</h3>
                            <form id="contactForm" novalidate>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="firstName" class="form-label fw-semibold">First Name *</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName"
                                            required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label fw-semibold">Last Name *</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">Email Address *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-semibold">Phone Number *</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="form-label fw-semibold">Subject *</label>
                                    <select class="form-select" id="subject" name="subject" required>
                                        <option value="">Select a subject</option>
                                        <option value="general">General Inquiry</option>
                                        <option value="order">Order Support</option>
                                        <option value="shipping">Shipping & Delivery</option>
                                        <option value="returns">Returns & Exchanges</option>
                                        <option value="product">Product Information</option>
                                        <option value="wholesale">Wholesale Inquiry</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label fw-semibold">Message *</label>
                                    <textarea class="form-control" id="message" name="message" rows="5"
                                        placeholder="Tell us how we can help you..." required></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletter"
                                            name="newsletter">
                                        <label class="form-check-label" for="newsletter">
                                            Subscribe to our newsletter for updates and special offers
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Business Hours -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">Business Hours</h5>
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <span class="fw-semibold">Monday - Friday</span>
                                <span class="text-muted">9:00 AM - 6:00 PM</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <span class="fw-semibold">Saturday</span>
                                <span class="text-muted">10:00 AM - 4:00 PM</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="fw-semibold">Sunday</span>
                                <span class="text-muted">Closed</span>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">Connect With Us</h5>
                            <p class="text-muted mb-3">Follow us on social media for the latest updates and fabric
                                collections.</p>
                            <div class="d-flex gap-3">
                                <a href="https://wa.me/+2348135905887" class="btn btn-success btn-sm rounded-circle"
                                    target="_blank" title="WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="https://instagram.com/YOUR_HANDLE" class="btn btn-danger btn-sm rounded-circle"
                                    target="_blank" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://facebook.com/YOUR_HANDLE" class="btn btn-primary btn-sm rounded-circle"
                                    target="_blank" title="Facebook">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">Find Us</h5>
                            <div class="bg-light rounded p-4 text-center">
                                <i class="fas fa-map-marker-alt fa-2x mb-2 text-primary"></i>
                                <p class="mb-2">Interactive map would be integrated here</p>
                                <small class="text-muted">Lagos, Nigeria</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Frequently Asked Questions</h2>
                    <p class="section-subtitle">Find answers to common questions about our fabrics and services</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq1">
                                    What types of fabrics do you offer?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We offer a wide variety of premium fabrics including cotton, silk, velvet, crepe,
                                    linen, and many more. Each fabric is carefully selected for quality and durability.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2">
                                    How long does shipping take?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Standard delivery takes 3-5 business days, express delivery takes 1-2 business days,
                                    and overnight delivery is available for next-day arrival.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq3">
                                    Do you offer wholesale prices?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we offer competitive wholesale prices for bulk orders. Please contact us with
                                    your requirements for a custom quote.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq4">
                                    What is your return policy?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We offer a 30-day return policy for unused fabrics in their original condition.
                                    Custom orders and cut fabrics are non-returnable.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq5">
                                    Can I get fabric samples?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we provide fabric samples for a small fee that can be applied to your order if
                                    you decide to purchase. Contact us to request samples.
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
                    <p>Your premier destination for unique and elegant fabrics. Quality you can trust, delivered to your
                        door.</p>
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
    <script src="main.js"></script>
    <script src="contact.js"></script>
</body>

</html>