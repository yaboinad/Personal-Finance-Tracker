<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$username_email = $_SESSION['username_email'];
$submitted_pin = $data['pin'] ?? '';

// Verify PIN
$sql = "SELECT pin FROM users WHERE username_email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username_email]);
$result = $stmt->fetch();

if ($result && $result['pin'] === $submitted_pin) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid PIN']);
}
?> 