<?php
session_start();
include "mysqlconnect.php";

if (isset($_SESSION['username'])) {
    echo "Logged in as: " . $_SESSION['username'] . " | <a href='logout.php'>Logout</a><br><br>";
} else {
    echo "You are not logged in. <a href='login_register.html'>Login</a><br><br>";
}

if (!isset($_GET['id'])) {
    echo "No book selected.";
    exit;
}

$book_id = $_GET['id'];

$sql = "SELECT * FROM books WHERE book_id = $book_id";
$result = mysqli_query($mysqli, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Book not found.";
    exit;
}

$book = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $book['title']; ?> - Book Details</title>
</head>
<body>

<h1><?php echo $book['title']; ?></h1>
Author: <?php echo $book['author']; ?><br>
Price: $<?php echo $book['price']; ?><br>
Category: <?php echo $book['category']; ?><br>
Stock: <?php echo $book['stock']; ?><br><br>

<?php
if ($book['image_url']) {
    echo "<img src='" . $book['image_url'] . "' alt='" . $book['title'] . "' height='200'><br><br>";
}
?>

<!-- Optional: Add to Cart button -->
<form action="simple_shopping_cart.php" method="POST">
    <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
    Quantity: <input type="number" name="quantity" value="1" min="1" max="<?php echo $book['stock']; ?>"><br><br>
    <button type="submit" name="add_to_cart">Add to Cart</button>
</form>

</body>
</html>
