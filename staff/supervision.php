<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role(['teacher','staff']);

$user = current_user();
$role = current_role();
$tid  = $role === 'teacher' ? (int)$user['teacher_id'] : 0;
$msg  = '';
$err  = '';
$view_request = isset($_GET['view']) ? (int)$_GET['view'] : null;
$view_records = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rid        = (int)($_POST['request_id'] ?? 0);
    $visit_date = trim($_POST['visit_date'] ?? '');
    $visit_type = trim($_POST['visit_type'] ?? '');
    $notes      = trim($_POST['notes']      ?? '');
    $score      = $_POST['score'] !== '' ? (float)$_POST['score'] : null;
    $grade      = trim($_POST['grade'] ?? '');
    $complete   = !empty($_POST['mark_complete']);

    $stmt = $conn->prepare(
        'SELECT status_id FROM internships_request WHERE request_id = ? AND advisor_id = ?'
    );
    $stmt->bind_param('ii', $rid, $tid);
    $stmt->execute();
    $cur = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$cur) {
        $err = 'ไม่พบคำขอ หรือคุณไม่ใช่อาจารย์นิเทศ';
    } elseif (!$visit_date) {
        $err = 'กรุณาระบุวันที่นิเทศ';
    } else {
        $notes_combined = $notes;
        if ($visit_type) $notes_combined = '[' . $visit_type . '] ' . $notes_combined;
        if ($grade)      $notes_combined .= "\nเกรด: " . $grade;

        $stmt = $conn->prepare(
            'INSERT INTO supervision_record
              (request_id, teacher_id, supervision_date, score, remarks)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('iisds', $rid, $tid, $visit_date, $score, $notes_combined);
        $stmt->execute();
        $stmt->close();

        if ($complete && (int)$cur['status_id'] !== 4) {
            $old = (int)$cur['status_id'];
            $new = 4;
            $stmt = $conn->prepare('UPDATE internships_request SET status_id = ? WHERE request_id = ?');
            $stmt->bind_param('ii', $new, $rid);
            $stmt->execute();
            $stmt->close();
            log_status_change($conn, $rid, $old, $new, $tid, null, 'ปิดเคสหลังนิเทศ');
        }

        $msg = 'บันทึกการนิเทศเรียบร้อย';
    }
}

