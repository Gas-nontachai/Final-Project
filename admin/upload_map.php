<?php
require("../condb.php");

// Check if a file is uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['newMap'])) {
    $targetDir = "../asset/maps/"; // Directory to save uploaded images
    $imageFileType = strtolower(pathinfo($_FILES["newMap"]["name"], PATHINFO_EXTENSION));
    $uploadOk = 1;

    // SQL to get the next image number (you might have a better logic to determine the file name)
    $sql = "SELECT MAX(idmarket_maps) AS max_id FROM market_maps";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $nextNumber = isset($row['max_id']) ? $row['max_id'] + 1 : 1;

    // New file name
    $newFileName = "maps.img." . $nextNumber . "." . $imageFileType;
    $targetFile = $targetDir . $newFileName;

    // Check if image file is a real image or fake image
    $check = getimagesize($_FILES["newMap"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>
                Swal.fire('ไฟล์นี้ไม่ใช่รูปภาพ', '', 'error');
              </script>";
        $uploadOk = 0;
    }

    // Check file size (optional)
    if ($_FILES["newMap"]["size"] > 5000000) {
        echo "<script>
                Swal.fire('ขออภัย! ไฟล์มีขนาดใหญ่เกินไป.', '', 'error');
              </script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>
                Swal.fire('ขออภัย! เฉพาะไฟล์ JPG, JPEG, PNG & GIF เท่านั้นที่อนุญาต.', '', 'error');
              </script>";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["newMap"]["tmp_name"], $targetFile)) {
            // SQL to update the database with the new map name
            $sql = "UPDATE market_maps SET map_image = '$newFileName' WHERE idmarket_maps = 1";

            if ($conn->query($sql) === TRUE) {
                // Success - Use Swal to display a success message
                echo "
                <!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>แผนผังตลาดได้รับการอัปเดตสำเร็จ</title>
                  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
                  <link rel='stylesheet' href='../asset/css/font.css'>
              </head>
              <body>
                  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
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
                  <link rel='stylesheet' href='../asset/css/font.css'>
              </head>
              <body>
                  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
                  <script>
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล!',
                        text: '$conn->error',
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
            // Error uploading file
            echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                  <title>เกิดข้อผิดพลาดในการอัปโหลดไฟล์</title>
                  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
                  <link rel='stylesheet' href='../asset/css/font.css'>
              </head>
              <body>
                  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
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
    }

    $conn->close();
}
