<?php 
$mahomestay = isset($_GET['id']) ? $_GET['id'] : null;

$result = $conn->query("SELECT * FROM db_homestay WHERE mahomestay = '$mahomestay' ");
if ($homestay = mysqli_fetch_assoc($result)) { ?>
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
                <a class="active">Cập nhật thông tin Homestay</a>
            </li>
        </ul>
    </div>
</div>
<div class="management-container">
    <div class="toolbar">
        <a href="home.php?page=homestay&id="$homestay class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        <div class="action-buttons">
            <a href="home.php?page=detail_homestay&id=<?php echo $mahomestay; ?>" class="detail-btn" edit-page="update_homestay" homestay-id="<?php echo $mahomestay; ?>"><i class='bx bx-detail'></i> Xem thông tin</a>
            <a href="#" class="delete-btn"><i class='bx bx-trash'></i> Xóa thông tin</a>
        </div>
    </div>
    <h2>Sửa Thông Tin Homestay</h2>
    <form action="update_homestay.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="mahomestay" value="<?php echo $homestay['mahomestay']; ?>">

        <div class="form-section">
            <h3>Thông tin cơ bản</h3>
            <div class="form-group">
                <label for="tenhomestay">Tên Homestay :</label>
                <input type="text" id="tenhomestay" name="tenhomestay" value="<?php echo $homestay['tenhomestay']; ?>" required>
            </div>
            <div class="form-group">
                <label for="loaihinh">Loại hình :</label>
                <select id="loaihinh" name="loaihinh">
                    <option value="homestay" <?php echo ($homestay['loaihinh'] == 'homestay') ? 'selected' : ''; ?>>Homestay</option>
                    <option value="villa" <?php echo ($homestay['loaihinh'] == 'villa') ? 'selected' : ''; ?>>Villa</option>
                    <option value="canho" <?php echo ($homestay['loaihinh'] == 'canho') ? 'selected' : ''; ?>>Căn hộ dịch vụ</option>
                    <option value="khac" <?php echo ($homestay['loaihinh'] == 'khac') ? 'selected' : ''; ?>>Khác</option>
                </select>
            </div>
            <div class="form-group">
                <label for="trangthai">Trạng thái hoạt động :</label>
                <select id="trangthai" name="trangthai">
                    <option value="danghoatdong" <?php echo ($homestay['trangthaihoatdong'] == 'danghoatdong') ? 'selected' : ''; ?>>Đang hoạt động</option>
                    <option value="dung" <?php echo ($homestay['trangthaihoatdong'] == 'dung') ? 'selected' : ''; ?>>Tạm dừng</option>
                    <option value="choduyet" <?php echo ($homestay['trangthaihoatdong'] == 'choduyet') ? 'selected' : ''; ?>>Chờ duyệt</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sophong">Số phòng :</label>
                <input type="number" id="sophong" name="sophong" value="<?php echo $homestay['sophong']; ?>" min="1" required>
            </div>
            <div class="form-group">
                <label for="giathue">Giá thuê trung bình (VNĐ/đêm) :</label>
                <input type="number" id="giathue" name="giathue" value="<?php echo $homestay['giathue']; ?>" required>
            </div>
        </div>

        <div class="form-section">
            <h3>Thông tin liên hệ & Địa chỉ</h3>
            <div class="form-group">
                <label for="sodienthoai">Số điện thoại :</label>
                <input type="tel" id="sodienthoai" name="sodienthoai" value="<?php echo $homestay['sodienthoai']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email liên hệ :</label>
                <input type="email" id="email" name="email" value="<?php echo $homestay['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="diachi">Địa chỉ :</label>
                <textarea id="diachi" name="diachi" rows="3" required><?php echo $homestay['diachi']; ?></textarea>
            </div>
        </div>

        <div class="form-section">
            <h3>Chi tiết & Mô tả</h3>
            <div class="form-group">
                <label for="mota">Mô tả :</label>
                <textarea id="mota" name="mota" rows="5"><?php echo $homestay['mota']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="tiennghi">Tiện nghi :</label>
                <textarea id="tiennghi" name="tiennghi" rows="3" placeholder="Ví dụ: Wifi, Bếp nấu ăn, Bãi đỗ xe..."><?php echo $homestay['tiennghi']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="chinhsach">Chính sách :</label>
                <textarea id="chinhsach" name="chinhsach" rows="3"><?php echo $homestay['chinhsach']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="hinhanh">Hình ảnh hiện tại :</label>
                <img src="<?php echo $homestay['hinhanh']; ?>" alt="Hình ảnh homestay" style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                <label for="hinhanh_new">Chọn ảnh mới để thay thế :</label>
                <input type="file" id="hinhanh_new" name="hinhanh_new[]" multiple accept="image/*">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="add-btn">Cập Nhật Homestay</button>
            <button type="reset" class="cancel-btn">Hủy</button>
        </div>
    </form>
</div>
<?php 
}else {
    echo "Không tìm thấy dữ liệu homestay.";
    exit();
} ?>