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
            <input type="text" placeholder="Tìm kiếm đánh giá...">
            <button class="search-btn"><i class='bx bx-search'></i></button>
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
                            <button class="detail-btn" title="Chi tiết"><i class='bx bx-detail'></i></button>
                            <button class="edit-btn" title="Sửa"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>