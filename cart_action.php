<?php
session_start();
header('Content-Type: application/json');

require_once 'db.php';

$session_id = session_id();

$input = json_decode(file_get_contents('php://input'), true);

if (!$input && isset($_POST['action'])) {
    $input = $_POST;
}

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$action = $input['action'] ?? '';

// Helper function to get current cart
function getCart($pdo, $session_id) {
    $stmt = $pdo->prepare("SELECT id as db_id, product_id as id, name, price, img, quantity FROM cart_items WHERE session_id = ?");
    $stmt->execute([$session_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Helper function to get cart count
function getCartCount($pdo, $session_id) {
    $stmt = $pdo->prepare("SELECT SUM(quantity) as val FROM cart_items WHERE session_id = ?");
    $stmt->execute([$session_id]);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res['val'] ? (int)$res['val'] : 0;
}

switch ($action) {
    case 'add':
        $product_id = (string)$input['id'];
        $name = $input['name'];
        $price = (float)$input['price'];
        $img = $input['img'];
        $quantity = isset($input['quantity']) ? (int)$input['quantity'] : 1;
        
        $sql = "INSERT INTO cart_items (session_id, product_id, name, price, img, quantity) 
                VALUES (?, ?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$session_id, $product_id, $name, $price, $img, $quantity]);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Item added to cart', 
                'count' => getCartCount($pdo, $session_id),
                'cart' => getCart($pdo, $session_id)
            ]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        break;

    case 'remove':
        $product_id = (string)$input['id'];
        $sql = "DELETE FROM cart_items WHERE session_id = ? AND product_id = ?";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$session_id, $product_id]);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Item removed', 
                'cart' => getCart($pdo, $session_id)
            ]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        break;

    case 'update':
        $product_id = (string)$input['id'];
        $quantity = (int)$input['quantity'];
        
        $sql = "UPDATE cart_items SET quantity = ? WHERE session_id = ? AND product_id = ?";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$quantity, $session_id, $product_id]);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Cart updated', 
                'cart' => getCart($pdo, $session_id)
            ]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        break;

    case 'clear':
        $sql = "DELETE FROM cart_items WHERE session_id = ?";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$session_id]);
            
            echo json_encode(['success' => true, 'message' => 'Cart cleared']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        break;

    case 'get':
        echo json_encode([
            'success' => true, 
            'items' => getCart($pdo, $session_id),
            'count' => getCartCount($pdo, $session_id)
        ]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
?>
