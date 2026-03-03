/**
 * MAIN APPLICATION SCRIPT
 * Enhanced ES6+ features for GUF XTORE e-commerce functionality
 */

/**
 * Main Application Class
 */
class GUFStoreApp {
    constructor() {
        this.cart = new CartManager();
        this.products = new ProductManager();
        this.ui = new UIManager();
        this.analytics = new AnalyticsManager();

        this.init();
    }

    /**
     * Initialize the application
     */
    async init() {
        try {
            // Wait for DOM to be ready
            await this.waitForDOM();

            // Initialize components
            this.initEventListeners();
            this.initScrollEffects();
            this.initNavigation();
            this.initCart();
            this.initNewsletter();
            this.initBackToTop();

            // Load featured products on homepage
            if (document.body.classList.contains('home-page')) {
                await this.loadFeaturedProducts();
            }

            // Initialize analytics
            this.analytics.trackPageView();

            console.log('GUF XTORE Application initialized successfully');
        } catch (error) {
            console.error('Failed to initialize application:', error);
            UIUtils.showToast('Application initialization failed', 'error');
        }
    }

    /**
     * Wait for DOM to be ready
     */
    waitForDOM() {
        return new Promise((resolve) => {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', resolve);
            } else {
                resolve();
            }
        });
    }

    /**
     * Initialize event listeners
     */
    initEventListeners() {
        // Window events
        window.addEventListener('scroll', PerformanceUtils.throttle(() => {
            this.handleScroll();
        }, 100));

        window.addEventListener('resize', PerformanceUtils.debounce(() => {
            this.handleResize();
        }, 250));

        // Network events
        window.addEventListener('online', () => {
            UIUtils.showToast('Connection restored', 'success');
        });

        window.addEventListener('offline', () => {
            UIUtils.showToast('Connection lost', 'warning');
        });

        // Preloader complete event
        document.addEventListener('preloaderComplete', () => {
            this.onPreloaderComplete();
        });
    }

    /**
     * Initialize scroll effects
     */
    initScrollEffects() {
        // Navbar scroll effect
        const navbar = document.getElementById('mainNav');
        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }

        // Parallax effects
        const parallaxElements = document.querySelectorAll('.parallax');
        if (parallaxElements.length > 0) {
            window.addEventListener('scroll', PerformanceUtils.throttle(() => {
                this.updateParallax();
            }, 16));
        }
    }

    /**
     * Update parallax effects
     */
    updateParallax() {
        const scrolled = window.pageYOffset;
        document.querySelectorAll('.parallax').forEach(element => {
            const rate = scrolled * -0.5;
            element.style.transform = `translateY(${rate}px)`;
        });
    }

    /**
     * Initialize navigation
     */
    initNavigation() {
        // Mobile menu toggle
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        if (navbarToggler && navbarCollapse) {
            navbarToggler.addEventListener('click', () => {
                navbarCollapse.classList.toggle('show');
            });
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                if (!navbarToggler.contains(e.target) && !navbarCollapse.contains(e.target)) {
                    navbarCollapse.classList.remove('show');
                }
            }
        });

        // Active navigation highlighting
        this.updateActiveNavigation();
    }

    /**
     * Update active navigation
     */
    updateActiveNavigation() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === currentPath.split('/').pop() ||
                (currentPath === '/' && link.getAttribute('href') === 'index.html')) {
                link.classList.add('active');
            }
        });
    }

    /**
     * Initialize cart functionality
     */
    initCart() {
        // Add to cart buttons
        // Add to cart buttons
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.add-to-cart');
            if (btn) {
                this.handleAddToCart(btn);
            }
        });

        // Update cart badge
        this.updateCartBadge();

        // Listen for cart updates
        document.addEventListener('cartUpdated', () => {
            this.updateCartBadge();
        });
    }

    /**
     * Check if user is authenticated
     */
    async checkAuth() {
        try {
            const res = await fetch('api/auth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'check' })
            });
            const data = await res.json();
            return data.authenticated;
        } catch (e) {
            console.error(e);
            return false;
        }
    }

    /**
     * Handle add to cart
     */
    async handleAddToCart(button) {
        const product = {
            name: button.dataset.name,
            price: parseFloat(button.dataset.price),
            img: button.dataset.img,
            id: button.dataset.id || button.dataset.name.toLowerCase().replace(/\s+/g, '-')
        };

        // Add loading state
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
        button.disabled = true;

        const isAuthenticated = await this.checkAuth();

        if (!isAuthenticated) {
            button.innerHTML = originalText;
            button.disabled = false;
            const authModal = new bootstrap.Modal(document.getElementById('authModal'));
            authModal.show();
            return;
        }

        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';

        // Simulate network delay for better UX
        setTimeout(async () => {
            const success = await this.cart.addItem(product);

            // Reset button
            button.innerHTML = originalText;
            button.disabled = false;

            if (success) {
                // Show success feedback
                UIUtils.showToast(`${product.name} added to cart!`, 'success');

                // Animate cart badge
                this.animateCartBadge();

                // Track analytics
                this.analytics.trackEvent('add_to_cart', product);
            }
        }, 500);
    }

    /**
     * Update cart badge
     */
    updateCartBadge() {
        const cartBadge = document.getElementById('cartBadge');
        const cartCount = this.cart.getItemCount();

        if (cartBadge) {
            cartBadge.textContent = cartCount;
            cartBadge.style.display = cartCount > 0 ? 'inline' : 'none';
        }
    }

    /**
     * Animate cart badge
     */
    animateCartBadge() {
        const cartBadge = document.getElementById('cartBadge');
        if (cartBadge) {
            cartBadge.style.animation = 'none';
            cartBadge.offsetHeight; // Trigger reflow
            cartBadge.style.animation = 'pulse 0.6s ease';
        }
    }

    /**
     * Initialize newsletter
     */
    initNewsletter() {
        const newsletterForm = document.getElementById('newsletterForm');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleNewsletterSubmission(newsletterForm);
            });
        }
    }

    /**
     * Handle newsletter submission
     */
    async handleNewsletterSubmission(form) {
        const emailInput = form.querySelector('input[type="email"]');
        const email = emailInput.value.trim();

        if (!FormUtils.isValidEmail(email)) {
            UIUtils.showToast('Please enter a valid email address', 'error');
            return;
        }

        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        // Show loading state
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        submitButton.disabled = true;

        try {
            // Simulate API call
            await new Promise(resolve => setTimeout(resolve, 1500));

            // Store email locally (in real app, send to server)
            const subscribers = StorageUtils.getItem('newsletter_subscribers', []);
            if (!subscribers.includes(email)) {
                subscribers.push(email);
                StorageUtils.setItem('newsletter_subscribers', subscribers);
            }

            UIUtils.showToast('Thank you for subscribing!', 'success');
            FormUtils.resetForm(form);

            // Track analytics
            this.analytics.trackEvent('newsletter_signup', { email });

        } catch (error) {
            console.error('Newsletter subscription failed:', error);
            UIUtils.showToast('Subscription failed. Please try again.', 'error');
        } finally {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }
    }

    /**
     * Initialize back to top button
     */
    initBackToTop() {
        const backToTopButton = document.getElementById('backToTop');
        if (backToTopButton) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopButton.classList.add('visible');
                } else {
                    backToTopButton.classList.remove('visible');
                }
            });

            backToTopButton.addEventListener('click', () => {
                AnimationUtils.smoothScrollTo(document.body);
            });
        }
    }

    /**
     * Load featured products
     */
    async loadFeaturedProducts() {
        const featuredProductsContainer = document.getElementById('featuredProducts');
        if (!featuredProductsContainer) return;

        try {
            // Show loading state
            UIUtils.showLoading(featuredProductsContainer, 'Loading featured products...');

            // Simulate API call
            await new Promise(resolve => setTimeout(resolve, 1000));

            // Get featured products
            const featuredProducts = this.products.getFeaturedProducts();

            // Render products
            this.renderFeaturedProducts(featuredProducts, featuredProductsContainer);

        } catch (error) {
            console.error('Failed to load featured products:', error);
            UIUtils.hideLoading(featuredProductsContainer, '<p class="text-center text-muted">Failed to load products</p>');
        }
    }

    /**
     * Render featured products
     */
    renderFeaturedProducts(products, container) {
        const productsHTML = products.map(product => `
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                <div class="card product-card h-100">
                    <div class="product-image-wrapper">
                        <img src="${product.img}" class="card-img-top" alt="${product.name}" loading="lazy">
                        ${product.badge ? `<div class="product-badge ${product.badge}">${product.badge}</div>` : ''}
                        <div class="product-actions">
                            <button class="product-action-btn" title="Quick View" data-product-id="${product.id}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="product-action-btn" title="Add to Wishlist" data-product-id="${product.id}">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">${product.name}</h5>
                        ${product.rating ? `
                            <div class="product-rating mb-2">
                                <div class="stars">
                                    ${this.generateStars(product.rating)}
                                </div>
                                <span class="rating-count">(${product.reviews})</span>
                            </div>
                        ` : ''}
                        <p class="card-text text-muted small mb-2">${product.description.substring(0, 80)}...</p>
                        <div class="product-details mb-2">
                            <small class="text-muted">
                                <i class="fas fa-tag me-1"></i>${product.material || 'Premium Quality'}
                            </small>
                        </div>
                        <div class="product-price mb-3">
                            <span class="price-current">₦${product.price.toLocaleString()}</span>
                            <small class="price-unit text-muted">per 5 yards</small>
                        </div>
                        <button class="btn btn-primary add-to-cart mt-auto"
                                data-name="${product.name}"
                                data-price="${product.price}"
                                data-img="${product.img}"
                                data-id="${product.id}">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        `).join('');

        UIUtils.hideLoading(container, productsHTML);

        // Animate products in
        const productCards = container.querySelectorAll('.product-card');
        AnimationUtils.staggerAnimation(productCards, 'fade-in', 100);
    }

    /**
     * Generate star rating HTML
     */
    generateStars(rating) {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 !== 0;
        let starsHTML = '';

        for (let i = 0; i < fullStars; i++) {
            starsHTML += '<i class="fas fa-star"></i>';
        }

        if (hasHalfStar) {
            starsHTML += '<i class="fas fa-star-half-alt"></i>';
        }

        const emptyStars = 5 - Math.ceil(rating);
        for (let i = 0; i < emptyStars; i++) {
            starsHTML += '<i class="far fa-star"></i>';
        }

        return starsHTML;
    }

    /**
     * Handle scroll events
     */
    handleScroll() {
        // Update back to top button visibility
        const backToTopButton = document.getElementById('backToTop');
        if (backToTopButton) {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        }

        // Update navbar
        const navbar = document.getElementById('mainNav');
        if (navbar) {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    }

    /**
     * Handle resize events
     */
    handleResize() {
        // Update any responsive components
        this.updateResponsiveElements();
    }

    /**
     * Update responsive elements
     */
    updateResponsiveElements() {
        // Close mobile menu on resize
        const navbarCollapse = document.querySelector('.navbar-collapse');
        if (navbarCollapse && window.innerWidth > 768) {
            navbarCollapse.classList.remove('show');
        }
    }

    /**
     * Handle preloader completion
     */
    onPreloaderComplete() {
        // Trigger any animations that should start after preloader
        document.querySelectorAll('.animate-on-load').forEach(element => {
            element.classList.add('animated');
        });
    }
}

