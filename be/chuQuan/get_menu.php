<?php

$conn = new mysqli("localhost", "root", "", "quan_an_db2024");

// header('Content-Type: application/json');
// $response = array(); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM menu WHERE ten_mon LIKE '%$search%'";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    echo '<table class="table">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Tên món</th>
            <th>Ảnh</th>
            <th>Giá món</th>
            <th>Mô tả</th>
            <th>Loại</th>
            <th>Hiển thị</th>
            <th>Thao tác</th>
          </tr>
        </thead>
        <tbody>
    ';
    $index = 1;
    while($row = $result->fetch_assoc()) {
        // Thay thế ../ bằng ../be/ trong đường dẫn hình ảnh
        $hinh_anh_moi = str_replace('../', '../be/', $row['hinh_anh']);
        $hien_thi= $row['hien_thi']?'<i title= "Hiện" class="fa fa-eye"></i>':'<i title= "Ẩn" class="fa fa-eye-slash"></i>';
        $id_mon_an= $row['id'];
        // number_format: Hàm này định dạng một số với các dấu phân cách hàng nghìn. 
        // Tham số thứ hai là số chữ số thập phân (0 trong trường hợp này),
        //  tham số thứ ba là dấu phân cách thập phân (,), và tham số thứ tư là dấu phân cách hàng nghìn (.).
        $gia_vnd = number_format($row['gia'], 0, ',', '.') . ' vnđ';

        echo "<tr>";
        echo "<td>" . $index++ . "</td>";
        echo "<td>" . $row['ten_mon'] . "</td>";
        echo "<td class='img-col'><img src='" . $hinh_anh_moi . "' class='img-thumbnail' class='img-col'alt='Hình ảnh'></td>";
        echo "<td>" . $gia_vnd. "</td>";
        echo "<td>" . $row['mo_ta'] . "</td>";
        echo "<td>" . $row['loai'] . "</td>";
        echo "<td style='text-align: center;'>". $hien_thi ."</td>";
        echo "<td>";
        echo "<button title='Sửa' class='btn btn-warning suaMonAn' id = 'suaID" .$id_mon_an. "'><i class='fa fa-pencil'></i></button> ";
        echo "<button title='Xóa' class='btn btn-danger xoaMonAn' id = 'xoaID" .$id_mon_an. "'><i class='fa fa-trash'></i></button>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "0 results";
}
