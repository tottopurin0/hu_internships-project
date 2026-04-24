<?php include('includes/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าแรก - IS SWU</title>
    <!-- ไฟล์ CSS Bootstrap และ FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <!-- CSS สำหรับจัดจอภาพสไลด์และเอฟเฟกต์การ์ด -->
    <style>
    .hero-slider {
        height: calc(100vh - 85px);
        position: relative;
    }

    .hero-slider .carousel-inner,
    .hero-slider .carousel-item {
        height: 100%;
    }

    .hero-slider .carousel-item img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .carousel-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 70%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        z-index: 1;
    }

    .custom-caption {
        position: absolute;
        bottom: 80px;
        left: 80px;
        z-index: 2;
        color: white;
        text-align: left;
    }

    .custom-caption h1 {
        font-size: 2.5rem;
        font-weight: 800;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
        margin-bottom: 5px;
    }

    .custom-caption p {
        font-size: 1.8rem;
        font-weight: 400;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.6);
    }

    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .transition-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }

    @media (max-width: 768px) {
        .custom-caption {
            left: 30px;
            bottom: 50px;
        }

        .custom-caption h1 {
            font-size: 2.5rem;
        }

        .custom-caption p {
            font-size: 1.2rem;
        }
    }
    </style>
</head>

<body class="bg-light">

    <!-- ดึง Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- ================= ส่วน SLIDER ภาพสไลด์ ================= -->
    <div id="swuCarousel" class="carousel slide hero-slider" data-bs-ride="carousel" data-bs-interval="4000">

        <div class="carousel-indicators" style="z-index: 3;">
            <button type="button" data-bs-target="#swuCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#swuCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#swuCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <!-- รูปที่ 1 -->
            <div class="carousel-item active">
                <img src="./img/sirigit.jpg" alt="sirigit">
                <div class="carousel-overlay"></div>
            </div>

            <!-- รูปที่ 2 -->
            <div class="carousel-item">
                <img src="./img/welcome.jpg" alt="University">
                <div class="carousel-overlay"></div>
                <div class="custom-caption">
                    <h1>หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา</h1>
                    <p>คณะมนุษยศาสตร์ มหาวิทยาลัยศรีนครินทรวิโรฒ</p>
                </div>
            </div>

            <!-- รูปที่ 3 -->
            <div class="carousel-item">
                <img src="./img/sornkran.jpg" alt="festival">
                <div class="carousel-overlay"></div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#swuCarousel" data-bs-slide="prev"
            style="z-index: 3; width: 7%;">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#swuCarousel" data-bs-slide="next"
            style="z-index: 3; width: 7%;">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- ================= ส่วน ข่าวสารกิจกรรม ================= -->
    <div class="container py-5 mt-4" id="showcase">

        <h3 class="fw-bold text-danger mb-4 border-start border-4 border-danger ps-3">
            <i class="fas fa-camera"></i> ข่าวสารกิจกรรม & IS Showcase
        </h3>

        <!-- รายการการ์ดข่าวสาร 3 การ์ดหลัก -->
        <div class="row g-4 mb-4">

            <!-- การ์ดกิจกรรมที่ 1 -->
            <div class="col-lg-4 col-md-6 a-item showcase" style="min-width: 320px;">
                <div
                    class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                    <img src="./img/pai online.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                        alt="Showcase">
                    <div class="activity-date-box" style="top: 15px; left: 15px;">
                        <span class="day">23</span>
                        <span class="month">ก.พ. 69</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column h-100">
                        <div class="mb-3">
                            <span class="badge bg-danger px-3 py-2 fw-bold rounded-1"
                                style="font-size: 13px;">ผลงาน</span>
                        </div>
                        <h5 class="fw-bold text-dark mt-1">กิจกรรมแข่งขันสร้างความตระหนักรู้ด้านคดีภัยออนไลน์ Cyber
                            Guardians & Digital Art Challenge University</h5>
                        <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                            เมื่อวันที่ 23 กุมภาพันธ์ 2569 ที่ผ่านมา นิสิตชั้นปีที่ 4
                            สาขาวิชาสารสนเทศศึกษาได้เข้าร่วมกิจกรรมแข่งขันสร้างความตระหนักรู้ด้านคดีภัยออนไลน์ ...
                        </p>
                        <a href="activities.php" class="btn btn-outline-danger w-100 mt-auto py-2 fw-medium">
                            อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- การ์ด 2 -->
            <div class="col-lg-4 col-md-6 a-item academic" style="min-width: 320px;">
                <div
                    class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                    <img src="./img/dit01.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                        alt="Academic4">
                    <div class="activity-date-box" style="top: 15px; left: 15px;">
                        <span class="day">24-25</span>
                        <span class="month">ก.ค. 68</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column h-100">
                        <div class="mb-3">
                            <span class="badge px-3 py-2 fw-bold rounded-1"
                                style="background-color: #0d6efd; font-size: 13px;">วิชาการ</span>
                        </div>
                        <h5 class="fw-bold text-dark mt-1">โครงการพัฒนาแหล่งเรียนรู้สู่ชุมชน ณ โรงเรียนวัดวังปลาจีด
                            จ.นครนายก และโรงเรียนวัดท่าช้าง (แสงปัญญาวิทยาคาร) จ.นครนายก</h5>
                        <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                            วันที่ 24- 25 กรกฎาคม 2568 หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา
                            ได้จัดโครงการพัฒนาแหล่งเรียนรู้สู่ชุมชน ณ โรงเรียนวัดวังปลาจีด จ.นครนายก
                            และโรงเรียนวัดท่าช้าง (แสงปัญญาวิทยาคาร) จ.นครนายก ...
                        </p>
                        <!-- ลิงก์ทะลุไปหน้า กิจกรรม -->
                        <a href="activities.php" class="btn btn-outline-primary w-100 mt-auto py-2 fw-medium">
                            อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- การ์ด 3 -->
            <div class="col-lg-4 col-md-6 a-item student" style="min-width: 320px;">
                <div
                    class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                    <img src="./img/ISspot.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                        alt="Camp">
                    <div class="activity-date-box" style="top: 15px; left: 15px;">
                        <span class="day">15</span>
                        <span class="month">ก.พ. 69</span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column h-100">
                        <div class="mb-3">
                            <span class="badge px-3 py-2 fw-bold rounded-1"
                                style="background-color: #198754; font-size: 13px;">กิจกรรมนิสิต</span>
                        </div>
                        <h5 class="fw-bold text-dark mt-1">IS DAY : โครงการสานสัมพันธ์สารสนเทศศึกษา</h5>
                        <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                            วันที่ 15 กุมภาพันธ์ 2569 ทางหลักสูตรได้จัดโครงการสานสัมพันธ์สารสนเทศ
                            เป็นกิจกรรมที่จัดขึ้นเพื่อเสริมสร้างความสัมพันธ์อันดีระหว่างนิสิตในสาขาสารสนเทศศึกษาทุกชั้นปี
                            ...
                        </p>
                        <!-- ลิงก์ทะลุไปหน้า กิจกรรม -->
                        <a href="activities.php" class="btn btn-outline-success w-100 mt-auto py-2 fw-medium">
                            อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- ปุ่มดูข่าวสารทั้งหมด -->
        <div class="text-center mt-3">
            <a href="activities.php" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm fw-bold">
                ดูข่าวสารทั้งหมด <i class="fas fa-angle-right ms-1"></i>
            </a>
        </div>

    </div>

    <!-- ดึงส่วนท้ายมาแสดง -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>