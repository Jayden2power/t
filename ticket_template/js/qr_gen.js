const randomData = [...'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'].sort(() => Math.random() - 0.5).slice(0, 62).join('');

// Declare variable for QR Code element by ID
const qrContainer = document.getElementById("qrcode");
    
// Let library create and manage the canvas
QRCode.toCanvas(randomData, {       // Start de QR-code generatie
    width: 249,                     // Breedte
    height: 249                     // Hoogte
}, function (error, canvas) {     // Voltooiings-callback
    // De callback ontvangt twee parameters:
    // error - als er iets misging tijdens generatie
    // canvas - het gegenereerde canvas element met de QR-code

    if (error) console.error(error); // Foutafhandeling en logt eventuele fouten naar de console
    qrContainer.appendChild(canvas); // Bij succes, voeg het canvas toe aan onze container
}); // Canvas is een <canvas> DOM-element met de visuele QR-code