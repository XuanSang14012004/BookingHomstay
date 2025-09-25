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
// -------------------- PHẦN THÊM --------------------

// Bật báo lỗi cho MySQLi (dùng để debug dễ hơn)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Hàm đóng kết nối (có thể gọi ở cuối file PHP khi cần)
function closeDB($conn) {
    if ($conn) {
        $conn->close();
    }
}

// Hàm thực thi câu lệnh SELECT nhanh
function queryDB($sql) {
    global $conn;
    $result = $conn->query($sql);
    if ($result === false) {
        die("Lỗi truy vấn: " . $conn->error);
    }
    return $result;
}

// Hàm chống SQL Injection cho input
function safeInput($data) {
    global $conn;
    return htmlspecialchars($conn->real_escape_string(trim($data)));
}

?>