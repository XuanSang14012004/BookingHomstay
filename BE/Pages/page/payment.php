<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_search_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_payment') {
    $is_add_form = true;
} else if ($action === 'edit_payment') {
    $is_edit_form = true;
} else if ($action === 'search_payment') {
    $is_search_form = true;
} else if ($action === 'detail_payment') {
    $is_detail_form = true;
} else {
    $is_view_form = true; // Trang chính

}

$mathanhtoan = isset($_GET['id']) ? $_GET['id'] : null;

$payment = null;
if (($is_edit_form || $is_detail_form) && $mathanhtoan) {
    $result = $conn->query("SELECT * FROM db_thanhtoan WHERE mathanhtoan = '$mathanhtoan'");
    if ($result && $result->num_rows > 0) {
        $payment = mysqli_fetch_assoc($result);
    }
}
?>

<!-------------------------------------------- Giao diện ----------------------------------->
<div class="form-container" id="payment-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Quản lí thanh toán</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download PDF</span>
    </a>
</div>
<div class="management-container">
    <h2>Quản lý Thanh toán</h2>
    <div class="toolbar">
        <button class="add-btn" onclick="showFormPay('add-form')"><i class='bx bx-plus'></i> Thêm hóa đơn mới</button>
        <div class="search-box">
            <input type="text" id="search" name="timkiem" placeholder="Tìm kiếm giao dịch...">
            <button type="submit" class="search-btn" onclick="showFormPay('search-form')"><i class='bx bx-search'></i></button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã thanh toán</th>
                    <th>Mã đơn đặt phòng</th>
                    <th>Phương thức thanh toán</th>
                    <th>Tổng tiền</th>
                    <th>Ngày thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    $result = $conn->query("SELECT * FROM db_thanhtoan");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['mathanhtoan'] ?></td>
                        <td><?php echo $row['madondatphong'] ?></td>
                        <td><?php echo $row['hinhthucthanhtoan'] ?></td>
                        <td><?php echo $row['sotien'] ?></td>
                        <td><?php echo $row['ngaythanhtoan'] ?></td>
                        <td><?php echo $row['trangthai'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" onclick="showFormPay('detail-form', '<?php echo $row['mathanhtoan']; ?>')"><i class='bx bx-detail'></i></button>
                            <button class="edit-btn" title="Sửa" onclick="showFormPay('edit-form', '<?php echo $row['mathanhtoan']; ?>')"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $row['mathanhtoan']; ?>')"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!---------------------------------------------- Thêm --------------------------------------->
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
                    <a>Quản lí thanh toán</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active">Thêm hóa đơn mới</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=payment" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
            <h2>Thêm Hóa Đơn Mới</h2>
            <form action="../modules/Create/add_function.php" method="POST" enctype="multipart/form-data">
                <div class="form-section">
                    <h3>Thông tin hóa đơn</h3>
                    <div class="form-group">
                        <label for="mathanhtoan">Mã thanh toán:</label>
                        <input type="text" id="mathanhtoan" name="mathanhtoan" required>
                    </div>
                    <div class="form-group">
                        <label for="madondatphong">Mã đơn đặt phòng:</label>
                        <input type="text" id="madondatphong" name="madondatphong" required>
                    </div>
                    <div class="form-group">
                        <label for="hinhthucthanhtoan">Hình thức thanh toán:</label>
                        <select id="hinhthucthanhtoan" name="hinhthucthanhtoan">
                            <option value="thetindung">Thẻ tín dụng</option>
                            <option value="chuyenkhoannganhang">Chuyển khoản ngân hàng</option>
                            <option value="tienmat">Tiền mặt</option>
                            <option value="khac">Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sotien">Số tiền (VNĐ):</label>
                        <input type="number" id="sotien" name="sotien" required>
                    </div>
                    <div class="form-group">
                        <label for="ngaythanhtoan">Ngày thanh toán:</label>
                        <input type="date" id="ngaythanhtoan" name="ngaythanhtoan" required>
                    </div>
                    <div class="form-group">
                        <label for="trangthai">Trạng thái:</label>
                        <select id="trangthai" name="trangthai">
                            <option value="dathanhtoan">Đã thanh toán</option>
                            <option value="dangcho">Đang chờ</option>
                            <option value="chuathanhtoan">Chưa thanh toán</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" name="submit_payment" class="add-btn">Thêm hóa đơn</button>
                    <button type="reset"  class="cancel-btn">Hủy</button>
                </div>
            </form>
    </div>
</div>

<!-------------------------------------------- Tìm kiếm ----------------------------------->
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
                <a class="active" href="#">Quản lí thanh toán</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download PDF</span>
    </a>
</div>
<div class="management-container">
    <h2>Quản lý Thanh toán</h2>
    <div class="toolbar">
        <button class="add-btn" onclick="showFormPay('add-form')"><i class='bx bx-plus'></i> Thêm hóa đơn mới</button>
        <div class="search-box">
            <input type="text" id="search" name="timkiem" placeholder="Tìm kiếm giao dịch...">
            <button type="submit" class="search-btn" onclick="showFormPay('search-form')"><i class='bx bx-search'></i></button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã thanh toán</th>
                    <th>Mã đơn đặt phòng</th>
                    <th>Phương thức thanh toán</th>
                    <th>Tổng tiền</th>
                    <th>Ngày thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if( isset($_GET['content']) ? $_GET['content'] :'' ){
                            $search_query = trim($_GET['content']);
                            $search = "%$search_query%";

                            $sql = "SELECT * FROM db_thanhtoan WHERE mathanhtoan LIKE '$search' OR madondatphong LIKE '$search' OR hinhthucthanhtoan LIKE '$search' OR ngaythanhtoan LIKE '$search' 
                            OR trangthai LIKE '$search'"; 
                            $result = $conn->query($sql);} 
                            $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['mathanhtoan'] ?></td>
                        <td><?php echo $row['madondatphong'] ?></td>
                        <td><?php echo $row['hinhthucthanhtoan'] ?></td>
                        <td><?php echo $row['sotien'] ?></td>
                        <td><?php echo $row['ngaythanhtoan'] ?></td>
                        <td><?php echo $row['trangthai'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" onclick="showFormPay('detail-form', '<?php echo $row['mathanhtoan']; ?>')"><i class='bx bx-detail'></i></button>
                            <button class="edit-btn" title="Sửa" onclick="showFormPay('edit-form', '<?php echo $row['mathanhtoan']; ?>')"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $row['mathanhtoan']; ?>')"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!---------------------------------------------- Sửa --------------------------------------->
<div class="form-container" id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($payment) { ?>
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a>Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a>Quản lí  thanh toán</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active">Cập nhật thông tin hóa đơn</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=payment" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormPay('detail-form', '<?php echo $payment['mathanhtoan']; ?>')"><i class='bx bx-detail'></i>Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $payment['mathanhtoan']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        <h2>Sửa thông tin hóa đơn</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="mathanhtoan" value="<?php echo $payment['mathanhtoan']; ?>">
                <div class="form-section">
                    <h3>Thông tin hóa đơn</h3>
                    <div class="form-group">
                        <label for="mathanhtoan">Mã thanh toán:</label>
                        <input type="text" id="mathanhtoan" name="mathanhtoan" value="<?php echo $payment['mathanhtoan']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="madondatphong">Mã đơn đặt phòng:</label>
                        <input type="text" id="madondatphong" name="madondatphong" value="<?php echo $payment['madondatphong']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hinhthucthanhtoan">Hình thức thanh toán:</label>
                        <select id="hinhthucthanhtoan" name="hinhthucthanhtoan">
                            <option value="thetindung" <?php echo ($payment['hinhthucthanhtoan'] == 'thetindung') ? 'selected' : ''; ?>>Thẻ tín dụng</option>
                            <option value="chuyenkhoannganhang" <?php echo ($payment['hinhthucthanhtoan'] == 'chuyenkhoannganhang') ? 'selected' : ''; ?>>Chuyển khoản ngân hàng</option>
                            <option value="tienmat" <?php echo ($payment['hinhthucthanhtoan'] == 'tienmat') ? 'selected' : ''; ?>>Tiền mặt</option>
                            <option value="khac" <?php echo ($payment['hinhthucthanhtoan'] == 'khac') ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sotien">Số tiền (VNĐ):</label>
                        <input type="number" id="sotien" name="sotien" value="<?php echo $payment['sotien']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ngaythanhtoan">Ngày thanh toán:</label>
                        <input type="date" id="ngaythanhtoan" name="ngaythanhtoan" value="<?php echo $payment['ngaythanhtoan']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="trangthai">Trạng thái:</label>
                        <select id="trangthai" name="trangthai">
                            <option value="dathanhtoan"<?php echo ($payment['trangthai'] == 'dathanhtoan') ? 'selected' : ''; ?>>Đã thanh toán</option>
                            <option value="dangcho"<?php echo ($payment['trangthai'] == 'dangcho') ? 'selected' : ''; ?>>Đang chờ</option>
                            <option value="chuathanhtoan"<?php echo ($payment['trangthai'] == 'chuathanhtoan') ? 'selected' : ''; ?>>Chưa thanh toán</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" name="submit_payment" class="edit-btn">Cập nhật thông tin</button>
                    <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
    <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin hóa đơn để sửa.</p>
    <?php } ?>
</div>
<!---------------------------------------------- Chi tiết --------------------------------------->
<div class="form-container" id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($payment) { ?>
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a>Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a>Quản lí thanh toán</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active">Thông tin chi tiết hóa đơn</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=payment" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormPay('edit-form', '<?php echo $payment['mathanhtoan']; ?>')"><i class='bx bx-edit-alt'></i>Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $payment['mathanhtoan']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết hóa đơn</h2>

        <div class="detail-grid">
            <div class="detail-section">
                <h3>Thông tin hóa đơn</h3>
                <div class="info-group">
                    <label for="mathanhtoan">Mã thanh toán:</label>
                    <p><?php echo $payment['mathanhtoan']; ?></p>
                </div>
                <div class="info-group">
                    <label for="madondatphong">Mã đơn đặt phòng:</label>
                    <p><?php echo $payment['madondatphong']; ?></p>
                </div>
                <div class="info-group">
                    <label for="hinhthucthanhtoan">Hình thức thanh toán:</label>
                    <p><?php echo $payment['hinhthucthanhtoan']; ?></p>
                </div>
                <div class="info-group">
                    <label for="sotien">Số tiền (VNĐ):</label>
                    <p><?php echo $payment['sotien']; ?></p>
                </div>
                <div class="info-group">
                    <label for="ngaythanhtoan">Ngày thanh toán:</label>
                    <p><?php echo $payment['ngaythanhtoan']; ?></p>
                <div class="info-group">
                    <label for="trangthai">Trạng thái:</label>
                    <p><?php echo $payment['trangthai']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin hóa đơn.</p>
    <?php } ?>
</div>
