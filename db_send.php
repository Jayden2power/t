<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info verzender</title>
</head>
<body>
<?php

//Toont alle errors indien aanwezig
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Controleert of het formulier is verzonden, dan pas wordt de onderstaande code uitgevoerd
// Zonder dit gedeelte zou het overzicht.php meteen geladen worden doormiddel van de include 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : ''; // Zorgt ervoor dat er geen value opgehaald wordt als er geen is
$last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : '';
$date_of_birth = isset($_POST["date_of_birth"]) ? $_POST["date_of_birth"] : '';
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
$statement = $conn->prepare("INSERT INTO qr_codes(qr_data, first_name, last_name, date_of_birth, email, phone_number, address, bsn) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

// Bind parameters - note phone_number and bsn are integers (i)
$statement->bind_param("sssssiis", 
    $qr_data,          // s (string)
    $first_name,       // s (string)
    $last_name,        // s (string)
    $date_of_birth,    // s (string)
    $email,            // s (string)
    $phone_number,     // i (integer)
    $address,            // s (string)
    $bsn               // i (integer)
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