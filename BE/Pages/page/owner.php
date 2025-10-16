<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_owner') {
    $is_add_form = true;
} else if ($action === 'edit_owner') {
    $is_edit_form = true;
} else if ($action === 'detail_owner') {
    $is_detail_form = true;
} else if ($action === 'search_owner') {
    $is_view_form = true;
} else {
    $is_view_form = true; 
}

$owner_id = isset($_GET['id']) ? $_GET['id'] : null;

$owner = null;
if (($is_edit_form || $is_detail_form) && $owner_id) {
    $result = $conn->query("SELECT * FROM db_owner WHERE owner_id = '$owner_id '");
    if ($result && $result->num_rows > 0) {
        $owner = mysqli_fetch_assoc($result);
    }
}

// Xử lý bộ lọc
$where = [];
if (isset($_GET['gender']) && $_GET['gender'] !== '') $where[] = "gender = '".mysqli_real_escape_string($conn, $_GET['gender'])."'";
$where_sql = $where ? 'WHERE '.implode(' AND ', $where) : '';

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;

// Đếm tổng số bản ghi cho phân trang (áp dụng cả lọc)
$count_sql = "SELECT COUNT(*) as total FROM db_owner $where_sql";
$total_result = $conn->query($count_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>
<!-------------------------------- Giao diện chính ------------------------------------>
<div class="form-container" id="owner-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;"> 
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý thông tin chủ Homestay</h2>
        <div class="filter-bar">
            <a href="home.php?page=owner<?=
                isset($_GET['gender']) ? '&gender='.urlencode($_GET['gender']) : ''
            ?>" title="Lọc dữ liệu">
                <i class='bx bx-filter'></i>
            </a>
            <form class="filter-form" method="get">
                <input type="hidden" name="page" value="owner">
                <select name="gender" onchange="this.form.submit()">
                    <option value="">-- Giới tính --</option>
                    <option value="Nam" <?= (isset($_GET['gender']) && $_GET['gender']=='Nam')?'selected':''; ?>>Nam</option>
                    <option value="Nữ" <?= (isset($_GET['gender']) && $_GET['gender']=='Nữ')?'selected':''; ?>>Nữ</option>
                    <option value="Khác" <?= (isset($_GET['gender']) && $_GET['gender']=='Khác')?'selected':''; ?>>Khác</option>
                </select>
            </form>
        </div>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormOwner('add-form')"><i class='bx bx-plus'></i> Thêm chủ Homestay mới</button>
            <div class="search-box">
                <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm chủ Homestay...">
                <button type="submit" class="search-btn" onclick="showFormOwner('search-form')"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <div class="limit-form">
            <form method="get">
                <input type="hidden" name="page" value="owner">
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
                        <th>Mã chủ Homestay</th>
                        <th>Mã tài khoản</th>
                        <th>Tên chủ Homestay</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['content']) && $_GET['content'] !== '') {
                        $search_query = trim($_GET['content']);
                        $search = "%".$conn->real_escape_string($search_query)."%";

                        $search_where = "(owner_id LIKE '$search'
                            OR account_id LIKE '$search'
                            OR fullname LIKE '$search' 
                            OR birthday LIKE '$search' 
                            OR gender LIKE '$search' 
                            OR email LIKE '$search' 
                            OR phone LIKE '$search' 
                            OR address LIKE '$search')";
                        $full_where = $where ? $search_where . " AND " . implode(" AND ", $where) : $search_where;
                        $sql = "SELECT * FROM db_owner WHERE $full_where LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    } else if ($where_sql) {
                        $sql = "SELECT * FROM db_owner $where_sql LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    } else {
                        $sql = "SELECT * FROM db_owner LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    }
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                            <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['owner_id']; ?>"></td> 
                            <td><?php echo $row['owner_id'] ?></td>
                            <td><?php if($row['account_id'] === NULL){
                                            echo 'Chủ Homestay chưa có tài khoản';
                                        }else{
                                            echo $row['account_id'];
                                        } ?></td>
                            <td><?php echo $row['fullname'] ?></td>
                            <td><?php echo $row['birthday'] ?></td>
                            <td><?php echo $row['gender'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <td class="truncate-text"><?php echo $row['address'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormOwner('detail-form', '<?php echo $row['owner_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormOwner('edit-form', '<?php echo $row['owner_id'] ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteOwner('<?php echo $row['owner_id']; ?>')"><i class='bx bx-trash'></i></button>
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
                <a href="home.php?page=owner&pagetable&limit=<?= $limit . $contentParam ?>">&laquo;</a>
                <a href="home.php?page=owner&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit . $contentParam ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=owner&pagetable=<?= $i ?>&limit=<?= $limit . $contentParam ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=owner&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit . $contentParam ?>"> &gt;</a>
                <a href="home.php?page=owner&pagetable=<?= $total_pages ?>&limit=<?= $limit . $contentParam ?>"> &raquo;</a>
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
        <h2>Thêm Chủ homestay mới</h2>
        <form action="../modules/add_function.php" method="POST">
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
                <button type="submit" name="submit_owner" class="add-btn">Thêm chủ homestay</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>

<!-------------------------------- Giao diện cập nhật ------------------------------------>
<div class="form-container" id="update-form" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($owner) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=owner" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormOwner('detail-form', '<?php echo $owner['owner_id']; ?>')"><i class='bx bx-detail'></i> Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteOwner('<?php echo $owner['owner_id']; ?>')"></i> Xóa thông tin</button>
            </div>
        </div>
        <h2>Cập Nhật Thông Tin chủ homestay</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="owner_id" value="<?php echo $owner['owner_id']; ?>">
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Thông tin cá nhân</h3>
                    <div class="form-group">
                        <label for="account_id">Mã tài khoản:</label>
                        <select id="account_id" name="account_id">
                            <option value="">Chủ Homestay chưa có tài khoản</option>
                            <?php
                                $owner_sql = "SELECT account_id, fullname FROM db_account";
                                $owner_result = mysqli_query($conn, $owner_sql);

                                if ($owner_result && mysqli_num_rows($owner_result) > 0) {
                                    while ($row = mysqli_fetch_assoc($owner_result)) {
                                        $selected = ($row['account_id'] == $owner['account_id']) ? 'selected' : '';
                                        echo "<option value='{$row['account_id']}' $selected>{$row['account_id']} - {$row['fullname']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>Chưa có tài khoản Chủ homestay  nào</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Họ và Tên:</label>
                        <input type="text" id="fullname" name="fullname" value="<?php echo $owner['fullname']; ?>" placeholder="Nhập họ tên" required>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh:</label>
                        <input type="date" id="birthday" name="birthday" value="<?php echo $owner['birthday']; ?>" placeholder="dd/mm/yyyy" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính:</label>
                        <select id="gender" name="gender" required>
                            <option value="Nam" <?php echo ($owner['gender'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo ($owner['gender'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Khác"<?php echo ($owner['gender'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>
                </div>
                <div style="flex:1;">
                    <h3>Thông tin liên hệ</h3>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $owner['email']; ?>" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo $owner['phone']; ?>" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" id="address" name="address" value="<?php echo $owner['address']; ?>" placeholder="Nhập địa chỉ" required>
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align:right;">
                <button type="submit" name="submit_owner" class="edit-btn">Cập nhật thông tin</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
    <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin chủ homestay để sửa.</p>
    <?php } ?>
</div>

<!-------------------------------- Giao diện thông tin chi tiết ------------------------------------>
<div class="form-container"id="detail-form" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($owner) { ?>
<?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="home.php?page=owner" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormOwner('edit-form', '<?php echo $owner['owner_id']; ?>')"><i class='bx bx-edit-alt'></i> Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteOwner('<?php echo $owner['owner_id']; ?>')"></i> Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết thông tin chủ homestay</h2>

        <div class="detail-grid">
            <div class="detail-section">
                <h3>Thông tin cá nhân</h3>
                <div class="info-group">
                    <label for="owner_id">Mã Chủ Homestay:</label>
                    <p><?php echo $owner['owner_id']; ?></p>
                </div>
                <div class="info-group">
                    <label for="fullname">Họ và Tên:</label>
                    <p><?php echo $owner['fullname']; ?></p>
                </div>
                <div class="info-group">
                    <label for="birthday">Ngày sinh:</label>
                    <p><?php echo $owner['birthday']; ?></p>
                </div>
                <div class="info-group">
                    <label for="gender">Giới tính :</label>
                    <p><?php echo $owner['gender']; ?></p>
                </div>
            </div>
            <div class="detail-section">
                <h3>Thông tin liên hệ </h3>
                <div class="info-group">
                    <label for="email">Email:</label>
                    <p><?php echo $owner['email']; ?></p>
                </div>
                <div class="info-group">
                    <label for="phone">Số điện thoại:</label>
                    <p><?php echo $owner['phone']; ?></p>
                </div>
                <div class="info-group"> 
                    <label for="address">Địa chỉ:</label>
                    <p><?php echo $owner['address']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin chủ homestay.</p>
    <?php } ?>

</div>