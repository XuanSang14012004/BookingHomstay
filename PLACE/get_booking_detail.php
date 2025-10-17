<?php
header('Content-Type: application/json'); // BẮT BUỘC: Khai báo phản hồi là JSON

include_once('../../BE/Config/connect.php');

// Bật hiển thị lỗi PHP (chỉ nên dùng khi debug)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Lấy ID và kiểm tra hợp lệ
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode(null);
    exit;
}

// Thêm các trường thiếu: status, payment_method (từ db_booking) và address (từ db_homestay)
$sql = "SELECT b.booking_id, b.homestay_id,b.homestay_id, b.checkin_date, b.checkout_date, b.guests, b.total_price, b.status, b.payment_method, 
              h.homestay_name, h.img AS homestay_img, h.address, 
              c.fullname AS customer_name, c.email AS customer_email, c.phone AS customer_phone
        FROM db_booking b
        JOIN db_homestay h ON b.homestay_id = h.homestay_id
        JOIN db_account c ON b.customer_id = c.account_id
        WHERE b.booking_id = ?";

// Kiểm tra kết nối
if ($conn->connect_error) {
    // Trả về lỗi JSON nếu kết nối thất bại
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    // Trả về lỗi JSON nếu prepare thất bại
    echo json_encode(["error" => "SQL Prepare failed: " . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$stmt->close();
$conn->close();

// Trả về dữ liệu (có thể là null nếu không tìm thấy đơn)
if ($data === null) {
    // Để tránh gửi array rỗng, có thể gửi null hoặc một object rỗng tùy ý
    echo json_encode(null);
} else {
    echo json_encode($data);
}

exit;