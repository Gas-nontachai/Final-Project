<?php
require("../condb.php");

// Check if a file is uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['newMap'])) {
    $targetDir = "../asset/maps/"; // Directory to save uploaded images
    $imageFileType = strtolower(pathinfo($_FILES["newMap"]["name"], PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Fetch the current map image name from the database
    $currentMapQuery = "SELECT map_image FROM market_maps WHERE idmarket_maps = 1";
    $currentMapResult = $conn->query($currentMapQuery);

    $currentMapImage = null;
    if ($currentMapResult && $currentMapResult->num_rows > 0) {
        $currentMapRow = $currentMapResult->fetch_assoc();
        $currentMapImage = $currentMapRow['map_image'];
    }

    // Check if image file is a real image or fake image
    $check = getimagesize($_FILES["newMap"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
        $errorMessage = 'ไฟล์นี้ไม่ใช่รูปภาพ';
    }

    // Allow only PNG and JPG file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        $uploadOk = 0;
        $errorMessage = 'เฉพาะไฟล์ JPG, JPEG และ PNG เท่านั้นที่อนุญาต';
    }

    // If everything is ok, try to upload file
    if ($uploadOk === 1) {
        $nextNumber = 1; // This should be defined based on your application's logic
        $newFileName = "maps.img." . $nextNumber . "." . $imageFileType;
        $targetFile = $targetDir . $newFileName; // Corrected file path

        if (move_uploaded_file($_FILES["newMap"]["tmp_name"], $targetFile)) {
            // Use a prepared statement to update the database with the new map name
            $stmt = $conn->prepare("UPDATE market_maps SET map_image = ? WHERE idmarket_maps = 1");
            $stmt->bind_param("s", $newFileName);

            if ($stmt->execute()) {
                // Success - Use Swal to display a success message
                echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>แผนผังตลาดได้รับการอัปเดตสำเร็จ</title>
                    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            title: 'สำเร็จ!',
                            text: 'แผนผังตลาดได้รับการอัปเดตสำเร็จ',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = './crud_page.php';
                            }
                        });
                    </script>
                </body>
                </html>";
            } else {
                // Error - Use Swal to display an error message
                echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>เกิดข้อผิดพลาดในการอัปเดตข้อมูล</title>
                    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            title: 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล!',
                            text: '{$conn->error}',
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ตกลง'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = './crud_page.php';
                            }
                        });
                    </script>
                </body>
                </html>";
            }
            $stmt->close();
        } else {
            // Error uploading file
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>เกิดข้อผิดพลาดในการอัปโหลดไฟล์</title>
                <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาดในการอัปโหลดไฟล์!',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ตกลง'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = './crud_page.php';
                        }
                    });
                </script>
            </body>
            </html>";
        }
    } else {
        // If upload failed, keep the old image
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>เกิดข้อผิดพลาด</title>
            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: 'ขออภัย!',
                    text: '{$errorMessage}',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './crud_page.php';
                    }
                });
            </script>
        </body>
        </html>";
    }

    $conn->close();
}
?>
