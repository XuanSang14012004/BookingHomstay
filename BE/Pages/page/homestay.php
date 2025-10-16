<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_add_form = false;
$is_edit_form = false;
$is_detail_form = false;

if ($action === 'add_homestay') {
    $is_add_form = true;
} else if ($action === 'search_homestay') {
    $is_view_form = true;
} else if ($action === 'edit_homestay') {
    $is_edit_form = true;
} else if ($action === 'detail_homestay') {
    $is_detail_form = true;
} else {
    $is_view_form = true;
}

$homestay_id = isset($_GET['id']) ? $_GET['id'] : null;

$homestay = null;
if (($is_edit_form || $is_detail_form) && $homestay_id) {
    $result = $conn->query("SELECT * FROM db_homestay WHERE homestay_id = '$homestay_id'");
    if ($result && $result->num_rows > 0) {
        $homestay = mysqli_fetch_assoc($result);
    }
}

// Xử lý bộ lọc
$where = [];
if (isset($_GET['status']) && $_GET['status'] !== '') $where[] = "status = '".mysqli_real_escape_string($conn, $_GET['status'])."'";
if (isset($_GET['room_type']) && $_GET['room_type'] !== '') $where[] = "room_type = '".mysqli_real_escape_string($conn, $_GET['room_type'])."'";
if (isset($_GET['owner_id']) && $_GET['owner_id'] !== '') $where[] = "owner_id = '".mysqli_real_escape_string($conn, $_GET['owner_id'])."'";
$where_sql = $where ? 'WHERE '.implode(' AND ', $where) : '';

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;

