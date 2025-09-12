<?php
session_start();
require_once('../../config/connect.php');
if( isset($_SESSION['password']) 
   && isset($_SESSION['email']) 
   && isset($_SESSION['role'])){ ?>
<?php 
    }else{
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style_admin.css">
    <title>Admin</title>
</head>
<body>
    <div class="sidebar">
        <h2>HomeStay</h2>
         <ul>
            <li><a href="admin_account.php"> Thông tin admin</a></li>
            <li><a href="admin_dashboard.php"> Dashboard</a></li>
            <li><a href="manage_booking.php"> Quản lý Booking</a></li>
            <li><a href="manage_homestay.php"> Quản lý Homestay</a></li>
            <li><a href="manage_user.php"> Quản lý Người dùng</a></li>
            <li><a href="manage_rooms.php"> Quản lý phòng</a></li>
            <li><a href="manage_payment.php"> Quản lý thanh toán</a></li>
            <li><a href="manage_feedback.php"> Phản hồi đánh giá</a></li>
            <li><a href="support.php"> Hỗ trợ khách hàng</a></li>
            <li><a href="../Login/logout.php"> Đăng xuất</a></li>
        </ul>
    </div>
    <div class="section">
    <div class="header">
            <h1>Quản lý Booking Homestay</h1>
            <button class="btn" onclick="document.getElementById('addBookingModal').style.display='block'">Thêm Booking</button>
        </div>
        <div class="account-section">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Homestay</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>Nguyễn Văn A</td>
                        <td>Sunshine Villa</td>
                        <td>2025-08-28</td>
                        <td>Đã xác nhận</td>
                        <td>
                            <button class="btn">Sửa</button>
                            <button class="btn">Xóa</button>
                        </td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>Trần Thị B</td>
                        <td>Green House</td>
                        <td>2025-08-27</td>
                        <td>Chờ xác nhận</td>
                        <td>
                            <button class="btn">Sửa</button>
                            <button class="btn">Xóa</button>
                        </td>
                    </tr>
                    <!-- Thêm các dòng booking khác tại đây -->
                </tbody>
            </table>
        </div>
        <!-- Quick Stats -->
        <div style="display: flex; gap: 24px; margin-bottom: 30px;">
            <div style="flex:1;">
                <div class="payment-section">
                    <h3>Đơn đặt phòng hôm nay</h3>
                    <p style="font-size:2rem; font-weight:bold; color:#2d3e50;">25</p>
                </div>
            </div>
            <div style="flex:1;">
                <div class="account-section">
                    <h3>Homestay đang hoạt động</h3>
                    <p style="font-size:2rem; font-weight:bold; color:#2d3e50;">12</p>
                </div>
            </div>
            <div style="flex:1;">
                <div class="payment-section">
                    <h3>Doanh thu tháng này</h3>
                    <p style="font-size:2rem; font-weight:bold; color:#2d3e50;">50,000,000₫</p>
                </div>
            </div>
            <div style="flex:1;">
                <div class="feedback-section">
                    <h3>Khách hàng mới</h3>
                    <p style="font-size:2rem; font-weight:bold; color:#2d3e50;">8</p>
                </div>
            </div>
        </div>

        <!-- Revenue Chart -->
    <div class="payment-section">
            <h3>Biểu đồ doanh thu</h3>
            <canvas id="revenueChart" height="100"></canvas>
            <div style="margin-top:16px;">
                <button class="btn" onclick="updateChart('day')">Ngày</button>
                <button class="btn" onclick="updateChart('month')">Tháng</button>
                <button class="btn" onclick="updateChart('year')">Năm</button>
            </div>
        </div>

        <!-- Important Notifications -->
    <div class="support-section">
            <h3>Thông báo quan trọng</h3>
            <ul style="padding-left:18px;">
                <li style="color:#e53935; font-weight:bold;">Phòng A101 sắp hết chỗ!</li>
                <li style="color:#fbc02d; font-weight:bold;">3 đơn đặt phòng chưa xác nhận.</li>
                <li style="color:#e53935; font-weight:bold;">Giao dịch #12345 lỗi thanh toán.</li>
            </ul>
        </div>

        <!-- Recent Activities -->
        <div class="account-section">
            <h3>Hoạt động gần đây</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Hoạt động</th>
                        <th>Người dùng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>08:30</td>
                        <td>Đặt phòng mới</td>
                        <td>Nguyễn Văn A</td>
                    </tr>
                    <tr>
                        <td>09:10</td>
                        <td>Đăng ký tài khoản</td>
                        <td>Trần Thị B</td>
                    </tr>
                    <tr>
                        <td>09:30</td>
                        <td>Bình luận mới</td>
                        <td>Lê Văn C</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Popup Thêm Booking -->
<div id="addBookingModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('addBookingModal').style.display='none'">&times;</span>
        <h2>Thêm Booking mới</h2>
        <form>
            <label for="customer">Khách hàng:</label>
            <input type="text" id="customer" name="customer" required>
            <label for="homestay">Homestay:</label>
            <input type="text" id="homestay" name="homestay" required>
            <label for="date">Ngày đặt:</label>
            <input type="date" id="date" name="date" required>
            <label for="status">Trạng thái:</label>
            <select id="status" name="status">
                <option>Chờ xác nhận</option>
                <option>Đã xác nhận</option>
            </select>
            <button type="submit" class="btn">Lưu</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../../js/js1.js"></script>
<script>
// Đóng popup khi click ra ngoài
window.onclick = function(event) {
    var modal = document.getElementById('addBookingModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>