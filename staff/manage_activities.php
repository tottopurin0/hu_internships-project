<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role(['staff', 'teacher']);

$action = $_GET['action'] ?? 'list';
$id     = (int)($_GET['id'] ?? 0);
$errors = [];
$msg    = '';

$categories = [
  'showcase' => 'ผลงาน',
  'academic' => 'วิชาการ',
  'student'  => 'กิจกรรมนิสิต',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $desc  = trim($_POST['description'] ?? '');
    $day   = trim($_POST['day'] ?? '');
    $month = trim($_POST['month'] ?? '');
    $image_file = '';

    if (!$title) $errors[] = 'กรุณากรอกชื่อกิจกรรม';
    if (!$desc)  $errors[] = 'กรุณากรอกรายละเอียด';
    if (!$category || !isset($categories[$category])) $errors[] = 'กรุณาเลือกหมวดหมู่';

    if (!$errors) {
        if ($action === 'add') {
            if (!empty($_FILES['image']['name'])) {
                $file = $_FILES['image'];
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $errors[] = 'เกิดข้อผิดพลาดในการอัปโหลด';
                } else {
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (!in_array($ext, $allowed)) {
                        $errors[] = 'อนุญาตเฉพาะไฟล์ jpg, png, gif, webp เท่านั้น';
                    } elseif ($file['size'] > 5 * 1024 * 1024) {
                        $errors[] = 'ขนาดไฟล์ต้องไม่เกิน 5 MB';
                    } else {
                        $image_file = bin2hex(random_bytes(8)) . '.' . $ext;
                        if (!move_uploaded_file($file['tmp_name'], '../assets/img/' . $image_file)) {
                            $errors[] = 'ไม่สามารถบันทึกไฟล์ได้';
                        }
                    }
                }
            }
            if (!$errors) {
                $stmt = $conn->prepare(
                    'INSERT INTO activities (category, title, description, day, month, image, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)'
                );
                $user_id = current_role() === 'teacher' ? current_user()['teacher_id'] : current_user()['staff_id'];
                $stmt->bind_param('ssssssi', $category, $title, $desc, $day, $month, $image_file, $user_id);
                if ($stmt->execute()) {
                    $msg = 'เพิ่มกิจกรรมสำเร็จแล้ว';
                    $action = 'list';
                } else {
                    $errors[] = 'เกิดข้อผิดพลาดในการบันทึก';
                }
                $stmt->close();
            }
        } elseif ($action === 'edit' && $id > 0) {
            $stmt = $conn->prepare('SELECT image FROM activities WHERE activity_id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!$row) {
                $errors[] = 'ไม่พบกิจกรรม';
            } else {
                $image_file = $row['image'];
                if (!empty($_FILES['image']['name'])) {
                    $file = $_FILES['image'];
                    if ($file['error'] !== UPLOAD_ERR_OK) {
                        $errors[] = 'เกิดข้อผิดพลาดในการอัปโหลด';
                    } else {
                        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        if (!in_array($ext, $allowed)) {
                            $errors[] = 'อนุญาตเฉพาะไฟล์ jpg, png, gif, webp เท่านั้น';
                        } elseif ($file['size'] > 5 * 1024 * 1024) {
                            $errors[] = 'ขนาดไฟล์ต้องไม่เกิน 5 MB';
                        } else {
                            $new_img = bin2hex(random_bytes(8)) . '.' . $ext;
                            if (move_uploaded_file($file['tmp_name'], '../assets/img/' . $new_img)) {
                                if ($row['image'] && file_exists('../assets/img/' . $row['image'])) {
                                    @unlink('../assets/img/' . $row['image']);
                                }
                                $image_file = $new_img;
                            } else {
                                $errors[] = 'ไม่สามารถบันทึกไฟล์ได้';
                            }
                        }
                    }
                }
                if (!$errors) {
                    $stmt = $conn->prepare(
                        'UPDATE activities SET category = ?, title = ?, description = ?, day = ?, month = ?, image = ? WHERE activity_id = ?'
                    );
                    $stmt->bind_param('ssssssи', $category, $title, $desc, $day, $month, $image_file, $id);
                    if ($stmt->execute()) {
                        $msg = 'อัปเดตกิจกรรมสำเร็จแล้ว';
                        $action = 'list';
                    } else {
                        $errors[] = 'เกิดข้อผิดพลาดในการบันทึก';
                    }
                    $stmt->close();
                }
            }
        }
    }
} elseif ($action === 'delete' && $id > 0) {
    $stmt = $conn->prepare('SELECT image FROM activities WHERE activity_id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($row && $row['image'] && file_exists('../assets/img/' . $row['image'])) {
        @unlink('../assets/img/' . $row['image']);
    }
    $stmt = $conn->prepare('DELETE FROM activities WHERE activity_id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $msg = 'ลบกิจกรรมสำเร็จแล้ว';
    $action = 'list';
}

if ($action === 'edit' && $id > 0 && empty($_POST)) {
    $stmt = $conn->prepare('SELECT * FROM activities WHERE activity_id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $edit = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$edit) {
        $action = 'list';
    }
}

$rows = $conn->query('SELECT * FROM activities ORDER BY sort_order DESC, created_at DESC')->fetch_all(MYSQLI_ASSOC);

$page_title = 'จัดการกิจกรรม';
require '../includes/header.php';
?>

<?php if ($msg): ?>
  <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= h($msg) ?></div>
<?php endif; ?>
<?php if ($errors): ?>
  <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= implode('<br>', array_map('h', $errors)) ?></div>
<?php endif; ?>

<?php if ($action === 'list'): ?>
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1><i class="fas fa-calendar-alt me-2" style="color: var(--swu-red);"></i> จัดการกิจกรรม</h1>
    <a class="btn btn-primary" href="?action=add"><i class="fas fa-plus me-1"></i> เพิ่มกิจกรรม</a>
  </div>

  <?php if (!$rows): ?>
    <p class="muted">ยังไม่มีกิจกรรม</p>
  <?php else: ?>
    <div class="card card-table">
      <table class="tbl">
        <thead>
          <tr><th>#</th><th>หมวดหมู่</th><th>รูปภาพ</th><th>ชื่อกิจกรรม</th><th>วันที่</th><th></th></tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $a): ?>
            <tr>
              <td><?= (int)$a['activity_id'] ?></td>
              <td><span class="badge" style="background-color: <?= $a['category'] === 'showcase' ? '#c4122d' : ($a['category'] === 'academic' ? '#0d6efd' : '#198754'); ?>"><?= h($categories[$a['category']] ?? $a['category']) ?></span></td>
              <td>
                <?php if (!empty($a['image'])): ?>
                  <img src="/assets/img/<?= h($a['image']) ?>" style="max-width: 50px; max-height: 50px; border-radius: 4px;">
                <?php else: ?>
                  <span class="muted">-</span>
                <?php endif; ?>
              </td>
              <td><strong><?= h(substr($a['title'], 0, 50)) ?></strong><?= strlen($a['title']) > 50 ? '...' : '' ?></td>
              <td><?= h($a['day'] ?? '') ?> <?= h($a['month'] ?? '') ?></td>
              <td>
                <a href="?action=edit&id=<?= (int)$a['activity_id'] ?>" class="btn btn-sm btn-secondary">แก้ไข</a>
                <a href="?action=delete&id=<?= (int)$a['activity_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('ลบกิจกรรมนี้ใช่หรือไม่?')">ลบ</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

<?php elseif ($action === 'add' || $action === 'edit'): ?>
  <h1><i class="fas fa-<?= $action === 'add' ? 'plus' : 'pen' ?> me-2" style="color: var(--swu-red);"></i> <?= $action === 'add' ? 'เพิ่มกิจกรรม' : 'แก้ไขกิจกรรม' ?></h1>

  <form method="POST" enctype="multipart/form-data" class="card" style="max-width: 600px; margin: 20px 0; padding: 20px;">
    <div class="form-group">
      <label>หมวดหมู่ <span style="color: red;">*</span></label>
      <select name="category" class="form-control" required>
        <option value="">-- เลือกหมวดหมู่ --</option>
        <?php foreach ($categories as $k => $v): ?>
          <option value="<?= h($k) ?>" <?= ($edit['category'] ?? '') === $k ? 'selected' : '' ?>><?= h($v) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label>ชื่อกิจกรรม <span style="color: red;">*</span></label>
      <input type="text" name="title" class="form-control" value="<?= h($edit['title'] ?? '') ?>" required>
    </div>

    <div class="form-group">
      <label>รายละเอียด <span style="color: red;">*</span></label>
      <textarea name="description" class="form-control" rows="5" required><?= h($edit['description'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
      <label>วัน (เช่น 23, 1-2, 2569)</label>
      <input type="text" name="day" class="form-control" value="<?= h($edit['day'] ?? '') ?>" placeholder="23">
    </div>

    <div class="form-group">
      <label>เดือน (เช่น ก.พ. 69)</label>
      <input type="text" name="month" class="form-control" value="<?= h($edit['month'] ?? '') ?>" placeholder="ก.พ. 69">
    </div>

    <div class="form-group">
      <label>รูปภาพ</label>
      <?php if ($action === 'edit' && !empty($edit['image'])): ?>
        <div style="margin-bottom: 10px;">
          <img src="/assets/img/<?= h($edit['image']) ?>" style="max-width: 150px; max-height: 150px; border-radius: 4px; display: block; margin-bottom: 10px;">
          <small class="muted">ไฟล์ปัจจุบัน: <?= h($edit['image']) ?></small>
        </div>
      <?php endif; ?>
      <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp" />
      <small class="muted">อนุญาต: JPG, PNG, GIF, WebP (สูงสุด 5 MB)</small>
    </div>

    <div style="display: flex; gap: 10px;">
      <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> บันทึก</button>
      <a href="?action=list" class="btn btn-secondary">ยกเลิก</a>
    </div>
  </form>

<?php endif; ?>

<?php require '../includes/footer.php'; ?>
