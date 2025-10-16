<?php
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Thêm hoặc sửa phòng
if(isset($_POST['action']) && $_POST['action'] == "save"){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $prices = $_POST['prices'];
    $quantity = $_POST['quantity'];
    $status = $_POST['statusRooms'];

    if(empty($id)){
        // Thêm phòng mới
        $stmt = $conn->prepare("INSERT INTO rooms (name, prices, quantity, statusRooms) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdis", $name, $prices, $quantity, $status);
    } else {
        // Cập nhật phòng
        $stmt = $conn->prepare("UPDATE rooms SET name=?, prices=?, quantity=?, statusRooms=? WHERE id=?");
        $stmt->bind_param("sdisi", $name, $prices, $quantity, $status, $id);
    }

    if($stmt->execute()){
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }
    $stmt->close();
    exit;
}

// Xóa phòng
if(isset($_POST['action']) && $_POST['action'] == "delete"){
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id=?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }
    $stmt->close();
    exit;
}

// Lấy thông tin phòng theo ID
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM rooms WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_assoc());
    $stmt->close();
    exit;
}
?>
