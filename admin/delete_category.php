<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "./login.php";</script>';
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<script>alert("Invalid category ID."); window.location.href = "./manage_cat.php";</script>';
    exit();
}

$category_id = $_GET['id'];

// Delete subcategories first
$sql_delete_subcategories = "DELETE FROM sub_category WHERE id_category = '$category_id'";
if ($conn->query($sql_delete_subcategories)) {
    // Delete category
    $sql_delete_category = "DELETE FROM category WHERE id_category = '$category_id'";
    if ($conn->query($sql_delete_category)) {
        echo '<script>alert("Category and its subcategories deleted successfully!"); window.location.href = "./manage_cat.php";</script>';
    } else {
        echo "Error deleting category: " . $conn->error;
    }
} else {
    echo "Error deleting subcategories: " . $conn->error;
}

$conn->close();
?>
