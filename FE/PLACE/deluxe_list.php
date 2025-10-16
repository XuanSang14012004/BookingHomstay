<?php
// ... GIỮ NGUYÊN CODE PHP CỦA BẠN ...

include_once('../../BE/Config/connect.php');

// Lấy bộ lọc
$discount = isset($_GET['discount']) ? floatval($_GET['discount']) : 0;
$rating = isset($_GET['rating']) ? intval($_GET['rating']) : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Lấy danh sách địa điểm duy nhất
$locationQuery = $conn->query("SELECT DISTINCT address FROM db_homestay WHERE LOWER (room_type)='deluxe'");
$locations = [];
while ($row = $locationQuery->fetch_assoc()) {
    $locations[] = $row['address'];
}

// Truy vấn homestay deluxe kèm bộ lọc
$sql = "SELECT * FROM db_homestay WHERE LOWER(room_type)='deluxe'";

// lọc theo sao
if ($rating > 0) {
    $sql .= " AND rating >= $rating";
}

// lọc theo địa điểm
if (!empty($location)) {
    $safeLocation = $conn->real_escape_string($location);
    $sql .= " AND address = '$safeLocation'";
}

// sắp xếp
if ($sort === 'price_asc') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort === 'price_desc') {
    $sql .= " ORDER BY price DESC";
} elseif ($sort === 'rating_desc') {
    $sql .= " ORDER BY rating DESC";
}

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
    <link rel="stylesheet" href="../CSS/style_user.css?v=11">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div class="page-deluxe-wrapper">
        <h1 class="deluxe-title"><i class="fa-solid fa-crown"></i> Danh sách Homestay Deluxe <span
                class="discount-label">- Giảm <?php echo $discount; ?>%</span></h1>

        <form method="GET" class="filter-bar">
            <input type="hidden" name="discount" value="<?php echo $discount; ?>">

            <select name="rating" class="filter-select">
                <option value="0">🌟 Lọc theo số sao</option>
                <option value="5" <?php if ($rating == 5) echo 'selected'; ?>>Từ 5 sao</option>
                <option value="4" <?php if ($rating == 4) echo 'selected'; ?>>Từ 4 sao</option>
                <option value="3" <?php if ($rating == 3) echo 'selected'; ?>>Từ 3 sao</option>
                <option value="2" <?php if ($rating == 2) echo 'selected'; ?>>Từ 2 sao</option>
                <option value="1" <?php if ($rating == 1) echo 'selected'; ?>>Từ 1 sao</option>
            </select>

            <select name="location" class="filter-select">
                <option value="">📍 Tất cả địa điểm</option>
                <?php foreach ($locations as $loc): ?>
                <option value="<?php echo htmlspecialchars($loc); ?>" <?php if ($location == $loc) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($loc); ?>
                </option>
                <?php endforeach; ?>
            </select>

            <select name="sort" class="filter-select">
                <option value="">🔽 Sắp xếp</option>
                <option value="price_asc" <?php if ($sort == 'price_asc') echo 'selected'; ?>>Giá tăng dần</option>
                <option value="price_desc" <?php if ($sort == 'price_desc') echo 'selected'; ?>>Giá giảm dần</option>
                <option value="rating_desc" <?php if ($sort == 'rating_desc') echo 'selected'; ?>>Sao cao nhất</option>
            </select>

            <button type="submit" class="btn-filter"><i class="fa-solid fa-magnifying-glass"></i> Lọc kết quả</button>
        </form>

        <div class="homestay-deluxe-list">
            <?php foreach ($homestays as $homestay):
                $price = $homestay['price'];
                $discountPrice = $price * (1 - $discount / 100);
                $final_discount = (floatval($discount) > 0); // Kiểm tra nếu có giảm giá
            ?>
            <div class="homestay-deluxe-card">
                <div class="card-image-wrapper">
                    <img src="<?php echo $homestay['img']; ?>"
                        alt="<?php echo htmlspecialchars($homestay['homestay_name']); ?>">
                    <?php if ($final_discount): ?>
                    <div class="discount-tag">
                        <i class="fa-solid fa-percent"></i> GIẢM <?php echo $discount; ?>%
                    </div>
                    <?php endif; ?>
                </div>

                <div class="card-info">
                    <h3 class="homestay-name"><?php echo htmlspecialchars($homestay['homestay_name']); ?></h3>

                    <p class="homestay-address"><i class="fa-solid fa-location-dot"></i>
                        <?php echo htmlspecialchars($homestay['address']); ?></p>

                    <div class="rating-display">
                        <i class="fa-solid fa-star"></i>
                        <?php
                            $rating = isset($homestay['rating']) ? (int)round($homestay['rating']) : 0;
                            if ($rating > 0) {
                                echo str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
                            } else {
                                echo '<span class="no-rating">Chưa có đánh giá</span>';
                            }
                            ?>
                    </div>

                    <div class="price-section">
                        <?php if ($final_discount): ?>
                        <p class="price-original">
                            <i class="fa-solid fa-coins"></i> <?php echo number_format($price, 0, ",", "."); ?>đ
                        </p>
                        <?php endif; ?>
                        <p class="price-discounted">
                            <i class="fa-solid fa-money-bill-wave"></i>
                            <?php echo number_format($discountPrice, 0, ",", "."); ?>đ / đêm
                        </p>
                    </div>

                    <a href="../PAY/user_booking.php?id=<?php echo $homestay['homestay_id']; ?>&discount=<?php echo $discount; ?>"
                        class="btn-booking">
                        <i class="fa-solid fa-calendar-check"></i> Đặt phòng ngay
                    </a>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if (empty($homestays)): ?>
            <p class='no-data-message'><i class="fa-solid fa-face-sad-tear"></i> Không tìm thấy homestay Deluxe phù hợp
                với tiêu chí lọc.</p>
            <?php endif; ?>
        </div>
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
</body>

</html>