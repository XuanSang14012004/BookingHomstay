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
?>
<!------------------------------------------------------------ Giao diện chính --------------------------------------------------->
<div class="form-container" id="booking-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
   <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý Đặt phòng</h2>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormBooking('add-form')"><i class='bx bx-plus'></i> Thêm đơn đặt phòng mới</button>
            <div class="search-box">
                <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm đơn đặt phòng...">
                <button type="submit" class="search-btn" onclick="showFormBooking('search-form')"><i class='bx bx-search'></i>
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
                            $search = "%".$search_query."%";

                            $sql = "SELECT * FROM db_booking WHERE booking_id LIKE '$search' 
                                OR customer_id LIKE '$search' 
                                OR customer_name LIKE '$search' 
                                OR homestay_id LIKE '$search' 
                                OR room_id LIKE '$search' 
                                OR booking_people LIKE '$search' 
                                OR date_booking LIKE '$search' 
                                OR date_checkin LIKE '$search' 
                                OR date_checkout LIKE '$search' 
                                OR note LIKE '$search' 
                                OR booking_price LIKE '$search' 
                                OR booking_status LIKE '$search' "; 
                            $result = $conn->query($sql);
                            $i = 1;
                        }else{
                            $result = $conn->query("SELECT * FROM db_booking");
                            $i = 1;
                        }
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['booking_id'] ?></td>
                            <td><?php echo $row['customer_id'] ?></td>
                            <td><?php echo $row['customer_name'] ?></td>
                            <td><?php echo $row['homestay_id'] ?></td>
                            <td><?php echo $row['room_id'] ?></td>
                            <td><?php echo $row['date_booking'] ?></td>
                            <td><?php echo $row['date_checkin'] ?></td>
                            <td><?php echo $row['date_checkout'] ?></td>
                            <td><?php echo $row['booking_people'] ?></td>
                            <td><?php echo $row['booking_price'] ?></td>
                            <td><?php echo $row['booking_status'] ?></td>
                            <td class="truncate-text"><?php echo $row['note'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormBooking('detail-form', '<?php echo $row['booking_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormBooking('edit-form', '<?php echo $row['booking_id']; ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteBooking('<?php echo $row['booking_id']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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
            <?php 
                $th_sql = "SELECT DISTINCT TRIM(booking_status) as booking_status FROM `db_booking`";
                $th_result = mysqli_query($conn, $th_sql);
            ?>
            <form action="../modules/add_function.php" method="POST" enctype="multipart/form-data">
                <div class="form-section">
                    <h3>Thông tin cơ bản về đơn đặt phòng</h3>
                    <div class="form-group">
                        <label for="booking_id">Mã đơn đặt phòng:</label>
                        <input type="text" id="booking_id" name="booking_id" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_id">Mã Khách hàng:</label>
                        <input type="text" id="customer_id" name="customer_id" required>
                    </div>
                    <div class="form-group">
                        <label for="homestay_id">Mã homestay:</label>
                        <input type="text" id="homestay_id" name="homestay_id" required>
                    </div>
                    <div class="form-group">
                        <label for="room_id">Mã phòng:</label>
                        <input type="text" id="room_id" name="room_id" required>
                    </div>
                    <div class="form-group">
                        <label for="date_booking">Ngày đặt phòng</label>
                        <input type="date" id="date_booking" name="date_booking" required>
                    </div>
                    <div class="form-group">
                        <label for="booking_status">Trạng thái:</label>
                        <select id="booking_status" name="booking_status">
                            <?php 
                        if ($th_result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($th_result)) {?>
                                <option value="<?php echo $row['booking_status'];?>">
                                    <?php echo $row['booking_status'];?>
                                </option>
                            <?php } 
                            } else {
                                echo "<option value=''>Không có dữ liệu</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Thông tin khách hàng đặt phòng</h3>
                    <div class="form-group">
                        <label for="customer_name">Tên Khách hàng:</label>
                        <input type="text" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="form-group">
                        <label for="date_checkin">Ngày nhận phòng:</label>
                        <input type="date" id="date_checkin" name="date_checkin" required>
                    </div>
                    <div class="form-group">
                        <label for="date_checkout">Ngày trả phòng:</label>
                        <input type="date" id="date_checkout" name="date_checkout" required>
                    </div>
                    <div class="form-group">
                        <label for="booking_people">Số người:</label>
                        <input type="number" id="booking_people" name="booking_people" required></input>
                    </div>
                    <div class="form-group">
                        <label for="booking_price">Tổng số tiền(VNĐ):</label>
                        <input type="number" id="booking_price" name="booking_price" required>
                    </div>
                    <div class="form-group">
                        <label for="note">Chú thích:</label>
                        <input type="text" id="note" name="note" required>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" name="submit_booking" class="add-btn">Thêm đơn đặt phòng</button>
                    <button type="reset" class="cancel-btn">Hủy</button>
                </div>
            </form>
    </div>
</div>

<!---------------------------------------- Giao diện Cập nhật ----------------------------------------------->
<div class="form-container"id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
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
        <?php 
                $th_sql = "SELECT DISTINCT TRIM(booking_status) as booking_status FROM `db_booking`";
                $th_result = mysqli_query($conn, $th_sql);
            ?>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                <div class="form-section">
                    <h3>Thông tin cơ bản về đơn đặt phòng</h3>
                    <div class="form-group">
                        <label for="booking_id">Mã đơn đặt phòng:</label>
                        <input type="text" id="booking_id" name="booking_id" value="<?php echo $booking['booking_id']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_id">Mã Khách hàng:</label>
                        <input type="text" id="customer_id" name="customer_id" value="<?php echo $booking['customer_id']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="homestay_id">Mã homestay:</label>
                        <input type="text" id="homestay_id" name="homestay_id" value="<?php echo $booking['homestay_id']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="room_id">Mã phòng:</label>
                        <input type="text" id="room_id" name="room_id" value="<?php echo $booking['room_id']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="date_booking">Ngày đặt phòng:</label>
                        <input type="date" id="date_booking" name="date_booking" value="<?php echo $booking['date_booking']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="booking_status">Trạng thái:</label>
                        <select id="booking_status" name="booking_status">
                            <option value="Đã xác nhận" <?php echo ($booking['booking_status'] == 'Đã xác nhận') ? 'selected' : ''; ?>>Đã xác nhận</option>
                            <option value="Chờ xác nhận" <?php echo ($booking['booking_status'] == 'Chờ xác nhận') ? 'selected' : ''; ?>>Chờ xác nhận</option>
                            <option value="Đã hủy" <?php echo ($booking['booking_status'] == 'Đã hủy') ? 'selected' : ''; ?>>Đã hủy</option>
                        </select>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Thông tin khách hàng đặt phòng</h3>
                    <div class="form-group">
                        <label for="customer_name">Tên Khách hàng:</label>
                        <input type="text" id="customer_name" name="customer_name" value="<?php echo $booking['customer_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="date_checkin">Ngày nhận phòng:</label>
                        <input type="date" id="date_checkin" name="date_checkin" value="<?php echo $booking['date_checkin']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="date_checkout">Ngày trả phòng:</label>
                        <input type="date" id="date_checkout" name="date_checkout" value="<?php echo $booking['date_checkout']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="booking_people">Số người:</label>
                        <input type="number" id="booking_people" name="booking_people" value="<?php echo $booking['booking_people']; ?>" required></input>
                    </div>
                    <div class="form-group">
                        <label for="booking_price">Tổng số tiền(VNĐ):</label>
                        <input type="number" id="booking_price" name="booking_price" value="<?php echo $booking['booking_price']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="note">Chú thích:</label>
                        <input type="text" id="note" name="note" value="<?php echo $booking['note']; ?>" required>
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


<!------------------------------------------------Giao diện thông tin chi tiết --------------------------------------------------->
<div class="form-container" id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
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
                    <h3>Thông tin cơ bản </h3>
                    <div class="info-group">
                        <label for="booking_id">Mã đơn đặt phòng:</label>
                        <p> <?php echo $booking['booking_id']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="customer_id">Mã Khách hàng:</label>
                        <p> <?php echo $booking['customer_id']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="homestay_id">Mã homestay:</label>
                        <p> <?php echo $booking['homestay_id']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="room_id">Mã phòng:</label>
                        <p> <?php echo $booking['room_id']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="date_booking">Ngày đặt phòng:</label>
                        <p> <?php echo $booking['date_booking']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="booking_status" >Trạng thái:</label>
                        <p class="status-active"> <?php echo $booking['booking_status']; ?> </p>
                    </div>
                </div>

                <div class="detail-section ">
                    <h3>Thông tin khách hàng </h3>
                    <div class="info-group">
                        <label for="customer_name">Tên Khách hàng:</label>
                        <p> <?php echo $booking['customer_name']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="date_checkin">Ngày nhận phòng:</label>
                        <p> <?php echo $booking['date_checkin']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="date_checkout">Ngày trả phòng:</label>
                        <p> <?php echo $booking['date_checkout']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="booking_people">Số người:</label>
                        <p> <?php echo $booking['booking_people']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="booking_price">Tổng số tiền(VNĐ):</label>
                        <p> <?php echo $booking['booking_price']; ?> </p>
                    </div>
                    <div class="info-group">
                        <label for="note">Chú thích:</label>
                        <p> <?php echo $booking['note']; ?> </p>
                    </div>
                </div>

        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin đơn đặt phòng.</p>
    <?php } ?>
</div>