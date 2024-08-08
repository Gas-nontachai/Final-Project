<?php
session_start();
require("../condb.php");

if (isset($_SESSION["username"])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST["submit"])) {
    if (isset($_POST['username']) && isset($_POST['pw'])) {
        $username = $_POST["username"];
        $password = $_POST["pw"];

        $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        if ($stmt->error) {
            echo "ข้อผิดพลาดในการสอบถามฐานข้อมูล: " . $stmt->error;
        } else {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_array();
                $_SESSION["user_id"] = $row['user_id'];
                $_SESSION["username"] = $row['username'];
                $_SESSION["shop_name"] = $row['shop_name'];
                $_SESSION["prefix"] = $row['prefix'];
                $_SESSION["firstname"] = $row['firstname'];
                $_SESSION["lastname"] = $row['lastname'];
                $_SESSION["tel"] = $row['tel'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["userrole"] = $row['userrole'];            

                if ($row['userrole'] == 0) {
                    echo '<script>alert("ล็อคอินสำเร็จ"); window.location.href = "../user/index.php";</script>';
                } elseif ($row['userrole'] == 1) {
                    echo '<script>alert("ล็อคอินสำเร็จ"); window.location.href = "./index.php";</script>';
                } else {
                    echo '<script>alert("บทบาทไม่รู้จัก");</script>';
                }
            } else {
                echo '<script>alert("รหัสผ่านไม่ถูกต้อง");</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียน - Spacebooker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-form h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        .input-group-text {
            cursor: pointer;
        }
        .form-check-label a {
            color: #007bff;
        }
        .form-check-label a:hover {
            text-decoration: underline;
        }
        .btn-primary:disabled {
            background-color: #adb5bd;
        }
    </style>
</head>

<body>
    <div class="login-form">
        <h1>เข้าสู่ระบบ</h1>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input oninput="check_username()" type="text" class="form-control" name="username" id="username" placeholder="Username">
                <span id="span_id" class="text-danger"></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <div class="input-group">
                    <input oninput="checkPassword()" type="password" class="form-control" name="pw" id="pw" placeholder="ใส่รหัสผ่านของคุณ">
                    <span class="input-group-text" onclick="togglePasswordVisibility('pw', 'eyeIcon')">
                        <i id="eyeIcon" class="bi bi-eye-fill"></i>
                    </span>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" id="term" onchange="termofser()" class="form-check-input">
                <label for="term" class="form-check-label">คุณได้อ่านและยอมรับ <a href="#">เงื่อนไขข้อกำหนดการใช้งาน</a></label>
            </div>
            <button type="submit" name="submit" id="submit" class="btn btn-primary w-100" disabled>เข้าสู่ระบบ</button>
            <div class="mt-3 text-center">
                <p>หากคุณยังไม่มีบัญชี <a href="register.php">สมัครที่นี่</a></p>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(inputId, eyeIconId) {
            let passwordInput = document.getElementById(inputId);
            let eyeIcon = document.getElementById(eyeIconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            }
        }

        function termofser() {
            const termCheckbox = document.getElementById("term");
            const submitButton = document.getElementById("submit");

            submitButton.disabled = !termCheckbox.checked;
        }
    </script>
</body>

</html>
