<style>
    .swal2-container {
        z-index: 9999 !important;
        /* ปรับค่าให้เหมาะสมตามที่ต้องการ */
    }

    .bgcolor {
        background-color: rgba(255, 255, 255, 0.9);
        padding-bottom: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
                    <strong>ยินดีต้อนรับสู่ จองล็อค.คอม(แอดมิน)</strong>
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
                            <a href="./refund_page.php" class="my-1 border nav-link link-dark btn btn-outline-info">
                                <div class="mx-2 p-2 d-flex align-items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-3 bi bi-cash-coin" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                                    </svg>
                                    <strong class="mx-2 "> คำขอยกเลิก/คืนเงิน </strong>
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
                            <a href="./stat_booking.php" class="my-1 border nav-link link-dark btn btn-outline-info">
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
                            echo $_SESSION["token"];
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
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ManulExpiredModal">ปรับหมดอายุคำขอแบบกดมือ</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <a href="./logout.php" type="button" class="btn btn-danger">ล็อกเอ้าท์</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Manul Expired Modal -->
    <div class="modal fade" id="ManulExpiredModal" tabindex="-1" aria-labelledby="ManulExpiredModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ManulExpiredModalLabel"><strong>ปรับหมดอายุคำขอแบบกดมือ</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>เมื่อคุณกดปุ่ม "ยืนยัน", ระบบจะทำการปรับสถานะคำขอให้เป็น "หมดอายุ" ซึ่งจะมีผลดังนี้:</p>
                    <ul>
                        <li>อัปเดตสถานะการจองที่มีวันหมดอายุ หรือที่มีสถานะ "หมดอายุ" ในฐานข้อมูล.</li>
                        <li>ย้ายข้อมูลการจองที่หมดอายุไปยังตาราง "booked" เพื่อเก็บประวัติ.</li>
                        <li>อัปเดตสถานะล็อก (lock) ที่เกี่ยวข้องให้พร้อมใช้งานอีกครั้ง.</li>
                        <li>ลบข้อมูลการจองที่หมดอายุออกจากตาราง "booking".</li>
                        <li>ระบบจะนำทางคุณไปยังหน้าใหม่เพื่อแสดงผลลัพธ์การดำเนินการนี้.</li>
                    </ul>
                    <p>คุณแน่ใจหรือไม่ว่าต้องการดำเนินการต่อ?</p>
                    <button type="button" class="btn btn-danger" id="confirmManualExpire">ยืนยัน</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('confirmManualExpire').addEventListener('click', function() {
            Swal.fire({
                title: 'ยืนยันการปรับสถานะ',
                text: "คุณแน่ใจหรือไม่ว่าต้องการปรับสถานะหมดอายุคำขอนี้?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ฉันแน่ใจ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ดำเนินการตามที่ต้องการเมื่อได้รับการยืนยัน
                    window.location.href = 'manual_expired_bookings.php'; // เปลี่ยน URL ตามต้องการ
                }
            });
        });
    </script>


    <!-- timer -->
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
            <div id="opening_time">ระบบเปิดเวลา : <a href="#" data-bs-toggle="modal" data-bs-target="#editTimeModal"><?php echo $openingTime; ?></a></div>
            <div id="closing_time">ระบบปิดเวลา : <a href="#" data-bs-toggle="modal" data-bs-target="#editTimeModal"><?php echo $closingTime; ?></a></div>
        </strong>
    </div>
    <!-- Modal สำหรับแก้ไขเวลาเปิด-ปิด -->
    <div class="modal fade" id="editTimeModal" tabindex="-1" aria-labelledby="editTimeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateTimeForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTimeModalLabel">แก้ไขเวลาเปิด-ปิดระบบ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="openingTime" class="form-label">เวลาเปิด</label>
                            <input type="time" class="form-control" id="openingTime" name="opening_time" value="<?php echo $openingTime; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="closingTime" class="form-label">เวลาปิด</label>
                            <input type="time" class="form-control" id="closingTime" name="closing_time" value="<?php echo $closingTime; ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript สำหรับ Swal และการอัพเดตเวลา -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ฟังก์ชันการแสดงผล Swal เมื่อสำเร็จ
        function showSuccessSwal() {
            Swal.fire({
                icon: 'success',
                title: 'แก้ไขเวลาเปิด-ปิดสำเร็จ',
                showConfirmButton: true,
                didClose: () => {
                    // Refresh the page
                    location.reload();
                }
            });
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
                    document.getElementById('status').innerHTML = "<span>ยังสามารถกดำเนินการได้ปกติ</span><span style='color: green;'>(ระบบเปิด)</span>";
                } else {
                    document.getElementById('status').innerHTML = "<span>ยังสามารถกดำเนินการได้ปกติ</span><span style='color: red;'>(ระบบปิด)</span>";
                }
            } else {
                // ช่วงเวลาเปิด-ปิดในวันเดียวกัน
                if (now >= openingDate && now <= closingDate) {
                    document.getElementById('status').innerHTML = "<span>ยังสามารถกดำเนินการได้ปกติ</span><span style='color: green;'>(ระบบเปิด)</span>";
                } else {
                    document.getElementById('status').innerHTML = "<span>ยังสามารถกดำเนินการได้ปกติ</span><span style='color: red;'>(ระบบปิด)</span>";
                }
            }

        }

        // เรียกใช้ฟังก์ชัน updateTime ทุกๆ 1 วินาที
        setInterval(updateTime, 1000);

        // เมื่อกด submit ฟอร์ม
        document.getElementById('updateTimeForm').addEventListener('submit', function(e) {
            e.preventDefault(); // ป้องกันการโหลดหน้าใหม่

            var formData = new FormData(this);

            // ส่งข้อมูลไปที่ PHP ด้วย AJAX
            fetch('update_time.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                .then(data => {
                    // แสดง Swal เมื่อสำเร็จ
                    showSuccessSwal();

                    // ปิด modal หลังจาก Swal แสดงผล
                    setTimeout(function() {
                        var modal = bootstrap.Modal.getInstance(document.getElementById('editTimeModal'));
                        modal.hide();
                    }, 1500);
                }).catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถแก้ไขเวลาได้'
                    });
                });
        });
    </script>

</nav>