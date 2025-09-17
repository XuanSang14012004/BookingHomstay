<div class="head-title">
    <div class="left">
        <h1>Dashboard</h1>
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
                    <th>Mã Đặt phòng</th>
                    <th>Khách hàng</th>
                    <th>Homestay</th>
                    <th>Phòng</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    $result = $conn->query("SELECT * FROM db_khachhang");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row['makhachhang'] ?></td>
                    <td><?php echo $row['tenkhachhang'] ?></td>
                    <td><?php echo $row['ngaysinh'] ?></td>
                    <td><?php echo $row['gioitinh'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['sodienthoai'] ?></td>
                    <td><?php echo $row['diachi'] ?></td>
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