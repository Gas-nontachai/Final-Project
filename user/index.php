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
    <!-- Nav -->
    <?php
    include('./user_nav.php');
    ?>

    <div class="row ">
        <div class="col">
            <!-- Display -->
            <div class="container mt-4 bgcolor py-4 rounded">
                <div class="container-fluid ">
                    <div class="row d-flex justify-content-center align-item-center">
                        <!-- BTN -->
                        <div class="row d-flex justify-content-center align-item-center">
                            <div class="col-12 d-flex justify-content-evenly px-3 pb-4">
                                <button class="btn btn-lg btn-success m-2 mt-3" type="button" id="reserveButton" data-bs-toggle="modal" data-bs-target="#step1Modal">
                                    จองพื้นที่การขาย
                                </button>
                            </div>

                        </div>
                        <div class="d-flex flex-column border border-dark rounded p-4 mb-3">
                            <div style="text-align: center;">
                                <strong>
                                    <h3>สถานะตลาด</h3>
                                </strong>
                            </div>
                            <div class="col-12 d-flex flex-wrap justify-content-center align-item-center">
                                <?php
                                $sql = "SELECT * FROM zone_detail ORDER BY zone_name";
                                if ($result = $conn->query($sql)) {
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $zone_id = $row["zone_id"];
                                            $sql_count = "SELECT COUNT(id_locks) AS total_locks, 
                                                                SUM(CASE WHEN available = 0 THEN 1 ELSE 0 END) AS available_locks 
                                                         FROM locks 
                                                         WHERE zone_id = $zone_id";
                                            $result_count = $conn->query($sql_count);
                                            $count_data = $result_count->fetch_assoc();
                                            $total_locks = $count_data['total_locks'];
                                            $available_locks = $count_data['available_locks'];

                                            $percentage_available = ($total_locks > 0) ? ($available_locks / $total_locks) * 100 : 0;

                                            $color = '';
                                            if ($percentage_available > 30) {
                                                $color = '<strong class="text-success border border-secondary border-2 px-2 mx-1 rounded">
                                                            ว่าง: ' . $available_locks . '/' . $total_locks . '
                                                        </strong>';  // สีเขียว
                                            } else if ($percentage_available <= 30) {
                                                $color = '<strong class="text-danger border border-secondary border-2 px-2 mx-1 rounded">
                                                            ว่าง: ' . $available_locks . '/' . $total_locks . '
                                                        </strong>';  // สีแดง
                                            }

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
                                                                            โซน: <strong>' . $row["zone_name"] . '</strong> (' . $row["zone_detail"] . ')' . $color . '
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
                                                     <div class="border rounded " style="text-align: center;">
                                                        <div class="bg-lightt rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                                                                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                                                            </svg>
                                                        </div>
                                                    </div>';
                                                        } else if ($row2["available"] == 1) {
                                                            echo '
                                                <div class="border rounded d-flex flex-column justify-content-center align-items-center" style="text-align: center;">
                                                        <div class="bg-primary rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px; color:white;" >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                                                                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                                                            </svg>
                                                        </div>
                                                    </div>';
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
                        </div>

                        <!--Avaliable--->
                        <div class="container-md d-flex justify-content-center p-2 m-2">
                            <div class="px-2 mx-2 d-flex justify-content-center align-items-center">
                                <div class="bg-lightt rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                                        <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                                    </svg>
                                </div>
                                <strong>ว่าง</strong>
                            </div>
                            <div class="px-2 mx-2 d-flex justify-content-center align-items-center">
                                <div class="bg-primary rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px; color:white;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class=" bi bi-shop" viewBox="0 0 16 16">
                                        <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                                    </svg>
                                </div>
                                <strong class="mx-1">ไม่ว่าง</strong>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col bgcolor">
            <!--Dispaly-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active mt-2 mx-2 p-2 " id="categort">
                    <div>
                        <h1>คำขอจองพื้นที่</h1>
                    </div>
                    <div class="mt-2 overflow-auto">
                        <?php
                        // Assuming you have a connection to your database in $conn
                        $sql = "SELECT BK.expiration_date, BK.total_price, BK.booking_id, CONCAT(U.prefix, U.firstname , ' ', U.lastname) AS fullname, BS.status, BK.booking_status, ZD.zone_name, ZD.zone_detail, C.cat_name, SC.sub_cat_name, BK.booking_type, BK.booking_amount, BK.slip_img, BK.booking_date 
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
                            <th>วันที่จอง</th>
                            <th>รายละเอียดโซน</th>
                            <th>จำนวน</th>
                            <th>สถานะ</th>
                            <th>วันหมดอายุคำจอง</th>
                            <th>การกระทำ</th>
                        </tr>
                    </thead>";
                            echo "<tbody>";

                            while ($row = $result->fetch_assoc()) {
                                $booking_date = date("เวลา H:i d/m/Y", strtotime($row["booking_date"]));
                                $slip_img = $row["slip_img"] ? "<img src='" . $row["slip_img"] . "' alt='Slip Image' style='width: 50px; height: auto;'>" : "ยังไม่มีการอัพโหลดสลิป";
                                if ($row["booking_type"] === 'PerDay') {
                                    $booking_type_display = 'รายวัน';
                                } elseif ($row["booking_type"] === 'PerMonth') {
                                    $booking_type_display = 'รายเดือน';
                                } else {
                                    $booking_type_display = 'ไม่ทราบประเภทการจอง';
                                }
                                echo "<tr>
                                        <td>" . htmlspecialchars($row["booking_id"]) . "</td>
                                        <td>" . $booking_date . "</td>
                                        <td>" . $booking_type_display   . " ( " . htmlspecialchars($row["zone_detail"]) . ")</td>
                                        <td>" . htmlspecialchars($row["booking_amount"]) . " ล็อค</td>
                            ";
                                if ($row["booking_status"] === '4' || $row["booking_status"] === '8') {
                                    echo "<td style='color: #06D001;'>" . htmlspecialchars($row["status"]) . "</td>";
                                } else if ($row["booking_status"] === '1' || $row["booking_status"] === '2' || $row["booking_status"] === '3' || $row["booking_status"] === '9') {
                                    echo "<td style='color: orange;'>" . htmlspecialchars($row["status"]) . "</td>";
                                } else {
                                    echo "<td style='color: red ;'>" . htmlspecialchars($row["status"]) . "</td>";  // You can change 'green' to any other color or style you prefer
                                }

                                if ($row["booking_status"] === '4') {
                                    echo "<td>" . htmlspecialchars($row["expiration_date"]) . "</td>";
                                } else {
                                    echo "<td>คำขอยังไม่สมบูรณ์</td>";
                                }
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
                                    case 10:
                                        echo " <td>
                                        <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
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
                            <label for="tokenInput" class="form-label"> <strong>คุณมีเหรียญ <span id="userToken"><?php echo htmlspecialchars($token); ?></span> เหรียญ</strong> </label>
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
            const userTokenSpan = document.getElementById('userToken');
            let userToken = parseInt(userTokenSpan.textContent, 10); // จำนวนเหรียญของผู้ใช้

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
    <?php
    $currentTime = date('H:i:s'); // เวลาปัจจุบัน

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

        // ฟังก์ชันแปลงเวลาเป็น Date object
        function timeStringToDate(timeString) {
            var today = new Date();
            var timeParts = timeString.split(':');
            return new Date(today.getFullYear(), today.getMonth(), today.getDate(), timeParts[0], timeParts[1], timeParts[2]);
        }

        // ฟังก์ชันตรวจสอบเวลา
        function checkTime() {
            var now = new Date();
            var openingDate = timeStringToDate(openingTime);
            var closingDate = timeStringToDate(closingTime);

            // ตรวจสอบว่าช่วงเวลาเปิด-ปิดข้ามวันหรือไม่
            if (closingDate <= openingDate) {
                // ช่วงเวลาเปิด-ปิดข้ามวัน เช่น 23:00:00 ถึง 05:00:00
                if (now >= openingDate || now <= closingDate) {
                    enableReserveButton(); // เปิดใช้งานปุ่มถ้าอยู่ในช่วงเวลาเปิด-ปิด
                } else {
                    disableReserveButton(); // ปิดใช้งานปุ่มถ้าอยู่นอกช่วงเวลาเปิด-ปิด
                }
            } else {
                // ช่วงเวลาเปิด-ปิดในวันเดียวกัน เช่น 09:00:00 ถึง 18:00:00
                if (now >= openingDate && now <= closingDate) {
                    enableReserveButton(); // เปิดใช้งานปุ่มถ้าอยู่ในช่วงเวลาเปิด-ปิด
                } else {
                    disableReserveButton(); // ปิดใช้งานปุ่มถ้าอยู่นอกช่วงเวลาเปิด-ปิด
                }
            }
        }

        // ปิดใช้งานปุ่มพร้อม tooltip
        function disableReserveButton() {
            var button = document.getElementById('reserveButton');
            if (button) {
                button.disabled = true;
                button.classList.add('disabled');
                button.setAttribute('title', 'ระบบยังไม่เปิดหรือปิดการจองแล้ว');
                if (!button._tooltip) { // ตรวจสอบว่ามี Tooltip อยู่หรือไม่
                    button._tooltip = new bootstrap.Tooltip(button); // ใช้ tooltip ของ Bootstrap
                }
            }
        }

        // เปิดใช้งานปุ่ม
        function enableReserveButton() {
            var button = document.getElementById('reserveButton');
            if (button) {
                button.disabled = false;
                button.classList.remove('disabled');
                button.removeAttribute('title');
                if (button._tooltip) {
                    button._tooltip.dispose(); // ลบ tooltip ที่ใช้งานอยู่
                    button._tooltip = null;
                }
            }
        }

        // เรียกใช้ฟังก์ชันตรวจสอบเวลาเมื่อโหลดหน้า
        checkTime();

        // อัปเดตสถานะทุกๆ 1 นาที (เพียงพอสำหรับการตรวจสอบเวลา)
        setInterval(checkTime, 60000);
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
				<table class="table table-striped">			
					<thead>
                        <div class="d-flex justify-content-center align-items-end">
                            <p>เลขล็อคที่ได้รับ :</p>
                            ${data.book_lock_number 
                                ? `<h4 class="mx-3 rounded py-2 px-4 bg-primary text-white">${data.book_lock_number}</h4>` 
                                : `<h4 class="mx-3 rounded py-2 px-4 bg-secondary text-white">ยังไม่ได้รับเลขล็อค</h4>`
                            }
                        </div>
                    </thead>
					<tbody>
                    <tr>
                    <th>หมายเลขการจอง</th>
						<td>${data.booking_id}</td>
                        </tr>
							<tr>
						<th scope="row">ชื่อ-สกุล</th>
						<td>${data.fullname}</td>
					</tr>
					<tr>
						<th scope="row">ชื่อโซน</th>
						<td>${data.zone_name} (${data.zone_detail})</td>
						</tr>
					<tr>
						<th scope="row">หมวดหมู่</th>
						<td> ${data.cat_name} (${data.sub_cat_name})</td>
					</tr>
					<tr>
						<th scope="row">ประเภทการจอง</th>
						<td> ${data.booking_type_display}</td>
					</tr>	
					<tr>
						<th scope="row">จำนวนการจอง</th>
						<td> ${data.booking_amount} ล็อค</td>
					</tr>	
					<tr>
						<th scope="row">รวม</th>
						<td> ${data.total_price} บาท</td>
					</tr>	
					<tr>
						<th scope="row">วันที่การจอง</th>
						<td>${data.booking_date}</td>
					</tr>	
					<tr>
						<th scope="row">วันที่คำขอหมดอายุ</th>
						<td> ${data.expiration_date ? data.expiration_date : 'คำขอยังไม่สมบูรณ์'}</td>
					</tr>	
						
					        `;
                            if (data.slip_img) {
                                content += `
                                <tr>
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



    <!-- Reserve Modal -->

    <!-- Step 1 Modal -->
    <div class="modal fade" id="step1Modal" tabindex="-1" aria-labelledby="ReserveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ReserveModalLabel"><strong>จองพื้นที่การขาย - ขั้นตอนที่ 1</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Progress Bar -->
                    <div class="progress mb-4">
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">ขั้นตอนที่ 1</div>
                    </div>

                    <form action="./reserve_order.php" method="post">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td><strong>ชื่อผู้จอง:</strong></td>
                                    <td><?php echo $fullname; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>ชื่อร้าน:</strong></td>
                                    <td><?php echo $shop_name; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>โซน:</strong></td>
                                    <td>
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
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong id="priceDisplay">
                                            ราคาต่อวัน: ฿ ราคาต่อเดือน: ฿
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#step2Modal" data-bs-dismiss="modal" onclick="updateProgressBar(66, 'ขั้นตอนที่ 2')">ถัดไป</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Step 2 Modal -->
    <div class="modal fade" id="step2Modal" tabindex="-1" aria-labelledby="ReserveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ReserveModalLabel"><strong>จองพื้นที่การขาย - ขั้นตอนที่ 2</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Progress Bar -->
                    <div class="progress mb-4">
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 66%;" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100">ขั้นตอนที่ 2</div>
                    </div>

                    <div class="mx-4 row">
                        <div class="col">
                            <img src="../asset/img/img.locks.png" alt="" style="width:  50%; height: 10rem;">
                            <label for="img"> รูปตัวอย่างล็อคปกติ</label>
                        </div>
                        <div class="col">
                            <img src="../asset/img/img.openbackcar.png" alt="" style="width:  10rem; height: 10rem;">
                            <label for="img"> รูปตัวอย่างล็อคเปิดท้าย</label>
                        </div>
                    </div>
                    <div class="mb-4 mt-2 row">
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
                        <strong style="color: red;">*กรุณาเลือกประเภทสินค้าให้สอดคล้องกับโซน*</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#step1Modal" data-bs-dismiss="modal" onclick="updateProgressBar(33, 'ขั้นตอนที่ 1')">กลับ</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#step3Modal" data-bs-dismiss="modal" onclick="updateProgressBar(100, 'ขั้นตอนที่ 3')">ถัดไป</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 3 Modal -->
    <div class="modal fade" id="step3Modal" tabindex="-1" aria-labelledby="ReserveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ReserveModalLabel"><strong>จองพื้นที่การขาย - ขั้นตอนที่ 3</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Progress Bar -->
                    <div class="progress mb-4">
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">ขั้นตอนที่ 3</div>
                    </div>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="col-sm-3">
                                    <strong>ประเภท:</strong>
                                </td>
                                <td class="col-sm-9">
                                    <select name="typeReserve" id="typeReserve" class="form-select" onchange="updateTotalPrice()">
                                        <option value="PerDay">รายวัน</option>
                                        <option value="PerMonth">รายเดือน</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-sm-3">
                                    <strong>จำนวน(ล็อค):</strong>
                                </td>
                                <td class="col-sm-9">
                                    <input type="number" class="form-control" name="amount" min="1" id="amount" oninput="updateTotalPrice()" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <strong id="TotalPrice">
                                        ราคาสุทธิ : ฿
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#step2Modal" data-bs-dismiss="modal" onclick="updateProgressBar(66, 'ขั้นตอนที่ 2')">กลับ</button>
                    <input class="btn btn-success" type="submit" name="submit" value="ยืนยันการจอง">
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- JavaScript -->
    <script>
        function updateProgressBar(value, stepText) {
            document.getElementById('progressBar').style.width = value + '%';
            document.getElementById('progressBar').setAttribute('aria-valuenow', value);
            document.getElementById('progressBar').textContent = stepText;
        }
    </script>
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