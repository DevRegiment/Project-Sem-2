<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'library_db');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $conn->real_escape_string($_POST['role']);

    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");

    echo "<script>alert('User added successfully!'); window.location.href='admin_dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add User</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="centre-container">
        <span>

            <h2>Register New User</h2>
            <button>

                <a href="admin_dashboard.php">Back to Dashboard</a>
            </button>
            <form method="POST">
                <label>Name:</label>
                <input type="text" name="name" required><br>

                <label>Email:</label>
                <input type="email" name="email" required><br>

                <label>Password:</label>
                <input type="password" name="password" required><br>

                <label>Role:</label>
                <select name="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select><br>

                <button type="submit">Add User</button>
            </form>
        </span>
    </div>
</body>

</html>