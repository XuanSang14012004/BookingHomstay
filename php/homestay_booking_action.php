<?php
include 'config.php'; // Kết nối database

// Thêm hoặc sửa booking
if (isset($_POST['action']) && $_POST['action'] == "save") {
    $id = $_POST['id'];
    $customerName = $_POST['customerName'];
    $customerEmail = $_POST['customerEmail'];
    $customerNumber = $_POST['customerNumber'];
    $homestayName = $_POST['homestayName'];
    $bookingDate = $_POST['bookingDate'];
    $bookingStatus = $_POST['bookingStatus'];

    if ($id == "") {
        // Thêm mới
        $sql = "INSERT INTO booking (customerName, customerEmail, customerNumber, homestayName, bookingDate, bookingStatus) 
                VALUES ('$customerName','$customerEmail','$customerNumber','$homestayName','$bookingDate','$bookingStatus')";
    } else {
        // Cập nhật
        $sql = "UPDATE booking SET 
                    customerName='$customerName',
                    customerEmail='$customerEmail',
                    customerNumber='$customerNumber',
                    homestayName='$homestayName',
                    bookingDate='$bookingDate',
                    bookingStatus='$bookingStatus'
                WHERE id=$id";
    }

    if ($conn->query($sql)) {
        echo "success";
    } else {
        echo "error: " . $conn->error;
    }
    exit;
}

// Xóa booking
if (isset($_POST['action']) && $_POST['action'] == "delete") {
    $id = $_POST['id'];
    if ($conn->query("DELETE FROM booking WHERE id=$id")) {
        echo "success";
    } else {
        echo "error: " . $conn->error;
    }
    exit;
}

// Lấy dữ liệu booking theo id (dùng khi sửa)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM booking WHERE id=$id");
    if($result->num_rows > 0){
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }
    exit;
}
?>
