<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role(['staff']);

$page_title = 'จัดการนิสิต';
require '../includes/header.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$errors = [];
$msg = '';

// Fetch advisors for dropdown
$advisors = $conn->query('SELECT teacher_id, first_name, last_name FROM teacher ORDER BY first_name')->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add' || $action === 'edit') {
        $code = trim($_POST['student_code'] ?? '');
        $fname = trim($_POST['first_name'] ?? '');
        $lname = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $faculty = trim($_POST['faculty'] ?? '');
        $major = trim($_POST['major'] ?? '');
        $gpa = trim($_POST['gpa'] ?? '');
        $advisor_id = (int)($_POST['advisor_id'] ?? 0);
        $password = trim($_POST['password'] ?? '');

        if (!preg_match('/^\d{5,20}$/', $code)) $errors[] = 'รหัสนิสิตต้องเป็นตัวเลข 5–20 หลัก';
        if (!$fname || !$lname) $errors[] = 'กรุณากรอกชื่อ-นามสกุล';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'อีเมลไม่ถูกต้อง';
        if ($gpa && !is_numeric($gpa)) $errors[] = 'GPA ไม่ถูกต้อง';

        if ($action === 'add') {
            if (!$password || strlen($password) < 6) $errors[] = 'รหัสผ่านต้องอย่างน้อย 6 ตัวอักษร';
            if (!$errors) {
                $stmt = $conn->prepare('SELECT 1 FROM student WHERE student_code = ?');
                $stmt->bind_param('s', $code);
                $stmt->execute();
                if ($stmt->get_result()->fetch_row()) $errors[] = 'รหัสนิสิตนี้มีในระบบแล้ว';
                $stmt->close();
            }
        }

        if (!$errors) {
            if ($action === 'add') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $gpa_val = $gpa ? (float)$gpa : null;
                $adv_val = $advisor_id ?: null;
                $stmt = $conn->prepare('INSERT INTO student (student_code, password, first_name, last_name, email, phone, faculty, major, gpa, advisor_id) VALUES (?,?,?,?,?,?,?,?,?,?)');
                $stmt->bind_param('ssssssdisi', $fname, $lname, $email, $phone, $faculty, $major, $gpa_val, $adv_val, $hash, $id);
                if ($stmt->execute()) {
                    $msg = 'เพิ่มนิสิตสำเร็จ';
                    $action = 'list';
                } else {
                    $errors[] = $conn->error;
                }
                $stmt->close();
            } else {
                $gpa_val = $gpa ? (float)$gpa : null;
                $adv_val = $advisor_id ?: null;
                if ($password) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare('UPDATE student SET first_name=?, last_name=?, email=?, phone=?, faculty=?, major=?, gpa=?, advisor_id=?, password=? WHERE student_id=?');
                    $stmt->bind_param('ssssssssi', $fname, $lname, $email, $phone, $faculty, $major, $gpa_val, $adv_val, $hash, $id);
                } else {
                    $stmt = $conn->prepare('UPDATE student SET first_name=?, last_name=?, email=?, phone=?, faculty=?, major=?, gpa=?, advisor_id=? WHERE student_id=?');
                    $stmt->bind_param('ssssssdii', $fname, $lname, $email, $phone, $faculty, $major, $gpa_val, $adv_val, $id);
                }
                if ($stmt->execute()) {
                    $msg = 'แก้ไขนิสิตสำเร็จ';
                    $action = 'list';
                } else {
                    $errors[] = $conn->error;
                }
                $stmt->close();
            }
        }
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare('DELETE FROM student WHERE student_id=?');
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $msg = 'ลบนิสิตสำเร็จ';
        } else {
            $errors[] = $conn->error;
        }
        $stmt->close();
        $action = 'list';
    }
}

