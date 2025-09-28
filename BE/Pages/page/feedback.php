<?php
require_once "../../config/connect.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

$is_view_form = false;
$is_reply_form = false;
$is_detail_form = false;

if ($action === 'reply_feedback') {
    $is_reply_form = true;
} else if ($action === 'detail_feedback') {
    $is_detail_form = true;
} else if ($action === 'search_feedback') {
    $is_view_form = true;
} else {
    $is_view_form = true;
}

$feedback_id = isset($_GET['id']) ? $_GET['id'] : null;
$feedback = null;
if (($is_reply_form || $is_detail_form) && $feedback_id) {
    $result = $conn->query("SELECT * FROM db_feedback WHERE feedback_id = '$feedback_id'");
    if ($result && $result->num_rows > 0) {
        $feedback = mysqli_fetch_assoc($result);
    }
    
}
?>

<!-------------------------------------------------- Giao diện chính ---------------------------->
<div class="form-container" id="feedback-form" style="display:<?php echo $is_view_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"; ?>
    <div class="management-container">
        <h2>Phản hồi Khách hàng</h2>
        <div class="toolbar">
            <div class="search-box">
                <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm phản hồi...">
                <button type="submit" class="search-btn" onclick="showFormFeedback('search-form')"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <h3><?php if( isset($_GET['content']) ? $_GET['content'] :'' ){
            echo "Kết quả tìm kiếm theo: {$_GET['content']}";
             } ?>
        </h3>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã Phản hồi</th>
                        <th>Tên Khách hàng</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th>Trả lời</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if( isset($_GET['content']) ? $_GET['content'] :'' ){
                            $search_query = trim($_GET['content']);
                            $search = "%".$search_query."%";

                            $sql = "SELECT * FROM db_feedback WHERE feedback_id LIKE '$search' 
                            OR customer_name LIKE '$search' 
                            OR title LIKE '$search'
                            OR content LIKE '$search'
                            OR date LIKE '$search'
                            OR feedback_status LIKE '$search' "; 
                            $result = $conn->query($sql);
                            $i = 1;
                    }else{
                        $result = $conn->query("SELECT * FROM db_feedback ");
                        $i = 1;
                    }
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['feedback_id']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td class="truncate-text"><?php echo $row['content']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['feedback_status']; ?></td>
                            <td class="truncate-text"><?php echo $row['reply']; ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormFeedback('detail-form', '<?php echo $row['feedback_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Phản hồi" onclick="showFormFeedback('reply-form', '<?php echo $row['feedback_id']; ?>')"><i class='bx bx-conversation'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteFeedback('<?php echo $row['feedback_id']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-------------------------------------------------- Giao diện phản hồi khách hàng ---------------------------->
<div class="form-container" id="reply-form" style="display:<?php echo $is_reply_form ? 'block' : 'none'; ?>;">
    <?php if ($feedback) { ?>
        <?php include "../home/header_content.php"; ?>
        <div class="management-container">
            <div class="toolbar">
                <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
            </div>
            <h2>Trả lời phản hồi: <?php echo $feedback['title']; ?></h2>
            <form action="../modules/update_function.php" method="POST">
                <input type="hidden" name="feedback_id" value="<?php echo $feedback['feedback_id']; ?>">
                
                <div class="form-section">
                    <h3>Thông tin phản hồi</h3>
                    <div class="form-group">
                        <label>Từ khách hàng:</label>
                        <p><?php echo $feedback['customer_name']; ?> (ID: <?php echo $feedback['customer_id']; ?>)</p>
                    </div>
                     <div class="form-group">
                        <label>Ngày gửi:</label>
                        <p><?php echo $feedback['date']; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nội dung:</label>
                        <p style="border: 1px solid #eee; padding: 10px; border-radius: 5px;"><?php echo nl2br($feedback['content']); ?></p>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Nội dung trả lời</h3>
                    <div class="form-group">
                        <label for="reply">Nội dung trả lời của bạn:</label>
                        <textarea id="reply" name="reply" rows="5" required><?php echo $feedback['reply']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="feedback_status">Cập nhật trạng thái:</label>
                        <select id="feedback_status" name="feedback_status">
                            <option value="Chưa trả lời" <?php echo ($feedback['feedback_status'] == 'Chưa trả lời') ? 'selected' : ''; ?>>Chưa trả lời</option>
                            <option value="Đã trả lời" <?php echo ($feedback['feedback_status'] == 'Đã trả lời') ? 'selected' : ''; ?>>Đã trả lời</option>
                            <option value="Đã đóng" <?php echo ($feedback['feedback_status'] == 'Đã đóng') ? 'selected' : ''; ?>>Đã đóng</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit_feedback" class="add-btn">Gửi trả lời</button>
                    <button type="reset" class="cancel-btn">Hủy</button>
                </div>
            </form>
        </div>
    <?php } else { echo "<p>Không tìm thấy thông tin phản hồi.</p>"; } ?>
</div>

<!-------------------------------------------------- Giao diện thông tin chi tiết ---------------------------->
<div class="form-container" id="detail-form" style="display:<?php echo $is_detail_form ? 'block' : 'none'; ?>;">
    <?php if ($feedback) { ?>
        <?php include "../home/header_content.php"; ?>
        <div class="management-container">
            <div class="toolbar">
                <a href="#" onclick="window.history.back();" class="back-btn"><i class='bx bx-arrow-back'></i> Quay lại</a>
                <div class="action-buttons">
                    <button class="edit-btn" title="Phản hồi" onclick="showFormFeedback('reply-form', '<?php echo $feedback['feedback_id']; ?>')"><i class='bx bx-conversation'></i> Phản hồi khách hàng</button>
                    <button class="delete-btn" title="Xóa" onclick="deleteFeedback('<?php echo $row['feedback_id']; ?>')"><i class='bx bx-trash'></i> Xóa thông tin</button>
                </div>
            </div>
            
            <h2>Chi tiết phản hồi #<?php echo $feedback['feedback_id']; ?></h2>

            <div class="detail-grid">
                <div class="detail-section">
                    <h3>Thông tin chung</h3>
                    <div class="info-group">
                        <label>Tiêu đề:</label>
                        <p><?php echo $feedback['title']; ?></p>
                    </div>
                     <div class="info-group">
                        <label>Tên Khách hàng:</label>
                        <p><?php echo $feedback['customer_name']; ?></p>
                    </div>
                    <div class="info-group">
                        <label>Mã Khách hàng:</label>
                        <p><?php echo $feedback['customer_id']; ?></p>
                    </div>
                     <div class="info-group">
                        <label>Ngày gửi:</label>
                        <p><?php echo $feedback['date']; ?></p>
                    </div>
                    <div class="info-group">
                        <label>Trạng thái:</label>
                        <p><?php echo $feedback['feedback_status']; ?></p>
                    </div>
                </div>
                <div class="detail-section">
                    <h3>Nội dung</h3>
                    <div class="info-group">
                        <label>Nội dung khách hàng gửi:</label>
                        <p><?php echo nl2br($feedback['content']); ?></p>
                    </div>
                    <div class="info-group">
                        <label>Nội dung đã trả lời:</label>
                        <p><?php echo $feedback['reply'] ? nl2br($feedback['reply']) : '<i>Chưa có phản hồi.</i>'; ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { echo "<p>Không tìm thấy thông tin phản hồi.</p>"; } ?>
</div>
