<?php
include 'config.php';

// Lấy số liệu nhanh
// 1. Đơn đặt phòng hôm nay
$today = date('Y-m-d');
$resBookingToday = $conn->query("SELECT COUNT(*) as total FROM booking WHERE bookingDate='$today'");
$bookingToday = $resBookingToday->fetch_assoc()['total'] ?? 0;

// 2. Homestay đang hoạt động
$resRooms = $conn->query("SELECT COUNT(*) as total FROM rooms WHERE statusRooms='Hoạt động'");
$roomsActive = $resRooms->fetch_assoc()['total'] ?? 0;

// 3. Doanh thu tháng này
$month = date('m');
$year = date('Y');
$resRevenue = $conn->query("SELECT SUM(money) as total FROM payments WHERE MONTH(datesPayments)='$month' AND YEAR(datesPayments)='$year'");
$revenueMonth = $resRevenue->fetch_assoc()['total'] ?? 0;

// 4. Khách hàng mới
$resUsers = $conn->query("SELECT COUNT(*) as total FROM users");
if (!$resUsers) {
    die("Query Error: " . $conn->error);
}
$newUsers = $resUsers->fetch_assoc()['total'] ?? 0;


// Dữ liệu biểu đồ doanh thu (tháng hiện tại)
$labels = [];
$data = [];
for($d=1; $d<=date('t'); $d++){
    $date = "$year-$month-$d";
    $labels[] = $d;
    $res = $conn->query("SELECT SUM(money) as total FROM payments WHERE datesPayments='$date'");
    $data[] = $res->fetch_assoc()['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4">Dashboard</h2>
    
    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Đơn đặt phòng hôm nay</h5>
                    <p class="card-text fs-3"><?= $bookingToday ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Homestay đang hoạt động</h5>
                    <p class="card-text fs-3"><?= $roomsActive ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Doanh thu tháng này</h5>
                    <p class="card-text fs-3"><?= number_format($revenueMonth,0,',','.') ?>₫</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Khách hàng mới</h5>
                    <p class="card-text fs-3"><?= $newUsers ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="card mb-4">
        <div class="card-header">
            Biểu đồ doanh thu tháng <?= date('m/Y') ?>
        </div>
        <div class="card-body">
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: <?= json_encode($data) ?>,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
</body>
</html>
