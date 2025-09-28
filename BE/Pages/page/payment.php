<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_payment') {
    $is_add_form = true;
} else if ($action === 'edit_payment') {
    $is_edit_form = true;
} else if ($action === 'search_payment') {
    $is_view_form = true;
} else if ($action === 'detail_payment') {
    $is_detail_form = true;
} else {
    $is_view_form = true; // Trang chính

}

$payment_id = isset($_GET['id']) ? $_GET['id'] : null;

$payment = null;
if (($is_edit_form || $is_detail_form) && $payment_id) {
    $result = $conn->query("SELECT * FROM db_payment WHERE payment_id = '$payment_id'");
    if ($result && $result->num_rows > 0) {
        $payment = mysqli_fetch_assoc($result);
    }
}
?>
<!----------------------------------------------- Giao diện chính -------------------------------------------->
<div class="form-container" id="payment-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
<?php include "../home/header_content.php"; ?>
<div class="management-container">
    <h2>Quản lý Thanh toán</h2>
    <div class="toolbar">
        <button class="add-btn" onclick="showFormPay('add-form')"><i class='bx bx-plus'></i> Thêm hóa đơn mới</button>
        <div class="search-box">
            <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm giao dịch...">
            <button type="submit" class="search-btn" onclick="showFormPay('search-form')"><i class='bx bx-search'></i></button>
        </div>
    </div>
    <h3><?php if( isset($_GET['content']) ? $_GET['content'] :'' ){
            echo "Kết quả tìm kiếm theo: {$_GET['content']}";
             } ?>
        </h3>
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

                        $sql = "SELECT * FROM db_payment WHERE payment_id LIKE '$search' 
                            OR booking_id LIKE '$search' 
                            OR method LIKE '$search'
                            OR payment_price LIKE '$search' 
                            OR date LIKE '$search' 
                            OR payment_status LIKE '$search'"; 
                        $result = $conn->query($sql); 
                        $i = 1;
                    }else{
                        $result = $conn->query("SELECT * FROM db_payment");
                        $i = 1;
                    }
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['payment_id'] ?></td>
                        <td><?php echo $row['booking_id'] ?></td>
                        <td><?php echo $row['method'] ?></td>
                        <td><?php echo $row['payment_price'] ?></td>
                        <td><?php echo $row['date'] ?></td>
                        <td><?php echo $row['payment_status'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" onclick="showFormPay('detail-form', '<?php echo $row['payment_id']; ?>')"><i class='bx bx-detail'></i></button>
                            <button class="edit-btn" title="Sửa" onclick="showFormPay('edit-form', '<?php echo $row['payment_id']; ?>')"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $row['payment_id']; ?>')"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!---------------------------------------- Giao diện thêm mới ------------------------------------>
<div class="form-container" id="add-form" style="display:<?php echo $is_add_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
            <h2>Thêm Hóa Đơn Mới</h2>
            <form action="../modules/Create/add_function.php" method="POST" enctype="multipart/form-data">
                <div class="form-section">
                    <h3>Thông tin hóa đơn</h3>
                    <div class="form-group">
                        <label for="payment_id">Mã thanh toán:</label>
                        <input type="text" id="payment_id" name="payment_id" required>
                    </div>
                    <div class="form-group">
                        <label for="booking_id">Mã đơn đặt phòng:</label>
                        <input type="text" id="booking_id" name="booking_id" required>
                    </div>
                    <div class="form-group">
                        <label for="method">Hình thức thanh toán:</label>
                        <select id="method" name="method">
                            <option value="thetindung">Thẻ tín dụng</option>
                            <option value="chuyenkhoannganhang">Chuyển khoản ngân hàng</option>
                            <option value="tienmat">Tiền mặt</option>
                            <option value="khac">Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_price">Số tiền (VNĐ):</label>
                        <input type="number" id="payment_price" name="payment_price" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Ngày thanh toán:</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_status">Trạng thái:</label>
                        <select id="payment_status" name="payment_status">
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

<!-------------------------------------- Giao diện cập nhật --------------------------------------->
<div class="form-container" id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($payment) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormPay('detail-form', '<?php echo $payment['payment_id']; ?>')"><i class='bx bx-detail'></i>Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $payment['payment_id']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        <h2>Sửa thông tin hóa đơn</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="payment_id" value="<?php echo $payment['payment_id']; ?>">
                <div class="form-section">
                    <h3>Thông tin hóa đơn</h3>
                    <div class="form-group">
                        <label for="payment_id">Mã thanh toán:</label>
                        <input type="text" id="payment_id" name="payment_id" value="<?php echo $payment['payment_id']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="booking_id">Mã đơn đặt phòng:</label>
                        <input type="text" id="booking_id" name="booking_id" value="<?php echo $payment['booking_id']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="method">Hình thức thanh toán:</label>
                        <select id="method" name="method">
                            <option value="thetindung" <?php echo ($payment['method'] == 'thetindung') ? 'selected' : ''; ?>>Thẻ tín dụng</option>
                            <option value="chuyenkhoannganhang" <?php echo ($payment['method'] == 'chuyenkhoannganhang') ? 'selected' : ''; ?>>Chuyển khoản ngân hàng</option>
                            <option value="tienmat" <?php echo ($payment['method'] == 'tienmat') ? 'selected' : ''; ?>>Tiền mặt</option>
                            <option value="khac" <?php echo ($payment['method'] == 'khac') ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_price">Số tiền (VNĐ):</label>
                        <input type="number" id="payment_price" name="payment_price" value="<?php echo $payment['payment_price']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Ngày thanh toán:</label>
                        <input type="date" id="date" name="date" value="<?php echo $payment['date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_status">Trạng thái:</label>
                        <select id="payment_status" name="payment_status">
                            <option value="dathanhtoan"<?php echo ($payment['payment_status'] == 'dathanhtoan') ? 'selected' : ''; ?>>Đã thanh toán</option>
                            <option value="dangcho"<?php echo ($payment['payment_status'] == 'dangcho') ? 'selected' : ''; ?>>Đang chờ</option>
                            <option value="chuathanhtoan"<?php echo ($payment['payment_status'] == 'chuathanhtoan') ? 'selected' : ''; ?>>Chưa thanh toán</option>
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

<!-------------------------------------- Giao diện thông tin chi tiết --------------------------------------->
<div class="form-container" id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($payment) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormPay('edit-form', '<?php echo $payment['payment_id']; ?>')"><i class='bx bx-edit-alt'></i>Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $payment['payment_id']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết hóa đơn</h2>

        <div class="detail-grid">
            <div class="detail-section">
                <h3>Thông tin hóa đơn</h3>
                <div class="info-group">
                    <label for="payment_id">Mã thanh toán:</label>
                    <p><?php echo $payment['payment_id']; ?></p>
                </div>
                <div class="info-group">
                    <label for="booking_id">Mã đơn đặt phòng:</label>
                    <p><?php echo $payment['booking_id']; ?></p>
                </div>
                <div class="info-group">
                    <label for="method">Hình thức thanh toán:</label>
                    <p><?php echo $payment['method']; ?></p>
                </div>
                <div class="info-group">
                    <label for="payment_price">Số tiền (VNĐ):</label>
                    <p><?php echo $payment['payment_price']; ?></p>
                </div>
                <div class="info-group">
                    <label for="date">Ngày thanh toán:</label>
                    <p><?php echo $payment['date']; ?></p>
                <div class="info-group">
                    <label for="payment_status">Trạng thái:</label>
                    <p><?php echo $payment['payment_status']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin hóa đơn.</p>
    <?php } ?>
</div>