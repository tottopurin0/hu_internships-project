<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ผู้พัฒนาระบบ | IS SWU</title>
  <?php include __DIR__ . '/includes/public_head.php'; ?>
  <style>
    .page-hero {
      background: linear-gradient(135deg, rgba(196,18,45,.95), rgba(33,37,41,.9));
      color: #fff; padding: 80px 16px; text-align: center;
    }
    .page-hero h1 { font-weight: 800; font-size: 36px; margin: 12px 0 8px; }
    .page-hero p { opacity: .9; font-size: 16px; margin: 0; }
    .dev-card {
      background: #fff; border-radius: 14px; padding: 30px 22px; text-align: center;
      box-shadow: 0 4px 14px rgba(0,0,0,.06); height: 100%;
      transition: transform .25s, box-shadow .25s;
    }
    .dev-card:hover { transform: translateY(-6px); box-shadow: 0 14px 28px rgba(0,0,0,.12); }
    .dev-avatar {
      width: 100px; height: 100px; border-radius: 50%;
      background: linear-gradient(135deg, #c4122d, #9b111e);
      color:#fff; display:flex; align-items:center; justify-content:center;
      font-size: 40px; margin: 0 auto 14px;
      box-shadow: 0 6px 18px rgba(196,18,45,.3);
    }
    .dev-card h5 { font-weight: 700; color: #222; margin-bottom: 2px; }
    .dev-card .role { color: #c4122d; font-weight: 600; font-size: 14px; margin-bottom: 10px; }
    .dev-card p { color: #666; font-size: 13.5px; line-height: 1.6; margin-bottom: 12px; }
    .tech-pill {
      display: inline-block; background: #fff0f2; color: #c4122d;
      padding: 3px 10px; border-radius: 999px; font-size: 11px;
      font-weight: 600; margin: 2px;
    }
    .stack-card {
      background: #fff; border-radius: 14px; padding: 30px;
      box-shadow: 0 4px 14px rgba(0,0,0,.06); margin-top: 30px;
    }
    .stack-card h3 {
      font-weight: 700; color: #c4122d; border-left: 5px solid #c4122d;
      padding-left: 14px; margin-bottom: 20px;
    }
    .stack-item {
      display:flex; align-items:center; gap: 14px; padding: 10px 0;
      border-bottom: 1px solid #f0f0f0;
    }
    .stack-item:last-child { border: 0; }
    .stack-icon {
      width: 44px; height: 44px; border-radius: 10px;
      display:flex; align-items:center; justify-content:center;
      color:#fff; font-size: 20px; flex-shrink: 0;
    }
    .si-php { background: #777bb4; }
    .si-db { background: #00758f; }
    .si-html { background: #e34f26; }
    .si-css { background: #264de4; }
    .si-bs { background: #7952b3; }
    .si-fa { background: #339af0; }
  </style>
</head>
<body class="bg-light">
<?php include __DIR__ . '/includes/public_nav.php'; ?>

<div class="page-hero">
  <i class="fas fa-code fa-2x"></i>
  <h1>ผู้พัฒนาระบบ</h1>
  <p>ทีมพัฒนาระบบจัดการการฝึกงาน (HU Internship Management System)</p>
</div>

<div class="container py-5" style="max-width: 1100px;">

  <div class="row g-4">
    <div class="col-lg-4 col-md-6">
      <div class="dev-card">
        <div class="dev-avatar"><i class="fas fa-user-astronaut"></i></div>
        <h5>ทีมพัฒนา</h5>
        <div class="role">Full-Stack Developer</div>
        <p>ออกแบบและพัฒนาฟังก์ชันการใช้งานของระบบจัดการคำขอฝึกงานทุกส่วน ตั้งแต่ frontend จนถึง backend</p>
        <div>
          <span class="tech-pill">PHP</span>
          <span class="tech-pill">MySQL</span>
          <span class="tech-pill">Bootstrap</span>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="dev-card">
        <div class="dev-avatar"><i class="fas fa-paint-brush"></i></div>
        <h5>UX/UI Designer</h5>
        <div class="role">Designer</div>
        <p>ออกแบบประสบการณ์ผู้ใช้งาน และรูปแบบหน้าตาของระบบให้สอดคล้องกับอัตลักษณ์ SWU</p>
        <div>
          <span class="tech-pill">Figma</span>
          <span class="tech-pill">Design System</span>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="dev-card">
        <div class="dev-avatar"><i class="fas fa-database"></i></div>
        <h5>Database &amp; Analyst</h5>
        <div class="role">Data Architect</div>
        <p>ออกแบบและวางโครงสร้างฐานข้อมูล จัดทำรายงานและสถิติการใช้งานระบบ</p>
        <div>
          <span class="tech-pill">MySQL</span>
          <span class="tech-pill">ER Diagram</span>
        </div>
      </div>
    </div>
  </div>

  <div class="stack-card">
    <h3><i class="fas fa-layer-group me-2"></i>เทคโนโลยีที่ใช้ในการพัฒนา</h3>
    <div class="row g-2">
      <div class="col-md-6">
        <div class="stack-item">
          <div class="stack-icon si-php"><i class="fab fa-php"></i></div>
          <div><b>PHP 8.3</b><br><small class="text-muted">ภาษาโปรแกรมหลักฝั่งเซิร์ฟเวอร์</small></div>
        </div>
        <div class="stack-item">
          <div class="stack-icon si-db"><i class="fas fa-database"></i></div>
          <div><b>MySQL 8</b><br><small class="text-muted">ระบบจัดการฐานข้อมูล</small></div>
        </div>
        <div class="stack-item">
          <div class="stack-icon si-html"><i class="fab fa-html5"></i></div>
          <div><b>HTML5</b><br><small class="text-muted">โครงสร้างเอกสารเว็บ</small></div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="stack-item">
          <div class="stack-icon si-css"><i class="fab fa-css3-alt"></i></div>
          <div><b>CSS3</b><br><small class="text-muted">รูปแบบและ Animation</small></div>
        </div>
        <div class="stack-item">
          <div class="stack-icon si-bs"><i class="fab fa-bootstrap"></i></div>
          <div><b>Bootstrap 5.3</b><br><small class="text-muted">Framework สำหรับ Responsive UI</small></div>
        </div>
        <div class="stack-item">
          <div class="stack-icon si-fa"><i class="fas fa-icons"></i></div>
          <div><b>Font Awesome 6</b><br><small class="text-muted">ชุดไอคอนที่ใช้ทั่วระบบ</small></div>
        </div>
      </div>
    </div>
  </div>

</div>

<?php include __DIR__ . '/includes/public_footer.php'; ?>
</body>
</html>
