<?php
include '../db.php'; // file kết nối CSDL

// Lấy 16 homestay đầu tiên
$sql = "SELECT * FROM homestays LIMIT 16";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <link rel="stylesheet" href="../CSS/style_user.css?v=6">
  <title>Danh sách Homestay</title>
</head>
<body>
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
  <div class="h1-homestay">
  <h1>Danh sách Homestay</h1>
  </div>
  <div class="container-homestay">
    <!-- Bộ lọc -->
    <div class="filter-box">
      <h3>Lọc kết quả</h3>
      <div>
        <strong>Số sao</strong>
        <label><input type="checkbox" class="filter" value="5sao"> 5 sao</label>
        <label><input type="checkbox" class="filter" value="4sao"> 4 sao</label>
        <label><input type="checkbox" class="filter" value="3sao"> 3 sao</label>
        <label><input type="checkbox" class="filter" value="2sao"> 2 sao</label>
        <label><input type="checkbox" class="filter" value="1sao"> 1 sao</label>
      </div>
      <div>
        <strong>Tình trạng</strong>
        <label><input type="checkbox" class="filter" value="còn phòng"> Còn phòng</label>
        <label><input type="checkbox" class="filter" value="hết phòng"> Hết phòng</label>
      </div>
      <div>
        <strong>Loại phòng</strong>
        <label><input type="checkbox" class="filter" value="Deluxe"> Deluxe</label>
        <label><input type="checkbox" class="filter" value="Family"> Family</label>
        <label><input type="checkbox" class="filter" value="Standard"> Standard</label>
      </div>
    </div>

    <!-- Danh sách homestay -->
    <div class="list-homestay" id="list-homestay">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): 
          // Tạo data-* cho filter
          $star = round($row['rating']); 
          $star_text = str_repeat("★", $star) . str_repeat("☆", 5-$star);
          $status = strtolower($row['status']) === 'còn phòng' ? 'còn phòng' : 'hết phòng';
        ?>
          <div class="list-homecard-card" 
              data-star="<?php echo $star . 'sao'; ?>" 
              data-status="<?php echo $status; ?>" 
              data-type="<?php echo $row['room_type']; ?>">
            <img src="<?php echo $row['img']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            <div class="info">
              <h4><?php echo htmlspecialchars($row['name']); ?></h4>
              <div class="star-homestay"><?php echo $star_text; ?></div>
              <div class="status <?php echo $status === 'còn phòng' ? 'available' : 'full'; ?>">
                <?php echo ucfirst($status); ?>
              </div>
              <span class="room-type"><?php echo $row['room_type']; ?></span>
              <a href="../PAY/booking.php?id=<?php echo $row['id']; ?>" class="btn-place-homestay btn-book">Đặt phòng</a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>Không có homestay nào.</p>
      <?php endif; ?>
    </div>
  </div>
  

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
<script src="../JS/JS_TRANGCHU.js">
</script>
</body>
</html>
