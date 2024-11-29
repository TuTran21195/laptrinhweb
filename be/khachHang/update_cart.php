<?php
session_start();
$user_id = $_SESSION['user_id'];
$updates = $_POST['updates'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_an_db2024";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach ($updates as $update) {
    $item_id = $update['id'];
    $quantity = $update['quantity'];
    $sql = "UPDATE cart SET quantity = '$quantity' WHERE id = '$item_id' AND user_id = '$user_id'";
    $conn->query($sql);
}

$conn->close();

echo "Cart updated successfully";
?>