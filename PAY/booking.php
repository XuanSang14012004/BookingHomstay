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

$discount = isset($_GET['discount']) ? floatval($_GET['discount']) : 0; // %
$message = "";
$bbq_text = "";

// Nếu homestay loại Deluxe, tự động giảm 30%
$auto_deluxe_discount = 0;
if ($homestay && strtolower($homestay['room_type']) === 'deluxe') {
    $auto_deluxe_discount = 30; // %
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

    // Tính số đêm (ép kiểu int)
    $days = max(1, intval((strtotime($checkout_date) - strtotime($checkin_date)) / (60*60*24)));
    $price_per_night = floatval($homestay['price'] ?? 0);
    $total_price = $days * $price_per_night;

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

    // Format lại total_price để lưu (2 chữ số thập phân)
    $total_price = round($total_price, 2);

    // Insert booking vào database với status = 'pending'
    $sql_insert = "INSERT INTO bookings (homestay_id, customer_name, customer_email, customer_phone, checkin_date, checkout_date, guests, payment_method, total_price, status)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    if (!$stmt_insert) die("Lỗi prepare insert: " . $conn->error);

    $status = 'pending';
    // types: i s s s s s i s d s  => "isssssisds"
    $stmt_insert->bind_param("isssssisds", $id, $name, $email, $phone, $checkin_date, $checkout_date, $guests, $payment_method, $total_price, $status);

    if ($stmt_insert->execute()) {
        $orderId = $stmt_insert->insert_id; // Lấy ID booking để dùng làm orderId
        // Phân nhánh thanh toán
        if ($payment_method === "cash") {
            // Thanh toán khi nhận phòng
            // Cập nhật vẫn giữ pending hoặc chuyển thành 'confirmed' tùy flow
            $sql_up = "UPDATE bookings SET status='confirmed' WHERE id=?";
            $st = $conn->prepare($sql_up);
            $st->bind_param("i", $orderId);
            $st->execute();
            $message .= "✅ Đặt phòng thành công! Thanh toán khi nhận phòng. Mã đặt: #$orderId. Tổng tiền: " . number_format($total_price,0,",",".") . "đ.<br>$bbq_text";
        } elseif ($payment_method === "vnpay") {
            // Gọi hàm tạo link VNPay
            include "payment_vnpay.php";
            createVnpayPayment($orderId, $total_price);
            exit;
        } elseif ($payment_method === "momo") {
            // Gọi hàm tạo link MoMo
            include "payment_momo.php";
            createMomoPayment($orderId, $total_price);
            exit;
        } else {
            $message .= "❌ Phương thức thanh toán không hợp lệ.";
        }
    } else {
        $message .= "❌ Lỗi khi đặt phòng: " . $conn->error;
    }
}

$conn->close();
?>
<!-- HTML phần hiển thị (giữ nguyên layout của bạn) -->
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đặt phòng - <?php echo htmlspecialchars($homestay['name'] ?? 'Homestay'); ?></title>
<link rel="stylesheet" href="../CSS/style_user.css?v=4.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
  <!-- (giữ nguyên phần header của bạn) -->
<div class="container-booking">
<?php if ($homestay): ?>
    <h1>Đặt phòng: <?php echo htmlspecialchars($homestay['name']); ?></h1>
    <div class="info-booking">
        <p><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($homestay['address']); ?></p>
        <p><?php echo htmlspecialchars($homestay['description']); ?></p>
    </div>

    <div class="gallery">
        <img src="<?php echo htmlspecialchars($homestay['img']); ?>" alt="">
        <img src="<?php echo htmlspecialchars($homestay['img1']); ?>" alt="">
        <img src="<?php echo htmlspecialchars($homestay['img2']); ?>" alt="">
        <img src="<?php echo htmlspecialchars($homestay['img3']); ?>" alt="">
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
        <input type="number" name="guests" value="1" min="1" max="<?php echo intval($homestay['guests']); ?>" required>

        <div class="booking-method">
            <label>Chọn phương thức thanh toán</label>
            <select name="payment_method" required>
                <option value="cash">Thanh toán khi nhận phòng</option>
                <option value="vnpay">VNpay</option>
                <option value="momo">MoMo</option>
            </select>
        </div>

        <button type="submit"><i class="fa-solid fa-bed"></i> Xác nhận đặt phòng</button>
    </form>
<?php else: ?>
    <p>❌ Không tìm thấy homestay.</p>
<?php endif; ?>
</div>

<script src="../JS/JS_TRANGCHU.js"></script>
<!-- (footer của bạn giữ nguyên) -->
</body>
</html>
