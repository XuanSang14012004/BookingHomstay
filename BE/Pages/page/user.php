<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_user') {
    $is_add_form = true;
} else if ($action === 'edit_user') {
    $is_edit_form = true;
} else if ($action === 'detail_user') {
    $is_detail_form = true;
} else if ($action === 'search_user') {
    $is_view_form = true;
} else {
    $is_view_form = true; 

}

$customer_id = isset($_GET['id']) ? $_GET['id'] : null;

$user = null;
if (($is_edit_form || $is_detail_form) && $customer_id) {
    $result = $conn->query("SELECT * FROM db_customer WHERE customer_id = '$customer_id '");
    if ($result && $result->num_rows > 0) {
        $user = mysqli_fetch_assoc($result);
    }
}
?>
<!-------------------------------- Giao diện chính ------------------------------------>
<div class="form-container" id="user-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;"> 
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý thông tin Khách hàng</h2>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormUser('add-form')"><i class='bx bx-plus'></i> Thêm Khách hàng mới</button>
            <div class="search-box">
                <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm khách hàng...">
                <button type="submit" class="search-btn" onclick="showFormUser('search-form')"><i class='bx bx-search'></i></button>
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
                            $search = "%".$search_query."%";

                            $sql = "SELECT * FROM db_customer WHERE customer_id LIKE '$search' 
                                OR customer_name LIKE '$search' 
                                OR birthday LIKE '$search' 
                                OR gender LIKE '$search' 
                                OR email LIKE '$search' 
                                OR customer_phone LIKE '$search' 
                                OR address LIKE '$search' ";
                            $result = $conn->query($sql); 
                            $i = 1;
                        }else{
                            $result = $conn->query("SELECT * FROM db_customer");
                            $i = 1;
                        }
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['customer_id'] ?></td>
                            <td><?php echo $row['customer_name'] ?></td>
                            <td><?php echo $row['birthday'] ?></td>
                            <td><?php echo $row['gender'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['customer_phone'] ?></td>
                            <td class="truncate-text"><?php echo $row['address'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormUser('detail-form', '<?php echo $row['customer_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormUser('edit-form', '<?php echo $row['customer_id'] ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteUser('<?php echo $row['customer_id']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
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
        <h2>Thêm Khách Hàng Mới</h2>
        <?php 
            $gender_sql = "SELECT DISTINCT TRIM(gender) as gender FROM `db_customer`";
            $gender_result = mysqli_query($conn, $gender_sql);
        ?>
        <form action="../modules/add_function.php" method="POST">
            <div class="form-section">
                <h3>Thông tin cá nhân</h3>
                <div class="form-group">
                    <label for="customer_id">Mã Khách hàng:</label>
                    <input type="text" id="customer_id" name="customer_id" required>
                </div>
                <div class="form-group">
                    <label for="customer_name">Họ và Tên:</label>
                    <input type="text" id="customer_name" name="customer_name" required>
                </div>
                <div class="form-group">
                    <label for="birthday">Ngày sinh:</label>
                    <input type="date" id="birthday" name="birthday" required>
                </div>
                <div class="form-group">
                    <label for="gender">Giới tính :</label>
                    <select id="gender" name="gender" required>
                         <?php
                            if ($gender_result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($gender_result)) {?>
                                <option value="<?php echo $row['gender']; ?>">
                                    <?php echo $row['gender']; ?>
                                </option>
                            <?php } 
                            } else {
                                echo "<option value=''>Không có dữ liệu</option>";
                            }
                            ?>
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
                    <label for="customer_phone">Số điện thoại:</label>
                    <input type="tel" id="customer_phone" name="customer_phone" required>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit_user" class="add-btn">Thêm Khách Hàng</button>
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
        <h2>Sửa Thông Tin Khác Hàng</h2>
        <?php 
            $gender_sql = "SELECT DISTINCT TRIM(gender) as gender FROM `db_customer`";
            $gender_result = mysqli_query($conn, $gender_sql);
        ?>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="customer_id" value="<?php echo $user['customer_id']; ?>">

            <div class="form-section">
                <h3>Thông tin cá nhân</h3>
                <div class="form-group">
                    <label for="customer_id">Mã Khách hàng:</label>
                    <input type="text" id="customer_id" name="customer_id" value="<?php echo $user['customer_id']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="customer_name">Họ và Tên:</label>
                    <input type="text" id="customer_name" name="customer_name" value="<?php echo $user['customer_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="birthday">Ngày sinh:</label>
                    <input type="date" id="birthday" name="birthday" value="<?php echo $user['birthday']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="gender">Giới tính :</label>
                    <select id="gender" name="gender" required>
                        <?php
                            if ($gender_result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($gender_result)) {?>
                                <option value="<?php echo $row['gender']; ?>">
                                    <?php echo $row['gender']; ?>
                                </option>
                            <?php } 
                            } else {
                                echo "<option value=''>Không có dữ liệu</option>";
                            }
                            ?>
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
                    <label for="customer_phone">Số điện thoại:</label>
                    <input type="tel" id="customer_phone" name="customer_phone" value="<?php echo $user['customer_phone']; ?>" required>
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
                    <label for="customer_name">Họ và Tên:</label>
                    <p><?php echo $user['customer_name']; ?></p>
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
                    <label for="customer_phone">Số điện thoại:</label>
                    <p><?php echo $user['customer_phone']; ?></p>
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