<?php

include_once('conn.php');
include_once('displayPolygons.php');   
// Decode JSON data
$postData = json_decode(file_get_contents('php://input'), true) ?? [];
$geoJSON = $postData['geoJSON'] ?? null;

// Establish a connection
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Insert the GeoJSON data into the database
$query = "INSERT INTO spatial_polygons (name, area) VALUES ('Custom Polygon', ST_GeomFromGeoJSON('" . pg_escape_string($geoJSON) . "'))";

$result = pg_query($conn, $query);

// Respond with success or error
if ($geoJSON !== null) {
    $escapedGeoJSON = pg_escape_string($geoJSON);
    $query = "INSERT INTO spatial_polygons (name, area) VALUES ('Custom Polygon', ST_GeomFromGeoJSON('$escapedGeoJSON'))";

    // Rest of your database connection and query execution code...
} else {
    // Handle the case where geoJSON is not present in the data
    $response = array('success' => false, 'message' => 'No GeoJSON data provided');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit; // Stop script execution
}

// Close the connection
pg_close($conn);

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);