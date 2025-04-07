<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database config
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'password';
$dbName = 'db_tickets';

// Get POST data
$qrData = $_POST['qr_data'] ?? '';
if (empty($qrData)) {
    die('Error: qr_data is empty');
}

try {
    // Connect to DB
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert data
    $stmt = $conn->prepare("INSERT INTO qr_codes (qr_data) VALUES (:qr_data)");
    $stmt->bindParam(':qr_data', $qrData);
    $stmt->execute();

    // Log success
    error_log("Inserted QR data: $qrData");
    echo "QR code saved to database!";
} catch (PDOException $e) {
    // Log detailed error
    error_log("Database error: " . $e->getMessage());
    die("Error: " . $e->getMessage());
}
?>