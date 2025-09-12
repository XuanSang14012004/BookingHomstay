
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý phòng</title>
    <link rel="stylesheet" href="../../css/style_admin.css">
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
            <li><a href="manage_rooms.php" class="active"> Quản lý phòng</a></li>
            <li><a href="manage_payment.php"> Quản lý thanh toán</a></li>
            <li><a href="manage_feedback.php"> Phản hồi đánh giá</a></li>
            <li><a href="support.php"> Hỗ trợ khách hàng</a></li>
            <li><a href="../Login/logout.php"> Đăng xuất</a></li>
        </ul>
    </div>
    <div class="section">
        <div class="header">
            <h1>Quản lý phòng</h1>
            <button class="btn" onclick="showAddRoomForm()">Thêm phòng</button>
        </div>
        <div class="rooms-section">
            <table class="room-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên phòng</th>
                        <th>Giá (VNĐ)</th>
                        <th>Số lượng trống</th>
                        <th>Số lượng đã thuê</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="roomTableBody">
                    <tr>
                        <td>101</td>
                        <td>Phòng A101</td>
                        <td>800,000</td>
                        <td>2</td>
                        <td>3</td>
                        <td>
                            <button class="btn" onclick="showEditRoomForm(101)">Sửa</button>
                            <button class="btn" onclick="deleteRoom(101)">Xóa</button>
                        </td>
                    </tr>
                    <tr>
                        <td>102</td>
                        <td>Phòng B102</td>
                        <td>650,000</td>
                        <td>1</td>
                        <td>4</td>
                        <td>
                            <button class="btn" onclick="showEditRoomForm(102)">Sửa</button>
                            <button class="btn" onclick="deleteRoom(102)">Xóa</button>
                        </td>
                    </tr>
                    <!-- Thêm các dòng phòng khác tại đây -->
                </tbody>
            </table>
        </div>
        <!-- Form thêm/sửa phòng -->
        <div id="roomForm" class="room-form" style="display:none;">
            <h3 id="formTitle">Thêm phòng</h3>
            <form id="formRoom" onsubmit="saveRoom(event)">
                <input type="hidden" id="roomId">
                <label>Tên phòng</label>
                <input type="text" id="roomName" required>
                <label>Giá (VNĐ)</label>
                <input type="number" id="roomPrice" required>
                <label>Số lượng trống</label>
                <input type="number" id="roomAvailable" required>
                <label>Số lượng đã thuê</label>
                <input type="number" id="roomRented" required>
                <button type="submit" class="btn">Lưu</button>
                <button type="button" class="btn" onclick="hideRoomForm()">Hủy</button>
            </form>
        </div>
    </div>
</body>
</html>
    <script src="../../js/js2.js"></script>
