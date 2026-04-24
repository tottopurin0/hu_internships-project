<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role(['staff']);

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = (int)($_POST['company_id'] ?? 0);
    $name = trim($_POST['company_name'] ?? '');
    $type = trim($_POST['company_type'] ?? '');
    $addr = trim($_POST['address']      ?? '');
    $prov = trim($_POST['province']     ?? '');
    $cp   = trim($_POST['contact_person'] ?? '');
    $ph   = trim($_POST['contact_phone']  ?? '');
    $em   = trim($_POST['contact_email']  ?? '');
    $web  = trim($_POST['website']        ?? '');
    $status = isset($_POST['is_active']) ? 'active' : 'inactive';

    if ($name === '') {
        $err = 'กรุณาระบุชื่อบริษัท';
    } else {
        if ($id > 0) {
            $stmt = $conn->prepare(
                'UPDATE company SET company_name=?, industry=?, address=?, province=?,
                    contact_person_name=?, contact_person_phone=?, contact_person_email=?, website=?, status=?
                 WHERE company_id=?'
            );
            $stmt->bind_param('sssssssssi', $name, $type, $addr, $prov, $cp, $ph, $em, $web, $status, $id);
            $stmt->execute();
            $stmt->close();
            $msg = 'อัปเดตข้อมูลบริษัทเรียบร้อย';
        } else {
            $stmt = $conn->prepare(
                'INSERT INTO company
                  (company_name, industry, address, province,
                   contact_person_name, contact_person_phone, contact_person_email, website, status)
                 VALUES (?,?,?,?,?,?,?,?,?)'
            );
            $stmt->bind_param('sssssssss', $name, $type, $addr, $prov, $cp, $ph, $em, $web, $status);
            $stmt->execute();
            $stmt->close();
            $msg = 'เพิ่มบริษัทใหม่เรียบร้อย';
        }
    }
}

$edit = null;
if (!empty($_GET['edit'])) {
    $stmt = $conn->prepare(
        'SELECT company_id, company_name, industry AS company_type, address, province,
                contact_person_name AS contact_person, contact_person_phone AS contact_phone,
                contact_person_email AS contact_email, website,
                (status = "active") AS is_active
         FROM company WHERE company_id = ?'
    );
    $eid = (int)$_GET['edit'];
    $stmt->bind_param('i', $eid);
    $stmt->execute();
    $edit = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$rows = $conn->query(
    'SELECT company_id, company_name, industry AS company_type, province,
            contact_person_name AS contact_person, contact_person_phone AS contact_phone,
            (status = "active") AS is_active
     FROM company ORDER BY company_name'
)->fetch_all(MYSQLI_ASSOC);

$page_title = 'จัดการบริษัท';
require '../includes/header.php';
?>

<h1><i class="fas fa-building me-2" style="color:var(--swu-red)"></i>จัดการบริษัทคู่สัญญา</h1>

<?php if ($msg): ?><div class="alert alert-success"><i class="fas fa-check me-2"></i><?= h($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert-error"><i class="fas fa-exclamation-circle me-2"></i><?= h($err) ?></div><?php endif; ?>

<div class="card card-form">
  <div class="card-header"><h2><i class="fas fa-<?= $edit?'pen':'plus' ?>-circle me-2"></i><?= $edit ? 'แก้ไขบริษัท #'.(int)$edit['company_id'] : 'เพิ่มบริษัทใหม่' ?></h2></div>
  <form method="POST" class="form" style="padding:24px">
    <input type="hidden" name="company_id" value="<?= (int)($edit['company_id'] ?? 0) ?>">
    <label>ชื่อบริษัท *
      <input type="text" name="company_name" required value="<?= h($edit['company_name'] ?? '') ?>">
    </label>
    <div class="row">
      <label>ประเภทธุรกิจ
        <input type="text" name="company_type" value="<?= h($edit['company_type'] ?? '') ?>">
      </label>
      <label>จังหวัด
        <input type="text" name="province" value="<?= h($edit['province'] ?? '') ?>">
      </label>
    </div>
    <label>ที่อยู่
      <textarea name="address" rows="2"><?= h($edit['address'] ?? '') ?></textarea>
    </label>
    <div class="row">
      <label>ผู้ติดต่อ
        <input type="text" name="contact_person" value="<?= h($edit['contact_person'] ?? '') ?>">
      </label>
      <label>โทร
        <input type="text" name="contact_phone" value="<?= h($edit['contact_phone'] ?? '') ?>">
      </label>
    </div>
    <div class="row">
      <label>อีเมล
        <input type="email" name="contact_email" value="<?= h($edit['contact_email'] ?? '') ?>">
      </label>
      <label>เว็บไซต์
        <input type="url" name="website" value="<?= h($edit['website'] ?? '') ?>">
      </label>
    </div>
    <label class="inline">
      <input type="checkbox" name="is_active" value="1"
        <?= (!$edit || (int)$edit['is_active'] === 1) ? 'checked' : '' ?>>
      เปิดใช้งาน (ให้นิสิตเลือกได้)
    </label>
    <div class="actions">
      <?php if ($edit): ?><a href="companies.php" class="btn">ยกเลิก</a><?php endif; ?>
      <button class="btn btn-primary" type="submit"><?= $edit ? 'บันทึกการแก้ไข' : 'เพิ่มบริษัท' ?></button>
    </div>
  </form>
</div>

<div class="card card-table">
  <div class="card-header"><h2><i class="fas fa-list-ul me-2"></i>รายการบริษัท (<?= count($rows) ?>)</h2></div>
  <?php if (!$rows): ?>
    <p class="muted">ยังไม่มีบริษัท</p>
  <?php else: ?>
    <table class="tbl">
      <thead><tr><th>ID</th><th>ชื่อ</th><th>ประเภท</th><th>จังหวัด</th><th>ผู้ติดต่อ</th><th>สถานะ</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($rows as $c): ?>
          <tr>
            <td><?= (int)$c['company_id'] ?></td>
            <td><?= h($c['company_name']) ?></td>
            <td><?= h($c['company_type']) ?></td>
            <td><?= h($c['province']) ?></td>
            <td><?= h($c['contact_person']) ?> <?= h($c['contact_phone']) ?></td>
            <td>
              <?php if ((int)$c['is_active'] === 1): ?>
                <span class="badge badge-approved">Active</span>
              <?php else: ?>
                <span class="badge badge-rejected">Inactive</span>
              <?php endif; ?>
            </td>
            <td><a href="?edit=<?= (int)$c['company_id'] ?>">แก้ไข</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php require '../includes/footer.php'; ?>
