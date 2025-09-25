<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Homestay</title>
    <link rel="stylesheet" href=" ../style.css">
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
            <h1>Quản lý Homestay</h1>
            <button class="btn" onclick="showAddHomestayForm()">Thêm Homestay</button>
        </div>

        <div class="table-container">
            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Homestay</th>
                        <th>Loại phòng</th>
                        <th>Số phòng</th>
                        <th>Tình trạng</th>
                        <th>Giá (VNĐ)</th>
                        <th>Hình ảnh</th>
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM admin";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['nameHomestay']."</td>";
                            echo "<td>".$row['typeRooms']."</td>";
                            echo "<td>".$row['numberRooms']."</td>";
                            echo "<td>".$row['status']."</td>";
                            echo "<td>".number_format($row['prices'])."</td>";
                            echo "<td><img src='../images/".$row['imgs']."' width='100'></td>";
                            echo "<td>".$row['description']."</td>";
                            echo "<td>
                                    <button class='btn' onclick='showEditHomestayForm(".$row['id'].")'>Sửa</button>
                                    <button class='btn' onclick='deleteHomestay(".$row['id'].")'>Xóa</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>Không có dữ liệu</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Form thêm/sửa Homestay -->
         <div id="homestayForm" style="display:none; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-top:20px;">
            <h3 id="formTitle">Thêm Homestay</h3>
            <form id="formHomestay" onsubmit="saveHomestay(event)">
                <input type="hidden" id="homestayId" name="id">
                <div class="mb-3">
                    <label>Tên Homestay</label>
                    <input type="text" class="form-control" id="homestayName" name="nameHomestay" required>
                </div>
                <div class="mb-3">
                    <label>Loại phòng</label>
                    <input type="text" class="form-control" id="homestayType" name="typeRooms" required>
                </div>
                <div class="mb-3">
                    <label>Số phòng</label>
                    <input type="number" class="form-control" id="homestayRooms"name="numberRooms" required>
                </div>
                <div class="mb-3">
                    <label>Tình trạng</label>
                    <input type="text" class="form-control" id="homestayStatus"name="status" required>
                </div>
                <div class="mb-3">
                    <label>Giá (VNĐ)</label>
                    <input type="text" class="form-control" id="homestayPrice" name="prices" required>
                </div>
                <div class="mb-3">
                    <label>Hình Ảnh</label>
                <input type="file" class="form-control" id="homestayImages" name="imgs" required>
                </div>
                <div class="mb-3">
                    <label>Mô tả</label>
                    <input type="text" class="form-control" id="homestayDescribe" name="description" required>
                </div>
                <button type="submit" class="btn">Lưu</button>
                <button type="button" class="btn" onclick="hideHomestayForm()">Hủy</button>
            </form>
        </div>
    </div>
    <script>
        function showAddHomestayForm() {
            document.getElementById('formTitle').innerText = 'Thêm Homestay';
            document.getElementById('homestayForm').style.display = 'block';
            document.getElementById('formHomestay').reset();
            document.getElementById('homestayId').value = '';
        }
        
     // TODO: Load dữ liệu homestay theo id để sửa 
        
        function showEditHomestayForm(id) {
    fetch("homestay_action.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('formTitle').innerText = 'Sửa Homestay #' + id;
        document.getElementById('homestayForm').style.display = 'block';
        document.getElementById('homestayId').value = data.id;
        document.getElementById('homestayName').value = data.nameHomestay;
        document.getElementById('homestayType').value = data.typeRooms;
        document.getElementById('homestayRooms').value = data.numberRooms;
        document.getElementById('homestayStatus').value = data.status;
        document.getElementById('homestayPrice').value = data.prices;
      //  document.getElementById('homestayImages').value = data.imgs;
        document.getElementById('homestayDescribe').value = data.description;
    });
}

        function hideHomestayForm() {
            document.getElementById('homestayForm').style.display = 'none';
        }
       
        // TODO: Xử lý xóa homestay ở backend
          
        function deleteHomestay(id) {
    if (confirm('Bạn có chắc muốn xóa Homestay #' + id + '?')) {
        var formData = new FormData();
        formData.append("action", "delete");
        formData.append("id", id);

        fetch("homestay_action.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if (data.trim() === "success") {
                alert("Đã xóa!");
                location.reload();
            } else {
                alert("Lỗi: " + data);
            }
        });
    }
}

        
        // TODO: Xử lý lưu homestay (thêm/sửa) ở backend
         
        function saveHomestay(event) {
         event.preventDefault();
             var formData = new FormData(document.getElementById("formHomestay"));
          formData.append("action", "save");

          fetch("homestay_action.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.text())
         .then(data => {
        if (data.trim() === "success") {
            alert("Lưu thành công!");
            location.reload();
        } else {
            alert("Có lỗi: " + data);
        }
    });
}

    </script>
</body>
</html>
