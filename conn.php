<?php
$host = "localhost";  // replace with your PostgreSQL host
$port = "5432";       // replace with your PostgreSQL port
$dbname = "example_postgis";   // replace with your PostgreSQL database name
$user = "postgres";   // replace with your PostgreSQL username
$password = "root"; // replace with your PostgreSQL password


$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

?>
