<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "./login.php";</script>';
    exit();
}

// รับข้อมูลจากฟอร์ม
$category_id = $_POST['cat_id'];
$category_name = $_POST['cat_name'];
$sub_cat_names = $_POST['sub_cat_name'];

// Update category name
$sql_update_category = "UPDATE category SET cat_name = '$category_name' WHERE id_category = '$category_id'";
if ($conn->query($sql_update_category) === TRUE) {
    // Delete existing subcategories for this category
    $sql_delete_subcategories = "DELETE FROM sub_category WHERE id_category = '$category_id'";
    if ($conn->query($sql_delete_subcategories)) {
        // Insert new subcategories
        $subcategories = explode(' ', $sub_cat_names);
        foreach ($subcategories as $sub_category) {
            $sql_insert_subcategory = "INSERT INTO sub_category (id_category, sub_cat_name) VALUES ('$category_id', '$sub_category')";
            if (!$conn->query($sql_insert_subcategory)) {
                echo "Error inserting subcategory: " . $conn->error;
                exit();
            }
        }

        echo '<script>alert("Category updated successfully!"); window.location.href = "./manage_cat.php";</script>';
    } else {
        echo "Error deleting existing subcategories: " . $conn->error;
    }
} else {
    echo "Error updating category name: " . $conn->error;
}

$conn->close();
