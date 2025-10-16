<?php
require_once "../../config/connect.php";

$account_id = $_SESSION['account_id'] ?? null;
if (!$account_id) {
    echo "Bạn chưa đăng nhập!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $fullname = trim($_POST['fullname'] ?? '');
    $birthday = trim($_POST['birthday'] ?? null);
    $gender   = trim($_POST['gender'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');

    $sql_current_img = "SELECT image FROM db_admin WHERE account_id = ?";
    $stmt_img = $conn->prepare($sql_current_img);
    $stmt_img->bind_param("s", $account_id);
    $stmt_img->execute();
    $res_img = $stmt_img->get_result();
    $current_img = ($res_img && $r = $res_img->fetch_assoc()) ? $r['image'] : '';

    $imageName = $current_img;
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . "/../../Images/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $origName = basename($_FILES['image']['name']);
        $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $origName);
        $target = $uploadDir . $safeName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $imageName = $safeName;
        }
    }

    $sql_update = "UPDATE db_admin SET fullname = ?, birthday = ?, gender = ?, email = ?, phone = ?, address = ?, image = ? WHERE account_id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssssssss", $fullname, $birthday, $gender, $email, $phone, $address, $imageName, $account_id);
    $success = $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$sql_acc = "SELECT * FROM db_account WHERE account_id = '$account_id'";
$res_acc = mysqli_query($conn, $sql_acc);
$acc = $res_acc && mysqli_num_rows($res_acc) > 0 ? mysqli_fetch_assoc($res_acc) : null;

$sql = "SELECT * FROM db_admin WHERE account_id = '$account_id'";
$result = mysqli_query($conn, $sql);
$row = $result && mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : null;

if (!$row || !$acc) {
    echo "Không tìm thấy thông tin tài khoản!";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'change_password') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $account_id = $_SESSION['account_id'] ?? null;
    $response = ['success' => false, 'message' => ''];

    if (!$account_id) {
        $response['message'] = 'Bạn chưa đăng nhập!';
        echo json_encode($response); exit();
    }
    $sql = "SELECT password FROM db_account WHERE account_id = '$account_id'";
    $result = mysqli_query($conn, $sql);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $current_password = $row['password'];
        if ($old_password !== $current_password) {
            $response['message'] = 'Mật khẩu hiện tại không đúng!';
        } else {
            $sql_update = "UPDATE db_account SET password = '$new_password' WHERE account_id = '$account_id'";
            if (mysqli_query($conn, $sql_update)) {
                $response['success'] = true;
                $response['message'] = 'Đổi mật khẩu thành công!';
            } else {
                $response['message'] = 'Lỗi khi cập nhật mật khẩu!';
            }
        }
    } else {
        $response['message'] = 'Không tìm thấy tài khoản!';
    }
    echo json_encode($response); exit();
}

?>
    <div class="profile-container">
        <div class="profile-left">
            <div class="profile-left-img">
                <p><img src="../../Images/<?php echo htmlspecialchars($row['image']); ?>" alt="Avatar"></p>
                <h2 class="profile-name"><?php echo htmlspecialchars($row['fullname']); ?></h2>
            </div>
            <div class="profile-left-content">
                <div class="content-list">
                    <h3>Tài khoản của tôi</h3>
                    <ul>
                        <li><button id="btn-info" class="active" onclick="showProfileTab('info')">Thông tin cá nhân</button></li>
                        <li><button id="btn-password" onclick="showProfileTab('password')">Đổi mật khẩu</button></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Thông tin cá nhân -->
        <div class="profile-right active" id="profile-info">
            <h2 style="color:#007bff;font-weight:600;">Hồ Sơ Của Tôi</h2>
            <p style="color:#888;margin-bottom:10px;">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            <form class="profile-form" autocomplete="off">
                <div class="form-left">
                    <div class="info-group">
                        <label>Họ và tên :</label>
                        <p><?php echo htmlspecialchars($row['fullname']); ?></p>
                    </div>
                    <div class="info-group">
                        <label>Ngày sinh :</label>
                        <p><?php echo date("d/m/Y", strtotime($row['birthday'])); ?></p>
                    </div>
                    <div class="info-group">
                        <label>Giới tính :</label>
                        <p><?php echo htmlspecialchars($row['gender']); ?></p>
                    </div>
                    <div class="info-group">
                        <label>Email :</label>
                        <p><?php echo htmlspecialchars($row['email']); ?></p>
                    </div>
                    <div class="info-group">
                        <label>Số điện thoại :</label>
                        <p><?php echo htmlspecialchars($row['phone']); ?></p>
                    </div>
                    <div class="info-group">
                        <label>Địa chỉ:</label>
                        <p><?php echo htmlspecialchars($row['address']); ?></p>
                    </div>
                    <div style="margin-top:12px;">
                        <button type="button" id="btn-edit-profile" class="btn">Cập nhật thông tin</button>
                    </div>
                </div>
                
                <div class="avatar-box">
                    <img src="../../Images/<?php echo htmlspecialchars($row['image']); ?>" alt="avatar">
                </div>
            </form>

            <form id="updateProfileForm" style="display:none; margin-top:18px;" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Họ và tên</label>
                        <input type="text" name="fullname" value="<?php echo htmlspecialchars($row['fullname']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh</label>
                        <input type="date" name="birthday" value="<?php echo htmlspecialchars($row['birthday']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <select name="gender">
                            <option value="">-- Chọn --</option>
                            <option value="Nam" <?php echo ($row['gender']=='Nam')?'selected':''; ?>>Nam</option>
                            <option value="Nữ" <?php echo ($row['gender']=='Nữ')?'selected':''; ?>>Nữ</option>
                            <option value="Khác" <?php echo ($row['gender']=='Khác')?'selected':''; ?>>Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>">
                    </div>
                    <div class="form-group full">
                        <label>Địa chỉ</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($row['address']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Ảnh đại diện (tùy chọn)</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                </div>

                <div class="form-actions" style="margin-top:12px;">
                    <button type="button" id="btn-cancel-update" class="cancel-btn">Hủy</button>
                    <button type="submit" class="edit-btn">Lưu cập nhật</button>
                </div>
            </form>
        </div>
        <div class="profile-right" id="profile-password">
            <h2 style="color:#007bff;font-weight:600;">Đổi mật khẩu</h2>
            <p style="color:#888;">Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác.</p>
            <form id="changePasswordForm" class="password-form" autocomplete="off" method="post">
                <div class="form-group">
                    <label for="old-password">Mật khẩu hiện tại:</label>
                    <input type="password" id="old-password" name="old_password" required placeholder="Nhập mật khẩu cũ">
                </div>
                <div class="form-group">
                    <label for="new-password">Mật khẩu mới:</label>
                    <input type="password" id="new-password" name="new_password" required placeholder="Nhập mật khẩu mới">
                </div>
                <div class="form-group">
                    <label for="confirm-password">Xác nhận mật khẩu mới:</label>
                    <input type="password" id="confirm-password" name="confirm_password" required placeholder="Nhập lại mật khẩu mới">
                </div>
                <button type="submit" class="btn">Lưu thay đổi</button>
                <div id="password-message"></div>
            </form>
        </div>
    </div>


