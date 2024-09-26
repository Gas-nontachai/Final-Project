<?php
session_start();
require("../condb.php");
if ($_SESSION["userrole"] == 1) {
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
                    title: "หน้านี้สำหรับผู้ใช้ทั่วไป คุณคือผู้ดูแลระบบ",
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
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดต่อเรา</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
    <style>
        body {
            background-image: url(../asset/img/img.market2blur.png);
            width: 100%;
            height: 100%;
            background-repeat: repeat;
            background-size: cover;
        }

        .contact-info {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <!-- Nav -->
    <?php include('./user_nav.php'); ?>

    <!-- Contact Us Information -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="contact-info mt-5 p-4">
                    <h2 class="text-center">ติดต่อเรา</h2>
                    <p>หากคุณมีคำถาม ข้อเสนอแนะ หรือปัญหาใด ๆ สามารถติดต่อเราได้ผ่านช่องทางดังต่อไปนี้:</p>
                    <ul>
                        <li><strong>ที่อยู่:</strong> มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน(สุรนารายณ์) 744 ถ. สุรนารายณ์</li>
                        <li><strong>โทรศัพท์:</strong> 02-888-8888</li>
                        <li><strong>อีเมล:</strong> info@marketplace.com</li>
                        <li><strong>เวลาทำการ:</strong> จันทร์ - ศุกร์ 9:00 น. - 17:00 น.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</body>

</html>