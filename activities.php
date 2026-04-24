<?php include('includes/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข่าวสารและกิจกรรม - IS SWU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css?v=1">
    <style>
    .activity-hero {
        background: linear-gradient(135deg, rgba(196, 18, 45, 0.9), rgba(33, 37, 41, 0.9)), url('./img/berner.jpg') center/cover;
        padding: 80px 0;
        color: white;
        text-align: center;
        margin-top: 0;
        margin-bottom: 40px;
    }

    /* =========================================
           CSS สำหรับ Slider การ์ดกิจกรรมและปุ่มเลื่อน
           ========================================= */
    .slider-wrapper {
        position: relative;
        padding: 0 10px;
    }

    /* ปรับให้กริดเลื่อนแนวนอนได้ และซ่อน Scrollbar */
    #activity-grid {
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        -ms-overflow-style: none;
        /* สำหรับ IE และ Edge */
        scrollbar-width: none;
        /* สำหรับ Firefox */
        padding-bottom: 15px;
    }

    #activity-grid::-webkit-scrollbar {
        display: none;
        /* ซ่อน Scrollbar ของ Chrome, Safari, Opera */
    }

    /* สไตล์ของปุ่มเลื่อน */
    .slide-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 45px;
        height: 45px;
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        z-index: 10;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .slide-btn:hover {
        background-color: #f8f9fa;
        color: #c4122d;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .slide-btn-prev {
        left: -20px;
    }

    .slide-btn-next {
        right: -20px;
    }

    @media (max-width: 768px) {
        .slide-btn {
            display: none;
        }

        /* ซ่อนปุ่มในมือถือให้ใช้นิ้วปัดแทน */
    }

    .indent {
        text-indent: 40px;
        line-height: 1.6;
    }

    /* จัดให้อยู่ตรงกลางและมีระยะห่าง */
    .pagination-dots {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        /* ระยะห่างระหว่างจุด */
        margin-top: 20px;
        /* ระยะห่างจากตัวการ์ดด้านบน */
    }

    /* รูปร่างของจุดปกติ (สีเทา) */
    .pagination-dots .dot {
        width: 12px;
        height: 12px;
        background-color: #e0e0e0;
        /* สีเทาอ่อน */
        border-radius: 50%;
        /* ทำให้เป็นวงกลม */
        cursor: pointer;
        transition: all 0.3s ease;
        /* ให้ตอนเปลี่ยนสีสมูทขึ้น */
    }

    /* รูปร่างของจุดที่ถูกเลือก (สีแดงยาว) */
    .pagination-dots .dot.active {
        width: 32px;
        /* ขยายความกว้างให้เป็นแคปซูล */
        background-color: #c8102e;
        /* สีแดงแบบในรูป */
        border-radius: 10px;
        /* ขอบมน */
    }
    </style>
</head>

<body style="background-color: #f8f9fa;">

    <?php include 'navbar.php'; ?>
<!-- กล่องด้านบนที่เป็นรูปภาพพร้อมตัวอักาณ -->
    <div class="activity-hero pb-5">
        <div class="container py-4">
            <h1 class="fw-bold mb-3"><i class="fas fa-camera-retro mb-2"></i><br>ข่าวสารกิจกรรม & IS Showcase</h1>
            <p class="fs-6 fw-light mb-0">ผลงานนวัตกรรม โครงการ และชีวิตนิสิตในรั้วมหาวิทยาลัยศรีนครินทรวิโรฒ</p>
        </div>
    </div>
