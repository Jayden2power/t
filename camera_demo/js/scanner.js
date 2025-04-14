// Get DOM elements. Without these we would have to continuously query the DOM. This is both more elegant and faster, even if by a small margin.
const video = document.getElementById('video');
const scanButton = document.getElementById('scan-button');

// Canvas for capturing frames. This creates an invisible canvas for video frame analysis. JsQR requires specific image data, this is a preparation step to convert the camera's output to image data that the scanner can then use.
const canvas = document.createElement('canvas');
const canvasContext = canvas.getContext('2d');

// Variables to track scanning state. Very important to both prevent button spam and resource hogging by the machine.
let isScanning = false;
let animationFrameId = null;

// Check if browser supports camera access. Some browsers do not support this, and this function checks that first things first. The !! is an absolute boolean for browsers that return an indecisive answer.
function hasGetUserMedia() {
    return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
}

// Function to stop camera and scanning
function stopCamera() {
    // If the camera stream exists this check is passed
    if (video.srcObject) {
        const stream = video.srcObject;
        const tracks = stream.getTracks();
        // This stops only the camera which is handy if we ever for whatever reason want audio
        tracks.forEach(track => track.stop());
        // This detaches the stream from the video element which allows for garbage collection
        video.srcObject = null;
    }
    
    // If the animation frame ID is active this check passes
    if (animationFrameId) {
        // This cancels the animation and sets the loop to null
        cancelAnimationFrame(animationFrameId);
        animationFrameId = null;
    }
    
    // Set scan state to false. Very important for state syncing. 
    isScanning = false;
}

// Start the camera and scanner
async function startCamera() {
    try {
        // Checks if the camera is supported using the aforementioned function higher up. If it passes it throws an error and immediately stops execution
        if (!hasGetUserMedia()) {
            throw new Error('Your browser does not support camera access.');
        }
        
        // Request camera access. To activate the camera we first have to ask for access without any audio.
        const stream = await navigator.mediaDevices.getUserMedia({
            video: {
                // We set the camera to environment mode instead of selfie mode. Like this the user can see what the device sees and accurately aim at the QR code.
                facingMode: 'environment', // Prefer rear camera on mobile
            },
            // Here we set the usage of audio to false.
            audio: false
        });
        
        // Assigns the camera output (stream) to the video element
        video.srcObject = stream;
        // Next we wait until the video is avaiable to play. Without it the scanner might accidentally try to process blank frames.
        await video.play();
        
        // Update UI and sets the isScanning boolean to true. Like this we can continue and update the button's text and color so the user knows what is going on.
        isScanning = true;
        scanButton.textContent = 'TAP TO STOP SCANNING';
        scanButton.style.backgroundColor = 'rgb(255, 123, 0)';
        
        // Start QR code scanning.
        scanQRCode();
        
        return true;
    } catch (error) {
        // In case of an error, the loop is terminated and the error is logged.
        console.error('Error accessing camera:', error);
        // The error is shown via the show result function that allows us to also see it on the screen
        showResult(`Error: ${error.message}`, false);
        // Terminates the loop
        return false;
    }
}

// Function to verify QR code with PHP backend
async function verifyQRCode(qrData) {
    const response = await fetch('./php/verify_ticket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ qr_code: qrData })
    });
    
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    
    return await response.json();
}

// Function to scan for QR codes
function scanQRCode() {
    // First we make sure the device is actually ready for scanning and has the camera on. If not, this passes, saving us some resources and unnecessary frame analysis.
    if (!isScanning) return;
    
    // If the video has enough data to process, IE if the video is not actively showing a blank frame for example, this passes. It prevents unnecessary frame analysis as well.
    if (video.readyState === video.HAVE_ENOUGH_DATA) {
        // Set canvas dimensions to match video. Oddly important. Since this canvas is invisible, we need to make sure its synced with what the user sees. Without this the QR could unknowingly become distorted.
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Draw video frame to canvas. It copies the current video frame to the canvas to be processed into image data which QR scanners need.
        canvasContext.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Get image data from canvas. This now directly extracts the RGB data from the frame that is then fed to the actual scanner.
        const imageData = canvasContext.getImageData(0, 0, canvas.width, canvas.height);
        
        // Try to decode QR code. This now attempts to find a QR code within the provided image data, and if so provides the results.
        const code = jsQR(imageData.data, imageData.width, imageData.height, {
            // Like this we look for QR codes that are black on white, so a white background with black code.
            inversionAttempts: 'dontInvert',
        });
        
        // If QR code found. We stop the camera and show the results with the data that the jsQR gave us.
        if (code) {
            showResult(code.data, true);
            stopCamera();
            return;
        }
    }
    
    // Continue scanning. This just creates a scanning loop so it keeps scanning for stuff until either manually stopped or after finding something.
    animationFrameId = requestAnimationFrame(scanQRCode);
}

// Function to display results. Mostly just sets colors and text. Also displays either the data or whatever else was provided.
async function showResult(data, isSuccess) {
    if (isSuccess) {
        try {
            const response = await verifyQRCode(data);
            
            if (response.exists) {
                if (response.already_scanned) {
                    // Already scanned
                    scanButton.style.backgroundColor = 'rgb(255, 0, 0)';
                    scanButton.textContent = 'TAP TO SCAN AGAIN\n\nTICKET ALREADY SCANNED!';
                } else if (response.expired) {
                    // Ticket is expired
                    scanButton.style.backgroundColor = 'rgb(255, 0, 0)';
                    scanButton.textContent = `TAP TO SCAN AGAIN\n\nTICKET EXPIRED!\nISSUED ON: ${response.date_of_issue}`;
                } else {
                    // Valid ticket
                    scanButton.style.backgroundColor = 'rgb(75, 175, 78)';
                    scanButton.textContent = `TAP TO SCAN AGAIN\n\n\nTICKET VERIFIED UNDER\n\nEMAIL: ${response.email}\nACCOUNT ID: ${response.account_id}\nTICKET ID: ${response.id}\nISSUED ON: ${response.date_of_issue}`;
                }
            } else {
                // Not found
                scanButton.style.backgroundColor = 'rgb(255, 0, 0)';
                scanButton.textContent = 'TAP TO SCAN AGAIN\n\nTICKET NOT FOUND!';
            }
        } catch (error) {
            console.error('Error verifying QR code:', error);
            scanButton.style.backgroundColor = 'rgb(255, 0, 0)';
            scanButton.textContent = 'TAP TO SCAN AGAIN\n\nCOULD NOT VERIFY';
        }
    } else {
        // Error state
        scanButton.style.backgroundColor = 'rgb(255, 0, 0)';
        scanButton.textContent = `TAP TO SCAN AGAIN\n\n${data}`;
    }
}

// Event listener for the scan button (now acts as toggle)
scanButton.addEventListener('click', () => {
    if (isScanning) {
        stopCamera();
        scanButton.textContent = 'TAP TO START SCANNING';
    } else {
        startCamera();
    }
});