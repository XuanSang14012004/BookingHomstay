<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a>Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a>Quản lí Phòng</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active">Thêm Thông tin phòng mới</a>
            </li>
        </ul>
    </div>
</div>
<div class="management-container form-container">
    <div class="toolbar">
        <a href="home.php?page=rooms" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
    </div>
    <h2>Thêm Phòng Mới</h2>
    <form action="process_add_phong.php" method="POST" enctype="multipart/form-data">
        <div class="form-section">
            <h3>Thông tin phòng</h3>
            <div class="form-group">
                <label for="homestay_id">Thuộc Homestay:</label>
                <select id="homestay_id" name="homestay_id" required>
                    <option value="1">Homestay Vọng Nguyệt</option>
                    <option value="2">Nhà Của Gió</option>
                    <option value="3">Biệt Thự Đồi</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tenphong">Tên Phòng:</label>
                <input type="text" id="tenphong" name="tenphong" required>
            </div>
            <div class="form-group">
                <label for="soguoitoiida">Số người tối đa:</label>
                <input type="number" id="soguoitoiida" name="soguoitoiida" min="1" required>
            </div>
            <div class="form-group">
                <label for="giathuephong">Giá thuê (VNĐ/đêm):</label>
                <input type="number" id="giathuephong" name="giathuephong" required>
            </div>
            <div class="form-group">
                <label for="mota">Mô tả phòng:</label>
                <textarea id="mota" name="mota" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="hinhanhphong">Hình ảnh:</label>
                <input type="file" id="hinhanhphong" name="hinhanhphong[]" multiple accept="image/*">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="add-btn">Thêm Phòng</button>
            <button type="reset" class="cancel-btn">Hủy</button>
        </div>
    </form>
</div>