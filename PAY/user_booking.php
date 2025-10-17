<?php
session_start();
include_once('../../BE/Config/connect.php');

$homestay_id = isset($_GET['homestay_id']) ? intval($_GET['homestay_id'])
    : (isset($_GET['id']) ? intval($_GET['id']) : 0);

if ($homestay_id <= 0) die("❌ Lỗi: homestay_id không hợp lệ hoặc trống!");

// Lấy thông tin homestay (Giữ nguyên logic PHP)
$sql = "SELECT * FROM db_homestay WHERE homestay_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) die("Lỗi prepare: " . $conn->error);

$stmt->bind_param("i", $homestay_id);
$stmt->execute();
$result = $stmt->get_result();
$homestay = $result->fetch_assoc();
if (!$homestay) die("❌ Không tìm thấy homestay.");

$discount = 0;
$message = "";

// Giảm giá tự động cho Deluxe
$auto_deluxe_discount = 0;
if (isset($homestay['room_type']) && strtolower($homestay['room_type']) === 'deluxe') {
    $auto_deluxe_discount = 30; // % giảm giá
    $message .= "✅ Giảm $auto_deluxe_discount% cho homestay Deluxe!<br>";
}

// Tính giá 1 đêm cuối cùng (Đã tính giảm giá)
$base_price = floatval($homestay['price']);
$final_price_per_night = $base_price;
if ($auto_deluxe_discount > 0) {
    $final_price_per_night *= (1 - $auto_deluxe_discount / 100);
}


