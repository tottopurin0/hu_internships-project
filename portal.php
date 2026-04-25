<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/auth.php';
if (is_logged_in()) {
    $role = current_role();
    if ($role === 'student')      header('Location: /student/dashboard.php');
    elseif ($role === 'teacher' || $role === 'staff') header('Location: /staff/dashboard.php');
    else header('Location: /index.php');
    exit;
}
$page_title = 'Portal';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
    .portal-title {
        color: var(--swu-red);
        font-weight: 800;
        font-size: 36px;
        position: relative;
        display: inline-block;
        margin-bottom: 10px;
    }

    .portal-title::after {
        content: '';
        position: absolute;
        width: 60%;
        height: 4px;
        background-color: var(--swu-red);
        bottom: -8px;
        left: 20%;
    }

    .reg-banner {
        background-color: #fff8e1;
        /* พื้นหลังสีเหลืองอ่อน */
        border-left: 6px solid #ffc107 !important;
        /* ขีดซ้ายสีเหลืองทอง */
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .reg-banner:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(255, 193, 7, 0.2) !important;
    }

    .icon-yellow-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #ffc107;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 0 4px 10px rgba(255, 193, 7, 0.4);
    }
    </style>
</head>

<body><?php include 'navbar.php'; ?>
    <div class="portal-wrapper">
        <div class="container pb-5">
            <div class="text-center mb-5">
                <h1 class="portal-title">Internships System</h1>
                <p class="portal-subtitle">เลือกระบบการเข้าใช้งานให้ตรงกับบทบาทของคุณ</p>
            </div>

            <!-- ================= กล่องสำหรับลงทะเบียนนิสิตใหม่ (เพิ่มใหม่) ================= -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm reg-banner p-4">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-yellow-circle me-4">
                                    <i class="fas fa-user-plus text-dark"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">สำหรับนิสิตใหม่ (New Student)</h5>
                                    <p class="mb-0 text-muted" style="font-size: 14.5px;">ยังไม่มีบัญชีใช่หรือไม่? สร้างบัญชีผู้ใช้นิสิตใหม่เพื่อเข้าสู่ระบบยื่นคำร้องฯ</p>
                                </div>
                            </div>
                            <!-- กดปุ๊บ วิ่งไปหน้า register_student.php -->
                            <a href="register_student.php" class="btn btn-dark fw-bold rounded-pill px-4 py-2 shadow-sm">
                                ลงทะเบียนนิสิตใหม่
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-center mb-5">
                <div class="col-lg-3 col-md-6">
                    <a href="login_student.php" class="portal-card bg-p1">
                        <div class="portal-icon">
                            <i class="fas fa-user-graduate"> </i>
                        </div>
                        <h3>นิสิต</h3>
                        <h4>Student Login</h4>
                        <p>เข้าสู่ระบบเพื่อยื่นคำร้อง<br>และติดตามสถานะ</p>
                        <div class="portal-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="login_staff.php" class="portal-card bg-p2">
                        <div class="portal-icon">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <h3>เจ้าหน้าที่คณะ</h3>
                        <h4>Staff Portal</h4>
                        <p>ตรวจสอบและอัปเดต<br>สถานะใบส่งตัว</p>
                        <div class="portal-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="login_teacher.php" class="portal-card bg-p3">
                        <div class="portal-icon">
                            <i class="fas fa-chalkboard-teacher"> </i>
                        </div>
                        <h3>อาจารย์</h3>
                        <h4>Teacher Portal</h4>
                        <p>อนุมัติคำร้องขอฝึกงาน<br>และประเมินผล</p>
                        <div class="portal-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="flowchart.php" class="portal-card bg-p4">
                        <div class="portal-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3>Manual</h3>
                        <h4>คู่มือการใช้งาน</h4>
                        <p>ขั้นตอนการดําเนินงาน<br>และระเบียบการ</p>
                        <div class="portal-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
            
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
