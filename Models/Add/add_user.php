<div class="management-container form-container">
    <h2>Thêm Khách Hàng Mới</h2>
    <form action="process_add_khachhang.php" method="POST">
        <div class="form-section">
            <h3>Thông tin cá nhân</h3>
            <div class="form-group">
                <label for="tenkhachhang">Họ và Tên:</label>
                <input type="text" id="tenkhachhang" name="tenkhachhang" required>
            </div>
            <div class="form-group">
                <label for="ngaysinh">Ngày sinh:</label>
                <input type="date" id="ngaysinh" name="ngaysinh">
            </div>
            <div class="form-group">
                <label for="gioitinh">Giới tính:</label>
                <select id="gioitinh" name="gioitinh">
                    <option value="nam">Nam</option>
                    <option value="nu">Nữ</option>
                    <option value="khac">Khác</option>
                </select>
            </div>
        </div>

        <div class="form-section">
            <h3>Thông tin liên hệ & Tài khoản</h3>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="sodienthoai">Số điện thoại:</label>
                <input type="tel" id="sodienthoai" name="sodienthoai" required>
            </div>
            <div class="form-group">
                <label for="matkhau">Mật khẩu:</label>
                <input type="password" id="matkhau" name="matkhau" required>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="add-btn">Thêm Khách Hàng</button>
            <button type="reset" class="cancel-btn">Hủy</button>
        </div>
    </form>
</div>