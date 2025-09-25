<?php
include '../db.php';
header("Content-Type: application/json; charset=UTF-8");

$booking_id = intval($_GET['booking_id'] ?? 0);

if ($booking_id > 0) {
    $sql = "SELECT r.*, b.customer_name, b.customer_email 
            FROM reviews r
            JOIN bookings b ON r.booking_id = b.id
            WHERE r.booking_id = ?
            ORDER BY r.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    echo json_encode($reviews, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([]);
}

$conn->close();
