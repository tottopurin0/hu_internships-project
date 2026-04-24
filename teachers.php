<?php include('includes/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คณาจารย์ประจำหลักสูตร - IS SWU</title>
    <!-- ไฟล์ CSS Bootstrap และ FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
    .teacher-hero {
        background: linear-gradient(135deg, rgba(196, 18, 45, 0.9), rgba(33, 37, 41, 0.9)), url('./img/berner.jpg') center/cover;
        padding: 80px 0;
        color: white;
        text-align: center;
        margin-top: 0;
        /* <--- เปลี่ยนตรงนี้เป็น 0 (แบนเนอร์จะชิดขอบพอดี) */
        margin-bottom: 40px;
    }

    /* ตกแต่งการ์ดอาจารย์ ให้เมาส์เป็นรูปนิ้วมือเวลาชี้ */
    .teacher-card {
        background: white;
        border: 1px solid #eaeaea;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        padding: 80px 20px;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        cursor: pointer;
    }

    .teacher-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(196, 18, 45, 0.15);
        border-color: #c4122d;
    }

    .profile-img-wrapper {
        width: 180px;
        height: 180px;
        background-color: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
        overflow: hidden;
        border: 3px solid white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-img-wrapper img {
        width: 85%;
        height: 85%;
        object-fit: cover;
        border-radius: 50%;
    }

    .click-hint {
        font-size: 11px;
        color: #c4122d;
        margin-top: 15px;
        font-weight: bold;
    }

    /* ตกแต่งใน Modal (Popup) */
    .modal-profile-img {
        width: 100%;
        max-width: 200px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .info-list {
        list-style: none;
        padding-left: 0;
        font-size: 14px;
        line-height: 2;
        color: #444;
        text-align: left;
    }

    .info-list i {
        color: #c4122d;
        width: 25px;
        text-align: center;
    }
    </style>
</head>

<body class="bg-light">

    <?php include 'navbar.php'; ?>

    <div class="teacher-hero pb-5">
        <div class="container py-4">
            <h1 class="fw-bold mb-3">
                <i class="fas fa-chalkboard-teacher mb-2"></i>
                <br>คณาจารย์ประจำหลักสูตร
            </h1>
            <p class="fs-6 fw-light mb-0">คณะอาจารย์ ประจำหลักสูตร</p>
        </div>
    </div>
    <div class="container py-5 mt-4" id="showcase">

        <h3 class="fw-bold text-danger mb-4 border-start border-4 border-danger ps-3">
            <i class="fa-solid fa-user"></i> กรรมการสาขา
        </h3>
        <div class="container py-3 mb-2" style="max-width: 1100px;">
            <div class="row g-4 justify-content-center">

                <!-- ================ อาจารย์ dit ================ -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="teacher-card" data-bs-toggle="modal" data-bs-target="#modalTeacher1">
                        <div class="profile-img-wrapper">
                            <img src="./img/t_Dit.jpg">
                        </div>
                        <h6 class="fw-bold fs-6 text-dark mb-1">อาจารย์ ดร. ดิษฐ์ สุทธิวงศ์</h6>
                        <p class="text-danger fw-bold mb-2" style="font-size: 12px;">ประธานกรรมการบริหารหลักสูตร</p>
                        <p class="text-muted small" style="line-height: 1.5; height: 40px;">Lecturer Dit Suthiwong, Ph.D.</p>
                        <div class="click-hint">
                            <i class="fas fa-mouse-pointer"></i> คลิกดูข้อมูลติดต่อ
                        </div>
                    </div>
                </div>

                <!-- ================ อาจารย์ thiti================ -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="teacher-card" data-bs-toggle="modal" data-bs-target="#modalTeacher2">
                        <div class="profile-img-wrapper">
                            <img src="./img/t_thiti.jpg">
                        </div>
                        <h6 class="fw-bold fs-6 text-dark mb-1">อาจารย์ ดร. ฐิติ อติชาติชยากร</h6>
                        <p class="text-danger fw-bold mb-2" style="font-size: 12px;">เลขานุการหลักสูตร</p>
                        <p class="text-muted small" style="line-height: 1.5; height: 40px;">Lecturer Thiti Atichartchayakorn, Ph.D.</p>
                        <div class="click-hint">
                            <i class="fas fa-mouse-pointer"></i> คลิกดูข้อมูลเพิ่มเติม
                        </div>
                    </div>
                </div>

                <!-- ================ อาจารย์ vipakorn ================ -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="teacher-card" data-bs-toggle="modal" data-bs-target="#modalTeacher3">
                        <div class="profile-img-wrapper">
                            <img src="./img/t_Vipakorn.jpg">
                        </div>
                        <h6 class="fw-bold fs-6 text-dark mb-1">ผู้ช่วยศาสตราจารย์ ดร. วิภากร วัฒนสินธุ์</h6>
                        <p class="text-secondary fw-bold mb-2" style="font-size: 12px;">อาจารย์ประจำหลักสูตร</p>
                        <p class="text-muted small" style="line-height: 1.5; height: 40px;">Assistant Professor Vipakorn Vadhanasin, Ph.D., PMP, FHEA</p>
                        <div class="click-hint">
                            <i class="fas fa-mouse-pointer"></i> คลิกดูข้อมูลเพิ่มเติม
                        </div>
                    </div>
                </div>

                <!-- ================ อาจารย์ chok ================ -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="teacher-card" data-bs-toggle="modal" data-bs-target="#modalTeacher4">
                        <div class="profile-img-wrapper">
                            <img src="./img/t_Chokthamrong.jpg">
                        </div>
                        <h6 class="fw-bold fs-6 text-dark mb-1">อาจารย์ ดร. โชคธำรงค์ จงจอหอ</h6>
                        <p class="text-secondary fw-bold mb-2" style="font-size: 12px;">อาจารย์ประจำหลักสูตร</p>
                        <p class="text-muted small" style="line-height: 1.5; height: 40px;">Lecturer Chokthamrong Chongchorhor, Ph.D.</p>
                        <div class="click-hint">
                            <i class="fas fa-mouse-pointer"></i> คลิกดูข้อมูลเพิ่มเติม
                        </div>
                    </div>
                </div>

                <!-- ================ อาจารย์ chotima ================ -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="teacher-card" data-bs-toggle="modal" data-bs-target="#modalTeacher5">
                        <div class="profile-img-wrapper">
                            <img src="./img/t_Chotima.jpg">
                        </div>
                        <h6 class="fw-bold fs-6 text-dark mb-1">อาจารย์โชติมา วัฒนะ</h6>
                        <p class="text-secondary fw-bold mb-2" style="font-size: 12px;">อาจารย์ประจำหลักสูตร</p>
                        <p class="text-muted small" style="line-height: 1.5; height: 40px;">Lecturer Chotima Watana</p>
                        <div class="click-hint">
                            <i class="fas fa-mouse-pointer"></i> คลิกดูข้อมูลเพิ่มเติม
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container mt-0 pt-0 pb-5 " id="showcase">

        <h3 class="fw-bold text-danger mb-4 border-start border-4 border-danger ps-3">
            <i class="fa-solid fa-user"></i> อาจารย์ผู้สอน
        </h3>
        <div class=" container py-5 mb-5" style="max-width: 1100px; min-height: 50vh;">
            <div class="row g-4 justify-content-center">

                <!-- ================ อาจารย์ dussadee ================ -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="teacher-card" data-bs-toggle="modal" data-bs-target="#modalTeacher6">
                        <div class="profile-img-wrapper">
                            <img src="./img/t_Dussadee.jpg">
                        </div>
                        <h6 class="fw-bold fs-6 text-dark mb-1">ผู้ช่วยศาสตราจารย์ ดร. ดุษฎี สีวังคำ</h6>
                        <p class="text-secondary fw-bold mb-2" style="font-size: 12px;">อาจารย์ผู้สอน</p>
                        <p class="text-muted small" style="line-height: 1.5; height: 40px;">Assistant Professor Dussadee Seewungkum, Ph.D.</p>
                        <div class="click-hint">
                            <i class="fas fa-mouse-pointer"></i> คลิกดูข้อมูลเพิ่มเติม
                    </div>
                    </div>
                </div>

                <!-- ================ อาจารย์ sasipimol================ -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="teacher-card" data-bs-toggle="modal" data-bs-target="#modalTeacher7">
                        <div class="profile-img-wrapper">
                            <img src="./img/t_Sasipimol.jpg">
                        </div>
                        <h6 class="fw-bold fs-6 text-dark mb-1">ผู้ช่วยศาสตราจารย์ <br> ดร. ศศิพิมล ประพินพงศกร</h6>
                        <p class="text-secondary fw-bold mb-2" style="font-size: 12px;">อาจารย์ผู้สอน</p>
                        <p class="text-muted small" style="line-height: 1.5; height: 40px;">Assistant Professor Sasipimol Prapinpongsakorn, Ph.D., FHEA</p>
                        <div class="click-hint">
                            <i class="fas fa-mouse-pointer"></i> คลิกดูข้อมูลเพิ่มเติม
                        </div>
                    </div>
                </div>

                <!-- ================ อาจารย์ sumattra ================ -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="teacher-card" data-bs-toggle="modal" data-bs-target="#modalTeacher8">
                        <div class="profile-img-wrapper">
                            <img src="./img/t_Sumattra.jpg">
                        </div>
                        <h6 class="fw-bold fs-6 text-dark mb-1"> อาจารย์ ดร. ศุมรรษตรา แสนวา</h6>
                        <p class="text-secondary fw-bold mb-2" style="font-size: 12px;"> อาจารย์ผู้สอน</p>
                        <p class="text-muted small" style="line-height: 1.5; height: 40px;"> Lecturer Sumattra Saenwa, Ph.D., FHEA</p>
                        <div class="click-hint">
                            <i class="fas fa-mouse-pointer"></i> คลิกดูข้อมูลเพิ่มเติม
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- กล่อง MODAL POPUP ข้อมูลอาจารย์ (ซ่อนไว้) -->
    <!-- ============================================== -->

    <!-- Modal อาจารย์ dit -->
    <div class="modal fade" id="modalTeacher1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #c4122d;">
                    <h5 class="modal-title fw-bold fs-6">
                        <i class="fas fa-info-circle"></i> ข้อมูลคณาจารย์
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-4 mb-md-0">
                            <img src="./img/t_Dit.jpg" class="modal-profile-img bg-light p-3">
                            <h5 class="fw-bold mt-2 mb-0">
                                <a href="resume/dit.pdf" target="_blank" class="text-dark text-decoration-none">
                                    อาจารย์ ดร. ดิษฐ์ สุทธิวงค์ 
                                    <i class="fas fa-external-link-alt fa-xs text-secondary"></i>
                                </a>
                            </h5>
                            <p class="text-danger fw-bold small">ประธานกรรมการบริหารหลักสูตร</p>
                        </div>
                        <div class="col-md-7 border-start ps-md-4">
                            <ul class="info-list mb-0">
                                <li>
                                    <i class="fas fa-graduation-cap"></i> 
                                    <b>วุฒิการศึกษา:</b>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>วท.บ.ศาสตร์คอมพิวเตอร์</li>
                                        <li>วท.ม. การจัดการเทคโนโลยีสารสนเทศ</li>
                                        <li>Ph.D. Information Technology</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-brain"></i> 
                                    <b>ความเชี่ยวชาญ:</b>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>ประสบการณ์ด้าน Project Management Skill สิบปีในธุรกิจ Banking/Finance/Insurance</li>
                                        <li>บริหารจัดการเทคโนโลยีสารสนเทศธุรกิจ Media Broadcast การจัดการ digital media, mediaasset management, digital censorship system.</li>
                                        <li>บริหารจัดการ IT Infrastructure ด้วย ITIL Standard ให้กับอุตสาหกรรม และโรงงานผลิตอาหาร</li>
                                    </ul>
                                <li>
                                    <i class="fas fa-envelope"></i> 
                                    <b>อีเมล:</b> dit.suthi@gmail.com
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i> 
                                    <b>เบอร์ติดต่อ:</b> 081-5550581
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i> 
                                    <b>ที่ทำงาน:</b> คณะมนุษยศาสตร์ มศว ประสานมิตร
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal อาจารย์ Thiti -->
    <div class="modal fade" id="modalTeacher2" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #c4122d;">
                    <h5 class="modal-title fw-bold fs-6">
                        <i class="fas fa-info-circle"></i> ข้อมูลคณาจารย์
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-4 mb-md-0">
                            <img src="./img/t_thiti.jpg" class="modal-profile-img bg-light p-3">
                            <h5 class="fw-bold mt-2 mb-0">
                                <a href="resume/thiti.pdf" target="_blank" class="text-dark text-decoration-none">
                                    อาจารย์ ดร. ฐิติ อติชาติชยากร 
                                    <i class="fas fa-external-link-alt fa-xs text-secondary"></i>
                                </a>
                            </h5>
                            <p class="text-secondary fw-bold small">เลขานุการหลักสูตร</p>
                        </div>
                        <div class="col-md-7 border-start ps-md-4">
                            <ul class="info-list mb-0">
                                <li>
                                    <i class="fas fa-graduation-cap"></i> 
                                    <b>วุฒิการศึกษา:</b>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>ศศ.บ.บรรณารักษศาสตร์และสารสนเทศศาสตร์</li>
                                        <li>อ.ม. บรรณารักษศาสตร์และสารนิเทศศาสตร์</li>
                                        <li>ค.ด. เทคโนโลยีและสื่อสารการศึกษา</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-brain"></i> 
                                    <b>ความเชี่ยวชาญ:</b>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>การพัฒนาห้องสมุดดิจิทัล</li>
                                        <li>การรู้สารสนเทศ</li>
                                        <li>การคิดเชิงออกแบบ</li>
                                        <li>การสร้างผลงานนวัตกรรมการบริการในห้องสมุด</li>
                                        <li>เทคโนโลยีสารสนเทศ</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-envelope"></i> 
                                    <b>อีเมล:</b> thitik@g.swu.ac.th
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i> 
                                    <b>เบอร์ติดต่อ:</b> 02-649-5000 ต่อ 16087
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i> 
                                    <b>ที่ทำงาน:</b> คณะมนุษยศาสตร์ มศว ประสานมิตร
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Modal อาจารย์ Vipa -->
    <div class="modal fade" id="modalTeacher3" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #c4122d;">
                    <h5 class="modal-title fw-bold fs-6">
                        <i class="fas fa-info-circle"></i> ข้อมูลคณาจารย์
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-4 mb-md-0">
                            <img src="./img/t_Vipakorn.jpg" class="modal-profile-img bg-light p-3">
                            <h5 class="fw-bold mt-2 mb-0">
                                <a href="resume/vipakorn.pdf" target="_blank" class="text-dark text-decoration-none">
                                    ผู้ช่วยศาสตราจารย์ ดร. วิภากร วัฒนสินธุ์ 
                                    <i class="fas fa-external-link-alt fa-xs text-secondary"></i>
                                </a>
                            </h5>
                            <p class="text-secondary fw-bold small">อาจารย์ประจำหลักสูตร</p>
                        </div>
                        <div class="col-md-7 border-start ps-md-4">
                            <ul class="info-list mb-0">
                                <li>
                                    <i class="fas fa-graduation-cap"></i> 
                                    <b>วุฒิการศึกษา:</b>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>บธ.บ. การตลาด</li>
                                        <li>น.บ. นิติศาสตร</li>
                                        <li>MBA Finance</li>
                                        <li>MS Computer Information System</li>
                                        <li>วท.ด. ธุรกิจเทคโนโลยีและการจัดการนวัตกรรม</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-brain"></i> 
                                    <b>ความเชี่ยวชาญ:</b>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>การจัดการโครงการ</li>
                                        <li>การออกแบบระบบ</li>
                                        <li>ฐานข้อมูล</li>
                                        <li>การวิเคราะห์ข้อมูล</li>
                                        <li>เทคโนโลยีสารสนเทศ</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-envelope"></i> 
                                    <b>อีเมล:</b> vipakorn@g.swu.ac.th
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i> 
                                    <b>เบอร์ติดต่อ:</b> 02-649-5000 ต่อ 16508
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i> 
                                    <b>ที่ทำงาน:</b> คณะมนุษยศาสตร์ มศว ประสานมิตร
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal อาจารย์ Chok -->
    <div class="modal fade" id="modalTeacher4" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #c4122d;">
                    <h5 class="modal-title fw-bold fs-6">
                        <i class="fas fa-info-circle"></i> ข้อมูลคณาจารย์
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-4 mb-md-0">
                            <img src="./img/t_Chokthamrong.jpg" class="modal-profile-img bg-light p-3">
                            <h5 class="fw-bold mt-2 mb-0">
                                <a href="resume/chokthamrong.pdf" target="_blank" class="text-dark text-decoration-none">
                                    อาจารย์ ดร. โชคธำรงค์ จงจอหอ 
                                    <i class="fas fa-external-link-alt fa-xs text-secondary"></i>
                                </a>
                            </h5>
                            <p class="text-secondary fw-bold small">อาจารย์ประจำหลักสูตร</p>
                        </div>
                        <div class="col-md-7 border-start ps-md-4">
                            <ul class="info-list mb-0">
                                <li>
                                    <i class="fas fa-graduation-cap"></i> 
                                    <b>วุฒิการศึกษา:</b>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>ศศ.บ. สารสนเทศศาสตร์</li>
                                        <li>ศศ.ม. การจัดการทรัพยากรชีวภาพ</li>
                                        <li>วท.ม. เทคโนโลยีผู้ประกอบการและการจัดการนวัตกรรม</li>
                                        <li>ปร.ด. สารสนเทศศึกษา</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-brain"></i> 
                                    <b>ความเชี่ยวชาญ:</b>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>การจัดระบบความรู้</li>
                                        <li>การสอนสารสนเทศศึกษา</li>
                                        <li>ดรรชนีและสาระสังเขป</li>
                                        <li>พฤติกรรมสารสนเทศของมนุษย์</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-envelope"></i> 
                                    <b>อีเมล:</b> chokthamrong@g.swu.ac.th
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i> 
                                    <b>เบอร์ติดต่อ:</b> 0-2649-5000 ต่อ 16292
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i> 
                                    <b>ที่ทำงาน:</b> คณะมนุษยศาสตร์ มศว ประสานมิตร
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal อาจารย์ Chotimai -->
    <div class="modal fade" id="modalTeacher5" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #c4122d;">
                    <h5 class="modal-title fw-bold fs-6">
                        <i class="fas fa-info-circle"></i> ข้อมูลคณาจารย์
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-4 mb-md-0">
                            <img src="./img/t_Chotima.jpg" class="modal-profile-img bg-light p-3">
                            <h5 class="fw-bold mt-2 mb-0">
                                <a href="resume/chotima.pdf" target="_blank" class="text-dark text-decoration-none">
                                    อาจารย์โชติมา วัฒนะ
                                    <i class="fas fa-external-link-alt fa-xs text-secondary"></i>
                                </a>
                            </h5>
                            <p class="text-secondary fw-bold small">อาจารย์ประจำหลักสูตร</p>
                        </div>
                        <div class="col-md-7 border-start ps-md-4">
                            <ul class="info-list mb-0">
                                <li>
                                    <i class="fas fa-graduation-cap"></i> 
                                    <b>วุฒิการศึกษา:</b><br>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>B.A. Information Science</li>
                                        <li>M.A. Information Management</li>
                                        <li>Ph.D. Candidate, Doctor of Philosophy Information Science</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-brain"></i> 
                                    <b>ความเชี่ยวชาญ:</b>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>Library Management</li>
                                        <li>Library Service</li>
                                        <li>Information Behavior</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-envelope"></i> 
                                    <b>อีเมล:</b> chotimaw@g.swu.ac.th
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i> 
                                    <b>เบอร์ติดต่อ:</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i> 
                                    <b>ที่ทำงาน:</b> คณะมนุษยศาสตร์ มศว ประสานมิตร
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--  Modal อาจารย์ Dussadee -->
    <div class="modal fade" id="modalTeacher6" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #c4122d;">
                    <h5 class="modal-title fw-bold fs-6">
                        <i class="fas fa-info-circle"></i> ข้อมูลคณาจารย์
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-4 mb-md-0">
                            <img src="./img/t_Dussadee.jpg" class="modal-profile-img bg-light p-3">
                            <h5 class="fw-bold mt-2 mb-0">
                                <a href="resume/dussadee.pdf" target="_blank" class="text-dark text-decoration-none">
                                    ผู้ช่วยศาสตราจารย์ ดร.ดุษฎี สีวังคำ
                                    <i class="fas fa-external-link-alt fa-xs text-secondary"></i>
                                </a>
                            </h5>
                            <p class="text-secondary fw-bold small">อาจารย์ผู้สอน</p>
                        </div>
                        <div class="col-md-7 border-start ps-md-4">
                            <ul class="info-list mb-0">
                                <li>
                                    <i class="fas fa-graduation-cap"></i>
                                    <b>วุฒิการศึกษา:</b>
                                    <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>Ph.D., King Mongkut’s University of Technology North Bangkok, Bangkok
                                            Thailand
                                            (Technical Education Technology) Dissertation: Development of a Distance
                                            Instructional
                                            Model via the Internet for Private Universities in Thailand
                                        </li>
                                        <li>M.S., King Mongkut’s
                                            University of Technology North Bangkok, Bangkok Thailand
                                            (Information Technology) Project: Development of a crossword game on mobile
                                            phone
                                        </li>
                                        <li>B.S., Rajabhat Institute Phetchabun, Phetchabun Thailand (Computer Science)
                                            Project: Learning to use the Computer Assisted Instruction (CAI)
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-brain"></i>
                                    <b>ความเชี่ยวชาญ:</b>
                                    <ul class="mt-0 text-muted"
                                        style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>Information Technology</li>
                                        <li>Computer Technology</li>
                                        <li>Communication Technology</li>
                                        <li>Education Technology</li>
                                        <li>Computer Programming</li>
                                        <li>Multimedia Technology</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-envelope"></i> 
                                    <b>อีเมล:</b> dussadee@g.swu.ac.th
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i> 
                                    <b>เบอร์ติดต่อ:</b> 02 649-5000 ต่อ 16292
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i> 
                                    <b>ที่ทำงาน:</b> คณะมนุษยศาสตร์ มศว ประสานมิตร
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal อาจารย์ Sasipimon -->
    <div class="modal fade" id="modalTeacher7" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #c4122d;">
                    <h5 class="modal-title fw-bold fs-6">
                        <i class="fas fa-info-circle"></i> ข้อมูลคณาจารย์
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-4 mb-md-0">
                            <img src="./img/t_Sasipimol.jpg" class="modal-profile-img bg-light p-3">
                            <h5 class="fw-bold mt-2 mb-0">
                                <a href="resume/sasipimol.pdf" target="_blank" class="text-dark text-decoration-none">
                                    ผู้ช่วยศาสตราจารย์ <br> ดร. ศศิพิมล ประพินพงศกร 
                                    <i class="fas fa-external-link-alt fa-xs text-secondary"></i>
                                </a>
                            </h5>
                            <p class="text-secondary fw-bold small">อาจารย์ผู้สอน</p>
                        </div>
                        <div class="col-md-7 border-start ps-md-4">
                            <ul class="info-list mb-0">
                                <li>
                                    <i class="fas fa-graduation-cap"></i> 
                                    <b>วุฒิการศึกษา:</b><br>
                                    ค.ด. เทคโนโลยีและสื่อสารการศึกษา
                                </li>
                                <li>
                                    <i class="fas fa-brain"></i>
                                    <b>ความเชี่ยวชาญ:</b>
                                    <ul class="mt-0 text-muted"
                                        style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>การรู้สารสนเทศ, การรู้ดิจิทัล, พฤติกรรมสารสนเทศ, การออกแบบบริการ (service
                                            design) การศึกษาผู้ใช้, การจัดระบบทรัพยากรสารสนเทศอิเล็กทรอนิกส์/คลังสารสนเทศดิจิทัล, 
                                            การวิจัยทางด้านสารสนเทศศึกษา
                                        </li>
                                        <li>การแก้ปัญหาเชิงสร้างสรรค์, การคิดเชิงออกแบบ, การคิดเชิงนวัตกรรม</li>
                                        <li>การออกแบบกิจกรรมการเรียนรู้แบบเชิงรุกและด้านเทคโนโลยีและสื่อสารการศึกษา</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-envelope"></i> 
                                    <b>อีเมล:</b> sasipimol@g.swu.ac.th
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i> 
                                    <b>เบอร์ติดต่อ:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i> 
                                    <b>ที่ทำงาน:</b> คณะมนุษยศาสตร์ มศว ประสานมิตร
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal อาจารย์ Sumattra -->
    <div class="modal fade" id="modalTeacher8" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background-color: #c4122d;">
                    <h5 class="modal-title fw-bold fs-6">
                        <i class="fas fa-info-circle"></i> ข้อมูลคณาจารย์
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-4 mb-md-0">
                            <img src="./img/t_Sumattra.jpg" class="modal-profile-img bg-light p-3">
                            <h5 class="fw-bold mt-2 mb-0">
                                <a href="resume/sumattra.pdf" target="_blank" class="text-dark text-decoration-none">
                                    อาจารย์ ดร. ศุมรรษตรา แสนวา
                                    <i class="fas fa-external-link-alt fa-xs text-secondary"></i>
                                </a>
                            </h5>
                            <p class="text-secondary fw-bold small">อาจารย์ผู้สอน</p>
                        </div>
                        <div class="col-md-7 border-start ps-md-4">
                            <ul class="info-list mb-0">
                                <li>
                                    <i class="fas fa-graduation-cap"></i>
                                    <b>วุฒิการศึกษา:</b>
                                    <ul class="mb-0 text-muted"
                                        style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>ศศ.บ. ภาษาอังกฤษ (เกียรตินิยมอันดับ 2)</li>
                                        <li>ศศ.ม. บรรณารักษศาสตร์และสารสนเทศศาสตร์</li>
                                        <li>ปร.ด. สารสนเทศศึกษา</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-brain"></i>
                                    <b>ความเชี่ยวชาญ:</b>
                                    <ul class="mb-0 text-muted"
                                        style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                                        <li>การจัดการสารสนเทศ</li>
                                        <li>การบริหารและจัดการองค์กรสารสนเทศ</li>
                                        <li>การจัดการความรู้</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-envelope"></i>
                                    <b>อีเมล:</b> sumattra@g.swu.ac.th
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i>
                                    <b>เบอร์ติดต่อ:</b> (085) 617-9617
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <b>ที่ทำงาน:</b> คณะมนุษยศาสตร์ มศว ประสานมิตร
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>