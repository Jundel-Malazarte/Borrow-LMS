<?php
function checkRememberMe($conn)
{
    if (isset($_COOKIE['remember_token']) && isset($_COOKIE['user_id'])) {
        $token = $_COOKIE['remember_token'];
        $user_id = $_COOKIE['user_id'];

        $stmt = $conn->prepare("SELECT id, username FROM admin WHERE id = ? AND remember_token = ?");
        $stmt->bind_param("is", $user_id, $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
    }
    return false;
}
