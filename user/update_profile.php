<?php
session_start();
require("../condb.php");

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "../admin/login.php";</script>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
    $shop_name = htmlspecialchars($_POST['editshopname']);
    $prefix = htmlspecialchars($_POST['editprefix']);
    $firstname = htmlspecialchars($_POST['editfirstname']);
    $lastname = htmlspecialchars($_POST['editlastname']);
    $tel = htmlspecialchars($_POST['edittel']);
    $email = htmlspecialchars($_POST['editemail']);

    // Validate input data
    if (empty($shop_name) || empty($prefix) || empty($firstname) || empty($lastname) || empty($tel) || empty($email)) {
        echo '<script>alert("Please fill in all the fields."); window.history.back();</script>';
        exit();
    }

    // Prepare the SQL statement
    $sql = "UPDATE tbl_user SET 
                shop_name = ?, 
                prefix = ?, 
                firstname = ?, 
                lastname = ?, 
                tel = ?, 
                email = ? 
            WHERE user_id = ?";

    // Initialize and execute the prepared statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssi", $shop_name, $prefix, $firstname, $lastname, $tel, $email, $user_id);

        if ($stmt->execute()) {
            echo '<script>alert("อัพเดตข้อมูลแล้ว กรุณาล็อกอินใหม่"); window.location.href = "./logout.php";</script>';
        } else {
            echo "Error updating profile: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }
} else {
    header("Location: ../admin/logout.php");
    exit();
}

// Close the database connection
$conn->close();
?>
