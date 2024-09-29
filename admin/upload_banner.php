<?php
require("../condb.php");

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bannerImage'])) {
    // Get the banner ID from the URL
    $bannerId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Set the target directory and file name
    $targetDir = "../asset/img/banner/";
    $fileName = basename($_FILES["bannerImage"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Check file type (only PNG, JPG, JPEG)
    $allowedTypes = ["jpg", "jpeg", "png"];
    if (in_array($fileType, $allowedTypes)) {
        // Move the uploaded file
        if (move_uploaded_file($_FILES["bannerImage"]["tmp_name"], $targetFilePath)) {
            // Check if the banner ID exists
            $stmt = $conn->prepare("SELECT id, file_name FROM banners WHERE id = ?");
            $stmt->bind_param("i", $bannerId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update existing record
                $row = $result->fetch_assoc();
                $updateStmt = $conn->prepare("UPDATE banners SET file_name = ? WHERE id = ?");
                $updateStmt->bind_param("si", $fileName, $bannerId);

                // Execute update and handle response
                if ($updateStmt->execute()) {
                    // Optionally delete the old file if needed
                    if ($row['file_name'] !== $fileName) {
                        unlink($targetDir . $row['file_name']); // Deletes the old image
                    }
                    echo generateAlert("สำเร็จ!", "แผนผังตลาดได้รับการอัปเดตสำเร็จ", "success");
                } else {
                    echo generateAlert("ขออภัย!", "เกิดข้อผิดพลาดในการอัปเดตข้อมูล.", "error");
                }
                $updateStmt->close();
            } else {
                // Insert new record
                $insertStmt = $conn->prepare("INSERT INTO banners (file_name) VALUES (?)");
                $insertStmt->bind_param("s", $fileName);

                // Execute insert and handle response
                if ($insertStmt->execute()) {
                    echo generateAlert("สำเร็จ!", "อัปโหลดสำเร็จ! (เพิ่มภาพใหม่)", "success");
                } else {
                    echo generateAlert("ขออภัย!", "เกิดข้อผิดพลาดในการบันทึกข้อมูล.", "error");
                }
                $insertStmt->close();
            }
        } else {
            // Handle file move error
            echo generateAlert("ขออภัย!", "เกิดข้อผิดพลาดในการอัปโหลดไฟล์.", "error");
        }
    } else {
        // Handle invalid file type
        echo generateAlert("ขออภัย!", "อนุญาตเฉพาะไฟล์ JPG, JPEG และ PNG เท่านั้น.", "error");
    }
} else {
    // Handle case when POST request does not have the file
    echo generateAlert("ไม่พบไฟล์สำหรับอัปโหลด.", "กรุณาเลือกไฟล์ที่ต้องการอัปโหลด.", "error");
}

// Close the database connection
mysqli_close($conn);

// Function to generate SweetAlert HTML
function generateAlert($title, $text, $icon)
{
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../asset/img/icon.market.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: "' . $title . '",
                text: "' . $text . '",
                icon: "' . $icon . '",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "ตกลง"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "./crud_page.php";
                }
            });
        </script>
    </body>
    </html>';
}