<!-- จบกล่องด้านบน -->
    <div class="container pt-2 pb-5">
        <!-- กล่องตัวเลือกกิจกรรม -->
        <div class="text-center filter-btn-group mb-5">
            <button class="btn active" data-filter="all">ทั้งหมด</button>
            <button class="btn" data-filter="showcase"><i class="fas fa-star"></i> ผลงาน</button>
            <button class="btn" data-filter="academic"><i class="fas fa-book-open"></i> วิชาการ</button>
            <button class="btn" data-filter="student"><i class="fas fa-users"></i> กิจกรรมนิสิต</button>
        </div>

        <div class="slider-wrapper position-relative">

            <button class="slide-btn slide-btn-prev" id="slidePrev">
                <i class="fas fa-chevron-left"></i>
            </button>
        <!-- จบกล่องตัวเลือก -->
            <div class="row g-4" id="activity-grid">
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
                            <button class="btn btn-outline-danger w-100 mt-auto py-2 fw-bold" data-bs-toggle="modal"
                                data-bs-target="#modalShowcase">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 2 -->
                <div class="col-lg-4 col-md-6 a-item academic" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/sin.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Academic">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">08</span>
                            <span class="month">ส.ค. 68</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge px-3 py-2 fw-bold rounded-1"
                                    style="background-color: #0d6efd; font-size: 13px;">วิชาการ</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">ประชุมวิชาการ Digital Revolution: Moving Towards
                                Developing Sustainability Libraries</h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                วันที่ 8 สิงหาคม 2568 หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา คณะมนุษยศาสตร์
                                ได้จัดโครงการนำเสนอผลงานด้านสารสนเทศศึกษา ...
                            </p>
                            <button class="btn w-100 mt-auto py-2 fw-bold"
                                style="border: 1px solid #0d6efd; color: #0d6efd;"
                                onmouseover="this.style.backgroundColor='#0d6efd'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0d6efd';"
                                data-bs-toggle="modal" data-bs-target="#modalAcademic">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 3 -->
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
                            <button class="btn w-100 mt-auto py-2 fw-bold"
                                style="border: 1px solid #198754; color: #198754;"
                                onmouseover="this.style.backgroundColor='#198754'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#198754';"
                                data-bs-toggle="modal" data-bs-target="#modalCamp">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 4 -->
                <div class="col-lg-4 col-md-6 a-item showcase" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/FF01.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Showcase2">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">2569</span>
                            <span class="month"></span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge bg-danger px-3 py-2 fw-bold rounded-1"
                                    style="font-size: 13px;">ผลงาน</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">ทุนวิจัย Fundamental Fund (FF) ประจำปี 2569
                                ของคณาจารย์ประจำสาขาวิชาสารสนเทศศึกษา สังกัดกลุ่มสาขาวิชาพัฒนาศักยภาพมนุษย์ </h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                โครงการวิจัยที่ 1
                                "การพัฒนาแพลตฟอร์มกลางมหาวิทยาลัยศรีนครินทรวิโรฒเพื่อเชื่อมโยงและแลกเปลี่ยนข้อมูลด้านการบริการวิชาการ
                                ...
                            </p>
                            <button class="btn btn-outline-danger w-100 mt-auto py-2 fw-bold" data-bs-toggle="modal"
                                data-bs-target="#modalShowcase2">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 5 -->
                <div class="col-lg-4 col-md-6 a-item academic" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/sahagit.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Academic2">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">28</span>
                            <span class="month">เม.ย. 68</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge px-3 py-2 fw-bold rounded-1"
                                    style="background-color: #0d6efd; font-size: 13px;">วิชาการ</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">โครงการแลกเปลี่ยนเรียนรู้ประสบการณ์วิชาชีพและสหกิจศึกษา
                            </h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                วันที่ 28 เมษายน 2568 หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา
                                ได้จัดโครงการแลกเปลี่ยนเรียนรู้ประสบการณ์วิชาชีพและสหกิจศึกษา ...
                            </p>
                            <button class="btn w-100 mt-auto py-2 fw-bold"
                                style="border: 1px solid #0d6efd; color: #0d6efd;"
                                onmouseover="this.style.backgroundColor='#0d6efd'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0d6efd';"
                                data-bs-toggle="modal" data-bs-target="#modalAcademic2">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 6 -->
                <div class="col-lg-4 col-md-6 a-item student" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/sho02.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Camp2">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">23</span>
                            <span class="month">ก.พ. 69</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge px-3 py-2 fw-bold rounded-1"
                                    style="background-color: #198754; font-size: 13px;">กิจกรรมนิสิต</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">โครงการพัฒนาห้องสมุดโรงเรียนสู่ชุมชน</h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                หลักสูตรสารสนเทศศึกษา ได้จัดโครงการพัฒนาห้องสมุดโรงเรียนสู่ชุมชน ในวันที่ 23 กุมภาพันธ์
                                2569 โดยมีวัตถุประสงค์เพื่อพัฒนาแหล่งเรียนรู้สู่ชุมชนเน้นการพัฒนาห้องสมุดของโรงเรียน ...
                            </p>
                            <button class="btn w-100 mt-auto py-2 fw-bold"
                                style="border: 1px solid #198754; color: #198754;"
                                onmouseover="this.style.backgroundColor='#198754'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#198754';"
                                data-bs-toggle="modal" data-bs-target="#modalCamp2">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 7 -->
                <div class="col-lg-4 col-md-6 a-item showcase" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/FF02.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Showcase3">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">2569</span>
                            <span class="month"></span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge bg-danger px-3 py-2 fw-bold rounded-1"
                                    style="font-size: 13px;">ผลงาน</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">ทุนวิจัย Fundamental Fund (FF) ประจำปี 2569
                                ของคณาจารย์ประจำสาขาวิชาสารสนเทศศึกษา สังกัดกลุ่มสาขาวิชาพัฒนาศักยภาพมนุษย์ </h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                โครงการวิจัยที่ 2
                                "การพัฒนาแพลตฟอร์มดิจิทัลเพื่อให้บริการสารสนเทศในโรงเรียนมัธยมศึกษาขนาดกลางและขนาดเล็กในเขตกรุงเทพมหานคร"
                                ...
                            </p>
                            <button class="btn btn-outline-danger w-100 mt-auto py-2 fw-bold" data-bs-toggle="modal"
                                data-bs-target="#modalShowcase3">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 8 -->
                <div class="col-lg-4 col-md-6 a-item academic" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/TKpark.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Academic3">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">12</span>
                            <span class="month">พ.ย. 67</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge px-3 py-2 fw-bold rounded-1"
                                    style="background-color: #0d6efd; font-size: 13px;">วิชาการ</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">ศึกษาดูงานและแลกเปลี่ยนเรียนรู้ ณ TK Park</h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                นิสิตหลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา ชั้นปีที่ 1 ทั้งภาคปกติและภาคพิเศษ
                                ได้เข้าศึกษาดูงานและร่วมแลกเปลี่ยนเรียนรู้ในหัวข้อ
                                “การรู้สารสนเทศและการจัดการบริการสารสนเทศยุคใหม่” ณ อุทยานการเรียนรู้ TK Park ...
                            </p>
                            <button class="btn w-100 mt-auto py-2 fw-bold"
                                style="border: 1px solid #0d6efd; color: #0d6efd;"
                                onmouseover="this.style.backgroundColor='#0d6efd'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0d6efd';"
                                data-bs-toggle="modal" data-bs-target="#modalAcademic3">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 9 -->
                <div class="col-lg-4 col-md-6 a-item student" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/openHU.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Camp3">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">1-2</span>
                            <span class="month">พ.ย. 69</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge px-3 py-2 fw-bold rounded-1"
                                    style="background-color: #198754; font-size: 13px;">กิจกรรมนิสิต</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">SWU Open House 2025</h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                วันที่ 1-2 พฤศจิกายน 2568 มหาวิทยาลัยศรีนครินทรวิโรฒ ได้จัดกิจกรรม SWU Open House 2025
                                ทางคณะมนุษยศาสตร์ หลักสูตรสารสนเทศศึกษา ได้จัดบูธขึ้นเพื่อเปิดโอกาสให้น้องๆ
                                นักเรียนที่สนใจได้เข้ามาทำความรู้จักกับหลักสูตรสารสนเทศศึกษาอย่างใกล้ชิด ...
                            </p>
                            <button class="btn w-100 mt-auto py-2 fw-bold"
                                style="border: 1px solid #198754; color: #198754;"
                                onmouseover="this.style.backgroundColor='#198754'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#198754';"
                                data-bs-toggle="modal" data-bs-target="#modalCamp3">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 10 -->
                <div class="col-lg-4 col-md-6 a-item showcase" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/SPN o4 work.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Showcase4">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">27-28</span>
                            <span class="month">พ.ย. 68</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge bg-danger px-3 py-2 fw-bold rounded-1"
                                    style="font-size: 13px;">ผลงาน</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">งานประชุมวิชาการ
                                “การจัดการศึกษาและวิจัยทางบรรณารักษศาสตร์และสารสนเทศศาสตร์เพื่อการพัฒนาที่ยั่งยืน
                                ความท้าทายของ AI ในการสื่อสารทางวิชาการ” </h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                เมื่อวันที่ 27-28 พฤศจิกายน 2568 ที่ผ่านมา ทางหลักสูตร ศศ.บ.สาขาวิชาสารสนเทศศึกษา
                                นำนิสิตไปนำเสนองานประชุมวิชาการภายใต้หัวข้อ
                                "การจัดการศึกษาและวิจัยทางบรรณารักษศาสตร์และสารสนเทศศาสตร์เพื่อการพัฒนาที่ยั่งยืน
                                ความท้าทายของ AI ในการสื่อสารทางวิชาการ" ...
                            </p>
                            <button class="btn btn-outline-danger w-100 mt-auto py-2 fw-bold" data-bs-toggle="modal"
                                data-bs-target="#modalShowcase4">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 11 -->
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
                            <button class="btn w-100 mt-auto py-2 fw-bold"
                                style="border: 1px solid #0d6efd; color: #0d6efd;"
                                onmouseover="this.style.backgroundColor='#0d6efd'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0d6efd';"
                                data-bs-toggle="modal" data-bs-target="#modalAcademic4">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 12 -->
                <div class="col-lg-4 col-md-6 a-item student" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/fristday.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Camp4">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">21-22</span>
                            <span class="month">ก.ค. 68</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge px-3 py-2 fw-bold rounded-1"
                                    style="background-color: #198754; font-size: 13px;">กิจกรรมนิสิต</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">ปฐมนิเทศนิสิตชั้นปีที่ 1</h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                วันที่ 21-22 กรกฎาคม 2568 หลักสูตรสารสนเทศศึกษาได้จัดโครงการปฐมนิเทศนิสิตชั้นปีที่ 1
                                จัดขึ้นเพื่อเตรียมความพร้อมให้กับนิสิตใหม่ในการก้าวเข้าสู่ชีวิตในรั้วมหาวิทยาลัยอย่างมั่นใจ
                                ...
                            </p>
                            <button class="btn w-100 mt-auto py-2 fw-bold"
                                style="border: 1px solid #198754; color: #198754;"
                                onmouseover="this.style.backgroundColor='#198754'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#198754';"
                                data-bs-toggle="modal" data-bs-target="#modalCamp4">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 13 -->
                <div class="col-lg-4 col-md-6 a-item student" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/satapanaHU.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Camp5">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">22</span>
                            <span class="month">ส.ค. 68</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge px-3 py-2 fw-bold rounded-1"
                                    style="background-color: #198754; font-size: 13px;">กิจกรรมนิสิต</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">งานสถาปนาคณะมนุษยศาสตร์ ครบรอบ 50 ปี</h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                เมื่อวันที่ 22 สิงหาคม พ.ศ. 2568 ได้จัดงานสถาปนาคณะมนุษยศาสตร์
                                มหาวิทยาลัยศรีนครินทรวิโรฒ ครบรอบ 50 ปี
                                เป็นกิจกรรมสำคัญที่จัดขึ้นเพื่อเฉลิมฉลองวาระครบรอบของคณะ ...
                            </p>
                            <button class="btn w-100 mt-auto py-2 fw-bold"
                                style="border: 1px solid #198754; color: #198754;"
                                onmouseover="this.style.backgroundColor='#198754'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#198754';"
                                data-bs-toggle="modal" data-bs-target="#modalCamp5">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- การ์ดกิจกรรมที่ 14 -->
                <div class="col-lg-4 col-md-6 a-item student" style="min-width: 320px;">
                    <div
                        class="activity-card-item h-100 d-flex flex-column bg-white shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <img src="./img/mss.jpg" class="img-fluid w-100 object-fit-cover" style="height: 220px;"
                            alt="Camp6">
                        <div class="activity-date-box" style="top: 15px; left: 15px;">
                            <span class="day">1</span>
                            <span class="month">ก.พ. 68</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <div class="mb-3">
                                <span class="badge px-3 py-2 fw-bold rounded-1"
                                    style="background-color: #198754; font-size: 13px;">กิจกรรมนิสิต</span>
                            </div>
                            <h5 class="fw-bold text-dark mt-1">โครงการสืบสานธรรมะศึกษาและศิลปวัฒนธรรมอย่างยั่งยืน
                                กิจกรรมศึกษาดูงาน ณ มิวเซียมสยาม พิพิธภัณฑ์ การรเรียนรู้แห่งชาติ กรุงเทพมหานครฯ</h5>
                            <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;">
                                โครงการสืบสานธรรมะศึกษาและศิลปวัฒนธรรมอย่างยั่งยืน
                                เป็นกิจกรรมศึกษาดูงานที่จัดขึ้นเพื่อส่งเสริมให้นิสิตได้เรียนรู้และตระหนักถึงคุณค่าของศิลปวัฒนธรรมไทย
                                ควบคู่ไปกับการปลูกฝังแนวคิดด้านคุณธรรมและจริยธรรม ...
                            </p>
                            <button class="btn w-100 mt-auto py-2 fw-bold"
                                style="border: 1px solid #198754; color: #198754;"
                                onmouseover="this.style.backgroundColor='#198754'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#198754';"
                                data-bs-toggle="modal" data-bs-target="#modalCamp6">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <button class="slide-btn slide-btn-next" id="slideNext">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 1 -->
        <div class="modal fade" id="modalShowcase" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #c4122d;">
                        <h5 class="modal-title fw-bold fs-6">กิจกรรมแข่งขันสร้างความตระหนักรู้ด้านคดีภัยออนไลน์ Cyber
                            Guardians & Digital Art Challenge University</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/pai online.jpg" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #c4122d;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                เมื่อวันที่ 23 กุมภาพันธ์ 2569 ที่ผ่านมา นิสิตชั้นปีที่ 4
                                สาขาวิชาสารสนเทศศึกษาได้เข้าร่วมกิจกรรมแข่งขันสร้างความตระหนักรู้ด้านคดีภัยออนไลน์
                                (รอบชิงชนะเลิศ)
                                Cyber Guardians & Digital Art Challenge (ครั้งที่ ๒) University ณ ห้อง Magic 3 โรงแรม
                                มิราเคิล แกรนด์ คอนเวนชั่น กรุงเทพฯ จัดโดยกระทรวงดิจิทัลเพื่อเศรษฐกิจและสังคม หรือ
                                กระทรวงดีอี (MDES)<br>
                            </p>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                สำหรับการจัดกิจกรรมดังกล่าว
                                จัดขึ้นเพื่อส่งเสริมให้เยาวชนตระหนักถึงความสำคัญของการรักษาความปลอดภัยทางเทคโนโลยี
                                รู้และความเข้าใจเกี่ยวกับภัยออนไลน์
                                เสริมสร้างเกราะป้องกันการตกเป็นเหยื่อของอาชญากรรมทางเทคโนโลยี
                                นอกจากนี้เป็นการสนับสนุนให้เยาวชนได้เรียนรู้และพัฒนาเกี่ยวกับปัญญาประดิษฐ์ (AI)
                                เป็นอีกหนึ่งแนวทางสำคัญในการเตรียมความพร้อมสู่อนาคต
                                เพื่อสามารถนำความรู้ไปใช้ในการสร้างสรรค์นวัตกรรมใหม่ ๆ เพื่อพัฒนาโอกาส
                                ในอาชีพการงานของตนเองได้ <br><br>
                                ชื่องานภาษาอังกฤษ : Cyber Guardians Digital Art Challenge ครั้งที่ 2 University<br>
                                ชื่องานภาษาไทย : กิจกรรมการสร้างความตระหนักรู้ด้านคดีภัยออนไลน์<br><br>
                                นิสิตสาขาวิชาสารสนเทศศึกษา ชั้นปีที่ 4 ได้รับรางวัลชมเชยอับดับ 1<br>
                                รายชื่อสมาชิก :<br>
                                1. นายปิยศักดิ์ ปานประทีป<br>
                                2. นางสาวชารีดา พึ่งกริม<br>
                                3. นางสาวอารียา สงวนพงศ์<br>
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาสาขาวิชาสารสนเทศศึกษาเป็นที่ปรึกษา ทางหลักสูตรฯ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 2 -->
        <div class="modal fade" id="modalAcademic" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #0d6efd;">
                        <h5 class="modal-title fw-bold fs-6">ประชุมวิชาการ Digital Revolution: Moving Towards Developing
                            Sustainability Libraries</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/sin.jpg" class="img-fluid w-100" style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #0d6efd;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                วันที่ 8 สิงหาคม 2568 หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา คณะมนุษยศาสตร์
                                ได้จัดโครงการนำเสนอผลงานด้านสารสนเทศศึกษา ครั้งที่ 2 ณ หอสมุดแห่งชาติ กรมศิลปากร
                                กระทรวงวัฒนธรรม กรุงเทพมหานคร โดยมี อาจารย์ ดร.โชคธำรงค์ จงจอหอ เป็นประธานโครงการ
                                มีวัตถุประสงค์เพื่อให้นิสิตระดับปริญญาตรี ชั้นปีที่ 3
                                ได้เข้าร่วมประชุมวิชาการและมีตัวแทนนิสิตร่วมนำเสนอผลงานด้านสารสนเทศศึกษาในหัวข้อเกี่ยวเรื่อง
                                “Digital Revolution: Moving Towards Developing Sustainability Libraries”
                                โดยมุ่งเน้นและส่งเสริมพัฒนาให้นิสิตได้แลกเปลี่ยนเรียนรู้จากผู้เชี่ยวชาญในวิชาชีพบรรณารักษศาสตร์และสารสนเทศศึกษาจากหลากหลายสถาบัน
                                ซึ่งนำไปสู่ความร่วมมือและโอกาสการทำงานในอนาคต
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาสาขาวิชาสารสนเทศศึกษาเป็นที่ปรึกษา ทางหลักสูตรฯ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 3 -->
        <div class="modal fade" id="modalCamp" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #198754;">
                        <h5 class="modal-title fw-bold fs-6">IS DAY : โครงการสานสัมพันธ์สารสนเทศศึกษา</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/ISspot.jpg" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #198754;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                วันที่ 15 กุมภาพันธ์ 2569 ทางหลักสูตรได้จัดโครงการสานสัมพันธ์สารสนเทศ
                                เป็นกิจกรรมที่จัดขึ้นเพื่อเสริมสร้างความสัมพันธ์อันดีระหว่างนิสิตในสาขาสารสนเทศศึกษาทุกชั้นปี
                                ตั้งแต่ปีที่ 1 ถึงปีที่ 4 ที่ผ่านมา
                                โดยมีเป้าหมายหลักเพื่อส่งเสริมความสัมพันธ์อันดีระหว่างนิสิตและบุคลากรภายในภาควิชาสารสนเทศศึกษา
                                ให้เกิดความสามัคคี ความเข้าใจอันดี และความผูกพันในองค์กร
                                ผ่านกิจกรรมที่สร้างสรรค์และเปิดโอกาสให้ผู้เข้าร่วมได้มีปฏิสัมพันธ์ร่วมกันอย่างใกล้ชิด
                                ภายในโครงการประกอบด้วยกิจกรรมสานสัมพันธ์หลากหลายรูปแบบ
                                ทั้งกิจกรรมกีฬาและกิจกรรมกลุ่มสัมพันธ์ เช่น การแข่งขันบาสเกตบอล วอลเลย์บอลยักษ์ ชักเย่อ
                                และกิจกรรมฐาน เช่น เกมวิบาก ซึ่งมุ่งเน้นการทำงานเป็นทีม การสื่อสาร
                                และการสร้างความสนุกสนานร่วมกัน
                            </p>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                นอกจากนี้ ยังมีกิจกรรมเสริมสร้างความสัมพันธ์ระหว่างนิสิตต่างชั้นปี เช่น
                                กิจกรรมละลายพฤติกรรม (Ice Breaking) และการจับกลุ่มทำกิจกรรมร่วมกัน
                                เพื่อเปิดโอกาสให้นิสิตได้ทำความรู้จัก แลกเปลี่ยนประสบการณ์ และสร้างเครือข่ายภายในภาควิชา
                                โครงการนี้จึงนับเป็นอีกหนึ่งกิจกรรมสำคัญที่ช่วยเสริมสร้างบรรยากาศแห่งความอบอุ่น
                                ความร่วมมือ และความเป็นหนึ่งเดียวกันของชาวสารสนเทศศึกษา
                                อันจะนำไปสู่การพัฒนาศักยภาพทั้งด้านวิชาการและการทำงานร่วมกันในอนาคต

                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาและนิสิตสาขาวิชาสารสนเทศศึกษาเป็นผู้รับผิดชอบ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 4 -->
        <div class="modal fade" id="modalShowcase2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #c4122d;">
                        <h5 class="modal-title fw-bold fs-6">ทุนวิจัย Fundamental Fund (FF) ประจำปี 2569
                            ของคณาจารย์ประจำสาขาวิชาสารสนเทศศึกษา สังกัดกลุ่มสาขาวิชาพัฒนาศักยภาพมนุษย์ </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/FF01.jpg" class="img-fluid w-100" style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #c4122d;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                โครงการวิจัยที่ 1
                                "การพัฒนาแพลตฟอร์มกลางมหาวิทยาลัยศรีนครินทรวิโรฒเพื่อเชื่อมโยงและแลกเปลี่ยนข้อมูลด้านการบริการวิชาการ
                                โดยมาตรฐาน Statistical Data and Metadata Exchange (SDMX)"<br><br>
                                ผู้วิจัย<br>
                                ผศ. ดร.ดุษฎี สีวังคำ (หัวหน้าโครงการวิจัย)<br>
                                อ. ดร.ดิษฐ์ สุทธิวงศ์<br>
                                ผศ. ดร.วิภากร วัฒนสินธุ์<br>

                            </p>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                จากการได้รับทุนวิจัย Fundamental Fund ของ สกสว. ในครั้งนี้
                                พวกเรามุ่งหวังที่จะค้นพบองค์ความรู้ใหม่ที่จะนำมาพัฒนานิสิตในสาขาวิชาสารสนเทศศึกษาของเราต่อไป
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาสาขาวิชาสารสนเทศศึกษาเป็นที่ปรึกษา ทางหลักสูตรฯ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 5 -->
        <div class="modal fade" id="modalAcademic2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #0d6efd;">
                        <h5 class="modal-title fw-bold fs-6">โครงการแลกเปลี่ยนเรียนรู้ประสบการณ์วิชาชีพและสหกิจศึกษา
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/sahagit.jpg" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #0d6efd;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                วันที่ 28 เมษายน 2568 หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา
                                ได้จัดโครงการแลกเปลี่ยนเรียนรู้ประสบการณ์วิชาชีพและสหกิจศึกษา
                                มีวัตถุประสงค์เพื่อสรุปภาพรวมของกิจกรรมฝึกงานและฝึกประสบการณ์วิชาชีพสหกิจศึกษาโดยการนําเสนอผลงานโครงงานของนิสิต
                                นำปัญหาอุปสรรคที่พบระหว่างฝึกงานมานำเสนอและแลกเปลี่ยนวิธีการแก้ไขปัญหา
                                และเป็นการแบ่งปันประสบการณ์และเตรียมความพร้อมให้กับนิสิตในรุ่นถัดไป โดยมีนิสิตปี 4
                                ร่วมบรรยายและแบ่งปันประสบการณ์ทำงานให้กับนิสิตรุ่นน้อง
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาและนิสิตสาขาวิชาสารสนเทศศึกษาเป็นผู้รับผิดชอบ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 6 -->
        <div class="modal fade" id="modalCamp2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #198754;">
                        <h5 class="modal-title fw-bold fs-6">โครงการพัฒนาห้องสมุดโรงเรียนสู่ชุมชน</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/sho02.jpg" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #198754;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                หลักสูตรสารสนเทศศึกษา ได้จัดโครงการพัฒนาห้องสมุดโรงเรียนสู่ชุมชน ในวันที่ 23 กุมภาพันธ์
                                2569 โดยมีวัตถุประสงค์เพื่อพัฒนาแหล่งเรียนรู้สู่ชุมชนเน้นการพัฒนาห้องสมุดของโรงเรียน
                                ประกอบไปด้วยกิจกรรมหลักคือการจัดทรัพยากรสารสนเทศและห้องสมุดและจัดกิจกรรมส่งเสริมการอ่านสำหรับนักเรียนประถมศึกษาจำนวน
                                4 ฐาน ณ โรงเรียนสุเหร่าสามอิน กรุงเทพมหานคร
                                ที่มุ่งเน้นการพัฒนาและปรับปรุงห้องสมุดให้เป็นแหล่งเรียนรู้ที่มีคุณภาพและตอบสนองต่อความต้องการของนักเรียน
                                ครูและชุมชนโดยรอบ ขอขอบพระคุณคณะผู้บริหารและคณาจารย์โรงเรียนสุเหร่าสามอิน
                                ที่ให้การสนับสนุนโครงการเป็นอย่างดียิ่ง รวมถึงน้อง ๆ นักเรียนชั้นประถมศึกษาปีที่ 4 ทุกคน
                                ที่ให้ความร่วมมือจนทำให้โครงการสำเร็จลุล่วงไปด้วยดี
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาและนิสิตสาขาวิชาสารสนเทศศึกษาเป็นผู้รับผิดชอบ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 7 -->
        <div class="modal fade" id="modalShowcase3" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #c4122d;">
                        <h5 class="modal-title fw-bold fs-6">ทุนวิจัย Fundamental Fund (FF) ประจำปี 2569
                            ของคณาจารย์ประจำสาขาวิชาสารสนเทศศึกษา สังกัดกลุ่มสาขาวิชาพัฒนาศักยภาพมนุษย์ </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/FF02.jpg" class="img-fluid w-100" style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #c4122d;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                โครงการวิจัยที่ 2
                                "การพัฒนาแพลตฟอร์มดิจิทัลเพื่อให้บริการสารสนเทศในโรงเรียนมัธยมศึกษาขนาดกลางและขนาดเล็กในเขตกรุงเทพมหานคร"<br><br>
                                ผู้วิจัย<br>
                                ผศ. ดร.วิภากร วัฒนสินธุ์ (หัวหน้าโครงการวิจัย)<br>
                                อ. ดร.ฐิติ อติชาติชยากร<br>
                            </p>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                จากการได้รับทุนวิจัย Fundamental Fund ของ สกสว. ในครั้งนี้
                                พวกเรามุ่งหวังที่จะค้นพบองค์ความรู้ใหม่ที่จะนำมาพัฒนานิสิตในสาขาวิชาสารสนเทศศึกษาของเราต่อไป
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาสาขาวิชาสารสนเทศศึกษาเป็นที่ปรึกษา ทางหลักสูตรฯ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 8 -->
        <div class="modal fade" id="modalAcademic3" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #0d6efd;">
                        <h5 class="modal-title fw-bold fs-6">ศึกษาดูงานและแลกเปลี่ยนเรียนรู้ ณ TK Park
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/TKpark.jpg" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #0d6efd;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                นิสิตหลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา ชั้นปีที่ 1 ทั้งภาคปกติและภาคพิเศษ
                                ได้เข้าศึกษาดูงานและร่วมแลกเปลี่ยนเรียนรู้ในหัวข้อ
                                “การรู้สารสนเทศและการจัดการบริการสารสนเทศยุคใหม่” ณ อุทยานการเรียนรู้ TK Park
                                เพื่อเสริมสร้างความรู้และประสบการณ์นอกห้องเรียนให้สอดคล้องกับบริบทการเรียนรู้ในยุคดิจิทัล
                                ในการศึกษาดูงานครั้งนี้ นิสิตได้มีโอกาสรับฟังการบรรยายจากวิทยากรผู้เชี่ยวชาญ
                                พร้อมทั้งร่วมแลกเปลี่ยนความคิดเห็นเกี่ยวกับแนวทางการจัดการสารสนเทศ
                                การให้บริการในแหล่งเรียนรู้สมัยใหม่
                                และบทบาทของห้องสมุดในยุคที่เทคโนโลยีมีการเปลี่ยนแปลงอย่างรวดเร็ว
                            </p>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                นอกจากนี้ นิสิตยังได้ทดลองใช้บริการและสำรวจพื้นที่การเรียนรู้ภายใน TK Park
                                ซึ่งมีการออกแบบให้สอดคล้องกับพฤติกรรมการเรียนรู้ของผู้ใช้ในปัจจุบัน อาทิ
                                พื้นที่อ่านหนังสือ พื้นที่สร้างสรรค์ และสื่อการเรียนรู้ดิจิทัล
                                ส่งผลให้นิสิตสามารถนำแนวคิดและประสบการณ์ที่ได้รับไปประยุกต์ใช้ในการเรียนและพัฒนาทักษะทางวิชาชีพในอนาคต
                                โครงการศึกษาดูงานในครั้งนี้จึงเป็นอีกหนึ่งกิจกรรมสำคัญที่ช่วยเปิดมุมมองใหม่ ๆ
                                ให้แก่นิสิต
                                และส่งเสริมความเข้าใจเกี่ยวกับการจัดการสารสนเทศและแหล่งเรียนรู้ในยุคปัจจุบันได้อย่างเป็นรูปธรรม
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาสาขาวิชาสารสนเทศศึกษาเป็นที่ปรึกษา ทางหลักสูตรฯ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 9 -->
        <div class="modal fade" id="modalCamp3" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #198754;">
                        <h5 class="modal-title fw-bold fs-6">SWU Open House 2025</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/openHU.jpg" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #198754;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                วันที่ 1-2 พฤศจิกายน 2568 มหาวิทยาลัยศรีนครินทรวิโรฒ ได้จัดกิจกรรม SWU Open House 2025
                                ทางคณะมนุษยศาสตร์ หลักสูตรสารสนเทศศึกษา ได้จัดบูธขึ้นเพื่อเปิดโอกาสให้น้องๆ
                                นักเรียนที่สนใจได้เข้ามาทำความรู้จักกับหลักสูตรสารสนเทศศึกษาอย่างใกล้ชิด
                                ภายในบูธมีการรวบรวมข้อมูลสำคัญเกี่ยวกับหลักสูตร เนื้อหาการเรียน
                                ทักษะที่จำเป็นในยุคดิจิทัล รวมถึงแนวทางการประกอบอาชีพในอนาคต น้องๆ
                                จะได้พบกับกิจกรรมที่ทั้งสนุกและเสริมสร้างความรู้ ไม่ว่าจะเป็นเกม การสาธิต
                                หรือกิจกรรมเชิงปฏิบัติที่พี่ๆ นิสิตได้ร่วมกันออกแบบและจัดเตรียมขึ้น
                                เพื่อให้ผู้เข้าร่วมได้สัมผัสประสบการณ์การเรียนรู้แบบลงมือทำจริง
                                อีกทั้งยังสามารถสอบถามข้อมูลเกี่ยวกับการเรียน การใช้ชีวิตในมหาวิทยาลัย
                                และการเตรียมตัวเข้าสู่หลักสูตรได้อย่างเป็นกันเอง กิจกรรมนี้ไม่เพียงช่วยให้น้องๆ
                                ได้เข้าใจภาพรวมของหลักสูตรสารสนเทศศึกษาเท่านั้น แต่ยังเป็นพื้นที่แห่งแรงบันดาลใจ
                                ที่เปิดโอกาสให้ทุกคนได้ค้นพบความสนใจของตนเอง
                                และเตรียมความพร้อมสู่การศึกษาในระดับมหาวิทยาลัย ภายใต้บรรยากาศที่อบอุ่น เป็นมิตร
                                และเต็มไปด้วยพลังของการเรียนรู้จากพี่ๆ นิสิตคณะมนุษยศาสตร์ มหาวิทยาลัยศรีนครินทรวิโรฒ
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาและนิสิตสาขาวิชาสารสนเทศศึกษาเป็นผู้รับผิดชอบ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 10 -->
        <div class="modal fade" id="modalShowcase4" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #c4122d;">
                        <h5 class="modal-title fw-bold fs-6">งานประชุมวิชาการ
                            “การจัดการศึกษาและวิจัยทางบรรณารักษศาสตร์และสารสนเทศศาสตร์เพื่อการพัฒนาที่ยั่งยืน
                            ความท้าทายของ AI ในการสื่อสารทางวิชาการ”</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/SPN o4 work.jpg" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #c4122d;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                เมื่อวันที่ 27-28 พฤศจิกายน 2568 ที่ผ่านมา ทางหลักสูตร ศศ.บ.สาขาวิชาสารสนเทศศึกษา
                                นำนิสิตไปนำเสนองานประชุมวิชาการภายใต้หัวข้อ
                                “การจัดการศึกษาและวิจัยทางบรรณารักษศาสตร์และสารสนเทศศาสตร์เพื่อการพัฒนาที่ยั่งยืน
                                ความท้าทายของ AI ในการสื่อสารทางวิชาการ“ จัดขึ้นโดยสมาคมห้องสมุดแห่งประเทศไทย ณ
                                โรงแรมแอมบาสเดอร์ กรุงเทพฯ โดยครั้งนี้ นิสิตในหลักสูตรฯ ได้รับรางวัลจำนวน 4 รางวัล
                                ได้แก่<br><br>

                                รางวัลชนะเลิศอันดับ 2<br>
                                บรรณบำบัด: การทบทวนวรรณกรรมอย่างเป็นระบบการวิเคราะห์บรรณมิติ<br>
                                อาจารย์ที่ปรึกษา : อาจารย์ ดร.โชคธำรง จงจอหอ<br><br>

                                รางวัลชมเชย<br>
                                GOGO WORD สำรวจโลกคำศัพท์: นวัตกรรมส่งเสริมทักษะภาษาอังกฤษ<br>
                                แบบบูรณาการสำหรับนักเรียนระดับประถมศึกษา<br>
                                อาจารย์ที่ปรึกษา : ผู้ช่วยศาสตราจารย์ ดร.ศศิพิมล ประพินพงศกร และ อาจารย์ โชติมา
                                วัฒนะ<br><br>

                                การพัฒนาเว็บไซต์ส่งเสริมความพร้อมในการศึกษาต่อระดับอุดมศึกษา<br>
                                สำหรับนักเรียนมัธยมศึกษาตอนปลาย<br>
                                อาจารย์ที่ปรึกษา : ผู้ช่วยศาสตราจารย์ ดร.ศศิพิมล ประพินพงศกร และ อาจารย์ โชติมา
                                วัฒนะ<br><br>

                                การพัฒนาเว็บไซต์ระบบศิษย์เก่าเพื่อส่งเสริมเครือข่ายความร่วมมือทางวิชาการ<br>
                                อาจารย์ที่ปรึกษา : ผู้ช่วยศาสตราจารย์ ดร.วิภากร วัฒนสินธุ์ ผู้ช่วยศาสตราจารย์
                                ดร.ดุษฎี<br>
                                สีวังคำ และอาจารย์ ดร.ดิษฐ์ สุทธิวงศ์<br><br>

                                ทางหลักสูตรฯ ขอแสดงความยินดีกับนิสิตที่ได้รับรางวัลในการประชุมครั้งนี้ด้วย

                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาสาขาวิชาสารสนเทศศึกษาเป็นที่ปรึกษา ทางหลักสูตรฯ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 11 -->
        <div class="modal fade" id="modalAcademic4" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #0d6efd;">
                        <h5 class="modal-title fw-bold fs-6">โครงการพัฒนาแหล่งเรียนรู้สู่ชุมชน ณ โรงเรียนวัดวังปลาจีด
                            จ.นครนายก และโรงเรียนวัดท่าช้าง (แสงปัญญาวิทยาคาร) จ.นครนายก
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/dit01.jpg" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #0d6efd;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                โครงการพัฒนาแหล่งเรียนรู้สู่ชุมชน ได้ดำเนินการจัดขึ้น ณ โรงเรียนวัดวังปลาจีด
                                และโรงเรียนวัดท่าช้าง (แสงปัญญาวิทยาคาร) จังหวัดนครนายก
                                โดยมีวัตถุประสงค์เพื่อเปิดโอกาสให้นิสิตได้นำองค์ความรู้ด้านสารสนเทศศึกษามาบูรณาการกับการพัฒนาแหล่งเรียนรู้ในบริบทของชุมชนอย่างเป็นรูปธรรม
                                การดำเนินโครงการมุ่งเน้นการออกแบบและปรับปรุงแหล่งเรียนรู้ให้สอดคล้องกับความต้องการของโรงเรียนและชุมชนโดยรอบ
                                อาทิ การจัดระบบทรัพยากรสารสนเทศ การพัฒนาพื้นที่การเรียนรู้ให้เหมาะสมต่อการใช้งาน
                                และการจัดกิจกรรมส่งเสริมการเรียนรู้ที่ช่วยกระตุ้นความสนใจของผู้เรียน
                            </p>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                นอกจากนี้ นิสิตยังได้มีส่วนร่วมในการวิเคราะห์ความต้องการของชุมชน วางแผนการดำเนินงาน
                                และลงมือปฏิบัติจริง ซึ่งช่วยเสริมสร้างทั้งทักษะทางปัญญา ทักษะชีวิต และทักษะวิชาชีพ
                                อันเป็นพื้นฐานสำคัญในการพัฒนาตนเองสู่การเป็นบัณฑิตที่มีคุณภาพและสามารถปรับตัวในสังคมได้อย่างมีประสิทธิภาพ
                                โครงการนี้จึงนับเป็นอีกหนึ่งกิจกรรมที่ส่งเสริมการเรียนรู้นอกห้องเรียน
                                และสะท้อนถึงบทบาทของสาขาวิชาสารสนเทศศึกษาในการนำความรู้ไปใช้ประโยชน์เพื่อพัฒนาสังคมและชุมชนอย่างยั่งยืน
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาและนิสิตสาขาวิชาสารสนเทศศึกษาเป็นผู้รับผิดชอบ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 12 -->
        <div class="modal fade" id="modalCamp4" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #198754;">
                        <h5 class="modal-title fw-bold fs-6">ปฐมนิเทศนิสิตชั้นปีที่ 1</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/fristday.jpg" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #198754;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                วันที่ 21-22 กรกฎาคม 2568 หลักสูตรสารสนเทศศึกษาได้จัดโครงการปฐมนิเทศนิสิตชั้นปีที่ 1
                                จัดขึ้นเพื่อเตรียมความพร้อมให้กับนิสิตใหม่ในการก้าวเข้าสู่ชีวิตในรั้วมหาวิทยาลัยอย่างมั่นใจ
                                ภายในกิจกรรม นิสิตจะได้ทำความรู้จักกับหลักสูตร แนวทางการเรียน ระบบการศึกษา
                                ตลอดจนกฎระเบียบและสิ่งอำนวยความสะดวกต่างๆ ที่เกี่ยวข้อง นอกจากนี้
                                ยังเป็นโอกาสสำคัญที่นิสิตใหม่จะได้พบปะอาจารย์ พี่ๆ นิสิต และเพื่อนร่วมรุ่น
                                ผ่านกิจกรรมสร้างความสัมพันธ์ที่ช่วยลดความกังวล และเสริมสร้างความคุ้นเคยในสภาพแวดล้อมใหม่
                                พร้อมทั้งได้รับคำแนะนำเกี่ยวกับการวางแผนการเรียน การใช้ชีวิตในมหาวิทยาลัย
                                และการพัฒนาตนเองในด้านต่างๆ โครงการปฐมนิเทศนี้จึงถือเป็นจุดเริ่มต้นที่สำคัญ
                                ที่ช่วยให้นิสิตชั้นปีที่ 1 สามารถปรับตัวได้อย่างเหมาะสม
                                มีความเข้าใจในเส้นทางการเรียนของตนเอง
                                และก้าวสู่การเป็นนิสิตสารสนเทศศึกษาอย่างเต็มภาคภูมิ ภายใต้บรรยากาศที่อบอุ่น เป็นกันเอง
                                และเต็มไปด้วยแรงสนับสนุนจากคณาจารย์และพี่ๆ นิสิต
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาและนิสิตสาขาวิชาสารสนเทศศึกษาเป็นผู้รับผิดชอบ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 13 -->
        <div class="modal fade" id="modalCamp5" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #198754;">
                        <h5 class="modal-title fw-bold fs-6">งานสถาปนาคณะมนุษยศาสตร์ ครบรอบ 50 ปี</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/satapanaHU.jpg" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #198754;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                เมื่อวันที่ 22 สิงหาคม พ.ศ. 2568 ได้จัดงานสถาปนาคณะมนุษยศาสตร์
                                มหาวิทยาลัยศรีนครินทรวิโรฒ ครบรอบ 50 ปี
                                เป็นกิจกรรมสำคัญที่จัดขึ้นเพื่อเฉลิมฉลองวาระครบรอบของคณะ
                                พร้อมทั้งสร้างความภาคภูมิใจและความผูกพันให้กับนิสิต คณาจารย์ และบุคลากรทุกคนในคณะ
                                ภายในงานมีกิจกรรมที่เปิดโอกาสให้นิสิตชั้นปีที่ 1
                                ของแต่ละสาขาได้มีส่วนร่วมอย่างสร้างสรรค์ โดยการจัดบูธจำหน่ายสินค้า
                                ซึ่งนิสิตได้ร่วมกันวางแผน ออกแบบ และบริหารจัดการบูธของตนเอง ไม่ว่าจะเป็นอาหาร
                                เครื่องดื่ม หรือสินค้าต่างๆ ที่น่าสนใจ
                                เพื่อหารายได้เข้าสาขาและสนับสนุนกิจกรรมของนิสิตในอนาคต
                            </p>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                กิจกรรมนี้ไม่เพียงแต่ช่วยเสริมสร้างความสามัคคีและการทำงานเป็นทีมเท่านั้น
                                แต่ยังเปิดโอกาสให้นิสิตได้ฝึกทักษะด้านการบริหารจัดการ การสื่อสาร
                                และความคิดสร้างสรรค์ในสถานการณ์จริง อีกทั้งยังเป็นพื้นที่ในการสร้างประสบการณ์ใหม่ๆ
                                และความทรงจำที่ดีร่วมกันภายในคณะ
                                งานสถาปนาครบรอบ 50 ปีในครั้งนี้จึงถือเป็นทั้งการเฉลิมฉลองและการเรียนรู้นอกห้องเรียน
                                ที่ช่วยหล่อหลอมให้นิสิตเติบโตอย่างรอบด้าน ภายใต้บรรยากาศที่เต็มไปด้วยความอบอุ่น สนุกสนาน
                                และความร่วมมือจากทุกภาคส่วนของคณะมนุษยศาสตร์ มหาวิทยาลัยศรีนครินทรวิโรฒ
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาสาขาวิชาสารสนเทศศึกษาเป็นที่ปรึกษา ทางหลักสูตรฯ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- กล่องข้อความอ่านเพิ่มเติม 14 -->
        <div class="modal fade" id="modalCamp6" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" style="background-color: #198754;">
                        <h5 class="modal-title fw-bold fs-6">โครงการสืบสานธรรมะศึกษาและศิลปวัฒนธรรมอย่างยั่งยืน
                            กิจกรรมศึกษาดูงาน ณ มิวเซียมสยาม พิพิธภัณฑ์ การรเรียนรู้แห่งชาติ กรุงเทพมหานครฯ</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="./img/mss.jpg" class="img-fluid w-100" style="max-height: 400px; object-fit: cover;">
                        <div class="p-4">
                            <h6 class="fw-bold mb-3" style="color: #198754;">รายละเอียดกิจกรรม</h6>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                โครงการสืบสานธรรมะศึกษาและศิลปวัฒนธรรมอย่างยั่งยืน
                                เป็นกิจกรรมศึกษาดูงานที่จัดขึ้นเพื่อส่งเสริมให้นิสิตได้เรียนรู้และตระหนักถึงคุณค่าของศิลปวัฒนธรรมไทย
                                ควบคู่ไปกับการปลูกฝังแนวคิดด้านคุณธรรมและจริยธรรม
                                ผ่านกระบวนการเรียนรู้นอกห้องเรียนที่เน้นประสบการณ์จริง
                                กิจกรรมศึกษาดูงานในครั้งนี้จัดขึ้น ณ มิวเซียมสยาม พิพิธภัณฑ์การเรียนรู้แห่งชาติ
                                กรุงเทพมหานคร ในวันเสาร์ที่ 1 กุมภาพันธ์ 2568
                                โดยนิสิตได้เข้าชมแหล่งเรียนรู้ที่นำเสนอเรื่องราวความเป็นไทยในมิติที่หลากหลาย
                                ทั้งด้านประวัติศาสตร์ วิถีชีวิต และวัฒนธรรม ผ่านนิทรรศการที่ทันสมัยและมีความน่าสนใจ
                            </p>
                            <p class="indent text-muted"
                                style="text-align: justify; font-size: 14px; line-height: 1.7;">
                                ภายในกิจกรรม นิสิตได้มีโอกาสเรียนรู้ผ่านสื่อมัลติมีเดียและกิจกรรมเชิงโต้ตอบ
                                (Interactive)
                                ซึ่งช่วยกระตุ้นความคิดสร้างสรรค์และเปิดมุมมองใหม่ในการทำความเข้าใจรากเหง้าทางวัฒนธรรมของตนเอง
                                นอกจากนี้ ยังเป็นโอกาสให้ผู้เข้าร่วมได้แลกเปลี่ยนความคิดเห็น
                                และสะท้อนความคิดเกี่ยวกับการอนุรักษ์และสืบสานศิลปวัฒนธรรมไทยในบริบทของสังคมปัจจุบัน
                                โครงการนี้จึงเป็นอีกหนึ่งกิจกรรมสำคัญที่ช่วยเสริมสร้างทั้งความรู้ ทักษะ
                                และจิตสำนึกด้านคุณธรรมและวัฒนธรรมให้แก่นิสิต พร้อมทั้งส่งเสริมการเรียนรู้อย่างยั่งยืน
                                ภายใต้บรรยากาศที่สร้างแรงบันดาลใจและเอื้อต่อการพัฒนาตนเองในทุกมิติ
                            </p>
                            <p class="mb-0" style="font-size: 14px;"><strong>ผู้รับผิดชอบ:</strong>
                                อาจารย์ที่ปรึกษาสาขาวิชาสารสนเทศศึกษาเป็นที่ปรึกษา ทางหลักสูตรฯ</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary btn-sm px-4 fw-bold"
                            data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="pagination-dots">
            <span class="dot active"></span> <span class="dot"></span> <span class="dot"></span>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // ==========================================
    // 1. ประกาศตัวแปรทั้งหมด
    // ==========================================
    const filterBtns = document.querySelectorAll('.filter-btn-group .btn');
    const activityItems = document.querySelectorAll('.a-item');
    const gridContainer = document.getElementById('activity-grid');
    const btnPrev = document.getElementById('slidePrev');
    const btnNext = document.getElementById('slideNext');
    const dotsContainer = document.querySelector('.pagination-dots');

    function getVisibleCards() {
        return Array.from(activityItems).filter(item => item.style.display !== 'none');
    }

    // ==========================================
    // 2. Script สำหรับ Filter คัดกรองข่าว
    // ==========================================
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filterValue = btn.getAttribute('data-filter');

            activityItems.forEach(item => {
                item.style.display = (filterValue === 'all' || item.classList.contains(
                    filterValue)) ? 'block' : 'none';
            });

            // รอให้จัดหน้าเสร็จแล้วคำนวณจุดใหม่
            setTimeout(generateDots, 50);
        });
    });

    // ==========================================
    // 3. Script สำหรับปุ่มเลื่อนซ้าย-ขวา (แบบเสถียร)
    // ==========================================
    btnNext.addEventListener('click', () => {
        const visibleCards = getVisibleCards();
        if (visibleCards.length === 0) return;

        const scrollAmount = visibleCards[0].offsetWidth + 24;
        const maxScrollLeft = gridContainer.scrollWidth - gridContainer.clientWidth;

        // เช็กว่าเลื่อนมาจนสุดขอบขวาหรือยัง (เผื่อไว้ 10px กันเบราว์เซอร์ปัดเศษ)
        if (Math.ceil(gridContainer.scrollLeft) >= maxScrollLeft - 10) {
            // ถ้าสุดแล้ว ให้เลื่อนฟรื้ดดด กลับไปหน้าแรก
            gridContainer.scrollTo({
                left: 0,
                behavior: 'smooth'
            });
        } else {
            // ถ้ายังไม่สุด เลื่อนทีละการ์ด
            gridContainer.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
    });

    btnPrev.addEventListener('click', () => {
        const visibleCards = getVisibleCards();
        if (visibleCards.length === 0) return;

        const scrollAmount = visibleCards[0].offsetWidth + 24;
        const maxScrollLeft = gridContainer.scrollWidth - gridContainer.clientWidth;

        // เช็กว่าอยู่หน้าซ้ายสุดหรือยัง
        if (gridContainer.scrollLeft <= 10) {
            // ถ้าอยู่หน้าแรกแล้วกดถอยหลัง ให้เลื่อนไปหน้าสุดท้าย
            gridContainer.scrollTo({
                left: maxScrollLeft,
                behavior: 'smooth'
            });
        } else {
            // ถอยหลังทีละการ์ด
            gridContainer.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        }
    });

    // ==========================================
    // 4. Script สำหรับ Pagination Dots
    // ==========================================
    function generateDots() {
        if (!dotsContainer) return;

        dotsContainer.innerHTML = ''; // ล้างจุดเก่า

        const visibleCards = getVisibleCards();
        const maxScrollLeft = gridContainer.scrollWidth - gridContainer.clientWidth;

        if (visibleCards.length === 0 || maxScrollLeft <= 0) return;

        const scrollAmount = visibleCards[0].offsetWidth + 24;
        const numDots = Math.ceil(maxScrollLeft / scrollAmount) + 1;

        for (let i = 0; i < numDots; i++) {
            const dot = document.createElement('span');
            dot.classList.add('dot');

            // กลับมาใช้ฟังก์ชันคลิกที่จุดเพื่อเลื่อนได้ตามปกติ
            dot.addEventListener('click', () => {
                gridContainer.scrollTo({
                    left: scrollAmount * i,
                    behavior: 'smooth'
                });
            });

            dotsContainer.appendChild(dot);
        }

        // เลื่อนกลับจุดเริ่มต้น
        gridContainer.scrollTo({
            left: 0,
            behavior: 'smooth'
        });
        setTimeout(updatePagination, 50);
    }

    function updatePagination() {
        const currentDots = document.querySelectorAll('.pagination-dots .dot');
        if (currentDots.length === 0) return;

        const visibleCards = getVisibleCards();
        if (visibleCards.length === 0) return;

        const scrollAmount = visibleCards[0].offsetWidth + 24;
        const maxScrollLeft = gridContainer.scrollWidth - gridContainer.clientWidth;
        const currentScroll = gridContainer.scrollLeft;

        let currentIndex = 0;

        if (Math.ceil(currentScroll) >= maxScrollLeft - 10) {
            currentIndex = currentDots.length - 1;
        } else {
            currentIndex = Math.round(currentScroll / scrollAmount);
        }

        if (currentIndex >= currentDots.length) currentIndex = currentDots.length - 1;
        if (currentIndex < 0) currentIndex = 0;

        currentDots.forEach(dot => dot.classList.remove('active'));
        if (currentDots[currentIndex]) {
            currentDots[currentIndex].classList.add('active');
        }
    }

    gridContainer.addEventListener('scroll', () => {
        window.requestAnimationFrame(updatePagination);
    });

    window.addEventListener('resize', () => {
        generateDots();
    });

    // รันครั้งแรกตอนโหลดเว็บ
    generateDots();
    </script>
</body>

</html>