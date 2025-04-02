<?php
session_start();
include "mysqlconnect.php";

if (isset($_SESSION['username'])) {
    echo "Logged in as: " . $_SESSION['username'] . " | <a href='logout.php'>Logout</a><br><br>";
} else {
    echo "You are not logged in. <a href='login_register.html'>Login</a><br><br>";
}

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $book_id = $_POST['book_id'];
    $quantity = $_POST['quantity'];

    // If cart doesn't exist yet
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If item already in cart, update quantity
    if (isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id] += $quantity;
    } else {
        $_SESSION['cart'][$book_id] = $quantity;
    }

    echo "Book added to cart. <a href='simple_shopping_cart.php'>View Cart</a>";
    exit;
}

// Remove from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    echo "Item removed from cart.<br><br>";
}

// Display cart
echo "<h1>Your Shopping Cart</h1>";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit;
}

// Get book info for all items in cart
$ids = implode(",", array_keys($_SESSION['cart']));
$sql = "SELECT * FROM books WHERE book_id IN ($ids)";
$result = mysqli_query($mysqli, $sql);

$total = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $book_id = $row['book_id'];
    $title = $row['title'];
    $price = $row['price'];
    $quantity = $_SESSION['cart'][$book_id];
    $subtotal = $price * $quantity;
    $total += $subtotal;

    echo "Title: $title<br>";
    echo "Price: \$$price<br>";
    echo "Quantity: $quantity<br>";
    echo "Subtotal: \$$subtotal<br>";
    echo "<a href='simple_shopping_cart.php?remove=$book_id'>Remove</a><br><br>";
}

echo "<strong>Total: \$$total</strong><br><br>";
echo "<a href='checkout.php'>Proceed to Checkout</a>";
?>
