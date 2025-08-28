
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
    <form action="" method="post">
        <h2><big>Đăng nhập</big> </h2>
        <h3>Bạn có thể đăng nhập tài khoản HUMG.com của mình để truy cập các dịch vụ của chúng tôi</h3>
        <?php if(isset($_GET['error'])){ ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <label for="email"></label>
        <input type="text" id="email" name="email" placeholder="Email or Phone number" required>
    
        <label for="password"></label>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <button type="submit">Đăng nhập</button>
            <div class="forgot-password">
                <a href="#">Quên mật khẩu?</a>
            </div>
        <h3>Hoặc sử dụng một trong các lựa chọn này</h3>
        <div class="social_options">
                <a href="#" class="social-btn facebook">
                    <i class='bx bxl-facebook'></i> Đăng nhập với Facebook
                </a>
                <a href="#" class="social-btn google">
                    <i class='bx bxl-google'></i> Đăng nhập với Google
                </a>
                <a href="#" class="social-btn apple">
                    <i class='bx bxl-apple'></i> Đăng nhập với Apple
                </a>
        </div>
        
    </form>
</body>
</html>
