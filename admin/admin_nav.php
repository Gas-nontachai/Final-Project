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
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li>
                            <a href="./index.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-house-door-fill " viewBox="0 0 16 16">
                                        <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5" />
                                    </svg>
                                    <strong class="mx-2 "> หน้าแรก </strong>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="./confirm_reserve.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-calendar2-check" viewBox="0 0 16 16">
                                        <path d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" />
                                        <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5z" />
                                    </svg>
                                    <strong class="mx-2 "> ปรับเปลี่ยนสถานะการจอง/ยืนยันการชำระเงิน </strong>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="./crud_page.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-shop-window" viewBox="0 0 16 16">
                                        <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h12V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5m2 .5a.5.5 0 0 1 .5.5V13h8V9.5a.5.5 0 0 1 1 0V13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                    <strong class="mx-2 "> จัดการพื้นที่การขาย </strong>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="./manage_cat.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-bag-x-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M6.854 8.146a.5.5 0 1 0-.708.708L7.293 10l-1.147 1.146a.5.5 0 0 0 .708.708L8 10.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 10l1.147-1.146a.5.5 0 0 0-.708-.708L8 9.293z" />
                                    </svg>
                                    <strong class="mx-2 "> จัดการประเภทสินค้า </strong>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="./view_member.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                    </svg>
                                    <strong class="mx-2 "> ดูข้อมูลสมาชิก </strong>
                                </div>
                            </a>
                        </li>
                        <li>
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
                        <li>
                            <a href="#" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-bar-chart" viewBox="0 0 16 16">
                                        <path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z" />
                                    </svg>
                                    <strong class="mx-2 "> สถิติการจอง </strong>
                                </div>
                            </a>
                        </li>

                    </ul>
                    <hr>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <a href="./logout.php" type="button" class="btn btn-danger">ล็อกเอ้าท์</a>
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
        </strong>
        <script src="../asset/js/time_couter.js"></script>
    </div>

</nav>