<?php
require("../condb.php");

if (isset($_GET['zone_id'])) {
    $zone_id = $_GET['zone_id'];

    // ตรวจสอบว่ามีล็อกที่ว่างอยู่หรือไม่
    $check_locks_sql = "SELECT COUNT(*) AS count FROM locks WHERE zone_id = ? AND available = 1";
    $check_locks_stmt = $conn->prepare($check_locks_sql);
    $check_locks_stmt->bind_param("i", $zone_id);
    $check_locks_stmt->execute();
    $check_locks_result = $check_locks_stmt->get_result();
    $locks_row = $check_locks_result->fetch_assoc();
    $count = $locks_row['count'];

    // หากมีล็อกที่ว่างอยู่ ให้แจ้งเตือนและหยุดการทำงาน
    if ($count > 0) {
        echo '<!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>ไม่สามารถลบโซนได้ เนื่องจากยังมีล็อกที่ใช้งานอยู่.</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link rel="stylesheet" href="../asset/css/font.css">
        </head>
        <body>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "ไม่สามารถลบโซนได้ เนื่องจากยังมีล็อกที่ใช้งานอยู่.",
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

    // ดำเนินการลบหากไม่มีล็อกที่ว่างอยู่
    $delete_locks_sql = "DELETE FROM locks WHERE zone_id = ?";
    $delete_locks_stmt = $conn->prepare($delete_locks_sql);
    $delete_locks_stmt->bind_param("i", $zone_id);

    if ($delete_locks_stmt->execute()) {
        // หากการลบล็อกสำเร็จ ให้ลบข้อมูลโซนต่อไป
        $delete_zone_detail_sql = "DELETE FROM zone_detail WHERE zone_id = ?";
        $delete_zone_detail_stmt = $conn->prepare($delete_zone_detail_sql);
        $delete_zone_detail_stmt->bind_param("i", $zone_id);

        if ($delete_zone_detail_stmt->execute()) {
            // ข้อความแจ้งเตือนว่าลบโซนสำเร็จ
            echo '<!DOCTYPE html>
            <html lang="th">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>ลบโซนสำเร็จ</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="stylesheet" href="../asset/css/font.css">
            </head>
            <body>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "ลบโซนสำเร็จ",
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
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }

        $delete_zone_detail_stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $delete_locks_stmt->close();
} else {
    echo json_encode(['error' => 'คำขอไม่ถูกต้อง.']);
}

$conn->close();
