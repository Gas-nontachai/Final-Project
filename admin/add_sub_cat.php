<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "./login.php";</script>';
    exit();
}

if (isset($_POST['category']) && isset($_POST['sub_category'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $subcategories = explode(' ', $_POST['sub_category']); 

    foreach ($subcategories as $sub_category) {
        $sql = "INSERT INTO sub_category (id_category, sub_cat_name) VALUES ('$category', '$sub_category')";
        
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit(); 
        }
    }

    echo '<script>alert("Add Sub Category successfully!"); window.location.href = "./manage_cat.php";</script>';
} else {
    echo '<script>alert("Missing form data!"); window.location.href = "./manage_cat.php";</script>';
}

$conn->close();
?>
