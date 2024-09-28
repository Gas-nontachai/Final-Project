<style>
    /* Modal Styles */
    .unique-modal-dialog {
        max-width: 100%;
        width: auto;
    }

    .unique-modal-content {
        background-color: transparent;
        border: none;
    }

    .unique-modal-body {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    /* Image Styling */
    .unique-modal-body img {
        width: 100%;
        max-width: 1000px;
        height: auto;
    }

    /* Close Button */
    .unique-close-btn {
        position: absolute;
        top: 10px;
        right: 20px;
        color: white;
        background: rgba(0, 0, 0, 0.5);
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 5px 10px;
    }

    .unique-close-btn:hover {
        background-color: red;
    }

    .swal2-container {
        z-index: 9999 !important;
        /* ปรับค่าให้เหมาะสมตามที่ต้องการ */
    }

    .bgcolor {
        background-color: rgba(255, 255, 255, 0.9);
        padding-bottom: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .modal-backdrop {
        z-index: 1040 !important;
        /* ให้ backdrop อยู่ต่ำกว่า navbar */
    }
</style>
<div class="d-flex flex-column border border-dark rounded p-4 mb-3">
    <div style="text-align: center;">
        <strong>
            <h3>สถานะตลาด</h3>
            <a href="#" data-bs-toggle="modal" data-bs-target="#uniqueImageModal">
                <i class="bi bi-map"></i>คลิ๊กที่นี่เพื่อเปิดแผนผังตลาด </a>
        </strong>
    </div>
    <div class="col-12 d-flex flex-wrap justify-content-center align-item-center">
        <?php
        require("../condb.php");
        $sql = "SELECT * FROM zone_detail ORDER BY zone_name";
        if ($result = $conn->query($sql)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $zone_id = $row["zone_id"];
                    $sql_count = "SELECT COUNT(id_locks) AS total_locks, 
                                                                SUM(CASE WHEN available = 0 THEN 1 ELSE 0 END) AS available_locks 
                                                         FROM locks 
                                                         WHERE zone_id = $zone_id";
                    $result_count = $conn->query($sql_count);
                    $count_data = $result_count->fetch_assoc();
                    $total_locks = $count_data['total_locks'];
                    $available_locks = $count_data['available_locks'];

                    $percentage_available = ($total_locks > 0) ? ($available_locks / $total_locks) * 100 : 0;

                    $color = '';
                    if ($percentage_available > 30) {
                        $color = '<strong class="text-success border border-secondary border-2 px-2 mx-1 rounded">
                                                            ว่าง: ' . $available_locks . '/' . $total_locks . '
                                                        </strong>';  // สีเขียว
                    } else if ($percentage_available <= 30) {
                        $color = '<strong class="text-danger border border-secondary border-2 px-2 mx-1 rounded">
                                                            ว่าง: ' . $available_locks . '/' . $total_locks . '
                                                        </strong>';  // สีแดง
                    }
                    echo '
                                    <div class="mt-2 ">
                                       <div class="row ">
                                            <div class="col">
                                                <div class="d-flex justify-content-start">
                                                        <div class="">
                                                        <p class="zone_detail" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="right" 
                                                            title="รายวัน ' . $row["pricePerDate"] . '฿<br>รายเดือน ' . $row["pricePerMonth"] . '฿">
                                                                            โซน: <strong>' . $row["zone_name"] . '</strong> (' . $row["zone_detail"] . ')' . $color . '
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
                                echo '<div class="mx-2 ">
                                                        <p>';
                                if ($row2["available"] == 0) {
                                    echo '
                                                    <div class="border rounded " style="text-align: center;">
                                                        <div class="bg-lightt rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                                                                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                                                            </svg>
                                                        </div>
                                                    </div>';
                                } else if ($row2["available"] == 1) {
                                    echo '
                                                <div class="border rounded d-flex flex-column justify-content-center align-items-center" style="text-align: center;">
                                                        <div class="bg-primary rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px; color:white;" >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                                                                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                                                            </svg>
                                                        </div>
                                                    </div>';
                                }
                                echo '</p>
                                                        </div>';
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
</div>


<!--Avaliable--->
<div class="container-md d-flex justify-content-center p-2 m-2">
    <div class="px-2 mx-2 d-flex justify-content-center align-items-center">
        <div class="bg-lightt rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
            </svg>
        </div>
        <strong>ว่าง</strong>
    </div>
    <div class="px-2 mx-2 d-flex justify-content-center align-items-center">
        <div class="bg-primary rounded d-flex justify-content-center align-items-center" style="width: 30px; height:30px; color:white;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class=" bi bi-shop" viewBox="0 0 16 16">
                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
            </svg>
        </div>
        <strong class="mx-1">ไม่ว่าง</strong>
    </div>
</div>