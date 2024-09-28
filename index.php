<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จองล็อค.คอม</title>
    <link rel="icon" type="image/x-icon" href="./asset/img/icon.market.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./asset/css/font.css">
    <style>
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: transparent;
            z-index: 1000;
            transition: background-color 0.3s ease-in-out;
        }

        .navbar.scrolled {
            background-color: rgba(255, 255, 255, 0.9);
            /* Slightly transparent white when scrolled */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Add a subtle shadow when scrolled */
        }

        .recommended-section img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease-in-out;
        }

        .recommended-section img:hover {
            transform: scale(1.05);
        }

        .navbar {
            margin-bottom: 30px;
        }

        .navbar.scrolled {
            background-color: rgba(255, 255, 255, 0.8);
        }


        .footer-icons img {
            width: 40px;
            height: 40px;
        }

        .footer {
            background-color: #000;
            color: #fff;
            padding: 20px;
        }

        html {
            scroll-behavior: smooth;
        }

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
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">ตลาด - จองล็อค.คอม</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            หน้าหลัก

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#uniqueImageModal">
                            แผนผังตลาด</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#contactUsModalUnique">
                            ติดต่อเรา
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ล็อคอิน/สมัครสมาชิก
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./login.php">ล็อคอิน</a></li>
                            <li><a class="dropdown-item" href="./register.php">สมัครสมาชิก</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Image Slider (Hero Section) -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./asset/img/img.soisin1.jpg" class="d-block w-100" alt="..." style="height: 40rem;">
                <div class="carousel-caption d-none d-md-block bg-dark p-4 bg-opacity-50 rounded">
                    <h5>ภาพบรรยากาศภายในงาน</h5>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#zoneModal" data-zone="โซนร้านอาหาร">ดูเพิ่มเติม</button>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./asset/img/img.soisin2.jpg" class="d-block w-100" alt="..." style="height: 40rem;">
                <div class="carousel-caption d-none d-md-block bg-dark p-4 bg-opacity-50 rounded">
                    <h5>ภาพบรรยากาศภายในงาน</h5>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#zoneModal" data-zone="โซนร้านอาหาร">ดูเพิ่มเติม</button>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./asset/img/img.soisin3.jpg" class="d-block w-100" alt="..." style="height: 40rem;">
                <div class="carousel-caption d-none d-md-block bg-dark p-4 bg-opacity-50 rounded">
                    <h5>ภาพบรรยากาศภายในงาน</h5>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#zoneModal" data-zone="โซนร้านอาหาร">ดูเพิ่มเติม</button>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./asset/img/img.soisin5.jpg" class="d-block w-100" alt="..." style="height: 40rem;">
                <div class="carousel-caption d-none d-md-block bg-dark p-4 bg-opacity-50 rounded">
                    <h5>ภาพบรรยากาศภายในงาน</h5>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#zoneModal" data-zone="โซนร้านอาหาร">ดูเพิ่มเติม</button>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./asset/img/img.soisin6.jpg" class="d-block w-100" alt="..." style="height: 40rem;">
                <div class="carousel-caption d-none d-md-block bg-dark p-4 bg-opacity-50 rounded">
                    <h5>ภาพบรรยากาศภายในงาน</h5>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#zoneModal" data-zone="โซนร้านอาหาร">ดูเพิ่มเติม</button>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Recommended Zones Section -->
    <div class="container recommended-section my-5">
        <h2 class="text-center">โซนแนะนำ</h2>
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="./asset/img/img.soisin7.jpg" style="height: 15rem;" alt="โซนอาหาร">
                <h3>โซนอาหาร</h3>
                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#zoneModal" data-zone="โซนอาหาร">ดูเพิ่มเติม</button>
            </div>
            <div class="col-md-4 text-center">
                <img src="./asset/img/img.soisin5.jpg" style="height: 15rem;" alt="โซนเดินเล่น">
                <h3>โซนเดินเล่น</h3>
                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#zoneModal" data-zone="โซนเดินเล่น">ดูเพิ่มเติม</button>
            </div>
            <div class="col-md-4 text-center">
                <img src="./asset/img/img.soisin4.jpg" style="height: 15rem;" alt="โซนเดินเล่น">
                <h3>โซนวาดเขียน</h3>
                <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#zoneModal" data-zone="โซนวาดเขียน">ดูเพิ่มเติม</button>
            </div>
        </div>
    </div>
    <!-- contact us Modal -->
    <div class="modal fade" id="contactUsModalUnique" tabindex="-1" aria-labelledby="contactUsModalLabelUnique" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactUsModalLabelUnique">ติดต่อเรา</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>หากคุณมีคำถาม ข้อเสนอแนะ หรือปัญหาใด ๆ สามารถติดต่อเราได้ผ่านช่องทางดังต่อไปนี้:</p>
                    <ul>
                        <li><strong>ที่อยู่:</strong> มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน(สุรนารายณ์) 744 ถ. สุรนารายณ์</li>
                        <li><strong>โทรศัพท์:</strong> 02-888-8888</li>
                        <li><strong>อีเมล:</strong> info@marketplace.com</li>
                        <li><strong>เวลาทำการ:</strong> จันทร์ - ศุกร์ 9:00 น. - 17:00 น.</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="zoneModal" tabindex="-1" aria-labelledby="zoneModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="zoneModalLabel">รายละเอียดโซน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="zoneDetails"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Maps Modal -->
    <div class="modal fade" id="uniqueImageModal" tabindex="-1" aria-labelledby="uniqueImageModalLabel" aria-hidden="true">
        <div class="modal-dialog unique-modal-dialog modal-dialog-centered">
            <div class="modal-content unique-modal-content">
                <div class="modal-body unique-modal-body">
                    <div style="background-color: aliceblue;" class="p-3 rounded">
                        <img src="./asset./img./maps.market.png.png" alt="Unique Large Image"> <!-- ตรวจสอบชื่อไฟล์ให้ถูกต้อง -->
                    </div>
                    <button class="unique-close-btn rounded" data-bs-dismiss="modal">&times;</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer with Contact Icons -->
    <footer class="footer">
        <div class="container text-center">
            <div class="footer-icons mb-3">
                <a href="#" class="mx-1"><img src="./asset/img/icon.facebook.png" alt="Facebook"></a>
                <a href="#" class="mx-1"><img src="./asset/img/icon.line.png" alt="Line"></a>
                <a href="#" class="mx-1"><img src="./asset/img/icon.youtube.png" alt="YouTube"></a>
                <a href="#" class="mx-1"><img src="./asset/img/icon.instagram.png" alt="Instagram"></a>
            </div>
            <p>© 2024 จองล็อค.คอม - ช่องทางติดต่อ</p>
            <ul>
                <p><strong>ที่อยู่:</strong> มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน(สุรนารายณ์) 744 ถ. สุรนารายณ์</p>
                <p><strong>โทรศัพท์:</strong> 02-888-8888 <strong>อีเมล:</strong> info@marketplace.com</p>
                <p></p>
                <p><strong>เวลาทำการ:</strong> จันทร์ - ศุกร์ 9:00 น. - 17:00 น.</p>
            </ul>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll for nav links
        document.querySelectorAll('.nav-link').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        // Change navbar background color when scrolling
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Display modal content based on zone selected
        document.getElementById('zoneModal').addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var zoneName = button.getAttribute('data-zone');
            var modalTitle = document.getElementById('zoneModalLabel');
            var modalBody = document.getElementById('zoneDetails');

            modalTitle.textContent = zoneName;
            modalBody.textContent = "ข้อมูลเกี่ยวกับ " + zoneName + " จะปรากฏที่นี่.";
        });
        // Display modal content based on zone selected
        document.getElementById('zoneModal').addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var zoneName = button.getAttribute('data-zone');
            var modalTitle = document.getElementById('zoneModalLabel');
            var modalBody = document.getElementById('zoneDetails');

            modalTitle.textContent = zoneName;

            // Set modal content based on selected zone
            if (zoneName === "โซนอาหาร") {
                modalBody.innerHTML = `
                <h4>โซนอาหาร</h4>
                <p>โซนนี้รวมอาหารหลากหลายจากทั่วประเทศ ไม่ว่าจะเป็นอาหารไทย อาหารต่างชาติ และขนมหวาน มีทั้งอาหารสดและแปรรูปให้เลือกซื้อ</p>
                <ul>
                    <li>เปิดให้บริการตั้งแต่เวลา 17.00 น. ถึง 21.00 น.</li>
                    <li>มีร้านอาหารกว่า 20 ร้าน</li>
                    <li>ที่จอดรถกว้างขวาง รองรับได้มากกว่า 100 คัน</li>
                </ul>
            `;
            } else if (zoneName === "โซนเดินเล่น") {
                modalBody.innerHTML = `
                <h4>โซนเดินเล่น</h4>
                <p>เหมาะสำหรับการพักผ่อน ช้อปปิ้ง และเพลิดเพลินกับบรรยากาศสบายๆ มีร้านขายสินค้ามากมาย เช่น เสื้อผ้า เครื่องประดับ และของฝาก</p>
                <ul>
                    <li>เปิดทุกวัน เวลา 17.00 น - 22.00 น.</li>
                    <li>มีลานกิจกรรมกลางแจ้ง เช่น โชว์ดนตรีและการแสดงสด</li>
                    <li>เหมาะสำหรับการพาครอบครัวมาเดินเล่น</li>
                </ul>
            `;
            } else if (zoneName === "โซนวาดเขียน") {
                modalBody.innerHTML = `
                <h4>โซนวาดเขียน</h4>
                <p>พบกับกิจกรรมวาดเขียนบนถนนซอยศิลป์สุดสร้างสรรค์</p>
                <ul>
                    <li>โซนนี้เปิดตั้งแต่ 17.00 น. ถึง 20.00 น.</li>
                    <li>นักศีกษาสามารถลงทะเบียนแล้วรีบสีไปวาดได้เลย</li>
                    <li>นักศีกษาทุกคนสามารถเข้าร่วมได้ฟรี</li>
                </ul>
            `;
            } else if (zoneName === "โซนร้านอาหาร") {
                modalBody.innerHTML = `
                <h4>โซนร้านอาหาร</h4>
                <p>โซนนี้รวมอาหารหลากหลายจากทั่วประเทศ ไม่ว่าจะเป็นอาหารไทย อาหารต่างชาติ และขนมหวาน มีทั้งอาหารสดและแปรรูปให้เลือกซื้อ</p>
                <ul>
                    <li>เปิดให้บริการตั้งแต่เวลา 10.00 น. ถึง 21.00 น.</li>
                    <li>มีร้านอาหารกว่า 50 ร้าน</li>
                    <li>ที่จอดรถกว้างขวาง รองรับได้มากกว่า 500 คัน</li>
                </ul>
            `;
            } else {
                modalBody.innerHTML = `<p>ไม่มีข้อมูลเกี่ยวกับโซนนี้</p>`;
            }
        });
    </script>

</body>

</html>