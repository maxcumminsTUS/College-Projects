<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "ecommerce_K00319172";


$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>