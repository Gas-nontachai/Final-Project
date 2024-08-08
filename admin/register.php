<?php
require("../condb.php");

session_start();

if (isset($_SESSION["username"])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST["submit"])) {
    if (empty($_POST["username"]) || empty($_POST["shopname"]) || empty($_POST["prefix"]) || empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["tel"]) || empty($_POST["email"]) || empty($_POST["pw"])) {
        echo '<script>alert("กรุณากรอกข้อมูลให้ครบทุกช่อง"); window.location.href = "register.php";</script>';
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
            echo '<script>alert("Username นี้ได้มีการสมัครไปแล้ว"); window.location.href = "register.php";</script>';
            exit();
        } else if (mysqli_num_rows($result_tel) > 0) {
            echo '<script>alert("หมายเลขโทรศัพท์นี้ได้สมัครสมาชิกไปแล้ว"); window.location.href = "register.php";</script>';
            exit();
        } else {
            $sql = "INSERT INTO tbl_user (username, shop_name, prefix, firstname, lastname, tel, email, password, userrole) VALUES 
            ('$username', '$shopname', '$prefix', '$firstname', '$lastname', '$tel', '$email', '$password', '$userrole')";

            if (mysqli_query($conn, $sql)) {
                echo '<script>alert("สมัครสมาชิกสำเร็จ"); window.location.href = "login.php";</script>';
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
    <style>
        /* การตกแต่งเพิ่มเติมสำหรับแบบฟอร์มของคุณ */
        body {
            padding: 20px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
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
            <input type="text" class="form-control" name="firstname" placeholder="สมบูรณ์">
        </div>
        <div class="form-group">
            <label for="lastname">นามสกุล</label>
            <input type="text" class="form-control" name="lastname" placeholder="ยิ่งใหญ่">
        </div>
        <div class="form-group">
            <label for="tel">เบอร์โทรศัพท์</label>
            <input oninput="check_tel()" type="tel" class="form-control" name="tel" id="tel" placeholder="088xxxxxxx">
            <span id="span_tel" class="text-danger"></span>
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
        <div class="form-group checkbox-group">
            <input type="checkbox" name="showPassword" id="showPassword" onchange="showpw()" class="form-check-input">
            <label for="showPassword" class="form-check-label">แสดงรหัสผ่าน</label>
        </div>
        <ul>
            <li id="length">ความยาวอย่างน้อย 8 หลัก</li>
            <li id="char">มีตัวอักษรภาษาอังกฤษ</li>
            <li id="num">มีตัวเลข</li>
            <li id="rech_pw">กรอกรหัสผ่านให้ตรงกัน</li>
        </ul>
        <div class="form-group checkbox-group">
            <input type="checkbox" id="term" onchange="termofser()" class="form-check-input">
            <label for="term" class="form-check-label">คุณได้อ่านและยอมรับ<a href="#">เงื่อนไขข้อกำหนดการใช้งาน</a></label>
        </div>
        <button type="submit" name="submit" id="submit" class="btn btn-primary" disabled>สมัครสมาชิก</button>
        <p>หากมีบัญชีแล้ว <a href="login.php">เข้าสู่ระบบได้ที่นี่</a></p>
    </form>

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
