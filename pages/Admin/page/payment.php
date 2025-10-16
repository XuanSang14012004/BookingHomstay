<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Quản lí thanh toán</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download PDF</span>
    </a>
</div>
<div class="management-container">
    <h2>Quản lý Thanh toán</h2>
    <div class="toolbar">
        <button class="add-btn" add-page="add_payment"><i class='bx bx-plus'></i> Thêm hóa đơn mới</button>
        <div class="search-box">
            <input type="text" placeholder="Tìm kiếm giao dịch...">
            <button class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã thanh toán</th>
                    <th>Mã đơn đặt phòng</th>
                    <th>Phương thức thanh toán</th>
                    <th>Tổng tiền</th>
                    <th>Ngày thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    $result = $conn->query("SELECT * FROM db_thanhtoan");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['mathanhtoan'] ?></td>
                        <td><?php echo $row['madondatphong'] ?></td>
                        <td><?php echo $row['hinhthucthanhtoan'] ?></td>
                        <td><?php echo $row['sotien'] ?></td>
                        <td><?php echo $row['ngaythanhtoan'] ?></td>
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