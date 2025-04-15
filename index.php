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
    <link rel="stylesheet" href="./index.css">
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
    <div class="header">Spik & Span Tickets
    <?php
    if (isset($_SESSION['email'])) {
        echo '<div class="top-right">Ingelogd als ' . htmlspecialchars($_SESSION['email']) . '</div>';
    }
    ?>
        <!-- <button class="menu-btn" onclick="toggleMenu()">☰</button> -->
   
        <div class="menu" id="sidebar">
            <?php if (isset($_SESSION['email'])): ?>
                <a href="logout.php" class="menu-logout">Uitloggen</a>
            <?php else: ?>
                <a href="login.php" class="menu-login">Inloggen</a>
            <?php endif; ?>
            <a href="#" class="menu-contact">Contact</a>
            <div class="language-selector">
                <select id="language-select">
                    <option value="nl">Nederlands</option>
                    <option value="en">English</option>
                    <option value="fr">Français</option>
                    <option value="li">Limburgs</option>
                </select>
            </div>
        </div>
    
        <div class="overlay" id="overlay" onclick="toggleMenu()"></div>
    </div>



    <div style="margin-top: 15px"; id="ticket-site-form">
        <form action="db_send.php" method="post">
            <label for="first_name" >Voornaam:</label><br>
            <input type="text" id="first_name" name="first_name" class="input"><br>

            <label for="last_name" >Achternaam:</label><br>
            <input type="text" id="last_name" name="last_name" class="input"><br>

            <label for="date_of_birth" >Geboortedatum:</label><br>
            <input type="text" id="date_of_birth" name="date_of_birth" class="input"><br>

            <label for="email" >Email:</label><br>
            <input type="text" id="email" name="email" class="input"><br>

            <label for="phone_number" >Telefoonnummer:</label><br>
            <input type="text" id="phone_number" name="phone_number" class="input"><br>

            <label for="adres" >Adres:</label><br>
            <input type="text" id="adres" name="adres" class="input"><br>

            <label for="bsn" >BSN:</label><br>
            <input type="text" id="bsn" name="bsn" class="input"><br>

            <input type="hidden" name="qr_code_data">

            

            
            <input type="submit" id="submit_knop" value="Versturen" class="input">
            <input type="reset" id="reset_knop" value="Leegmaken" class="input">
          </form>
    </div>
    <!--<button onclick="generateQR()" style="margin-top: 15px">Geef ons geld! (grapje is gratis)</button>-->

    <div id="qrcode"></div>
    
<!-- https://chat.deepseek.com/a/chat/s/72e4341b-41c6-4458-b12c-6eac69ced6ad -->
    
<?php include "db_send.php"?>
    
</body>
</html>
