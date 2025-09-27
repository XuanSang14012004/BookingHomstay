<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_search_form = false;
$is_edit_form = false;
$is_detail_form = false;


if ($action === 'edit_review') {
    $is_edit_form = true;
} else if ($action === 'detail_review') {
    $is_detail_form = true;
} else if ($action === 'search_review') {
    $is_search_form = true;
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
?>

<div class="form-container" id="review-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Quản lí đánh giá</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>
    <div class="management-container">
        <h2>Quản lý Đánh giá</h2>
        <div class="toolbar">
            <div class="search-box">
                <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm đánh giá...">
                <button type="submit" class="search-btn" onclick="showFormReview('search-form')"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>STT</th>
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
                    $result = $conn->query("SELECT * FROM db_review");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['review_id'] ?></td>
                            <td><?php echo $row['customer_id'] ?></td>
                            <td><?php echo $row['room_id'] ?></td>
                            <td><?php echo $row['title'] ?></td>
                            <td class="truncate-text"><?php echo $row['content'] ?></td>
                            <td><?php echo $row['rating'] ?></td>
                            <td><?php echo $row['review_status'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormReview('detail-form', '<?php echo $row['review_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $row['review_id']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="form-container" id="search-form" style="display:<?php echo $is_search_form ? 'block' : 'none'; ?>;">
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Admin Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Quản lí đánh giá</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>
    <div class="management-container">
        <h2>Quản lý Đánh giá</h2>
        <div class="toolbar">
            <div class="search-box">
                <input type="text" id="search" name="timkiem" placeholder="Tìm kiếm đánh gía...">
                <button type="submit" class="search-btn" onclick="showFormReview('search-form')"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>STT</th>
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

                        $sql = "SELECT * FROM db_review WHERE review_id LIKE '$search' OR customer_id LIKE '$search' OR room_id LIKE '$search' OR title LIKE '$search' 
                                OR rating LIKE '$search' OR review_status LIKE '$search' ";
                        $result = $conn->query($sql);
                    }
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['review_id'] ?></td>
                            <td><?php echo $row['customer_id'] ?></td>
                            <td><?php echo $row['room_id'] ?></td>
                            <td><?php echo $row['title'] ?></td>
                            <td class="truncate-text"><?php echo $row['content'] ?></td>
                            <td><?php echo $row['rating'] ?></td>
                            <td><?php echo $row['review_status'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormReview('detail-form', '<?php echo $row['review_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $row['review_id']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="form-container" id="edit-form" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($review) { ?>
        <div class="head-title">
            <div class="left">
                <h1>Management</h1>
                <ul class="breadcrumb">
                    <li>
                        <a>Admin Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a>Quản lí đánh giá</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active">Duyệt nội dung đánh giá</a>
                    </li>
                </ul>
            </div>
        </div>
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
                    <?php
                    $status_sql = "SELECT DISTINCT TRIM(review_status) as review_status FROM `db_review`";
                    $status_result = mysqli_query($conn, $status_sql);
                    ?>
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
                            <?php
                            if ($status_result->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($status_result)) { ?>
                                    <option value="<?php echo $row['review_status']; ?>">
                                        <?php echo $row['review_status']; ?>
                                    </option>
                            <?php }
                            } else {
                                echo "<option value=''>Không có dữ liệu</option>";
                            }
                            ?>
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


<div class="form-container" id="detail-form" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($review) { ?>
        <div class="head-title">
            <div class="left">
                <h1>Management</h1>
                <ul class="breadcrumb">
                    <li>
                        <a>Admin Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a>Quản lí homestay</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active">Thông tin chi tiết đánh giá</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="management-container">
            <div class="toolbar">
                <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
                <div class="action-buttons">
                    <button class="edit-btn" title="Sửa" onclick="showFormReview('edit-form', '<?php echo $review['review_id']; ?>')"><i class='bx bx-edit-alt'></i> Duyệt đánh giá</button>
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
                        <p><?php echo $review['review_status']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin dánh giá.</p>
    <?php } ?>
</div>
