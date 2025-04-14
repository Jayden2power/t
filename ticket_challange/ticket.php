<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spik & Span Tickets</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">Spik & Span Tickets
    <?php
    if (isset($_SESSION['email'])) {
        echo '<div class="top-right">Ingelogd als ' . htmlspecialchars($_SESSION['email']) . '</div>';
    }
    ?>
        <button class="menu-btn" onclick="toggleMenu()">☰</button>
   
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

    <div class="banner">
        <p class="banner-text">De kampioenen van de nacht!</p>
        <h1 class="main-heading">Bestel nu jouw tickets!</h1>
    </div>
    
    <div class="main-container">
        <div class="ticket-box left-ticket">
            <div class="ticket-header">
                <h2 class="ticket-title">Volwassenen</h2>
                <div class="price">€29,99</div>
            </div>
            <div class="ticket-details">
                <ul>
                    <li>✔ Toegang tot alle zones</li>
                    <li>✔ Toegang tot dansvloer</li>
                    <li>✔ Basis faciliteiten</li>
                    <li>✔ Live optredens</li>
                </ul>
            </div>
            <a href="../index.php" class="order-btn">Bestel nu</a>
        </div>

        <div class="featured-image-container">
            <div class="featured-ticket">
                <div class="featured-text"></div>
            </div>
        </div>

        <div class="ticket-box right-ticket">
            <div class="ticket-header">
                <h2 class="ticket-title">Kinderen(16 of jonger)</h2>
                <div class="price">€49,99</div>
            </div>
            <div class="ticket-details">
                <ul>
                    <li>✔ Toegang tot hoofdzone</li>
                    <li>✔ Toegang tot dansvloer</li>
                    <li>✔ Basis faciliteiten</li>
                    <li>✔ Live optredens</li>
                </ul>
            </div>
            <a href="../index.php" class="order-btn">Bestel nu</a>
        </div>
    </div>

    <script src="js/ticket.js"></script>
    <script src="js/vertalen.js"></script>
</body>
</html>