<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);

    // ✅ Chỉ cho phép hủy nếu đang "pending"
    $sql = "UPDATE bookings SET status='cancelled' WHERE id=? AND status='pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo "success";
    } else {
        echo "not_allowed"; // hoặc "error" nếu muốn
    }
}
