<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$accountType = $data['accountType'] ?? '';
$accountNumber = $data['accountNumber'] ?? '';

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Validate account numbers
function isValidAccount($type, $number) {
    if ($type === 'bdo') {
        return strlen($number) === 12 && substr($number, 0, 2) === '00';
    } else if ($type === 'gcash') {
        return strlen($number) === 11 && substr($number, 0, 2) === '09';
    }
    return false;
}

if (!isValidAccount($accountType, $accountNumber)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid account number format'
    ]);
    exit;
}

// Check if account already exists for another user
$sql = "SELECT username_email FROM users WHERE " . 
    ($accountType === 'bdo' ? "bdo_account = ?" : "gcash_account = ?") . 
    " AND username_email != ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $accountNumber, $_SESSION['username_email']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Account number already registered to another user'
    ]);
    exit;
}

echo json_encode(['success' => true]);
$stmt->close();
$conn->close();
?>
