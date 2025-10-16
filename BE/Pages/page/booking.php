<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_booking') {
    $is_add_form = true;
} else if ($action === 'edit_booking') {
    $is_edit_form = true;
} else if ($action === 'search_booking') {
    $is_view_form = true;
} else if ($action === 'detail_booking') {
    $is_detail_form = true;
} else {
    $is_view_form = true;
}

$booking_id = isset($_GET['id']) ? $_GET['id'] : null;

$booking = null;
if (($is_edit_form || $is_detail_form) && $booking_id) {
    $result = $conn->query("SELECT * FROM db_booking WHERE booking_id = '$booking_id'");
    if ($result && $result->num_rows > 0) {
        $booking = mysqli_fetch_assoc($result);
    }
}

// Xử lý bộ lọc
$where = [];
if (isset($_GET['status']) && $_GET['status'] !== "") {
    $where[] = "status = '" . $conn->real_escape_string($_GET['status']) . "'";
}
if (isset($_GET['payment_status']) && $_GET['payment_status'] !== "") {
    $where[] = "payment_status = '" . $conn->real_escape_string($_GET['payment_status']) . "'";
}
if (isset($_GET['payment_method']) && $_GET['payment_method'] !== "") {
    $where[] = "payment_method = '" . $conn->real_escape_string($_GET['payment_method']) . "'";
}
$where_sql = $where ? "WHERE " . implode(" AND ", $where) : "";

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;

