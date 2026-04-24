<?php include('includes/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แผนการศึกษา - IS SWU</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
    /* ================= แบนเนอร์ด้านบนสุด (ตามรูปเป๊ะ) ================= */
    .studyplan-hero {
        background: linear-gradient(135deg, rgba(196, 18, 45, 0.9), rgba(33, 37, 41, 0.9)), url('./img/berner.jpg') center/cover;
        padding: 80px 0 !important;
        /* <--- บังคับให้บน-ล่างกว้าง 80px เท่ากัน */
        color: white;
        text-align: center;
        margin-top: 0 !important;
        margin-bottom: 40px;
    }

    /* ================= ตกแต่งกระดาษและโครงสร้างเนื้อหา ================= */
    .studyplan-wrapper {
        padding-top: 60px;
        /* ลดระยะลงเพราะมี Hero Banner แล้ว */
        padding-bottom: 80px;
        background-color: #f7f8f9;
        min-height: 100vh;
    }

    .course-box {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        padding: 25px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .box-red {
        border-left: 5px solid #c4122d;
    }

    .box-dark {
        border-left: 5px solid #212529;
    }

    .box-gray {
        border-left: 5px solid #adb5bd;
    }

    .badge-credit-red {
        background-color: #fbe6e8;
        color: #c4122d;
        font-weight: bold;
        border-radius: 20px;
        padding: 6px 15px;
        font-size: 13px;
    }

    .badge-credit-gray {
        background-color: #f1f3f5;
        color: #495057;
        font-weight: bold;
        border-radius: 20px;
        padding: 6px 15px;
        font-size: 13px;
    }

    .list-indent {
        padding-left: 0;
        list-style: none;
        font-size: 13px;
        color: #555;
    }

    .list-indent li {
        margin-bottom: 3px;
        line-height: 1.6;
    }

    /* ================= ระบบปุ่มเลือกชั้นปี ================= */
    .custom-pills {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
        gap: 10px;
        flex-wrap: wrap;
    }

    .custom-btn {
        border: none;
        background: transparent;
        color: #333;
        font-weight: 700;
        border-radius: 30px;
        padding: 10px 25px;
        font-size: 15px;
        transition: 0.3s;
    }

    .custom-btn:hover {
        color: #c4122d;
        background-color: #fbe6e8;
    }

    .custom-btn.active {
        background-color: #c4122d;
        color: white;
        box-shadow: 0 4px 12px rgba(196, 18, 45, 0.4);
    }

    /* ================= การซ่อน/โชว์ ของเทอมต่างๆ ================= */
    .custom-tab-pane {
        display: none;
    }

    .custom-tab-pane.active {
        display: block;
        animation: fadeInTab 0.4s ease-in-out;
    }

    @keyframes fadeInTab {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ================= กล่องรายวิชา เทอม 1 และ เทอม 2 ================= */
    .term-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
        padding: 30px 40px;
        height: 100%;
    }

    .term-1 {
        border-top: 5px solid #212529;
    }

    .term-2 {
        border-top: 5px solid #c4122d;
    }

    .dotted-line {
        border-bottom: 2px dotted #e0e0e0;
        margin: 20px 0;
    }

    .subject-group {
        color: #c4122d;
        font-size: 14.5px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .subject-group-dark {
        color: #212529;
        font-size: 14.5px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .subject-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .subject-list li {
        color: #555;
        font-size: 13px;
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .subject-list li::before {
        content: "- ";
        color: #555;
    }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <!-- ================= แบนเนอร์สีแดงด้านบน ตามเรฟเฟอเรนซ์ ================= -->
    <div class="studyplan-hero pb-5">
        <div class="container py-4">
            <h1 class="fw-bold mb-3"><i class="fas fa-graduation-cap mb-2"></i><br>รายละเอียดของหลักสูตร</h1>
            <h5 class="fw-light mb-4">หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา</h5>
            <span class="badge bg-light text-danger fs-6 rounded-pill px-4 py-2 shadow-sm">หลักสูตรปรับปรุง พ.ศ.
                2565</span>
        </div>
    </div>

    <!-- ================= เนื้อหา ================= -->
    <div class="studyplan-wrapper">
        <div class="container" style="max-width: 1100px;">

            <div class="text-center mb-5">
                <h3 class="fw-bold" style="color: #212529;">โครงสร้างหลักสูตรและแผนการศึกษา</h3>
                <span class="badge bg-dark rounded-pill px-4 py-2 fs-6 mt-3 shadow-sm">
                    จำนวนหน่วยกิตรวมตลอดหลักสูตร ไม่น้อยกว่า 123 หน่วยกิต
                </span>
            </div>

            <!-- โครงสร้าง 3 กล่องด้านบน -->
            <div class="row g-4 mb-5 pb-5" style="border-bottom: 1px solid #e0e0e0;">
                <div class="col-md-4">
                    <div class="course-box box-red">
                        <h6 class="fw-bold mb-4"><i class="fas fa-book text-danger me-2"></i> 1. หมวดวิชาศึกษาทั่วไป
                        </h6>
                        <div class="mt-auto text-end"><span class="badge-credit-red">30 หน่วยกิต</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="course-box box-dark">
                        <h6 class="fw-bold mb-3"><i class="fas fa-sitemap text-dark me-2"></i> 2. หมวดวิชาเฉพาะ</h6>
                        <ul class="list-indent">
                            <li>- วิชาแกนคณะมนุษยศาสตร์ (9)</li>
                            <li>- วิชาบังคับ (52)</li>
                            <li>- วิชาเลือก (ไม่น้อยกว่า 6)</li>
                            <li>- วิชาเสริมสร้างประสบการณ์ (6)</li>
                        </ul>
                        <div class="mt-auto text-end"><span class="badge-credit-gray">ไม่น้อยกว่า 73 หน่วยกิต</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="course-box box-gray">
                        <h6 class="fw-bold mb-3"><i class="fas fa-th-large text-secondary me-2"></i> 3.
                            หมวดวิชาเลือกเสรี</h6>
                        <p style="font-size:13px; color:#555;">ลงทะเบียนเรียนวิชาใดๆ ที่เปิดสอนในมหาวิทยาลัย</p>
                        <div class="mt-auto text-end"><span class="badge-credit-gray">ไม่น้อยกว่า 20 หน่วยกิต</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mb-4 mt-2">
                <h3 class="fw-bold text-danger">แผนการศึกษา (Study Plan)</h3>
                <p class="text-muted small">คลิกเลือกชั้นปีเพื่อดูรายวิชาที่ต้องเรียนในแต่ละภาคการศึกษา</p>
            </div>

            <!-- ปุ่มแท็บเลือกชั้นปี -->
            <ul class="custom-pills">
                <li><button class="custom-btn active" onclick="switchTab('y1')">ชั้นปีที่ 1</button></li>
                <li><button class="custom-btn" onclick="switchTab('y2')">ชั้นปีที่ 2</button></li>
                <li><button class="custom-btn" onclick="switchTab('y3')">ชั้นปีที่ 3</button></li>
                <li><button class="custom-btn" onclick="switchTab('y4')">ชั้นปีที่ 4</button></li>
            </ul>

            <!-- ===================== เนื้อหา ชั้นปีที่ 1 ===================== -->
            <div class="custom-tab-pane active" id="y1">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="term-card term-1">
                            <h5 class="fw-bold text-center mb-4 text-dark">ภาคการศึกษาที่ 1</h5>
                            <div class="subject-group">ชุดวิชาการเรียนรู้และการสื่อสารในศตวรรษที่ 21 (6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>SWU191 การเรียนรู้โลกในศตวรรษที่ 21</li>
                                <li>SWU192 การใช้ภาษาไทยเพื่อการสื่อสาร</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group">ชุดวิชาพื้นฐานวิชาชีพสารสนเทศ (12 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>IS101 การพัฒนาทรัพยากรสารสนเทศ</li>
                                <li>IS111 การรู้สารสนเทศและรู้เท่าทันสื่อ</li>
                                <li>IS112 การจัดการบริการสารสนเทศ</li>
                                <li>IS121 การพัฒนาโปรแกรมคอมพิวเตอร์</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="term-card term-2">
                            <h5 class="fw-bold text-center mb-4 text-danger">ภาคการศึกษาที่ 2</h5>
                            <div class="subject-group">ชุดวิชาศิลปะการใช้ภาษาอังกฤษ... (6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>SWU193 การฟังและพูดภาษาอังกฤษเพื่อการสื่อสารอย่างมีประสิทธิภาพ</li>
                                <li>SWU194 การอ่านและเขียนภาษาอังกฤษเพื่อการสื่อสารอย่างมีประสิทธิภาพ</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group">ชุดวิชา มศว เพื่อสังคม (6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>SWU195 พลเมืองสร้างสรรค์สังคม</li>
                                <li>SWU196 ศาสตร์และศิลป์แห่งการพัฒนาสังคมอย่างยั่งยืน</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group">ชุดวิชาการบริการสารสนเทศ (6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>IS113 บริการสารสนเทศเฉพาะกลุ่ม</li>
                                <li>IS114 จิตวิทยาการบริการสารสนเทศ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== เนื้อหา ชั้นปีที่ 2 ===================== -->
            <div class="custom-tab-pane" id="y2">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="term-card term-1">
                            <h5 class="fw-bold text-center mb-4 text-dark">ภาคการศึกษาที่ 1</h5>
                            <div class="subject-group">ชุดวิชาวิถีชีวิตที่ชาญฉลาด (6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>SWU291 วิถีชีวิตเพื่อสุขภาพ</li>
                                <li>SWU292 วิทยาศาสตร์ กุญแจสู่การอยู่ร่วมกับสิ่งแวดล้อมอย่างสมดุล</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group">ชุดวิชาการจัดระบบสารสนเทศ (6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>IS201 การทำรายการและการจัดหมวดหมู่</li>
                                <li>IS202 การทำรายการและการจัดหมวดหมู่ขั้นสูง</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group-dark">ชุดวิชาเลือกเสรี (6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>ลงทะเบียนวิชาเลือกเสรีที่จัดโดยคณะอื่น</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="term-card term-2">
                            <h5 class="fw-bold text-center mb-4 text-danger">ภาคการศึกษาที่ 2</h5>
                            <div class="subject-group">ชุดวิชาการพัฒนาทักษะการทำงานและการเป็นผู้ประกอบการ (6 หน่วยกิต)
                            </div>
                            <ul class="subject-list">
                                <li>SWU197 การพูดและการนำเสนองานเพื่ออาชีพ</li>
                                <li>SWU198 การเตรียมพร้อมสู่การทำงานและการเป็นผู้ประกอบการ</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group">ชุดวิชาการพัฒนาโปรแกรม (9 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>IS222 ระบบจัดการฐานข้อมูล</li>
                                <li>IS223 การพัฒนาและบริหารเว็บไซต์</li>
                                <li>IS224 การพัฒนาแพลตฟอร์มดิจิทัล</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group-dark">ชุดวิชาเลือกเสรี (4 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>ลงทะเบียนวิชาเลือกเสรีที่จัดโดยคณะอื่น</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== เนื้อหา ชั้นปีที่ 3 ===================== -->
            <div class="custom-tab-pane" id="y3">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="term-card term-1">
                            <h5 class="fw-bold text-center mb-4 text-dark">ภาคการศึกษาที่ 1</h5>
                            <div class="subject-group">ชุดวิชาภาษาอังกฤษและการใช้เทคโนโลยีสารสนเทศในโลกสมัยใหม่ (4
                                หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>EIT211 ภาษาอังกฤษเพื่อการศึกษาเฉพาะศาสตร์</li>
                                <li>EIT212 ภาษาอังกฤษเพื่อเทคโนโลยีสารสนเทศ</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group">ชุดวิชาการวิเคราะห์ข้อมูล (9 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>IS321 การจัดเก็บและค้นคืนสารสนเทศ</li>
                                <li>IS322 การวิเคราะห์ข้อมูลและการเล่าเรื่องข้อมูล</li>
                                <li>IS323 การขับเคลื่อนองค์กรสารสนเทศด้วยข้อมูล</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group-dark">ชุดวิชาเลือกเสรี (6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>ลงทะเบียนวิชาเลือกเสรีที่จัดโดยคณะอื่น</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="term-card term-2">
                            <h5 class="fw-bold text-center mb-4 text-danger">ภาคการศึกษาที่ 2</h5>
                            <div class="subject-group">ชุดวิชามนุษยศาสตร์กับการสื่อสาร (5 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>HUC321 ภาษาอังกฤษเพื่อการเตรียมพร้อมด้านอาชีพ</li>
                                <li>HUC322 ศิลปะของการสื่อสารอย่างมีเหตุผลและมีประสิทธิภาพ</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group">ชุดวิชาการพัฒนานวัตกรรมสารสนเทศ (6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>IS311 ระบบห้องสมุดดิจิทัล</li>
                                <li>IS312 การพัฒนานวัตกรรมทางวิชาชีพสารสนเทศ</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group-dark">ชุดวิชาเลือกเสรี (4 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>ลงทะเบียนวิชาเลือกเสรีที่จัดโดยคณะอื่น</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================== เนื้อหา ชั้นปีที่ 4 ===================== -->
            <div class="custom-tab-pane" id="y4">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="term-card term-1">
                            <h5 class="fw-bold text-center mb-4 text-dark">ภาคการศึกษาที่ 1</h5>
                            <div class="subject-group">ชุดวิชาวิจัยทางวิชาชีพสารสนเทศ (4 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>IS431 การวิจัยพื้นฐานสำหรับวิชาชีพสารสนเทศ</li>
                                <li>IS432 สัมมนาสารสนเทศศึกษา</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group">ชุดวิชาเสริมสร้างประสบการณ์<br>(สำหรับนิสิตที่เลือกเรียน รายวิชา
                                IS444 ในภาคเรียนที่ 2)</div>
                            <ul class="subject-list">
                                <li>IS443 เตรียมความพร้อมสหกิจศึกษา</li>
                            </ul>
                            <div class="dotted-line"></div>
                            <div class="subject-group">ชุดวิชาเอกเลือก (6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>เลือก 1 ชุดวิชา</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="term-card term-2">
                            <h5 class="fw-bold text-center mb-4 text-danger">ภาคการศึกษาที่ 2</h5>
                            <div class="subject-group">วิชาเสริมสร้างประสบการณ์ (เลือก 6 หน่วยกิต)</div>
                            <ul class="subject-list">
                                <li>IS441 การฝึกประสบการณ์วิชาชีพสารสนเทศ</li>
                                <li>IS442 โครงงานอาชีพ</li>
                                <li>IS444 สหกิจศึกษา (บังคับเรียน สศ443 ก่อน)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ดึง Footer -->
    <?php include 'footer.php'; ?>

    <!-- สคริปต์สลับหน้าจอ (ทำงานไวทันตาเห็น) -->
    <script>
    function switchTab(tabId) {
        let tabs = document.querySelectorAll('.custom-tab-pane');
        let btns = document.querySelectorAll('.custom-btn');

        tabs.forEach(tab => tab.classList.remove('active'));
        btns.forEach(btn => btn.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        event.currentTarget.classList.add('active');
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>