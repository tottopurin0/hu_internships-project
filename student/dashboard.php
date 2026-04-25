<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role('student');

$user = current_user();
$student_code = $user['student_code'];
$student_id   = (int)$user['student_id'];

$stmt = $conn->prepare(
    'SELECT r.request_id, r.start_date, r.end_date, r.status_id, r.position AS position_title,
            c.company_name
     FROM internships_request r
     JOIN company c ON c.company_id = r.company_id
     WHERE r.student_id = ?
     ORDER BY r.created_at DESC'
);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$requests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$counts = ['total'=>0,'pending'=>0,'approved'=>0,'completed'=>0];
foreach ($requests as $r) {
    $counts['total']++;
    if ($r['status_id'] == 1) $counts['pending']++;
    if ($r['status_id'] == 2 || $r['status_id'] == 3) $counts['approved']++;
    if ($r['status_id'] == 4) $counts['completed']++;
}

$page_title = 'หน้าหลักนิสิต';
require '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?? 'ระบบฝึกงาน' ?></title>
    
    <link rel="stylesheet" href="/hu_internships-project/assets/css/style.css">
    
    </head>
<body>

<h1><i class="fas fa-hand-sparkles me-2" style="color:var(--swu-red)"></i> สวัสดี <?= h($user['display_name']) ?></h1>
<p class="muted"><i class="fas fa-id-card me-1"></i> รหัสนิสิต: <?= h($student_code) ?> · <?= h($user['major']) ?></p>

<div class="stats">
  <div class="stat-card"><div class="num"><?= $counts['total'] ?></div><div>คำขอทั้งหมด</div></div>
  <div class="stat-card"><div class="num"><?= $counts['pending'] ?></div><div>รออนุมัติ</div></div>
  <div class="stat-card"><div class="num"><?= $counts['approved'] ?></div><div>อนุมัติ/ออกใบแล้ว</div></div>
  <div class="stat-card"><div class="num"><?= $counts['completed'] ?></div><div>เสร็จสิ้น</div></div>
</div>

<div class="card card-table">
  <div class="card-header">
    <h2><i class="fas fa-list me-2"></i>คำขอฝึกงานล่าสุด</h2>
    <div style="display: flex; gap: 10px;">
      <a class="btn btn-primary" href="request_new.php"><i class="fas fa-plus me-1"></i> ยื่นคำขอใหม่</a>
      <a class="btn btn-secondary" href="/staff/supervision.php"><i class="fas fa-clipboard-check me-1"></i> ดูรายการบันทึกนิเทศ</a>
    </div>
  </div>

  <?php if (!$requests): ?>
    <p class="muted">ยังไม่มีคำขอฝึกงาน — <a href="request_new.php">เริ่มยื่นคำขอ</a></p>
  <?php else: ?>
    <table class="tbl">
      <thead>
        <tr>
          <th>#</th><th>บริษัท</th><th>ตำแหน่ง</th>
          <th>ช่วงฝึกงาน</th><th>สถานะ</th><th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($requests as $r):
        [$label, $class] = status_label($r['status_id']); ?>
        <tr>
          <td>#<?= (int)$r['request_id'] ?></td>
          <td><?= h($r['company_name']) ?></td>
          <td><?= h($r['position_title']) ?></td>
          <td><?= h($r['start_date']) ?> → <?= h($r['end_date']) ?></td>
          <td><span class="badge <?= h($class) ?>"><?= h($label) ?></span></td>
          <td><a href="request_status.php?id=<?= (int)$r['request_id'] ?>">ดูรายละเอียด</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
  </div>

  
</body>

</html>
