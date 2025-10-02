<?php
include '../../Config/connect.php';

// Tổng số khách hàng đăng ký trong ngày hôm nay
$sql_customers = "SELECT COUNT(*) AS total_customers FROM db_account WHERE DATE(created_at) = CURDATE()";
$result = $conn->query($sql_customers);
$row = $result->fetch_assoc();
$total_customers_today = $row['total_customers'] ?? 0;

// Tổng số homestay tạo mới trong ngày hôm nay
$sql_homestay = "SELECT COUNT(*) AS total_homestay FROM db_homestay WHERE DATE(created_at) = CURDATE()";
$result = $conn->query($sql_homestay);
$row = $result->fetch_assoc();
$total_homestay_today = $row['total_homestay'] ?? 0;

// Tổng số đơn đặt phòng trong ngày hôm nay
$sql_bookings = "SELECT COUNT(*) AS total_bookings FROM db_booking WHERE DATE(date_booking) = CURDATE()";
$result = $conn->query($sql_bookings);
$row = $result->fetch_assoc();
$total_bookings_today = $row['total_bookings'] ?? 0;

// Tổng doanh thu trong ngày hôm nay
$sql_revenue = "SELECT SUM(booking_price) AS total_revenue FROM db_booking WHERE DATE(date_booking) = CURDATE()";
$result = $conn->query($sql_revenue);
$row = $result->fetch_assoc();
$total_revenue_today = $row['total_revenue'] ?? 0;
?>

<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Admin Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Trang chủ</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download PDF</span>
    </a>
</div>

<ul class="box-info">
    <li>
        <i class='bx bxs-calendar-check'></i>
        <span class="text">
            <h3><?php echo number_format($total_bookings_today); ?></h3>
            <p>Đơn đặt phòng (<?php echo date("d/m/Y");?>)</p>
        </span>
    </li>
    <li>
        <i class='bx bxs-group'></i>
        <span class="text">
            <h3><?php echo number_format($total_customers_today); ?></h3>
            <p>Số lượng khách(<?php echo date("d/m/Y");?>)</p>
        </span>
    </li>
    <li>
        <i class='bx bxs-dollar-circle'></i>
        <span class="text">
            <h3><?php echo number_format($total_revenue_today, 0, ',', '.'); ?> VNĐ</h3>
            <p>Doanh thu(<?php echo date("d/m/Y");?>)</p>
        </span>
    </li>
</ul>


<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Danh sách đặt phòng</h3>
            <i class='bx bx-search'></i>
            <i class='bx bx-filter'></i>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Mã khách hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                     $result = $conn->query("SELECT * FROM db_booking ");
                    while ($row = mysqli_fetch_assoc($result)) { 
                    ?>
                      
                    <td><?php echo $row["customer_id"];?></td>
                    <td>

                        <p><?php echo $row['customer_name'] ?></p>
                    </td>
                    <td><?php echo $booking_time=date("d/m/Y ",strtotime($row['date_booking']));?></td>
                    <td>
                        <?php 
                            $text='';
                            $style='';
                            if($row['booking_status'] ==='Đã xác nhận'){
                                $text=  'Đã xác nhận';
                                $style= 'status-actived';
                            }else if($row['booking_status'] === 'Chờ thanh toán'){
                                $text=  'Chờ thanh toán';
                                $style= 'status-pending';
                            }else if($row['booking_status'] === 'Đã hoàn tất'){
                                $text=  'Đã thanh toán';
                                $style= 'status-completed';
                            }else if($row['booking_status'] === 'Đã hủy'){
                                $text=  'Đã hủy';
                                $style= 'status-cancel';
                            }echo "<span class='" . $style . "'>" . $text . "</span>";?>
                        </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="todo">
        <div class="head">
            <h3>Danh sách góp ý của khách hàng</h3>
            <i class='bx bx-plus'></i>
            <i class='bx bx-filter'></i>
        </div>
        <ul class="todo-list">
            <?php $result = $conn->query("SELECT * FROM db_feedback ");
                 while ($row = mysqli_fetch_assoc($result)) { ?>
            <li class="<?php 
                    if ($row['feedback_status'] === 'Đã phản hồi') {
                        echo 'completed';
                    } else if ($row['feedback_status'] === 'Chưa phản hồi') {
                        echo 'not-completed';
                    } 
                ?>">
                 <p class="truncate-text"><?php echo $row['title']; ?></p> 
                 <div class="todo-item"><i class='bx bx-dots-vertical-rounded'></i>
                    <div class="action-menu">
                        <ul>
                            <button class="detail-btn" title="Chi tiết" onclick="showFormFeedback('detail-form', '<?php echo $row['feedback_id']; ?>')"><i class='bx bx-detail'></i> Xem chi tiết</button>
                            <button class="delete-btn" title="Xóa" onclick="deleteFeedback('<?php echo $row['feedback_id']; ?>')"><i class='bx bx-trash'></i>Xóa góp ý</button>
                        </ul>
                    </div>
                </div>  
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const dotIcons = document.querySelectorAll(".todo-item .bx-dots-vertical-rounded");

    dotIcons.forEach(icon => {
        icon.addEventListener("click", function(e) {
            e.stopPropagation();

            document.querySelectorAll(".action-menu").forEach(menu => {
                menu.style.display = "none";
            });

            const menu = this.nextElementSibling;
            if (menu && menu.classList.contains("action-menu")) {
                menu.style.display = (menu.style.display === "block") ? "none" : "block";
            }
        });
    });

    document.addEventListener("click", function() {
        document.querySelectorAll(".action-menu").forEach(menu => {
            menu.style.display = "none";
        });
    });
});
</script>