<?php
include '../db.php';

// Lấy danh sách homestay còn phòng
$sql = "SELECT id, name, price, guests FROM homestays WHERE status='còn phòng' LIMIT 3";
$result = $conn->query($sql);
$homestays = [];
while($row = $result->fetch_assoc()){
    $homestays[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking HomeStay</title>
<<<<<<< HEAD
    <link rel="stylesheet" href="../CSS/style_user.css?v=6">
=======
    <link rel="stylesheet" href="../CSS/style_user.css?v=4.0">
>>>>>>> 68a2dc10f5c119f0bba44b4dbc411b9d6994c0c0
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="../JS/JS_TRANGCHU.js"></script>
</head>
<body>
    <!-- Thanh menu -->
    <div class="header-top">
        <ul>
            <li><a href="user.php">Trang chủ</a></li>
            <li><a href="about.php">Về chúng tôi</a></li>
            <li><a href="contact.html">&#9742;Liên hệ</a></li>
            <li><a href="#feedback">Đánh giá</a></li>
            <li><a href="../TrangChu/homestay.php">Danh sách các HomeStay</a></li>
             <li><a href="login.php">Đăng nhập</a></li>
             <ul class="menu">
             <li><a href="../PLACE/history.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
          </ul>
        </ul>
        <ul class="profile">
        <li> 
          <a href="#"><i class="fa-solid fa-user"></i></a>
          <!-- Hộp thông tin cá nhân -->
              <div class="profile-info">
              <img src="../images/7.webp" alt="Avatar">
              <h3>Nguyễn Văn A</h3>
              <p><b>Email: nguyenvana@example.com</b></p>
              <p><a href="profile.php">Thông tin cá nhân </a></p>
              <p> <a href="#">Đăng Xuất </a></p>
              </div>
        </li>
        <ul>
    </div>
   <div class="profile-container">
     <div class ="profile-left">

      <div class ="profile-left-img">
        <p><img src="../images/7.webp" alt="Avatar"></p>
        <h2>nguyensang14012004</h2>
        <p><i class="fa-solid fa-pen"></i>Sửa hồ sơ</p>
      </div> 

      <div class="profile-left-content">
        <div class="content-list">
         <h3>Tài khoản của tôi</h3>
          <ul>
              <li><a href="#hoso">Hồ sơ</a></li>
              <li><a href="#diachi">Địa chỉ</a></li>
              <li><a href="#lichsu">Lịch sử đặt hàng</a></li>
              <li><a href="#danhgia">Đánh giá của tôi</a></li>
              <li><a href="#matkhau">Đổi mật khẩu</a></li>
          </ul>
       </div>

      </div>
     </div>
  <div class="profile-right" id="hoso">
  <h2>Hồ Sơ Của Tôi</h2>
  <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
  <hr>

  <div class="profile-form">
    <!-- Cột trái: Form -->
    <div class="form-left">
      <div class="form-group">
        <label>Tên đăng nhập : </label>
        <p>nguyensang1401</p>
      </div>

      <div class="form-group">
        <label>Tên :</label>
        <input type="text" value="Sáng">
      </div>

      <div class="form-group">
        <label>Email :</label>
        <p>nguyensang@gmail.com <a href="#">Thay Đổi</a></p>
      </div>

      <div class="form-group">
        <label>Số điện thoại :</label>
        <p>0123456789 <a href="#">Thêm</a></p>
      </div>

      <div class="form-group">
        <label>Giới tính</label>
        <label><input type="radio" name="gender"> Nam</label>
        <label><input type="radio" name="gender"> Nữ</label>
        <label><input type="radio" name="gender"> Khác</label>
      </div>

      <div class="form-group">
        <label>Ngày sinh :</label>
        <p>14/01/2004 <a href="#">Thay Đổi</a></p>
      </div>

      <button class="btn">Lưu</button>
    </div>

    <!-- Cột phải: Avatar -->
    <div class="avatar-box">
      <img src="../images/7.webp" alt="avatar">
      <input type="file"><button>Chọn Ảnh </button></input>

      <p>Dung lượng file tối đa 1 MB<br>Định dạng: .JPEG, .PNG</p>
    </div>
  </div>
</div>
<!-- ------------địa chỉ-------------- -->
<div class="profile-right" id="diachi" style="display:none;">
  <h2>Địa chỉ của tôi</h2>
  <p>Quản lý thông tin địa chỉ để thuận tiện khi đặt homestay</p>
  <hr>

  <div class="address-list">
    <div class="address-item">
      <p><b>Nguyensang14</b> | 0123 456 789</p>
      <p>123 Đường ABC, Quận 1, TP. HCM</p>
      <button class="btn-edit">Sửa</button>
      <button class="btn-delete">Xóa</button>
    </div>

    <div class="address-item">
      <p><b>sangnguyen1401</b> | 0987 654 321</p>
      <p>456 Đường XYZ, Quận 2, TP. HCM</p>
      <button class="btn-edit">Sửa</button>
      <button class="btn-delete">Xóa</button>
    </div>
  </div>

  <button class="btn">+ Thêm địa chỉ mới</button>
</div>

<!-- ------------lịch sử đặt hàng-------------- -->
<div class="profile-right" id="lichsu" style="display:none;">
  <h2>Lịch sử đặt hàng</h2>
  <p>Quản lý các homestay bạn đã từng đặt.</p>
  <hr>

  <div class="order-history">
    <div class="order-item">
      <p><b>Mã đơn:</b> #12345</p>
      <p><b>Ngày đặt:</b> 15/09/2025</p>
      <p><b>Homestay:</b> Homestay Đà Lạt</p>
      <p><b>Trạng thái:</b> Hoàn thành</p>
      <button class="btn">Xem chi tiết</button>
    </div>

    <div class="order-item">
      <p><b>Mã đơn:</b> #67890</p>
      <p><b>Ngày đặt:</b> 01/09/2025</p>
      <p><b>Homestay:</b> Homestay Sapa</p>
      <p><b>Trạng thái:</b> Đang xử lý</p>
      <button class="btn">Xem chi tiết</button>
    </div>
  </div>
</div>
<!-- ------------đánh giá của tôi-------------- -->
<div class="profile-right" id="danhgia" style="display:none;">
  <h2>Đánh giá của tôi</h2>
  <p>Danh sách các homestay bạn đã đánh giá.</p>
  <hr>

  <div class="review-list">
    <div class="review-item">
      <p><b>Homestay Đà Lạt</b></p>
      <p>⭐⭐⭐⭐☆ (4/5)</p>
      <p>“Không gian đẹp, thoải mái. Sẽ quay lại.”</p>
      <button class="btn-edit">Sửa đánh giá</button>
      <button class="btn-delete">Xóa</button>
    </div>

    <div class="review-item">
      <p><b>Homestay Sapa</b></p>
      <p>⭐⭐⭐☆☆ (3/5)</p>
      <p>“Phòng ổn nhưng dịch vụ chưa tốt lắm.”</p>
      <button class="btn-edit">Sửa đánh giá</button>
      <button class="btn-delete">Xóa</button>
    </div>
  </div>

  <button class="btn">+ Viết đánh giá mới</button>
</div>
 <!-- ------------đổi mật khẩu-------------- -->
<div class="profile-right" id="matkhau" style="display:none;">
  <h2>Đổi mật khẩu</h2>
  <p>Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác.</p>
  <hr>

  <div class="password-form">
    <div class="form-group">
      <label for="old-password">Mật khẩu hiện tại:</label>
      <input type="password" id="old-password" placeholder="Nhập mật khẩu cũ">
    </div>

    <div class="form-group">
      <label for="new-password">Mật khẩu mới:</label>
      <input type="password" id="new-password" placeholder="Nhập mật khẩu mới">
    </div>

    <div class="form-group">
      <label for="confirm-password">Xác nhận mật khẩu mới:</label>
      <input type="password" id="confirm-password" placeholder="Nhập lại mật khẩu mới">
    </div>

    <button class="btn">Lưu thay đổi</button>
  </div>
</div>

     </div>
   </div>

      
<!-- -----------------------------------------------Footer ----------------------------------------------------------->
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
<!-- --------click chuyển trang hiển thị------------- -->
<script>
document.querySelectorAll('.content-list a').forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault(); // Ngăn chuyển trang #anchor

    // Ẩn tất cả profile-right
    document.querySelectorAll('.profile-right').forEach(div => {
      div.style.display = 'none';
    });

    // Hiện phần được chọn
    let target = this.getAttribute('href').substring(1); // bỏ dấu #
    document.getElementById(target).style.display = 'block';
  });
});
</script>
</body>
</html>