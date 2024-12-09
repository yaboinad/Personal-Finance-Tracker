<?php
session_start();
include 'db_connect.php';

if (isset($_SESSION['username_email'])) {
    $sql = "SELECT email FROM users WHERE username_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['username_email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    echo json_encode(['email' => $row['email'] ?? '']);
} else {
    echo json_encode(['email' => '']);
}
?> 