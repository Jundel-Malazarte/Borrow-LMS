<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Handle Remember Me
            if ($remember) {
                // Generate a secure token
                $token = bin2hex(random_bytes(32));
                $user_id = $user['id'];

                // Store token in database
                $stmt = $conn->prepare("UPDATE admin SET remember_token = ? WHERE id = ?");
                $stmt->bind_param("si", $token, $user_id);
                $stmt->execute();

                // Set cookie for 30 days
                setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');
                setcookie('user_id', $user_id, time() + (30 * 24 * 60 * 60), '/');
            }

            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid username or password";
        header("Location: index.php");
        exit();
    }
}
