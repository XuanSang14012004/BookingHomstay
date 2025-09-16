<?php
header('Content-Type: application/json');
include 'db_connection.php';

// Kiểm tra xem người dùng đã đăng nhập chưa (có session hay cookie)
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn phải đăng nhập để đánh giá.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu từ POST request

$accommodation_id = $data['accommodation_id'];
$rating = $data['rating'];
$comment = $data['comment'];
$sub_scores = json_encode($data['sub_scores']);

// Chèn dữ liệu vào bảng reviews
$sql = "INSERT INTO reviews (accommodation_id, user_id, rating, comment, rating_sub_scores) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iids", $accommodation_id, $user_id, $rating, $comment, $sub_scores);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Đánh giá của bạn đã được gửi thành công.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại.']);
}

$conn->close();
?>