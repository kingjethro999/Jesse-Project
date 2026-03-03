<?php
require_once 'db.php';

try {
    // Add columns to orders table if they don't exist
    $sql = "ALTER TABLE orders 
            ADD COLUMN address TEXT AFTER customer_phone,
            ADD COLUMN city VARCHAR(100) AFTER address,
            ADD COLUMN state VARCHAR(100) AFTER city,
            ADD COLUMN zip VARCHAR(20) AFTER state,
            ADD COLUMN payment_method VARCHAR(50) AFTER zip";
    
    $pdo->exec($sql);
    echo "Database updated successfully: Added columns to orders table.";
} catch (PDOException $e) {
    echo "Error updating database (columns might already exist): " . $e->getMessage();
}
?>
