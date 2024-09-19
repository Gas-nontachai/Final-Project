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
    <title>ยืนยันการจอง/ปรับเปลี่ยนสถานะ</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
    <style>
        body {
            background-image: url(../asset/img/img.market2.jpg);
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
    <div class="container mt-4 bgcolor py-4 rounded">
        <div class="container ">
            <div class="d-flex flex-column overflow-auto">


                <!-- Display -->
                <div class="col-12 container my-4 p-2 border rounded overflow-auto" style="width: 100%; height: 40rem; background-color: rgba(255, 255, 255);">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab1Content"><strong>คำขอจองพื้นที่</strong></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab2Content"><strong>ได้รับเลขล็อคแล้ว</strong></a>
                        </li>
                    </ul>

                    <div class="tab-content  p-3">
                        <!-- Tab 1: คำขอจองพื้นที่ -->
                        <div class="tab-pane fade show active" id="tab1Content">
                            <div class="mt-2" id="bookingTable1">
                                <div class="tab-pane fade show active mt-2 mx-2 p-2" id="category">
                                    <div class="d-flex justify-content-between align-items-end">
                                        <p>กำลังดำเนินการโดย <?php echo htmlspecialchars($fullname); ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- ฟอร์มค้นหา -->
                                        <form method="get" class="mb-3">
                                            <input type="text" name="search" placeholder="ค้นหาด้วยรหัสการจอง" class="form-control" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                                            <button type="submit" class="btn btn-primary mt-2">ค้นหา</button>
                                        </form>
                                        <!-- การแบ่งหน้า -->
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-3">
                                                <?php
                                                // ตรวจสอบและกำหนดค่าตัวแปร $page
                                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                                $totalPages = isset($totalPages) ? $totalPages : 1; // กำหนดค่าเริ่มต้นให้ $totalPages

                                                if ($page > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">ก่อนหน้า</a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                                <?php if ($page < $totalPages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">ถัดไป</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="mt-2" id="bookingTable">
                                        <?php
                                        $search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
                                        $searchCondition = $search ? "AND BK.booking_id LIKE '%$search%'" : '';

                                        $itemsPerPage = 10;
                                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $offset = ($page - 1) * $itemsPerPage;

                                        // การดึงข้อมูล
                                        $sql = "SELECT BK.total_price, BK.booking_id, CONCAT(U.prefix, U.firstname , ' ', U.lastname) AS fullname, BS.status, BK.booking_status, ZD.zone_name, ZD.zone_detail, C.cat_name, SC.sub_cat_name, BK.booking_type, BK.booking_amount, BK.slip_img, BK.booking_date 
                                                FROM booking AS BK 
                                                INNER JOIN booking_status AS BS ON BK.booking_status = BS.id
                                                INNER JOIN tbl_user AS U ON BK.member_id = U.user_id
                                                INNER JOIN category AS C ON BK.product_type = C.id_category
                                                INNER JOIN sub_category AS SC ON BK.sub_product_type = SC.idsub_category
                                                INNER JOIN zone_detail AS ZD ON BK.zone_id = ZD.zone_id
                                                WHERE booking_status != 4
                                                $searchCondition
                                                ORDER BY BK.booking_date DESC
                                                LIMIT $itemsPerPage OFFSET $offset";

                                        $result = $conn->query($sql);

                                        // การคำนวณจำนวนหน้าทั้งหมด
                                        $totalResult = $conn->query("SELECT COUNT(*) AS total FROM booking WHERE booking_status != 1 AND booking_status != 2 AND booking_status != 3 $searchCondition");
                                        $totalRow = $totalResult->fetch_assoc()['total'];
                                        $totalPages = ceil($totalRow / $itemsPerPage);

                                        if ($result->num_rows > 0) { ?>
                                            <ul class="list-group">
                                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <span> <strong><?php echo $row['booking_id']; ?></strong> </span>
                                                                <span><?php echo $row['fullname']; ?></span>
                                                                <p>
                                                                    <strong>
                                                                        ยอดทั้งหมด <?php echo htmlspecialchars($row['total_price']); ?> บาท
                                                                    </strong>
                                                                </p>
                                                                <p>
                                                                    <strong>
                                                                        สถานะ : <?php
                                                                                if ($row["booking_status"] === '4' || $row["booking_status"] === '8') {
                                                                                    echo "<span style='color: #06D001;'>" . htmlspecialchars($row["status"]) . "</span>";
                                                                                } else if ($row["booking_status"] === '1' || $row["booking_status"] === '2' || $row["booking_status"] === '3' || $row["booking_status"] === '9') {
                                                                                    echo "<span style='color: orange;'>" . htmlspecialchars($row["status"]) . "</span>";
                                                                                } else {
                                                                                    echo "<span style='color: red ;'>" . htmlspecialchars($row["status"]) . "</span>";  // You can change 'green' to any other color or style you prefer
                                                                                }



                                                                                ?>
                                                                    </strong>
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                    <span>วันที่จอง : <?php echo $row['booking_date']; ?></span>
                                                                    <br>
                                                                    <span>วันที่หมดอายุการจอง :<?php if ($row["booking_status"] === '4') {
                                                                                                    echo "<span>" . htmlspecialchars($row["expiration_date"]) . "</span>";
                                                                                                } else {
                                                                                                    echo "<span>คำขอยังไม่สมบูรณ์</span>";
                                                                                                } ?></span>
                                                                </div>
                                                                <div class="mt-1">

                                                                    <?php switch ($row["booking_status"]) {
                                                                        case 1:
                                                                            echo " <td>
                                        <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                        </td>";
                                                                            break;
                                                                        case 2:
                                                                            echo " <td>
                                        <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                        <button class='btn btn-sm btn-success m-2' type='button' data-bs-toggle='modal' data-bs-target='#ConfirmModal' data-id='" . $row["booking_id"] . "'  data-name='" . $row["zone_name"] . "'  data-amount='" . $row["booking_amount"] . "'>ปรับเปลี่ยนสถานะ/ให้เลขล็อค</button>
                                        </td>";
                                                                            break;
                                                                        case 3:
                                                                            echo " <td>
                                        <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                        <button class='btn btn-sm btn-success m-2' type='button' data-bs-toggle='modal' data-bs-target='#ConfirmModal' data-id='" . $row["booking_id"] . "'  data-name='" . $row["zone_name"] . "'  data-amount='" . $row["booking_amount"] . "'>ปรับเปลี่ยนสถานะ/ให้เลขล็อค</button>
                                        </td>";
                                                                            break;
                                                                        case 5:
                                                                            echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    <a href='#' class='btn btn-sm btn-danger' onclick=\"confirmCancel('" . addslashes($row['booking_id']) . "'); return false;\">ยกเลิกการจอง</a>
                                   </td>";
                                                                            break;
                                                                        case 6:
                                                                            echo " <td>
                                    <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                    </td>";
                                                                            break;
                                                                        case 7:
                                                                            echo " <td>
                                    <a href='./refund_page.php'><button class='btn btn-sm btn-primary m-2' type='button' >ไปหน้าคืนเงิน</button></a>
                                    </td>";
                                                                            break;
                                                                        case 9:
                                                                            echo " <td>
                                        <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                        <button class='btn btn-sm btn-success m-2' type='button' data-bs-toggle='modal' data-bs-target='#ConfirmModal' data-id='" . $row["booking_id"] . "'  data-name='" . $row["zone_name"] . "'  data-amount='" . $row["booking_amount"] . "'>ปรับเปลี่ยนสถานะ/ให้เลขล็อค</button>
                                        </td>";
                                                                        case 10:
                                                                            echo " <td>
                                                                                <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                                                                </td>";
                                                                            break;
                                                                        default:
                                                                            echo " <td>
                                                                                <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                                                                </td>";
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </li>
                                                <?php endwhile; ?>
                                            </ul>

                                        <?php  } else {
                                            echo "<p class='text-center'>ยังไม่ได้มีการจอง</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: ได้รับเลขล็อคแล้ว -->
                        <div class="tab-pane fade" id="tab2Content">
                            <div class="mt-2" id="bookingTable2">
                                <div class="tab-pane fade show active mt-2 mx-2 p-2" id="category">
                                    <div class="d-flex justify-content-between align-items-end">
                                        <p>กำลังดำเนินการโดย <?php echo htmlspecialchars($fullname); ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- ฟอร์มค้นหา -->
                                        <form method="get" class="mb-3">
                                            <input type="text" name="search" placeholder="ค้นหาด้วยรหัสการจอง" class="form-control" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                                            <button type="submit" class="btn btn-primary mt-2">ค้นหา</button>
                                        </form>
                                        <!-- การแบ่งหน้า -->
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-3">
                                                <?php
                                                // ตรวจสอบและกำหนดค่าตัวแปร $page
                                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                                $totalPages = isset($totalPages) ? $totalPages : 1; // กำหนดค่าเริ่มต้นให้ $totalPages

                                                if ($page > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">ก่อนหน้า</a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                                <?php if ($page < $totalPages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">ถัดไป</a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="mt-2" id="bookingTable">
                                        <?php
                                        $search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
                                        $searchCondition = $search ? "AND BK.booking_id LIKE '%$search%'" : '';

                                        $itemsPerPage = 10;
                                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                        $offset = ($page - 1) * $itemsPerPage;

                                        // การดึงข้อมูล
                                        $sql = "SELECT BK.booking_id, CONCAT(U.prefix, U.firstname , ' ', U.lastname) AS fullname, BS.status, BK.booking_status, ZD.zone_name, ZD.zone_detail, C.cat_name, SC.sub_cat_name, BK.booking_type, BK.booking_amount, BK.slip_img, BK.booking_date 
                        FROM booking AS BK 
                        INNER JOIN booking_status AS BS ON BK.booking_status = BS.id
                        INNER JOIN tbl_user AS U ON BK.member_id = U.user_id
                        INNER JOIN category AS C ON BK.product_type = C.id_category
                        INNER JOIN sub_category AS SC ON BK.sub_product_type = SC.idsub_category
                        INNER JOIN zone_detail AS ZD ON BK.zone_id = ZD.zone_id
                        WHERE booking_status = 4 
                        $searchCondition
                        ORDER BY BK.booking_date DESC
                        LIMIT $itemsPerPage OFFSET $offset";

                                        $result = $conn->query($sql);

                                        // การคำนวณจำนวนหน้าทั้งหมด
                                        $totalResult = $conn->query("SELECT COUNT(*) AS total FROM booking WHERE booking_status != 1 AND booking_status != 2 AND booking_status != 3 $searchCondition");
                                        $totalRow = $totalResult->fetch_assoc()['total'];
                                        $totalPages = ceil($totalRow / $itemsPerPage);

                                        if ($result->num_rows > 0) { ?>
                                            <ul class="list-group">
                                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <span> <strong><?php echo $row['booking_id']; ?></strong> </span>
                                                                <span><?php echo $row['fullname']; ?></span>
                                                                <p>
                                                                    <strong>
                                                                        ยอดทั้งหมด <?php echo htmlspecialchars($row['total_price']); ?> บาท
                                                                    </strong>
                                                                </p>
                                                                <p>
                                                                    <strong>
                                                                        สถานะ : <?php
                                                                                if ($row["booking_status"] === '4' || $row["booking_status"] === '8') {
                                                                                    echo "<span style='color: #06D001;'>" . htmlspecialchars($row["status"]) . "</span>";
                                                                                } else if ($row["booking_status"] === '1' || $row["booking_status"] === '2' || $row["booking_status"] === '3' || $row["booking_status"] === '9') {
                                                                                    echo "<span style='color: orange;'>" . htmlspecialchars($row["status"]) . "</span>";
                                                                                } else {
                                                                                    echo "<span style='color: red ;'>" . htmlspecialchars($row["status"]) . "</span>";  // You can change 'green' to any other color or style you prefer
                                                                                }



                                                                                ?>
                                                                    </strong>
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <div>
                                                                    <span>วันที่จอง : <?php echo $row['booking_date']; ?></span>
                                                                    <br>
                                                                    <span>วันที่หมดอายุการจอง :<?php if ($row["booking_status"] === '4') {
                                                                                                    echo "<span>" . htmlspecialchars($row["expiration_date"]) . "</span>";
                                                                                                } else {
                                                                                                    echo "<span>คำขอยังไม่สมบูรณ์</span>";
                                                                                                } ?></span>
                                                                </div>
                                                                <div class="mt-1">

                                                                    <?php switch ($row["booking_status"]) {
                                                                        case 4:
                                                                            echo " <td>
                                                                <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                                                </td>";
                                                                            break;
                                                                        case 5:
                                                                            echo " <td>
                                                                <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                                                <a href='#' class='btn btn-sm btn-danger' onclick=\"confirmCancel('" . addslashes($row['booking_id']) . "'); return false;\">ยกเลิกการจอง</a>
                                                            </td>";
                                                                            break;
                                                                        case 6:
                                                                            echo " <td>
                                                                <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                                                </td>";
                                                                            break;
                                                                        case 7:
                                                                            echo " <td>
                                                                <a href='./refund_page.php'><button class='btn btn-sm btn-primary m-2' type='button' >ไปหน้าคืนเงิน</button></a>
                                                                </td>";
                                                                            break;
                                                                        default:
                                                                            echo " <td>
                                                                                <button class='btn btn-primary m-2' type='button' data-bs-toggle='modal' data-bs-target='#viewBookingModal' data-id='" . $row["booking_id"] . "'>ดู</button>
                                                                                </td>";
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </li>
                                                <?php endwhile; ?>
                                            </ul>

                                        <?php    } else {
                                            echo "<p class='text-center'>ยังไม่ได้มีการจอง</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <script>
                    function confirmCancel(booking_id) {
                        Swal.fire({
                            title: "คุณแน่ใจหรือไม่?",
                            text: "คุณกำลังจะยกเลิกการจองน้า",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "ใช่, ยกเลิก!",
                            cancelButtonText: "ยกเลิก"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'cancel_booking.php?booking_id=' + booking_id;
                            }
                        });
                    }
                </script>
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
                            <div class="modal-footer">
                                <!-- Cancel Order Button and Close Button will be inserted here by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // Listen for click to open the modal
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
                                    let cancelButton = '';
                                    if (data.error) {
                                        content = `<p>${data.error}</p>`;
                                    } else {
                                        content = `
                        <table class="table table-striped">
                            <thead>
                                <div class="d-flex justify-content-center align-items-end">
                                    <p>เลขล็อคที่ได้รับ :</p>
                                    ${data.book_lock_number 
                                        ? `<h4 class="mx-3 rounded py-2 px-4 bg-primary text-white">${data.book_lock_number}</h4>` 
                                        : `<h4 class="mx-3 rounded py-2 px-4 bg-secondary text-white">ยังไม่ได้รับเลขล็อค</h4>`
                                    }
                                </div>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>หมายเลขการจอง</th>
                                    <td>${data.booking_id}</td>
                                </tr>
                                <tr>
                                    <th scope="row">ชื่อ-สกุล</th>
                                    <td>${data.fullname}</td>
                                </tr>
                                <tr>
                                    <th scope="row">เบอร์โทรติดต่อ</th>
                                    <td>${data.tel}</td>
                                </tr>
                                <tr>
                                    <th scope="row">ชื่อโซน</th>
                                    <td>${data.zone_name} (${data.zone_detail})</td>
                                </tr>
                                <tr>
                                    <th scope="row">หมวดหมู่</th>
                                    <td>${data.cat_name} (${data.sub_cat_name})</td>
                                </tr>
                                <tr>
                                    <th scope="row">ประเภทการจอง</th>
                                    <td>${data.booking_type_display}</td>
                                </tr>
                                <tr>
                                    <th scope="row">จำนวนการจอง</th>
                                    <td>${data.booking_amount} ล็อค</td>
                                </tr>
                                <tr>
                                    <th scope="row">รวม</th>
                                    <td>${data.total_price} บาท</td>
                                </tr>
                                <tr>
                                    <th scope="row">สถานะ</th>
                                    <td>${data.status}</td>
                                </tr>
                                <tr>
                                    <th scope="row">วันที่การจอง</th>
                                    <td>${data.booking_date}</td>
                                </tr>
                                <tr>
                                    <th scope="row">วันที่คำขอหมดอายุ</th>
                                    <td>${data.expiration_date ? data.expiration_date : 'คำขอยังไม่สมบูรณ์'}</td>
                                </tr>`;

                                        if (data.slip_img) {
                                            content += `
                                <tr>
                                    <th scope="row">รูปภาพใบเสร็จ</th>
                                    <td><img src="../asset/slip_img/${data.slip_img}" alt="ภาพใบเสร็จ" class="img-fluid"></td>
                                </tr>`;
                                        }

                                        content += `
                            </tbody>
                        </table>`;
                                        const footer = document.querySelector('#viewBookingModal .modal-footer');
                                        if ([1, 2, 3].includes(data.booking_status)) {
                                            // Add cancel button to modal footer
                                            footer.innerHTML = `
                                                                <button id="cancelOrderBtn" class="btn btn-danger">ยกเลิกการจอง</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                            `;
                                        } else {
                                            footer.innerHTML = `
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                            `;
                                        }


                                        // Attach event listener to the cancel button
                                        const cancelOrderBtn = document.getElementById('cancelOrderBtn');
                                        if (cancelOrderBtn) {
                                            cancelOrderBtn.addEventListener('click', () => {
                                                handleOrderCancellation(data.booking_id, data.booking_status);
                                            });
                                        }
                                    }
                                    document.querySelector('#viewBookingModal .modal-body').innerHTML = content;
                                })
                                .catch(error => {
                                    console.error('เกิดข้อผิดพลาดในการดึงข้อมูลการจอง:', error);
                                    document.querySelector('#viewBookingModal .modal-body').innerHTML = '<p>มีข้อผิดพลาดในการดึงข้อมูลการจอง</p>';
                                });
                        }

                        function handleOrderCancellation(bookingId, status) {
                            let url = '';
                            let text = '';

                            if (status == 1) {
                                url = `cancel_order.php?booking_id=${bookingId}`;
                                text = "คุณแน่ใจหรือไม่ว่าต้องการยกเลิกการจองนี้?";
                            } else if (status == 2 || status == 3) {
                                url = `cancel_refund.php?booking_id=${bookingId}`;
                                text = "คุณแน่ใจหรือไม่ว่าต้องการคืนเงินสำหรับการจองนี้?";
                            }

                            Swal.fire({
                                title: 'ยืนยันการดำเนินการ?',
                                text: text,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'ใช่, ดำเนินการเลย!',
                                cancelButtonText: 'ไม่, ยกเลิก',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    fetch(url, {
                                            method: 'GET', // ใช้ GET เพื่อส่งข้อมูลใน URL
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded',
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                Swal.fire(
                                                    'สำเร็จ!',
                                                    data.message,
                                                    'success'
                                                ).then(() => {
                                                    location.reload();
                                                });
                                            } else {
                                                Swal.fire(
                                                    'เกิดข้อผิดพลาด!',
                                                    data.message,
                                                    'error'
                                                );
                                            }
                                        })
                                        .catch(error => {
                                            console.error('เกิดข้อผิดพลาดในการดำเนินการ:', error);
                                            Swal.fire(
                                                'เกิดข้อผิดพลาด!',
                                                'ไม่สามารถดำเนินการได้ในขณะนี้.',
                                                'error'
                                            );
                                        });
                                }
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
                                <div class="mb-3">
                                    <strong>
                                        <label for="zoneName" class="form-label">โซนที่ทำการจอง :
                                            <span id="zoneName" name="zone_name" style="color: red;">
                                            </span>
                                        </label>
                                    </strong>
                                    <br>
                                    <strong>
                                        <label for="bookingAmount" class="form-label">จำนวนการจอง:
                                            <span id="bookingAmount" name="booking_amount" style="color: red;">
                                            </span>
                                        </label>
                                    </strong>
                                </div>
                                <div class="mb-3">
                                </div>
                                <form id="updateForm" method="POST" action="update_locks.php">
                                    <input type="hidden" id="bookingId" name="booking_id" value="">
                                    <input type="hidden" id="zoneId" name="zone_id" value="">
                                    <div class="mb-3">
                                        <label for="zoneSelect" class="form-label">เลือกโซน</label>
                                        <select class="form-select" id="zoneSelect" name="zone_id">
                                            <option value="" selected>กรุณาเลือกโซน</option>
                                            <?php
                                            $sql = "SELECT * FROM zone_detail ORDER BY zone_name ";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['zone_id']) . '">' . htmlspecialchars($row['zone_name']) . ' (' . htmlspecialchars($row['zone_detail']) . ')</option>';
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
                                    <button id="updateButton" type="submit" class="btn update-btn btn-primary mt-3" disabled>อัพเดตข้อมูล</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        var maxLocks = 0; // ตัวแปรสำหรับเก็บค่าจำนวนล็อคสูงสุดที่สามารถเลือกได้

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
                            var selectedCount = $('.lock-checkbox:checked').length; // นับจำนวนล็อคที่ถูกเลือก
                            var updateButton = document.getElementById('updateButton');

                            if (!isChecked && selectedCount >= maxLocks) {
                                alert('ไม่สามารถเลือกล็อคได้เกิน ' + maxLocks + ' ล็อค');
                                return;
                            }

                            checkbox.prop('checked', !isChecked);
                            $(this).toggleClass('active', !isChecked);

                            // อัปเดตสถานะของปุ่มล็อคเมื่อเลือกครบตามจำนวน
                            selectedCount = $('.lock-checkbox:checked').length; // อัปเดตจำนวนการเลือกล็อคอีกครั้ง
                            if (selectedCount >= maxLocks) {
                                $('.lock-btn').not('.active').prop('disabled', true); // ปิดการใช้งานปุ่มที่ยังไม่ถูกเลือก
                                updateButton.disabled = false;
                            } else {
                                $('.lock-btn').prop('disabled', false); // เปิดการใช้งานปุ่มทั้งหมดหากยังไม่ครบ
                                updateButton.disabled = true;
                            }
                        });

                        // อัปเดตข้อมูลใน modal และกำหนดค่าจำนวนล็อคสูงสุด
                        $('#ConfirmModal').on('show.bs.modal', function(event) {
                            var button = $(event.relatedTarget); // ปุ่มที่ถูกกดเพื่อเปิด modal
                            var bookingId = button.data('id'); // ดึงข้อมูลจาก data-* attributes
                            var zoneName = button.data('name'); // ดึงข้อมูลจาก data-* attributes
                            var bookingAmount = button.data('amount'); // ดึงข้อมูลจาก data-* attributes

                            maxLocks = parseInt(bookingAmount); // กำหนดจำนวนล็อคสูงสุดตาม bookingAmount

                            // อัปเดตข้อมูลใน Modal
                            var modal = $(this);
                            modal.find('#bookingId').val(bookingId);
                            modal.find('#zoneId').val(zoneName); // อัปเดต zoneId ด้วยข้อมูลโซนที่เลือก
                            modal.find('#zoneName').text(zoneName); // แสดงชื่อโซนใน span
                            modal.find('#bookingAmount').text(bookingAmount); // แสดงจำนวนการจองใน span

                            // รีเซ็ตปุ่มล็อคทั้งหมดเมื่อเปิด modal
                            $('.lock-btn').prop('disabled', false).removeClass('active');
                            $('.lock-checkbox').prop('checked', false);
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



</body>

</html>