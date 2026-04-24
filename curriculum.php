<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>เกี่ยวกับหลักสูตร | IS SWU</title>
  <?php include __DIR__ . '/includes/public_head.php'; ?>
  <style>
    .page-hero {
      background: linear-gradient(135deg, rgba(196,18,45,.95), rgba(33,37,41,.9));
      color: #fff; padding: 80px 16px; text-align: center;
    }
    .page-hero h1 { font-weight: 800; font-size: 36px; margin: 12px 0 8px; }
    .page-hero p { opacity: .9; font-size: 16px; margin: 0; }
    .page-hero .pill {
      display: inline-block; background: #fff; color: #c4122d; font-weight: 700;
      border-radius: 999px; padding: 6px 18px; font-size: 14px; margin-top: 10px;
    }
    .info-card {
      background: #fff; border-radius: 14px; padding: 28px 30px;
      box-shadow: 0 4px 14px rgba(0,0,0,.06); margin-bottom: 24px;
    }
    .sec-title {
      font-weight: 700; color: #c4122d; font-size: 20px;
      border-left: 5px solid #c4122d; padding-left: 14px; margin-bottom: 20px;
    }
    .info-card i.li { color: #c4122d; width: 26px; }
    .career-box {
      background: linear-gradient(135deg, #fff5f5, #ffe6ea);
      border-left: 5px solid #c4122d; border-radius: 10px;
      padding: 22px 24px; margin-top: 16px;
    }
    .philosophy-box {
      background: #212529; color: #fff; padding: 24px;
      border-radius: 12px; text-align: center; margin-bottom: 20px;
    }
    .check-list { list-style: none; padding: 0; }
    .check-list li { padding-left: 30px; position: relative; margin-bottom: 10px; line-height: 1.7; }
    .check-list li::before {
      content: "\f058"; font-family: "Font Awesome 5 Free"; font-weight: 900;
      position: absolute; left: 0; top: 2px; color: #198754; font-size: 16px;
    }
  </style>
</head>
<body class="bg-light">
<?php include __DIR__ . '/includes/public_nav.php'; ?>

<div class="page-hero">
  <i class="fas fa-graduation-cap fa-2x"></i>
  <h1>รายละเอียดของหลักสูตร</h1>
  <p>หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา</p>
  <span class="pill">หลักสูตรปรับปรุง พ.ศ. 2565</span>
</div>

<div class="container py-5" style="max-width: 1000px;">

  <div class="info-card">
    <h3 class="sec-title">ข้อมูลทั่วไป</h3>
    <div class="row g-4">
      <div class="col-md-6 border-end">
        <div class="mb-3"><i class="fas fa-university li"></i><b>ชื่อสถาบัน:</b> มหาวิทยาลัยศรีนครินทรวิโรฒ</div>
        <div class="mb-3"><i class="fas fa-building li"></i><b>คณะ:</b> มนุษยศาสตร์</div>
        <div class="mb-3"><i class="fas fa-fingerprint li"></i><b>รหัสหลักสูตร:</b> 25520091104002</div>
        <div class="mb-3"><i class="fas fa-clock li"></i><b>รูปแบบ:</b> หลักสูตรระดับปริญญาตรี 4 ปี</div>
      </div>
      <div class="col-md-6">
        <p class="text-danger fw-bold mb-1"><i class="fas fa-bookmark me-2"></i>ชื่อหลักสูตร</p>
        <ul class="small text-muted mb-3" style="list-style-type: square;">
          <li><b>ภาษาไทย:</b> หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา</li>
          <li><b>ภาษาอังกฤษ:</b> Bachelor of Arts Program in Information Studies</li>
        </ul>
        <p class="text-danger fw-bold mb-1"><i class="fas fa-award me-2"></i>ชื่อปริญญา</p>
        <ul class="small text-muted mb-0" style="list-style-type: square;">
          <li><b>ภาษาไทย:</b> ศิลปศาสตรบัณฑิต (สารสนเทศศึกษา) — ศศ.บ. (สารสนเทศศึกษา)</li>
          <li><b>ภาษาอังกฤษ:</b> Bachelor of Arts (Information Studies) — B.A. (Information Studies)</li>
        </ul>
      </div>
    </div>

    <div class="career-box">
      <h5 class="fw-bold mb-2"><i class="fas fa-briefcase text-danger me-2"></i>อาชีพที่ประกอบได้หลังสำเร็จการศึกษา</h5>
      <p class="text-muted mb-2">
        หลักสูตรนี้พัฒนาบัณฑิตให้มีความรู้ ความสามารถ และทักษะในการปฏิบัติงานด้านสารสนเทศอย่างรอบด้าน สามารถนำองค์ความรู้ไปประยุกต์ใช้ร่วมกับเทคโนโลยีสารสนเทศและการสื่อสารได้อย่างมีประสิทธิภาพ ทั้งในหน่วยงานภาครัฐและภาคเอกชน
      </p>
      <p class="mb-0 fw-medium text-muted">
        สายงานที่เกี่ยวข้อง อาทิ <span class="text-danger fw-bold">อาจารย์ · บรรณารักษ์ · นักเอกสารสนเทศ · นักวิเคราะห์ระบบสารสนเทศ · นักออกแบบเว็บไซต์ · IT Support</span>
      </p>
    </div>
  </div>

  <div class="info-card">
    <h3 class="sec-title">ข้อมูลเฉพาะของหลักสูตร</h3>

    <div class="philosophy-box">
      <h5 class="fw-bold mb-2"><i class="fas fa-quote-left me-2"></i>ปรัชญาของหลักสูตร</h5>
      <p class="mb-0" style="font-size: 15px; line-height: 1.8;">
        มุ่งผลิตบัณฑิตที่มีความรู้ความสามารถด้านสารสนเทศ มีจริยธรรมวิชาชีพ
        และสามารถประยุกต์ใช้เทคโนโลยีสารสนเทศเพื่อการจัดการความรู้ในสังคมอย่างยั่งยืน
      </p>
    </div>

    <h5 class="fw-bold text-dark mb-3 mt-4">วัตถุประสงค์ของหลักสูตร</h5>
    <ul class="check-list">
      <li>เพื่อผลิตบัณฑิตที่มีความรู้ ทักษะ และความสามารถในงานด้านสารสนเทศอย่างรอบด้าน</li>
      <li>เพื่อพัฒนานิสิตให้มีทักษะด้านเทคโนโลยีสารสนเทศและการสื่อสารในยุคดิจิทัล</li>
      <li>เพื่อปลูกฝังจริยธรรม คุณธรรม และจิตสำนึกสาธารณะในวิชาชีพสารสนเทศ</li>
      <li>เพื่อพัฒนาศักยภาพในการทำงานร่วมกับผู้อื่น และการเรียนรู้ตลอดชีวิต</li>
    </ul>
  </div>

  <div class="info-card">
    <h3 class="sec-title">โครงสร้างหลักสูตร</h3>
    <div class="row g-3">
      <div class="col-md-4">
        <div class="p-3 border rounded-3 h-100 text-center">
          <i class="fas fa-book fa-2x text-danger mb-2"></i>
          <h6 class="fw-bold">หมวดวิชาศึกษาทั่วไป</h6>
          <p class="text-muted mb-0">30 หน่วยกิต</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-3 border rounded-3 h-100 text-center">
          <i class="fas fa-layer-group fa-2x text-danger mb-2"></i>
          <h6 class="fw-bold">หมวดวิชาเฉพาะ</h6>
          <p class="text-muted mb-0">96 หน่วยกิต</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-3 border rounded-3 h-100 text-center">
          <i class="fas fa-star fa-2x text-danger mb-2"></i>
          <h6 class="fw-bold">หมวดวิชาเลือกเสรี</h6>
          <p class="text-muted mb-0">6 หน่วยกิต</p>
        </div>
      </div>
    </div>
    <p class="text-center text-muted fw-bold mt-3 mb-0">รวมทั้งสิ้น 132 หน่วยกิต</p>
  </div>

</div>

<?php include __DIR__ . '/includes/public_footer.php'; ?>
</body>
</html>
