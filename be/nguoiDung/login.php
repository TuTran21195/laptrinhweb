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
        $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                $response['status'] = 'success';
                $response['redirect'] = '../index.php';
            } else {
                $response['status'] = 'error';
                $response['message'] = "Sai Username hoặc Password";
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = "Lỗi truy vấn: " . mysqli_error($conn);
        }
    }
}
echo json_encode($response);
?>