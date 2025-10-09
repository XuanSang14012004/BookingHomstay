<?php
session_start();
require_once('../BE/Config/connect.php');

if (isset($_POST['signUp'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = "user";

    $checkEmail = "SELECT email From db_account where email='$email'";
    $result = mysqli_query($conn, $checkEmail);
    if (mysqli_num_rows($result) > 0) {
        header("Location:login.php?action=signup&form=signup&status=exist");
    }else{
    $sql = "INSERT INTO `db_account` (fullname,email,phone,password,role) VAlUES ('$fullname','$email','$phone','$password','$role')";
    $query = $conn->query($sql);
        if ($query === TRUE) {
            header("Location:login.php?form=signup&status=success");
             exit();
        } else {
            header("Location:login.php?form=signup&status=error") . $conn->error;
             exit();
        }
    }
}


if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check = "SELECT * FROM `db_account` WHERE email='$email' and password='$password'";
    $result = $conn->query($check);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['email'] === $email && $row['password'] === $password) {
            $_SESSION['account_id'] = $row['account_id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['role'] = $row['role'];
            if ($row['role'] == 'user') {
                header("Location:../FE/TrangChu/user_main.php?form=signin&status=success");
                exit();
            } elseif ($row['role'] == 'admin') {
                header("Location:../BE/Pages/home/home.php?form=signin&status=success");
                exit();
            } else {
            header("Location:login.php?form=signin&status=missrole");
            exit();
            }
        } else {
            header("Location:login.php?form=signin&status=error");
            exit();
        }
        
    } 
}
