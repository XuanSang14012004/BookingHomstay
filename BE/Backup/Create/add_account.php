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
                <a class="active">Thêm tài khoản mới</a>
            </li>
        </ul>
    </div>
</div>
<div class="management-container">
    <div class="toolbar">
        <a href="home.php?page=account" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
    </div>
    <h2>Thêm Tài Khoản Mới</h2>
    <form action="../modules/Create/add_function.php" method="POST">
        <div class="form-section">
            <h3>Thông tin cá nhân</h3>
            <div class="form-group">
                <label for="fullname">Họ và tên:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="text" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Phân quyền:</label>
                <input type="text" id="role" name="role" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" name="submit_account" class="add-btn">Thêm tài khoản</button>
            <button type="reset" class="cancel-btn">Hủy</button>
        </div>
    </form>
</div>
