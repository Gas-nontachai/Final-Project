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
            background-image: url(../asset/img/img.market2.jpg);
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
                    <!-- Content will be dynamically filled by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Listen for clicks to open the modal
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const bookingId = this.getAttribute('data-id');
                    fetchBookingDetails(bookingId);
                });
            });

            function fetchBookingDetails(bookingId) {
                // Clear previous content
                document.querySelector('#viewBookingModal .modal-body').innerHTML = '';

                fetch('fetch_history_booking_details.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            'fetch_booking_details': 1,
                            'booking_id': bookingId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        let content = '';
                        if (data.error) {
                            content = `<p>${data.error}</p>`;
                        } else {
                            content = `
                            <table class="table table-striped-columns">			
					<thead>
					<tr>
						<th>หมายเลขการจอง</th>
						<td>${data.booking_id}</td>
					</tr>
					</thead>
					<tbody>
							<tr>
						<th scope="row">ชื่อ-สกุล</th>
						<td>${data.fullname}</td>
					</tr>
							<tr>
						<th scope="row">จำนวนการจอง</th>
						<td>${data.booking_amount}</td>
					</tr>
							<tr>
						<th scope="row">ราคารวม</th>
						<td>${data.total_price}</td>
					</tr>
							<tr>
						<th scope="row">ประเภทสินค้า</th>
						<td>${data.cat_name}(${data.sub_cat_name})</td>
					</tr>
							<tr>
						<th scope="row">สถานะการจอง</th>
						<td>${data.status}</td>
					</tr>
							<tr>
						<th scope="row">ประเภทการจอง</th>
						<td>${data.booking_type === 'PerDay' ? 'รายวัน' : data.booking_type === 'PerMonth' ? 'รายเดือน' : 'ไม่ทราบประเภทการจอง'}</td>
					</tr>
							<tr>
						<th scope="row">เลขล็อคที่ได้รับ</th>
						<td>${data.booked_lock_number ? data.booked_lock_number : 'ยังไม่ได้รับเลขล็อคหรือข้อมูลสูญหาย'}</td>
					</tr>
							<tr>
						<th scope="row">วันที่จอง</th>
						<td> ${data.display_booking_date}</td>
					</tr>	 
							<tr>
						<th scope="row">วันหมดอายุการจอง</th>
						<td>${data.display_expiration_date ? data.display_expiration_date : 'ดำเนินการยังไม่เสร็จสิ้น'}</td>
					</tr>	 `;
                            if (data.slip_img) {
                                content += ` <tr>
                                                <th scope="row">รูปภาพใบเสร็จ</th>
                                                <td>  <img  src="../asset/slip_img/${data.slip_img}" alt="ภาพใบเสร็จ" class="img-fluid"></td>
                                             </tr>
                                          </tbody>
                                       </table>`;
                            } else {
                                content += `</tbody>
                                </table>`;
                            }
                        }
                        document.querySelector('#viewBookingModal .modal-body').innerHTML = content;
                    })
                    .catch(error => {
                        console.error('เกิดข้อผิดพลาดในการดึงข้อมูลการจอง:', error);
                        document.querySelector('#viewBookingModal .modal-body').innerHTML = '<p>มีข้อผิดพลาดในการดึงข้อมูลการจอง</p>';
                    });
            }
        });
    </script>

</body>

</html>