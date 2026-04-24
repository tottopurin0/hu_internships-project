<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// =====================================================
// One-time setup: generates bcrypt hashes for all seed
// accounts so you can log in with password123.
// Run this ONCE after importing internships.sql, then
// delete the file (or leave it — it will refuse to run
// again if hashes already look valid).
// =====================================================

require_once __DIR__ . '/includes/db_connect.php';

$DEFAULT_PASSWORD = 'password123';
$hash = password_hash($DEFAULT_PASSWORD, PASSWORD_DEFAULT);

$tables = [
    'student'        => 'student_code',
    'teacher'        => 'username',
    'faculty_staff'  => 'username',
];

$updated = [];
$skipped = [];

foreach ($tables as $table => $key_col) {
    $sql = "SELECT $key_col AS ident, password FROM $table";
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) {
        if (strpos($row['password'], '$2y$') === 0) {
            $skipped[] = "$table:{$row['ident']}";
            continue;
        }
        $new_hash = password_hash($DEFAULT_PASSWORD, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE $table SET password = ? WHERE $key_col = ?");
        $stmt->bind_param('ss', $new_hash, $row['ident']);
        $stmt->execute();
        $stmt->close();
        $updated[] = "$table:{$row['ident']}";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>Setup | HU Internships</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
  <div class="login-card" style="max-width:640px">
    <h1>✅ Setup เสร็จสิ้น</h1>
    <p>ตั้งรหัสผ่านเริ่มต้นให้ผู้ใช้ทุกคนเป็น: <code><?= h($DEFAULT_PASSWORD) ?></code></p>

    <h3>อัปเดต (<?= count($updated) ?>)</h3>
    <ul><?php foreach ($updated as $u): ?><li><?= h($u) ?></li><?php endforeach; ?></ul>

    <?php if ($skipped): ?>
      <h3>ข้าม — มี hash แล้ว (<?= count($skipped) ?>)</h3>
      <ul><?php foreach ($skipped as $s): ?><li><?= h($s) ?></li><?php endforeach; ?></ul>
    <?php endif; ?>

    <p class="alert alert-warning">
      ⚠️ ลบไฟล์ <code>setup.php</code> ออกจาก server หลังใช้เสร็จเพื่อความปลอดภัย
    </p>

    <a class="btn btn-primary" href="login.php">ไปยังหน้า Login →</a>
  </div>
</body>
</html>
