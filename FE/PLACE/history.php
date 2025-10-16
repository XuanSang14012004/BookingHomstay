<?php
session_start(); // ✅ BẮT BUỘC để session hoạt động
include_once('../../BE/Config/connect.php');

// Lấy tên người dùng đã đăng nhập để hiển thị (từ logic login bạn cung cấp)
$display_name = isset($_SESSION['fullname']) ? htmlspecialchars($_SESSION['fullname']) : 'User';

// Giữ nguyên Logic PHP: Lấy dữ liệu từ DB
// Thêm điều kiện WHERE customer_id = $_SESSION['account_id'] để chỉ hiển thị lịch sử của người đó
if (isset($_SESSION['account_id'])) {
    $customer_id = intval($_SESSION['account_id']);
    $sql = "SELECT b.*, h.homestay_name AS homestay_name, h.img AS homestay_img 
            FROM db_booking b 
            JOIN db_homestay h ON b.homestay_id = h.homestay_id 
            WHERE b.customer_id = $customer_id 
            ORDER BY b.created_at DESC";
    $result = $conn->query($sql);
} else {
    // Nếu chưa đăng nhập, không có kết quả lịch sử
    $result = null;
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Lịch sử Đặt phòng - BookingHomeStay</title>
    <link rel="stylesheet" href="../CSS/style_user.css?v=12">
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
                <a href="../PLACE/history.php" class="cart-icon active" title="Lịch sử đặt phòng"><i
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

    <div class="history-page-container">
        <h2 class="page-title"><i class="fa-solid fa-receipt"></i> Lịch sử Đặt phòng của bạn</h2>

        <div class="history-content-wrapper">
            <div class="history-list-area">
                <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="history-card <?php echo strtolower(str_replace(' ', '-', $row['status'])); ?>"
                    data-booking-id="<?php echo $row['booking_id']; ?>">
                    <div class="history-card-thumb">
                        <img src="<?php echo htmlspecialchars($row['homestay_img']); ?>"
                            alt="<?php echo htmlspecialchars($row['homestay_name']); ?>">
                    </div>

                    <div class="history-card-details">
                        <h3 class="homestay-name"><?php echo htmlspecialchars($row['homestay_name']); ?></h3>
                        <p class="booking-date-range">
                            <i class="fa-solid fa-calendar-alt"></i>
                            Từ <b><?php echo date('d/m/Y', strtotime($row['checkin_date'])); ?></b>
                            đến <b><?php echo date('d/m/Y', strtotime($row['checkout_date'])); ?></b>
                        </p>
                        <p class="guest-count"><i class="fa-solid fa-users"></i> <?php echo $row['guests']; ?> khách</p>
                        <p class="total-price">
                            <i class="fa-solid fa-money-bill-wave"></i>
                            Tổng tiền: <b><?php echo number_format($row['total_price'], 0, ",", "."); ?>đ</b>
                        </p>
                    </div>

                    <div class="history-card-actions">
                        <?php
                                $status_class = '';
                                $status_icon = '';
                                if ($row['status'] === 'Đã xác nhận' || $row['status'] === 'Đã thanh toán') {
                                    $status_class = 'confirmed';
                                    $status_icon = 'fa-check-circle';
                                } elseif ($row['status'] === 'Chờ xác nhận' || $row['status'] === 'Chờ thanh toán') {
                                    $status_class = 'pending';
                                    $status_icon = 'fa-clock';
                                } elseif ($row['status'] === 'Đã hủy') {
                                    $status_class = 'cancelled';
                                    $status_icon = 'fa-times-circle';
                                }
                                ?>
                        <span class="status-tag <?php echo $status_class; ?>">
                            <i class="fa-solid <?php echo $status_icon; ?>"></i>
                            <?php echo htmlspecialchars($row['status']); ?>
                        </span>

                        <?php if ($row['status'] === 'Đã xác nhận' || $row['status'] === 'Đã thanh toán'): ?>
                        <button class="action-btn review-btn primary-btn"><i class="fa-solid fa-star"></i> Đánh
                            giá</button>
                        <?php elseif ($row['status'] === 'Chờ xác nhận' || $row['status'] === 'Chờ thanh toán'): ?>
                        <button class="action-btn cancel-btn danger-btn"><i class="fa-solid fa-ban"></i> Hủy
                            đơn</button>
                        <button class="action-btn detail-btn secondary-btn"><i class="fa-solid fa-info-circle"></i> Chi
                            tiết</button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <div class="no-history-message">
                    <i class="fa-solid fa-box-open"></i>
                    <p>Bạn chưa có lịch sử đặt phòng nào.</p>
                    <a href="./../TrangChu/user_homestay.php" class="btn-browse-homestay">Đặt phòng ngay</a>
                </div>
                <?php endif; ?>
            </div>
            <div class="history-detail-area">
                <div class="detail-card" id="detail">
                    <h3><i class="fa-solid fa-clipboard-list"></i> Chi tiết Đơn hàng</h3>
                    <p class="placeholder-text">👉 Vui lòng chọn một đơn đặt phòng bên trái để xem chi tiết.</p>
                </div>
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
    document.addEventListener("DOMContentLoaded", () => {

        const detailEl = document.getElementById("detail");

        // Show detail khi click vào card
        document.querySelectorAll(".history-card").forEach(card => {
            card.addEventListener("click", () => {
                // Xóa active cũ và thêm active mới
                document.querySelectorAll(".history-card").forEach(c => c.classList.remove(
                    'active'));
                card.classList.add('active');

                const id = card.dataset.bookingId;
                showDetail(id);
            });
        });

        // Delegation cho button đánh giá / hủy / chi tiết (dùng cho các button bên trong card)
        document.body.addEventListener("click", e => {
            const card = e.target.closest(".history-card");
            if (!card) return;
            const id = card.dataset.bookingId;

            // Đảm bảo click vào nút, không phải khu vực khác của card
            if (e.target.matches(".review-btn") || e.target.matches(".detail-btn")) {
                e.stopPropagation();

                // Xóa active cũ và thêm active mới cho card được click
                document.querySelectorAll(".history-card").forEach(c => c.classList.remove('active'));
                card.classList.add('active');

                showDetail(id);
            }

            if (e.target.matches(".cancel-btn")) {
                e.stopPropagation();
                cancelBooking(id);
            }
        });

        function showDetail(id) {
            // Tải lại chi tiết và hiển thị
            detailEl.innerHTML =
                `<h3><i class="fa-solid fa-spinner fa-spin"></i> Đang tải chi tiết đơn hàng #${id}...</h3>`;

            fetch("get_booking_detail.php?id=" + id)
                .then(res => res.json())
                .then(data => {
                    if (!data) {
                        detailEl.innerHTML =
                            "<p class='error-message'>⚠️ Không tìm thấy chi tiết đơn này</p>";
                        return;
                    }

                    // Reset rating cho form review
                    detailEl.dataset.rating = 0;

                    // Cập nhật nội dung chi tiết
                    detailEl.innerHTML = `
                        <div class="detail-section-header">
                            <h3>Mã đơn hàng: #${data.booking_id}</h3>
                            <span class="status-tag detail-status ${data.status.toLowerCase().replace(' ', '-')}">${data.status}</span>
                        </div>
                        
                        <div class="detail-homestay-info">
                            <img src="${data.homestay_img}" alt="${data.homestay_name}" class="detail-homestay-img">
                            <div>
                                <h4>${data.homestay_name}</h4>
                                <p><i class="fa-solid fa-location-dot"></i> ${data.address}</p>
                            </div>
                        </div>

                        <div class="detail-summary-info">
                            <p><b><i class="fa-solid fa-calendar-check"></i> Check-in/out:</b> ${data.checkin_date} đến ${data.checkout_date}</p>
                            <p><b><i class="fa-solid fa-users"></i> Số khách:</b> ${data.guests}</p>
                            <p><b><i class="fa-solid fa-user"></i> Khách hàng:</b> ${data.customer_name} (${data.customer_email})</p>
                            <p><b><i class="fa-solid fa-phone"></i> SĐT:</b> ${data.customer_phone}</p>
                            <p><b><i class="fa-solid fa-credit-card"></i> PTTT:</b> ${data.payment_method.toUpperCase()}</p>
                            <p class="final-price"><b><i class="fa-solid fa-money-bill-wave"></i> TỔNG TIỀN:</b> <span>${parseInt(data.total_price).toLocaleString("vi-VN")} đ</span></p>
                        </div>

                        ${(data.status === 'Đã xác nhận' || data.status === 'Đã thanh toán') ? `
                        <div class="detail-review-form">
                            <h4>⭐ Đánh giá của bạn:</h4>
                            <div class="rating">
                                <i class="fa fa-star" data-value="1"></i>
                                <i class="fa fa-star" data-value="2"></i>
                                <i class="fa fa-star" data-value="3"></i>
                                <i class="fa fa-star" data-value="4"></i>
                                <i class="fa fa-star" data-value="5"></i>
                            </div>
                            <textarea id="review" placeholder="Nhập đánh giá của bạn (tối đa 500 ký tự)..."></textarea>
                            <button id="submit-review" class="primary-btn"><i class="fa-solid fa-paper-plane"></i> Gửi đánh giá</button>
                        </div>
                        ` : ''}

                        <div id="review-list" class="detail-reviews"><p>⏳ Đang tải đánh giá...</p></div>
                    `;

                    // Logic JS cho chọn sao
                    detailEl.querySelectorAll(".fa-star").forEach(star => {
                        star.addEventListener("click", () => {
                            const value = parseInt(star.dataset.value);
                            detailEl.querySelectorAll(".fa-star").forEach(s => s.classList
                                .remove("active"));
                            for (let i = 0; i < value; i++) {
                                detailEl.querySelectorAll(".fa-star")[i].classList.add(
                                    "active");
                            }
                            detailEl.dataset.rating = value;
                        });
                    });

                    // Logic JS Gửi review
                    if (document.getElementById("submit-review")) {
                        document.getElementById("submit-review").addEventListener("click", () => {
                            const rating = detailEl.dataset.rating || 0;
                            const review = document.getElementById("review").value.trim();
                            if (rating == 0 && !review) {
                                alert("⚠️ Vui lòng nhập đánh giá hoặc chọn sao!");
                                return;
                            }

                            // SỬA: Đổi tên file từ get_reviews.php sang submit_review.php
                            fetch("submit_review.php", {

                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: "booking_id=" + id + "&rating=" + rating +
                                        "&review=" + encodeURIComponent(review),
                                    credentials: "include"
                                })
                                .then(res => res.text())
                                .then(resp => {
                                    if (resp === "success") {
                                        alert("✅ Đã gửi đánh giá!");

                                        // SỬA: Tải lại reviews của homestay đó (dùng homestay_id)
                                        loadReviews(data.homestay_id);

                                        document.getElementById("review").value = '';
                                        detailEl.dataset.rating = 0;
                                        detailEl.querySelectorAll(".fa-star").forEach(s => s
                                            .classList.remove("active"));
                                    } else if (resp === "not_logged_in") {
                                        alert("⚠️ Bạn cần đăng nhập trước khi gửi đánh giá!");
                                    } else {
                                        alert(
                                            "❌ Gửi đánh giá thất bại! Vui lòng kiểm tra console."
                                        );
                                        console.error("Lỗi PHP: ", resp);
                                    }
                                });

                        });
                    }

                    // SỬA: Gọi loadReviews bằng homestay_id để lấy tất cả review liên quan
                    loadReviews(data.homestay_id);

                })
                .catch(err => {
                    console.error(err);
                    detailEl.innerHTML = "<p class='error-message'>⚠️ Lỗi khi tải chi tiết đơn.</p>";
                });
        }

        // SỬA: Hàm loadReviews nhận homestay_id và gọi đúng tham số
        function loadReviews(homestay_id) {
            // SỬA: Truyền homestay_id vào get_reviews.php
            fetch("get_reviews.php?homestay_id=" + homestay_id)
                .then(res => res.json())
                .then(data => {
                    if (data.status === "error") {
                        const reviewList = document.getElementById("review-list");
                        if (reviewList) reviewList.innerHTML =
                            `<h4>💬 Lỗi tải đánh giá: ${data.message}</h4>`;
                        return;
                    }

                    const reviews = data.reviews || [];
                    const reviewList = document.getElementById("review-list");
                    if (!reviewList) return;

                    reviewList.innerHTML = `<h4>💬 Các đánh giá liên quan (${reviews.length} lượt):</h4>`;
                    if (reviews.length === 0) {
                        reviewList.innerHTML += "<p>⚠️ Chưa có đánh giá nào cho homestay này.</p>";
                        return;
                    }

                    reviews.forEach(r => {
                        reviewList.innerHTML += `
                <div class="review-item-display">
                    <p class="review-meta"><b>${r.customer_name}</b> 
                        <span class="rating-display">${"★".repeat(r.rating)}${"☆".repeat(5-r.rating)}</span>
                        <span class="review-date">(${r.created_at})</span>
                    </p>
                    <p class="review-content">${r.review}</p>
                </div>
            `;
                    });
                })
                .catch(err => console.error(err));
        }


        // Giữ nguyên Logic JS: cancelBooking
        function cancelBooking(id) {
            if (!confirm("Bạn có chắc chắn muốn hủy đặt phòng này không? Hành động này không thể hoàn tác."))
                return;

            fetch("cancel_booking.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "id=" + id
                })
                .then(res => res.text())
                .then(data => {
                    if (data === "success") {
                        alert("❌ Đã hủy đặt phòng! Vui lòng làm mới trang để xem trạng thái mới nhất.");
                        location.reload();
                    } else {
                        alert("⚠️ Hủy thất bại! Đơn hàng đã được xử lý hoặc không hợp lệ.");
                    }
                })
                .catch(err => console.error(err));
        }

    });
    </script>
</body>

</html>