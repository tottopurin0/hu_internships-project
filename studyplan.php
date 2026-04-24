<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>แผนการศึกษา | IS SWU</title>
  <?php include __DIR__ . '/includes/public_head.php'; ?>
  <style>
    .page-hero {
      background: linear-gradient(135deg, rgba(196,18,45,.95), rgba(33,37,41,.9));
      color: #fff; padding: 80px 16px; text-align: center;
    }
    .page-hero h1 { font-weight: 800; font-size: 36px; margin: 12px 0 8px; }
    .page-hero p { opacity: .9; font-size: 16px; margin: 0; }
    .year-card {
      background: #fff; border-radius: 14px; padding: 24px 26px; margin-bottom: 22px;
      box-shadow: 0 4px 14px rgba(0,0,0,.06);
      border-top: 5px solid #c4122d;
    }
    .year-card h4 {
      font-weight: 700; color: #c4122d; margin-bottom: 4px;
      display:flex; align-items:center; gap: 10px;
    }
    .year-card .sub { color: #666; font-size: 14px; margin-bottom: 16px; }
    .semester { margin-bottom: 16px; }
    .semester h6 {
      background: #fff0f2; color: #c4122d; font-weight: 700;
      padding: 8px 14px; border-radius: 8px; display: inline-block;
      margin-bottom: 10px; font-size: 14px;
    }
    table.plan { width:100%; border-collapse: collapse; font-size: 14px; }
    table.plan th, table.plan td { padding: 9px 12px; border-bottom: 1px solid #f0f0f0; text-align: left; }
    table.plan thead { background: #fafafa; }
    table.plan th { font-weight: 700; color: #555; font-size: 13px; }
    table.plan .credits { text-align: center; width: 80px; color: #c4122d; font-weight: 700; }
    .total-row { background: #fff0f2; font-weight: 700; color: #c4122d; }
  </style>
</head>
<body class="bg-light">
<?php include __DIR__ . '/includes/public_nav.php'; ?>

<div class="page-hero">
  <i class="fas fa-calendar-alt fa-2x"></i>
  <h1>แผนการศึกษา</h1>
  <p>แผนการศึกษา 4 ปี · หลักสูตรสารสนเทศศึกษา ปรับปรุง พ.ศ. 2565</p>
</div>

<div class="container py-5" style="max-width: 1000px;">

  <div class="year-card">
    <h4><i class="fas fa-seedling"></i>ชั้นปีที่ 1</h4>
    <p class="sub">ปูพื้นฐานวิชาศึกษาทั่วไป และความรู้เบื้องต้นทางสารสนเทศ</p>

    <div class="semester">
      <h6>ภาคเรียนที่ 1</h6>
      <table class="plan">
        <thead><tr><th>รหัสวิชา</th><th>รายวิชา</th><th class="credits">หน่วยกิต</th></tr></thead>
        <tbody>
          <tr><td>SWU111</td><td>ภาษาไทยเพื่อการสื่อสาร</td><td class="credits">3</td></tr>
          <tr><td>SWU121</td><td>ภาษาอังกฤษเพื่อประสิทธิภาพการสื่อสาร 1</td><td class="credits">3</td></tr>
          <tr><td>IS111</td><td>สารสนเทศศึกษาเบื้องต้น</td><td class="credits">3</td></tr>
          <tr><td>IS112</td><td>เทคโนโลยีสารสนเทศและการสื่อสาร</td><td class="credits">3</td></tr>
          <tr><td>SWU141</td><td>ชีวิตในโลกดิจิทัล</td><td class="credits">3</td></tr>
          <tr class="total-row"><td colspan="2">รวม</td><td class="credits">15</td></tr>
        </tbody>
      </table>
    </div>

    <div class="semester">
      <h6>ภาคเรียนที่ 2</h6>
      <table class="plan">
        <thead><tr><th>รหัสวิชา</th><th>รายวิชา</th><th class="credits">หน่วยกิต</th></tr></thead>
        <tbody>
          <tr><td>SWU122</td><td>ภาษาอังกฤษเพื่อประสิทธิภาพการสื่อสาร 2</td><td class="credits">3</td></tr>
          <tr><td>IS121</td><td>การจัดระบบสารสนเทศ</td><td class="credits">3</td></tr>
          <tr><td>IS122</td><td>ทรัพยากรสารสนเทศ</td><td class="credits">3</td></tr>
          <tr><td>IS123</td><td>การสืบค้นและการบริการสารสนเทศ</td><td class="credits">3</td></tr>
          <tr><td>SWU151</td><td>การศึกษาทั่วไปเพื่อพัฒนามนุษย์</td><td class="credits">3</td></tr>
          <tr class="total-row"><td colspan="2">รวม</td><td class="credits">15</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="year-card">
    <h4><i class="fas fa-book-open"></i>ชั้นปีที่ 2</h4>
    <p class="sub">เรียนรู้การจัดการและบริการสารสนเทศเชิงลึก</p>

    <div class="semester">
      <h6>ภาคเรียนที่ 1</h6>
      <table class="plan">
        <tbody>
          <tr><td>IS211</td><td>การวิเคราะห์และออกแบบระบบสารสนเทศ</td><td class="credits">3</td></tr>
          <tr><td>IS212</td><td>ฐานข้อมูลและการจัดการ</td><td class="credits">3</td></tr>
          <tr><td>IS213</td><td>การจัดหมวดหมู่และการทำดรรชนี</td><td class="credits">3</td></tr>
          <tr><td>IS214</td><td>การพัฒนาเว็บไซต์เบื้องต้น</td><td class="credits">3</td></tr>
          <tr><td>—</td><td>วิชาศึกษาทั่วไป / วิชาเลือก</td><td class="credits">3</td></tr>
          <tr class="total-row"><td colspan="2">รวม</td><td class="credits">15</td></tr>
        </tbody>
      </table>
    </div>
    <div class="semester">
      <h6>ภาคเรียนที่ 2</h6>
      <table class="plan">
        <tbody>
          <tr><td>IS221</td><td>การจัดการห้องสมุดดิจิทัล</td><td class="credits">3</td></tr>
          <tr><td>IS222</td><td>สถิติเพื่อการวิจัยด้านสารสนเทศ</td><td class="credits">3</td></tr>
          <tr><td>IS223</td><td>การออกแบบประสบการณ์ผู้ใช้ (UX)</td><td class="credits">3</td></tr>
          <tr><td>IS224</td><td>สารสนเทศเพื่อการศึกษา</td><td class="credits">3</td></tr>
          <tr><td>—</td><td>วิชาศึกษาทั่วไป / วิชาเลือก</td><td class="credits">3</td></tr>
          <tr class="total-row"><td colspan="2">รวม</td><td class="credits">15</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="year-card">
    <h4><i class="fas fa-laptop-code"></i>ชั้นปีที่ 3</h4>
    <p class="sub">เจาะลึกเทคโนโลยีและการวิเคราะห์ข้อมูลสารสนเทศ</p>

    <div class="semester">
      <h6>ภาคเรียนที่ 1</h6>
      <table class="plan">
        <tbody>
          <tr><td>IS311</td><td>การจัดการโครงการสารสนเทศ</td><td class="credits">3</td></tr>
          <tr><td>IS312</td><td>Data Analytics และ Visualization</td><td class="credits">3</td></tr>
          <tr><td>IS313</td><td>การจัดการความรู้ในองค์กร</td><td class="credits">3</td></tr>
          <tr><td>IS314</td><td>การพัฒนาแอปพลิเคชันสารสนเทศ</td><td class="credits">3</td></tr>
          <tr><td>—</td><td>วิชาเลือก</td><td class="credits">3</td></tr>
          <tr class="total-row"><td colspan="2">รวม</td><td class="credits">15</td></tr>
        </tbody>
      </table>
    </div>
    <div class="semester">
      <h6>ภาคเรียนที่ 2</h6>
      <table class="plan">
        <tbody>
          <tr><td>IS321</td><td>การวิจัยทางสารสนเทศ 1</td><td class="credits">3</td></tr>
          <tr><td>IS322</td><td>การตลาดสารสนเทศและการสื่อสาร</td><td class="credits">3</td></tr>
          <tr><td>IS323</td><td>จริยธรรมและกฎหมายสารสนเทศ</td><td class="credits">3</td></tr>
          <tr><td>IS324</td><td>การประมวลผลภาษาธรรมชาติเบื้องต้น</td><td class="credits">3</td></tr>
          <tr><td>—</td><td>วิชาเลือก</td><td class="credits">3</td></tr>
          <tr class="total-row"><td colspan="2">รวม</td><td class="credits">15</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="year-card">
    <h4><i class="fas fa-briefcase"></i>ชั้นปีที่ 4</h4>
    <p class="sub">ฝึกงานในสถานประกอบการ และจัดทำโครงงานทางสารสนเทศ</p>

    <div class="semester">
      <h6>ภาคเรียนที่ 1 · ภาคฝึกงาน</h6>
      <table class="plan">
        <tbody>
          <tr><td>IS411</td><td>สหกิจศึกษา / ฝึกงาน (ไม่น้อยกว่า 16 สัปดาห์)</td><td class="credits">6</td></tr>
          <tr><td>IS412</td><td>การวิจัยทางสารสนเทศ 2</td><td class="credits">3</td></tr>
          <tr class="total-row"><td colspan="2">รวม</td><td class="credits">9</td></tr>
        </tbody>
      </table>
    </div>
    <div class="semester">
      <h6>ภาคเรียนที่ 2</h6>
      <table class="plan">
        <tbody>
          <tr><td>IS421</td><td>โครงงานพิเศษทางสารสนเทศ</td><td class="credits">6</td></tr>
          <tr><td>IS422</td><td>สัมมนาทางสารสนเทศ</td><td class="credits">3</td></tr>
          <tr><td>—</td><td>วิชาเลือก</td><td class="credits">3</td></tr>
          <tr class="total-row"><td colspan="2">รวม</td><td class="credits">12</td></tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php include __DIR__ . '/includes/public_footer.php'; ?>
</body>
</html>
