<?php
session_start();
include "mysqlconnect.php";

if (isset($_SESSION['username'])) {
    echo "Logged in as: " . $_SESSION['username'] . " | <a href='logout.php'>Logout</a><br><br>";
} else {
    echo "You are not logged in. <a href='login_register.html'>Login</a><br><br>";
}

// Make sure the cart is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit;
}

// Fetch book details
$ids = implode(",", array_keys($_SESSION['cart']));
$sql = "SELECT * FROM books WHERE book_id IN ($ids)";
$result = mysqli_query($mysqli, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>

<h1>Checkout</h1>

<h2>Your Order:</h2>
<?php
$total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $book_id = $row['book_id'];
    $title = $row['title'];
    $price = $row['price'];
    $quantity = $_SESSION['cart'][$book_id];
    $subtotal = $price * $quantity;
    $total += $subtotal;

    echo "$title - $quantity x \$$price = \$$subtotal<br>";
}
echo "<br><strong>Total: \$$total</strong><br><br>";
?>

<h2>Customer Information</h2>
<form action="place_order.php" method="POST">
    Full Name: <input type="text" name="full_name" required><br><br>
    Address: <input type="text" name="address" required><br><br>
    <button type="submit" name="place_order">Place Order</button>
</form>

</body>
</html>
