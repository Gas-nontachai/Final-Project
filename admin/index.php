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

if ($userrole == 0) {
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
    <div class="container mt-4 pb-5">
        <div class="container ">
            <div class="row d-flex justify-content-center align-item-center overflow-auto">
                <!-- BTN -->
                <div class="row d-flex justify-content-center bgcolor rounded align-item-center">

                    <div class="col-12 d-flex flex-wrap justify-content-center align-item-center py-4 rounded overflow-auto">
                        <!-- fetch_zone_detail -->
                        <?php
                        include('./fetch_zone_detail.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
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