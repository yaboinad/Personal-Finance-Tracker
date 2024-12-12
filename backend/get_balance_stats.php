<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

try {
    $user_stmt = $conn->prepare("SELECT id FROM users WHERE username_email = ?");
    $user_stmt->bind_param("s", $_SESSION['username_email']);
    $user_stmt->execute();
    $user = $user_stmt->get_result()->fetch_assoc();

    if (!$user) {
        throw new Exception('User not found');
    }

    // Get BDO statistics including total balance
    $bdo_stats = $conn->prepare("
        SELECT 
            u.bdo_balance as balance,
            COALESCE(SUM(CASE 
                WHEN t.transaction_type = 'Deposit' THEN t.amount 
                WHEN t.transaction_type IN ('Withdraw', 'Transfer Money') THEN -t.amount 
                ELSE 0 
            END), 0) as total_balance,
            COALESCE(SUM(CASE WHEN t.transaction_type = 'Deposit' THEN t.amount ELSE 0 END), 0) as total_deposits,
            COALESCE(SUM(CASE WHEN t.transaction_type IN ('Withdraw', 'Transfer Money') THEN t.amount ELSE 0 END), 0) as total_withdrawals
        FROM users u
        LEFT JOIN transactions t ON u.id = t.user_id AND t.payment_method = 'bdo'
        WHERE u.id = ?
        GROUP BY u.id, u.bdo_balance
    ");

    $bdo_stats->bind_param("i", $user['id']);
    $bdo_stats->execute();
    $bdo_result = $bdo_stats->get_result()->fetch_assoc();

    // Get GCash statistics including total balance
    $gcash_stats = $conn->prepare("
        SELECT 
            u.gcash_balance as balance,
            COALESCE(SUM(CASE 
                WHEN t.transaction_type = 'Deposit' THEN t.amount 
                WHEN t.transaction_type IN ('Withdraw', 'Transfer Money') THEN -t.amount 
                ELSE 0 
            END), 0) as total_balance,
            COALESCE(SUM(CASE WHEN t.transaction_type = 'Deposit' THEN t.amount ELSE 0 END), 0) as total_deposits,
            COALESCE(SUM(CASE WHEN t.transaction_type IN ('Withdraw', 'Transfer Money') THEN t.amount ELSE 0 END), 0) as total_withdrawals
        FROM users u
        LEFT JOIN transactions t ON u.id = t.user_id AND t.payment_method = 'gcash'
        WHERE u.id = ?
        GROUP BY u.id, u.gcash_balance
    ");

    $gcash_stats->bind_param("i", $user['id']);
    $gcash_stats->execute();
    $gcash_result = $gcash_stats->get_result()->fetch_assoc();

    echo json_encode([
        'success' => true,
        'bdo' => [
            'balance' => $bdo_result['total_balance'] ?? 0,
            'total_deposits' => $bdo_result['total_deposits'] ?? 0,
            'total_withdrawals' => $bdo_result['total_withdrawals'] ?? 0
        ],
        'gcash' => [
            'balance' => $gcash_result['total_balance'] ?? 0,
            'total_deposits' => $gcash_result['total_deposits'] ?? 0,
            'total_withdrawals' => $gcash_result['total_withdrawals'] ?? 0
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($user_stmt)) $user_stmt->close();
    if (isset($bdo_stats)) $bdo_stats->close();
    if (isset($gcash_stats)) $gcash_stats->close();
    if (isset($conn)) $conn->close();
}
?> 