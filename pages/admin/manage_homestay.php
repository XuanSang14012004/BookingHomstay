
<?php
    include_once '../../config/connect.php';
    $sql = "SELECT * FROM db_homestay";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Homestay</title>
    <link rel="stylesheet" href="../../Css/style_admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_homestay.php" class="active">Quản lý Homestay</a></li>
            <li><a href="manage_rooms.php">Quản lý Phòng</a></li>
            <li><a href="manage_booking.php">Quản lý Đặt phòng</a></li>
            <li><a href="manage_user.php">Quản lý Người dùng</a></li>
            <li><a href="manage_payment.php">Quản lý Thanh toán</a></li>
            <li><a href="manage_feedback.php">Quản lý Feedback</a></li>
            <li><a href="support.php">Hỗ trợ</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Quản lý Homestay</h1>
            <a href="#" class="btn">Thêm Homestay</a>
        </div>
        <div class="container">
            <table class="homestay-table">
                <thead>
                    <tr>
                        <th>Mã homestay</th>
                        <th>Tên homestay</th>
                        <th>Địa chỉ</th>
                        <th>Mô tả</th>
                        <th>Hình ảnh</th>
                        <th>Tiện nghi</th>
                        <th>Mã chủ hộ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['mahomestay']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['tenhomestay']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['diachi']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['mota']) . '</td>';
                            echo '<td><img src="../../images/' . htmlspecialchars($row['hinhanh']) . '" alt="Hình ảnh"></td>';
                            echo '<td>' . htmlspecialchars($row['tiennghi']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['machuhomestay']) . '</td>';
                            echo '<td>';
                            echo '<a href="#" class="btn edit">Sửa</a> ';
                            echo '<a href="#" class="btn delete">Xóa</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8" style="text-align:center;">Không có dữ liệu</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
