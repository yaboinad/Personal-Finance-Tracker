<?php
session_start();
header('Content-Type: application/json');

$response = [
    'logged_in' => isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true,
    'username' => $_SESSION['username_email'] ?? null
];

echo json_encode($response);
?> 