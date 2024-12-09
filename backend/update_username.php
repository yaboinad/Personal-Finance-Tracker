<?php
session_start();
include 'db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$new_username = $data['username'] ?? '';
$current_email = $_SESSION['username_email'] ?? '';

if (empty($new_username)) {
    echo json_encode(['success' => false, 'message' => 'Username cannot be empty']);
    exit;
}

try {
    // Check if username already exists
    $check_sql = "SELECT username FROM users WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $new_username);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Username already taken']);
        exit;
    }

    // Update username in database
    $sql = "UPDATE users SET username = ? WHERE username_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_username, $current_email);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed']);
    }
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
?> 