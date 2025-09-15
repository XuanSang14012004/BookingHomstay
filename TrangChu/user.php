<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking HomeStay</title>
    <link rel="stylesheet" href="../CSS/css.css?v=1.7">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <!-- Thanh menu -->
    <div class="header-top">
        <ul>
            <li><a href="user.php">Trang chủ</a></li>
            <li><a href="about.php">Về chúng tôi</a></li>
            <li><a href="contact.html">&#9742;Liên hệ</a></li>
            <li><a href="review.html">Đánh giá</a></li>
            <li><a href="#explore-location">Danh sách các HomeStay</a></li>
             <li><a href="login.php">Đăng nhập</a></li>
             <li><a href="signup.php">Đăng ký</a></li>
             <li><a href="#"><i class="fa-solid fa-user"></i></a></li>
             <li><a><i class="fa-solid fa-cart-shopping"></i></a></li>
        </ul>
    </div>

    <!-- Video + Sidebar -->
     <section>
    <div class="video-container slideshow">
        <img class="img" alt="HomeStay ở Sóc Sơn" src="../ANH/5.jpg">
        <img class="img" alt="HomeStay ở Sóc Sơn" src="../ANH/6.webp">
        <img class="img" alt="HomeStay ở Sóc Sơn" src="../ANH/7.webp">          
    <div class="search-overlay">
    <form action="" method="GET" class="search-form">
      <!-- Địa điểm -->
      <div class="form-group">
        <label for="location">Địa điểm</label>
        <select id="location" name="location" required>
          <option value="">-- Chọn --</option>
          <option value="BaVi">Ba Vì</option>
          <option value="SocSon">Sóc Sơn</option>
          <option value="TamDao">Tam Đảo</option>
          <option value="MocChau">Mộc Châu</option>
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
     </section>
   
     <section>
      <div class="social-sidebar">
            <a href="#" target="_blank"><img src="../ANH/zalo.jpg" alt="Zalo"></a>
            <a href="#" target="_blank"><img src="../ANH/MES.jpg" alt="Messenger"></a>
            <a href="#" target="_blank"><img src="../ANH/FB.jpg" alt="Facebook"></a>
            <a href="#" target="_blank"><img src="../ANH/IG.jpg" alt="Instagram"></a>
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
        <img src="../ANH/BV1.jpg" alt="Homestay 1">
        <div class="info">
          <h3>Mely Farm</h3>
          <p>Giá: 800.000đ / đêm</p>
          <p>Sức chứa: 6 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/BV2.jpg" alt="Homestay 2">
        <div class="info">
          <h3>Family Homestay</h3>
          <p>Giá: 850.000đ / đêm</p>
          <p>Sức chứa: 5 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/BV3.jpg" alt="Homestay 3">
        <div class="info">
          <h3>Melia Bavi Mountain Retreat</h3>
          <p>Giá: 900.000đ / đêm</p>
          <p>Sức chứa: 8 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/BV4.jpg" alt="Homestay 4">
        <div class="info">
          <h3>BaVi Padme </h3>
          <p>Giá: 750.000đ / đêm</p>
          <p>Sức chứa: 4 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/MC1.webp" alt="Homestay 5">
        <div class="info">
          <h3>Phoenix Mộc Châu Bungalow</h3>
          <p>Giá: 1.000.000đ / đêm</p>
          <p>Sức chứa: 10 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/MC2.webp" alt="Homestay 6">
        <div class="info">
          <h3>Mộc Châu Eco-garden</h3>
          <p>Giá: 950.000đ / đêm</p>
          <p>Sức chứa: 7 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/MC3.webp" alt="Homestay 7">
        <div class="info">
          <h3>Mama’s House</h3>
          <p>Giá: 800.000đ / đêm</p>
          <p>Sức chứa: 6 khách</p>
          <button class="btn">Đặt phòng</button>
        </div> 
      </div>

      <div class="homestay-card">
        <img src="../ANH/MC4.webp" alt="Homestay 8">
        <div class="info">
          <h3>Mộc Homestay</h3>
          <p>Giá: 850.000đ / đêm</p>
          <p>Sức chứa: 5 khách</p>
          <button class="btn">Đặt phòng</button>
        </div> 
      </div>

      <div class="homestay-card">
        <img src="../ANH/SS1.jpg" alt="Homestay 9">
        <div class="info">
          <h3>Amaya Home</h3>
          <p>Giá: 900.000đ / đêm</p>
          <p>Sức chứa: 8 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/SS2.jpg" alt="Homestay 10">
        <div class="info">
          <h3>Cerf Volant Soc Son Resort</h3>
          <p>Giá: 750.000đ / đêm</p>
          <p>Sức chứa: 4 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/SS3.jpg" alt="Homestay 11">
        <div class="info">
          <h3>De'bay Retreat</h3>
          <p>Giá: 1.000.000đ / đêm</p>
          <p>Sức chứa: 10 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/SS5.jpg" alt="Homestay 12">
        <div class="info">
          <h3>Amaya Retreat</h3>
          <p>Giá: 950.000đ / đêm</p>
          <p>Sức chứa: 7 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/TD1.jpg" alt="Homestay 13">
        <div class="info">
          <h3>Dream House</h3>
          <p>Giá: 800.000đ / đêm</p>
          <p>Sức chứa: 6 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/TD2.jpg" alt="Homestay 14">
        <div class="info">
          <h3>Le Bleu Floating Cloud</h3>
          <p>Giá: 850.000đ / đêm</p>
          <p>Sức chứa: 5 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/TD3.jpg" alt="Homestay 15">
        <div class="info">
          <h3>Up In The Air Homestay</h3>
          <p>Giá: 900.000đ / đêm</p>
          <p>Sức chứa: 8 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>

      <div class="homestay-card">
        <img src="../ANH/TD4.jpg" alt="Homestay 16">
        <div class="info">
          <h3>Cloudy Garden</h3>
          <p>Giá: 750.000đ / đêm</p>
          <p>Sức chứa: 4 khách</p>
          <button class="btn">Đặt phòng</button>
        </div>
      </div>


      <!-- Thêm tiếp cho đủ 16 homestay -->
      <!-- ... -->
    </div>
  </div>

  <a href="homestay.php" class="show-more">Xem đầy đủ các HomeStay</a>
