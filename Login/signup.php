<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/Login.css">
    <link rel="icon" href="../images/logo.jpg">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>HUMG.com | Đăng ký</title>
</head>
<body>
    <form action="" method="post" autocomplete="off" class="signup-form">
        <h2>ĐĂNG KÍ TÀI KHOẢN</h2>
        <h3>Tạo tài khoản HUMG.com để sử dụng các dịch vụ tốt nhất của chúng tôi</h3>
        <?php if(isset($_GET['error'])){ ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <div>
            <label for="fullname">Họ và tên</label>
            <input type="text" id="fullname" name="fullname" placeholder="Nhập họ và tên" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Nhập email" required>
        </div>
        <div>
            <label for="phone">Số điện thoại</label>
            <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
        </div>
        <div >
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" placeholder="Tạo mật khẩu" required>
        </div>
        <div >
            <label for="confirm_password">Nhập lại mật khẩu</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
        </div>
        <button type="submit">Đăng ký</button>
        <div class="signup-link">
            Đã có tài khoản? <a href="login.php">Đăng nhập</a>
        </div>
    </form>
</body>
</html>
