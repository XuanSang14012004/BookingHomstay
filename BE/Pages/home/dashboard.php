<?php
include '../../Config/connect.php';

// Tháng và năm hiện tại
$current_month = date('m');
$current_year  = date('Y');

// Tổng số khách hàng đăng ký trong tháng hiện tại
$sql_customers = "SELECT COUNT(*) AS total_customers 
                  FROM db_account 
                  WHERE `role`='user' AND MONTH(created_at) = $current_month AND YEAR(created_at) = $current_year";
$result = $conn->query($sql_customers);
$row = $result ? $result->fetch_assoc() : null;
$total_customers_today = (int)($row['total_customers'] ?? 0);

// Tổng số đơn đặt phòng được tạo trong tháng hiện tại (tất cả trạng thái)
$sql_bookings = "SELECT COUNT(*) AS total_bookings 
                 FROM db_booking 
                 WHERE MONTH(created_at) = $current_month AND YEAR(created_at) = $current_year";
$result = $conn->query($sql_bookings);
$row = $result ? $result->fetch_assoc() : null;
$total_bookings_today = (int)($row['total_bookings'] ?? 0);

// Tổng số đơn đã xác nhận trong tháng hiện tại
$sql_confirmed = "SELECT COUNT(*) AS total_confirmed 
                  FROM db_booking 
                  WHERE MONTH(created_at) = $current_month AND YEAR(created_at) = $current_year AND status = 'Đã xác nhận'";
$result = $conn->query($sql_confirmed);
$row = $result ? $result->fetch_assoc() : null;
$total_confirmed_today = (int)($row['total_confirmed'] ?? 0);

// Tổng doanh thu trong tháng hiện tại (chỉ tính các đơn đã xác nhận)
$sql_revenue = "SELECT COALESCE(SUM(total_price), 0) AS total_revenue 
                FROM db_booking 
                WHERE MONTH(created_at) = $current_month AND YEAR(created_at) = $current_year AND status = 'Đã xác nhận'";
$result = $conn->query($sql_revenue);
$row = $result ? $result->fetch_assoc() : null;
$total_revenue_today = $row['total_revenue'] ?? 0;

// Số đánh giá đang chờ phản hồi trong tháng hiện tại
$sql_pending_reviews = "SELECT COUNT(*) AS pending_reviews 
                        FROM db_review 
                        WHERE status_review = 'Chưa phản hồi' 
                          AND MONTH(created_at) = $current_month 
                          AND YEAR(created_at) = $current_year";
$result = $conn->query($sql_pending_reviews);
$row = $result ? $result->fetch_assoc() : null;
$pending_reviews_count = (int)($row['pending_reviews'] ?? 0);

// Biểu đồ cột: số đơn đặt phòng theo tháng
$current_year = date('Y');
$bookingMonthCounts = array_fill(1, 12, 0);
$sql_booking_month = "SELECT MONTH(created_at) as month, COUNT(*) as count
                      FROM db_booking
                      WHERE YEAR(created_at) = $current_year
                      GROUP BY MONTH(created_at)";
$res_booking_month = $conn->query($sql_booking_month);
if ($res_booking_month) {
    while ($row = $res_booking_month->fetch_assoc()) {
        $bookingMonthCounts[(int)$row['month']] = (int)$row['count'];
    }
}
$bookingMonthLabels = ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6','Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'];

// Tỷ lệ trạng thái đơn đặt phòng trong tháng hiện tại
$statusCounts = [
    'Đã xác nhận' => 0,
    'Chờ xác nhận' => 0,
    'Đã hủy' => 0
];
$sql_status = "SELECT status, COUNT(*) as count 
               FROM db_booking 
               WHERE MONTH(created_at) = $current_month AND YEAR(created_at) = $current_year
               GROUP BY status";
