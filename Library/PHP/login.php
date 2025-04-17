<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'library_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = trim($_POST['email']);
$password = $_POST['password'];
$role = $_POST['role'];

$email = $conn->real_escape_string($email);
$role = $conn->real_escape_string($role);

$sql = "SELECT * FROM users WHERE email='$email' AND role='$role'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if ($password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $role;
        $_SESSION['name'] = $user['name'];

        header("Location: " . ($role == 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php'));
        exit();
    } else {
        echo "<script>alert('Invalid credentials!'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('User not found! Please register.'); window.location.href='register.html';</script>";
}

$conn->close();
