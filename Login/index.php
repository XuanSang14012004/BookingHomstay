<!-- // session_start();
// require_once('../BE/Config/connect.php');

// if (isset($_POST['signUp'])) {
// $fullname = $_POST['fullname'];
// $email = $_POST['email'];
// $phone = $_POST['phone'];
// $password = $_POST['password'];
// $role = "user";

// $checkEmail = "SELECT email From db_account where email='$email'";
// $result = mysqli_query($conn, $checkEmail);
// if (mysqli_num_rows($result) > 0) {
// header("Location:login.php?action=signup&form=signup&status=exist");
// }else{
// $sql = "INSERT INTO `db_account` (fullname,email,phone,password,role) VAlUES
('$fullname','$email','$phone','$password','$role')";
// $query = $conn->query($sql);
// if ($query === TRUE) {
// header("Location:login.php?form=signup&status=success");
// exit();
// } else {
// header("Location:login.php?form=signup&status=error") . $conn->error;
// exit();
// }
// }
// }


// if (isset($_POST['signIn'])) {
// $email = $_POST['email'];
// $password = $_POST['password'];

// $check = "SELECT * FROM `db_account` WHERE email='$email' and password='$password'";
// $result = $conn->query($check);
// if ($result && $result->num_rows > 0) {
// $row = $result->fetch_assoc();
// if ($row['email'] === $email && $row['password'] === $password) {
// $_SESSION['account_id'] = $row['account_id'];
// $_SESSION['fullname'] = $row['fullname'];
// $_SESSION['email'] = $row['email'];
// $_SESSION['password'] = $row['password'];
// $_SESSION['role'] = $row['role'];
// if ($row['role'] == 'user') {
// header("Location: ../FE/TrangChu/user_main.php?form=signin&status=success");
// exit();
// } elseif ($row['role'] == 'admin') {
// header("Location:../BE/Pages/home/home.php?form=signin&status=success");
// exit();
// } else {
// header("Location:login.php?form=signin&status=missrole");
// exit();
// }
// } else {
// header("Location:login.php?form=signin&status=error");
// exit();
// }

// }
// } -->


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
        echo "<script>alert('Email đã tồn tại!'); window.location='login.php?action=signup';</script>";
        exit;
    }

    $role = "user"; // Mặc định là user
    $insert = $conn->prepare("INSERT INTO db_account(fullname,email,phone,password,role) VALUES(?,?,?,?,?)");
    $insert->bind_param("sssss", $fullname, $email, $phone, $password, $role);
    $insert->execute();

    echo "<script>alert('Đăng ký thành công! Hãy đăng nhập.'); window.location='login.php?action=signin';</script>";
    exit;
}

// ---------------- XỬ LÝ ĐĂNG NHẬP ----------------
if (isset($_POST['signIn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM db_account WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $_SESSION['account_id'] = $user['account_id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        // ✅ Chuyển hướng theo vai trò
        if ($user['role'] === 'admin') {
    header("Location: ../BE/Pages/home/home.php");
    exit;
} else {
    header("Location: ../FE/TrangChu/user_main.php");
    exit;
}
    } else {
        echo "<script>alert('Email hoặc mật khẩu không đúng!'); window.location='login.php?action=signin';</script>";
        exit;
}
}
?>