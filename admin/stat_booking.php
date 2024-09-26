<?php
session_start();
require("../condb.php");
if ($_SESSION["userrole"] == 0) {
    session_destroy();
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ไม่มีสิทธิ์เข้าถึง</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "คุณไม่มีสิทธิ์เข้าถึง เฉพาะผู้ดูแลเท่านั้น",
                    icon: "error",
                    showConfirmButton: true
                }).then((result) => {
                    window.location.href = "../login.php";
                });
            });
        </script>
    </body>
    </html>';
    exit();
}
if (!isset($_SESSION["username"])) {
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>กรุณาล็อคอินก่อน</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "กรุณาล็อคอินก่อน",
                   icon: "error",
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                }).then((result) => {
                        window.location.href = "../login.php";
                    
                });
            });
        </script>
    </body>
    </html>';
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$shop_name = $_SESSION["shop_name"];
$prefix = $_SESSION["prefix"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];
$tel = $_SESSION["tel"];
$email = $_SESSION["email"];
$userrole = $_SESSION["userrole"];
$fullname = $prefix . ' ' . $firstname . ' ' . $lastname;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
    <!-- Custom styles for this template-->
    <link href="../asset/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .bg {
            background-color: #F0EBE3;
        }

        .chart-container {
            position: relative;
            width: 60%;
            height: 100%;
            /* Set height to a smaller percentage */
            margin: auto;
            /* Center the chart */
        }
    </style>
</head>

