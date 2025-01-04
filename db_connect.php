<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = ""; // Default XAMPP password for MySQL is empty
$dbname = "car_rental_system";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
