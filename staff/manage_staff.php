<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role(['staff']);

$page_title = 'จัดการเจ้าหน้าที่';
require '../includes/header.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$errors = [];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add' || $action === 'edit') {
        $fname = trim($_POST['first_name'] ?? '');
        $lname = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$fname || !$lname) $errors[] = 'กรุณากรอกชื่อ-นามสกุล';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'อีเมลไม่ถูกต้อง';

        if ($action === 'add') {
            if (!$password || strlen($password) < 6) $errors[] = 'รหัสผ่านต้องอย่างน้อย 6 ตัวอักษร';
        }

        if (!$errors) {
            if ($action === 'add') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare('INSERT INTO faculty_staff (first_name, last_name, email, phone, position, password) VALUES (?,?,?,?,?,?)');
                $stmt->bind_param('ssssss', $fname, $lname, $email, $phone, $position, $hash);
                if ($stmt->execute()) {
                    $msg = 'เพิ่มเจ้าหน้าที่สำเร็จ';
                    $action = 'list';
                } else {
                    $errors[] = $conn->error;
                }
                $stmt->close();
            } else {
                if ($password) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare('UPDATE faculty_staff SET first_name=?, last_name=?, email=?, phone=?, position=?, password=? WHERE faculty_staff_id=?');
                    $stmt->bind_param('ssssssi', $fname, $lname, $email, $phone, $position, $hash, $id);
                } else {
                    $stmt = $conn->prepare('UPDATE faculty_staff SET first_name=?, last_name=?, email=?, phone=?, position=? WHERE faculty_staff_id=?');
                    $stmt->bind_param('sssssi', $fname, $lname, $email, $phone, $position, $id);
                }
                if ($stmt->execute()) {
                    $msg = 'แก้ไขเจ้าหน้าที่สำเร็จ';
                    $action = 'list';
                } else {
                    $errors[] = $conn->error;
                }
                $stmt->close();
            }
        }
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare('DELETE FROM faculty_staff WHERE faculty_staff_id=?');
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $msg = 'ลบเจ้าหน้าที่สำเร็จ';
        } else {
            $errors[] = $conn->error;
        }
        $stmt->close();
        $action = 'list';
    }
}

if ($action === 'list') {
    $staff_list = $conn->query('SELECT * FROM faculty_staff ORDER BY first_name')->fetch_all(MYSQLI_ASSOC);
    ?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
  <h1><i class="fas fa-id-badge me-2" style="margin-right: 10px;"></i>จัดการเจ้าหน้าที่</h1>
  <a href="?action=add" class="btn btn-primary"><i class="fas fa-user-plus me-1" style="margin-right: 10px;"></i>เพิ่มเจ้าหน้าที่ใหม่</a>
</div>

<?php if ($msg): ?>
  <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= h($msg) ?></div>
<?php endif; ?>

<?php if (!$staff_list): ?>
  <p class="muted">ยังไม่มีเจ้าหน้าที่</p>
<?php else: ?>
  <div class="card card-table">
    <table class="tbl">
      <thead>
        <tr><th>ชื่อ-นามสกุล</th><th>อีเมล</th><th>ตำแหน่ง</th><th>เบอร์โทร</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($staff_list as $s): ?>
          <tr>
            <td><strong><?= h($s['first_name'].' '.$s['last_name']) ?></strong></td>
            <td><?= h($s['email']) ?></td>
            <td><?= h($s['position']) ?></td>
            <td><?= h($s['phone']) ?></td>
            <td style="text-align: right; gap: 8px;">
              <a href="?action=edit&id=<?= (int)$s['faculty_staff_id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit me-1" style="margin-right: 10px;"></i>แก้ไข</a>
              <a href="?action=delete&id=<?= (int)$s['faculty_staff_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('ต้องการลบ?')"><i class="fas fa-trash me-1" style="margin-right: 10px;"></i>ลบ</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif;

} elseif ($action === 'add' || $action === 'edit') {
    $staff = null;
    if ($action === 'edit') {
        $stmt = $conn->prepare('SELECT * FROM faculty_staff WHERE faculty_staff_id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $staff = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!$staff) {
            echo '<p class="alert alert-error">ไม่พบเจ้าหน้าที่นี้</p>';
            exit;
        }
    }
    ?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
  <h1><i class="fas fa-id-badge me-2"></i><?= $action === 'add' ? 'เพิ่มเจ้าหน้าที่ใหม่' : 'แก้ไขเจ้าหน้าที่' ?></h1>
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
    <!-- Personal Information Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-user me-2" style="color: #c4122d;"></i>ข้อมูลส่วนตัว</h5>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group">
          <label style="font-weight: 500;">ชื่อ <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
          <input type="text" name="first_name" required value="<?= $staff ? h($staff['first_name']) : '' ?>" style="border-radius: 6px;">
        </div>
        <div class="form-group">
          <label style="font-weight: 500;">นามสกุล <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
          <input type="text" name="last_name" required value="<?= $staff ? h($staff['last_name']) : '' ?>" style="border-radius: 6px;">
        </div>
      </div>
    </div>

    <!-- Contact Information Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-envelope me-2" style="color: #c4122d;"></i>ข้อมูลติดต่อ</h5>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div class="form-group">
          <label style="font-weight: 500;">อีเมล <span class="req" style="color: #c4122d; font-weight: bold;">*</span></label>
          <input type="email" name="email" required value="<?= $staff ? h($staff['email']) : '' ?>" style="border-radius: 6px;">
        </div>
        <div class="form-group">
          <label style="font-weight: 500;">เบอร์โทร</label>
          <input type="text" name="phone" value="<?= $staff ? h($staff['phone']) : '' ?>" placeholder="เช่น 089-xxx-xxxx" style="border-radius: 6px;">
        </div>
      </div>
    </div>

    <!-- Position Section -->
    <div style="border-bottom: 1px solid #e0e0e0; padding-bottom: 20px; margin-bottom: 20px;">
      <h5 style="color: #333; margin-bottom: 16px; font-weight: 600;"><i class="fas fa-briefcase me-2" style="color: #c4122d;"></i>ตำแหน่ง</h5>
      <div class="form-group">
        <label style="font-weight: 500;">ตำแหน่ง</label>
        <input type="text" name="position" value="<?= $staff ? h($staff['position']) : '' ?>" placeholder="เช่น เจ้าหน้าที่ประสานงาน" style="border-radius: 6px;">
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
      <button type="submit" class="btn btn-primary" style="flex: 1;"><i class="fas fa-save me-2"></i><?= $action === 'add' ? 'เพิ่มเจ้าหน้าที่' : 'บันทึกการเปลี่ยนแปลง' ?></button>
      <a href="?" class="btn btn-secondary" style="flex: 1; text-align: center;"><i class="fas fa-times me-2"></i>ยกเลิก</a>
    </div>
  </form>
</div>

<?php }