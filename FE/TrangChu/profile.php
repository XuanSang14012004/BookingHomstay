<?php
session_start();
require_once('../../BE/Config/connect.php');

// ✅ Kiểm tra đăng nhập
if (!isset($_SESSION['account_id'])) {
    header("Location: ../../Login/login.php");
    exit();
}

$account_id = $_SESSION['account_id'];
$user = []; 
$customer_id = null; 

// --- HÀM LẤY THÔNG TIN NGƯỜI DÙNG ---
function getUserInfo($conn, $account_id) {
    $sql = "
        SELECT a.account_id, a.fullname, a.email, a.phone, a.role,
               c.customer_id, c.gender, c.address, c.birthday, c.avatar
        FROM db_account a
        LEFT JOIN db_customer c ON a.account_id = c.account_id
        WHERE a.account_id = ?
    ";

    $stmt = $conn->prepare($sql);
    // ⚠️ KIỂM TRA LỖI Prepare
    if (!$stmt) {
        error_log("Lỗi Prepare getUserInfo: " . $conn->error);
        return false;
    }
    
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $fields = ['customer_id', 'gender', 'address', 'birthday', 'avatar'];
        foreach ($fields as $f) {
            if (!isset($user_data[$f]) || is_null($user_data[$f])) {
                $user_data[$f] = '';
            }
        }
        $stmt->close();
        return $user_data;
    } else {
        $stmt->close();
        return false; 
    }
}

// Lấy thông tin người dùng lần đầu
$user = getUserInfo($conn, $account_id);

if ($user === false) {
    echo "<script>alert('Không tìm thấy thông tin người dùng hoặc lỗi truy vấn!'); window.location='user_main.php';</script>";
    exit();
}

$customer_id = $user['customer_id'];

// --- XỬ LÝ CẬP NHẬT THÔNG TIN CÁ NHÂN (Hồ sơ) ---
$update_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $birthday = trim($_POST['birthday']);

    // 1. Cập nhật bảng db_account (fullname, email, phone)
    $update_account_sql = "UPDATE db_account SET fullname = ?, email = ?, phone = ? WHERE account_id = ?";
    $stmt_acc = $conn->prepare($update_account_sql);
    if (!$stmt_acc) {
        $update_message = "<script>alert('Lỗi chuẩn bị truy vấn tài khoản: " . $conn->error . "');</script>";
    } else {
        $stmt_acc->bind_param("sssi", $fullname, $email, $phone, $account_id);
        $stmt_acc->execute();
        $stmt_acc->close();
    }


    // 2. Cập nhật/Chèn vào bảng db_customer (gender, address, birthday)
    $success = true;
    if (empty($customer_id)) {
        $insert_customer_sql = "INSERT INTO db_customer (account_id, gender, address, birthday) VALUES (?, ?, ?, ?)";
        $stmt_cus = $conn->prepare($insert_customer_sql);
        if (!$stmt_cus) {
            $update_message = "<script>alert('Lỗi chuẩn bị truy vấn chèn khách hàng: " . $conn->error . "');</script>";
            $success = false;
        } else {
            $stmt_cus->bind_param("isss", $account_id, $gender, $address, $birthday);
            $success = $stmt_cus->execute();
            
            if ($success) {
                $customer_id = $conn->insert_id;
                $user['customer_id'] = $customer_id;
            }
            $stmt_cus->close();
        }
    } else {
        $update_customer_sql = "UPDATE db_customer SET gender = ?, address = ?, birthday = ? WHERE customer_id = ?";
        $stmt_cus = $conn->prepare($update_customer_sql);
        if (!$stmt_cus) {
            $update_message = "<script>alert('Lỗi chuẩn bị truy vấn cập nhật khách hàng: " . $conn->error . "');</script>";
            $success = false;
        } else {
            $stmt_cus->bind_param("sssi", $gender, $address, $birthday, $customer_id);
            $success = $stmt_cus->execute();
            $stmt_cus->close();
        }
    }
    
    if ($success && empty($update_message)) {
        // Cập nhật lại thông tin user sau khi lưu thành công
        $user = getUserInfo($conn, $account_id); 
        $update_message = "<script>alert('Cập nhật thông tin cá nhân thành công!'); window.location='profile.php#ho_so_ca_nhan';</script>";
    } elseif(!$success && empty($update_message)) {
        $update_message = "<script>alert('Lỗi khi cập nhật thông tin cá nhân!');</script>";
    }
}


