<?php
session_start();
require("../condb.php");

if (!isset($_SESSION["username"])) {
    echo '<!DOCTYPE html>
    <html lang="th">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>กรุณาล็อคอินก่อน</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "กรุณาล็อคอินก่อน",
                    icon: "error",
                    timer: 2000, 
                    timerProgressBar: true, // แสดงแถบความก้าวหน้า
                    showConfirmButton: false // ซ่อนปุ่ม "OK"
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "../admin/login.php";
                    }
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
</head>

<body>
    <!-- Nav -->
    <?php
    include('./admin_nav.php');
    ?>

    <!-- Display -->
    <div class="container mt-4">
        <div class="container ">
            <div class="row d-flex justify-content-center align-item-center">
                <div class="col-12 d-flex flex-wrap justify-content-center align-item-center">
                    <!-- fetch_zone_detail -->
                    <?php
                    include('./fetch_zone_detail.php');
                    ?>
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
                                    <a href='#' class='btn btn-sm btn-danger' onclick=\"confirmCancel('" . addslashes($row['booking_id']) . "'); return false;\">ยกเลิกการจอง</a>
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

                                            $sql = "SELECT * FROM zone_detail ORDER BY zone_name";
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



</body>

</html>