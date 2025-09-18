<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Quản lí đơn đặt phòng</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download PDF</span>
    </a>
</div>
<div class="management-container">
    <h2>Quản lý Đặt phòng</h2>
    <div class="toolbar">
        <div class="search-box">
            <input type="text" placeholder="Tìm kiếm mã đặt phòng...">
            <button class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã đơn đặt phòng</th>
                    <th>Mã khách hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Mã phòng</th>
                    <th>Ngày đặt phòng</th>
                    <th>Ngày nhận phòng</th>
                    <th>Ngày trả phòng</th>
                    <th>Số người</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chú thích của khách hàng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    $result = $conn->query("SELECT * FROM db_booking");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['madondatphong'] ?></td>
                        <td><?php echo $row['makhachhang'] ?></td>
                        <td><?php echo $row['tenkhachhang'] ?></td>
                        <td><?php echo $row['maphong'] ?></td>
                        <td><?php echo $row['ngaydatphong'] ?></td>
                        <td><?php echo $row['ngaynhanphong'] ?></td>
                        <td><?php echo $row['ngaytraphong'] ?></td>
                        <td><?php echo $row['songuoi'] ?></td>
                        <td><?php echo $row['tongtien'] ?></td>
                        <td><?php echo $row['trangthai'] ?></td>
                        <td class="truncate-text"><?php echo $row['chuthich'] ?></td>
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