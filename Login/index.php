<?php
session_start();
require_once("../BE/Config/connect.php");

// ---------------- XỬ LÝ ĐĂNG KÝ ----------------
if (isset($_POST['signUp'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Kiểm tra email tồn tại
    $check = $conn->prepare("SELECT * FROM db_account WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>window.location='login.php?action=signup&status=exist';</script>";
        exit;
    }

    $role = "user"; // Mặc định là user
    $insert = $conn->prepare("INSERT INTO db_account(fullname,email,phone,password,role) VALUES(?,?,?,?,?)");
    $insert->bind_param("sssss", $fullname, $email, $phone, $password, $role);
    $insert->execute();

    echo "<script>window.location='login.php?action=signin&status=signup_success';</script>";
    exit;
}

// ---------------- XỬ LÝ ĐĂNG NHẬP ----------------
if (isset($_POST['signIn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $stmt = $conn->prepare("SELECT * FROM db_account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        echo "<script>window.location='login.php?action=signin&status=no_account';</script>";
        exit;
    }

    $user = $result->fetch_assoc();

    if ($user['password'] !== $password) {
        echo "<script>window.location='login.php?action=signin&status=wrong_password';</script>";
        exit;
    }

    if (empty($user['role'])) {
        echo "<script>window.location='login.php?action=signin&status=no_role';</script>";
        exit;
    }

    $_SESSION['account_id'] = $user['account_id'];
    $_SESSION['fullname'] = $user['fullname'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] === 'admin') {
        header("Location: ../BE/Pages/home/home.php");
        exit;
    } elseif ($user['role'] === 'owner') {
        header("Location: ../BE/Pages/home/home.php");
        exit;
    } elseif ($user['role'] === 'user') {
        header("Location: ../FE/TrangChu/user_main.php");
        exit;
    } else {
        echo "<script>window.location='login.php?action=signin&status=invalid_role';</script>";
        exit;
    }
}
?>