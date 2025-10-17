<?php
include_once('../../BE/Config/connect.php');

// Giữ nguyên logic PHP để lấy dữ liệu
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM db_homestay WHERE homestay_id = ?";
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
    <title><?php echo $homestay ? $homestay['homestay_name'] : 'Chi tiết Homestay'; ?></title>
    <link rel="stylesheet" href="../CSS/style_user.css">
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
                <a href="../PLACE/history.php" class="cart-icon" title="Lịch sử đặt phòng"><i
                        class="fa-solid fa-clock-rotate-left"></i></a>

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

    <?php if ($homestay): ?>
    <div class="place-detail-container">

        <div class="place-header-section">
            <h1><?php echo $homestay['homestay_name']; ?></h1>
            <div class="place-meta">
                <p class="address"><i class="fa-solid fa-location-dot"></i> <?php echo $homestay['address']; ?></p>
                <span class="rating-info">
                    <i class="fa-solid fa-star"></i>
                    <strong><?php echo number_format($homestay['rating'], 1); ?></strong>/5
                    (<?php echo $homestay['reviews_count']; ?> đánh giá)
                </span>
            </div>
        </div>

        <div class="gallery-grid">
            <div class="main-image">
                <img src="/BS/FE/images/<?php echo $homestay['img']; ?>" alt="Ảnh homestay chính">
            </div>
            <div class="sub-images">
                <img src="<?php echo $homestay['img1']; ?>" alt="Ảnh homestay 2">
                <img src="<?php echo $homestay['img2']; ?>" alt="Ảnh homestay 3">
                <img src="<?php echo $homestay['img3']; ?>" alt="Ảnh homestay 4">
                <img src="<?php echo $homestay['img4'] ?? $homestay['img2']; ?>" alt="Ảnh homestay 5">
            </div>
        </div>

        <div class="detail-content-wrapper">
            <div class="main-details">
                <div class="section-block description-block">
                    <h2>Giới thiệu về chỗ nghỉ</h2>
                    <p class="description-text"><?php echo nl2br($homestay['description']); ?></p>
                </div>

                <hr>

                <div class="section-block utilities-block">
                    <h2><i class="fa-solid fa-fire-extinguisher"></i> Tiện ích chính</h2>
                    <div class="utility-grid">
                        <div class="utility-item"><i class="fa-solid fa-wifi"></i> Wifi miễn phí</div>
                        <div class="utility-item"><i class="fa-solid fa-snowflake"></i> Điều hòa</div>
                        <div class="utility-item"><i class="fa-solid fa-tv"></i> TV màn hình phẳng</div>
                        <div class="utility-item"><i class="fa-solid fa-kitchen-set"></i> Bếp riêng</div>
                        <div class="utility-item"><i class="fa-solid fa-water-ladder"></i> Hồ bơi ngoài trời</div>
                        <div class="utility-item"><i class="fa-solid fa-car"></i> Bãi đỗ xe miễn phí</div>
                        <div class="utility-item"><i class="fa-solid fa-pet"></i> Cho phép mang thú cưng</div>
                        <div class="utility-item"><i class="fa-solid fa-mug-hot"></i> Đồ uống miễn phí</div>
                    </div>
                </div>

                <hr>

                <div class="section-block rules-block">
                    <h2><i class="fa-solid fa-calendar-check"></i> Quy tắc chỗ nghỉ</h2>
                    <div class="checkin-checkout">
                        <p><strong>Nhận phòng:</strong> Sau <?php echo $homestay['checkin']; ?></p>
                        <p><strong>Trả phòng:</strong> Trước <?php echo $homestay['checkout']; ?></p>
                        <p><i class="fa-solid fa-person-circle-question"></i> Vui lòng liên hệ trước nếu muốn
                            check-in/out sớm/muộn.</p>
                    </div>
                </div>

                <hr>

                <div class="section-block reviews-block">
                    <h2><i class="fa-solid fa-comment-dots"></i> Đánh giá từ khách hàng</h2>
                    <div class="rating-summary">
                        <div class="overall-rating">
                            <strong><?php echo number_format($homestay['rating'], 1); ?></strong>
                            <span>Tuyệt vời</span>
                        </div>
                        <div class="rating-count">
                            Từ **<?php echo $homestay['reviews_count']; ?>** đánh giá
                        </div>
                    </div>
                    <div class="review-list">
                        <div class="review-item">
                            <i class="fa-solid fa-user-circle"></i>
                            <strong>Nguyễn Lan</strong>: "Homestay rất đẹp, không gian yên tĩnh, chủ nhà thân thiện. Rất
                            đáng để quay lại!"
                        </div>
                        <div class="review-item">
                            <i class="fa-solid fa-user-circle"></i>
                            <strong>Trần Minh</strong>: "Phòng sạch sẽ, đầy đủ tiện nghi. Hồ bơi cực chill vào buổi tối.
                            5 sao!"
                        </div>
                        <a href="#" class="view-all-reviews">Xem tất cả (<?php echo $homestay['reviews_count']; ?>)</a>
                    </div>
                </div>
            </div>

            <div class="booking-sidebar">
                <div class="booking-box">
                    <div class="box-header">
                        <p class="price-big">
                            **<?php echo number_format($homestay['price'], 0, ',', '.'); ?>đ**
                            <span>/ đêm</span>
                        </p>
                    </div>

                    <form action="../PAY/user_booking.php" method="GET" class="booking-form">
                        <input type="hidden" name="id" value="<?php echo $homestay['homestay_id']; ?>">

                        <div class="form-group">
                            <label for="checkin_date">Nhận phòng</label>
                            <input type="date" id="checkin_date" name="checkin_date" required>
                        </div>
                        <div class="form-group">
                            <label for="checkout_date">Trả phòng</label>
                            <input type="date" id="checkout_date" name="checkout_date" required>
                        </div>
                        <div class="form-group">
                            <label for="guests">Số khách</label>
                            <select id="guests" name="guests" required>
                                <option value="1">1 Khách</option>
                                <option value="2" selected>2 Khách</option>
                                <option value="3">3 Khách</option>
                                <option value="4">4 Khách</option>
                                <option value="5">5+ Khách</option>
                            </select>
                        </div>

                        <div class="total-price-summary">
                            <p>Giá tạm tính (1 đêm)</p>
                            <strong><?php echo number_format($homestay['price'], 0, ',', '.'); ?>đ</strong>
                        </div>

                        <button type="submit" class="btn-booking-primary">
                            <i class="fa-solid fa-calendar-check"></i> Đặt phòng ngay
                        </button>
                        <p class="text-center-small">Bạn sẽ không bị trừ tiền ngay bây giờ</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <p class="error-message">❌ Không tìm thấy homestay này.</p>
    <?php endif; ?>

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

</body>

</html>