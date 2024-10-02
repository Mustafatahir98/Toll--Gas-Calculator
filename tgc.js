function initialize() {
    var options = {
        types: ['geocode'], // More precise geocoding
        componentRestrictions: { country: 'us' }
    };

    var fromCityAutocomplete = new google.maps.places.Autocomplete(
        document.getElementById('fromCity'),
        options
    );

    var toCityAutocomplete = new google.maps.places.Autocomplete(
        document.getElementById('toCity'),
        options
    );
    fromCityAutocomplete.addListener('place_changed', function() {
        var place = fromCityAutocomplete.getPlace();
        if (!place.geometry) {
            alert("No details available for input: '" + place.name + "'");
            return;
        }
        updateMapboxRoute(place.geometry.location, 'from');
    });

    toCityAutocomplete.addListener('place_changed', function() {
        var place = toCityAutocomplete.getPlace();
        if (!place.geometry) {
            alert("No details available for input: '" + place.name + "'");
            return;
        }
        updateMapboxRoute(place.geometry.location, 'to');
    });
}
function initializeMapbox() {
    mapboxgl.accessToken = ''; // Use your actual Mapbox token
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-98.5795, 39.8283], // Center on the geographic center of the contiguous US
        zoom: 4
    });
    var directions = new MapboxDirections({
        accessToken: mapboxgl.accessToken,
        unit: 'imperial',
        profile: 'mapbox/driving',
        controls: { inputs: false },
        geocoder: {
            countries: 'us'
        }
    });
    map.addControl(directions, 'top-left');
    return directions;
}
var mapboxDirections = initializeMapbox();
function updateMapboxRoute(location, type) {
    if (type === 'from') {
        mapboxDirections.setOrigin([location.lng(), location.lat()]);
    } else if (type === 'to') {
        mapboxDirections.setDestination([location.lng(), location.lat()]);
    }
    var routeCoordinates = {
    from: mapboxDirections.getOrigin().geometry.coordinates,
    to: mapboxDirections.getDestination().geometry.coordinates
};
sessionStorage.setItem('routeCoordinates', JSON.stringify(routeCoordinates));

}
window.addEventListener('load', initialize);
document.getElementById('type_of_vehicle').addEventListener('change', function () {
updateFuelDetails();
});
window.addEventListener('load', function() {
updateFuelDetails();
});
document.querySelector('form').addEventListener('submit', function(event) {
event.preventDefault(); // Prevent the form from submitting immediately
});
function shareResults() {
if (navigator.share) {
navigator.share({
  title: 'Toll Cost Estimation',
  text: 'Check out my toll cost estimation.',
  url: window.location.href // Or the URL of the result page
}).then(() => {
  console.log('Thanks for sharing!');
})
.catch(console.error);
} else {
// Fallback for browsers that don't support the Web Share API
alert('Web share not supported in this browser.');
}
}
document.getElementById('share-button').addEventListener('click', function() {
document.getElementById('share-modal').style.display = 'block';
});
document.getElementById('close-modal').addEventListener('click', function() {
document.getElementById('share-modal').style.display = 'none';
});
// Update share links dynamically
window.addEventListener('load', function(){
const shareURL = encodeURIComponent(window.location.href);
document.getElementById('share-whatsapp').href = `https://api.whatsapp.com/send?text=Check out this page: ${shareURL}`;
document.getElementById('share-facebook').href = `https://www.facebook.com/sharer/sharer.php?u=${shareURL}`;
// Twitter
document.getElementById('share-twitter').href = `https://twitter.com/intent/tweet?url=${shareURL}&text=Check out this page`;
// LinkedIn
document.getElementById('share-linkedin').href = `https://www.linkedin.com/shareArticle?mini=true&url=${shareURL}`;
// Email
document.getElementById('share-email').href = `mailto:?subject=Check out this page&body=${shareURL}`;
// Copy link
document.getElementById('copy-link').onclick = function() {
navigator.clipboard.writeText(window.location.href).then(() => {
    alert("Link copied to clipboard!");
}).catch(err => {
    console.error('Error copying link to clipboard', err);
});
};
});
window.addEventListener('click', function(event) {
let modal = document.getElementById('share-modal');
if (event.target == modal) {
    modal.style.display = "none";
}
});
function generateQRCode() {
const pageURL = encodeURIComponent(window.location.href);
const qrCodeURL = `https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${pageURL}`;

document.getElementById('qr-code-container').innerHTML = `<img src="${qrCodeURL}" alt="QR Code" style="width:150px; height: 150px;"/>`;
}
// Call this function when the page loads or when you want to display the QR code
generateQRCode();
document.querySelector('.dropdown-selected').addEventListener('click', function() {
// Toggle the dropdown display on click
var dropdownOptions = document.querySelector('.dropdown-options');
dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
});
document.querySelector('.dropdown-options').addEventListener('click', function(event) {
// Check if the clicked element is an LI or an element inside an LI
if (event.target.matches('li, li *')) {
    // Find the closest LI element
    var selectedItem = event.target.closest('li');
    var value = selectedItem.getAttribute('data-value');
    var text = selectedItem.textContent.trim();
    var iconSrc = selectedItem.querySelector('img').src;

    // Update the dropdown display, hidden input, and image
    document.querySelector('.dropdown-selected span').textContent = text;
    document.querySelector('.dropdown-selected .selected-icon').src = iconSrc;
    document.getElementById('type_of_vehicle').value = value;

    // Close the dropdown
    document.querySelector('.dropdown-options').style.display = 'none';
}
});
// Clicking outside the dropdown to close it
window.addEventListener('click', function(e) {
if (!document.querySelector('.dropdown').contains(e.target)) {
    document.querySelector('.dropdown-options').style.display = 'none';
}
});
function printResult() {
// Create an iframe element
var printFrame = document.createElement('iframe');
printFrame.name = 'print_frame';
printFrame.style.position = 'absolute';
printFrame.style.top = '-1000000px'; // Position iframe off-screen
document.body.appendChild(printFrame);
// Write the content to the iframe
var frameDoc = printFrame.contentWindow ? printFrame.contentWindow : printFrame.contentDocument.document ? printFrame.contentDocument.document : printFrame.contentDocument;
frameDoc.document.open();
frameDoc.document.write('<html><head><title>Print</title><style>');
frameDoc.document.write('\
    body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }\
    #toll-cost-estimation { width: 100%; text-align: center; }\
    #toll-cost-estimation table { margin: auto; border-collapse: collapse; }\
    #toll-cost-estimation th, #toll-cost-estimation td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 18px; }\
    #print-button { display: none; }\
    #result-share-button { display: none; }\
    #back-button { display: none; }\
    .close-btn { display: none; }\
    #toll-cost-estimation th { background-color: #047cba; color: white; text-transform: uppercase; }'
    );  
frameDoc.document.write('</style></head><body>');
frameDoc.document.write(document.getElementById('toll-cost-estimation').outerHTML);
frameDoc.document.write('</body></html>');
frameDoc.document.close();
// Print the iframe's content
setTimeout(function () {
    frameDoc.focus();
    frameDoc.print();
    // Remove the iframe after printing
    document.body.removeChild(printFrame);
}, 500);
}
function closePopup() {
// Make sure this function is called when you want to close the popup,
// for example, when the close button (x) on the popup is clicked.
document.querySelector('.overlay').style.display = 'none';
}
document.getElementById('result-share-button').addEventListener('click', function() {
const shareData = {
title: 'Trip Cost Estimation',
text: `Trip Cost Estimation Results:\n\n` +
      `From City: ${document.getElementById('fromCity').value}\n` +
      `To City: ${document.getElementById('toCity').value}\n` +
      `Type of Vehicle: ${document.getElementById('type_of_vehicle').value}\n` +
      `Trip Type: ${document.getElementById('Trip').value}\n` +
      `Estimated Toll Cost: ${document.querySelector('#toll-cost-estimation table tr:nth-child(7) td').textContent}\n` +
      `Estimated Fuel Cost: ${document.querySelector('#toll-cost-estimation table tr:nth-child(8) td').textContent}\n` +
      `Total Cost (Toll + Fuel): ${document.querySelector('#toll-cost-estimation table tr:last-child td').textContent}\n\n` +
      `For more info, go to:\n` + // Add this line to prompt the user
      'https://www.personaldrivers.com/road-trip/tools/gas-calculator/ \n' +         // The URL to your site
      `To learn more about hiring a driver for long-distance road trip, visit:\n` + // Add this line to prompt the user
      'https://www.personaldrivers.com/' // The URL to your site
};
// Proceed with the rest of the sharing code...
if (navigator.share) {
    navigator.share(shareData)
        .then(() => console.log('Successful share'))
        .catch((error) => console.log('Error sharing:', error));
} else {
    // Fallback for browsers that don't support the Web Share API
    alert('Web share not supported in this browser.');
}
});

