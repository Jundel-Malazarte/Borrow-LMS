<?php
session_start();
require_once 'db_connection.php';

// Define constant for better readability
define('ONE_HOUR', 3600); // 60 minutes × 60 seconds

if (isset($_SESSION['user_id'])) {
    // Clear remember token in database
    $stmt = $conn->prepare("UPDATE admin SET remember_token = NULL WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();


    // Common cookie duration constants:
    // ONE_HOUR = 3600 seconds
    // ONE_DAY = 86400 seconds (24 × 3600)
    // ONE_WEEK = 604800 seconds (7 × 86400)
    // ONE_MONTH ≈ 2592000 seconds (30 × 86400)

    // Clear cookies by setting expiration to 1 hour ago
    setcookie('remember_token', '', time() - ONE_HOUR, '/');
    setcookie('user_id', '', time() - ONE_HOUR, '/');
}

session_destroy();
header("Location: index.php");
exit();
