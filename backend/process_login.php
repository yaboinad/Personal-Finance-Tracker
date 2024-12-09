<?php
session_start();
include 'db_connect.php';

// Get form data
$username_email = $_POST['username_email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username_email) || empty($password)) {
    $_SESSION['login_error'] = "Please fill in all fields";
    header("Location: ../Financia_Sign_In.php");
    exit();
}

try {
    // Check for user by either username_email or email
    $sql = "SELECT * FROM users WHERE username_email = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['logged_in'] = true;
        $_SESSION['username_email'] = $user['username_email'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_id'] = $user['id'];
        
        header("Location: ../Financia.php");
        exit();
    } else {
        // Login failed
        $_SESSION['login_error'] = "Invalid username/email or password";
        header("Location: ../Financia_Sign_In.php");
        exit();
    }

} catch(Exception $e) {
    error_log("Login error: " . $e->getMessage());
    $_SESSION['login_error'] = "An error occurred during login";
    header("Location: ../Financia_Sign_In.php");
    exit();
}

$stmt->close();
?>