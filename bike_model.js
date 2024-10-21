// // Existing code for changing colorsfunction viewDetails(bikeId) {
//     window.location.href = `display_details.html?id=${bikeId}`;


function changeColor(bikeId, imagePath) {
    const bikeImage = document.getElementById(bikeId);
    bikeImage.src = imagePath;
}

document.addEventListener('DOMContentLoaded', () => {
    // Add event listeners for color change buttons
    const colorBalls = document.querySelectorAll('.color-ball');
    colorBalls.forEach(ball => {
        ball.addEventListener('click', (event) => {
            const bikeId = event.target.parentElement.parentElement.id; // Get bike ID from the card
            changeColor(bikeId, event.target.style.backgroundColor); // Change color based on the selected color
        });
    });

    // Add event listeners for the "View" buttons
    const viewButtons = document.querySelectorAll('.view-button');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const bikeId = event.target.getAttribute('data-id');
            // Redirect to details page with bike ID as a query parameter
            window.location.href = `display_details.html?id=${bikeId}`;
        });
    });
});