$stmt = $conn->prepare(
    'SELECT r.request_id, r.status_id, r.start_date, r.end_date,
            s.first_name, s.last_name, s.student_code, c.company_name
     FROM internships_request r
     JOIN student s ON s.student_id = r.student_id
     JOIN company c ON c.company_id = r.company_id
     WHERE r.advisor_id = ? AND r.status_id IN (2, 3, 4)
     ORDER BY r.start_date DESC'
);
$stmt->bind_param('i', $tid);
$stmt->execute();
$cases = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if ($view_request) {
    $stmt = $conn->prepare(
        'SELECT supervision_date, score, remarks FROM supervision_record
         WHERE request_id = ? ORDER BY supervision_date DESC'
    );
    $stmt->bind_param('i', $view_request);
    $stmt->execute();
    $view_records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$page_title = 'บันทึกการนิเทศ';
require '../includes/header.php';
?>

<h1><i class="fas fa-clipboard-check me-2" style="color:var(--swu-red); margin-right: 10px;"></i>บันทึกการนิเทศงาน</h1>

<?php if ($msg): ?><div class="alert alert-success"><i class="fas fa-check me-2"></i><?= h($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert-error"><i class="fas fa-exclamation-circle me-2"></i><?= h($err) ?></div><?php endif; ?>

<div class="card card-table">
  <div class="card-header"><h2><i class="fas fa-user-graduate me-2" style="margin-right: 10px;"></i>เคสที่อยู่ภายใต้การดูแล</h2></div>
  <?php if (!$cases): ?>
    <p class="muted">ยังไม่มีนิสิตที่ต้องนิเทศ</p>
  <?php else: ?>
    <table class="tbl">
      <thead><tr><th>#</th><th>นิสิต</th><th>บริษัท</th><th>ช่วง</th><th>สถานะ</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($cases as $r): [$l,$c] = status_label($r['status_id']); ?>
          <tr>
            <td>#<?= (int)$r['request_id'] ?></td>
            <td><?= h($r['student_code'].' '.$r['first_name'].' '.$r['last_name']) ?></td>
            <td><?= h($r['company_name']) ?></td>
            <td><?= h($r['start_date']) ?> → <?= h($r['end_date']) ?></td>
            <td><span class="badge <?= h($c) ?>"><?= h($l) ?></span></td>
            <td><a href="?view=<?= (int)$r['request_id'] ?>" class="btn btn-sm btn-secondary"><i class="fas fa-eye me-1" style="margin-right: 10px;"></i>ดูบันทึกนิเทศ</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php if ($view_request): ?>
<div class="card card-table">
  <div class="card-header">
    <h2><i class="fas fa-history me-2" style="margin-right: 10px;"></i>บันทึกการนิเทศสำหรับเคส #<?= (int)$view_request ?></h2>
    <a href="supervision.php" class="btn btn-secondary"><i class="fas fa-times me-1"></i>ปิด</a>
  </div>
  <?php if (!$view_records): ?>
    <p class="muted">ยังไม่มีบันทึกการนิเทศ</p>
  <?php else: ?>
    <table class="tbl">
      <thead><tr><th>วันที่นิเทศ</th><th>บันทึก</th><th>คะแนน</th></tr></thead>
      <tbody>
      <?php foreach ($view_records as $rec): ?>
        <tr>
          <td><strong><?= h($rec['supervision_date']) ?></strong></td>
          <td style="white-space: pre-wrap;"><?= h($rec['remarks']) ?></td>
          <td><?= $rec['score'] !== null ? (int)$rec['score'] : '—' ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
<?php endif; ?>

<div class="card card-form">
  <div class="card-header"><h2><i class="fas fa-plus-circle me-2" style="margin-right: 10px;"></i>เพิ่มบันทึกการนิเทศ</h2></div>
  <form method="POST" class="form" style="padding:24px">
    <label>เลือกคำขอ *
      <select name="request_id" required>
        <option value="">— เลือกเคส —</option>
        <?php foreach ($cases as $r): ?>
          <option value="<?= (int)$r['request_id'] ?>">
            #<?= (int)$r['request_id'] ?> — <?= h($r['first_name'].' '.$r['last_name']) ?> @ <?= h($r['company_name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    <div class="row">
      <label>วันที่นิเทศ * <input type="date" name="visit_date" required></label>
      <label>ประเภท
        <select name="visit_type">
          <option value="On-site">On-site (ที่บริษัท)</option>
          <option value="Online">Online (ออนไลน์)</option>
          <option value="Phone">Phone (โทรศัพท์)</option>
        </select>
      </label>
    </div>
    <label>บันทึก
      <textarea name="notes" rows="4" placeholder="สิ่งที่สังเกตเห็น, งานที่นิสิตกำลังทำ, จุดปรับปรุง"></textarea>
    </label>
    <div class="row">
      <label>คะแนน (0-100) <input type="number" name="score" min="0" max="100" step="0.5"></label>
      <label>เกรด
        <select name="grade">
          <option value="">—</option>
          <?php foreach (['A','B+','B','C+','C','D+','D','F'] as $g): ?>
            <option value="<?= $g ?>"><?= $g ?></option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>
    <label class="inline">
      <input type="checkbox" name="mark_complete" value="1">
      ปิดเคส (เปลี่ยนสถานะเป็น “เสร็จสิ้น”)
    </label>
    <div class="actions">
      <button class="btn btn-primary" type="submit">บันทึก</button>
    </div>
  </form>
</div>
