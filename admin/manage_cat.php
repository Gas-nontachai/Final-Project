<?php
session_start();
require("../condb.php");
if ($_SESSION["userrole"] == 0) {
    session_destroy();
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ไม่มีสิทธิ์เข้าถึง</title>
            <link rel="icon" type="image/x-icon" href="../asset/img/icon.market.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "คุณไม่มีสิทธิ์เข้าถึง เฉพาะผู้ดูแลเท่านั้น",
                    icon: "error",
                    showConfirmButton: true
                }).then((result) => {
                    window.location.href = "../login.php";
                });
            });
        </script>
    </body>
    </html>';
    exit();
}
if (!isset($_SESSION["username"])) {
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>กรุณาล็อคอินก่อน</title>
            <link rel="icon" type="image/x-icon" href="../asset/img/icon.market.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../asset/css/font.css">
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "กรุณาล็อคอินก่อน",
                    icon: "error",
                        showConfirmButton: true // ซ่อนปุ่ม "OK"
                }).then((result) => {
                        window.location.href = "../login.php";
                    
                });
            });
        </script>
    </body>
    </html>';
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$shop_name = $_SESSION["shop_name"];
$prefix = $_SESSION["prefix"];
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];
$tel = $_SESSION["tel"];
$email = $_SESSION["email"];
$userrole = $_SESSION["userrole"];
$fullname = $prefix . ' ' . $firstname . ' ' . $lastname;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการประเภทสินค้า</title>
    <link rel="icon" type="image/x-icon" href="../asset/img/icon.market.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-image: url(../asset/img/img.market2blur.png);
            width: 100%;
            height: 100%;
            background-repeat: repeat;
            background-size: cover;
        }
    </style>
</head>

