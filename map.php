<?php

include_once('conn.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaflet Map</title>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw"></script>

</head>
<body>
    <!-- Create a div to hold the map -->
    <div id="map" style="height: 400px;"></div>

    <script>
        // Initialize the map
        var map = L.map('map').setView([0, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
        draw: {
            polygon: true,
            polyline: false,
            rectangle: false,
            circle: false,
            marker: false
        },
        edit: {
            featureGroup: drawnItems,
            remove: true
        }
    });

    map.addControl(drawControl);
    map.on('draw:created', function (event) {
        var layer = event.layer;
        drawnItems.addLayer(layer);

        // Convert the drawn polygon to GeoJSON
        var geoJSON = layer.toGeoJSON();

        // Send the GeoJSON data to the server
        fetch('savePolygon.php', {
            method: 'POST',
         headers: {
        'Content-Type': 'application/json',
        },
        body: JSON.stringify({ geoJSON: JSON.stringify(geoJSON.geometry) })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Polygon saved successfully:', data);
        })
        .catch(error => {
            console.error('Error saving polygon:', error);
        });
    });

        
    </script>
</body>
</html>
