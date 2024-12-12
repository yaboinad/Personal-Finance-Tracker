<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$username_email = $_SESSION['username_email'];

// Get user_id and current balance
$user_sql = "SELECT id, bdo_balance, gcash_balance FROM users WHERE username_email = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("s", $username_email);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
$user_id = $user['id'];

try {
    $conn->begin_transaction();
    
    // Set description to NULL if empty
    $description = !empty($data['description']) ? $data['description'] : null;
    
    // Validate based on transaction type
    switch($data['transactionType']) {
        case 'Transfer Money':
            if (empty($data['recipientName']) || empty($data['recipientAccount'])) {
                throw new Exception('Recipient name and account number are required for transfers');
            }
            $current_balance = ($data['payment'] === 'bdo') ? $user['bdo_balance'] : $user['gcash_balance'];
            if ($current_balance < $data['amount']) {
                throw new Exception('Insufficient balance. Available balance: ₱' . number_format($current_balance, 2));
            }
            $successMessage = 'Transfer of ₱' . number_format($data['amount'], 2) . ' completed successfully';
            break;
            
        case 'Withdraw':
            $current_balance = ($data['payment'] === 'bdo') ? $user['bdo_balance'] : $user['gcash_balance'];
            if ($current_balance < $data['amount']) {
                throw new Exception('Insufficient balance. Available balance: ₱' . number_format($current_balance, 2));
            }
            $successMessage = 'Withdrawal of ₱' . number_format($data['amount'], 2) . ' completed successfully';
            break;
            
        case 'Deposit':
            $successMessage = 'Deposit of ₱' . number_format($data['amount'], 2) . ' completed successfully';
            break;
            
        default:
            $successMessage = 'Transaction completed successfully';
    }

    // Insert transaction record
    $sql = "INSERT INTO transactions (
        user_id, 
        transaction_type, 
        payment_method,
        recipient_name,
        recipient_account,
        amount,
        description,
        transaction_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssds",
        $user_id,
        $data['transactionType'],
        $data['payment'],
        $data['recipientName'] ?? '',
        $data['recipientAccount'] ?? '',
        $data['amount'],
        $description
    );
    
    $stmt->execute();

    // Update user's balance
    $balance_column = $data['payment'] === 'bdo' ? 'bdo_balance' : 'gcash_balance';
    
    if ($data['transactionType'] === 'Deposit') {
        $sql = "UPDATE users SET $balance_column = $balance_column + ? WHERE id = ?";
    } else {
        $sql = "UPDATE users SET $balance_column = $balance_column - ? WHERE id = ?";
    }

    $update_stmt = $conn->prepare($sql);
    $update_stmt->bind_param("di", $data['amount'], $user_id);
    $update_stmt->execute();

    $conn->commit();
    echo json_encode([
        'success' => true, 
        'message' => $successMessage,
        'transaction_type' => $data['transactionType'],
        'amount' => $data['amount'],
        'payment_method' => $data['payment']
    ]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$stmt->close();
$conn->close();
?> 