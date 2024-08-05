<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "../admin/login.php";</script>';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="row g-2">
        <!-- btn sidebar -->
        <div class="col-12 d-flex justify-content-between px-5 py-3">
            <div class="col-4">
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-window-sidebar" viewBox="0 0 16 16">
                        <path d="M2.5 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1 .5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                        <path d="M2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v2H1V3a1 1 0 0 1 1-1zM1 13V6h4v8H2a1 1 0 0 1-1-1m5 1V6h9v7a1 1 0 0 1-1 1z" />
                    </svg>
                </button>
                <!-- sidebar -->
                <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                    <div class="offcanvas-header">
                        <h3 class="offcanvas-title" id="offcanvasWithBothOptionsLabel"><strong>เมนูเพิ่มเติม</strong></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-flex flex-column mb-3 ">
                        <a href="#" type="button" class="btn btn-primary m-2">สถิติการจอง</a>
                        <a href="./view_member.php" type="button" class="btn btn-primary m-2">ดูรายชื่อสมาชิก</a>
                        <a href="./manage_cat.php" type="button" class="btn btn-primary m-2">จัดการประเภทสินค้า</a>
                    </div>
                </div>
                <a href="./crud_page.php" class="btn btn-success" type="button">
                    <strong>CRUD</strong>
                </a>
            </div>
            <!-- profile btn -->
            <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#ProfileModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                </svg>
            </button>
            <!-- Modal -->
            <div class="modal fade" id="ProfileModal" tabindex="-1" aria-labelledby="ProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="ProfileModalLabel"><strong>โปรไฟล์ผู้ใช้งาน</strong></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>UserID:</strong> <?php echo $user_id; ?></p>
                            <p><strong>Username:</strong> <?php echo $username; ?></p>
                            <p><strong>shop_name:</strong> <?php echo $shop_name; ?></p>
                            <p><strong>ชื่อ-นามสกุล:</strong> <?php echo $fullname; ?></p>
                            <p><strong>เบอร์โทรศัพท์:</strong> <?php echo $tel; ?></p>
                            <p><strong>อีเมล:</strong> <?php echo $email; ?></p>
                            <div class=" d-flex align-items-start">
                                <p><strong>ประเภทผู้ใช้งาน:</strong> <?php echo $userrole; ?></p>
                                <span class="question-icon mx-2" data-bs-toggle="tooltip" data-bs-placement="right" title="0 ผู้ใช้งานทั่วไป&lt;br&gt;1 แอดมิน/ผู้ดูแลระบบ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-question-fill" viewBox="0 0 16 16">
                                        <path d="M5.933.87a2.89 2.89 0 0 1 4.134 0l.622.638.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622-.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01zM7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0m1.602-2.027c.04-.534.198-.815.846-1.26.674-.475 1.05-1.09 1.05-1.986 0-1.325-.92-2.227-2.262-2.227-1.02 0-1.792.492-2.1 1.29A1.7 1.7 0 0 0 6 5.48c0 .393.203.64.545.64.272 0 .455-.147.564-.51.158-.592.525-.915 1.074-.915.61 0 1.03.446 1.03 1.084 0 .563-.208.885-.822 1.325-.619.433-.926.914-.926 1.64v.111c0 .428.208.745.585.745.336 0 .504-.24.554-.627" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="./logout.php" type="button" class="btn btn-danger">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- timer -->
        <div class="col-12 d-flex justify-content-between px-5">
            <strong>
                <div id="time"></div>
                <div id="#">(ระบบปิด)</div>
            </strong>
            <strong>
                <div id="#">ระบบเปิดเวลา : <a href="#">00:00:00</a></div>
            </strong>
        </div>

    </nav> 
    <!-- Display -->
    <div class="container mt-4">
        <div class="container ">
            <div class="row d-flex justify-content-center align-item-center">
                <div class="col-12 d-flex flex-wrap justify-content-center align-item-center">
                    <?php
                    $sql = "SELECT * FROM zone_detail";
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
                    <a href="./confirm_reserve.php" type="button" class="btn btn-success m-2">ตรวจสอบการชำระเงิน / ยืนยันการจอง / ยกเลิกการจอง</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
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
<script src="../asset/js/time_couter.js"></script>

</html>