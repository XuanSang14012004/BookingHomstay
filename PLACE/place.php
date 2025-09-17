<?php
include '../db.php'; // kết nối database

$location = isset($_GET['location']) ? trim($_GET['location']) : '';

// Đổi location -> address (trong CSDL chỉ có address, không có location)
$sql = "SELECT * FROM homestays WHERE address LIKE ?";
$search = "%$location%";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

$homestays = [];
while ($row = $result->fetch_assoc()) {
    $homestays[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danh sách Homestay <?php echo htmlspecialchars($location); ?></title>
  <link rel="stylesheet" href="../CSS/css.css?v=1.1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
  <!-- Header -->
  <header>
    <h1>Homestay <?php echo htmlspecialchars($location); ?></h1>
    <nav>
      <ul>
        <li><a href="../TrangChu/user.php">Trang chủ</a></li>
        <li><a href="#">Liên hệ</a></li>
        <li><a href="#"><i class="fa-solid fa-user"></i> Tài khoản</a></li>
      </ul>
    </nav>
  </header>

  <!-- Bộ lọc -->
  <div class="container">
    <h2>Danh sách Homestay</h2>
    <div class="filter-bar">
      <input type="text" id="searchInput" placeholder="🔍 Tìm kiếm theo tên phòng...">
      <select id="filterType">
        <option value="">-- Lọc theo loại phòng --</option>
        <option value="Deluxe">Deluxe</option>
        <option value="Family">Family</option>
        <option value="Standard">Standard</option>
      </select>
      <select id="sortStars">
        <option value="">-- Sắp xếp theo sao --</option>
        <option value="desc">Sao cao → thấp</option>
        <option value="asc">Sao thấp → cao</option>
      </select>
    </div>

    <!-- Danh sách phòng -->
    <div class="room-list" id="roomList">
      <?php if (!empty($homestays)): ?>
        <?php foreach ($homestays as $h): ?>
          <div class="card" data-type="<?php echo $h['room_type'] ?? ''; ?>" data-stars="<?php echo $h['rating'] ?? 0; ?>">
            <img src="<?php echo $h['img'] ?? '../ANH/default.jpg'; ?>" alt="<?php echo $h['name'] ?? 'Homestay'; ?>">
            <div class="card-content">
              <h3><?php echo $h['name'] ?? 'Chưa có tên'; ?></h3>
              <p class="info">Số phòng: <?php echo $h['rooms'] ?? 'Chưa có thông tin'; ?></p>
              <p class="info">Loại phòng: <?php echo $h['room_type'] ?? 'Chưa có'; ?></p>
              <p class="info">Tình trạng: 
                <?php if (($h['status'] ?? '') == 'Còn trống'): ?>
                  <b style="color:green">Còn trống</b>
                <?php else: ?>
                  <b style="color:red">Đã đặt</b>
                <?php endif; ?>
              </p>
              <p class="info">Nhận phòng: <?php echo $h['checkin'] ?? '-'; ?> | Trả phòng: <?php echo $h['checkout'] ?? '-'; ?></p>
              <p class="price">Giá: <?php echo isset($h['price']) ? number_format($h['price'], 0, ',', '.') : '-'; ?>đ / đêm</p>
              <div class="stars"><?php echo str_repeat("⭐", (int)($h['rating'] ?? 0)); ?></div>
              <div class="btn-group">
                <a href="detail_place.php?id=<?php echo $h['id'] ?? 0; ?>" class="btn-place btn-detail">Xem chi tiết</a>
                <a href="#" class="btn-place btn-book">Đặt phòng</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>❌ Không tìm thấy homestay cho địa điểm này.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-col">
        <h2>BookingHomeStay</h2>
        <p>Đặt homestay nhanh chóng, dễ dàng và tiện lợi.  
        Mang đến trải nghiệm nghỉ dưỡng tuyệt vời cho bạn.</p>
      </div>
      <div class="footer-col">
        <h3>Liên hệ</h3>
        <p>📍 Hà Nội, Việt Nam</p>
        <p>📞 0123 456 789</p>
        <p>✉️ bookinghomestay@gmail.com</p>
      </div>
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
    <script src="../JS/JS_TRANGCHU.js"></script>
  </footer>
</body>
</html>
