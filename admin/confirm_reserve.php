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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zone_id'])) {
    $zoneId = $_POST['zone_id'];
    $sql = "SELECT pricePerDate, pricePerMonth FROM zone_detail WHERE zone_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $zoneId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(array(
            "pricePerDate" => $row['pricePerDate'],
            "pricePerMonth" => $row['pricePerMonth']
        ));
    } else {
        echo json_encode(array(
            "pricePerDate" => "N/A",
            "pricePerMonth" => "N/A"
        ));
    }
    exit; // Ensure no further output is sent 
}

if (isset($_GET['category_id'])) {
    $categoryId = intval($_GET['category_id']);
    $sql = "SELECT * FROM sub_category WHERE id_category = $categoryId";
    $result = $conn->query($sql);

    $subcategories = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subcategories[] = $row;
        }
    }
    echo json_encode($subcategories);
    exit;
}
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
        <div class="col-12 d-flex justify-content-between px-3 py-3">
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
                        <a href="#" type="button" class="btn btn-primary m-2">ประวัติการจอง</a>
                        <a href="#" type="button" class="btn btn-primary m-2">แสดงความคิดเห็น</a>
                    </div>
                </div>
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
                            <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#EditModal">Edit Profile</button>
                            <a href="./logout.php" type="button" class="btn btn-danger">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Profile Modal -->
            <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="update_profile.php" method="POST">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="EditModalLabel"><strong>โปรไฟล์ผู้ใช้งาน</strong></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>UserID:</strong> <?php echo $user_id; ?></p>
                                <p><strong>Username:</strong> <?php echo $username; ?></p>
                                <div class="mb-3 row">
                                    <label for="shopname" class="col-sm-3 col-form-label"><strong>shop_name:</strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="editshopname" id="editshopname" value="<?php echo $shop_name; ?>">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="fullname" class="col-sm-3 col-form-label"><strong>ชื่อ-นามสกุล:</strong></label>
                                    <div class="col-sm-3">
                                        <select id="prefixSelect" class="form-control" name="editprefix">
                                            <option value="นาย">นาย</option>
                                            <option value="นาง">นาง</option>
                                            <option value="นางสาว">นางสาว</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="editfirstname" value="<?php echo $firstname; ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="editlastname" value="<?php echo $lastname; ?>">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="tel" class="col-sm-3 col-form-label"><strong>เบอร์โทรศัพท์:</strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="edittel" id="edittel" value="<?php echo $tel; ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="email" class="col-sm-3 col-form-label"><strong>อีเมล:</strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="editemail" id="editemail" value="<?php echo $email; ?>">
                                    </div>
                                </div>

                                <div class="d-flex align-items-start">
                                    <p><strong>ประเภทผู้ใช้งาน:</strong> <?php echo $userrole; ?></p>
                                    <span class="question-icon mx-2" data-bs-toggle="tooltip" data-bs-placement="right" title="0 ผู้ใช้งานทั่วไป&lt;br&gt;1 แอดมิน/ผู้ดูแลระบบ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-question-fill" viewBox="0 0 16 16">
                                            <path d="M5.933.87a2.89 2.89 0 0 1 4.134 0l.622.638.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622-.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01zM7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0m1.602-2.027c.04-.534.198-.815.846-1.26.674-.475 1.05-1.09 1.05-1.986 0-1.325-.92-2.227-2.262-2.227-1.02 0-1.792.492-2.1 1.29A1.7 1.7 0 0 0 6 5.48c0 .393.203.64.545.64.272 0 .455-.147.564-.51.158-.592.525-.915 1.074-.915.61 0 1.03.446 1.03 1.084 0 .563-.208.885-.822 1.325-.619.433-.926.914-.926 1.64v.111c0 .428.208.745.585.745.336 0 .504-.24.554-.627" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">อัพเดตโปรไฟล์</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- timer -->
        <div class="col-12 d-flex justify-content-between px-3">
            <strong>
                <div id="time"></div>
                <div id="#">(ระบบปิด)</div>
            </strong>
            <strong>
                <div id="#">ระบบเปิดเวลา : 00:00:00</div>
            </strong>
        </div>
        <!-- Display -->
        <div class="container mt-4">
            <div class="container ">
                <div class="row d-flex justify-content-center align-item-center">
                    <div class="col-12 d-flex flex-wrap justify-content-center align-item-center">
                        <?php
                        $sql = "SELECT * FROM zone_detail";
                        if ($result = $conn->query($sql)) {
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '
                                    <div class="">
                                       <div class="row ">
                                            <div class="col">
                                                <div class="d-flex justify-content-start">
                                                        <div class="">
                                                        <p class="zone_detail" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="right" 
                                                            title="รายวัน ' . $row["pricePerDate"] . '฿<br>รายเดือน ' . $row["pricePerMonth"] . '฿">
                                                            โซน: <strong>' . $row["zone_name"] . '</strong><br>(' . $row["zone_detail"] . ')
                                                        </p>
                                                        </div>
                                                </div>
                                        </div>
                                    </div>
                                    ';
                                    $sql2 = "SELECT * FROM locks WHERE zone_id = " . $row["zone_id"];
                                    if ($result2 = $conn->query($sql2)) {
                                        if ($result2->num_rows > 0) {
                                            echo '<div class="d-flex flex-wrap container-md">';
                                            while ($row2 = $result2->fetch_assoc()) {
                                                echo '<div class="mx-2">';
                                                echo '<p>';
                                                if ($row2["available"] == 0) {
                                                    echo '
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                    </svg>';
                                                } else if ($row2["available"] == 1) {
                                                    echo '
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
                                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2z"/>
                                                </svg>';
                                                }
                                                echo '</p>';
                                                echo '</div>';
                                            }
                                            echo '</div>';
                                        } else {
                                            echo "<p>ยังไม่มีการสร้างข้อมูลพื้นที่การขาย</p>";
                                        }
                                        $result2->free();
                                    } else {
                                        echo "<p>Error in nested query: " . $conn->error . "</p>";
                                    }
                                }
                            } else {
                                echo "<p><strong>ยังไม่มีการสร้างข้อมูลพื้นที่การขาย</strong></p>";
                            }
                            $result->free();
                        } else {
                            echo "<p>Error in main query: " . $conn->error . "</p>";
                        }
                        ?>
                    </div>
                    <!--Avaliable--->
                    <div class="container-md d-flex justify-content-center p-2 m-2">
                        <div class="px-2 mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                            </svg>
                            <strong>ว่าง</strong>
                        </div>
                        <div class="px-2 mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
                                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2z" />
                            </svg>
                            <strong>ไม่ว่าง</strong>
                        </div>
                    </div>
                    <!-- Display -->
                    <div class="tab-content border" id="myTabContent">
                        <div class="tab-pane fade show active mt-2 mx-2 p-2" id="category">
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="d-flex w-50 justify-content-start align-items-center">
                                    <h1>คำขอจองพื้นที่</h1>
                                    <div class="mx-3 d-flex align-items-end">
                                        <select id="filterType" name="filterType" class="form-select">
                                            <option value="all">ทั้งหมด</option>
                                            <option value="PerDay">ต่อวัน</option>
                                            <option value="PerMonth">ต่อเดือน</option>
                                        </select>
                                        <button id="resetFilter" class="btn btn-secondary mx-2">รีเซ็ต</button>
                                    </div>
                                </div>
                                <p>กำลังดำเนินการโดย <?php echo htmlspecialchars($fullname); ?></p>
                            </div>
                            <div class="mt-2"></div>
                            <div class="mt-2" id="bookingTable">
                                <?php
                                // PHP Code to handle pagination and filtering
                                $filterType = isset($_GET['filterType']) ? $_GET['filterType'] : 'all';
                                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                $recordsPerPage = 10; // Number of records to show per page
                                $offset = ($currentPage - 1) * $recordsPerPage;

                                // Base SQL query
                                $sql = "SELECT BK.booking_id, BK.booking_status, ZD.zone_name, ZD.zone_detail, C.cat_name, SC.sub_cat_name, BK.booking_type, BK.booking_amount, BK.slip_img, BS.status, BK.booking_date 
                                        FROM booking AS BK 
                                        INNER JOIN booking_status AS BS ON BK.booking_status = BS.id
                                        INNER JOIN category AS C ON BK.product_type = C.id_category
                                        INNER JOIN sub_category AS SC ON BK.sub_product_type = SC.idsub_category
                                        INNER JOIN zone_detail AS ZD ON BK.zone_id = ZD.zone_id";

                                // Add filter condition if needed
                                if ($filterType == 'PerDay') {
                                    $sql .= " WHERE BK.booking_type = 'PerDay'";
                                } elseif ($filterType == 'PerMonth') {
                                    $sql .= " WHERE BK.booking_type = 'PerMonth'";
                                }

                                // Add limit and offset for pagination
                                $sql .= " LIMIT $offset, $recordsPerPage";

                                $result = $conn->query($sql);

                                // Get total number of records for pagination
                                $countSql = "SELECT COUNT(*) AS total FROM booking";
                                if ($filterType == 'PerDay') {
                                    $countSql .= " WHERE booking_type = 'PerDay'";
                                } elseif ($filterType == 'PerMonth') {
                                    $countSql .= " WHERE booking_type = 'PerMonth'";
                                }
                                $countResult = $conn->query($countSql);
                                $totalRecords = $countResult->fetch_assoc()['total'];
                                $totalPages = ceil($totalRecords / $recordsPerPage);

                                if ($result->num_rows > 0) {
                                    echo "<table class='table table-striped'>";
                                    echo "<thead>
                        <tr>
                            <th>ชื่อโซน</th>
                            <th>รายละเอียดโซน</th>
                            <th>หมวดหมู่</th>
                            <th>หมวดหมู่ย่อย</th>
                            <th>ประเภทการจอง</th>
                            <th>จำนวนการจอง</th>
                            <th>สถานะ</th>
                            <th>วันที่จอง</th>
                            <th>การกระทำ</th>
                        </tr>
                      </thead>";
                                    echo "<tbody>";

                                    while ($row = $result->fetch_assoc()) {
                                        $booking_date = date("d/m/Y เวลา H:i", strtotime($row["booking_date"]));
                                        $slip_img = $row["slip_img"] ? "<img src='" . htmlspecialchars($row["slip_img"]) . "' alt='Slip Image' style='width: 50px; height: auto;'>" : "ยังไม่มีการอัพโหลดสลิป";

                                        echo "<tr>
                            <td>" . htmlspecialchars($row["zone_name"]) . "</td>
                            <td>" . htmlspecialchars($row["zone_detail"]) . "</td>
                            <td>" . htmlspecialchars($row["cat_name"]) . "</td>
                            <td>" . htmlspecialchars($row["sub_cat_name"]) . "</td>
                            <td>" . htmlspecialchars($row["booking_type"]) . "</td>
                            <td>" . htmlspecialchars($row["booking_amount"]) . "</td>
                            <td>" . htmlspecialchars($row["status"]) . "</td>
                            <td>" . $booking_date  . "</td>";
                                        switch ($row["booking_status"]) {
                                            case 1:
                                                echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    </td>";
                                                break;
                                            case 2:
                                                echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    <button class='btn btn-sm btn-success m-2' type='button' data-bs-toggle='modal' data-bs-target='#ConfirmModal' data-id='" . $row["booking_id"] . "'>ปรับเปลี่ยนสถานะ/ให้เลขล็อค</button>
                                    </td>";
                                                break;
                                            case 3:
                                                echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    <button class='btn btn-sm btn-success m-2' type='button' data-bs-toggle='modal' data-bs-target='#ConfirmModal' data-id='" . $row["booking_id"] . "'>ปรับเปลี่ยนสถานะ/ให้เลขล็อค</button>
                                    </td>";
                                                break;
                                            case 4:
                                                echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    </td>";
                                                break;
                                            case 5:
                                                echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    <a href='cancel_booking.php?booking_id=" . $row["booking_id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"คุณแน่ใจหรือว่าต้องการยกเลิกการจองนี้?\")'>ยกเลิก</a>
                                    </td>";
                                                break;
                                            case 6:
                                                echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    </td>";
                                                break;
                                            default:
                                                echo "ไม่ทราบสถานะ";
                                        }
                                        echo "</tr>";
                                    }

                                    echo "</tbody></table>";

                                    // Display pagination
                                    if ($totalPages > 1) {
                                        echo "<nav aria-label='Page navigation example'>";
                                        echo "<ul class='pagination'>";
                                        for ($i = 1; $i <= $totalPages; $i++) {
                                            $activeClass = ($i == $currentPage) ? 'active' : '';
                                            echo "<li class='page-item $activeClass'><a class='page-link' href='?filterType=$filterType&page=$i'>$i</a></li>";
                                        }
                                        echo "</ul>";
                                        echo "</nav>";
                                    }
                                } else {
                                    echo "ยังไม่ได้มีการจอง";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.getElementById('filterType').addEventListener('change', function() {
                            const filterType = this.value;
                            const url = new URL(window.location.href);
                            url.searchParams.set('filterType', filterType);
                            url.searchParams.delete('page'); // Reset to first page on filter change
                            window.location.href = url.toString();
                        });

                        document.getElementById('resetFilter').addEventListener('click', function() {
                            const url = new URL(window.location.href);
                            url.searchParams.delete('filterType');
                            url.searchParams.delete('page');
                            window.location.href = url.toString();
                        });
                    </script>


                    <!-- View Modal -->
                    <div class="modal fade" id="viewBookingModal" tabindex="-1" aria-labelledby="viewBookingModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="viewBookingModalLabel"><strong>รายละเอียดการจอง</strong></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Content will be dynamically filled by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            // ฟังการคลิกเพื่อเปิดโมดัล
                            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                                button.addEventListener('click', function() {
                                    const bookingId = this.getAttribute('data-id');
                                    fetchBookingDetails(bookingId);
                                });
                            });

                            function fetchBookingDetails(bookingId) {
                                fetch('fetch_booking_details.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded',
                                        },
                                        body: new URLSearchParams({
                                            'fetch_booking_details': 1,
                                            'booking_id': bookingId
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        let content = '';
                                        if (data.error) {
                                            content = `<p>${data.error}</p>`;
                                        } else {
                                            content = `
                                                    <p><strong>หมายเลขการจอง:</strong> ${data.booking_id}</p>
                                                    <p><strong>ชื่อโซน:</strong> ${data.zone_name}</p>
                                                    <p><strong>รายละเอียดโซน:</strong> ${data.zone_detail}</p>
                                                    <p><strong>ชื่อหมวดหมู่:</strong> ${data.cat_name}</p>
                                                    <p><strong>ชื่อหมวดหมู่ย่อย:</strong> ${data.sub_cat_name}</p>
                                                    <p><strong>ประเภทการจอง:</strong> ${data.booking_type}</p>
                                                    <p><strong>จำนวนเงินการจอง:</strong> ${data.booking_amount}</p>
                                                    <p><strong>สถานะ:</strong> ${data.status}</p>
                                                    <p><strong>วันที่การจอง:</strong> ${data.booking_date}</p>
                                                    <p><strong>เลขล็อคที่ได้รับ:</strong> ${data.book_lock_number}</p>
                                                `;
                                            if (data.slip_img) {
                                                content += `<img src="../asset./slip_img./${data.slip_img}" alt="ภาพใบเสร็จ" class="img-fluid">`;
                                                content += `<button class="btn btn-success">ยืนยันการชำระเงิน</button>`;
                                            } else {
                                                switch (parseInt(data.booking_status, 10)) {
                                                    case 1:
                                                        content += `<button class="btn btn-success">แจ้งชำระเงิน</button>`;
                                                        break;
                                                    case 2:
                                                        content += `<button class="btn btn-success">แจ้ง</button>`;
                                                        break;
                                                    case 3:
                                                        content += `<button class="btn btn-success">ชำ</button>`;
                                                        break;
                                                    case 4:
                                                        content += `<button class="btn btn-success">ระ</button>`;
                                                        break;
                                                    case 5:
                                                        content += `<button class="btn btn-danger">ยืนยันการยกเลิก</button>`;
                                                        break;
                                                    case 6:
                                                        content += `<strong style="color: red;">ยกเลิกเรียบร้อยแล้ว</strong>`;
                                                        break;
                                                    default:
                                                        content += `<p>ไม่ทราบสถานะ</p>`;
                                                        break;
                                                }
                                            }
                                        }
                                        document.querySelector('#viewBookingModal .modal-body').innerHTML = content;
                                    })
                                    .catch(error => {
                                        console.error('เกิดข้อผิดพลาดในการดึงข้อมูลการจอง:', error);
                                        document.querySelector('#viewBookingModal .modal-body').innerHTML = '<p>มีข้อผิดพลาดในการดึงข้อมูลการจอง</p>';
                                    });
                            }
                        });
                    </script>
                    <!-- Confirm Modal -->
                    <div class="modal fade" id="ConfirmModal" tabindex="-1" aria-labelledby="ConfirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="ConfirmModalLabel"><strong>ยืนยันการจอง/ปรับเปลี่ยนสถานะ</strong></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="updateForm" method="POST" action="update_locks.php">
                                        <input type="hidden" id="bookingId" name="booking_id" value="">
                                        <input type="hidden" id="zoneId" name="zone_id" value="">
                                        <div class="mb-3">
                                            <label for="zoneSelect" class="form-label">เลือกโซน</label>
                                            <select class="form-select" id="zoneSelect" name="zone_id">
                                                <option value="" selected>กรุณาเลือกโซน</option>
                                                <?php
                                                include('connect.php'); // รวมการเชื่อมต่อฐานข้อมูล

                                                $sql = "SELECT * FROM zone_detail";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<option value="' . htmlspecialchars($row['zone_id']) . '">' . htmlspecialchars($row['zone_name']) . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">ไม่มีข้อมูล</option>';
                                                }

                                                $conn->close();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="display_locks">
                                            <!-- ข้อมูลจะถูกแสดงที่นี่ -->
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">อัพเดตข้อมูล</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#zoneSelect').on('change', function() {
                                var selectedZone = $(this).val();

                                if (selectedZone) {
                                    $.ajax({
                                        url: 'fetch_locks.php',
                                        method: 'POST',
                                        data: {
                                            zone_id: selectedZone
                                        },
                                        success: function(response) {
                                            $('.display_locks').html(response);
                                        },
                                        error: function() {
                                            $('.display_locks').html('<p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p>');
                                        }
                                    });
                                } else {
                                    $('.display_locks').html('กรุณาเลือกโซน');
                                }
                            });

                            $(document).on('click', '.lock-btn', function() {
                                var checkbox = $(this).siblings('.lock-checkbox');
                                var isChecked = checkbox.prop('checked');
                                checkbox.prop('checked', !isChecked);
                                $(this).toggleClass('active', !isChecked);
                            });

                            // Event listener for modal button to set hidden fields
                            $('#ConfirmModal').on('show.bs.modal', function(event) {
                                var button = $(event.relatedTarget); // Button that triggered the modal
                                var bookingId = button.data('id'); // Extract info from data-* attributes
                                var zoneId = button.data('zone-id'); // Extract info from data-* attributes (if applicable)
                                var modal = $(this);
                                modal.find('#bookingId').val(bookingId);
                                modal.find('#zoneId').val(zoneId);
                            });
                        });
                    </script>

                    <style>
                        .lock-btn.active {
                            background-color: #007bff;
                            color: white;
                            border-color: #007bff;
                        }
                    </style>



    </nav>
</body>
<script src="../asset/js/time_couter.js"></script>

</html>