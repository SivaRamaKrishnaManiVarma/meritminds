<?php

// Database connection

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "tracking";

$servername = "localhost";
$username = "u701696978_leads";
$password = "?0I=u;[af"; 
$dbname = "u701696978_leads";



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>