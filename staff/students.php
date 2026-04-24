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
                $stmt->bind_param('ssssssssdi', $code, $hash, $fname, $lname, $email, $phone, $faculty, $major, $gpa_val, $adv_val);
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
                    $stmt->bind_param('ssssssdi', $fname, $lname, $email, $phone, $faculty, $major, $gpa_val, $adv_val, $id);
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
  <h1><i class="fas fa-users me-2"></i>จัดการนิสิต</h1>
  <a href="?action=add" class="btn btn-primary"><i class="fas fa-user-plus me-1"></i>เพิ่มนิสิตใหม่</a>
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
              <a href="?action=edit&id=<?= (int)$s['student_id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit me-1"></i>แก้ไข</a>
              <a href="?action=delete&id=<?= (int)$s['student_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('ต้องการลบ?')"><i class="fas fa-trash me-1"></i>ลบ</a>
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
  <h1><i class="fas fa-users me-2"></i><?= $action === 'add' ? 'เพิ่มนิสิตใหม่' : 'แก้ไขนิสิต' ?></h1>
</div>

<?php if ($errors): ?>
  <div class="alert alert-error" style="margin-bottom: 20px;">
    <strong><i class="fas fa-exclamation-circle me-2"></i>พบข้อผิดพลาด:</strong>
    <ul style="margin-bottom: 0;">
      <?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="card card-form" style="max-width: 700px;">
  <form method="POST">
    <!-- Student ID Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-id-card me-2" style="color: #c4122d;"></i>รหัสนิสิต</h5>
      <div class="form-group">
        <label style="font-weight: 500;">รหัสนิสิต <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
        <input type="text" name="student_code" required value="<?= $student ? h($student['student_code']) : '' ?>" <?= $action === 'edit' ? 'readonly' : '' ?> placeholder="เช่น 6610501234" style="border-radius: 6px;">
        <small style="color: #666; margin-top: 6px; display: block;">ต้องเป็นตัวเลข 5–20 หลัก <?= $action === 'edit' ? '(ไม่สามารถแก้ไขได้)' : '' ?></small>
      </div>
    </div>

    <!-- Personal Information Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-user me-2" style="color: #c4122d;"></i>ข้อมูลส่วนตัว</h5>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group">
          <label style="font-weight: 500;">ชื่อ <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
          <input type="text" name="first_name" required value="<?= $student ? h($student['first_name']) : '' ?>" style="border-radius: 6px;">
        </div>
        <div class="form-group">
          <label style="font-weight: 500;">นามสกุล <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
          <input type="text" name="last_name" required value="<?= $student ? h($student['last_name']) : '' ?>" style="border-radius: 6px;">
        </div>
      </div>
    </div>

    <!-- Contact Information Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-envelope me-2" style="color: #c4122d;"></i>ข้อมูลติดต่อ</h5>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group">
          <label style="font-weight: 500;">อีเมล <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
          <input type="email" name="email" required value="<?= $student ? h($student['email']) : '' ?>" style="border-radius: 6px;">
        </div>
        <div class="form-group">
          <label style="font-weight: 500;">เบอร์โทร</label>
          <input type="text" name="phone" value="<?= $student ? h($student['phone']) : '' ?>" placeholder="เช่น 089-xxx-xxxx" style="border-radius: 6px;">
        </div>
      </div>
    </div>

    <!-- Academic Information Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-graduation-cap me-2" style="color: #c4122d;"></i>ข้อมูลการศึกษา</h5>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group">
          <label style="font-weight: 500;">คณะ</label>
          <input type="text" name="faculty" value="<?= $student ? h($student['faculty']) : '' ?>" placeholder="เช่น วิทยาศาสตร์" style="border-radius: 6px;">
        </div>
        <div class="form-group">
          <label style="font-weight: 500;">สาขา</label>
          <input type="text" name="major" value="<?= $student ? h($student['major']) : '' ?>" placeholder="เช่น วิทยาการคอมพิวเตอร์" style="border-radius: 6px;">
        </div>
      </div>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 16px;">
        <div class="form-group">
          <label style="font-weight: 500;">GPA</label>
          <input type="number" step="0.01" min="0" max="4" name="gpa" value="<?= $student ? h($student['gpa']) : '' ?>" placeholder="0.00 - 4.00" style="border-radius: 6px;">
        </div>
        <div class="form-group">
          <label style="font-weight: 500;">อาจารย์ที่ปรึกษา</label>
          <select name="advisor_id" style="border-radius: 6px;">
            <option value="">— ไม่มี —</option>
            <?php foreach ($advisors as $a): ?>
              <option value="<?= (int)$a['teacher_id'] ?>" <?= $student && $student['advisor_id'] == $a['teacher_id'] ? 'selected' : '' ?>>
                <?= h($a['first_name'].' '.$a['last_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>

    <!-- Security Section -->
    <div style="padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-lock me-2" style="color: #c4122d;"></i>ความปลอดภัย</h5>
      <?php if ($action === 'add'): ?>
        <div class="form-group">
          <label style="font-weight: 500;">รหัสผ่าน <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
          <input type="password" name="password" required minlength="6" placeholder="อย่างน้อย 6 ตัวอักษร" style="border-radius: 6px;">
          <small style="color: #666; margin-top: 6px; display: block;">ใช้อักษรตัวใหญ่ ตัวเล็ก และตัวเลขเพื่อความปลอดภัยสูงสุด</small>
        </div>
      <?php else: ?>
        <div class="form-group">
          <label style="font-weight: 500;">รหัสผ่านใหม่</label>
          <input type="password" name="password" minlength="6" placeholder="เว้นว่างเพื่อเก็บรหัสเดิม" style="border-radius: 6px;">
          <small style="color: #666; margin-top: 6px; display: block;">ปล่อยว่างเพื่อไม่เปลี่ยนแปลง</small>
        </div>
      <?php endif; ?>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
      <button type="submit" class="btn btn-primary" style="flex: 1;"><i class="fas fa-save me-2"></i><?= $action === 'add' ? 'เพิ่มนิสิต' : 'บันทึกการเปลี่ยนแปลง' ?></button>
      <a href="?" class="btn btn-secondary" style="flex: 1; text-align: center;"><i class="fas fa-times me-2"></i>ยกเลิก</a>
    </div>
  </form>
</div>

<?php }

require '../includes/footer.php';
?>
