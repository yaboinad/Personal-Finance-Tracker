<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

try {
    $result = $conn->query("SELECT 1");
    echo json_encode(['success' => true, 'message' => 'Database connection successful']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
}
?> 