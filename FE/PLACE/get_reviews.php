<?php
include_once('../../BE/Config/connect.php');

header('Content-Type: application/json; charset=UTF-8');

// ---------- KIỂM TRA THAM SỐ ----------
if (!isset($_GET['homestay_id']) || empty($_GET['homestay_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "missing_homestay_id"
    ]);
    exit;
}

$homestay_id = intval($_GET['homestay_id']);
$reviews = [];

// ---------- TRUY VẤN DỮ LIỆU ----------
$sql = "
    SELECT 
        r.rating, 
        r.review, 
        DATE_FORMAT(r.created_at, '%d/%m/%Y') AS created_at,
        c.fullname AS customer_name
    FROM db_review r
    INNER JOIN db_customer c ON r.customer_id = c.customer_id
    WHERE r.homestay_id = ?
    ORDER BY r.created_at DESC
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "prepare_failed"
    ]);
    exit;
}

$stmt->bind_param("i", $homestay_id);
$stmt->execute();
$result = $stmt->get_result();

// ---------- XỬ LÝ KẾT QUẢ ----------
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = [
            "customer_name" => $row["customer_name"],
            "rating"        => (int)$row["rating"],
            "review"        => $row["review"],
            "created_at"    => $row["created_at"]
        ];
    }

    echo json_encode([
        "status" => "success",
        "count"  => count($reviews),
        "reviews" => $reviews
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "count"  => 0,
        "reviews" => []
    ]);
}

$stmt->close();
$conn->close();