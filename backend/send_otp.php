<?php
session_start();
require_once 'db_connect.php';

// Generate a random 6-digit OTP
$otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

// Store OTP in session for verification
$_SESSION['signup_otp'] = $otp;

// Store the email and OTP temporarily
$_SESSION['temp_email'] = $_POST['email'] ?? '';

// Store OTP in database
if (isset($_SESSION['temp_email'])) {
    $sql = "UPDATE users SET otp = ? WHERE username_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $otp, $_SESSION['temp_email']);
    $stmt->execute();
    $stmt->close();
}

// Return OTP in response
echo json_encode(['success' => true, 'otp' => $otp]);
?>