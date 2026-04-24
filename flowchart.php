<?php include('includes/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>ขั้นตอนการฝึกงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ขั้นตอนการดำเนินงาน Internships - IS SWU</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <!-- CSS เฉพาะสำหรับหน้า Flowchart -->
    <style>
    /* แบนเนอร์ด้านบน */
    /* แบนเนอร์ด้านบน */
    .flowchart-hero {
        background: linear-gradient(135deg, rgba(196, 18, 45, 0.9), rgba(33, 37, 41, 0.9)), url('./img/berner.jpg') center/cover;
        padding: 80px 0;
        /* <--- กลับมาใช้ 80px ธรรมดา */
        color: white;
        text-align: center;
        margin-top: 0 !important;
        margin-bottom: 40px;
    }

    /* ---------------- ไทม์ไลน์แนวตั้ง ---------------- */
    .timeline-section {
        position: relative;
        padding: 20px 0;
    }

    /* เส้นแกนกลาง */
    .timeline-section::before {
        content: '';
        position: absolute;
        width: 3px;
        background-color: #dee2e6;
        top: 40px;
        bottom: 40px;
        left: 24px;
    }

    .timeline-step {
        position: relative;
        padding-left: 70px;
        margin-bottom: 25px;
    }

    /* วงกลมตัวเลข */
    .timeline-circle {
        position: absolute;
        width: 50px;
        height: 50px;
        left: 0;
        top: 10px;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }

    /* กล่องข้อความ */
    .timeline-card {
        background: white;
        border-radius: 8px;
        border: 1px solid #eee;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        padding: 20px 25px;
        transition: 0.3s;
    }

    .timeline-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    .doer-badge {
        background-color: #6c757d;
        color: white;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 4px;
    }

    /* ป้ายสถานะสีสันต่างๆ */
    .status-label {
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: bold;
        color: white;
        display: inline-block;
        margin-right: 10px;
    }

    .bg-color-red {
        background-color: #dc3545;
    }

    .bg-color-yellow {
        background-color: #ffc107;
        color: #000;
    }

    .bg-color-blue {
        background-color: #0d6efd;
    }

    .bg-color-purple {
        background-color: #6f42c1;
    }

    .bg-color-green {
        background-color: #198754;
    }

    /* ---------------- กล่องแถบสถานะด้านขวา (Sticky) ---------------- */
    .status-box-header {
        background-color: #212529;
        color: white;
        padding: 15px;
        font-weight: bold;
        border-radius: 8px 8px 0 0;
        font-size: 14px;
    }

    .status-list li {
        border-bottom: 1px solid #eee;
        padding: 12px 15px;
        display: flex;
        align-items: center;
        font-size: 14px;
        font-weight: bold;
    }

    .status-list li:last-child {
        border-bottom: none;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 15px;
    }

    .btn-red-login {
        background-color: #c4122d;
        color: white;
        font-weight: bold;
    }

    .btn-red-login:hover {
        background-color: #a00b22;
        color: white;
    }
    </style>
</head>

<body class="bg-light">

    <!-- ดึง Navbar แบบ PHP -->
    <?php include 'navbar.php'; ?>

    <!-- แบนเนอร์หัวเรื่อง (Header) -->
    <div class="flowchart-hero pb-5">
        <div class="container py-4">
            <h1 class="fw-bold mb-3"><i class="fas fa-project-diagram mb-2"></i><br>ขั้นตอนการดำเนินงาน Internship</h1>
            <p class="mb-0 fs-6 fw-light">กระบวนการขอฝึกงานและสหกิจศึกษา หลักสูตรสารสนเทศศึกษา มศว</p>
        </div>
    </div>

    <!-- เนื้อหาหลัก -->
    <div class="container py-5" style="min-height: 80vh;">
        <div class="row g-5">

            <!-- ฝั่งซ้าย: ไทม์ไลน์ขั้นตอน -->
            <div class="col-lg-8">
                <div class="timeline-section">

                    <!-- ขั้นตอนที่ 1 -->
                    <div class="timeline-step">
                        <div class="timeline-circle bg-color-red">1</div>
                        <div class="timeline-card border-start border-danger border-4">
                            <h5 class="fw-bold text-danger"><i class="fas fa-edit"></i> นิสิตยื่นแบบฟอร์มขอฝึกงาน</h5>
                            <p class="text-muted small mb-3">นิสิตเข้าสู่ระบบและคีย์ข้อมูลสถานประกอบการ,
                                วันที่เริ่มต้น-สิ้นสุด ผ่านระบบ Web Form เพื่อให้ข้อมูลเข้าสู่ฐานข้อมูล</p>
                            <span class="doer-badge"><i class="fas fa-user-graduate"></i> ผู้ดำเนินการ: นิสิต</span>
                        </div>
                    </div>

                    <!-- ขั้นตอนที่ 2 -->
                    <div class="timeline-step">
                        <div class="timeline-circle bg-color-yellow">2</div>
                        <div class="timeline-card border-start border-warning border-4">
                            <h5 class="fw-bold text-warning" style="text-shadow: 1px 1px 1px rgba(0,0,0,0.1);"><i
                                    class="fas fa-inbox"></i> รับเรื่องเข้าระบบ</h5>
                            <p class="text-muted small mb-3">เจ้าหน้าที่คณะตรวจสอบความถูกต้องของข้อมูลเบื้องต้น
                                และอัปเดตสถานะการรับเรื่อง</p>
                            <div>
                                <span class="status-label bg-color-yellow">สถานะ 1: รับเรื่องเข้าระบบ</span>
                                <span class="doer-badge"><i class="fas fa-file-signature"></i> ผู้ดำเนินการ:
                                    เจ้าหน้าที่</span>
                            </div>
                        </div>
                    </div>

                    <!-- ขั้นตอนที่ 3 -->
                    <div class="timeline-step">
                        <div class="timeline-circle bg-color-blue">3</div>
                        <div class="timeline-card border-start border-primary border-4">
                            <h5 class="fw-bold text-primary"><i class="fas fa-user-check"></i> อาจารย์ที่ปรึกษาพิจารณา
                            </h5>
                            <p class="text-muted small mb-3">อาจารย์ประจำหลักสูตร Login
                                เข้าสู่ระบบเพื่อตรวจสอบรายละเอียดคำขอฝึกงาน หากเหมาะสมจะทำการกดอนุมัติ</p>
                            <div>
                                <span class="status-label bg-color-blue">สถานะ 2: อาจารย์ที่ปรึกษาอนุมัติ</span>
                                <span class="doer-badge"><i class="fas fa-chalkboard-teacher"></i> ผู้ดำเนินการ:
                                    อาจารย์</span>
                            </div>
                        </div>
                    </div>

                    <!-- ขั้นตอนที่ 4 -->
                    <div class="timeline-step">
                        <div class="timeline-circle bg-color-purple">4</div>
                        <div class="timeline-card border-start border-4" style="border-color: #6f42c1 !important;">
                            <h5 class="fw-bold" style="color: #6f42c1;"><i class="fas fa-file-export"></i> ออกใบส่งตัว
                            </h5>
                            <p class="text-muted small mb-3">เจ้าหน้าที่คณะจัดพิมพ์เอกสารหนังสือส่งตัวแบบเป็นทางการ
                                เพื่อให้นิสิตนำไปยื่นให้กับสถานประกอบการ</p>
                            <div>
                                <span class="status-label bg-color-purple">สถานะ 3: ออกใบส่งตัวแล้ว</span>
                                <span class="doer-badge"><i class="fas fa-file-signature"></i> ผู้ดำเนินการ:
                                    เจ้าหน้าที่</span>
                            </div>
                        </div>
                    </div>

                    <!-- ขั้นตอนที่ 5 -->
                    <div class="timeline-step">
                        <div class="timeline-circle bg-color-green">5</div>
                        <div class="timeline-card border-start border-success border-4">
                            <h5 class="fw-bold text-success"><i class="fas fa-check-circle"></i> เสร็จสิ้นการฝึกงาน</h5>
                            <p class="text-muted small mb-3">นิสิตปฏิบัติงานเสร็จสิ้น
                                อาจารย์ประเมินผลการนิเทศน์สหกิจศึกษาและบันทึกผลลงระบบ</p>
                            <div>
                                <span class="status-label bg-color-green">สถานะ 4: ฝึกงานเสร็จสิ้น</span>
                                <span class="doer-badge"><i class="fas fa-users"></i> ผู้ดำเนินการ: อาจารย์ /
                                    เจ้าหน้าที่</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ฝั่งขวา: กล่องความหมายสถานะ (Sticky Box) -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                    <div class="status-box-header">
                        <i class="fas fa-info-circle"></i> ความหมายของเลขสถานะ (Status)
                    </div>
                    <ul class="list-unstyled status-list bg-white m-0">
                        <li><span class="dot bg-color-yellow"></span> 1 : รับเรื่องเข้าระบบ</li>
                        <li><span class="dot bg-color-blue"></span> 2 : อาจารย์ที่ปรึกษาอนุมัติ</li>
                        <li><span class="dot bg-color-purple"></span> 3 : ออกใบส่งตัวแล้ว</li>
                        <li><span class="dot bg-color-green"></span> 4 : ฝึกงานเสร็จสิ้น</li>
                        <li class="text-danger"><span class="dot bg-color-red"></span> 9 : ยกเลิก / ข้อมูลผิดพลาด</li>
                    </ul>

                    <div class="card-body bg-light rounded-bottom text-center">
                        <p class="small text-muted mb-3 text-start">หากนิสิตพร้อมแล้ว
                            สามารถเข้าสู่ระบบเพื่อยื่นคำร้องขอฝึกงานได้ทันที</p>

                        <!-- ลิงก์ไปหน้า portal เลือกเข้าระบบ -->
                        <a href="portal.php" class="btn btn-red-login w-100 py-2 mb-2">
                            <i class="fas fa-sign-in-alt"></i> เข้าระบบยื่นคำร้องฝึกงาน
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ดึง Footer แบบ PHP -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>