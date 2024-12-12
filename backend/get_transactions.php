<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

try {
    // Get user ID first
    $user_stmt = $conn->prepare("SELECT id FROM users WHERE username_email = ?");
    $user_stmt->bind_param("s", $_SESSION['username_email']);
    $user_stmt->execute();
    $user = $user_stmt->get_result()->fetch_assoc();

    if (!$user) {
        throw new Exception('User not found');
    }

    // Get all transactions for this user
    $stmt = $conn->prepare("
        SELECT 
            id,
            transaction_type,
            payment_method,
            amount,
            description,
            created_at
        FROM transactions 
        WHERE user_id = ?
        ORDER BY created_at DESC
    ");

    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    $transactions = [];
    while ($row = $result->fetch_assoc()) {
        $transactions[] = [
            'id' => $row['id'],
            'transaction_type' => $row['transaction_type'],
            'payment_method' => $row['payment_method'],
            'amount' => $row['amount'],
            'description' => $row['description'],
            'created_at' => $row['created_at']
        ];
    }

    echo json_encode([
        'success' => true,
        'transactions' => $transactions
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($user_stmt)) $user_stmt->close();
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
?> 