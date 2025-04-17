<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="centre-container">

        <div class="admin-container">
            <span id="admin-dashboard">

                <h2>Admin Dashboard</h2>
                <a href="logout.php">Logout</a>
            </span>
            <span id="book-mgmt">


                <h3 style="color: black;">Book Management</h3>
                <a href="add_book.php">Add Book</a>
                <a href="manage_books.php">Update/Delete Books</a>
            </span>
            <span id="user-mgmt">


                <h3 style="color: black;">User Management</h3>
                <a href="add_user.php">Register New User</a>
                <a href="manage_users.php">Update/Delete Users</a>
            </span>
        </div>
    </div>
</body>

</html>