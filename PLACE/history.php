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
    <li><a href="../TrangChu/user.php">Trang chủ</a></li>
    <li><a href="about.php">Về chúng tôi</a></li>
    <li><a href="contact.html">&#9742;Liên hệ</a></li>
    <li><a href="##review">Đánh giá</a></li>
    <li><a href="#explore-location">Danh sách các HomeStay</a></li>
    <li><a href="login.php">Đăng nhập</a></li>
    <li><a href="#"><i class="fa-solid fa-user"></i></a></li>
    <ul class="menu">
      <li><a href="../PLACE/history.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
    </ul>
  </ul>
</div>

<h2>Lịch sử đặt Homestay</h2>

<div class="container-history">
  <div class="history">
    <div class="card-history" onclick="showDetail(0)">
      <img src="https://picsum.photos/id/1018/200/150" alt="">
      <div class="card-info">
        <h3>Amaya Home Deluxe</h3>
        <p>Ngày đến: 2025-09-20</p>
        <p>Ngày đi: 2025-09-22</p>
        <span class="status confirmed">✔ Đã xác nhận</span><br>
        <button class="review-btn" onclick="event.stopPropagation(); showDetail(0)">Đánh giá</button>
      </div>
    </div>

    <div class="card-history" onclick="showDetail(1)">
      <img src="https://picsum.photos/id/1015/200/150" alt="">
      <div class="card-info">
        <h3>Dream House Standard</h3>
        <p>Ngày đến: 2025-10-01</p>
        <p>Ngày đi: 2025-10-03</p>
        <span class="status confirmed">✔ Đã xác nhận</span>
      </div>
    </div>

    <div class="card-history" onclick="showDetail(2)">
      <img src="https://picsum.photos/id/1020/200/150" alt="">
      <div class="card-info">
        <h3>Sunset Villa</h3>
        <p>Ngày đến: 2025-09-25</p>
        <p>Ngày đi: 2025-09-28</p>
        <span class="status pending">⏳ Chờ xác nhận</span><br>
        <button class="cancel-btn" onclick="event.stopPropagation(); cancelBooking(3)">Hủy đặt phòng</button>
      </div>
    </div>
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
const homestays = [
  { name: "Amaya Home Deluxe", price: 1200000, nights: 2, img: "https://picsum.photos/id/1018/600/400", desc: "Homestay sang trọng, đầy đủ tiện nghi." },
  { name: "Dream House Standard", price: 900000, nights: 2, img: "https://picsum.photos/id/1015/600/400", desc: "Không gian gia đình ấm cúng, gần trung tâm." },
  { name: "Sunset Villa", price: 1500000, nights: 3, img: "https://picsum.photos/id/1020/600/400", desc: "View hoàng hôn tuyệt đẹp, hồ bơi ngoài trời." }
];

function showDetail(index) {
  const h = homestays[index];
  if (!h) return;
  const total = h.price * h.nights;

  const detailEl = document.getElementById("detail");
  detailEl.innerHTML = `
    <h3>${h.name}</h3>
    <img src="${h.img}" alt="${h.name}">
    <p><b>Giá/đêm:</b> ${h.price.toLocaleString("vi-VN")} VND</p>
    <p><b>Số đêm:</b> ${h.nights}</p>
    <p><b>Tổng tiền đã thanh toán:</b> <span class="total">${total.toLocaleString("vi-VN")} VND</span></p>
    <p>${h.desc}</p>

    <h4>⭐ Đánh giá của bạn:</h4>
    <div class="rating" id="rating-${index}">
      <i class="fa fa-star" data-value="1"></i>
      <i class="fa fa-star" data-value="2"></i>
      <i class="fa fa-star" data-value="3"></i>
      <i class="fa fa-star" data-value="4"></i>
      <i class="fa fa-star" data-value="5"></i>
    </div>
    <textarea id="review" placeholder="Nhập đánh giá của bạn..."></textarea>
    <input type="file" id="videoUpload" accept="video/*">
    <button class="review-btn" onclick="submitReview()">Gửi đánh giá</button>

    <div class="review-history">
      <h4>💬 Đánh giá của khách trước:</h4>
      <div class="review">
        <p><b>nguyenhoa@gmail.com</b> <span class="rating">★★★★☆</span></p>
        <p>Homestay sạch sẽ, nhân viên thân thiện.</p>
      </div>
      <div class="review">
        <p><b>tranminh@yahoo.com</b> <span class="rating">★★★★★</span></p>
        <p>View cực đẹp, đáng tiền!</p>
      </div>
    </div>
  `;

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
}

function submitReview() {
  const detailEl = document.getElementById("detail");
  const rating = detailEl.dataset.rating || 0;
  const review = document.getElementById("review")?.value.trim();
  const video = document.getElementById("videoUpload")?.files[0];

  if (rating == 0 && !review && !video) {
    alert("⚠️ Vui lòng nhập ít nhất một đánh giá!");
    return;
  }

  let msg = `✅ Đã gửi đánh giá!\n- Sao: ${rating}/5`;
  if (review) msg += `\n- Nội dung: ${review}`;
  if (video) msg += `\n- Video: ${video.name}`;
  alert(msg);

  document.getElementById("review").value = "";
  document.getElementById("videoUpload").value = "";
  detailEl.querySelectorAll(".fa-star").forEach(s => s.classList.remove("active"));
  detailEl.dataset.rating = 0;
}

function cancelBooking(index) {
  if (confirm("Bạn có chắc chắn muốn hủy đặt phòng này không?")) {
    alert(`❌ Đã hủy đặt phòng: ${homestays[index].name}`);
  }
}

window.showDetail = showDetail;
window.submitReview = submitReview;
window.cancelBooking = cancelBooking;
</script>
</body>
</html>
