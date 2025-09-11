<?php
// Nếu cần xử lý backend, thêm code tại đây
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Thanh toán</title>
    <link rel="stylesheet" href="../Css/style.css">
</head>
<body>
    <div class="payment-header">Quản lý Thanh toán</div>
    <div class="payment-list">
        <table>
            <tr>
                <th>Khách hàng</th>
                <th>Homestay/Khách sạn</th>
                <th>Ngày đặt</th>
                <th>Giá trị</th>
                <th>Phương thức</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
            <!-- Dữ liệu thanh toán sẽ được render tại đây -->
            <tr>
                <td>Nguyễn Văn C</td>
                <td>Great Victoria Hotel</td>
                <td>20/09/2025</td>
                <td>3.224.799 đ</td>
                <td>Chuyển khoản</td>
                <td>Đã thanh toán</td>
                <td class="payment-action">
                    <button>Xem</button>
                    <button>Xóa</button>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
