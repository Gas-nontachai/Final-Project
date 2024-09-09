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
// fetch_locks.php
if (isset($_POST['zone_id'])) {
    $zone_id = $_POST['zone_id'];

    // Query ข้อมูล
    $sql = "SELECT * FROM locks WHERE zone_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $zone_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="d-flex flex-wrap gap-2">';
        while ($row = $result->fetch_assoc()) {
            $isAvailable = $row['available']; // Assume available is 1 or 0

            // เพิ่ม class และ disabled attribute ตามสถานะของล็อก
            $btnClass = $isAvailable ? 'btn-secondary' : 'btn-outline-primary';
            $btnDisabled = $isAvailable ? 'disabled' : '';
            $btnText = htmlspecialchars($row['lock_name']);

            echo '
                <div class="form-check">
                    <input class="form-check-input lock-checkbox" type="checkbox" name="id_locks[]" value="' . htmlspecialchars($row['id_locks']) . '" id="lock' . htmlspecialchars($row['id_locks']) . '" style="display:none;">
                    <button type="button" class="btn ' . $btnClass . ' lock-btn" data-lock-id="' . htmlspecialchars($row['id_locks']) . '" ' . $btnDisabled . '>' . $btnText . '</button>
                </div>
            ';
        }
        echo '</div>';
    } else {
        echo '<p>ไม่มีข้อมูลสำหรับโซนที่เลือก</p>';
    }

    $stmt->close();
    $conn->close();
}