// Xử lý đặt phòng (Giữ nguyên logic PHP)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ... (Giữ nguyên toàn bộ logic xử lý POST)
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $checkin_date = $_POST['checkin_date'] ?? '';
    $checkout_date = $_POST['checkout_date'] ?? '';
    $guests = intval($_POST['guests'] ?? 1);
    $payment_method = $_POST['payment_method'] ?? '';
    $note = $_POST['note'] ?? '';
    $created_at = date("Y-m-d H:i:s");

    // Xác định customer_id
    if (isset($_SESSION['account_id'])) {
        $customer_id = $_SESSION['account_id'];
        $sql_check_cust = "SELECT * FROM db_customer WHERE customer_id = ?";
        $stmt_cust = $conn->prepare($sql_check_cust);
        $stmt_cust->bind_param("i", $customer_id);
        $stmt_cust->execute();
        $res_cust = $stmt_cust->get_result();
        if ($res_cust->num_rows == 0) {
            $stmt_insert_cust = $conn->prepare("INSERT INTO db_customer (customer_id, fullname, birthday, gender, email, phone, address) VALUES (?, ?, '2000-01-01', 'Khác', ?, ?, NULL)");
            $stmt_insert_cust->bind_param("isss", $customer_id, $name, $email, $phone);
            $stmt_insert_cust->execute();
        }
    } else {
        $stmt_acc = $conn->prepare("INSERT INTO db_account (fullname, email, phone, password, role) VALUES (?, ?, ?, '', 'user')");
        $stmt_acc->bind_param("sss", $name, $email, $phone);
        $stmt_acc->execute();
        $customer_id = $stmt_acc->insert_id;

        $stmt_insert_cust = $conn->prepare("INSERT INTO db_customer (customer_id, fullname, birthday, gender, email, phone, address) VALUES (?, ?, '2000-01-01', 'Khác', ?, ?, NULL)");
        $stmt_insert_cust->bind_param("isss", $customer_id, $name, $email, $phone);
        $stmt_insert_cust->execute();
    }

    // Tính số đêm
    $days = max(1, intval((strtotime($checkout_date) - strtotime($checkin_date)) / (60 * 60 * 24)));
    $price_per_night_post = floatval($homestay['price']);
    if ($auto_deluxe_discount > 0) {
        $price_per_night_post *= (1 - $auto_deluxe_discount / 100);
    }
    $total_price = round($days * $price_per_night_post, 2);

    // Insert booking
    $sql_insert = "INSERT INTO db_booking (homestay_id, customer_id, customer_name, customer_email, customer_phone, created_at, checkin_date, checkout_date, guests, payment_method, total_price, status, note)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    if (!$stmt_insert) die("Lỗi prepare insert: " . $conn->error);

    $status = 'Chờ xác nhận';
    $stmt_insert->bind_param("iissssssisdss", $homestay_id, $customer_id, $name, $email, $phone, $created_at, $checkin_date, $checkout_date, $guests, $payment_method, $total_price, $status, $note);

    if ($stmt_insert->execute()) {
        $orderId = $stmt_insert->insert_id;
        if ($payment_method === "cash") {
            $message .= "✅ Đặt phòng thành công! Thanh toán khi nhận phòng. Mã đặt: #$orderId. Tổng tiền: " . number_format($total_price, 0, ",", ".") . "đ.<br>";
        } elseif ($payment_method === "vnpay") {
            include "payment_vnpay.php";
            createVnpayPayment($orderId, $total_price);
            exit;
        } elseif ($payment_method === "momo") {
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
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt phòng - <?php echo htmlspecialchars($homestay['homestay_name'] ?? 'Homestay'); ?></title>
    <link rel="stylesheet" href="../CSS/style_user.css?v=5.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header class="main-header">
        <div class="header-container">
            <a href="./../TrangChu/user_main.php" class="logo">BookingHomeStay</a>
            <nav class="main-nav">
                <ul>
                    <li><a href="./../TrangChu/user_main.php">Trang chủ</a></li>
                    <li><a href="./../TrangChu/about.php">Về chúng tôi</a></li>
                    <li><a href="./../TrangChu/user_homestay.php">HomeStay</a></li>
                    <li><a href="#explore-location">Khám phá</a></li>
                    <li><a href="#feedback">Đánh giá</a></li>
                    <li><a href="./../TrangChu/contact.html">Liên hệ</a></li>
                </ul>
            </nav>

            <div class="user-actions">
                <a href="../PLACE/history.php" class="cart-icon" title="Giỏ hàng"><i
                        class="fa-solid fa-cart-shopping"></i></a>

                <div class="user-menu-wrapper">
                    <a href="javascript:void(0);" id="userIcon" class="user-icon-link">
                        <i class="fa-solid fa-user"></i> User
                    </a>
                    <div class="dropdown-menu" id="userDropdown">
                        <div class="user-info">
                            <img src="../images/user.jpg" alt="Avatar" class="avatar">
                            <span>Trường Giang</span>
                        </div>
                        <hr>
                        <a href="../TrangChu/profile.php"><i class="fa-solid fa-user-circle"></i> Profile</a>
                        <a href=""><i class="fa-solid fa-gear"></i> Cài đặt & quyền riêng tư</a>
                        <a href="#"><i class="fa-solid fa-question-circle"></i> Trợ giúp & hỗ trợ</a>
                        <a href="../../Login/logout.php" class="logout"><i class="fa-solid fa-sign-out"></i> Đăng
                            xuất</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="booking-page-container">
        <?php if ($homestay): ?>
        <div class="booking-header">
            <h1><i class="fa-solid fa-calendar-check"></i> Hoàn tất đặt phòng của bạn</h1>
            <p>Bước 2: Nhập thông tin và thanh toán</p>
        </div>

        <div class="booking-content-wrapper">
            <div class="booking-form-area">

                <div class="section-block customer-info-block">
                    <h2>1. Thông tin liên hệ</h2>
                    <p class="small-text">Vui lòng cung cấp thông tin chính xác để nhận xác nhận đặt phòng.</p>
                    <form method="POST" class="booking-form">
                        <div class="form-group">
                            <label for="name">Họ và tên:</label>
                            <input type="text" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input type="text" id="phone" name="phone" required>
                        </div>

                </div>

                <div class="section-block date-guest-block">
                    <h2>2. Ngày & Số lượng khách</h2>
                    <div class="date-guest-grid">
                        <div class="form-group">
                            <label for="checkin_date">Ngày nhận phòng:</label>
                            <input type="date" id="checkin_date" name="checkin_date" required>
                        </div>

                        <div class="form-group">
                            <label for="checkout_date">Ngày trả phòng:</label>
                            <input type="date" id="checkout_date" name="checkout_date" required>
                        </div>

                        <div class="form-group guests-group">
                            <label for="guests">Số khách tối đa:</label>
                            <input type="number" id="guests" name="guests" value="1" min="1"
                                max="<?php echo intval($homestay['guests']); ?>" required>
                            <span class="max-guest-note">Tối đa <?php echo intval($homestay['guests']); ?> người</span>
                        </div>
                    </div>
                </div>

                <div class="section-block payment-block">
                    <h2>3. Phương thức thanh toán</h2>
                    <div class="payment-options">
                        <input type="radio" id="pay-cash" name="payment_method" value="cash" required>
                        <label for="pay-cash" class="payment-card">
                            <div class="radio-indicator"></div>
                            <img src="../images/cash.jpg" alt="Cash">
                            <span>Thanh toán khi nhận phòng</span>
                        </label>

                        <input type="radio" id="pay-vnpay" name="payment_method" value="vnpay">
                        <label for="pay-vnpay" class="payment-card">
                            <div class="radio-indicator"></div>
                            <img src="../images/VNPAY.png" alt="VNPay">
                            <span>VNPay</span>
                        </label>

                        <input type="radio" id="pay-momo" name="payment_method" value="momo">
                        <label for="pay-momo" class="payment-card">
                            <div class="radio-indicator"></div>
                            <img src="../images/MOMO.png" alt="MoMo">
                            <span>MoMo</span>
                        </label>
                    </div>
                </div>

                <div class="section-block note-block">
                    <h2>4. Yêu cầu đặc biệt (Không bắt buộc)</h2>
                    <div class="form-group">
                        <label for="note">Ghi chú:</label>
                        <textarea id="note" name="note" rows="3"
                            placeholder="Ví dụ: Cần phòng ở tầng cao, check-in muộn..."></textarea>
                    </div>
                </div>

                <div class="booking-action-footer">
                    <div class="message-box"><?php echo $message; ?></div>
                    <button type="submit" class="btn-confirm-booking">
                        <i class="fa-solid fa-receipt"></i> Xác nhận và Thanh toán
                    </button>
                    <p class="small-text">Bằng việc nhấn "Xác nhận và Thanh toán", bạn đồng ý với các Điều khoản & Điều
                        kiện của chúng tôi.</p>
                </div>
            </div>
            <div class="booking-summary">

                <div class="summary-card homestay-detail-card">
                    <h3>Homestay bạn đã chọn</h3>
                    <div class="homestay-info-summary">
                        <img src="<?php echo htmlspecialchars($homestay['img']); ?>" alt="Ảnh homestay"
                            class="summary-thumb">
                        <div>
                            <h4><?php echo htmlspecialchars($homestay['homestay_name']); ?></h4>
                            <p class="summary-address"><i class="fa-solid fa-location-dot"></i>
                                <?php echo htmlspecialchars($homestay['address']); ?></p>
                            <p class="room-type-tag"><?php echo htmlspecialchars($homestay['room_type']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="summary-card price-summary-card">
                    <h3>Chi tiết giá</h3>
                    <div class="price-line">
                        <span>Giá 1 đêm (đã giảm)</span>
                        <span class="price-value"><?php echo number_format($final_price_per_night, 0, ",", "."); ?>
                            đ</span>
                    </div>

                    <?php if ($auto_deluxe_discount > 0): ?>
                    <div class="price-line discount-line">
                        <span>Giảm giá Deluxe (<?php echo $auto_deluxe_discount; ?>%)</span>
                        <span class="price-value discount-amount">-
                            <?php echo number_format($base_price * ($auto_deluxe_discount / 100), 0, ",", "."); ?>
                            đ</span>
                    </div>
                    <?php endif; ?>

                    <div class="price-line total-line">
                        <label>Tổng tiền thanh toán</label>
                        <p id="totalPrice" class="total-price-value">0 đ</p>
                    </div>

                    <p class="small-text-fee">Bao gồm thuế và phí dịch vụ. Giá cuối cùng sẽ được tính khi bạn chọn ngày.
                    </p>
                </div>
            </div>
        </div>
        </form> <?php else: ?>
        <p>❌ Không tìm thấy homestay.</p>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col">
                <h3>BookingHomeStay</h3>
                <p>Đặt homestay nhanh chóng, dễ dàng và tiện lợi. Mang đến trải nghiệm nghỉ dưỡng tuyệt vời cho bạn.</p>
            </div>
            <div class="footer-col">
                <h3>Danh mục</h3>
                <ul>
                    <li><a href="./../TrangChu/user_main.php">Trang chủ</a></li>
                    <li><a href="./../TrangChu/about.php">Về chúng tôi</a></li>
                    <li><a href="./../TrangChu/user_homestay.php">Danh sách HomeStay</a></li>
                    <li><a href="#explore-location">Khám phá địa điểm</a></li>
                </ul>
            </div>
            <div class="footer-col contact-info">
                <h3>Liên hệ</h3>
                <p><i class="fa-solid fa-location-dot"></i> Hà Nội, Việt Nam</p>
                <p><i class="fa-solid fa-phone"></i> 0123 456 789</p>
                <p><i class="fa-solid fa-envelope"></i> bookinghomestay@gmail.com</p>
            </div>
            <div class="footer-col">
                <h3>Kết nối</h3>
                <div class="social-links">
                    <a href="#" target="_blank" title="Facebook"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" target="_blank" title="Zalo"><i class="fa-brands fa-viber"></i></a>
                    <a href="#" target="_blank" title="Messenger"><i class="fa-brands fa-facebook-messenger"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Bản quyền &copy; 2025 BookingHomeStay. All rights reserved.</p>
        </div>
    </footer>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const checkinInput = document.getElementById('checkin_date');
        const checkoutInput = document.getElementById('checkout_date');
        const guestsInput = document.getElementById('guests');
        const totalPriceEl = document.getElementById('totalPrice');

        // Giá 1 đêm (đã tính giảm giá nếu có) - Giữ nguyên logic PHP để truyền giá trị
        const pricePerNight = <?php
                                    echo $final_price_per_night;
                                    ?>;

        function calculateTotal() {
            const checkinDate = new Date(checkinInput.value);
            const checkoutDate = new Date(checkoutInput.value);
            const guests = parseInt(guestsInput.value) || 1;

            if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                const oneDay = 1000 * 60 * 60 * 24;
                const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
                const days = Math.ceil(timeDiff / oneDay);

                // Đảm bảo số đêm tối thiểu là 1 nếu ngày hợp lệ
                if (days > 0) {
                    const total = days * pricePerNight;
                    totalPriceEl.textContent = total.toLocaleString('vi-VN') + ' đ';
                    // Cập nhật giá trị hiển thị ở phần tóm tắt giá
                    document.querySelector('.total-line .price-value').textContent = total.toLocaleString(
                        'vi-VN') + ' đ';
                } else {
                    totalPriceEl.textContent = '0 đ';
                }

            } else {
                totalPriceEl.textContent = '0 đ';
            }
        }

        checkinInput.addEventListener('change', calculateTotal);
        checkoutInput.addEventListener('change', calculateTotal);
        guestsInput.addEventListener('input', calculateTotal);

        // Tính toán tổng tiền ban đầu khi tải trang
        calculateTotal();
    });
    </script>
</body>

</html>