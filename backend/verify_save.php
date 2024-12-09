<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username_email'])) {
    echo "Not logged in";
    exit;
}

$username_email = $_SESSION['username_email'];
$sql = "SELECT username_email, bdo_account, gcash_account FROM users WHERE username_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username_email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo "<pre>";
    print_r($row);
    echo "</pre>";
} else {
    echo "User not found";
}

$stmt->close();
$conn->close();
?> 