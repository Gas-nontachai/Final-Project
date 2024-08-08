<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "../admin/login.php";</script>';
    exit();
}

if (isset($_GET['id_category'])) {
    $id_category = intval($_GET['id_category']);

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Delete subcategories first
        $sub_sql = "DELETE FROM sub_category WHERE id_category = ?";
        $stmt = $conn->prepare($sub_sql);
        $stmt->bind_param("i", $id_category);
        $stmt->execute();

        // Check if subcategory deletion was successful
        if ($stmt->affected_rows > 0) {
            // Delete category
            $cat_sql = "DELETE FROM category WHERE id_category = ?";
            $stmt = $conn->prepare($cat_sql);
            $stmt->bind_param("i", $id_category);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $conn->commit();
                echo '<script>alert("ลบประเภทหลักและประเภทย่อยสำเร็จ!"); window.location.href = "./manage_cat.php";</script>';
            } else {
                throw new Exception("ลบประเภทหลักไม่สำเร็จ.");
            }
        } else {
            throw new Exception("ลบประเภทย่อยไม่สำเร็จ.");
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo '<script>alert("เออเร่อ: ' . $e->getMessage() . '"); window.location.href = "./manage_cat.php";</script>';
    }

    $stmt->close();
    $conn->close();
} else {
    echo '<script>alert("คำขอผิดพลาด."); window.location.href = "./manage_cat.php";</script>';
}
