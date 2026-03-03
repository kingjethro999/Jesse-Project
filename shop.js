/**
 * SHOP PAGE FUNCTIONALITY (SSR VERSION)
 * Handles UI interactions like Grid/List toggle, mobile filters, and Quick View
 */

document.addEventListener('DOMContentLoaded', () => {

    // Mobile Filter Sidebar Toggle
    const openFiltersBtn = document.getElementById('openFilters');
    const closeFiltersBtn = document.getElementById('closeFilters');
    const filterSidebar = document.getElementById('filterSidebar');
    const filterOverlay = document.getElementById('filterOverlay');

    if (openFiltersBtn) {
        openFiltersBtn.addEventListener('click', () => {
            if (filterSidebar) filterSidebar.classList.add('open');
            if (filterOverlay) filterOverlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        });
    }

    const closeFilters = () => {
        if (filterSidebar) filterSidebar.classList.remove('open');
        if (filterOverlay) filterOverlay.classList.remove('open');
        document.body.style.overflow = '';
    };

    if (closeFiltersBtn) closeFiltersBtn.addEventListener('click', closeFilters);
    if (filterOverlay) filterOverlay.addEventListener('click', closeFilters);

    // Sort Auto-submit
    const sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.value = new URLSearchParams(window.location.search).get('sort') || 'name-asc';
        sortSelect.addEventListener('change', (e) => {
            const form = document.getElementById('filterSidebar');
            if (form) {
                const sortInput = form.querySelector('input[name="sort"]');
                if (sortInput) sortInput.value = e.target.value;
                form.submit();
            }
        });
    }

    // Grid/List View Toggle (Client-side fast toggle)
    const gridViewBtn = document.getElementById('gridViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    const productsGrid = document.getElementById('productsGrid');

    const setView = (view) => {
        if (!productsGrid) return;

        // Update URL and hidden input
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('view', view);
        window.history.replaceState({}, '', `${window.location.pathname}?${urlParams}`);

        const form = document.getElementById('filterSidebar');
        if (form) {
            const viewInput = form.querySelector('input[name="view"]');
            if (viewInput) viewInput.value = view;
        }

        // Toggle CSS classes
        if (view === 'list') {
            productsGrid.classList.add('list-view');
            gridViewBtn?.classList.remove('active');
            listViewBtn?.classList.add('active');
        } else {
            productsGrid.classList.remove('list-view');
            listViewBtn?.classList.remove('active');
            gridViewBtn?.classList.add('active');
        }

        // Adjust column CSS classes on product wrappers
        const productWrappers = productsGrid.querySelectorAll('.col-12');
        productWrappers.forEach(wrapper => {
            if (view === 'list') {
                wrapper.className = 'col-12 mb-4';
                wrapper.querySelector('.product-card').setAttribute('data-view', 'list');
            } else {
                wrapper.className = 'col-12 col-sm-6 col-lg-4 mb-4';
                wrapper.querySelector('.product-card').setAttribute('data-view', 'grid');
            }
        });
    };

    if (gridViewBtn) gridViewBtn.addEventListener('click', () => setView('grid'));
    if (listViewBtn) listViewBtn.addEventListener('click', () => setView('list'));

    // Quick View Logic
    const generateStars = (rating) => {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 !== 0;
        let starsHTML = '';
        for (let i = 0; i < fullStars; i++) starsHTML += '<i class="fas fa-star"></i>';
        if (hasHalfStar) starsHTML += '<i class="fas fa-star-half-alt"></i>';
        const emptyStars = 5 - Math.ceil(rating);
        for (let i = 0; i < emptyStars; i++) starsHTML += '<i class="far fa-star"></i>';
        return starsHTML;
    };

    document.querySelectorAll('.quick-view-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const product = JSON.parse(btn.getAttribute('data-product'));
            if (!product) return;

            const modalHTML = `
                <div class="modal fade" id="quickViewModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${product.name}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="${product.img}" class="img-fluid rounded" alt="${product.name}">
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="text-primary">₦${product.price.toLocaleString()}</h4>
                                        ${product.rating ? `
                                            <div class="mb-3">
                                                <div class="stars mb-1">${generateStars(product.rating)}</div>
                                                <small class="text-muted">${product.reviews} reviews</small>
                                            </div>
                                        ` : ''}
                                        <p>${product.description}</p>
                                        <div class="mb-3">
                                            <strong>Category:</strong> ${product.category.charAt(0).toUpperCase() + product.category.slice(1)}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Availability:</strong> 
                                            <span class="text-${product.inStock ? 'success' : 'danger'}">
                                                ${product.inStock ? 'In Stock' : 'Out of Stock'}
                                            </span>
                                        </div>
                                        <button class="btn btn-primary btn-lg w-100 add-to-cart" 
                                                data-name="${product.name}"
                                                data-price="${product.price}"
                                                data-img="${product.img}"
                                                data-id="${product.id}"
                                                ${!product.inStock ? 'disabled' : ''}>
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            ${product.inStock ? 'Add to Cart' : 'Out of Stock'}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('quickViewModal');
            if (existingModal) existingModal.remove();

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHTML);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            modal.show();

            // Hide modal when add-to-cart is clicked (main.js handles the cart addition)
            document.querySelector('#quickViewModal .add-to-cart').addEventListener('click', () => {
                modal.hide();
            });
        });
    });

    // Toggle Wishlist Logic
    document.querySelectorAll('.product-action-btn[title="Add to Wishlist"]').forEach(btn => {
        btn.addEventListener('click', () => {
            const productId = btn.dataset.productId;
            if (!window.StorageUtils || !window.UIUtils) return; // Depends on utils.js loaded first

            const wishlist = window.StorageUtils.getItem('wishlist', []);
            const index = wishlist.indexOf(productId);

            if (index > -1) {
                wishlist.splice(index, 1);
                window.UIUtils.showToast('Removed from wishlist', 'info');
            } else {
                wishlist.push(productId);
                window.UIUtils.showToast('Added to wishlist', 'success');
            }
            window.StorageUtils.setItem('wishlist', wishlist);
        });
    });
});
