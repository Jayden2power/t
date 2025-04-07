
    //Functie maken
    function generateQR() {

        const randomData = 
        Math.random().toString(36).substring(0,4) +
        Math.random().toString(36).substring(2,24) +
        Math.random().toString(36).substring(2,24) +
        Math.random().toString(36).substring(2,24) +
        Math.random().toString(36).substring(2,24);
        // //Maakt een random data entry:
        // //math.random = random floating generator between 0 and 1 (example: 0.1234567890123456)
        // //tostring converts the number to a base-36, using digits 0-9 and letters a-z
        // //substring takes a portion of the string, starting at index 2(skipping 0) and ending before 10
        // //Gives us an 8 character random portion (example: "4fzyo82m)



        // //Clear previous QR
        const qrContainer = document.getElementById("qrcode");
        qrContainer.innerHTML= "";
    
    // Let library create and manage the canvas
    QRCode.toCanvas(randomData, {       //Start de QR-code generatie
        width: 256,                     //Breedte
        height: 256                     //Hoogte
    }, function (error, canvas) {     //Voltooiings-callback
        // De callback ontvangt twee parameters:
        // error - als er iets misging tijdens generatie
        // canvas - het gegenereerde canvas element met de QR-code
        
        if (error) console.error(error); //Foutafhandeling en logt eventuele fouten naar de console
        qrContainer.appendChild(canvas); //Bij succes, voeg het canvas toe aan onze container

        saveQRData(randomData);
    
    
    console.log(randomData);
    }); //Canvas is een <canvas> DOM-element met de visuele QR-code
}


// Function to save QR data to database
function saveQRData(qrData) {
    fetch('/qr_code/php/save_qr.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `qr_data=${encodeURIComponent(qrData)}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        console.log('Success:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


    //Deepseek adventure: 
    // https://chat.deepseek.com/a/chat/s/d7cce399-ac11-4326-a268-7ad70a43ca4d