// Đếm tổng số bản ghi cho phân trang (áp dụng cả lọc)
$count_sql = "SELECT COUNT(*) as total FROM db_booking $where_sql";
$total_result = $conn->query($count_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>
<!------------------------------------------------------------ Giao diện chính --------------------------------------------------->
<div class="form-container" id="booking-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
   <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý Đặt phòng</h2>
        <div class="filter-bar">
            <a href="home.php?page=booking<?=
                isset($_GET['status']) ? '&status='.urlencode($_GET['status']) : ''
            ?><?=
                isset($_GET['payment_status']) ? '&payment_status='.urlencode($_GET['payment_status']) : ''
            ?><?=
                isset($_GET['payment_method']) ? '&payment_method='.urlencode($_GET['payment_method']) : ''
            ?>" title="Lọc dữ liệu">
                <i class='bx bx-filter'></i>
            </a>
            <form class="filter-form" method="get">
                <input type="hidden" name="page" value="booking">
                <select name="status" onchange="this.form.submit()">
                    <option value="">-- Trạng thái đặt phòng --</option>
                    <option value="Đã xác nhận" <?= (isset($_GET['status']) && $_GET['status']=='Đã xác nhận')?'selected':''; ?>>Đã xác nhận</option>
                    <option value="Chờ xác nhận" <?= (isset($_GET['status']) && $_GET['status']=='Chờ xác nhận')?'selected':''; ?>>Chờ xác nhận</option>
                    <option value="Đã hủy" <?= (isset($_GET['status']) && $_GET['status']=='Đã hủy')?'selected':''; ?>>Đã hủy</option>
                </select>
                <select name="payment_status" onchange="this.form.submit()">
                    <option value="">-- Trạng thái thanh toán --</option>
                    <option value="Đã thanh toán" <?= (isset($_GET['payment_status']) && $_GET['payment_status']=='Đã thanh toán')?'selected':''; ?>>Đã thanh toán</option>
                    <option value="Chờ thanh toán" <?= (isset($_GET['payment_status']) && $_GET['payment_status']=='Chờ thanh toán')?'selected':''; ?>>Chờ thanh toán</option>
                </select>
                <select name="payment_method" onchange="this.form.submit()">
                    <option value="">-- Phương thức thanh toán --</option>
                    <option value="Thanh toán khi trả phòng" <?= (isset($_GET['payment_method']) && $_GET['payment_method']=='Thanh toán khi trả phòng')?'selected':''; ?>>Thanh toán khi nhận phòng</option>
                    <option value="VNPay" <?= (isset($_GET['payment_method']) && $_GET['payment_method']=='VNPay')?'selected':''; ?>>VNPay</option>
                    <option value="Momo" <?= (isset($_GET['payment_method']) && $_GET['payment_method']=='Momo')?'selected':''; ?>>Momo</option>
                    <option value="Tiền mặt" <?= (isset($_GET['payment_method']) && $_GET['payment_method']=='Tiền mặt')?'selected':''; ?>>Tiền mặt</option>
                    <option value="Đặt cọc" <?= (isset($_GET['payment_method']) && $_GET['payment_method']=='Đặt cọc')?'selected':''; ?>>Đặt cọc</option>
                </select>
            </form>
        </div>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormBooking('add-form')"><i class='bx bx-plus'></i> Thêm đơn đặt phòng mới</button>
            <div class="search-box">
                <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm đơn đặt phòng...">
                <button type="submit" class="search-btn" onclick="showFormBooking('search-form')"><i class='bx bx-search'></i>
            </div>
        </div>
        <div class="limit-form">
            <form method="get">
                <input type="hidden" name="page" value="booking">
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
                        <th>Mã Homestay</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Ngày đặt phòng</th>
                        <th>Ngày nhận phòng</th>
                        <th>Ngày trả phòng</th>
                        <th>Số người</th>
                        <th>Trạng thái đặt phòng</th>
                        <th>Phương thức thanh toán</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái thanh toán</th>
                        <th>Chú thích của khách hàng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Xử lý tìm kiếm kết hợp bộ lọc
                    if (isset($_GET['content']) && $_GET['content'] !== '') {
                        $search_query = trim($_GET['content']);
                        $search = "%".$conn->real_escape_string($search_query)."%";

                        $search_where = "(booking_id LIKE '$search' 
                            OR homestay_id LIKE '$search' 
                            OR customer_name LIKE '$search' 
                            OR customer_email LIKE '$search' 
                            OR customer_phone LIKE '$search' 
                            OR created_at LIKE '$search' 
                            OR checkin_date LIKE '$search' 
                            OR checkout_date LIKE '$search' 
                            OR guests LIKE '$search'
                            OR payment_method LIKE '$search'
                            OR payment_status LIKE '$search'
                            OR payment_date LIKE '$search'  
                            OR total_price LIKE '$search' 
                            OR `status` LIKE '$search'
                            OR `payment_status` LIKE '$search'
                            OR note LIKE '$search')";
                        $full_where = $where ? $search_where . " AND " . implode(" AND ", $where) : $search_where;
                        $sql = "SELECT * FROM db_booking WHERE $full_where LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    } else if ($where_sql) {
                        $sql = "SELECT * FROM db_booking $where_sql LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    } else {
                        $sql = "SELECT * FROM db_booking LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    }
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                            <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['booking_id']; ?>"></td> 
                            <td><?php echo $row['booking_id'] ?></td>
                            <td><?php echo $row['homestay_id'] ?></td>
                            <td><?php echo $row['customer_name'] ?></td>
                            <td><?php echo $row['customer_email'] ?></td>
                            <td><?php echo $row['customer_phone'] ?></td>
                            <td><?php echo $row['created_at'] ?></td>
                            <td><?php echo $row['checkin_date'] ?></td>
                            <td><?php echo $row['checkout_date'] ?></td>
                            <td><?php echo $row['guests'] ?></td>
                            <td><?php echo $row['status'] ?></td>
                            <td><?php echo $row['payment_method'] ?></td>
                            <td><?php echo $row['total_price'] ?></td>
                            <td><?php echo $row['payment_status'] ?></td>
                            <td class="truncate-text"><?php echo $row['note'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormBooking('detail-form', '<?php echo $row['booking_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormBooking('edit-form', '<?php echo $row['booking_id']; ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteBooking('<?php echo $row['booking_id']; ?>')"><i class='bx bx-trash'></i></button>
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
                <a href="home.php?page=booking&pagetable&limit=<?= $limit . $contentParam ?>">&laquo;</a>
                <a href="home.php?page=booking&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit . $contentParam ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=booking&pagetable=<?= $i ?>&limit=<?= $limit . $contentParam ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=booking&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit . $contentParam ?>"> &gt;</a>
                <a href="home.php?page=booking&pagetable=<?= $total_pages ?>&limit=<?= $limit . $contentParam ?>"> &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</div>


<!----------------------------------------------------Giao diện thêm mới ------------------------------------------------>
<div class="form-container" id="add-form" style="display:<?php echo $is_add_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container" >
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
        <h2>Thêm Đơn Đặt Phòng Mới</h2>
        <form action="../modules/add_function.php" method="POST" enctype="multipart/form-data">
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Thông tin đơn đặt phòng</h3>
                    <div class="form-group">
                        <label for="homestay_id">Mã homestay:</label>
                        <select id="homestay_id" name="homestay_id" required>
                            <?php
                                $hst_sql = "SELECT homestay_id, homestay_name FROM db_homestay";
                                $hst_result = mysqli_query($conn, $hst_sql);

                                if ($hst_result && mysqli_num_rows($hst_result) > 0) {
                                    while ($row = mysqli_fetch_assoc($hst_result)) {
                                        $selected = ($row['homestay_id'] == $booking['homestay_id']) ? 'selected' : '';
                                        echo "<option value='{$row['homestay_id']}' $selected>{$row['homestay_id']} - {$row['homestay_name']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>Không có dữ liệu homestay</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="created_at">Ngày đặt phòng</label>
                        <input type="datetime-local" id="created_at" name="created_at" required>
                    </div>
                    <div class="form-group">
                        <label for="checkin_date">Ngày nhận phòng:</label>
                        <input type="date" id="checkin_date" name="checkin_date" required>
                    </div>
                    <div class="form-group">
                        <label for="checkout_date">Ngày trả phòng:</label>
                        <input type="date" id="checkout_date" name="checkout_date" required>
                    </div>
                    <div class="form-group">
                        <label for="guests">Số người:</label>
                        <input type="number" id="guests" name="guests" placeholder="Nhập số khách" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái đặt phòng:</label>
                        <select id="status" name="status">
                            <option value="Đã xác nhận">Đã xác nhận</option>
                            <option value="Chờ xác nhận">Chờ xác nhận</option>
                            <option value="Đã hủy">Đã hủy</option>
                        </select>
                    </div>
                </div>
                <div style="flex:1;">
                    <h3>Thông tin khách hàng</h3>
                    <div class="form-group">
                        <label for="customer_id">Mã Khách hàng:</label>
                        <input type="text" id="customer_id" name="customer_id" placeholder="Bỏ qua nếu là khách hàng mới">
                    </div>
                    <div class="form-group">
                        <label for="customer_name">Tên Khách hàng:</label>
                        <input type="text" id="customer_name" name="customer_name" placeholder="Nhập tên khách hàng" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_email">Email:</label>
                        <input type="text" id="customer_email" name="customer_email" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_phone">Số điện thoại:</label>
                        <input type="text" id="customer_phone" name="customer_phone" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <label for="note">Chú thích:</label>
                        <input type="text" id="note" name="note" placeholder="Ghi chú thêm">
                    </div>
                </div>
            </div>
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Thông tin thanh toán</h3>
                    <div class="form-group">
                        <label for="payment_method">Phương thức thanh toán:</label>
                        <select id="payment_method" name="payment_method">
                            <option value="Thanh toán khi trả phòng">Thanh toán khi nhận phòng</option>
                            <option value="VNPay">VNPay</option>
                            <option value="Momo">Momo</option>
                            <option value="Tiền mặt">Tiền mặt</option>
                            <option value="Đặt cọc">Đặt cọc</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="total_price">Tổng số tiền(VNĐ):</label>
                        <input type="number" id="total_price" name="total_price" placeholder="Nhập tổng tiền" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_status">Trạng thái thanh toán:</label>
                        <select id="payment_status" name="payment_status">
                            <option value="Chờ thanh toán">Chờ thanh toán</option>
                            <option value="Đã thanh toán">Đã thanh toán</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_date">Ngày thanh toán:</label>
                        <input type="date" id="payment_date" name="payment_date" placeholder="Bỏ qua nếu chưa thanh toán">
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align:right;">
                <button type="submit" name="submit_booking" class="add-btn">Thêm đơn đặt phòng</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>

<!---------------------------------------- Giao diện Cập nhật ----------------------------------------------->
<div class="form-container"id="update-form" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($booking) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormBooking('detail-form', '<?php echo $booking['booking_id']; ?>')"><i class='bx bx-detail'></i>Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteBooking('<?php echo $booking['booking_id']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        <h2>Sửa thông tin đơn đặt phòng</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Thông tin đơn đặt phòng</h3>
                    <div class="form-group">
                        <label for="booking_id">Mã đơn đặt phòng:</label>
                        <input type="text" id="booking_id" name="booking_id" value="<?php echo $booking['booking_id']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="homestay_id">Mã homestay:</label>
                        <select id="homestay_id" name="homestay_id" required>
                            <?php
                                $hst_sql = "SELECT homestay_id, homestay_name FROM db_homestay";
                                $hst_result = mysqli_query($conn, $hst_sql);

                                if ($hst_result && mysqli_num_rows($hst_result) > 0) {
                                    while ($row = mysqli_fetch_assoc($hst_result)) {
                                        $selected = ($row['homestay_id'] == $booking['homestay_id']) ? 'selected' : '';
                                        echo "<option value='{$row['homestay_id']}' $selected>{$row['homestay_id']} - {$row['homestay_name']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>Không có dữ liệu homestay</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="created_at">Ngày đặt phòng:</label>
                        <input type="datetime-local" id="created_at" name="created_at" value="<?php echo $booking['created_at']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="checkin_date">Ngày nhận phòng:</label>
                        <input type="date" id="checkin_date" name="checkin_date" value="<?php echo $booking['checkin_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="checkout_date">Ngày trả phòng:</label>
                        <input type="date" id="checkout_date" name="checkout_date" value="<?php echo $booking['checkout_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="guests">Số người:</label>
                        <input type="number" id="guests" name="guests" value="<?php echo $booking['guests']; ?>" placeholder="Nhập số khách" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái đặt phòng:</label>
                        <select id="status" name="status">
                            <option value="Đã xác nhận" <?php echo ($booking['status'] == 'Đã xác nhận') ? 'selected' : ''; ?>>Đã xác nhận</option>
                            <option value="Chờ xác nhận" <?php echo ($booking['status'] == 'Chờ xác nhận') ? 'selected' : ''; ?>>Chờ xác nhận</option>
                            <option value="Đã hủy" <?php echo ($booking['status'] == 'Đã hủy') ? 'selected' : ''; ?>>Đã hủy</option>
                        </select>
                    </div>
                </div>
                <div style="flex:1;">
                    <h3>Thông tin khách hàng</h3>
                    <div class="form-group">
                        <label for="customer_id">Mã Khách hàng:</label>
                        <select id="customer_id" name="customer_id">
                        <option value="">Khách hàng mới chưa có mã</option>
                            <?php
                                $user_sql = "SELECT customer_id, fullname FROM db_customer";
                                $user_result = mysqli_query($conn, $user_sql);

                                if ($user_result && mysqli_num_rows($user_result) > 0) {
                                    while ($row = mysqli_fetch_assoc($user_result)) {
                                        $selected = ($row['customer_id'] == $booking['customer_id']) ? 'selected' : '';
                                        echo "<option value='{$row['customer_id']}' $selected>{$row['customer_id']} - {$row['fullname']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>Khách hàng chưa có tài khoản</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="customer_name">Tên Khách hàng:</label>
                        <input type="text" id="customer_name" name="customer_name" value="<?php echo $booking['customer_name']; ?>" placeholder="Nhập tên khách hàng" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_email">Email:</label>
                        <input type="text" id="customer_email" name="customer_email" value="<?php echo $booking['customer_email']; ?>" placeholder="Nhập email" required>
                    </div>   
                    <div class="form-group">
                        <label for="customer_phone">Số điện thoại:</label>
                        <input type="text" id="customer_phone" name="customer_phone" value="<?php echo $booking['customer_phone']; ?>" placeholder="Nhập số điện thoại" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="note">Chú thích:</label>
                        <input type="text" id="note" name="note" value="<?php echo $booking['note']; ?>" placeholder="Ghi chú thêm">
                    </div>
                </div>
            </div>
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Thông tin thanh toán</h3>
                    <div class="form-group">
                        <label for="payment_method">Phương thức thanh toán:</label>
                        <select id="payment_method" name="payment_method">
                           <option value="Thanh toán khi trả phòng" <?php echo ($booking['payment_method'] == 'Thanh toán khi trả phòng') ? 'selected' : ''; ?>>Thanh toán khi nhận phòng</option>
                            <option value="VNPay" <?php echo ($booking['payment_method'] == 'VNPay') ? 'selected' : ''; ?> >VNPay</option>
                            <option value="Momo" <?php echo ($booking['payment_method'] == 'Momo') ? 'selected' : ''; ?> >Momo</option>
                            <option value="Tiền mặt" <?php echo ($booking['payment_method'] == 'Tiền mặt') ? 'selected' : ''; ?> >Tiền mặt</option>
                            <option value="Đặt cọc"<?php echo ($booking['payment_method'] == 'Đặt cọc') ? 'selected' : ''; ?> >Đặt cọc</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="total_price">Tổng số tiền(VNĐ):</label>
                        <input type="number" id="total_price" name="total_price" value="<?php echo $booking['total_price']; ?>" placeholder="Nhập tổng tiền" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_status">Trạng thái thanh toán:</label>
                        <select id="payment_status" name="payment_status">
                            <option value="Đã thanh toán" <?php echo ($booking['payment_status'] == 'Đã thanh toán') ? 'selected' : ''; ?>>Đã thanh toán</option>
                            <option value="Chờ thanh toán" <?php echo ($booking['payment_status'] == 'Chờ thanh toán') ? 'selected' : ''; ?>>Chờ thanh toán</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_date">Ngày thanh toán:</label>
                        <input type="datetime-local" id="payment_date" name="payment_date" value="<?php echo $booking['payment_date']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align:right;">
                <button type="submit" name="submit_booking" class="edit-btn">Cập Nhật thông tin</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
    <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin đơn đặt phòng để sửa.</p>
    <?php } ?>
</div>


<!------------------------------------------------Giao diện thông tin chi tiết --------------------------------------------------->
<div class="form-container" id="detail-form" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($booking) { ?>
   <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormBooking('edit-form', '<?php echo $booking['booking_id']; ?>')"><i class='bx bx-edit-alt'></i>Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteBooking('<?php echo $booking['booking_id']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        <h2>Chi tiết đơn đặt phòng:# <?php echo $booking['booking_id']; ?></h2>
        <div class="detail-grid">
            <div class="detail-section">
                    <h3>Thông tin đơn đặt phòng </h3>
                    <div class="info-group">
                        <label for="booking_id">Mã đơn đặt phòng:</label>
                        <p> <?php echo $booking['booking_id']; ?> </p>
                    </div>
                    
                    <div class="info-group">
                        <label for="homestay_id">Mã homestay:</label>
                        <p> <?php echo $booking['homestay_id']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="created_at">Ngày đặt phòng:</label>
                        <p> <?php echo $booking['created_at']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="checkin_date">Ngày nhận phòng:</label>
                        <p> <?php echo $booking['checkin_date']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="checkout_date">Ngày trả phòng:</label>
                        <p> <?php echo $booking['checkout_date']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="guests">Số người:</label>
                        <p> <?php echo $booking['guests']; ?> </p>
                    </div>
                    
                    <div class="info-group">
                        <label for="status" >Trạng thái:</label>
                        <p> <?php 
                            $text='';
                            $style='';
                            if($booking['status'] ==='Đã xác nhận'){
                                $text=  'Đã xác nhận';
                                $style= 'status-actived';
                            }else if($booking['status'] === 'Chờ xác nhận'){
                                $text=  'Chờ xác nhận';
                                $style= 'status-pending';
                            }else if($booking['status'] === 'Đã hủy'){
                                $text=  'Đã hủy';
                                $style= 'status-cancel';
                            }echo "<span class='" . $style . "'>" . $text . "</span>";?> </p>
                    </div>
                </div>

                <div class="detail-section ">
                    <h3>Thông tin khách hàng </h3>
                    <div class="info-group">
                        <label for="customer_id">Mã Khách hàng:</label>
                        <p> <?php echo $booking['customer_id']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="customer_name">Tên Khách hàng:</label>
                        <p> <?php echo $booking['customer_name']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="customer_email">Email:</label>
                        <p> <?php echo $booking['customer_email']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="customer_phone">Số điện thoại:</label>
                        <p> <?php echo $booking['customer_phone']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="note">Chú thích:</label>
                        <p> <?php echo $booking['note']; ?> </p>
                    </div>
                </div>
                <div class="detail-section ">
                    <h3>Thông tin thanh toán </h3>
                    <div class="info-group">
                        <label for="payment_method">Phương thức thanh toán:</label>
                        <p> <?php echo $booking['payment_method']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="total_price">Tổng số tiền(VNĐ):</label>
                        <p> <?php echo $booking['total_price']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="payment_status">Trạng thái thanh toán:</label>
                        <p><?php 
                            $text='';
                            $style='';
                            if($booking['payment_status'] ==='Đã thanh toán'){
                                $text=  'Đã thanh toán';
                                $style= 'status-completed';
                            }else if($booking['payment_status'] === 'Chờ thanh toán'){
                                $text=  'Chờ thanh toán';
                                $style= 'status-pending';
                            }echo "<span class='" . $style . "'>" . $text . "</span>";?>  </p>
                    </div>
                    <div class="info-group">
                        <label for="payment_date">Ngày thanh toán:</label>
                        <p> <?php echo $booking['payment_date']; ?> </p>
                    </div>
                </div>

        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin đơn đặt phòng.</p>
    <?php } ?>
</div>