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
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "กรุณาล็อคอินก่อน",
                    icon: "error",
                    timer: 2000, 
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "../admin/login.php";
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
    <link rel="stylesheet" href="../asset/css/font.css">
</head>

<body>
    <!-- เมนูนำทาง -->
    <?php include('./admin_nav.php'); ?>

    <!-- แสดงผล -->
    <div class="container my-4 p-2 border border-dark-subtle rounded overflow-auto" style="width: 90%; height: 40rem;">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active mt-2 mx-2 p-2" id="category">

                <div class="mt-2">
                    <div class="d-flex">
                        <div class="row">
                            <div class="w-50">
                                <h2><strong>ประวัติการจอง</strong></h2>
                            </div>
                            <div class="w-50">
                                <form method="GET">
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="text" name="search_query" placeholder="ค้นหาโดยรหัสการจอง, ชื่อ-สกุล">
                                        <button class="btn btn-outline-secondary" type="submit">ค้นหา</button>
                                        <a href="?reset=true" class="btn btn-outline-secondary">รีเซ็ต</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Pagination links
                    $sql_total = "SELECT COUNT(*) FROM market_booking.booked";
                    $result_total = $conn->query($sql_total);
                    $row_total = $result_total->fetch_row();
                    $total_records = $row_total[0];
                    $total_pages = ceil($total_records / $results_per_page);

                    echo "<nav>";
                    echo "<ul class='pagination'>";
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
                    }
                    echo "</ul>";
                    echo "</nav>";

                    $sql = "SELECT 
                B.booking_id, 
                CONCAT(U.prefix, ' ', U.firstname, ' ', U.lastname) AS fullname, 
                B.booking_amount, 
                B.total_price, 
                C.cat_name, 
                SC.sub_cat_name, 
                BS.status, 
                B.booking_type, 
                B.slip_img, 
                B.booked_lock_number, 
                B.booking_date
            FROM market_booking.booked AS B
            LEFT JOIN booking_status AS BS ON B.booking_status = BS.id
            LEFT JOIN tbl_user AS U ON B.member_id = U.user_id
            LEFT JOIN category AS C ON B.product_type = C.id_category
            LEFT JOIN sub_category AS SC ON B.sub_product_type = SC.idsub_category";

                    // ตรวจสอบว่ามีการตั้งค่าคำค้นหาหรือไม่
                    if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
                        $search_query = $conn->real_escape_string($_GET['search_query']);
                        $sql .= " WHERE B.booking_id LIKE '%$search_query%' 
                  OR CONCAT(U.prefix, ' ', U.firstname, ' ', U.lastname) LIKE '%$search_query%'";
                    }

                    // ตรวจสอบว่ามีการคลิกปุ่มรีเซ็ตหรือไม่
                    if (isset($_GET['reset'])) {
                        $sql = "SELECT 
                    B.booking_id, 
                    CONCAT(U.prefix, ' ', U.firstname, ' ', U.lastname) AS fullname, 
                    B.booking_amount, 
                    B.total_price, 
                    C.cat_name, 
                    SC.sub_cat_name, 
                    BS.status, 
                    B.booking_type, 
                    B.slip_img, 
                    B.booked_lock_number, 
                    B.booking_date
                FROM market_booking.booked AS B
                LEFT JOIN booking_status AS BS ON B.booking_status = BS.id
                LEFT JOIN tbl_user AS U ON B.member_id = U.user_id
                LEFT JOIN category AS C ON B.product_type = C.id_category
                LEFT JOIN sub_category AS SC ON B.sub_product_type = SC.idsub_category";
                    }

                    $sql .= " LIMIT $start_from, $results_per_page";

                    $result = $conn->query($sql);

                    if ($result === false) {
                        echo "ข้อผิดพลาด SQL: " . $conn->error;
                    } elseif ($result->num_rows > 0) {
                        echo "<table class='table table-striped'>";
                        echo "<thead>
            <tr>
                <th>รหัสการจอง</th>
                <th>ชื่อ-สกุล</th>
                <th>จำนวนการจองและราคา</th>
                <th>ประเภทสินค้า</th>
                <th>สถานะการจอง</th>
                <th>ประเภทการจอง</th>
                <th>Action</th>
            </tr>
        </thead>";
                        echo "<tbody>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><strong>" . (is_null($row["booking_id"]) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : $row["booking_id"]) . "</strong></td>";
                            echo "<td><strong>" . (is_null($row["fullname"]) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : $row["fullname"]) . "</strong></td>";
                            echo "<td><strong>" . (is_null($row["booking_amount"]) || is_null($row["total_price"]) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : $row["booking_amount"] . " ล็อค รวม:" . $row["total_price"] . " ฿") . "</strong></td>";
                            echo "<td><strong>" . (is_null($row["cat_name"]) || is_null($row["sub_cat_name"]) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : $row["cat_name"] . " (" . $row["sub_cat_name"] . ")") . "</strong></td>";
                            echo "<td><strong>" . (is_null($row["status"]) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : $row["status"]) . "</strong></td>";
                            echo "<td><strong>" . (is_null($row["booking_type"]) ? "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" : $row["booking_type"]) . "</strong></td>";
                            echo "<td>
                    <button 
                        class='btn btn-primary m-2' type='button' 
                        data-bs-toggle='modal' 
                        data-bs-target='#viewBookingModal' 
                        data-id='" . (is_null($row["booking_id"]) ? '' : $row["booking_id"]) . "'>
                        ดู
                    </button>
                </td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "ไม่พบข้อมูล";
                    }
                    ?>
                </div>


            </div>
        </div>

    </div>

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
                            <p><strong>หมายเลขการจอง:</strong> ${data.booking_id}</p>
                            <p><strong>ชื่อ-สกุล:</strong> ${data.fullname}</p>
                            <p><strong>จำนวนการจอง:</strong> ${data.booking_amount}</p>
                            <p><strong>ราคารวม:</strong> ${data.total_price}</p>
                            <p><strong>ประเภทสินค้า:</strong> ${data.cat_name}</p>
                            <p><strong>ประเภทสินค้าย่อย:</strong> ${data.sub_cat_name}</p>
                            <p><strong>สถานะการจอง:</strong> ${data.status}</p>
                            <p><strong>ประเภทการจอง:</strong> ${data.booking_type}</p>
                            <p><strong>เลขล็อคที่ได้รับ:</strong> ${data.booked_lock_number}</p>
                            <p><strong>วันที่จอง:</strong> ${data.booking_date}</p>
                        `;
                            if (data.slip_img) {
                                content += `<img src="../asset./slip_img/${data.slip_img}" alt="ภาพใบเสร็จ" class="img-fluid">`;
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