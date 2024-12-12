<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$newUsername = trim($data['username'] ?? '');
$currentUsername = $_SESSION['username_email'];

if (empty($newUsername)) {
    echo json_encode(['success' => false, 'message' => 'Username cannot be empty']);
    exit;
}

try {
    // Check if the new username already exists for another user
    $stmt = $conn->prepare("SELECT id FROM users WHERE username_email = ? AND username_email != ?");
    $stmt->bind_param("ss", $newUsername, $currentUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Username already taken']);
        exit;
    }
    
    // Update both username and username_email fields
    $stmt = $conn->prepare("UPDATE users SET username = ?, username_email = ? WHERE username_email = ?");
    $stmt->bind_param("sss", $newUsername, $newUsername, $currentUsername);
    
    if ($stmt->execute()) {
        // Update the session variable with the new username
        $_SESSION['username_email'] = $newUsername;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update username']);
    }
} catch (Exception $e) {
    error_log("Error updating username: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

$stmt->close();
$conn->close();
?> 