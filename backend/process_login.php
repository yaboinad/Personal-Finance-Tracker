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
    header("Location: ../Financia_Sign_In.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_email = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validate input
    if (empty($username_email) || empty($password)) {
        $_SESSION['login_errors'] = ["All fields are required"];
        header("Location: ../Financia_Sign_In.php");
        exit();
    }

    try {
        // Query to check user credentials
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username_email = ?");
        $stmt->execute([$username_email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username_email'] = $user['username_email'];
            $_SESSION['logged_in'] = true;
            $_SESSION['birthdate'] = $user['birthdate'];
            $_SESSION['city'] = $user['city'];
            $_SESSION['created_at'] = $user['created_at'];
            
            // Redirect to homepage (changed from .html to .php)
            header("Location: ../Financia.php");
            exit();
        } else {
            $_SESSION['login_errors'] = ["Invalid username/email or password"];
            header("Location: ../Financia_Sign_In.php");
            exit();
        }
    } catch(PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        $_SESSION['login_errors'] = ["Login failed. Please try again."];
        header("Location: ../Financia_Sign_In.php");
        exit();
    }
}
?>