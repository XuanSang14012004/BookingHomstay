<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phản hồi đánh giá</title>
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
        <li><a href="review.php" class="active">Phản hồi đánh giá</a></li>
        <li><a href="support.php">Hỗ trợ khách hàng</a></li>
        <li><a href="login.html">Đăng xuất</a></li>
    </ul>
</div>

<div class="main">
    <div class="header">
        <h1>Phản hồi đánh giá từ khách hàng</h1>
    </div>

    <div class="table-container">
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Homestay</th>
                    <th>Đánh giá</th>
                    <th>Ngày gửi</th>
                    <th>Phản hồi của admin</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $result = $conn->query("SELECT * FROM review ORDER BY id DESC");
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['custommerName']."</td>";
                    echo "<td>".$row['homestayName']."</td>";
                    echo "<td>".$row['reviews']."</td>";
                    echo "<td>".$row['dateReview']."</td>";
                    echo "<td>".$row['feedback']."</td>";
                    echo "<td>
                        <button class='btn' onclick='showReplyForm(".$row['id'].")'>Phản hồi</button>
                        <button class='btn' onclick='deleteReview(".$row['id'].")'>Xóa</button>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Chưa có đánh giá nào</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Form phản hồi -->
    <div id="replyForm" style="display:none; background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-top:20px;">
        <h3 id="replyTitle">Phản hồi đánh giá</h3>
        <form id="formReply" onsubmit="saveReply(event)">
            <input type="hidden" id="reviewId">
            <div class="mb-3">
                <label>Nội dung phản hồi</label>
                <textarea class="form-control" id="replyContent" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn">Gửi phản hồi</button>
            <button type="button" class="btn" onclick="hideReplyForm()">Hủy</button>
        </form>
    </div>
</div>

<script>
function showReplyForm(id){
    document.getElementById('replyTitle').innerText = 'Phản hồi đánh giá #' + id;
    document.getElementById('replyForm').style.display = 'block';
    document.getElementById('formReply').reset();
    document.getElementById('reviewId').value = id;

    // Lấy feedback hiện tại từ server
    fetch('review_action.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('replyContent').value = data.feedback || '';
    });
}

function hideReplyForm(){
    document.getElementById('replyForm').style.display = 'none';
}

function saveReply(event){
    event.preventDefault();
    var formData = new FormData();
    formData.append('action','save');
    formData.append('id', document.getElementById('reviewId').value);
    formData.append('feedback', document.getElementById('replyContent').value);

    fetch('review_action.php',{
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if(data.trim() === 'success'){
            alert('Đã lưu phản hồi!');
            location.reload();
        } else {
            alert('Lỗi: ' + data);
        }
    });
}

function deleteReview(id){
    if(confirm('Bạn có chắc muốn xóa đánh giá #' + id + '?')){
        var formData = new FormData();
        formData.append('action','delete');
        formData.append('id', id);

        fetch('review_action.php',{
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            if(data.trim() === 'success'){
                alert('Đã xóa!');
                location.reload();
            } else {
                alert('Lỗi: ' + data);
            }
        });
    }
}
</script>
</body>
</html>
