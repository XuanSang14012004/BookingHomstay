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

$madanhgia = isset($_GET['id']) ? $_GET['id'] : null;

$reviews = null;
if (($is_edit_form || $is_detail_form) && $madanhgia) {
    $result = $conn->query("SELECT * FROM db_danhgia WHERE madanhgia = '$madanhgia'");
    if ($result && $result->num_rows > 0) {
        $reviews = mysqli_fetch_assoc($result);
    }
}
?>

<!--------------------------------- Giao diện ------------------------>
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
            <input type="text" id="search" name="timkiem" placeholder="Tìm kiếm đánh giá...">
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
                <tr>
                    <?php
                    $result = $conn->query("SELECT * FROM db_danhgia");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['madanhgia'] ?></td>
                        <td><?php echo $row['makhachhang'] ?></td>
                        <td><?php echo $row['maphong'] ?></td>
                        <td><?php echo $row['tieude'] ?></td>
                        <td class="truncate-text"><?php echo $row['noidung'] ?></td>
                        <td><?php echo $row['diemdanhgia'] ?></td>
                        <td><?php echo $row['trangthai'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" onclick="showFormReview('detail-form', '<?php echo $row['madanhgia']; ?>')"><i class='bx bx-detail'></i></button>
                            <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $row['madanhgia']; ?>')"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!--------------------------------- Tìm kiếm ------------------------>
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
                <tr>
                    <?php
                    if( isset($_GET['content']) ? $_GET['content'] :'' ){
                            $search_query = trim($_GET['content']);
                            $search = "%$search_query%";

                            $sql = "SELECT * FROM db_danhgia WHERE madanhgia LIKE '$search' OR makhachhang LIKE '$search' OR maphong LIKE '$search' OR tieude LIKE '$search' 
                            OR diemdanhgia LIKE '$search' OR trangthai LIKE '$search' "; 
                            $result = $conn->query($sql);} 
                            $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['madanhgia'] ?></td>
                        <td><?php echo $row['makhachhang'] ?></td>
                        <td><?php echo $row['maphong'] ?></td>
                        <td><?php echo $row['tieude'] ?></td>
                        <td class="truncate-text"><?php echo $row['noidung'] ?></td>
                        <td><?php echo $row['diemdanhgia'] ?></td>
                        <td><?php echo $row['trangthai'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" onclick="showFormReview('detail-form', '<?php echo $row['madanhgia']; ?>')"><i class='bx bx-detail'></i></button>
                            <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $row['madanhgia']; ?>')"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!------------------------------- Duyệt đánh giá ------------------------>
<div class="form-container" id="update" style="display:<?php echo $is_edit_form ? 'block' : 'none'; ?>;">
    <?php if ($reviews) { ?>
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
            <a href="home.php?page=reviews" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $account['madanhgia']; ?>')"></i> Xóa thông tin</button>
            </div>
        </div>
        <h2>Duyệt nội dung đánh giá</h2>
        <form action="../modules/update_function.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="madanhgia" value="<?php echo $reviews['madanhgia']; ?>">

            <div class="form-section">
                <h3>Thông tin cơ bản</h3>
                <?php 
                    $th_sql = "SELECT DISTINCT TRIM(trangthai) as trangthai FROM `db_danhgia`";
                    $th_result = mysqli_query($conn, $th_sql);
                ?>
                <div class="form-group">
                    <label for="madanhgia">Mã đánh giá:</label>
                    <p><?php echo $reviews['madanhgia']; ?></p>
                </div>
                <div class="form-group">
                    <label for="tenkhachhang">Mã khách hàng:</label>
                    <p><?php echo $reviews['makhachhang']; ?></p>
                </div>
                <div class="form-group">
                    <label for="maphong">Mã phòng:</label>
                    <p><?php echo $reviews['maphong']; ?></p>
                </div>
                <div class="form-group">
                    <label for="tieude">Tiêu đề đánh giá:</label>
                    <p><?php echo $reviews['tieude']; ?></p>
                </div>
                <div class="form-group">
                    <label for="noidung">Nội dung đánh giá:</label>
                    <p><?php echo $reviews['noidung']; ?></p>
                </div>
                <div class="form-group">
                    <label for="diemdanhgia">Điểm đánh giá:</label>
                    <p><?php echo $reviews['diemdanhgia']; ?></p>
                </div>
                <div class="form-group">
                    <label for="trangthai">Trạng thái:</label>
                    <select id="trangthai" name="trangthai">
                        <?php 
                        if ($th_result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($lh_result)) {?>
                                <option value="<?php echo $row['trangthai']; ?>">
                                    <?php echo $row['trangthai']; ?>
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
        </form>
    </div>
    <?php } else if ($is_edit_form) { ?>
        <p>Không tìm thấy thông tin đánh giá để duyệt.</p>
    <?php } ?>
</div>


<!----------------------------------- Chi tiết --------------------------------->
<div class="form-container" id="detail" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($reviews) { ?>
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
            <a href="home.php?page=homestay&id="$homestay class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            <div class="action-buttons">
                <button class="edit-btn" title="Sửa" onclick="showFormReview('edit-form', '<?php echo $reviews['madanhgia']; ?>')"><i class='bx bx-edit-alt'></i> Duyệt đánh giá</button>
                <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $reviews['madanhgia']; ?>')"></i> Xóa thông tin</button>
            </div>
        </div>
        
        <h2>Chi tiết nội dung đánh giá</h2>

        <div class="detail-grid">
            <div class="detail-section">
                <h3>Thông tin cơ bản</h3>
                <div class="form-group">
                    <label for="madanhgia">Mã đánh giá:</label>
                    <p><?php echo $reviews['madanhgia']; ?></p>
                </div>
                <div class="form-group">
                    <label for="tenkhachhang">Mã khách hàng:</label>
                    <p><?php echo $reviews['makhachhang']; ?></p>
                </div>
                <div class="form-group">
                    <label for="maphong">Mã phòng:</label>
                    <p><?php echo $reviews['maphong']; ?></p>
                </div>
                <div class="form-group">
                    <label for="tieude">Tiêu đề đánh giá:</label>
                    <p><?php echo $reviews['tieude']; ?></p>
                </div>
                <div class="form-group">
                    <label for="noidung">Nội dung đánh giá:</label>
                    <p><?php echo $reviews['noidung']; ?></p>
                </div>
                <div class="form-group">
                    <label for="diemdanhgia">Điểm đánh giá:</label>
                    <p><?php echo $reviews['diemdanhgia']; ?></p>
                </div>
                <div class="form-group">
                    <label for="trangthai">Trạng thái:</label>
                    <p><?php echo $reviews['trangthai']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php } else if ($is_detail_form) { ?>
        <p>Không tìm thấy thông tin dánh giá.</p>
    <?php } ?>
</div>