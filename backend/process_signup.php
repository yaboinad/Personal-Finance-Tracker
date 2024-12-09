<?php
session_start();
require_once 'db_connect.php';

// Get form data and validate
$username = $_POST['username'] ?? '';
$email = $_POST['username'] ?? ''; // Using same field for email
$username_email = $email; // For consistency
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$city = $_POST['city'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$submitted_otp = $_POST['otp'] ?? '';
$stored_otp = $_SESSION['signup_otp'] ?? '';

// Validate OTP
if ($submitted_otp !== $stored_otp) {
    $_SESSION['signup_errors'][] = "Invalid OTP. Please try again.";
    header('Location: /Personal-Finance-Tracker/Financia_Sign_Up.php');
    exit;
}

// After successful OTP verification, store it as PIN
$pin = $submitted_otp;

try {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Single INSERT statement including all fields
    $stmt = $conn->prepare("INSERT INTO users (
        username, 
        username_email, 
        email, 
        password, 
        birthdate, 
        city, 
        mobile_number,
        pin,
        deleted
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
    
    $stmt->bind_param("ssssssss",
        $username,
        $username_email,
        $email,
        $hashedPassword,
        $birthdate,
        $city,
        $mobile,
        $pin
    );
    
    if ($stmt->execute()) {
        $_SESSION['signup_success'] = true;
        header("Location: /Personal-Finance-Tracker/Financia_Sign_In.php");
        exit();
    }
} catch(Exception $e) {
    error_log("Error during signup: " . $e->getMessage());
    $_SESSION['signup_errors'][] = "An error occurred during signup";
    header("Location: /Personal-Finance-Tracker/Financia_Sign_Up.php");
    exit();
}

$stmt->close();
$conn->close();
?>
