<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "bookstore"; 

$mysqli = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
printf("Connect failed: %s\n <br/>", mysqli_connect_error());
exit();
} else {
printf("Host information: %s\n <br/>", mysqli_get_host_info($mysqli));
}

?>