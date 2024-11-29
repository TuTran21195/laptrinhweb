<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_an_db2024";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM menu WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Xóa món ăn thành công!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>