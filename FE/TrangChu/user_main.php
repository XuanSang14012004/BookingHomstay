<?php
session_set_cookie_params(['path' => '/BS/']);
session_start();
include_once('../../BE/Config/connect.php');

// Lấy danh sách homestay còn phòng
$sql = "SELECT * FROM db_homestay ORDER BY homestay_id";

$result = $conn->query($sql);
if (!$result) {
    die("❌ Lỗi truy vấn db_homestay: " . $conn->error);
}
$homestays = [];
while ($row = $result->fetch_assoc()) {
    $homestays[] = $row;
}
// Truy vấn tất cả đánh giá có thông tin khách và homestay
$sql_review = "
    SELECT 
        r.review_id,
        c.fullname AS customer_name,
        c.avatar AS customer_avatar,
        h.homestay_name,
        r.rating,
        r.review AS content_review,
        r.content_feedback,
        r.created_at
    FROM db_review r
    INNER JOIN db_customer c ON r.customer_id = c.customer_id
    INNER JOIN db_homestay h ON r.homestay_id = h.homestay_id
    ORDER BY r.created_at DESC
    LIMIT 5 
";

$result_review = $conn->query($sql_review);

if (!$result_review) {
    die('SQL Error: ' . $conn->error);
}
// ❗ Đóng kết nối sau khi đã lấy hết dữ liệu
$conn->close();


