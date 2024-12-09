<?php
$servername = "localhost";
$username = "root";  // Your database username (default for XAMPP is "root")
$password = "";      // Your database password (default for XAMPP is empty)
$dbname = "financia";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

// Optionally set timezone if needed
date_default_timezone_set('Asia/Manila');  // Adjust timezone as needed
?> 