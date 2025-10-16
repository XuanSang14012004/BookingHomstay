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

if (isset($_GET['content']) && $_GET['content'] !== '') {
    $search_query = trim($_GET['content']);
    $search = "%".$search_query."%";
    $count_sql = "SELECT COUNT(*) as total FROM db_admin WHERE admin_id LIKE '$search'
        OR account_id LIKE '$search'
        OR fullname LIKE '$search' 
        OR birthday LIKE '$search' 
        OR gender LIKE '$search' 
        OR email LIKE '$search' 
        OR phone LIKE '$search' 
        OR address LIKE '$search'";
    $total_result = $conn->query($count_sql);
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);
} else {
    $total_result = $conn->query("SELECT COUNT(*) as total FROM db_admin");
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);
}
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
                                OR phone LIKE '$search' 
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
            <?php
                $contentParam = isset($_GET['content']) ? '&content='.urlencode($_GET['content']) : '';
            ?>
            <?php if ($pagetable > 1): ?>
                <a href="home.php?page=admin&pagetable&limit=<?= $limit . $contentParam ?>">&laquo;</a>
                <a href="home.php?page=admin&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit . $contentParam ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=admin&pagetable=<?= $i ?>&limit=<?= $limit . $contentParam ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=admin&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit . $contentParam ?>"> &gt;</a>
                <a href="home.php?page=admin&pagetable=<?= $total_pages ?>&limit=<?= $limit . $contentParam ?>"> &raquo;</a>
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
        <h2>Thêm quản trị viên mới</h2>
        <form action="../modules/add_function.php" method="POST" enctype="multipart/form-data">
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Thông tin cá nhân</h3>
                    <div class="form-group">
                        <label for="account_id">Mã tài khoản:</label>
                        <input type="number" id="account_id" name="account_id" placeholder="Nhập mã tài khoản (nếu có)">
                    </div>
                    <div class="form-group">
                        <label for="fullname">Họ và Tên:</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Nhập họ tên" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Hình ảnh đại diện:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh:</label>
                        <input type="date" id="birthday" name="birthday" placeholder="dd/mm/yyyy" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính:</label>
                        <select id="gender" name="gender" required>
                            <option value="" disabled selected>Chọn giới tính</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                </div>
                <div style="flex:1;">
                    <h3>Thông tin liên hệ</h3>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <textarea id="address" name="address" rows="2" placeholder="Nhập địa chỉ" required></textarea>
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align:right;">
                <button type="submit" name="submit_admin" class="add-btn">Thêm quản trị viên</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>

<!-------------------------------- Giao diện cập nhật ------------------------------------>
<div class="form-container" id="update-form" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($admin) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=admin" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormAdmin('detail-form', '<?php echo $admin['admin_id']; ?>')"><i class='bx bx-detail'></i> Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteAdmin('<?php echo $admin['admin_id']; ?>')"></i> Xóa thông tin</button>
            </div>
        </div>
        <h2>Cập Nhật Thông Tin Quản trị viên</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="admin_id" value="<?php echo $admin['admin_id']; ?>">
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Thông tin cá nhân</h3>
                    <div class="form-group">
                        <label for="account_id">Mã tài khoản:</label>
                        <select id="account_id" name="account_id">
                            <option value="">Quản trị viên chưa có tài khoản</option>
                            <?php
                                $admin_sql = "SELECT account_id, fullname FROM db_account";
                                $admin_result = mysqli_query($conn, $admin_sql);

                                if ($admin_result && mysqli_num_rows($admin_result) > 0) {
                                    while ($row = mysqli_fetch_assoc($admin_result)) {
                                        $selected = ($row['account_id'] == $admin['account_id']) ? 'selected' : '';
                                        echo "<option value='{$row['account_id']}' $selected>{$row['account_id']} - {$row['fullname']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>Chưa có tài khoản nào của quản trị viên</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Họ và Tên:</label>
                        <input type="text" id="fullname" name="fullname" value="<?php echo $admin['fullname']; ?>" placeholder="Nhập họ tên" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Hình ảnh hiện tại:</label>
                        <img src="../../Images/<?php echo $admin['image']; ?>" alt="Hình ảnh đại diện" style="width: 120px; height: auto; display: block; margin-bottom: 10px;">
                        <label for="image">Chọn ảnh mới:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh:</label>
                        <input type="date" id="birthday" name="birthday" value="<?php echo $admin['birthday']; ?>" placeholder="dd/mm/yyyy" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính:</label>
                        <select id="gender" name="gender" required>
                            <option value="Nam" <?php echo ($admin['gender'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo ($admin['gender'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Khác"<?php echo ($admin['gender'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>
                </div>
                <div style="flex:1;">
                    <h3>Thông tin liên hệ</h3>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $admin['email']; ?>" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo $admin['phone']; ?>" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <textarea id="address" name="address" rows="2" placeholder="Nhập địa chỉ" required><?php echo $admin['address']; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align:right;">
                <button type="submit" name="submit_admin" class="edit-btn">Cập nhật thông tin</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
    <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin quản trị viên để sửa.</p>
    <?php } ?>
</div>

<!-------------------------------- Giao diện thông tin chi tiết ------------------------------------>
<div class="form-container"id="detail-form" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($admin) { ?>
<?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=admin" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormAdmin('edit-form', '<?php echo $admin['admin_id']; ?>')"><i class='bx bx-edit-alt'></i> Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteAdmin('<?php echo $admin['admin_id']; ?>')"></i> Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết thông tin quản trị viên</h2>
        <div class="detail-flex" style="display: flex; gap: 40px; align-items: flex-start;">
            <div class="detail-section" style="flex:2;">
                <h3>Thông tin cá nhân</h3>
                <div class="info-group">
                    <label for="admin_id">Mã quản trị viên:</label>
                    <p><?php echo $admin['admin_id']; ?></p>
                </div>
                <div class="info-group">
                    <label for="fullname">Họ và Tên:</label>
                    <p><?php echo $admin['fullname']; ?></p>
                </div>
                <div class="info-group">
                    <label for="birthday">Ngày sinh:</label>
                    <p><?php echo $admin['birthday']; ?></p>
                </div>
                <div class="info-group">
                    <label for="gender">Giới tính :</label>
                    <p><?php echo $admin['gender']; ?></p>
                </div>
                <h3>Thông tin liên hệ </h3>
                <div class="info-group">
                    <label for="email">Email:</label>
                    <p><?php echo $admin['email']; ?></p>
                </div>
                <div class="info-group">
                    <label for="phone">Số điện thoại:</label>
                    <p><?php echo $admin['phone']; ?></p>
                </div>
                <div class="info-group"> 
                    <label for="address">Địa chỉ:</label>
                    <p><?php echo $admin['address']; ?></p>
                </div>
            </div>
            <div class="detail-section" style="flex:1; display: flex; flex-direction: column; align-items: center;">
                <h3>Ảnh đại diện</h3>
                <div class="info-group" style="text-align:center;">
                    <img src="../../Images/<?php echo $admin['image']; ?>" alt="Hình ảnh đại diện" style="max-width:220px; width:100%; height:auto; border-radius:8px; border:1px solid #eee; box-shadow:0 2px 8px #eee;">
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin quản trị viên.</p>
    <?php } ?>
</div>
<script src="../../Js/test.js"></script>