<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_search_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_room') {
    $is_add_form = true;
} else if ($action === 'edit_room') {
    $is_edit_form = true;
} else if ($action === 'search_room') {
    $is_search_form = true;
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
?>
<div class="form-container" id="room-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Quản lí phòng</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download PDF</span>
    </a>
</div>
<div class="management-container">
    <h2>Quản lý Phòng</h2>
    <div class="toolbar">
        <button class="add-btn" onclick="showFormRoom('add-form')"><i class='bx bx-plus'></i> Thêm phòng mới</button>
        <div class="search-box">
            <input type="text" id="search" name="timkiem" placeholder="Tìm kiếm phòng...">
            <button type="submit" class="search-btn" onclick="showFormRoom('search-form')"><i class='bx bx-search'></i></button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>STT</th>
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
                    $result = $conn->query("SELECT * FROM db_room");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['homestay_name'] ?></td>
                        <td><?php echo $row['room_id'] ?></td>
                        <td><?php echo $row['room_name'] ?></td>
                        <td><?php echo $row['room_type'] ?></td>
                        <td class="truncate-text"><?php echo $row['room_describe'] ?></td>
                        <td><?php echo $row['room_people'] ?></td>
                        <td><?php echo $row['room_price'] ?></td>
                        <td><?php echo $row['room_status'] ?></td>
                        <td><?php echo $row['image_room'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" onclick="showFormRoom('detail-form', '<?php echo $row['room_id'] ?>')"><i class='bx bx-detail'></i></button>
                            <button class="edit-btn" title="Sửa" onclick="showFormRoom('edit-form', '<?php echo $row['room_id'] ?>')"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa" onclick="deleteRoom('<?php echo $row['room_id'] ?>')"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>


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
                    <a>Quản lí Phòng</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active">Thêm thông tin phòng mới</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="management-container form-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
        <h2>Thêm Phòng Mới</h2>
        <form action="../modules/Create/add_function.php" method="POST" enctype="multipart/form-data">
            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="homestay_name">Thuộc Homestay:</label>
                    <select id="homestay_name" name="homestay_name" required>
                        <option value="HST_01">Homestay Vọng Nguyệt</option>
                        <option value="HST_02">Nhà Của Gió</option>
                        <option value="HST_03">Biệt Thự Đồi</option>
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
                    <select id="room_type" name="room_type" required>
                        <option value="pdon">Phòng Đơn</option>
                        <option value="pdoi">Phòng Đôi</option>
                        <option value="pgiadinh">Phòng Gia Đình</option>
                        <option value="psuite">Phòng Suite</option>
                    </select>
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
                    <input type="text" id="room_status" name="room_status" rows="4"></input>
                </div>
                <div class="form-group">
                    <label for="image_room">Hình ảnh:</label>
                    <input type="file" id="image_room" name="image_room[]" multiple accept="image/*">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit_room" class="add-btn">Thêm Phòng</button>
                <button type="reset"  class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>



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
                <a class="active" href="#">Quản lí phòng</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download PDF</span>
    </a>
</div>
<div class="management-container">
    <h2>Quản lý Phòng</h2>
    <div class="toolbar">
        <button class="add-btn" onclick="showFormRoom('add-form')"><i class='bx bx-plus'></i> Thêm phòng mới</button>
        <div class="search-box">
            <input type="text" id="search" name="timkiem" placeholder="Tìm kiếm phòng...">
            <button type="submit" class="search-btn" onclick="showFormRoom('search-form')"><i class='bx bx-search'></i></button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>STT</th>
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

                            $sql = "SELECT * FROM db_room WHERE room_id LIKE '$search' OR homestay_name LIKE '$search' OR room_name LIKE '$search' OR room_type LIKE '$search' 
                            OR room_people LIKE '$search' OR room_price LIKE '$search' OR room_status LIKE '$search' "; 
                            $result = $conn->query($sql);} 
                            $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['homestay_name'] ?></td>
                        <td><?php echo $row['room_id'] ?></td>
                        <td><?php echo $row['room_name'] ?></td>
                        <td><?php echo $row['room_type'] ?></td>
                        <td class="truncate-text"><?php echo $row['room_describe'] ?></td>
                        <td><?php echo $row['room_people'] ?></td>
                        <td><?php echo $row['room_price'] ?></td>
                        <td><?php echo $row['room_status'] ?></td>
                        <td><?php echo $row['image_room'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" onclick="showFormRoom('detail-form', '<?php echo $row['room_id'] ?>')"><i class='bx bx-detail'></i></button>
                            <button class="edit-btn" title="Sửa" onclick="showFormRoom('edit-form', '<?php echo $row['room_id'] ?>')"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa" onclick="deleteRoom('<?php echo $row['room_id'] ?>')"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>


<div class="form-container" id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($rooms) { ?>
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a>Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a>Quản lí phòng</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active">Cập nhật thông tin phòng</a>
                </li>
            </ul>
        </div>
    </div>
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
            <input type="hidden" name="room_id" value="<?php echo $rooms['room_id']; ?>">
            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="homestay_name">Thuộc Homestay:</label>
                    <select id="homestay_name" name="homestay_name" required>
                        <option value="HST_001" <?php echo ($rooms['homestay_name'] == 'HST_001') ? 'selected' : ''; ?>>Homestay Vọng Nguyệt</option>
                        <option value="HST_002" <?php echo ($rooms['homestay_name'] == 'HST_002') ? 'selected' : ''; ?>>Nhà Của Gió</option>
                        <option value="HST_003" <?php echo ($rooms['homestay_name'] == 'HST_003') ? 'selected' : ''; ?>>Biệt Thự Đồi</option>
                        <option value="khac" <?php echo ($rooms['homestay_name'] == 'khac') ? 'selected' : ''; ?>>Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="room_id">Mã Phòng:</label>
                    <input type="text" id="room_id" name="room_id" value="<?php echo $rooms['room_id']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="room_name">Tên Phòng:</label>
                    <input type="text" id="room_name" name="room_name" value="<?php echo $rooms['room_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="room_type">Loại Phòng:</label>
                    <select id="room_type" name="room_type" required>
                        <option value="P_01" <?php echo ($rooms['room_type'] == 'P_01') ? 'selected' : ''; ?>>Phòng Đơn</option>
                        <option value="P_02" <?php echo ($rooms['room_type'] == 'P_02') ? 'selected' : ''; ?>>Phòng Đôi</option>
                        <option value="P_03" <?php echo ($rooms['room_type'] == 'P_03') ? 'selected' : ''; ?>>Phòng Gia Đình</option>
                        <option value="P_04" <?php echo ($rooms['room_type'] == 'P_04') ? 'selected' : ''; ?>>Phòng Suite</option>
                    </select>
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
                    <input type="text" id="room_status" name="room_status" rows="4" value="<?php echo $rooms['room_status']; ?>"></input>
                </div>
                <div class="form-group">
                    <label for="image_room">Hình ảnh:</label>
                    <input type="image" id="image_room" name="image_room" value="<?php echo $rooms['image_room']; ?>">
                    <input type="file" id="image_room" name="image_room[]" multiple accept="image/*" value="<?php echo $rooms['image_room']; ?>">
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


<div class="form-container"id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($rooms) { ?>

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
                    <a class="active">Thông tin chi tiết phòng</a>
                </li>
            </ul>
        </div>
    </div>
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
                    <p> <?php echo $rooms['room_status']; ?> </p>
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
        <p>Không tìm thấy thông tin phòng.</p>
    <?php } ?>
</div>