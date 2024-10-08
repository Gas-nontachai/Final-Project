<?php
session_start();
require("../condb.php");
if ($_SESSION["userrole"] == 1) {
    session_destroy();
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ไม่มีสิทธิ์เข้าถึง</title>
            <link rel="icon" type="image/x-icon" href="../asset/img/icon.market.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "หน้านี้สำหรับผู้ใช้ทั่วไป คุณคือผู้ดูแลระบบ",
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
            <link rel="icon" type="image/x-icon" href="../asset/img/icon.market.png">
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
    <link rel="icon" type="image/x-icon" href="../asset/img/icon.market.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
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
    <!-- Nav -->
    <?php
    include('./user_nav.php');
    ?>

    <!-- แสดงผล -->
    <div class="container my-4 p-2 border border-dark-subtle rounded  overflow-auto  bgcolor" style="width: 90%; height: 45rem;">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active mt-2 mx-2 p-2" id="category">
                <div>
                    <h1>ประวัติการจอง</h1>
                </div>
                <div class="mt-2 overflow-auto">
                    <?php
                    // Pagination links
                    $sql_total = "SELECT COUNT(*) FROM market_booking.booked WHERE member_id = $user_id";
                    $result_total = $conn->query($sql_total);
                    $row_total = $result_total->fetch_row();
                    $total_records = $row_total[0];
                    $total_pages = ceil($total_records / $results_per_page);
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $adjacents = 1; // จำนวนหน้าที่จะแสดงข้างหน้าและข้างหลังเลขหน้า  

                    echo "<nav>";
                    echo "<ul class='pagination justify-content-center'>";

                    // ปุ่ม Previous
                    if ($current_page > 1) {
                        echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page - 1) . "'>Previous</a></li>";
                    }

                    // แสดงปุ่มเลขหน้า
                    if ($total_pages <= (1 + ($adjacents * 2))) {
                        // ถ้ามีหน้าน้อย แสดงทุกหน้า
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $current_page) {
                                echo "<li class='page-item active'><a class='page-link' href='#'>" . $i . "</a></li>";
                            } else {
                                echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
                            }
                        }
                    } else {
                        // ถ้ามีหลายหน้า
                        if ($current_page <= ($adjacents * 2)) {
                            // ถ้าอยู่ในหน้าต้น ๆ แสดงหน้าต้น ๆ
                            for ($i = 1; $i <= (4 + ($adjacents * 2)); $i++) {
                                if ($i == $current_page) {
                                    echo "<li class='page-item active'><a class='page-link' href='#'>" . $i . "</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
                                }
                            }
                            echo "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='?page=" . $total_pages . "'>" . $total_pages . "</a></li>";
                        } elseif ($current_page > ($total_pages - ($adjacents * 2))) {
                            // ถ้าอยู่ในหน้าท้าย ๆ แสดงหน้าท้าย ๆ
                            echo "<li class='page-item'><a class='page-link' href='?page=1'>1</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                            for ($i = ($total_pages - (4 + ($adjacents * 2))); $i <= $total_pages; $i++) {
                                if ($i == $current_page) {
                                    echo "<li class='page-item active'><a class='page-link' href='#'>" . $i . "</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
                                }
                            }
                        } else {
                            // ถ้าอยู่ตรงกลาง แสดงหน้าใกล้เคียง
                            echo "<li class='page-item'><a class='page-link' href='?page=1'>1</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                            for ($i = ($current_page - $adjacents); $i <= ($current_page + $adjacents); $i++) {
                                if ($i == $current_page) {
                                    echo "<li class='page-item active'><a class='page-link' href='#'>" . $i . "</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
                                }
                            }
                            echo "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                            echo "<li class='page-item'><a class='page-link' href='?page=" . $total_pages . "'>" . $total_pages . "</a></li>";
                        }
                    }

                    // ปุ่ม Next
                    if ($current_page < $total_pages) {
                        echo "<li class='page-item'><a class='page-link' href='?page=" . ($current_page + 1) . "'>Next</a></li>";
                    }

                    echo "</ul>";
                    echo "</nav>";
                    $sql = "SELECT 
                    B.booking_status,
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
                            LEFT JOIN sub_category AS SC ON B.sub_product_type = SC.idsub_category
                            WHERE member_id = $user_id
                            ";

                    $sql .= " LIMIT $start_from, $results_per_page";

                    $result = $conn->query($sql);

                    if ($result === false) {
                        echo "ข้อผิดพลาด SQL: " . $conn->error;
                    } elseif ($result->num_rows > 0) {
                        echo "<table class='table table-striped'>";
                        echo "<thead>
                            <tr>
                                <th>รหัสการจอง</th>
                                <th>จำนวนการจองและราคา</th>
                                <th>ประเภทสินค้า</th>
                                <th>สถานะการจอง</th>
                                <th>Action</th>
                            </tr>
                        </thead>";
                        echo "<tbody>";
                        function getBadgeClass($status)
                        {
                            switch ($status) {
                                case '4':
                                    return 'bg-success text-white'; // สีเขียว
                                case '6':
                                    return 'bg-danger text-white'; // สีเหลือง
                                case '10':
                                    return 'bg-danger text-white'; // สีแดง
                                case '11':
                                    return 'bg-success text-white'; // สีน้ำเงิน
                                default:
                                    return 'bg-primary text-white'; // สีเทา สำหรับสถานะอื่น ๆ
                            }
                        }
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td style='text-align:center;'><strong>" . $row["booking_id"] . "</strong></td>";
                            echo "<td><strong>" . $row["booking_amount"] . " ล็อค รวม: " . $row["total_price"] . " ฿</strong></td>";
                            echo "<td><strong>" . $row["cat_name"] . " (" . $row["sub_cat_name"] . ")</strong></td>";
                            echo "<td>" . (is_null($row['status']) ?
                                "<span class='text-danger'>ข้อมูลถูกลบไปแล้ว</span>" :
                                "<span class='badge " . getBadgeClass($row['booking_status']) . "'>" . htmlspecialchars($row['status']) . "</span>") . "</td>";
                            echo "<td>
                                    <button 
                                        class='btn btn-primary m-2' type='button' 
                                        data-bs-toggle='modal' 
                                        data-bs-target='#viewBookingModal' 
                                        data-id='" . $row["booking_id"] . "'>
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
				<table class="table table-striped">			
					<thead>
					<tr>
						<th>หมายเลขการจอง</th>
						<th>${data.booking_id}</th>
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
						<td> ${data.total_price}</td>
					</tr>
					<tr>
						<th scope="row">ประเภทสินค้า</th>
						<td> ${data.cat_name}</td>
					</tr>	
					<tr>
						<th scope="row">ประเภทสินค้าย่อย</th>
						<td> ${data.sub_cat_name}</td>
					</tr>	
					<tr>
						<th scope="row">สถานะการจอง</th>
						<td> ${data.status}</td>
					</tr>	
					<tr>
						<th scope="row">ประเภทการจอง</th>
						<td> ${data.booking_type === 'PerDay' ? 'รายวัน' : data.booking_type === 'PerMonth' ? 'รายเดือน' : 'ไม่ทราบประเภทการจอง'}</td>
					</tr>	
					<tr>
						<th scope="row">เลขล็อคที่ได้รับ</th>
						<td>  ${data.booked_lock_number ? data.booked_lock_number : 'ยังไม่ได้รับเลขล็อค'}</td>
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
                                content += `
                                <tr>
                                    <th scope="row">รูปภาพใบเสร็จ</th>
                                    <td>  <img  src="../asset./slip_img/${data.slip_img}" alt="ภาพใบเสร็จ" class="img-fluid"></td>
                                </tr>
                             </tbody>
                               </table>`;
                            } else {
                                content += ``;
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