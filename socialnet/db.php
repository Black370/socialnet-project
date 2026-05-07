<?php
$host = "localhost";
$username = "YOUR_DATABASE_USESRNAME"; // Change this
$password = "YOUR_DATABASE_PASSWORD"; // Change this
$database = "socialnet"; 

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
?>
