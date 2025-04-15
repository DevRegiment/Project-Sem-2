<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'library_db');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

// Fetch all books
$books = $conn->query("SELECT * FROM books");

// Handle book deletion
if (isset($_GET['delete_id'])) {
    $conn->query("DELETE FROM books WHERE id='" . $_GET['delete_id'] . "'");
    echo "<script>alert('Book deleted successfully!'); window.location.href='manage_books.php';</script>";
}

// Handle book update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $book_id = $_POST['book_id'];
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $quantity = intval($_POST['quantity']);

    $conn->query("UPDATE books SET title='$title', author='$author', isbn='$isbn', genre='$genre', quantity='$quantity' WHERE id='$book_id'");
    echo "<script>alert('Book updated successfully!'); window.location.href='manage_books.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Books</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <div class="manage-books-container">
        <h2>Manage Books</h2>
        <button>

            <a href="admin_dashboard.php">Back to Dashboard</a>
        </button>

        <table border="1">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Genre</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
            <?php while ($book = $books->fetch_assoc()) { ?>
                <tr>
                    <form method="POST">
                        <td><input type="text" name="title" value="<?= $book['title'] ?>"></td>
                        <td><input type="text" name="author" value="<?= $book['author'] ?>"></td>
                        <td><input type="text" name="isbn" value="<?= $book['isbn'] ?>"></td>
                        <td><input type="text" name="genre" value="<?= $book['genre'] ?>"></td>
                        <td><input type="number" name="quantity" value="<?= $book['quantity'] ?>"></td>
                        <td>
                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                            <button type="submit">Update</button>
                            <a href="manage_books.php?delete_id=<?= $book['id'] ?>" onclick="return confirm('Delete this book?')">Delete</a>
                        </td>
                    </form>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>