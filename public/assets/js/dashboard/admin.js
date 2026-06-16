document.querySelectorAll('.stats-tab').forEach(button => {
    button.addEventListener('click', function () {
        document.querySelectorAll('.stats-tab').forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.remove('active');
            btn.classList.add('btn-outline-primary');
        });

        this.classList.remove('btn-outline-primary');
        this.classList.add('btn-primary');
        this.classList.add('active');

        document.getElementById('daily-section').style.display = 'none';
        document.getElementById('monthly-section').style.display = 'none';
        document.getElementById('yearly-section').style.display = 'none';

        document.getElementById(
            this.dataset.target + '-section'
        ).style.display = 'block';
    });
});

// Daily, Month, Yearly Views 
const dailyViews = window.dashboardData.dailyViews;
const monthlyViews = window.dashboardData.monthlyViews;
const yearlyViews = window.dashboardData.yearlyViews;

let chart;

function renderChart(data, title) {
    const labels = data.map(item => item.label);
    const values = data.map(item => item.total);

    document.getElementById('chart-title').innerText = title;

    if (chart) {
        chart.destroy();
    }

    chart = new Chart(
        document.getElementById('viewChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Views',
                    data: values,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true
            }
        }
    );
}

renderChart(
    dailyViews,
    'View 30 Hari Terakhir'
);

document.querySelectorAll('.stats-tab').forEach(button => {
    button.addEventListener('click', function () {
        const target = this.dataset.target;

        if (target === 'daily') {
            renderChart(
                dailyViews,
                'View 30 Hari Terakhir'
            );
        }

        if (target === 'monthly') {
            renderChart(
                monthlyViews,
                'View 12 Bulan Terakhir'
            );
        }

        if (target === 'yearly') {
            renderChart(
                yearlyViews,
                'View Per Tahun'
            );
        }
    });
});