<?php
include_once('../../BE/Config/connect.php');

// Giữ nguyên Logic PHP: Lấy tất cả homestay
$sql = "SELECT * FROM db_homestay ORDER BY homestay_id DESC";
$result = $conn->query($sql);
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style_user.css?v=9">
    <title>Danh sách Homestay</title>
</head>

<body>
    <header class="main-header">
        <div class="header-container">
            <a href="./../TrangChu/user_main.php" class="logo">BookingHomeStay</a>
            <nav class="main-nav">
                <ul>
                    <li><a href="./../TrangChu/user_main.php">Trang chủ</a></li>
                    <li><a href="./../TrangChu/about.php">Về chúng tôi</a></li>
                    <li><a href="./../TrangChu/user_homestay.php" class="active">HomeStay</a></li>
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

    <div class="page-content-wrapper">
        <h1 class="page-title-main"><i class="fa-solid fa-house-user"></i> Danh sách Homestay</h1>

        <div class="homestay-container">

            <div class="filter-sidebar">
                <div class="filter-box">
                    <h3><i class="fa-solid fa-filter"></i> Lọc kết quả</h3>

                    <div class="filter-group">
                        <strong><i class="fa-solid fa-star"></i> Số sao</strong>
                        <label class="filter-item"><input type="checkbox" class="filter" value="5sao"> 5 sao</label>
                        <label class="filter-item"><input type="checkbox" class="filter" value="4sao"> 4 sao</label>
                        <label class="filter-item"><input type="checkbox" class="filter" value="3sao"> 3 sao</label>
                        <label class="filter-item"><input type="checkbox" class="filter" value="2sao"> 2 sao</label>
                        <label class="filter-item"><input type="checkbox" class="filter" value="1sao"> 1 sao</label>
                    </div>

                    <div class="filter-group">
                        <strong><i class="fa-solid fa-hotel"></i> Tình trạng</strong>
                        <label class="filter-item"><input type="checkbox" class="filter" value="còn phòng"> Còn
                            phòng</label>
                        <label class="filter-item"><input type="checkbox" class="filter" value="hết phòng"> Hết
                            phòng</label>
                    </div>

                    <div class="filter-group">
                        <strong><i class="fa-solid fa-bed"></i> Loại phòng</strong>
                        <label class="filter-item"><input type="checkbox" class="filter" value="Deluxe"> Deluxe</label>
                        <label class="filter-item"><input type="checkbox" class="filter" value="Family"> Family</label>
                        <label class="filter-item"><input type="checkbox" class="filter" value="Standard">
                            Standard</label>
                    </div>
                </div>
            </div>

            <div class="list-homestay-area">
                <div class="list-homestay-grid" id="list-homestay">
                    <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()):
                            // Tạo data-* cho filter
                            $star = round($row['rating']);
                            $star_text = str_repeat("★", $star) . str_repeat("☆", 5 - $star);
                            $status = strtolower($row['status']) === 'còn phòng' ? 'còn phòng' : 'hết phòng';
                            $price_formatted = number_format($row['price'], 0, ",", ".");
                        ?>
                    <div class="homestay-card" data-star="<?php echo $star . 'sao'; ?>"
                        data-status="<?php echo $status; ?>" data-type="<?php echo $row['room_type']; ?>">

                        <div class="homestay-card-image">
                            <img src="<?php echo $row['img']; ?>"
                                alt="<?php echo htmlspecialchars($row['homestay_name']); ?>">
                            <span class="room-type-tag"><i class="fa-solid fa-tag"></i>
                                <?php echo $row['room_type']; ?></span>
                        </div>

                        <div class="homestay-card-info">
                            <h4 class="homestay-name"><?php echo htmlspecialchars($row['homestay_name']); ?></h4>
                            <p class="homestay-address"><i class="fa-solid fa-location-dot"></i>
                                <?php echo htmlspecialchars($row['address']); ?></p>

                            <div class="rating-info">
                                <span class="star-display"><?php echo $star_text; ?></span>
                                <span class="rating-value"><?php echo number_format($row['rating'], 1); ?>/5.0</span>
                            </div>

                            <div class="price-status">
                                <span class="homestay-price">
                                    <?php echo $price_formatted; ?>đ / đêm
                                </span>
                                <span class="status-tag <?php echo $status === 'còn phòng' ? 'available' : 'full'; ?>">
                                    <i
                                        class="fa-solid <?php echo $status === 'còn phòng' ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                                    <?php echo ucfirst($status); ?>
                                </span>
                            </div>

                            <a href="../PAY/user_booking.php?id=<?php echo $row['homestay_id']; ?>"
                                class="btn-book-now <?php echo $status === 'hết phòng' ? 'disabled' : ''; ?>"
                                <?php echo $status === 'hết phòng' ? 'disabled' : ''; ?>>
                                <i class="fa-solid fa-suitcase-rolling"></i> Đặt phòng ngay
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <p class="no-homestay-message">Không có homestay nào được tìm thấy trong hệ thống.</p>
                    <?php endif; ?>
                </div>
                <p id="no-result" class="no-result-message" style="display:none;">
                    <i class="fa-solid fa-box-open"></i> Không tìm thấy homestay phù hợp với tiêu chí lọc.
                </p>
            </div>
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

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const filters = document.querySelectorAll(".filter");
        const cards = document.querySelectorAll(".homestay-card"); // Đã đổi tên class
        const listHomestayGrid = document.getElementById("list-homestay"); // Giữ nguyên ID

        filters.forEach(f => {
            f.addEventListener("change", filterCards);
        });

        function filterCards() {
            // Gom filter theo nhóm
            let selectedStars = [];
            let selectedStatus = [];
            let selectedTypes = [];

            filters.forEach(f => {
                if (f.checked) {
                    if (f.value.includes("sao")) selectedStars.push(f.value);
                    else if (f.value === "còn phòng" || f.value === "hết phòng") selectedStatus.push(f
                        .value);
                    else selectedTypes.push(f.value);
                }
            });

            let visibleCount = 0;

            cards.forEach(card => {
                let star = card.dataset.star;
                let status = card.dataset.status;
                let type = card.dataset.type;

                // Kiểm tra từng nhóm filter
                // Logic OR: Nếu không chọn gì trong nhóm đó, coi như match. Nếu có chọn, phải khớp với 1 trong các lựa chọn.
                let starMatch = selectedStars.length === 0 || selectedStars.includes(star);
                let statusMatch = selectedStatus.length === 0 || selectedStatus.includes(status);
                let typeMatch = selectedTypes.length === 0 || selectedTypes.includes(type);

                // Tổng hợp (Logic AND: Phải khớp tất cả nhóm filter)
                if (starMatch && statusMatch && typeMatch) {
                    card.style.display = "flex"; // Đổi từ block sang flex (tối ưu cho CSS mới)
                    visibleCount++;
                } else {
                    card.style.display = "none";
                }
            });

            //Nếu không có kết quả, hiển thị thông báo
            let noResultMsg = document.getElementById("no-result");
            // Đảm bảo thông báo luôn được hiển thị/ẩn đúng cách
            noResultMsg.style.display = visibleCount === 0 ? "block" : "none";
        }
    });
    </script>
</body>

</html>