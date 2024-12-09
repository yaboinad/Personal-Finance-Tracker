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
$username_email = trim($_POST['username'] ?? '');
$email = $username_email; // Use the same value for both fields
$username = ''; // Don't automatically create username from email
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$city = $_POST['city'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$otp = $_POST['otp'] ?? '';

// Basic validation
$errors = [];

// Validate username/email
if (empty($username_email)) {
    $errors[] = "Email is required";
} elseif (!str_contains($username_email, '@')) {
    $errors[] = "Email must contain @ symbol";
}

// Validate mobile number
if (empty($mobile)) {
    $errors[] = "Mobile number is required";
} elseif (!preg_match("/^(09|\+639)\d{9}$/", $mobile)) {
    $errors[] = "Invalid mobile number format";
}

try {
    // Check if username/email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username_email = ? OR email = ? OR username = ?");
    $stmt->execute([$username_email, $email, $username]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Email already exists";
    }
} catch(PDOException $e) {
    error_log("Error checking existing user: " . $e->getMessage());
    $errors[] = "Database error during validation";
}

// If there are any errors, redirect back
if (!empty($errors)) {
    $_SESSION['signup_errors'] = $errors;
    header("Location: /Personal-Finance-Tracker/Financia_Sign_Up.php");
    exit();
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
    
    $stmt = $pdo->prepare("INSERT INTO users (username, username_email, email, password, birthdate, city, mobile_number) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([
        $username,
        $username_email,
        $email,
        $hashedPassword,
        $birthdate,
        $city,
        $mobile
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
