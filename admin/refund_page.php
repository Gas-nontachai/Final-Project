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
    <title>คำขอคืนเงิน</title>
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

    <!-- เมนูนำทาง -->
    <?php include('./admin_nav.php'); ?>


    <!-- Display -->
    <div class="container my-4 px-2 border rounded overflow-auto bgcolor py-4" style="width: 100%; height: 40rem;">
        <ul class="nav nav-tabs" id="myTab">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#categort"><strong>คำขอคืนเงิน</strong></a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active mt-2 mx-2 p-2" id="categort">
                <div>
                    <h1>คำขอคืนเงิน</h1>
                </div>
                <div class="mt-2">
                    <div class="row overflow-auto">
                        <?php
                        $sql = "SELECT 
                        BK.expiration_date, 
                        BK.booking_date,
                        DATE_FORMAT(BK.booking_date, '%d/%m/%Y เวลา %H:%i') AS formatted_booking_date,
                        DATE_FORMAT(BK.expiration_date, '%d/%m/%Y เวลา %H:%i') AS formatted_expiration_date,
                        BK.total_price, 
                        BK.booking_id, 
                        CONCAT(U.prefix, ' ', U.firstname, ' ', U.lastname) AS fullname, 
                        BS.status, 
                        BK.booking_status, 
                        C.cat_name, 
                        SC.sub_cat_name, 
                        BK.booking_type, 
                        BK.booking_amount, 
                        BK.slip_img 
                    FROM booking AS BK 
                    LEFT JOIN booking_status AS BS ON BK.booking_status = BS.id
                    LEFT JOIN tbl_user AS U ON BK.member_id = U.user_id
                    LEFT JOIN category AS C ON BK.product_type = C.id_category
                    LEFT JOIN sub_category AS SC ON BK.sub_product_type = SC.idsub_category
                    WHERE booking_status IN (7, 5)";

                        $result = mysqli_query($conn, $sql);
                        ?>
                        <div class="container">
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <ul class="list-group">
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span><strong><?php echo $row['booking_id']; ?></strong></span>
                                                    <span><?php echo $row['fullname']; ?></span>
                                                    <p>
                                                        <strong>ยอดทั้งหมด <?php echo htmlspecialchars($row['total_price']); ?> บาท</strong>
                                                    </p>
                                                </div>
                                                <div class="d-flex flex-column justify-content-between align-items-end">
                                                    <div class="d-flex flex-column justify-content-center align-items-end">
                                                        <span>วันที่จอง : <?php echo $row['formatted_booking_date']; ?></span>
                                                    </div>
                                                    <div class="mt-1">
                                                        <button
                                                            class='btn btn-sm btn-primary m-2' type='button'
                                                            data-bs-toggle='modal'
                                                            data-bs-target='#viewBookingModal'
                                                            data-id='<?php echo $row["booking_id"]; ?>'>
                                                            ดู
                                                        </button>

                                                        <a href="#" class="btn btn-sm btn-danger"
                                                            onclick="confirmRefund('<?php echo $row['booking_id']; ?>', '<?php echo $row['booking_status']; ?>'); return false;">
                                                            ยืนยันการยกเลิกการจอง
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php else: ?>
                                <p>ยังไม่มีคำขอคืนเงินในตอนนี้</p>
                            <?php endif; ?>
                        </div>
                    </div>
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

                fetch('fetch_refund_booking_details.php', {
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
						<td> ${data.booking_amount} ล็อค</td>
					</tr>	
                    <tr>
						<th scope="row">ราคารวม</th>
						<td> ${data.total_price} บาท</td>
					</tr>
					<tr>
					<th scope="row">โซน</th>
                        <td>${data.zone_name}(${data.zone_detail})</td>
						</tr>
					<tr>
						<th scope="row">ประเภทสินค้า</th>
						<td> ${data.cat_name} (${data.sub_cat_name})</td>
					</tr>
					
					<tr>
						<th scope="row">สถานะการจอง</th>
						<td>${data.status}</td>
					</tr>	
                    <tr>
						<th scope="row">ประเภทการจอง</th>
						<td> ${data.booking_type_display}</td>
					</tr>	
                    <tr>
						<th scope="row">เลขล็อคที่ได้รับ</th>
						<td>  ${data.book_lock_number ? data.book_lock_number : 'ยังไม่ได้รับเลขล็อค'}</td>
					</tr>	
                    <tr>
						<th scope="row">วันที่จอง</th>
						<td> ${data.display_booking_date}</td>
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

        function confirmRefund(booking_id, booking_status) {
            Swal.fire({
                title: "คุณแน่ใจหรือไม่?",
                text: "คุณกำลังจะคืนเงินให้กับ " + booking_id + " น้า",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ใช่, ยืนยันการคืนเงิน!",
                cancelButtonText: "ยกเลิก"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (booking_status == 7) {
                        window.location.href = 'confirm_refund.php?booking_id=' + booking_id;
                    } else if (booking_status == 5) {
                        window.location.href = 'cancel_booking2.php?booking_id=' + booking_id;
                    }
                }
            });
        }
    </script>

</body>

</html>