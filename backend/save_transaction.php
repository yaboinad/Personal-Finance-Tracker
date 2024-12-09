<?php
require_once 'db_connection.php';
session_start();

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $stmt = $pdo->prepare("INSERT INTO transactions (
        transaction_type,
        transaction_name,
        payment_option,
        recipient_name,
        recipient_account,
        recipient_email,
        amount,
        description,
        payment_date,
        user_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $data['transactionType'],
        $data['transactionName'],
        $data['paymentOption'],
        $data['recipientName'],
        $data['recipientAccount'],
        $data['recipientEmail'],
        $data['amount'],
        $data['description'],
        $data['paymentDate'],
        $_SESSION['user_id']
    ]);

    echo json_encode(['success' => true, 'message' => 'Transaction saved successfully']);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?> 