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
$ten_mon = $_POST['ten_mon'];
$gia = $_POST['gia'];
$loai = $_POST['loai'];
$hien_thi = $_POST['hien_thi'];
$mo_ta = $_POST['mo_ta'];
$hinh_anh = '';

if(isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0){
    $target_dir = "../uploads/";
    
    $target_file = $target_dir . basename($_FILES["hinh_anh"]["name"]);
    if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
        $hinh_anh = $target_file;
    } else {
        echo "Có lỗi xảy ra khi tải lên hình ảnh.";
        exit;
    }
}

$sql = "UPDATE menu SET ten_mon='$ten_mon', gia='$gia', loai='$loai', hien_thi='$hien_thi', mo_ta='$mo_ta'";
if ($hinh_anh) {
    $sql .= ", hinh_anh='$hinh_anh'";
}
$sql .= " WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Cập nhật món ăn thành công!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>