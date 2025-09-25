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

$maphong = isset($_GET['id']) ? $_GET['id'] : null;

$rooms = null;
if (($is_edit_form || $is_detail_form) && $maphong) {
    $result = $conn->query("SELECT * FROM db_phong WHERE maphong = '$maphong'");
    if ($result && $result->num_rows > 0) {
        $rooms = mysqli_fetch_assoc($result);
    }
}
?>
<!-------------------------------------- Giao diện ------------------------------->
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
                    $result = $conn->query("SELECT * FROM db_phong");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['tenhomestay'] ?></td>
                        <td><?php echo $row['maphong'] ?></td>
                        <td><?php echo $row['tenphong'] ?></td>
                        <td><?php echo $row['loaiphong'] ?></td>
                        <td class="truncate-text"><?php echo $row['mota'] ?></td>
                        <td><?php echo $row['succhua'] ?></td>
                        <td><?php echo $row['gia'] ?></td>
                        <td><?php echo $row['trangthai'] ?></td>
                        <td><?php echo $row['hinhanh'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" onclick="showFormRoom('detail-form', '<?php echo $row['maphong'] ?>')"><i class='bx bx-detail'></i></button>
                            <button class="edit-btn" title="Sửa" onclick="showFormRoom('edit-form', '<?php echo $row['maphong'] ?>')"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa" onclick="deleteRoom('<?php echo $row['maphong'] ?>')"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>


<!-------------------------------------- Thêm ------------------------------->
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
            <a href="home.php?page=rooms" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
        <h2>Thêm Phòng Mới</h2>
        <form action="../modules/Create/add_function.php" method="POST" enctype="multipart/form-data">
            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="tenhomestay">Thuộc Homestay:</label>
                    <select id="tenhomestay" name="homestay-id" required>
                        <option value="HST_01">Homestay Vọng Nguyệt</option>
                        <option value="HST_02">Nhà Của Gió</option>
                        <option value="HST_03">Biệt Thự Đồi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="maphong">Mã Phòng:</label>
                    <input type="text" id="maphong" name="maphong" required>
                </div>
                <div class="form-group">
                    <label for="tenphong">Tên Phòng:</label>
                    <input type="text" id="tenphong" name="tenphong" required>
                </div>
                <div class="form-group">
                    <label for="loaiphong">Loại Phòng:</label>
                    <select id="loaiphong" name="loaiphong" required>
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
                    <label for="mota">Mô tả phòng:</label>
                    <textarea id="mota" name="mota" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="succhua">Số người tối đa:</label>
                    <input type="number" id="succhua" name="succhua" min="1" required>
                </div>
                <div class="form-group">
                    <label for="gia">Giá thuê (VNĐ/đêm):</label>
                    <input type="number" id="gia" name="gia" required>
                </div>
                <div class="form-group">
                    <label for="trangthai">Trạng thái:</label>
                    <input type="text" id="trangthai" name="trangthai" rows="4"></input>
                </div>
                <div class="form-group">
                    <label for="hinhanh">Hình ảnh:</label>
                    <input type="file" id="hinhanh" name="hinhanh[]" multiple accept="image/*">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit_room" class="add-btn">Thêm Phòng</button>
                <button type="reset"  class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>



<!-------------------------------------- Tìm kiếm ------------------------------->
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

                            $sql = "SELECT * FROM db_phong WHERE maphong LIKE '$search' OR tenhomestay LIKE '$search' OR tenphong LIKE '$search' OR loaiphong LIKE '$search' 
                            OR succhua LIKE '$search' OR gia LIKE '$search' OR trangthai LIKE '$search' "; 
                            $result = $conn->query($sql);} 
                            $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['tenhomestay'] ?></td>
                        <td><?php echo $row['maphong'] ?></td>
                        <td><?php echo $row['tenphong'] ?></td>
                        <td><?php echo $row['loaiphong'] ?></td>
                        <td class="truncate-text"><?php echo $row['mota'] ?></td>
                        <td><?php echo $row['succhua'] ?></td>
                        <td><?php echo $row['gia'] ?></td>
                        <td><?php echo $row['trangthai'] ?></td>
                        <td><?php echo $row['hinhanh'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" onclick="showFormRoom('detail-form', '<?php echo $row['maphong'] ?>')"><i class='bx bx-detail'></i></button>
                            <button class="edit-btn" title="Sửa" onclick="showFormRoom('edit-form', '<?php echo $row['maphong'] ?>')"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa" onclick="deleteRoom('<?php echo $row['maphong'] ?>')"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>


<!-------------------------------------- Sửa ------------------------------->
<div class="form-container" id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($roóms) { ?>>
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
            <a href="../modules/update_function.php" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormRoom('detail-form', '<?php echo $row['maphong'] ?>')"><i class='bx bx-detail'></i>Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteRoom('<?php echo $row['maphong'] ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        <h2>Sửa thông tin phòng</h2>
        <form action="update_rooms.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="mahomestay" value="<?php echo $rooms['maphong']; ?>">
            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="tenhomestay">Thuộc Homestay:</label>
                    <select id="tenhomestay" name="tenhomestay" required>
                        <option value="HST_001" <?php echo ($rooms['tenhomestay'] == 'HST_001') ? 'selected' : ''; ?>>Homestay Vọng Nguyệt</option>
                        <option value="HST_002" <?php echo ($rooms['tenhomestay'] == 'HST_001') ? 'selected' : ''; ?>>Nhà Của Gió</option>
                        <option value="HST_003" <?php echo ($rooms['tenhomestay'] == 'HST_001') ? 'selected' : ''; ?>>Biệt Thự Đồi</option>
                        <option value="khac" <?php echo ($rooms['tenhomestay'] == 'khac') ? 'selected' : ''; ?>>Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="maphong">Mã Phòng:</label>
                    <input type="text" id="maphong" name="maphong" value="<?php echo $rooms['maphong']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="tenphong">Tên Phòng:</label>
                    <input type="text" id="tenphong" name="tenphong" value="<?php echo $rooms['tenphong']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="loaiphong">Loại Phòng:</label>
                    <select id="loaiphong" name="loaiphong" required>
                        <option value="P_01" <?php echo ($rooms['loaiphong'] == 'P_01') ? 'selected' : ''; ?>>Phòng Đơn</option>
                        <option value="P_02" <?php echo ($rooms['loaiphong'] == 'P_02') ? 'selected' : ''; ?>>Phòng Đôi</option>
                        <option value="P_03" <?php echo ($rooms['loaiphong'] == 'P_03') ? 'selected' : ''; ?>>Phòng Gia Đình</option>
                        <option value="P_04" <?php echo ($rooms['loaiphong'] == 'P_04') ? 'selected' : ''; ?>>Phòng Suite</option>
                    </select>
                </div>
            </div>
            <div class="form-section">
                <h3>Thông tin chi tiết</h3>
                <div class="form-group">
                    <label for="mota">Mô tả phòng:</label>
                    <input type="text" id="mota" name="mota" value="<?php echo $rooms['mota']; ?>"></input>
                </div>
                <div class="form-group">
                    <label for="succhua">Số người tối đa:</label>
                    <input type="number" id="succhua" name="succhua" min="1" value="<?php echo $rooms['succhua']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="gia">Giá thuê (VNĐ/đêm):</label>
                    <input type="number" id="gia" name="gia" value="<?php echo $rooms['gia']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="trangthai">Trạng thái:</label>
                    <input type="text" id="trangthai" name="trangthai" rows="4" value="<?php echo $rooms['trangthai']; ?>"></input>
                </div>
                <div class="form-group">
                    <label for="hinhanh">Hình ảnh:</label>
                    <input type="image" id="hinhanh" name="hinhanh" value="<?php echo $rooms['hinhanh']; ?>">
                    <input type="file" id="hinhanh" name="hinhanh[]" multiple accept="image/*" value="<?php echo $rooms['hinhanh']; ?>">
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


<!-------------------------------------- Chi tiết ----------------------------------->
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
            <a href="home.php?page=rooms" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormRoom('edit-form', '<?php echo $row['maphong'] ?>')"><i class='bx bx-edit-alt'></i>Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteRoom('<?php echo $row['maphong'] ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết phòng</h2>

        <div class="detail-grid">
            <div class="detail-section">
                <div class="info-group">
                    <label for="tenhomestay">Thuộc Homestay:</label>
                    <p> <?php echo $rooms['tenhomestay']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="maphong">Mã Phòng:</label>
                    <p> <?php echo $rooms['maphong']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="tenphong">Tên Phòng:</label>
                    <p> <?php echo $rooms['tenphong']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="loaiphong">Loại Phòng:</label>
                    <p> <?php echo $rooms['loaiphong']; ?> </p>
                </div>
            </div>
            <div class="detail-section">
                <h3>Thông tin chi tiết</h3>
                <div class="info-group">
                    <label for="mota">Mô tả phòng:</label>
                    <p> <?php echo $rooms['mota']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="succhua">Số người tối đa:</label>
                    <p> <?php echo $rooms['succhua']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="gia">Giá thuê (VNĐ/đêm):</label>
                    <p> <?php echo $rooms['gia']; ?> </p>
                </div>
                <div class="info-group">
                    <label for="trangthai">Trạng thái:</label>
                    <p> <?php echo $rooms['trangthai']; ?> </p>
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