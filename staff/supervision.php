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

// ==========================================
// 1. จัดการการบันทึกข้อมูล (เฉพาะ Teacher เท่านั้น)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $role === 'teacher') {
    $rid        = (int)($_POST['request_id'] ?? 0);
    $visit_date = trim($_POST['visit_date'] ?? '');
    $visit_type = trim($_POST['visit_type'] ?? '');
    $notes      = trim($_POST['notes']      ?? '');
    $score      = $_POST['score'] !== '' ? (float)$_POST['score'] : null;
    $grade      = trim($_POST['grade'] ?? '');
    $complete   = !empty($_POST['mark_complete']);
    $failed     = !empty($_POST['mark_failed']);

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

        $new_status = null;
        if ($complete) {
            $new_status = 4; // เสร็จสิ้น
        } elseif ($failed) {
            $new_status = 9; // ไม่ผ่าน/ยกเลิก
        }

        if ($new_status !== null && (int)$cur['status_id'] !== $new_status) {
            $old = (int)$cur['status_id'];
            $stmt = $conn->prepare('UPDATE internships_request SET status_id = ? WHERE request_id = ?');
            $stmt->bind_param('ii', $new_status, $rid);
            $stmt->execute();
            $stmt->close();
            $log_msg = ($new_status === 4) ? 'ปิดเคสหลังนิเทศ (เสร็จสิ้น)' : 'ปิดเคสหลังนิเทศ (ไม่ผ่าน)';
            log_status_change($conn, $rid, $old, $new_status, $tid, null, $log_msg);
        }

        $msg = 'บันทึกการนิเทศเรียบร้อย';
    }
}

// ==========================================
// 2. ดึงข้อมูลแสดงผล แยกตาม Role (Teacher / Staff)
// ==========================================
$active_cases = [];
$history_cases = [];

if ($role === 'teacher') {
    // ดึงข้อมูลสำหรับ อาจารย์ (เฉพาะเคสของตัวเอง)
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

    if (!empty($cases)) {
        foreach ($cases as $case) {
            if ((int)$case['status_id'] === 3) {
                $active_cases[] = $case;
            } else {
                $history_cases[] = $case;
            }
        }
    }
} elseif ($role === 'staff') {
    // ดึงข้อมูลสำหรับ เจ้าหน้าที่ (ดูทั้งหมดของระบบ)
    $stmt = $conn->prepare(
        'SELECT r.request_id, r.status_id, r.start_date, r.end_date,
                s.first_name, s.last_name, s.student_code, c.company_name,
                t.first_name AS t_fn, t.last_name AS t_ln
         FROM internships_request r
         JOIN student s ON s.student_id = r.student_id
         JOIN company c ON c.company_id = r.company_id
         LEFT JOIN teacher t ON t.teacher_id = r.advisor_id
         WHERE r.status_id IN (2, 3, 4, 9) 
         ORDER BY r.start_date DESC'
    );
    $stmt->execute();
    $cases = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    if (!empty($cases)) {
        foreach ($cases as $case) {
            if ((int)$case['status_id'] === 3) {
                $active_cases[] = $case;
            } else {
                $history_cases[] = $case;
            }
        }
    }
}

// โหลดข้อมูลประวัติกรณีมีการกดปุ่ม "ดูบันทึก" (ใช้ได้ทั้งคู่)
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

<style>
/* CSS สำหรับจัดการหน้าต่าง Popup (Modal) ดูบันทึกการนิเทศ */
.custom-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); 
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.custom-modal-content {
    background-color: #fff;
    border-radius: 8px;
    width: 90%;
    max-width: 1000px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    overflow: hidden;
    animation: fadeInDown 0.3s ease-out;
}

