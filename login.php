<?php
session_start();
include 'mysqlconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['login_username'];
    $password = $_POST['login_password'];

    // check if username and password match with database
    $result = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($result) > 0) {
        // Login successful, start the session
        $_SESSION['username'] = $username;
        echo "Login successful!";
        header("Location: welcome.php"); // Redirect to a welcome page or dashboard after login
        exit();
    } else {
        echo "Invalid username or password.";
    }
}

// Logout logic
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    logout();
}

function logout() {
    // Destroy session data
    session_unset();
    session_destroy();
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    displayPage();
} else {
    displayLoginForm();
}

function displayPage() {
    echo "<h1>Welcome, " . $_SESSION['username'] . "!</h1>";
    echo "<p>You are currently logged in.</p>";
    echo "<p><a href='?action=logout'>Logout</a></p>";
}

function displayLoginForm($message = "") {
    echo "<h1>Login</h1>";
    if ($message) {
        echo '<p class="error">' . $message . '</p>';
    }
    ?>
    <form action="login.php" method="post">
        <div style="width: 30em;">
            <label for="login_username">Username</label>
            <input type="text" name="login_username" id="login_username" value="" required />
            <label for="login_password">Password</label>
            <input type="password" name="login_password" id="login_password" value="" required />
            <div style="clear: both;">
                <input type="submit" value="Login" />
            </div>
        </div>
    </form>
    <?php
}
?>
