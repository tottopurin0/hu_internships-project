<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role('student');

$user = current_user();
$student_code = $user['student_code'];
$student_id   = (int)$user['student_id'];
$errors = [];
$success = '';

$companies = $conn->query(
    "SELECT company_id, company_name, province FROM company
     WHERE status = 'active' ORDER BY company_name"
)->fetch_all(MYSQLI_ASSOC);

$teachers = $conn->query(
    'SELECT teacher_id, first_name, last_name, department FROM teacher ORDER BY first_name'
)->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_id     = (int)($_POST['company_id'] ?? 0);
    $advisor_id     = (int)($_POST['advisor_id'] ?? 0) ?: ($user['advisor_id'] ?? null);
    $start_date     = trim($_POST['start_date'] ?? '');
    $end_date       = trim($_POST['end_date']   ?? '');
    $position_title = trim($_POST['position_title'] ?? '');
    $description    = trim($_POST['description']    ?? '');

    if ($company_id <= 0) $errors[] = 'กรุณาเลือกบริษัท';
    if (!$start_date)     $errors[] = 'กรุณาระบุวันเริ่มฝึกงาน';
    if (!$end_date)       $errors[] = 'กรุณาระบุวันสิ้นสุดฝึกงาน';
    if ($start_date && $end_date && strtotime($start_date) >= strtotime($end_date)) {
        $errors[] = 'วันเริ่มต้นต้องน้อยกว่าวันสิ้นสุด';
    }
    if ($position_title === '') $errors[] = 'กรุณาระบุตำแหน่งที่ต้องการฝึกงาน';

    if (!$errors) {
        $stmt = $conn->prepare(
            'INSERT INTO internships_request
              (student_id, company_id, advisor_id, start_date, end_date,
               position, remarks, status_id)
             VALUES (?, ?, ?, ?, ?, ?, ?, 1)'
        );
        $stmt->bind_param('iiissss', $student_id, $company_id, $advisor_id,
            $start_date, $end_date, $position_title, $description);
        $stmt->execute();
        $new_id = $stmt->insert_id;
        $stmt->close();

        log_status_change($conn, $new_id, null, 1, null, null, 'ยื่นคำขอใหม่ โดยนิสิต ' . $student_code);

        $success = 'ส่งคำขอฝึกงานเรียบร้อยแล้ว (หมายเลข #' . $new_id . ')';
    }
}

$page_title = 'ยื่นคำขอฝึกงาน';
require '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?? 'ยื่นคำขอฝึกงาน' ?></title>
    <link rel="stylesheet" href="/hu_internships-project/assets/css/style.css">
    
    </head>
<body>

<h1><i class="fas fa-file-signature" style="color:var(--swu-red); margin-right: 10px;"></i>ยื่นคำขอฝึกงาน</h1>

<?php if ($success): ?>
  <div class="alert alert-success">
    <?= h($success) ?> — <a href="request_status.php">ตรวจสอบสถานะ</a>
  </div>
<?php endif; ?>

<?php if ($errors): ?>
  <div class="alert alert-error">
    <ul><?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul>
  </div>
<?php endif; ?>

<div class="card card-form">
  <div class="card-header"><h2><i class="fas fa-edit me-2"></i>แบบฟอร์มคำขอ</h2></div>
<form method="POST" class="form" style="padding:24px">
  <label>
    บริษัท *
    <select name="company_id" required>
      <option value="">— เลือกบริษัท —</option>
      <?php foreach ($companies as $c): ?>
        <option value="<?= (int)$c['company_id'] ?>">
          <?= h($c['company_name']) ?> <?= $c['province'] ? '('.h($c['province']).')':'' ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>

  <label>
    อาจารย์ที่ปรึกษา
    <select name="advisor_id">
      <option value="0">— ใช้อาจารย์ที่ปรึกษาประจำตัว —</option>
      <?php foreach ($teachers as $t): ?>
        <option value="<?= (int)$t['teacher_id'] ?>"
          <?= ((int)$user['advisor_id'] === (int)$t['teacher_id']) ? 'selected' : '' ?>>
          อ.<?= h($t['first_name'].' '.$t['last_name']) ?> — <?= h($t['department']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>

  <label>
    ตำแหน่งที่ต้องการฝึกงาน *
    <input type="text" name="position_title" required maxlength="200"
           placeholder="เช่น Junior Web Developer">
  </label>

  <div class="row">
    <label>วันเริ่มฝึกงาน * <input type="date" name="start_date" required></label>
    <label>วันสิ้นสุดฝึกงาน * <input type="date" name="end_date"   required></label>
  </div>

  <label>
    รายละเอียดเพิ่มเติม
    <textarea name="description" rows="4" placeholder="อธิบายงานที่ต้องการฝึก, เหตุผลที่เลือกบริษัทนี้ ฯลฯ"></textarea>
  </label>

  <div class="actions">
    <a href="dashboard.php" class="btn"><i class="fas fa-times me-1"></i> ยกเลิก</a>
    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> ส่งคำขอ</button>
  </div>
</form>
</div>


</body>

</html>
