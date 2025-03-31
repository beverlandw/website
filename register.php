<?php
include 'mysqlconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];

    // check if the username exists
    $checkUser = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$username'");
    
    if (mysqli_num_rows($checkUser) > 0) {
        echo "Username already taken.";
    } else {
        $sql = "INSERT INTO users (username, password, email, full_name, address) 
                VALUES ('$username', '$password', '$email', '$full_name', '$address')";
        
        if (mysqli_query($mysqli, $sql)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . mysqli_error($mysqli);
        }
    }
}
?>  