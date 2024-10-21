document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const bikeId = params.get('id');

    fetch('details.json')
        .then(response => response.json())
        .then(data => {
            // Fetch the bikes array from the JSON data
            const bikeDetails = data.bikes.find(bike => bike.id === bikeId);

            if (bikeDetails) {
                // Set the bike name, price, and info
                document.getElementById('bike-name').textContent = bikeDetails.name;
                document.getElementById('bike-price').textContent = `Price: ${bikeDetails.price}`;
                document.getElementById('bike-info').textContent = bikeDetails.info;

                // Display the bike features
                const featuresList = document.getElementById('bike-features');
                featuresList.innerHTML = ''; // Clear previous features
                Object.entries(bikeDetails.features).forEach(([key, value]) => {
                    const li = document.createElement('li');
                    li.textContent = `${key}: ${value}`;
                    featuresList.appendChild(li);
                });

                // Display the 360-degree images
                const imageContainer = document.getElementById('bike-images');
                imageContainer.innerHTML = ''; // Clear previous images
                bikeDetails.images["360"].forEach(imagePath => {
                    const img = document.createElement('img');
                    img.src = imagePath;
                    img.alt = `${bikeDetails.name} 360° view`;
                    img.classList.add('bike-360-image');
                    imageContainer.appendChild(img);
                });
            } else {
                console.error('Bike details not found');
            }
        })
        .catch(error => console.error('Error fetching bike details:', error));
});
