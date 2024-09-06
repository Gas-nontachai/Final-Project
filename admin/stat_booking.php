<?php
session_start();
require("../condb.php");

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
                        timer: 2000, 
                        timerProgressBar: true, // แสดงแถบความก้าวหน้า
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "../login.php";
                    }
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

    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
    <!-- Custom styles for this template-->
    <link href="../asset/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body id="page-top">
    <!-- Nav -->
    <?php
    include('./admin_nav.php');
    ?>
    <!-- Page Wrapper -->
    <div id="wrapper" class="mt-3">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid mt-4">

                    <div class="container-fluid d-flex justify-content-around align-items-start">
                        <div style="width: 50%;">
                            <!-- Content Row -->
                            <div class="row">

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

                        <div style="width: 40%;">
                            <div class="row overflow-auto" style="height: 25rem;">
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
                    <div class="container-fluid d-flex justify-content-around align-items-start">
                        <div class="row ms-5" style="width: 50%;">
                            <?php
                            // ดึงข้อมูลการจองต่อเดือน
                            $sql_month = "SELECT DATE_FORMAT(booking_date, '%Y-%m') AS month, COUNT(*) AS total_bookings FROM booked GROUP BY month";
                            $result_month = $conn->query($sql_month);

                            $data_month = array();
                            if ($result_month->num_rows > 0) {
                                while ($row = $result_month->fetch_assoc()) {
                                    $data_month[] = $row;
                                }
                            }

                            // ดึงข้อมูลการจองต่อวัน
                            $sql_day = "SELECT DATE(booking_date) AS day, COUNT(*) AS total_bookings FROM booked GROUP BY day";
                            $result_day = $conn->query($sql_day);

                            $data_day = array();
                            if ($result_day->num_rows > 0) {
                                while ($row = $result_day->fetch_assoc()) {
                                    $data_day[] = $row;
                                }
                            }
                            ?>
                            <div class="container mt-5">
                                <h1 class="mb-4"> <strong>ยอดการจองต่อวัน</strong> </h1>
                                <div class="row">
                                    <div class="col-md-8">
                                        <canvas id="dailyBookingsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="container mt-5">
                                <h1 class="mb-4"> <strong>ยอดการจองต่อเดือน</strong> </h1>
                                <div class="row">
                                    <div class="col-md-8">
                                        <canvas id="monthlyBookingsChart"></canvas>
                                    </div>
                                </div>
                            </div>



                            <script>
                                // กราฟยอดการจองต่อเดือน
                                var dataFromPHP_month = <?php echo json_encode($data_month); ?>;

                                var labels_month = dataFromPHP_month.map(function(e) {
                                    return e.month;
                                });
                                var values_month = dataFromPHP_month.map(function(e) {
                                    return e.total_bookings;
                                });

                                var ctx_month = document.getElementById('monthlyBookingsChart').getContext('2d');
                                var myChart_month = new Chart(ctx_month, {
                                    type: 'bar',
                                    data: {
                                        labels: labels_month,
                                        datasets: [{
                                            label: 'ยอดการจอง',
                                            data: values_month,
                                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        return context.label + ': ' + context.raw;
                                                    }
                                                }
                                            }
                                        },
                                        scales: {
                                            x: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'เดือน'
                                                }
                                            },
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'ยอดการจองทั้งหมด'
                                                }
                                            }
                                        }
                                    }
                                });

                                // กราฟยอดการจองต่อวัน
                                var dataFromPHP_day = <?php echo json_encode($data_day); ?>;

                                var labels_day = dataFromPHP_day.map(function(e) {
                                    return e.day;
                                });
                                var values_day = dataFromPHP_day.map(function(e) {
                                    return e.total_bookings;
                                });

                                var ctx_day = document.getElementById('dailyBookingsChart').getContext('2d');
                                var myChart_day = new Chart(ctx_day, {
                                    type: 'line', // เปลี่ยนเป็น line เพื่อดูแนวโน้มการจองต่อวัน
                                    data: {
                                        labels: labels_day,
                                        datasets: [{
                                            label: 'ยอดการจอง',
                                            data: values_day,
                                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                            borderColor: 'rgba(153, 102, 255, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        return context.label + ': ' + context.raw;
                                                    }
                                                }
                                            }
                                        },
                                        scales: {
                                            x: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'วัน'
                                                }
                                            },
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'ยอดการจองทั้งหมด'
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>

                        <div class="row" style="width: 50%; ">
                            <style>
                                .chart-container {
                                    position: relative;
                                    width: 100%;
                                    height: 400px;
                                    /* ปรับความสูงของกราฟตามต้องการ */
                                }

                                #bookingStatusChart {
                                    width: 100% !important;
                                    height: auto !important;
                                }
                            </style>
                            <?php
                            $sql = "SELECT status, COUNT(*) AS count FROM booked AS B
                                    LEFT JOIN booking_status AS BS ON B.booking_status = BS.id
                                    GROUP BY booking_status";
                            $result = $conn->query($sql);

                            $data = array();
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $data[] = $row;
                                }
                            }
                            $conn->close();
                            ?>
                            <div class="container">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="chart-container p-3 mb-4">
                                            <h1 class="mb-4 text-center"> <strong>กราฟสถานะการจอง</strong> </h1>
                                            <canvas id="bookingStatusChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                var dataFromPHP = <?php echo json_encode($data); ?>;

                                var labels = dataFromPHP.map(function(e) {
                                    return e.status;
                                });
                                var values = dataFromPHP.map(function(e) {
                                    return e.count;
                                });

                                var ctx = document.getElementById('bookingStatusChart').getContext('2d');
                                var bookingStatusChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'กราฟสถานะการจอง',
                                            data: values,
                                            backgroundColor: [
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false, // ปิดการรักษาสัดส่วน
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        return context.label + ': ' + context.raw;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <!-- Bootstrap core JavaScript-->
    <script src="../asset/vendor/jquery/jquery.min.js"></script>
    <script src="../asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../asset/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../asset/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../asset/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../asset/js/demo/chart-area-demo.js"></script>
    <script src="../asset/js/demo/chart-pie-demo.js"></script>

</body>

</html>