<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'library_db');

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must log in to borrow books!'); window.location.href='login.html';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = $_GET['id'];

// Check borrowing limit (Max 3 books per user)
$borrowed_count = $conn->query("SELECT COUNT(*) AS total FROM borrowed_books WHERE user_id='$user_id'")->fetch_assoc()['total'];
if ($borrowed_count >= 2) {
    echo "<script>alert('You have reached your borrowing limit (3 books)!'); window.location.href='user_dashboard.php';</script>";
    exit();
}

// Check if book is available
$result = $conn->query("SELECT * FROM books WHERE id='$book_id'");
$book = $result->fetch_assoc();

if ($book && $book['quantity'] > 0) {
    // Reduce book quantity and add to borrowed_books table with due date
    $conn->query("UPDATE books SET quantity = quantity - 1 WHERE id='$book_id'");
    $conn->query("INSERT INTO borrowed_books (user_id, book_id, borrow_date, due_date) VALUES ('$user_id', '$book_id', NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY))");

    echo "<script>alert('Book borrowed successfully! Due date: " . date('Y-m-d', strtotime("+14 days")) . "'); window.location.href='user_dashboard.php';</script>";
} else {
    echo "<script>alert('Sorry, this book is not available!'); window.location.href='user_dashboard.php';</script>";
}
