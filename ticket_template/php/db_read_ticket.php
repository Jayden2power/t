<?php
$host = 'localhost';
$user = 'root';
$pass = 'root';
$dbname = 'test';
$tbname = 'tickettest';

try {
    $conn = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Temporary solution. Will be replaced once login is complete
$account_id = 2;
$ticket_id = 3;

$sql = "SELECT id, qr, firstname, lastname, date_of_birth, email, telnum, address, bsn, date_of_issue, account_id FROM $tbname WHERE id='$ticket_id' AND account_id='$account_id'";
$stmt = $conn->query($sql);

// Fetch the row as an associative array
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Randomly select one entry from the fetched rows
if (!empty($row)) {
    header('Content-Type: application/json');
    echo json_encode($row); // Return the selected row as JSON
} else {
    echo json_encode(["error" => "No data found in the table."]);
}
?>