document.addEventListener("DOMContentLoaded", function() {
// Retrieve the stored type_of_vehicle value from the PHP session
var storedType = "<?php echo getFormFieldValue('type_of_vehicle'); ?>";

if (storedType) {
    var options = document.querySelectorAll('.dropdown-options li');
    options.forEach(function(option) {
        if (option.getAttribute('data-value') === storedType) {
            // Update the dropdown display, hidden input, and image
            var selectedText = option.textContent.trim();
            var selectedImageSrc = option.querySelector('img').src;
        }
    });
}
});
document.addEventListener("DOMContentLoaded", function() {
// Retrieve the type_of_vehicle value from the PHP session
var storedType = "<?php echo getFormFieldValue('type_of_vehicle'); ?>";
var defaultType = 'Car/SUV or Pickup Truck';
var defaultImageSrc = 'https://www.personaldrivers.com/wp-content/uploads/car-2axles.png';

if (!storedType) {
    storedType = defaultType;
}
var options = document.querySelectorAll('.dropdown-options li');
options.forEach(function(option) {
    if (option.getAttribute('data-value') === storedType) {
        var selectedText = option.textContent.trim();
        var selectedImageSrc = option.querySelector('img') ? option.querySelector('img').src : defaultImageSrc;
        document.getElementById('vehicle-display').textContent = selectedText;
        document.getElementById('type_of_vehicle').value = storedType;
        document.querySelector('.selected-icon').src = selectedImageSrc;
    }
});
});
 document.getElementById('new-search').addEventListener('click', function() {
// Clear the form fields
document.getElementById('fromCity').value = '';
document.getElementById('toCity').value = '';
document.getElementById('Trip').value = 'OneWay';
// Set the vehicle type dropdown and hidden input to default values
document.getElementById('vehicle-display').textContent = 'Car/SUV or Pickup Truck (2-Axles)';
document.getElementById('type_of_vehicle').value = 'Car/SUV or Pickup Truck'; // This should be the value attribute of the default option
document.querySelector('.selected-icon').src = 'https://www.personaldrivers.com/wp-content/uploads/car-2axles.png'; // Set to default image
if (hiddenVehicleInput) {
    hiddenVehicleInput.value = '';
}
localStorage.removeItem('fromCity');
localStorage.removeItem('toCity');
localStorage.removeItem('type_of_vehicle');
localStorage.removeItem('Trip');
localStorage.removeItem('mapboxOrigin');
localStorage.removeItem('mapboxDestination');
// Reset Mapbox Directions
if (mapboxDirections) {
    mapboxDirections.removeRoutes(); // If this method is not available, you may need to use a different one based on Mapbox Directions API
}
// Clear local storage values for mapbox locations
localStorage.removeItem('mapboxOrigin');
localStorage.removeItem('mapboxDestination');
// Reset the map view to the default center and zoom
map.flyTo({
    center: [-98.5795, 39.8283], // Default center coordinates
    zoom: 4 // Default zoom level
});  
});
document.addEventListener("DOMContentLoaded", function() {
var storedType = "<?php echo getFormFieldValue('type_of_vehicle'); ?>";
var dropdownOptions = document.querySelectorAll('.dropdown-options li');

dropdownOptions.forEach(function(option) {
    if (option.getAttribute('data-value') === storedType) {
        var selectedText = option.textContent.trim();
        var selectedImageSrc = option.querySelector('img') ? option.querySelector('img').src : '';

        // Update the dropdown display, hidden input, and image
        document.getElementById('vehicle-display').textContent = selectedText;
        document.getElementById('type_of_vehicle').value = storedType;
        document.querySelector('.selected-icon').src = selectedImageSrc;
    }
});
});
