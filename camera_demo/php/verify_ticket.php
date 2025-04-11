<?php
header('Content-Type: application/json');

// Database configuration (adjust these to your settings)
$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'root';

try {
    // Get the POST data
    $data = json_decode(file_get_contents('php://input'), true);
    $qrCode = $data['qr_code'] ?? null;

    if (!$qrCode) {
        throw new Exception('No QR code data provided');
    }

    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute query
    $stmtticket = $pdo->prepare("SELECT account_id, id FROM tickettest WHERE qr = :qr_code");
    $stmtticket->bindParam(':qr_code', $qrCode);
    $stmtticket->execute();

    $resultticket = $stmtticket->fetch(PDO::FETCH_ASSOC);
    
    $stmtlogin = $pdo->prepare("SELECT email, id FROM ticketlogin WHERE id = :account_id");
    $stmtlogin->bindParam(':account_id', $resultticket['account_id']);
    $stmtlogin->execute();
    
    $resultlogin = $stmtlogin->fetch(PDO::FETCH_ASSOC);
    
    if ($resultticket) {
        // QR code found in database
        echo json_encode([
            'exists' => true,
            'email' => $resultlogin['email'],
            'account_id' => $resultlogin['id'],
            'id' => $resultticket['id']
        ]);
    } else {
        // QR code not found
        echo json_encode([
            'exists' => false
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
?>