<?php
    require_once "../../config/connect.php";
    $sql_customers = "SELECT COUNT(*) AS total_customers FROM db_customer";
    $result = $conn->query($sql_customers);
    $row = $result->fetch_assoc();
    $total_customers = $row['total_customers'];

    $sql_homestay = "SELECT COUNT(*) AS total_homestay FROM db_homestay";
    $result = $conn->query($sql_homestay);
    $row = $result->fetch_assoc();
    $total_homestay = $row['total_homestay'];

    $sql_bookings = "SELECT COUNT(*) AS total_bookings FROM db_booking";
    $result = $conn->query($sql_bookings);
    $row = $result->fetch_assoc();
    $total_bookings = $row['total_bookings'];

    $sql_revenue = "SELECT SUM(total_price) AS total_revenue FROM db_booking";
    $result = $conn->query($sql_revenue);
    $row = $result->fetch_assoc();
    $total_revenue = $row['total_revenue'] ?? 0;

    $revenueData = array_fill(1, 12, 0);

    $sql_revenue = "SELECT MONTH(created_at) as month, SUM(total_price) as total 
                    FROM db_booking 
                    GROUP BY MONTH(created_at)";
    $res_revenue = $conn->query($sql_revenue);

    if ($res_revenue) {
        while ($row = $res_revenue->fetch_assoc()) {
            $revenueData[(int)$row['month']] = (int)$row['total'];
        }
    }
    $roomLabels = [];
    $roomRatings = [];

    $sql_rating = "SELECT booking_id, AVG(rating) as avg_rating 
                FROM db_review 
                GROUP BY booking_id";
    $res_rating = $conn->query($sql_rating);

    if ($res_rating) {
        while ($row = $res_rating->fetch_assoc()) {
            $roomLabels[] = "Booking " . $row['booking_id'];
            $roomRatings[] = round($row['avg_rating'], 2);
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
                <span>Đặt phòng trong tháng</span>
                <h3><?php echo number_format($total_bookings); ?></h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="card-icon"><i class='bx bx-money'></i></div>
            <div class="card-info">
                <span>Doanh thu trong năm</span>
                <h3><?php echo number_format($total_revenue, 0, ',', '.'); ?>VND</h3>
            </div>
        </div>
    </div>
    
    <!-- Khối chứa 2 biểu đồ -->
    <div class="charts-container">
        <div class="chart-box">
            <h3>Doanh thu theo tháng</h3>
            <canvas id="revenueChart"></canvas>
        </div>
        <div class="chart-box">
            <h3>Điểm đánh giá trung bình theo homestay</h3>
            <canvas id="ratingChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const revenueData = <?= json_encode(array_values($revenueData)) ?>;
        const roomLabels = <?= json_encode($roomLabels) ?>;
        const roomRatings = <?= json_encode($roomRatings) ?>;

        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6',
                        'Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'],
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
    </script>