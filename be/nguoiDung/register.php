<?php
session_start();

header('Content-Type: application/json');
$response = array(); 

$conn = new mysqli("localhost", "root", "", "quan_an_db2024");

if ($conn->connect_error) {
    echo "Kết nối CSDL thất bại: " . $conn->connect_error;
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sdt = $_POST['sdt'];

        // Kiểm tra xem sdt đã tồn tại chưa
        $check_query = "SELECT * FROM user WHERE sdt ='$sdt'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $response['status'] = 'error';
            $response['message'] = "Số điện thoại này đã dược đăng ký!";
        } else {
            // Thêm người dùng mới vào cơ sở dữ liệu
            $query = "INSERT INTO user (username, password, sdt) VALUES ('$username', '$password', '$sdt')";
            if (mysqli_query($conn, $query)) {
                $response['status'] = 'success';
            } else {
                $response['status'] = 'error';
                $response['message'] = "Lỗi truy vấn: " . mysqli_error($conn);
            }
        }
    }
}

echo json_encode($response);
?>