<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a>Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a>Quản lí đơn đặt phòng</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active">Thêm đơn đặt phòng mới</a>
            </li>
        </ul>
    </div>
</div>
<div class="management-container">
    <div class="toolbar">
        <a href="home.php?page=homestay" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
    </div>
        <h2>Thêm Đơn Đặt phòng Mới</h2>
        <form action="add_homestay.php" method="POST" enctype="multipart/form-data">
            <div class="form-section">
                <h3>Thông tin cơ bản về đơn đặt phòng</h3>
                <div class="form-group">
                    <label for="madondatphong">Mã đơn đặt phòng:</label>
                    <input type="text" id="madondatphong" name="madondatphong" required>
                </div>
                <div class="form-group">
                    <label for="makhachhang">Mã Khách hàng:</label>
                    <input type="text" id="makhachhang" name="makhachhang" required>
                </div>
                <div class="form-group">
                    <label for="mahomestay">Mã homestay:</label>
                    <input type="text" id="mahomestay" name="mahomestay" required>
                </div>
                <div class="form-group">
                    <label for="maphong">Mã phòng:</label>
                    <input type="text" id="maphong" name="maphong" required>
                </div>
                <div class="form-group">
                    <label for="ngaydatphong">Ngày đặt phòng</label>
                    <input type="date" id="ngaydatphong" name="ngaydatphong" required>
                </div>
                <div class="form-group">
                    <label for="trangthai">Trạng thái:</label>
                    <select id="trangthai" name="trangthai">
                        <option value="danghoatdong">Đã xác nhận</option>
                        <option value="dung">Tạm dừng</option>
                        <option value="choduyet">Chờ duyệt</option>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h3>Thông tin khách hàng đặt phòng</h3>
                <div class="form-group">
                    <label for="tenkhachhang">Tên Khách hàng:</label>
                    <input type="text" id="tenkhachhang" name="tenkhachhang" required>
                </div>
                <div class="form-group">
                    <label for="ngaynhanphong">Ngày nhận phòng:</label>
                    <input type="date" id="ngaynhanphong" name="ngaynhanphong" required>
                </div>
                <div class="form-group">
                    <label for="ngaytraphong">Ngày trả phòng:</label>
                    <input type="date" id="ngaytraphong" name="ngaytraphong" required>
                </div>
                <div class="form-group">
                    <label for="songuoi">Số người:</label>
                    <input type="number" id="songuoi" name="songuoi" required></input>
                </div>
                <div class="form-group">
                    <label for="tongtien">Tống số tiền(VNĐ):</label>
                    <input type="number" id="tongtien" name="tongtien" required>
                </div>
                <div class="form-group">
                    <label for="chuthich">Chú thích:</label>
                    <input type="text" id="chuthich" name="chuthich" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="add-btn">Thêm đơn đặt phòng</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
</div>