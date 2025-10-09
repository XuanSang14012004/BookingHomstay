<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_room') {
    $is_add_form = true;
} else if ($action === 'edit_room') {
    $is_edit_form = true;
} else if ($action === 'search_room') {
    $is_view_form = true;
} else if ($action === 'detail_room') {
    $is_detail_form = true;
} else {
    $is_view_form = true; // Trang chính

}

$room_id = isset($_GET['id']) ? $_GET['id'] : null;

$rooms = null;
if (($is_edit_form || $is_detail_form) && $room_id) {
    $result = $conn->query("SELECT * FROM db_room WHERE room_id = '$room_id'");
    if ($result && $result->num_rows > 0) {
        $rooms = mysqli_fetch_assoc($result);
    }
}
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) as total FROM db_room");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>

<!----------------------------------- Giao diện chính ---------------------------------------------->
<div class="form-container" id="room-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý Phòng</h2>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormRoom('add-form')"><i class='bx bx-plus'></i> Thêm phòng mới</button>
            <div class="search-box">
                <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm phòng...">
                <button type="submit" class="search-btn" onclick="showFormRoom('search-form')"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <div class="limit-form">
            <form method="get">
                <input type="hidden" name="page" value="rooms">
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
                        <th>Thuộc Homestay</th>
                        <th>Mã Phòng</th>
                        <th>Tên Phòng</th>
                        <th>Loại phòng</th>
                        <th>Mô tả chi tiết</th>
                        <th>Số người tối đa</th>
                        <th>Giá phòng(/Đêm)</th>
                        <th>Trạng thái</th>
                        <th>Hình ảnh</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        if( isset($_GET['content']) ? $_GET['content'] :'' ){
                            $search_query = trim($_GET['content']);
                            $search = "%$search_query%";

                            $sql = "SELECT * FROM db_room WHERE room_id LIKE '$search' 
                                OR homestay_name LIKE '$search' 
                                OR room_name LIKE '$search' 
                                OR room_type LIKE '$search' 
                                OR room_people LIKE '$search' 
                                OR room_price LIKE '$search' 
                                OR room_describe LIKE '$search'
                                OR room_status LIKE '$search'
                                LIMIT $limit OFFSET $offset "; 
                            
                            $result = $conn->query($sql);
                        }else{
                            $result = $conn->query("SELECT * FROM db_room LIMIT $limit OFFSET $offset");
                        }
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['room_id']; ?>"></td> 
                                <td><?php echo $row['homestay_name'] ?></td>
                                <td><?php echo $row['room_id'] ?></td>
                                <td><?php echo $row['room_name'] ?></td>
                                <td><?php echo $row['room_type'] ?></td>
                                <td class="truncate-text"><?php echo $row['room_describe'] ?></td>
                                <td><?php echo $row['room_people'] ?></td>
                                <td><?php echo $row['room_price'] ?></td>
                                <td><?php echo $row['room_status'] ?></td>
                                <td><?php echo "<img src='../../Images/" .$row['image_room']. "' alt='Hình ảnh' style='width:100px;height:auto;'>"; ?></td>  
                                <td class="actions">
                                    <button class="detail-btn" title="Chi tiết" onclick="showFormRoom('detail-form', '<?php echo $row['room_id'] ?>')"><i class='bx bx-detail'></i></button>
                                    <button class="edit-btn" title="Sửa" onclick="showFormRoom('edit-form', '<?php echo $row['room_id'] ?>')"><i class='bx bx-edit-alt'></i></button>
                                    <button class="delete-btn" title="Xóa" onclick="deleteRoom('<?php echo $row['room_id'] ?>')"><i class='bx bx-trash'></i></button>
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
                <a href="home.php?page=rooms&pagetable&limit=<?= $limit ?>">&laquo;</a>
                <a href="home.php?page=rooms&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=rooms&pagetable=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=rooms&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit ?>"> &gt;</a>
                <a href="home.php?page=rooms&pagetable=<?= $total_pages ?>&limit=<?= $limit ?>"> &raquo;</a>
            <?php endif; ?>
        </div>  
    </div>
</div>

