<div class="manage-container">
    <div class="profile-container">
        <div class ="profile-left">
            <div class ="profile-left-img">
                <p><img src="../images/7.webp" alt="Avatar"></p>
                <h2>nguyensang14012004</h2>
                <p><i class="fa-solid fa-pen"></i>Sửa hồ sơ</p>
            </div> 
            <div class="profile-left-content">
                <div class="content-list">
                    <h3>Tài khoản của tôi</h3>
                    <ul>
                        <li><a href="#hoso">Hồ sơ</a></li>
                        <li><a href="#diachi">Địa chỉ</a></li>
                        <li><a href="#lichsu">Lịch sử đặt hàng</a></li>
                        <li><a href="#danhgia">Đánh giá của tôi</a></li>
                        <li><a href="#matkhau">Đổi mật khẩu</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="profile-right" id="hoso">
            <h2>Hồ Sơ Của Tôi</h2>
            <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            <div class="profile-form">
                <div class="form-left">
                    <div class="form-group">
                        <label>Tên đăng nhập : </label>
                        <p>nguyensang1401</p>
                    </div>

                    <div class="form-group">
                        <label>Tên :</label>
                        <input type="text" value="Sáng">
                    </div>

                    <div class="form-group">
                        <label>Email :</label>
                        <p>nguyensang@gmail.com <a href="#">Thay Đổi</a></p>
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại :</label>
                        <p>0123456789 <a href="#">Thêm</a></p>
                    </div>

                    <div class="form-group">
                        <label>Giới tính</label>
                        <label><input type="radio" name="gender"> Nam</label>
                        <label><input type="radio" name="gender"> Nữ</label>
                        <label><input type="radio" name="gender"> Khác</label>
                    </div>

                    <div class="form-group">
                        <label>Ngày sinh :</label>
                        <p>14/01/2004 <a href="#">Thay Đổi</a></p>
                    </div>

                    <button class="btn">Lưu</button>
                </div>

                <div class="avatar-box">
                    <img src="../images/7.webp" alt="avatar">
                    <input type="file"><button>Chọn Ảnh </button></input>

                    <p>Dung lượng file tối đa 1 MB<br>Định dạng: .JPEG, .PNG</p>
                </div>
            </div>
        </div>
        <!-- ------------địa chỉ-------------- -->
        <div class="profile-right" id="diachi" style="display:none;">
            <h2>Địa chỉ của tôi</h2>
            <p>Quản lý thông tin địa chỉ để thuận tiện khi đặt homestay</p>

            <div class="address-list">
                <div class="address-item">
                    <p><b>Nguyensang14</b> | 0123 456 789</p>
                    <p>123 Đường ABC, Quận 1, TP. HCM</p>
                    <button class="btn-edit">Sửa</button>
                    <button class="btn-delete">Xóa</button>
                </div>

                <div class="address-item">
                    <p><b>sangnguyen1401</b> | 0987 654 321</p>
                    <p>456 Đường XYZ, Quận 2, TP. HCM</p>
                    <button class="btn-edit">Sửa</button>
                    <button class="btn-delete">Xóa</button>
                </div>
            </div>

                <button class="btn">+ Thêm địa chỉ mới</button>
        </div>

            <!-- ------------đổi mật khẩu-------------- -->
        <div class="profile-right" id="matkhau" style="display:none;">
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
