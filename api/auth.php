<?php
session_start();
header('Content-Type: application/json');

require_once '../db.php';

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

switch ($action) {
    case 'check':
        echo json_encode(['authenticated' => isset($_SESSION['customer_id'])]);
        break;

    case 'login':
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        if (empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Please provide email and password.']);
            exit;
        }

        try {
            $stmt = $pdo->prepare("SELECT id, name, password FROM customers WHERE email = ?");
            $stmt->execute([$email]);
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($customer && password_verify($password, $customer['password'])) {
                $_SESSION['customer_id'] = $customer['id'];
                $_SESSION['customer_name'] = $customer['name'];
                
                // Merge session cart with customer cart if needed (omitted for brevity, just update user id)
                $stmtMerge = $pdo->prepare("UPDATE cart_items SET customer_id = ? WHERE session_id = ? AND customer_id IS NULL");
                $stmtMerge->execute([$customer['id'], session_id()]);

                echo json_encode(['success' => true, 'message' => 'Login successful', 'customer' => $customer['name']]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        break;

    case 'register':
        $name = trim($input['name'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Please fill all fields.']);
            exit;
        }

        if (strlen($password) < 6) {
            echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters.']);
            exit;
        }

        try {
            // Check if email already exists
            $stmtCheck = $pdo->prepare("SELECT id FROM customers WHERE email = ?");
            $stmtCheck->execute([$email]);
            if ($stmtCheck->fetchColumn()) {
                echo json_encode(['success' => false, 'message' => 'Email is already registered.']);
                exit;
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO customers (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashed_password]);
            
            $customer_id = $pdo->lastInsertId();
            
            $_SESSION['customer_id'] = $customer_id;
            $_SESSION['customer_name'] = $name;

            // Merge session cart
            $stmtMerge = $pdo->prepare("UPDATE cart_items SET customer_id = ? WHERE session_id = ? AND customer_id IS NULL");
            $stmtMerge->execute([$customer_id, session_id()]);

            echo json_encode(['success' => true, 'message' => 'Registration successful']);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Database error during registration']);
        }
        break;
        
    case 'logout':
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
