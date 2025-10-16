<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý phòng</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="sidebar">
    <h2>HomeStay</h2>
    <ul>
        <li><a href="admin.php">ADMIN</a></li>
        <li><a href="adminDashboard.php">Dashboard</a></li>
        <li><a href="adminBooking.php">Quản lý Booking</a></li>
        <li><a href="adminUser.php">Quản lý Người dùng</a></li>
        <li><a href="rooms.php" class="active">Quản lý phòng</a></li>
        <li><a href="payment.php">Quản lý thanh toán</a></li>
        <li><a href="review.php">Phản hồi đánh giá</a></li>
        <li><a href="support.php">Hỗ trợ khách hàng</a></li>
        <li><a href="login.html">Đăng xuất</a></li>
    </ul>
</div>

<div class="main">
    <div class="header">
        <h1>Quản lý phòng</h1>
        <button class="btn" onclick="showAddRoomForm()">Thêm phòng</button>
    </div>

    <div class="table-container">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên phòng</th>
                    <th>Giá (VNĐ)</th>
                    <th>Số lượng khách</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="roomTableBody">
            <?php
            $result = $conn->query("SELECT * FROM rooms ORDER BY id DESC");
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".number_format($row['prices'])."</td>";
                    echo "<td>".$row['quantity']."</td>";
                    echo "<td>".$row['statusRooms']."</td>";
                    echo "<td>
                        <button class='btn' onclick='showEditRoomForm(".$row['id'].")'>Sửa</button>
                        <button class='btn' onclick='deleteRoom(".$row['id'].")'>Xóa</button>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Chưa có phòng nào</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Form thêm/sửa phòng -->
    <div id="roomForm" style="display:none; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-top:20px;">
        <h3 id="formTitle">Thêm phòng</h3>
        <form id="formRoom" onsubmit="saveRoom(event)">
            <input type="hidden" id="roomId">
            <div class="mb-3">
                <label>Tên phòng</label>
                <input type="text" class="form-control" id="roomName" name="name" required>
            </div>
            <div class="mb-3">
                <label>Giá (VNĐ)</label>
                <input type="text" class="form-control" id="roomPrice" name="prices" required>
            </div>
            <div class="mb-3">
                <label>Số lượng khách</label>
                <input type="number" class="form-control" id="roomQuantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label>Trạng thái</label>
                    <select class="form-control" id="roomStatus" name="statusRooms" required>
                    <option value="Đã xác nhận">Còn trống</option>
                    <option value="Chờ xác nhận">Hết phòng</option>
                    <option value="Đã hủy">Đang bảo trì</option>
                </select>
            </div>
            <button type="submit" class="btn">Lưu</button>
            <button type="button" class="btn" onclick="hideRoomForm()">Hủy</button>
        </form>
    </div>
</div>

<script>
function showAddRoomForm() {
    document.getElementById('formTitle').innerText = 'Thêm phòng';
    document.getElementById('roomForm').style.display = 'block';
    document.getElementById('formRoom').reset();
    document.getElementById('roomId').value = '';
}

function showEditRoomForm(id) {
    document.getElementById('formTitle').innerText = 'Sửa phòng #' + id;
    document.getElementById('roomForm').style.display = 'block';

    fetch("rooms_action.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('roomId').value = data.id;
        document.getElementById('roomName').value = data.name;
        document.getElementById('roomPrice').value = data.prices;
        document.getElementById('roomQuantity').value = data.quantity;
        document.getElementById('roomStatus').value = data.statusRooms;
    });
}

function saveRoom(event){
    event.preventDefault();
    var formData = new FormData();
    formData.append("action","save");
    formData.append("id", document.getElementById('roomId').value);
    formData.append("name", document.getElementById('roomName').value);
    formData.append("prices", document.getElementById('roomPrice').value);
    formData.append("quantity", document.getElementById('roomQuantity').value);
    formData.append("statusRooms", document.getElementById('roomStatus').value);

    fetch("rooms_action.php",{
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if(data.trim() === "success"){
            alert("Lưu thành công!");
            location.reload();
        } else {
            alert("Lỗi: "+data);
        }
    });
}
function deleteRoom(id){
    if(confirm("Bạn có chắc muốn xóa phòng #" + id + "?")){
        var formData = new FormData();
        formData.append("action", "delete");
        formData.append("id", id);

        fetch("rooms_action.php", {  // thống nhất với file xử lý
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
