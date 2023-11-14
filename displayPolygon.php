<?php
include_once('conn.php');

$result = pg_query($conn, "SELECT id, name, ST_AsGeoJSON(area) AS geojson FROM spatial_polygons");

// Create an array to store GeoJSON features
$geojsonFeatures = array();

while ($row = pg_fetch_assoc($result)) {
    $feature = array(
        'type' => 'Feature',
        'properties' => array(
            'id' => $row['id'],
            'name' => $row['name']
        ),
        'geometry' => json_decode($row['geojson'])
    );

    $geojsonFeatures[] = $feature;
}

// Close the connection
pg_close($conn);

// Create a GeoJSON feature collection
$geojsonCollection = array(
    'type' => 'FeatureCollection',
    'features' => $geojsonFeatures
);

// Send GeoJSON data to the client
header('Content-Type: application/json');
echo json_encode($geojsonCollection);
?>

?>