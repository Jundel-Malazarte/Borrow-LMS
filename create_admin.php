<?php
require_once 'db_connection.php';

$username = 'admin';
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// First check if admin exists
$check_stmt = $conn->prepare("SELECT id FROM admin WHERE username = ?");
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    // Admin exists, update password
    $update_stmt = $conn->prepare("UPDATE admin SET password = ? WHERE username = ?");
    $update_stmt->bind_param("ss", $hashed_password, $username);

    if ($update_stmt->execute()) {
        echo "Admin password updated successfully!\n";
        echo "Username: admin\n";
        echo "New password: admin123\n";
    } else {
        echo "Error updating admin password: " . $conn->error;
    }
    $update_stmt->close();
} else {
    // Create new admin
    $insert_stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $insert_stmt->bind_param("ss", $username, $hashed_password);

    if ($insert_stmt->execute()) {
        echo "Admin user created successfully!\n";
        echo "Username: admin\n";
        echo "Password: admin123\n";
    } else {
        echo "Error creating admin user: " . $conn->error;
    }
    $insert_stmt->close();
}

$check_stmt->close();
$conn->close();
