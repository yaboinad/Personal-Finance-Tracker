<?php
session_start();
include 'db_connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get form data
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Remove +63 prefix from mobile number if present
$mobile = str_replace('+63', '', $mobile);

// Basic validation
$errors = [];

if (empty($email)) {
    $errors[] = "Email/Username is required";
}

if (empty($mobile)) {
    $errors[] = "Mobile number is required";
} elseif (!preg_match("/^(09|\+?63|0)[0-9]{9}$/", $mobile)) {
    $errors[] = "Invalid mobile number format";
}

if (empty($new_password)) {
    $errors[] = "New password is required";
} elseif (strlen($new_password) < 6) {
    $errors[] = "Password must be at least 6 characters long";
}

if ($new_password !== $confirm_password) {
    $errors[] = "Passwords do not match";
}

if (!empty($errors)) {
    $_SESSION['reset_errors'] = $errors;
    header("Location: ../Financia_Forgot_Password.php");
    exit();
}

try {
    // Verify database connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Check if user exists with given email/username and mobile
    $sql = "SELECT id FROM users WHERE username_email = ? AND mobile_number = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ss", $email, $mobile);
    
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['reset_errors'] = ["No account found with these credentials"];
        header("Location: ../Financia_Forgot_Password.php");
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password
    $update_sql = "UPDATE users SET password = ? WHERE username_email = ? AND mobile_number = ?";
    $update_stmt = $conn->prepare($update_sql);
    
    if ($update_stmt === false) {
        throw new Exception("Update prepare failed: " . $conn->error);
    }
    
    $update_stmt->bind_param("sss", $hashed_password, $email, $mobile);
    
    if (!$update_stmt->execute()) {
        throw new Exception("Update execute failed: " . $update_stmt->error);
    }

    if ($update_stmt->affected_rows > 0) {
        $_SESSION['reset_success'] = "✓ Password successfully reset! Please login with your new password.";
        header("Location: ../Financia_Sign_In.php");
    } else {
        throw new Exception("No rows were updated");
    }

} catch (Exception $e) {
    error_log("Password reset error: " . $e->getMessage());
    error_log("Error trace: " . $e->getTraceAsString());
    
    $_SESSION['reset_errors'] = ["An error occurred. Please try again later. Error: " . $e->getMessage()];
    header("Location: ../Financia_Forgot_Password.php");
}

$conn->close();
?> 