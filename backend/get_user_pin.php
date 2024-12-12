<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$username_email = $_SESSION['username_email'];

$sql = "SELECT pin FROM users WHERE username_email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username_email]);
$result = $stmt->fetch();

if ($result) {
    echo json_encode(['success' => true, 'pin' => $result['pin']]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}
?> 