function adjustScale() {
    const scaler = document.getElementById('scaler');
    const container = document.getElementById('container');
    
    // Get the container's natural width/height
    const containerWidth = container.offsetWidth;
    const containerHeight = container.offsetHeight;
    
    // Get the viewport dimensions
    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;
    
    // Calculate the maximum scale that fits the screen
    const scaleX = viewportWidth / containerWidth; 
    const scaleY = viewportHeight / containerHeight;
    const scale = Math.min(scaleX, scaleY);
    
    // Apply the scale
    scaler.style.transform = `scale(${scale})`;
}

window.addEventListener('resize', adjustScale);
window.addEventListener('load', () => {
    // Add a small delay to ensure everything is ready
    setTimeout(adjustScale, 100);
});