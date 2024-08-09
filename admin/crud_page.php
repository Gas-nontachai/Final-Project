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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการพื้นที่การขาย</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">    <link rel="stylesheet" href="../asset/css/font.css">
</head>

<body>
    <!-- Nav -->
    <?php
    include('./admin_nav.php');
    ?>

    <!-- Display -->
    <div class="container mt-4">
        <div class="container">
            <div class=" row d-flex justify-content-center align-item-center">
                <div class="col-12 d-flex flex-wrap justify-content-center align-item-center">
                    <?php
                    $sql = "SELECT * FROM zone_detail ORDER BY zone_name";
                    if ($result = $conn->query($sql)) {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
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
                                                                data-bs-month="' . $row['pricePerMonth'] . '">
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
                                $sql2 = "SELECT * FROM locks WHERE zone_id = " . $row["zone_id"];
                                if ($result2 = $conn->query($sql2)) {
                                    if ($result2->num_rows > 0) {
                                        echo '<div class="d-flex flex-wrap container-md">';
                                        while ($row2 = $result2->fetch_assoc()) {
                                            echo '<div class="mx-2 ">
                                                        <p>';
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
                                            echo '</p>
                                                        </div>';
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
                    <button class="btn btn-success m-2" type="button" data-bs-toggle="modal" data-bs-target="#AddZoneModal">
                        เพิ่มโซน(พื้นที่การขาย)
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- EDIT MODAL -->
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-success">อัพเดต</button>
                    </div>
                </form>
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

                        document.getElementById('zone_id').value = zoneId;
                        document.getElementById('zone_name').value = zoneName;
                        document.getElementById('zone_detail').value = zoneDetail;
                        document.getElementById('pricePerDate').value = pricePerDate;
                        document.getElementById('pricePerMonth').value = pricePerMonth;
                    });
                });
            });
        </script>

        <?php $conn->close(); ?>
    </div>
    <!-- Add Zone Modal -->
    <div class="modal fade" id="AddZoneModal" tabindex="-1" aria-labelledby="AddZoneModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="Add_zone.php" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="AddZoneModalLabel"><strong>AddZoneModal</strong></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="zone_name" class="col-sm-3 col-form-label"><strong>Zone name:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="zone_name" id="zone_name">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="zone_detail" class="col-sm-3 col-form-label"><strong>Detail:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="zone_detail" id="zone_detail">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="pricePerDate" class="col-sm-3 col-form-label"><strong>pricePerDate:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pricePerDate" id="pricePerDate">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="pricePerMonth" class="col-sm-3 col-form-label"><strong>pricePerMonth:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pricePerMonth" id="pricePerMonth">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="amount" class="col-sm-3 col-form-label"><strong>amount:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="amount" id="amount">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Zone</button>
                    </div>
                </form>
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