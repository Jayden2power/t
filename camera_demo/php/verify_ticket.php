<?php
header('Content-Type: application/json');

// Database configuration
$host = 'localhost';
$dbname = 'db_ticketsite';
$username = 'root';
$password = 'password';

// Configurable expiration period (in days)
$expirationDays = 7;

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $qrCode = $data['qr_code'] ?? null;

    if (!$qrCode) {
        throw new Exception('No QR code data provided');
    }

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch ticket including date_of_issue
    $stmtticket = $pdo->prepare("SELECT account_id, id, already_scanned, date_of_issue, date_of_scan FROM tb_tickets WHERE qr = :qr_code");
    $stmtticket->bindParam(':qr_code', $qrCode);
    $stmtticket->execute();

    $resultticket = $stmtticket->fetch(PDO::FETCH_ASSOC);

    // Check if already scanned
    if ($resultticket['already_scanned']) {
        echo json_encode([
            'exists' => true,
            'already_scanned' => true
        ]);
        exit;
    }

    if ($resultticket) {
        // Check if ticket is expired
        $dateOfIssueStr = $resultticket['date_of_issue'];
        $dateParts = explode('-', $dateOfIssueStr);
        
        if (count($dateParts) !== 3) {
            throw new Exception("Invalid date format in database (expected DD-MM-YYYY)");
        }
    
        $day = $dateParts[0];
        $month = $dateParts[1];
        $year = $dateParts[2];
        
        // Create DateTime object (format: YYYY-MM-DD)
        $dateOfIssue = DateTime::createFromFormat('Y-m-d', "$year-$month-$day");
        
        if (!$dateOfIssue) {
            throw new Exception("Failed to parse ticket issue date");
        }
    
        $currentDate = new DateTime();
        $formattedDate = $currentDate->format('d-m-Y'); // Format first
        $interval = $dateOfIssue->diff($currentDate);
        $daysSinceIssue = $interval->days;
    
        if ($daysSinceIssue > $expirationDays) {
            $updateStmt = $pdo->prepare("UPDATE tb_tickets SET date_of_scan = '$formattedDate', already_scanned = 1 WHERE id = :id");
            $updateStmt->bindParam(':id', $resultticket['id']);
            $updateStmt->execute();
            echo json_encode([
                'exists' => true,
                'expired' => true,
                'date_of_issue' => $dateOfIssueStr // Return original string
            ]);
            exit;
        }
        
        $updateStmt = $pdo->prepare("UPDATE tb_tickets SET date_of_scan = '$formattedDate', already_scanned = 1 WHERE id = :id");
        $updateStmt->bindParam(':id', $resultticket['id']);
        $updateStmt->execute();
        
        $stmtlogin = $pdo->prepare("SELECT email, id FROM tb_login WHERE id = :account_id");
        $stmtlogin->bindParam(':account_id', $resultticket['account_id']);
        $stmtlogin->execute();
        
        $resultlogin = $stmtlogin->fetch(PDO::FETCH_ASSOC);
        
        // Valid ticket
        echo json_encode([
            'exists' => true,
            'already_scanned' => false,
            'expired' => false,
            'email' => $resultlogin['email'],
            'account_id' => $resultlogin['id'],
            'id' => $resultticket['id'],
            'date_of_issue' => $resultticket['date_of_issue']
        ]);
    } else {
        // Ticket not found
        echo json_encode(['exists' => false]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>