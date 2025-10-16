<?php
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['action']) && $_POST['action']=="save"){
    $id = $_POST['id'];
    $bookingID = $_POST['bookingID'];
    $customerName = $_POST['customerName'];
    $money = $_POST['money'];
    $datesPayments = $_POST['datesPayments'];
    $method = $_POST['method'];
    $statusPayment = $_POST['statusPayment'];

    if(empty($id)){
        $stmt = $conn->prepare("INSERT INTO payments (customerName, bookingID, money, datesPayments, method, statusPayment) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sidsss", $customerName, $bookingID, $money, $datesPayments, $method, $statusPayment);
    } else {
        $stmt = $conn->prepare("UPDATE payments SET customerName=?, bookingID=?, money=?, datesPayments=?, method=?, statusPayment=? WHERE id=?");
        $stmt->bind_param("sidsssi", $customerName, $bookingID, $money, $datesPayments, $method, $statusPayment, $id);
    }

    if($stmt->execute()){
        echo "success";
    } else {
        echo "error: ".$stmt->error;
    }
    exit;
}

if(isset($_POST['action']) && $_POST['action']=="delete"){
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM payments WHERE id=?");
    $stmt->bind_param("i",$id);
    if($stmt->execute()){
        echo "success";
    } else {
        echo "error: ".$stmt->error;
    }
    exit;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $conn->query("SELECT p.*, b.customerName FROM payments p LEFT JOIN booking b ON p.bookingID=b.id WHERE p.id=$id");
    echo json_encode($result->fetch_assoc());
    exit;
}
?>
