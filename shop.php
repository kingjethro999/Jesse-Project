<?php
session_start();
require_once 'db.php';

// Pagination settings
$itemsPerPage = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Capture filters
$search = $_GET['search'] ?? '';
$categories = $_GET['category'] ?? [];
$priceMin = isset($_GET['priceMin']) ? (int)$_GET['priceMin'] : 0;
$priceMax = isset($_GET['priceMax']) ? (int)$_GET['priceMax'] : 50000;
$availability = $_GET['availability'] ?? [];
$sort = $_GET['sort'] ?? 'name-asc';
$view = $_GET['view'] ?? 'grid';

// Build the query
$queryStr = "SELECT * FROM fabrics WHERE price >= :priceMin AND price <= :priceMax";
$params = [
    ':priceMin' => $priceMin,
    ':priceMax' => $priceMax
];

if (!empty($search)) {
    $queryStr .= " AND (name LIKE :search OR description LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

if (!empty($categories) && !in_array('all', $categories)) {
    $placeholders = [];
    foreach ($categories as $i => $cat) {
        $p = ":cat$i";
        $placeholders[] = $p;
        $params[$p] = $cat;
    }
    $queryStr .= " AND category IN (" . implode(',', $placeholders) . ")";
}

// Just map the availability mock logic to basic DB attributes if available
if (!empty($availability)) {
    if (in_array('in-stock', $availability)) {
        $queryStr .= " AND in_stock = 1";
    }
    // New/Sale badges could be implemented here as DB queries later
}

// Apply Sorting
switch ($sort) {
    case 'name-desc':
        $queryStr .= " ORDER BY name DESC";
        break;
    case 'price-asc':
        $queryStr .= " ORDER BY price ASC";
        break;
    case 'price-desc':
        $queryStr .= " ORDER BY price DESC";
        break;
    case 'newest':
        $queryStr .= " ORDER BY created_at DESC";
        break;
    case 'name-asc':
    default:
        $queryStr .= " ORDER BY name ASC";
        break;
}

// Get Total Count for Pagination
$stmtCount = $pdo->prepare(str_replace("SELECT *", "SELECT COUNT(*) as total", $queryStr));
$stmtCount->execute($params);
$totalProducts = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];

// Apply Pagination LIMIT
$offset = ($page - 1) * $itemsPerPage;
$queryStr .= " LIMIT $itemsPerPage OFFSET $offset";

