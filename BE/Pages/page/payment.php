<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_pay_form = false;
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
} else if ($action === 'action_payment') {
    $is_pay_form = true;
} else {
    $is_view_form = true; // Trang chính

}

$payment_id = isset($_GET['id']) ? $_GET['id'] : null;

$payment = null;
if (($is_edit_form || $is_detail_form || $is_pay_form) && $payment_id) {
    $result = $conn->query("SELECT * FROM db_payment WHERE payment_id = '$payment_id'");
    if ($result && $result->num_rows > 0) {
        $payment = mysqli_fetch_assoc($result);
    }
}

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) as total FROM db_payment");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
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
    <div class="limit-form">
            <form method="get">
                <input type="hidden" name="page" value="payment">
                <label for="limit">Hiển thị</label>
                <input type="number" name="limit" id="limit" min="1" value="<?= $limit ?>">
                <input type="hidden" name="pagetable" value="1">
                <button type="submit">Xem</button>
            </form>
        </div>
    <p class="line-search"><?php if( isset($_GET['content']) ? $_GET['content'] :'' ){
        echo "Kết quả tìm kiếm theo từ khóa: '{$_GET['content']}'";
            } ?>
    </p>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
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
                            OR payment_status LIKE '$search'
                            LIMIT $limit OFFSET $offset"; 
                        $result = $conn->query($sql); 
                    }else{
                        $result = $conn->query("SELECT * FROM db_payment LIMIT $limit OFFSET $offset");
                    }
                    if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['payment_id']; ?>"></td> 
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
                <?php } 
                        } else { ?>
                        <tr>
                            <td colspan="11" style="text-align:center; color: #888; font-style: italic;">
                                Không có dữ liệu phù hợp
                            </td>
                        </tr>
                    <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
            <?php if ($pagetable > 1): ?>
                <a href="home.php?page=payment&pagetable&limit=<?= $limit ?>">&laquo;</a>
                <a href="home.php?page=payment&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=payment&pagetable=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=payment&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit ?>"> &gt;</a>
                <a href="home.php?page=payment&pagetable=<?= $total_pages ?>&limit=<?= $limit ?>"> &raquo;</a>
            <?php endif; ?>
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
                            <option value="Thẻ tín dụng">Thẻ tín dụng</option>
                            <option value="Chuyển khoản ngân hàng">Chuyển khoản ngân hàng</option>
                            <option value="Tiền mặt">Tiền mặt</option>
                            <option value="Momo">Momo</option>
                            <option value="VNpay">VNpay</option>
                            <option value="Khác">Khác</option>
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
                            <option value="Đã đặt cọc">Đã đặt cọc</option>
                            <option value="Đã thanh toán">Đã thanh toán</option>
                            <option value="Chưa thanh toán">Chưa thanh toán</option>
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
<div class="form-container" id="update-form" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
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
                            <option value="Thẻ tín dụng" <?php echo ($payment['method'] == 'Thẻ tín dụng') ? 'selected' : ''; ?>>Thẻ tín dụng</option>
                            <option value="Chuyển khoản ngân hàng" <?php echo ($payment['method'] == 'Chuyển khoản ngân hàng') ? 'selected' : ''; ?>>Chuyển khoản ngân hàng</option>
                            <option value="Tiền mặt" <?php echo ($payment['method'] == 'Tiền mặt') ? 'selected' : ''; ?>>Tiền mặt</option>
                            <option value="Momo" <?php echo ($payment['method'] == 'Momo') ? 'selected' : ''; ?>>Momo</option>
                            <option value="VNpay" <?php echo ($payment['method'] == 'VNpay') ? 'selected' : ''; ?>>VNpay</option>
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
                            <option value="Đã thanh toán"<?php echo ($payment['payment_status'] == 'Đã thanh toán') ? 'selected' : ''; ?>>Đã thanh toán</option>
                            <option value="Đã đặt cọc"<?php echo ($payment['payment_status'] == 'Đã đặt cọc') ? 'selected' : ''; ?>>Đã đặt cọc</option>
                            <option value="Chưa thanh toán"<?php echo ($payment['payment_status'] == 'Chưa thanh toán') ? 'selected' : ''; ?>>Chưa thanh toán</option>
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
<div class="form-container" id="detail-form" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($payment) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Sửa" onclick="showFormPay('pay-form', '<?php echo $payment['payment_id']; ?>')"><i class='bx bx-dollar-circle'></i> Thanh toán</button>
                <button class="edit-btn" title="Sửa" onclick="showFormPay('edit-form', '<?php echo $payment['payment_id']; ?>')"><i class='bx bx-edit-alt'></i>Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $payment['payment_id']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết hóa đơn</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="payment_id" value="<?php echo $payment['payment_id']; ?>">
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
                </div>
                <div class="info-group">
                    <label for="payment_status">Trạng thái:</label>
                    <p><?php 
                            $text='';
                            $style='';
                            if($payment['payment_status'] ==='Đã thanh toán'){
                                $text=  'Đã thanh toán';
                                $style= 'status-completed';
                            }else if($payment['payment_status'] === 'Đã đặt cọc'){
                                $text=  'Đã đặt cọc';
                                $style= 'status-pending';
                            }else if($payment['payment_status'] === 'Chưa thanh toán'){
                                $text=  'Đã đặt';
                                $style= 'status-cancel';
                            }
                            echo "<span class='" . $style . "'>" . $text . "</span>";?></p>
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin hóa đơn.</p>
    <?php } ?>
</div>

<!-------------------------------------- Giao diện thông tin chi tiết --------------------------------------->
<div class="form-container" id="pay-form" style="display:<?php echo $is_pay_form ? 'block' : 'none'; ?>;">
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
                </div>
                <div class="info-group">
                    <label for="payment_status">Trạng thái:</label>
                    <p><?php echo $payment['payment_status']; ?></p>
                </div>
                <div class="form-actions">
                    <button type="submit" name="done_payment" class="edit-btn">Xác nhận thanh toán</button>
                    <button type="reset" class="cancel-btn">Hủy</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin hóa đơn.</p>
    <?php } ?>
</div>