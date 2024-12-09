<?php
session_start();
require_once 'db_connect.php';

// Set header first
header('Content-Type: application/json');

if (!isset($_SESSION['username_email'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get JSON data from request
$data = json_decode(file_get_contents('php://input'), true);
$username_email = $_SESSION['username_email'];

// Validate the data
if (!isset($data['transactionType']) || !isset($data['paymentMethod']) || !isset($data['amount'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

try {
    $conn->begin_transaction();

    // Get current balance
    $stmt = $conn->prepare("SELECT id, bdo_balance, gcash_balance FROM users WHERE username_email = ?");
    $stmt->bind_param("s", $username_email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        throw new Exception('User not found');
    }

    // Determine which balance to update
    $balance_field = $data['paymentMethod'] === 'bdo' ? 'bdo_balance' : 'gcash_balance';
    $current_balance = floatval($user[$balance_field]);
    $amount = floatval($data['amount']);
    
    // Calculate new balance based on transaction type
    switch ($data['transactionType']) {
        case 'Deposit':
            $new_balance = $current_balance + $amount;
            break;
            
        case 'Withdraw':
            if ($current_balance < $amount) {
                throw new Exception('Insufficient balance');
            }
            $new_balance = $current_balance - $amount;
            break;
            
        case 'Transfer Money':
            if ($current_balance < $amount) {
                throw new Exception('Insufficient balance');
            }
            $new_balance = $current_balance - $amount;
            break;
            
        default:
            throw new Exception('Invalid transaction type');
    }

    // Update the balance
    $update_sql = "UPDATE users SET $balance_field = ? WHERE username_email = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ds", $new_balance, $username_email);
    
    if (!$update_stmt->execute()) {
        throw new Exception('Failed to update balance');
    }

    // Record the transaction
    $insert_sql = "INSERT INTO transactions (user_id, transaction_type, payment_method, amount, description) 
                  VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("issds", 
        $user['id'],
        $data['transactionType'],
        $data['paymentMethod'],
        $amount,
        $data['description']
    );
    
    if (!$insert_stmt->execute()) {
        throw new Exception('Failed to record transaction');
    }

    $conn->commit();
    echo json_encode([
        'success' => true, 
        'message' => 'Transaction completed successfully',
        'new_balance' => $new_balance
    ]);

} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollback();
    }
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($update_stmt)) $update_stmt->close();
    if (isset($insert_stmt)) $insert_stmt->close();
    if (isset($conn)) $conn->close();
}
?> 