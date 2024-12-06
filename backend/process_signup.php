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
    $_SESSION['signup_errors'] = ["Database connection failed"];
    header("Location: /Personal-Finance-Tracker/Financia_Sign_Up.php");
    exit();
}

// Get form data
$username_email = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$city = $_POST['city'] ?? '';
$otp = $_POST['otp'] ?? '';

// Basic validation
$errors = [];

// Validate username/email
if (empty($username_email)) {
    $errors[] = "Username/Email is required";
}

try {
    // Check if username/email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username_email = ?");
    $stmt->execute([$username_email]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Username/Email already exists";
    }
} catch(PDOException $e) {
    error_log("Error checking existing user: " . $e->getMessage());
    $errors[] = "Database error during validation";
}

// Validate passwords match
if ($password !== $confirmPassword) {
    $errors[] = "Passwords do not match";
}

// Validate OTP
if (empty($otp) || $otp !== $_SESSION['generated_otp']) {
    $errors[] = "Invalid OTP";
}

// If there are errors
if (!empty($errors)) {
    $_SESSION['signup_errors'] = $errors;
    header("Location: /Personal-Finance-Tracker/Financia_Sign_Up.php");
    exit();
}

// If validation passes, insert into database
try {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username_email, password, birthdate, city) 
                          VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([
        $username_email,
        $hashedPassword,
        $birthdate,
        $city
    ])) {
        // Successful registration
        $_SESSION['signup_success'] = "Registration successful! You can now sign in with your new account.";
        
        // If user is already logged in, keep them logged in
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            header("Location: ../Financia.php");
        } else {
            header("Location: ../Financia_Sign_In.php");
        }
        exit();
    } else {
        throw new Exception("Insert failed");
    }
    
} catch(Exception $e) {
    error_log("Registration error: " . $e->getMessage());
    $_SESSION['signup_errors'] = ["Registration failed: " . $e->getMessage()];
    header("Location: ../Financia_Sign_Up.php");
    exit();
}
?>
