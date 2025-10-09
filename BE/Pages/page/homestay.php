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
    $is_view_form = true; // Trang chính

}

$homestay_id = isset($_GET['id']) ? $_GET['id'] : null;

$homestay = null;
if (($is_edit_form || $is_detail_form) && $homestay_id) {
    $result = $conn->query("SELECT * FROM db_homestay WHERE homestay_id = '$homestay_id'");
    if ($result && $result->num_rows > 0) {
        $homestay = mysqli_fetch_assoc($result);
    }
}

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) as total FROM db_homestay");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>
<!-------------------------------------------------- Giao diện chính --------------------------------------------->
<div class="form-container" id="homestay-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
   <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý Homestay</h2>
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
                        <th>Email liên hệ</th>
                        <th>Số điện thoại</th>
                        <th>Điểm đánh giá trung bình(/5)</th>
                        <th>Số lượt đánh giá đã nhận</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                         if( isset($_GET['content']) ? $_GET['content'] :'' ){
                            $search_query = trim($_GET['content']);
                            $search = "%".$search_query."%";

                            $sql = "SELECT * FROM db_homestay WHERE homestay_id LIKE '$search' 
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
                                OR checkin LIKE '$search'
                                OR checkout LIKE '$search'
                                OR rating LIKE '$search' 
                                LIMIT $limit OFFSET $offset"; 
                            $result = $conn->query($sql);
                        }else {
                            $result = $conn->query("SELECT * FROM db_homestay LIMIT $limit OFFSET $offset"); 
                        }
                        if ($result && mysqli_num_rows(result: $result) > 0) {  
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['homestay_id']; ?>"></td> 
                            <td><?php echo $row['homestay_id'] ?></td>
                            <td><?php echo $row['homestay_name'] ?></td>
                            <td><?php echo $row['address'] ?></td>
                            <td><?php echo "<img src='../../../FE/images/" .$row['img']. "' alt='Hình ảnh' style='width:100px;height:auto;'>"; ?></td> 
                            <td><?php echo $row['status'] ?></td>
                            <td><?php echo $row['room_type'] ?></td>
                            <td class="truncate-text"><?php echo $row['policy'] ?></td>
                            <td class="truncate-text"><?php echo $row['description'] ?></td>
                            <td class="truncate-text"><?php echo $row['guests'] ?></td>
                            <td><?php echo $row['checkin'] ?></td>
                            <td><?php echo $row['checkout'] ?></td>
                            <td><?php echo $row['price'] ?></td>
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
            <?php if ($pagetable > 1): ?>
                <a href="home.php?page=homestay&pagetable&limit=<?= $limit ?>">&laquo;</a>
                <a href="home.php?page=homestay&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=homestay&pagetable=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=homestay&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit ?>"> &gt;</a>
                <a href="home.php?page=homestay&pagetable=<?= $total_pages ?>&limit=<?= $limit ?>"> &raquo;</a>
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
                <div class="form-section">
                    <h3>Thông tin cơ bản</h3>
                    <div class="form-group">
                        <label for="homestay_name">Tên Homestay:</label>
                        <input type="text" id="homestay_name" name="homestay_name" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Trạng thái:</label>
                        <select id="status" name="status">
                            <option value="còn phòng"> Còn phòng</option>
                            <option value="Đã đặt"> Đã đặt</option>
                            <option value="Đang bảo trì"> Đang bảo trì</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room_type">Loại phòng:</label>
                        <input type="text" id="room_type" name="room_type" required>
                    </div>
                    <div class="form-group">
                        <label for="checkin">Thời gian nhận phòng:</label>
                        <input type="text" id="checkin" name="checkin" required>
                    </div>
                    <div class="form-group">
                        <label for="checkout">Thời gian trả phòng:</label>
                        <input type="text" id="checkout" name="checkout" required>
                    </div>
                     <div class="form-group">
                        <label for="guests">Sức chứa:</label>
                        <input type="number" id="guests" name="guests" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Giá thuê trung bình (VNĐ/đêm):</label>
                        <input type="number" id="price" name="price" required>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Thông tin liên hệ & Địa chỉ</h3>
                    <div class="form-group">
                        <label for="homestay_phone">Số điện thoại:</label>
                        <input type="tel" id="homestay_phone" name="homestay_phone" required>
                    </div>
                    <div class="form-group">
                        <label for="homestay_email">Email liên hệ:</label>
                        <input type="email" id="homestay_email" name="homestay_email" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <textarea id="address" name="address" rows="3" required></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Chi tiết & Mô tả</h3>
                    <div class="form-group">
                        <label for="description">Mô tả:</label>
                        <textarea id="description" name="description" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="policy">Tiện nghi:</label>
                        <textarea id="policy" name="policy" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="img">Hình ảnh chính:</label>
                        <input type="file" id="img" name="img" multiple accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="img1">Hình ảnh phụ 1:</label>
                        <input type="file" id="img1" name="img1" multiple accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="img2">Hình ảnh phụ 2:</label>
                        <input type="file" id="img2" name="img2" multiple accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="img3">Hình ảnh phụ 3:</label>
                        <input type="file" id="img3" name="img3" multiple accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="rating">Điểm đánh giá trung bình:</label>
                        <input type="number" id="rating" name="rating" required>
                    </div>
                    <div class="form-group">
                        <label for="reviews_count">Số lượt đánh giá đã nhận:</label>
                        <input type="number" id="reviews_count" name="reviews_count" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name ="submit_homestay" class="add-btn">Thêm Homestay</button>
                    <button type="reset"  class="cancel-btn">Hủy</button>
                </div>
            </form>
    </div>
</div>


<!-------------------------------------------------- Giao diện cập nhật--------------------------------------------->
<div class="form-container"id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($homestay) { ?>
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <div class="toolbar">
            <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="detail-btn" title="Chi tiết" onclick="showFormHomestay('detail-form', '<?php echo $homestay['homestay_id']; ?>')"><i class='bx bx-detail'></i> Xem thông tin</button>
                <button class="delete-btn" title="Xóa" onclick="deleteHomestay('<?php echo $homestay['homestay_id']; ?>')"><i class='bx bx-trash'></i> Xóa thông tin</button>
            </div>
        </div>
        <h2>Cập nhật thông tin Homestay</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="homestay_id" value="<?php echo $homestay['homestay_id']; ?>">

            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="homestay_id">Mã Homestay:</label>
                    <input type="text" name="homestay_id" value="<?php echo $homestay['homestay_id']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="homestay_name">Tên Homestay:</label>
                    <input type="text" id="homestay_name" name="homestay_name" value="<?php echo $homestay['homestay_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="room_type">Loại phòng:</label>
                    <input type="text" id="room_type" name="room_type" value="<?php echo $homestay['room_type']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status">Trạng thái:</label>
                    <select id="status" name="status">
                        <option value="Đang bảo trì" <?php echo ($homestay['status'] == 'Đang bảo trì') ? 'selected' : ''; ?>>Đang bảo trì</option>
                        <option value="Còn trống" <?php echo ($homestay['status'] == 'Còn trống') ? 'selected' : ''; ?>>Còn trống</option>
                        <option value="Đã đặt"<?php echo ($homestay['status'] == 'Đã đặt') ? 'selected' : ''; ?>>Đã đặt</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="checkin">Thời gian nhận phòng:</label>
                    <input type="text" id="checkin" name="checkin" value="<?php echo $homestay['checkin']; ?>"  required>
                </div>
                <div class="form-group">
                    <label for="checkout">Thời gian trả phòng:</label>
                    <input type="text" id="checkout" name="checkout" value="<?php echo $homestay['checkout']; ?>"  required>
                </div>
                <div class="form-group">
                    <label for="guests">Sức chứa:</label>
                    <input type="number" id="guests" name="guests" value="<?php echo $homestay['guests']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Giá thuê:</label>
                    <input type="number" id="price" name="price" value="<?php echo $homestay['price']; ?>" min="100" required>
                </div>   
            </div>

            <div class="form-section">
                <h3>Thông tin liên hệ & Địa chỉ</h3>
                <div class="form-group">
                    <label for="homestay_phone">Số điện thoại:</label>
                    <input type="tel" id="homestay_phone" name="homestay_phone" value="<?php echo $homestay['homestay_phone']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="homestay_email">Email liên hệ:</label>
                    <input type="email" id="homestay_email" name="homestay_email" value="<?php echo $homestay['homestay_email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <textarea id="address" name="address" rows="3" required><?php echo $homestay['address']; ?></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>Chi tiết & Mô tả</h3>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <textarea id="description" name="description" rows="5"><?php echo $homestay['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="policy">Tiện nghi:</label>
                    <textarea id="policy" name="policy" rows="3"><?php echo $homestay['policy']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="img">Hình ảnh hiện tại:</label>
                    <img src="../../../FE/images/<?php echo $homestay['img']; ?>" alt="Hình ảnh homestay" style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                    <label for="image_new">Chọn ảnh mới để thay thế :</label>
                    <input type="file" id="image_new" name="image_new" multiple accept="image/*">
                </div>
                <div class="form-group">
                    <label for="img1">Hình ảnh hiện tại:</label>
                    <img src="../../../FE/images/<?php echo $homestay['img1']; ?>" alt="Hình ảnh homestay" style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                    <label for="image1_new">Chọn ảnh mới để thay thế :</label>
                    <input type="file" id="image1_new" name="image1_new" multiple accept="image/*">
                </div>
                <div class="form-group">
                    <label for="img2">Hình ảnh hiện tại:</label>
                    <img src="../../../FE/images/<?php echo $homestay['img2']; ?>" alt="Hình ảnh homestay" style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                    <label for="image2_new">Chọn ảnh mới để thay thế :</label>
                    <input type="file" id="image2_new" name="image2_new" multiple accept="image/*">
                </div>
                <div class="form-group">
                    <label for="img3">Hình ảnh hiện tại:</label>
                    <img src="../../../FE/images/<?php echo $homestay['img3']; ?>" alt="Hình ảnh homestay" style="width: 150px; height: auto; display: block; margin-bottom: 10px;">
                    <label for="image3_new">Chọn ảnh mới để thay thế :</label>
                    <input type="file" id="image3_new" name="image3_new" multiple accept="image/*">
                </div>
                <div class="form-group">
                    <label for="rating">Điểm đánh giá trung bình:</label>
                    <input type="number" id="rating" name="rating" value="<?php echo $homestay['rating']; ?>" min="1" required>
                </div>
                <div class="form-group">
                    <label for="reviews_count">Số lượt đánh giá đã nhận:</label>
                    <input type="number" id="reviews_count" name="reviews_count" value="<?php echo $homestay['reviews_count']; ?>" min="1" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit_homestay" class="edit-btn">Cập Nhật Homestay</button>
                <button type="reset" class="cancel-btn">Hủy</button>
            </div>
        </form>
    </div>
        <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin homestay để sửa.</p>
    <?php } ?>
</div>

<!-------------------------------------------------- Giao diện thông tin chi tiết --------------------------------------------->
<div class="form-container" id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
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

        <div class="detail-grid">
            <div class="detail-section">
                <h3>Thông tin cơ bản</h3>
                <div class="info-group">
                    <label>Mã Homestay:</label>
                    <p><?php echo $homestay['homestay_id']; ?></p>
                </div>
                <div class="info-group">
                    <label>Tên Homestay:</label>
                    <p><?php echo $homestay['homestay_name']; ?></p>
                </div>
                <div class="info-group">
                    <label>Loại phòng:</label>
                    <p><?php echo $homestay['room_type']; ?></p>
                </div>
                <div class="info-group">
                    <label>Trạng thái:</label>
                    <p><?php 
                            $text='';
                            $style='';
                            if($homestay['status'] ==='Đang bảo trì'){
                                $text=  'Đang bảo trì';
                                $style= 'status-pending';
                            }else if($homestay['status'] === 'còn phòng'){
                                $text=  'Còn phòng';
                                $style= 'status-actived';
                            }else if($homestay['status'] === 'Đã đặt'){
                                $text=  'Đã đặt';
                                $style= 'status-completed';
                            }
                            echo "<span class='" . $style . "'>" . $text . "</span>";?>
                        </p>
                </div>
                <div class="info-group">
                    <label>Thời gian nhận phòng:</label>
                    <p><?php echo $homestay['checkin']; ?></p>
                </div>
                <div class="info-group">
                    <label>Thời gian trả phòng:</label>
                    <p><?php echo $homestay['checkout']; ?></p>
                </div>
                <div class="info-group">
                    <label>Sức chứa:</label>
                    <p><?php echo $homestay['guests']; ?></p>
                </div>
            </div>

            <div class="detail-section">
                <h3>Mô tả & Tiện nghi</h3>
                <div class="info-group">
                    <label>Mô tả:</label>
                    <p><?php echo $homestay['description']; ?></p>
                </div>
                <div class="info-group">
                    <label>Tiện nghi:</label>
                    <p><?php echo $homestay['policy']; ?></p>
                </div>
            </div>

            <div class="detail-section">
                <h3>Địa chỉ & Liên hệ</h3>
                <div class="info-group">
                    <label>Địa chỉ:</label>
                    <p><?php echo $homestay['address']; ?></p>
                </div>
                <div class="info-group">
                    <label>Số điện thoại:</label>
                    <p><?php echo $homestay['homestay_phone']; ?></p>
                </div>
                <div class="info-group">
                    <label>Email liên hệ:</label>
                    <p><?php echo $homestay['homestay_email']; ?></p>
                </div>
            </div>

            <div class="detail-section">
                <h3>Hình ảnh Homestay</h3>
                <div class="images-gallery">
                    <img src="../../../FE/images/<?php echo $homestay['img1']; ?>" alt="Hình ảnh Homestay 1">
                    <img src="../../../FE/images/<?php echo $homestay['img2']; ?>" alt="Hình ảnh Homestay 2">
                    <img src="../../../FE/images/<?php echo $homestay['img3']; ?>" alt="Hình ảnh Homestay 3">
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin homestay.</p>
    <?php } ?>
</div>