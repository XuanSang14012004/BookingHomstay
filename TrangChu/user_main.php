<?php
include '../config/db.php';

$sql = "SELECT * FROM db_homestay";
$result = $conn->query($sql);

if(!$result){
    die("Lỗi truy vấn: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking HomeStay</title>
    <link rel="stylesheet" href="../CSS/style_user.css?v=7">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <!-- Thanh menu -->
   <div class="header-top">
  <ul>
    <li><a href="../TrangChu/user_main.php">Trang chủ</a></li>
    <li><a href="about.php">Về chúng tôi</a></li>
    <li><a href="contact.html">&#9742; Liên hệ</a></li>
    <li><a href="#feedback">Đánh giá</a></li>
    <li><a href="../TrangChu/user_homestay.php">Danh sách các HomeStay</a></li>
    <li><a href="../pages/login/login.php">Đăng nhập</a></li>

    <!-- User -->
    <li class="user-menu">
      <a href="javascript:void(0);" id="userIcon">
        <i class="fa-solid fa-user"></i> User
      </a>
      <!-- Menu ẩn -->
      <div class="dropdown-menu" id="userDropdown">
        <div class="user-info">
          <img src="../images/10.jpg" alt="Avatar" class="avatar">
          <span>Trường Giang</span>
        </div>
        <hr>
        <a href="">Cài đặt & quyền riêng tư</a>
        <a href="../TrangChu/profile.php">Profile</a>
        <a href="#">Trợ giúp & hỗ trợ</a>
        <a href="#">Màn hình & trợ năng</a>
        <a href="#">Đóng góp ý kiến</a>
        <a href="#">Đăng xuất</a>
      </div>
    </li>
    <!-- Giỏ hàng -->
    <li><a href="../PLACE/history.php"><i class="fa-solid fa-cart-shopping"></i> Giỏ hàng</a></li>
  </ul>
</div>
    <!-- Video + Sidebar -->
    <section>
  <div class="video-container slideshow">
    <img class="img" alt="HomeStay ở Sóc Sơn" src="../images/5.jpg">
    <img class="img" alt="HomeStay ở Sóc Sơn" src="../images/6.webp">
    <img class="img" alt="HomeStay ở Sóc Sơn" src="../images/7.webp">          
    <div class="search-overlay">
    <form id="filterForm" action="" method="GET" class="search-form">

      <!-- bộ lọc -->
       <form id="filterForm" action="" method="GET" class="search-form">
      <div class="form-group">
        <label for="location">Địa điểm</label>
        <select id="location" name="location" required>
          <option value="">-- Chọn --</option>
          <option value="Ba Vì">Ba Vì</option>
          <option value="Sóc Sơn">Sóc Sơn</option>
          <option value="Tam Đảo">Tam Đảo</option>
          <option value="Mộc Châu">Mộc Châu</option>
        </select>
      </div>

      <!-- Ngày đi -->
      <div class="form-group">
        <label for="checkin">Ngày đi</label>
        <input type="date" id="checkin" name="checkin" required>
      </div>

      <!-- Ngày về -->
      <div class="form-group">
        <label for="checkout">Ngày về</label>
        <input type="date" id="checkout" name="checkout" required>
      </div>

      <!-- Số người -->
      <div class="form-group">
        <label for="type">Loại phòng</label>
        <select id="type" name="type" required>
          <option value="">-- Chọn --</option>
          <option  value="Deluxe"> Deluxe</option>
          <option value="Family"> Family</option>
          <option value="Standard"> Standard</option>
        </select>
      </div>
      <script>
  document.getElementById("filterForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const location = document.getElementById("location").value.trim();
  const type = document.getElementById("type").value.trim();

  const cards = document.querySelectorAll(".homestay-card");

  cards.forEach(card => {
    const text = card.innerText; // lấy toàn bộ text của card
    const matchLocation = location === "" || text.includes(location);
    const matchType = type === "" || text.includes(type);

    if (matchLocation && matchType) {
      card.style.display = "block";
    } else {
      card.style.display = "none";
    }
  });
});
</script>

      <!-- Nút -->
      <button type="submit" class="btn-search">Tìm kiếm</button>
    </form>
   <!-- Khoảng giá -->
        <!-- <div class="form-group">
          <label for="price_range">Khoảng giá</label>
          <select id="price_range" name="price_range" required>
            <option value="">-- Chọn --</option>
            <option value="500-1000000">500 VND - 1.000.000 VND</option>
            <option value="1000000-1500000">1.000.000 VND - 1.500.000 VND</option>
            <option value="1500000-2000000">1.500.000 VND - 2.000.000 VND</option>
            <option value="2000000+">Trên 2.000.000 VND</option>
          </select>
        </div> -->
        <!-- Số người -->
        <!-- <div class="form-group">
          <label for="guests">Số người</label>
          <input type="number" id="guests" name="guests" min="1" value="1" required>
        </div> -->

        <!-- Nút -->
       
    </div>
  </div>
</section>

     <section>
      <div class="social-sidebar">
            <a href="#" target="_blank"><img src="../images/zalo.jpg" alt="Zalo"></a>
            <a href="#" target="_blank"><img src="../images/MES.jpg" alt="Messenger"></a>
            <a href="#" target="_blank"><img src="../images/FB.jpg" alt="Facebook"></a>
            <a href="#" target="_blank"><img src="../images/IG.jpg" alt="Instagram"></a>
        </div>
     </section>
    <!---------------------------------------------------------- Danh sách các HomeStay-------------------------------------------->
<section class="homestay-section">
  <h2>Danh Sách Các HomeStay</h2>

  <!-- Nút điều hướng -->
  <button class="arrow left" onclick="scrollHomestay(-1)">&#10094;</button>
  <button class="arrow right" onclick="scrollHomestay(1)">&#10095;</button>

  <div class="homestay-container">
    <div class="homestay-list">
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <div class="homestay-card">
            <img src="<?php echo htmlspecialchars($row['hinhanh']); ?>" alt="<?php echo htmlspecialchars($row['tenhomestay']); ?>">
            <div class="info">
              <h3><?php echo htmlspecialchars($row['tenhomestay']); ?></h3>
              <p class="info">Địa điểm: <b style="color:green"><?php echo htmlspecialchars($row['diachi']); ?></b></p>
              <p class="info">Số phòng: <?php echo intval($row['sophong']); ?></p>
              <p class="info">Loại phòng: <?php echo htmlspecialchars($row['loaiphong']); ?></p>
              <p class="info">Tình trạng: 
                <b style="color:<?php echo ($row['trangthai'] == 'Còn trống') ? 'green' : 'red'; ?>">
                  <?php echo htmlspecialchars($row['trangthai']); ?>
                </b>
              </p>
              <p class="price">Giá: <?php echo number_format($row['gia'], 0, ',', '.'); ?>đ / đêm</p>
              <div class="stars"><?php echo str_repeat('⭐', intval($row['sosao'])); ?></div>
           <a href="../PAY/user_booking.php?mahomestay=<?php echo $row['mahomestay']; ?>" class="btn">Đặt phòng</a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Chưa có homestay nào.</p>
      <?php endif; ?>
    </div>
  </div>

  <a href="../TrangChu/user_homestay.php" class="show-more">Xem đầy đủ các HomeStay</a>
</section>

<!---------------------------------------------Giảm giá-------------------------------------------------------------------------->
         <!-- ƯU ĐÃI / DEALS -->
<section class="deals">
  <div class="container">
    <h1 class="h1-style">Ưu đãi & Khuyến mãi</h1>

    <div class="deal-banner">
      <img src="../images/8.png" alt="Summer Sale">
      <div class="deal-banner-text">
        <h2>Summer Sale 🔥</h2>
        <p>Giảm đến 30% cho tất cả Homestay Deluxe</p> 
        <button onclick="window.location.href='../PLACE/deluxe_list.php?discount=30'">Đặt ngay</button>
      </div>
    </div>
  </div>
</section>
<!-------------------------------------------------------------------------------------------------------------------------->

<!------------------------------------Tìm kiếm theo địa điểm---------------------------------------------------------------->
<section id="explore-location" class="explore-location">
  <h2>Khám phá Homestay theo địa điểm</h2>
  <div class="location-grid">
    <div class="location-item">
      <img src="../images/SS5.jpg" alt="Sóc Sơn">
      <div class="overlay"> <p>Sóc Sơn</p>
    <a href="../PLACE/place.php?location=Sóc Sơn"><button class="btn-location">Xem chi tiết</button></a>
    </div>
    </div>
    <div class="location-item">
      <img src="../images/TD1.jpg" alt="Tam Đảo">
      <div class="overlay"><p>Tam đảo</p>
      <a href="../PLACE/place.php?location=Tam Đảo"><button class="btn-location">Xem chi tiết</button></a>
    </div>
    </div>
    <div class="location-item">
      <img src="../images/mcc.webp" alt="Mộc Châu">
      <div class="overlay"><p>Mộc Châu</p>
    <a href="../PLACE/place.php?location=Mộc Châu"><button class="btn-location">Xem chi tiết</button></a>
      </div>
    </div>
    <div class="location-item">
      <img src="../images/BV2.jpg" alt="Ba Vì">
      <div class="overlay"><p>Ba Vì</p>
     <a href="../PLACE/place.php?location=Ba Vì"><button class="btn-location">Xem chi tiết</button></a>
    </div>
    </div>
  </div>
</section>
<!-------------------------------------------------------------------------------------------------------------------------->




<!------------------------------------------------------------------ Blog / Tin tức------------------------------------------------------------------------------------>
<!-- ========== Blog / Tin tức ========== -->
<section class="blog">
  <div class="container">
    <h2 class="h1-style">Tin tức & Blog</h2>
    <div class="blog-list">

      <!-- Bài viết 1 -->
      <div class="blog-card">
        <img src="../images/TT1.webp" alt="Kinh nghiệm du lịch Đà Lạt">
        <div class="blog-info">
          <h3>Kinh nghiệm du lịch Ba Vì 3 ngày 2 đêm</h3>
          <p>Chia sẻ lịch trình du lịch Ba Vì tiết kiệm, homestay đẹp, các điểm check-in nổi tiếng.</p>
          <a href="blog1.html" class="btn-read">Đọc thêm</a>
        </div>
      </div>

      <!-- Bài viết 2 -->
      <div class="blog-card">
        <img src="../images/TT2.jpg" alt="Mẹo đặt homestay giá rẻ">
        <div class="blog-info">
          <h3>Mẹo đặt homestay giá rẻ mùa cao điểm</h3>
          <p>Bí quyết săn homestay với giá tốt, tránh tình trạng hết phòng vào mùa lễ hội.</p>
          <a href="blog2.html" class="btn-read">Đọc thêm</a>
        </div>
      </div>

      <!-- Bài viết 3 -->
      <div class="blog-card">
        <img src="../images/TT3.webp" alt="Khám phá Sapa">
        <div class="blog-info">
          <h3>Khám phá Sapa: Đi đâu, ăn gì, ở đâu?</h3>
          <p>Gợi ý các homestay view núi rừng đẹp, trải nghiệm ẩm thực và văn hóa địa phương.</p>
          <a href="blog3.html" class="btn-read">Đọc thêm</a>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- -------------------------------đánh giá--------------------------------------------------------------->
<section id="feedback" class="feedback">
  <div class="container">
    <h2 class="h1-style">Phản hồi từ khách hàng</h2>
    <div class="feedback-list">
      <!-- Khung nhập đánh giá -->
      <div class="feedback-cmt">
        <input type="text" placeholder="Viết đánh giá của bạn...">
        <button>Gửi</button>
      </div>

      <!-- Phản hồi 1 -->
      <div class="feedback-card">
        <p>"Dịch vụ tuyệt vời, homestay đẹp và sạch sẽ. Chúng tôi đã có một kỳ nghỉ đáng nhớ!"</p>
        <h4>- Nguyễn Văn A</h4>
        <!-- Admin trả lời -->
        <div class="feedback-admin">
          <p><strong>Admin:</strong> Cảm ơn anh A, homestay rất vui khi mang đến trải nghiệm tốt cho anh và gia đình.</p>
        </div>
      </div>

      <!-- Phản hồi 2 -->
      <div class="feedback-card">
        <p>"Giá cả hợp lý, nhân viên thân thiện. Sẽ quay lại lần nữa!"</p>
        <h4>- Trần Thị B</h4>
        <!-- Admin trả lời -->
        <div class="feedback-admin">
          <p><strong>Admin:</strong> Cảm ơn chị B, hẹn gặp lại chị trong chuyến đi tiếp theo!</p>
        </div>
      </div>

      <!-- Phản hồi 3 -->
      <div class="feedback-card">
        <p>"Vị trí homestay thuận tiện, gần nhiều điểm tham quan. Rất hài lòng với trải nghiệm."</p>
        <h4>- Lê Văn C</h4>
        <!-- Admin trả lời -->
        <div class="feedback-admin">
          <p><strong>Admin:</strong> Cảm ơn anh C đã tin tưởng. Chúc anh có nhiều chuyến đi thú vị!</p>
        </div>
      </div>

    </div>
  </div>
</section>



<!-- -----------------------------------------------Footer ----------------------------------------------------------->
<footer class="footer">
  <div class="footer-container">
    <!-- Cột 1: Logo + giới thiệu -->
    <div class="footer-col">
      <h2>BookingHomeStay</h2>
      <p>Đặt homestay nhanh chóng, dễ dàng và tiện lợi.  
      Mang đến trải nghiệm nghỉ dưỡng tuyệt vời cho bạn.</p>
    </div>

    <!-- Cột 2: Thông tin liên hệ -->
    <div class="footer-col">
      <h3>Liên hệ</h3>
      <p>📍 Hà Nội, Việt Nam</p>
      <p>📞 0123 456 789</p>
      <p>✉️ bookinghomestay@gmail.com</p>
    </div>

    <!-- Cột 3: Mạng xã hội -->
    <div class="footer-col">
      <h3>Kết nối với chúng tôi</h3>
      <div class="social-links">
        <a href="#"><img src="../images/FB.jpg" alt="Facebook"></a>
        <a href="#"><img src="../images/IG.jpg" alt="Instagram"></a>
        <a href="#"><img src="../images/zalo.jpg" alt="Zalo"></a>
        <a href="#"><img src="../images/MES.jpg" alt="TikTok"></a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2025 BookingHomeStay. All rights reserved.</p>
  </div>
</footer>
<script src="../JS/JS_TRANGCHU.js?v=7"></script>
</body>
</html>