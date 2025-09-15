<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đặt Homestay Mộc Châu</title>
<link rel="stylesheet" href="../CSS/css.css?v=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  </head>
<body>
  <!-- <style>
    * {margin:0; padding:0; box-sizing:border-box; font-family: "Segoe UI", sans-serif;}
    body {background:#f5f6f7; color:#333;}

    header {
      background:#2c3e50;
      color:#fff;
      padding:15px 40px;
      display:flex;
      justify-content:space-between;
      align-items:center;
    }
    header h1 {font-size:22px;}
    nav ul {list-style:none; display:flex; gap:20px;}
    nav a {color:white; text-decoration:none; transition:.3s;}
    nav a:hover {color:#f39c12;}

    .container {width:90%; margin:30px auto;}
    h2 {margin-bottom:20px; color:#2c3e50;}

    /* Bộ lọc */
    .filter-bar {
      background:#fff;
      padding:15px;
      border-radius:8px;
      margin-bottom:20px;
      box-shadow:0 2px 8px rgba(0,0,0,.1);
      display:flex;
      flex-wrap:wrap;
      gap:15px;
      align-items:center;
    }
    .filter-bar input, .filter-bar select {
      padding:8px 10px;
      border:1px solid #ccc;
      border-radius:6px;
      font-size:14px;
    }

    .room-list {
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
      gap:20px;
    }
    .card {
      background:#fff;
      border-radius:12px;
      overflow:hidden;
      box-shadow:0 4px 10px rgba(0,0,0,.1);
      transition:.3s;
    }
    .card:hover {transform:scale(1.02);}
    .card img {width:100%; height:200px; object-fit:cover;}
    .card-content {padding:15px;}
    .card-content h3 {margin-bottom:8px;}
    .info {font-size:14px; margin:4px 0; color:#555;}
    .stars {color:#f1c40f; margin:5px 0;}
    .btn-group {margin-top:10px; display:flex; gap:10px;}
    .btn {
      flex:1;
      text-align:center;
      padding:8px;
      border-radius:6px;
      text-decoration:none;
      color:#fff;
      font-size:14px;
    }
    .btn-detail {background:#3498db;}
    .btn-detail:hover {background:#2980b9;}
    .btn-book {background:#27ae60;}
    .btn-book:hover {background:#2ecc71;}

    footer {
      background:#2c3e50;
      color:white;
      text-align:center;
      padding:15px;
      margin-top:40px;
    }
  </style> -->


  <!-- Header -->
  <header>
    <h1>Homestay Mộc Châu</h1>
    <nav>
      <ul>
        <li><a href="user.php">Trang chủ</a></li>
        <li><a href="#">Liên hệ</a></li>
        <li><a href="#"><i class="fa-solid fa-user"></i> Tài khoản</a></li>
      </ul>
    </nav>
  </header>

  <!-- Bộ lọc -->
  <div class="container">
    <h2>Danh sách Homestay</h2>
    <div class="filter-bar">
      <input type="text" id="searchInput" placeholder="🔍 Tìm kiếm theo tên phòng...">
      <select id="filterType">
        <option value="">-- Lọc theo loại phòng --</option>
        <option value="Deluxe">Deluxe</option>
        <option value="Family">Family</option>
        <option value="Standard">Standard</option>
      </select>
      <select id="sortStars">
        <option value="">-- Sắp xếp theo sao --</option>
        <option value="desc">Sao cao → thấp</option>
        <option value="asc">Sao thấp → cao</option>
      </select>
    </div>

    <!-- Danh sách phòng -->
    <div class="room-list" id="roomList">

      <!-- Phòng 1 -->
      <div class="card" data-type="Deluxe" data-stars="5">
        <img src="../ANH/1.jpg" alt="Phòng Deluxe">
        <div class="card-content">
          <h3>Phòng Deluxe Ven Hồ</h3>
          <p class="info">Số phòng: 101</p>
          <p class="info">Loại phòng: Deluxe</p>
          <p class="info">Tình trạng: <b style="color:green">Còn trống</b></p>
          <p class="info">Nhận phòng: 14:00 | Trả phòng: 12:00</p>
          <div class="stars">⭐⭐⭐⭐⭐</div>
          <div class="btn-group">
            <a href="#" class="btn-place btn-detail">Xem chi tiết</a>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
          </div>
        </div>
      </div>

      <div class="card" data-type="Deluxe" data-stars="5">
        <img src="../ANH/2.jpg" alt="Phòng Deluxe">
        <div class="card-content">
          <h3>Phòng Deluxe Ven Hồ</h3>
          <p class="info">Số phòng: 101</p>
          <p class="info">Loại phòng: Deluxe</p>
          <p class="info">Tình trạng: <b style="color:green">Còn trống</b></p>
          <p class="info">Nhận phòng: 14:00 | Trả phòng: 12:00</p>
          <div class="stars">⭐⭐⭐⭐⭐</div>
          <div class="btn-group">
            <a href="#" class="btn-place btn-detail">Xem chi tiết</a>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
          </div>
        </div>
      </div>

 <div class="card" data-type="Deluxe" data-stars="5">
        <img src="../ANH/3.jpg" alt="Phòng Deluxe">
        <div class="card-content">
          <h3>Phòng Deluxe Ven Hồ</h3>
          <p class="info">Số phòng: 101</p>
          <p class="info">Loại phòng: Deluxe</p>
          <p class="info">Tình trạng: <b style="color:green">Còn trống</b></p>
          <p class="info">Nhận phòng: 14:00 | Trả phòng: 12:00</p>
          <div class="stars">⭐⭐⭐⭐⭐</div>
          <div class="btn-group">
            <a href="#" class="btn-place btn-detail">Xem chi tiết</a>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
          </div>
        </div>
      </div>


      <!-- Phòng 2 -->
      <div class="card" data-type="Family" data-stars="4">
        <img src="../ANH/4.jpg" alt="Phòng Family">
        <div class="card-content">
          <h3>Phòng Family Rừng Thông</h3>
          <p class="info">Số phòng: 202</p>
          <p class="info">Loại phòng: Family</p>
          <p class="info">Tình trạng: <b style="color:red">Đã đặt</b></p>
          <p class="info">Nhận phòng: 13:00 | Trả phòng: 11:00</p>
          <div class="stars">⭐⭐⭐⭐</div>
          <div class="btn-group">
            <a href="#" class="btn-place btn-detail">Xem chi tiết</a>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
          </div>
        </div>
      </div>

 <div class="card" data-type="Family" data-stars="4">
        <img src="../ANH/5.jpg" alt="Phòng Family">
        <div class="card-content">
          <h3>Phòng Family Rừng Thông</h3>
          <p class="info">Số phòng: 202</p>
          <p class="info">Loại phòng: Family</p>
          <p class="info">Tình trạng: <b style="color:red">Đã đặt</b></p>
          <p class="info">Nhận phòng: 13:00 | Trả phòng: 11:00</p>
          <div class="stars">⭐⭐⭐⭐</div>
          <div class="btn-group">
            <a href="#" class="btn-place btn-detail">Xem chi tiết</a>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
          </div>
        </div>
      </div>


      <!-- Phòng 3 -->
      <div class="card" data-type="Standard" data-stars="3">
        <img src="../ANH/7.webp" alt="Phòng Standard">
        <div class="card-content">
          <h3>Phòng Standard Nhà Gỗ</h3>
          <p class="info">Số phòng: 303</p>
          <p class="info">Loại phòng: Standard</p>
          <p class="info">Tình trạng: <b style="color:green">Còn trống</b></p>
          <p class="info">Nhận phòng: 15:00 | Trả phòng: 12:00</p>
          <div class="stars">⭐⭐⭐</div>
          <div class="btn-group">
            <a href="#" class="btn-place btn-detail">Xem chi tiết</a>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
          </div>
        </div>
      </div>


<div class="card" data-type="Standard" data-stars="3">
        <img src="../ANH/7.webp" alt="Phòng Standard">
        <div class="card-content">
          <h3>Phòng Standard Nhà Gỗ</h3>
          <p class="info">Số phòng: 303</p>
          <p class="info">Loại phòng: Standard</p>
          <p class="info">Tình trạng: <b style="color:green">Còn trống</b></p>
          <p class="info">Nhận phòng: 15:00 | Trả phòng: 12:00</p>
          <div class="stars">⭐⭐⭐</div>
          <div class="btn-group">
            <a href="#" class="btn-place btn-detail">Xem chi tiết</a>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
          </div>
        </div>
      </div>

      <div class="card" data-type="Standard" data-stars="3">
        <img src="../ANH/7.webp" alt="Phòng Standard">
        <div class="card-content">
          <h3>Phòng Standard Nhà Gỗ</h3>
          <p class="info">Số phòng: 303</p>
          <p class="info">Loại phòng: Standard</p>
          <p class="info">Tình trạng: <b style="color:green">Còn trống</b></p>
          <p class="info">Nhận phòng: 15:00 | Trả phòng: 12:00</p>
          <div class="stars">⭐⭐⭐</div>
          <div class="btn-group">
            <a href="#" class="btn-place btn-detail">Xem chi tiết</a>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
          </div>
        </div>
      </div>

    </div>
  </div>


  <!-- Footer -->
<footer class="footer">
  <div class="footer-container">
    <!-- Cột 1: Logo + giới thiệu -->
    <div class="footer-col">
      <h2>BookingHomeStay</h2>
      <p>Đặt homestay nhanh chóng, dễ dàng và tiện lợi.  
      Mang đến trải nghiệm nghỉ dưỡng tuyệt vời cho bạn.</p>
    </div>

    <!-- Cột 2: Thông tin liên hệ -->
    <div class="footer-col">
      <h3>Liên hệ</h3>
      <p>📍 Hà Nội, Việt Nam</p>
      <p>📞 0123 456 789</p>
      <p>✉️ bookinghomestay@gmail.com</p>
    </div>

    <!-- Cột 3: Mạng xã hội -->
    <div class="footer-col">
      <h3>Kết nối với chúng tôi</h3>
      <div class="social-links">
        <a href="#"><img src="../ANH/FB.jpg" alt="Facebook"></a>
        <a href="#"><img src="../ANH/IG.jpg" alt="Instagram"></a>
        <a href="#"><img src="../ANH/zalo.jpg" alt="Zalo"></a>
        <a href="#"><img src="../ANH/MES.jpg" alt="TikTok"></a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2025 BookingHomeStay. All rights reserved.</p>
  </div>
</footer>

  <!-- JS Lọc - Sắp xếp -->
  <script>
    const searchInput = document.getElementById("searchInput");
    const filterType = document.getElementById("filterType");
    const sortStars = document.getElementById("sortStars");
    const roomList = document.getElementById("roomList");
    let cards = Array.from(roomList.getElementsByClassName("card"));

    function filterRooms() {
      let searchText = searchInput.value.toLowerCase();
      let type = filterType.value;

      cards.forEach(card => {
        let name = card.querySelector("h3").innerText.toLowerCase();
        let roomType = card.dataset.type;

        let match = true;
        if (searchText && !name.includes(searchText)) match = false;
        if (type && roomType !== type) match = false;

        card.style.display = match ? "block" : "none";
      });
    }

    function sortRooms() {
      let order = sortStars.value;
      if (!order) return;

      cards.sort((a,b) => {
        let starsA = parseInt(a.dataset.stars);
        let starsB = parseInt(b.dataset.stars);
        return order === "desc" ? starsB - starsA : starsA - starsB;
      });

      // Sắp xếp lại DOM
      cards.forEach(card => roomList.appendChild(card));
    }

    searchInput.addEventListener("input", filterRooms);
    filterType.addEventListener("change", filterRooms);
    sortStars.addEventListener("change", sortRooms);
  </script>

</body>
</html>
