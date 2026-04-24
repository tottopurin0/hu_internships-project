<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/db_connect.php';

$errors = [];
$msg = '';
$old = [
    'student_code' => '', 'first_name' => '', 'last_name' => '',
    'email' => '', 'phone' => '', 'faculty' => '', 'major' => '',
    'year_level' => '', 'gpa' => '', 'advisor_id' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($old as $k => $_) $old[$k] = trim($_POST[$k] ?? '');
    $password  = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (!preg_match('/^\d{5,20}$/', $old['student_code'])) $errors[] = 'รหัสนิสิตต้องเป็นตัวเลข 5–20 หลัก';
    if ($old['first_name'] === '' || $old['last_name'] === '') $errors[] = 'กรุณากรอกชื่อ-นามสกุล';
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'อีเมลไม่ถูกต้อง';
    if (strlen($password) < 6) $errors[] = 'รหัสผ่านต้องอย่างน้อย 6 ตัวอักษร';
    if ($password !== $password2) $errors[] = 'รหัสผ่านยืนยันไม่ตรงกัน';
    if ($old['year_level'] !== '' && !ctype_digit($old['year_level'])) $errors[] = 'ชั้นปีไม่ถูกต้อง';
    if ($old['gpa'] !== '' && !is_numeric($old['gpa'])) $errors[] = 'GPA ไม่ถูกต้อง';

    if (!$errors) {
        $stmt = $conn->prepare('SELECT 1 FROM student WHERE student_code = ?');
        $stmt->bind_param('s', $old['student_code']);
        $stmt->execute();
        if ($stmt->get_result()->fetch_row()) $errors[] = 'รหัสนิสิตนี้ลงทะเบียนแล้ว';
        $stmt->close();
    }

    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $gpa  = $old['gpa'] !== '' ? (float)$old['gpa'] : null;
        $adv  = $old['advisor_id'] !== '' ? (int)$old['advisor_id'] : null;

        $stmt = $conn->prepare(
            'INSERT INTO student (student_code, password, first_name, last_name, email, phone, faculty, major, gpa, advisor_id)
             VALUES (?,?,?,?,?,?,?,?,?,?)'
        );
        $stmt->bind_param(
            'ssssssssdi',
            $old['student_code'], $hash, $old['first_name'], $old['last_name'],
            $old['email'], $old['phone'], $old['faculty'], $old['major'],
            $gpa, $adv
        );
        if ($stmt->execute()) {
            $msg = 'สมัครสมาชิกสำเร็จ! ใช้รหัสนิสิต ' . h($old['student_code']) . ' เข้าสู่ระบบได้ทันที';
            $old = array_fill_keys(array_keys($old), '');
        } else {
            $errors[] = 'เกิดข้อผิดพลาด: ' . $conn->error;
        }
        $stmt->close();
    }
}

