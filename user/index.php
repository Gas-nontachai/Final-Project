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
    <link rel="icon" type="image/x-icon" href="../asset/img/icon.market.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <div class="row ">
        <div class="col">
            <!-- Display -->
            <div class="container mt-4 bgcolor py-4 rounded">
                <div class="container-fluid ">
                    <div class="row d-flex justify-content-center align-item-center">
                        <div class="d-flex flex-column border border-dark rounded p-4 mb-3">
                            <div style="text-align: center;">
                                <span style="text-align: center;">
                                    <strong>
                                        <h3>สถานะตลาด</h3>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#uniqueImageModal">
                                            <i class="bi bi-map"></i>คลิ๊กที่นี่เพื่อเปิดแผนผังตลาด </a>
                                    </strong>
                                </span>
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
                                                            <div class="border rounded" style="text-align: center;">
                                                                <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px;">
                                                                    <button class="reserveButton rounded border-0" type="button" data-bs-toggle="modal" data-bs-target="#step1Modal">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                                                                            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                                                                        </svg>
                                                                    </button>
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
            <div class="container my-4 px-2 border rounded overflow-auto bgcolor py-4" style="width: 100%; height: 40rem;">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#categort"><strong>คำขอจองพื้นที่</strong></a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active mt-2 mx-2 p-2" id="categort">
                        <div>
                            <h1>คำขอจองพื้นที่</h1>
                        </div>
                        <div class="mt-2">
                            <div class="row overflow-auto">
                                <?php
                                $sql = "SELECT 
                                 BK.expiration_date, 
                                 BK.booking_date, 
                                 DATE_FORMAT(BK.booking_date, '%d/') AS day,
                                 CASE MONTH(BK.booking_date) 
                                     WHEN 1 THEN 'ม.ค.'
                                     WHEN 2 THEN 'ก.พ.'
                                     WHEN 3 THEN 'มี.ค.'
                                     WHEN 4 THEN 'เม.ย.'
                                     WHEN 5 THEN 'พ.ค.'
                                     WHEN 6 THEN 'มิ.ย.'
                                     WHEN 7 THEN 'ก.ค.'
                                     WHEN 8 THEN 'ส.ค.'
                                     WHEN 9 THEN 'ก.ย.'
                                     WHEN 10 THEN 'ต.ค.'
                                     WHEN 11 THEN 'พ.ย.'
                                     WHEN 12 THEN 'ธ.ค.'
                                 END AS month,
                                 DATE_FORMAT(BK.booking_date, '%Y %H:%i') AS year_time,
                                 DATE_FORMAT(BK.expiration_date, '%d/') AS exp_day,
                                 CASE MONTH(BK.expiration_date) 
                                     WHEN 1 THEN 'ม.ค.'
                                     WHEN 2 THEN 'ก.พ.'
                                     WHEN 3 THEN 'มี.ค.'
                                     WHEN 4 THEN 'เม.ย.'
                                     WHEN 5 THEN 'พ.ค.'
                                     WHEN 6 THEN 'มิ.ย.'
                                     WHEN 7 THEN 'ก.ค.'
                                     WHEN 8 THEN 'ส.ค.'
                                     WHEN 9 THEN 'ก.ย.'
                                     WHEN 10 THEN 'ต.ค.'
                                     WHEN 11 THEN 'พ.ย.'
                                     WHEN 12 THEN 'ธ.ค.'
                                 END AS exp_month,
                                 DATE_FORMAT(BK.expiration_date, '%Y %H:%i') AS exp_year_time,
                                 BK.total_price, 
                                 BK.booking_id, 
                                 CONCAT(U.prefix, U.firstname , ' ', U.lastname) AS fullname, 
                                 BS.status, 
                                 BK.booking_status, 
                                 ZD.zone_name, 
                                 ZD.zone_detail, 
                                 C.cat_name, 
                                 SC.sub_cat_name, 
                                 BK.booking_type, 
                                 BK.booking_amount, 
                                 BK.slip_img 
                             FROM booking AS BK 
                                INNER JOIN booking_status AS BS ON BK.booking_status = BS.id
                                INNER JOIN tbl_user AS U ON BK.member_id = U.user_id
                                INNER JOIN category AS C ON BK.product_type = C.id_category
                                INNER JOIN sub_category AS SC ON BK.sub_product_type = SC.idsub_category
                                INNER JOIN zone_detail AS ZD ON BK.zone_id = ZD.zone_id
                                WHERE member_id = $user_id
                                ORDER BY booking_id 
                           ";
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
                                                            <p>
                                                                <strong>
                                                                    สถานะ : <?php
                                                                            if ($row["booking_status"] === '4' || $row["booking_status"] === '8') {
                                                                                echo "<span style='color: #06D001;'>" . htmlspecialchars($row["status"]) . "</span>";
                                                                            } else if ($row["booking_status"] === '1' || $row["booking_status"] === '2' || $row["booking_status"] === '3' || $row["booking_status"] === '9') {
                                                                                echo "<span style='color: orange;'>" . htmlspecialchars($row["status"]) . "</span>";
                                                                            } else {
                                                                                echo "<span style='color: red ;'>" . htmlspecialchars($row["status"]) . "</span>";  // You can change 'green' to any other color or style you prefer
                                                                            }



                                                                            ?>
                                                                </strong>
                                                            </p>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-between align-items-end">
                                                            <div class="d-flex flex-column justify-content-center align-items-end">
                                                                <span>วันที่จอง : <?php
                                                                                    $yearTime = intval($row['year_time']); // แปลงให้เป็นตัวเลข
                                                                                    $formattedBookingDate = $row['day'] . $row['month'] . '/' . ($yearTime + 543) . ' เวลา ' . date('H:i', strtotime($row['booking_date']));
                                                                                    echo $formattedBookingDate;
                                                                                    ?></span>

                                                                <span>วันที่หมดอายุการจอง :
                                                                    <?php
                                                                    if ($row["booking_status"] === '4') {
                                                                        // แปลงปีเป็นปีไทย
                                                                        $expYear = intval(date('Y', strtotime($row['expiration_date']))) + 543;
                                                                        // แสดงผลในรูปแบบที่ต้องการ
                                                                        echo $row['exp_day'] . $row['exp_month'] . '/' . $expYear . ' เวลา ' . date('H:i', strtotime($row['expiration_date']));
                                                                    } else {
                                                                        echo "<span>คำขอยังไม่สมบูรณ์</span>";
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </div>
                                                            <div class="mt-1">

                                                                <?php switch ($row["booking_status"]) {
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
                                                                        echo " <td>
                                                                                <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                                                                </td>";
                                                                } ?>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </li>
                                            <?php endwhile; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p>ยังไม่มีคำขอจองพื้นที่ในตอนนี้</p>
                                        <button class="reserveButton btn btn-sm btn-success mx-2" type="button" id="reserveButton" data-bs-toggle="modal" data-bs-target="#step1Modal">
                                            จองพื้นที่การขาย
                                        </button> <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
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
                    <p style="color: red;"><strong>*กรุณาตรวจสอบให้แน่ใจว่าข้อมูลถูกต้องก่อนชำระเงิน*</strong></p>
                    <h3><strong>ช่องทางการชำระเงินสำหรับ booking id: <span id="payModalBookingId"></span></strong></h3>

                    <!-- ตัวเลือกช่องทางการชำระเงิน -->
                    <div class="mb-3">
                        <label><strong>เลือกช่องทางการชำระเงิน:</strong></label>
                        <div>
                            <input type="radio" name="paymentMethod" value="mobile" id="mobileBanking">
                            <label for="mobileBanking">Mobile Banking(บัญชีธนาคาร)</label>
                        </div>
                        <div>
                            <input type="radio" name="paymentMethod" value="token" id="tokenPayment">
                            <label for="tokenPayment">Token(เหรียญในระบบ)</label>
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
                            <p style="color: red;"><strong>*กรุณาอัพโหลดสลิป*</strong></p>
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

        document.addEventListener('DOMContentLoaded', function() {
            // เรียกใช้ฟังก์ชันตรวจสอบเวลาเมื่อโหลดหน้า
            checkTime();
            // อัปเดตสถานะทุกๆ 1 นาที
            setInterval(checkTime, 60000);
        });

        function disableReserveButtons() {
            var buttons = document.getElementsByClassName('reserveButton');
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].disabled = true;
                buttons[i].classList.add('disabled');
                buttons[i].setAttribute('title', 'ระบบยังไม่เปิดหรือปิดการจองแล้ว');
                if (!buttons[i]._tooltip) {
                    buttons[i]._tooltip = new bootstrap.Tooltip(buttons[i]);
                }
            }
        }

        function enableReserveButtons() {
            var buttons = document.getElementsByClassName('reserveButton');
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].disabled = false;
                buttons[i].classList.remove('disabled');
                buttons[i].removeAttribute('title');
                if (buttons[i]._tooltip) {
                    buttons[i]._tooltip.dispose();
                    buttons[i]._tooltip = null;
                }
            }
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
                    enableReserveButtons();
                } else {
                    disableReserveButtons();
                }
            } else {
                // ช่วงเวลาเปิด-ปิดในวันเดียวกัน เช่น 09:00:00 ถึง 18:00:00
                if (now >= openingDate && now <= closingDate) {
                    enableReserveButtons();
                } else {
                    disableReserveButtons();
                }
            }
        }
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
						<td>${data.display_booking_date}</td>
					</tr>	
					<tr>
						<th scope="row">วันที่คำขอหมดอายุ</th>
						<td> ${data.display_expiration_date ? data.display_expiration_date : 'คำขอยังไม่สมบูรณ์'}</td>
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
                    <strong style="font-size: 14px; color: red; display: block; text-align: center;">
                        *ล็อคที่ได้รับมอบหมายโดยผู้ดูแลระบบ ผู้ใช้ไม่สามารถจองล็อคใดๆ ได้*
                    </strong>


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
                                        <select name="zone" id="zone" class="form-select" onchange="avaliablelockcheck(); updatePrices();">
                                            <option value="#">กรุณาเลือกโซน</option>
                                            <?php
                                            $sql = "SELECT z.zone_id, z.zone_name, z.zone_detail, z.pricePerDate, z.pricePerMonth,
                SUM(CASE WHEN l.available = 0 THEN 1 ELSE 0 END) AS available_locks
            FROM zone_detail z
            INNER JOIN locks l ON z.zone_id = l.zone_id
            GROUP BY z.zone_id, z.zone_name, z.zone_detail, z.pricePerDate, z.pricePerMonth
            ORDER BY z.zone_name;";

                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    // Check if available_locks is 0 to disable the option
                                                    $disabled = ($row['available_locks'] == 0) ? 'disabled' : '';

                                                    // Set the style and text, either showing "โซนเต็ม" in red or the normal zone detail
                                                    $redStyle = ($row['available_locks'] == 0) ? 'color:red;' : '';
                                                    $text = ($row['available_locks'] == 0) ? ' - โซนเต็ม' : '';

                                                    // Echo the option, conditionally adding the disabled attribute, style, and dynamic text
                                                    echo '<option style="' . $redStyle . '" value="' . $row['zone_id'] . '" ' . $disabled . ' data-zone-name="' . $row['zone_name'] . '">'
                                                        . $row['zone_name'] . ' (' . $row['zone_detail'] . ')' . $text
                                                        . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No categories found</option>';
                                            }
                                            ?>
                                        </select>

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

                                            function avaliablelockcheck() {
                                                var zoneSelect = document.getElementById("zone");
                                                var selectedOption = zoneSelect.options[zoneSelect.selectedIndex];
                                                var zoneName = selectedOption.getAttribute('data-zone-name'); // เก็บ zone name

                                                var xhr = new XMLHttpRequest();
                                                xhr.open("POST", "fetch_lock_count.php", true); // ชื่อไฟล์ที่จัดการการประมวลผล
                                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                xhr.onreadystatechange = function() {
                                                    if (xhr.readyState == 4 && xhr.status == 200) {
                                                        var availableLocks = parseInt(xhr.responseText, 10) || 0; // แปลงค่าที่ส่งกลับจาก PHP เป็นจำนวนเต็ม
                                                        console.log("Available Locks: " + availableLocks);

                                                        // อัปเดต UI โดยแสดงจำนวนล็อคที่ว่าง
                                                        document.getElementById("availableLocksDisplay").innerText = "ล็อคที่ว่าง: " + availableLocks;

                                                    }
                                                };
                                                xhr.send("zone_name=" + encodeURIComponent(zoneName)); // ส่ง zone name
                                            }
                                        </script>

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
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#step2Modal" data-bs-dismiss="modal" onclick="updateProgressBar(66, 'ขั้นตอนที่ 2')">ถัดไป</button>
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
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#step1Modal" data-bs-dismiss="modal" onclick="updateProgressBar(33, 'ขั้นตอนที่ 1')">กลับ</button>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#step3Modal" data-bs-dismiss="modal" onclick="updateProgressBar(100, 'ขั้นตอนที่ 3')">ถัดไป</button>
                    </div>
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
                    <strong style="font-size: 14px; color: red; display: block; text-align: center;">
                        *หลังจากส่งคำของจองแล้ว กรุณาชำระเงินเพื่อดำเนินการให้เสร็จสิ้น*
                    </strong>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="col-sm-3">
                                    <strong style="font-size: 14px; color: red;" id="availableLocksDisplay">ล็อคที่ว่าง: 0</strong>
                                </td>
                            </tr>
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
                                    <strong id="TotalPrice">ราคาสุทธิ : ฿</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <script>
                        function updateTotalPrice() {
                            var amount = parseInt(document.getElementById("amount").value) || 0; // แปลงค่าจำนวนล็อคเป็นจำนวนเต็ม
                            var availableLocks = parseInt(document.getElementById("availableLocksDisplay").innerText.replace("ล็อคที่ว่าง: ", "")) || 0; // จำนวนล็อคที่ว่าง
                            var totalPrice = 0;

                            // ตรวจสอบว่า amount ไม่เกิน availableLocks
                            if (amount > availableLocks) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'คำเตือน',
                                    text: 'จำนวนล็อคที่กรอกเกินจำนวนที่ว่าง กรุณาลองอีกครั้ง',
                                    confirmButtonText: 'ตกลง'
                                });

                                document.getElementById("amount").value = availableLocks; // ปรับค่ากลับไปที่จำนวนล็อคที่ว่าง
                                amount = availableLocks; // ปรับ amount ให้เท่ากับ availableLocks
                            }

                            // คำนวณราคาสุทธิ
                            var typeReserve = document.getElementById("typeReserve").value;
                            if (typeReserve === "PerDay") {
                                totalPrice = amount * pricePerDay;
                            } else if (typeReserve === "PerMonth") {
                                totalPrice = amount * pricePerMonth;
                            }

                            // แสดงราคาสุทธิ
                            document.getElementById("TotalPrice").innerHTML = 'ราคาสุทธิ : ฿ ' + totalPrice.toFixed(2); // ใช้ toFixed(2) เพื่อแสดงราคาสองตำแหน่งทศนิยม
                        }

                        // เรียกใช้ updatePrices เมื่อต้องการอัปเดตจำนวนล็อค
                        document.getElementById("zone").addEventListener("change", updatePrices);
                    </script>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#step2Modal" data-bs-dismiss="modal" onclick="updateProgressBar(66, 'ขั้นตอนที่ 2')">กลับ</button>
                    <input class="btn btn-success" type="submit" name="submit" value="ยืนยันการจอง">
                    </form>
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

</html>