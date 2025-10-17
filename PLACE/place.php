<?php
include_once('../../BE/Config/connect.php');

// Lấy dữ liệu từ GET
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';
$price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';
$sort_stars = isset($_GET['sort_stars']) ? $_GET['sort_stars'] : '';

// Câu SQL cơ bản
$sql = "SELECT * FROM db_homestay WHERE address LIKE ?";
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
    // Determine the types string dynamically based on whether price_range is used (not necessary since price is checked directly in SQL)
    // We only need to account for $search (s) and $room_type (s)
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
    <title>Homestay tại <?php echo htmlspecialchars($location); ?></title>
    <link rel="stylesheet" href="../CSS/style_user.css?v=5.2">
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

    <div class="search-results-wrapper">
        <h1 class="page-search-title"><i class="fa-solid fa-magnifying-glass-location"></i> Kết quả tìm kiếm tại:
            <span><?php echo htmlspecialchars($location); ?></span>
        </h1>

        <form method="GET" action="" class="filter-bar-full">
            <input type="hidden" name="location" value="<?php echo htmlspecialchars($location); ?>">

            <div class="filter-group">
                <label for="room_type">Loại phòng</label>
                <select name="room_type" id="room_type" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    <option value="Deluxe" <?php if ($room_type == "Deluxe") echo "selected"; ?>>Deluxe</option>
                    <option value="Family" <?php if ($room_type == "Family") echo "selected"; ?>>Family</option>
                    <option value="Standard" <?php if ($room_type == "Standard") echo "selected"; ?>>Standard</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="sort_stars">Sắp xếp</label>
                <select name="sort_stars" id="sort_stars" onchange="this.form.submit()">
                    <option value="">Mặc định</option>
                    <option value="desc" <?php if ($sort_stars == "desc") echo "selected"; ?>>Sao cao → thấp</option>
                    <option value="asc" <?php if ($sort_stars == "asc") echo "selected"; ?>>Sao thấp → cao</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="price_range">Mức giá</label>
                <select name="price_range" id="price_range" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    <option value="under_1m" <?php if ($price_range == "under_1m") echo "selected"; ?>>
                        < 1.000.000 VND</option>
                    <option value="1m_1_5m" <?php if ($price_range == "1m_1_5m") echo "selected"; ?>>1.000.000 -
                        1.500.000
                    </option>
                    <option value="over_1_5m" <?php if ($price_range == "over_1_5m") echo "selected"; ?>>>= 1.500.000
                        VND
                    </option>
                </select>
            </div>
        </form>

        <div class="homestay-results-list">
            <?php if (!empty($homestays)): ?>
            <?php foreach ($homestays as $h):
                    $status_class = strtolower($h['status']) == 'còn phòng' ? 'available' : 'full';
                    $rating_stars = str_repeat("⭐", (int)round($h['rating'] ?? 0));
                    if (empty($rating_stars)) $rating_stars = 'Chưa có đánh giá';
                ?>
            <div class="homestay-card-item">
                <div class="card-img-container">
                    <img src="<?php echo $h['img'] ?? '../ANH/default.jpg'; ?>"
                        alt="<?php echo htmlspecialchars($h['homestay_name']); ?>">
                    <span class="room-type-tag"><?php echo $h['room_type']; ?></span>
                </div>

                <div class="card-content">
                    <h3 class="card-name"><?php echo htmlspecialchars($h['homestay_name']); ?></h3>
                    <p class="card-address"><i class="fa-solid fa-location-dot"></i>
                        <?php echo htmlspecialchars($h['address']); ?></p>

                    <div class="card-status-price">
                        <span class="card-status <?php echo $status_class; ?>">
                            <i
                                class="fa-solid <?php echo $status_class == 'available' ? 'fa-check' : 'fa-times'; ?>"></i>
                            <?php echo ucfirst($h['status']); ?>
                        </span>
                        <span class="card-price">
                            <?php echo number_format($h['price'], 0, ',', '.'); ?>đ / đêm
                        </span>
                    </div>

                    <div class="card-rating">
                        <i class="fa-solid fa-star"></i> Xếp hạng: <span><?php echo $rating_stars; ?></span>
                    </div>

                    <div class="card-btn-group">
                        <a href="detail_place.php?id=<?php echo $h['homestay_id']; ?>"
                            class="btn-action btn-detail-sm">Xem chi
                            tiết</a>
                        <a href="../PAY/user_booking.php?id=<?php echo $h['homestay_id']; ?>"
                            class="btn-action btn-book-sm <?php echo $status_class == 'full' ? 'disabled' : ''; ?>"
                            <?php echo $status_class == 'full' ? 'onclick="return false;"' : ''; ?>>
                            Đặt phòng
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="no-results-message">❌ Không tìm thấy homestay nào tại <?php echo htmlspecialchars($location); ?>
                phù hợp với tiêu chí lọc.</p>
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