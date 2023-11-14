<?php
include_once('displayPolygon.php');


?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaflet Map</title>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Leaflet Draw CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <script src="https://unpkg.com/leaflet-draw"></script>
</head>
<body>
    <!-- Create a div to hold the map -->
    <div id="map" style="height: 400px;"></div>
    <?php
        foreach ($polygons as $polygon) {
            echo "L.geoJSON(" . $polygon['geojson'] . ").addTo(map).bindPopup('" . $polygon['name'] . "');\n";
        }
        ?>
    <script>
        // Initialize the map
        var map = L.map('map').setView([0, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);


    </script>
</body>
</html>
