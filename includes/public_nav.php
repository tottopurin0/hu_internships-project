<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$__cur = basename($_SERVER['PHP_SELF']);
$__is_logged_in = !empty($_SESSION['user']);
$__role = $_SESSION['role'] ?? null;
$__dash = '/portal.php';
if ($__role === 'student') $__dash = '/student/dashboard.php';
elseif ($__role === 'teacher' || $__role === 'staff') $__dash = '/staff/dashboard.php';
?>
<div class="public-top-bar"></div>
<nav class="navbar navbar-expand-xl public-navbar py-2">
  <div class="container-fluid px-lg-4">
    <a class="brand" href="/index.php">
      <img src="/assets/img/swu_Logo.png" alt="SWU" class="brand-logo">
      <div class="brand-divider"></div>
      <div class="brand-text">
        <h1>มหาวิทยาลัยศรีนครินทรวิโรฒ</h1>
        <p>SRINAKHARINWIROT UNIVERSITY</p>
      </div>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pubMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="pubMenu">
      <ul class="navbar-nav align-items-xl-center gap-1">
        <li class="nav-item"><a class="nav-link <?= $__cur==='index.php'?'active':'' ?>" href="/index.php"><i class="fas fa-home me-1"></i> หน้าแรก</a></li>
        <li class="nav-item"><a class="nav-link <?= $__cur==='activities.php'?'active':'' ?>" href="/activities.php"><i class="fas fa-bullhorn me-1"></i> ข่าวสารกิจกรรม</a></li>
        <li class="nav-item"><a class="nav-link <?= $__cur==='teachers.php'?'active':'' ?>" href="/teachers.php"><i class="fas fa-chalkboard-teacher me-1"></i> อาจารย์ผู้สอน</a></li>
        <li class="nav-item"><a class="nav-link <?= $__cur==='flowchart.php'?'active':'' ?>" href="/flowchart.php"><i class="fas fa-project-diagram me-1"></i> ขั้นตอนการฝึกงาน</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= in_array($__cur,['curriculum.php','studyplan.php'])?'active':'' ?>" href="#" data-bs-toggle="dropdown">
            <i class="fas fa-graduation-cap me-1"></i> หลักสูตร
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/curriculum.php"><i class="fas fa-book me-2 text-danger"></i>เกี่ยวกับหลักสูตร</a></li>
            <li><a class="dropdown-item" href="/studyplan.php"><i class="fas fa-calendar-alt me-2 text-danger"></i>แผนการศึกษา</a></li>
          </ul>
        </li>
        <?php if ($__is_logged_in): ?>
          <li class="nav-item ms-xl-3 mt-2 mt-xl-0">
            <a class="nav-link btn-login-red" href="<?= $__dash ?>"><i class="fas fa-user-circle me-1"></i> Dashboard</a>
          </li>
        <?php else: ?>
          <li class="nav-item ms-xl-3 mt-2 mt-xl-0">
            <a class="nav-link btn-login-red" href="/portal.php"><i class="fas fa-sign-in-alt me-1"></i> เข้าสู่ระบบ</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