// --- XỬ LÝ UPLOAD ẢNH ĐẠI DIỆN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    // Logic xử lý upload ảnh (giữ nguyên, đảm bảo $customer_id được tạo nếu chưa có)
    if (empty($customer_id)) {
        $insert_customer_sql = "INSERT INTO db_customer (account_id) VALUES (?)";
        $stmt_cus = $conn->prepare($insert_customer_sql);
        if ($stmt_cus) {
             $stmt_cus->bind_param("i", $account_id);
             $stmt_cus->execute();
             $customer_id = $conn->insert_id;
             $user['customer_id'] = $customer_id;
             $stmt_cus->close();
        }
    }
    
    $file = $_FILES['avatar'];

    if ($file['error'] === 0) {
        $targetDir = "../uploads/avatar/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

        $ext = strtolower(pathinfo(basename($file['name']), PATHINFO_EXTENSION));
        $fileName = "avatar_" . $account_id . "_" . time() . "." . $ext;
        $targetFile = $targetDir . $fileName;

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($ext, $allowed)) {
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                
                if (!empty($user['avatar']) && file_exists($user['avatar'])) {
                    unlink($user['avatar']);
                }

                $update_sql = "UPDATE db_customer SET avatar = ? WHERE customer_id = ?";
                $stmt_up = $conn->prepare($update_sql);
                if ($stmt_up) {
                    $stmt_up->bind_param("si", $targetFile, $customer_id);
                    $stmt_up->execute();
                    $stmt_up->close();
                    
                    $user['avatar'] = $targetFile;
                    echo "<script>alert('Cập nhật ảnh đại diện thành công!'); window.location='profile.php';</script>";
                    exit;
                } else {
                     echo "<script>alert('Lỗi chuẩn bị truy vấn cập nhật avatar: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Lỗi khi tải ảnh lên.');</script>";
            }
        } else {
            echo "<script>alert('Chỉ chấp nhận định dạng JPG, PNG, WEBP.');</script>";
        }
    } else if ($file['error'] !== 4) {
        echo "<script>alert('Lỗi: " . $file['error'] . " khi upload file.');</script>";
    }
}

// --- XỬ LÝ ĐỔI MẬT KHẨU (Khung xử lý) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    // ⚠️ LOGIC XỬ LÝ ĐỔI MẬT KHẨU CẦN ĐƯỢC THÊM VÀO ĐÂY SAU ⚠️
    echo "<script>alert('Chức năng đổi mật khẩu đang được phát triển!');</script>";
}


// --- LẤY LỊCH SỬ ĐẶT PHÒNG (Động) ---


$customer_id = $_SESSION['account_id'] ?? null;
$history = new class { public $num_rows = 0; public function fetch_assoc() { return null; } };

if ($customer_id) {
    $sql_history = "
        SELECT 
            b.booking_id, b.created_at, b.status, b.total_price, 
            b.checkin_date, b.checkout_date, b.guests, b.payment_method,
            h.homestay_name, h.img
        FROM db_booking b
        JOIN db_homestay h ON b.homestay_id = h.homestay_id
        WHERE b.customer_id = ?
        ORDER BY b.created_at DESC
    ";

    $stmt2 = $conn->prepare($sql_history);
    if ($stmt2) {
        $stmt2->bind_param("i", $customer_id);
        $stmt2->execute();
        $history = $stmt2->get_result();
        $stmt2->close();
    } else {
        die("Lỗi Prepare: " . $conn->error);
    }
}