</section>
<script>
let currentScroll = 0;

function scrollHomestay(direction) {
  const list = document.querySelector('.homestay-list');
  const cardWidth = document.querySelector('.homestay-card').offsetWidth + 20; // 20 = margin
  const visibleCards = Math.floor(document.querySelector('.homestay-container').offsetWidth / cardWidth);

  currentScroll += direction * cardWidth * visibleCards;

  const maxScroll = (list.children.length - visibleCards) * cardWidth;
  if (currentScroll < 0) currentScroll = 0;
  if (currentScroll > maxScroll) currentScroll = maxScroll;

  list.style.transform = `translateX(-${currentScroll}px)`;
}
</script>


<!---------------------------------------------Giảm giá-------------------------------------------------------------------------->
         <!-- ƯU ĐÃI / DEALS -->
<section class="deals">
  <div class="container">
    <h1 class="h1-style">Ưu đãi & Khuyến mãi</h1>

    <!-- Banner giảm giá -->
    <div class="deal-banner">
      <img src="../ANH/8.png" alt="Summer Sale">
      <div class="deal-banner-text">
        <h2>Summer Sale 🔥</h2>
        <p>Giảm đến 30% cho tất cả Homestay</p>
        <button>Đặt ngay</button>
      </div>
    </div>

    <!-- Các gói combo -->
    <div class="deal-cards">
      <div class="deal-card">
        <h3>🌟 Giảm 20%</h3>
        <p>Khi đặt từ 2 đêm liên tiếp</p>
        <button>Xem chi tiết</button>
      </div>
      <div class="deal-card">
        <h3>🍖 Combo BBQ</h3>
        <p>Miễn phí BBQ khi đặt villa > 5 khách</p>
        <button>Xem chi tiết</button>
      </div>
      <div class="deal-card">
        <h3>👨‍👩‍👧‍👦 Ưu đãi nhóm</h3>
        <p>Giảm thêm 10% cho đoàn từ 10 người</p>
        <button>Xem chi tiết</button>
      </div>
    </div>
  </div>
