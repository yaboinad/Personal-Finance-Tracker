<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'financia';

try {
    // Set connection timeout
    $conn = mysqli_init();
    if (!$conn) {
        throw new Exception("mysqli_init failed");
    }

    mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 5);

    if (!mysqli_real_connect($conn, $host, $username, $password, $database)) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    
    // Set charset to handle special characters
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}
?> 