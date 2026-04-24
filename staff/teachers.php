<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role(['staff']);

$page_title = 'จัดการอาจารย์';
require '../includes/header.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$errors = [];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add' || $action === 'edit') {
        $username = trim($_POST['username'] ?? '');
        $fname = trim($_POST['first_name'] ?? '');
        $lname = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$username) $errors[] = 'กรุณากรอกชื่อผู้ใช้';
        if (!$fname || !$lname) $errors[] = 'กรุณากรอกชื่อ-นามสกุล';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'อีเมลไม่ถูกต้อง';

        if ($action === 'add') {
            if (!$password || strlen($password) < 6) $errors[] = 'รหัสผ่านต้องอย่างน้อย 6 ตัวอักษร';
        }

        if (!$errors) {
            if ($action === 'add') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare('INSERT INTO teacher (username, first_name, last_name, email, phone, department, password) VALUES (?,?,?,?,?,?,?)');
                $stmt->bind_param('sssssss', $username, $fname, $lname, $email, $phone, $department, $hash);
                if ($stmt->execute()) {
                    $msg = 'เพิ่มอาจารย์สำเร็จ';
                    $action = 'list';
                } else {
                    $errors[] = $conn->error;
                }
                $stmt->close();
            } else {
                if ($password) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare('UPDATE teacher SET username=?, first_name=?, last_name=?, email=?, phone=?, department=?, password=? WHERE teacher_id=?');
                    $stmt->bind_param('sssssssi', $username, $fname, $lname, $email, $phone, $department, $hash, $id);
                } else {
                    $stmt = $conn->prepare('UPDATE teacher SET username=?, first_name=?, last_name=?, email=?, phone=?, department=? WHERE teacher_id=?');
                    $stmt->bind_param('ssssssi', $username, $fname, $lname, $email, $phone, $department, $id);
                }
                if ($stmt->execute()) {
                    $msg = 'แก้ไขอาจารย์สำเร็จ';
                    $action = 'list';
                } else {
                    $errors[] = $conn->error;
                }
                $stmt->close();
            }
        }
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare('DELETE FROM teacher WHERE teacher_id=?');
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $msg = 'ลบอาจารย์สำเร็จ';
        } else {
            $errors[] = $conn->error;
        }
        $stmt->close();
        $action = 'list';
    }
}

if ($action === 'list') {
    $teachers = $conn->query('SELECT * FROM teacher ORDER BY first_name')->fetch_all(MYSQLI_ASSOC);
    ?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
  <h1><i class="fas fa-chalkboard-user me-2"></i>จัดการอาจารย์</h1>
  <div style="display: flex; gap: 10px;">
    <a href="?action=add" class="btn btn-primary"><i class="fas fa-user-plus me-1"></i>เพิ่มอาจารย์ใหม่</a>
    <a href="supervision.php" class="btn btn-secondary"><i class="fas fa-clipboard-check me-1"></i>ดูรายการบันทึกนิเทศ</a>
  </div>
</div>

<?php if ($msg): ?>
  <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= h($msg) ?></div>
<?php endif; ?>

<?php if (!$teachers): ?>
  <p class="muted">ยังไม่มีอาจารย์</p>
<?php else: ?>
  <div class="card card-table">
    <table class="tbl">
      <thead>
        <tr><th>ชื่อผู้ใช้</th><th>ชื่อ-นามสกุล</th><th>อีเมล</th><th>สาขา/แผนก</th><th>เบอร์โทร</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($teachers as $t): ?>
          <tr>
            <td><code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px;"><?= h($t['username']) ?></code></td>
            <td><strong><?= h($t['first_name'].' '.$t['last_name']) ?></strong></td>
            <td><?= h($t['email']) ?></td>
            <td><?= h($t['department']) ?></td>
            <td><?= h($t['phone']) ?></td>
            <td style="text-align: right; gap: 8px;">
              <a href="?action=edit&id=<?= (int)$t['teacher_id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit me-1"></i>แก้ไข</a>
              <a href="?action=delete&id=<?= (int)$t['teacher_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('ต้องการลบ?')"><i class="fas fa-trash me-1"></i>ลบ</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif;

} elseif ($action === 'add' || $action === 'edit') {
    $teacher = null;
    if ($action === 'edit') {
        $stmt = $conn->prepare('SELECT * FROM teacher WHERE teacher_id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $teacher = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!$teacher) {
            echo '<p class="alert alert-error">ไม่พบอาจารย์นี้</p>';
            exit;
        }
    }
    ?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
  <h1><i class="fas fa-chalkboard-user me-2"></i><?= $action === 'add' ? 'เพิ่มอาจารย์ใหม่' : 'แก้ไขอาจารย์' ?></h1>
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
    <!-- Username Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-user-secret me-2" style="color: #c4122d;"></i>ชื่อผู้ใช้</h5>
      <div class="form-group">
        <label style="font-weight: 500;">ชื่อผู้ใช้ <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
        <input type="text" name="username" required value="<?= $teacher ? h($teacher['username']) : '' ?>" placeholder="เช่น teacher_001" style="border-radius: 6px;">
        <small style="color: #666; margin-top: 6px; display: block;">ใช้ในการเข้าสู่ระบบ</small>
      </div>
    </div>

    <!-- Personal Information Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-user me-2" style="color: #c4122d;"></i>ข้อมูลส่วนตัว</h5>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group">
          <label style="font-weight: 500;">ชื่อ <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
          <input type="text" name="first_name" required value="<?= $teacher ? h($teacher['first_name']) : '' ?>" style="border-radius: 6px;">
        </div>
        <div class="form-group">
          <label style="font-weight: 500;">นามสกุล <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
          <input type="text" name="last_name" required value="<?= $teacher ? h($teacher['last_name']) : '' ?>" style="border-radius: 6px;">
        </div>
      </div>
    </div>

    <!-- Contact Information Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-envelope me-2" style="color: #c4122d;"></i>ข้อมูลติดต่อ</h5>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group">
          <label style="font-weight: 500;">อีเมล <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
          <input type="email" name="email" required value="<?= $teacher ? h($teacher['email']) : '' ?>" style="border-radius: 6px;">
        </div>
        <div class="form-group">
          <label style="font-weight: 500;">เบอร์โทร</label>
          <input type="text" name="phone" value="<?= $teacher ? h($teacher['phone']) : '' ?>" placeholder="เช่น 089-xxx-xxxx" style="border-radius: 6px;">
        </div>
      </div>
    </div>

    <!-- Department Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-briefcase me-2" style="color: #c4122d;"></i>สาขา/แผนก</h5>
      <div class="form-group">
        <label style="font-weight: 500;">สาขา/แผนก</label>
        <input type="text" name="department" value="<?= $teacher ? h($teacher['department']) : '' ?>" placeholder="เช่น วิทยาการคอมพิวเตอร์" style="border-radius: 6px;">
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
      <button type="submit" class="btn btn-primary" style="flex: 1;"><i class="fas fa-save me-2"></i><?= $action === 'add' ? 'เพิ่มอาจารย์' : 'บันทึกการเปลี่ยนแปลง' ?></button>
      <a href="?" class="btn btn-secondary" style="flex: 1; text-align: center;"><i class="fas fa-times me-2"></i>ยกเลิก</a>
    </div>
  </form>
</div>

<?php }

require '../includes/footer.php';
?>
