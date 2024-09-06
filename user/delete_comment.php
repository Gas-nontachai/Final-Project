<?php
session_start();
require("../condb.php");

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION["username"])) {
    echo json_encode(["success" => false, "error" => "กรุณาล็อคอินก่อน"]);
    exit();
}

if (isset($_GET['id'])) {
    $comment_id = mysqli_real_escape_string($conn, $_GET['id']);

    // ตรวจสอบว่ามีข้อมูลความคิดเห็นนี้ในฐานข้อมูลหรือไม่
    $sql_check = "SELECT user_id FROM comments WHERE id = '$comment_id'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        $row = mysqli_fetch_assoc($result_check);

        // ตรวจสอบว่าเป็นความคิดเห็นของผู้ใช้ปัจจุบันหรือไม่
        if ($row['user_id'] == $_SESSION['user_id']) {
            // ลบความคิดเห็น
            $sql_delete = "DELETE FROM comments WHERE id = '$comment_id'";
            if (mysqli_query($conn, $sql_delete)) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => "เกิดข้อผิดพลาดในการลบความคิดเห็น"]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "คุณไม่สามารถลบความคิดเห็นนี้ได้"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "ความคิดเห็นนี้ไม่พบในฐานข้อมูล"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "ไม่พบ ID ของความคิดเห็น"]);
}

mysqli_close($conn);
