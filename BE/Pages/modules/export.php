<?php
include "../../config/connect.php";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=booking_data.csv');

$output = fopen('php://output', 'w');

fputcsv($output, array('ID', 'Khách hàng', 'Homestay', 'Giá', 'Ngày đặt'));

$sql = "SELECT * FROM db_booking";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
exit;
?>
