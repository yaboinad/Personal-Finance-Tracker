<?php
session_start();
require_once 'db_connect.php';

// Test database connection
try {
    // Test users table
    $sql = "SELECT COUNT(*) as count FROM users";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        echo "Users table exists. Total users: " . $row['count'] . "<br>";
    }

    // Test transactions table
    $sql = "SELECT COUNT(*) as count FROM transactions";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        echo "Transactions table exists. Total transactions: " . $row['count'] . "<br>";
    }

    // Test user balance columns
    if (isset($_SESSION['username_email'])) {
        $sql = "SELECT bdo_balance, gcash_balance FROM users WHERE username_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['username_email']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            echo "User balances found:<br>";
            echo "BDO Balance: ₱" . number_format($row['bdo_balance'], 2) . "<br>";
            echo "GCash Balance: ₱" . number_format($row['gcash_balance'], 2) . "<br>";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conn->close();
}
?> 