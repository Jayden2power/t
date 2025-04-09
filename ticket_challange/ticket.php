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
                <a href="logout.php">Uitloggen</a>
            <?php else: ?>
                <a href="login.php">Inloggen</a>
            <?php endif; ?>
            <a href="#">Contact</a>
        </div>
    
        <div class="overlay" id="overlay" onclick="toggleMenu()"></div>
    </div>

    <div class="banner">
        <p>De kampioenen van de nacht!</p>
        <h1>Bestel nu jouw tickets!</h1>
    </div>
    
    <div class="main-container">
              <div class="ticket-box left-ticket">
            <div class="ticket-header">
                <h2>Volwassenen</h2>
                <div class="price">€29,99</div>
            </div>
            <div class="ticket-details">
                <ul>
                    <li> Toegang tot alle zones</li>
                    <li> Toegang tot dansvloer</li>
                    <li> Basis faciliteiten</li>
                    <li> Live optredens</li>
                </ul>
            </div>
            <button class="order-btn">Bestel nu</button>
        </div>

      
        <div class="featured-image-container">
            <div class="featured-ticket">
                <div class="featured-text"></div>
            </div>
        </div>

        
        <div class="ticket-box right-ticket">
            <div class="ticket-header">
                <h2>Kinderen(16 of jonger)</h2>
                <div class="price">€49,99</div>
            </div>
            <div class="ticket-details">
                <ul>
                    <li> Toegang tot hoofdzone</li>
                    <li> Toegang tot dansvloer</li>
                    <li> Basis faciliteiten</li>
                    <li> Live optredens</li>
                </ul>
            </div>
            <button class="order-btn">
                <a href="#">Bestel nu</a>
            </button>
        </div>
    </div>

    <script src="js/ticket.js"></script>
</body>
</html>