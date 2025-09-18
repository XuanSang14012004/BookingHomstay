<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Quản lí phòng</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download PDF</span>
    </a>
</div>
<div class="management-container">
    <h2>Quản lý Phòng</h2>
    <div class="toolbar">
        <button class="add-btn"><i class='bx bx-plus'></i> Thêm mới</button>
        <div class="search-box">
            <input type="text" placeholder="Tìm kiếm phòng...">
            <button class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã Phòng</th>
                    <th>Tên Phòng</th>
                    <th>Loại phòng</th>
                    <th>Mô tả chi tiết</th>
                    <th>Số người tối đa</th>
                    <th>Giá phòng(/Đêm)</th>
                    <th>Trạng thái</th>
                    <th>Hình ảnh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    $result = $conn->query("SELECT * FROM db_phong");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['maphong'] ?></td>
                        <td><?php echo $row['tenphong'] ?></td>
                        <td><?php echo $row['loaiphong'] ?></td>
                        <td class="truncate-text"><?php echo $row['mota'] ?></td>
                        <td><?php echo $row['succhua'] ?></td>
                        <td><?php echo $row['gia'] ?></td>
                        <td><?php echo $row['trangthai'] ?></td>
                        <td><?php echo $row['hinhanh'] ?></td>
                        <td class="actions">
                            <button class="edit-btn" title="Sửa"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>