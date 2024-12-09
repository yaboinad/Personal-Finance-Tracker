<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$username_email = $_SESSION['username_email'];

// Prepare SQL statement to delete bank accounts
$sql = "UPDATE users SET bdo_account = NULL, gcash_account = NULL WHERE username_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username_email);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Accounts deleted successfully';
} else {
    $response['success'] = false;
    $response['message'] = 'Error deleting accounts';
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?> 