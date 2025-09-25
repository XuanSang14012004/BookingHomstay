<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_search_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_booking') {
    $is_add_form = true;
} else if ($action === 'edit_booking') {
    $is_edit_form = true;
} else if ($action === 'search_booking') {
    $is_search_form = true;
} else if ($action === 'detail_booking') {
    $is_detail_form = true;
} else {
    $is_view_form = true; // Trang chính

}

$madatphong= isset($_GET['id']) ? $_GET['id'] : null;

$booking = null;
if (($is_edit_form || $is_detail_form) && $madatphong) {
    $result = $conn->query("SELECT * FROM db_booking WHERE madondatphong = '$madatphong'");
    if ($result && $result->num_rows > 0) {
        $booking = mysqli_fetch_assoc($result);
    }
}
?>

<!-------------------------------- Giao diện --------------------------->
<div class="form-container" id="booking-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Quản lí đơn đặt phòng</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>
    <div class="management-container">
        <h2>Quản lý Đặt phòng</h2>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormBooking('add-form')"><i class='bx bx-plus'></i> Thêm đơn đặt phòng mới</button>
            <div class="search-box">
                <input type="text" id="search" name="timkiem" placeholder="Tìm kiếm đơn đặt phòng...">
                <button type="submit" class="search-btn" onclick="showFormBooking('search-form')"><i class='bx bx-search'></i>
            </div>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn đặt phòng</th>
                        <th>Mã khách hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Mã Homestay</th>
                        <th>Mã phòng</th>
                        <th>Ngày đặt phòng</th>
                        <th>Ngày nhận phòng</th>
                        <th>Ngày trả phòng</th>
                        <th>Số người</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chú thích của khách hàng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $result = $conn->query("SELECT * FROM db_booking");
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['madondatphong'] ?></td>
                            <td><?php echo $row['makhachhang'] ?></td>
                            <td><?php echo $row['tenkhachhang'] ?></td>
                            <td><?php echo $row['mahomestay'] ?></td>
                            <td><?php echo $row['maphong'] ?></td>
                            <td><?php echo $row['ngaydatphong'] ?></td>
                            <td><?php echo $row['ngaynhanphong'] ?></td>
                            <td><?php echo $row['ngaytraphong'] ?></td>
                            <td><?php echo $row['songuoi'] ?></td>
                            <td><?php echo $row['tongtien'] ?></td>
                            <td><?php echo $row['trangthai'] ?></td>
                            <td class="truncate-text"><?php echo $row['chuthich'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormBooking('detail-form', '<?php echo $row['madondatphong']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormBooking('edit-form', '<?php echo $row['madondatphong']; ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteBooking('<?php echo $row['madondatphong']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<!---------------------------------- Thêm --------------------------->
<div class="form-container" id="add-form" style="display:<?php echo $is_add_form ? 'block' : 'none'; ?>;">
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
    <div class="management-container" >
        <div class="toolbar">
            <a href="home.php?page=homestay" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
            <h2>Thêm Đơn Đặt Phòng Mới</h2>
            <form action="../modules/Create/add_function.php" method="POST" enctype="multipart/form-data">
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
                        <label for="tongtien">Tổng số tiền(VNĐ):</label>
                        <input type="number" id="tongtien" name="tongtien" required>
                    </div>
                    <div class="form-group">
                        <label for="chuthich">Chú thích:</label>
                        <input type="text" id="chuthich" name="chuthich" required>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" name="submit_booking" class="add-btn">Thêm đơn đặt phòng</button>
                    <button type="reset"  class="cancel-btn">Hủy</button>
                </div>
            </form>
    </div>
</div>




<!-------------------------------- Tìm kiếm --------------------------->
<div class="form-container" id="search-form" style="display:<?php echo $is_search_form ? 'block' : 'none'; ?>;">
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Quản lí đơn đặt phòng</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>
    <div class="management-container">
        <h2>Quản lý Đặt phòng</h2>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormBooking('add-form')"><i class='bx bx-plus'></i> Thêm đơn đặt phòng mới</button>
            <div class="search-box">
                <input type="text" id="search" name="timkiem" placeholder="Tìm kiếm đơn đặt phòng...">
                <button type="submit" class="search-btn" onclick="showFormBooking('search-form')"><i class='bx bx-search'></i>
            </div>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn đặt phòng</th>
                        <th>Mã khách hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Mã Homestay</th>
                        <th>Mã phòng</th>
                        <th>Ngày đặt phòng</th>
                        <th>Ngày nhận phòng</th>
                        <th>Ngày trả phòng</th>
                        <th>Số người</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chú thích của khách hàng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        if( isset($_GET['content']) ? $_GET['content'] :'' ){
                            $search_query = trim($_GET['content']);
                            $search = "%$search_query%";

                            $sql = "SELECT * FROM db_booking WHERE madondatphong LIKE '$search' OR makhachhang LIKE '$search' OR tenkhachhang LIKE '$search' OR mahomestay LIKE '$search' 
                            OR maphong LIKE '$search' OR songuoi LIKE '$search' OR ngaydatphong LIKE '$search' OR trangthai LIKE '$search' "; 
                            $result = $conn->query($sql);} 
                            $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['madondatphong'] ?></td>
                            <td><?php echo $row['makhachhang'] ?></td>
                            <td><?php echo $row['tenkhachhang'] ?></td>
                            <td><?php echo $row['mahomestay'] ?></td>
                            <td><?php echo $row['maphong'] ?></td>
                            <td><?php echo $row['ngaydatphong'] ?></td>
                            <td><?php echo $row['ngaynhanphong'] ?></td>
                            <td><?php echo $row['ngaytraphong'] ?></td>
                            <td><?php echo $row['songuoi'] ?></td>
                            <td><?php echo $row['tongtien'] ?></td>
                            <td><?php echo $row['trangthai'] ?></td>
                            <td class="truncate-text"><?php echo $row['chuthich'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormBooking('detail-form', '<?php echo $row['madondatphong']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormBooking('edit-form', '<?php echo $row['madondatphong']; ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteBooking('<?php echo $row['madondatphong']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!---------------------------------- Sửa --------------------------->

<div class="form-container"id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($booking) { ?>
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
                    <a class="active">Cập nhật thông tin đơn đặt phòng</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=booking" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormBooking('detail-form', '<?php echo $booking['madondatphong']; ?>')"><i class='bx bx-detail'></i>Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteBooking('<?php echo $booking['madondatphong']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        <h2>Sửa thông tin đơn đặt phòng</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="madondatphong" value="<?php echo $booking['madondatphong']; ?>">
                <div class="form-section">
                    <h3>Thông tin cơ bản về đơn đặt phòng</h3>
                    <div class="form-group">
                        <label for="madondatphong">Mã đơn đặt phòng:</label>
                        <input type="text" id="madondatphong" name="madondatphong" value="<?php echo $booking['madondatphong']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="makhachhang">Mã Khách hàng:</label>
                        <input type="text" id="makhachhang" name="makhachhang" value="<?php echo $booking['makhachhang']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="mahomestay">Mã homestay:</label>
                        <input type="text" id="mahomestay" name="mahomestay" value="<?php echo $booking['mahomestay']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="maphong">Mã phòng:</label>
                        <input type="text" id="maphong" name="maphong" value="<?php echo $booking['maphong']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ngaydatphong">Ngày đặt phòng:</label>
                        <input type="date" id="ngaydatphong" name="ngaydatphong" value="<?php echo $booking['ngaydatphong']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="trangthai">Trạng thái:</label>
                        <select id="trangthai" name="trangthai">
                            <option value="danghoatdong" <?php echo ($booking['trangthai'] == 'danghoatdong') ? 'selected' : ''; ?>>Đã xác nhận</option>
                            <option value="dung" <?php echo ($booking['trangthai'] == 'dung') ? 'selected' : ''; ?>>Tạm dừng</option>
                            <option value="choduyet" <?php echo ($booking['trangthai'] == 'choduyet') ? 'selected' : ''; ?>>Chờ duyệt</option>
                        </select>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Thông tin khách hàng đặt phòng</h3>
                    <div class="form-group">
                        <label for="tenkhachhang">Tên Khách hàng:</label>
                        <input type="text" id="tenkhachhang" name="tenkhachhang" value="<?php echo $booking['tenkhachhang']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ngaynhanphong">Ngày nhận phòng:</label>
                        <input type="date" id="ngaynhanphong" name="ngaynhanphong" value="<?php echo $booking['ngaynhanphong']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ngaytraphong">Ngày trả phòng:</label>
                        <input type="date" id="ngaytraphong" name="ngaytraphong" value="<?php echo $booking['ngaytraphong']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="songuoi">Số người:</label>
                        <input type="number" id="songuoi" name="songuoi" value="<?php echo $booking['songuoi']; ?>" required></input>
                    </div>
                    <div class="form-group">
                        <label for="tongtien">Tổng số tiền(VNĐ):</label>
                        <input type="number" id="tongtien" name="tongtien" value="<?php echo $booking['tongtien']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="chuthich">Chú thích:</label>
                        <input type="text" id="chuthich" name="chuthich" value="<?php echo $booking['chuthich']; ?>" required>
                    </div>
                </div>
                    <div class="form-actions">
                    <button type="submit" name="submit_booking" class="edit-btn">Cập Nhật thông tin</button>
                <button type="reset" class="cancel-btn">Hủy</button>
                </div>
            </form>
        </div>
    <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin đơn đặt phòng để sửa.</p>
    <?php } ?>
</div>

<!-------------------------------- Chi tiết --------------------------->
<div class="form-container" id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($booking) { ?>
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
                    <a class="active">Thông tin chi tiết đơn đặt phòng</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=booking" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormBooking('edit-form', '<?php echo $booking['madondatphong']; ?>')"><i class='bx bx-edit-alt'></i>Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteBooking('<?php echo $booking['madondatphong']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết đơn đặt phòng</h2>

        <div class="detail-grid">
            <div class="detail-section">
                    <h3>Thông tin cơ bản về đơn đặt phòng</h3>
                    <div class="info-group">
                        <label for="madondatphong">Mã đơn đặt phòng:</label>
                        <p> <?php echo $booking['madondatphong']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="makhachhang">Mã Khách hàng:</label>
                        <p> <?php echo $booking['makhachhang']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="mahomestay">Mã homestay:</label>
                        <p> <?php echo $booking['mahomestay']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="maphong">Mã phòng:</label>
                        <p> <?php echo $booking['maphong']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="ngaydatphong">Ngày đặt phòng:</label>
                        <p> <?php echo $booking['ngaydatphong']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="trangthai">Trạng thái:</label>
                        <p> <?php echo $booking['trangthai']; ?> </p>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Thông tin khách hàng đặt phòng</h3>
                    <div class="info-group">
                        <label for="tenkhachhang">Tên Khách hàng:</label>
                        <p> <?php echo $booking['tenkhachhang']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="ngaynhanphong">Ngày nhận phòng:</label>
                        <p> <?php echo $booking['ngaynhanphong']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="ngaytraphong">Ngày trả phòng:</label>
                        <p> <?php echo $booking['madondatphong']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="songuoi">Số người:</label>
                        <p> <?php echo $booking['songuoi']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="tongtien">Tổng số tiền(VNĐ):</label>
                        <p> <?php echo $booking['tongtien']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="chuthich">Chú thích:</label>
                        <p> <?php echo $booking['chuthich']; ?> </p>
                    </div>
                </div>

        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin đơn đặt phòng.</p>
    <?php } ?>
</div>