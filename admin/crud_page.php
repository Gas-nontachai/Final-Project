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
            <link rel="icon" type="image/x-icon" href="../asset/img/icon.market.png">
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการพื้นที่การขาย</title>
    <link rel="icon" type="image/x-icon" href="../asset/img/icon.market.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    include('./admin_nav.php');
    ?>

    <!-- Display -->
    <div class="container mt-4 bgcolor py-4 rounded">
        <div class="">
            <a href="#" data-bs-toggle="modal" data-bs-target="#uniqueImageModal">
                <i class="bi bi-map"></i>คลิ๊กที่นี่เพื่อเปิดแผนผังตลาด
            </a> <a href="#" data-bs-toggle="modal" data-bs-target="#changeMapsModal">
                <i class="bi bi-geo-alt"></i> เปลี่ยนรูปแผนผังตลาด
            </a>
            </a> <a href="#" data-bs-toggle="modal" data-bs-target="#changeBannerModal">
                <i class="bi bi-paint-bucket"></i> เปลี่ยนรูปหน้าเว็บตลาด
            </a>
        </div>
        <div class="container">
            <div class=" row d-flex justify-content-center align-item-center">
                <div class="col-12 d-flex flex-wrap justify-content-center align-item-center">
                    <?php
                    $sql = "SELECT * FROM zone_detail ORDER BY zone_name";
                    if ($result = $conn->query($sql)) {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Get the count of locks for the current zone
                                $sql2 = "SELECT COUNT(*) as count FROM locks WHERE zone_id = " . $row["zone_id"];
                                $lockCountResult = $conn->query($sql2);
                                $lockCountRow = $lockCountResult->fetch_assoc();
                                $lockCount = $lockCountRow['count'];
                                $lockCountResult->free();

                                echo '
                <div class="mt-2 ">
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
                                    <div class="">
                                        <button class="btn btn-sm mx-2 btn-warning edit-btn" 
                                            type="button" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#EditModal" 
                                            data-bs-id="' . $row['zone_id'] . '" 
                                            data-bs-name="' . $row['zone_name'] . '"
                                            data-bs-detail="' . $row['zone_detail'] . '"
                                            data-bs-date="' . $row['pricePerDate'] . '"
                                            data-bs-month="' . $row['pricePerMonth'] . '"
                                            data-bs-amount="' . $lockCount . '">
                                        แก้ไขรายละเอียด</button>                                             
                                    <a href="#" class="btn btn-sm btn-danger" 
                                        onclick="confirmDelete(\'' . $row['zone_id'] . '\', \'' . addslashes($row['zone_name']) . '\'); return false;">
                                        ลบโซน
                                        </a>
                                    </div>
                            </div>
                    </div>
                </div>
                ';

                                $sql3 = "SELECT * FROM locks WHERE zone_id = " . $row["zone_id"];
                                if ($result3 = $conn->query($sql3)) {
                                    if ($result3->num_rows > 0) {
                                        echo '<div class="d-flex flex-wrap container-md">';
                                        while ($row3 = $result3->fetch_assoc()) {
                                            echo '<div class="mx-2 ">
                                    <p>';
                                            if ($row3["available"] == 0) {
                                                echo '
                                <div class="border rounded " style="text-align: center;">
                                                        <div class="bg-lightt rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                                                                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                                                            </svg>
                                                        </div>
                                                    </div>';
                                            } else if ($row3["available"] == 1) {
                                                echo '
                            <div class="border rounded d-flex flex-column justify-content-center align-items-center" style="text-align: center;">
                                                        <div class="bg-secondary rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px; color:white;" >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                                                                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                                                            </svg>
                                                        </div>
                                                    </div>';
                                            }
                                            echo '</p>
                                </div>';
                                        }
                                        echo '</div>';
                                    } else {
                                        echo "<p>ยังไม่มีการสร้างข้อมูลพื้นที่การขาย</p>";
                                    }
                                    $result3->free();
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

                    <script>
                        function confirmDelete(zoneId, zoneName) {
                            Swal.fire({
                                title: "คุณแน่ใจหรือไม่?",
                                text: "คุณกำลังจะลบโซน " + zoneName + " น้า",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "ใช่, ลบเลย!",
                                cancelButtonText: "ยกเลิก"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // หากผู้ใช้ยืนยันการลบ, รีไดเร็กต์ไปยัง delete_zone.php พร้อม zone_id
                                    window.location.href = 'delete_zone.php?zone_id=' + zoneId;
                                }
                            });
                        }
                    </script>


                </div>
                <!-- BTN -->
                <div class="col-12 d-flex justify-content-evenly px-3">
                    <button class="btn btn-success m-2" type="button" data-bs-toggle="modal" data-bs-target="#AddZoneModal">
                        เพิ่มโซน(พื้นที่การขาย)
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Fetch the current map image from the database
    require("../condb.php");
    $sql = "SELECT map_image FROM market_maps WHERE idmarket_maps = 1"; // Adjust the WHERE clause as necessary
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $currentMap = isset($row['map_image']) ? $row['map_image'] : 'default_map.jpg'; // Fallback image if none found
    $conn->close();
    ?>

    <!-- Change Maps Modal -->
    <div class="modal fade" id="changeMapsModal" tabindex="-1" aria-labelledby="changeMapsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeMapsModalLabel">เปลี่ยนรูปแผนผังตลาด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Current Image Display -->
                    <div class="mb-3">
                        <label for="currentMap" class="form-label">แผนผังตลาดปัจจุบัน</label>
                        <div>
                            <img id="currentMapImg" src="../asset/maps/<?php echo $currentMap; ?>" alt="แผนผังตลาดปัจจุบัน" style="width:100%; max-height:300px; object-fit:cover;">
                        </div>
                    </div>

                    <!-- Form for uploading new image -->
                    <form action="upload_map.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="newMap" class="form-label">อัปโหลดรูปแผนผังใหม่</label>
                            <input type="file" class="form-control" id="newMap" name="newMap" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- maps modal -->

    <div class="modal fade" id="uniqueImageModal" tabindex="-1" aria-labelledby="uniqueImageModalLabel" aria-hidden="true">
        <div class="modal-dialog unique-modal-dialog modal-dialog-centered">
            <div class="modal-content unique-modal-content">
                <div class="modal-body unique-modal-body">
                    <div style="background-color: aliceblue;" class="p-3 rounded">
                        <?php
                        // Fetch the current map image from the database
                        require("../condb.php");
                        $sql = "SELECT map_image FROM market_maps WHERE idmarket_maps = 1"; // Adjust the WHERE clause as necessary
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $currentMap = isset($row['map_image']) ? $row['map_image'] : 'default_map.jpg'; // Fallback image if none found
                        $conn->close();
                        ?>
                        <img src="../asset/maps/<?php echo $currentMap; ?>" alt="Unique Large Image"> <!-- ตรวจสอบชื่อไฟล์ให้ถูกต้อง -->
                    </div>
                    <button class="unique-close-btn rounded" data-bs-dismiss="modal">&times;</button>
                </div>
            </div>
        </div>
        <style>
            /* Modal Styles */
            .unique-modal-dialog {
                max-width: 100%;
                width: auto;
            }

            .unique-modal-content {
                background-color: transparent;
                border: none;
            }

            .unique-modal-body {
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
            }

            /* Image Styling */
            .unique-modal-body img {
                width: 100%;
                max-width: 1000px;
                height: auto;
            }

            /* Close Button */
            .unique-close-btn {
                position: absolute;
                top: 10px;
                right: 20px;
                color: white;
                background: rgba(0, 0, 0, 0.5);
                border: none;
                font-size: 24px;
                cursor: pointer;
                padding: 5px 10px;
            }

            .unique-close-btn:hover {
                background-color: red;
            }

            .swal2-container {
                z-index: 9999 !important;
                /* ปรับค่าให้เหมาะสมตามที่ต้องการ */
            }

            .bgcolor {
                background-color: rgba(255, 255, 255, 0.9);
                padding-bottom: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .modal-backdrop {
                z-index: 1040 !important;
                /* ให้ backdrop อยู่ต่ำกว่า navbar */
            }
        </style>
    </div>
    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="update_zone.php" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="EditModalLabel"><strong>แก้ไขรายละเอียดโซน</strong></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="zone_id" id="zone_id">
                        <div class="mb-3 row">
                            <label for="zone_name" class="col-sm-3 col-form-label"><strong>ชื่อโซน:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="zone_name" id="zone_name">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="zone_detail" class="col-sm-3 col-form-label"><strong>รายละเอียดโซน:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="zone_detail" id="zone_detail">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="pricePerDate" class="col-sm-3 col-form-label"><strong>ราคาต่อวัน:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pricePerDate" id="pricePerDate">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="pricePerMonth" class="col-sm-3 col-form-label"><strong>ราคาต่อเดือน:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pricePerMonth" id="pricePerMonth">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="lock_amount" class="col-sm-3 col-form-label"><strong>จำนวนล็อค:</strong></label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="lock_amount" id="lock_amount" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-success">อัพเดต</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editButtons = document.querySelectorAll('.edit-btn');

            editButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var zoneId = this.getAttribute('data-bs-id');
                    var zoneName = this.getAttribute('data-bs-name');
                    var zoneDetail = this.getAttribute('data-bs-detail');
                    var pricePerDate = this.getAttribute('data-bs-date');
                    var pricePerMonth = this.getAttribute('data-bs-Month');
                    var lockAmount = this.getAttribute('data-bs-amount'); // Assuming this attribute is set

                    document.getElementById('zone_id').value = zoneId;
                    document.getElementById('zone_name').value = zoneName;
                    document.getElementById('zone_detail').value = zoneDetail;
                    document.getElementById('pricePerDate').value = pricePerDate;
                    document.getElementById('pricePerMonth').value = pricePerMonth;
                    document.getElementById('lock_amount').value = lockAmount; // Set the lock amount
                });
            });
        });
    </script>

    </div>
    <!-- Add Zone Modal -->
    <div class="modal fade" id="AddZoneModal" tabindex="-1" aria-labelledby="AddZoneModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="Add_zone.php" method="POST" id="addZoneForm">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="AddZoneModalLabel"><strong>เพิ่มโซน(พื้นที่การขาย)</strong></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="zone_name" class="col-sm-3 col-form-label"><strong>ชื่อโซน :</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="zone_name" id="zone_name">
                                <span class="text-danger req" style="font-size: 14px;" id="reqZoneName">*จำเป็น</span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="zone_detail" class="col-sm-3 col-form-label"><strong>รายละเอียด :</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="zone_detail" id="zone_detail">
                                <span class="text-danger req" style="font-size: 14px;" id="reqZoneDetail">*จำเป็น</span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="pricePerDate" class="col-sm-3 col-form-label"><strong>ราคาต่อวัน :</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pricePerDate" id="pricePerDate">
                                <span class="text-danger req" style="font-size: 14px;" id="reqPricePerDate">*จำเป็น</span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="pricePerMonth" class="col-sm-3 col-form-label"><strong>ราคาต่อเดือน :</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pricePerMonth" id="pricePerMonth">
                                <span class="text-danger req" style="font-size: 14px;" id="reqPricePerMonth">*จำเป็น</span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="amount" class="col-sm-3 col-form-label"><strong>จำนวนล็อคในโซน :</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="amount" id="amount">
                                <span class="text-danger req" style="font-size: 14px;" id="reqAmount">*จำเป็น</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-success">เพิ่มโซน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Change Banner Modal -->
    <div class="modal fade" id="changeBannerModal" tabindex="-1" aria-labelledby="changeBannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeBannerModalLabel">เปลี่ยนรูปหน้าเว็บตลาด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Carousel for Banners -->
                    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            require("../condb.php");

                            // Array to hold banner ids
                            $bannerIds = [1, 2, 3, 4, 5, 6];
                            $isActive = true; // For the first item

                            foreach ($bannerIds as $id) {
                                // Fetch the current banner image from the database
                                $sql = "SELECT file_name FROM banners WHERE id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $bannerImage = isset($row['file_name']) ? $row['file_name'] : 'default_map.jpg'; // Fallback image if none found

                                // Set active class for the first item
                                $activeClass = $isActive ? 'active' : '';
                                $isActive = false; // Only the first one should be active

                                // Carousel item
                                echo "
                            <div class='carousel-item $activeClass'>
                                <img src='../asset/img/banner/$bannerImage' class='d-block w-100' alt='Banner $id' style='height: 25rem;'>
                                <div class='carousel-caption d-none d-md-block bg-dark p-4 bg-opacity-50 rounded'>
                                    <h5>ภาพ $id</h5>
                                    <form id='uploadForm$id' enctype='multipart/form-data' action='upload_banner.php?id=$id' method='POST' style='max-width: 300px; margin: auto;'>
                                        <div class='mb-3'>
                                            <label for='bannerImage$id' class='form-label'>เลือกรูปภาพ:</label>
                                            <input type='file' class='form-control form-control-sm' id='bannerImage$id' name='bannerImage' accept='image/png, image/jpeg' required>
                                        </div>
                                        <button type='submit' class='btn btn-primary btn-sm w-100'>อัปโหลด</button>
                                    </form>
                                </div>
                            </div>";
                            }

                            $stmt->close();
                            ?>
                        </div>
                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <!-- Recommended Zones Section -->
                    <div class="container recommended-section my-5">
                        <h2 class="text-center">โซนแนะนำ</h2>
                        <div class="row">
                            <?php
                            $zoneRecommendIds = [7, 8, 9];
                            // Fetch zone images in a similar way
                            foreach ($zoneRecommendIds as $id) {
                                $sql = "SELECT file_name FROM banners WHERE id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                $zoneImage = isset($row['file_name']) ? $row['file_name'] : 'default_map.jpg'; // Fallback image if none found

                                echo "
                            <div class='col-md-4 text-center'>
                                <img src='../asset/img/banner/$zoneImage' class='d-block w-100' alt='Zone Image $id' style='height: 10rem;'>
                                <form id='uploadFormZone$id' enctype='multipart/form-data' action='upload_banner.php?id=$id' method='POST' style='max-width: 300px; margin: auto;'>
                                    <div class='mb-3'>
                                        <label for='zoneImage$id' class='form-label'>เลือกรูปภาพ:</label>
                                            <input type='file' class='form-control form-control-sm' id='bannerImage$id' name='bannerImage' accept='image/png, image/jpeg' required>
                                    </div>
                                    <button type='submit' class='btn btn-primary btn-sm w-100'>อัปโหลด</button>
                                </form>
                            </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
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


</html>