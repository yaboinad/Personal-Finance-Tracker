<?php
session_start();
include 'db_connect.php';

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);
$new_username = $data['username'] ?? '';
$current_username = $_SESSION['username_email'] ?? '';

if (empty($new_username)) {
    echo json_encode(['success' => false, 'message' => 'Username cannot be empty']);
    exit;
}

try {
    // Update username in database
    $sql = "UPDATE users SET username_email = ? WHERE username_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_username, $current_username);
    
    if ($stmt->execute()) {
        // Update session with new username
        $_SESSION['username_email'] = $new_username;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed']);
    }
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
?> 