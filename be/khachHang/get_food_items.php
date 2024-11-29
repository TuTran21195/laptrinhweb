<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_an_db2024";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$type = isset($_GET['type']) ? $_GET['type'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM menu WHERE hien_thi = 1";
if ($type) {
    $sql .= " AND loai = '$type'";
}
if ($search) {
    $sql .= " AND ten_mon LIKE '%$search%'";
}
$result = $conn->query($sql);


$food_items = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // chỉ món nào hien_thi == 1 thì mới cho vào menu cho khách xem thôi
        if ($row['hien_thi']){
            $food_items[] = $row;
        }
    }
}

$conn->close();

echo json_encode($food_items);
?>