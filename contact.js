/**
 * CONTACT PAGE FUNCTIONALITY
 * Enhanced contact form with validation and interactive features
 */

/**
 * Contact Page Manager Class
 */
class ContactPageManager {
    constructor() {
        this.form = null;
        this.faqItems = [];
        this.init();
    }

    /**
     * Initialize contact page
     */
    init() {
        try {
            this.initForm();
            this.initFAQ();
            this.initValidation();
            this.initEventListeners();

            console.log('Contact page manager initialized successfully');
        } catch (error) {
            console.error('Failed to initialize contact page manager:', error);
            UIUtils.showToast('Failed to initialize contact page', 'error');
        }
    }

    /**
     * Initialize contact form
     */
    initForm() {
        this.form = document.getElementById('contactForm');
        if (!this.form) {
            console.warn('Contact form not found');
            return;
        }

        // Add real-time validation
        this.setupRealTimeValidation();
    }

    /**
     * Setup real-time validation
     */
    setupRealTimeValidation() {
        const inputs = this.form.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
            // Validate on blur
            input.addEventListener('blur', () => {
                this.validateField(input);
            });

            // Clear validation on input
            input.addEventListener('input', () => {
                this.clearFieldValidation(input);
            });

            // Special handling for email and phone
            if (input.type === 'email') {
                input.addEventListener('input', PerformanceUtils.debounce(() => {
                    this.validateEmail(input);
                }, 300));
            }

            if (input.type === 'tel') {
                input.addEventListener('input', PerformanceUtils.debounce(() => {
                    this.validatePhone(input);
                }, 300));
            }
        });
    }

    /**
     * Initialize FAQ functionality
     */
    initFAQ() {
        this.faqItems = document.querySelectorAll('.faq-item');

        this.faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');

            if (question && answer) {
                question.addEventListener('click', () => {
                    this.toggleFAQ(item, question, answer);
                });
            }
        });
    }

    /**
     * Initialize form validation
     */
    initValidation() {
        if (!this.form) return;

        // Add custom validation rules
        this.addCustomValidationRules();
    }

    /**
     * Add custom validation rules
     */
    addCustomValidationRules() {
        // Custom email validation
        const emailInput = this.form.querySelector('#email');
        if (emailInput) {
            emailInput.addEventListener('invalid', (e) => {
                if (emailInput.validity.typeMismatch) {
                    emailInput.setCustomValidity('Please enter a valid email address');
                } else if (emailInput.validity.valueMissing) {
                    emailInput.setCustomValidity('Email address is required');
                }
            });

            emailInput.addEventListener('input', () => {
                emailInput.setCustomValidity('');
            });
        }

        // Custom phone validation
        const phoneInput = this.form.querySelector('#phone');
        if (phoneInput) {
            phoneInput.addEventListener('invalid', (e) => {
                if (phoneInput.validity.patternMismatch) {
                    phoneInput.setCustomValidity('Please enter a valid phone number');
                } else if (phoneInput.validity.valueMissing) {
                    phoneInput.setCustomValidity('Phone number is required');
                }
            });

            phoneInput.addEventListener('input', () => {
                phoneInput.setCustomValidity('');
            });
        }
    }

    /**
     * Initialize event listeners
     */
    initEventListeners() {
        // Form submission
        if (this.form) {
            this.form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleFormSubmission();
            });
        }

        // Copy contact info
        document.querySelectorAll('.contact-info-text a').forEach(link => {
            link.addEventListener('click', (e) => {
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    this.copyContactInfo(link.href);
                }
            });
        });

        // Social media clicks
        document.querySelectorAll('.social-contact-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                this.trackSocialClick(btn.href);
            });
        });
    }

    /**
     * Validate individual field
     */
    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = `${this.getFieldLabel(field)} is required`;
        }

        // Email validation
        if (field.type === 'email' && value && !FormUtils.isValidEmail(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address';
        }

        // Phone validation
        if (field.type === 'tel' && value && !FormUtils.isValidPhone(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid phone number (e.g., +2348123456789)';
        }

        // Message length validation
        if (field.name === 'message' && value && value.length < 10) {
            isValid = false;
            errorMessage = 'Message must be at least 10 characters long';
        }

        // Update field appearance
        this.updateFieldValidation(field, isValid, errorMessage);

        return isValid;
    }

    /**
     * Validate email with visual feedback
     */
    validateEmail(emailInput) {
        const value = emailInput.value.trim();

        if (value && FormUtils.isValidEmail(value)) {
            this.updateFieldValidation(emailInput, true, '');
        } else if (value) {
            this.updateFieldValidation(emailInput, false, 'Please enter a valid email address');
        } else {
            this.clearFieldValidation(emailInput);
        }
    }

    /**
     * Validate phone with visual feedback
     */
    validatePhone(phoneInput) {
        const value = phoneInput.value.trim();

        if (value && FormUtils.isValidPhone(value)) {
            this.updateFieldValidation(phoneInput, true, '');
        } else if (value) {
            this.updateFieldValidation(phoneInput, false, 'Please enter a valid phone number');
        } else {
            this.clearFieldValidation(phoneInput);
        }
    }

    /**
     * Update field validation appearance
     */
    updateFieldValidation(field, isValid, errorMessage = '') {
        const feedback = field.parentNode.querySelector('.invalid-feedback, .valid-feedback');

        // Remove existing validation classes
        field.classList.remove('is-valid', 'is-invalid');

        if (feedback) {
            feedback.remove();
        }

        if (isValid && field.value.trim()) {
            // Valid state
            field.classList.add('is-valid');
            const validFeedback = document.createElement('div');
            validFeedback.className = 'valid-feedback';
            validFeedback.textContent = 'Looks good!';
            field.parentNode.appendChild(validFeedback);
        } else if (!isValid) {
            // Invalid state
            field.classList.add('is-invalid');
            const invalidFeedback = document.createElement('div');
            invalidFeedback.className = 'invalid-feedback';
            invalidFeedback.textContent = errorMessage;
            field.parentNode.appendChild(invalidFeedback);
        }
    }

    /**
     * Clear field validation
     */
    clearFieldValidation(field) {
        field.classList.remove('is-valid', 'is-invalid');
        const feedback = field.parentNode.querySelector('.invalid-feedback, .valid-feedback');
        if (feedback) {
            feedback.remove();
        }
    }

    /**
     * Get field label text
     */
    getFieldLabel(field) {
        const label = this.form.querySelector(`label[for="${field.id}"]`);
        return label ? label.textContent.replace('*', '').trim() : field.name;
    }

    /**
     * Handle form submission
     */
    async handleFormSubmission() {
        if (!this.form) return;

        // Validate all fields
        const isValid = this.validateForm();

        if (!isValid) {
            UIUtils.showToast('Please fix the errors in the form', 'warning');
            this.scrollToFirstError();
            return;
        }

        // Get form data
        const formData = this.getFormData();

        // Show loading state
        const submitBtn = this.form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
        submitBtn.disabled = true;

        try {
            // Simulate form submission (in real app, send to server)
            await this.submitForm(formData);

            // Success
            UIUtils.showToast('Message sent successfully! We\'ll get back to you soon.', 'success');
            this.resetForm();

            // Track analytics
            this.trackFormSubmission(formData);

        } catch (error) {
            console.error('Form submission failed:', error);
            UIUtils.showToast('Failed to send message. Please try again.', 'error');
        } finally {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    /**
     * Validate entire form
     */
    validateForm() {
        const fields = this.form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    /**
     * Get form data
     */
    getFormData() {
        const formData = new FormData(this.form);
        const data = {};

        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        // Add additional metadata
        data.timestamp = new Date().toISOString();
        data.userAgent = navigator.userAgent;
        data.referrer = document.referrer;

        return data;
    }

    /**
     * Submit form (simulate API call)
     */
    async submitForm(formData) {
        // Send to backend
        const response = await fetch('process_contact.php', {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Form submission failed');
        }

        console.log('Form submitted successfully:', result);
    }

    /**
     * Reset form
     */
    resetForm() {
        if (this.form) {
            this.form.reset();

            // Clear all validation states
            const fields = this.form.querySelectorAll('input, select, textarea');
            fields.forEach(field => {
                this.clearFieldValidation(field);
            });
        }
    }

    /**
     * Scroll to first error
     */
    scrollToFirstError() {
        const firstError = this.form.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    }

    /**
     * Toggle FAQ item
     */
    toggleFAQ(item, question, answer) {
        const isActive = answer.classList.contains('active');

        // Close all other FAQ items
        this.faqItems.forEach(otherItem => {
            if (otherItem !== item) {
                const otherQuestion = otherItem.querySelector('.faq-question');
                const otherAnswer = otherItem.querySelector('.faq-answer');

                if (otherQuestion && otherAnswer) {
                    otherQuestion.classList.remove('active');
                    otherAnswer.classList.remove('active');
                }
            }
        });

        // Toggle current item
        if (isActive) {
            question.classList.remove('active');
            answer.classList.remove('active');
        } else {
            question.classList.add('active');
            answer.classList.add('active');
        }
    }

    /**
     * Copy contact info to clipboard
     */
    async copyContactInfo(url) {
        const text = url.replace('tel:', '').replace('mailto:', '');

        try {
            await UIUtils.copyToClipboard(text);
            UIUtils.showToast('Contact info copied to clipboard', 'success');
        } catch (error) {
            console.error('Failed to copy contact info:', error);
        }
    }

    /**
     * Track social media clicks
     */
    trackSocialClick(url) {
        // In a real app, this would send analytics data
        console.log('Social media click:', url);

        // Track with analytics manager if available
        if (window.gufStoreApp?.analytics) {
            window.gufStoreApp.analytics.trackEvent('social_click', { url });
        }
    }

    /**
     * Track form submission
     */
    trackFormSubmission(formData) {
        // In a real app, this would send analytics data
        console.log('Contact form submitted:', {
            subject: formData.subject,
            timestamp: formData.timestamp
        });

        // Track with analytics manager if available
        if (window.gufStoreApp?.analytics) {
            window.gufStoreApp.analytics.trackEvent('contact_form_submit', {
                subject: formData.subject,
                hasNewsletter: formData.newsletter === 'on'
            });
        }
    }

    /**
     * Initialize auto-save functionality
     */
    initAutoSave() {
        if (!this.form) return;

        const autoSaveKey = 'contact_form_autosave';

        // Load saved data
        this.loadAutoSave();

        // Save on input
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', PerformanceUtils.debounce(() => {
                this.saveAutoSave();
            }, 1000));
        });

        // Clear on successful submission
        this.form.addEventListener('submit', () => {
            this.clearAutoSave();
        });
    }

    /**
     * Load auto-save data
     */
    loadAutoSave() {
        const savedData = StorageUtils.getItem('contact_form_autosave', null);

        if (savedData && Date.now() - savedData.timestamp < 3600000) { // 1 hour
            Object.entries(savedData.data).forEach(([key, value]) => {
                const field = this.form.querySelector(`[name="${key}"]`);
                if (field && field.type !== 'checkbox') {
                    field.value = value;
                } else if (field && field.type === 'checkbox') {
                    field.checked = value === 'on';
                }
            });
        }
    }

    /**
     * Save form data automatically
     */
    saveAutoSave() {
        if (!this.form) return;

        const formData = new FormData(this.form);
        const data = {};

        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        StorageUtils.setItem('contact_form_autosave', {
            data,
            timestamp: Date.now()
        });
    }

    /**
     * Clear auto-save data
     */
    clearAutoSave() {
        StorageUtils.removeItem('contact_form_autosave');
    }
}

// Initialize contact page manager when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Wait for main app to be ready
    if (window.gufStoreApp) {
        window.contactPageManager = new ContactPageManager();
    } else {
        // Wait for main app
        const checkApp = setInterval(() => {
            if (window.gufStoreApp) {
                window.contactPageManager = new ContactPageManager();
                clearInterval(checkApp);
            }
        }, 100);
    }
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ContactPageManager };
}
