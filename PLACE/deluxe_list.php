<?php
include '../db.php';

// Lấy danh sách homestay loại Deluxe
$discount = isset($_GET['discount']) ? floatval($_GET['discount']) : 0;

$sql = "SELECT * FROM homestays WHERE LOWER(room_type)='deluxe'";
$result = $conn->query($sql);

$homestays = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $homestays[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Danh sách Homestay Deluxe</title>
<link rel="stylesheet" href="../CSS/style_user.css?v=4.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
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
    <h1 class="deluxe-title">Danh sách Homestay Deluxe - Giảm <?php echo $discount; ?>%</h1>
    
    <div class="homestay-deluxe-list">
        <?php foreach($homestays as $homestay): 
            $price = $homestay['price'];
            $discountPrice = $price * (1 - $discount/100);
        ?>
            <div class="homestay-deluxe-card">
                <img src="<?php echo $homestay['img']; ?>" alt="">
                <h3><?php echo $homestay['name']; ?></h3>

                <p class="price-original"><?php echo number_format($price,0,",","."); ?>đ / đêm</p>
                <p class="price-discounted"><?php echo number_format($discountPrice,0,",","."); ?>đ / đêm</p>

                <p class="discount">✅ Giảm <?php echo $discount; ?>%</p>
                <a href="../PAY/booking.php?id=<?php echo $homestay['id']; ?>&discount=<?php echo $discount; ?>">
    <button class="btn-booking">Đặt phòng</button>
                </a>
            </div>
        <?php endforeach; ?>
        <?php if(empty($homestays)) echo "<p class='no-data'>❌ Không có homestay Deluxe nào.</p>"; ?>
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