$res_status = $conn->query($sql_status);
if ($res_status) {
    while ($row = $res_status->fetch_assoc()) {
        $status = $row['status'];
        if (isset($statusCounts[$status])) {
            $statusCounts[$status] = (int)$row['count'];
        }
    }
}
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
</div>
<div class="management-container">
    <ul class="box-info">
        <li>
            <i class='bx bxs-calendar-check'></i>
            <span class="text">
                <h3><?php echo number_format($total_bookings_today); ?></h3>
                <p>Đơn đặt phòng trong tháng (<?php echo $current_month . '/' . $current_year; ?>)</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3><?php echo number_format($total_customers_today); ?></h3>
                <p>Khách đăng ký trong tháng (<?php echo $current_month . '/' . $current_year; ?>)</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-dollar-circle'></i>
            <span class="text">
                <h3><?php echo number_format($total_revenue_today, 0, ',', '.'); ?></h3>
                <p>Doanh thu trong tháng (VND)</p>
            </span>
        </li>

        <li>
            <i class='bx bxs-check-circle'></i>
            <span class="text">
                <h3><?php echo number_format($total_confirmed_today); ?></h3>
                <p>Đơn đã xác nhận trong tháng (<?php echo $current_month . '/' . $current_year; ?>)</p>
            </span>
        </li>

        <li>
            <i class='bx bxs-message-dots'></i>
            <span class="text">
                <h3><?php echo number_format($pending_reviews_count); ?></h3>
                <p>Đánh giá chờ phản hồi trong tháng (<?php echo $current_month . '/' . $current_year; ?>)</p>
            </span>
        </li>
    </ul>

    <div class="charts-dashboard">
        <div class="chart-card">
            <h3>Số đơn đặt phòng theo tháng (<?php echo $current_year; ?>)</h3>
            <canvas id="bookingMonthChart" height="180"></canvas>
        </div>
        <div class="chart-card" style="display: flex; flex-direction: column; align-items: center;">
            <h3>Trạng thái đơn đặt phòng</h3>
            <canvas id="statusPieChart"></canvas>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Danh sách đặt phòng</h3>
                <a href="home.php?page=booking"><i class='bx bx-search'></i></a>
                <i class='bx bx-filter'></i>
            </div>
            <div style="overflow-x:auto;">
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
                    <?php
                     $sql_list_bookings = "SELECT * FROM db_booking WHERE MONTH(created_at) = $current_month AND YEAR(created_at) = $current_year ORDER BY created_at DESC";
                     $result = $conn->query($sql_list_bookings);
                    while ($row = mysqli_fetch_assoc($result)) { 
                    ?>
                    <tr>
                        <td><?php echo $row["customer_id"];?></td>
                        <td><p><?php echo $row['customer_name'] ?></p></td>
                        <td><?php echo $booking_time=date("d/m/Y ",strtotime($row['created_at']));?></td>
                        <td>
                            <?php 
                                $text='';
                                $style='';
                                if($row['status'] ==='Đã xác nhận'){
                                    $text=  'Đã xác nhận';
                                    $style= 'status-actived';
                                }else if($row['status'] === 'Chờ xác nhận'){
                                    $text=  'Chờ xác nhận';
                                    $style= 'status-pending';
                                }else if($row['status'] === 'Đã hủy'){
                                    $text=  'Đã hủy';
                                    $style= 'status-cancel';
                                }echo "<span class='" . $style . "'>" . $text . "</span>";?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
        <div class="todo">
            <div class="head">
                <h3>Danh sách đánh giá</h3>
                <a href="home.php?page=reviews"><i class='bx bx-search'></i></a>
                <i class='bx bx-filter'></i>
            </div>
            <ul class="todo-list">
                <?php 
                     $sql_list_reviews = "SELECT * FROM db_review WHERE MONTH(created_at) = $current_month AND YEAR(created_at) = $current_year ORDER BY created_at DESC";
                     $result = $conn->query($sql_list_reviews);
                     while ($row = mysqli_fetch_assoc($result)) { ?>
                <li class="<?php 
                        if ($row['status_review'] === 'Đã phản hồi') {
                            echo 'completed';
                        } else if ($row['status_review'] === 'Chưa phản hồi') {
                            echo 'not-completed';
                        } 
                    ?>">
                 <p class="truncate-text"><?php if($row['review']=== NULL || $row['review']=== "" ){echo "Khách hàng không ghi nội dung";}else{ echo $row['review'];} ?></p> 
                 <div class="todo-item">
                    <i class='bx bx-dots-vertical-rounded'></i>
                    <div class="action-menu">
                        <ul>
                            <button class="detail-btn" title="Chi tiết" onclick="showFormReview('detail-form', '<?php echo $row['review_id']; ?>')"><i class='bx bx-detail'></i> Xem chi tiết</button>
                            <button class="delete-btn" title="Xóa" onclick="deleteReview('<?php echo $row['review_id']; ?>')"><i class='bx bx-trash'></i>Xóa đánh giá</button>
                        </ul>
                    </div>
                </div>  
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ cột: số đơn đặt phòng theo tháng
    const bookingMonthLabels = <?= json_encode($bookingMonthLabels) ?>;
    const bookingMonthCounts = <?= json_encode(array_values($bookingMonthCounts)) ?>;
    const ctxBookingMonth = document.getElementById('bookingMonthChart').getContext('2d');
    new Chart(ctxBookingMonth, {
        type: 'bar',
        data: {
            labels: bookingMonthLabels,
            datasets: [{
                label: 'Số đơn đặt phòng',
                data: bookingMonthCounts,
                backgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Biểu đồ tròn: tỷ lệ trạng thái đơn đặt phòng
    const statusLabels = <?= json_encode(array_keys($statusCounts)) ?>;
    const statusData = <?= json_encode(array_values($statusCounts)) ?>;
    const ctxStatusPie = document.getElementById('statusPieChart').getContext('2d');
    new Chart(ctxStatusPie, {
        type: 'pie',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: ['#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const dotIcons = document.querySelectorAll(".todo-item .bx-dots-vertical-rounded");

    dotIcons.forEach(icon => {
        icon.addEventListener("click", function(e) {
            e.stopPropagation();

            // Hide any open action menus first
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