<?php
session_start();
include_once('../../BE/Config/connect.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain; charset=utf-8');

// -----------------------------
// 1️⃣ Kiểm tra request hợp lệ
// -----------------------------
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "invalid_request_method";
    exit;
}

if (!isset($_POST['booking_id'], $_POST['rating'], $_POST['review'])) {
    echo "missing_params";
    exit;
}

// -----------------------------
// 2️⃣ Kiểm tra đăng nhập (Sửa key Session)
// -----------------------------
if (!isset($_SESSION['account_id'])) { // SỬA TẠI ĐÂY: Dùng key 'account_id'
    echo "not_logged_in";
    exit;
}

// Lấy và làm sạch dữ liệu
$customer_id = intval($_SESSION['account_id']); // SỬA TẠI ĐÂY: Lấy ID bằng key 'account_id'
$booking_id  = intval($_POST['booking_id']);
$rating      = intval($_POST['rating']);
$review      = trim($_POST['review']);

// -----------------------------
// 3️⃣ Lấy thông tin booking (Sử dụng Prepared Statement)
// -----------------------------
$get_info_sql = "
    SELECT homestay_id 
    FROM db_booking 
    WHERE booking_id = ? AND customer_id = ?
";
$stmt_info = $conn->prepare($get_info_sql);

if (!$stmt_info) {
    echo "prepare_info_failed: " . $conn->error;
    exit;
}

$stmt_info->bind_param("ii", $booking_id, $customer_id);
$stmt_info->execute();
$info_result = $stmt_info->get_result();
$stmt_info->close();

if ($info_result->num_rows === 0) {
    echo "booking_not_found";
    exit;
}

$info = $info_result->fetch_assoc();
$homestay_id = intval($info['homestay_id']);


// -----------------------------
// 4️⃣ Kiểm tra xem đã có review chưa (Sử dụng Prepared Statement)
// -----------------------------
$check_sql = "
    SELECT review_id 
    FROM db_review 
    WHERE booking_id = ? AND customer_id = ?
";
$stmt_check = $conn->prepare($check_sql);

if (!$stmt_check) {
    echo "prepare_check_failed: " . $conn->error;
    exit;
}

$stmt_check->bind_param("ii", $booking_id, $customer_id);
$stmt_check->execute();
$check_result = $stmt_check->get_result();
$stmt_check->close(); 

if ($check_result->num_rows > 0) {
    // Đã có → UPDATE (Sử dụng Prepared Statement)
    $update_sql = "
        UPDATE db_review 
        SET 
            rating = ?, 
            review = ?, 
            homestay_id = ?, 
            updated_at = NOW() 
        WHERE booking_id = ? AND customer_id = ?
    ";
    
    $stmt_update = $conn->prepare($update_sql);

    if (!$stmt_update) {
        echo "prepare_update_failed: " . $conn->error;
        exit;
    }
    
    // Tham số: i(rating), s(review), i(homestay_id), i(booking_id), i(customer_id)
    $stmt_update->bind_param("isiii", $rating, $review, $homestay_id, $booking_id, $customer_id);

    if ($stmt_update->execute()) {
        echo "success";
    } else {
        echo "update_failed: " . $stmt_update->error;
    }
    $stmt_update->close();
} else {
    // Chưa có → INSERT (Sử dụng Prepared Statement)
    $insert_sql = "
        INSERT INTO db_review (booking_id, homestay_id, customer_id, rating, review, created_at) 
        VALUES (?, ?, ?, ?, ?, NOW())
    ";

    $stmt_insert = $conn->prepare($insert_sql);
    
    if (!$stmt_insert) {
        echo "prepare_insert_failed: " . $conn->error;
        exit;
    }

    // Tham số: i(booking_id), i(homestay_id), i(customer_id), i(rating), s(review)
    $stmt_insert->bind_param("iiiis", $booking_id, $homestay_id, $customer_id, $rating, $review);

    if ($stmt_insert->execute()) {
        echo "success";
    } else {
        echo "insert_failed: " . $stmt_insert->error;
    }
    $stmt_insert->close();
}

// -----------------------------
// 5️⃣ Đóng kết nối
// -----------------------------
$conn->close();