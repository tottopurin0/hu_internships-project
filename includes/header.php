<?php
require_once __DIR__ . '/auth.php';
$user = current_user();
$role = current_role();
$display_name = $user['display_name'] ?? '';
$page_title = $page_title ?? 'Internship Management System';
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($page_title) ?> | HU Internships</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="top-red-bar"></div>
<!-- ส่วนโลโก้  -->
    <header class="custom-navbar">
        <a class="navbar-brand" href="/index.php">
            <img src="../img/swu_Logo.png" alt="SWU" class="brand-logo">
            <div class="brand-divider"></div>
            <!-- ส่วนชื่อมหาวิทยาลัย -->
            <div class="logo-text">
                <h1>มหาวิทยาลัยศรีนครินทรวิโรฒ</h1>
                <p>SRINAKHARINWIROT UNIVERSITY</p>
            </div>
        </a>
<!-- จบ ส่วนโลโก้  -->
        <!-- เริ่ม ส่วนรายการ -->
        <nav class="nav-main">
            <?php if ($role === 'student'): ?>
            <a href="dashboard.php" class="<?= $current==='dashboard.php'?'active':'' ?>">
              <i class="fas fa-home me-1"></i> หน้าหลัก
            </a>
            <a href="request_new.php" class="<?= $current==='request_new.php'?'active':'' ?>"> 
              <i class="fas fa-file-signature me-1"></i> ยื่นคำขอ
            </a>
            <a href="request_status.php" class="<?= $current==='request_status.php'?'active':'' ?>">
              <i class="fas fa-tasks me-1"></i> สถานะคำขอ
            </a>
            <?php elseif ($role === 'teacher'): ?>
            <a href="dashboard.php" class="<?= $current==='dashboard.php'?'active':'' ?>">
              <i class="fas fa-home me-1"></i> หน้าหลัก 
            </a>
            <a href="approve_requests.php" class="<?= $current==='approve_requests.php'?'active':'' ?>">
              <i class="fas fa-check-circle me-1"></i> อนุมัติคำขอ
            </a>
            <a href="supervision.php" class="<?= $current==='supervision.php'?'active':'' ?>">
              <i class="fas fa-clipboard-check me-1"></i> บันทึกนิเทศ
            </a>
            <a href="reports.php" class="<?= $current==='reports.php'?'active':'' ?>">
              <i class="fas fa-chart-bar me-1"></i> รายงาน
            </a>
            <?php elseif ($role === 'staff'): ?>
            <a href="dashboard.php" class="<?= $current==='dashboard.php'?'active':'' ?>">
              <i class="fas fa-home me-1"></i> หน้าหลัก
            </a>
            <a href="students.php" class="<?= $current==='students.php'?'active':'' ?>">
              <i class="fas fa-users me-1"></i> นิสิต 
            </a>
            <a href="teachers.php" class="<?= $current==='teachers.php'?'active':'' ?>">
              <i class="fas fa-chalkboard-user me-1"></i> อาจารย์
            </a>
            <a href="manage_staff.php" class="<?= $current==='manage_staff.php'?'active':'' ?>">
              <i class="fas fa-id-badge me-1"></i> เจ้าหน้าที่
            </a>
            <a href="companies.php" class="<?= $current==='companies.php'?'active':'' ?>">
              <i class="fas fa-building me-1"></i> บริษัท
            </a>
            <a href="issue_letter.php" class="<?= $current==='issue_letter.php'?'active':'' ?>">
              <i class="fas fa-envelope-open-text me-1"></i> ใบส่งตัว
            </a>
            <a href="supervision.php" class="<?= $current==='supervision.php'?'active':'' ?>">
              <i class="fas fa-clipboard-check me-1"></i> บันทึกนิเทศ
            </a>
            <a href="reports.php" class="<?= $current==='reports.php'?'active':'' ?>">
              <i class="fas fa-chart-bar me-1"></i> รายงาน
            </a>
            <?php endif; ?>
        </nav>
        <!-- จบ ส่วนรายการ -->

        <!-- ส่วนออกจากระบบ -->
        <?php if (is_logged_in()): ?>
        <div class="user-box">
            <span class="user-name">
              <i class="fas fa-user-circle me-1"></i> <?= h($display_name) ?>
            </span>
            <span class="role-chip role-<?= h($role) ?>"><?= h($role) ?></span>
            <a class="btn-logout" href="../logout.php">
                <i class="fas fa-sign-out-alt me-1"></i> ออกจากระบบ
            </a>
        </div>
        <!-- จบ -->
        <?php endif; ?>
    </header>

    <main class="container">