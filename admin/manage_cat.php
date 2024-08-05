<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<script>alert("กรุณาล็อคอินก่อน"); window.location.href = "../admin/login.php";</script>';
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
    <title>Index</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="row g-2">
        <!-- btn sidebar -->
        <div class="col-12 d-flex justify-content-between px-5 py-3">
            <div class="col-4">
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-window-sidebar" viewBox="0 0 16 16">
                        <path d="M2.5 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1 .5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                        <path d="M2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v2H1V3a1 1 0 0 1 1-1zM1 13V6h4v8H2a1 1 0 0 1-1-1m5 1V6h9v7a1 1 0 0 1-1 1z" />
                    </svg>
                </button>
                <!-- sidebar -->
                <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                    <div class="offcanvas-header">
                        <h3 class="offcanvas-title" id="offcanvasWithBothOptionsLabel"><strong>เมนูเพิ่มเติม</strong></h3>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-flex flex-column mb-3 ">
                        <a href="#" type="button" class="btn btn-primary m-2">สถิติการจอง</a>
                        <a href="./view_member.php" type="button" class="btn btn-primary m-2">ดูรายชื่อสมาชิก</a>
                        <a href="#" type="button" class="btn btn-primary m-2">ตรวจสอบการชำระเงิน</a>
                        <a href="#" type="button" class="btn btn-primary m-2">ยืนยันการจอง</a>
                        <a href="#" type="button" class="btn btn-primary m-2">ยกเลิกการจอง</a>
                    </div>
                </div>
                <a href="./index.php" class="btn btn-success" type="button">
                    <strong>กลับสู่หน้าแรก</strong>
                </a>
                <h1><strong>ระบบจัดการประเภทสินค้า</strong></h1>
            </div>
            <!-- profile btn -->
            <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#ProfileModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                </svg>
            </button>
            <!-- Modal -->
            <div class="modal fade" id="ProfileModal" tabindex="-1" aria-labelledby="ProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="ProfileModalLabel"><strong>โปรไฟล์ผู้ใช้งาน</strong></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>UserID:</strong> <?php echo $user_id; ?></p>
                            <p><strong>Username:</strong> <?php echo $username; ?></p>
                            <p><strong>shop_name:</strong> <?php echo $shop_name; ?></p>
                            <p><strong>ชื่อ-นามสกุล:</strong> <?php echo $fullname; ?></p>
                            <p><strong>เบอร์โทรศัพท์:</strong> <?php echo $tel; ?></p>
                            <p><strong>อีเมล:</strong> <?php echo $email; ?></p>
                            <div class=" d-flex align-items-start">
                                <p><strong>ประเภทผู้ใช้งาน:</strong> <?php echo $userrole; ?></p>
                                <span class="question-icon mx-2" data-bs-toggle="tooltip" data-bs-placement="right" title="0 ผู้ใช้งานทั่วไป&lt;br&gt;1 แอดมิน/ผู้ดูแลระบบ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-question-fill" viewBox="0 0 16 16">
                                        <path d="M5.933.87a2.89 2.89 0 0 1 4.134 0l.622.638.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622-.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01zM7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0m1.602-2.027c.04-.534.198-.815.846-1.26.674-.475 1.05-1.09 1.05-1.986 0-1.325-.92-2.227-2.262-2.227-1.02 0-1.792.492-2.1 1.29A1.7 1.7 0 0 0 6 5.48c0 .393.203.64.545.64.272 0 .455-.147.564-.51.158-.592.525-.915 1.074-.915.61 0 1.03.446 1.03 1.084 0 .563-.208.885-.822 1.325-.619.433-.926.914-.926 1.64v.111c0 .428.208.745.585.745.336 0 .504-.24.554-.627" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="./logout.php" type="button" class="btn btn-danger">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- timer -->
        <div class="col-12 d-flex justify-content-between px-5">
            <strong>
                <div id="time"></div>
                <div id="#">(ระบบปิด)</div>
            </strong>
            <strong>
                <div id="#">ระบบเปิดเวลา : <a href="#">00:00:00</a></div>
                <a href="#">แก้ไขเวลาเปิด-ปิด</a>
            </strong>
        </div>
        <!-- Display -->
        <div class="container mt-2 p-2 border border-dark-subtle rounded overflow-auto" style="width: 60%; height: 40rem;">
            <ul class="nav nav-tabs" id="myTab">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#categort"><strong>ประเภทสินค้า</strong> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#pre_category"> <strong>คำขอเพิ่มประเภทสินค้า</strong></a>
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
                        $sql = "SELECT * FROM category";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table class='table table-striped'>";
                            echo "<thead><tr><th>Category</th><th>Subcategories</th><th>Actions</th></tr></thead>";
                            echo "<tbody>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='category-item' data-category-id='" . $row["id_category"] . "'>";
                                echo "<td><strong>" . $row["cat_name"] . "</strong></td>";

                                // Initially hide subcategories, shown on click
                                echo "<td>";
                                $id_category = $row["id_category"];
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

                                $subcategories_str = implode(' ', $subcategories);
                                echo "</td>";
                                echo "<td>";
                                echo "<button class='btn btn-sm mx-2 btn-warning edit-btn' 
                        type='button' 
                        data-bs-toggle='modal' 
                        data-bs-target='#EditModal' 
                        data-bs-id='" . $row["id_category"] . "' 
                        data-bs-cat_name='" . $row["cat_name"] . "'
                        data-bs-sub_cat_name='" . $subcategories_str . "'>Edit</button>";
                                echo "<a href='delete_category.php?id=" . $row["id_category"] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this category?\");'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "0 results";
                        }
                        ?>
                    </div>

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


                <div class="tab-pane fade mt-2 mx-2 p-2" id="pre_category">
                    <div class="">
                        <h1>คำขอเพิ่มประเภทสินค้า</h1>
                    </div>
                    <div class="mt-2">
                        <p>This is the home page of the tabbed navigation.</p>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- Add Category Modal -->
        <div class="modal fade" id="AddCatModal" tabindex="-1" aria-labelledby="AddCatModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="AddCatModalLabel"><strong>AddCatModal</strong></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h1>เพิ่ม Category และ Subcategory</h1>
                        <form action="./add_cat.php" method="post">
                            <div class="mb-3 row">
                                <label for="category" class="col-sm-3 col-form-label">
                                    <strong>Category:</strong>
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="category" id="category" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="sub_category" class="col-sm-3 col-form-label">
                                    <strong>Subcategories (แยกคำด้วยการเว้นวรรค):</strong>
                                    <p>ตัวอย่างการกรอก : *ของหวาน ของคาว*</p>
                                </label>
                                <div class="col-sm-9">
                                    <textarea style="height: 200px;" class="form-control" type="text" name="sub_category" id="sub_category" required></textarea>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input class="btn btn-success" type="submit" value="Submit">

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
                        <h1 class="modal-title fs-5" id="AddSubCatModalLabel"><strong>AddSubCatModal</strong></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h1>เพิ่ม Subcategory</h1>
                        <form action="./add_sub_cat.php" method="post">
                            <div class="mb-3 row">
                                <label for="category" class="col-sm-3 col-form-label">
                                    <strong>Category:</strong>
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
                                            echo '<option value="">No categories found</option>';
                                        }
                                        $conn->close();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="sub_category" class="col-sm-3 col-form-label">
                                    <strong>Subcategories (แยกคำด้วยการเว้นวรรค):</strong>
                                    <p>ตัวอย่างการกรอก : *ของหวาน ของคาว*</p>
                                </label>
                                <div class="col-sm-9">
                                    <textarea style="height: 200px;" class="form-control" type="text" name="sub_category" id="sub_category" required></textarea>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input class="btn btn-success" type="submit" value="Submit">

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
                            <h1 class="modal-title fs-5" id="EditModalLabel"><strong>Edit Zone</strong></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h1>เพิ่ม Category และ Subcategory</h1>
                            <input type="hidden" name="cat_id" id="zone_id">
                            <div class="mb-3 row">
                                <label for="zone_name" class="col-sm-3 col-form-label"><strong>Category:</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="cat_name" id="zone_name" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="zone_detail" class="col-sm-3 col-form-label"><strong>Subcategories (แยกคำด้วยการเว้นวรรค):</strong></label>
                                <p>ตัวอย่างการกรอก : *ของหวาน ของคาว*</p>
                                <div class="col-sm-9">
                                    <textarea style="height: 200px;" class="form-control" type="text" name="sub_cat_name" id="zone_detail" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">อัพเดต</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editButtons = document.querySelectorAll('.edit-btn');

                editButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        var catId = this.getAttribute('data-bs-id');
                        var catName = this.getAttribute('data-bs-cat_name');
                        var subCatName = this.getAttribute('data-bs-sub_cat_name');

                        document.getElementById('zone_id').value = catId;
                        document.getElementById('zone_name').value = catName;
                        document.getElementById('zone_detail').value = subCatName;
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editButtons = document.querySelectorAll('.edit-btn');

                editButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        var catId = this.getAttribute('data-bs-id');
                        var catName = this.getAttribute('data-bs-cat_name');
                        var subCatName = this.getAttribute('data-bs-sub_cat_name');

                        document.getElementById('zone_id').value = catId;
                        document.getElementById('zone_name').value = catName;
                        document.getElementById('zone_detail').value = subCatName;
                    });
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
<script src="../asset/js/time_couter.js"></script>

</html>