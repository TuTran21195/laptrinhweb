<?php

$conn = new mysqli("localhost", "root", "", "quan_an_db2024");

header('Content-Type: application/json');
$response = array(); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_tim_kiem = $_GET['id'];

$sql = "SELECT * FROM menu WHERE id = $id_tim_kiem";
$result = $conn->query($sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $ans = mysqli_fetch_assoc($result);
        $response['id'] = $ans['id'];
        $response['ten_mon'] = $ans['ten_mon'];
        $response['gia'] = $ans['gia'];
        $response['loai'] = $ans['loai'];
        $response['hien_thi'] = $ans['hien_thi'];
        $response['mo_ta'] = $ans['mo_ta'];
        $response['hinh_anh'] = $ans['hinh_anh'];
    }
}

echo json_encode($response);