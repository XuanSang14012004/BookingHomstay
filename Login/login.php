
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/Login.css">
    <link rel="icon" href="../images/logo.jpg">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>HUMG.com | Đăng nhập</title>
</head>
<body>
    <form action="" method="post" autocomplete="off">
        <h2>ĐĂNG NHẬP</h2>
        <h3>Đăng nhập vào HUMG.com để sử dụng các dịch vụ tốt nhất của chúng tôi</h3>
        <?php if(isset($_GET['error'])){ ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <div>
            <label for="email"></label>
            <input type="text" id="email" name="email" placeholder="Nhập email hoặc số điện thoại" required >
        </div>
        <div>
            <label for="password"></label>
            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
        </div>
        <button type="submit">Đăng nhập</button>
        <div class="login-bottom-row">
            <a href="signup.php" class="login-create-link">Bạn chưa có tài khoản?</a>
            <a href="#" class="forgot-link">Quên mật khẩu?</a>
        </div>
        <h3>Hoặc</h3>
        <div class="social_options">
            <a href="#" class="social-btn facebook">
                <i class='bx bxl-facebook'></i> Facebook
            </a>
            <a href="#" class="social-btn google">
                <i class='bx bxl-google'></i> Google
            </a>
            <a href="#" class="social-btn apple">
                <i class='bx bxl-apple'></i> Apple
            </a>
        </div>
    </form>
</body>
</html>
