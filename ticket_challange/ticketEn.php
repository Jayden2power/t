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
    <div class="header">Spick & Span Tickets
    <?php
    if (isset($_SESSION['email'])) {
        echo '<div class="top-right">Logged in as ' . htmlspecialchars($_SESSION['email']) . '</div>';
    }
    ?>
        <button class="menu-btn" onclick="toggleMenu()">☰</button>
   
        <div class="menu" id="sidebar">
            <?php if (isset($_SESSION['email'])): ?>
                <a href="logout.php">Log out</a>
            <?php else: ?>
                <a href="login.php">Log in</a>
            <?php endif; ?>
            <a href="ticket.php">Translate</a>
            <a href="#">Contact</a>
        </div>
    
        <div class="overlay" id="overlay" onclick="toggleMenu()"></div>
    </div>

    <div class="banner">
        <p>The champions of the night!</p>
        <h1>Order your ticktets now!</h1>
    </div>
    
    <div class="main-container">
              <div class="ticket-box left-ticket">
            <div class="ticket-header">
                <h2>Adults</h2>
                <div class="price">€29,99</div>
            </div>
            <div class="ticket-details">
                <ul>
                <li>✔ Access to all zones</li>
                <li>✔ Access to the dance floor</li>
                <li>✔ Basic facilities</li>
                <li>✔ Live performances</li>
                </ul>
            </div>
            <button class="order-btn">Order now</button>
        </div>

      
        <div class="featured-image-container">
            <div class="featured-ticket">
                <div class="featured-text"></div>
            </div>
        </div>

        
        <div class="ticket-box right-ticket">
            <div class="ticket-header">
                <h2>Minors(16 or younger)</h2>
                <div class="price">€19,99</div>
            </div>
            <div class="ticket-details">
                <ul>
                <li>✔ Access to all zones</li>
                <li>✔ Access to the dance floor</li>
                <li>✔ Basic facilities</li>
                <li>✔ Live performances</li>
                </ul>
            </div>
            <button class="order-btn">
                <a href="#">Order now</a>
            </button>
        </div>
    </div>

    <script src="js/ticket.js"></script>
</body>
</html>