<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role(['staff']);

$user = current_user();
$fid  = (int)$user['staff_id'];
$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rid = (int)($_POST['request_id'] ?? 0);
    $remark = trim($_POST['remark'] ?? '');

    $stmt = $conn->prepare('SELECT status_id FROM internships_request WHERE request_id = ?');
    $stmt->bind_param('i', $rid);
    $stmt->execute();
    $cur = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$cur) {
        $err = 'ไม่พบคำขอ';
    } elseif ((int)$cur['status_id'] !== 2) {
        $err = 'คำขอนี้ยังไม่ผ่านการอนุมัติจากอาจารย์';
    } else {
        $old = 2; $new = 3;
        $stmt = $conn->prepare('UPDATE internships_request SET status_id = ? WHERE request_id = ?');
        $stmt->bind_param('ii', $new, $rid);
        $stmt->execute();
        $stmt->close();
        log_status_change($conn, $rid, $old, $new, null, $fid, $remark ?: 'ออกใบส่งตัว');
        $msg = 'ออกใบส่งตัวเรียบร้อย (คำขอ #'.$rid.')';
    }
}

$preview_id = (int)($_GET['id'] ?? 0);
$preview = null;
if ($preview_id) {
    $stmt = $conn->prepare(
        'SELECT r.*, r.position AS position_title, r.remarks AS description,
                s.first_name, s.last_name, s.student_code, s.faculty, s.major,
                c.company_name, c.address AS company_address,
                c.contact_person_name AS contact_person, c.province,
                t.first_name AS t_fn, t.last_name AS t_ln
         FROM internships_request r
         JOIN student s ON s.student_id = r.student_id
         JOIN company c ON c.company_id = r.company_id
         LEFT JOIN teacher t ON t.teacher_id = r.advisor_id
         WHERE r.request_id = ?'
    );
    $stmt->bind_param('i', $preview_id);
    $stmt->execute();
    $preview = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$ready = $conn->query(
    'SELECT r.request_id, r.start_date, r.end_date, r.status_id, r.position AS position_title,
            s.first_name, s.last_name, s.student_code, c.company_name
     FROM internships_request r
     JOIN student s ON s.student_id = r.student_id
     JOIN company c ON c.company_id = r.company_id
     WHERE r.status_id IN (2,3) ORDER BY r.updated_at DESC'
)->fetch_all(MYSQLI_ASSOC);

$page_title = 'ออกใบส่งตัว';
require '../includes/header.php';
?>

<h1><i class="fas fa-envelope-open-text me-2" style="color:var(--swu-red); margin-right: 10px;"></i>ออกใบส่งตัวฝึกงาน</h1>

<?php if ($msg): ?><div class="alert alert-success"><i class="fas fa-check me-2"></i><?= h($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert-error"><i class="fas fa-exclamation-circle me-2"></i><?= h($err) ?></div><?php endif; ?>

<div class="card card-table">
  <div class="card-header"><h2><i class="fas fa-inbox me-2" style="margin-right: 10px;"></i>คำขอที่พร้อมออกใบส่งตัว</h2></div>
  <?php if (!$ready): ?>
    <p class="muted">ไม่มีคำขอที่รออกใบส่งตัว</p>
  <?php else: ?>
    <table class="tbl">
      <thead><tr><th>#</th><th>นิสิต</th><th>บริษัท</th><th>ตำแหน่ง</th><th>ช่วง</th><th>สถานะ</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($ready as $r): [$l,$c] = status_label($r['status_id']); ?>
          <tr>
            <td>#<?= (int)$r['request_id'] ?></td>
            <td><?= h($r['student_code'].' '.$r['first_name'].' '.$r['last_name']) ?></td>
            <td><?= h($r['company_name']) ?></td>
            <td><?= h($r['position_title']) ?></td>
            <td><?= h($r['start_date']) ?> → <?= h($r['end_date']) ?></td>
            <td><span class="badge <?= h($c) ?>"><?= h($l) ?></span></td>
            <td><a href="?id=<?= (int)$r['request_id'] ?>">ดู</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php if ($preview): [$lbl, $cls] = status_label($preview['status_id']); ?>
  <div class="card card-form">
    <div class="card-header">
      <h2><i class="fas fa-file-invoice me-2" style="margin-right: 10px;"></i>ใบส่งตัว (Preview) #<?= (int)$preview['request_id'] ?></h2>
      <span class="badge <?= h($cls) ?>"><?= h($lbl) ?></span>
    </div>
    <div class="letter">
      <h3>ใบส่งตัวนิสิตฝึกงาน</h3>
      <p>เรียน ผู้จัดการฝ่ายทรัพยากรบุคคล<br>
         <strong><?= h($preview['company_name']) ?></strong><br>
         <?= h($preview['company_address']) ?> <?= h($preview['province']) ?></p>
      <p>ตามที่ <strong><?= h($preview['first_name'].' '.$preview['last_name']) ?></strong>
         รหัสนิสิต <?= h($preview['student_code']) ?> สังกัด <?= h($preview['faculty']) ?>
         สาขา <?= h($preview['major']) ?> ได้ประสานขอเข้าฝึกงาน ณ บริษัทของท่านในตำแหน่ง
         <strong><?= h($preview['position_title']) ?></strong>
         ระหว่างวันที่ <strong><?= h($preview['start_date']) ?></strong>
         ถึง <strong><?= h($preview['end_date']) ?></strong> นั้น</p>
      <p>คณะขอส่งตัวนิสิตดังกล่าวเข้าฝึกงานตามเวลาที่ระบุ โดยมี
         <strong>อ.<?= h(($preview['t_fn'].' '.$preview['t_ln']) ?: '-') ?></strong>
         เป็นอาจารย์ที่ปรึกษาและผู้นิเทศ</p>
      <p class="right">ขอแสดงความนับถือ<br>เจ้าหน้าที่คณะ</p>
    </div>

    <?php if ((int)$preview['status_id'] === 2): ?>
      <form method="POST" class="form">
        <input type="hidden" name="request_id" value="<?= (int)$preview['request_id'] ?>">
        <label>หมายเหตุ (ถ้ามี)
          <input type="text" name="remark" placeholder="เช่น เลขที่หนังสือ อว.xxx/2568">
        </label>
        <div class="actions">
          <button class="btn btn-primary" type="submit"><i class="fas fa-check me-1"></i> ยืนยันการออกใบส่งตัว</button>
          <button class="btn" type="button" onclick="window.print()"><i class="fas fa-print me-1"></i> พิมพ์</button>
        </div>
      </form>
    <?php else: ?>
      <p class="muted">คำขอนี้ออกใบส่งตัวไปแล้ว</p>
      <button class="btn" type="button" onclick="window.print()">พิมพ์</button>
    <?php endif; ?>
  </div>
<?php endif; ?>
