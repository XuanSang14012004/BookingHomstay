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
                <a>Quản lí thông tin tài khoản</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active">Thông tin chi tiết tài khoản</a>
            </li>
        </ul>
    </div>
</div>
<div class="management-container">
    <div class="toolbar">
        <a href="home.php?page=account" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        <div class="action-buttons">
            <a href="home.php?page=update_account&id=<?php echo $email; ?>" class="edit-btn" edit-page="update_account" account-id="<?php echo $email; ?>"><i class='bx bx-edit-alt'></i> Sửa thông tin</a>
            <a href="#" class="delete-btn"><i class='bx bx-trash'></i> Xóa thông tin</a>
        </div>
    </div>
    
    <h2>Chi tiết thông tin tài khoản</h2>

    <div class="detail-grid">
        <div class="detail-section">
            <h3>Thông tin cá nhân</h3>
            <div class="info-group">
                <label for="fullname">Họ và tên:</label>
                <p><?php echo $account['fullname']; ?></p>
            </div>
            <div class="info-group">
                <label for="email">Email:</label>
                <p><?php echo $account['email']; ?></p>
            </div>
            <div class="info-group">
                <label for="phone">Số điện thoại:</label>
                <p><?php echo $account['phone']; ?></p>
            </div>
            <div class="info-group">
                <label for="password">Mật khẩu:</label>
                <p><?php echo $account['password']; ?></p>
            </div>
            <div class="info-group">
                <label for="role">Phân quyền:</label>
                <p><?php echo $account['role']; ?></p>
            </div>
        </div>
    </div>
</div>
<?php } else {
    echo "<p>Không tìm thấy thông tin homestay.</p>";
} ?>