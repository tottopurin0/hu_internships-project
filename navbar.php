<!-- แถบสีแดงเล็กๆ ด้านบนสุด -->
<div class="top-red-bar d-none d-lg-block"></div>

<nav class="navbar navbar-expand-xl custom-navbar shadow-sm sticky-top" style="background-color: white;">
    <div class="container-fluid px-lg-5 py-2 py-lg-0">

        <!-- โลโก้ มศว (อัปเดตลิงก์รูปภาพใหม่ ไม่แตกแน่นอน) -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="./img/swu_Logo.png" alt="SWU Logo" height="50">
            <div class="logo-text ms-2">
                <h1 class="mb-0 text-dark fw-bold" style="font-size: 18px;">มหาวิทยาลัยศรีนครินทรวิโรฒ</h1>
                <p class="mb-0 text-muted" style="font-size: 11px; letter-spacing: 0.5px;">SRINAKHARINWIROT UNIVERSITY |
                    INFORMATION STUDIES</p>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navMenu">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
                <li class="nav-item"><a class="nav-link" href="activities.php">ข่าวสารกิจกรรม</a></li>
                <li class="nav-item"><a class="nav-link" href="teachers.php">อาจารย์ผู้สอน</a></li>
                <li class="nav-item"><a class="nav-link" href="flowchart.php">ขั้นตอนการฝึกงาน</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">หลักสูตร</a>
                    <ul class="dropdown-menu border-0 shadow-sm mt-2 rounded-3">
                        <li><a class="dropdown-item py-2 fw-medium" href="curriculum.php">เกี่ยวกับหลักสูตร</a></li>
                        <li><a class="dropdown-item py-2 fw-medium" href="studyplan.php">แผนการศึกษา</a></li>
                    </ul>
                </li>

                <!-- ระบบตรวจสอบ Login -->
                <?php if(isset($_SESSION['user_id'])): ?>
                <?php 
                        $d = "";
                        if($_SESSION['role'] == 'student') $d = "student_dashboard.php";
                        elseif($_SESSION['role'] == 'staff') $d = "staff_dashboard.php";
                        elseif($_SESSION['role'] == 'teacher') $d = "teacher_dashboard.php";
                    ?>
                <li class="nav-item ms-3 mt-3 mt-xl-0"><a class="btn btn-dark btn-sm rounded-pill px-4 py-2 fw-bold"
                        href="<?php echo $d; ?>"><i class="fas fa-user-circle"></i> ไปหน้า Dashboard</a></li>
                <?php else: ?>
                <li class="nav-item ms-3 mt-3 mt-xl-0">
                        <a class="btn text-white btn-sm rounded-pill px-4 py-2 fw-bold shadow-sm d-flex align-items-center" href="portal.php" style="background-color: #c4122d;">
                            <i class="fas fa-sign-in-alt fs-6 me-2"></i> เข้าสู่ระบบ
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>