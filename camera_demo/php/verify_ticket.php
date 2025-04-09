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
    $stmt = $pdo->prepare("SELECT id, email, account_id FROM tickettest WHERE qr = :qr_code");
    $stmt->bindParam(':qr_code', $qrCode);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // QR code found in database
        echo json_encode([
            'exists' => true,
            'id' => $result['id'],
            'email' => $result['email'],
            'account_id' => $result['account_id']
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