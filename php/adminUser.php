<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người dùng</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="sidebar">
    <h2>HomeStay</h2>
    <ul>
        <li><a href="admin.php">ADMIN</a></li>
        <li><a href="adminDashboard.php">Dashboard</a></li>
        <li><a href="adminBooking.php">Quản lý Booking</a></li>
        <li><a href="adminUser.php" class="active">Quản lý Người dùng</a></li>
        <li><a href="rooms.php">Quản lý phòng</a></li>
        <li><a href="payment.php">Quản lý thanh toán</a></li>
        <li><a href="review.php">Phản hồi đánh giá</a></li>
        <li><a href="support.php">Hỗ trợ khách hàng</a></li>
        <li><a href="login.html">Đăng xuất</a></li>
    </ul>
</div>

<div class="main">
    <div class="header">
        <h1>Quản lý Người dùng</h1>
        <button class="btn" onclick="showAddUserForm()">Thêm Người dùng</button>
    </div>

    <div class="table-container">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Tên</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT id, username, name, role FROM users ORDER BY id DESC";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['username']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['role']."</td>";
                    echo "<td>
                        <button class='btn' onclick='showEditUserForm(".$row['id'].")'>Sửa</button>
                        <button class='btn' onclick='deleteUser(".$row['id'].")'>Xóa</button>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Chưa có người dùng nào</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Form thêm/sửa người dùng -->
    <div id="userForm" style="display:none; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-top:20px;">
        <h3 id="formTitle">Thêm Người dùng</h3>
        <form id="formUser" onsubmit="saveUser(event)">
            <input type="hidden" id="userId">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" class="form-control" id="userUsername" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control" id="userPassword" required>
            </div>
            <div class="mb-3">
                <label>Tên Người dùng</label>
                <input type="text" class="form-control" id="userName" required>
            </div>
            <div class="mb-3">
                <label>Vai trò</label>
                <select class="form-control" id="userRole" required>
                    <option value="Admin">Admin</option>
                    <option value="Khách hàng">Khách hàng</option>
                </select>
            </div>

            <button type="submit" class="btn">Lưu</button>
            <button type="button" class="btn" onclick="hideUserForm()">Hủy</button>
        </form>
    </div>
</div>

<script>
function showAddUserForm(){
    document.getElementById('formTitle').innerText = 'Thêm Người dùng';
    document.getElementById('userForm').style.display = 'block';
    document.getElementById('formUser').reset();
    document.getElementById('userId').value = '';
}

function showEditUserForm(id){
    document.getElementById('formTitle').innerText = 'Sửa Người dùng #' + id;
    document.getElementById('userForm').style.display = 'block';

    fetch("admin_user_action.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('userId').value = data.id;
        document.getElementById('userUsername').value = data.username;
        document.getElementById('userName').value = data.name;
        document.getElementById('userRole').value = data.role;
        document.getElementById('userPassword').value = ''; // không hiển thị password cũ
    });
}

function hideUserForm(){
    document.getElementById('userForm').style.display = 'none';
}

function saveUser(event){
    event.preventDefault();
    var formData = new FormData();
    formData.append("action","save");
    formData.append("id", document.getElementById('userId').value);
    formData.append("username", document.getElementById('userUsername').value);
    formData.append("password", document.getElementById('userPassword').value);
    formData.append("name", document.getElementById('userName').value);
    formData.append("role", document.getElementById('userRole').value);


    fetch("admin_user_action.php",{
        method:"POST",
        body: formData
    })
    .then(res=>res.text())
    .then(data=>{
        if(data.trim() === "success"){
            alert("Lưu thành công!");
            location.reload();
        }else{
            alert("Lỗi: "+data);
        }
    });
}

function deleteUser(id){
    if(confirm("Bạn có chắc muốn xóa người dùng #" + id + "?")){
        var formData = new FormData();
        formData.append("action","delete");
        formData.append("id", id);

        fetch("admin_user_action.php",{
            method:"POST",
            body: formData
        })
        .then(res=>res.text())
        .then(data=>{
            if(data.trim() === "success"){
                alert("Đã xóa!");
                location.reload();
            }else{
                alert("Lỗi: "+data);
            }
        });
    }
}
</script>
</body>
</html>
