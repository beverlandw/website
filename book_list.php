<?php
session_start();
include "mysqlconnect.php";

if (isset($_SESSION['username'])) {
    echo "Logged in as: " . $_SESSION['username'] . " | <a href='logout.php'>Logout</a><br><br>";
} else {
    echo "You are not logged in. <a href='login_register.html'>Login</a><br><br>";
}



$sql = "SELECT * FROM books";
$result = mysqli_query($mysqli, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
</head>
<body>

<h1>Available Books</h1>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<h3>" . $row['title'] . "</h3>";
        echo "Author: " . $row['author'] . "<br>";
        echo "Price: $" . $row['price'] . "<br>";
        echo "Category: " . $row['category'] . "<br>";
        if ($row['image_url']) {
            echo "<img src='" . $row['image_url'] . "' alt='" . $row['title'] . "' height='150'><br>";
        }
        echo "<a href='book_details.php?id=" . $row['book_id'] . "'>View Details</a><br><br>";
    }
} else {
    echo "No books found.";
}
?>

</body>
</html>
