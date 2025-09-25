<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = intval($_POST['booking_id']);
    $rating = intval($_POST['rating']);
    $review = trim($_POST['review']);

    if ($booking_id > 0 && ($rating > 0 || $review != "")) {
        $sql = "INSERT INTO reviews (booking_id, rating, review) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $booking_id, $rating, $review);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "invalid";
    }
}
