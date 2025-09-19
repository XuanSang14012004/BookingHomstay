<?php
include '../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM homestays WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$homestay = $result->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title><?php echo $homestay ? $homestay['name'] : 'Chi tiết Homestay'; ?></title>
  <link rel="stylesheet" href="../CSS/style_user.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
  <?php if ($homestay): ?>
    <div class="container-place">
      <h1><?php echo $homestay['name']; ?></h1>
      <p class="address"><i class="fa-solid fa-location-dot"></i> <?php echo $homestay['address']; ?></p>

      <!-- Mô tả -->
      <div class="description">
        <p><?php echo $homestay['description']; ?></p>
      </div>

      <!-- Hình ảnh -->
      <div class="gallery">
        <img src="<?php echo $homestay['img']; ?>" alt="Ảnh homestay 1">
        <img src="<?php echo $homestay['img1']; ?>" alt="Ảnh homestay 2">
        <img src="<?php echo $homestay['img2']; ?>" alt="Ảnh homestay 3">
        <img src="<?php echo $homestay['img3']; ?>" alt="Ảnh homestay 4">
      </div>

      <!-- Tiện ích -->
      <div class="utilities">
        <h2>Tiện ích</h2>
        <ul>
          <li><i class="fa-solid fa-wifi"></i> Wifi miễn phí</li>
          <li><i class="fa-solid fa-snowflake"></i> Điều hòa</li>
          <li><i class="fa-solid fa-tv"></i> TV màn hình phẳng</li>
          <li><i class="fa-solid fa-kitchen-set"></i> Bếp riêng</li>
          <li><i class="fa-solid fa-water-ladder"></i> Hồ bơi ngoài trời</li>
          <li><i class="fa-solid fa-car"></i> Bãi đỗ xe</li>
        </ul>
      </div>

      <!-- Check-in / Check-out -->
      <div class="checkin-checkout">
        <h2>Thời gian nhận & trả phòng</h2>
        <p><i class="fa-solid fa-right-to-bracket"></i> Nhận phòng: <?php echo $homestay['checkin']; ?></p>
        <p><i class="fa-solid fa-right-from-bracket"></i> Trả phòng: <?php echo $homestay['checkout']; ?></p>
      </div>

      <!-- Đánh giá -->
      <div class="reviews">
        <h2>Đánh giá từ khách hàng</h2>
        <div class="rating">
          ⭐⭐⭐⭐☆ (<?php echo $homestay['rating']; ?>/5 - <?php echo $homestay['reviews_count']; ?> đánh giá)
        </div>
        <div class="review">
          <strong>Nguyễn Lan:</strong> "Homestay rất đẹp, không gian yên tĩnh, chủ nhà thân thiện. Rất đáng để quay lại!"
        </div>
        <div class="review">
          <strong>Trần Minh:</strong> "Phòng sạch sẽ, đầy đủ tiện nghi. Hồ bơi cực chill vào buổi tối."
        </div>
        <div class="review">
          <strong>Phạm Hòa:</strong> "Vị trí thuận tiện, đi từ Hà Nội khá gần. Giá cả hợp lý so với chất lượng."
        </div>
      </div>

      <!-- Giá & Đặt phòng -->
      <p class="price">Giá: <?php echo number_format($homestay['price'], 0, ',', '.'); ?>đ / đêm</p>
      <a href="booking.php?id=<?php echo $homestay['id']; ?>" class="btn-price"><i class="fa-solid fa-bed"></i> Đặt phòng ngay</a>
    </div>
  <?php else: ?>
    <p>❌ Không tìm thấy homestay này.</p>
  <?php endif; ?>

  <!-- Nút quay về trang chủ -->
<div style="margin-top:20px; text-align:center;">
    <a href="../TrangChu/user.php" 
       style="display:inline-block; padding:10px 20px; background:#007BFF; color:#fff; text-decoration:none; border-radius:5px;">
       ← Quay về trang chủ
    </a>
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
</body>
</html>
