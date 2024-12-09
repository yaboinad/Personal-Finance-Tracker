<?php
session_start();
require_once 'db_connect.php';

// Get JSON data from request
$data = json_decode(file_get_contents('php://input'), true);
$userId = $_SESSION['user_id'];

// Log the received data for debugging
error_log("Received data: " . print_r($data, true));

// Prepare SQL statement to update accounts
$sql = "UPDATE users SET 
        bdo_account = ?,
        gcash_account = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", 
    $data['bdoAccount'], 
    $data['gcashAccount'], 
    $userId
);

$response = array();
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Accounts updated successfully';
    $response['debug'] = [
        'bdo' => $data['bdoAccount'],
        'gcash' => $data['gcashAccount']
    ];
} else {
    $response['success'] = false;
    $response['message'] = 'Error updating accounts: ' . $conn->error;
}

header('Content-Type: application/json');
echo json_encode($response);
?> 