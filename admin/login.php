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
            // Handle the database query error (e.g., log or display an error message)
            echo "Database query error: " . $stmt->error;
        } else {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_array();

                // Set session variables
                $_SESSION["user_id"] = $row['user_id'];
                $_SESSION["username"] = $row['username'];
                $_SESSION["shop_name"] = $row['shop_name'];
                $_SESSION["prefix"] = $row['prefix'];
                $_SESSION["firstname"] = $row['firstname'];
                $_SESSION["lastname"] = $row['lastname'];
                $_SESSION["tel"] = $row['tel'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["userrole"] = $row['userrole'];            

                // Check user role and redirect accordingly
                if ($row['userrole'] == 0) {
                    echo '<script>alert("ล็อคอิน"); window.location.href = "../user/index.php";</script>';
                } elseif ($row['userrole'] == 1) {
                    echo '<script>alert("ล็อคอิน"); window.location.href = "./index.php";</script>';
                } else {
                    echo '<script>alert("Unknown role");</script>';
                }
            } else {
                echo '<script>alert("รหัสผ่านไม่ถูกต้อง");</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register-Spacebooker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.15.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Additional styling for your form */
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
    <h1>เข้าสู่ระบบ</h1>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input oninput="check_username()" type="text" class="form-control" name="username" id="username" placeholder="Username">
            <span id="span_id" class="text-danger"></span>
        </div>
        <div class="form-group">
            <label for="password">รหัสผ่าน</label>
            <div class="input-group">
                <input oninput="checkPassword()" type="password" class="form-control" name="pw" id="pw" placeholder="ใส่รหัสผ่านของคุณ">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility('pw', 'eyeIcon')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="form-group checkbox-group">
            <input type="checkbox" id="term" onchange="termofser()" class="form-check-input">
            <label for="term" class="form-check-label">คุณได้อ่านและยอมรับ<a href="#">เงื่อนไขข้อกำหนดการใช้งาน</a></label>
        </div>
        <button type="submit" name="submit" id="submit" class="btn btn-primary" disabled>เข้าสู่ระบบ</button>
        <p>หากคุณยังไม่มีบัญชีแล้ว <a href="register.php">สมัครได้ได้ที่นี่</a></p>
    </form>

    <script>
        let passwordInput = document.getElementById('pw');
        let eyeIcon = document.getElementById('eyeIcon');

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