if ($action === 'list') {
    $students = $conn->query('SELECT s.*, t.first_name AS advisor_fname, t.last_name AS advisor_lname FROM student s LEFT JOIN teacher t ON s.advisor_id = t.teacher_id ORDER BY s.student_code')->fetch_all(MYSQLI_ASSOC);
    ?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
  <h1><i class="fas fa-users me-2" style="margin-right: 20px;"></i>จัดการนิสิต</h1>
</div>

<?php if ($msg): ?>
  <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= h($msg) ?></div>
<?php endif; ?>

<?php if (!$students): ?>
  <p class="muted">ยังไม่มีนิสิต</p>
<?php else: ?>
  
  <div class="card card-table">
    <table class="tbl">
      <thead>
        <tr><th>รหัสนิสิต</th><th>ชื่อ-นามสกุล</th><th>อีเมล</th><th>อาจารย์ที่ปรึกษา</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($students as $s): ?>
          <tr>
            <td><strong><?= h($s['student_code']) ?></strong></td>
            <td><?= h($s['first_name'].' '.$s['last_name']) ?></td>
            <td><?= h($s['email']) ?></td>
            <td><?= $s['advisor_fname'] ? h($s['advisor_fname'].' '.$s['advisor_lname']) : '—' ?></td>
            <td style="text-align: right; gap: 8px;">
              <a href="?action=edit&id=<?= (int)$s['student_id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit me-1" style="margin-right: 10px;"></i>แก้ไข</a>
              <a href="?action=delete&id=<?= (int)$s['student_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('ต้องการลบ?')"><i class="fas fa-trash me-1" style="margin-right: 10px;"></i>ลบ</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif;

} elseif ($action === 'add' || $action === 'edit') {
    $student = null;
    if ($action === 'edit') {
        $stmt = $conn->prepare('SELECT * FROM student WHERE student_id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $student = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!$student) {
            echo '<p class="alert alert-error">ไม่พบนิสิตนี้</p>';
            exit;
        }
    }
    ?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
  <h1><i class="fas fa-users me-2" style="margin-right: 10px;"></i><?= $action === 'add' ? 'เพิ่มนิสิตใหม่' : 'แก้ไขนิสิต' ?></h1>
</div>

<?php if ($errors): ?>
  <div class="alert alert-error" style="margin-bottom: 20px;">
    <strong><i class="fas fa-exclamation-circle me-2"></i>พบข้อผิดพลาด:</strong>
    <ul style="margin-bottom: 0;">
      <?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?>
    </ul>
  </div>

<?php endif; ?>

<div class="card card-form">
  <div class="card-header">
    <h2>
      <i class="fas fa-<?= $action === 'edit' ? 'pen' : 'user-plus' ?>-circle me-2" style="margin-right: 10px;"></i>
      <?= $action === 'add' ? 'เพิ่มนิสิตใหม่' : 'แก้ไขนิสิต' ?>
    </h2>
  </div>

  <form method="POST" class="form" style="padding:24px">
    
    <label>รหัสนิสิต *
      <input type="text" name="student_code" required value="<?= $student ? h($student['student_code']) : '' ?>" <?= $action === 'edit' ? 'readonly' : '' ?> placeholder="เช่น 6610501234">
      <small style="color: #666; display: block; margin-top: 4px;">ต้องเป็นตัวเลข 5–20 หลัก <?= $action === 'edit' ? '(ไม่สามารถแก้ไขได้)' : '' ?></small>
    </label>

    <div class="row">
      <label>ชื่อ *
        <input type="text" name="first_name" required value="<?= $student ? h($student['first_name']) : '' ?>">
      </label>
      <label>นามสกุล *
        <input type="text" name="last_name" required value="<?= $student ? h($student['last_name']) : '' ?>">
      </label>
    </div>

    <div class="row">
      <label>อีเมล *
        <input type="email" name="email" required value="<?= $student ? h($student['email']) : '' ?>">
      </label>
      <label>เบอร์โทร
        <input type="text" name="phone" value="<?= $student ? h($student['phone']) : '' ?>" placeholder="เช่น 089-xxx-xxxx">
      </label>
    </div>

    <div class="row">
      <label>คณะ
        <input type="text" name="faculty" value="<?= $student ? h($student['faculty']) : '' ?>" placeholder="เช่น วิทยาศาสตร์">
      </label>
      <label>สาขา
        <input type="text" name="major" value="<?= $student ? h($student['major']) : '' ?>" placeholder="เช่น วิทยาการคอมพิวเตอร์">
      </label>
    </div>

    <div class="row">
      <label>GPA
        <input type="number" step="0.01" min="0" max="4" name="gpa" value="<?= $student ? h($student['gpa']) : '' ?>" placeholder="0.00 - 4.00">
      </label>
      <label>อาจารย์ที่ปรึกษา
        <select name="advisor_id">
          <option value="">— ไม่มี —</option>
          <?php foreach ($advisors as $a): ?>
            <option value="<?= (int)$a['teacher_id'] ?>" <?= $student && $student['advisor_id'] == $a['teacher_id'] ? 'selected' : '' ?>>
              <?= h($a['first_name'].' '.$a['last_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>

    <?php if ($action === 'add'): ?>
      <label>รหัสผ่าน *
        <input type="password" name="password" required minlength="6" placeholder="อย่างน้อย 6 ตัวอักษร">
        <small style="color: #666; display: block; margin-top: 4px;">ใช้อักษรตัวใหญ่ ตัวเล็ก และตัวเลขเพื่อความปลอดภัยสูงสุด</small>
      </label>
    <?php else: ?>
      <label>รหัสผ่านใหม่
        <input type="password" name="password" minlength="6" placeholder="เว้นว่างเพื่อเก็บรหัสเดิม">
        <small style="color: #666; display: block; margin-top: 4px;">ปล่อยว่างเพื่อไม่เปลี่ยนแปลง</small>
      </label>
    <?php endif; ?>

    <div class="actions">
      <a href="?" class="btn">ยกเลิก</a>
      <button class="btn btn-primary" type="submit">
        <i class="fas fa-save me-2"></i> <?= $action === 'add' ? 'เพิ่มนิสิต' : 'บันทึกการเปลี่ยนแปลง' ?>
      </button>
    </div>

  </form>
</div>

<?php }


