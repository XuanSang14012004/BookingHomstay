<?php
// ✅ Khởi tạo session để đồng bộ với index/logout
session_start();
include "../BE/Config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'signin';
$is_signup_form = ($action === 'signup');
$is_signin_form = !$is_signup_form;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/logo.jpg">
    <title>Login</title>
</head>

<body>

    <!----------------------------------------- form đăng kí ----------------------------------------->
    <div class="container" id="signup-form" style="display:<?php echo $is_signup_form ? 'block' : 'none'; ?>;">
        <div class="login-container">
            <div class="login-left"></div>
            <div class="login-right">
                <h1 class="form-title">Đăng Kí</h1>
                <form method="post" action="index.php">
                    <div class="form-section">
                        <div class="input-group">
                            <i class='bx bx-user'></i>
                            <input type="text" placeholder="Họ và tên" name="fullname" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bx-envelope'></i>
                            <input type="email" placeholder="Email" name="email" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bx-phone'></i>
                            <input type="text" placeholder="Số điện thoại" name="phone" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bx-lock-alt'></i>
                            <input type="password" name="password" placeholder="Mật khẩu" required>
                        </div>
                    </div>
                    <div class="form-action">
                        <button type="submit" class="submit-btn" name="signUp">Đăng kí</button>
                    </div>
                </form>
                <p class="or">Hoặc</p>
                <div class="icons">
                    <a href="#" class="social-google"><i class='bx bxl-google'></i></a>
                    <a href="#" class="social-facebook"><i class='bx bxl-facebook'></i></a>
                </div>
                <div class="links">
                    <p>Bạn đã có tài khoản ?</p>
                    <button class="signin-btn" onclick="window.location='login.php?action=signin'">Đăng nhập</button>
                </div>
            </div>
        </div>
    </div>

    <!----------------------------------------- form đăng nhập ----------------------------------------->
    <div class="container" id="signin-form" style="display:<?php echo $is_signin_form ? 'block' : 'none'; ?>;">
        <div class="login-container">
            <div class="login-left"></div>
            <div class="login-right">
                <h1 class="form-title">Đăng Nhập</h1>
                <form method="post" action="index.php">
                    <div class="form-section">
                        <div class="input-group">
                            <i class='bx bx-envelope'></i>
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bx-lock-alt'></i>
                            <input type="password" name="password" placeholder="Mật khẩu" required>
                        </div>
                    </div>
                    <p class="recover"><a href="#">Quên mật khẩu?</a></p>
                    <div class="form-action">
                        <button type="submit" class="submit-btn" name="signIn">Đăng nhập</button>
                    </div>
                </form>
                <p class="or">Hoặc</p>
                <div class="icons">
                    <a href="#" class="social-google"><i class='bx bxl-google'></i></a>
                    <a href="#" class="social-facebook"><i class='bx bxl-facebook'></i></a>
                </div>
                <div class="links">
                    <p>Bạn chưa có tài khoản?</p>
                    <button class="signup-btn" onclick="window.location='login.php?action=signup'">Đăng ký</button>
                </div>
            </div>
        </div>
    </div>

    <script src="login.js"></script>
</body>

</html>