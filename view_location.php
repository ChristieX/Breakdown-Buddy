<?php
// Include the database connection file
include_once 'db_connect.php';
include_once 'template.html';

// Check if incident_id is set in the URL
if (isset($_GET['incident_id'])) {
    $incident_id = $_GET['incident_id'];

    // Query to retrieve geolocation_id from the incident table
    $geolocation_query = "SELECT geolocation_id FROM incident WHERE incident_id = $incident_id";
    $geolocation_result = $conn->query($geolocation_query);

    if ($geolocation_result->num_rows > 0) {
        $geolocation_row = $geolocation_result->fetch_assoc();
        $geolocation_id = $geolocation_row['geolocation_id'];

        // Query to retrieve latitude and longitude from the client_geolocation table
        $location_query = "SELECT latitude, longitude FROM client_geolocation WHERE geolocation_id = $geolocation_id";
        $location_result = $conn->query($location_query);

        if ($location_result->num_rows > 0) {
            $location_row = $location_result->fetch_assoc();
            $latitude = $location_row['latitude'];
            $longitude = $location_row['longitude'];

            // Close the database connection
            $conn->close();
        } else {
            echo "Location not found.";
            exit();
        }
    } else {
        echo "Incident not found.";
        exit();
    }
} else {
    echo "Incident ID not specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Location</title>

    <!-- Use Leaflet from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>

    <h2>Client Location</h2>

    <div id="map" style="height: 400px; width: 100%;"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Initialize the map with the client's location
        function initMap() {
            var latitude = <?php echo $latitude; ?>;
            var longitude = <?php echo $longitude; ?>;
            
            var map = L.map('map').setView([latitude, longitude], 15);

            // Use the Leaflet tile layer from CDN
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Use the default Leaflet marker icon
            L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Client Location')
                .openPopup();
        }

        // Ensure Leaflet is loaded before initializing the map
        document.addEventListener('DOMContentLoaded', function () {
            initMap();
        });
    </script>

</body>
</html>
