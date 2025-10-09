<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_admin') {
    $is_add_form = true;
} else if ($action === 'edit_admin') {
    $is_edit_form = true;
} else if ($action === 'detail_admin') {
    $is_detail_form = true;
} else if ($action === 'search_admin') {
    $is_view_form = true;
} else {
    $is_view_form = true; 

}

$admin_id = isset($_GET['id']) ? $_GET['id'] : null;

$admin = null;
if (($is_edit_form || $is_detail_form) && $admin_id) {
    $result = $conn->query("SELECT * FROM db_admin WHERE admin_id = '$admin_id '");
    if ($result && $result->num_rows > 0) {
        $admin = mysqli_fetch_assoc($result);
    }
}

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) as total FROM db_admin");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>
<!-------------------------------- Giao diện chính ------------------------------------>
<div class="form-container" id="admin-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;"> 
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý thông tin quản trị viên</h2>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormAdmin('add-form')"><i class='bx bx-plus'></i> Thêm quản trị viên mới</button>
            <div class="search-box">
                <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm quản trị viên...">
                <button type="submit" class="search-btn" onclick="showFormAdmin('search-form')"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <div class="limit-form">
            <form method="get">
                <input type="hidden" name="page" value="admin">
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
                        <th>Mã quản trị viên</th>
                        <th>Mã tài khoản</th>
                        <th>Tên quản trị viên</th>
                        <th>Hình ảnh</th>
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
                            $search = "%".$search_query."%";

                            $sql = "SELECT * FROM db_admin WHERE admin_id LIKE '$search'
                                OR account_id LIKE '$search'
                                OR fullname LIKE '$search' 
                                OR birthday LIKE '$search' 
                                OR gender LIKE '$search' 
                                OR email LIKE '$search' 
                                OR customer_phone LIKE '$search' 
                                OR address LIKE '$search'
                                LIMIT $limit OFFSET $offset ";
                            $result = $conn->query($sql); 
                        }else{
                            $sql = "SELECT * FROM db_admin LIMIT $limit OFFSET $offset ";
                            $result = $conn->query($sql);
                        }
                        if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['admin_id']; ?>"></td> 
                            <td><?php echo $row['admin_id'] ?></td>
                            <td><?php if($row['account_id'] === NULL){
                                            echo 'Quản trị viên chưa có tài khoản';
                                        }else{
                                            echo $row['account_id'];
                                        } ?></td>
                            <td><?php echo $row['fullname'] ?></td>
                            <td><?php echo "<img src='../../Images/" .$row['image']. "' alt='Hình ảnh' style='width:100px;height:auto;'>"; ?></td>
                            <td><?php echo $row['birthday'] ?></td>
                            <td><?php echo $row['gender'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <td class="truncate-text"><?php echo $row['address'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormAdmin('detail-form', '<?php echo $row['admin_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormAdmin('edit-form', '<?php echo $row['admin_id'] ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteAdmin('<?php echo $row['admin_id']; ?>')"><i class='bx bx-trash'></i></button>
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
                <a href="home.php?page=admin&pagetable&limit=<?= $limit ?>">&laquo;</a>
                <a href="home.php?page=admin&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=admin&pagetable=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=admin&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit ?>"> &gt;</a>
                <a href="home.php?page=admin&pagetable=<?= $total_pages ?>&limit=<?= $limit ?>"> &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-------------------------------- Giao diện thêm mới ------------------------------------>
<div class="form-container" id="add-form" style="display:<?php echo $is_add_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
           <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
        <h2>Thêm khách hàng mới </h2>
        <form action="../modules/add_function.php" method="POST">
            <div class="form-section">
                <h3>Thông tin cá nhân</h3>
                <div class="form-group">
                    <label for="account_id">Mã tài khoản:</label>
                    <input type="number" id="account_id" name="account_id" placeholder="Bỏ qua nếu khách hàng chưa có tài khoản">
                </div>
                <div class="form-group">
                    <label for="fullname">Họ và Tên:</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="image">Hình ảnh đại diện:</label>
                    <input type="file" id="image" name="image" multiple accept="image/*">
                </div>
                <div class="form-group">
                    <label for="birthday">Ngày sinh:</label>
                    <input type="date" id="birthday" name="birthday" required>
                </div>
                <div class="form-group">
                    <label for="gender">Giới tính :</label>
                    <select id="gender" name="gender" required>
                        <option value="Nam">Nam</option>
                        <option value="Nữ" >Nữ</option>
                        <option value="Khác" >Khác</option>
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
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit_admin" class="add-btn">Thêm khách hàng</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>

<!-------------------------------- Giao diện cập nhật ------------------------------------>
<div class="form-container" id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($user) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=user" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormUser('detail-form', '<?php echo $user['customer_id']; ?>')"><i class='bx bx-detail'></i> Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteUser('<?php echo $user['customer_id']; ?>')"></i> Xóa thông tin</button>
            </div>
        </div>
        <h2>Cập Nhật Thông Tin Khách Hàng</h2>
        
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="customer_id" value="<?php echo $user['customer_id']; ?>">

            <div class="form-section">
                <h3>Thông tin cá nhân</h3>
                <div class="form-group">
                    <label for="account_id">Mã tài khoản:</label>
                    <select id="account_id" name="account_id" >
                        <option value="">Khách hàng chưa có tài khoản</option>
                            <?php
                                $user_sql = "SELECT account_id, fullname FROM db_account";
                                $user_result = mysqli_query($conn, $user_sql);

                                if ($user_result && mysqli_num_rows($user_result) > 0) {
                                    while ($row = mysqli_fetch_assoc($user_result)) {
                                        $selected = ($row['account_id'] == $user['account_id']) ? 'selected' : '';
                                        echo "<option value='{$row['account_id']}' $selected>{$row['account_id']} - {$row['fullname']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>Khách hàng chưa có tài khoản</option>";
                                }
                            ?>
                        </select>
                </div>
                <div class="form-group">
                    <label for="fullname">Họ và Tên:</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo $user['fullname']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="birthday">Ngày sinh:</label>
                    <input type="date" id="birthday" name="birthday" value="<?php echo $user['birthday']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="gender">Giới tính :</label>
                    <select id="gender" name="gender" required>
                        <option value="Nam" <?php echo ($user['gender'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                        <option value="Nữ" <?php echo ($user['gender'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                        <option value="Khác"<?php echo ($user['gender'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
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
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
                </div>
                <div class="form-group"> 
                    <label for="address">Địa chỉ:</label>
                    <input type="text" id="address" name="address" rows="3" value="<?php echo $user['address']; ?>" required></input>
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

<!-------------------------------- Giao diện thông tin chi tiết ------------------------------------>
<div class="form-container"id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($user) { ?>
<?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=user" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormUser('edit-form', '<?php echo $user['customer_id']; ?>')"><i class='bx bx-edit-alt'></i> Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteUser('<?php echo $user['customer_id']; ?>')"></i> Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết thông tin khách hàng</h2>

        <div class="detail-grid">
            <div class="detail-section">
                <h3>Thông tin cá nhân</h3>
                <div class="info-group">
                    <label for="customer_id">Mã Khách hàng:</label>
                    <p><?php echo $user['customer_id']; ?></p>
                </div>
                <div class="info-group">
                    <label for="fullname">Họ và Tên:</label>
                    <p><?php echo $user['fullname']; ?></p>
                </div>
                <div class="info-group">
                    <label for="birthday">Ngày sinh:</label>
                    <p><?php echo $user['birthday']; ?></p>
                </div>
                <div class="info-group">
                    <label for="gender">Giới tính :</label>
                    <p><?php echo $user['gender']; ?></p>
                </div>
            </div>
            <div class="detail-section">
                <h3>Thông tin liên hệ </h3>
                <div class="info-group">
                    <label for="email">Email:</label>
                    <p><?php echo $user['email']; ?></p>
                </div>
                <div class="info-group">
                    <label for="phone">Số điện thoại:</label>
                    <p><?php echo $user['phone']; ?></p>
                </div>
                <div class="info-group"> 
                    <label for="address">Địa chỉ:</label>
                    <p><?php echo $user['address']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin khách hàng.</p>
    <?php } ?>
</div>
<script src="../../Js/test.js"></script> 