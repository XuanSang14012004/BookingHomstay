<?php
include 'config.php';

// Lấy dữ liệu người dùng theo id
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $conn->query("SELECT id, username, name, role FROM users WHERE id=$id");
    echo json_encode($result->fetch_assoc());
    exit;
}

// Thêm hoặc cập nhật người dùng
if(isset($_POST['action']) && $_POST['action'] == "save"){
    $id       = isset($_POST['id']) ? $_POST['id'] : "";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name     = $_POST['name'];
    $role     = $_POST['role'];

    // Kiểm tra trùng username
    if($id==""){
        $check = $conn->query("SELECT id FROM users WHERE username='$username'");
        if($check->num_rows > 0){
            echo "error: Username đã tồn tại!";
            exit;
        }
    } else {
        $check = $conn->query("SELECT id FROM users WHERE username='$username' AND id != $id");
        if($check->num_rows > 0){
            echo "error: Username đã tồn tại!";
            exit;
        }
    }

    // Mã hóa password nếu có
    $passwordHash = $password ? password_hash($password, PASSWORD_DEFAULT) : "";

    if($id==""){
        // Thêm mới
        $sql = "INSERT INTO users (username,password,name,role) VALUES ('$username','$passwordHash','$name','$role')";
    } else {
        // Cập nhật
        if($passwordHash != ""){
            $sql = "UPDATE users SET username='$username', password='$passwordHash', name='$name', role='$role' WHERE id=$id";
        } else {
            $sql = "UPDATE users SET username='$username', name='$name', role='$role' WHERE id=$id";
        }
    }

    if($conn->query($sql)){
        echo "success";
    } else {
        echo "error: ".$conn->error;
    }
    exit;
}

// Xóa người dùng
if(isset($_POST['action']) && $_POST['action'] == "delete"){
    $id = $_POST['id'];
    if($conn->query("DELETE FROM users WHERE id=$id")){
        echo "success";
    } else {
        echo "error: ".$conn->error;
    }
    exit;
}
?>
