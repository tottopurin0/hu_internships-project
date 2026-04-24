<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role(['teacher']);

$user = current_user();
$tid  = (int)$user['teacher_id'];
$msg  = '';
$err  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rid    = (int)($_POST['request_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    $remark = trim($_POST['remark'] ?? '');

    $stmt = $conn->prepare(
        'SELECT status_id FROM internships_request
         WHERE request_id = ? AND advisor_id = ?'
    );
    $stmt->bind_param('ii', $rid, $tid);
    $stmt->execute();
    $cur = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$cur) {
        $err = 'ไม่พบคำขอนี้ หรือคุณไม่ใช่อาจารย์ที่ปรึกษาของคำขอนี้';
    } elseif ((int)$cur['status_id'] !== 1) {
        $err = 'คำขอนี้ไม่อยู่ในสถานะรออนุมัติ';
    } else {
        $new_status = ($action === 'approve') ? 2 : (($action === 'reject') ? 9 : 0);
        if ($new_status === 0) {
            $err = 'การกระทำไม่ถูกต้อง';
        } else {
            $stmt = $conn->prepare('UPDATE internships_request SET status_id = ? WHERE request_id = ?');
            $stmt->bind_param('ii', $new_status, $rid);
            $stmt->execute();
            $stmt->close();

            log_status_change(
                $conn, $rid, 1, $new_status,
                $tid, null, $remark
            );
            $msg = 'บันทึกการพิจารณาเรียบร้อย';
        }
    }
}

$selected_id = (int)($_GET['id'] ?? 0);
$selected = null;
if ($selected_id) {
    $stmt = $conn->prepare(
        'SELECT r.*, r.position AS position_title, r.remarks AS description,
                s.first_name, s.last_name, s.student_code, s.faculty, s.major, s.gpa,
                c.company_name, c.province,
                c.contact_person_name AS contact_person, c.contact_person_phone AS contact_phone
         FROM internships_request r
         JOIN student s ON s.student_id = r.student_id
         JOIN company c ON c.company_id = r.company_id
         WHERE r.request_id = ? AND r.advisor_id = ?'
    );
    $stmt->bind_param('ii', $selected_id, $tid);
    $stmt->execute();
    $selected = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$stmt = $conn->prepare(
    'SELECT r.request_id, r.start_date, r.end_date, r.status_id, r.position AS position_title,
            s.first_name, s.last_name, s.student_code, c.company_name
     FROM internships_request r
     JOIN student s ON s.student_id = r.student_id
     JOIN company c ON c.company_id = r.company_id
     WHERE r.advisor_id = ? AND r.status_id = 1
     ORDER BY r.created_at ASC'
);
$stmt->bind_param('i', $tid);
$stmt->execute();
$pending = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$page_title = 'อนุมัติคำขอ';
require '../includes/header.php';
?>

<h1><i class="fas fa-check-circle me-2" style="color:var(--swu-red)"></i>อนุมัติคำขอฝึกงาน</h1>

<?php if ($msg): ?><div class="alert alert-success"><i class="fas fa-check me-2"></i><?= h($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert-error"><i class="fas fa-exclamation-circle me-2"></i><?= h($err) ?></div><?php endif; ?>

<div class="card card-table">
  <div class="card-header"><h2><i class="fas fa-hourglass-half me-2"></i>คำขอที่รอพิจารณา (<?= count($pending) ?>)</h2></div>
  <?php if (!$pending): ?>
    <p class="muted">ไม่มีคำขอที่รอพิจารณา ✅</p>
  <?php else: ?>
    <table class="tbl">
      <thead><tr><th>#</th><th>นิสิต</th><th>บริษัท</th><th>ตำแหน่ง</th><th>ช่วง</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($pending as $r): ?>
          <tr>
            <td>#<?= (int)$r['request_id'] ?></td>
            <td><?= h($r['student_code'].' '.$r['first_name'].' '.$r['last_name']) ?></td>
            <td><?= h($r['company_name']) ?></td>
            <td><?= h($r['position_title']) ?></td>
            <td><?= h($r['start_date']) ?> → <?= h($r['end_date']) ?></td>
            <td><a href="?id=<?= (int)$r['request_id'] ?>">พิจารณา →</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php if ($selected): [$lbl, $cls] = status_label($selected['status_id']); ?>
  <div class="card card-form">
    <div class="card-header">
      <h2><i class="fas fa-file-alt me-2"></i>รายละเอียดคำขอ #<?= (int)$selected['request_id'] ?></h2>
      <span class="badge <?= h($cls) ?>"><?= h($lbl) ?></span>
    </div>
    <dl class="kv">
      <dt>นิสิต</dt>
      <dd><?= h($selected['student_code'].' — '.$selected['first_name'].' '.$selected['last_name']) ?></dd>
      <dt>คณะ/สาขา</dt><dd><?= h($selected['faculty'].' / '.$selected['major']) ?></dd>
      <dt>GPA</dt><dd><?= h($selected['gpa']) ?></dd>
      <dt>บริษัท</dt><dd><?= h($selected['company_name']) ?> (<?= h($selected['province']) ?>)</dd>
      <dt>ผู้ติดต่อ</dt><dd><?= h($selected['contact_person']) ?> <?= h($selected['contact_phone']) ?></dd>
      <dt>ตำแหน่ง</dt><dd><?= h($selected['position_title']) ?></dd>
      <dt>ช่วงฝึกงาน</dt><dd><?= h($selected['start_date']) ?> ถึง <?= h($selected['end_date']) ?></dd>
      <dt>รายละเอียด</dt><dd><?= nl2br(h($selected['description'] ?: '-')) ?></dd>
    </dl>

    <?php if ((int)$selected['status_id'] === 1): ?>
      <form method="POST" class="form">
        <input type="hidden" name="request_id" value="<?= (int)$selected['request_id'] ?>">
        <label>หมายเหตุ (ถึงนิสิต)
          <textarea name="remark" rows="3" placeholder="ข้อคิดเห็น, เงื่อนไข, ฯลฯ"></textarea>
        </label>
        <div class="actions">
          <button class="btn btn-danger"  name="action" value="reject"><i class="fas fa-times-circle me-1"></i> ไม่อนุมัติ</button>
          <button class="btn btn-primary" name="action" value="approve"><i class="fas fa-check-circle me-1"></i> อนุมัติ</button>
        </div>
      </form>
    <?php else: ?>
      <p class="muted">คำขอนี้ได้รับการพิจารณาแล้ว — ไม่สามารถแก้ไขได้</p>
    <?php endif; ?>
  </div>
<?php endif; ?>

<?php require '../includes/footer.php'; ?>