/**
 * Cart Manager Class (PHP Session Version)
 */
class CartManager {
    constructor() {
        this.items = [];
        this.fetchCart();
    }

    /**
     * Fetch cart from server
     */
    async fetchCart() {
        try {
            const response = await fetch('api/get_cart.php');
            const data = await response.json();
            this.items = data.items || [];
            this.notifyUpdate();
        } catch (error) {
            console.error('Failed to fetch cart:', error);
        }
    }

    /**
     * Add item to cart
     */
    async addItem(product, quantity = 1) {
        try {
            const response = await fetch('cart_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'add',
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    img: product.img,
                    quantity: quantity
                })
            });

            const result = await response.json();
            if (result.success) {
                this.items = result.cart;
                this.notifyUpdate();
                return true;
            }
            return false;
        } catch (error) {
            console.error('Error adding to cart:', error);
            return false;
        }
    }

    /**
     * Remove item from cart
     */
    async removeItem(itemId) {
        try {
            const response = await fetch('cart_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'remove',
                    id: itemId
                })
            });

            const result = await response.json();
            if (result.success) {
                this.items = result.cart;
                this.notifyUpdate();
            }
        } catch (error) {
            console.error('Error removing item:', error);
        }
    }

    /**
     * Update item quantity
     */
    async updateQuantity(itemId, quantity) {
        try {
            if (quantity <= 0) {
                return this.removeItem(itemId);
            }

            const response = await fetch('cart_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'update',
                    id: itemId,
                    quantity: quantity
                })
            });

            const result = await response.json();
            if (result.success) {
                this.items = result.cart;
                this.notifyUpdate();
            }
        } catch (error) {
            console.error('Error updating quantity:', error);
        }
    }

    /**
     * Clear cart
     */
    async clear() {
        try {
            const response = await fetch('cart_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'clear' })
            });

            const result = await response.json();
            if (result.success) {
                this.items = [];
                this.notifyUpdate();
            }
        } catch (error) {
            console.error('Error clearing cart:', error);
        }
    }

    /**
     * Get cart items
     */
    getItems() {
        return [...this.items];
    }

    /**
     * Get total items count
     */
    getItemCount() {
        return this.items.reduce((total, item) => total + item.quantity, 0);
    }

    /**
     * Get total price
     */
    getTotalPrice() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    /**
     * Check if cart is empty
     */
    isEmpty() {
        return this.items.length === 0;
    }

    /**
     * Notify cart update
     */
    notifyUpdate() {
        document.dispatchEvent(new CustomEvent('cartUpdated', {
            detail: { items: this.items }
        }));
    }
}

