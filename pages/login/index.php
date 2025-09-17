<?php
session_start();
require_once('../../Config/connect.php');

if (isset($_POST['signUp'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = "user";


    $checkEmail = "SELECT * From db_account where email='$email'";
    $result = $conn->query($checkEmail);
    if ($result->num_rows > 0) {
        echo "Email Address Already Exists !";
    } else {
        $sql = "INSERT INTO `db_account` (fullname,email,phone,password,role) VAlUES ('$fullname','$email','$phone','$password','$role')";
        if ($conn->query($sql) === TRUE) {
            header("Location : login.php?success=Đăng kí tài khoản thành công");
        } else {
            header("Location : login.php?error=Đăng kí tài khoản thất bại") . $conn->error;
        }
    }
}


if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM db_account WHERE email='$email' and password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        if ($row['email'] === $email && $row['password'] === $password) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['role'] = $row['role'];
            if ($row['role'] == 'user') {
                header("Location: ../User/user.php");
                exit();
            } elseif ($row['role'] == 'admin') {
                header("Location: ../Admin/home.php");
                exit();
            } else {
                header("Location: login.php?error=Tài khoản của bạn chưa được phân quyền!");
                exit();
            }
        }
    } else {
        header("Location: login.php?error=Thông tin chưa chính xác. Vui lòng nhập lại!");
        exit();
    }
}
