<?php

session_start();

$host = 'localhost';
$user = 'root';
$pass = 'password';
$dbname = 'db_ticketsite';
$tbname = 'tb_tickets';

try {
    $conn = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = session_id(); // Or another unique ID (e.g., from login).
}
$account_id = $_SESSION['user_id']; // Now safe to use.


$sql = "SELECT id, qr, firstname, lastname, date_of_birth, email, phone_number, address, bsn, date_of_issue, account_id FROM $tbname WHERE account_id='$account_id'";
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