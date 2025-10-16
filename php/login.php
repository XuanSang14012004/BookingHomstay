<?php
// filepath: d:\adminbooking\be_login.php

session_start();
$conn = new mysqli("localhost", "root", "", "homestay_db");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Kiểm tra tài khoản ( bảng users có trường username, password)
$sql = "SELECT * FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['username'] = $username;
    header("Location: admin.php");
    exit();
} else {
    echo "<script>alert('Sai tài khoản hoặc mật khẩu!'); window.location='login.html';</script>";
}

$stmt->close();
$conn->close();
?>