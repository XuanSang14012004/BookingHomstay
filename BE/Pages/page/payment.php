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
    $result = $conn->query("SELECT * FROM db_booking WHERE booking_id = '$payment_id'");
    if ($result && $result->num_rows > 0) {
        $payment = mysqli_fetch_assoc($result);
    }
}

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;

if (isset($_GET['content']) && $_GET['content'] !== '') {
    $search_query = trim($_GET['content']);
    $search = "%".$search_query."%";
    $count_sql = "SELECT COUNT(*) as total FROM db_booking WHERE booking_id LIKE '$search'
        OR customer_name LIKE '$search'
        OR customer_email LIKE '$search' 
        OR customer_phone LIKE '$search'  
        OR payment_method LIKE '$search'
        OR total_price LIKE '$search' 
        OR payment_date LIKE '$search' 
        OR payment_status LIKE '$search'";
    $total_result = $conn->query($count_sql);
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);
} else {
    $total_result = $conn->query("SELECT COUNT(*) as total FROM db_booking");
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);
}
?>
<!----------------------------------------------- Giao diện chính -------------------------------------------->
<div class="form-container" id="payment-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
<?php include "../home/header_content.php"; ?>
<div class="management-container">
    <h2>Quản lý Thanh toán</h2>
    <div class="toolbar">
        <button id="btn-bulk-pay" type="button" class="detail-btn" title="Thanh toán"><i class='bx bx-dollar-circle'></i> Thanh toán hóa đơn</button>
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
                <?php if(isset($_GET['content'])): ?>
                    <input type="hidden" name="content" value="<?= htmlspecialchars($_GET['content']) ?>">
                <?php endif; ?>
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
                    <th>Mã đơn đặt phòng</th>
                    <th>Tên khách hàng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Phương thức thanh toán</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái thanh toán</th>
                    <th>Ngày thanh toán</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if( isset($_GET['content']) ? $_GET['content'] :'' ){
                        $search_query = trim($_GET['content']);
                        $search = "%$search_query%";

                        $sql = "SELECT * FROM db_booking WHERE booking_id LIKE '$search'
                            OR customer_name LIKE '$search'
                            OR customer_email LIKE '$search' 
                            OR customer_phone LIKE '$search'  
                            OR payment_method LIKE '$search'
                            OR total_price LIKE '$search' 
                            OR payment_date LIKE '$search' 
                            OR payment_status LIKE '$search'
                            LIMIT $limit OFFSET $offset"; 
                        $result = $conn->query($sql); 
                    }else{
                        $result = $conn->query("SELECT * FROM db_booking LIMIT $limit OFFSET $offset");
                    }
                    if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['booking_id']; ?>"></td> 
                        <td><?php echo $row['booking_id'] ?></td>
                        <td><?php echo $row['customer_name'] ?></td>
                        <td><?php echo $row['customer_email'] ?></td>
                        <td><?php echo $row['customer_phone'] ?></td>
                        <td><?php echo $row['payment_method'] ?></td>
                        <td><?php echo $row['total_price'] ?></td>
                        <td><?php echo $row['payment_status'] ?></td>
                        <td><?php echo $row['payment_date'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" onclick="showFormPay('detail-form', '<?php echo $row['booking_id']; ?>')"><i class='bx bx-detail'></i></button>
                            <button class="edit-btn" title="Sửa" onclick="showFormPay('edit-form', '<?php echo $row['booking_id']; ?>')"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $row['booking_id']; ?>')"><i class='bx bx-trash'></i></button>
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
            <?php
                $contentParam = isset($_GET['content']) ? '&content='.urlencode($_GET['content']) : '';
            ?>
            <?php if ($pagetable > 1): ?>
                <a href="home.php?page=payment&pagetable&limit=<?= $limit . $contentParam ?>">&laquo;</a>
                <a href="home.php?page=payment&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit . $contentParam ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=payment&pagetable=<?= $i ?>&limit=<?= $limit . $contentParam ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=payment&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit . $contentParam ?>"> &gt;</a>
                <a href="home.php?page=payment&pagetable=<?= $total_pages ?>&limit=<?= $limit . $contentParam ?>"> &raquo;</a>
            <?php endif; ?>
        </div>  
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
                <button class="detail-btn" title="Chi tiết" onclick="showFormPay('detail-form', '<?php echo $payment['booking_id']; ?>')"><i class='bx bx-detail'></i>Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $payment['booking_id']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        <h2>Sửa thông tin hóa đơn</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="payment_id" value="<?php echo $payment['booking_id']; ?>">
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Thông tin hóa đơn</h3>
                    <div class="form-group">
                        <label for="booking_id">Mã đơn đặt phòng:</label>
                        <input type="text" id="booking_id" name="booking_id" value="<?php echo $payment['booking_id']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="customer_name">Tên khách hàng:</label>
                        <input type="text" id="customer_name" name="customer_name" value="<?php echo $payment['customer_name']; ?>" placeholder="Nhập tên khách hàng" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_email">Email:</label>
                        <input type="text" id="customer_email" name="customer_email" value="<?php echo $payment['customer_email']; ?>" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_phone">Số điện thoại:</label>
                        <input type="text" id="customer_phone" name="customer_phone" value="<?php echo $payment['customer_phone']; ?>" placeholder="Nhập số điện thoại" required>
                    </div>
                </div>
                <div style="flex:1;">
                    <h3>Thông tin thanh toán</h3>
                    <div class="form-group">
                        <label for="method">Hình thức thanh toán:</label>
                        <select id="payment_method" name="payment_method">
                            <option value="Thẻ tín dụng" <?php echo ($payment['payment_method'] == 'Thẻ tín dụng') ? 'selected' : ''; ?>>Thẻ tín dụng</option>
                            <option value="Chuyển khoản ngân hàng" <?php echo ($payment['payment_method'] == 'Chuyển khoản ngân hàng') ? 'selected' : ''; ?>>Chuyển khoản ngân hàng</option>
                            <option value="Tiền mặt" <?php echo ($payment['payment_method'] == 'Tiền mặt') ? 'selected' : ''; ?>>Tiền mặt</option>
                            <option value="Momo" <?php echo ($payment['payment_method'] == 'Momo') ? 'selected' : ''; ?>>Momo</option>
                            <option value="VNpay" <?php echo ($payment['payment_method'] == 'VNpay') ? 'selected' : ''; ?>>VNpay</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="total_price">Số tiền (VNĐ):</label>
                        <input type="number" id="total_price" name="total_price" value="<?php echo $payment['total_price']; ?>" placeholder="Nhập số tiền" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_date">Ngày thanh toán:</label>
                        <input type="datetime-local" id="payment_date" name="payment_date" value="<?php echo $payment['payment_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_status">Trạng thái:</label>
                        <select id="payment_status" name="payment_status">
                            <option value="Đã thanh toán"<?php echo ($payment['payment_status'] == 'Đã thanh toán') ? 'selected' : ''; ?>>Đã thanh toán</option>
                            <option value="Đã đặt cọc"<?php echo ($payment['payment_status'] == 'Đã đặt cọc') ? 'selected' : ''; ?>>Đã đặt cọc</option>
                            <option value="Chờ thanh toán"<?php echo ($payment['payment_status'] == 'Chờ thanh toán') ? 'selected' : ''; ?>>Chờ thanh toán</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align:right;">
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
                <button class="edit-btn" title="Sửa" onclick="showFormPay('edit-form', '<?php echo $payment['booking_id']; ?>')"><i class='bx bx-edit-alt'></i>Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deletePay('<?php echo $payment['booking_id']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Thông tin hóa đơn đặt phòng</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="payment_id" value="<?php echo $payment['booking_id']; ?>">
        <div class="detail-grid">
            <div class="detail-section">
                <h3>Thông tin hóa đơn</h3>
                <div class="info-group">
                    <label for="booking_id">Mã đơn đặt phòng:</label>
                    <p><?php echo $payment['booking_id']; ?></p>
                </div>
                <div class="info-group">
                    <label for="customer_name">Tên khách hàng:</label>
                    <p><?php echo $payment['customer_name']; ?></p>
                </div>
                <div class="info-group">
                    <label for="customer_email">Email:</label>
                    <p><?php echo $payment['customer_email']; ?></p>
                </div>
                <div class="info-group">
                    <label for="customer_phone">Số điện thoại:</label>
                    <p><?php echo $payment['customer_phone']; ?></p>
                </div>
                <div class="info-group">
                    <label for="payment_method">Hình thức thanh toán:</label>
                    <p><?php echo $payment['payment_method']; ?></p>
                </div>
                <div class="info-group">
                    <label for="total_price">Số tiền (VNĐ):</label>
                    <p><?php echo $payment['total_price']; ?></p>
                </div>
                <div class="info-group">
                    <label for="payment_date">Ngày thanh toán:</label>
                    <p><?php echo $payment['payment_date']; ?></p>
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
                            }else if($payment['payment_status'] === 'Chờ thanh toán'){
                                $text=  'Chờ thanh toán';
                                $style= 'status-pending';
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

<!-- Giao diện form thanh toán -->
<div class="form-container" id="pay-form" style="display:<?php echo $is_pay_form ? 'block' : 'none'; ?>;">
    <?php if ($payment) { ?>
    <?php include "../home/header_content.php"; ?>

    <div class="management-container">
        <h2 style="margin-bottom:12px;">Thanh toán đơn đặt phòng</h2>

        <form action="../modules/update_function.php" method="POST">
            <input type="hidden" name="action" value="confirm_payment">
            <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($payment['booking_id']); ?>">

            <div class="detail-grid">
                <!-- LEFT: hiển thị các khối thông tin theo yêu cầu -->
                <div style="flex:1; display:flex; flex-direction:column; gap:16px;">
                    <div class="detail-section">
                        <h3>Thông tin đơn đặt phòng</h3>
                        <div class="info-group">
                            <label for="booking_id">Mã đơn đặt phòng:</label>
                            <p><?php echo htmlspecialchars($payment['booking_id']); ?></p>
                        </div>
                        <div class="info-group">
                            <label for="homestay_id">Mã homestay:</label>
                            <p><?php echo htmlspecialchars($payment['homestay_id'] ?? ''); ?></p>
                        </div>
                        <div class="info-group">
                            <label for="created_at">Ngày đặt phòng:</label>
                            <p><?php echo htmlspecialchars($payment['created_at'] ?? ''); ?></p>
                        </div>
                        <div class="info-group">
                            <label for="checkin_date">Ngày nhận phòng:</label>
                            <p><?php echo htmlspecialchars($payment['checkin_date'] ?? ''); ?></p>
                        </div>
                        <div class="info-group">
                            <label for="checkout_date">Ngày trả phòng:</label>
                            <p><?php echo htmlspecialchars($payment['checkout_date'] ?? ''); ?></p>
                        </div>
                        <div class="info-group">
                            <label for="guests">Số người:</label>
                            <p><?php echo htmlspecialchars($payment['guests'] ?? ''); ?></p>
                        </div>
                        <div class="info-group">
                            <label for="status">Trạng thái:</label>
                            <p>
                                <?php 
                                    $text = '';
                                    $style = '';
                                    if(($payment['status'] ?? '') === 'Đã xác nhận'){
                                        $text = 'Đã xác nhận';
                                        $style = 'status-actived';
                                    } else if(($payment['status'] ?? '') === 'Chờ xác nhận'){
                                        $text = 'Chờ xác nhận';
                                        $style = 'status-pending';
                                    } else if(($payment['status'] ?? '') === 'Đã hủy'){
                                        $text = 'Đã hủy';
                                        $style = 'status-cancel';
                                    }
                                    echo "<span class='" . $style . "'>" . $text . "</span>";
                                ?>
                            </p>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h3>Thông tin khách hàng</h3>
                        <div class="info-group">
                            <label for="customer_id">Mã Khách hàng:</label>
                            <p><?php echo htmlspecialchars($payment['customer_id'] ?? ''); ?></p>
                        </div>
                        <div class="info-group">
                            <label for="customer_name">Tên Khách hàng:</label>
                            <p><?php echo htmlspecialchars($payment['customer_name'] ?? ''); ?></p>
                        </div>
                        <div class="info-group">
                            <label for="customer_email">Email:</label>
                            <p><?php echo htmlspecialchars($payment['customer_email'] ?? ''); ?></p>
                        </div>
                        <div class="info-group">
                            <label for="customer_phone">Số điện thoại:</label>
                            <p><?php echo htmlspecialchars($payment['customer_phone'] ?? ''); ?></p>
                        </div>
                        <div class="info-group">
                            <label for="note">Chú thích:</label>
                            <p><?php echo htmlspecialchars($payment['note'] ?? ''); ?></p>
                        </div>
                    </div>
                </div>

                <div class="summary-box" style="display:flex; flex-direction:column; gap:12px; width:380px;">
                    <h3>Thông tin thanh toán</h3>

                    <div class="form-group">
                        <label for="payment_method">Phương thức thanh toán</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="Thẻ tín dụng" <?php echo ($payment['payment_method']=='Thẻ tín dụng') ? 'selected' : ''; ?>>Thẻ tín dụng</option>
                            <option value="Chuyển khoản ngân hàng" <?php echo ($payment['payment_method']=='Chuyển khoản ngân hàng') ? 'selected' : ''; ?>>Chuyển khoản ngân hàng</option>
                            <option value="Tiền mặt" <?php echo ($payment['payment_method']=='Tiền mặt') ? 'selected' : ''; ?>>Tiền mặt</option>
                            <option value="Momo" <?php echo ($payment['payment_method']=='Momo') ? 'selected' : ''; ?>>Momo</option>
                            <option value="VNpay" <?php echo ($payment['payment_method']=='VNpay') ? 'selected' : ''; ?>>VNpay</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="total_price">Số tiền thanh toán (VNĐ)</label>
                        <input type="number" id="total_price" name="total_price" min="0" step="1" value="<?php echo htmlspecialchars($payment['total_price']); ?>" placeholder="Nhập số tiền" required>
                    </div>

                    <div class="form-group">
                        <label for="payment_status">Trạng thái thanh toán</label>
                        <select id="payment_status" name="payment_status" required>
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="Đã thanh toán" <?php echo ($payment['payment_status']=='Đã thanh toán') ? 'selected' : ''; ?>>Đã thanh toán</option>
                            <option value="Đã đặt cọc" <?php echo ($payment['payment_status']=='Đã đặt cọc') ? 'selected' : ''; ?>>Đã đặt cọc</option>
                            <option value="Chờ thanh toán" <?php echo ($payment['payment_status']=='Chờ thanh toán') ? 'selected' : ''; ?>>Chờ thanh toán</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="payment_date">Ngày/giờ thanh toán</label>
                        <?php
                            $dt = $payment['payment_date'] ?? date('Y-m-d H:i:s');
                            $dt_local = date('Y-m-d\TH:i', strtotime($dt));
                        ?>
                        <input type="datetime-local" id="payment_date" name="payment_date" value="<?php echo $dt_local; ?>" required>
                    </div>

                    <!-- <div class="form-group">
                        <label for="payment_ref">Mã giao dịch / Tham chiếu</label>
                        <input type="text" id="payment_ref" name="payment_ref" value="<?php echo htmlspecialchars($payment['payment_ref'] ?? ''); ?>" placeholder="Nhập mã giao dịch (nếu có)">
                    </div> -->

                    <div class="form-actions" style="margin-top:12px; display:flex; justify-content:flex-end; gap:10px;">
                        <button type="submit" name="done_payment" class="edit-btn">Xác nhận thanh toán</button>
                        <button type="button" class="cancel-btn" onclick="window.history.back();">Hủy</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin hóa đơn.</p>
    <?php } ?>
</div>