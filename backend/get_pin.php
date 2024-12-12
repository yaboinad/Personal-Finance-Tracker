<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$username_email = $_SESSION['username_email'];

// Add error logging
error_log("Fetching PIN for user: " . $username_email);

// Get the OTP from users table
$sql = "SELECT pin FROM users WHERE username_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username_email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    error_log("PIN found: " . $row['pin']);
    echo json_encode(['success' => true, 'pin' => $row['pin']]);
} else {
    error_log("No PIN found for user");
    echo json_encode(['success' => false, 'message' => 'PIN not found']);
}

$stmt->close();
$conn->close();
?> 