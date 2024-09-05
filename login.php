<?php
session_start();
require("./condb.php");

$message = ''; // ตัวแปรเก็บข้อความแจ้งเตือน

if (isset($_POST["submit"])) {
    if (isset($_POST['username']) && isset($_POST['pw'])) {
        $username = $_POST["username"];
        $password = $_POST["pw"];

        $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        if ($stmt->error) {
            $message = "ข้อผิดพลาดในการสอบถามฐานข้อมูล: " . $stmt->error;
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
                $_SESSION["token"] = $row['token'];

                // อัปเดตเวลาล็อกอินล่าสุด
                $updateStmt = $conn->prepare("UPDATE tbl_user SET last_login = NOW() WHERE user_id = ?");
                $updateStmt->bind_param("i", $row['user_id']);
                $updateStmt->execute();

                if ($row['userrole'] == 0) {
                    $message = 'ล็อคอินสำเร็จ|./user/index.php';
                } elseif ($row['userrole'] == 1) {
                    $message = 'ล็อคอินสำเร็จ|./admin/index.php';
                } else {
                    $message = 'บทบาทไม่รู้จัก';
                }
            } else {
                $message = 'รหัสผ่านไม่ถูกต้อง';
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
    <title>เข้าสู่ระบบ - Spacebooker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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

<body style="background-image: url(./asset/img/img.market2.jpg); width: 100%; height: 100vh; background-repeat: repeat; background-size: cover;">
    <div class="p-4 rounded " style="background-color:rgba(255, 255, 255, 0.7);">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                            </svg> </span>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" id="term" onchange="termofser()" class="form-check-input">
                    <label for="term" class="form-check-label">คุณได้อ่านและยอมรับ <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">เงื่อนไขข้อกำหนดการใช้งาน</a>
                    </label>
                </div>
                <button type="submit" name="submit" id="submit" class="btn btn-primary w-100" disabled>เข้าสู่ระบบ</button>
                <div class="mt-3 text-center">
                    <p>หากคุณยังไม่มีบัญชี <a href="register.php">สมัครที่นี่</a></p>
                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($message): ?>
                var messageParts = "<?php echo $message; ?>".split('|');
                var messageText = messageParts[0];
                var redirectUrl = messageParts[1] || null;

                Swal.fire({
                    title: messageText,
                    icon: redirectUrl ? 'success' : 'error',
                    timer: 2000,
                    timerProgressBar: true, // แสดงแถบความก้าวหน้า
                    showConfirmButton: false, // ซ่อนปุ่ม "OK"
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer && redirectUrl) {
                        window.location.href = redirectUrl;
                    }
                });

            <?php endif; ?>
        });
    </script>
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