<?php
require("./condb.php");

session_start();

if (isset($_POST["submit"])) {
    if (empty($_POST["username"]) || empty($_POST["shopname"]) || empty($_POST["prefix"]) || empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["tel"]) || empty($_POST["email"]) || empty($_POST["pw"])) {
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
                            window.location.href = "./register.php";
                    });
                });
            </script>
        </body>
        </html>';
        exit();
    } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $shopname = mysqli_real_escape_string($conn, $_POST["shopname"]);
        $prefix = mysqli_real_escape_string($conn, $_POST["prefix"]);
        $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
        $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
        $tel = mysqli_real_escape_string($conn, $_POST["tel"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["pw"]);
        $userrole = "0";

        $check_username = "SELECT * FROM tbl_user WHERE username = '$username'";
        $result = mysqli_query($conn, $check_username);
        $check_tel = "SELECT * FROM tbl_user WHERE tel = '$tel'";
        $result_tel = mysqli_query($conn, $check_tel);

        if (mysqli_num_rows($result) > 0) {
            echo '<!DOCTYPE html>
            <html lang="th">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Username นี้ได้มีการสมัครไปแล้ว</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="stylesheet" href="../asset/css/font.css">
            </head>
            <body>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Username นี้ได้มีการสมัครไปแล้ว",
                           icon: "error",
                        
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                        }).then((result) => {
                                window.location.href = "./register.php";
                        });
                    });
                </script>
            </body>
            </html>';
            exit();
        } else if (mysqli_num_rows($result_tel) > 0) {
            echo '<!DOCTYPE html>
            <html lang="th">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>หมายเลขโทรศัพท์นี้ได้สมัครสมาชิกไปแล้ว</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <link rel="stylesheet" href="../asset/css/font.css">
            </head>
            <body>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "หมายเลขโทรศัพท์นี้ได้สมัครสมาชิกไปแล้ว",
                         icon: "error",
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                        }).then((result) => {
                                window.location.href = "./register.php";
                        });
                    });
                </script>
            </body>
            </html>';
            exit();
        } else {
            $sql = "INSERT INTO tbl_user (username, shop_name, prefix, firstname, lastname, tel, email, password, userrole) VALUES 
            ('$username', '$shopname', '$prefix', '$firstname', '$lastname', '$tel', '$email', '$password', '$userrole')";

            if (mysqli_query($conn, $sql)) {
                echo '<!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>สมัครสมาชิกสำเร็จ</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <link rel="stylesheet" href="../asset/css/font.css">
                </head>
                <body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "สมัครสมาชิกสำเร็จ",
                                icon: "success",
                                showConfirmButton: true // ซ่อนปุ่ม "OK"
                            }).then((result) => {
                                    window.location.href = "./login.php";
                            });
                        });
                    </script>
                </body>
                </html>';
                exit();
            } else {
                echo "ข้อผิดพลาด: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียน - Spacebooker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.15.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./asset/css/font.css">
    <style>
        /* การตกแต่งเพิ่มเติมสำหรับแบบฟอร์มของคุณ */
        body {
            padding: 10px;
            display: flex;
            justify-content: center;
            background-image: url(./asset/img/img.market.blur.jpg);
            width: 100%;
            height: 100%;
            background-repeat: repeat;
            background-size: cover;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
        }

        .login-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .login-form h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        h1 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        button:disabled {
            background-color: #d3d3d3;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="p-4 rounded " style="background-color:rgba(255, 255, 255, 0.7); ">
        <div class="login-form" style="opacity:1.0;">
            <h1>สมัครสมาชิก</h1>
            <form action="register.php" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="username">Username (ใช้ในการล็อกอิน)</label>
                    <input oninput="check_username()" type="text" class="form-control" name="username" id="username" placeholder="Username ไว้เพื่อใช้ในการ Login">
                    <span id="span_id" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="shopname">ชื่อร้านค้า</label>
                    <input type="text" class="form-control" name="shopname" id="shopname" placeholder="ชื่อร้านค้า">
                    <span id="span_id" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="prefixSelect">คำนำหน้า:</label>
                    <select id="prefixSelect" class="form-control" name="prefix">
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="firstname">ชื่อ</label>
                    <input type="text" class="form-control" name="firstname" placeholder="ชื่อ">
                </div>
                <div class="form-group">
                    <label for="lastname">นามสกุล</label>
                    <input type="text" class="form-control" name="lastname" placeholder="นามสกุล">
                </div>
                <div class="form-group">
                    <label for="tel">เบอร์โทรศัพท์</label>
                    <input oninput="check_tel()" type="tel" class="form-control" name="tel" id="tel" placeholder="088xxxxxxx">
                    <span id="span_tel" class=""></span>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" placeholder="สมบูรณ์@gmail.com">
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน</label>
                    <div class="input-group">
                        <input oninput="checkPassword()" type="password" class="form-control" name="pw" id="pw" placeholder="กรุณาตั้งให้รัดกุม">
                    </div>
                </div>

                <div class="form-group">
                    <label for="re-password">ยืนยันรหัสผ่าน</label>
                    <div class="input-group">
                        <input oninput="recheck_pass()" type="password" class="form-control" name="re-pw" id="re-pw" placeholder="ยืนยันรหัสผ่าน">
                    </div>
                </div>

                <div class="form-group checkbox-group d-flex align-items-start">
                    <input type="checkbox" name="showPassword" id="showPassword" onchange="showpw()" class="form-check-input">
                    <label for="showPassword" class="form-check-label mx-2">แสดงรหัสผ่าน</label>
                </div>
                <ul>
                    <li id="length">ความยาวอย่างน้อย 8 หลัก</li>
                    <li id="char">มีตัวอักษรภาษาอังกฤษ</li>
                    <li id="num">มีตัวเลข</li>
                    <li id="rech_pw">กรอกรหัสผ่านให้ตรงกัน</li>
                </ul>
                <div class="form-group checkbox-group d-flex align-items-start">
                    <input type="checkbox" id="term" onchange="termofser()" class="form-check-input ">
                    <label for="term" class="form-check-label">คุณได้อ่านและยอมรับ <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">เงื่อนไขข้อกำหนดการใช้งาน</a>
                </div>
                <button type="submit" name="submit" id="submit" class="btn btn-primary" disabled>สมัครสมาชิก</button>
                <p>หากมีบัญชีแล้ว <a href="login.php">เข้าสู่ระบบได้ที่นี่</a></p>
            </form>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">เงื่อนไขข้อกำหนดการใช้งาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>ข้อที่ 1: การใช้งานบริการ</h6>
                    <p>ผู้ใช้จะต้องใช้งานบริการของเราตามที่กำหนดไว้และห้ามละเมิดเงื่อนไขใด ๆ ในการใช้งาน เช่น การนำข้อมูลไปใช้ในทางที่ผิดกฎหมายหรือการคัดลอกเนื้อหาโดยไม่ได้รับอนุญาต</p>

                    <h6>ข้อที่ 2: ความรับผิดชอบของผู้ใช้</h6>
                    <p>ผู้ใช้ต้องรับผิดชอบต่อการกระทำของตนเองที่เกิดขึ้นจากการใช้บริการนี้ หากพบว่ามีการละเมิดทางเราขอสงวนสิทธิ์ในการระงับการใช้งานของผู้ใช้งาน</p>

                    <h6>ข้อที่ 3: การเก็บข้อมูลส่วนตัว</h6>
                    <p>เราจะเก็บข้อมูลส่วนตัวของผู้ใช้งานตามนโยบายความเป็นส่วนตัว โดยข้อมูลที่เก็บรวบรวมจะถูกใช้งานเพื่อการพัฒนาบริการและไม่มีการขายต่อข้อมูลให้บุคคลภายนอก</p>

                    <h6>ข้อที่ 4: การเปลี่ยนแปลงเงื่อนไข</h6>
                    <p>เราขอสงวนสิทธิ์ในการเปลี่ยนแปลงเงื่อนไขข้อกำหนดการใช้งานโดยไม่จำเป็นต้องแจ้งให้ทราบล่วงหน้า ผู้ใช้ควรตรวจสอบเงื่อนไขนี้เป็นระยะ ๆ</p>

                    <p>หากผู้ใช้มีข้อสงสัยเพิ่มเติมสามารถติดต่อทีมงานได้ผ่านช่องทางที่ระบุในเว็บไซต์</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePasswordVisibility(inputId, eyeIconId) {
            let passwordInput = document.getElementById(inputId);
            let eyeIcon = document.getElementById(eyeIconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        }

        function check_tel() {
            var input = document.getElementById('tel');
            var value = input.value;
            const span_tel = document.getElementById('span_tel');

            if (value.length < 10) {
                span_tel.style.color = "red";
                span_tel.textContent = "กรุณากรอกให้ครบ 10 หลัก";
            } else if (value.length > 10) {
                span_tel.style.color = "yellow";
                span_tel.textContent = "กรุณากรอกไม่เกิน 10 หลัก";
                input.value = value.slice(0, 10);

                setTimeout(function() {
                    span_tel.style.color = "green";
                    span_tel.textContent = "ครบ 10 หลัก";
                }, 2000);
            } else {
                span_tel.style.color = "green";
                span_tel.textContent = "ครบ 10 หลัก";
            }

            return true;
        }

        function checkPassword() {
            const pw = document.getElementById("pw");
            const value = pw.value;
            const hasChar = /[a-zA-Z]/.test(value);
            const hasNum = /\d/.test(value);

            const char = document.getElementById("char");
            const num = document.getElementById("num");
            const length = document.getElementById("length");

            if (!hasChar) {
                char.style.color = "red";
                char.textContent = "กรุณาใส่ตัวอักษรภาษาอังกฤษ";
            } else {
                char.style.color = "green";
            }

            if (!hasNum) {
                num.style.color = "red";
                num.textContent = "กรุณาใส่ตัวเลข";
            } else {
                num.style.color = "green";
            }

            if (value.length < 8) {
                length.style.color = "red";
            } else {
                length.style.color = "green";
            }
        }

        function recheck_pass() {
            const pw = document.getElementById("pw");
            const value = pw.value;
            const re_pw = document.getElementById("re-pw");
            const re_value = re_pw.value;
            const rech_pw = document.getElementById("rech_pw");

            if (re_value !== value) {
                rech_pw.style.color = "red";
                rech_pw.textContent = "รหัสผ่านไม่ถูกต้อง";
            } else {
                rech_pw.style.color = "green";
                rech_pw.textContent = "รหัสผ่านถูกต้อง";
            }
        }

        function showpw() {
            const pw = document.getElementById("pw");
            const re_pw = document.getElementById("re-pw");
            var x = document.getElementById("pw");
            var y = document.getElementById("re-pw");

            if (x.type === "password" && y.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }

        function termofser() {
            const termCheckbox = document.getElementById("term");
            const submitButton = document.getElementById("submit");

            if (!termCheckbox.checked) {
                submitButton.disabled = true;
            } else {
                submitButton.disabled = false;
            }
        }
    </script>
</body>

</html>