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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $zone_id = $_POST["zone_id"];
    $zone_name = $_POST["zone_name"];
    $zone_detail = $_POST["zone_detail"];
    $pricePerDate = $_POST["pricePerDate"];
    $pricePerMonth = $_POST["pricePerMonth"];
    $new_amount = $_POST["lock_amount"];

    // ตรวจสอบจำนวนล็อคที่ถูกจอง
    $current_lock_count_query = "SELECT COUNT(*) as count FROM locks WHERE zone_id = ?";
    $booked_lock_count_query = "SELECT COUNT(*) as count FROM locks WHERE zone_id = ? AND available = 1";

    $stmt = $conn->prepare($current_lock_count_query);
    $stmt->bind_param("i", $zone_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $current_lock_count = $row['count'];
    $stmt->close();

    $stmt = $conn->prepare($booked_lock_count_query);
    $stmt->bind_param("i", $zone_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $booked_lock_count = $row['count'];
    $stmt->close();

    if ($new_amount < $current_lock_count && $new_amount < $booked_lock_count) {
        // แจ้งเตือนถ้าพยายามลดจำนวนล็อคให้ต่ำกว่าจำนวนที่ถูกจอง
        echo '<!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>ไม่สามารถลดจำนวนล็อคได้</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="stylesheet" href="../asset/css/font.css">
        </head>
        <body>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "ไม่สามารถลดจำนวนล็อคได้เนื่องจากมีการจองอยู่",
                       icon: "error",
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                    }).then((result) => {
                            window.location.href = "./crud_page.php";
                        
                    });
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // ตรวจสอบข้อมูลที่จำเป็น
    if (empty($zone_name) || empty($zone_detail) || empty($pricePerDate) || empty($pricePerMonth)) {
        echo '<!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>กรุณากรอกข้อมูลในช่องที่ต้องกรอกทั้งหมด</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="stylesheet" href="../asset/css/font.css">
        </head>
        <body>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "กรุณากรอกข้อมูลในช่องที่ต้องกรอกทั้งหมด",
                        icon: "error",
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                    }).then((result) => {
                            window.location.href = "./crud_page.php";
                        
                    });
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // อัพเดตข้อมูลโซน
    $sql = "UPDATE zone_detail
            SET 
                zone_name = ?, 
                zone_detail = ?, 
                pricePerDate = ?, 
                pricePerMonth = ? 
            WHERE 
                zone_id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "Prepare failed: " . $conn->error;
    } else {
        $stmt->bind_param("sssss", $zone_name, $zone_detail, $pricePerDate, $pricePerMonth, $zone_id);

        if ($stmt->execute()) {
            // อัพเดตจำนวนล็อค
            if ($new_amount > $current_lock_count) {
                // เพิ่มล็อค
                $lock_sql = "INSERT INTO locks (lock_name, zone_id, available) VALUES (?, ?, '0')";
                $lock_stmt = $conn->prepare($lock_sql);
                for ($i = $current_lock_count + 1; $i <= $new_amount; $i++) {
                    $lock_name = $zone_name . $i;
                    $lock_stmt->bind_param("si", $lock_name, $zone_id);
                    $lock_stmt->execute();
                }
                $lock_stmt->close();
            } elseif ($new_amount < $current_lock_count) {
                // ลบล็อคที่ยังไม่มีการจอง
                $delete_sql = "DELETE FROM locks WHERE zone_id = ? AND available = 0 ORDER BY lock_name DESC LIMIT ?";
                $stmt = $conn->prepare($delete_sql);
                $delete_count = $current_lock_count - $new_amount;
                $stmt->bind_param("ii", $zone_id, $delete_count);
                $stmt->execute();
                $stmt->close();
            }

            echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>อัพเดตโซนสำเร็จ</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <link rel="stylesheet" href="../asset/css/font.css">
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "อัพเดตโซนสำเร็จ",
                                 icon: "success",
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
                            }).then((result) => {
                                    window.location.href = "./crud_page.php";
                                
                            });
                        });
                    </script>
                </body>
                </html>';
        } else {
            echo "Error updating zone: " . $stmt->error;
        }
    }
} else {
    header("Location: ./crud_page.php");
    exit();
}
