<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role(['teacher','staff']);

$role = current_role();
$user = current_user();

$counts = $conn->query(
    'SELECT status_id, COUNT(*) AS n FROM internships_request GROUP BY status_id'
)->fetch_all(MYSQLI_ASSOC);

$by_status = array_fill_keys([1,2,3,4,9], 0);
foreach ($counts as $c) $by_status[(int)$c['status_id']] = (int)$c['n'];

if ($role === 'teacher') {
    $tid = (int)$user['teacher_id'];
    $stmt = $conn->prepare(
        'SELECT r.request_id, r.start_date, r.end_date, r.status_id, r.position AS position_title,
                s.first_name, s.last_name, s.student_code, c.company_name
         FROM internships_request r
         JOIN student s ON s.student_id = r.student_id
         JOIN company c ON c.company_id = r.company_id
         WHERE r.advisor_id = ?
         ORDER BY r.created_at DESC LIMIT 20'
    );
    $stmt->bind_param('i', $tid);
} else {
    $stmt = $conn->prepare(
        'SELECT r.request_id, r.start_date, r.end_date, r.status_id, r.position AS position_title,
                s.first_name, s.last_name, s.student_code, c.company_name
         FROM internships_request r
         JOIN student s ON s.student_id = r.student_id
         JOIN company c ON c.company_id = r.company_id
         ORDER BY r.created_at DESC LIMIT 20'
    );
}
$stmt->execute();
$recent = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$page_title = 'หน้าหลัก';
require '../includes/header.php';
?>

<h1><i class="fa-solid fa-address-card me-2" style="color:var(--swu-red)"></i> สวัสดี <?= h($user['display_name']) ?></h1>
<p class="muted">
  บทบาท: <?= $role === 'teacher' ? 'อาจารย์' : 'เจ้าหน้าที่' ?>
  <?php if ($role === 'teacher' && !empty($user['department'])): ?>
    · <?= h($user['department']) ?>
  <?php elseif ($role === 'staff' && !empty($user['position'])): ?>
    · <?= h($user['position']) ?>
  <?php endif; ?>
</p>

<div class="stats">
  <div class="stat-card"><div class="num"><?= $by_status[1] ?></div><div>รออนุมัติ</div></div>
  <div class="stat-card"><div class="num"><?= $by_status[2] ?></div><div>อนุมัติแล้ว</div></div>
  <div class="stat-card"><div class="num"><?= $by_status[3] ?></div><div>ออกใบส่งตัว</div></div>
  <div class="stat-card"><div class="num"><?= $by_status[4] ?></div><div>เสร็จสิ้น</div></div>
  <div class="stat-card"><div class="num"><?= $by_status[9] ?></div><div>ยกเลิก/ไม่ผ่าน</div></div>
</div>

<div class="card card-table">
  <div class="card-header">
    <h2><i class="fas fa-clock me-2" style="margin-right: 10px;"></i>คำขอล่าสุด</h2>
    <div style="display: flex; gap: 10px;">
      <?php if ($role === 'teacher'): ?>
        <a class="btn btn-primary" href="approve_requests.php"><i class="fas fa-check-circle me-1"></i> ไปอนุมัติคำขอ</a>
        <a class="btn btn-secondary" href="supervision.php"><i class="fas fa-clipboard-check me-1"></i> ดูรายการบันทึกนิเทศ</a>
      <?php else: ?>
        <a class="btn btn-primary" href="issue_letter.php"><i class="fas fa-envelope-open-text me-1"></i> ออกใบส่งตัว</a>
        <a class="btn btn-secondary" href="supervision.php"><i class="fas fa-clipboard-check me-1"></i> ดูรายการบันทึกนิเทศ</a>
      <?php endif; ?>
    </div>
  </div>

  <?php if (!$recent): ?>
    <p class="muted">ยังไม่มีคำขอ</p>
  <?php else: ?>
    <table class="tbl">
      <thead>
        <tr><th>#</th><th>นิสิต</th><th>บริษัท</th><th>ช่วง</th><th>สถานะ</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($recent as $r): [$l,$c] = status_label($r['status_id']); ?>
          <tr>
            <td>#<?= (int)$r['request_id'] ?></td>
            <td><?= h($r['student_code']) ?> <?= h($r['first_name'].' '.$r['last_name']) ?></td>
            <td><?= h($r['company_name']) ?></td>
            <td><?= h($r['start_date']) ?> → <?= h($r['end_date']) ?></td>
            <td><span class="badge <?= h($c) ?>"><?= h($l) ?></span></td>
            <td>
              <?php if ($role === 'teacher'): ?>
                <a href="approve_requests.php?id=<?= (int)$r['request_id'] ?>">จัดการ</a>
              <?php else: ?>
                <a href="issue_letter.php?id=<?= (int)$r['request_id'] ?>">จัดการ</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>


