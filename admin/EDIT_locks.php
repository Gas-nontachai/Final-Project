<?php
session_start();
require("../condb.php");
// ส่วนหัว HTML เพื่อรวม Google Fonts และ CSS
echo '
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
    <title>อัปเดตการจอง</title>
</head>
<body>
';
if (isset($_POST['editbookingId']) && isset($_POST['editid_locks'])) {
    $booking_id = $_POST['editbookingId'];
    $id_lockss = $_POST['editid_locks']; // อาร์เรย์ของ ID ล็อคที่เลือก

    // แสดง booking_id และ id_lockss ที่ได้รับมา
    //echo "หมายเลขการจอง: " . htmlspecialchars($booking_id) . "<br>";
    //echo "หมายเลขล็อค (อาร์เรย์): " . implode(', ', array_map('htmlspecialchars', $id_lockss)) . "<br>";

    // ขั้นตอนที่ 1: ตั้งค่า booking_id เป็น NULL และ available เป็น 0 สำหรับล็อคทั้งหมดที่เคยใช้ booking_id นี้
    $sql1 = "UPDATE locks SET booking_id = NULL, available = 0 WHERE booking_id = ?";
    //echo "SQL1: " . $sql1 . "<br>";

    if ($stmt1 = $conn->prepare($sql1)) {
        $stmt1->bind_param("s", $booking_id); // "s" สำหรับ string
        //echo "เตรียม SQL1 ด้วย booking_id: " . htmlspecialchars($booking_id) . "<br>";

        if ($stmt1->execute()) {
            //echo "SQL1 ดำเนินการสำเร็จ.<br>";

            // ขั้นตอนที่ 2: วนลูปอัปเดต booking_id ใหม่ให้กับล็อคที่เลือกใน SQL2
            foreach ($id_lockss as $id_locks) {
                $sql2 = "UPDATE locks SET booking_id = ?, available = 1 WHERE id_locks = ?";
                //echo "SQL2 สำหรับหมายเลขล็อค " . htmlspecialchars($id_locks) . ": " . $sql2 . "<br>";

                if ($stmt2 = $conn->prepare($sql2)) {
                    $stmt2->bind_param("si", $booking_id, $id_locks); // "s" สำหรับ string, "i" สำหรับ integer
                    //echo "เตรียม SQL2 ด้วย booking_id: " . htmlspecialchars($booking_id) . " สำหรับ id_locks: " . htmlspecialchars($id_locks) . "<br>";

                    if ($stmt2->execute()) {
                        //echo "SQL2 ดำเนินการสำเร็จสำหรับ id_locks: " . htmlspecialchars($id_locks) . "<br>";
                    } else {
                        //echo "SQL2 ดำเนินการล้มเหลวสำหรับ id_locks: " . htmlspecialchars($id_locks) . ". ข้อผิดพลาด: " . $stmt2->error . "<br>";
                    }
                    $stmt2->close();
                }
            }

            // ขั้นตอนที่ 3: ดึง lock_name ของล็อคที่เลือก
            $lock_names = []; // เก็บ lock_name ทั้งหมด
            foreach ($id_lockss as $id_locks) {
                $sql3 = "SELECT lock_name FROM locks WHERE id_locks = ?";
                //echo "SQL3 สำหรับหมายเลขล็อค " . htmlspecialchars($id_locks) . ": " . $sql3 . "<br>";

                if ($stmt3 = $conn->prepare($sql3)) {
                    $stmt3->bind_param("i", $id_locks); // "i" สำหรับ integer
                    //echo "เตรียม SQL3 สำหรับ id_locks: " . htmlspecialchars($id_locks) . "<br>";

                    if ($stmt3->execute()) {
                        $stmt3->bind_result($lock_name);
                        while ($stmt3->fetch()) {
                            $lock_names[] = $lock_name; // เก็บ lock_name ไว้ใน array
                        }
                        //echo "ดึง lock_name สำหรับ id_locks " . htmlspecialchars($id_locks) . ": " . htmlspecialchars($lock_name) . "<br>";
                    } else {
                        //echo "SQL3 ดำเนินการล้มเหลวสำหรับ id_locks: " . htmlspecialchars($id_locks) . ". ข้อผิดพลาด: " . $stmt3->error . "<br>";
                    }
                    $stmt3->close();
                }
            }

            // รวม lock_names เป็น string
            $lock_names_str = implode(', ', $lock_names);
            //echo "ชื่อล็อค: " . htmlspecialchars($lock_names_str) . "<br>";

            // ขั้นตอนที่ 4: อัปเดต book_lock_number ในตาราง booking
            $sql4 = "UPDATE booking SET book_lock_number = ? WHERE booking_id = ?";
            //echo "SQL4: " . $sql4 . "<br>";

            if ($stmt4 = $conn->prepare($sql4)) {
                $stmt4->bind_param("ss", $lock_names_str, $booking_id); // "ss" สำหรับ string ทั้งสอง
                // echo "เตรียม SQL4 ด้วย lock_names: " . htmlspecialchars($lock_names_str) . " และ booking_id: " . htmlspecialchars($booking_id) . "<br>";

                if ($stmt4->execute()) {
                    // echo "SQL4 ดำเนินการสำเร็จสำหรับ booking_id: " . htmlspecialchars($booking_id) . "<br>";
                } else {
                    // echo "SQL4 ดำเนินการล้มเหลว: " . $stmt4->error . "<br>";
                }
                $stmt4->close();
            }
        } else {
            // echo "SQL1 ดำเนินการล้มเหลว: " . $stmt1->error . "<br>";
        }
        $stmt1->close();
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    // echo "ปิดการเชื่อมต่อฐานข้อมูล.<br>";

    // แสดง Swal alert ก่อนการเปลี่ยนหน้า
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "สำเร็จ!",
            text: "การอัปเดตการจองเสร็จสิ้นแล้ว",
            icon: "success",
            confirmButtonText: "ตกลง"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "confirm_reserve.php"; // เปลี่ยนไปยังหน้า confirm_reserve.php
            }
        });
    </script>
    ';
    exit();
} else {
    echo "ไม่พบข้อมูลที่ส่งมา<br>";
}
