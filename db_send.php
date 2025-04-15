<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = session_id(); // Or another unique ID (e.g., from login).
}
$account_id = $_SESSION['user_id']; // Now safe to use.

//Toont alle errors indien aanwezig
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Controleert of het formulier is verzonden, dan pas wordt de onderstaande code uitgevoerd
// Zonder dit gedeelte zou het overzicht.php meteen geladen worden doormiddel van de include 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Replace the old date_of_birth collection with the new dropdown handling
    $first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : '';
    $last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : '';
    
    // NEW CODE FOR DATE OF BIRTH - DD-MM-YYYY FORMAT
    $day = isset($_POST["day"]) ? $_POST["day"] : '';
    $month = isset($_POST["month"]) ? $_POST["month"] : '';
    $year = isset($_POST["year"]) ? $_POST["year"] : '';
    
    // Validate and combine the date components
    if (!empty($day) && !empty($month) && !empty($year)) {
        if (checkdate($month, $day, $year)) {
            // Format as DD-MM-YYYY with leading zeros
            $date_of_birth = sprintf("%02d-%02d-%04d", $day, $month, $year);
        } else {
            die("Ongeldige geboortedatum ingevoerd!");
        }
    } else {
        $date_of_birth = ''; // Or handle the empty case as you prefer
    }
    // END OF NEW DATE OF BIRTH CODE
    
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $phone_number = isset($_POST["phone_number"]) ? $_POST["phone_number"] : '';
    $address = isset($_POST["address"]) ? $_POST["address"] : '';
    $bsn = isset($_POST["bsn"]) ? $_POST["bsn"] : '';



// Bijv. $naam = $_POST["gast_naam"]; geeft array fout zodra je op de pagina komt
// Er wordt geprobeerd informatie op te halen die nog niet gegeven is


//Info van de DB om te connecten

$host = 'localhost';
$username = 'root'; 
$password = 'password';
$database = 'db_tickets'; 



//Connecten
$conn = new mysqli($host, $username, $password, $database);

// Als connectie error krijgt, show verbinding mislukt & de error
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
} else {

// Generate QR data
$qr_data = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 62);

// Prepare statement (excluding created_at - let DB handle it)
$statement = $conn->prepare("INSERT INTO qr_codes(qr_data, first_name, last_name, date_of_birth, email, phone_number, address, bsn, account_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind parameters - note phone_number and bsn are integers (i)
$statement->bind_param("sssssssii", 
    $qr_data,          // s (string)
    $first_name,       // s (string)
    $last_name,        // s (string)
    $date_of_birth,    // s (string)
    $email,            // s (string)
    $phone_number,     // s (integer)
    $address,          // s (string)
    $bsn,              // i (integer)
    $_SESSION['user_id'] // i (integer)
    
);

// Execute
if ($statement->execute()) {
    echo "Data saved successfully!";
} else {
    echo "Error: " . $statement->error;
}
    // Afsluiten
    $statement->close();
    $conn->close();

    // Doorverwijzen naar het overzicht met de berichten
    //header("Location: overzicht.php");
    exit();
}
}
?>






<!--
De informatie uit een php gecreeërde session ID halen, en dit omzetten in een account ID wat vervolgens in de database gestored word  -->