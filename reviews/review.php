<?php
header('Content-Type: application/json');
include 'db_connection.php'; // Kết nối đến database

$accommodation_id = $_GET['id']; // Lấy ID của homestay từ URL

// Lấy tổng quan đánh giá
$sql_summary = "
    SELECT 
        AVG(rating) as avg_rating,
        COUNT(review_id) as total_reviews
    FROM reviews 
    WHERE accommodation_id = ?
";
$stmt_summary = $conn->prepare($sql_summary);
$stmt_summary->bind_param("i", $accommodation_id);
$stmt_summary->execute();
$result_summary = $stmt_summary->get_result();
$summary = $result_summary->fetch_assoc();

// Lấy danh sách đánh giá chi tiết
$sql_reviews = "
    SELECT 
        u.username, r.rating, r.comment, r.created_at, r.rating_sub_scores
    FROM reviews r
    JOIN users u ON r.user_id = u.user_id
    WHERE r.accommodation_id = ?
    ORDER BY r.created_at DESC
";
$stmt_reviews = $conn->prepare($sql_reviews);
$stmt_reviews->bind_param("i", $accommodation_id);
$stmt_reviews->execute();
$result_reviews = $stmt_reviews->get_result();
$reviews = [];
while ($row = $result_reviews->fetch_assoc()) {
    $row['rating_sub_scores'] = json_decode($row['rating_sub_scores'], true);
    $reviews[] = $row;
}

echo json_encode(['summary' => $summary, 'reviews' => $reviews]);

$conn->close();
?>