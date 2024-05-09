<?php
$host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "spmsa_db";

$conn=mysqli_connect($host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>