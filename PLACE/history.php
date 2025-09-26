<?php
include '../db.php';

// Lấy dữ liệu từ DB: bookings + homestay
$sql = "SELECT b.*, h.name AS homestay_name, h.img AS homestay_img 
        FROM bookings b 
        JOIN homestays h ON b.homestay_id = h.id 
        ORDER BY b.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Lịch sử Homestay</title>
  <link rel="stylesheet" href="../CSS/style_user.css?v=6">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="header-top">
  <ul>

    <li><a href="../TrangChu/user_main.php">Trang chủ</a></li>
    <li><a href="../TrangChu/about.php">Về chúng tôi</a></li>
    <li><a href="../TrangChu/contact.html">&#9742;Liên hệ</a></li>
    <li><a href="##review">Đánh giá</a></li>

    <li><a href="#explore-location">Danh sách các HomeStay</a></li>
    <li><a href="login.php">Đăng nhập</a></li>
    <li><a href="#"><i class="fa-solid fa-user"></i></a></li>
    <ul class="menu">
      <li><a href="history.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
    </ul>
  </ul>
</div>

<h2>Lịch sử đặt Homestay</h2>

<div class="container-history">
  <div class="history">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="card-history" data-booking-id="<?php echo $row['id']; ?>" onclick="showDetail(<?php echo $row['id']; ?>)">
          <img src="<?php echo htmlspecialchars($row['homestay_img']); ?>" alt="">
          <div class="card-info">
            <h3><?php echo htmlspecialchars($row['homestay_name']); ?></h3>
            <p>Ngày đến: <?php echo $row['checkin_date']; ?></p>
            <p>Ngày đi: <?php echo $row['checkout_date']; ?></p>
            <p>Số khách: <?php echo $row['guests']; ?></p>
            <p>Thanh toán: <?php echo strtoupper($row['payment_method']); ?></p>
            <p>Tổng tiền: <b><?php echo number_format($row['total_price'],0,",","."); ?>đ</b></p>

            <?php if ($row['status'] === 'confirmed' || $row['status'] === 'paid'): ?>
              <span class="status confirmed">✔ Đã xác nhận</span><br>
              <button class="review-btn" onclick="event.stopPropagation(); showDetail(<?php echo $row['id']; ?>)">Đánh giá</button>
            <?php elseif ($row['status'] === 'pending'): ?>
              <span class="status pending">⏳ Chờ xác nhận</span><br>
              <button class="cancel-btn" onclick="event.stopPropagation(); cancelBooking(<?php echo $row['id']; ?>)">Hủy đặt phòng</button>
            <?php else: ?>
              <span class="status cancel">❌ Đã hủy</span>
            <?php endif; ?>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>❌ Bạn chưa có đơn đặt phòng nào.</p>
    <?php endif; ?>
  </div>

  <div class="detail" id="detail">
    <p>👉 Chọn một homestay bên trái để xem chi tiết</p>
  </div>
</div>

<footer class="footer">
  <div class="footer-container">
    <div class="footer-col">
      <h2>BookingHomeStay</h2>
      <p>Đặt homestay nhanh chóng, dễ dàng và tiện lợi.  
      Mang đến trải nghiệm nghỉ dưỡng tuyệt vời cho bạn.</p>
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

<script>
// Hiển thị chi tiêt
// Hiển thị chi tiết
function showDetail(id) {
  fetch("get_booking_detail.php?id=" + id)
    .then(res => res.json())
    .then(data => {
      const detailEl = document.getElementById("detail");
      if (!data) {
        detailEl.innerHTML = "<p>⚠️ Không tìm thấy chi tiết đơn này</p>";
        return;
      }

      detailEl.innerHTML = `
        <h3>${data.homestay_name}</h3>
        <img src="${data.homestay_img}" alt="">
        <p><b>Khách hàng:</b> ${data.customer_name} (${data.customer_email})</p>
        <p><b>Số điện thoại:</b> ${data.customer_phone}</p>
        <p><b>Ngày đến:</b> ${data.checkin_date}</p>
        <p><b>Ngày đi:</b> ${data.checkout_date}</p>
        <p><b>Số khách:</b> ${data.guests}</p>
        <p><b>Tổng tiền:</b> ${parseInt(data.total_price).toLocaleString("vi-VN")} VND</p>

        <h4>⭐ Đánh giá của bạn:</h4>
        <div class="rating" id="rating">
          <i class="fa fa-star" data-value="1"></i>
          <i class="fa fa-star" data-value="2"></i>
          <i class="fa fa-star" data-value="3"></i>
          <i class="fa fa-star" data-value="4"></i>
          <i class="fa fa-star" data-value="5"></i>
        </div>
        <textarea id="review" placeholder="Nhập đánh giá của bạn..."></textarea>
        <button onclick="submitReview(${data.id})">Gửi đánh giá</button>

        <div id="review-list"><p>⏳ Đang tải đánh giá...</p></div>
      `;

      // chọn sao
      detailEl.querySelectorAll(".fa-star").forEach(star => {
        star.addEventListener("click", () => {
          const value = parseInt(star.dataset.value);
          detailEl.querySelectorAll(".fa-star").forEach(s => s.classList.remove("active"));
          for (let i = 0; i < value; i++) {
            detailEl.querySelectorAll(".fa-star")[i].classList.add("active");
          }
          detailEl.dataset.rating = value;
        });
      });

      // tải danh sách review
      loadReviews(id);
    });
}

// Lấy review từ DB
function loadReviews(booking_id) {
  fetch("get_reviews.php?booking_id=" + booking_id)
    .then(res => res.json())
    .then(reviews => {
      const reviewList = document.getElementById("review-list");
      if (reviews.length === 0) {
        reviewList.innerHTML = "<p>⚠️ Chưa có đánh giá nào.</p>";
        return;
      }
      reviewList.innerHTML = "<h4>💬 Đánh giá của khách:</h4>";
      reviews.forEach(r => {
        reviewList.innerHTML += `
          <div class="review">
            <p><b>${r.customer_name}</b> (${r.customer_email}) 
              <span class="rating">${"★".repeat(r.rating)}${"☆".repeat(5-r.rating)}</span>
            </p>
            <p>${r.review}</p>
          </div>
        `;
      });
    });
}


// Gửi đánh giá
function submitReview(id) {
  const detailEl = document.getElementById("detail");
  const rating = detailEl.dataset.rating || 0;
  const review = document.getElementById("review").value.trim();

  if (rating == 0 && !review) {
    alert("⚠️ Vui lòng nhập đánh giá hoặc chọn sao!");
    return;
  }

  fetch("submit_review.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "booking_id=" + id + "&rating=" + rating + "&review=" + encodeURIComponent(review)
  })
  .then(res => res.text())
  .then(data => {
    if (data === "success") {
      alert("✅ Đã gửi đánh giá!");
    } else {
      alert("❌ Gửi đánh giá thất bại!");
    }
  });
}

// Hủy đặt phòng
function cancelBooking(id) {
  if (!confirm("Bạn có chắc chắn muốn hủy đặt phòng này không?")) return;

  fetch("cancel_booking.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + id
  })
  .then(res => res.text())
  .then(data => {
    if (data === "success") {
      alert("❌ Đã hủy đặt phòng!");
      location.reload();
    } else {
      alert("⚠️ Hủy thất bại!");
    }
  });
}
</script>
</body>
</html>
