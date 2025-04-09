<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <!-- Include QR code library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
    <!-- Include your JavaScript file -->
    <script src="./qr_code/js/script.js" defer></script>
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


    <div style="margin-top: 15px"; id="gastenboek">
        <form action="db_send.php" method="post">
            <label for="first_name" style="color:black">Voornaam:</label><br>
            <input type="text" id="first_name" name="first_name"><br>

            <label for="last_name" style="color:black">Achternaam:</label><br>
            <input type="text" id="last_name" name="last_name"><br>

            <label for="date_of_birth" style="color:black">Geboortedatum:</label><br>
            <input type="text" id="date_of_birth" name="date_of_birth"><br>

            <label for="email" style="color:black">Email:</label><br>
            <input type="text" id="email" name="email"><br>

            <label for="phone_number" style="color:black">Telefoonnummer:</label><br>
            <input type="text" id="phone_number" name="phone_number"><br>

            <label for="adres" style="color:black">Adres:</label><br>
            <input type="text" id="adres" name="adres"><br>

            <label for="bsn" style="color:black">BSN:</label><br>
            <input type="text" id="bsn" name="bsn"><br>

            <input type="hidden" name="qr_code_data">

            

            
            <input type="submit" id="submit_knop" value="Versturen">
            <input type="reset" id="reset_knop" value="Leegmaken">
          </form>
    </div>
    <!--<button onclick="generateQR()" style="margin-top: 15px">Geef ons geld! (grapje is gratis)</button>-->

    <div id="qrcode"></div>
    
<!-- https://chat.deepseek.com/a/chat/s/72e4341b-41c6-4458-b12c-6eac69ced6ad -->
    
<?php include "db_send.php"?>
    
</body>
</html>
