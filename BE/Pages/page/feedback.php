<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_account') {
    $is_add_form = true;
} else if ($action === 'edit_account') {
    $is_edit_form = true;
} else if ($action === 'detail_account') {
    $is_detail_form = true;
} else {
    $is_view_form = true; // Trang chính

}

$email = isset($_GET['id']) ? $_GET['id'] : null;

$account = null;
if (($is_edit_form || $is_detail_form) && $email) {
    $result = $conn->query("SELECT * FROM db_account WHERE email = '$email'");
    if ($result && $result->num_rows > 0) {
        $account = mysqli_fetch_assoc($result);
    }
}
?>

<!---------------------------------- Giao diện --------------------------------->
<div class="form-container">
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Phản hồi khách hàng</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>
    <div class="management-container">
        <h2>Phản hồi Khách hàng</h2>
        <div class="toolbar">
            <button class="feedback-btn"><i class='bx bx-conversation'></i>Phản hồi Khách hàng</button>
            <div class="search-box">
                <input type="text" placeholder="Tìm kiếm phản hồi...">
                <button class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã Phản hồi</th>
                        <th>Mã Khách hàng</th>
                        <th>Tên Khác hàng</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th>Phản hồi của chủ Homestay</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $result = $conn->query("SELECT * FROM db_feedback");
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['maphanhoi'] ?></td>
                            <td><?php echo $row['makhachhang'] ?></td>
                            <td><?php echo $row['tenkhachhang'] ?></td>
                            <td><?php echo $row['tieude'] ?></td>
                            <td><?php echo $row['noidung'] ?></td>
                            <td><?php echo $row['ngaygui'] ?></td>
                            <td><?php echo $row['trangthai'] ?></td>
                            <td class="truncate-text"><?php echo $row['traloi'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" read-page="detail_feedback" feedback-id="<?php echo $row['maphanhoi'] ?>"><i class='bx bx-detail'></i></button>
                                <button class="delete-btn" title="Xóa" delete-page="delete_feedback" account-id="<?php echo $row['maphanhoi'] ?>"><i class='bx bx-trash'></i></button>
                            </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!---------------------------------- Giao diện --------------------------------->
<div class="form-container">
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Phản hồi khách hàng</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>
    <div class="management-container">
        <h2>Phản hồi Khách hàng</h2>
        <div class="toolbar">
            <button class="feedback-btn"><i class='bx bx-conversation'></i>Phản hồi Khách hàng</button>
            <div class="search-box">
                <input type="text" placeholder="Tìm kiếm phản hồi...">
                <button class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã Phản hồi</th>
                        <th>Mã Khách hàng</th>
                        <th>Tên Khác hàng</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th>Phản hồi của chủ Homestay</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $result = $conn->query("SELECT * FROM db_feedback");
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['maphanhoi'] ?></td>
                            <td><?php echo $row['makhachhang'] ?></td>
                            <td><?php echo $row['tenkhachhang'] ?></td>
                            <td><?php echo $row['tieude'] ?></td>
                            <td><?php echo $row['noidung'] ?></td>
                            <td><?php echo $row['ngaygui'] ?></td>
                            <td><?php echo $row['trangthai'] ?></td>
                            <td class="truncate-text"><?php echo $row['traloi'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" read-page="detail_feedback" feedback-id="<?php echo $row['maphanhoi'] ?>"><i class='bx bx-detail'></i></button>
                                <button class="delete-btn" title="Xóa" delete-page="delete_feedback" account-id="<?php echo $row['maphanhoi'] ?>"><i class='bx bx-trash'></i></button>
                            </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!--------------------------------------------- Phản hồi khiếu nại ---------------------------------->
<div class="form-container">
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
            <a href="home.php?page=homestay" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <a href="home.php?page=detail_homestay&id=<?php echo $mahomestay; ?>" class="detail-btn" edit-page="update_homestay" homestay-id="<?php echo $mahomestay; ?>"><i class='bx bx-detail'></i> Xem thông tin</a>
                <a href="#" class="delete-btn"><i class='bx bx-trash'></i> Xóa thông tin</a>
            </div>
        </div>
        <h2>Sửa Thông Tin Homestay</h2>
        <form action="../../modules/Update/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="mahomestay" value="<?php echo $homestay['mahomestay']; ?>">

            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="mahomestay">Mã Homestay:</label>
                    <input type="text" name="mahomestay" value="<?php echo $homestay['mahomestay']; ?>">
                </div>
                <div class="form-group">
                    <label for="tenhomestay">Tên Homestay:</label>
                    <input type="text" id="tenhomestay" name="tenhomestay" value="<?php echo $homestay['tenhomestay']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="loaihinh">Loại hình:</label>
                    <select id="loaihinh" name="loaihinh">
                        <option value="homestay" <?php echo ($homestay['loaihinh'] == 'homestay') ? 'selected' : ''; ?>>Homestay</option>
                        <option value="villa" <?php echo ($homestay['loaihinh'] == 'villa') ? 'selected' : ''; ?>>Villa</option>
                        <option value="canho" <?php echo ($homestay['loaihinh'] == 'canho') ? 'selected' : ''; ?>>Căn hộ dịch vụ</option>
                        <option value="khac" <?php echo ($homestay['loaihinh'] == 'khac') ? 'selected' : ''; ?>>Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="trangthai">Trạng thái hoạt động:</label>
                    <select id="trangthai" name="trangthai">
                        <option value="danghoatdong" <?php echo ($homestay['trangthaihoatdong'] == 'danghoatdong') ? 'selected' : ''; ?>>Đang hoạt động</option>
                        <option value="dung" <?php echo ($homestay['trangthaihoatdong'] == 'dung') ? 'selected' : ''; ?>>Tạm dừng</option>
                        <option value="choduyet" <?php echo ($homestay['trangthaihoatdong'] == 'choduyet') ? 'selected' : ''; ?>>Chờ duyệt</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sophong">Số phòng:</label>
                    <input type="number" id="sophong" name="sophong" value="<?php echo $homestay['sophong']; ?>" min="1" required>
                </div>
            </div>

            <div class="form-section">
                <h3>Thông tin liên hệ & Địa chỉ</h3>
                <div class="form-group">
                    <label for="sodienthoai">Số điện thoại:</label>
                    <input type="tel" id="sodienthoai" name="sodienthoai" value="<?php echo $homestay['sodienthoai']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email liên hệ:</label>
                    <input type="email" id="email" name="email" value="<?php echo $homestay['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="diachi">Địa chỉ:</label>
                    <textarea id="diachi" name="diachi" rows="3" required><?php echo $homestay['diachi']; ?></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>Chi tiết & Mô tả</h3>
                <div class="form-group">
                    <label for="mota">Mô tả:</label>
                    <textarea id="mota" name="mota" rows="5"><?php echo $homestay['mota']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="tiennghi">Tiện nghi:</label>
                    <textarea id="tiennghi" name="tiennghi" rows="3" placeholder="Ví dụ: Wifi, Bếp nấu ăn, Bãi đỗ xe..."><?php echo $homestay['tiennghi']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="chinhsach">Chính sách:</label>
                    <textarea id="chinhsach" name="chinhsach" rows="3"><?php echo $homestay['chinhsach']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="hinhanh">Hình ảnh hiện tại:</label>
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
</div>

<!------------------------------------------------ Chi tiết ------------------------------------------->
<div class="form-container">
        <?php 
    $maphanhoi= isset($_GET['id']) ? $_GET['id'] : null;

    $result = $conn->query("SELECT * FROM db_feedback WHERE maphanhoi = '$maphanhoi' ");
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
</div>