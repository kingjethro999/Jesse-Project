<?php
// process_contact.php
header('Content-Type: application/json');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input if sent as JSON, or POST vars
    $input = json_decode(file_get_contents('php://input'), true);
    
    $name = $input['firstName'] . ' ' . $input['lastName'] ?? $_POST['firstName'] . ' ' . $_POST['lastName'];
    $email = $input['email'] ?? $_POST['email'];
    $phone = $input['phone'] ?? $_POST['phone'];
    $subject = $input['subject'] ?? $_POST['subject'];
    $message = $input['message'] ?? $_POST['message'];
    
    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);
        
        echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>
