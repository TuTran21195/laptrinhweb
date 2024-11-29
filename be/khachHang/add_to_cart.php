<?php
session_start();
$user_id = $_SESSION['user_id'];
$food_id = $_POST['food_id'];
$quantity = $_POST['quantity'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_an_db2024";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO cart (user_id, food_id, quantity) VALUES ('$user_id', '$food_id', '$quantity')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>