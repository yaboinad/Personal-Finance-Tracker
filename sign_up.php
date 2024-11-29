<?php
$servername = "localhost"; 
$db_username = "root"; 
$db_password = ""; 
$dbname = "financia";  

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Retrieve form data
        $input = trim($_POST['email/username']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];
        $birthdate = $_POST['birthdate'];
        $country = $_POST['country'];

        // Check if passwords match
        if ($password !== $confirmPassword) {
            throw new Exception("Passwords do not match!");
        }

        // Check if input is email or username
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $email = $input;
            $username = null;
        } else {
            $username = $input;
            $email = null;
        }

        // Check if username or email exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            throw new Exception("Username or Email already exists.");
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, birthdate, country) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $hashedPassword, $birthdate, $country);

        if (!$stmt->execute()) {
            throw new Exception("Failed to register user: " . $stmt->error);
        }

        echo "User registered successfully!";
    } catch (Exception $e) {
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    } finally {
        // Close resources
        if (isset($stmt)) $stmt->close();
        $conn->close();
    }
}
?>
