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
    $result = $conn->query("SELECT * FROM db_review JOIN db_booking ON db_review.booking_id = db_booking.booking_id WHERE review_id = '$review_id'");
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
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Mã đánh giá</th>
                        <th>Mã đơn đặt phòng</th>
                        <th>Mã Homestay</th>
                        <th>Tên khách hàng</th>
                        <th>Nội dung đánh giá</th>
                        <th>Điểm đánh giá</th>
                        <th>Thời gian gửi</th>
                        <th>Nội dung phản hồi</th>
                        <th>Trạng thái</th>
                        <th>Thời gian cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['content']) ? $_GET['content'] : '') {
                        $search_query = trim($_GET['content']);
                        $search = "%$search_query%";

                        $sql = "SELECT * FROM db_review JOIN db_booking ON db_review.booking_id = db_booking.booking_id  WHERE review_id LIKE '$search' 
                        OR customer_id LIKE '$search' 
                        OR homestay_id LIKE '$search'
                        OR db_review.booking_id LIKE '$search'  
                        OR customer_name LIKE '$search'
                        OR content_review LIKE '$search'
                        OR content_feedback LIKE '$search'   
                        OR rating LIKE '$search' 
                        OR status_review LIKE '$search'
                        OR update_at LIKE '$search'  
                        LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                    }else{
                        $result = $conn->query("SELECT * FROM db_review  
                        JOIN db_booking ON db_review.booking_id = db_booking.booking_id 
                        LIMIT $limit OFFSET $offset");
                    }
                    if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><input type="checkbox" class="row-checkbox" value="<?php echo $row['review_id']; ?>">
                            <td><?php echo $row['review_id'] ?></td>
                            <td><?php echo $row['booking_id'] ?></td>
                            <td><?php echo $row['homestay_id'] ?></td>
                            <td><?php echo $row['customer_name'] ?></td>
                            <td class="truncate-text"><?php echo $row['content_review'] ?></td>
                            <td><?php echo $row['rating'] ?></td>
                            <td><?php echo $row['created_at'] ?></td>
                            <td class="truncate-text"><?php echo $row['content_feedback'] ?></td>
                            <td><?php echo $row['status_review'] ?></td>
                            <td><?php echo $row['update_at'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormReview('detail-form', '<?php echo $row['review_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Phản hồi" onclick="showFormReview('edit-form', '<?php echo $row['review_id']; ?>')"><i class='bx bx-conversation'></i></button>
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


<!-------------------------------------- Giao diện phản hồi ---------------------------------->
<div class="form-container" id="edit-form" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($review) { ?>
       <?php include "../home/header_content.php"; ?>
        <div class="management-container">
            <div class="toolbar">
                <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
                <div class="action-buttons">
                    <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $review['review_id']; ?>')"></i> Xóa đánh giá</button>
                </div>
            </div>
            <h2>Phản hồi đánh giá</h2>
            <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">

                <div class="form-section">
                    <h3>Thông tin bài đánh giá</h3>
                    <div class="info-group">
                        <label for="review_id">Mã đánh giá:</label>
                        <p><?php echo $review['review_id']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="booking_id">Mã đơn đặt phòng:</label>
                        <p><?php echo $review['booking_id']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="homestay_id">Mã homestay:</label>
                        <p><?php echo $review['homestay_id']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="customer_name">Tên khách hàng:</label>
                        <p><?php echo $review['customer_name']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="content_review">Nội dung đánh giá:</label>
                        <p><?php echo $review['content_review']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="rating">Điểm đánh giá:</label>
                        <p><?php echo $review['rating']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="created_at">Thời gian gửi:</label>
                        <p><?php echo $review['created_at']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="content_feedback">Nội dung phản hồi:</label>
                        <input type="text" id="content_feedback" name="content_feedback">
                    </div>
                    <div class="form-group">
                        <label for="status_review">Trạng thái:</label>
                        <select id="status_review" name="status_review">
                            <option value="Đã phản hồi" <?php echo ($review['status_review'] == 'Đã phản hồi') ? 'selected' : ''; ?>>Đã phản hồi</option>
                            <option value="Chưa phản hồi" <?php echo ($review['status_review'] == 'Chờ phản hồi') ? 'selected' : ''; ?>>Chưa phản hồi</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="submit_review" class="edit-btn">Cập nhật phản hồi</button>
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
                    <button class="edit-btn" title="Duyệt" onclick="showFormReview('edit-form', '<?php echo $review['review_id']; ?>')"><i class='bx bx-edit-alt'></i> Phản hồi đánh giá</button>
                    <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $review['review_id']; ?>')"></i> Xóa đánh giá</button>
                </div>
            </div>

            <h2>Chi tiết nội dung đánh giá</h2>

            <div class="detail-grid">
                <div class="detail-section">
                    <h3>Thông tin cơ bản</h3>
                    <div class="info-group">
                        <label for="review_id">Mã đánh giá:</label>
                        <p><?php echo $review['review_id']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="booking_id">Mã đơn đặt phòng:</label>
                        <p><?php echo $review['booking_id']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="homestay_id">Mã homestay:</label>
                        <p><?php echo $review['homestay_id']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="customer_name">Tên khách hàng:</label>
                        <p><?php echo $review['customer_name']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="content_review">Nội dung đánh giá:</label>
                        <p><?php echo $review['content_review']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="rating">Điểm đánh giá:</label>
                        <p><?php echo $review['rating']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="created_at">Thời gian gửi:</label>
                        <p><?php echo $review['created_at']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="content_feedback">Nội dung phản hồi:</label>
                        <p><?php echo $review['content_feedback']; ?></p>
                    </div>
                    <div class="info-group">
                        <label for="status_review">Trạng thái:</label>
                        <p><?php 
                            $text='';
                            $style='';
                            if($review['status_review'] ==='Đã phản hồi'){
                                $text=  'Đã duyệt';
                                $style= 'status-completed';
                            }else if($review['status_review'] === 'Chưa phản hồi'){
                                $text=  'Chờ duyệt';
                                $style= 'status-pending';
                            }
                            echo "<span class='" . $style . "'>" . $text . "</span>";?></p>
                    </div>
                    <div class="info-group">
                        <label for="update_at">Thời gian phản hồi:</label>
                        <p><?php echo $review['update_at']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin dánh giá.</p>
    <?php } ?>
</div>
