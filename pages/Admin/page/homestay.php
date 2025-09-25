<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Quản lí homestay</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download PDF</span>
    </a>
</div>
<div class="management-container">
    <h2>Quản lý Homestay</h2>
    <div class="toolbar">
        <button class="add-btn" add-page="add_homestay"><i class='bx bx-plus'></i> Thêm Homestay mới</button>
        <div class="search-box">
            <input type="text" placeholder="Tìm kiếm homestay...">
            <button class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </div>
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
                    $result = $conn->query("SELECT * FROM db_homestay");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['mahomestay'] ?></td>
                        <td><?php echo $row['tenhomestay'] ?></td>
                        <td><?php echo $row['loaihinh'] ?></td>
                        <td><?php echo $row['trangthaihoatdong'] ?></td>
                        <td class="truncate-text"><?php echo $row['mota'] ?></td>
                        <td><?php echo $row['sophong'] ?></td>
                        <td class="truncate-text"><?php echo $row['tiennghi'] ?></td>
                        <td class="truncate-text"><?php echo $row['diachi'] ?></td>
                        <td><?php echo $row['sodienthoai'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td class="truncate-text"><?php echo $row['giathue'] ?></td>
                        <td class="truncate-text"><?php echo $row['chinhsach'] ?></td>
                        <td><?php echo $row['hinhanh'] ?></td>  
                        <td><?php echo $row['diemdanhgia'] ?></td>
                        <td><?php echo $row['soluotdanhgia'] ?></td>
                        <td class="actions">
                            <button class="detail-btn" title="Chi tiết" read-page="detail_homestay" homestay-id="<?php echo $row['mahomestay'] ?>"><i class='bx bx-detail'></i></button>
                            <button class="edit-btn" title="Sửa" edit-page="update_homestay" homestay-id="<?php echo $row['mahomestay'] ?>"><i class='bx bx-edit-alt'></i></button>
                            <button class="delete-btn" title="Xóa"><i class='bx bx-trash'></i></button>
                        </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>