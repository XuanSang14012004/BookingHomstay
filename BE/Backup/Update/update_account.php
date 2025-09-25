<?php 
$email = isset($_GET['id']) ? $_GET['id'] : null;

$result = $conn->query("SELECT * FROM db_account WHERE email = '$email' ");
if ($account = mysqli_fetch_assoc($result)) { ?>
<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a>Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a>Quản lí homestay</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active">Cập nhật thông tin tài khoản</a>
            </li>
        </ul>
    </div>
</div>
<div class="management-container">
    <div class="toolbar">
        <a href="home.php?page=account" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        <div class="action-buttons">
            <a href="home.php?page=detail_account&id=<?php echo $email; ?>" class="detail-btn" edit-page="update_account" homestay-id="<?php echo $email; ?>"><i class='bx bx-detail'></i> Xem thông tin</a>
            <a href="#" class="delete-btn"><i class='bx bx-trash'></i> Xóa thông tin</a>
        </div>
    </div>
    <h2>Sửa Thông Tin Tài Khoản</h2>
    <form action="../../modules/Update/update_function.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="email" value="<?php echo $account['email']; ?>">

        <div class="form-section">
            <h3>Thông tin cá nhân</h3>
            <div class="form-group">
                <label for="fullname">Họ và tên:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo $account['fullname']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $account['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo $account['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="text" id="password" name="password" value="<?php echo $account['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Phân quyền:</label>
                <input type="text" id="role" name="role" value="<?php echo $account['role']; ?>" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="add-btn">Cập nhật thông tin</button>
            <button type="reset" class="cancel-btn">Hủy</button>
        </div>
    </form>
</div>
<?php 
}else {
    echo "Không tìm thấy dữ liệu homestay.";
    exit();
} ?>