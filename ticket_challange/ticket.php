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
<<<<<<< Updated upstream
            <div class="language-selector">
                <select id="language-select">
                    <option value="nl">Nederlands</option>
                    <option value="en">English</option>
                    <option value="fr">Français</option>
                    <option value="li">Limburgs</option>
                </select>
            </div>
=======
            <a href="#" class="menu-translate">English</a> 
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
                <div class="price">€49,99</div>
=======
                <div class="price">€19,99</div>
>>>>>>> Stashed changes
            </div>
            <div class="ticket-details">
                <ul>
                    <li>✔ Toegang tot hoofdzone</li>
                    <li>✔ Toegang tot dansvloer</li>
                    <li>✔ Basis faciliteiten</li>
                    <li>✔ Live optredens</li>
                </ul>
            </div>
<<<<<<< Updated upstream
            <a href="../index.php" class="order-btn">Bestel nu</a>
=======
            <button class="order-btn">Bestel nu</button>
>>>>>>> Stashed changes
        </div>
    </div>

    <script src="js/ticket.js"></script>
<<<<<<< Updated upstream
    <script src="js/vertalen.js"></script>
=======
    <script>
        // Globale variabele voor vertalingen
        let translations = {};
        
        // Laad de vertalingen
        fetch('translations.json/lang.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                translations = data.translations;
                console.log('Translations loaded successfully');
                
                // Initialiseer de vertaalfunctie nadat de vertalingen zijn geladen
                initTranslation();
            })
            .catch(error => {
                console.error('Error loading translations:', error);
            });

        function initTranslation() {
            // Vertaal functie
            document.querySelector('.menu-translate').addEventListener('click', function(e) {
                e.preventDefault();
                
                // Bepaal de huidige en volgende taal
                const currentLang = document.documentElement.lang;
                let nextLang;
                
                switch(currentLang) {
                    case 'nl': nextLang = 'en'; break;
                    case 'en': nextLang = 'li'; break;
                    case 'li': nextLang = 'nl'; break;
                    default: nextLang = 'en';
                }
                
                // Pas de taal van de pagina aan
                document.documentElement.lang = nextLang;
                
                // Update de vertaalknop tekst
                this.textContent = translations[nextLang].menu.translate;
                
                // Vertaal alle elementen
                translatePage(nextLang);
            });
        }

        function translatePage(lang) {
            const langData = translations[lang];
            
            if (!langData) {
                console.error('Language data not found for:', lang);
                return;
            }
            
            // Titel
            document.title = langData.site_title;
            
            // Ingelogd tekst
            const loggedInText = document.querySelector('.top-right');
            if (loggedInText) {
                const email = loggedInText.textContent.split(' ').pop();
                loggedInText.textContent = `${langData.logged_in_as} ${email}`;
            }
            
            // Menu items
            const logoutBtn = document.querySelector('.menu-logout');
            if (logoutBtn) logoutBtn.textContent = langData.menu.logout;
            
            const loginBtn = document.querySelector('.menu-login');
            if (loginBtn) loginBtn.textContent = langData.menu.login;
            
            document.querySelector('.menu-contact').textContent = langData.menu.contact;
            
            // Banner
            document.querySelector('.banner-text').textContent = langData.banner.text;
            document.querySelector('.main-heading').textContent = langData.banner.heading;
            
            // Tickets - Volwassenen
            const adultTicket = document.querySelector('.left-ticket');
            if (adultTicket) {
                adultTicket.querySelector('.ticket-title').textContent = langData.tickets.adults.title;
                adultTicket.querySelector('.order-btn').textContent = langData.tickets.adults.button;
                
                const adultFeatures = adultTicket.querySelectorAll('.ticket-details li');
                langData.tickets.adults.features.forEach((feature, i) => {
                    if (adultFeatures[i]) adultFeatures[i].textContent = feature;
                });
            }
            
            // Tickets - Kinderen
            const childTicket = document.querySelector('.right-ticket');
            if (childTicket) {
                childTicket.querySelector('.ticket-title').textContent = langData.tickets.children.title;
                childTicket.querySelector('.order-btn').textContent = langData.tickets.children.button;
                
                const childFeatures = childTicket.querySelectorAll('.ticket-details li');
                langData.tickets.children.features.forEach((feature, i) => {
                    if (childFeatures[i]) childFeatures[i].textContent = feature;
                });
            }
        }
    </script>
>>>>>>> Stashed changes
</body>
</html>