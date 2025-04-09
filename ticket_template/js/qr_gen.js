fetch('php/db_read_ticket.php')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error(data.error); // Log error if no data is found
        } else {
            // Declare variable for QR Code element by ID
            const qrContainer = document.getElementById("qrcode");

            // Let library create and manage the canvas
            QRCode.toCanvas(data.qr, {       // Start de QR-code generatie
                width: 249,                     // Breedte
                height: 249                     // Hoogte
            }, function (error, canvas) {     // Voltooiings-callback
                // De callback ontvangt twee parameters:
                // error - als er iets misging tijdens generatie
                // canvas - het gegenereerde canvas element met de QR-code
            
                if (error) console.error(error); // Foutafhandeling en logt eventuele fouten naar de console
                qrContainer.appendChild(canvas); // Bij succes, voeg het canvas toe aan onze container
            }); // Canvas is een <canvas> DOM-element met de visuele QR-code
        }
    })
    .catch(error => console.error('Error fetching data:', error));