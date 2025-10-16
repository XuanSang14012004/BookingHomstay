document.addEventListener('DOMContentLoaded', function() {
    const monthlyRevenueChartElement = document.getElementById('monthlyRevenueChart');
    if (monthlyRevenueChartElement) {
        const monthlyRevenueData = {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
            datasets: [{
                label: 'Doanh thu (triệu VNĐ)',
                data: [120, 150, 100, 180, 200, 160],
                backgroundColor: [
                    'rgba(52, 152, 219, 0.8)',
                    'rgba(241, 196, 15, 0.8)',
                    'rgba(46, 204, 113, 0.8)',
                    'rgba(230, 126, 34, 0.8)',
                    'rgba(155, 89, 182, 0.8)', 
                    'rgba(26, 188, 156, 0.8)' 
                ],
                borderColor: [
                    'rgba(52, 152, 219, 1)',
                    'rgba(241, 196, 15, 1)',
                    'rgba(46, 204, 113, 1)',
                    'rgba(230, 126, 34, 1)',
                    'rgba(155, 89, 182, 1)',
                    'rgba(26, 188, 156, 1)'
                ],
                borderWidth: 1
            }]
        };

        const monthlyRevenueConfig = {
            type: 'bar',
            data: monthlyRevenueData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        };

        new Chart(monthlyRevenueChartElement, monthlyRevenueConfig);
    }
});