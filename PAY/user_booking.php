<?php
// PAY/user_booking.php
include(__DIR__ . '/../config/db.php'); // sửa đường dẫn nếu file db.php nằm nơi khác

// Lấy mahomestay từ URL
if (isset($_GET['mahomestay'])) {
    $mahomestay = $_GET['mahomestay'];

    $stmt = $conn->prepare("SELECT * FROM db_homestay WHERE mahomestay = ?");
    if (!$stmt) die("Lỗi prepare: " . $conn->error);
    $stmt->bind_param("s", $mahomestay);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $homestay = $result->fetch_assoc();
    } else {
        echo "❌ Không tìm thấy homestay.";
        exit;
    }
} else {
    echo "❌ Thiếu tham số homestay.";
    exit;
}

// Nhận thông số ưu đãi từ URL (nếu có)
$discount = isset($_GET['discount']) ? floatval($_GET['discount']) : 0;
$message = "";

// Nếu homestay là Deluxe, giảm 30% tự động
$auto_deluxe_discount = 0;
if ($homestay && strtolower($homestay['loaiphong']) === 'deluxe') {
    $auto_deluxe_discount = 30;
    $message .= "✅ Giảm $auto_deluxe_discount% cho Deluxe!<br>";
}

// Xử lý đặt phòng (đặt homestay, không đặt phòng cụ thể)
if ($_SERVER["REQUEST_METHOD"] === "POST" && $homestay) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $checkin_date = $_POST['checkin_date'] ?? '';
    $checkout_date = $_POST['checkout_date'] ?? '';
    $guests = intval($_POST['guests'] ?? 1);
    $payment_method = $_POST['payment_method'] ?? '';

    // Validate cơ bản
    if (!$checkin_date || !$checkout_date) {
        $message .= "❌ Vui lòng chọn ngày nhận và ngày trả phòng.";
    } else {
        // Tính số đêm
        $days = max(1, (strtotime($checkout_date) - strtotime($checkin_date)) / (60*60*24));
        $total_price = $days * ($homestay['gia'] ?? 0);

        // Áp dụng giảm giá tự động
        if ($auto_deluxe_discount > 0) {
            $total_price *= (1 - $auto_deluxe_discount / 100);
            $message .= "✅ Đã áp dụng giảm $auto_deluxe_discount% cho Deluxe.<br>";
        }

        // Áp dụng giảm từ URL
        if ($discount > 0) {
            $total_price *= (1 - $discount / 100);
            $message .= "✅ Áp dụng giảm $discount% (khuyến mãi).<br>";
        }

        // Sinh mã đơn (ví dụ)
        $madondatphong = "BKG" . date("YmdHis") . rand(100, 999);

        // Insert vào db_booking
        // Lưu ý: db_booking trong SQL của bạn có cột maphong và makhachhang nhưng không bắt NOT NULL,
        // nên ở kịch bản "đặt homestay" ta bỏ qua maphong, makhachhang để lưu nhanh bản ghi đặt.
        $sql_insert = "INSERT INTO db_booking (madondatphong, ngaydat, ngaynhan, ngaytra, songuoi, trangthai)
                       VALUES (?, NOW(), ?, ?, ?, 'chờ xử lý')";
        $stmt_insert = $conn->prepare($sql_insert);
        if (!$stmt_insert) {
            $message .= "❌ Lỗi prepare insert: " . $conn->error;
        } else {
            // types: madondatphong (s), ngaynhan (s), ngaytra (s), songuoi (i)
            $stmt_insert->bind_param("sssi", $madondatphong, $checkin_date, $checkout_date, $guests);

            if ($stmt_insert->execute()) {
                $message .= "✅ Đặt phòng thành công! Tổng tiền: " . number_format($total_price,0,",",".") . "đ.<br>";
                // (tuỳ bạn muốn) có thể lưu $name,$email,$phone vào db_khachhang hoặc gửi email...
            } else {
                $message .= "❌ Lỗi khi đặt phòng: " . $stmt_insert->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đặt phòng - <?php echo $homestay['tenhomestay'] ?? 'Homestay'; ?></title>
<link rel="stylesheet" href="../CSS/style_user.css?v=4.0">
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
  </ul>
</div>
<div class="container-booking">
<?php if ($homestay): ?>
    <h1>Đặt phòng: <?php echo htmlspecialchars($homestay['tenhomestay']); ?></h1>
    <div class="info-booking">
        <p><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($homestay['diachi']); ?></p>
        <?php if (!empty($homestay['mota'])): ?>
            <p><?php echo nl2br(htmlspecialchars($homestay['mota'])); ?></p>
        <?php endif; ?>
    </div>

    <div class="gallery">
    <?php if (!empty($homestay['hinhanh'])): ?>
        <img src="<?php echo htmlspecialchars($homestay['hinhanh']); ?>" 
             alt="<?php echo htmlspecialchars($homestay['tenhomestay']); ?>">
    <?php endif; ?>

    <?php if (!empty($homestay['hinhanh2'])): ?>
        <img src="<?php echo htmlspecialchars($homestay['hinhanh2']); ?>" 
             alt="<?php echo htmlspecialchars($homestay['tenhomestay']); ?> - Ảnh 2">
    <?php endif; ?>
</div>

    <p class="price-booking">
        <?php if (strtolower($homestay['loaiphong']) === 'deluxe'): ?>
            Giá gốc: <span style="text-decoration:line-through;">
                <?php echo number_format($homestay['gia'],0,",","."); ?>đ
            </span> / đêm
            <br>
            Giá sau giảm: 
            <strong style="color:red;">
                <?php echo number_format($homestay['gia'] * (1 - ($auto_deluxe_discount + $discount)/100),0,",","."); ?>đ
            </strong> / đêm
        <?php else: ?>
            Giá: <strong style="color:red;">
                <?php echo number_format($homestay['gia'],0,",","."); ?>đ
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
        <input type="number" name="guests" value="1" min="1" max="<?php echo intval($homestay['sophong']); ?>" required>

        <div class="booking-method">
            <label>Chọn phương thức thanh toán</label>
            <select name="payment_method" required>
                <option value="cash">Thanh toán khi nhận phòng</option>
                <option value="bank">Chuyển khoản ngân hàng</option>
                <option value="card">Thẻ tín dụng / ghi nợ</option>
                <option value="momo">Momo / ZaloPay</option>
            </select>
        </div>
       <!-- Truyền dữ liệu từ PHP qua JS -->
<div id="booking-data" 
     data-price="<?php echo intval($homestay['gia']); ?>" 
     data-discount="<?php echo $discount + $auto_deluxe_discount; ?>">
</div>

<p><strong>Tổng tiền (ước tính):</strong> <span id="total-price">0</span> đ</p>

<button type="submit"><i class="fa-solid fa-bed"></i> Xác nhận đặt phòng</button>

    </form>
<?php else: ?>
    <p>❌ Không tìm thấy homestay.</p>
<?php endif; ?>
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
<script src="../JS/JS_TRANGCHU.js?v=6"></script>
</body>
</html>
