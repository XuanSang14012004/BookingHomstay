<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';


$is_view_form = false;
$is_add_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_homestay') {
    $is_add_form = true;
} else if ($action === 'search_homestay') {
    $is_view_form = true;
} else if ($action === 'edit_homestay') {
    $is_edit_form = true;
} else if ($action === 'detail_homestay') {
    $is_detail_form = true;
} else {
    $is_view_form = true; // Trang chính

}

$homestay_id = isset($_GET['id']) ? $_GET['id'] : null;

$homestay = null;
if (($is_edit_form || $is_detail_form) && $homestay_id) {
    $result = $conn->query("SELECT * FROM db_homestay WHERE homestay_id = '$homestay_id'");
    if ($result && $result->num_rows > 0) {
        $homestay = mysqli_fetch_assoc($result);
    }
}
?>
<!-------------------------------------------------- Giao diện chính --------------------------------------------->
<div class="form-container" id="homestay-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
   <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý Homestay</h2>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormHomestay('add-form')"><i class='bx bx-plus'></i> Thêm Homestay mới</button>
                <div class="search-box">
                    <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm homestay...">
                    <button type="submit" class="search-btn" onclick="showFormHomestay('search-form')"><i class='bx bx-search'></i></button>
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
                        <th>Mã Homestay</th>
                        <th>Tên Homestay</th>
                        <th>Loại hình</th>
                        <th>Trạng thái hoạt động</th>
                        <th>Mô tả chi tiêt</th>
                        <th>Số phòng</th>
                        <th>Tiện nghi</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Email liên hệ</th>
                        <th>Giá thuê (VND)</th>
                        <th>Chính sách</th>
                        <th>Hình ảnh</th>
                        <th>Điểm đánh giá trung bình(/5)</th>
                        <th>Số lượt đánh giá đã nhận</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                         if( isset($_GET['content']) ? $_GET['content'] :'' ){
                            $search_query = trim($_GET['content']);
                            $search = "%".$search_query."%";

                            $sql = "SELECT * FROM db_homestay WHERE homestay_id LIKE '$search' 
                                OR homestay_name LIKE '$search' 
                                OR homestay_type LIKE '$search' 
                                OR homestay_status LIKE '$search' 
                                OR room_number LIKE '$search' 
                                OR email LIKE '$search' 
                                OR phone_owner LIKE '$search' 
                                OR home_price LIKE '$search' 
                                OR homestay_address LIKE '$search' 
                                OR rating_number LIKE '$search' 
                                OR `describe` LIKE '$search'
                                OR `policy` LIKE '$search'
                                OR amenities LIKE '$search'
                                OR home_rating LIKE '$search' "; 
                            $result = $conn->query($sql);
                            $i = 1;
                        }else
                            $result = $conn->query("SELECT * FROM db_homestay");
                            $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['homestay_id'] ?></td>
                            <td><?php echo $row['homestay_name'] ?></td>
                            <td><?php echo $row['homestay_type'] ?></td>
                            <td><?php echo $row['homestay_status'] ?></td>
                            <td class="truncate-text"><?php echo $row['describe'] ?></td>
                            <td><?php echo $row['room_number'] ?></td>
                            <td class="truncate-text"><?php echo $row['amenities'] ?></td>
                            <td class="truncate-text"><?php echo $row['homestay_address'] ?></td>
                            <td><?php echo $row['phone_owner'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td class="truncate-text"><?php echo $row['home_price'] ?></td>
                            <td class="truncate-text"><?php echo $row['policy'] ?></td>
                            <td><?php echo "<img src='../../Images/" .$row['image']. "' alt='Hình ảnh' style='width:100px;height:auto;'>"; ?></td>  
                            <td><?php echo $row['home_rating'] ?></td>
                            <td><?php echo $row['rating_number'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormHomestay('detail-form', '<?php echo $row['homestay_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormHomestay('edit-form', '<?php echo $row['homestay_id']; ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteHomestay('<?php echo $row['homestay_id']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>  
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-------------------------------------------------- Giao diện thêm mới --------------------------------------------->
<div class="form-container" id="add-form" style="display:<?php echo $is_add_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
            <h2>Thêm Homestay Mới</h2>
                <?php 
                    $lh_sql = "SELECT DISTINCT TRIM(homestay_type) as homestay_type FROM `db_homestay`";
                    $lh_result = mysqli_query($conn, $lh_sql);
                    $th_sql = "SELECT DISTINCT TRIM(homestay_status) as homestay_status FROM `db_homestay`";
                    $th_result = mysqli_query($conn, $th_sql);
                ?>
            <form action="../modules/add_function.php" method="POST" enctype="multipart/form-data">
                <div class="form-section">
                    <h3>Thông tin cơ bản</h3>
                    <div class="form-group">
                        <label for="homestay_id">Mã Homestay:</label>
                        <input type="text" id="homestay_id" name="homestay_id" required>
                    </div>
                    <div class="form-group">
                        <label for="homestay_name">Tên Homestay:</label>
                        <input type="text" id="homestay_name" name="homestay_name" required>
                    </div>
                    <div class="form-group">
                        <label for="homestay_type">Loại hình:</label>
                        <select id="homestay_type" name="homestay_type">
                            <?php
                            if ($lh_result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($lh_result)) {?>
                                <option value="<?php echo $row['homestay_type']; ?>">
                                    <?php echo $row['homestay_type']; ?>
                                </option>
                            <?php } 
                            } else {
                                echo "<option value=''>Không có dữ liệu</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="homestay_status">Trạng thái hoạt động:</label>
                        <select id="homestay_status" name="homestay_status">
                            <?php 
                        if ($th_result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($th_result)) {?>
                                <option value="<?php echo $row['homestay_status'];?>">
                                    <?php echo $row['homestay_status'];?>
                                </option>
                            <?php } 
                            } else {
                                echo "<option value=''>Không có dữ liệu</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room_number">Số phòng:</label>
                        <input type="number" id="room_number" name="room_number" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="home_price">Giá thuê trung bình (VNĐ/đêm):</label>
                        <input type="number" id="home_price" name="home_price" required>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Thông tin liên hệ & Địa chỉ</h3>
                    <div class="form-group">
                        <label for="phone_owner">Số điện thoại:</label>
                        <input type="tel" id="phone_owner" name="phone_owner" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email liên hệ:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="homestay_address">Địa chỉ:</label>
                        <textarea id="homestay_address" name="homestay_address" rows="3" required></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Chi tiết & Mô tả</h3>
                    <div class="form-group">
                        <label for="describe">Mô tả:</label>
                        <textarea id="describe" name="describe" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="amenities">Tiện nghi:</label>
                        <textarea id="amenities" name="amenities" rows="3"
                        placeholder="Ví dụ: Wifi, Bếp nấu ăn, Bãi đỗ xe..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="policy">Chính sách:</label>
                        <textarea id="policy" name="policy" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Hình ảnh:</label>
                        <input type="file" id="image" name="image" multiple accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="home_rating">Điểm đánh giá trung bình(/10):</label>
                        <input type="number" id="home_rating" name="home_rating" multiple accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="rating_number">Số lượt đánh giá đã nhận:</label>
                        <input type="number" id="rating_number" name="rating_number" multiple accept="image/*">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name ="submit_homestay" class="add-btn">Thêm Homestay</button>
                    <button type="reset"  class="cancel-btn">Hủy</button>
                </div>
            </form>
    </div>
</div>


<!-------------------------------------------------- Giao diện cập nhật--------------------------------------------->
<div class="form-container"id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($homestay) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormHomestay('detail-form', '<?php echo $homestay['homestay_id']; ?>')"><i class='bx bx-detail'></i> Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteHomestay('<?php echo $homestay['homestay_id']; ?>')"><i class='bx bx-trash'></i> Xóa thông tin</button>
            </div>
        </div>
        <h2>Cập nhật thông tin Homestay</h2>
            <?php 
                $lh_sql = "SELECT DISTINCT TRIM(homestay_type) as homestay_type FROM `db_homestay`";
                $lh_result = mysqli_query($conn, $lh_sql);
                $th_sql = "SELECT DISTINCT TRIM(homestay_status) as homestay_status FROM `db_homestay`";
                $th_result = mysqli_query($conn, $th_sql);
            ?>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="homestay_id" value="<?php echo $homestay['homestay_id']; ?>">

            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="homestay_id">Mã Homestay:</label>
                    <input type="text" name="homestay_id" value="<?php echo $homestay['homestay_id']; ?>">
                </div>
                <div class="form-group">
                    <label for="homestay_name">Tên Homestay:</label>
                    <input type="text" id="homestay_name" name="homestay_name" value="<?php echo $homestay['homestay_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="homestay_type">Loại hình:</label>
                    <select id="homestay_type" name="homestay_type">
                         <?php
                            if ($lh_result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($lh_result)) {?>
                                <option value="<?php echo $row['homestay_type']; ?>">
                                    <?php echo $row['homestay_type']; ?>
                                </option>
                            <?php } 
                            } else {
                                echo "<option value=''>Không có dữ liệu</option>";
                            }
                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="homestay_status">Trạng thái hoạt động:</label>
                    <select id="homestay_status" name="homestay_status">
                        <?php 
                        if ($th_result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($th_result)) {?>
                                <option value="<?php echo $row['homestay_status'];?>">
                                    <?php echo $row['homestay_status'];?>
                                </option>
                            <?php } 
                            } else {
                                echo "<option value=''>Không có dữ liệu</option>";
                            }
                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="room_number">Số phòng:</label>
                    <input type="number" id="room_number" name="room_number" value="<?php echo $homestay['room_number']; ?>" min="1" required>
                </div>
                <div class="form-group">
                    <label for="home_price">Giá thuê:</label>
                    <input type="number" id="home_price" name="home_price" value="<?php echo $homestay['home_price']; ?>" min="100" required>
                </div>
                <div class="form-group">
                    <label for="home_rating">Điểm đánh giá trung bình:</label>
                    <input type="number" id="home_rating" name="home_rating" value="<?php echo $homestay['home_rating']; ?>" min="1" required>
                </div>
                <div class="form-group">
                    <label for="rating_number">Số lượt đánh giá đã nhận:</label>
                    <input type="number" id="rating_number" name="rating_number" value="<?php echo $homestay['rating_number']; ?>" min="1" required>
                </div>
            </div>

            <div class="form-section">
                <h3>Thông tin liên hệ & Địa chỉ</h3>
                <div class="form-group">
                    <label for="phone_owner">Số điện thoại chủ homestay:</label>
                    <input type="tel" id="phone_owner" name="phone_owner" value="<?php echo $homestay['phone_owner']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email liên hệ:</label>
                    <input type="email" id="email" name="email" value="<?php echo $homestay['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="homestay_address">Địa chỉ:</label>
                    <textarea id="homestay_address" name="homestay_address" rows="3" required><?php echo $homestay['homestay_address']; ?></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>Chi tiết & Mô tả</h3>
                <div class="form-group">
                    <label for="describe">Mô tả:</label>
                    <textarea id="describe" name="describe" rows="5"><?php echo $homestay['describe']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="amenities">Tiện nghi:</label>
                    <textarea id="amenities" name="amenities" rows="3" placeholder="Ví dụ: Wifi, Bếp nấu ăn, Bãi đỗ xe..."><?php echo $homestay['amenities']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="policy">Chính sách:</label>
                    <textarea id="policy" name="policy" rows="3"><?php echo $homestay['policy']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Hình ảnh hiện tại:</label>
                    <img src="<?php echo $homestay['image']; ?>" alt="Hình ảnh homestay" style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                    <label for="image_new">Chọn ảnh mới để thay thế :</label>
                    <input type="file" id="image_new" name="image_new[]" multiple accept="image/*">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit_homestay" class="edit-btn">Cập Nhật Homestay</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
        <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin homestay để sửa.</p>
    <?php } ?>
</div>

<!-------------------------------------------------- Giao diện thông tin chi tiết --------------------------------------------->
<div class="form-container" id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($homestay) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormHomestay('edit-form', '<?php echo $homestay['homestay_id']; ?>')"><i class='bx bx-edit-alt'></i>Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteHomestay('<?php echo $homestay['homestay_id']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết Homestay</h2>

        <div class="detail-grid">
            <div class="detail-section">
                <h3>Thông tin cơ bản</h3>
                <div class="info-group">
                    <label>Tên Homestay:</label>
                    <p><?php echo $homestay['homestay_name']; ?></p>
                </div>
                <div class="info-group">
                    <label>Mã Homestay:</label>
                    <p><?php echo $homestay['homestay_id']; ?></p>
                </div>
                <div class="info-group">
                    <label>Loại hình:</label>
                    <p><?php echo $homestay['homestay_type']; ?></p>
                </div>
                <div class="info-group">
                    <label>Số phòng:</label>
                    <p><?php echo $homestay['room_number']; ?></p>
                </div>
                <div class="info-group">
                    <label>Trạng thái hoạt động:</label>
                    <p class="status-active"><?php echo $homestay['homestay_status']; ?></p>
                </div>
            </div>

            <div class="detail-section">
                <h3>Mô tả & Tiện nghi</h3>
                <div class="info-group">
                    <label>Mô tả:</label>
                    <p><?php echo $homestay['describe']; ?></p>
                </div>
                <div class="info-group">
                    <label>Tiện nghi:</label>
                    <span>
                        <?php 
                        $temp = $homestay['amenities'];
                        $amenities = str_replace(',', '<br>', $temp);
                        ?>
                        <p><?php echo $amenities;?> </p>
                </span>
                </div>
                <div class="info-group">
                    <label>Chính sách:</label>
                    <p><?php echo $homestay['policy']; ?></p>
                </div>
            </div>

            <div class="detail-section">
                <h3>Địa chỉ & Liên hệ</h3>
                <div class="info-group">
                    <label>Địa chỉ:</label>
                    <p><?php echo $homestay['homestay_address']; ?></p>
                </div>
                <div class="info-group">
                    <label>Số điện thoại:</label>
                    <p><?php echo $homestay['phone_owner']; ?></p>
                </div>
                <div class="info-group">
                    <label>Email liên hệ:</label>
                    <p><?php echo $homestay['email']; ?></p>
                </div>
            </div>

            <div class="detail-section">
                <h3>Hình ảnh Homestay</h3>
                <div class="images-gallery">
                    <img src="../../../images/image1.jpg" alt="Hình ảnh Homestay 1">
                    <img src="../../../images/image2.jpg" alt="Hình ảnh Homestay 2">
                    <img src="../../../images/image3.jpg" alt="Hình ảnh Homestay 3">
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin homestay.</p>
    <?php } ?>
</div>