$teachers = $conn->query('SELECT teacher_id, first_name, last_name, department FROM teacher ORDER BY first_name')->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ลงทะเบียนนิสิต | HU Internships</title>
  <?php include __DIR__ . '/includes/public_head.php'; ?>
  <style>
    .reg-wrapper { max-width: 860px; margin: 48px auto; padding: 0 16px; }
    .reg-head { text-align:center; margin-bottom: 28px; }
    .reg-icon-circle {
      width: 80px; height: 80px; border-radius: 50%;
      background: linear-gradient(135deg, var(--swu-red), var(--swu-red-dark));
      color:#fff; display:flex; align-items:center; justify-content:center;
      font-size: 32px; margin: 0 auto 14px;
      box-shadow: 0 8px 20px rgba(196,18,45,.3);
    }
    .reg-head h1 { color: var(--swu-red); font-weight: 800; margin: 0 0 6px; font-size: 28px; }
    .reg-head p { color:#666; margin:0; }
    .reg-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 18px; }
    @media (max-width: 640px) { .reg-grid { grid-template-columns: 1fr; } }
    .reg-grid .full { grid-column: 1 / -1; }
    .form-field label { display:block; font-weight:600; margin-bottom:6px; color:#333; font-size: 14px; }
    .form-field .req { color: var(--swu-red); }
    .form-field input, .form-field select {
      width:100%; padding: 10px 12px; border:1px solid #ddd; border-radius: 8px;
      font-family: inherit; font-size: 15px; transition: border-color .2s;
    }
    .form-field input:focus, .form-field select:focus { outline: none; border-color: var(--swu-red); box-shadow: 0 0 0 3px rgba(196,18,45,.1); }
    .actions { margin-top: 22px; display:flex; justify-content: space-between; align-items:center; flex-wrap: wrap; gap:10px; }
    .back-link { color:#666; text-decoration:none; font-size: 14px; }
    .back-link:hover { color: var(--swu-red); }
  </style>
</head>
<body class="bg-light">
<?php include __DIR__ . '/includes/public_nav.php'; ?>

<div class="reg-wrapper">
  <div class="reg-head">
    <div class="reg-icon-circle"><i class="fas fa-user-plus"></i></div>
    <h1>ลงทะเบียนนิสิตใหม่</h1>
    <p>กรอกข้อมูลให้ครบถ้วนเพื่อสร้างบัญชีผู้ใช้นิสิต</p>
  </div>

  <?php if ($msg): ?>
    <div class="alert alert-success">
      <i class="fas fa-check-circle me-2"></i><?= $msg ?>
      <div style="margin-top:10px"><a href="/login.php" class="btn btn-primary btn-sm"><i class="fas fa-sign-in-alt me-1"></i> ไปหน้าเข้าสู่ระบบ</a></div>
    </div>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="alert alert-error">
      <i class="fas fa-exclamation-circle me-2"></i>
      <strong>พบข้อผิดพลาด:</strong>
      <ul style="margin: 6px 0 0 22px; padding:0;">
        <?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="card card-form">
    <div class="card-header">
      <h2><i class="fas fa-id-card me-2"></i>ข้อมูลนิสิต</h2>
    </div>

    <form method="POST" class="form">
      <div class="reg-grid">
        <div class="form-field">
          <label>รหัสนิสิต <span class="req">*</span></label>
          <input type="text" name="student_code" required value="<?= h($old['student_code']) ?>" placeholder="เช่น 65001001">
        </div>
        <div class="form-field">
          <label>อีเมล <span class="req">*</span></label>
          <input type="email" name="email" required value="<?= h($old['email']) ?>" placeholder="student@hu.ac.th">
        </div>

        <div class="form-field">
          <label>ชื่อ <span class="req">*</span></label>
          <input type="text" name="first_name" required value="<?= h($old['first_name']) ?>">
        </div>
        <div class="form-field">
          <label>นามสกุล <span class="req">*</span></label>
          <input type="text" name="last_name" required value="<?= h($old['last_name']) ?>">
        </div>

        <div class="form-field">
          <label>เบอร์โทร</label>
          <input type="text" name="phone" value="<?= h($old['phone']) ?>" placeholder="08x-xxx-xxxx">
        </div>
        <div class="form-field">
          <label>ชั้นปี</label>
          <select name="year_level">
            <option value="">-- เลือกชั้นปี --</option>
            <?php for ($i=1;$i<=6;$i++): ?>
              <option value="<?= $i ?>" <?= $old['year_level']==$i?'selected':'' ?>>ปี <?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="form-field">
          <label>คณะ</label>
          <input type="text" name="faculty" value="<?= h($old['faculty']) ?>" placeholder="เช่น วิทยาการคอมพิวเตอร์">
        </div>
        <div class="form-field">
          <label>สาขา</label>
          <input type="text" name="major" value="<?= h($old['major']) ?>" placeholder="เช่น วิทยาการคอมพิวเตอร์">
        </div>

        <div class="form-field">
          <label>GPA</label>
          <input type="number" step="0.01" min="0" max="4" name="gpa" value="<?= h($old['gpa']) ?>" placeholder="เช่น 3.25">
        </div>
        <div class="form-field">
          <label>อาจารย์ที่ปรึกษา</label>
          <select name="advisor_id">
            <option value="">-- เลือกอาจารย์ที่ปรึกษา --</option>
            <?php foreach ($teachers as $t): ?>
              <option value="<?= (int)$t['teacher_id'] ?>" <?= $old['advisor_id']==$t['teacher_id']?'selected':'' ?>>
                อ.<?= h($t['first_name'].' '.$t['last_name']) ?> — <?= h($t['department']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-field">
          <label>รหัสผ่าน <span class="req">*</span></label>
          <input type="password" name="password" required minlength="6" placeholder="อย่างน้อย 6 ตัวอักษร">
        </div>
        <div class="form-field">
          <label>ยืนยันรหัสผ่าน <span class="req">*</span></label>
          <input type="password" name="password2" required minlength="6">
        </div>
      </div>

      <div class="actions">
        <a class="back-link" href="portal.php"><i class="fas fa-arrow-left me-1"></i> กลับไปหน้า Portal</a>
        <button class="btn btn-primary" type="submit"><i class="fas fa-user-plus me-1"></i> สมัครสมาชิก</button>
      </div>
    </form>
  </div>
</div>

<?php include __DIR__ . '/includes/public_footer.php'; ?>
</body>
</html>
