<?php
session_start();
require_once 'db_connection.php';
require_once 'check_remember.php';

// Check if user is already logged in
if (isset($_SESSION['user_id']) || checkRememberMe($conn)) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Login</title>
    <link rel="icon" href="images/top_logo.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row vh-100 align-items-center justify-content-center">
            <div class="col-sm-12 col-md-8 col-lg-6 col-xl-4">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Library Kiosk Login</h2>
                        <div class="text-center mb-4">
                            <img src="img/library-logo.png" alt="Library Logo" class="img-fluid" style="max-width: 150px;">
                        </div>
                        <?php

                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
                            unset($_SESSION['error']);
                        }
                        ?>
                        <form id="loginForm" action="login_process.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>