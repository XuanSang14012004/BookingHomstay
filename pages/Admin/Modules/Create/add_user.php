<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a>Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a>Quản lí thông tin Khách hàng</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active">Thêm Khách hàng mới</a>
            </li>
        </ul>
    </div>
</div>
<div class="management-container form-container">
    <div class="toolbar">
        <a href="home.php?page=user" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
    </div>
    <h2>Thêm Khách Hàng Mới</h2>
    <form action="process_add_khachhang.php" method="POST">
        <div class="form-section">
            <h3>Thông tin cá nhân</h3>
            <div class="form-group">
                <label for="makhachhang">Mã Khách hàng:</label>
                <input type="text" id="tenkhachhang" name="tenkhachhang" required>
            </div>
            <div class="form-group">
                <label for="tenkhachhang">Họ và Tên:</label>
                <input type="text" id="tenkhachhang" name="tenkhachhang" required>
            </div>
            <div class="form-group">
                <label for="ngaysinh">Ngày sinh:</label>
                <input type="date" id="ngaysinh" name="ngaysinh" required>
            </div>
            <div class="form-group">
                <label for="gioitinh">Giới tính :</label>
                <select id="gioitinh" name="gioitinh" required>
                    <option value="nam">Nam</option>
                    <option value="nu">Nữ</option>
                    <option value="khac">Khác</option>
                </select>
            </div>
        </div>
        <div class="form-section">
            <h3>Thông tin liên hệ </h3>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="sodienthoai">Số điện thoại:</label>
                <input type="tel" id="sodienthoai" name="sodienthoai" required>
            </div>
            <div class="form-group">
                <label for="diachi">Địa chỉ :</label>
                <textarea id="diachi" name="diachi" rows="3" required></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="add-btn">Thêm Khách Hàng</button>
            <button type="reset" class="cancel-btn">Hủy</button>
        </div>
    </form>
</div>
