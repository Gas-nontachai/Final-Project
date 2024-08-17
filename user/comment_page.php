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
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแสดงความคิดเห็นตลาด</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/font.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 1rem;
        }

        .card-body {
            padding: 2rem;
        }

        .star-rating {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .star {
            font-size: 4rem;
            color: #ccc;
            transition: color 0.2s;
        }

        .star.selected,
        .star:hover {
            color: #ffc107;
        }

        .form-control,
        .btn {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <!-- Nav -->
    <?php include('./user_nav.php'); ?>
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="card" style="width: 80%;">
            <div class="card-header text-center">
                <h3 class="mb-0"><strong>แสดงความคิดเห็นของคุณ</strong></h3>
            </div>
            <div class="card-body">
                <form id="commentForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">ชื่อผู้ใช้ <strong><?php echo htmlspecialchars($username); ?></strong></label>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">ความคิดเห็น</label>
                        <textarea class="form-control" id="comment" rows="4" placeholder="กรุณากรอกความคิดเห็นของคุณที่นี่" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ให้คะแนน</label>
                        <div class="star-rating" id="rating">
                            <span class="star" data-value="1">&#9733;</span>
                            <span class="star" data-value="2">&#9733;</span>
                            <span class="star" data-value="3">&#9733;</span>
                            <span class="star" data-value="4">&#9733;</span>
                            <span class="star" data-value="5">&#9733;</span>
                        </div>
                        <input type="hidden" id="ratingValue" name="rating" value="0">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary w-100">ส่งความคิดเห็น</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    $sql = "SELECT id, comment, rating, created_at FROM comments WHERE user_id = '$user_id' ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    ?>
    <!-- แสดงความคิดเห็นที่เคยแสดงความคิดเห็น -->
    <div class="mt-4">
        <h4>ความคิดเห็นของฉัน</h4>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <ul class="list-group">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <span>คะแนน: <?php echo $row['rating']; ?>/5</span>
                            <span><?php echo $row['created_at']; ?></span>
                        </div>
                        <p><?php echo htmlspecialchars($row['comment']); ?></p>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editCommentModal" onclick="populateEditModal(<?php echo $row['id']; ?>, '<?php echo addslashes($row['comment']); ?>', <?php echo $row['rating']; ?>)">แก้ไข</button>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['id']; ?>)">ลบ</button>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>คุณยังไม่ได้แสดงความคิดเห็น</p>
        <?php endif; ?>
    </div>
    </div>

    <!-- Modal สำหรับแก้ไขความคิดเห็น -->
    <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCommentModalLabel">แก้ไขความคิดเห็น</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCommentForm">
                        <div class="mb-3">
                            <label for="editComment" class="form-label">ความคิดเห็น</label>
                            <textarea class="form-control" id="editComment" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ให้คะแนน</label>
                            <div class="star-rating" id="editRating">
                                <span class="star" data-value="1">&#9733;</span>
                                <span class="star" data-value="2">&#9733;</span>
                                <span class="star" data-value="3">&#9733;</span>
                                <span class="star" data-value="4">&#9733;</span>
                                <span class="star" data-value="5">&#9733;</span>
                            </div>
                            <input type="hidden" id="editRatingValue" name="rating" value="0">
                        </div>
                        <input type="hidden" id="editCommentId">
                        <button type="submit" class="btn btn-primary w-100">บันทึกการแก้ไข</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const badWords = [
            'ไอ้', 'ควาย', 'งี่เง่า', 'หมา', 'ชิบหาย', 'เลว', 'สถุน', 'สวะ', 'ถุย', 'เฮงซวย', 'แย่',
            'บ้า', 'สัส', 'ห่า', 'หยัง', 'พ่อแม่', 'ปากหมา', 'ดอก', 'สารเลว', 'แสบ', 'เหี้ย', 'แม่ง',
            'ฉิบ', 'เสือก', 'ซวย', 'ไอ้สัตว์', 'บัก', 'แดก', 'หมาขี้', 'หมาแก่', 'เวร', 'เหี้ยไอ้',
            'ระยำ', 'ชัง', 'ตีน', 'อี', 'กระหรี่', 'ลามก', 'ควย', 'ปากหมา', 'จังไร', 'ติ่ง', 'น้ำลาย',
            'พี่เลี้ยง', 'ทน', 'สันดาน', 'ขี้โกง', 'คอร์รัป', 'คม', 'ส้นตีน', 'โง่', 'ผี', 'เห่ย',
            'damn', 'hell', 'stupid', 'idiot', 'moron', 'jerk', 'asshole', 'bastard', 'fuck', 'shit', 'bitch',
            'cunt', 'dick', 'piss', 'slut', 'whore', 'fag', 'nigger', 'motherfucker', 'cock', 'twat', 'douchebag',
            'prick', 'wanker', 'wank', 'fistfuck', 'cocksucker', 'pussy', 'shithead', 'ass', 'butt', 'dumbass',
            'cocksucker', 'dumbass', 'shitface', 'clit', 'piss off', 'twat', 'fisting', 'tits', 'nipple', 'cum',
            'douche', 'sex', 'smegma', 'bukkake', 'fist', 'wank', 'blowjob', 'orgy', 'rapist', 'tard', 'retard'
        ];

        const userId = <?php echo json_encode($user_id); ?>;

        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const comment = document.getElementById('comment').value.trim();
            const rating = document.getElementById('ratingValue').value;

            let containsBadWord = badWords.some(word => comment.toLowerCase().includes(word.toLowerCase()));

            if (containsBadWord) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถส่งความคิดเห็นได้',
                    text: 'พบคำหยาบในความคิดเห็นของคุณ!',
                });
            } else if (rating === '0') {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถส่งความคิดเห็นได้',
                    text: 'กรุณาให้คะแนนก่อนส่ง!',
                });
            } else {
                fetch('submit_comment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            comment,
                            rating
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'ความคิดเห็นของคุณถูกส่งแล้ว!',
                            });
                            document.getElementById('commentForm').reset();
                            document.getElementById('ratingValue').value = '0';
                            document.querySelectorAll('.star-rating .star').forEach(star => {
                                star.classList.remove('selected');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: data.message || 'ไม่สามารถส่งความคิดเห็นได้',
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            text: 'ไม่สามารถส่งความคิดเห็นได้',
                        });
                    });

            }
        });

        document.querySelectorAll('.star-rating .star').forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                document.getElementById('ratingValue').value = value;
                document.querySelectorAll('.star-rating .star').forEach(star => {
                    star.classList.remove('selected');
                    if (star.getAttribute('data-value') <= value) {
                        star.classList.add('selected');
                    }
                });
            });

            star.addEventListener('mouseover', function() {
                const value = this.getAttribute('data-value');
                document.querySelectorAll('.star-rating .star').forEach(star => {
                    if (star.getAttribute('data-value') <= value) {
                        star.classList.add('hover');
                    } else {
                        star.classList.remove('hover');
                    }
                });
            });

            star.addEventListener('mouseout', function() {
                document.querySelectorAll('.star-rating .star').forEach(star => {
                    star.classList.remove('hover');
                });
            });
        });

        function populateEditModal(commentId, comment, rating) {
            document.getElementById('editCommentId').value = commentId;
            document.getElementById('editComment').value = comment;
            document.getElementById('editRatingValue').value = rating;
            // Set stars for the rating
            [...document.querySelectorAll('#editRating .star')].forEach(star => {
                star.classList.remove('selected');
                if (parseInt(star.getAttribute('data-value')) <= rating) {
                    star.classList.add('selected');
                }
            });
        }
        // ฟังก์ชันสำหรับการส่งข้อมูลการแก้ไข
        document.getElementById('editCommentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const commentId = document.getElementById('editCommentId').value;
            const comment = document.getElementById('editComment').value.trim();
            const rating = document.getElementById('editRatingValue').value;

            if (rating === '0') {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถบันทึกได้',
                    text: 'กรุณาให้คะแนนก่อนบันทึก!',
                });
            } else {
                fetch('update_comment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: commentId,
                            comment: comment,
                            rating: rating
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'ความคิดเห็นถูกแก้ไขแล้ว!',
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: data.message || 'ไม่สามารถแก้ไขความคิดเห็นได้',
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            text: 'ไม่สามารถแก้ไขความคิดเห็นได้',
                        });
                    });
            }
        });

        function confirmDelete(commentId) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: 'คุณต้องการลบความคิดเห็นนี้หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteComment(commentId);
                }
            });
        }

        function deleteComment(commentId) {
            fetch(`delete_comment.php?id=${commentId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'ความคิดเห็นถูกลบแล้ว',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: data.error
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถลบความคิดเห็นได้'
                    });
                });
        }

        // Star rating interaction
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                let value = this.getAttribute('data-value');
                document.getElementById('ratingValue').value = value;
                [...document.querySelectorAll('#rating .star')].forEach(s => {
                    s.classList.remove('selected');
                });
                this.classList.add('selected');
                for (let i = 1; i < value; i++) {
                    document.querySelector(`#rating .star[data-value="${i}"]`).classList.add('selected');
                }
            });
        });

        document.querySelectorAll('#editRating .star').forEach(star => {
            star.addEventListener('click', function() {
                let value = this.getAttribute('data-value');
                document.getElementById('editRatingValue').value = value;
                [...document.querySelectorAll('#editRating .star')].forEach(s => {
                    s.classList.remove('selected');
                });
                this.classList.add('selected');
                for (let i = 1; i < value; i++) {
                    document.querySelector(`#editRating .star[data-value="${i}"]`).classList.add('selected');
                }
            });
        });
    </script>
</body>

</html>