<!----------------------------------- Giao diện thêm mới ---------------------------------------------->
<div class="form-container" id="add-form" style="display:<?php echo $is_add_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container form-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
        <h2>Thêm Phòng Mới</h2>
        <?php 
            $hst_sql = "SELECT DISTINCT TRIM(homestay_name) as homestay_name FROM `db_room`";
            $hst_result = mysqli_query($conn, $hst_sql);
        ?>
        <form action="../modules/add_function.php" method="POST" enctype="multipart/form-data">
            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="homestay_name">Thuộc Homestay:</label>
                    <select id="homestay_name" name="homestay_name" required>
                        <?php
                            if ($hst_result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($hst_result)) {?>
                                <option value="<?php echo $row['homestay_name']; ?>">
                                    <?php echo $row['homestay_name']; ?>
                                </option>
                            <?php } 
                            } else {
                                echo "<option value=''>Không có dữ liệu</option>";
                            }
                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="room_id">Mã Phòng:</label>
                    <input type="text" id="room_id" name="room_id" required>
                </div>
                <div class="form-group">
                    <label for="room_name">Tên Phòng:</label>
                    <input type="text" id="room_name" name="room_name" required>
                </div>
                <div class="form-group">
                    <label for="room_type">Loại Phòng:</label>
                    <input type="text" id="room_type" name="room_type" required>
                </div>
            </div>
            <div class="form-section">
                <h3>Thông tin chi tiết</h3>
                <div class="form-group">
                    <label for="room_describe">Mô tả phòng:</label>
                    <textarea id="room_describe" name="room_describe" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="room_people">Số người tối đa:</label>
                    <input type="number" id="room_people" name="room_people" min="1" required>
                </div>
                <div class="form-group">
                    <label for="room_price">Giá thuê (VNĐ/đêm):</label>
                    <input type="number" id="room_price" name="room_price" required>
                </div>
                <div class="form-group">
                    <label for="room_status">Trạng thái:</label>
                    <select id="room_status" name="room_status">
                        <option value="Đang trống">Đang trống</option>
                        <option value="Đã đặt" >Đã đặt</option>
                        <option value="Đang bảo trì" >Chờ thanh toán</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image_room">Hình ảnh:</label>
                    <input type="file" id="image_room" name="image_room" multiple accept="image/*">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit_room" class="add-btn">Thêm Phòng</button>
                <button type="reset"  class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>


<!----------------------------------- Giao diện cập nhật ---------------------------------------------->
<div class="form-container" id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($rooms) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormRoom('detail-form', '<?php echo $rooms['room_id'] ?>')"><i class='bx bx-detail'></i>Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteRoom('<?php echo $rooms['room_id'] ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        <h2>Sửa thông tin phòng</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="homestay_name">Thuộc Homestay:</label>
                    <select id="homestay_name" name="homestay_name" required> 
                        <?php
                            $hst_sql = "SELECT DISTINCT TRIM(homestay_name) AS homestay_name FROM db_room";
                            $hst_result = mysqli_query($conn, $hst_sql);

                            if ($hst_result && mysqli_num_rows($hst_result) > 0) {
                                while ($row = mysqli_fetch_assoc($hst_result)) {
                                    $selected = ($row['homestay_name'] == trim($rooms['homestay_name'])) ? 'selected' : '';
                                    echo "<option value='{$row['homestay_name']}' $selected>{$row['homestay_name']}</option>";
                                }
                            } else {
                                echo "<option value=''>Không có dữ liệu</option>";
                            }
                            ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="room_id">Mã Phòng:</label>
                    <input type="text" id="room_id" name="room_id" value="<?php echo $rooms['room_id']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="room_name">Tên Phòng:</label>
                    <input type="text" id="room_name" name="room_name" value="<?php echo $rooms['room_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="room_type">Loại Phòng:</label>
                    <input type="text" id="room_type" name="room_type" value="<?php echo $rooms['room_type']; ?>" required>
                </div>
            </div>
            <div class="form-section">
                <h3>Thông tin chi tiết</h3>
                <div class="form-group">
                    <label for="room_describe">Mô tả phòng:</label>
                    <input type="text" id="room_describe" name="room_describe" value="<?php echo $rooms['room_describe']; ?>"></input>
                </div>
                <div class="form-group">
                    <label for="room_people">Số người tối đa:</label>
                    <input type="number" id="room_people" name="room_people" min="1" value="<?php echo $rooms['room_people']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="room_price">Giá thuê (VNĐ/đêm):</label>
                    <input type="number" id="room_price" name="room_price" value="<?php echo $rooms['room_price']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="room_status">Trạng thái:</label>
                    <select id="room_status" name="room_status">
                        <option value="Đang trống" <?php echo ($rooms['room_status'] == 'Đang trống') ? 'selected' : ''; ?>>Đang trống</option>
                        <option value="Đã đặt" <?php echo ($rooms['room_status'] == 'Đã đặt') ? 'selected' : ''; ?>>Đã đặt</option>
                        <option value="Đang bảo trì"<?php echo ($rooms['room_status'] == 'Đang bảo trì') ? 'selected' : ''; ?>>Đang bảo trì</option>
                        <option value="Đang vệ sinh"<?php echo ($rooms['room_status'] == 'Đang vệ sinh') ? 'selected' : ''; ?>>Đang vệ sinh</option>
                        <option value="Đã xóa"<?php echo ($rooms['room_status'] == 'Đã xóa') ? 'selected' : ''; ?>>Đã xóa</option>

                    </select>
                </div>
                <div class="form-group">
                    <label for="image_room">Hình ảnh hiện tại:</label>
                    <img src="../../Images/<?php echo $rooms['image_room']; ?>" alt="Hình ảnh homestay" style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                    <label for="image_room">Chọn ảnh mới để thay thế :</label>
                    <input type="file" id="image_room" name="image_room" multiple accept="image/*" value="<?php echo $rooms['image_room']; ?>">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="submit_room" class="edit-btn">Cập Nhật thông tin</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
     <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin phòng để sửa.</p>
    <?php } ?>
