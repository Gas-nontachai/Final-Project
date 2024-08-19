<?php
session_start();
require("../condb.php");

// ตรวจสอบว่ามีข้อมูลฟอร์มที่ถูกโพสต์หรือไม่
if (isset($_POST['booking_id']) && isset($_POST['zone_id']) && isset($_POST['id_locks'])) {
    $booking_id = $_POST['booking_id'];
    $zone_id = $_POST['zone_id'];
    $lock_ids = $_POST['id_locks']; // อาร์เรย์ของ ID ล็อคที่เลือก

    // เริ่มต้นการทำธุรกรรม
    $conn->begin_transaction();

    try {
        // อัพเดทสถานะของล็อคที่เลือก
        $sql_locks = "UPDATE locks SET available = 1, booking_id = ? WHERE id_locks = ? AND zone_id = ?";
        $stmt_locks = $conn->prepare($sql_locks);

        foreach ($lock_ids as $lock_id) {
            $stmt_locks->bind_param('iii', $booking_id, $lock_id, $zone_id);
            $stmt_locks->execute();
        }

        // ดึงชื่อล็อคสำหรับการอัพเดทการจอง
        $sql_lock_names = "SELECT lock_name FROM locks WHERE id_locks IN (" . implode(',', array_fill(0, count($lock_ids), '?')) . ")";
        $stmt_lock_names = $conn->prepare($sql_lock_names);
        $stmt_lock_names->bind_param(str_repeat('i', count($lock_ids)), ...$lock_ids);
        $stmt_lock_names->execute();
        $result_lock_names = $stmt_lock_names->get_result();

        $lock_names = [];
        while ($row = $result_lock_names->fetch_assoc()) {
            $lock_names[] = $row['lock_name'];
        }
        $lock_names_str = implode(', ', $lock_names);

        // ดึงประเภทการจองและวันที่การจองเพื่อคำนวณวันที่หมดอายุ
        $sql_booking_info = "SELECT booking_type, booking_date FROM booking WHERE booking_id = ?";
        $stmt_booking_info = $conn->prepare($sql_booking_info);
        $stmt_booking_info->bind_param('i', $booking_id);
        $stmt_booking_info->execute();
        $result_booking_info = $stmt_booking_info->get_result();

        if ($row_booking_info = $result_booking_info->fetch_assoc()) {
            $booking_type = $row_booking_info['booking_type'];
            $booking_date = $row_booking_info['booking_date'];

            // คำนวณวันที่หมดอายุ
            if ($booking_type == 'PerDay') {
                $expiration_date = date('Y-m-d 23:59:58');
            } elseif ($booking_type == 'PerMonth') {
                $expiration_date = date('Y-m-d 23:59:58', strtotime($booking_date . ' +1 month'));
            }

            // อัพเดทสถานะการจอง ชื่อล็อค และวันที่หมดอายุ
            $sql_booking = "UPDATE booking SET booking_status = 4, book_lock_number = ?, expiration_date = ? WHERE booking_id = ?";
            $stmt_booking = $conn->prepare($sql_booking);
            $stmt_booking->bind_param('ssi', $lock_names_str, $expiration_date, $booking_id);
            $stmt_booking->execute();

            // คอมมิตธุรกรรม
            $conn->commit();

            // เปลี่ยนเส้นทางไปยังหน้าสำเร็จหรือแสดงข้อความสำเร็จ

            echo '<!DOCTYPE html>
                  <html lang="th">
                  <head>
                      <meta charset="UTF-8">
                      <meta name="viewport" content="width=device-width, initial-scale=1.0">
                      <title>ทำการปรับเปลี่ยนสถานะเรียบร้อย</title>
                      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                      <link rel="stylesheet" href="../asset/css/font.css">
                  </head>
                  <body>
                      <script>
                          document.addEventListener("DOMContentLoaded", function() {
                              Swal.fire({
                                  title: "ทำการปรับเปลี่ยนสถานะเรียบร้อย",
                                  icon: "success",
                                  timer: 2000, // แสดงเป็นเวลา 2 วินาที
                                  timerProgressBar: true, // แสดงแถบความก้าวหน้า
                                  showConfirmButton: false // ซ่อนปุ่ม "OK"
                              }).then((result) => {
                                  if (result.dismiss === Swal.DismissReason.timer) {
                                      window.location.href = "./confirm_reserve.php"; // เปลี่ยนเส้นทางไปยังหน้า index.php
                                  }
                              });
                          });
                      </script>
                  </body>
                  </html>';
            exit();
        } else {
            throw new Exception("ไม่พบการจอง.");
        }
    } catch (Exception $e) {
        // ยกเลิกธุรกรรมหากเกิดข้อผิดพลาด
        $conn->rollback();

        // แสดงข้อผิดพลาดหรือบันทึกข้อผิดพลาด
        echo 'ข้อผิดพลาด: ' . htmlspecialchars($e->getMessage());
    } finally {
        $stmt_locks->close();
        $stmt_lock_names->close();
        if (isset($stmt_booking_info)) {
            $stmt_booking_info->close();
        }
        if (isset($stmt_booking)) {
            $stmt_booking->close();
        }
        $conn->close();
    }
} else {
    echo 'คำขอไม่ถูกต้อง: ข้อมูลหายไป.';
}
