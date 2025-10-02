<?php
include "../BE/Config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_signup_form = false;
$is_signin_form = false;

if ($action === 'signup') {
    $is_signup_form = true;
} else {
    $is_signin_form = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>
    <!----------------------------------------- form đăng kí ---------------------------------------->
<div class="container"id="signup-form" style="display:<?php echo $is_signup_form ? 'block' : 'none'; ?>;" >
    <div class="login-container">
        <div class="login-left"></div>

        <div class="login-right" >
            <h1 class="form-title">Đăng Kí</h1>
            <form method="post" action="index.php">
                <div class="form-section">
                    <div class="input-group">
                        <i class='bx bx-envelope'></i>
                        <input type="text" placeholder="Họ và tên" name="fullname" id="fullname" required>  
                    </div>
                    <div class="input-group">
                        <i class='bx bx-user'></i>
                        <input type="email" placeholder="Email" name="email" id="email" required>
                    </div>
                    <div class="input-group">
                        <i class='bx bx-phone'></i>
                        <input type="phone" placeholder="Số điện thoại" name="phone" id="phone" required>
                    </div>
                    <div class="input-group">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                    </div>
                </div>
                <div class="form-action">
                    <button type="submit" class="submit-btn" name="signUp">Đăng kí</button>
                </div>
            </form>
                <p class="or">Hoặc</p>
            <div class="icons">
                <a href="#" class="social-google">
                    <i class='bx bxl-google' ></i>
                </a>
                <a href="#" class="social-facebook">
                    <i class='bx bxl-facebook'></i>
                </a>
            </div>
            <div class="links">
                <p>Bạn đã có tài khoản ?</p>
                <button class="signin-btn" title="Đăng kí" onclick="showForm('signin-form');return false;">Đăng nhập</button>
            </div>
        </div>
    </div>
</div>

<!----------------------------------------- form đăng nhập ---------------------------------------->
<div class="container" id="signin-form" style="display:<?php echo $is_signin_form ? 'block' : 'none'; ?>;">
    <div class="login-container">
        <div class="login-left"></div>

        <div class="login-right">
            <h1 class="form-title">Đăng Nhập</h1>
            <form method="post" action="index.php">
                <div class="form-section">
                    <div class="input-group">
                        <i class='bx bx-envelope'></i>
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                    </div>
                </div>
                <p class="recover">
                    <a href="#">Quên mật khẩu</a>
                </p>
                <div class="form-action">
                    <button type="submit" class="submit-btn" name="signIn">Đăng nhập</button>
                </div>
            </form>
                <p class="or">Hoặc</p>
            <div class="icons">
                <a href="#" class="social-google">
                    <i class='bx bxl-google' ></i>
                </a>
                <a href="#" class="social-facebook">
                    <i class='bx bxl-facebook'></i>
                </a>
            </div>
            <div class="links">
                <p>Bạn chưa có tài khoản?</p>
                <button class="signup-btn" title="Chi tiết" onclick="showForm('signup-form');return false;">Đăng kí</button>
            </div>
        </div>
    </div>
</div>
    <script src="login.js"></script>
</body>

</html>
