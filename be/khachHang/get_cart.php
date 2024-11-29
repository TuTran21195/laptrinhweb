<?php
session_start();
$user_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_an_db2024";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT c.id, m.ten_mon AS name, c.quantity, m.gia AS price, m.hinh_anh AS image 
        FROM cart c 
        JOIN menu m ON c.food_id = m.id 
        WHERE c.user_id = '$user_id'";
$result = $conn->query($sql);

$cart_items = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }
}

$conn->close();

echo json_encode($cart_items);
?>