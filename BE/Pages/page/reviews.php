<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_edit_form = false;
$is_detail_form = false;


if ($action === 'edit_review') {
    $is_edit_form = true;
} else if ($action === 'detail_review') {
    $is_detail_form = true;
} else if ($action === 'search_review') {
    $is_view_form = true;
} else {
    $is_view_form = true; // Trang chính

}

$review_id = isset($_GET['id']) ? $_GET['id'] : null;

$review = null;
if (($is_edit_form || $is_detail_form) && $review_id) {
    $result = $conn->query("SELECT * FROM db_review WHERE review_id = '$review_id'");
    if ($result && $result->num_rows > 0) {
        $review = mysqli_fetch_assoc($result);
    }
}
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
if ($limit <= 0) $limit = 10;

$pagetable = isset($_GET['pagetable']) ? (int)$_GET['pagetable'] : 1;
if ($pagetable < 1) $pagetable = 1;
$offset = ($pagetable - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) as total FROM db_review");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>
<!-------------------------------------------- Giao diện chính ------------------------------------------->
<div class="form-container" id="review-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Quản lý Đánh giá</h2>
        <div class="toolbar">
            <div class="search-box">
                <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm đánh giá...">
                <button type="submit" class="search-btn" onclick="showFormReview('search-form')"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <div class="limit-form">
            <form method="get">
                <input type="hidden" name="page" value="reviews">
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
                        <th><input type="checkbox" id="select-all"></th><th>STT</th>
                        <th>Mã đánh giá</th>
                        <th>Mã khách hàng</th>
                        <th>Mã phòng</th>
                        <th>Tiêu đề đánh giá</th>
                        <th>Nội dung đánh giá</th>
                        <th>Điểm đánh giá</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['content']) ? $_GET['content'] : '') {
                        $search_query = trim($_GET['content']);
                        $search = "%$search_query%";

                        $sql = "SELECT * FROM db_review WHERE review_id LIKE '$search' 
                        OR customer_id LIKE '$search' 
                        OR room_id LIKE '$search' 
                        OR title LIKE '$search'
                        OR content LIKE '$search'   
                        OR rating LIKE '$search' 
                        OR review_status LIKE '$search' 
                        LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    }else{
                        $result = $conn->query("SELECT * FROM db_review LIMIT $limit OFFSET $offset");
                    }
                    if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['review_id']; ?>">
                            <td><?php echo $row['review_id'] ?></td>
                            <td><?php echo $row['customer_id'] ?></td>
                            <td><?php echo $row['room_id'] ?></td>
                            <td><?php echo $row['title'] ?></td>
                            <td class="truncate-text"><?php echo $row['content'] ?></td>
                            <td><?php echo $row['rating'] ?></td>
                            <td><?php echo $row['review_status'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormReview('detail-form', '<?php echo $row['review_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormReview('edit-form', '<?php echo $row['review_id']; ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $row['review_id']; ?>')"><i class='bx bx-trash'></i></button>
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
                <a href="home.php?page=reviews&pagetable&limit=<?= $limit ?>">&laquo;</a>
                <a href="home.php?page=reviews&pagetable=<?= $pagetable-1 ?>&limit=<?= $limit ?>">&lt;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $pagetable): ?>
                    <span><?= $i ?></span>
                <?php else: ?>
                    <a href="home.php?page=reviews&pagetable=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagetable < $total_pages): ?>
                <a href="home.php?page=reviews&pagetable=<?= $pagetable+1 ?>&limit=<?= $limit ?>"> &gt;</a>
                <a href="home.php?page=reviews&pagetable=<?= $total_pages ?>&limit=<?= $limit ?>"> &raquo;</a>
            <?php endif; ?>
        </div>  
    </div>
</div>


<!-------------------------------------- Giao diện cập nhật ---------------------------------->
<div class="form-container" id="edit-form" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($review) { ?>
       <?php include "../home/header_content.php"; ?>
        <div class="management-container">
            <div class="toolbar">
                <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
                <div class="action-buttons">
                    <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $review['review_id']; ?>')"></i> Xóa thông tin</button>
                </div>
            </div>
            <h2>Duyệt nội dung đánh giá</h2>
            <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">

                <div class="form-section">
                    <h3>Thông tin cơ bản</h3>
                    <div class="form-group">
                        <label for="review_id">Mã đánh giá:</label>
                        <p><?php echo $review['review_id']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="customer_id">Mã khách hàng:</label>
                        <p><?php echo $review['customer_id']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="room_id">Mã phòng:</label>
                        <p><?php echo $review['room_id']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="title">Tiêu đề đánh giá:</label>
                        <p><?php echo $review['title']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung đánh giá:</label>
                        <p><?php echo $review['content']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="rating">Điểm đánh giá:</label>
                        <p><?php echo $review['rating']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="review_status">Trạng thái:</label>
                        <select id="review_status" name="review_status">
                            <option value="Đã duyệt" <?php echo ($review['review_status'] == 'Đã duyệt') ? 'selected' : ''; ?>>Đã duyệt</option>
                            <option value="Chờ duyệt" <?php echo ($review['review_status'] == 'Chờ duyệt') ? 'selected' : ''; ?>>Chờ duyệt</option>
                            <option value="Đã ẩn" <?php echo ($review['review_status'] == 'Đã ẩn') ? 'selected' : ''; ?>>Đã ẩn</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit_review" class="edit-btn">Xác nhận</button>
                        <button type="reset" class="cancel-btn">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin đánh giá để duyệt.</p>
    <?php } ?>
</div>

<!---------------------------------- Giao diện thông tin chi tiết -------------------------------->
<div class="form-container" id="detail-form" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($review) { ?>
        <?php include "../home/header_content.php"; ?>
        <div class="management-container">
            <div class="toolbar">
                <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
                <div class="action-buttons">
                    <button class="edit-btn" title="Duyệt" onclick="showFormReview('reply-form', '<?php echo $review['review_id']; ?>')"><i class='bx bx-edit-alt'></i> Duyệt đánh giá</button>
                    <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $review['review_id']; ?>')"></i> Xóa thông tin</button>
                </div>
            </div>

            <h2>Chi tiết nội dung đánh giá</h2>

            <div class="detail-grid">
                <div class="detail-section">
                    <h3>Thông tin cơ bản</h3>
                    <div class="form-group">
                        <label for="review_id">Mã đánh giá:</label>
                        <p><?php echo $review['review_id']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="customer_id">Mã khách hàng:</label>
                        <p><?php echo $review['customer_id']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="room_id">Mã phòng:</label>
                        <p><?php echo $review['room_id']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="title">Tiêu đề đánh giá:</label>
                        <p><?php echo $review['title']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung đánh giá:</label>
                        <p><?php echo $review['content']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="rating">Điểm đánh giá:</label>
                        <p><?php echo $review['rating']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="review_status">Trạng thái:</label>
                        <p><?php 
                            $text='';
                            $style='';
                            if($review['review_status'] ==='Đã duyệt'){
                                $text=  'Đã duyệt';
                                $style= 'status-completed';
                            }else if($review['review_status'] === 'Chờ duyệt'){
                                $text=  'Chờ duyệt';
                                $style= 'status-pending';
                            }else if($review['review_status'] === 'Đã ẩn'){
                                $text=  'Đã ẩn';
                                $style= 'status-cancel';
                            }

                            echo "<span class='" . $style . "'>" . $text . "</span>";?></p>
                        echo $review['review_status']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin dánh giá.</p>
    <?php } ?>
</div>
