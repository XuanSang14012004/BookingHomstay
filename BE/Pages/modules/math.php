<?php
require "../../Config/connect.php";
$sum_rating = 0;
$sum_review = 0;
$sum_revenues = 0; 

$count=
$sql = "SELECT sotien FROM db_thanhtoan WHERE 1";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $count= $row['sotien'];
$sum_revenues += $row['sotien'];
echo $count;

}
?>