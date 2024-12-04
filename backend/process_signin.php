<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'financia';
$dbusername = 'root';
$dbpassword = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    $_SESSION['login_errors'] = ["Database connection failed"];
    header("Location: /Personal-Finance-Tracker/Financia_Sign_In.php");
    exit();
}

// Get form data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validate inputs
if (empty($username) || empty($password)) {
    $_SESSION['login_errors'] = ["All fields are required"];
    header("Location: /Personal-Finance-Tracker/Financia_Sign_In.php");
    exit();
}

try {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username_email = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Successful login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username_email'];
        header("Location: /Personal-Finance-Tracker/Financia.html");
        exit();
    } else {
        $_SESSION['login_errors'] = ["Invalid username or password"];
        header("Location: /Personal-Finance-Tracker/Financia_Sign_In.php");
        exit();
    }
} catch(PDOException $e) {
    error_log("Login error: " . $e->getMessage());
    $_SESSION['login_errors'] = ["Login failed"];
    header("Location: /Personal-Finance-Tracker/Financia_Sign_In.php");
    exit();
}
?> 