/**
 * Product Manager Class
 */
class ProductManager {
    constructor() {
        this.products = this.getDefaultProducts();
    }

    /**
     * Get default products
     */
    getDefaultProducts() {
        return [
            {
                id: 'premium-silk',
                name: 'Premium Silk Fabric',
                price: 25000,
                img: 'fabrics/fabric1.webp',
                category: 'luxury',
                featured: true,
                description: 'Luxurious premium silk fabric with beautiful sheen and drape, perfect for elegant evening wear and formal occasions',
                rating: 4.8,
                reviews: 32,
                inStock: true,
                badge: 'premium',
                material: '100% Silk',
                weight: 'Light',
                care: 'Dry Clean Only',
                colors: ['Ivory', 'Black', 'Navy', 'Burgundy']
            },
            {
                id: 'cotton-linen-blend',
                name: 'Cotton Linen Blend',
                price: 8500,
                img: 'fabrics/fabric.jpeg',
                category: 'cotton',
                featured: true,
                description: 'Breathable cotton linen blend perfect for summer wear, casual shirts, and comfortable everyday garments',
                rating: 4.5,
                reviews: 28,
                inStock: true,
                badge: 'popular',
                material: '70% Cotton, 30% Linen',
                weight: 'Medium',
                care: 'Machine Washable',
                colors: ['Natural', 'White', 'Beige', 'Light Blue']
            },
            {
                id: 'designer-print',
                name: 'Designer Print Fabric',
                price: 12000,
                img: 'fabrics/fabric2.jpeg',
                category: 'cotton',
                featured: true,
                description: 'Beautiful designer print cotton fabric with intricate patterns, ideal for dresses, skirts, and home décor',
                rating: 4.6,
                reviews: 45,
                inStock: true,
                badge: 'new',
                material: '100% Cotton',
                weight: 'Medium',
                care: 'Machine Washable',
                colors: ['Multi-color', 'Blue', 'Pink', 'Green']
            },
            {
                id: 'luxury-velvet',
                name: 'Luxury Velvet',
                price: 18000,
                img: 'fabrics/fabric3.jpeg',
                category: 'luxury',
                featured: true,
                description: 'Rich, plush velvet fabric with luxurious texture, perfect for evening gowns, curtains, and upholstery',
                rating: 4.9,
                reviews: 18,
                inStock: true,
                badge: 'luxury',
                material: '100% Polyester Velvet',
                weight: 'Heavy',
                care: 'Dry Clean Only',
                colors: ['Deep Blue', 'Burgundy', 'Emerald', 'Black']
            },
            {
                id: 'lightweight-chiffon',
                name: 'Lightweight Chiffon',
                price: 9500,
                img: 'fabrics/fabric4.jpeg',
                category: 'luxury',
                featured: false,
                description: 'Delicate, flowing chiffon fabric with sheer elegance, perfect for blouses, scarves, and layered garments',
                rating: 4.4,
                reviews: 22,
                inStock: true,
                material: '100% Polyester Chiffon',
                weight: 'Very Light',
                care: 'Hand Wash',
                colors: ['White', 'Ivory', 'Pastel Pink', 'Sky Blue']
            },
            {
                id: 'sturdy-denim',
                name: 'Sturdy Denim',
                price: 11000,
                img: 'fabrics/fabric5.jpeg',
                category: 'cotton',
                featured: false,
                description: 'Durable denim fabric with classic texture, perfect for jeans, jackets, and casual wear',
                rating: 4.3,
                reviews: 38,
                inStock: true,
                badge: 'durable',
                material: '100% Cotton Denim',
                weight: 'Heavy',
                care: 'Machine Washable',
                colors: ['Indigo', 'Black', 'Light Blue', 'White']
            },
            {
                id: 'elegant-satin',
                name: 'Elegant Satin',
                price: 14000,
                img: 'fabrics/images.jpeg',
                category: 'luxury',
                featured: false,
                description: 'Smooth, glossy satin fabric with elegant drape, ideal for formal wear, linings, and special occasions',
                rating: 4.7,
                reviews: 25,
                inStock: true,
                material: '100% Polyester Satin',
                weight: 'Medium',
                care: 'Dry Clean Only',
                colors: ['Pearl White', 'Royal Blue', 'Deep Red', 'Gold']
            }
        ];
    }

