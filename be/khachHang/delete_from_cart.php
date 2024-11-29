<?php
session_start();
$user_id = $_SESSION['user_id'];
$items = $_POST['items'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_an_db2024";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach ($items as $item_id) {
    $sql = "DELETE FROM cart WHERE id = '$item_id' AND user_id = '$user_id'";
    $conn->query($sql);
}

$conn->close();

echo "Items deleted successfully";
?>