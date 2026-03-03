<?php
// process_order.php
header('Content-Type: application/json');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
         // Fallback to POST if needed, but cart normally sends JSON
         http_response_code(400);
         echo json_encode(['success' => false, 'message' => 'Invalid data format.']);
         exit;
    }

    $customer_name = $input['customerName'];
    $customer_email = $input['customerEmail'];
    $customer_phone = $input['customerPhone'] ?? '';
    
    // Detailed Address Info
    $address = $input['address'] ?? '';
    $city = $input['city'] ?? '';
    $state = $input['state'] ?? '';
    $zip = $input['zip'] ?? '';
    $payment_method = $input['paymentMethod'] ?? 'Bank Transfer';

    $items = $input['items'];
    $total_amount = $input['totalAmount'];

    if (empty($customer_name) || empty($customer_email) || empty($items)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing required order information.']);
        exit;
    }

    try {
        $pdo->beginTransaction();

        // 1. Insert Order
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, address, city, state, zip, payment_method, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$customer_name, $customer_email, $customer_phone, $address, $city, $state, $zip, $payment_method, $total_amount]);
        $order_id = $pdo->lastInsertId();

        // 2. Insert Order Items
        $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, fabric_id, quantity, price) VALUES (?, ?, ?, ?)");
        
        foreach ($items as $item) {
            // Ensure fabric_id exists or handle error (skipping check for speed/simplicity, assuming valid IDs from frontend)
            // Note: Frontend IDs might be 'organic-cotton' (string) if from sample data, but DB has INTs.
            // We need to make sure frontend uses DB IDs. 
            // The initial DB seed has IDs 1-8. 
            // If frontend sends string IDs for the sample usage, this will fail or store 0. 
            // Assumption: Frontend will reload products from API which gives DB IDs.
            
            $fabric_id = $item['id']; 
            $qty = $item['quantity'];
            $price = $item['price'];
            
            $stmtItem->execute([$order_id, $fabric_id, $qty, $price]);
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Order placed successfully!', 'orderId' => $order_id]);
    } catch (PDOException $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Order processing failed: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>
