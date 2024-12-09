<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$username_email = $_SESSION['username_email'];

// Delete user data from the database
$sql = "DELETE FROM users WHERE username_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username_email);

$response = array();
if ($stmt->execute()) {
    // Clear all session data
    $_SESSION = array();
    session_destroy();
    
    $response['success'] = true;
    $response['message'] = 'Account deleted successfully';
} else {
    $response['success'] = false;
    $response['message'] = 'Error deleting account';
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?> 