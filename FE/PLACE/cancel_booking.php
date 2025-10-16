<?php
include_once('../../BE/Config/connect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);

    // ✅ Chỉ cho phép hủy nếu đang "pending"
    $sql = "UPDATE db_booking SET status='cancelled' WHERE booking_id=? AND status='Chờ xác nhận'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "success";
    } else {
        echo "not_allowed"; // hoặc "error" nếu muốn
    }
}