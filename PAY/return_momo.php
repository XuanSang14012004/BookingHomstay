<?php
include '../db.php'; // Kết nối CSDL

// MoMo sẽ trả về các tham số qua GET hoặc POST
$booking_id = $_GET['orderId'] ?? null;
$resultCode = $_GET['resultCode'] ?? null;

if ($booking_id && $resultCode == "0") { // 0 = Thanh toán thành công
    $sql = "UPDATE bookings SET status='paid' WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        // Sau khi update thành công thì chuyển về history
        header("Location: ../PLACE/history.php?msg=success");
        exit;
    }
} else {
    header("Location: ../PLACE/history.php?msg=fail");
    exit;
}
?>
