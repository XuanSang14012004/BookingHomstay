<?php
session_start();
include_once('../../BE/Config/connect.php');

if (!isset($_SESSION['customer_id'])) {
    echo "not_logged_in";
    exit;
}

$customer_id = intval($_SESSION['customer_id']);
$booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$review = isset($_POST['review']) ? trim($_POST['review']) : '';

// Lấy homestay_id từ booking
$stmt = $conn->prepare("SELECT homestay_id, status FROM db_booking WHERE booking_id = ? AND customer_id = ? LIMIT 1");
$stmt->bind_param("ii", $booking_id, $customer_id);
$stmt->execute();
$res = $stmt->get_result();
$booking = $res->fetch_assoc();

if (!$booking) {
    echo "error";
    exit;
}

// Chỉ cho đánh giá nếu booking đã xác nhận
if (!in_array($booking['status'], ['Đã xác nhận', 'Đã thanh toán'])) {
    echo "error";
    exit;
}

$homestay_id = $booking['homestay_id'];

// Kiểm tra xem khách đã đánh giá chưa
$stmt = $conn->prepare("SELECT * FROM db_review WHERE booking_id = ? LIMIT 1");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    // Cập nhật review cũ
    $stmt = $conn->prepare("UPDATE db_review SET rating = ?, review = ?, created_at = NOW() WHERE booking_id = ?");
    $stmt->bind_param("isi", $rating, $review, $booking_id);
    $stmt->execute();
} else {
    // Thêm review mới
    $stmt = $conn->prepare("INSERT INTO db_review (booking_id, homestay_id, customer_id, rating, review, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiiis", $booking_id, $homestay_id, $customer_id, $rating, $review);
    $stmt->execute();
}

echo "success";
$conn->close();