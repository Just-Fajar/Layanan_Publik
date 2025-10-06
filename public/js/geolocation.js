const TARGET_LATITUDE = -7.6844691;
const TARGET_LONGITUDE = 111.4671122;
const MAX_DISTANCE_KM = 0.1; // 100 meters radius

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Earth's radius in kilometers
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = 
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
        Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c; // Distance in kilometers
}

function checkLocation() {
    return new Promise((resolve, reject) => {
        if (!navigator.geolocation) {
            reject('Geolocation is not supported by your browser');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const distance = calculateDistance(
                    position.coords.latitude,
                    position.coords.longitude,
                    TARGET_LATITUDE,
                    TARGET_LONGITUDE
                );

                const locationData = {
                    currentLatitude: position.coords.latitude,
                    currentLongitude: position.coords.longitude,
                    distance: distance,
                    isWithinRange: distance <= MAX_DISTANCE_KM
                };

                resolve(locationData);
            },
            (error) => {
                reject('Error getting location: ' + error.message);
            }
        );
    });
}

// Function to update UI based on location check
function updateLocationStatus(locationData) {
    const statusElement = document.getElementById('location-status');
    const submitButton = document.querySelector('button[type="submit"]');
    const locationFields = document.getElementById('location-fields');

    if (locationData.isWithinRange) {
        statusElement.innerHTML = '<div class="alert alert-success">Anda berada dalam area yang diizinkan, silahkan isi buku tamu</div>';
        submitButton.disabled = false;
        
        // Update hidden fields with location data
        document.getElementById('latitude').value = locationData.currentLatitude;
        document.getElementById('longitude').value = locationData.currentLongitude;
    } else {
        statusElement.innerHTML = '<div class="alert alert-danger">Maaf, Anda berada di luar area yang diizinkan. Silahkan datang ke lokasi untuk mengisi buku tamu.</div>';
        submitButton.disabled = true;
    }
}

// Initial location check when page loads
document.addEventListener('DOMContentLoaded', function() {
    checkLocation()
        .then(updateLocationStatus)
        .catch(error => {
            document.getElementById('location-status').innerHTML = 
                `<div class="alert alert-warning">${error}</div>`;
        });
});