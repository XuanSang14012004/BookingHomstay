<div class="detail-container">
    <h2>Chi Tiết Đánh Giá</h2>
    <div class="detail-form">
        <div class="detail-section">
            <div class="info-group">
                <label>Người đánh giá:</label>
                <p>Trần Thị B</p>
            </div>
            <div class="info-group">
                <label>Homestay được đánh giá:</label>
                <p>Nhà Của Gió</p>
            </div>
            <div class="info-group">
                <label>Số sao:</label>
                <p class="rating-stars">★★★★★</p>
            </div>
            <div class="info-group">
                <label>Nội dung:</label>
                <p class="review-content">Homestay rất đẹp, sạch sẽ và chủ nhà thân thiện. Tôi rất thích phong cảnh ở
                    đây, thật sự rất yên bình và thoải mái.</p>
            </div>
        </div>
    </div>
</div>

<!-------------------------------------------------- Giao diện hiển thị kết quả tìm kiếm --------------------------------------------->
<div class="form-container" id="search-homestay" style="display:<?php echo $is_search_form ? 'block' : 'none'; ?>;">
    <?php include "../home/header_content.php"?>
    <div class="management-container">
        <h2>Quản lý Homestay</h2>
        <div class="toolbar">
            <button class="add-btn" onclick="showFormHomestay('add-form')"><i class='bx bx-plus'></i> Thêm Homestay mới</button>
            <div class="search-box">
                <input type="text" class="search" id="research" name="timkiem" placeholder="Tìm kiếm homestay...">
                <button type="submit" class="search-btn" onclick="showFormHomestay('research-form')"><i class='bx bx-search'></i></button>
            </div>
        </div>
        <big>Kết quả tìm kiếm theo" ... "</big>
        <br>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã Homestay</th>
                        <th>Tên Homestay</th>
                        <th>Loại hình</th>
                        <th>Trạng thái hoạt động</th>
                        <th>Mô tả chi tiêt</th>
                        <th>Số phòng</th>
                        <th>Tiện nghi</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Email liên hệ</th>
                        <th>Giá thuê</th>
                        <th>Chính sách</th>
                        <th>Hình ảnh</th>
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

                            $sql = "SELECT * FROM db_homestay WHERE homestay_id LIKE '$search' OR homestay_name LIKE '$search' OR homestay_type LIKE '$search' OR homestay_status LIKE '$search' 
                            OR room_number LIKE '$search' OR email LIKE '$search' OR phone_owner LIKE '$search' OR home_price LIKE '$search' OR homestay_address LIKE '$search' OR home_rating LIKE '$search' "; 
                            $result = $conn->query($sql);
                            $i = 1;

                        } else if( isset($_GET['recontent']) ? $_GET['recontent'] :'' ){
                            $search_query = trim($_GET['recontent']);
                            $search = "%".$search_query."%";

                            $sql = "SELECT * FROM db_homestay WHERE homestay_id LIKE '$search' OR homestay_name LIKE '$search' OR homestay_type LIKE '$search' OR homestay_status LIKE '$search' 
                            OR room_number LIKE '$search' OR email LIKE '$search' OR phone_owner LIKE '$search' OR home_price LIKE '$search' OR homestay_address LIKE '$search' OR home_rating LIKE '$search' ";
                            $result = $conn->query($sql);
                            $i = 1;
                        }
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['homestay_id'] ?></td>
                            <td><?php echo $row['homestay_name'] ?></td>
                            <td><?php echo $row['homestay_type'] ?></td>
                            <td><?php echo $row['homestay_status'] ?></td>
                            <td class="truncate-text"><?php echo $row['describe'] ?></td>
                            <td><?php echo $row['room_number'] ?></td>
                            <td class="truncate-text"><?php echo $row['amenities'] ?></td>
                            <td class="truncate-text"><?php echo $row['homestay_address'] ?></td>
                            <td><?php echo $row['phone_owner'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td class="truncate-text"><?php echo $row['home_price'] ?></td>
                            <td class="truncate-text"><?php echo $row['policy'] ?></td>
                            <td><?php echo "<img src='../../Images/" .$row['image']. "' alt='Hình ảnh' style='width:100px;height:auto;'>"; ?></td>  
                            <td><?php echo $row['home_rating'] ?></td>
                            <td><?php echo $row['rating_number'] ?></td>
                            <td class="actions">
                                <button class="detail-btn" title="Chi tiết" onclick="showFormHomestay('detail-form', '<?php echo $row['homestay_id']; ?>')"><i class='bx bx-detail'></i></button>
                                <button class="edit-btn" title="Sửa" onclick="showFormHomestay('edit-form', '<?php echo $row['homestay_id']; ?>')"><i class='bx bx-edit-alt'></i></button>
                                <button class="delete-btn" title="Xóa" onclick="deleteHomestay('<?php echo $row['homestay_id']; ?>')"><i class='bx bx-trash'></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-------------------------------------------------- Giao diện tìm kiếm ---------------------------->
<div class="form-container" id="search-form" style="display:<?php echo $is_search_form ? 'block' : 'none'; ?>;">
    <div class="head-title">
        <div class="left">
            <h1>Management</h1>
            <ul class="breadcrumb">
                <li><a href="#">Admin Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a href="home.php?page=feedback">Phản hồi khách hàng</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Kết quả tìm kiếm</a></li>
            </ul>
        </div>
    </div>
    <div class="management-container">
        <h2>Kết quả tìm kiếm cho: </h2>
        <div class="toolbar">
            <input type="text" class="search" id="search" name="timkiem" placeholder="Tìm kiếm phản hồi...">
            <button type="submit" class="search-btn" onclick="showFormFeed('research-form')"><i class='bx bx-search'></i></button>
        </div>
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
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if( isset($_GET['content']) ? $_GET['content'] :'' ){
                            $search_query = trim($_GET['content']);
                            $search = "%".$search_query."%";

                            $sql = "SELECT * FROM db_feedback WHERE feedback_id LIKE '$search' OR customer_name LIKE '$search' OR feedback_status LIKE '$search' "; 
                            $result = $conn->query($sql);
                            $i = 1;
                    }else if( isset($_GET['recontent']) ? $_GET['recontent'] :'' ){
                            $search_query = trim($_GET['recontent']);
                            $search = "%".$search_query."%";

                            $sql = "SELECT * FROM db_feedback WHERE feedback_id LIKE '$search' OR customer_name LIKE '$search' OR feedback_status LIKE '$search' "; 
                            $result = $conn->query($sql);
                            $i = 1;
                    }       

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row['feedback_id']; ?></td>
                                <td><?php echo $row['customer_name']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['content']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['feedback_status']; ?></td>
                                <td class="actions">
                                    <button class="detail-btn" title="Chi tiết" onclick="showFormFeed('detail-form', '<?php echo $row['feedback_id']; ?>')"><i class='bx bx-detail'></i></button>
                                    <button class="edit-btn" title="Phản hồi" onclick="showFormFeed('reply-form', '<?php echo $row['feedback_id']; ?>')"><i class='bx bx-conversation'></i></button>
                                    <button class="delete-btn" title="Xóa" onclick="deleteFeed('<?php echo $row['feedback_id']; ?>')"><i class='bx bx-trash'></i></button>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='7'>Không tìm thấy kết quả nào.</td></tr>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>