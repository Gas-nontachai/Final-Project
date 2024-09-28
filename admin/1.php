<div>
    <div class="form-group mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="startDate" class="form-label">วันเริ่มต้น</label>
                <input type="date" id="startDate" class="form-control" value="<?= date('Y-m-d', strtotime('-7 days')); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="endDate" class="form-label">วันสิ้นสุด</label>
                <input type="date" id="endDate" class="form-control" value="<?= date('Y-m-d'); ?>">
            </div>
        </div>
    </div>
    <div class="mt-3 border-top border-bottom border-dark py-2 mb-3">
        <div class="container rounded bg-light ">
            <h2>สถิติการจอง</h2>
            <div class="d-flex">
                <div style="height: 30rem;" class="w-50 m-2 shadow bg-light p-3 rounded">
                    <canvas id="bookingChart" width="250" height="300"></canvas>
                </div>
                <div style="height: 30rem;" class="w-50 m-2 shadow bg-light p-3 rounded">
                    <div style="height: 50%;" class="border">
                        <canvas id="revenueDayChart" width="150" height="80" class="mt-4"></canvas>
                    </div>
                    <div style="height: 50%;" class="border">
                        <canvas id="revenueMonthChart" width="150" height="80" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5 container py-3 pb-2 mb-3 shadow bg-light rounded">
        <h2>วิเคราะห์โซนและการวิเคราะห์การจองตามประเภทสินค้า</h2>
        <div class="d-flex">
            <div class="w-50 m-2 shadow bg-light p-3 rounded">
                <h2>วิเคราะห์โซน</h2>
                <div class="chart-container">
                    <canvas id="zoneChart"></canvas>
                    <div class="legend-container" id="legendZone"></div>
                </div>
            </div>
            <div class="w-50 m-2 shadow bg-light p-3 rounded">
                <h2>การวิเคราะห์การจองตามประเภทสินค้า</h2>
                <div class="chart-container">
                    <canvas id="productTypeChart"></canvas>
                    <div class="legend-container" id="legendProduct"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ฟังก์ชันในการโหลดข้อมูลการจองสำหรับโซน
function loadZoneData(startDate, endDate) {
    fetch('fetch_zone_data_analysis.php?start_date=' + startDate + '&end_date=' + endDate)
        .then(response => response.json())
        .then(data => {
            updateZoneChart(data.labels, data.booking_amounts);
        });
}

// โหลดข้อมูลครั้งแรกเมื่อเปิดหน้า
loadZoneData('<?= date('Y-m-d', strtotime('-7 days')); ?>', '<?= date('Y-m-d'); ?>');

// สร้างกราฟด้วย Chart.js สำหรับโซน
var ctxZone = document.getElementById('zoneChart').getContext('2d');
var zoneChart = new Chart(ctxZone, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [{
            label: 'จำนวนการจอง',
            data: [],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

function updateZoneChart(labels, data) {
    zoneChart.data.labels = labels;
    zoneChart.data.datasets[0].data = data;
    zoneChart.update();

    // สร้างลิสต์ชื่อด้านขวา
    var legendHtml = '';
    labels.forEach((label, index) => {
        legendHtml += '<div style="display: flex; align-items: center;">' +
            '<div style="width: 15px; height: 15px; background-color:' + zoneChart.data.datasets[0].backgroundColor[index] + '; margin-right: 10px;"></div>' +
            '<span>' + label + ' (' + data[index] + ')</span>' +
            '</div>';
    });
    document.getElementById('legendZone').innerHTML = legendHtml;
}

document.getElementById('startDate').addEventListener('change', function() {
    var startDate = this.value;
    var endDate = document.getElementById('endDate').value;
    loadZoneData(startDate, endDate);
});

document.getElementById('endDate').addEventListener('change', function() {
    var startDate = document.getElementById('startDate').value;
    var endDate = this.value;
    loadZoneData(startDate, endDate);
});

// ฟังก์ชันในการโหลดข้อมูลการจองสำหรับประเภทสินค้า
function loadProductTypeData(startDate, endDate) {
    fetch('fetch_product_type_analysis.php?start_date=' + startDate + '&end_date=' + endDate)
        .then(response => response.json())
        .then(data => {
            updateProductTypeChart(data.labels, data.booking_amounts);
        });
}

// โหลดข้อมูลครั้งแรกเมื่อเปิดหน้า
loadProductTypeData('<?= date('Y-m-d', strtotime('-7 days')); ?>', '<?= date('Y-m-d'); ?>');

// สร้างกราฟด้วย Chart.js สำหรับประเภทสินค้า
var ctxProduct = document.getElementById('productTypeChart').getContext('2d');
var productTypeChart = new Chart(ctxProduct, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [{
            label: 'จำนวนการจอง',
            data: [],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

function updateProductTypeChart(labels, data) {
    productTypeChart.data.labels = labels;
    productTypeChart.data.datasets[0].data = data;
    productTypeChart.update();

    // สร้างลิสต์ชื่อด้านขวา
    var legendHtml = '';
    labels.forEach((label, index) => {
        legendHtml += '<div style="display: flex; align-items: center;">' +
            '<div style="width: 15px; height: 15px; background-color:' + productTypeChart.data.datasets[0].backgroundColor[index] + '; margin-right: 10px;"></div>' +
            '<span>' + label + ' (' + data[index] + ')</span>' +
            '</div>';
    });
    document.getElementById('legendProduct').innerHTML = legendHtml;
}

document.getElementById('startDate').addEventListener('change', function() {
    var startDate = this.value;
    var endDate = document.getElementById('endDate').value;
    loadProductTypeData(startDate, endDate);
});

document.getElementById('endDate').addEventListener('change', function() {
    var startDate = document.getElementById('startDate').value;
    var endDate = this.value;
    loadProductTypeData(startDate, endDate);
});

// ฟังก์ชันในการโหลดกราฟอื่นๆ ตามความจำเป็น
</script>