// --- LẤY ĐÁNH GIÁ CỦA TÔI (Động) ---
$customer_id = $_SESSION['account_id'] ?? null;

$reviews = new class { public $num_rows = 0; public function fetch_assoc() { return null; } };

if ($customer_id) {
    $sql = "
        SELECT r.review_id, r.review, r.rating, r.created_at, h.homestay_name
        FROM db_review r
        JOIN db_booking b ON r.booking_id = b.booking_id
        JOIN db_homestay h ON b.homestay_id = h.homestay_id
        WHERE b.customer_id = ?
        ORDER BY r.created_at DESC
    ";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $reviews = $stmt->get_result();
        $stmt->close();
    } else {
        die("Lỗi prepare: " . $conn->error);
    }
}


// Đóng kết nối
$conn->close();

/**
 * Hàm tạo chuỗi sao dựa trên số điểm
 * @param int|float $rating
 * @return string
 */
function displayStars($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $stars .= '⭐';
        } else {
            $stars .= '☆';
        }
    }
    return $stars;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân | Booking HomeStay</title>
    <link rel="stylesheet" href="../CSS/style_user.css?v=17">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../JS/JS_TRANGCHU.js"></script>
</head>

<body>
    <header class="main-header">
        <div class="header-container">
            <a href="./../TrangChu/user_main.php" class="logo">BookingHomeStay</a>
            <nav class="main-nav">
                <ul>
                    <li><a href="./../TrangChu/user_main.php">Trang chủ</a></li>
                    <li><a href="./../TrangChu/about.php">Về chúng tôi</a></li>
                    <li><a href="./../TrangChu/user_homestay.php">HomeStay</a></li>
                    <li><a href="#feedback">Đánh giá</a></li>
                    <li><a href="./../TrangChu/contact.html">Liên hệ</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <a href="../PLACE/history.php" class="cart-icon" title="Giỏ hàng"><i
                        class="fa-solid fa-cart-shopping"></i></a>
                <div class="user-menu-wrapper">
                    <a href="javascript:void(0);" id="userIcon" class="user-icon-link">
                        <i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($user['fullname']); ?>
                    </a>
                    <div class="dropdown-menu" id="userDropdown">
                        <div class="user-info-dropdown">
                            <img src="<?php echo htmlspecialchars($user['avatar'] ? $user['avatar'] : '../images/default_avt.png'); ?>"
                                alt="Avatar" class="avatar">
                            <div>
                                <span
                                    class="dropdown-username"><?php echo htmlspecialchars($user['fullname']); ?></span>
                                <p class="dropdown-email"><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                        </div>
                        <hr>
                        <a href="profile.php"><i class="fa-solid fa-user-circle"></i> Hồ sơ cá nhân</a>
                        <a href="profile.php#mat_khau"><i class="fa-solid fa-gear"></i> Đổi mật khẩu</a>
                        <a href="../../Login/logout.php" class="logout"><i class="fa-solid fa-sign-out"></i> Đăng
                            xuất</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?php echo $update_message; ?>

    <div class="profile-container">
        <div class="profile-left">
            <div class="profile-left-img">
                <img id="avatar-display"
                    src="<?php echo htmlspecialchars($user['avatar'] ? $user['avatar'] : '../images/default_avt.png'); ?>"
                    alt="Avatar">
                <h2><?php echo htmlspecialchars($user['fullname']); ?></h2>
                <p><i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                <form action="profile.php" method="POST" enctype="multipart/form-data" id="avatar-form">
                    <input type="file" name="avatar" id="avatar-upload" style="display: none;"
                        onchange="document.getElementById('avatar-form').submit();">
                    <button type="button" class="btn btn-secondary"
                        onclick="document.getElementById('avatar-upload').click();">
                        <i class="fa-solid fa-camera"></i> Đổi ảnh
                    </button>
                </form>
            </div>

            <div class="profile-left-menu">
                <a href="#ho_so_ca_nhan" class="menu-item active"><i class="fa-solid fa-user-circle"></i> Hồ sơ cá
                    nhân</a>
                <a href="#lich_su_dat_phong" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> Lịch sử đặt
                    phòng</a>
                <a href="#danh_gia_cua_toi" class="menu-item"><i class="fa-solid fa-star-half-stroke"></i> Đánh giá của
                    tôi</a>
                <a href="#mat_khau" class="menu-item"><i class="fa-solid fa-key"></i> Đổi mật khẩu</a>
            </div>
        </div>

        <div class="profile-right-wrapper">

            <div class="profile-right" id="ho_so_ca_nhan" style="display: block;">
                <h2><i class="fa-solid fa-id-card"></i> Thông tin & Sửa hồ sơ</h2>
                <hr>
                <form action="profile.php" method="POST">
                    <div class="form-group">
                        <label for="fullname">Họ và Tên:</label>
                        <input type="text" id="fullname" name="fullname"
                            value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email"
                            value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" id="phone" name="phone"
                            value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh:</label>
                        <input type="date" id="birthday" name="birthday"
                            value="<?php echo htmlspecialchars($user['birthday']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính:</label>
                        <select id="gender" name="gender">
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" <?php echo $user['gender'] == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo $user['gender'] == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Khác" <?php echo $user['gender'] == 'Khác' ? 'selected' : ''; ?>>Khác
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" id="address" name="address"
                            value="<?php echo htmlspecialchars($user['address']); ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="update_profile" class="btn btn-primary"><i
                                class="fa-solid fa-save"></i> Lưu Thay Đổi</button>
                    </div>
                </form>
            </div>

            <div class="profile-right" id="lich_su_dat_phong" style="display: none;">
                <h2><i class="fa-solid fa-receipt"></i> Lịch sử Đặt phòng</h2>
                <hr>
                <div class="history-list-area">
                    <?php if ($history->num_rows > 0): ?>
                    <?php while ($row = $history->fetch_assoc()): 
                        $status_class = '';
                        $status_icon = '';
                        if ($row['status'] === 'Đã xác nhận') {
                            $status_class = 'confirmed';
                            $status_icon = 'fa-check-circle';
                        } elseif ($row['status'] === 'Chưa xác nhận') {
                            $status_class = 'pending';
                            $status_icon = 'fa-clock';
                        } elseif ($row['status'] === 'Đã hủy') {
                            $status_class = 'cancelled';
                            $status_icon = 'fa-times-circle';
                        }
                    ?>
                    <div class="history-card">
                        <div class="history-card-thumb">
                            <img src="<?php echo htmlspecialchars($row['img']); ?>"
                                alt="<?php echo htmlspecialchars($row['homestay_name']); ?>">
                        </div>

                        <div class="history-card-details">
                            <h3 class="homestay-name"><?php echo htmlspecialchars($row['homestay_name']); ?></h3>
                            <p class="booking-date-range">
                                <i class="fa-solid fa-calendar-alt"></i>
                                Từ <b><?php echo date('d/m/Y', strtotime($row['checkin_date'])); ?></b>
                                đến <b><?php echo date('d/m/Y', strtotime($row['checkout_date'])); ?></b>
                            </p>
                            <p class="guest-count"><i class="fa-solid fa-users"></i> <?php echo $row['guests']; ?> khách
                            </p>
                            <p class="total-price">
                                <i class="fa-solid fa-money-bill-wave"></i>
                                Tổng tiền: <b><?php echo number_format($row['total_price'], 0, ",", "."); ?>đ</b>
                            </p>
                            <span class="status-tag <?php echo $status_class; ?>">
                                <i class="fa-solid <?php echo $status_icon; ?>"></i>
                                <?php echo htmlspecialchars($row['status']); ?>
                            </span>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <div class="no-history-message">
                        <i class="fa-solid fa-box-open"></i>
                        <p>Bạn chưa có lịch sử đặt phòng nào.</p>
                        <a href="./../TrangChu/user_homestay.php" class="btn-browse-homestay">Đặt phòng ngay</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="profile-right" id="danh_gia_cua_toi" style="display: none;">
                <h2><i class="fa-solid fa-star"></i> Đánh giá của tôi</h2>
                <hr>
                <div class="review-list-area">
                    <?php if ($reviews->num_rows > 0): ?>
                    <?php while ($row = $reviews->fetch_assoc()): ?>
                    <div class="review-card" data-review-id="<?php echo $row['review_id']; ?>">
                        <div class="review-homestay-thumb">
                            <i class="fa-solid fa-home"
                                style="font-size: 50px; color: #007bff; display: block; text-align: center; line-height: 100px;"></i>
                        </div>
                        <div class="review-details">
                            <h3 class="homestay-name"><?php echo htmlspecialchars($row['homestay_name']); ?></h3>
                            <p class="review-rating"><?php echo displayStars($row['rating']); ?></p>
                            <p class="review-content">**Nội dung:** <?php echo htmlspecialchars($row['review']); ?></p>
                            <p class="review-meta">Ngày đánh giá:
                                <?php echo date('d/m/Y', strtotime($row['created_at'])); ?></p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <div class="no-reviews-message">
                        <i class="fa-solid fa-comment-dots"></i>
                        <p>Bạn chưa có đánh giá nào.</p>
                        <p>Hãy đặt phòng và chia sẻ trải nghiệm của bạn!</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="profile-right" id="mat_khau" style="display: none;">
                <h2><i class="fa-solid fa-key"></i> Đổi mật khẩu</h2>
                <hr>
                <form action="profile.php" method="POST">
                    <div class="form-group">
                        <label for="old_password">Mật khẩu cũ:</label>
                        <input type="password" id="old_password" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Mật khẩu mới:</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Xác nhận mật khẩu mới:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="change_password" class="btn btn-primary"><i
                                class="fa-solid fa-refresh"></i> Đổi mật khẩu</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <footer class="footer">
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Lấy tham chiếu đến các phần tử
        const menuItems = document.querySelectorAll('.profile-left-menu .menu-item');
        const profileSections = document.querySelectorAll('.profile-right');

        // Hàm xử lý chuyển đổi tab
        function switchTab(targetId) {
            // Loại bỏ active khỏi tất cả menu item
            menuItems.forEach(item => {
                item.classList.remove('active');
            });

            // Ẩn tất cả profile-right
            profileSections.forEach(div => {
                div.style.display = 'none';
            });

            // Hiện phần được chọn
            let targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.style.display = 'block';
                // Thêm active vào menu item tương ứng
                document.querySelector(`.profile-left-menu a[href="#${targetId}"]`).classList.add('active');
            }
        }

        // Xử lý sự kiện click trên menu
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1); // Lấy ID
                history.pushState(null, null, 'profile.php#' + targetId); // Cập nhật URL
                switchTab(targetId);
            });
        });

        // Xử lý khi load trang hoặc khi có hash trong URL
        function checkHash() {
            const hash = window.location.hash.substring(1);
            const defaultTab = 'ho_so_ca_nhan';
            if (hash && document.getElementById(hash)) {
                switchTab(hash);
            } else {
                switchTab(defaultTab);
            }
        }

        // Chạy khi DOMContentLoaded và khi hash thay đổi
        checkHash();
        window.addEventListener('hashchange', checkHash);

        // Logic cho dropdown menu header (giữ nguyên)
        const userIcon = document.getElementById('userIcon');
        const userDropdown = document.getElementById('userDropdown');
        if (userIcon && userDropdown) {
            userIcon.addEventListener('click', (event) => {
                userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
                event.stopPropagation();
            });
            document.addEventListener('click', (event) => {
                if (userDropdown.style.display === 'block' && !userIcon.contains(event.target) && !
                    userDropdown.contains(event.target)) {
                    userDropdown.style.display = 'none';
                }
            });
        }
    });
    </script>
</body>

</html>