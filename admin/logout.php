<?php
session_start();

$_SESSION = array();

session_destroy();

echo '<script>alert("ออกจากระบบเรียบร้อย"); window.location.href = "../admin/login.php";</script>';
exit();
?>