</div>

<!----------------------------------- Giao diện thông tin chi tiết ---------------------------------------------->
<div class="form-container"id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($rooms) { ?>
<?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormRoom('edit-form', '<?php echo $rooms['room_id'] ?>')"><i class='bx bx-edit-alt'></i>Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteRoom('<?php echo $rooms['room_id'] ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết phòng</h2>

        <div class="detail-grid">
            <div class="detail-section">
                <div class="info-group">
                    <label for="homestay_name">Thuộc Homestay:</label>
                    <p> <?php echo $rooms['homestay_name']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="room_id">Mã Phòng:</label>
                    <p> <?php echo $rooms['room_id']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="room_name">Tên Phòng:</label>
                    <p> <?php echo $rooms['room_name']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="room_type">Loại Phòng:</label>
                    <p> <?php echo $rooms['room_type']; ?> </p>
                </div>
            </div>
            <div class="detail-section">
                <h3>Thông tin chi tiết</h3>
                <div class="info-group">
                    <label for="room_describe">Mô tả phòng:</label>
                    <p> <?php echo $rooms['room_describe']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="room_people">Số người tối đa:</label>
                    <p> <?php echo $rooms['room_people']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="room_price">Giá thuê (VNĐ/đêm):</label>
                    <p> <?php echo $rooms['room_price']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="room_status">Trạng thái:</label>
                    <p> <?php 
                            $text='';
                            $style='';
                            if($rooms['room_status'] ==='Đang trống'){
                                $text=  'Đang trống';
                                $style= 'status-actived';
                            }else if($rooms['room_status'] === 'Đang dọn dẹp'){
                                $text=  'Đang bảo trì';
                                $style= 'status-pending';
                            }else if($rooms['room_status'] === 'Đã đặt'){
                                $text=  'Đã đặt';
                                $style= 'status-completed';
                            }
                            echo "<span class='" . $style . "'>" . $text . "</span>";?>
                    </p>
                </div>
            </div>
            <div class="detail-section">
                <h3>Hình ảnh Homestay</h3>
                <div class="images-gallery">
                    <img src="../../Images/<?php echo $rooms['image_room']; ?>" alt="Hình ảnh Homestay 1">
                    <img src="../../Images/<?php echo $rooms['image_room']; ?>" alt="Hình ảnh Homestay 2">
                    <img src="../../Images/<?php echo $rooms['image_room']; ?>" alt="Hình ảnh Homestay 3">
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin phòng.</p>
    <?php } ?>
</div>