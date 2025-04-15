<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Info</title>
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
         <button class="menu-btn" onclick="toggleMenu()">☰</button>
   
   <div class="menu" id="sidebar">
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
            <label for="first_name">Voornaam:</label><br>
            <input type="text" id="first_name" name="first_name" class="input" required><br>

            <label for="last_name">Achternaam:</label><br>
            <input type="text" id="last_name" name="last_name" class="input" required><br>

            <label>Geboortedatum (DD-MM-JJJJ):</label><br>
            <div class="date-of-birth-container" style="display: flex; gap: 5px;">
                <!-- Day dropdown (DD) -->
                <select name="day" id="day" class="input date-input" required style="width: 80px;">
                    <option value="">Dag</option>
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>">
                            <?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <!-- Month dropdown (MM) -->
                <select name="month" id="month" class="input date-input" required style="width: 120px;">
                    <option value="">Maand</option>
                    <?php 
                    $months = ["Januari", "Februari", "Maart", "April", "Mei", "Juni", 
                              "Juli", "Augustus", "September", "Oktober", "November", "December"];
                    foreach ($months as $index => $month): 
                        $monthNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    ?>
                        <option value="<?= $monthNumber ?>"><?= $month ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Year dropdown (YYYY) -->
                <select name="year" id="year" class="input date-input" required style="width: 100px;">
                    <option value="">Jaar</option>
                    <?php 
                    $currentYear = date("Y");
                    for ($i = $currentYear; $i >= 1900; $i--): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div><br>

            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" class="input" required><br>

            <label for="phone_number">Telefoonnummer:</label><br>
            <input type="text" id="phone_number" name="phone_number" class="input" required><br>

            <label for="address">Adres:</label><br>
            <input type="text" id="address" name="address" class="input" required><br>

            <label for="bsn">BSN:</label><br>
            <input type="text" id="bsn" name="bsn" class="input" required><br>

            <input type="hidden" name="qr_code_data">

            <input type="submit" id="submit_knop" value="Versturen" class="input">
            <input type="reset" id="reset_knop" value="Leegmaken" class="input">
        </form>
    </div>

    <div id="qrcode"></div>
    

    <script src="/ticket_challange/js/ticket.js"></script>


</body>
</html>
