<?php
require_once "../../config/connect.php";

// Tổng số khách hàng
$sql_customers = "SELECT COUNT(*) AS total_customers FROM db_customer";
$result = $conn->query($sql_customers);
$total_customers = $result ? $result->fetch_assoc()['total_customers'] : 0;

// Tổng số homestay
$sql_homestay = "SELECT COUNT(*) AS total_homestay FROM db_homestay";
$result = $conn->query($sql_homestay);
$total_homestay = $result ? $result->fetch_assoc()['total_homestay'] : 0;

// Tổng số booking 
$sql_bookings = "SELECT COUNT(*) AS total_bookings FROM db_booking";
$result = $conn->query($sql_bookings);
$total_bookings = $result ? $result->fetch_assoc()['total_bookings'] : 0;

// Tổng doanh thu trong năm hiện tại
$current_year = date('Y');
$sql_revenue = "SELECT SUM(total_price) AS total_revenue FROM db_booking WHERE YEAR(created_at) = $current_year";
$result = $conn->query($sql_revenue);
$total_revenue = $result ? ($result->fetch_assoc()['total_revenue'] ?? 0) : 0;

// Doanh thu theo tháng trong năm hiện tại
$revenueData = array_fill(1, 12, 0);
$sql_revenue = "SELECT MONTH(created_at) as month, SUM(total_price) as total 
                FROM db_booking 
                WHERE YEAR(created_at) = $current_year
                GROUP BY MONTH(created_at)";
$res_revenue = $conn->query($sql_revenue);
if ($res_revenue) {
    while ($row = $res_revenue->fetch_assoc()) {
        $revenueData[(int)$row['month']] = (int)$row['total'];
    }
}

// Điểm đánh giá trung bình theo homestay
$roomLabels = [];
$roomRatings = [];
$sql_rating = "SELECT h.homestay_name, AVG(r.rating) as avg_rating 
            FROM db_review r
            JOIN db_booking b ON r.booking_id = b.booking_id
            JOIN db_homestay h ON b.homestay_id = h.homestay_id
            GROUP BY h.homestay_id";
$res_rating = $conn->query($sql_rating);
if ($res_rating) {
    while ($row = $res_rating->fetch_assoc()) {
        $roomLabels[] = $row['homestay_name'];
        $roomRatings[] = round($row['avg_rating'], 2);
    }
}

// Số lượt đặt phòng theo homestay
$homestayBookingLabels = [];
$homestayBookingCounts = [];
$sql_homestay_bookings = "SELECT h.homestay_name, COUNT(b.booking_id) as booking_count
                            FROM db_homestay h
                            LEFT JOIN db_booking b ON h.homestay_id = b.homestay_id
                            GROUP BY h.homestay_id";
$res_homestay_bookings = $conn->query($sql_homestay_bookings);
if ($res_homestay_bookings) {
    while ($row = $res_homestay_bookings->fetch_assoc()) {
        $homestayBookingLabels[] = $row['homestay_name'];
        $homestayBookingCounts[] = (int)$row['booking_count'];
    }
}

// Số lượt đặt phòng theo tháng trong năm hiện tại
$bookingMonthLabels = [];
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

// bảng thống kê
$homestayStats = [];
$topLabels = [];
$topRevenue = [];
$topBookings = [];
$topReviewCounts = [];
$topAvgRatings = [];

$sql_homestay_stats = "
    SELECT 
        h.homestay_id,
        h.homestay_name,
        COUNT(b.booking_id) AS total_bookings,
        COALESCE(SUM(b.total_price), 0) AS total_revenue,
        COUNT(r.review_id) AS review_count,
        ROUND(AVG(r.rating), 2) AS avg_rating
    FROM db_homestay h
    LEFT JOIN db_booking b ON h.homestay_id = b.homestay_id
    LEFT JOIN db_review r ON b.booking_id = r.booking_id
    GROUP BY h.homestay_id
    ORDER BY total_revenue DESC
    LIMIT 10
