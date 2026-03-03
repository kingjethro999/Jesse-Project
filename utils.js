/**
 * UTILITY FUNCTIONS AND ANIMATIONS
 * Modern ES6+ utility functions for enhanced user experience
 */

/**
 * Animation utilities using modern JavaScript
 */
class AnimationUtils {
    /**
     * Smooth scroll to element
     */
    static smoothScrollTo(element, offset = 0) {
        const targetPosition = element.offsetTop - offset;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        const duration = 800;
        let start = null;

        const animation = (currentTime) => {
            if (start === null) start = currentTime;
            const timeElapsed = currentTime - start;
            const run = this.easeInOutQuad(timeElapsed, startPosition, distance, duration);
            window.scrollTo(0, run);
            if (timeElapsed < duration) requestAnimationFrame(animation);
        };

        requestAnimationFrame(animation);
    }

    /**
     * Easing function for smooth animations
     */
    static easeInOutQuad(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return c / 2 * t * t + b;
        t--;
        return -c / 2 * (t * (t - 2) - 1) + b;
    }

    /**
     * Fade in element with intersection observer
     */
    static fadeInOnScroll() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements with fade-in class
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

    /**
     * Stagger animation for multiple elements
     */
    static staggerAnimation(elements, animationClass, delay = 100) {
        elements.forEach((el, index) => {
            setTimeout(() => {
                el.classList.add(animationClass);
            }, index * delay);
        });
    }

    /**
     * Parallax scrolling effect
     */
    static initParallax() {
        const parallaxElements = document.querySelectorAll('.parallax');
        
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            
            parallaxElements.forEach(element => {
                const rate = scrolled * -0.5;
                element.style.transform = `translateY(${rate}px)`;
            });
        });
    }
}

/**
 * DOM manipulation utilities
 */
class DOMUtils {
    /**
     * Query selector with error handling
     */
    static $(selector, parent = document) {
        const element = parent.querySelector(selector);
        if (!element) {
            console.warn(`Element not found: ${selector}`);
        }
        return element;
    }

    /**
     * Query selector all with error handling
     */
    static $$(selector, parent = document) {
        return Array.from(parent.querySelectorAll(selector));
    }

    /**
     * Create element with attributes and content
     */
    static createElement(tag, attributes = {}, content = '') {
        const element = document.createElement(tag);
        
        Object.entries(attributes).forEach(([key, value]) => {
            if (key === 'className') {
                element.className = value;
            } else if (key === 'innerHTML') {
                element.innerHTML = value;
            } else {
                element.setAttribute(key, value);
            }
        });
        
        if (content) {
            element.textContent = content;
        }
        
        return element;
    }

    /**
     * Add multiple event listeners
     */
    static addEventListeners(element, events) {
        Object.entries(events).forEach(([event, handler]) => {
            element.addEventListener(event, handler);
        });
    }

    /**
     * Remove multiple event listeners
     */
    static removeEventListeners(element, events) {
        Object.entries(events).forEach(([event, handler]) => {
            element.removeEventListener(event, handler);
        });
    }

    /**
     * Toggle class with animation
     */
    static toggleClassWithAnimation(element, className, animationDuration = 300) {
        if (element.classList.contains(className)) {
            element.style.transition = `all ${animationDuration}ms ease`;
            element.classList.remove(className);
        } else {
            element.style.transition = `all ${animationDuration}ms ease`;
            element.classList.add(className);
        }
    }
}

/**
 * Local storage utilities with error handling
 */
class StorageUtils {
    /**
     * Safe JSON parse
     */
    static safeJSONParse(str, defaultValue = null) {
        try {
            return JSON.parse(str);
        } catch (error) {
            console.warn('Failed to parse JSON:', error);
            return defaultValue;
        }
    }

    /**
     * Safe JSON stringify
     */
    static safeJSONStringify(obj, defaultValue = '{}') {
        try {
            return JSON.stringify(obj);
        } catch (error) {
            console.warn('Failed to stringify JSON:', error);
            return defaultValue;
        }
    }

    /**
     * Get item from localStorage with fallback
     */
    static getItem(key, defaultValue = null) {
        try {
            const item = localStorage.getItem(key);
            return item ? this.safeJSONParse(item, defaultValue) : defaultValue;
        } catch (error) {
            console.warn('Failed to get item from localStorage:', error);
            return defaultValue;
        }
    }

    /**
     * Set item in localStorage with error handling
     */
    static setItem(key, value) {
        try {
            localStorage.setItem(key, this.safeJSONStringify(value));
            return true;
        } catch (error) {
            console.warn('Failed to set item in localStorage:', error);
            return false;
        }
    }

    /**
     * Remove item from localStorage
     */
    static removeItem(key) {
        try {
            localStorage.removeItem(key);
            return true;
        } catch (error) {
            console.warn('Failed to remove item from localStorage:', error);
            return false;
        }
    }

    /**
     * Clear all localStorage
     */
    static clear() {
        try {
            localStorage.clear();
            return true;
        } catch (error) {
            console.warn('Failed to clear localStorage:', error);
            return false;
        }
    }
}

/**
 * Form validation utilities
 */
class FormUtils {
    /**
     * Email validation
     */
    static isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Phone number validation (Nigerian format)
     */
    static isValidPhone(phone) {
        const phoneRegex = /^(\+234|0)[789][01]\d{8}$/;
        return phoneRegex.test(phone.replace(/\s/g, ''));
    }