$stmt = $pdo->prepare($queryStr);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalPages = ceil($totalProducts / $itemsPerPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop — Gracious Unique Fabrics</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Custom CSS replaced with Bootstrap classes -->
    <style>
        /* Shop hero styling handled by Bootstrap classes */
        
        .filter-sidebar {
            background: white;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: sticky;
            top: 100px;
            max-height: calc(100vh - 120px);
            overflow-y: auto;
            border: 1px solid var(--gray-200);
        }
        
        .filter-group {
            margin-bottom: 1.5rem;
        }
        
        .filter-group h6 {
            color: var(--dark-color);
            margin-bottom: 0.75rem;
            font-weight: 600;
            font-family: var(--font-primary);
        }
        
        .filter-option {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: var(--transition-normal);
            padding: 0.25rem 0;
            border-radius: var(--radius-sm);
        }
        
        .filter-option:hover {
            color: var(--secondary-color);
            background: rgba(233, 69, 96, 0.05);
            padding-left: 0.5rem;
        }
        
        .filter-option input[type="checkbox"] {
            margin-right: 0.5rem;
        }
        
        .price-range {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        
        .price-input {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            transition: var(--transition-fast);
        }
        
        .price-input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(233, 69, 96, 0.25);
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .products-grid.list-view {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .product-card {
            background: white;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            position: relative;
            border: 1px solid var(--gray-200);
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
            border-color: var(--secondary-color);
        }
        
        /* List view specific styles */
        .product-card[data-view="list"] {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 1.5rem;
            gap: 1.5rem;
        }
        
        .product-card[data-view="list"] .product-image {
            flex: 0 0 200px;
            height: 150px;
            border-radius: var(--radius-lg);
        }
        
        .product-card[data-view="list"] .product-info {
            flex: 1;
            padding: 0;
        }
        
        .product-card[data-view="list"] .product-actions {
            display: none;
        }
        
        .product-card[data-view="list"] .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .product-card[data-view="list"] .add-to-cart-btn {
            width: auto;
            min-width: 150px;
        }
        
        .product-image {
            position: relative;
            overflow: hidden;
        }
        
        .product-image img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        
        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--accent-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .product-badge.new {
            background: var(--success-color);
        }
        
        .product-badge.sale {
            background: var(--danger-color);
        }
        
        .product-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            opacity: 0;
            transition: var(--transition);
        }
        
        .product-card:hover .product-actions {
            opacity: 1;
        }
        
        .product-action-btn {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-lg);
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--glass-shadow);
            transition: var(--transition-bounce);
            cursor: pointer;
            backdrop-filter: blur(20px);
            color: var(--gray-700);
        }
        
        .product-action-btn:hover {
            background: var(--secondary-color);
            color: white;
            transform: scale(1.1);
            border-color: var(--secondary-color);
        }
        
        .product-info {
            padding: 1.5rem;
        }
        
        .product-title {
            font-family: var(--font-primary);
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .product-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .product-price .old-price {
            font-size: 1rem;
            color: var(--gray-500);
            text-decoration: line-through;
            margin-left: 0.5rem;
        }
        
        .product-rating {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .stars {
            color: var(--warning-color);
            margin-right: 0.5rem;
        }
        
        .rating-count {
            color: var(--gray-600);
            font-size: 0.9rem;
        }
        
        .product-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        
        .add-to-cart-btn {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--radius-lg);
            font-weight: 600;
            transition: var(--transition-bounce);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .add-to-cart-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: var(--transition-slow);
        }
        
        .add-to-cart-btn:hover::before {
            left: 100%;
        }
        
        .add-to-cart-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .add-to-cart-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .shop-toolbar {
            background: white;
            padding: 1rem;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            border: 1px solid var(--gray-200);
            position: sticky;
            top: 100px;
            z-index: 10;
        }
        
        .results-count {
            color: var(--gray-600);
            font-size: 0.9rem;
        }
        
        .sort-options {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .sort-select {
            padding: 0.5rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            transition: var(--transition-fast);
        }
        
        .sort-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(233, 69, 96, 0.25);
        }
        
        .view-toggle {
            display: flex;
            gap: 0.25rem;
        }
        
        .view-btn {
            width: 40px;
            height: 40px;
            border: 1px solid var(--gray-300);
            background: white;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-bounce);
        }
        
        .view-btn.active,
        .view-btn:hover {
            background: var(--secondary-color);
            color: white;
            border-color: var(--secondary-color);
            transform: scale(1.05);
        }
        
        .search-box {
            position: relative;
            flex: 1;
            max-width: 300px;
        }
        
        .search-input {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            transition: var(--transition-fast);
        }
        
        .search-input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(233, 69, 96, 0.25);
        }
        
        .search-btn {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-600);
            cursor: pointer;
        }
        
        .no-products {
            text-align: center;
            padding: 3rem;
            color: var(--gray-600);
        }
        
        .no-products i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--gray-400);
        }
        
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }
        
        .page-loading {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid var(--gray-300);
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @media (max-width: 768px) {
            .shop-hero {
                padding: 4rem 0 2rem;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }
            
            .products-grid.list-view {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .product-card[data-view="list"] {
                flex-direction: column;
                text-align: center;
                padding: 1rem;
                gap: 1rem;
            }
            
            .product-card[data-view="list"] .product-image {
                flex: none;
                width: 100%;
                height: 200px;
            }
            
            .product-card[data-view="list"] .product-info {
                width: 100%;
            }
            
            .product-card[data-view="list"] .add-to-cart-btn {
                width: 100%;
            }
            
            .shop-toolbar {
                flex-direction: column;
                align-items: stretch;
                position: relative;
                top: auto;
            }
            
            .search-box {
                max-width: none;
            }
            
            .filter-sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 80%;
                max-width: 300px;
                height: 100vh;
                z-index: 1000;
                transition: var(--transition-normal);
                overflow-y: auto;
                border-radius: 0;
                margin-bottom: 0;
            }
            
            .filter-sidebar.open {
                left: 0;
            }
            
            .filter-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: var(--transition-normal);
            }
            
            .filter-overlay.open {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>
<body class="shop-page">
    <!-- Preloader -->
    <div id="preloader" class="d-flex align-items-center justify-content-center">
        <div class="preloader-content text-center text-white">
            <div class="fabric-icon fs-1 mb-3">
                <i class="fas fa-store"></i>
            </div>
            <div class="loading-text">
                <h3 class="mb-2 display-3">GUF XTORE</h3>
                <p class="fs-5">Loading Products...</p>
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
                        <a class="nav-link active" href="shop.php">
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
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadge">
                                0
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Shop Hero -->
    <section class="py-5 text-white position-relative mt-5" style="margin-top: 76px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 50%, var(--primary-dark) 100%);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="shop-badge mb-3">
                        <span class="badge bg-glass text-white px-4 py-2 rounded-pill">
                            <i class="fas fa-store me-2"></i>Premium Collection
                        </span>
                    </div>
                    <h1 class="display-4 fw-bold mb-3 text-premium">Our Fabric Collection</h1>
                    <p class="lead fs-4 text-elegant">Discover premium fabrics for your next creation</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Filter Sidebar -->
                <div class="col-lg-3">
                    <form class="filter-sidebar" id="filterSidebar" method="GET" action="shop.php">
                        <input type="hidden" name="view" value="<?= htmlspecialchars($view) ?>">
                        <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold text-dark text-premium">
                                <i class="fas fa-filter me-2 text-secondary"></i>Filters
                            </h5>
                            <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" id="closeFilters">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <!-- Search -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3 text-premium">
                                <i class="fas fa-search me-2 text-secondary"></i>Search
                            </h6>
                            <div class="position-relative">
                                <input type="text" class="form-control pe-5" placeholder="Search fabrics..." name="search" id="searchInput" value="<?= htmlspecialchars($search) ?>">
                                <button class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-2" type="submit">
                                    <i class="fas fa-search text-secondary"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3 text-premium">
                                <i class="fas fa-tags me-2 text-secondary"></i>Category
                            </h6>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="category-all" name="category[]" value="all" <?= empty($categories) || in_array('all', $categories) ? 'checked' : '' ?>>
                                <label for="category-all" class="form-check-label">All Categories</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="category-luxury" name="category[]" value="luxury" <?= in_array('luxury', $categories) ? 'checked' : '' ?>>
                                <label for="category-luxury" class="form-check-label">Luxury</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="category-cotton" name="category[]" value="cotton" <?= in_array('cotton', $categories) ? 'checked' : '' ?>>
                                <label for="category-cotton" class="form-check-label">Cotton</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="category-silk" name="category[]" value="silk" <?= in_array('silk', $categories) ? 'checked' : '' ?>>
                                <label for="category-silk" class="form-check-label">Silk</label>
                            </div>
                        </div>
                        
                        <!-- Price Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3 text-premium">
                                <i class="fas fa-dollar-sign me-2 text-secondary"></i>Price Range
                            </h6>
                            <div class="d-flex gap-2 align-items-center mb-3">
                                <input type="number" class="form-control form-control-sm" placeholder="Min" name="priceMin" id="priceMin" min="0" value="<?= $priceMin ?>">
                                <span class="text-muted">-</span>
                                <input type="number" class="form-control form-control-sm" placeholder="Max" name="priceMax" id="priceMax" min="0" value="<?= $priceMax ?>">
                            </div>
                            <div>
                                <input type="range" class="form-range" min="0" max="50000" step="1000" id="priceRange" value="<?= $priceMax ?>">
                            </div>
                        </div>
                        
                        <!-- Availability -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3 text-premium">
                                <i class="fas fa-check-circle me-2 text-secondary"></i>Availability
                            </h6>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="in-stock" name="availability[]" value="in-stock" <?= in_array('in-stock', $availability) ? 'checked' : '' ?>>
                                <label for="in-stock" class="form-check-label">In Stock</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="new-arrivals" name="availability[]" value="new" <?= in_array('new', $availability) ? 'checked' : '' ?>>
                                <label for="new-arrivals" class="form-check-label">New Arrivals</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="on-sale" name="availability[]" value="sale" <?= in_array('sale', $availability) ? 'checked' : '' ?>>
                                <label for="on-sale" class="form-check-label">On Sale</label>
                            </div>
                        </div>
                        
                        <!-- Apply Filters -->
                        <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill mb-2">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                        
                        <!-- Clear Filters -->
                        <a href="shop.php" class="btn btn-outline-secondary w-100 fw-bold rounded-pill">
                            <i class="fas fa-refresh me-2"></i>Clear All Filters
                        </a>
                    </form>
                    
                    <!-- Filter Overlay for Mobile -->
                    <div class="filter-overlay" id="filterOverlay"></div>
                </div>
                
                <!-- Products Section -->
                <div class="col-lg-9">
                    <!-- Shop Toolbar -->
                    <div class="shop-toolbar">
                        <div class="row align-items-center w-100">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3">
                                    <button class="btn btn-outline-secondary d-lg-none" id="openFilters">
                                        <i class="fas fa-filter me-2"></i>Filters
                                    </button>
                                    <span class="text-muted small" id="resultsCount">Loading products...</span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <label for="sortSelect" class="form-label mb-0 small">Sort by:</label>
                                        <select class="form-select form-select-sm" id="sortSelect" style="width: auto;">
                                            <option value="name-asc">Name A-Z</option>
                                            <option value="name-desc">Name Z-A</option>
                                            <option value="price-asc">Price Low-High</option>
                                            <option value="price-desc">Price High-Low</option>
                                            <option value="newest">Newest First</option>
                                        </select>
                                    </div>
                                    
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary active" data-view="grid" title="Grid View">
                                        <!-- Grid/List View handled via JS simple class toggle now -->
                                        <button class="btn btn-outline-secondary <?= $view === 'grid' ? 'active' : '' ?>" id="gridViewBtn" title="Grid View">
                                            <i class="fas fa-th"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary <?= $view === 'list' ? 'active' : '' ?>" id="listViewBtn" title="List View">
                                            <i class="fas fa-list"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (empty($products)): ?>
                    <!-- No Products Message -->
                    <div class="text-center py-5" id="noProducts">
                        <i class="fas fa-search fs-1 text-muted mb-3"></i>
                        <h4 class="fw-bold text-dark">No products found</h4>
                        <p class="text-muted mb-4">Try adjusting your filters or search terms</p>
                        <a href="shop.php" class="btn btn-primary fw-bold">
                            <i class="fas fa-refresh me-2"></i>Reset Search
                        </a>
                    </div>
                    <?php else: ?>
                    
                    <!-- Products Grid -->
                    <div class="row g-4 <?= $view === 'list' ? 'list-view' : '' ?>" id="productsGrid">
                        <?php foreach($products as $product): ?>
                            <?php 
                                $colClass = $view === 'grid' ? 'col-12 col-sm-6 col-lg-4 mb-4' : 'col-12 mb-4'; 
                                $badgeHTML = '';
                                if ($product['badge']) {
                                    $badgeHTML = '<div class="product-badge ' . htmlspecialchars($product['badge']) . '">' . htmlspecialchars($product['badge']) . '</div>';
                                }
                                $stockStatus = $product['in_stock'] ? '' : 'disabled';
                                $stockText = $product['in_stock'] ? 'Add to Cart' : 'Out of Stock';
                            ?>
                            <div class="<?= $colClass ?>">
                                <div class="product-card" data-view="<?= htmlspecialchars($view) ?>">
                                    <div class="product-image">
                                        <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy">
                                        <?= $badgeHTML ?>
                                        <div class="product-actions">
                                            <button class="product-action-btn quick-view-btn" title="Quick View" 
                                                    data-product='<?= htmlspecialchars(json_encode([
                                                        "id" => $product["id"],
                                                        "name" => $product["name"],
                                                        "price" => (float)$product["price"],
                                                        "img" => $product["image_path"],
                                                        "category" => $product["category"],
                                                        "description" => $product["description"],
                                                        "inStock" => (bool)$product["in_stock"],
                                                        "rating" => 5.0,
                                                        "reviews" => 10
                                                    ]), ENT_QUOTES, "UTF-8") ?>'>
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="product-action-btn" title="Add to Wishlist" data-product-id="<?= $product['id'] ?>">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="card-title mb-2"><?= htmlspecialchars($product['name']) ?></h3>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="price-wrap">
                                                <span class="price-current">₦<?= number_format($product['price'], 2) ?></span>
                                            </div>
                                        </div>
                                        <p class="text-muted small mb-4 line-clamp-2"><?= htmlspecialchars($product['description']) ?></p>
                                        <button class="btn btn-primary w-100 add-to-cart" <?= $stockStatus ?>
                                            data-id="<?= $product['id'] ?>"
                                            data-name="<?= htmlspecialchars($product['name']) ?>"
                                            data-price="<?= $product['price'] ?>"
                                            data-img="<?= htmlspecialchars($product['image_path']) ?>">
                                            <i class="fas fa-shopping-cart me-2"></i><?= $stockText ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                    <div class="d-flex justify-content-center mt-5">
                        <nav aria-label="Products pagination">
                            <ul class="pagination">
                                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&priceMin=<?= $priceMin ?>&priceMax=<?= $priceMax ?>&sort=<?= urlencode($sort) ?>&view=<?= urlencode($view) ?>" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                    </a>
                                </li>
                                
                                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= ($page === $i) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&priceMin=<?= $priceMin ?>&priceMax=<?= $priceMax ?>&sort=<?= urlencode($sort) ?>&view=<?= urlencode($view) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&priceMin=<?= $priceMin ?>&priceMax=<?= $priceMax ?>&sort=<?= urlencode($sort) ?>&view=<?= urlencode($view) ?>" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <?php endif; ?>
                    
                    <?php endif; ?>
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
    <script src="shop.js"></script>
<?php include "auth_modal.php"; ?>
</body>
</html>
