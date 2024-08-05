<?php
session_start();

$_SESSION = array();

session_destroy();

echo '<script>alert("Logout successful"); window.location.href = "../admin/login.php";</script>';
exit();
?>
