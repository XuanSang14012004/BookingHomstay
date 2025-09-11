
<?php
// Kết nối database
$conn = new mysqli("localhost", "root", "", "homestay_db");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu booking
$sql = "SELECT b.id, u.name AS customer, h.name AS homestay, b.date, b.status
        FROM booking b
        JOIN users u ON b.user_id = u.id
        JOIN homestay h ON b.homestay_id = h.id
        ORDER BY b.date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin</title>
</head>
<body>
    <div class="sidebar">
        <h2>BookingHomeStay</h2>
        <ul>
           <li><a href="adminDashboard.html"> Dashboard</a></li>
            <li><a href="adminBooking.html"> Quản lý Booking</a></li>
             <li><a href="adminHomestay.html"> Quản lý Homestay</a></li>
            <li><a href="adminUser.html"> Quản lý Người dùng</a></li>
            <li><a href="index.html"> Đăng xuất</a></li>
        </ul>
    </div>
    <div class="main">
        <div class="header">
            <h1>Quản lý Booking Homestay</h1>
            <button class="btn">Thêm Booking</button>
        </div>
        <div class="table-container">
            <table>
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
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['customer'] ?></td>
                                <td><?= $row['homestay'] ?></td>
                                <td><?= $row['date'] ?></td>
                                <td><?= $row['status'] ?></td>
                                <td>
                                    <button class="btn">Sửa</button>
                                    <button class="btn">Xóa</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6">Không có dữ liệu</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>