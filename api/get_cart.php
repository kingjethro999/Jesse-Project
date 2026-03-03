<?php
session_start();
header('Content-Type: application/json');

require_once '../db.php';

$session_id = session_id();

try {
    // Get cart items
    $stmt = $pdo->prepare("SELECT id as db_id, product_id as id, name, price, img, quantity FROM cart_items WHERE session_id = ?");
    $stmt->execute([$session_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get cart quantity total
    $stmtCount = $pdo->prepare("SELECT SUM(quantity) as val FROM cart_items WHERE session_id = ?");
    $stmtCount->execute([$session_id]);
    $resCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
    $count = $resCount['val'] ? (int)$resCount['val'] : 0;

    echo json_encode([
        'items' => $items,
        'count' => $count
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?>