";
$res_homestay_stats = $conn->query($sql_homestay_stats);
if ($res_homestay_stats) {
    while ($row = $res_homestay_stats->fetch_assoc()) {
        $homestayStats[] = $row;
        $topLabels[] = $row['homestay_name'];
        $topRevenue[] = (int)$row['total_revenue'];
        $topBookings[] = (int)$row['total_bookings'];
        $topReviewCounts[] = (int)$row['review_count'];
        $topAvgRatings[] = $row['avg_rating'] !== null ? (float)$row['avg_rating'] : 0;
    }
}
?>
<?php include "../home/header_content.php";?>
<div class="management-container">
    <h2>Thống kê & Báo cáo</h2>
    <div class="card-container">
        <div class="stat-card">
            <div class="card-icon"><i class='bx bx-user-plus'></i></div>
            <div class="card-info">
                <span>Tổng số khách hàng</span>
                <h3><?php echo number_format($total_customers); ?></h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="card-icon"><i class='bx bx-home-alt-2'></i></div>
            <div class="card-info">
                <span>Tổng số homestay</span>
                <h3><?php echo number_format($total_homestay); ?></h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="card-icon"><i class='bx bx-calendar-check'></i></div>
            <div class="card-info">
                <span>Tổng số đơn đặt phòng</span>
                <h3><?php echo number_format($total_bookings); ?></h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="card-icon"><i class='bx bx-money'></i></div>
            <div class="card-info">
                <span>Doanh thu trong năm</span>
                <h3><?php echo number_format($total_revenue, 0, ',', '.'); ?> VND</h3>
            </div>
        </div>
    </div>
    
    <!-- Biểu đồ chia 2 hàng, mỗi hàng 2 biểu đồ -->
    <div class="charts-grid">
        <div class="chart-box">
            <h3>Doanh thu theo tháng</h3>
            <canvas id="revenueChart" height="180"></canvas>
        </div>
        <div class="chart-box">
            <h3>Điểm đánh giá trung bình theo homestay</h3>
            <canvas id="ratingChart" height="180"></canvas>
        </div>
        <div class="chart-box">
            <h3>Số đơn đặt phòng theo homestay</h3>
            <canvas id="homestayBookingChart" height="180"></canvas>
        </div>
        <div class="chart-box">
            <h3>Top homestay theo doanh thu</h3>
            <canvas id="topHomestayChart" height="180"></canvas>
        </div>
    </div>

    <!--Bảng thống kê chi tiết homestay phía dưới biểu đồ -->
    <div class="table-section">
        <h3 class="page-title">Bảng thống kê</h3>
        <div class="table-wrapper">
            <table class="homestay-table">
                <thead>
                    <tr>
                        <th>Mã homestay</th>
                        <th>Tên homestay</th>
                        <th>Số đơn đặt phòng</th>
                        <th>Doanh thu (VND)</th>
                        <th>Số lượt đánh giá</th>
                        <th>Điểm trung bình</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($homestayStats as $h): ?>
                        <tr>
                            <td data-label="Mã homestay"><?php echo htmlspecialchars($h['homestay_id']); ?></td>
                            <td data-label="Tên homestay"><?php echo htmlspecialchars($h['homestay_name']); ?></td>
                            <td data-label="Số đơn đặt phòng" class="center"><?php echo number_format((int)$h['total_bookings']); ?></td>
                            <td data-label="Doanh thu (VND)" class="right"><?php echo number_format((int)$h['total_revenue'], 0, ',', '.'); ?></td>
                            <td data-label="Số lượt đánh giá" class="center"><?php echo number_format((int)$h['review_count']); ?></td>
                            <td data-label="Điểm trung bình" class="center"><?php echo $h['avg_rating'] !== null ? number_format((float)$h['avg_rating'], 2) : '0.00'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const revenueData = <?= json_encode(array_values($revenueData)) ?>;

        const roomLabels = <?= json_encode($roomLabels) ?>;
        const roomRatings = <?= json_encode($roomRatings) ?>;

        const homestayBookingLabels = <?= json_encode($homestayBookingLabels) ?>;
        const homestayBookingCounts = <?= json_encode($homestayBookingCounts) ?>;

        const bookingMonthLabels = <?= json_encode($bookingMonthLabels) ?>;
        const bookingMonthCounts = <?= json_encode(array_values($bookingMonthCounts)) ?>;

        const topHomestayLabels = <?= json_encode($topLabels) ?>;
        const topHomestayRevenue = <?= json_encode($topRevenue) ?>;
        // Chart: Doanh thu theo tháng
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: bookingMonthLabels,
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: revenueData,
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

        // Chart: Điểm đánh giá trung bình theo homestay
        const ctxRating = document.getElementById('ratingChart').getContext('2d');
        new Chart(ctxRating, {
            type: 'bar',
            data: {
                labels: roomLabels,
                datasets: [{
                    label: 'Điểm trung bình',
                    data: roomRatings,
                    backgroundColor: '#28a745'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { 
                        beginAtZero: true,
                        max: 5
                    }
                }
            }
        });

        // Chart: Lượt đặt phòng theo homestay
        const ctxHomestayBooking = document.getElementById('homestayBookingChart').getContext('2d');
        new Chart(ctxHomestayBooking, {
            type: 'bar',
            data: {
                labels: homestayBookingLabels,
                datasets: [{
                    label: 'Lượt đặt phòng',
                    data: homestayBookingCounts,
                    backgroundColor: '#ffc107'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Chart: Top homestay theo doanh thu
        const ctxTop = document.getElementById('topHomestayChart').getContext('2d');
        new Chart(ctxTop, {
            type: 'bar',
            data: {
                labels: topHomestayLabels,
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: topHomestayRevenue,
                    backgroundColor: 'rgba(255,99,132,0.6)'
                }]
            },
            options: {
                indexAxis: 'y', // thanh ngang
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw.toLocaleString() + ' VND';
                            }
                        }
                    }
                }
            }
        });
    </script>
</div>
<?php $conn->close(); ?>