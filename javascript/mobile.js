function displayDevices(devices) {
    const deviceList = document.getElementById('deviceList');
    deviceList.innerHTML = '';  

    devices.forEach(device => {
        const card = document.createElement('div');
        card.className = 'device-card';

        // Star rating setup
        const fullStars = Math.floor(device.rating);
        const halfStar = device.rating % 1 >= 0.5 ? 1 : 0;
        const emptyStars = 5 - fullStars - halfStar;
        const stars = '★'.repeat(fullStars) + '½'.repeat(halfStar) + '☆'.repeat(emptyStars);

        // Default/fallback display size and image path handling
        const displayInfo = device.display_size ? `${device.display_size} inches` : "Not Available";
        const imagePath = device.image_path || 'path/to/default-image.jpg';

        card.innerHTML = `
            <div class="device-image">
                <img src="${imagePath}" alt="${device.brand} ${device.model} Image" onerror="this.onerror=null;this.src='path/to/default-image.jpg';">
            </div>
            <div class="device-info">
                <h3>${device.brand} ${device.model}</h3>
                <p><strong>Price:</strong> $${device.price}</p>
                <p><strong>Display:</strong> ${displayInfo}</p>
                <p><strong>Camera:</strong> ${device.camera} MP</p>
                <p><strong>Battery:</strong> ${device.battery} mAh</p>
                <p><strong>Operating System:</strong> ${device.os}</p>
                <p><strong>Rating:</strong> <span class="stars">${stars}</span></p>
            </div>
        `;
        deviceList.appendChild(card);
    });
}

function toggleFilterMenu() {
    const filterMenu = document.querySelector('.filter-menu');
    const mainContent = document.querySelector('main');

    filterMenu.classList.toggle('active');
    mainContent.classList.toggle('shifted');
}

function filterDevices() {
    const searchQuery = document.getElementById('searchBar').value.trim();
    const brand = document.getElementById('brandFilter').value;
    const price = document.getElementById('priceFilter').value;
    const battery = document.getElementById('batteryFilter').value;
    const os = document.getElementById('osFilter').value;
    const display = document.getElementById('displayFilter').value;
    const rating = document.getElementById('starFilter').value;
    const camera = document.getElementById('cameraFilter').value;

    const queryString = new URLSearchParams({
        search: searchQuery,
        brand: brand,
        price: price,
        battery: battery,
        os: os,
        display: display,
        rating: rating,
        camera: camera
    }).toString();

    fetch('filter_devices.php?' + queryString)
        .then(response => response.json())
        .then(data => {
            const deviceList = document.getElementById('deviceList');
            deviceList.innerHTML = ''; 

            if (data.length === 0) {
                deviceList.innerHTML = '<p>No devices found matching the criteria.</p>';
            } else {
                displayDevices(data); 
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

document.addEventListener('DOMContentLoaded', () => {
    fetch('filter_devices.php')  // 
        .then(response => response.json())
        .then(data => {
            displayDevices(data); 
        })
        .catch(error => console.error('Error loading devices:', error));
});
