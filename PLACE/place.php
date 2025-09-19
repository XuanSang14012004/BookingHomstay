<?php
include '../db.php'; // kết nối database

// Lấy dữ liệu từ GET
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';
$price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';
$sort_stars = isset($_GET['sort_stars']) ? $_GET['sort_stars'] : '';

// Câu SQL cơ bản
$sql = "SELECT * FROM homestays WHERE address LIKE ?";
$search = "%$location%";

// Thêm điều kiện loại phòng
if (!empty($room_type)) {
    $sql .= " AND room_type = ?";
}

// Thêm điều kiện lọc giá
if (!empty($price_range)) {
    if ($price_range === "under_1m") {
        $sql .= " AND price < 1000000";
    } elseif ($price_range === "1m_1_5m") {
        $sql .= " AND price BETWEEN 1000000 AND 1500000";
    } elseif ($price_range === "over_1_5m") {
        $sql .= " AND price >= 1500000";
    }
}

// Thêm sắp xếp sao
if (!empty($sort_stars)) {
    if ($sort_stars === "asc") {
        $sql .= " ORDER BY rating ASC";
    } elseif ($sort_stars === "desc") {
        $sql .= " ORDER BY rating DESC";
    }
}

// Chuẩn bị statement
if (!empty($room_type)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $search, $room_type);
} else {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
}

$stmt->execute();
$result = $stmt->get_result();

// Lấy danh sách homestay
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
  <link rel="stylesheet" href="../CSS/style_user.css?v=5.1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
  <!-- Header -->
   <div class="header-top">
        <ul>
            <li><a href="../TrangChu/user.php">Trang chủ</a></li>
            <li><a href="../TrangChu/about.php">Về chúng tôi</a></li>
            <li><a href="../TrangChu/contact.html">&#9742;Liên hệ</a></li>
            <li><a href="##review">Đánh giá</a></li>
            <li><a href="#explore-location">Danh sách các HomeStay</a></li>
             <li><a href="login.php">Đăng nhập</a></li>
             <li><a href="#"><i class="fa-solid fa-user"></i></a></li>
             <ul class="menu">
             <li><a href="../PLACE/history.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
          </ul>
        </ul>
    </div>

  <!-- Bộ lọc -->
  <div class="container-place">
   <h2>Danh sách Homestay</h2>

<!-- Form lọc -->
<form method="GET" action="" class="filter-bar-place">
  <!-- Giữ lại location -->
  <input type="hidden" name="location" value="<?php echo htmlspecialchars($location); ?>">

  <!-- Lọc loại phòng -->
  <select name="room_type" onchange="this.form.submit()">
    <option value="">-- Lọc theo loại phòng --</option>
    <option value="Deluxe" <?php if($room_type=="Deluxe") echo "selected"; ?>>Deluxe</option>
    <option value="Family" <?php if($room_type=="Family") echo "selected"; ?>>Family</option>
    <option value="Standard" <?php if($room_type=="Standard") echo "selected"; ?>>Standard</option>
  </select>

  <!-- Sắp xếp theo sao -->
  <select name="sort_stars" onchange="this.form.submit()">
    <option value="">-- Sắp xếp theo sao --</option>
    <option value="desc" <?php if($sort_stars=="desc") echo "selected"; ?>>Sao cao → thấp</option>
    <option value="asc" <?php if($sort_stars=="asc") echo "selected"; ?>>Sao thấp → cao</option>
  </select>

  <!-- Lọc theo giá -->
  <select name="price_range" onchange="this.form.submit()">
    <option value="">-- Lọc theo giá --</option>
    <option value="under_1m" <?php if($price_range=="under_1m") echo "selected"; ?>>< 1.000.000 VND</option>
    <option value="1m_1_5m" <?php if($price_range=="1m_1_5m") echo "selected"; ?>>1.000.000 - 1.500.000 VND</option>
    <option value="over_1_5m" <?php if($price_range=="over_1_5m") echo "selected"; ?>>>= 1.500.000 VND</option>
  </select>
</form>
  </div>

    <!-- Danh sách phòng -->
   <div class="room-list">
  <?php if (!empty($homestays)): ?>
    <?php foreach ($homestays as $h): ?>
      <div class="card">
        <img src="<?php echo $h['img'] ?? '../ANH/default.jpg'; ?>" alt="<?php echo $h['name'] ?? 'Homestay'; ?>">
        <div class="card-content">
          <h3><?php echo $h['name']; ?></h3>
          <p class="info">Loại phòng: <?php echo $h['room_type']; ?></p>
          <p class="info">Tình trạng: 
            <?php if ($h['status'] == 'còn phòng'): ?>
              <b style="color:green">Còn phòng</b>
            <?php else: ?>
              <b style="color:red">Hết phòng</b>
            <?php endif; ?>
          </p>
          <p class="price">Giá: <?php echo number_format($h['price'], 0, ',', '.'); ?>đ / đêm</p>
          <div class="stars"><?php echo str_repeat("⭐", (int)($h['rating'] ?? 0)); ?></div>
          <div class="btn-group">
            <a href="detail_place.php?id=<?php echo $h['id']; ?>" class="btn-place btn-detail">Xem chi tiết</a>
            <a href="../PAY/booking.php?id=<?php echo $h['id']; ?>" class="btn-place btn-book">Đặt phòng</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>❌ Không tìm thấy homestay nào phù hợp.</p>
  <?php endif; ?>
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
    <script src="../JS/JS_TRANGCHU.js?v=2.0"></script>
  </footer>
</body>
</html>
