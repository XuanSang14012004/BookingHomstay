<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Css/test.css">
    <title>add_homestay</title>
</head>

<body>
    <div class="form-container">
        <h2>Thêm Homestay Mới</h2>
        <form action="add_homestay.php" method="POST" enctype="multipart/form-data">
            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="tenhomestay">Tên Homestay:</label>
                    <input type="text" id="tenhomestay" name="tenhomestay" required>
                </div>
                <div class="form-group">
                    <label for="loaihinh">Loại hình:</label>
                    <select id="loaihinh" name="loaihinh">
                        <option value="homestay">Homestay</option>
                        <option value="villa">Villa</option>
                        <option value="canho">Căn hộ dịch vụ</option>
                        <option value="khac">Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="trangthai">Trạng thái hoạt động:</label>
                    <select id="trangthai" name="trangthai">
                        <option value="danghoatdong">Đang hoạt động</option>
                        <option value="dung">Tạm dừng</option>
                        <option value="choduyet">Chờ duyệt</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sophong">Số phòng:</label>
                    <input type="number" id="sophong" name="sophong" min="1" required>
                </div>
                <div class="form-group">
                    <label for="giathue">Giá thuê trung bình (VNĐ/đêm):</label>
                    <input type="number" id="giathue" name="giathue" required>
                </div>
            </div>

            <div class="form-section">
                <h3>Thông tin liên hệ & Địa chỉ</h3>
                <div class="form-group">
                    <label for="sodienthoai">Số điện thoại:</label>
                    <input type="tel" id="sodienthoai" name="sodienthoai" required>
                </div>
                <div class="form-group">
                    <label for="email">Email liên hệ:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="diachi">Địa chỉ:</label>
                    <textarea id="diachi" name="diachi" rows="3" required></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>Chi tiết & Mô tả</h3>
                <div class="form-group">
                    <label for="mota">Mô tả:</label>
                    <textarea id="mota" name="mota" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="tiennghi">Tiện nghi:</label>
                    <textarea id="tiennghi" name="tiennghi" rows="3"
                        placeholder="Ví dụ: Wifi, Bếp nấu ăn, Bãi đỗ xe..."></textarea>
                </div>
                <div class="form-group">
                    <label for="chinhsach">Chính sách:</label>
                    <textarea id="chinhsach" name="chinhsach" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="hinhanh">Hình ảnh:</label>
                    <input type="file" id="hinhanh" name="hinhanh[]" multiple accept="image/*">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="add-btn">Thêm Homestay</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</body>

</html>