<?php 
$sql = "SELECT * FROM db_account";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);

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

$profile = null;
if (($is_edit_form || $is_detail_form) && $email) {
    $result = $conn->query("SELECT * FROM db_account WHERE email = '$email'");
    if ($result && $result->num_rows > 0) {
        $profile = mysqli_fetch_assoc($result);
    }
}

?>
    <div class="form-container">
        <div class="profile-container">
            <div class ="profile-left">
                <div class ="profile-left-img">
                    <p><img src="../../Images/user.jpg" alt="Avatar"></p>
                    <h2 class="profile-name"><?php echo $row['fullname'] ?></h2>
                    <p><i class='bx bx-edit-alt' ></i></i>Sửa hồ sơ</p>
                </div> 
                <div class="profile-left-content">
                    <div class="content-list">
                        <h3>Tài khoản của tôi</h3>
                        <ul>
                            <li><button  onclick="showFormProfile('detail-form', '<?php echo $row['email']; ?>')">Thông tin cá nhân</button></li>
                            <li><button  onclick="showFormProfile('edit-form', '<?php echo $row['email']; ?>')">Đổi mật khẩu</button></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="profile-right" id="info-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
                <h2>Hồ Sơ Của Tôi</h2>
                <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
                <div class="profile-form">
                    <div class="form-left">

                        <div class="form-group">
                            <label>Họ và tên :</label>
                            <p><?php echo $row['fullname'] ?> </p>
                        </div>

                        <div class="form-group">
                            <label>Email :</label>
                            <p><?php echo $row['email'] ?> <a href="#">Thay Đổi</a></p>
                        </div>

                        <div class="form-group">
                            <label>Số điện thoại :</label>
                            <p><?php echo $row['phone'] ?></p>
                        </div>

                        <div class="form-group">
                            <label>giới tính :</label>
                            <p>Nam</p>
                        </div>

                        <div class="form-group">
                            <label>Ngày sinh :</label>
                            <p>01/03/2004</p>
                        </div>

                        <button class="btn">Lưu</button>
                    </div>

                    <div class="avatar-box">
                        <img src="../../Images/user.jpg" alt="avatar">
                        <input type="file"><button>Chọn Ảnh </button></input>

                        <p>Dung lượng file tối đa 1 MB<br>Định dạng: .JPEG, .PNG</p>
                    </div>
                </div>
            </div>
            <div class="profile-right" id="account-form" style="display:none;">
                <h2>Hồ Sơ Của Tôi</h2>
                <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
                <div class="profile-form">
                    <div class="form-left">

                        <div class="form-group">
                            <label>Họ và tên :</label>
                            <p><?php echo $row['fullname'] ?> </p>
                        </div>

                        <div class="form-group">
                            <label>Email :</label>
                            <p><?php echo $row['email'] ?> <a href="#">Thay Đổi</a></p>
                        </div>

                        <div class="form-group">
                            <label>Số điện thoại :</label>
                            <p><?php echo $row['phone'] ?></p>
                        </div>

                        <div class="form-group">
                            <label>giới tính :</label>
                            <p>Nam</p>
                        </div>

                        <div class="form-group">
                            <label>Ngày sinh :</label>
                            <p>01/03/2004</p>
                        </div>

                        <button class="btn">Lưu</button>
                    </div>

                    <div class="avatar-box">
                        <img src="../../Images/user.jpg" alt="avatar">
                        <input type="file"><button>Chọn Ảnh </button></input>

                        <p>Dung lượng file tối đa 1 MB<br>Định dạng: .JPEG, .PNG</p>
                    </div>
                </div>
            </div>

                <!-- ------------đổi mật khẩu-------------- -->
            <div class="profile-right" id="password-form" style="display:none;" >
                    <h2>Đổi mật khẩu</h2>
                    <p>Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác.</p>
                    <hr>

                <div class="password-form">
                    <div class="form-group">
                        <label for="old-password">Mật khẩu hiện tại:</label>
                        <input type="password" id="old-password" placeholder="Nhập mật khẩu cũ">
                    </div>

                    <div class="form-group">
                        <label for="new-password">Mật khẩu mới:</label>
                        <input type="password" id="new-password" placeholder="Nhập mật khẩu mới">
                    </div>

                    <div class="form-group">
                        <label for="confirm-password">Xác nhận mật khẩu mới:</label>
                        <input type="password" id="confirm-password" placeholder="Nhập lại mật khẩu mới">
                    </div>

                    <button class="btn">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>

