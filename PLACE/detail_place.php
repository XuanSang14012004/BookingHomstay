<?php
include '../config/db.php';

// Lấy id homestay từ URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Query thông tin homestay
$sql = "SELECT * FROM db_homestay WHERE mahomestay = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$homestay = $result->fetch_assoc();
$stmt->close();

// Query danh sách phòng thuộc homestay
$rooms = [];
$sql_room = "SELECT * FROM db_phong WHERE mahomestay = ?";
$stmt = $conn->prepare($sql_room);
$stmt->bind_param("s", $id);
$stmt->execute();
$rooms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Query đánh giá (JOIN phòng)
$reviews = [];
$sql_review = "
    SELECT d.tenkhachhang, d.sao, d.binhluan, d.ngaydg
    FROM db_danhgia d
    JOIN db_phong p ON d.maphong = p.maphong
    WHERE p.mahomestay = ?
    ORDER BY d.ngaydg DESC
";
$stmt = $conn->prepare($sql_review);
$stmt->bind_param("s", $id);
$stmt->execute();
$reviews = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Tính rating trung bình & tổng số đánh giá
$rating = 0;
$reviews_count = count($reviews);
if ($reviews_count > 0) {
    $total_star = array_sum(array_column($reviews, 'sao'));
    $rating = round($total_star / $reviews_count, 1);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title><?php echo $homestay ? $homestay['tenhomestay'] : 'Chi tiết Homestay'; ?></title>
  <link rel="stylesheet" href="../CSS/style_user.css?v=7">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
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
</div>
  <?php if ($homestay): ?>
    <div class="container-place">
      <h1><?php echo $homestay['tenhomestay']; ?></h1>
      <p class="address"><i class="fa-solid fa-location-dot"></i> <?php echo $homestay['diachi']; ?></p>

      <!-- Mô tả -->
      <div class="description">
        <p><?php echo $homestay['mota']; ?></p>
      </div>

      <!-- Hình ảnh -->
     <div class="gallery">
    <?php if (!empty($homestay['hinhanh'])): ?>
        <img src="<?php echo htmlspecialchars($homestay['hinhanh']); ?>" 
             alt="<?php echo htmlspecialchars($homestay['tenhomestay']); ?> - Ảnh 1">
    <?php endif; ?>

    <?php if (!empty($homestay['hinhanh2'])): ?>
        <img src="<?php echo htmlspecialchars($homestay['hinhanh2']); ?>" 
             alt="<?php echo htmlspecialchars($homestay['tenhomestay']); ?> - Ảnh 2">
    <?php endif; ?>
</div>

      <!-- Thông tin -->
      <div class="info">
        <p><i class="fa-solid fa-phone"></i> <?php echo $homestay['sodienthoai']; ?></p>
        <p><i class="fa-solid fa-envelope"></i> <?php echo $homestay['email']; ?></p>
        <p><i class="fa-solid fa-door-open"></i> Loại phòng: <?php echo $homestay['loaiphong']; ?></p>
        <p><i class="fa-solid fa-bed"></i> Số phòng: <?php echo $homestay['sophong']; ?></p>
        <p><i class="fa-solid fa-circle-info"></i> Trạng thái: <?php echo $homestay['trangthai']; ?></p>
      </div>

<!-- Tiện ích -->
<div class="amenities">
  <h2>Tiện ích</h2>
  <ul>
    <li><i class="fa-solid fa-wifi"></i> Wifi miễn phí</li>
    <li><i class="fa-solid fa-snowflake"></i> Điều hòa</li>
    <li><i class="fa-solid fa-tv"></i> TV màn hình phẳng</li>
    <li><i class="fa-solid fa-kitchen-set"></i> Bếp riêng</li>
    <li><i class="fa-solid fa-person-swimming"></i> Hồ bơi ngoài trời</li>
    <li><i class="fa-solid fa-square-parking"></i> Bãi đỗ xe</li>
  </ul>
</div>



      <!-- Danh sách phòng -->
      <div class="rooms">
        <h2>Danh sách phòng</h2>
        <?php if (!empty($rooms)): ?>
          <ul>
            <?php foreach ($rooms as $r): ?>
              <li>
                <strong><?php echo $r['tenphong']; ?></strong> - 
                <?php echo number_format($r['gia'], 0, ',', '.'); ?>đ / đêm 
                (<?php echo $r['loaiphong']; ?>, <?php echo $r['songuoi']; ?> người)
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p>Chưa có phòng nào.</p>
        <?php endif; ?>
      </div>

      <!-- Đánh giá -->
      <div class="reviews">
        <h2>Đánh giá khách hàng</h2>
        <p>⭐ <?php echo $rating; ?>/5 - (<?php echo $reviews_count; ?> đánh giá)</p>
        <?php if (!empty($reviews)): ?>
          <?php foreach ($reviews as $rv): ?>
            <div class="review-item" style="margin-bottom:10px; border-bottom:1px solid #ddd; padding:10px 0;">
              <strong><?php echo htmlspecialchars($rv['tenkhachhang']); ?></strong> 
              - <span style="color:gold;">⭐ <?php echo $rv['sao']; ?>/5</span>
              <p><?php echo nl2br(htmlspecialchars($rv['binhluan'])); ?></p>
              <small><i class="fa-regular fa-clock"></i> <?php echo $rv['ngaydg']; ?></small>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Chưa có đánh giá nào cho homestay này.</p>
        <?php endif; ?>
      </div>

      <!-- Giá & Đặt phòng -->
      <p class="price">Giá từ: <?php echo number_format($homestay['gia'], 0, ',', '.'); ?>đ / đêm</p>
     <a href="../PAY/user_booking.php?mahomestay=<?php echo urlencode($homestay['mahomestay']); ?>" class="btn-price">
    <i class="fa-solid fa-bed"></i> Đặt phòng ngay</a>
    </div>
  <?php else: ?>
    <p>❌ Không tìm thấy homestay này.</p>
  <?php endif; ?>

  <!-- Nút quay về trang chủ -->
  <div style="margin-top:20px; text-align:center;">
    <a href="../TrangChu/user_main.php" 
       style="display:inline-block; padding:10px 20px; background:#007BFF; color:#fff; text-decoration:none; border-radius:5px;">
       ← Quay về trang chủ
    </a>
  </div>
  <!-- Footer -->]
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
