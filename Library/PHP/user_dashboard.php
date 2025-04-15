<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'library_db');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.html");
    exit();
}

$search = isset($_POST['search']) ? $_POST['search'] : '';
$books = $conn->query("SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%'");

$user_id = $_SESSION['user_id'];
$borrowed_books = $conn->query("SELECT b.title, b.author, bb.borrow_date, bb.due_date, bb.id 
                                FROM borrowed_books bb
                                JOIN books b ON bb.book_id = b.id
                                WHERE bb.user_id = '$user_id'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <nav id="user-nav">
        <span>
            <h2>Welcome, <?= $_SESSION['name'] ?>!</h2>
        </span>
        <span>
            <form method="POST" class="search">
                <input type="text" name="search" placeholder="Search books...">
                <button type="submit">Search</button>
            </form>
        </span>
        <button id="user-logout-btn">
            <a href="logout.php">Logout</a>
        </button>
    </nav>
    <div class="user-container">

        <h3 style="margin-bottom: 20px;">Available Books</h3>
        <div class="table-container">

            <table border="1" style="text-align: center; ">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
                <?php while ($book = $books->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $book['title'] ?></td>
                        <td><?= $book['author'] ?></td>
                        <td><?= $book['genre'] ?></td>
                        <td><?= $book['quantity'] ?></td>
                        <td>
                            <?php if ($book['quantity'] > 0) { ?>
                                <button id="borrow-btn">
                                    <a href="borrow_books.php?id=<?= $book['id'] ?>">Borrow</a>
                                </button>
                            <?php } else { ?>
                                <span style="color:red;">Not Available</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <h3>Your Borrowed Books</h3>
        <div class="table-container">

            <table border="1">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
                <?php while ($borrowed = $borrowed_books->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $borrowed['title'] ?></td>
                        <td><?= $borrowed['author'] ?></td>
                        <td><?= $borrowed['borrow_date'] ?></td>
                        <td><?= $borrowed['due_date'] ?></td>
                        <td>
                            <button>

                                <a href="return_book.php?id=<?= $borrowed['id'] ?>">Return</a>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>