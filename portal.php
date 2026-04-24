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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= h($page_title) ?> | HU Internships</title>
  <?php include __DIR__ . '/includes/public_head.php'; ?>
  <style>
    .portal-wrapper { padding: 48px 16px 64px; background: linear-gradient(180deg, #fafafa 0%, #f3f3f3 100%); min-height: calc(100vh - 180px); }
    .portal-head { text-align: center; margin-bottom: 36px; }
    .portal-title {
      color: var(--swu-red);
      font-weight: 800;
      font-size: 40px;
      position: relative;
      display: inline-block;
      margin: 0 0 12px;
      font-family: 'Kanit', sans-serif;
    }
    .portal-title::after {
      content:''; position: absolute; width: 60%; height: 4px;
      background-color: var(--swu-red); bottom: -10px; left: 20%; border-radius: 2px;
    }
    .portal-subtitle { color:#666; font-size: 17px; margin-top: 18px; }

    .portal-container { max-width: 1100px; margin: 0 auto; }

    .reg-banner {
      background: #fff8e1;
      border-left: 6px solid #ffc107;
      border-radius: 14px;
      padding: 22px 26px;
      margin-bottom: 40px;
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 16px;
      box-shadow: 0 4px 14px rgba(0,0,0,.05);
      transition: all .25s ease;
    }
    .reg-banner:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(255,193,7,.25); }
    .reg-left { display:flex; align-items:center; gap: 18px; }
    .icon-yellow-circle {
      width: 60px; height: 60px; border-radius: 50%;
      background: #ffc107; color:#fff;
      display:flex; align-items:center; justify-content:center;
      font-size: 22px; box-shadow: 0 4px 10px rgba(255,193,7,.4);
      flex-shrink: 0;
    }
    .reg-text h5 { margin:0 0 4px; font-weight:700; color:#333; font-size: 17px; }
    .reg-text p  { margin:0; color:#777; font-size: 14.5px; }
    .btn-register {
      background:#222; color:#fff; border:none; border-radius: 999px;
      padding: 10px 24px; font-weight: 600; text-decoration:none;
      transition: all .2s ease; white-space: nowrap;
    }
    .btn-register:hover { background:#000; transform: translateY(-2px); box-shadow: 0 6px 14px rgba(0,0,0,.2); }

    .portal-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 22px;
    }
    @media (max-width: 992px) { .portal-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px) { .portal-grid { grid-template-columns: 1fr; } }

    .portal-card {
      position: relative;
      display: block;
      padding: 28px 22px 60px;
      border-radius: 16px;
      color: #fff;
      text-decoration: none;
      box-shadow: 0 6px 18px rgba(0,0,0,.08);
      transition: transform .25s ease, box-shadow .25s ease;
      min-height: 240px;
      overflow: hidden;
    }
    .portal-card:hover { transform: translateY(-6px); box-shadow: 0 14px 28px rgba(0,0,0,.18); color:#fff; }
    .portal-card .portal-icon {
      width: 56px; height: 56px; border-radius: 50%;
      background: rgba(255,255,255,.22);
      display:flex; align-items:center; justify-content:center;
      font-size: 24px; margin-bottom: 14px;
    }
    .portal-card h3 { font-size: 22px; font-weight: 700; margin: 0 0 2px; }
    .portal-card h4 { font-size: 13px; font-weight: 500; opacity: .85; margin: 0 0 12px; letter-spacing: .5px; }
    .portal-card p  { font-size: 14px; line-height: 1.5; opacity: .95; margin:0; }
    .portal-arrow {
      position: absolute; right: 18px; bottom: 18px;
      width: 36px; height: 36px; border-radius: 50%;
      background: rgba(255,255,255,.22);
      display:flex; align-items:center; justify-content:center;
      transition: transform .2s ease, background .2s ease;
    }
    .portal-card:hover .portal-arrow { background: rgba(255,255,255,.4); transform: translateX(4px); }

    .bg-p1 { background: linear-gradient(135deg, #c4122d 0%, #9b111e 100%); }
    .bg-p2 { background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%); }
    .bg-p3 { background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%); }
    .bg-p4 { background: linear-gradient(135deg, #ef6c00 0%, #e65100 100%); }
  </style>
</head>
<body>
<?php include __DIR__ . '/includes/public_nav.php'; ?>

<div class="portal-wrapper">
  <div class="portal-container">

    <div class="portal-head">
      <h1 class="portal-title">Internships System</h1>
      <p class="portal-subtitle">เลือกระบบการเข้าใช้งานให้ตรงกับบทบาทของคุณ</p>
    </div>

    <div class="reg-banner">
      <div class="reg-left">
        <div class="icon-yellow-circle"><i class="fas fa-user-plus"></i></div>
        <div class="reg-text">
          <h5>สำหรับนิสิตใหม่ (New Student)</h5>
          <p>ยังไม่มีบัญชีใช่หรือไม่? สร้างบัญชีผู้ใช้นิสิตใหม่เพื่อเข้าสู่ระบบยื่นคำร้องฯ</p>
        </div>
      </div>
      <a href="/register_student.php" class="btn-register">
        <i class="fas fa-user-plus me-1"></i> ลงทะเบียนนิสิตใหม่
      </a>
    </div>

    <div class="portal-grid">
      <a href="/login.php?role=student" class="portal-card bg-p1">
        <div class="portal-icon"><i class="fas fa-user-graduate"></i></div>
        <h3>นิสิต</h3>
        <h4>STUDENT LOGIN</h4>
        <p>เข้าสู่ระบบเพื่อยื่นคำร้อง<br>และติดตามสถานะ</p>
        <div class="portal-arrow"><i class="fas fa-arrow-right"></i></div>
      </a>

      <a href="/login.php?role=staff" class="portal-card bg-p2">
        <div class="portal-icon"><i class="fas fa-file-signature"></i></div>
        <h3>เจ้าหน้าที่คณะ</h3>
        <h4>STAFF PORTAL</h4>
        <p>ตรวจสอบและอัปเดต<br>สถานะใบส่งตัว</p>
        <div class="portal-arrow"><i class="fas fa-arrow-right"></i></div>
      </a>

      <a href="/login.php?role=teacher" class="portal-card bg-p3">
        <div class="portal-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <h3>อาจารย์</h3>
        <h4>TEACHER PORTAL</h4>
        <p>อนุมัติคำร้องขอฝึกงาน<br>และประเมินผล</p>
        <div class="portal-arrow"><i class="fas fa-arrow-right"></i></div>
      </a>

      <a href="/docs/flowchart.php" class="portal-card bg-p4">
        <div class="portal-icon"><i class="fas fa-book-open"></i></div>
        <h3>Manual</h3>
        <h4>คู่มือการใช้งาน</h4>
        <p>ขั้นตอนการดำเนินงาน<br>และระเบียบการ</p>
        <div class="portal-arrow"><i class="fas fa-arrow-right"></i></div>
      </a>
    </div>

  </div>
</div>

<?php include __DIR__ . '/includes/public_footer.php'; ?>
</body>
</html>
