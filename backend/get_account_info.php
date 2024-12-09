<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$username_email = $_SESSION['username_email'];

$sql = "SELECT bdo_account, gcash_account FROM users WHERE username_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username_email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'accounts' => $row]);
} else {
    echo json_encode(['success' => true, 'accounts' => null]);
}

$stmt->close();
$conn->close();
?> 