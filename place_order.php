<?php
session_start();
include "mysqlconnect.php";

if (!isset($_POST['place_order']) || empty($_SESSION['cart'])) {
    echo "Invalid request.";
    exit;
}

$full_name = $_POST['full_name'];
$address = $_POST['address'];

// Get user_id from session username
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_query = mysqli_query($mysqli, "SELECT user_id FROM users WHERE username='$username'");
    if (!$user_query) {
        die("Error fetching user: " . mysqli_error($mysqli));
    }
    $user_data = mysqli_fetch_assoc($user_query);
    $user_id = $user_data['user_id'];
} else {
    echo "You must be logged in to place an order.";
    exit;
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $book_id => $quantity) {
    $price_result = mysqli_query($mysqli, "SELECT price FROM books WHERE book_id = $book_id");
    $row = mysqli_fetch_assoc($price_result);
    $total += $row['price'] * $quantity;
}

// Insert order
$sql_order = "INSERT INTO orders (user_id, total_price, status) VALUES ('$user_id', '$total', 'pending')";
if (!mysqli_query($mysqli, $sql_order)) {
    die("Error inserting order: " . mysqli_error($mysqli));
}

$order_id = mysqli_insert_id($mysqli);

// Insert each item
foreach ($_SESSION['cart'] as $book_id => $quantity) {
    $sql_item = "INSERT INTO order_items (order_id, book_id, quantity)
                 VALUES ($order_id, $book_id, $quantity)";
    mysqli_query($mysqli, $sql_item);
}

// Clear the cart
unset($_SESSION['cart']);

// Show confirmation
echo "<h1>Order Placed!</h1>";
echo "Thank you, $full_name.<br>";
echo "Your order number is <strong>#$order_id</strong>.<br>";
echo "<a href='index.php'>Back to Home</a>";
?>
