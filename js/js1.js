document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    let chartType = 'day';
    let chartData = {
        day: {
            labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
            data: [5000000, 7000000, 6000000, 8000000, 7500000, 9000000, 8500000]
        },
        month: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8'],
            data: [40000000, 45000000, 42000000, 48000000, 50000000, 47000000, 52000000, 53000000]
        },
        year: {
            labels: ['2021', '2022', '2023', '2024', '2025'],
            data: [350000000, 400000000, 420000000, 480000000, 500000000]
        }
    };

    window.revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData[chartType].labels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: chartData[chartType].data,
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
            }
        }
    });

    window.updateChart = function(type) {
        chartType = type;
        window.revenueChart.data.labels = chartData[type].labels;
        window.revenueChart.data.datasets[0].data = chartData[type].data;
        window.revenueChart.update();
    }
});