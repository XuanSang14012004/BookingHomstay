<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_search_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_user') {
    $is_add_form = true;
} else if ($action === 'edit_user') {
    $is_edit_form = true;
} else if ($action === 'detail_user') {
    $is_detail_form = true;
} else if ($action === 'search_user') {
    $is_search_form = true;
} else {
    $is_view_form = true; // Trang chính

}

$makhachhang = isset($_GET['id']) ? $_GET['id'] : null;

$user = null;
if (($is_edit_form || $is_detail_form) && $makhachhang) {
    $result = $conn->query("SELECT * FROM db_khachhang WHERE makhachhang = '$makhachhang '");
    if ($result && $result->num_rows > 0) {
        $user = mysqli_fetch_assoc($result);
    }
}
?>

<!------------------------------------ Giao diện -------------------------->
<div class="form-container" id="user-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;"> 
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Quản lí thông tin khách hàng</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>

    <div class="management-container">
        <h2>Quản lý thông tin Khách hàng</h2>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormUser('add-form')"><i class='bx bx-plus'></i> Thêm Khách hàng mới</button>
            <div class="search-box">
                <input type="text" id="search" name="timkiem" placeholder="Tìm kiếm khách hàng...">
                <button type="submit" class="search-btn" onclick="showFormUser('search-form')"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã Khách hàng</th>
                        <th>Tên Khách hàng</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $result = $conn->query("SELECT * FROM db_khachhang");
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['makhachhang'] ?></td>
                            <td><?php echo $row['tenkhachhang'] ?></td>
                            <td><?php echo $row['ngaysinh'] ?></td>
                            <td><?php echo $row['gioitinh'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['sodienthoai'] ?></td>
                            <td class="truncate-text"><?php echo $row['diachi'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormUser('detail-form', '<?php echo $row['makhachhang']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormUser('edit-form', '<?php echo $row['makhachhang'] ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteUser('<?php echo $row['makhachhang']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>   


<!------------------------------------ Tìm kiếm-------------------------->
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
                    <a class="active" href="#">Quản lí thông tin khách hàng</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>

    <div class="management-container">
        <h2>Quản lý thông tin Khách hàng</h2>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormUser('add-form')"><i class='bx bx-plus'></i> Thêm Khách hàng mới</button>
            <div class="search-box">
                <input type="text" id="search" name="timkiem" placeholder="Tìm kiếm khách hàng...">
                <button type="submit" class="search-btn" onclick="showFormUser('search-form')"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã Khách hàng</th>
                        <th>Tên Khách hàng</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                         if( isset($_GET['content']) ? $_GET['content'] :'' ){
                            $search_query = trim($_GET['content']);
                            $search = "%$search_query%";

                            $sql = "SELECT * FROM db_khachhang WHERE makhachhang LIKE '$search' OR tenkhachhang LIKE '$search' OR ngaysinh LIKE '$search' OR gioitinh LIKE '$search' 
                            OR email LIKE '$search' OR sodienthoai LIKE '$search' OR diachi LIKE '$search' "; 
                            $result = $conn->query($sql);} 
                            $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['makhachhang'] ?></td>
                            <td><?php echo $row['tenkhachhang'] ?></td>
                            <td><?php echo $row['ngaysinh'] ?></td>
                            <td><?php echo $row['gioitinh'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['sodienthoai'] ?></td>
                            <td class="truncate-text"><?php echo $row['diachi'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormUser('detail-form', '<?php echo $row['makhachhang']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormUser('edit-form', '<?php echo $row['makhachhang'] ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteUser('<?php echo $row['makhachhang']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>   

<!----------------------------------------- Thêm ---------------------------------->
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
                <a>Quản lí thông tin Khách hàng</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active">Thêm khách hàng mới</a>
            </li>
        </ul>
    </div>
</div>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=user" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
        <h2>Thêm Khách Hàng Mới</h2>
        <form action="../modules/add_function.php" method="POST">
            <div class="form-section">
                <h3>Thông tin cá nhân</h3>
                <div class="form-group">
                    <label for="makhachhang">Mã Khách hàng:</label>
                    <input type="text" id="makhachhang" name="makhachhang" required>
                </div>
                <div class="form-group">
                    <label for="tenkhachhang">Họ và Tên:</label>
                    <input type="text" id="tenkhachhang" name="tenkhachhang" required>
                </div>
                <div class="form-group">
                    <label for="ngaysinh">Ngày sinh:</label>
                    <input type="date" id="ngaysinh" name="ngaysinh" required>
                </div>
                <div class="form-group">
                    <label for="gioitinh">Giới tính :</label>
                    <select id="gioitinh" name="gioitinh" required>
                        <option value="nam" <?php if(isset($_POST['gioitinh']) && $_POST['gioitinh']=='nam') echo 'selected'; ?>>Nam</option>
                        <option value="nu" <?php if(isset($_POST['gioitinh']) && $_POST['gioitinh']=='nu') echo 'selected'; ?>>Nữ</option>
                        <option value="khac" <?php if(isset($_POST['gioitinh']) && $_POST['gioitinh']=='khac') echo 'selected'; ?>>Khác</option>
                    </select>
                </div>
            </div>
            <div class="form-section">
                <h3>Thông tin liên hệ </h3>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="sodienthoai">Số điện thoại:</label>
                    <input type="tel" id="sodienthoai" name="sodienthoai" required>
                </div>
                <div class="form-group">
                    <label for="diachi">Địa chỉ:</label>
                    <textarea id="diachi" name="diachi" rows="3" required></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit_user" class="add-btn">Thêm Khách Hàng</button>
                <button type="reset"  class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>

<!----------------------------------------------- Sửa ----------------------------------------->
<div class="form-container" id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($user) { ?>
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a>Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a>Quản lí thông tin tài khoản</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active">Cập nhật thông tin khách hàng</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=user" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormUser('detail-form', '<?php echo $user['makhachhang']; ?>')"><i class='bx bx-detail'></i> Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteUser('<?php echo $row['makhachhang']; ?>')"></i> Xóa thông tin</button>
            </div>
        </div>
        <h2>Sửa Thông Tin Khác Hàng</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="makhachhang" value="<?php echo $user['makhachhang']; ?>">

            <div class="form-section">
                <h3>Thông tin cá nhân</h3>
                <div class="form-group">
                    <label for="makhachhang">Mã Khách hàng:</label>
                    <input type="text" id="makhachhang" name="makhachhang" value="<?php echo $user['makhachhang']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="tenkhachhang">Họ và Tên:</label>
                    <input type="text" id="tenkhachhang" name="tenkhachhang" value="<?php echo $user['tenkhachhang']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="ngaysinh">Ngày sinh:</label>
                    <input type="date" id="ngaysinh" name="ngaysinh" value="<?php echo $user['ngaysinh']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="gioitinh">Giới tính :</label>
                    <select id="gioitinh" name="gioitinh" required>
                        <option value="nam" <?php echo ($user['gioitinh'] == 'nam') ? 'selected' : ''; ?>>Nam</option>
                        <option value="nu" <?php echo ($user['gioitinh'] == 'nu') ? 'selected' : ''; ?>>Nữ</option>
                    </select>
                </div>
            </div>
            <div class="form-section">
                <h3>Thông tin liên hệ </h3>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="sodienthoai">Số điện thoại:</label>
                    <input type="tel" id="sodienthoai" name="sodienthoai" value="<?php echo $user['sodienthoai']; ?>" required>
                </div>
                <div class="form-group"> 
                    <label for="diachi">Địa chỉ:</label>
                    <input type="text" id="diachi" name="diachi" rows="3" value="<?php echo $user['diachi']; ?>" required></input>
                </div>
            </div>
                    <div class="form-actions">
                <button type="submit" name="submit_user" class="edit-btn">Cập nhật thông tin</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
    <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin khách hàng để sửa.</p>
    <?php } ?>

</div>

<!----------------------------------------- Chi tiết -------------------------------->
<div class="form-container"id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($user) { ?>

    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a>Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a>Quản lí thông tin khách hàng</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active">Thông tin chi tiết khách hàng</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=user" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormUser('edit-form', '<?php echo $user['makhachhang']; ?>')"><i class='bx bx-edit-alt'></i> Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteUser('<?php echo $row['makhachhang']; ?>')"></i> Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết thông tin khách hàng</h2>

        <div class="detail-grid">
            <div class="detail-section">
                <h3>Thông tin cá nhân</h3>
                <div class="info-group">
                    <label for="makhachhang">Mã Khách hàng:</label>
                    <p><?php echo $user['makhachhang']; ?></p>
                </div>
                <div class="info-group">
                    <label for="tenkhachhang">Họ và Tên:</label>
                    <p><?php echo $user['tenkhachhang']; ?></p>
                </div>
                <div class="info-group">
                    <label for="ngaysinh">Ngày sinh:</label>
                    <p><?php echo $user['ngaysinh']; ?></p>
                </div>
                <div class="info-group">
                    <label for="gioitinh">Giới tính :</label>
                    <p><?php echo $user['gioitinh']; ?></p>
                </div>
            </div>
            <div class="detail-section">
                <h3>Thông tin liên hệ </h3>
                <div class="info-group">
                    <label for="email">Email:</label>
                    <p><?php echo $user['email']; ?></p>
                </div>
                <div class="info-group">
                    <label for="sodienthoai">Số điện thoại:</label>
                    <p><?php echo $user['sodienthoai']; ?></p>
                </div>
                <div class="info-group"> 
                    <label for="diachi">Địa chỉ:</label>
                    <p><?php echo $user['diachi']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin khách hàng.</p>
    <?php } ?>

</div>