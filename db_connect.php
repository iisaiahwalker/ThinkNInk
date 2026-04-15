<?php
$host = "db";
$username = "root";
$password = "rootpassword";
$dbname = "thinknink";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>