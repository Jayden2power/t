<?php 

header('Content-Type: text/plain');

// Database configuration
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'password';
$dbName = 'db_tickets';

// Get the scanned data
$qrData = $_POST['qr_data'] ?? '';

if (empty($qrData)) {
    die('Error: No QR code data received');
}

try {
    // Create connection
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Prepare and execute SQL
    $stmt = $conn->prepare("INSERT INTO  (qr_data, ip_address) VALUES (:data, :ip)");
    $stmt->bindParam(':data', $qrData);
    $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
    $stmt->execute();
    
    echo "Scan saved successfully";
} catch(PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>



https://chat.deepseek.com/a/chat/s/f097a06d-b70b-4cff-8829-42af447930b3