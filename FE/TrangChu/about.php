<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về Chúng Tôi - Booking Homestay</title>
    <link rel="stylesheet" href="../CSS/style_user.css?v=4.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="body">
    <header class="main-header">
        <div class="header-container">
            <a href="./../TrangChu/user_main.php" class="logo">BookingHomeStay</a>
            <nav class="main-nav">
                <ul>
                    <li><a href="./../TrangChu/user_main.php">Trang chủ</a></li>
                    <li><a href="./../TrangChu/about.php">Về chúng tôi</a></li>
                    <li><a href="./../TrangChu/user_homestay.php">HomeStay</a></li>
                    <li><a href="#explore-location">Khám phá</a></li>
                    <li><a href="#feedback">Đánh giá</a></li>
                    <li><a href="./../TrangChu/contact.html">Liên hệ</a></li>
                </ul>
            </nav>

            <div class="user-actions">
                <a href="../PLACE/history.php" class="cart-icon" title="Giỏ hàng"><i
                        class="fa-solid fa-cart-shopping"></i></a>

                <div class="user-menu-wrapper">
                    <a href="javascript:void(0);" id="userIcon" class="user-icon-link">
                        <i class="fa-solid fa-user"></i> User
                    </a>
                    <div class="dropdown-menu" id="userDropdown">
                        <div class="user-info">
                            <img src="../images/user.jpg" alt="Avatar" class="avatar">
                            <span>Trường Giang</span>
                        </div>
                        <hr>
                        <a href="../TrangChu/profile.php"><i class="fa-solid fa-user-circle"></i> Profile</a>
                        <a href=""><i class="fa-solid fa-gear"></i> Cài đặt & quyền riêng tư</a>
                        <a href="#"><i class="fa-solid fa-question-circle"></i> Trợ giúp & hỗ trợ</a>
                        <a href="../../Login/logout.php" class="logout"><i class="fa-solid fa-sign-out"></i> Đăng
                            xuất</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="about">
        <h2>Về Chúng Tôi</h2>
        <p><strong>Booking Homestay</strong> là nền tảng đặt phòng homestay trực tuyến, giúp kết nối du khách với những
            không gian nghỉ dưỡng độc đáo và tiện nghi trên khắp Việt Nam. Với hệ thống tìm kiếm thông minh, thông tin
            minh bạch và đa dạng lựa chọn, chúng tôi cam kết mang đến trải nghiệm đặt phòng nhanh chóng, an toàn và giá
            cả hợp lý. Booking Homestay không chỉ là nơi bạn tìm được chỗ ở ưng ý, mà còn là người bạn đồng hành trên
            mỗi hành trình khám phá, mang lại những khoảnh khắc nghỉ dưỡng thoải mái và đáng nhớ.</p>
        <p>Chúng tôi cam kết mang đến trải nghiệm du lịch thân thiện, uy tín và nhanh chóng
            với hệ thống đặt phòng dễ dàng, hỗ trợ 24/7.</p>

        <div class="values">
            <div class="value-box">
                <i class="fas fa-handshake"></i>
                <h3>Uy tín</h3>
                <p>Hợp tác cùng chủ homestay được xác minh, đảm bảo an toàn và đáng tin cậy.</p>
            </div>
            <div class="value-box">
                <i class="fas fa-star"></i>
                <h3>Chất lượng</h3>
                <p>Mang đến không gian nghỉ dưỡng tiện nghi, phù hợp cho mọi du khách.</p>
            </div>
            <div class="value-box">
                <i class="fas fa-smile"></i>
                <h3>Trải nghiệm</h3>
                <p>Đặt phòng nhanh chóng, dịch vụ hỗ trợ tận tình, mang lại sự hài lòng tối đa.</p>
            </div>
        </div>

        <div class="team">
            <h2>Đội Ngũ</h2>
            <div class="team-members">
                <div class="member">
                    <img src="../images/10.jpg" alt="Thành viên 1">
                    <h4>Nguyễn Văn A</h4>
                    <p>Founder & CEO</p>
                </div>
                <div class="member">
                    <img src="../images/10.jpg" alt="Thành viên 2">
                    <h4>Trần Thị B</h4>
                    <p>Marketing</p>
                </div>
                <div class="member">
                    <img src="../images/10.jpg" alt="Thành viên 3">
                    <h4>Lê Văn C</h4>
                    <p>Developer</p>
                </div>
                <div class="member">
                    <img src="../images/10.jpg" alt="Thành viên 4">
                    <h4>Phạm Thanh D</h4>
                    <p>Hỗ trợ khách hàng</p>
                </div>
                <div class="member">
                    <img src="../images/10.jpg" alt="Thành viên 5">
                    <h4>Hoàng Minh E</h4>
                    <p>Quản lý Đối tác</p>
                </div>
            </div>
        </div>
    </section>


    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col">
                <h3>BookingHomeStay</h3>
                <p>Đặt homestay nhanh chóng, dễ dàng và tiện lợi. Mang đến trải nghiệm nghỉ dưỡng tuyệt vời cho bạn.</p>
            </div>

            <div class="footer-col">
                <h3>Danh mục</h3>
                <ul>
                    <li><a href="./../TrangChu/user_main.php">Trang chủ</a></li>
                    <li><a href="./../TrangChu/about.php">Về chúng tôi</a></li>
                    <li><a href="./../TrangChu/user_homestay.php">Danh sách HomeStay</a></li>
                    <li><a href="#explore-location">Khám phá địa điểm</a></li>
                </ul>
            </div>

            <div class="footer-col contact-info">
                <h3>Liên hệ</h3>
                <p><i class="fa-solid fa-location-dot"></i> Hà Nội, Việt Nam</p>
                <p><i class="fa-solid fa-phone"></i> 0123 456 789</p>
                <p><i class="fa-solid fa-envelope"></i> bookinghomestay@gmail.com</p>
            </div>

            <div class="footer-col">
                <h3>Kết nối</h3>
                <div class="social-links">
                    <a href="#" target="_blank" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" target="_blank" title="Zalo"><i class="fa-brands fa-viber"></i></a>
                    <a href="#" target="_blank" title="Messenger"><i class="fa-brands fa-facebook-messenger"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>Bản quyền &copy; 2025 BookingHomeStay. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>