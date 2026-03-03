<?php
// api/products.php
header('Content-Type: application/json');
require_once '../db.php';

try {
    $stmt = $pdo->query("SELECT * FROM fabrics ORDER BY created_at DESC");
    $products = $stmt->fetchAll();
    
    // Transform data to match frontend expectation if needed
    // Frontend expects: id, name, price, img, category, description, rating, reviews, inStock, badge
    // We will Map DB columns to JSON keys
    
    $mappedProducts = array_map(function($p) {
        return [
            'id' => $p['id'],
            'name' => $p['name'],
            'price' => (float)$p['price'],
            'img' => $p['image_path'],
            'category' => $p['category'],
            'description' => $p['description'],
            'rating' => 5.0, // Default or adding rating column later
            'reviews' => 10, // Default or adding reviews column later
            'inStock' => (bool)$p['in_stock'],
            'badge' => '' // Can be logic based (e.g. 'new' if recent)
        ];
    }, $products);

    echo json_encode($mappedProducts);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
