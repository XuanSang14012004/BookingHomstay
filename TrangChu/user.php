<?php
include '../db.php';

// Lấy danh sách homestay còn phòng
$sql = "SELECT id, name, price, guests FROM homestays WHERE status='còn phòng' LIMIT 3";
$result = $conn->query($sql);
$homestays = [];
while($row = $result->fetch_assoc()){
    $homestays[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking HomeStay</title>
    <link rel="stylesheet" href="../CSS/style_user.css?v=4.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="../JS/JS_TRANGCHU.js"></script>
</head>
<body>
    <!-- Thanh menu -->
    <div class="header-top">
        <ul>
            <li><a href="user.php">Trang chủ</a></li>
            <li><a href="about.php">Về chúng tôi</a></li>
            <li><a href="contact.html">&#9742;Liên hệ</a></li>
            <li><a href="##review">Đánh giá</a></li>
            <li><a href="#explore-location">Danh sách các HomeStay</a></li>
             <li><a href="login.php">Đăng nhập</a></li>
             <li><a href="#"><i class="fa-solid fa-user"></i></a></li>
             <ul class="menu">
             <li><a href="../PLACE/history.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
          </ul>
        </ul>
    </div>
    <!-- Video + Sidebar -->
    <section>
  <div class="video-container slideshow">
    <img class="img" alt="HomeStay ở Sóc Sơn" src="../images/5.jpg">
    <img class="img" alt="HomeStay ở Sóc Sơn" src="../images/6.webp">
    <img class="img" alt="HomeStay ở Sóc Sơn" src="../images/7.webp">          
    <div class="search-overlay">
      <form action="" method="GET" class="search-form">

        <!-- Loại phòng -->
        <div class="form-group">
          <label for="room_type">Loại phòng</label>
          <select id="room_type" name="room_type" required>
            <option value="">-- Chọn --</option>
            <option value="deluxe">Deluxe</option>
            <option value="family">Family</option>
            <option value="standard">Standard</option>
          </select>
        </div>

        <!-- Khoảng giá -->
        <div class="form-group">
          <label for="price_range">Khoảng giá</label>
          <select id="price_range" name="price_range" required>
            <option value="">-- Chọn --</option>
            <option value="500-1000000">500 VND - 1.000.000 VND</option>
            <option value="1000000-1500000">1.000.000 VND - 1.500.000 VND</option>
            <option value="1500000-2000000">1.500.000 VND - 2.000.000 VND</option>
            <option value="2000000+">Trên 2.000.000 VND</option>
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
          <label for="guests">Số người</label>
          <input type="number" id="guests" name="guests" min="1" value="1" required>
        </div>

        <!-- Nút -->
        <button type="submit" class="btn-search">Tìm kiếm</button>

      </form>
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
      <!-- 16 Homestay Card -->
      <div class="homestay-card">
        <img src="../images/BV1.jpg" alt="Homestay 1">
        <div class="info">
          <h3>Mely Farm</h3>
          <p>Giá: 800.000đ / đêm</p>
          <p>Sức chứa: 6 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/BV2.jpg" alt="Homestay 2">
        <div class="info">
          <h3>Family Homestay</h3>
          <p>Giá: 850.000đ / đêm</p>
          <p>Sức chứa: 5 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/BV3.jpg" alt="Homestay 3">
        <div class="info">
          <h3>Melia Bavi Mountain Retreat</h3>
          <p>Giá: 900.000đ / đêm</p>
          <p>Sức chứa: 8 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/BV4.jpg" alt="Homestay 4">
        <div class="info">
          <h3>BaVi Padme </h3>
          <p>Giá: 750.000đ / đêm</p>
          <p>Sức chứa: 4 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/MC.jpg" alt="Homestay 5">
        <div class="info">
          <h3>Phoenix Mộc Châu Bungalow</h3>
          <p>Giá: 1.000.000đ / đêm</p>
          <p>Sức chứa: 10 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/MC1.5.jpeg" alt="Homestay 6">
        <div class="info">
          <h3>Mộc Châu Eco-garden</h3>
          <p>Giá: 950.000đ / đêm</p>
          <p>Sức chứa: 7 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/MC3.webp" alt="Homestay 7">
        <div class="info">
          <h3>Mama’s House</h3>
          <p>Giá: 800.000đ / đêm</p>
          <p>Sức chứa: 6 khách</p>
          <button class="btn">Đặt phòng</button>
        </div> 
      </div>

      <div class="homestay-card">
        <img src="../images/MC4.webp" alt="Homestay 8">
        <div class="info">
          <h3>Mộc Homestay</h3>
          <p>Giá: 850.000đ / đêm</p>
          <p>Sức chứa: 5 khách</p>
          <button class="btn">Đặt phòng</button>
        </div> 
      </div>

      <div class="homestay-card">
        <img src="../images/SS1.jpg" alt="Homestay 9">
        <div class="info">
          <h3>Amaya Home</h3>
          <p>Giá: 900.000đ / đêm</p>
          <p>Sức chứa: 8 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/SS2.jpg" alt="Homestay 10">
        <div class="info">
          <h3>Cerf Volant Soc Son Resort</h3>
          <p>Giá: 750.000đ / đêm</p>
          <p>Sức chứa: 4 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/SS3.jpg" alt="Homestay 11">
        <div class="info">
          <h3>De'bay Retreat</h3>
          <p>Giá: 1.000.000đ / đêm</p>
          <p>Sức chứa: 10 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/SS5.jpg" alt="Homestay 12">
        <div class="info">
          <h3>Amaya Retreat</h3>
          <p>Giá: 950.000đ / đêm</p>
          <p>Sức chứa: 7 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/TD1.jpg" alt="Homestay 13">
        <div class="info">
          <h3>Dream House</h3>
          <p>Giá: 800.000đ / đêm</p>
          <p>Sức chứa: 6 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/TD2.jpg" alt="Homestay 14">
        <div class="info">
          <h3>Le Bleu Floating Cloud</h3>
          <p>Giá: 850.000đ / đêm</p>
          <p>Sức chứa: 5 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/TD3.jpg" alt="Homestay 15">
        <div class="info">
          <h3>Up In The Air Homestay</h3>
          <p>Giá: 900.000đ / đêm</p>
          <p>Sức chứa: 8 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../images/TD4.jpg" alt="Homestay 16">
        <div class="info">
          <h3>Cloudy Garden</h3>
          <p>Giá: 750.000đ / đêm</p>
          <p>Sức chứa: 4 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>
    </div>
  </div>

  <a href="homestay.php" class="show-more">Xem đầy đủ các HomeStay</a>
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
<section class="feedback" id="#review">
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
      </div>

      <!-- Phản hồi 2 -->
      <div class="feedback-card">
        <p>"Giá cả hợp lý, nhân viên thân thiện. Sẽ quay lại lần nữa!"</p>
        <h4>- Trần Thị B</h4>
      </div>

      <!-- Phản hồi 3 -->
      <div class="feedback-card">
        <p>"Vị trí homestay thuận tiện, gần nhiều điểm tham quan. Rất hài lòng với trải nghiệm."</p>
        <h4>- Lê Văn C</h4>
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
</body>
</html>