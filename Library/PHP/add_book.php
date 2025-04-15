<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'library_db');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $quantity = intval($_POST['quantity']);

    $conn->query("INSERT INTO books (title, author, isbn, genre, quantity) VALUES ('$title', '$author', '$isbn', '$genre', '$quantity')");

    echo "<script>alert('Book added successfully!'); window.location.href='admin_dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Book</title>
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


            <h2>Add New Book</h2>
            <button>

                <a href="admin_dashboard.php">Back to Dashboard</a>
            </button>
            <form method="POST">
                <label>Title:</label>
                <input type="text" name="title" required><br>

                <label>Author:</label>
                <input type="text" name="author" required><br>

                <label>ISBN:</label>
                <input type="text" name="isbn" required><br>

                <label>Genre:</label>
                <input type="text" name="genre" required><br>

                <label>Quantity:</label>
                <input type="number" name="quantity" required min="1"><br>

                <button type="submit">Add Book</button>
            </form>
        </span>
    </div>
</body>

</html>