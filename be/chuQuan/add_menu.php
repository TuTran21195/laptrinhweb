<?php

$conn = new mysqli("localhost", "root", "", "quan_an_db2024");

// header('Content-Type: application/json');
// $response = array(); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ten_mon = $_POST['ten_mon'];
$gia = $_POST['gia'];
$loai = $_POST['loai'];
$hien_thi = $_POST['hien_thi'];
$mo_ta = $_POST['mo_ta'];
$hinh_anh = '';

if(isset($_FILES['hinh_anh'])){
    // Hiện tại mình đang ở thư mục be/chuQuan và mình muốn upload những hình mà người dùng họ upload vào cái thư mục be/uploads
    // thì mình cần phải thoát khỏi thư mục chuQuan -> ra đc folder be rồi vào thư mục uploads
    $target_dir = "../uploads/";
    
    // Lấy đường dẫn của file
    $target_file = $target_dir . basename($_FILES["hinh_anh"]["name"]);
    // Di chuyển file đến thư mục đích
    if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
        $hinh_anh = $target_file;
    } else {
        // $response['status'] = 'error';
        // $response['message'] = "Có lỗi xảy ra khi tải lên hình ảnh.";
        echo "Có lỗi xảy ra khi tải lên hình ảnh.";
    }
}

$sql = "INSERT INTO menu (ten_mon, gia, loai, hien_thi, mo_ta, hinh_anh) VALUES ('$ten_mon', '$gia', '$loai', '$hien_thi', '$mo_ta', '$hinh_anh')";

if ($conn->query($sql) === TRUE) {
    // $response['status'] = 'success';
    echo "Thêm món mới thành công. <br> Món mới đã được lưu trong CSDL.";
} else {
    // $response['status'] = 'error';
    // $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
    echo "Có lỗi xảy ra khi lưu món vào CSDL: " . $sql . "<br>" . $conn->error;
}

// echo json_encode($response);

$conn->close();

?>