// Đếm tổng số bản ghi cho phân trang (áp dụng cả lọc)
$count_sql = "SELECT COUNT(*) as total FROM db_homestay $where_sql";
$total_result = $conn->query($count_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>
<!-------------------------------------------------- Giao diện chính --------------------------------------------->
<div class="form-container" id="homestay-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
   <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý Homestay</h2>
        <div class="filter-bar">
            <a href="home.php?page=homestay<?=
                isset($_GET['status']) ? '&status='.urlencode($_GET['status']) : ''
            ?><?=
                isset($_GET['room_type']) ? '&room_type='.urlencode($_GET['room_type']) : ''
            ?><?=
                isset($_GET['owner_id']) ? '&owner_id='.urlencode($_GET['owner_id']) : ''
            ?>" title="Lọc dữ liệu">
                <i class='bx bx-filter'></i>
            </a>
            <form class="filter-form" method="get">
                <input type="hidden" name="page" value="homestay">
                <select name="status" onchange="this.form.submit()">
                    <option value="">-- Trạng thái --</option>
                    <option value="còn phòng" <?= (isset($_GET['status']) && $_GET['status']=='còn phòng')?'selected':''; ?>>Còn phòng</option>
                    <option value="Đã đặt" <?= (isset($_GET['status']) && $_GET['status']=='Đã đặt')?'selected':''; ?>>Đã đặt</option>
                    <option value="Đang bảo trì" <?= (isset($_GET['status']) && $_GET['status']=='Đang bảo trì')?'selected':''; ?>>Đang bảo trì</option>
                </select>
                <select name="room_type" onchange="this.form.submit()">
                    <option value="">-- Loại phòng --</option>
                    <?php
                    $room_types = $conn->query("SELECT DISTINCT room_type FROM db_homestay");
                    while($rt = $room_types->fetch_assoc()) {
                        $val = $rt['room_type'];
                        echo "<option value=\"$val\" ".((isset($_GET['room_type']) && $_GET['room_type']==$val)?'selected':'').">$val</option>";
                    }
                    ?>
                </select>
                <select name="owner_id" onchange="this.form.submit()">
                    <option value="">-- Chủ homestay --</option>
                    <?php
                    $owners = $conn->query("SELECT owner_id, fullname FROM db_owner");
                    while($ow = $owners->fetch_assoc()) {
                        $val = $ow['owner_id'];
                        echo "<option value=\"$val\" ".((isset($_GET['owner_id']) && $_GET['owner_id']==$val)?'selected':'').">{$ow['owner_id']} - {$ow['fullname']}</option>";
                    }
                    ?>
                </select>
            </form>
        </div>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormHomestay('add-form')"><i class='bx bx-plus'></i> Thêm Homestay mới</button>
                <div class="search-box">
                    <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm homestay...">
                    <button type="submit" class="search-btn" onclick="showFormHomestay('search-form')"><i class='bx bx-search'></i></button>
                </div>
        </div>
        <div class="limit-form">
            <form method="get">
                <input type="hidden" name="page" value="homestay">
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
                        <th>Mã Homestay</th>
                        <th>Tên Homestay</th>
                        <th>Địa chỉ</th>
                        <th>Hình ảnh</th>
                        <th>Trạng thái</th>
                        <th>Loại phòng</th>
                        <th>Tiện nghi</th>
                        <th>Mô tả chi tiêt</th>
                        <th>Sức chứa</th>
                        <th>Thời gian Checkin</th>
                        <th>Thời gian checkout</th>
                        <th>Giá thuê (VND)</th>
                        <th>Mã chủ homestay</th>
                        <th>Email liên hệ</th>
                        <th>Số điện thoại</th>
                        <th>Điểm đánh giá</th>
                        <th>Số lượt đánh giá</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['content']) && $_GET['content'] !== '') {
                        $search_query = trim($_GET['content']);
                        $search = "%".$conn->real_escape_string($search_query)."%";

                        $search_where = "(homestay_id LIKE '$search' 
                            OR homestay_name LIKE '$search' 
                            OR room_type LIKE '$search' 
                            OR `status` LIKE '$search' 
                            OR guests LIKE '$search' 
                            OR homestay_email LIKE '$search' 
                            OR homestay_phone LIKE '$search' 
                            OR price LIKE '$search' 
                            OR `address` LIKE '$search' 
                            OR reviews_count LIKE '$search' 
                            OR `description` LIKE '$search'
                            OR `policy` LIKE '$search'
                            OR `owner_id` LIKE '$search'
                            OR checkin LIKE '$search'
                            OR checkout LIKE '$search'
                            OR rating LIKE '$search')";
                        $full_where = $where ? $search_where . " AND " . implode(" AND ", $where) : $search_where;
                        $sql = "SELECT * FROM db_homestay WHERE $full_where LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    } else if ($where_sql) {
                        $sql = "SELECT * FROM db_homestay $where_sql LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    } else {
                        $sql = "SELECT * FROM db_homestay LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    }
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['homestay_id']; ?>"></td> 
                                <td><?php echo $row['homestay_id'] ?></td>
                                <td><?php echo $row['homestay_name'] ?></td>
                                <td><?php echo $row['address'] ?></td>
                                <td><?php echo "<img src='../../../FE/images/" .$row['img']. "' alt='Hình ảnh' "; ?></td> 
                                <td><?php echo $row['status'] ?></td>
                                <td><?php echo $row['room_type'] ?></td>
                                <td class="truncate-text"><?php echo $row['policy'] ?></td>
                                <td class="truncate-text"><?php echo $row['description'] ?></td>
                                <td class="truncate-text"><?php echo $row['guests'] ?></td>
                                <td><?php echo $row['checkin'] ?></td>
                                <td><?php echo $row['checkout'] ?></td>
                                <td><?php echo $row['price'] ?></td>
                                <td><?php echo $row['owner_id'] ?></td> 
                                <td><?php echo $row['homestay_email'] ?></td> 
                                <td><?php echo $row['homestay_phone'] ?></td>
                                <td><?php echo $row['rating'] ?></td>
                                <td><?php echo $row['reviews_count'] ?></td>
                                <td class="actions">
                                    <button class="detail-btn" title="Chi tiết" onclick="showFormHomestay('detail-form', '<?php echo $row['homestay_id']; ?>')"><i class='bx bx-detail'></i></button>
                                    <button class="edit-btn" title="Sửa" onclick="showFormHomestay('edit-form', '<?php echo $row['homestay_id']; ?>')"><i class='bx bx-edit-alt'></i></button>
                                    <button class="delete-btn" title="Xóa" onclick="deleteHomestay('<?php echo $row['homestay_id']; ?>')"><i class='bx bx-trash'></i></button>
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
                <a href="home.php?page=homestay&pagetable&limit=<?= $limit . $contentParam ?>">&laquo;</a>
                <a href="home.php?page=homestay&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit . $contentParam ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=homestay&pagetable=<?= $i ?>&limit=<?= $limit . $contentParam ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=homestay&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit . $contentParam ?>"> &gt;</a>
                <a href="home.php?page=homestay&pagetable=<?= $total_pages ?>&limit=<?= $limit . $contentParam ?>"> &raquo;</a>
            <?php endif; ?>
        </div>  
    </div>
