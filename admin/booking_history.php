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

// Pagination
$results_per_page = 7; // จำนวนรายการต่อหน้า
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $results_per_page;
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการจอง</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../asset/css/font.css">
    <style>
        body {
            background-image: url(../asset/img/img.market2blur.png);
            width: 100%;
            height: 100%;
            background-repeat: repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <!-- เมนูนำทาง -->
    <?php include('./admin_nav.php'); ?>

    <!-- แสดงผล -->
    <div class="container my-4 px-2 border bgcolor py-4 rounded overflow-auto" style="width: 90%; height: 40rem;">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active mt-2 mx-2 p-2" id="categort">
                <div>
                    <h1>ประวัติการจอง</h1>
                </div>
                <div class="mt-2">
                    <form id="searchForm" method="GET">
                        <div class="input-group mb-3">
                            <input class="form-control" id="search" type="text" name="search_query" placeholder="ค้นหาด้วยรหัสการจอง,ชื่อ-สกุล" value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>">
                            <button class="btn btn-outline-secondary" type="submit">ค้นหา</button>
                            <a href="?reset=true" class="btn btn-outline-secondary">รีเซ็ต</a>
                        </div>
                    </form>

                    <div id="resultsContainer">
                        <!-- ผลลัพธ์ที่ค้นหาจะแสดงที่นี่ -->
                    </div>

                    <nav id="paginationNav" aria-label="Page navigation">
                        <ul class="pagination justify-content-center" id="paginationLinks"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            loadData(); // โหลดข้อมูลเมื่อเริ่มต้น

            // เมื่อมีการพิมพ์ในฟิลด์ค้นหา
            $('#search').on('input', function() {
                loadData(); // โหลดข้อมูลใหม่เมื่อมีการค้นหา
            });

            // เมื่อคลิกที่ pagination links
            $(document).on('click', '#paginationLinks .page-link', function(e) {
                e.preventDefault(); // ป้องกันการโหลดหน้าใหม่
                var page = $(this).attr('data-page'); // ดึงหมายเลขหน้าจาก data attribute
                loadData(page); // โหลดข้อมูลด้วยหมายเลขหน้า
            });

            function loadData(page = 1) {
                var searchQuery = $('#search').val(); // รับค่าการค้นหา

                $.ajax({
                    url: 'fetch_jquery_booking.php', // URL ของ PHP ที่จัดการกับการค้นหา
                    method: 'GET',
                    data: {
                        search_query: searchQuery,
                        page: page // ส่งหมายเลขหน้าไปด้วย
                    },
                    success: function(data) {
                        // ตรวจสอบว่าข้อมูลที่ได้รับคือ JSON หรือไม่
                        try {
                            var jsonData = JSON.parse(data); // แปลง JSON string เป็น object

                            // แสดงผลลัพธ์ใน #resultsContainer
                            $('#resultsContainer').html(jsonData.results);

                            // แสดงผลลัพธ์ของ pagination
                            $('#paginationLinks').html(jsonData.pagination);
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            $('#resultsContainer').html('ไม่สามารถแสดงผลลัพธ์ได้');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $('#resultsContainer').html('เกิดข้อผิดพลาดในการเชื่อมต่อ');
                    }
                });
            }
        });
    </script>


    <!-- View Modal -->
    <div class="modal fade" id="viewBookingModal" tabindex="-1" aria-labelledby="viewBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="viewBookingModalLabel"><strong>รายละเอียดการจอง</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalContent"></div> <!-- Container for dynamic content -->
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Event listener for when the modal is about to be shown
            $('#viewBookingModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var bookingId = button.data('id'); // Extract booking ID from data-* attribute

                // Make an AJAX request to fetch booking details
                $.ajax({
                    url: 'fetch_history_booking_details.php', // Create a new PHP file for fetching data
                    method: 'POST',
                    data: {
                        booking_id: bookingId
                    },
                    success: function(data) {
                        $('#modalContent').html(data); // Update modal content with received data
                    },
                    error: function() {
                        $('#modalContent').html('<p>ไม่สามารถโหลดข้อมูลการจองได้</p>'); // Error message
                    }
                });
            });
        });
    </script>
</body>

</html>