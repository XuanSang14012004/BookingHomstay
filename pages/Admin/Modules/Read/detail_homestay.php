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
                <a class="active">Thông tin chi tiết Homestay</a>
            </li>
        </ul>
    </div>
</div>
<div class="management-container">
    <div class="toolbar">
        <a href="home.php?page=homestay&id="$homestay class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        <div class="action-buttons">
            <a href="home.php?page=update_homestay&id=<?php echo $mahomestay; ?>" class="edit-btn" edit-page="update_homestay" homestay-id="<?php echo $mahomestay; ?>"><i class='bx bx-edit-alt'></i> Sửa thông tin</a>
            <a href="#" class="delete-btn"><i class='bx bx-trash'></i> Xóa thông tin</a>
        </div>
    </div>
    
    <h2>Chi tiết Homestay</h2>

    <div class="detail-grid">
        <div class="detail-section">
            <h3>Thông tin cơ bản</h3>
            <div class="info-group">
                <label>Tên Homestay:</label>
                <p>Homestay Vọng Nguyệt</p>
            </div>
            <div class="info-group">
                <label>Mã Homestay:</label>
                <p>HS-001</p>
            </div>
            <div class="info-group">
                <label>Loại hình:</label>
                <p>Homestay</p>
            </div>
            <div class="info-group">
                <label>Số phòng:</label>
                <p>5 phòng</p>
            </div>
            <div class="info-group">
                <label>Trạng thái hoạt động:</label>
                <p class="status-active">Đang hoạt động</p>
            </div>
        </div>

        <div class="detail-section">
            <h3>Mô tả & Tiện nghi</h3>
            <div class="info-group">
                <label>Mô tả:</label>
                <p>Một homestay yên bình nằm trên đỉnh đồi, bao quanh bởi rừng thông và sương mù. Không gian được thiết kế theo phong cách tối giản, tận dụng tối đa ánh sáng tự nhiên và view toàn cảnh.</p>
            </div>
            <div class="info-group">
                <label>Tiện nghi:</label>
                <ul>
                    <li>Wifi miễn phí</li>
                    <li>Bếp nấu ăn chung</li>
                    <li>Bãi đỗ xe</li>
                    <li>Vườn nướng BBQ</li>
                </ul>
            </div>
            <div class="info-group">
                <label>Chính sách:</label>
                <p>Giờ nhận phòng: 14:00. Giờ trả phòng: 12:00. Không cho phép thú cưng.</p>
            </div>
        </div>

        <div class="detail-section">
            <h3>Địa chỉ & Liên hệ</h3>
            <div class="info-group">
                <label>Địa chỉ:</label>
                <p>123 Đường Bán Nguyệt, Phường 2, Đà Lạt, Lâm Đồng</p>
            </div>
            <div class="info-group">
                <label>Số điện thoại:</label>
                <p>0987654321</p>
            </div>
            <div class="info-group">
                <label>Email liên hệ:</label>
                <p>contact@vongnguyet.vn</p>
            </div>
        </div>

        <div class="detail-section">
            <h3>Hình ảnh Homestay</h3>
            <div class="images-gallery">
                <img src="path/to/image1.jpg" alt="Hình ảnh Homestay 1">
                <img src="path/to/image2.jpg" alt="Hình ảnh Homestay 2">
                <img src="path/to/image3.jpg" alt="Hình ảnh Homestay 3">
            </div>
        </div>
    </div>
</div>
<?php } else {
    echo "<p>Không tìm thấy thông tin homestay.</p>";
} ?>