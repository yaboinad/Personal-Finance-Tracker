<?php
session_start();
include 'db_connect.php';

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$username_email = $_SESSION['username_email'] ?? '';

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

try {
    // Update email in database
    $sql = "UPDATE users SET email = ? WHERE username_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $username_email);
    
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