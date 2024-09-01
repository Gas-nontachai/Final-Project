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
    <title>คำขอคืนเงิน</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
</head>

<body>

    <!-- เมนูนำทาง -->
    <?php include('./admin_nav.php'); ?>


    <!-- Display -->
    <div class="container my-4 p-2 border border-dark-subtle rounded overflow-auto" style="width: 90%; height: 40rem;">
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
                                    B.booking_id, 
                                    CONCAT(U.prefix, ' ', U.firstname, ' ', U.lastname) AS fullname, 
                                    B.booking_amount, 
                                    B.booking_status,
                                    B.total_price, 
                                    C.cat_name, 
                                    SC.sub_cat_name, 
                                    BS.status, 
                                    B.booking_type, 
                                    B.slip_img, 
                                    B.book_lock_number, 
                                    B.booking_date
                                FROM market_booking.booking AS B
                                LEFT JOIN booking_status AS BS ON B.booking_status = BS.id
                                LEFT JOIN tbl_user AS U ON B.member_id = U.user_id
                                LEFT JOIN category AS C ON B.product_type = C.id_category
                                LEFT JOIN sub_category AS SC ON B.sub_product_type = SC.idsub_category
                                WHERE booking_status = 7";
                        $result = mysqli_query($conn, $sql);
                        ?>
                        <div class="container">
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <ul class="list-group">
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span> <strong><?php echo $row['booking_id']; ?></strong> </span>
                                                    <span><?php echo $row['fullname']; ?></span>
                                                    <p>
                                                        <strong>
                                                            ยอดทั้งหมด <?php echo htmlspecialchars($row['total_price']); ?> บาท
                                                        </strong>
                                                    </p>
                                                </div>
                                                <div>
                                                    <div>
                                                        <span><?php echo $row['booking_date']; ?></span>
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
                                                            onclick="confirmRefund('<?php echo $row['booking_id']; ?>'); return false;">
                                                            ยืนยันการคืนเงิน
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
						<td> ${data.booking_amount} ล็อค}</td>
					</tr>	
                    <tr>
						<th scope="row">ราคารวม</th>
						<td> ${data.total_price} บาท</td>
					</tr>
					<tr>
						<th scope="row">โซน</th>
						<td>${data.zone_name} (${data.zone_detail})</td>
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
						<td> ${data.booking_type}</td>
					</tr>	
                    <tr>
						<th scope="row">เลขล็อคที่ได้รับ</th>
						<td>  ${data.book_lock_number ? data.book_lock_number : 'ยังไม่ได้รับเลขล็อค'}</td>
					</tr>	
                    <tr>
						<th scope="row">วันที่จอง</th>
						<td> ${data.booking_date}</td>
					</tr>	
					</tbody>
                    </table> `;
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

        function confirmRefund(booking_id) {
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
                    window.location.href = 'confirm_refund.php?booking_id=' + booking_id;
                }
            });
        }
    </script>

</body>

</html>