.custom-modal-header {
    background-color: #6c757d; 
    color: white;
    padding: 15px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.custom-modal-header h2 {
    margin: 0;
    font-size: 1.2rem;
    color: white;
    display: flex;
    align-items: center;
}

.custom-modal-close {
    background-color: white;
    color: #333;
    border: none;
    padding: 6px 18px;
    border-radius: 20px;
    text-decoration: none;
    font-weight: bold;
    font-size: 0.95rem;
    transition: 0.2s;
    display: flex;
    align-items: center;
}

.custom-modal-close:hover {
    background-color: #f1f1f1;
    color: #000;
}

.custom-modal-body {
    padding: 25px;
    max-height: 75vh;
    overflow-y: auto;
}

.custom-modal-body table.tbl th {
    background-color: #ffffff;
    color: #333;
    border-bottom: 2px solid #dee2e6;
    padding: 12px 10px;
}

.custom-modal-body table.tbl td {
    vertical-align: top;
    border-bottom: 1px solid #f1f1f1;
    padding: 15px 10px;
}

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

body:has(.custom-modal-overlay) {
    overflow: hidden;
}
</style>

<h1>
  <i class="fas fa-clipboard-check me-2" style="color:var(--swu-red); margin-right: 10px;"></i>บันทึกการนิเทศงาน
</h1>

<?php if ($msg): ?><div class="alert alert-success"><i class="fas fa-check me-2"></i><?= h($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert-error"><i class="fas fa-exclamation-circle me-2"></i><?= h($err) ?></div><?php endif; ?>


<?php if ($role === 'teacher'): ?>
<div class="card card-table">
      <div class="card-header">
        <h2>
          <i class="fas fa-user-graduate me-2" style="margin-right: 10px;"></i>เคสที่อยู่ภายใต้การดูแล (กำลังดำเนินการ)
        </h2>
      </div>

      <?php if (empty($active_cases)): ?>
        <p class="muted" style="padding:20px">ยังไม่มีนิสิตที่อยู่ระหว่างการฝึกงาน</p>
      <?php else: ?>
        <table class="tbl">
          <thead><tr><th>#</th><th>นิสิต</th><th>บริษัท</th><th>ช่วง</th><th>สถานะ</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($active_cases as $r): [$l,$c] = status_label($r['status_id']); ?>
              <tr>
                  <td>#<?= (int)$r['request_id'] ?></td>
                  <td><?= h($r['student_code'].' '.$r['first_name'].' '.$r['last_name']) ?></td>
                  <td><?= h($r['company_name']) ?></td>
                  <td><?= h($r['start_date']) ?> → <?= h($r['end_date']) ?></td>
                  <td><span class="badge <?= h($c) ?>"><?= h($l) ?></span></td>
                  <td><a href="?view=<?= (int)$r['request_id'] ?>" class="btn btn-sm btn-secondary">
                    <i class="fas fa-eye me-1" style="margin-right: 10px;"></i>ดูบันทึกนิเทศ</a>
                  </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <div class="card card-form">
      <div class="card-header"><h2><i class="fas fa-plus-circle me-2" style="margin-right: 10px;"></i>เพิ่มบันทึกการนิเทศ</h2></div>
      <form method="POST" class="form" style="padding:24px">
        <label>เลือกคำขอ *
          <select name="request_id" required>
            <option value="">— เลือกเคส —</option>
            <?php foreach ($active_cases as $r): ?>
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
       <div style="margin-bottom: 15px;">
          <label class="inline" style="margin-right: 20px;">
            <input type="checkbox" name="mark_complete" value="1">
            ปิดเคส (เปลี่ยนสถานะเป็น “เสร็จสิ้น”)
          </label>
          <label class="inline">
            <input type="checkbox" name="mark_failed" value="1">
            ปิดเคส (เปลี่ยนสถานะเป็น “ไม่ผ่าน”)
          </label>
        </div>
        <div class="actions">
          <button class="btn btn-primary" type="submit">บันทึก</button>
        </div>
      </form>
    </div>

    <div class="card card-table" style="margin-top: 30px;">
      <div class="card-header">
        <h2>
          <i class="fas fa-archive me-2" style="margin-right: 10px;"></i>ประวัติการนิเทศ (เคสที่ปิดแล้ว)
        </h2>
      </div>

      <?php if (empty($history_cases)): ?>
        <p class="muted" style="padding:20px">ยังไม่มีประวัติเคสที่เสร็จสิ้น</p>
      <?php else: ?>
        <table class="tbl">
          <thead><tr><th>#</th><th>นิสิต</th><th>บริษัท</th><th>ช่วง</th><th>สถานะ</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($history_cases as $r): [$l,$c] = status_label($r['status_id']); ?>
              <tr>
                  <td>#<?= (int)$r['request_id'] ?></td>
                  <td><?= h($r['student_code'].' '.$r['first_name'].' '.$r['last_name']) ?></td>
                  <td><?= h($r['company_name']) ?></td>
                  <td><?= h($r['start_date']) ?> → <?= h($r['end_date']) ?></td>
                  <td><span class="badge <?= h($c) ?>"><?= h($l) ?></span></td>
                  <td>
                    <a href="?view=<?= (int)$r['request_id'] ?>" class="btn btn-sm btn-secondary">
                      <i class="fas fa-eye me-1" style="margin-right: 10px;"></i>ดูบันทึก
                    </a>
                  </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

<?php elseif ($role === 'staff'): ?>
<div class="card card-table">
      <div class="card-header">
        <h2>
          <i class="fas fa-user-graduate me-2" style="margin-right: 10px;"></i>เคสที่อยู่ภายใต้การดูแล (กำลังดำเนินการ) ทั้งหมด
        </h2>
      </div>

      <?php if (empty($active_cases)): ?>
        <p class="muted" style="padding:20px">ยังไม่มีนิสิตที่อยู่ระหว่างการฝึกงาน</p>
      <?php else: ?>
        <table class="tbl">
          <thead><tr><th>#</th><th>นิสิต</th><th>บริษัท</th><th>อาจารย์ผู้นิเทศ</th><th>ช่วง</th><th>สถานะ</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($active_cases as $r): [$l,$c] = status_label($r['status_id']); ?>
              <tr>
                  <td>#<?= (int)$r['request_id'] ?></td>
                  <td><?= h($r['student_code'].' '.$r['first_name'].' '.$r['last_name']) ?></td>
                  <td><?= h($r['company_name']) ?></td>
                  <td><?= $r['t_fn'] ? 'อ.'.h($r['t_fn'].' '.$r['t_ln']) : '<span class="muted">-</span>' ?></td>
                  <td><?= h($r['start_date']) ?> → <?= h($r['end_date']) ?></td>
                  <td><span class="badge <?= h($c) ?>"><?= h($l) ?></span></td>
                  <td>
                    <a href="?view=<?= (int)$r['request_id'] ?>" class="btn btn-sm btn-secondary">
                      <i class="fas fa-eye me-1" style="margin-right: 10px;"></i>ดูบันทึก
                    </a>
                  </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <div class="card card-table" style="margin-top: 30px;">
      <div class="card-header">
        <h2>
          <i class="fas fa-list-alt me-2" style="margin-right: 10px;"></i>ประวัติการนิเทศทั้งหมด (ทุกเคส)
        </h2>
      </div>

      <?php if (empty($history_cases)): ?>
        <p class="muted" style="padding:20px">ยังไม่มีข้อมูลประวัติการนิเทศ</p>
      <?php else: ?>
        <table class="tbl">
          <thead><tr><th>#</th><th>นิสิต</th><th>บริษัท</th><th>อาจารย์ผู้นิเทศ</th><th>ช่วง</th><th>สถานะ</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($history_cases as $r): [$l,$c] = status_label($r['status_id']); ?>
              <tr>
                  <td>#<?= (int)$r['request_id'] ?></td>
                  <td><?= h($r['student_code'].' '.$r['first_name'].' '.$r['last_name']) ?></td>
                  <td><?= h($r['company_name']) ?></td>
                  <td><?= $r['t_fn'] ? 'อ.'.h($r['t_fn'].' '.$r['t_ln']) : '<span class="muted">-</span>' ?></td>
                  <td><?= h($r['start_date']) ?> → <?= h($r['end_date']) ?></td>
                  <td><span class="badge <?= h($c) ?>"><?= h($l) ?></span></td>
                  <td>
                    <a href="?view=<?= (int)$r['request_id'] ?>" class="btn btn-sm btn-secondary">
                      <i class="fas fa-eye me-1" style="margin-right: 10px;"></i>ดูบันทึก
                    </a>
                  </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

<?php endif; ?>

<?php if ($view_request): ?>
<div class="custom-modal-overlay">
  <div class="custom-modal-content">
    <div class="custom-modal-header">
      <h2><i class="fas fa-history me-2" style="margin-right: 10px;"></i>บันทึกการนิเทศสำหรับเคส #<?= (int)$view_request ?></h2>
      <a href="supervision.php" class="custom-modal-close"><i class="fas fa-times" style="margin-right: 5px;"></i> ปิด</a>
    </div>
    
    <div class="custom-modal-body">
      <?php if (!$view_records): ?>
        <p class="muted" style="text-align:center; padding:30px;">ยังไม่มีบันทึกการนิเทศ</p>
      <?php else: ?>
        <table class="tbl" style="width:100%; border-collapse: collapse; margin: 0;">
          <thead>
            <tr>
              <th style="width: 15%; text-align: left;">วันที่นิเทศ</th>
              <th style="width: 75%; text-align: left;">บันทึก</th>
              <th style="width: 10%; text-align: center;">คะแนน</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($view_records as $rec): ?>
            <tr>
              <td><strong><?= h($rec['supervision_date']) ?></strong></td>
              <td style="white-space: pre-wrap; line-height: 1.6;"><?= h($rec['remarks']) ?></td>
              <td style="text-align: center; font-weight: bold; font-size: 1.1rem; color: #333;">
                <?= $rec['score'] !== null ? (int)$rec['score'] : '—' ?>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php endif; ?>

</body>
</html>