<?php include('includes/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดหลักสูตร - IS SWU</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
    /* ================= ตกแต่งเฉพาะหน้าเกี่ยวกับหลักสูตร ================= */
    body {
        background-color: #f8f9fa;
    }

    .curriculum-hero {
        background: linear-gradient(135deg, rgba(196, 18, 45, 0.9), rgba(33, 37, 41, 0.9)), url('./img/berner.jpg') center/cover;
        padding: 80px 0 !important;
        /* <--- บังคับให้บน-ล่างกว้าง 80px เท่ากัน */
        color: white;
        text-align: center;
        margin-top: 0 !important;
        margin-bottom: 40px;
    }

    .section-title {
        color: #212529;
        font-weight: 800;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }

    .section-title::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 28px;
        background-color: #c4122d;
        margin-right: 12px;
        border-radius: 3px;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        padding: 35px;
        margin-bottom: 30px;
    }

    .list-icon {
        color: #c4122d;
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .text-justify {
        text-align: justify;
        line-height: 1.8;
    }

    /* กล่องไฮไลท์พิเศษ */
    .highlight-box {
        background-color: #fdf3f4;
        border-left: 4px solid #c4122d;
        padding: 20px;
        border-radius: 0 8px 8px 0;
        margin-top: 20px;
    }

    /* ตกแต่ง List ของ PLO */
    .plo-list {
        padding-left: 0;
        list-style: none;
    }

    .plo-list li {
        margin-bottom: 12px;
        background: #fff;
        padding: 12px 18px;
        border-radius: 8px;
        border: 1px solid #eaeaea;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.01);
        display: flex;
    }

    .plo-list li strong {
        color: #c4122d;
        margin-right: 10px;
        min-width: 50px;
    }

    .check-list {
        padding-left: 0;
        list-style: none;
    }

    .check-list li {
        margin-bottom: 10px;
        position: relative;
        padding-left: 30px;
        line-height: 1.6;
    }

    .check-list li::before {
        content: "\f058";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        color: #198754;
        font-size: 18px;
    }
    </style>
</head>

<body>

    <!-- ดึง Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- ================= 1. แบนเนอร์หัวเรื่อง ================= -->
    <div class="curriculum-hero pb-5">
        <div class="container py-4">
            <h1 class="fw-bold mb-3"><i class="fas fa-graduation-cap mb-2"></i><br>รายละเอียดของหลักสูตร</h1>
            <h5 class="fw-light mb-4">หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา</h5>
            <span class="badge bg-light text-danger fs-6 rounded-pill px-4 py-2 shadow-sm">หลักสูตรปรับปรุง พ.ศ.
                2565</span>
        </div>
    </div>

    <div class="container py-5" style="max-width: 1000px;">

        <!-- ================= 2. ข้อมูลทั่วไป ================= -->
        <div class="info-card" id="general-info">
            <h3 class="section-title">ข้อมูลทั่วไป</h3>

            <div class="row g-4 mb-4">
                <!-- ฝั่งซ้าย -->
                <div class="col-md-6 border-end-md">
                    <div class="mb-3"><i class="fas fa-university list-icon"></i> <b>ชื่อสถาบันอุดมศึกษา:</b>
                        มหาวิทยาลัยศรีนครินทรวิโรฒ</div>
                    <div class="mb-3"><i class="fas fa-building list-icon"></i> <b>คณะ:</b> มนุษยศาสตร์</div>
                    <div class="mb-3"><i class="fas fa-fingerprint list-icon"></i> <b>รหัสหลักสูตร:</b> 25520091104002
                    </div>
                    <div class="mb-3"><i class="fas fa-clock list-icon"></i> <b>รูปแบบของหลักสูตร:</b>
                        หลักสูตรระดับปริญญาตรี 4 ปี</div>
                </div>

                <!-- ฝั่งขวา -->
                <div class="col-md-6 ps-md-4">
                    <p class="mb-1 text-danger fw-bold"><i class="fas fa-bookmark me-2"></i>ชื่อหลักสูตร</p>
                    <ul class="text-muted small mb-3" style="list-style-type: square;">
                        <li><b>ภาษาไทย:</b> หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา</li>
                        <li><b>ภาษาอังกฤษ:</b> Bachelor of Arts Program in Information Studies</li>
                    </ul>

                    <p class="mb-1 text-danger fw-bold"><i class="fas fa-award me-2"></i>ชื่อปริญญาและสาขาวิชา</p>
                    <ul class="text-muted small mb-0" style="list-style-type: square;">
                        <li class="mb-1"><b>ภาษาไทย:</b><br>ชื่อเต็ม: ศิลปศาสตรบัณฑิต (สารสนเทศศึกษา)<br>ชื่อย่อ: ศศ.บ.
                            (สารสนเทศศึกษา)</li>
                        <li><b>ภาษาอังกฤษ:</b><br>ชื่อเต็ม: Bachelor of Arts (Information Studies)<br>ชื่อย่อ: B.A.
                            (Information Studies)</li>
                    </ul>
                </div>
            </div>

            <!-- อาชีพที่ประกอบได้ -->
            <div class="highlight-box">
                <h5 class="fw-bold text-dark"><i class="fas fa-briefcase text-danger me-2"></i>
                    อาชีพที่ประกอบได้หลังสำเร็จการศึกษา</h5>
                <p class="text-muted text-justify mt-3 mb-2">
                    หลักสูตรนี้ได้รับการออกแบบเพื่อพัฒนาบัณฑิตให้มีความรู้ ความสามารถ
                    และทักษะในการปฏิบัติงานด้านสารสนเทศอย่างรอบด้าน
                    สามารถนำองค์ความรู้ไปประยุกต์ใช้ร่วมกับเทคโนโลยีสารสนเทศและการสื่อสารได้อย่างมีประสิทธิภาพ
                    ทั้งในหน่วยงานภาครัฐและภาคเอกชน
                </p>
                <hr class="text-danger opacity-25">
                <p class="text-muted text-justify mb-0 fw-medium">
                    บัณฑิตที่สำเร็จการศึกษาสามารถประกอบอาชีพได้หลากหลาย อาทิ <span class="text-danger fw-bold">อาจารย์,
                        บรรณารักษ์, นักเอกสารสนเทศ, นักวิเคราะห์ระบบสารสนเทศ, นักออกแบบและพัฒนาเว็บไซต์,
                        ผู้สนับสนุนการใช้ระบบสารสนเทศ (IT Support)</span> รวมถึงสายงานอื่น ๆ
                    ที่เกี่ยวข้องกับการจัดการและการใช้ประโยชน์จากสารสนเทศในยุคดิจิทัล
                </p>
            </div>
        </div>

        <!-- ================= 3. ข้อมูลเฉพาะของหลักสูตร ================= -->
        <div class="info-card mt-4" id="specific-info">
            <h3 class="section-title">ข้อมูลเฉพาะของหลักสูตร</h3>

            <!-- ปรัชญา -->
            <div class="text-center p-4 bg-dark text-white rounded-3 shadow-sm mb-5 position-relative">
                <i class="fas fa-quote-left fs-1 text-white opacity-25 position-absolute"
                    style="top: 15px; left: 20px;"></i>
                <h6 class="text-danger fw-bold mb-2">ปรัชญา</h6>
                <h5 class="fw-light mb-0" style="line-height: 1.6;">
                    "สารสนเทศศึกษานำไปสู่การจัดการสารสนเทศอย่างสร้างสรรค์เพื่อสังคมในยุคดิจิทัล"</h5>
            </div>

            <!-- ความสำคัญ -->
            <div class="mb-5">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-star text-warning me-2"></i>
                    ความสำคัญ</h5>
                <p class="text-muted text-justify">
                    หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา (หลักสูตรปรับปรุง พ.ศ. 2560)
                    เป็นหลักสูตรระดับปริญญาตรีของคณะมนุษยศาสตร์ มหาวิทยาลัยศรีนครินทรวิโรฒ
                    ที่พัฒนามาจากสาขาบรรณารักษศาสตร์และสารสนเทศศาสตร์ โดยมีการจัดการเรียนการสอนอย่างต่อเนื่อง
                    และมีการปรับปรุงหลักสูตรให้ทันสมัย
                    สอดคล้องกับความต้องการของตลาดแรงงานและการเปลี่ยนแปลงของสังคมในยุคดิจิทัล
                </p>
                <p class="text-muted text-justify">
                    จากการเปลี่ยนแปลงของเทคโนโลยีอย่างรวดเร็วในยุค Disruptive Technology
                    ส่งผลให้สารสนเทศมีปริมาณเพิ่มขึ้นและมีความซับซ้อนมากยิ่งขึ้น
                    องค์กรทั้งภาครัฐและเอกชนจึงจำเป็นต้องนำเทคโนโลยีดิจิทัล เช่น ปัญญาประดิษฐ์ (AI) มาใช้ในการจัดการ
                    วิเคราะห์ และให้บริการข้อมูลอย่างมีประสิทธิภาพ
                    หลักสูตรจึงมุ่งเน้นการพัฒนาบัณฑิตให้มีความรู้ด้านการจัดการสารสนเทศ
                    ควบคู่กับทักษะการใช้เทคโนโลยีดิจิทัล สามารถบูรณาการองค์ความรู้ข้ามศาสตร์
                    และปรับตัวให้ทันต่อความเปลี่ยนแปลงของโลกการทำงาน
                    รวมถึงสอดคล้องกับนโยบายการพัฒนาประเทศและการศึกษาในศตวรรษที่ 21
                </p>
                <p class="text-muted text-justify mb-0">
                    นอกจากนี้ หลักสูตรยังออกแบบการเรียนการสอนในรูปแบบโมดูล (Module System)
                    เพื่อให้นิสิตได้พัฒนาทักษะเชิงปฏิบัติและมีโอกาสฝึกประสบการณ์ในสถานประกอบการจริง
                    ส่งเสริมให้บัณฑิตมีความพร้อมในการทำงาน
                    และสามารถนำความรู้ไปประยุกต์ใช้ได้อย่างมีประสิทธิภาพในวิชาชีพด้านสารสนเทศ
                </p>
            </div>

            <div class="row mt-4">
                <!-- วัตถุประสงค์ -->
                <div class="col-md-12 mb-5">
                    <h5 class="fw-bold text-dark mb-3"><i class="fas fa-bullseye text-primary me-2"></i>
                        วัตถุประสงค์ของหลักสูตร</h5>
                    <p class="mb-2 text-muted fw-medium">เพื่อผลิตบัณฑิตให้มีคุณลักษณะ ดังนี้:</p>
                    <ul class="check-list text-muted">
                        <li>มีคุณธรรมจริยธรรมทางวิชาชีพ และจิตสำนึกความรับผิดชอบต่อสังคม</li>
                        <li>มีทักษะการรู้สารสนเทศเพื่อพัฒนาตนเองและผู้อื่นให้สามารถเรียนรู้ได้ตลอดชีวิต</li>
                        <li>มีความรู้ความสามารถในการใช้เทคโนโลยีดิจิทัลได้อย่างมีประสิทธิภาพเพื่อช่วยในการจัดการองค์กรสารสนเทศ
                        </li>
                    </ul>
                </div>
            </div>

            <!-- ผลลัพธ์การเรียนรู้ PLO -->
            <div class="mb-5 p-4 rounded-3" style="background-color: #f8f9fa; border: 1px solid #dee2e6;">
                <h5 class="fw-bold text-dark mb-3"><i class="fas fa-chart-line text-danger me-2"></i>
                    ผลลัพธ์การเรียนรู้ที่คาดหวังของหลักสูตร (PLOs)</h5>
                <ul class="plo-list mb-0 text-muted">
                    <li><strong>PLO1:</strong>
                        <div>สามารถให้บริการสารสนเทศได้อย่างมีจิตสำนึกสาธารณะ</div>
                    </li>
                    <li><strong>PLO2:</strong>
                        <div>สามารถจัดระบบสารสนเทศได้อย่างถูกต้องและเหมาะสม</div>
                    </li>
                    <li><strong>PLO3:</strong>
                        <div>สามารถออกแบบและพัฒนาระบบงานสารสนเทศ</div>
                    </li>
                    <li><strong>PLO4:</strong>
                        <div>สามารถค้นคืน วิเคราะห์ แปลผลข้อมูล เพื่อนำเสนอและสื่อสารได้เหมาะสมกับทุกระดับผู้ใช้งาน
                        </div>
                    </li>
                    <li><strong>PLO5:</strong>
                        <div>สามารถบูรณาการความรู้เพื่อการทำวิจัยและทำผลงานนวัตกรรมสารสนเทศได้อย่างมีจริยธรรมในวิชาชีพ
                            มุ่งเน้นการรับใช้สังคม</div>
                    </li>
                </ul>
            </div>

            <!-- จุดเด่นของหลักสูตร -->
            <div>
                <h5 class="fw-bold text-dark mb-3"><i class="fas fa-medal text-warning me-2"></i> จุดเด่นของหลักสูตร
                </h5>
                <p class="mb-2 text-muted fw-medium">นิสิตหลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา
                    จะได้รับการส่งเสริมดังนี้:</p>
                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <div
                            class="card h-100 border-danger border-top border-3 border-0 border-bottom border-start border-end shadow-sm p-3 text-center">
                            <i class="fas fa-laptop-code fs-2 text-danger mb-3 mt-2"></i>
                            <p class="small text-muted mb-0">
                                เน้นการเรียนการสอนรายวิชาเกี่ยวกับเทคโนโลยีสารสนเทศทั้งวิชาเอกบังคับและวิชาเอกเลือก</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="card h-100 border-dark border-top border-3 border-0 border-bottom border-start border-end shadow-sm p-3 text-center">
                            <i class="fas fa-search fs-2 text-dark mb-3 mt-2"></i>
                            <p class="small text-muted mb-0">
                                จัดให้มีการเรียนการสอนรายวิชาการวิจัยพื้นฐานสำหรับวิชาชีพสารสนเทศ</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="card h-100 border-danger border-top border-3 border-0 border-bottom border-start border-end shadow-sm p-3 text-center">
                            <i class="fas fa-building fs-2 text-danger mb-3 mt-2"></i>
                            <p class="small text-muted mb-0">
                                นิสิตจะได้ฝึกประสบการณ์วิชาชีพสารสนเทศทั้งภายในและภายนอกมหาวิทยาลัย</p>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- End Info Card -->

    </div>

    <!-- ดึง Footer -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>