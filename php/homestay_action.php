<?php
include 'config.php';

// Thêm mới hoặc cập nhật
if (isset($_POST['action']) && $_POST['action'] == "save") {
    $id           = $_POST['id'];
    $nameHomestay = $_POST['nameHomestay'];
    $typeRooms    = $_POST['typeRooms'];
    $numberRooms  = $_POST['numberRooms'];
    $status       = $_POST['status'];
    $prices       = $_POST['prices'];
    $description  = $_POST['description'];

    // upload ảnh
    $imgName = "";
    if (isset($_FILES['imgs']) && $_FILES['imgs']['error'] == 0) {
        $imgName = time() . "_" . basename($_FILES['imgs']['name']);
        move_uploaded_file($_FILES['imgs']['tmp_name'], "../images/" . $imgName);
    }

    if ($id == "") {
        // thêm mới
        $sql = "INSERT INTO admin (nameHomestay, typeRooms, numberRooms, status, prices, imgs, description) 
                VALUES ('$nameHomestay','$typeRooms','$numberRooms','$status','$prices','$imgName','$description')";
    } else {
        // cập nhật
        $sql = "UPDATE admin 
                SET nameHomestay='$nameHomestay', typeRooms='$typeRooms', numberRooms='$numberRooms',
                    status='$status', prices='$prices', description='$description'";

        if ($imgName != "") {
            $sql .= ", imgs='$imgName'";
        }
        $sql .= " WHERE id=$id";
    }
    $conn->query($sql);
    echo "success";
    exit;
}

// Xóa homestay
if (isset($_POST['action']) && $_POST['action'] == "delete") {
    $id = $_POST['id'];
    $conn->query("DELETE FROM admin WHERE id=$id");
    echo "success";
    exit;
}

// Lấy dữ liệu theo id (sửa)
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM admin WHERE id=$id");
    echo json_encode($result->fetch_assoc());
    exit;
}
