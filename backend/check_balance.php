<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['username_email'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$bank = $input['bank'] ?? '';

$username_email = $_SESSION['username_email'];

$sql = "SELECT bdo_balance, gcash_balance FROM users WHERE username_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username_email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

header('Content-Type: application/json');
if ($user) {
    $balance = $bank === 'bdo' ? $user['bdo_balance'] : $user['gcash_balance'];
    echo json_encode(['success' => true, 'balance' => $balance]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

$stmt->close();
$conn->close();
?>
