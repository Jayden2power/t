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
            <a href="#" class="menu-translate">English</a> <!-- Nieuwe vertaalknop -->
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
                    <li>✔ basis faciliteiten</li>
                    <li>✔ Live optredens</li>
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
                <h2 class="ticket-title">Kinderen(16 of jonger)</h2>
                <div class="price">€19,99</div>
            </div>
            <div class="ticket-details">
                <ul>
                    <li>✔ Toegang tot hoofdzone</li>
                    <li>✔ Toegang tot dansvloer</li>
                    <li>✔ Basis faciliteiten</li>
                    <li>✔ Live optredens</li>
                </ul>
            </div>
            <button class="order-btn">Bestel nu</button>
        </div>
    </div>

    <script src="js/ticket.js"></script>
    <script>
        // Vertaal functie
        document.querySelector('.menu-translate').addEventListener('click', function(e) {
            e.preventDefault();
           
            // Controleer of de pagina al in het Engels is
            const isEnglish = document.documentElement.lang === 'en';
            const elementsToTranslate = document.querySelectorAll(
                '.banner-text, .main-heading, .menu-logout, .menu-login, .menu-contact, ' +
                '.ticket-title, .ticket-details li, .order-btn'
            );
           
            if (!isEnglish) {
                // Vertaal naar Engels
                document.documentElement.lang = 'en';
                this.textContent = 'Nederlands';
               
                // Vertaal alle elementen
                elementsToTranslate.forEach(element => {
                    const originalText = element.textContent;
                    console.log(elementsToTranslate)
                   
                    // Eenvoudige vertalingen - in een echte app zou je een vertaalbestand gebruiken
                    if (element.classList.contains('banner-text')) {
                        element.textContent = 'The champions of the night!';
                    } else if (element.classList.contains('main-heading')) {
                        element.textContent = 'Order your tickets now!';
                    } else if (element.classList.contains('menu-logout')) {
                        element.textContent = 'Logout';
                    } else if (element.classList.contains('menu-login')) {
                        element.textContent = 'Login';
                    } else if (element.classList.contains('menu-contact')) {
                        element.textContent = 'Contact';
                    } else if (element.classList.contains('ticket-title')) {
                        if (originalText.includes('Volwassenen')) {
                            element.textContent = 'Adults';
                        } else if (originalText.includes('Kinderen')) {
                            element.textContent = 'Children (16 or younger)';
                        }
                    } else if (element.classList.contains('order-btn')) {
                        element.textContent = 'Order now';
                    } else if (element.textContent.includes('Toegang tot alle zones')) {
                        element.textContent = '✔ Access to all zones';
                    } else if (element.textContent.includes('Toegang tot dansvloer')) {
                        element.textContent = '✔ Access to dance floor';
                    } else if (element.textContent.includes('basis faciliteiten')) {
                        element.textContent = '✔ Basic facilities';
                    } else if (element.textContent.includes('Live optredens')) {
                        element.textContent = '✔ Live performances';
                    } else if (element.textContent.includes('Toegang tot hoofdzone')) {
                        element.textContent = '✔ Access to main zone';
                    }
                });
               
                // Ingelogd tekst aanpassen
                const loggedInText = document.querySelector('.top-right');
                if (loggedInText && loggedInText.textContent.includes('Ingelogd als')) {
                    loggedInText.textContent = loggedInText.textContent.replace('Ingelogd als', 'Logged in as');
                }
            } else {
                // Terug naar Nederlands
                document.documentElement.lang = 'nl';
                this.textContent = 'English';
               
                // Vertaal alle elementen terug
                elementsToTranslate.forEach(element => {
                    const originalText = element.textContent;
                   
                    if (element.classList.contains('banner-text')) {
                        element.textContent = 'De kampioenen van de nacht!';
                    } else if (element.classList.contains('main-heading')) {
                        element.textContent = 'Bestel nu jouw tickets!';
                    } else if (element.classList.contains('menu-logout')) {
                        element.textContent = 'Uitloggen';
                    } else if (element.classList.contains('menu-login')) {
                        element.textContent = 'Inloggen';
                    } else if (element.classList.contains('menu-contact')) {
                        element.textContent = 'Contact';
                    } else if (element.classList.contains('ticket-title')) {
                        if (originalText.includes('Adults')) {
                            element.textContent = 'Volwassenen';
                        } else if (originalText.includes('Children')) {
                            element.textContent = 'Kinderen(16 of jonger)';
                        }
                    } else if (element.classList.contains('order-btn')) {
                        element.textContent = 'Bestel nu';
                    } else if (element.textContent.includes('Access to all zones')) {
                        element.textContent = '✔ Toegang tot alle zones';
                    } else if (element.textContent.includes('Access to dance floor')) {
                        element.textContent = '✔ Toegang tot dansvloer';
                    } else if (element.textContent.includes('Basic facilities')) {
                        element.textContent = '✔ basis faciliteiten';
                    } else if (element.textContent.includes('Live performances')) {
                        element.textContent = '✔ Live optredens';
                    } else if (element.textContent.includes('Access to main zone')) {
                        element.textContent = '✔ Toegang tot hoofdzone';
                    }
                });
               
                // Ingelogd tekst aanpassen
                const loggedInText = document.querySelector('.top-right');
                if (loggedInText && loggedInText.textContent.includes('Logged in as')) {
                    loggedInText.textContent = loggedInText.textContent.replace('Logged in as', 'Ingelogd als');
                }
            }
        });
    </script>
</body>
</html>