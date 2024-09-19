<style>
    .swal2-container {
        z-index: 9999 !important;
    }

    .bgcolor {
        background-color: rgba(255, 255, 255, 0.9);
        padding-bottom: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Custom styles for responsiveness */
    .nav-item {
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .bgcolor {
            padding: 5px 15px;
        }

        .nav-item {
            text-align: center;
        }

        h5 {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        .bgcolor {
            padding: 5px 10px;
        }

        h5 {
            font-size: 1rem;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            padding: 10px;
        }
    }
</style>


<nav class="row g-2 bgcolor">
    <!-- btn sidebar -->
    <div class="col-12 d-flex justify-content-between px-5 py-3">
        <div class="col-4">
            <div class="d-flex align-items-end ">
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="30" fill="currentColor" class="bi bi-justify" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                    </svg>
                </button>
                <h5>
                    <strong>ยินดีต้อนรับสู่ จองล็อค.คอม</strong>
                </h5>
            </div>

            <!-- sidebar -->
            <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                <div class="offcanvas-header">
                    <h3 class="offcanvas-title" id="offcanvasWithBothOptionsLabel"><strong>เมนูเพิ่มเติม</strong></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body d-flex flex-column mb-3 ">
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="./index.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-house-door-fill " viewBox="0 0 16 16">
                                        <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5" />
                                    </svg>
                                    <strong class="mx-2 "> หน้าแรก </strong>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./order.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-bookmark-fill" viewBox="0 0 16 16">
                                        <path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2" />
                                    </svg>
                                    <strong class="mx-2 "> คำขอจองพื้นที่การขาย </strong>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./booking_history.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-clock-history" viewBox="0 0 16 16">
                                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                    <strong class="mx-2 "> ประวัติการจอง </strong>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./comment_page.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-chat-left-text" viewBox="0 0 16 16">
                                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                        <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
                                    </svg>
                                    <strong class="mx-2 "> แสดงความคิดเห็นตลาด </strong>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../asset/pdf/คู่มือการใช้งานสำหรับผู้ใช้งาน.pdf" target="_blank" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-journal-bookmark" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6 8V1h1v6.117L8.743 6.07a.5.5 0 0 1 .514 0L11 7.117V1h1v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8" />
                                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                                    </svg>
                                    <strong class="mx-2 ">คู่มือการใช้งาน</strong>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./contactus.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-building" viewBox="0 0 16 16">
                                        <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                                        <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z" />
                                    </svg>
                                    <strong class="mx-2 ">ช่องทางการติดต่อ</strong>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <hr>
                </div>
            </div>
        </div>
        <!-- profile btn -->
        <div class="d-flex align-items-center ">
            <div class="row  ">
                <div class="col d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                        <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z" />
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12" />
                    </svg>
                    <p class="ms-1">
                        <strong>
                            <?php
                            $user_id = $_SESSION["user_id"];

                            $stmt = $conn->prepare("SELECT user_id, username, shop_name, tel, email, token, 
                                  firstname, lastname, userrole, 
                                  CONCAT(prefix, firstname, ' ', lastname) AS fullname
                        FROM market_booking.tbl_user
                        WHERE user_id = ?");
                            $stmt->bind_param("i", $user_id);

                            $stmt->execute();

                            // Bind the results to variables
                            $stmt->bind_result($SQLuser_id, $SQLusername, $SQLshop_name, $SQLtel, $SQLemail, $SQLtoken, $SQLfirstname, $SQLlastname, $SQLuserrole, $SQLfullname);

                            // Fetch the results
                            $stmt->fetch();

                            // Output the token (or any other variable as needed)
                            echo htmlspecialchars($SQLtoken);
                            $token = htmlspecialchars($SQLtoken);
                            ?>

                        </strong>
                    </p>

                </div>
            </div>
            <button class="btn " type="button" data-bs-toggle="modal" data-bs-target="#ProfileModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                </svg>
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ProfileModal" tabindex="-1" aria-labelledby="ProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ProfileModalLabel"><strong>โปรไฟล์ผู้ใช้งาน</strong></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>UserID:</strong> <?php echo $SQLuser_id; ?></p>
                        <p><strong>Username:</strong> <?php echo $SQLusername; ?></p>
                        <p><strong>ชื่อร้าน:</strong> <?php echo $SQLshop_name; ?></p>
                        <p><strong>ชื่อ-นามสกุล:</strong> <?php echo $SQLfullname; ?></p>
                        <p><strong>เบอร์โทรศัพท์:</strong> <?php echo $SQLtel; ?></p>
                        <p><strong>อีเมล:</strong> <?php echo $SQLemail; ?></p>
                        <div class="mb-3 row">
                            <div class="col-sm-9">
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-user-id="<?php echo $user_id; ?>">ลบโปรไฟล์</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#EditModal">แก้ไขโปรไฟล์</button>
                        <a href='#' class='btn btn-danger' onclick=confirmLogout()>ออกจากระบบ</a>
                    </div>
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
                        <p><strong>UserID:</strong> <?php echo $SQLuser_id; ?></p>
                        <p><strong>Username:</strong> <?php echo $SQLusername; ?></p>
                        <div class="mb-3 row">
                            <label for="shopname" class="col-sm-3 col-form-label"><strong>shop_name:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="editshopname" id="editshopname" value="<?php echo $SQLshop_name; ?>">
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
                                <input type="text" class="form-control" name="editfirstname" value="<?php echo $SQLfirstname; ?>">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="editlastname" value="<?php echo $SQLlastname; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tel" class="col-sm-3 col-form-label"><strong>เบอร์โทรศัพท์:</strong></label>
                            <div class="col-sm-9">
                                <input oninput="check_tel()" type="tel" class="form-control" name="edittel" id="edittel" value="<?php echo $SQLtel; ?>">
                                <span id="span_tel" class=""></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-3 col-form-label"><strong>อีเมล:</strong></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="editemail" id="editemail" value="<?php echo $SQLemail; ?>">
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <p><strong>ประเภทผู้ใช้งาน:</strong> <?php echo $SQLuserrole; ?></p>
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
    <?php
    require("../condb.php");

    $currentTime = date('H:i:s'); // เวลาปัจจุบัน
    // ดึงข้อมูลจาก database
    $sql_time = "SELECT opening_time, closing_time FROM operating_hours LIMIT 1";
    $result = $conn->query($sql_time);
    $row_time = $result->fetch_assoc();

    $openingTime = $row_time['opening_time'];
    $closingTime = $row_time['closing_time'];
    ?>
    <!-- Timer -->
    <div class="col-12 d-flex justify-content-between px-5">
        <strong>
            <div id="time"></div>
            <div id="status"></div>
        </strong>
        <strong>
            <div id="opening_time">ระบบเปิดเวลา : <?php echo $openingTime; ?></div>
            <div id="closing_time">ระบบปิดเวลา : <?php echo $closingTime; ?></div>
        </strong>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function check_tel() {
            var input = document.getElementById('edittel');
            var value = input.value;
            const span_tel = document.getElementById('span_tel');

            if (value.length < 10) {
                span_tel.style.color = "red";
                span_tel.textContent = "กรุณากรอกให้ครบ 10 หลัก";
            } else if (value.length > 10) {
                span_tel.style.color = "yellow";
                span_tel.textContent = "กรุณากรอกไม่เกิน 10 หลัก";
                input.value = value.slice(0, 10);

                setTimeout(function() {
                    span_tel.style.color = "green";
                    span_tel.textContent = "ครบ 10 หลัก";
                }, 2000);
            } else {
                span_tel.style.color = "green";
                span_tel.textContent = "ครบ 10 หลัก";
            }

            return true;
        }

        function updateTime() {
            var now = new Date();
            var currentTime = now.toTimeString().split(' ')[0];

            document.getElementById('time').innerHTML = "เวลาปัจจุบัน : " + currentTime;

            var openingTime = "<?php echo $openingTime; ?>";
            var closingTime = "<?php echo $closingTime; ?>";

            // แปลงเวลาจาก string เป็น Date object
            var nowDate = new Date();
            var openingDate = new Date(nowDate.toDateString() + ' ' + openingTime);
            var closingDate = new Date(nowDate.toDateString() + ' ' + closingTime);

            // ตรวจสอบว่าช่วงเวลาปิดข้ามวันหรือไม่
            if (closingDate <= openingDate) {
                // ช่วงเวลาเปิด-ปิดข้ามวัน เช่น 23:00:00 ถึง 05:00:00
                if (now >= openingDate || now <= closingDate) {
                    document.getElementById('status').innerHTML = "<span style='color: green;'>ขณะนี้สามารถจองพื้นที่การขายได้ (ระบบเปิด)</span>";
                } else {
                    document.getElementById('status').innerHTML = "<span style='color: red;'>ขณะนี้ไม่สามารถจองพื้นที่การขายได้ (ระบบปิด)</span>";
                }
            } else {
                // ช่วงเวลาเปิด-ปิดในวันเดียวกัน
                if (now >= openingDate && now <= closingDate) {
                    document.getElementById('status').innerHTML = "<span style='color: green;'>ขณะนี้สามารถจองพื้นที่การขายได้ (ระบบเปิด)</span>";
                } else {
                    document.getElementById('status').innerHTML = "<span style='color: red;'>ขณะนี้ไม่สามารถจองพื้นที่การขายได้ (ระบบปิด)</span>";
                }
            }

        }

        // เรียกใช้ฟังก์ชัน updateTime ทุกๆ 1 วินาที
        setInterval(updateTime, 1000);

        function confirmLogout(booking_id) {
            Swal.fire({
                title: "คุณแน่ใจหรือไม่?",
                text: "คุณกำลังจะออกจากระบบน้า",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ใช่, ออกจากระบบ!",
                cancelButtonText: "ยกเลิก"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = './logout.php';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');

                    // First confirmation step
                    Swal.fire({
                        title: 'ยืนยันการลบ?',
                        text: "คุณแน่ใจว่าต้องการลบโปรไฟล์นี้หรือไม่?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ใช่, ลบ!',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Second confirmation step with dropdown
                            Swal.fire({
                                title: 'ยืนยันการลบ!',
                                text: "เลือก 'ยืนยันที่จะลบโปรไฟล์' จาก dropdown เพื่อดำเนินการต่อ:",
                                input: 'select',
                                inputOptions: {
                                    '': 'ล้อเล่นไม่ลบหรอก',
                                    'not_delete': 'ล้อเล่นไม่ลบหรอก',
                                    'change_mind': 'เปลี่ยนใจละ',
                                    'not_delete': 'ไม่ลบดีกว่า',
                                    'confirm': 'ยืนยันที่จะลบโปรไฟล์',
                                    'second_confirm': 'ยืนยันที่จะลบโปรไฟล์ดีไหมน้า หรือไม่ลบดี',
                                },
                                inputPlaceholder: 'เลือกตัวเลือก',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ยืนยัน',
                                cancelButtonText: 'ยกเลิก',
                                preConfirm: (inputValue) => {
                                    if (inputValue !== 'confirm') {
                                        Swal.showValidationMessage('คุณต้องเลือก "ยืนยันที่จะลบโปรไฟล์" เพื่อดำเนินการต่อ');
                                        return false;
                                    }
                                    return true;
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Proceed with the deletion
                                    window.location.href = `delete_profile.php?user_id=${encodeURIComponent(userId)}`;
                                }
                            });
                        }
                    });
                });
            });
        });
    </script>
</nav>