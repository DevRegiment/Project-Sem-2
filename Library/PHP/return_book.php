<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'library_db');

if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit();
}

$user_id = $_SESSION['user_id'];
$borrow_id = $_GET['id'];

$result = $conn->query("SELECT * FROM borrowed_books WHERE id='$borrow_id' AND user_id='$user_id'");
$borrowed = $result->fetch_assoc();

if ($borrowed) {

    $conn->query("UPDATE books SET quantity = quantity + 1 WHERE id='{$borrowed['book_id']}'");

    $conn->query("DELETE FROM borrowed_books WHERE id='$borrow_id'");

    echo "<script>alert('Book returned successfully!'); window.location.href='user_dashboard.php';</script>";
} else {
    echo "<script>alert('Error: Book not found!'); window.location.href='user_dashboard.php';</script>";
}
