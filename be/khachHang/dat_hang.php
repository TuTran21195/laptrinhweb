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

// Tính tổng tiền đơn hàng
$sql = "SELECT SUM(c.quantity * m.gia) AS tong_tien FROM cart c JOIN menu m ON c.food_id = m.id WHERE c.user_id = '$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$tong_tien = $row['tong_tien'];

// Tạo đơn hàng mới
$ngay_dat = date('Y-m-d H:i:s');
$sql = "INSERT INTO orders (user_id, ngay_dat, tong_tien, trang_thai) VALUES ('$user_id', '$ngay_dat', '$tong_tien', 'unconfirmed')";
if ($conn->query($sql) === TRUE) {
    $order_id = $conn->insert_id;

    // Thêm các món vào bảng order_item
    $sql = "SELECT c.food_id, c.quantity, m.gia 
    FROM cart c 
    JOIN menu m ON c.food_id = m.id 
    WHERE c.user_id = '$user_id'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $food_id = $row['food_id'];
        $quantity = $row['quantity'];
        $don_gia = $row['gia'];
        $sql = "INSERT INTO order_item (order_id, food_id, so_luong, don_gia) VALUES ('$order_id', '$food_id', '$quantity', '$don_gia')";
        $conn->query($sql);
    }

    // Xóa giỏ hàng sau khi đặt hàng
    $sql = "DELETE FROM cart WHERE user_id = '$user_id'";
    $conn->query($sql);

    // Gửi thông điệp WebSocket
    // $context = new ZMQContext();
    // $socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'order update');
    // $socket->connect("tcp://localhost:5555");
    // $socket->send(json_encode(['message' => 'New order placed']));

    echo "Đặt hàng thành công!";
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>