</div>

<!-------------------------------------------------- Giao diện thêm mới --------------------------------------------->
<div class="form-container" id="add-form" style="display:<?php echo $is_add_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
        </div>
        <h2>Thêm Homestay Mới</h2>
        <form action="../modules/add_function.php" method="POST" enctype="multipart/form-data">
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Thông tin cơ bản</h3>
                    <div class="form-group">
                        <label for="homestay_name">Tên Homestay</label>
                        <input type="text" id="homestay_name" name="homestay_name" placeholder="Nhập tên homestay" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <textarea id="address" name="address" rows="2" placeholder="Nhập địa chỉ" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select id="status" name="status">
                            <option value="còn phòng">Còn phòng</option>
                            <option value="Đã đặt">Đã đặt</option>
                            <option value="Đang bảo trì">Đang bảo trì</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room_type">Loại phòng</label>
                        <input type="text" id="room_type" name="room_type" placeholder="Nhập loại phòng" required>
                    </div>
                    <div class="form-group">
                        <label for="checkin">Nhận phòng</label>
                        <input type="text" id="checkin" name="checkin" placeholder="VD: 14:00" required>
                    </div>
                    <div class="form-group">
                        <label for="checkout">Trả phòng</label>
                        <input type="text" id="checkout" name="checkout" placeholder="VD: 12:00" required>
                    </div>
                    <div class="form-group">
                        <label for="guests">Sức chứa</label>
                        <input type="number" id="guests" name="guests" min="1" placeholder="Nhập số khách tối đa" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Giá thuê trung bình (VNĐ/đêm)</label>
                        <input type="number" id="price" name="price" placeholder="Nhập giá thuê" required>
                    </div>
                </div>
                <div style="flex:1;">
                    <h3>Liên hệ & Chủ Homestay</h3>
                    <div class="form-group">
                        <label for="owner_id">Mã chủ homestay</label>
                        <select id="owner_id" name="owner_id">
                            <option value="">Chưa có mã</option>
                            <?php
                                $owner_sql = "SELECT owner_id, fullname FROM db_owner";
                                $owner_result = mysqli_query($conn, $owner_sql);
                                if ($owner_result && mysqli_num_rows($owner_result) > 0) {
                                    while ($row = mysqli_fetch_assoc($owner_result)) {
                                        echo "<option value='{$row['owner_id']}'>{$row['owner_id']} - {$row['fullname']}</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="homestay_phone">Số điện thoại</label>
                        <input type="tel" id="homestay_phone" name="homestay_phone" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <label for="homestay_email">Email liên hệ</label>
                        <input type="email" id="homestay_email" name="homestay_email" placeholder="Nhập email" required>
                    </div>
                    <div class="form-group">
                        <label for="img">Hình ảnh chính</label>
                        <input type="file" id="img" name="img" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="img1">Hình ảnh phụ 1</label>
                        <input type="file" id="img1" name="img1" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="img2">Hình ảnh phụ 2</label>
                        <input type="file" id="img2" name="img2" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="img3">Hình ảnh phụ 3</label>
                        <input type="file" id="img3" name="img3" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="form-section" style="display: flex; gap: 32px;">
                <div style="flex:1;">
                    <h3>Chi tiết & Mô tả</h3>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea id="description" name="description" rows="3" placeholder="Mô tả ngắn về homestay"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="policy">Tiện nghi</label>
                        <textarea id="policy" name="policy" rows="2" placeholder="Liệt kê tiện nghi"></textarea>
                    </div>
                </div>
                <div style="flex:1;">
                    <div class="form-group">
                        <label for="rating">Điểm đánh giá</label>
                        <input type="number" id="rating" name="rating" placeholder="VD: 4.5" required>
                    </div>
                    <div class="form-group">
                        <label for="reviews_count">Số lượt đánh giá</label>
                        <input type="number" id="reviews_count" name="reviews_count" placeholder="Nhập số lượt đánh giá" required>
                    </div>
                </div>
            </div>
            <div class="form-actions" style="text-align:right;">
                <button type="submit" name="submit_homestay" class="add-btn">Thêm Homestay</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
</div>


<!-------------------------------------------------- Giao diện cập nhật--------------------------------------------->
<div class="form-container" id="update-form" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($homestay) { ?>
    <?php include "../home/header_content.php"; ?>

    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn">
                <i class='bx bx-arrow-back'></i> Quay lại
            </a>
            <div class="action-buttons">
                <button class="detail-btn" onclick="showFormHomestay('detail-form', '<?php echo $homestay['homestay_id']; ?>')">
                    <i class='bx bx-detail'></i> Chi tiết
                </button>
                <button class="delete-btn" onclick="deleteHomestay('<?php echo $homestay['homestay_id']; ?>')">
                    <i class='bx bx-trash'></i> Xóa
                </button>
            </div>
        </div>

        <h2>Cập nhật thông tin Homestay</h2>

        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="homestay_id" value="<?php echo $homestay['homestay_id']; ?>">

            <div class="form-wrapper">
                <!-- Cột trái -->
                <div class="form-column">
                    <div class="form-section">
                        <h3>Thông tin cơ bản</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Mã Homestay</label>
                                <input type="text" value="<?php echo $homestay['homestay_id']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Tên Homestay</label>
                                <input type="text" name="homestay_name" value="<?php echo $homestay['homestay_name']; ?>" required>
                            </div>
                            <div class="form-group full">
                                <label>Địa chỉ</label>
                                <textarea name="address" rows="3" required><?php echo $homestay['address']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Loại phòng</label>
                                <input type="text" name="room_type" value="<?php echo $homestay['room_type']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select name="status">
                                    <option value="Đang bảo trì" <?php echo ($homestay['status']=='Đang bảo trì')?'selected':''; ?>>Đang bảo trì</option>
                                    <option value="Còn trống" <?php echo ($homestay['status']=='Còn trống')?'selected':''; ?>>Còn trống</option>
                                    <option value="Đã đặt" <?php echo ($homestay['status']=='Đã đặt')?'selected':''; ?>>Đã đặt</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nhận phòng</label>
                                <input type="text" name="checkin" value="<?php echo $homestay['checkin']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Trả phòng</label>
                                <input type="text" name="checkout" value="<?php echo $homestay['checkout']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Sức chứa</label>
                                <input type="number" name="guests" value="<?php echo $homestay['guests']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Giá thuê (VNĐ/đêm)</label>
                                <input type="number" name="price" value="<?php echo $homestay['price']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Liên hệ & Chủ Homestay</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Chủ Homestay</label>
                                <select name="owner_id">
                                    <option value="">Chưa có mã</option>
                                    <?php
                                        $owner_sql = "SELECT owner_id, fullname FROM db_owner";
                                        $owner_result = mysqli_query($conn, $owner_sql);
                                        if ($owner_result && mysqli_num_rows($owner_result) > 0) {
                                            while ($row = mysqli_fetch_assoc($owner_result)) {
                                                $selected = ($row['owner_id'] == $homestay['owner_id']) ? 'selected' : '';
                                                echo "<option value='{$row['owner_id']}' $selected>{$row['owner_id']} - {$row['fullname']}</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="tel" name="homestay_phone" value="<?php echo $homestay['homestay_phone']; ?>" required>
                            </div>
                            <div class="form-group full">
                                <label>Email liên hệ</label>
                                <input type="email" name="homestay_email" value="<?php echo $homestay['homestay_email']; ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="form-column">
                    <div class="form-section">
                        <h3>Hình ảnh & Mô tả</h3>
                        <div class="image-preview-group">
                            <?php for ($i = 0; $i < 4; $i++): 
                                $imgField = $i == 0 ? 'img' : 'img'.$i; 
                                $label = $i == 0 ? 'Hình chính' : "Hình phụ $i";
                            ?>
                            <div class="image-item">
                                <label><?php echo $label; ?> hiện tại:</label>
                                <img src="../../../FE/images/<?php echo $homestay[$imgField]; ?>" alt="Ảnh <?php echo $i; ?>">
                                <input type="file" name="<?php echo $imgField; ?>_new" accept="image/*">
                            </div>
                            <?php endfor; ?>
                        </div>
                        <div class="form-group full">
                            <label>Mô tả</label>
                            <textarea name="description" rows="4"><?php echo $homestay['description']; ?></textarea>
                        </div>
                        <div class="form-group full">
                            <label>Tiện nghi</label>
                            <textarea name="policy" rows="3"><?php echo $homestay['policy']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Điểm đánh giá</label>
                            <input type="number" name="rating" value="<?php echo $homestay['rating']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Lượt đánh giá</label>
                            <input type="number" name="reviews_count" value="<?php echo $homestay['reviews_count']; ?>" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit_homestay" class="edit-btn">Cập nhật</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>

    <?php } else { ?>
        <p>Không tìm thấy thông tin homestay để sửa.</p>
    <?php } ?>
</div>

<!-------------------------------------------------- Giao diện thông tin chi tiết --------------------------------------------->
<div class="form-container" id="detail-form" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($homestay) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormHomestay('edit-form', '<?php echo $homestay['homestay_id']; ?>')"><i class='bx bx-edit-alt'></i>Sửa thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteHomestay('<?php echo $homestay['homestay_id']; ?>')"><i class='bx bx-trash'></i>Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết Homestay</h2>

        <div class="detail-layout">
            
            <div class="detail-left">
                <div class="detail-section">
                    <h3>Hình ảnh Homestay</h3>
                    <div class="images-gallery">
                        <img src="../../../FE/images/<?php echo $homestay['img']; ?>" alt="Hình ảnh Homestay chính">
                        <img src="../../../FE/images/<?php echo $homestay['img1']; ?>" alt="Hình ảnh Homestay 1">
                        <img src="../../../FE/images/<?php echo $homestay['img2']; ?>" alt="Hình ảnh Homestay 2">
                        <img src="../../../FE/images/<?php echo $homestay['img3']; ?>" alt="Hình ảnh Homestay 3">
                    </div>
                </div>
            </div>

            <div class="detail-right">
                <div class="detail-section">
                    <h3>Thông tin cơ bản</h3>
                    <div class="info-group"><label>Mã Homestay:</label><p><?php echo $homestay['homestay_id']; ?></p></div>
                    <div class="info-group"><label>Tên Homestay:</label><p><?php echo $homestay['homestay_name']; ?></p></div>
                    <div class="info-group"><label>Địa chỉ:</label><p><?php echo $homestay['address']; ?></p></div>
                    <div class="info-group"><label>Loại phòng:</label><p><?php echo $homestay['room_type']; ?></p></div>
                    <div class="info-group">
                        <label>Trạng thái:</label>
                        <p>
                            <?php 
                                $text=''; $style='';
                                if($homestay['status'] ==='Đang bảo trì'){
                                    $text= 'Đang bảo trì'; $style= 'status-pending';
                                }else if($homestay['status'] === 'còn phòng'){
                                    $text= 'Còn phòng'; $style= 'status-actived';
                                }else if($homestay['status'] === 'Đã đặt'){
                                    $text= 'Đã đặt'; $style= 'status-completed';
                                }
                                echo "<span class='".$style."'>".$text."</span>";
                            ?>
                        </p>
                    </div>
                    <div class="info-group"><label>Thời gian nhận phòng:</label><p><?php echo $homestay['checkin']; ?></p></div>
                    <div class="info-group"><label>Thời gian trả phòng:</label><p><?php echo $homestay['checkout']; ?></p></div>
                    <div class="info-group"><label>Sức chứa:</label><p><?php echo $homestay['guests']; ?></p></div>
                </div>

                <div class="detail-section">
                    <h3>Mô tả & Tiện nghi</h3>
                    <div class="info-group"><label>Mô tả:</label><p><?php echo $homestay['description']; ?></p></div>
                    <div class="info-group"><label>Tiện nghi:</label><p><?php echo $homestay['policy']; ?></p></div>
                </div>

                <div class="detail-section">
                    <h3>Thông tin liên hệ</h3>
                    <div class="info-group"><label>Mã chủ homestay:</label><p><?php echo $homestay['owner_id']; ?></p></div>
                    <div class="info-group"><label>Số điện thoại:</label><p><?php echo $homestay['homestay_phone']; ?></p></div>
                    <div class="info-group"><label>Email liên hệ:</label><p><?php echo $homestay['homestay_email']; ?></p></div>
                </div>
            </div>

        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin homestay.</p>
    <?php } ?>
</div>