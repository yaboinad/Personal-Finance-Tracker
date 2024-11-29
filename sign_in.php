<?php
session_start(); // Start session for login tracking

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
        // Sanitize user input
        $input = trim($_POST['email']); // 'email' or 'username' based on form input
        $password = $_POST['password'];

        // Check if input is email or username
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT * FROM users WHERE email = ?";
        } else {
            $query = "SELECT * FROM users WHERE username = ?";
        }

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $input);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Invalid username/email or password.");
        }

        $user = $result->fetch_assoc();

        // Verify password
        if (!password_verify($password, $user['password'])) {
            throw new Exception("Invalid username/email or password.");
        }

        // Successful login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        // Redirect to dashboard or homepage
        header("Location: Financia.html");
        exit;

    } catch (Exception $e) {
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    } finally {
        if (isset($stmt)) $stmt->close();
        $conn->close();
    }
}
?>