    /**
     * Validate form fields
     */
    static validateForm(form) {
        const errors = [];
        const formData = new FormData(form);
        
        // Check required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                errors.push(`${field.name || field.id} is required`);
            }
        });
        
        // Email validation
        const emailFields = form.querySelectorAll('input[type="email"]');
        emailFields.forEach(field => {
            if (field.value && !this.isValidEmail(field.value)) {
                errors.push(`${field.name || field.id} must be a valid email`);
            }
        });
        
        // Phone validation
        const phoneFields = form.querySelectorAll('input[type="tel"]');
        phoneFields.forEach(field => {
            if (field.value && !this.isValidPhone(field.value)) {
                errors.push(`${field.name || field.id} must be a valid phone number`);
            }
        });
        
        return {
            isValid: errors.length === 0,
            errors
        };
    }

    /**
     * Show form errors
     */
    static showFormErrors(form, errors) {
        // Clear previous errors
        form.querySelectorAll('.error-message').forEach(error => error.remove());
        
        errors.forEach(error => {
            const errorElement = DOMUtils.createElement('div', {
                className: 'error-message text-danger small mt-1'
            }, error);
            form.appendChild(errorElement);
        });
    }

    /**
     * Reset form with animation
     */
    static resetForm(form) {
        form.reset();
        form.querySelectorAll('.error-message').forEach(error => error.remove());
        form.querySelectorAll('.is-invalid').forEach(field => field.classList.remove('is-invalid'));
        form.querySelectorAll('.is-valid').forEach(field => field.classList.remove('is-valid'));
    }
}

/**
 * Network utilities
 */
class NetworkUtils {
    /**
     * Check online status
     */
    static isOnline() {
        return navigator.onLine;
    }

    /**
     * Fetch with timeout
     */
    static async fetchWithTimeout(url, options = {}, timeout = 10000) {
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), timeout);
        
        try {
            const response = await fetch(url, {
                ...options,
                signal: controller.signal
            });
            clearTimeout(timeoutId);
            return response;
        } catch (error) {
            clearTimeout(timeoutId);
            throw error;
        }
    }

    /**
     * Retry failed requests
     */
    static async retryRequest(fn, maxRetries = 3, delay = 1000) {
        for (let i = 0; i < maxRetries; i++) {
            try {
                return await fn();
            } catch (error) {
                if (i === maxRetries - 1) throw error;
                await new Promise(resolve => setTimeout(resolve, delay * (i + 1)));
            }
        }
    }
}

/**
 * Performance utilities
 */
class PerformanceUtils {
    /**
     * Debounce function
     */
    static debounce(func, wait, immediate = false) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func.apply(this, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(this, args);
        };
    }

    /**
     * Throttle function
     */
    static throttle(func, limit) {
        let inThrottle;
        return function executedFunction(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    /**
     * Measure performance
     */
    static measurePerformance(name, fn) {
        const start = performance.now();
        const result = fn();
        const end = performance.now();
        console.log(`${name} took ${end - start} milliseconds`);
        return result;
    }
}

/**
 * UI enhancement utilities
 */
class UIUtils {
    /**
     * Show toast notification
     */
    static showToast(message, type = 'info', duration = 3000) {
        const toast = DOMUtils.createElement('div', {
            className: `toast toast-${type}`,
            style: `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${this.getToastColor(type)};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                transform: translateX(100%);
                transition: transform 0.3s ease;
            `
        }, message);

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);

        // Auto remove
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    /**
     * Get toast color based on type
     */
    static getToastColor(type) {
        const colors = {
            success: '#00b894',
            error: '#e17055',
            warning: '#fdcb6e',
            info: '#6c5ce7'
        };
        return colors[type] || colors.info;
    }

    /**
     * Show loading spinner
     */
    static showLoading(element, text = 'Loading...') {
        const spinner = DOMUtils.createElement('div', {
            className: 'loading-spinner',
            innerHTML: `
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">${text}</p>
            `
        });

        element.innerHTML = '';
        element.appendChild(spinner);
    }

    /**
     * Hide loading spinner
     */
    static hideLoading(element, content = '') {
        element.innerHTML = content;
    }

    /**
     * Copy text to clipboard
     */
    static async copyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            this.showToast('Copied to clipboard!', 'success');
            return true;
        } catch (error) {
            console.warn('Failed to copy to clipboard:', error);
            this.showToast('Failed to copy to clipboard', 'error');
            return false;
        }
    }
}

/**
 * Date and time utilities
 */
class DateTimeUtils {
    /**
     * Format date
     */
    static formatDate(date, options = {}) {
        const defaultOptions = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        return new Intl.DateTimeFormat('en-US', { ...defaultOptions, ...options }).format(date);
    }

    /**
     * Get relative time
     */
    static getRelativeTime(date) {
        const now = new Date();
        const diff = now - date;
        const seconds = Math.floor(diff / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);

        if (days > 0) return `${days} day${days > 1 ? 's' : ''} ago`;
        if (hours > 0) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
        if (minutes > 0) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
        return 'Just now';
    }
}

/**
 * Initialize utility functions when DOM is ready
 */
document.addEventListener('DOMContentLoaded', () => {
    // Initialize scroll animations
    AnimationUtils.fadeInOnScroll();
    
    // Initialize parallax if elements exist
    if (document.querySelectorAll('.parallax').length > 0) {
        AnimationUtils.initParallax();
    }
    
    // Add smooth scrolling to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                AnimationUtils.smoothScrollTo(target, 80);
            }
        });
    });
});

// Export utilities for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        AnimationUtils,
        DOMUtils,
        StorageUtils,
        FormUtils,
        NetworkUtils,
        PerformanceUtils,
        UIUtils,
        DateTimeUtils
    };
}
