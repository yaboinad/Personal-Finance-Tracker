<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$username_email = $_SESSION['username_email'];
$bank = $data['bank'] ?? '';

// Determine which account field to check based on bank
$accountField = $bank === 'bdo' ? 'bdo_balance' : 'gcash_balance';

$sql = "SELECT $accountField as balance FROM users WHERE username_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username_email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && $user['balance'] !== null) {
    $response = [
        'success' => true,
        'hasAccount' => true,
        'balance' => $user['balance']
    ];
} else {
    $response = [
        'success' => true,
        'hasAccount' => false,
        'message' => 'No account found'
    ];
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?> 