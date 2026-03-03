<?php
// db.php - Database Connection

define('DB_HOST', 's4946.fra1.stableserver.net');
define('DB_USER', 'edisocie_root');
define('DB_PASS', 'Seun2000*');
define('DB_NAME', 'edisocie_jesse');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