<body id="page-top">
    <!-- Nav -->
    <?php
    include('./admin_nav.php');
    ?>
    <!-- Page Wrapper -->
    <div class="bg" id="wrapper" class="mt-3">

        <!-- Content Wrapper -->
        <div id="bg content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id=" content">

                <!-- Begin Page Content -->
                <div class=" container-fluid mt-4">

                    <div class=" container-fluid d-flex justify-content-around align-items-start">
                        <div style="width: 50%; height:30rem;" class=" shadow bg-light p-3 m-2 rounded">
                            <!-- Content Row -->
                            <div class="row ">

                                <!-- สมาชิกปัจจุบัน Card -->
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="font-weight-bold text-primary text-uppercase mx-2">
                                                        สมาชิกปัจจุบัน
                                                    </div>
                                                    <?php
                                                    $query = "SELECT COUNT(*) AS total_members FROM tbl_user ;";
                                                    $result = mysqli_query($conn, $query);
                                                    $row = mysqli_fetch_assoc($result);
                                                    $total_members = $row['total_members'];
                                                    ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mx-2">
                                                        <?php echo $total_members; ?> คน
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="font-weight-bold text-success text-uppercase mx-2">
                                                        จำนวนการจองปัจจุบัน</div>
                                                    <?php
                                                    $query = "SELECT COUNT(*) AS total_book FROM booking ;";
                                                    $result = mysqli_query($conn, $query);
                                                    $row = mysqli_fetch_assoc($result);
                                                    $total_book = $row['total_book'];
                                                    ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mx-2">
                                                        <?php echo $total_book; ?> รายการ
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-info shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="font-weight-bold text-info text-uppercase mx-2">
                                                        จองที่เสร็จสิ้นแล้ว</div>
                                                    <?php
                                                    $query = "SELECT COUNT(*) AS total_booked FROM booked ;";
                                                    $result = mysqli_query($conn, $query);
                                                    $row = mysqli_fetch_assoc($result);
                                                    $total_booked = $row['total_booked'];
                                                    ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mx-2">
                                                        <?php echo $total_booked; ?> รายการ
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="font-weight-bold text-danger text-uppercase mx-2">
                                                        จำนวนการจองที่ยกเลิก</div>
                                                    <?php
                                                    $query = "SELECT COUNT(*) AS cancel_booked FROM booked WHERE booking_status = 5 OR booking_status = 6;";
                                                    $result = mysqli_query($conn, $query);
                                                    $row = mysqli_fetch_assoc($result);
                                                    $cancel_booked = $row['cancel_booked'];
                                                    ?>
                                                    <div class="h5 mb-0 font-weight-bold text-red-800 mx-2">
                                                        <?php echo $cancel_booked; ?> รายการ
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-dollar-sign fa-2x text-red-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="font-weight-bold text-warning text-uppercase mx-2">
                                                        คะแนนตลาดปัจจุบัน
                                                    </div>
                                                    <?php
                                                    $query = "SELECT 
                                                            ROUND(AVG(rating), 1) AS average_rating
                                                        FROM comments;";
                                                    $result = mysqli_query($conn, $query);
                                                    $row = mysqli_fetch_assoc($result);
                                                    $average_rating = $row['average_rating'];
                                                    ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mx-2">
                                                        <?php echo $average_rating; ?> / 5.0 คะแนน
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card border-left-dark shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="font-weight-bold text-dark text-uppercase mx-2">
                                                        จำนวนคอมเมนต์</div>
                                                    <?php
                                                    $query = "SELECT 
                                                            COUNT(*) AS total_comments
                                                        FROM comments;";
                                                    $result = mysqli_query($conn, $query);
                                                    $row = mysqli_fetch_assoc($result);
                                                    $total_comments = $row['total_comments'];
                                                    ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800 mx-2">
                                                        <?php echo $total_comments; ?> รายการ
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div style="width: 40%; height: 30rem;" class="shadow bg-light  p-3 m-2 rounded">
                            <div class="row overflow-auto" style="height: 28rem;">
                                <?php
                                $sql = "SELECT id, comment, rating, created_at, firstname FROM market_booking.comments AS C
                                LEFT JOIN tbl_user AS U ON C.user_id = U.user_id 
                                ORDER BY created_at DESC";
                                $result = mysqli_query($conn, $sql);
                                ?>
                                <!-- แสดงความคิดเห็นที่เคยแสดงความคิดเห็น -->
                                <div class="container">
                                    <h4> <strong>ความคิดเห็นทั้งหมด</strong> </h4>
                                    <?php if (mysqli_num_rows($result) > 0): ?>
                                        <ul class="list-group">
                                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <span> <strong><?php echo $row['firstname']; ?></strong> </span>
                                                            <span>คะแนน: <?php echo $row['rating']; ?>/5</span>
                                                        </div>
                                                        <span><?php echo $row['created_at']; ?></span>
                                                    </div>
                                                    <p><?php echo htmlspecialchars($row['comment']); ?></p>

                                                </li>
                                            <?php endwhile; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p>คุณยังไม่ได้แสดงความคิดเห็น</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 border-top border-bottom border-dark py-2 mb-3">
                        <div class="container rounded bg-light ">
                            <h2>สถิติการจอง</h2>
                            <div class="form-group">
                                <label for="timeFrame">เลือกช่วงเวลา:</label>
                                <select id="timeFrame" class="form-control">
                                    <option value="monthly">รายเดือน</option>
                                    <option value="weekly">รายสัปดาห์</option>
                                    <option value="daily">รายวัน</option>
                                </select>
                            </div>
                            <div class="d-flex">
                                <div style="height: 30rem;" class="w-50 m-2 shadow bg-light p-3 rounded">
                                    <canvas id="bookingChart" width="250" height="300"></canvas>
                                </div>
                                <div style="height: 30rem;" class="w-50 m-2 shadow bg-light p-3 rounded">
                                    <canvas id="revenueChart" width="250" height="300" class="mt-4"></canvas>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                const bookingCtx = document.getElementById('bookingChart').getContext('2d');
                                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                                let bookingChart;
                                let revenueChart;

                                function formatNumber(num) {
                                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }

                                function fetchData(timeFrame) {
                                    $.ajax({
                                        url: 'fetch_stat_booking_total.php',
                                        type: 'GET',
                                        data: {
                                            timeFrame: timeFrame
                                        },
                                        dataType: 'json',
                                        success: function(data) {
                                            let labels = [];
                                            const totalBookings = data.map(item => item.total_bookings);
                                            const totalRevenue = data.map(item => item.total_revenue);

                                            if (timeFrame === 'daily') {
                                                labels = data.map(item => {
                                                    const date = new Date(item.booking_date);
                                                    return date.toLocaleDateString('th-TH', {
                                                        day: 'numeric',
                                                        month: 'long',
                                                        year: 'numeric'
                                                    });
                                                });
                                            } else if (timeFrame === 'weekly') {
                                                labels = data.map(item => {
                                                    const yearWeek = item.booking_week.split('-');
                                                    const year = yearWeek[0];
                                                    const week = yearWeek[1];
                                                    const firstDayOfWeek = new Date(year, 0, (week - 1) * 7 + 1);
                                                    return firstDayOfWeek.toLocaleDateString('th-TH', {
                                                        month: 'long',
                                                        year: 'numeric'
                                                    }) + ` (สัปดาห์ที่ ${week})`;
                                                });
                                            } else {
                                                labels = data.map(item => {
                                                    const monthDate = new Date(item.booking_month + '-01');
                                                    return monthDate.toLocaleDateString('th-TH', {
                                                        month: 'long',
                                                        year: 'numeric'
                                                    });
                                                });
                                            }

                                            if (bookingChart) {
                                                bookingChart.destroy();
                                            }

                                            if (revenueChart) {
                                                revenueChart.destroy();
                                            }

                                            // Booking Chart
                                            bookingChart = new Chart(bookingCtx, {
                                                type: 'bar',
                                                data: {
                                                    labels: labels,
                                                    datasets: [{
                                                        label: 'จำนวนการจอง',
                                                        data: totalBookings,
                                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                        borderColor: 'rgba(75, 192, 192, 1)',
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            title: {
                                                                display: true,
                                                                text: 'จำนวนการจอง'
                                                            }
                                                        },
                                                        x: {
                                                            title: {
                                                                display: true,
                                                                text: 'วัน/สัปดาห์/เดือน'
                                                            }
                                                        }
                                                    }
                                                }
                                            });

                                            // Revenue Chart
                                            revenueChart = new Chart(revenueCtx, {
                                                type: 'bar',
                                                data: {
                                                    labels: labels,
                                                    datasets: [{
                                                        label: 'รายได้รวม',
                                                        data: totalRevenue,
                                                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                                        borderColor: 'rgba(153, 102, 255, 1)',
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            title: {
                                                                display: true,
                                                                text: 'รายได้ (บาท)'
                                                            }
                                                        },
                                                        x: {
                                                            title: {
                                                                display: true,
                                                                text: 'วัน/สัปดาห์/เดือน'
                                                            }
                                                        }
                                                    },
                                                    plugins: {
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(context) {
                                                                    return context.dataset.label + ': ' + formatNumber(context.raw) + ' ฿'; // Format revenue with commas
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            alert('เกิดข้อผิดพลาดในการดึงข้อมูล กรุณาลองใหม่อีกครั้ง');
                                            console.error('AJAX Error:', textStatus, errorThrown);
                                        }
                                    });
                                }


                                $('#timeFrame').change(function() {
                                    const selectedValue = $(this).val();
                                    fetchData(selectedValue);
                                });

                                // เรียกใช้ฟังก์ชันเริ่มต้นเมื่อโหลดหน้า
                                fetchData('monthly');
                            });
                        </script>
                    </div>
                    <div class="mb-5 container py-3 pb-2 mb-3 shadow bg-light rounded">
                        <h2>วิเคราะห์โซนและการวิเคราะห์การจองตามประเภทสินค้า</h2>

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

                        <div class="d-flex">
                            <div class="w-50 m-2 shadow bg-light p-3 rounded">
                                <h2>วิเคราะห์โซน</h2>
                                <div class="chart-container">
                                    <canvas id="zoneChart"></canvas> <!-- No height and width set inline -->
                                    <div class="legend-container" id="legendZone"></div>

                                </div>
                            </div>
                            <div class="w-50 m-2 shadow bg-light p-3 rounded">
                                <h2>การวิเคราะห์การจองตามประเภทสินค้า</h2>
                                <div class="chart-container">
                                    <canvas id="productTypeChart"></canvas> <!-- No height and width set inline -->
                                    <div class="legend-container" id="legendProduct"></div>

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
                        </script>

                        <script>
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
                        </script>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                </div>
            </div>
        </div>
    </div>


</body>

</html>