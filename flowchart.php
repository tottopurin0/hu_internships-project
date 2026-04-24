<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ขั้นตอนการฝึกงาน | IS SWU</title>
  <?php include __DIR__ . '/includes/public_head.php'; ?>
  <style>
    .page-hero {
      background: linear-gradient(135deg, rgba(196,18,45,.95), rgba(33,37,41,.9));
      color: #fff !important; padding: 80px 16px; text-align: center;
    }
    .page-hero * { color: #fff !important; }
    .page-hero h1 { font-weight: 800; font-size: 36px; margin: 12px 0 8px; color: #fff !important; }
    .page-hero p { opacity: .95; font-size: 16px; margin: 0; color: #fff !important; }
    .page-hero i { color: #fff !important; }
    .flow { max-width: 900px; margin: 0 auto; position: relative; padding: 24px 0; }
    .flow::before {
      content: ''; position: absolute; left: 40px; top: 0; bottom: 0;
      width: 4px; background: linear-gradient(180deg, #c4122d, #9b111e);
      border-radius: 2px;
    }
    .step { position: relative; padding-left: 90px; margin-bottom: 28px; }
    .step-num {
      position: absolute; left: 12px; top: 0;
      width: 60px; height: 60px; border-radius: 50%;
      background: linear-gradient(135deg, #c4122d, #9b111e);
      color:#fff; display:flex; align-items:center; justify-content:center;
      font-weight: 800; font-size: 24px;
      box-shadow: 0 6px 18px rgba(196,18,45,.35);
      border: 4px solid #fff;
    }
    .step-card {
      background: #fff; border-radius: 14px; padding: 22px 24px;
      box-shadow: 0 4px 14px rgba(0,0,0,.06);
      border-left: 4px solid #c4122d;
      transition: transform .2s, box-shadow .2s;
    }
    .step-card:hover { transform: translateX(6px); box-shadow: 0 10px 24px rgba(0,0,0,.1); }
    .step-card h5 { font-weight: 700; color: #c4122d; margin-bottom: 8px; }
    .step-card p  { color: #555; margin: 0; line-height: 1.6; }
    .step-card .role-chip {
      display: inline-block; margin-top: 8px; padding: 3px 10px; border-radius: 999px;
      background: #fff0f2; color: #c4122d; font-size: 12px; font-weight: 600;
    }
    .status-legend {
      background: #fff; border-radius: 14px; padding: 24px;
      box-shadow: 0 4px 14px rgba(0,0,0,.06); margin-top: 30px;
    }
    .status-legend h4 { color: #c4122d; font-weight: 700; margin-bottom: 16px; }
    .status-item { display:flex; align-items:center; gap: 12px; padding: 8px 0; }
    .badge-s {
      display: inline-block; padding: 4px 12px; border-radius: 4px;
      font-size: 13px; font-weight: 700; color: #fff; min-width: 110px; text-align: center;
    }
    .bs1{background:#6c757d;} .bs2{background:#0d6efd;} .bs3{background:#fd7e14;}
    .bs4{background:#198754;} .bs9{background:#dc3545;}
  </style>
</head>
<body class="bg-light">
<?php include __DIR__ . '/includes/public_nav.php'; ?>

<div class="page-hero">
  <i class="fas fa-project-diagram fa-2x"></i>
  <h1>ขั้นตอนการฝึกงาน</h1>
  <p>ขั้นตอนการยื่นคำขอและดำเนินการฝึกงาน ของนิสิตสารสนเทศศึกษา</p>
</div>

<div class="container py-5">

  <div class="flow">
    <div class="step">
      <div class="step-num">1</div>
      <div class="step-card">
        <h5><i class="fas fa-file-signature me-2"></i>ยื่นคำขอฝึกงาน</h5>
        <p>นิสิตล็อกอินเข้าระบบ กรอกข้อมูลบริษัท ตำแหน่ง และช่วงเวลาที่ต้องการฝึกงาน พร้อมเลือกอาจารย์ที่ปรึกษา</p>
        <span class="role-chip"><i class="fas fa-user-graduate me-1"></i>นิสิต</span>
      </div>
    </div>

    <div class="step">
      <div class="step-num">2</div>
      <div class="step-card">
        <h5><i class="fas fa-user-check me-2"></i>อาจารย์ที่ปรึกษาพิจารณา</h5>
        <p>อาจารย์ที่ปรึกษาตรวจสอบคำขอ อนุมัติหรือปฏิเสธ พร้อมระบุหมายเหตุ</p>
        <span class="role-chip"><i class="fas fa-chalkboard-teacher me-1"></i>อาจารย์</span>
      </div>
    </div>

    <div class="step">
      <div class="step-num">3</div>
      <div class="step-card">
        <h5><i class="fas fa-envelope-open-text me-2"></i>เจ้าหน้าที่ออกใบส่งตัว</h5>
        <p>เจ้าหน้าที่คณะออกเอกสารใบส่งตัวอย่างเป็นทางการ ส่งให้บริษัทต้นสังกัด</p>
        <span class="role-chip"><i class="fas fa-file-invoice me-1"></i>เจ้าหน้าที่</span>
      </div>
    </div>

    <div class="step">
      <div class="step-num">4</div>
      <div class="step-card">
        <h5><i class="fas fa-briefcase me-2"></i>ฝึกงาน ณ สถานประกอบการ</h5>
        <p>นิสิตเริ่มฝึกงานตามเวลาที่กำหนด อาจารย์ออกนิเทศเพื่อติดตามผลและให้คำแนะนำ</p>
        <span class="role-chip"><i class="fas fa-clipboard-check me-1"></i>อาจารย์นิเทศ</span>
      </div>
    </div>

    <div class="step">
      <div class="step-num">5</div>
      <div class="step-card">
        <h5><i class="fas fa-award me-2"></i>ประเมินผลและสรุปการฝึกงาน</h5>
        <p>อาจารย์และเจ้าหน้าที่ประเมินผลการฝึกงาน พร้อมบันทึกคะแนนและเกรดลงในระบบ</p>
        <span class="role-chip"><i class="fas fa-chart-bar me-1"></i>อาจารย์/เจ้าหน้าที่</span>
      </div>
    </div>
  </div>

  <div class="status-legend">
    <h4><i class="fas fa-tags me-2"></i>สถานะในระบบ</h4>
    <div class="status-item"><span class="badge-s bs1">รอพิจารณา</span><span>นิสิตยื่นคำขอ รอให้อาจารย์ที่ปรึกษาตรวจสอบ</span></div>
    <div class="status-item"><span class="badge-s bs2">อนุมัติ</span><span>อาจารย์ที่ปรึกษาอนุมัติคำขอแล้ว รอเจ้าหน้าที่ออกใบส่งตัว</span></div>
    <div class="status-item"><span class="badge-s bs3">ออกใบส่งตัว</span><span>เจ้าหน้าที่ออกเอกสารใบส่งตัวให้บริษัท</span></div>
    <div class="status-item"><span class="badge-s bs4">สิ้นสุดการฝึก</span><span>ฝึกงานจบสิ้น ประเมินผลเรียบร้อย</span></div>
    <div class="status-item"><span class="badge-s bs9">ปฏิเสธ</span><span>คำขอไม่ผ่านการพิจารณา</span></div>
  </div>

</div>

<?php include __DIR__ . '/includes/public_footer.php'; ?>
</body>
</html>
