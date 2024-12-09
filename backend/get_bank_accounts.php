<?php
session_start();
require_once 'db_connect.php';

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
$user = $result->fetch_assoc();

$response = [
    'success' => true,
    'bdo_account' => $user['bdo_account'] ?? null,
    'gcash_account' => $user['gcash_account'] ?? null
];

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?> 