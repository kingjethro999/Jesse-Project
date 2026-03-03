/**
 * CART PAGE FUNCTIONALITY
 * Enhanced cart management with quantity controls and checkout features
 */

/**
 * Cart Page Manager Class
 */
class CartPageManager {
    constructor() {
        this.cart = null;
        this.shippingRates = {
            standard: { name: 'Standard Delivery', price: 1500, days: '3-5 days' },
            express: { name: 'Express Delivery', price: 3000, days: '1-2 days' },
            overnight: { name: 'Overnight Delivery', price: 5000, days: 'Next day' }
        };
        this.selectedShipping = 'standard';
        this.checkoutStep = 1;

        this.init();
    }

    /**
     * Initialize cart page
     */
    async init() {
        try {
            // Get cart from main app or create new instance
            this.cart = window.gufStoreApp?.cart || new CartManager();

            this.initEventListeners();
            this.initShippingOptions();
            this.renderCart();
            this.updateTotals();

            console.log('Cart page manager initialized successfully');
        } catch (error) {
            console.error('Failed to initialize cart page manager:', error);
            UIUtils.showToast('Failed to load cart', 'error');
        }
    }

    /**
     * Initialize event listeners
     */
    initEventListeners() {
        // Quantity controls
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('quantity-btn')) {
                this.handleQuantityChange(e.target);
            }
        });

        // Remove item buttons
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
                this.handleRemoveItem(e.target);
            }
        });

        // Clear cart button
        const clearCartBtn = document.getElementById('clearCartBtn');
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', () => {
                this.handleClearCart();
            });
        }

        // Continue shopping button
        const continueShoppingBtn = document.getElementById('continueShoppingBtn');
        if (continueShoppingBtn) {
            continueShoppingBtn.addEventListener('click', () => {
                window.location.href = 'shop.html';
            });
        }

        // Checkout buttons
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', () => {
                this.handleCheckout();
            });
        }

        // Shipping options
        document.querySelectorAll('input[name="shipping"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                this.selectedShipping = e.target.value;
                this.updateTotals();
            });
        });

        // Coupon form
        const couponForm = document.getElementById('couponForm');
        if (couponForm) {
            couponForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleCouponSubmission(couponForm);
            });
        }

        // Remove coupon
        const removeCouponBtn = document.getElementById('removeCouponBtn');
        if (removeCouponBtn) {
            removeCouponBtn.addEventListener('click', () => {
                this.removeCoupon();
            });
        }

        // Listen for cart updates
        document.addEventListener('cartUpdated', () => {
            this.renderCart();
            this.updateTotals();
        });
    }

    /**
     * Initialize shipping options
     */
    initShippingOptions() {
        const shippingOptions = document.getElementById('shippingOptions');
        if (!shippingOptions) return;

        const shippingHTML = Object.entries(this.shippingRates).map(([key, rate]) => `
            <div class="shipping-option">
                <input type="radio" name="shipping" value="${key}" id="shipping-${key}" 
                       ${key === this.selectedShipping ? 'checked' : ''}>
                <label for="shipping-${key}" class="shipping-label">
                    <div class="shipping-info">
                        <h6 class="mb-1">${rate.name}</h6>
                        <small class="text-muted">${rate.days}</small>
                    </div>
                    <div class="shipping-price">
                        ₦${rate.price.toLocaleString()}
                    </div>
                </label>
            </div>
        `).join('');

        shippingOptions.innerHTML = shippingHTML;
    }

    /**
     * Render cart items
     */
    renderCart() {
        const cartItemsContainer = document.getElementById('cartItems');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const cartContent = document.getElementById('cartContent');

        if (!cartItemsContainer) return;

        if (this.cart.isEmpty()) {
            cartItemsContainer.innerHTML = '';
            if (emptyCartMessage) emptyCartMessage.style.display = 'block';
            if (cartContent) cartContent.style.display = 'none';
            return;
        }

        if (emptyCartMessage) emptyCartMessage.style.display = 'none';
        if (cartContent) cartContent.style.display = 'block';

        const cartHTML = this.cart.getItems().map(item => this.generateCartItemHTML(item)).join('');
        cartItemsContainer.innerHTML = cartHTML;
    }

    /**
     * Generate cart item HTML
     */
    generateCartItemHTML(item) {
        const subtotal = item.price * item.quantity;

        return `
            <div class="cart-item" data-item-id="${item.id}">
                <div class="cart-item-image">
                    <img src="${item.img}" alt="${item.name}" loading="lazy">
                </div>
                <div class="cart-item-details">
                    <h6 class="cart-item-title">${item.name}</h6>
                    <p class="cart-item-price">₦${item.price.toLocaleString()} per 5 yards</p>
                    <div class="quantity-controls">
                        <button class="quantity-btn btn-minus" data-item-id="${item.id}">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="quantity-display">${item.quantity}</span>
                        <button class="quantity-btn btn-plus" data-item-id="${item.id}">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="cart-item-total">
                    <span class="subtotal">₦${subtotal.toLocaleString()}</span>
                    <button class="btn btn-sm btn-outline-danger remove-item" data-item-id="${item.id}" title="Remove item">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }

    /**
     * Handle quantity change
     */
    handleQuantityChange(button) {
        const itemId = button.dataset.itemId;
        const isIncrease = button.classList.contains('btn-plus');
        const currentItem = this.cart.getItems().find(item => item.id === itemId);

        if (!currentItem) return;

        const newQuantity = isIncrease ? currentItem.quantity + 1 : currentItem.quantity - 1;

        if (newQuantity <= 0) {
            this.handleRemoveItem(button);
        } else {
            this.cart.updateQuantity(itemId, newQuantity);
            this.animateQuantityChange(button);
        }
    }

    /**
     * Animate quantity change
     */
    animateQuantityChange(button) {
        button.style.transform = 'scale(1.2)';
        button.style.color = 'var(--primary-color)';

        setTimeout(() => {
            button.style.transform = '';
            button.style.color = '';
        }, 200);
    }

    /**
     * Handle remove item
     */
    handleRemoveItem(button) {
        const itemId = button.dataset.itemId;
        const cartItem = document.querySelector(`[data-item-id="${itemId}"]`);

        if (cartItem) {
            // Animate removal
            cartItem.style.transition = 'all 0.3s ease';
            cartItem.style.opacity = '0';
            cartItem.style.transform = 'translateX(-100%)';

            setTimeout(() => {
                this.cart.removeItem(itemId);
                UIUtils.showToast('Item removed from cart', 'info');
            }, 300);
        }
    }

    /**
     * Handle clear cart
     */
    handleClearCart() {
        // Show confirmation modal
        const confirmModal = this.createConfirmModal(
            'Clear Cart',
            'Are you sure you want to remove all items from your cart?',
            () => {
                this.cart.clear();
                UIUtils.showToast('Cart cleared', 'info');
            }
        );

        document.body.appendChild(confirmModal);
        const modal = new bootstrap.Modal(confirmModal);
        modal.show();
    }

    /**
     * Create confirmation modal
     */
    createConfirmModal(title, message, onConfirm) {
        const modalHTML = `
            <div class="modal fade" id="confirmModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmAction">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        const modalElement = document.createElement('div');
        modalElement.innerHTML = modalHTML;
        const modal = modalElement.firstElementChild;

        // Add event listener to confirm button
        modal.querySelector('#confirmAction').addEventListener('click', () => {
            onConfirm();
            bootstrap.Modal.getInstance(modal).hide();
        });

        return modal;
    }

    /**
     * Update totals
     */
    updateTotals() {
        this.updateSubtotal();
        this.updateShipping();
        this.updateTax();
        this.updateCoupon();
        this.updateGrandTotal();
        this.updateCheckoutButton();
    }

    /**
     * Update subtotal
     */
    updateSubtotal() {
        const subtotalElement = document.getElementById('subtotal');
        if (subtotalElement) {
            const subtotal = this.cart.getTotalPrice();
            subtotalElement.textContent = `₦${subtotal.toLocaleString()}`;
        }
    }

    /**
     * Update shipping cost
     */
    updateShipping() {
        const shippingElement = document.getElementById('shippingCost');
        if (shippingElement) {
            const shippingRate = this.shippingRates[this.selectedShipping];
            shippingElement.textContent = `₦${shippingRate.price.toLocaleString()}`;
        }
    }

    /**
     * Update tax
     */
    updateTax() {
        const taxElement = document.getElementById('taxCost');
        if (taxElement) {
            const subtotal = this.cart.getTotalPrice();
            const tax = subtotal * 0.05; // 5% tax
            taxElement.textContent = `₦${tax.toLocaleString()}`;
        }
    }

    /**
     * Update coupon discount
     */
    updateCoupon() {
        const couponElement = document.getElementById('couponDiscount');
        const appliedCoupon = document.getElementById('appliedCoupon');

        if (couponElement && appliedCoupon) {
            const coupon = StorageUtils.getItem('applied_coupon', null);

            if (coupon) {
                const subtotal = this.cart.getTotalPrice();
                let discount = 0;

                if (coupon.type === 'percentage') {
                    discount = subtotal * (coupon.value / 100);
                } else if (coupon.type === 'fixed') {
                    discount = coupon.value;
                }

                couponElement.textContent = `-₦${discount.toLocaleString()}`;
                appliedCoupon.style.display = 'block';
            } else {
                couponElement.textContent = '₦0';
                appliedCoupon.style.display = 'none';
            }
        }
    }

    /**
     * Update grand total
     */
    updateGrandTotal() {
        const grandTotalElement = document.getElementById('grandTotal');
        if (!grandTotalElement) return;

        const subtotal = this.cart.getTotalPrice();
        const shipping = this.shippingRates[this.selectedShipping].price;
        const tax = subtotal * 0.05;

        let discount = 0;
        const coupon = StorageUtils.getItem('applied_coupon', null);
        if (coupon) {
            if (coupon.type === 'percentage') {
                discount = subtotal * (coupon.value / 100);
            } else if (coupon.type === 'fixed') {
                discount = coupon.value;
            }
        }

        const grandTotal = subtotal + shipping + tax - discount;
        grandTotalElement.textContent = `₦${grandTotal.toLocaleString()}`;
    }

    /**
     * Update checkout button state
     */
    updateCheckoutButton() {
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.disabled = this.cart.isEmpty();

            if (this.cart.isEmpty()) {
                checkoutBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Cart is Empty';
            } else {
                checkoutBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i>Proceed to Checkout';
            }
        }
    }

    /**
     * Handle coupon submission
     */
    async handleCouponSubmission(form) {
        const couponCode = form.querySelector('input[name="couponCode"]').value.trim();

        if (!couponCode) {
            UIUtils.showToast('Please enter a coupon code', 'warning');
            return;
        }

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Applying...';
        submitBtn.disabled = true;

        try {
            // Simulate API call
            await new Promise(resolve => setTimeout(resolve, 1500));

            // Validate coupon (in real app, validate with server)
            const validCoupons = {
                'WELCOME10': { type: 'percentage', value: 10, description: '10% off your order' },
                'SAVE500': { type: 'fixed', value: 500, description: '₦500 off your order' },
                'NEWUSER': { type: 'percentage', value: 15, description: '15% off for new users' }
            };

            const coupon = validCoupons[couponCode.toUpperCase()];

            if (coupon) {
                // Apply coupon
                StorageUtils.setItem('applied_coupon', {
                    code: couponCode.toUpperCase(),
                    ...coupon
                });

                this.updateTotals();
                UIUtils.showToast('Coupon applied successfully!', 'success');
                form.reset();

            } else {
                UIUtils.showToast('Invalid coupon code', 'error');
            }

        } catch (error) {
            console.error('Coupon application failed:', error);
            UIUtils.showToast('Failed to apply coupon', 'error');
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    /**
     * Remove applied coupon
     */
    removeCoupon() {
        StorageUtils.removeItem('applied_coupon');
        this.updateTotals();
        UIUtils.showToast('Coupon removed', 'info');
    }

    /**
     * Handle checkout process
     */
    async handleCheckout() {
        if (this.cart.isEmpty()) {
            UIUtils.showToast('Your cart is empty', 'warning');
            return;
        }

        // Inject modal if not exists
        this.injectCheckoutModal();

        // Show modal
        const modalEl = document.getElementById('checkoutModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        // Handle Place Order logic
        const submitBtn = document.getElementById('submitOrderBtn');

        // Remove old listeners to avoid duplicates if any (simple way is to clone or just use onclick)
        // Using onclick for simplicity in this tailored class method
        submitBtn.onclick = async () => {
            const form = document.getElementById('checkoutForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            await this.submitOrder(modal, submitBtn);
        };
    }

    /**
     * Submit Order
     */
    async submitOrder(modal, submitBtn) {
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
        submitBtn.disabled = true;

        try {
            const orderData = {
                customerName: document.getElementById('checkoutName').value,
                customerEmail: document.getElementById('checkoutEmail').value,
                customerPhone: document.getElementById('checkoutPhone').value,
                address: document.getElementById('checkoutAddress').value,
                city: document.getElementById('checkoutCity').value,
                state: document.getElementById('checkoutState').value,
                zip: document.getElementById('checkoutZip').value,
                paymentMethod: document.querySelector('input[name="paymentMethod"]:checked').value,
                items: this.cart.getItems(),
                totalAmount: parseFloat(document.getElementById('grandTotal').textContent.replace('₦', '').replace(/,/g, ''))
            };

            const response = await fetch('process_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(orderData)
            });

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.message);
            }

            // Success
            modal.hide();
            UIUtils.showToast('Order placed successfully! Order ID: #' + result.orderId, 'success');

            // Clear cart
            this.cart.clear();

            // Show Success Modal or Redirect
            // For now, redirect to shop or just reload
            setTimeout(() => {
                window.location.href = 'shop.html?order_success=true&order_id=' + result.orderId;
            }, 2000);

        } catch (error) {
            console.error('Checkout failed:', error);
            UIUtils.showToast('Order failed: ' + error.message, 'error');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    /**
     * Generate order summary
     */
    generateOrderSummary() {
        const items = this.cart.getItems();
        const shipping = this.shippingRates[this.selectedShipping];
        const subtotal = this.cart.getTotalPrice();
        const tax = subtotal * 0.05;

        let discount = 0;
        const coupon = StorageUtils.getItem('applied_coupon', null);
        if (coupon) {
            if (coupon.type === 'percentage') {
                discount = subtotal * (coupon.value / 100);
            } else if (coupon.type === 'fixed') {
                discount = coupon.value;
            }
        }

        const grandTotal = subtotal + shipping.price + tax - discount;

        return `Items: ${items.length}
Total: ₦${grandTotal.toLocaleString()}
Shipping: ${shipping.name} (${shipping.days})
Payment: To be processed`;
    }

    /**
     * Save cart state
     */
    saveCartState() {
        StorageUtils.setItem('cart_state', {
            items: this.cart.getItems(),
            shipping: this.selectedShipping,
            timestamp: Date.now()
        });
    }

    /**
     * Load cart state
     */
    loadCartState() {
        const savedState = StorageUtils.getItem('cart_state', null);
        if (savedState && Date.now() - savedState.timestamp < 86400000) { // 24 hours
            this.selectedShipping = savedState.shipping;
            this.initShippingOptions();
        }
    }
    /**
     * Inject Checkout Modal HTML
     */
    injectCheckoutModal() {
        if (document.getElementById('checkoutModal')) return;

        const modalHTML = `
            <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fas fa-lock me-2"></i>Secure Checkout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="checkoutForm">
                                <h6 class="mb-3">Contact Information</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="checkoutName" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="checkoutName" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="checkoutEmail" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="checkoutEmail" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="checkoutPhone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="checkoutPhone" required placeholder="+234...">
                                </div>

                                <h6 class="mb-3 mt-4">Shipping Address</h6>
                                <div class="mb-3">
                                    <label for="checkoutAddress" class="form-label">Street Address</label>
                                    <input type="text" class="form-control" id="checkoutAddress" required>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="checkoutCity" class="form-label">City</label>
                                        <input type="text" class="form-control" id="checkoutCity" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="checkoutState" class="form-label">State</label>
                                        <input type="text" class="form-control" id="checkoutState" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="checkoutZip" class="form-label">Zip Code</label>
                                        <input type="text" class="form-control" id="checkoutZip">
                                    </div>
                                </div>

                                <h6 class="mb-3 mt-4">Payment Method</h6>
                                <div class="mb-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="payBank" value="Bank Transfer" checked>
                                        <label class="form-check-label" for="payBank">
                                            Bank Transfer
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="payCOD" value="Cash on Delivery">
                                        <label class="form-check-label" for="payCOD">
                                            Cash on Delivery
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info mt-4">
                                    <small><i class="fas fa-info-circle me-1"></i> Your order will be processed securely. Payment details will be provided on the next step.</small>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="submitOrderBtn">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }
}

// Initialize cart page manager when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Wait for main app to be ready
    if (window.gufStoreApp) {
        window.cartPageManager = new CartPageManager();
    } else {
        // Wait for main app
        const checkApp = setInterval(() => {
            if (window.gufStoreApp) {
                window.cartPageManager = new CartPageManager();
                clearInterval(checkApp);
            }
        }, 100);
    }
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { CartPageManager };
}
