<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_account') {
    $is_add_form = true;
} else if ($action === 'edit_account') {
    $is_edit_form = true;
} else if ($action === 'search_account') {
    $is_view_form = true;
} else if ($action === 'detail_account') {
    $is_detail_form = true;
} else {
    $is_view_form = true;
}

$ID = isset($_GET['id']) ? $_GET['id'] : null;

$account = null;
if (($is_edit_form || $is_detail_form) && $ID) {
    $result = $conn->query("SELECT * FROM db_account WHERE account_id = '$ID'");
    if ($result && $result->num_rows > 0) {
        $account = mysqli_fetch_assoc($result);
    }
}

// Xử lý bộ lọc
$where = [];
if (isset($_GET['role']) && $_GET['role'] !== '') $where[] = "role = '".mysqli_real_escape_string($conn, $_GET['role'])."'";
$where_sql = $where ? 'WHERE '.implode(' AND ', $where) : '';

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;

// Đếm tổng số bản ghi cho phân trang (áp dụng cả lọc)
$count_sql = "SELECT COUNT(*) as total FROM db_account $where_sql";
$total_result = $conn->query($count_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>
<!-------------------------------------- Giao diện chính --------------------------------------->
<div class="form-container" id="account-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý thông tin tài khoản</h2>
        <div class="filter-bar">
            <a href="home.php?page=account<?=
                isset($_GET['role']) ? '&role='.urlencode($_GET['role']) : ''
            ?>" title="Lọc dữ liệu">
                <i class='bx bx-filter'></i>
            </a>
            <form class="filter-form" method="get">
                <input type="hidden" name="page" value="account">
                <select name="role" onchange="this.form.submit()">
                    <option value="">-- Phân quyền --</option>
                    <option value="admin" <?= (isset($_GET['role']) && $_GET['role']=='admin')?'selected':''; ?>>Quản trị viên</option>
                    <option value="user" <?= (isset($_GET['role']) && $_GET['role']=='user')?'selected':''; ?>>Khách hàng</option>
                    <option value="owner" <?= (isset($_GET['role']) && $_GET['role']=='owner')?'selected':''; ?>>Chủ homestay</option>
                </select>
            </form>
        </div>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormAccount('add-form')"><i class='bx bx-plus'></i> Thêm tài khoản mới</button>
            <div class="search-box">
                <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm tài khoản...">
                <button type="submit" class="search-btn" onclick="showFormAccount('search-form')"><i class='bx bx-search'></i>
            </div>
        </div>
        <div class="limit-form">
            <form method="get">
                <input type="hidden" name="page" value="account">
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
                        <th>Mã tài khoản</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Mật khẩu</th>
                        <th>Phân quyền</th>
                        <th>Ngày tạo tài khoản</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['content']) && $_GET['content'] !== '') {
                        $search_query = trim($_GET['content']);
                        $search = "%".$conn->real_escape_string($search_query)."%";

                        $search_where = "(account_id LIKE '$search' 
                            OR fullname LIKE '$search' 
                            OR email LIKE '$search' 
                            OR role LIKE '$search'
                            OR created_at LIKE '$search' 
                            OR phone LIKE '$search')";
                        $full_where = $where ? $search_where . " AND " . implode(" AND ", $where) : $search_where;
                        $sql = "SELECT * FROM db_account WHERE $full_where LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    } else if ($where_sql) {
                        $sql = "SELECT * FROM db_account $where_sql LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    } else {
                        $sql = "SELECT * FROM db_account LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    }
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                            <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['account_id']; ?>"></td> 
                            <td><?php echo $row['account_id'] ?></td>
                            <td><?php echo $row['fullname'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <td><?php echo $row['password'] ?></td>
                            <td><?php if($row['role'] ==='user'){
                                            echo 'Khách hàng';
                                        }else if($row['role'] === 'owner'){
                                            echo 'Chủ homestay';
                                        }else if($row['role'] === 'admin'){
                                            echo 'Quản trị viên';
                                        } ?>
                            </td>
                            <td><?php echo $row['created_at'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormAccount('detail-form', '<?php echo $row['account_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormAccount('edit-form', '<?php echo $row['account_id']; ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteAccount('<?php echo $row['account_id']; ?>')"><i class='bx bx-trash'></i></button>
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
                <a href="home.php?page=account&pagetable&limit=<?= $limit . $contentParam ?>">&laquo;</a>
                <a href="home.php?page=account&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit . $contentParam ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=account&pagetable=<?= $i ?>&limit=<?= $limit . $contentParam ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=account&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit . $contentParam ?>"> &gt;</a>
                <a href="home.php?page=account&pagetable=<?= $total_pages ?>&limit=<?= $limit . $contentParam ?>"> &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-------------------------------------------- Giao diện thêm mới ------------------------------------------------->
<div class="form-container" id="add-form" style="display:<?php echo $is_add_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
        <h2>Thêm Tài Khoản Mới</h2>
        <form action="../modules/add_function.php" method="POST">
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Thông tin cá nhân</h3>
                    <div class="form-group">
                        <label for="fullname">Họ và tên:</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Nhập họ tên" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
                    </div>
                </div>
                <div style="flex:1;">
                    <h3>Bảo mật & Phân quyền</h3>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input type="text" id="password" name="password" placeholder="Nhập mật khẩu" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Phân quyền:</label>
                        <select id="role" name="role">
                            <option value="admin">Quản trị viên</option>
                            <option value="user">Khách hàng</option>
                            <option value="owner">Chủ homestay</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align:right;">
                <button type="submit" name="submit_account" class="add-btn">Thêm tài khoản</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>

<!----------------------------------------------- Giao diện cập nhật -------------------------------------------->

<div class="form-container" id="update-form" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($account) { ?>
       <?php include "../home/header_content.php"; ?>
        <div class="management-container">
            <div class="toolbar">
                <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
                <div class="action-buttons">
                    <button class="detail-btn" title="Chi tiết" onclick="showFormAccount('detail-form', '<?php echo $account['account_id']; ?>')"><i class='bx bx-detail'></i> Xem thông tin</button>
                    <button class="delete-btn" title="Xóa" onclick="deleteAccount('<?php echo $account['account_id']; ?>')"></i> Xóa thông tin</button>
                </div>
            </div>
            <h2>Sửa Thông Tin Tài Khoản</h2>
            <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="account_id" value="<?php echo $account['account_id']; ?>">
                <div class="form-section" style="display: flex; gap: 32px;">
                    <div style="flex:1;">
                        <h3>Thông tin cá nhân</h3>
                        <div class="form-group">
                            <label for="fullname">Họ và tên:</label>
                            <input type="text" id="fullname" name="fullname" value="<?php echo $account['fullname']; ?>" placeholder="Nhập họ tên" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo $account['email']; ?>" placeholder="Nhập email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo $account['phone']; ?>" placeholder="Nhập số điện thoại" required>
                        </div>
                    </div>
                    <div style="flex:1;">
                        <h3>Bảo mật & Phân quyền</h3>
                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <input type="text" id="password" name="password" value="<?php echo $account['password']; ?>" placeholder="Nhập mật khẩu" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Phân quyền:</label>
                            <select id="role" name="role">
                                <option value="admin" <?php echo ($account['role'] == 'admin') ? 'selected' : ''; ?>>Quản trị viên</option>
                                <option value="user" <?php echo ($account['role'] == 'user') ? 'selected' : ''; ?>>Khách hàng</option>
                                <option value="owner" <?php echo ($account['role'] == 'owner') ? 'selected' : ''; ?>>Chủ homestay</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="text-align:right;">
                    <button type="submit" name="submit_account" class="edit-btn">Cập nhật thông tin</button>
                    <button type="reset" class="cancel-btn">Hủy</button>
                </div>
            </form>
        </div>
    <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin tài khoản để sửa.</p>
    <?php } ?>
</div>

<!-----------------------------------  Chi tiết --------------------------------->
<div class="form-container" id="detail-form" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($account) { ?>
        <?php include "../home/header_content.php"; ?>
        <div class="management-container">
            <div class="toolbar">
                <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
                <div class="action-buttons">
                    <button class="edit-btn" title="Sửa" onclick="showFormAccount('edit-form', '<?php echo $account['account_id']; ?>')"><i class='bx bx-edit-alt'></i> Sửa thông tin</button>
                    <button class="delete-btn" title="Xóa" onclick="deleteAccount('<?php echo $account['account_id']; ?>')"></i> Xóa thông tin</button>
                </div>
            </div>

            <h2>Chi tiết thông tin tài khoản</h2>

            <div class="detail-grid">
                <div class="detail-section">
                    <h3>Thông tin cá nhân</h3>
                    <div class="info-group">
                        <label for="fullname">Họ và tên:</label>
                        <p><?php echo $account['fullname']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="email">Email:</label>
                        <p><?php echo $account['email']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="phone">Số điện thoại:</label>
                        <p><?php echo $account['phone']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="password">Mật khẩu:</label>
                        <p><?php echo $account['password']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="role">Phân quyền:</label>
                        <p><?php if($account['role'] ==='user'){
                                            echo 'Khách hàng';
                                        }else if($account['role'] === 'owner'){
                                            echo 'Chủ homestay';
                                        }else if($account['role'] === 'admin'){
                                            echo 'Quản trị viên';
                                        } ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin tài khoản.</p>
    <?php } ?>
</div>