?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking HomeStay</title>
    <link rel="stylesheet" href="../CSS/style_user.css?v=12">
    <link rel="icon" href="../images/logo.jpg">
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

            <!-- <div class="user-actions">
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
                        <a href="../../Login/login.php" class="logout"><i class="fa-solid fa-sign-out"></i> Đăng
                            nhập</a>
                    </div>
                </div>
            </div>
        </div> -->


            <div class="user-actions">
                <a href="../PLACE/history.php" class="cart-icon" title="Giỏ hàng"><i
                        class="fa-solid fa-cart-shopping"></i></a>

                <div class="user-menu-wrapper">
                    <?php if (isset($_SESSION['account_id'])):
                        $user_fullname = htmlspecialchars($_SESSION['fullname'] ?? 'User');
                        $user_avatar = htmlspecialchars($_SESSION['avatar'] ?? '../images/user.jpg');
                        $user_email = htmlspecialchars($_SESSION['email'] ?? 'N/A');
                    ?>
                    <a href="javascript:void(0);" id="userIcon" class="user-icon-link">
                        <i class="fa-solid fa-user"></i> <?php echo $user_fullname; ?>
                    </a>
                    <div class="dropdown-menu" id="userDropdown">
                        <div class="user-info">
                            <img src="<?php echo $user_avatar; ?>" alt="Avatar" class="avatar">
                            <span><?php echo $user_fullname; ?></span>
                            <p style="font-size: 0.8em; color: #888; margin: 0;"><?php echo $user_email; ?></p>
                        </div>
                        <hr>
                        <a href="../TrangChu/profile.php"><i class="fa-solid fa-user-circle"></i> Profile</a>
                        <a href="#settings"><i class="fa-solid fa-gear"></i> Cài đặt & quyền riêng tư</a>
                        <a href="#"><i class="fa-solid fa-question-circle"></i> Trợ giúp & hỗ trợ</a>
                        <a href="../../Login/logout.php" class="logout"><i class="fa-solid fa-sign-out"></i> Đăng
                            xuất</a>
                    </div>
                    <?php else: ?>
                    <a href="../../Login/login.php" id="userIcon" class="user-icon-link">
                        <i class="fa-solid fa-user"></i> Đăng nhập
                    </a>
                    <div class="dropdown-menu" id="userDropdown">
                        <div class="user-info">
                            <img src="../images/user.jpg" alt="Avatar" class="avatar">
                            <span>Khách</span>
                        </div>
                        <hr>
                        <a href="../../Login/login.php" class="logout"><i class="fa-solid fa-sign-in"></i> Đăng nhập
                            / Đăng kí</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </header>

    <main>
        <section class="hero-section">
            <div class="slideshow-container">
                <img class="hero-img active" alt="HomeStay Sóc Sơn 1" src="../images/SS1.jpg">
                <img class="hero-img" alt="HomeStay Sóc Sơn 2" src="../images/6.webp">
                <img class="hero-img" alt="HomeStay Sóc Sơn 3" src="../images/7.webp">
            </div>

            <div class="search-overlay">
                <h1 class="hero-title">Tìm kiếm Homestay hoàn hảo cho bạn</h1>
                <form id="filterForm" action="./../TrangChu/user_homestay.php" method="GET" class="search-form">
                    <div class="form-group">
                        <label for="location"><i class="fa-solid fa-location-dot"></i> Địa điểm</label>
                        <select id="location" name="location">
                            <option value="">-- Chọn --</option>
                            <option value="Ba Vì">Ba Vì</option>
                            <option value="Sóc Sơn">Sóc Sơn</option>
                            <option value="Tam Đảo">Tam Đảo</option>
                            <option value="Mộc Châu">Mộc Châu</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="checkin"><i class="fa-solid fa-calendar-alt"></i> Ngày đi</label>
                        <input type="date" id="checkin" name="checkin" required>
                    </div>

                    <div class="form-group">
                        <label for="checkout"><i class="fa-solid fa-calendar-alt"></i> Ngày về</label>
                        <input type="date" id="checkout" name="checkout" required>
                    </div>

                    <div class="form-group">
                        <label for="type"><i class="fa-solid fa-bed"></i> Loại phòng</label>
                        <select id="type" name="type">
                            <option value="">-- Chọn --</option>
                            <option value="Deluxe"> Deluxe</option>
                            <option value="Family"> Family</option>
                            <option value="Standard"> Standard</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i> Tìm
                        kiếm</button>
                </form>
            </div>
        </section>

        <section class="social-sidebar">
            <a href="#" target="_blank" title="Zalo"><img src="../images/zalo.jpg" alt="Zalo"></a>
            <a href="#" target="_blank" title="Messenger"><img src="../images/MES.jpg" alt="Messenger"></a>
            <a href="#" target="_blank" title="Facebook"><img src="../images/FB.jpg" alt="Facebook"></a>
            <a href="#" target="_blank" title="Instagram"><img src="../images/IG.jpg" alt="Instagram"></a>
        </section>

        <section class="homestay-section main-content-section">
            <h2 class="section-title">✨ Homestay Nổi Bật</h2>
            <p class="section-subtitle">Các homestay được khách hàng yêu thích và đánh giá cao nhất.</p>

            <div class="carousel-wrapper">
                <button class="arrow left" onclick="scrollHomestay(-1)">&#10094;</button>

                <div class="homestay-container">
                    <div class="homestay-list">
                        <?php foreach ($homestays as $row): ?>

                        <div class="homestay-card" data-location="<?php echo htmlspecialchars($row['address']); ?>"
                            data-type="<?php echo htmlspecialchars($row['room_type']); ?>">

                            <img src="<?php echo $row['img']; ?>" alt="<?php echo $row['homestay_name']; ?>"
                                class="card-img">
                            <div class="info">
                                <h3><?php echo $row['homestay_name']; ?></h3>
                                <p class="location-tag"><i class="fa-solid fa-map-marker-alt"></i> <b
                                        style="color:var(--primary-color)"><?php echo $row['address']; ?></b></p>
                                <div class="details-row">
                                    <p><i class="fa-solid fa-users"></i> Số khách: <?php echo $row['guests']; ?></p>
                                    <p><i class="fa-solid fa-house-chimney"></i> Loại: <?php echo $row['room_type']; ?>
                                    </p>
                                </div>
                                <p class="status">Tình trạng:
                                    <b class="status-text"
                                        style="color:<?php echo ($row['status'] == 'Còn phòng') ? 'var(--success-color)' : 'var(--danger-color)'; ?>">
                                        <?php echo $row['status']; ?>
                                    </b>
                                </p>
                                <div class="rating-price">
                                    <div class="stars">
                                        <?php echo str_repeat("⭐", $row['rating']); ?>
                                    </div>
                                    <p class="price"><?php echo number_format($row['price'], 0, ',', '.'); ?>đ / đêm</p>
                                </div>
                                <a href="../PAY/user_booking.php?id=<?php echo $row['homestay_id']; ?>"
                                    class="btn btn-book">Đặt phòng ngay</a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button class="arrow right" onclick="scrollHomestay(1)">&#10095;</button>
            </div>

            <a href="user_homestay.php" class="btn btn-secondary show-more">Xem đầy đủ các HomeStay <i
                    class="fa-solid fa-arrow-right"></i></a>
        </section>

        <hr>

        <section class="deals main-content-section">
            <h2 class="section-title">🔥 Ưu Đãi & Khuyến Mãi</h2>
            <p class="section-subtitle">Đừng bỏ lỡ các ưu đãi hấp dẫn chỉ có trong hôm nay.</p>

            <div class="deal-banner">
                <img src="../images/8.png" alt="Summer Sale" class="deal-img">
                <div class="deal-content">
                    <h3>Giảm Sốc Mùa Hè - Summer Sale!</h3>
                    <p>Giảm đến 30% cho tất cả Homestay loại Deluxe khi đặt trước 7 ngày.</p>
                    <button onclick="window.location.href='../PLACE/deluxe_list.php?discount=30'"
                        class="btn btn-primary">Khám phá ngay</button>
                </div>
            </div>
        </section>

        <hr>

        <section id="explore-location" class="explore-location main-content-section">
            <h2 class="section-title">📍 Khám Phá Homestay Theo Địa Điểm</h2>
            <p class="section-subtitle">Những điểm đến tuyệt vời đang chờ đón bạn.</p>
            <div class="location-grid">
                <a href="../PLACE/place.php?location=Sóc Sơn" class="location-item">
                    <img src="../images/SS5.jpg" alt="Sóc Sơn" class="location-img">
                    <div class="overlay">
                        <h4>Sóc Sơn</h4>
                        <span class="location-count">12+ Homestay</span>
                    </div>
                </a>
                <a href="../PLACE/place.php?location=Tam Đảo" class="location-item">
                    <img src="../images/TD1.jpg" alt="Tam Đảo" class="location-img">
                    <div class="overlay">
                        <h4>Tam Đảo</h4>
                        <span class="location-count">8+ Homestay</span>
                    </div>
                </a>
                <a href="../PLACE/place.php?location=Mộc Châu" class="location-item">
                    <img src="../images/mcc.webp" alt="Mộc Châu" class="location-img">
                    <div class="overlay">
                        <h4>Mộc Châu</h4>
                        <span class="location-count">15+ Homestay</span>
                    </div>
                </a>
                <a href="../PLACE/place.php?location=Ba Vì" class="location-item">
                    <img src="../images/BV2.jpg" alt="Ba Vì" class="location-img">
                    <div class="overlay">
                        <h4>Ba Vì</h4>
                        <span class="location-count">7+ Homestay</span>
                    </div>
                </a>
            </div>
        </section>

        <hr>

        <section class="blog main-content-section">
            <h2 class="section-title">📰 Tin Tức & Blog Du Lịch</h2>
            <p class="section-subtitle">Những mẹo hay, kinh nghiệm du lịch và điểm đến mới.</p>
            <div class="blog-list">

                <div class="blog-card">
                    <img src="../images/TT1.webp" alt="Kinh nghiệm du lịch Ba Vì" class="blog-img">
                    <div class="blog-info">
                        <h3>Kinh nghiệm du lịch Ba Vì 3 ngày 2 đêm</h3>
                        <p>Chia sẻ lịch trình du lịch Ba Vì tiết kiệm, homestay đẹp, các điểm check-in nổi tiếng.</p>
                        <a href="blog1.html" class="btn btn-read">Đọc thêm <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="blog-card">
                    <img src="../images/TT2.jpg" alt="Mẹo đặt homestay giá rẻ" class="blog-img">
                    <div class="blog-info">
                        <h3>Mẹo đặt homestay giá rẻ mùa cao điểm</h3>
                        <p>Bí quyết săn homestay với giá tốt, tránh tình trạng hết phòng vào mùa lễ hội.</p>
                        <a href="blog2.html" class="btn btn-read">Đọc thêm <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="blog-card">
                    <img src="../images/TT3.webp" alt="Khám phá Sapa" class="blog-img">
                    <div class="blog-info">
                        <h3>Khám phá Sapa: Đi đâu, ăn gì, ở đâu?</h3>
                        <p>Gợi ý các homestay view núi rừng đẹp, trải nghiệm ẩm thực và văn hóa địa phương.</p>
                        <a href="blog3.html" class="btn btn-read">Đọc thêm <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <section id="feedback" class="feedback main-content-section">
            <h2 class="section-title">💬 Phản Hồi Từ Khách Hàng</h2>
            <p class="section-subtitle">Khách hàng nói gì về chúng tôi và các Homestay.</p>

            <div class="feedback-list">
                <?php
                if ($result_review && $result_review->num_rows > 0) {
                    while ($row = $result_review->fetch_assoc()) {
                ?>
                <div class="feedback-item">
                    <div class="feedback-header">
                        <img src="<?php echo htmlspecialchars($row['customer_avatar'] ?: '../images/user.jpg'); ?>"
                            alt="Avatar" class="feedback-avatar">
                        <div class="customer-info">
                            <h3><?php echo htmlspecialchars($row['customer_name']); ?></h3>
                            <p>Đã ở tại <strong><?php echo htmlspecialchars($row['homestay_name']); ?></strong></p>
                            <span class="feedback-time">
                                <i class="fa-solid fa-clock"></i>
                                <?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?>
                            </span>
                        </div>
                    </div>

                    <div class="feedback-rating">
                        <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    echo "<span class='star" . ($i <= $row['rating'] ? " filled" : "") . "'>&#9733;</span>";
                                }
                                ?>
                    </div>

                    <div class="feedback-content">
                        <p class="customer-comment">
                            <i class="fa-solid fa-quote-left"></i>
                            <?php echo htmlspecialchars($row['content_review']); ?>
                            <i class="fa-solid fa-quote-right"></i>
                        </p>

                        <?php if (!empty($row['content_feedback'])): ?>
                        <div class="admin-reply">
                            <p><strong><i class="fa-solid fa-reply"></i> Phản hồi từ Admin:</strong></p>
                            <p><?php echo htmlspecialchars($row['content_feedback']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p class='no-feedback'>Chưa có phản hồi nào.</p>";
                }
                ?>
            </div>
        </section>



    </main>

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

        // =============================
        // PHẦN ẢNH SLIDESHOW
        // =============================
        let slideIndex = 0;

        function showSlides() {
            const slides = document.querySelectorAll(".hero-img");
            slides.forEach(s => s.classList.remove("active"));

            slideIndex++;
            if (slideIndex > slides.length) slideIndex = 1;

            if (slides.length > 0) {
                slides[slideIndex - 1].classList.add("active");
            }

            setTimeout(showSlides, 4000); // 4 giây đổi ảnh
        }
        showSlides();


        // =============================
        // PHẦN ẨN/HIỆN GIAO DIỆN NGƯỜI DÙNG
        // =============================
        const userIcon = document.getElementById('userIcon');
        const userDropdown = document.getElementById('userDropdown');

        if (userIcon && userDropdown) {
            userIcon.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!userDropdown.contains(e.target) && e.target !== userIcon) {
                    userDropdown.classList.remove('show');
                }
            });
        }


        // =============================
        // CUỘN DANH SÁCH HOMESTAY
        // =============================
        let currentScroll = 0;

        window.scrollHomestay = function(direction) {
            const list = document.querySelector('.homestay-list');
            const card = document.querySelector('.homestay-card');
            const container = document.querySelector('.homestay-container');

            if (!list || !card || !container) return;

            const cardWidth = card.offsetWidth + 20; // 20px margin
            const containerWidth = container.offsetWidth;
            const totalCards = list.children.length;
            const visibleCards = Math.floor(containerWidth / cardWidth);
            const maxScroll = (totalCards - visibleCards) * cardWidth;

            if (maxScroll <= 0) return;

            currentScroll += direction * cardWidth * visibleCards;
            if (currentScroll > maxScroll) currentScroll = maxScroll;
            if (currentScroll < 0) currentScroll = 0;

            list.style.transform = `translateX(-${currentScroll}px)`;
        };


        // =============================
        // LỌC HOMESTAY (CẢI TIẾN)
        // =============================
        const filterForm = document.getElementById("filterForm");
        const homestayContainer = document.querySelector(".homestay-container") || document.querySelector(
            ".homestay-list");

        if (filterForm) {
            filterForm.addEventListener("submit", function(e) {
                e.preventDefault();

                const locationFilter = document.getElementById("location").value.trim().toLowerCase();
                const typeFilter = document.getElementById("type").value.trim().toLowerCase();
                const checkinFilter = document.getElementById("checkin").value;
                const checkoutFilter = document.getElementById("checkout").value;

                const checkinDate = checkinFilter ? new Date(checkinFilter) : null;
                const checkoutDate = checkoutFilter ? new Date(checkoutFilter) : null;

                if (checkinDate && checkoutDate && checkinDate >= checkoutDate) {
                    alert("Ngày đi phải trước Ngày về!");
                    return;
                }

                const cards = document.querySelectorAll(".homestay-card");
                let foundMatch = false;

                cards.forEach(card => {
                    const cardLocation = (card.getAttribute('data-location') || '')
                        .toLowerCase().trim();
                    const cardType = (card.getAttribute('data-type') || '').toLowerCase()
                        .trim();

                    const matchLocation = !locationFilter || cardLocation.includes(
                        locationFilter);
                    const matchType = !typeFilter || cardType === typeFilter;

                    if (matchLocation && matchType) {
                        card.classList.remove("fade-out");
                        card.classList.add("fade-in");
                        card.style.display = "flex";
                        foundMatch = true;
                    } else {
                        card.classList.remove("fade-in");
                        card.classList.add("fade-out");
                        setTimeout(() => {
                            card.style.display = "none";
                        }, 300);
                    }
                });

                updateNoResultMessage(foundMatch, homestayContainer);
            });
        }

        function updateNoResultMessage(found, container) {
            if (!container) return;
            let noResultMsg = document.getElementById('no-result-message');
            if (!noResultMsg) {
                noResultMsg = document.createElement('p');
                noResultMsg.id = 'no-result-message';
                noResultMsg.textContent = '❌ Không tìm thấy homestay phù hợp với tiêu chí của bạn.';
                noResultMsg.style.textAlign = 'center';
                noResultMsg.style.color = '#e74c3c';
                noResultMsg.style.marginTop = '20px';
                container.appendChild(noResultMsg);
            }
            noResultMsg.style.display = found ? 'none' : 'block';
        }

    });
    </script>
    </script>
</body>

</html>