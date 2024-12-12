<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['logged_in'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT bdo_balance, gcash_balance FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $balances = $result->fetch_assoc();
    if ($balances) {
        echo json_encode(['success' => true, 'balances' => $balances]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No balances found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error fetching balances']);
}

$stmt->close();
$conn->close();
?>
