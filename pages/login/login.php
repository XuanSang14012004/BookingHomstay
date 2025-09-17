<?php
include "../../Config/connect.php";


?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../Css/style_login.css">
    <title>Login</title>
</head>

<body>
    <section>
        <div class="container" id="signup" style="display:none;">
            <h1 class="form-title">Đăng Kí</h1>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>
            <form method="post" action="index.php">
                <div class="input-group">
                    <i class='bx bx-user'></i>
                    <input type="text" placeholder="Họ và tên" name="fullname" id="fullname" required>
                </div>
                <div class="input-group">
                    <i class='bx bx-envelope'></i>
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
                <input type="submit" class="btn" value="Đăng kí" name="signUp">
            </form>
            <p class="or">Hoặc</p>
            <div class="icons">
                <a href="#" class="social-google">
                    <i class='bx bxl-google'></i>
                </a>
                <a href="#" class="social-facebook">
                    <i class='bx bxl-facebook'></i>
                </a>
            </div>
            <div class="links">
                <p>Bạn đã có tài khoản ?</p>
                <button id="signInButton">Đăng nhập</button>
            </div>
        </div>

        <div class="container" id="signIn">
            <h1 class="form-title">Đăng Nhập</h1>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>
            <form method="post" action="index.php">
                <div class="input-group">
                    <i class='bx bx-envelope'></i>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                </div>
                <p class="recover">
                    <a href="#">Quên mật khẩu</a>
                </p>
                <input type="submit" class="btn" value="Đăng nhập" name="signIn">
            </form>
            <p class="or">Hoặc</p>

            <div class="icons">
                <a href="#" class="social-google">
                    <i class='bx bxl-google'></i>
                </a>
                <a href="#" class="social-facebook">
                    <i class='bx bxl-facebook'></i>
                </a>
            </div>

            <div class="links">
                <p>Bạn chưa có tài khoản?</p>
                <button id="signUpButton">Đăng kí</button>
            </div>
        </div>
    </section>
    <script src="../../Js/login.js"></script>
</body>

</html>