    /**
     * Get featured products
     */
    getFeaturedProducts() {
        return this.products.filter(product => product.featured);
    }

    /**
     * Get all products
     */
    getAllProducts() {
        return [...this.products];
    }

    /**
     * Get product by ID
     */
    getProductById(id) {
        return this.products.find(product => product.id === id);
    }

    /**
     * Search products
     */
    searchProducts(query) {
        const searchTerm = query.toLowerCase();
        return this.products.filter(product =>
            product.name.toLowerCase().includes(searchTerm) ||
            product.description.toLowerCase().includes(searchTerm) ||
            product.category.toLowerCase().includes(searchTerm)
        );
    }

    /**
     * Filter products by category
     */
    filterByCategory(category) {
        return this.products.filter(product => product.category === category);
    }
}

/**
 * UI Manager Class
 */
class UIManager {
    constructor() {
        this.init();
    }

    init() {
        this.initTooltips();
        this.initModals();
    }

    /**
     * Initialize tooltips
     */
    initTooltips() {
        // Bootstrap tooltips will be initialized automatically
        // This is a placeholder for custom tooltip logic
    }

    /**
     * Initialize modals
     */
    initModals() {
        // Custom modal logic if needed
    }
}

/**
 * Analytics Manager Class
 */
class AnalyticsManager {
    constructor() {
        this.events = [];
        this.init();
    }

