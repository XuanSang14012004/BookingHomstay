<?php
session_start();
require_once('../../config/db.php');

if (isset($_POST['signUp'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash mật khẩu
    $role = "user";

    $stmt = $conn->prepare("SELECT * FROM db_account WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: login.php?error=Email đã tồn tại");
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO db_account (fullname,email,phone,password,role) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $fullname, $email, $phone, $password, $role);
        if ($stmt->execute()) {
            header("Location: login.php?success=Đăng ký thành công");
            exit();
        } else {
            header("Location: login.php?error=Đăng ký thất bại");
            exit();
        }
    }
}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM db_account WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            if ($row['role'] == 'user') {
                header("Location: ../../TrangChu/user_main.php");
            } else {
                header("Location: ../Admin/home.php");
            }
            exit();
        } else {
            header("Location: login.php?error=Mật khẩu không đúng");
            exit();
        }
    } else {
        header("Location: login.php?error=Email không tồn tại");
        exit();
    }
}
?>
