<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spik & Span Tickets</title>
    <link rel="stylesheet" href="css/mede.css">
</head>
<body>

    <div class="header">
        Spik & Span Tickets

        <?php if (isset($_SESSION['email'])): ?>
            <div class="top-right">Jouw medewerker mail is <?= htmlspecialchars($_SESSION['email']); ?></div>
        <?php endif; ?>

        
        <button class="menu-btn" onclick="toggleMenu()">☰</button>

       
        <div class="menu" id="sidebar">
            <?php if (isset($_SESSION['email'])): ?>
                <form action="logout.php" method="post" style="display:inline;">
                    <button type="submit" class="logout-btn">Uitloggen</button>
                </form>
            <?php endif; ?>
            
        </div>

        <div class="overlay" id="overlay" onclick="toggleMenu()"></div>
    </div>

    <div class="banner">
        <p class="banner-text">Zie alle statistieken van de tickets.</p>
        <h1 class="main-heading">Scan tickets!</h1>
    </div>
    
    <div class="main-container">
        <div class="ticket-box left-ticket">
            <div class="ticket-header">
                <h2 class="ticket-title">Volwassenen</h2>
                <div class="price"></div>
            </div>
            <div class="ticket-details">
                <ul>
                    <li>✔ Toegang tot alle zones</li>
                    <li>✔ Toegang tot dansvloer</li>
                    <li>✔ Basis faciliteiten</li>
                    <li>✔ Live optredens</li>
                </ul>
            </div>
            <button class="order-btn">Scan nu</button>
        </div>

        <div class="featured-image-container">
            <div class="featured-ticket">
                <div class="featured-text"></div>
            </div>
        </div>

        <div class="ticket-box right-ticket">
            <div class="ticket-header">
                <h2 class="ticket-title">Kinderen (16 of jonger)</h2>
                <div class="price"></div>
            </div>
            <div class="ticket-details">
                <ul>
                    <li>✔ Toegang tot hoofdzone</li>
                    <li>✔ Toegang tot dansvloer</li>
                    <li>✔ Basis faciliteiten</li>
                    <li>✔ Live optredens</li>
                </ul>
            </div>
            <button class="order-btn">Scan nu</button>
        </div>
    </div>

    <script>
        function toggleMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    </script>
</body>
</html>