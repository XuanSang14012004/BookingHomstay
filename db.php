<?php
$host = "localhost";
$user = "root";       // mặc định XAMPP là root
$pass = "";           // mặc định XAMPP không có mật khẩu
$dbname = "bookinghomestay";

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8mb4");
mysqli_set_charset($conn, "utf8mb4");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
