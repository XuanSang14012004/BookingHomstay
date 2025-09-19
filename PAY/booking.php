<?php
include '../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin homestay
$sql = "SELECT * FROM homestays WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) die("Lỗi prepare: " . $conn->error);

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$homestay = $result->fetch_assoc();

// Nhận thông số ưu đãi từ URL
$discount = isset($_GET['discount']) ? floatval($_GET['discount']) : 0; // % người dùng nhập
$group_discount = isset($_GET['group_discount']) ? floatval($_GET['group_discount']) : 0; // % nhóm
$free_bbq = isset($_GET['free_bbq']) ? intval($_GET['free_bbq']) : 0;
$min_nights = isset($_GET['min_nights']) ? intval($_GET['min_nights']) : 1;
$min_guests = isset($_GET['min_guests']) ? intval($_GET['min_guests']) : 1;

$message = "";
$bbq_text = "";

// Nếu homestay loại Deluxe, tự động giảm 30%
$auto_deluxe_discount = 0;
if ($homestay && strtolower($homestay['room_type']) === 'deluxe') {
    $auto_deluxe_discount = 30; // % giảm giá tự động
    $message .= " Giảm $auto_deluxe_discount% cho homestay Deluxe!<br>";
}

// Xử lý đặt phòng
if ($_SERVER["REQUEST_METHOD"] === "POST" && $homestay) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $checkin_date = $_POST['checkin_date'] ?? '';
    $checkout_date = $_POST['checkout_date'] ?? '';
    $guests = intval($_POST['guests'] ?? 1);
    $payment_method = $_POST['payment_method'] ?? '';

   // Tính số đêm
$days = max(1, (strtotime($checkout_date) - strtotime($checkin_date)) / (60*60*24));
$total_price = $days * ($homestay['price'] ?? 0);

// Áp dụng giảm giá auto cho Deluxe
if ($auto_deluxe_discount > 0) {
    $total_price *= (1 - $auto_deluxe_discount / 100);
    $message .= "✅ Giảm $auto_deluxe_discount% tự động cho Deluxe.<br>";
}

// Áp dụng giảm giá từ URL (nếu có)
if ($discount > 0) {
    $total_price *= (1 - $discount / 100);
    $message .= "✅ Giảm thêm $discount% (khuyến mãi).<br>";
}

    // Insert booking vào database
    $sql_insert = "INSERT INTO bookings (homestay_id, customer_name, customer_email, customer_phone, checkin_date, checkout_date, guests, payment_method, total_price)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    if (!$stmt_insert) die("Lỗi prepare insert: " . $conn->error);

    $stmt_insert->bind_param("isssssisi", $id, $name, $email, $phone, $checkin_date, $checkout_date, $guests, $payment_method, $total_price);

    if ($stmt_insert->execute()) {
        $message .= "✅ Đặt phòng thành công! Tổng tiền: " . number_format($total_price,0,",",".") . "đ.<br>$bbq_text";
    } else {
        $message .= "❌ Lỗi khi đặt phòng: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đặt phòng - <?php echo $homestay['name'] ?? 'Homestay'; ?></title>
<link rel="stylesheet" href="../CSS/style_user.css?v=4.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <div class="header-top">
        <ul>
            <li><a href="../TrangChu/user.php">Trang chủ</a></li>
            <li><a href="../TrangChu/about.php">Về chúng tôi</a></li>
            <li><a href="../TrangChu/contact.html">&#9742;Liên hệ</a></li>
            <li><a href="">Đánh giá</a></li>
            <li><a href="../TrangChu/homestay.php">Danh sách các HomeStay</a></li>
            <li><a href="login.php">Đăng nhập</a></li>
            <li><a href="#"><i class="fa-solid fa-user"></i></a></li>
            <ul class="menu">
                <li><a href="../PLACE/history.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </ul>
    </div>

<div class="container-booking">
<?php if ($homestay): ?>
    <h1>Đặt phòng: <?php echo $homestay['name']; ?></h1>
    <div class="info-booking">
        <p><i class="fa-solid fa-location-dot"></i> <?php echo $homestay['address']; ?></p>
        <p><?php echo $homestay['description']; ?></p>
    </div>

    <div class="gallery">
        <img src="<?php echo $homestay['img']; ?>" alt="">
        <img src="<?php echo $homestay['img1']; ?>" alt="">
        <img src="<?php echo $homestay['img2']; ?>" alt="">
        <img src="<?php echo $homestay['img3']; ?>" alt="">
    </div>

 <p class="price-booking">
    <?php if (strtolower($homestay['room_type']) === 'deluxe'): ?>
        Giá gốc: <span style="text-decoration:line-through;">
            <?php echo number_format($homestay['price'],0,",","."); ?>đ
        </span> / đêm
        <br>
        Giá sau giảm: 
        <strong style="color:red;">
            <?php echo number_format($homestay['price'] * (1 - ($auto_deluxe_discount + $discount)/100),0,",","."); ?>đ
        </strong> / đêm
    <?php else: ?>
        Giá: <strong style="color:red;">
            <?php echo number_format($homestay['price'],0,",","."); ?>đ
        </strong> / đêm
    <?php endif; ?>
</p>


    <div class="message"><?php echo $message; ?></div>

    <form method="POST" class="POST">
        <label>Họ và tên:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Số điện thoại:</label>
        <input type="text" name="phone" required>

        <label>Ngày nhận phòng:</label>
        <input type="date" name="checkin_date" required>

        <label>Ngày trả phòng:</label>
        <input type="date" name="checkout_date" required>

        <label>Số khách:</label>
        <input type="number" name="guests" value="1" min="1" max="<?php echo $homestay['guests']; ?>" required>

        <div class="booking-method">
            <label>Chọn phương thức thanh toán</label>
            <select name="payment_method" required>
                <option value="cash">Thanh toán khi nhận phòng</option>
                <option value="bank">Chuyển khoản ngân hàng</option>
                <option value="card">Thẻ tín dụng / ghi nợ</option>
                <option value="momo">Momo / ZaloPay</option>
            </select>
        </div>

        <button type="submit"><i class="fa-solid fa-bed"></i> Xác nhận đặt phòng</button>
    </form>
<?php else: ?>
    <p>❌ Không tìm thấy homestay.</p>
<?php endif; ?>
</div>

<script src="../JS/JS_TRANGCHU.js"></script>

<footer class="footer">
  <div class="footer-container">
    <div class="footer-col">
      <h2>BookingHomeStay</h2>
      <p>Đặt homestay nhanh chóng, dễ dàng và tiện lợi. Mang đến trải nghiệm nghỉ dưỡng tuyệt vời cho bạn.</p>
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
</footer>
</body>
</html>
