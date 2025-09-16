<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý thanh toán</title>
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
        <h1>Quản lý thanh toán</h1>
        <button class="btn" onclick="showAddPaymentForm()">Thêm thanh toán</button>
    </div>

    <div class="table-container">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Booking</th>
                    <th>Số tiền (VNĐ)</th>
                    <th>Ngày thanh toán</th>
                    <th>Phương thức</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $result = $conn->query("SELECT p.*, b.customerName FROM payments p 
                                    LEFT JOIN booking b ON p.bookingID=b.id
                                    ORDER BY p.id DESC");
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['customerName']."</td>";
                    echo "<td>".$row['bookingID']."</td>";
                    echo "<td>".number_format($row['money'])."</td>";
                    echo "<td>".$row['datesPayments']."</td>";
                    echo "<td>".$row['method']."</td>";
                    echo "<td>".$row['statusPayment']."</td>";
                    echo "<td>
                        <button class='btn' onclick='showEditPaymentForm(".$row['id'].")'>Sửa</button>
                        <button class='btn' onclick='deletePayment(".$row['id'].")'>Xóa</button>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Chưa có thanh toán nào</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Form thêm/sửa thanh toán -->
    <div id="paymentForm" style="display:none; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-top:20px;">
        <h3 id="formTitle">Thêm thanh toán</h3>
        <form id="formPayment" onsubmit="savePayment(event)">
            <input type="hidden" id="paymentId">
            <div class="mb-3">
                <label>Booking</label>
                <select class="form-control" id="paymentBooking" required onchange="updateCustomerName()">
                    <option value="">Chọn Booking</option>
                    <?php
                    $bookings = $conn->query("SELECT * FROM booking ORDER BY id DESC");
                    while($b = $bookings->fetch_assoc()){
                        echo "<option value='".$b['id']."' data-customer='".$b['customerName']."'>".$b['id']." - ".$b['customerName']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Khách hàng</label>
                <input type="text" class="form-control" id="paymentCustomer" readonly>
            </div>
            <div class="mb-3">
                <label>Số tiền (VNĐ)</label>
                <input type="number" class="form-control" id="paymentAmount" required>
            </div>
            <div class="mb-3">
                <label>Ngày thanh toán</label>
                <input type="date" class="form-control" id="paymentDate" required>
            </div>
            <div class="mb-3">
                <label>Phương thức</label>
                <select class="form-control" id="paymentMethod" required>
                    <option value="Chuyển khoản">Chuyển khoản</option>
                    <option value="Tiền mặt">Tiền mặt</option>
                    <option value="Thẻ tín dụng">Thẻ tín dụng</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Trạng thái</label>
                <select class="form-control" id="paymentStatus" required>
                    <option value="Đã thanh toán">Đã thanh toán</option>
                    <option value="Chờ xác nhận">Chờ xác nhận</option>
                    <option value="Đã hủy">Đã hủy</option>
                </select>
            </div>
            <button type="submit" class="btn">Lưu</button>
            <button type="button" class="btn" onclick="hidePaymentForm()">Hủy</button>
        </form>
    </div>
</div>

<script>
function showAddPaymentForm() {
    document.getElementById('formTitle').innerText = 'Thêm thanh toán';
    document.getElementById('paymentForm').style.display = 'block';
    document.getElementById('formPayment').reset();
    document.getElementById('paymentId').value = '';
    document.getElementById('paymentCustomer').value = '';
}

function showEditPaymentForm(id){
    document.getElementById('formTitle').innerText = 'Sửa thanh toán #' + id;
    document.getElementById('paymentForm').style.display = 'block';

    fetch("payment_action.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('paymentId').value = data.id;
        document.getElementById('paymentBooking').value = data.bookingID;
        document.getElementById('paymentCustomer').value = data.customerName;
        document.getElementById('paymentAmount').value = data.money;
        document.getElementById('paymentDate').value = data.datesPayments;
        document.getElementById('paymentMethod').value = data.method;
        document.getElementById('paymentStatus').value = data.statusPayment;
    });
}

function hidePaymentForm() {
    document.getElementById('paymentForm').style.display = 'none';
}

function updateCustomerName() {
    var bookingSelect = document.getElementById('paymentBooking');
    var selectedOption = bookingSelect.options[bookingSelect.selectedIndex];
    document.getElementById('paymentCustomer').value = selectedOption.dataset.customer;
}

function savePayment(event){
    event.preventDefault();
    var formData = new FormData();
    formData.append("action","save");
    formData.append("id", document.getElementById('paymentId').value);
    formData.append("bookingID", document.getElementById('paymentBooking').value);
    formData.append("customerName", document.getElementById('paymentCustomer').value);
    formData.append("money", document.getElementById('paymentAmount').value);
    formData.append("datesPayments", document.getElementById('paymentDate').value);
    formData.append("method", document.getElementById('paymentMethod').value);
    formData.append("statusPayment", document.getElementById('paymentStatus').value);

    fetch("payment_action.php", {
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

function deletePayment(id){
    if(confirm("Bạn có chắc muốn xóa thanh toán #" + id + "?")){
        var formData = new FormData();
        formData.append("action","delete");
        formData.append("id", id);

        fetch("payment_action.php",{
            method:"POST",
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if(data.trim() === "success"){
                alert("Đã xóa!");
                location.reload();
            } else {
                alert("Lỗi: "+data);
            }
        });
    }
}
</script>
</body>
</html>
