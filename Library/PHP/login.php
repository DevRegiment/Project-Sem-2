<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'library_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = trim($_POST['email']);
$password = $_POST['password'];
$role = $_POST['role'];

// Prevent SQL injection
$email = $conn->real_escape_string($email);
$role = $conn->real_escape_string($role);

// Check if the user exists in the database
$sql = "SELECT * FROM users WHERE email='$email' AND role='$role'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify password
    if ($password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $role;
        $_SESSION['name'] = $user['name'];

        // Redirect based on role
        header("Location: " . ($role == 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php'));
        exit();
    } else {
        echo "<script>alert('Invalid credentials!'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('User not found! Please register.'); window.location.href='register.html';</script>";
}

// Close connection
$conn->close();
