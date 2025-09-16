<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Booking</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="sidebar">
    <h2>HomeStay</h2>
    <ul>
        <li><a href="admin.php">ADMIN</a></li>
        <li><a href="adminDashboard.php">Dashboard</a></li>
        <li><a href="adminBooking.php" class="active">Quản lý Booking</a></li>
        <li><a href="adminUser.php">Quản lý Người dùng</a></li>
        <li><a href="rooms.php">Quản lý phòng</a></li>
        <li><a href="payment.php">Quản lý thanh toán</a></li>
        <li><a href="review.php">Phản hồi đánh giá</a></li>
        <li><a href="support.php">Hỗ trợ khách hàng</a></li>
        <li><a href="login.html">Đăng xuất</a></li>
    </ul>
</div>

<div class="main">
    <div class="header">
        <h1>Quản lý Booking</h1>
        <button class="btn" onclick="showAddBookingForm()">Thêm Booking</button>
    </div>

    <div class="table-container">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Homestay</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM booking ORDER BY id DESC";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['customerName']."</td>";
                    echo "<td>".$row['customerEmail']."</td>";
                    echo "<td>".$row['customerNumber']."</td>";
                    echo "<td>".$row['homestayName']."</td>";
                    echo "<td>".$row['bookingDate']."</td>";
                    echo "<td>".$row['bookingStatus']."</td>";
                    echo "<td>
                        <button class='btn' onclick='showEditBookingForm(".$row['id'].")'>Sửa</button>
                        <button class='btn' onclick='deleteBooking(".$row['id'].")'>Xóa</button>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Chưa có booking nào</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Form thêm/sửa booking -->
    <div id="bookingForm" style="display:none; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-top:20px;">
        <h3 id="formTitle">Thêm Booking</h3>
        <form id="formBooking" onsubmit="saveBooking(event)">
            <input type="hidden" id="bookingId">
            <div class="mb-3">
                <label>Khách hàng</label>
                <input type="text" class="form-control" id="customerName" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" id="customerEmail" required>
            </div>
            <div class="mb-3">
                <label>Số điện thoại</label>
                <input type="text" class="form-control" id="customerNumber" required>
            </div>
            <div class="mb-3">
                <label>Homestay</label>
                <input type="text" class="form-control" id="homestayName" required>
            </div>
            <div class="mb-3">
                <label>Ngày đặt</label>
                <input type="date" class="form-control" id="bookingDate" required>
            </div>
            <div class="mb-3">
                <label>Trạng thái</label>
                <select class="form-control" id="bookingStatus" required>
                    <option value="Đã xác nhận">Đã xác nhận</option>
                    <option value="Chờ xác nhận">Chờ xác nhận</option>
                    <option value="Đã hủy">Đã hủy</option>
                </select>
            </div>
            <button type="submit" class="btn">Lưu</button>
            <button type="button" class="btn" onclick="hideBookingForm()">Hủy</button>
        </form>
    </div>
</div>

<script>
function showAddBookingForm(){
    document.getElementById('formTitle').innerText = 'Thêm Booking';
    document.getElementById('bookingForm').style.display = 'block';
    document.getElementById('formBooking').reset();
    document.getElementById('bookingId').value = '';
}

function showEditBookingForm(id){
    document.getElementById('formTitle').innerText = 'Sửa Booking #' + id;
    document.getElementById('bookingForm').style.display = 'block';

    fetch("homestay_booking_action.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('bookingId').value = data.id;
        document.getElementById('customerName').value = data.customerName;
        document.getElementById('customerEmail').value = data.customerEmail;
        document.getElementById('customerNumber').value = data.customerNumber;
        document.getElementById('homestayName').value = data.homestayName;
        document.getElementById('bookingDate').value = data.bookingDate;
        document.getElementById('bookingStatus').value = data.bookingStatus;
    });
}

function hideBookingForm(){
    document.getElementById('bookingForm').style.display = 'none';
}

function saveBooking(event){
    event.preventDefault();
    var formData = new FormData();
    formData.append("action", "save");
    formData.append("id", document.getElementById('bookingId').value);
    formData.append("customerName", document.getElementById('customerName').value);
    formData.append("customerEmail", document.getElementById('customerEmail').value);
    formData.append("customerNumber", document.getElementById('customerNumber').value);
    formData.append("homestayName", document.getElementById('homestayName').value);
    formData.append("bookingDate", document.getElementById('bookingDate').value);
    formData.append("bookingStatus", document.getElementById('bookingStatus').value);

    fetch("homestay_booking_action.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if(data.trim() === "success"){
            alert("Lưu thành công!");
            location.reload();
        } else {
            alert("Lỗi: " + data);
        }
    });
}

function deleteBooking(id){
    if(confirm("Bạn có chắc muốn xóa booking #" + id + "?")){
        var formData = new FormData();
        formData.append("action", "delete");
        formData.append("id", id);

        fetch("homestay_booking_action.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if(data.trim() === "success"){
                alert("Đã xóa!");
                location.reload();
            } else {
                alert("Lỗi: " + data);
            }
        });
    }
}
</script>

</body>
</html>
