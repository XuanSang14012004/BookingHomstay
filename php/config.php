<?php
$servername = "localhost";
$username   = "root";     // tài khoản MySQL
$password   = "";         // mật khẩu MySQL
$database   = "homestay_db";  // tên database

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>