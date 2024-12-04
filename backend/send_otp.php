<?php
session_start();

// Generate OTP
$otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

// Store OTP in session
$_SESSION['generated_otp'] = $otp;

// Return response as JSON
header('Content-Type: application/json');
echo json_encode(['otp' => $otp]);
?>