<body>
    <!-- Nav -->
    <?php
    include('./admin_nav.php');
    ?>
    <!-- Display -->
    <div class="container mt-2 px-2 border bgcolor py-4 rounded overflow-auto" style="width: 60%; height: 40rem;">
        <ul class="nav nav-tabs" id="myTab">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#categort"><strong>ประเภทสินค้า</strong> </a>
            </li>
        </ul>

        <div class="tab-content " id="myTabContent">
            <div class="tab-pane fade show active mt-2 mx-2 p-2" id="categort">
                <div>
                    <h1>ประเภทสินค้า</h1>
                    <a href="#" class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#AddCatModal">
                        <strong>เพิ่มประเภทสินค้า</strong>
                    </a>
                    <a href="#" class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#AddSubCatModal">
                        <strong>เพิ่มประเภทสินค้าย่อย</strong>
                    </a>
                </div>
                <div class="mt-2">
                    <?php
                    $sql = "SELECT id_category, cat_name, zone_name,zone_detail
                            FROM category AS C
                            LEFT JOIN zone_detail AS Z ON C.zone_allow = Z.zone_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table class='table table-striped'>";
                        echo "<thead><tr><th>หมวดหมู่</th><th>หมวดหมู่ย่อย</th><th>โซนที่ใช้งาน</th><th>การกระทำ</th></tr></thead>";
                        echo "<tbody>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='category-item' data-category-id='" . $row["id_category"] . "'>";
                            echo "<td><strong>" . $row["cat_name"] . "</strong></td>";

                            // Initially hide subcategories, shown on click
                            echo "<td>";
                            $id_category = $row["id_category"];
                            $cat_name = $row["cat_name"];
                            $sub_sql = "SELECT * FROM sub_category WHERE id_category = $id_category";
                            $sub_result = $conn->query($sub_sql);
                            $subcategories = [];

                            if ($sub_result->num_rows > 0) {
                                echo "<ul class='subcategory-list' style='display:none;'>";
                                while ($sub_row = $sub_result->fetch_assoc()) {
                                    $subcategories[] = $sub_row["sub_cat_name"];
                                    echo "<li class='subcategory-item'>" . $sub_row["sub_cat_name"] . "</li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "No subcategories found for this category.";
                            }

                            $subcategories_str = implode(',', $subcategories);
                            echo "</td>";
                            echo "<td><strong>" . $row["zone_name"] . "(" . $row["zone_detail"] . ")</strong></td>";
                            echo "<td>";
                            echo "<button class='btn btn-sm mx-2 btn-warning edit-btn' 
                            type='button' 
                            data-bs-toggle='modal' 
                            data-bs-target='#EditModal' 
                            data-bs-id='" . htmlspecialchars($id_category) . "' 
                            data-bs-cat_name='" . htmlspecialchars($cat_name) . "' 
                            data-bs-sub_cat_name='" . htmlspecialchars($subcategories_str) . "'>
                            แก้ไข
                      </button>";
                            echo "<a href='#' class='btn btn-sm btn-danger' onclick='confirmDeleteCat(" . $id_category . ", \"" . $cat_name . "\"); return false;'>ลบ</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table>";
                    } else {
                        echo "0 results";
                    }
                    ?>
                </div>
                <script>
                    function confirmDeleteCat(id_category, cat_name) {
                        Swal.fire({
                            title: "คุณแน่ใจหรือไม่?",
                            text: "คุณกำลังจะลบ " + cat_name + " น้า",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "ใช่, ลบเลย!",
                            cancelButtonText: "ยกเลิก"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // หากผู้ใช้ยืนยันการลบ, รีไดเร็กต์ไปยัง delete_category.php พร้อม zone_id
                                window.location.href = 'delete_category.php?id_category=' + id_category;
                            }
                        });
                    }
                </script>
                <style>
                    .category-item {
                        cursor: pointer;
                    }
                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const categoryItems = document.querySelectorAll('.category-item');

                        categoryItems.forEach(item => {
                            item.addEventListener('click', function() {
                                const subcategoryList = this.querySelector('.subcategory-list');
                                if (subcategoryList.style.display === 'none') {
                                    subcategoryList.style.display = 'block';
                                } else {
                                    subcategoryList.style.display = 'none';
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Add Category Modal -->
    <div class="modal fade" id="AddCatModal" tabindex="-1" aria-labelledby="AddCatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AddCatModalLabel"><strong>เพิ่ม ประเภทหลัก และ ประเภทย่อย</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h1>เพิ่ม ประเภทหลัก และ ประเภทย่อย</h1>
                    <form action="./add_cat.php" method="post">
                        <div class="mb-3 row">
                            <label for="category" class="col-sm-3 col-form-label">
                                <strong>ประเภทหลัก:</strong>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="category" id="category" required oninput="checkRequired(this)">
                                <span class="text-danger req" style="font-size: 14px; display:none;" id="reqCategory">*จำเป็น</span>
                                <span style="color: red;">*จำเป็น</span> <!-- Added requirement text -->
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="sub_category" class="col-sm-3 col-form-label">
                                <strong>ประเภทย่อย (แยกคำด้วย,):</strong>
                                <p>ตัวอย่างการกรอก : *ของหวาน,ของคาว*</p>
                            </label>
                            <div class="col-sm-9">
                                <textarea style="height: 200px;" class="form-control" type="text" name="sub_category" id="sub_category" required oninput="checkRequired(this)"></textarea>
                                <span class="text-danger req" style="font-size: 14px; display:none;" id="reqSubCategory">*จำเป็น</span>
                                <span style="color: red;">*จำเป็น</span> <!-- Added requirement text -->
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="zone" class="col-sm-3 col-form-label">
                                <strong>โซนที่ใช้ได้:</strong>
                            </label>
                            <div class="col-sm-9">
                                <select name="zone" id="zone" class="form-select" required>
                                    <option value="#">กรุณาเลือกโซน</option>
                                    <?php
                                    // Correct SQL query to fetch zone details
                                    $sql = "SELECT z.zone_id, z.zone_name, z.zone_detail FROM zone_detail z ORDER BY z.zone_name;";

                                    $result = $conn->query($sql);

                                    // Check if there are any results
                                    if ($result->num_rows > 0) {
                                        // Loop through each zone and create an option
                                        while ($row = $result->fetch_assoc()) {
                                            // Create the option element
                                            echo '<option value="' . htmlspecialchars($row['zone_id']) . '">'
                                                . htmlspecialchars($row['zone_name']) . ' (' . htmlspecialchars($row['zone_detail']) . ')'
                                                . '</option>';
                                        }
                                    } else {
                                        // If no zones are found, show a default option
                                        echo '<option value="">ไม่มีโซน</option>';
                                    }
                                    ?>
                                </select>
                                <span style="color: red;">*จำเป็น</span> <!-- Added requirement text -->


                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <input class="btn btn-success" type="submit" value="เพิ่มประเภทสินค้า">
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- AddSubCatModal Modal -->
    <div class="modal fade" id="AddSubCatModal" tabindex="-1" aria-labelledby="AddSubCatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AddSubCatModalLabel"><strong>เพิ่มประเภทสินค้าย่อย</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                </div>
                <div class="modal-body">
                    <h1>เพิ่มประเภทย่อย</h1>
                    <form action="./add_sub_cat.php" method="post">
                        <div class="mb-3 row">
                            <label for="category" class="col-sm-3 col-form-label">
                                <strong>ประเภทหลัก:</strong>
                            </label>
                            <div class="col-sm-9">
                                <select name="category" id="category" class="form-select">
                                    <?php
                                    $sql = "SELECT * FROM category";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['id_category'] . '">' . $row['cat_name'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">ยังไม่มีการสร้างระเภทสินค้า</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="sub_category" class="col-sm-3 col-form-label">
                                <strong>ประเภทย่อย (แยกคำด้วย,):</strong>
                                <p>ตัวอย่างการกรอก : *ของหวาน,ของคาว*</p>
                            </label>
                            <div class="col-sm-9">
                                <textarea style="height: 200px;" class="form-control" type="text" name="sub_category" id="sub_category" required></textarea>
                                <span class="text-danger req" style="font-size: 14px;" id="reqZoneName">*จำเป็น</span>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <input class="btn btn-success" type="submit" value="เพิ่มประเภทสินค้าย่อย">

                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- EDIT MODAL -->
    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="update_category.php" method="POST">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="EditModalLabel"><strong>อัพเดตประเภทหลักและประเภทย่อย</strong></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h1>แก้ไข ประเภทหลัก และ ประเภทย่อย</h1>
                        <input type="hidden" name="cat_id" id="cat_id">
                        <div class="mb-3 row">
                            <label for="cat_name_data" class="col-sm-3 col-form-label"><strong>ประเภทหลัก:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="cat_name" id="cat_name_data" required>
                                <span style="color: red;">*จำเป็น</span> <!-- Added requirement text -->
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="zone_detail" class="col-sm-3 col-form-label"><strong>ประเภทย่อย (แยกคำด้วย ,):</strong></label>
                            <p>ตัวอย่างการกรอก : *ของหวาน,ของคาว*</p>
                            <div class="col-sm-9">
                                <textarea style="height: 200px;" class="form-control" name="sub_cat_name" id="zone_detail" required></textarea>
                                <span style="color: red;">*จำเป็น</span> <!-- Added requirement text -->
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="zone" class="col-sm-3 col-form-label"><strong>โซนที่ใช้ได้:</strong></label>
                            <div class="col-sm-9">
                                <select name="zone" id="zone" class="form-select" required>
                                    <option value="#">กรุณาเลือกโซน</option>
                                    <?php
                                    // Correct SQL query to fetch zone details
                                    $sql = "SELECT z.zone_id, z.zone_name, z.zone_detail FROM zone_detail z ORDER BY z.zone_name;";

                                    $result = $conn->query($sql);

                                    // Check if there are any results
                                    if ($result->num_rows > 0) {
                                        // Loop through each zone and create an option
                                        while ($row = $result->fetch_assoc()) {
                                            // Create the option element
                                            echo '<option value="' . htmlspecialchars($row['zone_id']) . '">'
                                                . htmlspecialchars($row['zone_name']) . ' (' . htmlspecialchars($row['zone_detail']) . ')'
                                                . '</option>';
                                        }
                                    } else {
                                        // If no zones are found, show a default option
                                        echo '<option value="">ไม่มีโซน</option>';
                                    }
                                    ?>
                                </select>
                                <span style="color: red;">*จำเป็น</span> <!-- Added requirement text -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-success">อัพเดต</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        var editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var catId = this.getAttribute('data-bs-id');
                var catName = this.getAttribute('data-bs-cat_name');
                var subCatName = this.getAttribute('data-bs-sub_cat_name');

                // Log the values to the console
                console.log("catId:", catId);
                console.log("catName:", catName);
                console.log("subCatName:", subCatName);

                // Set the old values in the input fields
                document.getElementById('cat_id').value = catId; // Hidden field for category ID
                document.getElementById('cat_name_data').value = catName; // Main category name
                document.getElementById('zone_detail').value = subCatName; // Subcategory names (textarea)

                // Show the modal
                var editModal = new bootstrap.Modal(document.getElementById('EditModal'));
                editModal.show();
            });
        });
    </script>


</body>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('.question-icon'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            html: true
        });
    });
</script>

</html>