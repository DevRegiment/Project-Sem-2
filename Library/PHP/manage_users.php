<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'library_db');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
$users = $conn->query("SELECT * FROM users WHERE role != 'admin'");

if (isset($_GET['delete_id'])) {
    $conn->query("DELETE FROM users WHERE id='" . $_GET['delete_id'] . "'");
    echo "<script>alert('User deleted successfully!'); window.location.href='manage_users.php';</script>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);

    $conn->query("UPDATE users SET name='$name', email='$email', role='$role' WHERE id='$user_id'");
    echo "<script>alert('User updated successfully!'); window.location.href='manage_users.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <h2>Manage Users</h2>
    <button>

        <a href="admin_dashboard.php">Back to Dashboard</a>
    </button>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($user = $users->fetch_assoc()) { ?>
            <tr>
                <form method="POST">
                    <td><input type="text" name="name" value="<?= $user['name'] ?>"></td>
                    <td><input type="email" name="email" value="<?= $user['email'] ?>"></td>
                    <td>
                        <select name="role">
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <button type="submit">Update</button>
                        <a href="manage_users.php?delete_id=<?= $user['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
                    </td>
                </form>
            </tr>
        <?php } ?>
    </table>
</body>

</html>