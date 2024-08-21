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
        <link rel="stylesheet" href="../asset/css/font.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "กรุณาล็อคอินก่อน",
                    icon: "error",
                    timer: 2000,
                    timerProgressBar: true, // แสดงแถบความก้าวหน้า
                    showConfirmButton: false // ซ่อนปุ่ม "OK"
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zone_id'])) {
    $zoneId = $_POST['zone_id'];
    $sql = "SELECT pricePerDate, pricePerMonth FROM zone_detail WHERE zone_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $zoneId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(array(
            "pricePerDate" => $row['pricePerDate'],
            "pricePerMonth" => $row['pricePerMonth']
        ));
    } else {
        echo json_encode(array(
            "pricePerDate" => "N/A",
            "pricePerMonth" => "N/A"
        ));
    }
    exit; // Ensure no further output is sent 
}

if (isset($_GET['category_id'])) {
    $categoryId = intval($_GET['category_id']);
    $sql = "SELECT * FROM sub_category WHERE id_category = $categoryId";
    $result = $conn->query($sql);

    $subcategories = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subcategories[] = $row;
        }
    }
    echo json_encode($subcategories);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแรก</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">

</head>

<body>
    <!-- Nav -->
    <?php
    include('./user_nav.php');
    ?>
    <div class="row">
        <div class="col">
            <!-- Display -->
            <div class="container mt-4">
                <div class="container-fluid ">
                    <div class="row d-flex justify-content-center align-item-center">
                        <div class="col-12 d-flex flex-wrap justify-content-center align-item-center">
                            <?php
                            $sql = "SELECT * FROM zone_detail ORDER BY zone_name";
                            if ($result = $conn->query($sql)) {
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '
                                    <div class="">
                                       <div class="row ">
                                            <div class="col">
                                                <div class="d-flex justify-content-start">
                                                        <div class="">
                                                        <p class="zone_detail" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="right" 
                                                            title="รายวัน ' . $row["pricePerDate"] . '฿<br>รายเดือน ' . $row["pricePerMonth"] . '฿">
                                                            โซน: <strong>' . $row["zone_name"] . '</strong><br>(' . $row["zone_detail"] . ')
                                                        </p>
                                                        </div>
                                                </div>
                                        </div>
                                    </div>
                                    ';
                                        $sql2 = "SELECT * FROM locks WHERE zone_id = " . $row["zone_id"];
                                        if ($result2 = $conn->query($sql2)) {
                                            if ($result2->num_rows > 0) {
                                                echo '<div class="d-flex flex-wrap container-md">';
                                                while ($row2 = $result2->fetch_assoc()) {
                                                    echo '<div class="mx-2">';
                                                    echo '<p>';
                                                    if ($row2["available"] == 0) {
                                                        echo '
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                    </svg>';
                                                    } else if ($row2["available"] == 1) {
                                                        echo '
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
                                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2z"/>
                                                </svg>';
                                                    }
                                                    echo '</p>';
                                                    echo '</div>';
                                                }
                                                echo '</div>';
                                            } else {
                                                echo "<p>ยังไม่มีการสร้างข้อมูลพื้นที่การขาย</p>";
                                            }
                                            $result2->free();
                                        } else {
                                            echo "<p>Error in nested query: " . $conn->error . "</p>";
                                        }
                                    }
                                } else {
                                    echo "<p><strong>ยังไม่มีการสร้างข้อมูลพื้นที่การขาย</strong></p>";
                                }
                                $result->free();
                            } else {
                                echo "<p>Error in main query: " . $conn->error . "</p>";
                            }
                            ?>
                        </div>
                        <!--Avaliable--->
                        <div class="container-md d-flex justify-content-center p-2 m-2">
                            <div class="px-2 mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                </svg>
                                <strong>ว่าง</strong>
                            </div>
                            <div class="px-2 mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2z" />
                                </svg>
                                <strong>ไม่ว่าง</strong>
                            </div>
                        </div>
                        <!-- BTN -->
                        <div class="col-12 d-flex justify-content-evenly px-3">
                            <button class="btn btn-success m-2" type="button" id="reserveButton" data-bs-toggle="modal" data-bs-target="#ReserveModal">
                                จองพื้นที่การขาย
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <!--Dispaly-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active mt-2 mx-2 p-2 border" id="categort">
                    <div>
                        <h1>คำขอจองพื้นที่</h1>
                    </div>
                    <div class="mt-2">
                        <?php
                        // Assuming you have a connection to your database in $conn
                        $sql = "SELECT BK.total_price, BK.booking_id, CONCAT(U.prefix, U.firstname , ' ', U.lastname) AS fullname, BS.status, BK.booking_status, ZD.zone_name, ZD.zone_detail, C.cat_name, SC.sub_cat_name, BK.booking_type, BK.booking_amount, BK.slip_img, BK.booking_date 
                                FROM booking AS BK 
                                INNER JOIN booking_status AS BS ON BK.booking_status = BS.id
                                INNER JOIN tbl_user AS U ON BK.member_id = U.user_id
                                INNER JOIN category AS C ON BK.product_type = C.id_category
                                INNER JOIN sub_category AS SC ON BK.sub_product_type = SC.idsub_category
                                INNER JOIN zone_detail AS ZD ON BK.zone_id = ZD.zone_id
                                WHERE member_id = $user_id
                                ORDER BY booking_id 
                            ";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table class='table table-striped'>";
                            echo "<thead>
                        <tr>
                            <th>รหัสการจอง</th>
                            <th>รายละเอียดโซน</th>
                            <th>หมวดหมู่</th>
                            <th>ประเภทการจอง</th>
                            <th>จำนวนการจอง</th>
                            <th>สถานะ</th>
                            <th>วันที่จอง</th>
                            <th>การกระทำ</th>
                        </tr>
                    </thead>";
                            echo "<tbody>";

                            while ($row = $result->fetch_assoc()) {
                                $booking_date = date("เวลา H:i d/m/Y", strtotime($row["booking_date"]));
                                $slip_img = $row["slip_img"] ? "<img src='" . $row["slip_img"] . "' alt='Slip Image' style='width: 50px; height: auto;'>" : "ยังไม่มีการอัพโหลดสลิป";

                                echo "<tr>
                            <td>" . htmlspecialchars($row["booking_id"]) . "</td>
                                                                <td>" . htmlspecialchars($row["zone_detail"]) . "</td>
                                                                <td>" . htmlspecialchars($row["cat_name"]) . "(" . htmlspecialchars($row["sub_cat_name"]) . ")</td>
                                                                <td>" . htmlspecialchars($row["booking_type"]) . "</td>
                                                                <td>" . htmlspecialchars($row["booking_amount"]) . " ล็อค</td>
                                                                <td style='color: red;'>" . htmlspecialchars($row["status"]) . "</td>
                                                                
                            <td>" . $booking_date  . "</td>
                            ";
                                switch ($row["booking_status"]) {
                                    case 1:
                                        echo "<td>
                                                <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                                <button class='btn btn-success m-2' type='button' data-bs-toggle='modal' data-bs-target='#PayModal' data-id='" . $row["booking_id"] . "' data-total-price='" . $row["total_price"] . "'>ชำระเงิน</button>
                                                <a href='#' class='btn btn-sm btn-danger' onclick=\"confirmCancel('" . addslashes($row['booking_id']) . "'); return false;\">ยกเลิกการจอง</a>
                                            </td>
                                            ";
                                        break;
                                    case 2:
                                        echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    <a href='#' class='btn btn-sm btn-danger' onclick=\"confirmRefund('" . addslashes($row['booking_id']) . "'); return false;\">ยกเลิกการจอง/ขอเงินคืน</a>
                                    </td>";
                                        break;
                                    case 3:
                                        echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    <a href='#' class='btn btn-sm btn-danger' onclick=\"confirmCancel('" . addslashes($row['booking_id']) . "'); return false;\">ยกเลิกการจอง</a>
                                    </td>";
                                        break;
                                    case 4:
                                        echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    </td>";
                                        break;
                                    case 5:
                                        echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    </td>";
                                        break;
                                    case 6:
                                        echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    </td>";
                                        break;
                                    case 7:
                                        echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    </td>";
                                        break;
                                    case 9:
                                        echo " <td>
                                        <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                        <a href='#' class='btn btn-sm btn-danger' onclick=\"confirmCancel('" . addslashes($row['booking_id']) . "'); return false;\">ยกเลิกการจอง</a>
                                        </td>";
                                        break;
                                    default:
                                        echo "ไม่ทราบสถานะ";
                                }
                                echo " </tr>";
                            }

                            echo "</tbody></table>";
                        } else {
                            echo "ยังไม่ได้มีการจอง";
                        }
                        ?>
                    </div>
                </div>
                <script>
                    function confirmCancel(booking_id) {
                        Swal.fire({
                            title: "คุณแน่ใจหรือไม่?",
                            text: "คุณกำลังจะยกเลิกการจองน้า",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "ใช่, ยกเลิก!",
                            cancelButtonText: "ยกเลิก"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // หากผู้ใช้ยืนยันการยกเลิก, รีไดเร็กต์ไปยัง cancel_booking.php พร้อม booking_id
                                window.location.href = 'cancel_booking.php?booking_id=' + booking_id;
                            }
                        });
                    }

                    function confirmRefund(booking_id) {
                        Swal.fire({
                            title: "คุณแน่ใจหรือไม่?",
                            text: "คุณกำลังจะยกเลิกการจองน้า",
                            text: "เงินที่คุณจะได้ จะได้รับเป็นเหรียญในระบบ หากต้องการเงินคืนให้ติดต่อที่สำนักงาน",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "ใช่, ยกเลิก!",
                            cancelButtonText: "ยกเลิก"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // หากผู้ใช้ยืนยันการยกเลิก, รีไดเร็กต์ไปยัง cancel_booking.php พร้อม booking_id
                                window.location.href = 'refund_booking.php?booking_id=' + booking_id;
                            }
                        });
                    }
                </script>


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

    <!-- Pay Modal -->
    <!-- Pay Modal -->
    <div class="modal fade" id="PayModal" tabindex="-1" aria-labelledby="PayModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="PayModalLabel"><strong>ชำระเงิน</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color: red;"><strong>*กรุณาตรวจสอบให้แน่ใจว่าข้อมูลถูกต้อง*</strong></p>
                    <h3><strong>ช่องทางการชำระเงินสำหรับ booking id: <span id="payModalBookingId"></span></strong></h3>

                    <!-- ตัวเลือกช่องทางการชำระเงิน -->
                    <div class="mb-3">
                        <label><strong>เลือกช่องทางการชำระเงิน:</strong></label>
                        <div>
                            <input type="radio" name="paymentMethod" value="mobile" id="mobileBanking">
                            <label for="mobileBanking">Mobile Banking</label>
                        </div>
                        <div>
                            <input type="radio" name="paymentMethod" value="token" id="tokenPayment">
                            <label for="tokenPayment">Token</label>
                        </div>
                    </div>

                    <!-- ฟอร์มการชำระเงิน -->
                    <form id="paymentForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="hiddenBookingId" name="booking_id">
                        <input type="hidden" id="hiddentotal_price" name="total_price">

                        <!-- ส่วน Mobile Banking -->
                        <div id="mobileBankingForm">
                            <p><strong>ชื่อบัญชี: บ.จองล็อค ไม่จำกัด ธนาคาร XXXXXXXXX</strong></p>
                            <p><strong>หมายเลขบัญชี: 1212312121</strong></p>
                            <div class="mt-3 border border-round p-2">
                                <label for="formFile" class="form-label">อัปโหลดรูปภาพหลักฐานการชำระเงิน</label>
                                <input class="form-control" type="file" id="formFile" name="receipt" required>
                            </div>
                        </div>

                        <!-- ส่วน Token Payment -->
                        <div id="tokenPaymentForm" style="display: none;">
                            <label for="tokenInput" class="form-label"> <strong>คุณมีเหรียญ <?php echo htmlspecialchars($token); ?> เหรียญ</strong> </label>
                            <br>
                            <label for="tokenInput" class="form-label"> <strong>ต้องใช้ทั้งหมด <span id="payModaltotalprice"></span> เหรียญ</strong> </label>
                            <p id="tokenWarning" style="color: red; display: none;">เหรียญของคุณไม่เพียงพอ</p>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary mt-3" id="payButton">ชำระเงิน</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileBankingForm = document.getElementById('mobileBankingForm');
            const tokenPaymentForm = document.getElementById('tokenPaymentForm');
            const payModal = document.getElementById('PayModal');
            const payButton = document.getElementById('payButton');
            const tokenWarning = document.getElementById('tokenWarning');
            const userToken = <?php echo json_encode($token); ?>; // จำนวนเหรียญของผู้ใช้

            function updateModalData(bookingId, totalPrice) {
                document.getElementById('payModalBookingId').textContent = bookingId;
                document.getElementById('hiddenBookingId').value = bookingId;
                document.getElementById('hiddentotal_price').value = totalPrice;
                document.getElementById('payModaltotalprice').textContent = totalPrice;
            }

            function handlePaymentMethodChange() {
                const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value;
                if (paymentMethod === 'mobile') {
                    mobileBankingForm.style.display = 'block';
                    tokenPaymentForm.style.display = 'none';
                    payButton.disabled = false;
                    document.getElementById('paymentForm').setAttribute('action', 'upload_slip.php');
                } else if (paymentMethod === 'token') {
                    mobileBankingForm.style.display = 'none';
                    tokenPaymentForm.style.display = 'block';

                    const totalPrice = parseInt(document.getElementById('payModaltotalprice').textContent, 10);
                    if (userToken < totalPrice) {
                        tokenWarning.style.display = 'block';
                        payButton.disabled = true;
                    } else {
                        tokenWarning.style.display = 'none';
                        payButton.disabled = false;
                    }
                    document.getElementById('paymentForm').setAttribute('action', 'token_pay.php');
                }
            }

            payModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const bookingId = button.getAttribute('data-id');
                const totalPrice = button.getAttribute('data-total-price');
                updateModalData(bookingId, totalPrice);

                // Reset the radio buttons and forms
                document.querySelectorAll('input[name="paymentMethod"]').forEach(input => input.checked = false);
                mobileBankingForm.style.display = 'none';
                tokenPaymentForm.style.display = 'none';
                payButton.disabled = false;
            });

            document.querySelectorAll('input[name="paymentMethod"]').forEach(function(input) {
                input.addEventListener('change', handlePaymentMethodChange);
            });

            payButton.addEventListener('click', function(event) {
                const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value;
                if (paymentMethod === 'token' && payButton.disabled) {
                    event.preventDefault(); // Prevent form submission if tokens are insufficient

                    Swal.fire({
                        title: 'ข้อผิดพลาด',
                        text: 'เหรียญของคุณไม่เพียงพอสำหรับการชำระเงิน',
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    });
                } else if (paymentMethod === 'token') {
                    Swal.fire({
                        title: 'ยืนยันการชำระเงิน',
                        text: 'คุณแน่ใจหรือไม่ว่าต้องการใช้เหรียญจำนวนนี้เพื่อชำระเงิน?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'ใช่, ชำระเงิน',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var form = document.getElementById('paymentForm');
                            var formData = new FormData(form);

                            fetch('token_pay.php', {
                                    method: 'POST',
                                    body: formData
                                }).then(response => response.text())
                                .then(data => {
                                    document.open();
                                    document.write(data);
                                    document.close();
                                }).catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('ข้อผิดพลาด', 'เกิดข้อผิดพลาดในการส่งข้อมูล', 'error');
                                });
                        }
                    });
                }
            });
        });
    </script>


    <?php $currentTime = date('H:i:s'); // เวลาปัจจุบัน
    // ดึงข้อมูลจาก database
    $sql_time = "SELECT opening_time, closing_time FROM operating_hours LIMIT 1";
    $result = $conn->query($sql_time);
    $row_time = $result->fetch_assoc();

    $openingTime = $row_time['opening_time'];
    $closingTime = $row_time['closing_time'];
    ?>
    <script>
        // เวลาเปิดและปิดจาก PHP
        var openingTime = "<?php echo $openingTime; ?>"; // เวลาเปิด เช่น "09:00:00"
        var closingTime = "<?php echo $closingTime; ?>"; // เวลาปิด เช่น "18:00:00"

        // ฟังก์ชันตรวจสอบเวลา
        function checkTime() {
            var now = new Date();
            var currentTime = now.toTimeString().split(' ')[0];

            if (currentTime < openingTime || currentTime > closingTime) {
                disableReserveButton(); // ปิดใช้งานปุ่มถ้ายังไม่ถึงเวลาหรือเกินเวลา
            } else {
                enableReserveButton(); // เปิดใช้งานปุ่มถ้าอยู่ในช่วงเวลาเปิด-ปิด
            }
        }

        // ปิดใช้งานปุ่มพร้อม tooltip
        function disableReserveButton() {
            var button = document.getElementById('reserveButton');
            button.disabled = true;
            button.classList.add('disabled');
            button.setAttribute('title', 'ระบบยังไม่เปิดหรือปิดการจองแล้ว');
            var tooltip = new bootstrap.Tooltip(button); // ใช้ tooltip ของ Bootstrap
        }

        // เปิดใช้งานปุ่ม
        function enableReserveButton() {
            var button = document.getElementById('reserveButton');
            button.disabled = false;
            button.classList.remove('disabled');
            button.removeAttribute('title');
        }

        // เรียกใช้ฟังก์ชันตรวจสอบเวลาเมื่อโหลดหน้า
        checkTime();

        // อัปเดตสถานะทุกๆ 1 วินาที (ถ้าต้องการตรวจสอบเวลาตลอดเวลา)
        setInterval(checkTime, 1000);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const bookingId = this.getAttribute('data-id');
                    const targetModal = this.getAttribute('data-bs-target');

                    if (targetModal === '#viewBookingModal') {
                        fetchBookingDetails(bookingId);
                    }
                });
            });

            function fetchBookingDetails(bookingId) {
                fetch('fetch_booking_details.php', {
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
                                                    <p><strong>ผู้จอง:</strong> ${data.fullname}</p>
                                                    <p><strong>ชื่อโซน:</strong> ${data.zone_name}</p>
                                                    <p><strong>รายละเอียดโซน:</strong> ${data.zone_detail}</p>
                                                    <p><strong>หมวดหมู่:</strong> ${data.cat_name}(${data.sub_cat_name})</p>
                                                    <p><strong>ประเภทการจอง:</strong> ${data.booking_type}</p>
                                                    <p><strong>จำนวนการจอง:</strong> ${data.booking_amount}</p>
                                                    <p><strong>รวม:</strong> ${data.total_price} บาท</p>
                                                    <p><strong>สถานะ:</strong> ${data.status}</p>
                                                    <p><strong>วันที่การจอง:</strong> ${data.booking_date}</p>
                                                    <p><strong>เลขล็อคที่ได้รับ:</strong> ${data.book_lock_number}</p> `;
                            if (data.slip_img) {
                                content += `<img src="../asset./slip_img/${data.slip_img}" alt="ภาพใบเสร็จ" class="img-fluid">`;
                            } else if (data.booking_status === 2) {
                                content += `<button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#PayModal' data-id='${data.booking_id}'>ชำระเงิน</button>`;

                            } else {}
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




    <!-- Reserve Modal -->
    <div class="modal fade" id="ReserveModal" tabindex="-1" aria-labelledby="ReserveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ReserveModalLabel"><strong>จองพื้นที่การขาย</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>จองพื้นที่การขาย</h3>
                    <form action="./reserve_order.php" method="post">
                        <div class="mb-3 row">
                            <label for="fullname" class="col-sm-3 col-form-label">
                                <strong>ชื่อผู้จอง :</strong>
                            </label>
                            <div class="col-sm-9">
                                <p><strong><?php echo $fullname; ?></strong></p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="shop_name" class="col-sm-3 col-form-label">
                                <strong>ชื่อร้าน :</strong>
                            </label>
                            <div class="col-sm-9">
                                <p><strong><?php echo $shop_name; ?></strong></p>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="category" class="col-sm-3 col-form-label">
                                <strong>ประเภทสินค้า :</strong>
                            </label>
                            <div class="col-sm-4">
                                <select name="category" id="category" class="form-select">
                                    <option value="#">กรุณาเลือกประเภทสินค้า</option>
                                    <?php
                                    $sql = "SELECT * FROM category";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['id_category'] . '">' . $row['cat_name'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No categories found</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select name="subcategory" id="subcategory" class="form-select">
                                    <option value="#">กรุณาเลือกสินค้าที่จะขาย</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="zone" class="col-sm-3 col-form-label">
                                <strong>โซน :</strong>
                            </label>
                            <div class="col-sm-9">
                                <select name="zone" id="zone" class="form-select" onchange="updatePrices()">
                                    <option value="#">กรุณาเลือกโซน</option>
                                    <?php
                                    $sql = "SELECT * FROM zone_detail ORDER BY zone_name";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['zone_id'] . '">' . $row['zone_name'] . ' (' . $row['zone_detail'] . ')' . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">No categories found</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <strong id="priceDisplay">
                                    ราคาต่อวัน: ฿ ราคาต่อเดือน: ฿
                                </strong>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="typeReserve" class="col-sm-3 col-form-label">
                                <strong>จำนวน :</strong>
                            </label>
                            <div class="col-sm-9">
                                <select name="typeReserve" id="typeReserve" class="form-select" onchange="updateTotalPrice()">
                                    <option value="PerDay">รายวัน</option>
                                    <option value="PerMonth">รายเดือน</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="amount" class="col-sm-3 col-form-label">
                                <strong>จำนวน :</strong>
                            </label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="amount" id="amount" oninput="updateTotalPrice()" required>
                            </div>
                            <div class="col-sm-12">
                                <strong id="TotalPrice">
                                    ราคาสุทธิ : ฿
                                </strong>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <input class="btn btn-success" type="submit" name="submit" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
    document.getElementById('category').addEventListener('change', function() {
        var categoryId = this.value;
        var subCategoryDropdown = document.getElementById('subcategory');

        // Clear the subcategory dropdown
        subCategoryDropdown.innerHTML = '<option value="#">กรุณาเลือกสินค้าที่จะขาย</option>';

        if (categoryId) {
            fetch(window.location.href + '?category_id=' + categoryId)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(subcategory => {
                            var option = document.createElement('option');
                            option.value = subcategory.idsub_category;
                            option.text = subcategory.sub_cat_name;
                            subCategoryDropdown.add(option);
                        });
                    } else {
                        var option = document.createElement('option');
                        option.value = '';
                        option.text = 'No sub-categories found';
                        subCategoryDropdown.add(option);
                    }
                })
                .catch(error => console.error('Error fetching subcategories:', error));
        }
    });
</script>
<script>
    var pricePerDay = 0;
    var pricePerMonth = 0;

    function updatePrices() {
        var zoneId = document.getElementById("zone").value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var prices = JSON.parse(xhr.responseText);
                pricePerDay = prices.pricePerDate;
                pricePerMonth = prices.pricePerMonth;
                document.getElementById("priceDisplay").innerHTML =
                    'ราคาต่อวัน: ' + pricePerDay + '฿ ราคาต่อเดือน: ' + pricePerMonth + '฿';
                updateTotalPrice(); // Update total price whenever prices are updated
            }
        };
        xhr.send("zone_id=" + zoneId);
    }

    function updateTotalPrice() {
        var amount = document.getElementById("amount").value;
        var typeReserve = document.getElementById("typeReserve").value;
        var totalPrice = 0;

        if (typeReserve === "PerDay") {
            totalPrice = amount * pricePerDay;
        } else if (typeReserve === "PerMonth") {
            totalPrice = amount * pricePerMonth;
        }

        document.getElementById("TotalPrice").innerHTML = 'ราคาสุทธิ : ' + totalPrice + '฿';
    }

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('.question-icon'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            html: true
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('.zone_detail'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            html: true
        });
    });
</script>

</html>