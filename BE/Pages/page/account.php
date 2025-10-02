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
    $is_view_form = true; // Trang chính

}

$email = isset($_GET['id']) ? $_GET['id'] : null;

$account = null;
if (($is_edit_form || $is_detail_form) && $email) {
    $result = $conn->query("SELECT * FROM db_account WHERE email = '$email'");
    if ($result && $result->num_rows > 0) {
        $account = mysqli_fetch_assoc($result);
    }
}

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;


$total_result = $conn->query("SELECT COUNT(*) as total FROM db_account");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>

<!-------------------------------------- Giao diện chính --------------------------------------->
<div class="form-container" id="account-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý thông tin tài khoản</h2>
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
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Mật khẩu</th>
                        <th>Phân quyền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        if( isset($_GET['content']) ? $_GET['content'] :'' ){ 
                            $search_query = trim($_GET['content']);
                            $search = "%".$search_query."%";

                            $sql = "SELECT * FROM db_account  WHERE fullname LIKE '$search' 
                                OR email LIKE '$search' 
                                OR role LIKE '$search' 
                                OR phone LIKE '$search'
                                LIMIT $limit OFFSET $offset"; 
                            $result = $conn->query($sql);
                        }else{
                            $sql = "SELECT * FROM db_account LIMIT $limit OFFSET $offset";
                            $result = $conn->query($sql);
                        }
                        if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['email']; ?>"></td> 
                            <td><?php echo $row['fullname'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['phone'] ?></td>
                            <td><?php echo $row['password'] ?></td>
                            <td><?php echo $row['role'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormAccount('detail-form', '<?php echo $row['email']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormAccount('edit-form', '<?php echo $row['email']; ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteAccount('<?php echo $row['email']; ?>')"><i class='bx bx-trash'></i></button>
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
                <a href="home.php?page=account&pagetable&limit=<?= $limit ?>">&laquo;</a>
                <a href="home.php?page=account&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=account&pagetable=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=account&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit ?>"> &gt;</a>
                <a href="home.php?page=account&pagetable=<?= $total_pages ?>&limit=<?= $limit ?>"> &raquo;</a>
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
            <div class="form-section">
                <h3>Thông tin cá nhân</h3>
                <div class="form-group">
                    <label for="fullname">Họ và tên:</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="text" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Phân quyền:</label>
                    <select id="role" name="role">
                        <option value="admin">Quản trị viên</option>
                        <option value="customer" >Khách hàng</option>
                        <option value="owner" >Chủ homestay</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="submit_account" class="add-btn">Thêm tài khoản</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>

<!----------------------------------------------- Giao diện cập nhật -------------------------------------------->

<div class="form-container" id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($account) { ?>
       <?php include "../home/header_content.php"; ?>
        <div class="management-container">
            <div class="toolbar">
                <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
                <div class="action-buttons">
                    <button class="detail-btn" title="Chi tiết" onclick="showFormAccount('detail-form', '<?php echo $account['email']; ?>')"><i class='bx bx-detail'></i> Xem thông tin</button>
                    <button class="delete-btn" title="Xóa" onclick="deleteAccount('<?php echo $account['email']; ?>')"></i> Xóa thông tin</button>
                </div>
            </div>
            <h2>Sửa Thông Tin Tài Khoản</h2>
            <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="email" value="<?php echo $account['email']; ?>">

                <div class="form-section">
                    <h3>Thông tin cá nhân</h3>
                    <div class="form-group">
                        <label for="fullname">Họ và tên:</label>
                        <input type="text" id="fullname" name="fullname" value="<?php echo $account['fullname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $account['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo $account['phone']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input type="text" id="password" name="password" value="<?php echo $account['password']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Phân quyền:</label>
                        <select id="role" name="role">
                            <option value="admin" <?php echo ($account['role'] == 'admin') ? 'selected' : ''; ?>>Quản trị viên</option>
                            <option value="customer" <?php echo ($account['role'] == 'customer') ? 'selected' : ''; ?>>Khách hàng</option>
                            <option value="owner" <?php echo ($account['role'] == 'owner') ? 'selected' : ''; ?>>Chủ homestay</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
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
<div class="form-container" id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($account) { ?>
        <?php include "../home/header_content.php"; ?>
        <div class="management-container">
            <div class="toolbar">
                <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
                <div class="action-buttons">
                    <button class="edit-btn" title="Sửa" onclick="showFormAccount('edit-form', '<?php echo $account['email']; ?>')"><i class='bx bx-edit-alt'></i> Sửa thông tin</button>
                    <button class="delete-btn" title="Xóa" onclick="deleteAccount('<?php echo $account['email']; ?>')"></i> Xóa thông tin</button>
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
                        <p><?php echo $account['role']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin tài khoản.</p>
    <?php } ?>
</div>