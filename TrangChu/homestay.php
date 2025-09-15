<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
  <title>Danh sách Homestay</title>
  <style>
    body { font-family: Arial, sans-serif; margin:0; padding:20px; background:#f5f5f5; }
    h1 { text-align:center; margin-bottom:20px; color:#0071c2; }
    .container { display:flex; gap:20px; }

    /* Sidebar filter */
    .filter-box {
      width:250px; background:#fff; padding:15px; border-radius:8px;
      box-shadow:0 2px 6px rgba(0,0,0,0.1);
    }
    .filter-box h3 { margin-bottom:10px; color:#333; }
    .filter-box label { display:block; margin:6px 0; }

    /* Homestay grid */
    .homestay-list {
      flex:1;
      display:grid;
      grid-template-columns: 1fr 1fr;  /* 👉 Cố định 2 cột */
      gap:20px;
    }
    .homestay-card {
      background:#fff; border-radius:8px; overflow:hidden;
      box-shadow:0 2px 6px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .homestay-card:hover { transform: translateY(-5px); }
    .homestay-card img { width:100%; height:180px; object-fit:cover; }
    .homestay-card .info { padding:12px; }
    .homestay-card h4 { margin:0; color:#0071c2; font-size:18px; }
    .stars { color:#f5a623; }
    .status { font-size:14px; margin:6px 0; }
    .status.available { color:green; }
    .status.full { color:red; }
    .room-type { font-size:14px; background:#eee; padding:4px 8px; border-radius:6px; display:inline-block; }
    .btn-place { 
      display:inline-block; margin-top:10px; padding:8px 12px; background:#0071c2; color:#fff; text-decoration:none; border-radius:6px;
      transition: background 0.3s;
    }
  </style>
</head>
<body>
  <h1>Danh sách Homestay</h1>
  <div class="container">
    <!-- Bộ lọc -->
    <div class="filter-box">
      <h3>Lọc kết quả</h3>
      <div>
        <strong>Số sao</strong>
        <label><input type="checkbox" class="filter" value="5sao"> 5 sao</label>
        <label><input type="checkbox" class="filter" value="4sao"> 4 sao</label>
        <label><input type="checkbox" class="filter" value="3sao"> 3 sao</label>
        <label><input type="checkbox" class="filter" value="3sao"> 2 sao</label>
        <label><input type="checkbox" class="filter" value="3sao"> 1 sao</label>
      </div>
      <div>
        <strong>Tình trạng</strong>
        <label><input type="checkbox" class="filter" value="conphong"> Còn phòng</label>
        <label><input type="checkbox" class="filter" value="hetphong"> Hết phòng</label>
      </div>
      <div>
        <strong>Loại phòng</strong>
        <label><input type="checkbox" class="filter" value="Deluxe"> Deluxe</label>
        <label><input type="checkbox" class="filter" value="Family"> Family</label>
        <label><input type="checkbox" class="filter" value="Standard"> Standard</label>
      </div>
    </div>

    <!-- Danh sách homestay -->
    <div class="homestay-list" id="homestay-list">
      <!-- 16 homestay demo -->
      <div class="homestay-card" data-star="5sao" data-status="conphong" data-type="Deluxe">
        <img src="../ANH/BV1.jpg" alt="Homestay 1">
        <div class="info">
          <h4>Homestay Ba Vì</h4>
          <div class="stars">★★★★★</div>
          <div class="status available">Còn phòng</div>
          <span class="room-type">Deluxe</span>
          <a href="#" class="btn-place btn-book">Đặt phòng</a>
        </div>
      </div>

      <div class="homestay-card" data-star="4sao" data-status="hetphong" data-type="Family">
        <img src="../ANH/MC1.webp" alt="Homestay 2">
        <div class="info">
          <h4>Homestay Sóc Sơn</h4>
          <div class="stars">★★★★☆</div>
          <div class="status full">Hết phòng</div>
          <span class="room-type">Family</span>
          <a href="#" class="btn-place btn-book">Đặt phòng</a>
        </div>
      </div>

      <div class="homestay-card" data-star="3sao" data-status="conphong" data-type="Standard">
        <img src="../ANH/SS1.jpg" alt="Homestay 3">
        <div class="info">
          <h4>Homestay Tam Đảo</h4>
          <div class="stars">★★★☆☆</div>
          <div class="status available">Còn phòng</div>
          <span class="room-type">Standard</span>
          <a href="#" class="btn-place btn-book">Đặt phòng</a>
        </div>
      </div>

      <!-- 16 homestay demo -->
      <div class="homestay-card" data-star="5sao" data-status="conphong" data-type="Deluxe">
        <img src="../ANH/TD1.jpg" alt="Homestay 1">
        <div class="info">
          <h4>Homestay Ba Vì</h4>
          <div class="stars">★★★★★</div>
          <div class="status available">Còn phòng</div>
          <span class="room-type">Deluxe</span>
          <a href="#" class="btn-place btn-book">Đặt phòng</a>
        </div>
      </div>

        <div class="homestay-card" data-star="4sao" data-status="hetphong" data-type="Family">
            <img src="../ANH/BV2.jpg" alt="Homestay 2">
            <div class="info">
            <h4>Homestay Sóc Sơn</h4>
            <div class="stars">★★★★☆</div>
            <div class="status full">Hết phòng</div>
            <span class="room-type">Family</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>

        <div class="homestay-card" data-star="3sao" data-status="conphong" data-type="Standard">
            <img src="../ANH/MC2.webp" alt="Homestay 3">
            <div class="info">
            <h4>Homestay Tam Đảo</h4>
            <div class="stars">★★★☆☆</div>
            <div class="status available">Còn phòng</div>
            <span class="room-type">Standard</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>
           
        <div class="homestay-card" data-star="5sao" data-status="conphong" data-type="Deluxe">
            <img src="../ANH/SS2.jpg" alt="Homestay 4">
            <div class="info">
            <h4>Homestay Mộc Châu</h4>
            <div class="stars">★★★★★</div>
            <div class="status available">Còn phòng</div>
            <span class="room-type">Deluxe</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>

        <div class="homestay-card" data-star="4sao" data-status="hetphong" data-type="Family">
            <img src="../ANH/TD2.jpg" alt="Homestay 5">
            <div class="info">
            <h4>Homestay Đà Lạt</h4>
            <div class="stars">★★★★☆</div>
            <div class="status full">Hết phòng</div>
            <span class="room-type">Family</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>

        <div class="homestay-card" data-star="3sao" data-status="conphong" data-type="Standard">
            <img src="../ANH/BV3.jpg" alt="Homestay 6">
            <div class="info">
            <h4>Homestay Ninh Bình</h4>
            <div class="stars">★★★☆☆</div>
            <div class="status available">Còn phòng</div>
            <span class="room-type">Standard</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
            </div>

        <div class="homestay-card" data-star="5sao" data-status="conphong" data-type="Deluxe">
            <img src="../ANH/MC3.webp" alt="Homestay 7">
            <div class="info">
            <h4>Homestay Phú Quốc</h4>
            <div class="stars">★★★★★</div>
            <div class="status available">Còn phòng</div>
            <span class="room-type">Deluxe</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>

        <div class="homestay-card" data-star="4sao" data-status="hetphong" data-type="Family">
            <img src="../ANH/TD3.jpg" alt="Homestay 8">
            <div class="info">
            <h4>Homestay Hội An</h4>
            <div class="stars">★★★★☆</div>
            <div class="status full">Hết phòng</div>
            <span class="room-type">Family</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>
        
        <div class="homestay-card" data-star="3sao" data-status="conphong" data-type="Standard">
            <img src="../ANH/SS3.jpg" alt="Homestay 9">
            <div class="info">
            <h4>Homestay Huế</h4>
            <div class="stars">★★★☆☆</div>
            <div class="status available">Còn phòng</div>
            <span class="room-type">Standard</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>

        <div class="homestay-card" data-star="5sao" data-status="conphong" data-type="Deluxe">
            <img src="../ANH/BV4.jpg" alt="Homestay 10">
            <div class="info">
            <h4>Homestay Sapa</h4>
            <div class="stars">★★★★★</div>
            <div class="status available">Còn phòng</div>
            <span class="room-type">Deluxe</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>

        <div class="homestay-card" data-star="4sao" data-status="hetphong" data-type="Family">
            <img src="../ANH/MC4.webp" alt="Homestay 11">
            <div class="info">
            <h4>Homestay Cần Thơ</h4>
            <div class="stars">★★★★☆</div>
            <div class="status full">Hết phòng</div>
            <span class="room-type">Family</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>

        <div class="homestay-card" data-star="3sao" data-status="conphong" data-type="Standard">
            <img src="../ANH/SS5.jpg" alt="Homestay 12">
            <div class="info">
            <h4>Homestay Vũng Tàu</h4>
            <div class="stars">★★★☆☆</div>
            <div class="status available">Còn phòng</div>
            <span class="room-type">Standard</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>

        <div class="homestay-card" data-star="5sao" data-status="conphong" data-type="Deluxe">
            <img src="../ANH/TD4.jpg" alt="Homestay 13">
            <div class="info">
            <h4>Homestay Quy Nhơn</h4>
            <div class="stars">★★★★★</div>
            <div class="status available">Còn phòng</div>
            <span class="room-type">Deluxe</span>
            <a href="#" class="btn-place btn-book">Đặt phòng</a>
            </div>
        </div>

      <!-- 👉 Bạn copy thêm và chỉnh nội dung cho đủ 16 homestay -->
    </div>
  </div>

  <script>
    const filters = document.querySelectorAll('.filter');
    const cards = document.querySelectorAll('.homestay-card');

    filters.forEach(f => {
      f.addEventListener('change', () => {
        filterCards();
      });
    });

    function filterCards() {
      let activeFilters = Array.from(filters)
        .filter(f => f.checked)
        .map(f => f.value);

      cards.forEach(card => {
        let match = activeFilters.every(f =>
          card.dataset.star === f ||
          card.dataset.status === f ||
          card.dataset.type === f
        );

        // Nếu không có filter nào -> show hết
        if (activeFilters.length === 0 || match) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });
    }
  </script>
</body>
</html>