</section>
<!-- --------------------------------------------------------------------------------------------------------->


<!------------------------------------Tìm kiếm theo địa điểm---------------------------------------------------------------->
<section id="explore-location" class="explore-location">
  <h2>Khám phá Homestay theo địa điểm</h2>
  <div class="location-grid">
    <div class="location-item">
      <img src="../ANH/SS5.jpg" alt="Sóc Sơn">
      <div class="overlay">Sóc Sơn
     <a href="placesocson.php"> <button class="btn-location">Xem chi tiết</button></a>
    </div>
    </div>
    <div class="location-item">
      <img src="../ANH/TD1.jpg" alt="Hồ Gươm">
      <div class="overlay">Tam đảo
      <a href="placetamdao.php"> <button class="btn-location">Xem chi tiết</button></a>
    </div>
    </div>
    <div class="location-item">
      <img src="../ANH/MC1.webp" alt="Hồ Tây">
      <div class="overlay">Mộc Châu
    <a href="placemocchau.php"> <button class="btn-location">Xem chi tiết</button></a>
      </div>
    </div>
    <div class="location-item">
      <img src="../ANH/BV2.jpg" alt="Ba Vì">
      <div class="overlay">Ba Vì
     <a href="placebavi.php"> <button class="btn-location">Xem chi tiết</button></a>
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
        <img src="../ANH/TT1.webp" alt="Kinh nghiệm du lịch Đà Lạt">
        <div class="blog-info">
          <h3>Kinh nghiệm du lịch Ba Vì 3 ngày 2 đêm</h3>
          <p>Chia sẻ lịch trình du lịch Ba Vì tiết kiệm, homestay đẹp, các điểm check-in nổi tiếng.</p>
          <a href="blog1.html" class="btn-read">Đọc thêm</a>
        </div>
      </div>

      <!-- Bài viết 2 -->
      <div class="blog-card">
        <img src="../ANH/TT2.jpg" alt="Mẹo đặt homestay giá rẻ">
        <div class="blog-info">
          <h3>Mẹo đặt homestay giá rẻ mùa cao điểm</h3>
          <p>Bí quyết săn homestay với giá tốt, tránh tình trạng hết phòng vào mùa lễ hội.</p>
          <a href="blog2.html" class="btn-read">Đọc thêm</a>
        </div>
      </div>

      <!-- Bài viết 3 -->
      <div class="blog-card">
        <img src="../ANH/TT3.webp" alt="Khám phá Sapa">
        <div class="blog-info">
          <h3>Khám phá Sapa: Đi đâu, ăn gì, ở đâu?</h3>
          <p>Gợi ý các homestay view núi rừng đẹp, trải nghiệm ẩm thực và văn hóa địa phương.</p>
          <a href="blog3.html" class="btn-read">Đọc thêm</a>
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
        <a href="#"><img src="../ANH/FB.jpg" alt="Facebook"></a>
        <a href="#"><img src="../ANH/IG.jpg" alt="Instagram"></a>
        <a href="#"><img src="../ANH/zalo.jpg" alt="Zalo"></a>
        <a href="#"><img src="../ANH/MES.jpg" alt="TikTok"></a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2025 BookingHomeStay. All rights reserved.</p>
  </div>
</footer>
</body>
</html>