    init() {
        // Initialize analytics tracking
        this.trackSessionStart();
    }

    /**
     * Track page view
     */
    trackPageView() {
        const pageData = {
            url: window.location.href,
            title: document.title,
            timestamp: Date.now()
        };

        this.events.push({
            type: 'page_view',
            data: pageData,
            timestamp: Date.now()
        });

        // Store locally (in real app, send to analytics service)
        this.storeEvent('page_view', pageData);
    }

    /**
     * Track custom event
     */
    trackEvent(eventType, eventData = {}) {
        const event = {
            type: eventType,
            data: eventData,
            timestamp: Date.now()
        };

        this.events.push(event);
        this.storeEvent(eventType, eventData);
    }

    /**
     * Track session start
     */
    trackSessionStart() {
        const sessionData = {
            startTime: Date.now(),
            userAgent: navigator.userAgent,
            screenResolution: `${screen.width}x${screen.height}`,
            language: navigator.language
        };

        this.storeEvent('session_start', sessionData);
    }

    /**
     * Store event locally
     */
    storeEvent(eventType, eventData) {
        const events = StorageUtils.getItem('analytics_events', []);
        events.push({
            type: eventType,
            data: eventData,
            timestamp: Date.now()
        });

        // Keep only last 100 events
        if (events.length > 100) {
            events.splice(0, events.length - 100);
        }

        StorageUtils.setItem('analytics_events', events);
    }
}

// Initialize application when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.gufStoreApp = new GUFStoreApp();
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { GUFStoreApp, CartManager, ProductManager, UIManager, AnalyticsManager };
}

