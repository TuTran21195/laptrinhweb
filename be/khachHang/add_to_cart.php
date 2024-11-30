<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Bạn cần đăng nhập để thực hiện chức năng này!";
    exit();
}

$user_id = $_SESSION['user_id'];
$food_id = $_POST['food_id'];
$quantity = $_POST['quantity'];

$user_role = $_SESSION['role'];

if ($user_role != 'customer') {
    echo "Quyền của bạn không thực hiện được chức năng này!";
} else {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quan_an_db2024";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Kiểm tra xem món ăn đã tồn tại trong giỏ hàng chưa
    $sql_check = "SELECT quantity FROM cart WHERE user_id = '$user_id' AND food_id = '$food_id'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        // Nếu món ăn đã tồn tại, cập nhật số lượng
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $sql_update = "UPDATE cart SET quantity = '$new_quantity' WHERE user_id = '$user_id' AND food_id = '$food_id'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Cập nhật giỏ hàng thành công";
        } else {
            echo "Error: " . $sql_update . "<br>" . $conn->error;
        }
    } else {
        // Nếu món ăn chưa tồn tại, thêm mới vào giỏ hàng
        $sql_insert = "INSERT INTO cart (user_id, food_id, quantity) VALUES ('$user_id', '$food_id', '$quantity')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "Thêm vào giỏ hàng thành công";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>