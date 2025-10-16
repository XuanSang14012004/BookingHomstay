<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hỗ trợ khách hàng</title>
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
        <li><a href="rooms.php">Quản lý phòng</a></li>
        <li><a href="payment.php">Quản lý thanh toán</a></li>
        <li><a href="review.php">Phản hồi đánh giá</a></li>
        <li><a href="support.php" class="active">Hỗ trợ khách hàng</a></li>
        <li><a href="login.html">Đăng xuất</a></li>
    </ul>
</div>

<div class="main">
    <div class="header">
        <h1>Hỗ trợ khách hàng</h1>
        <button class="btn" onclick="showAddSupportForm()">Thêm yêu cầu hỗ trợ</button>
    </div>

    <div class="table-container">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Email</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Ngày gửi</th>
                    <th>Trạng thái</th>
                    <th>Phản hồi của admin</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $result = $conn->query("SELECT * FROM support ORDER BY id DESC");
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['customerName']."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td>".$row['titel']."</td>";
                    echo "<td>".$row['content']."</td>";
                    echo "<td>".$row['dateSupport']."</td>";
                    echo "<td>".$row['statusSupport']."</td>";
                    echo "<td>".$row['feedbacksp']."</td>";
                    echo "<td>
                        <button class='btn' onclick='showReplySupportForm(".$row['id'].")'>Phản hồi</button>
                        <button class='btn' onclick='deleteSupport(".$row['id'].")'>Xóa</button>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Chưa có yêu cầu hỗ trợ nào</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Form thêm/sửa -->
    <div id="supportForm" style="display:none; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-top:20px;">
        <h3 id="formTitle">Thêm yêu cầu hỗ trợ</h3>
        <form id="formSupport" onsubmit="saveSupport(event)">
            <input type="hidden" id="supportId">
            <div class="mb-3">
                <label>Khách hàng</label>
                <input type="text" class="form-control" id="supportCustomer" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" id="supportEmail" required>
            </div>
            <div class="mb-3">
                <label>Tiêu đề</label>
                <input type="text" class="form-control" id="supportTitle" required>
            </div>
            <div class="mb-3">
                <label>Nội dung</label>
                <textarea class="form-control" id="supportContent" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn">Gửi yêu cầu</button>
            <button type="button" class="btn" onclick="hideSupportForm()">Hủy</button>
        </form>
    </div>

    <!-- Form phản hồi -->
    <div id="replySupportForm" style="display:none; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-top:20px;">
        <h3 id="replySupportTitle">Phản hồi yêu cầu hỗ trợ</h3>
        <form id="formReplySupport" onsubmit="saveReplySupport(event)">
            <input type="hidden" id="replySupportId">
            <div class="mb-3">
                <label>Nội dung phản hồi</label>
                <textarea class="form-control" id="replySupportContent" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn">Gửi phản hồi</button>
            <button type="button" class="btn" onclick="hideReplySupportForm()">Hủy</button>
        </form>
    </div>
</div>

<script>
function showAddSupportForm() {
    document.getElementById('formTitle').innerText = 'Thêm yêu cầu hỗ trợ';
    document.getElementById('supportForm').style.display = 'block';
    document.getElementById('formSupport').reset();
    document.getElementById('supportId').value = '';
}
function hideSupportForm() {
    document.getElementById('supportForm').style.display = 'none';
}
function showReplySupportForm(id) {
    document.getElementById('replySupportTitle').innerText = 'Phản hồi yêu cầu #' + id;
    document.getElementById('replySupportForm').style.display = 'block';
    document.getElementById('formReplySupport').reset();
    document.getElementById('replySupportId').value = id;

    fetch('support_action.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('replySupportContent').value = data.feedbacksp || '';
    });
}
function hideReplySupportForm() {
    document.getElementById('replySupportForm').style.display = 'none';
}

function saveSupport(event){
    event.preventDefault();
    var formData = new FormData();
    formData.append('action','save');
    formData.append('id', document.getElementById('supportId').value);
    formData.append('customerName', document.getElementById('supportCustomer').value);
    formData.append('email', document.getElementById('supportEmail').value);
    formData.append('titel', document.getElementById('supportTitle').value);
    formData.append('content', document.getElementById('supportContent').value);

    fetch('support_action.php',{
        method:'POST',
        body: formData
    })
    .then(res=>res.text())
    .then(data=>{
        if(data.trim()=='success'){
            alert('Lưu thành công!');
            location.reload();
        } else {
            alert('Lỗi: '+data);
        }
    });
}

function saveReplySupport(event){
    event.preventDefault();
    var formData = new FormData();
    formData.append('action','reply');
    formData.append('id', document.getElementById('replySupportId').value);
    formData.append('feedbacksp', document.getElementById('replySupportContent').value);

    fetch('support_action.php',{
        method:'POST',
        body: formData
    })
    .then(res=>res.text())
    .then(data=>{
        if(data.trim()=='success'){
            alert('Đã phản hồi!');
            location.reload();
        } else {
            alert('Lỗi: '+data);
        }
    });
}

function deleteSupport(id){
    if(confirm('Bạn có chắc muốn xóa yêu cầu hỗ trợ #' + id + '?')){
        var formData = new FormData();
        formData.append('action','delete');
        formData.append('id', id);

        fetch('support_action.php',{
            method:'POST',
            body: formData
        })
        .then(res=>res.text())
        .then(data=>{
            if(data.trim()=='success'){
                alert('Đã xóa!');
                location.reload();
            } else {
                alert('Lỗi: '+data);
            }
        });
    }
}
</script>
</body>
</html>
