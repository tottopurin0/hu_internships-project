<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/auth.php';
if (is_logged_in()) {
    header('Location: index.php');
    exit;
}
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
$role = $_SESSION['login_role'] ?? 'student';
unset($_SESSION['login_role']);

// Fetch sample data for each role
$sample_students = $conn->query('SELECT student_code FROM student LIMIT 3')->fetch_all(MYSQLI_ASSOC);
$sample_teachers = $conn->query('SELECT username FROM teacher LIMIT 3')->fetch_all(MYSQLI_ASSOC);
$sample_staff = $conn->query('SELECT username FROM faculty_staff LIMIT 3')->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>เข้าสู่ระบบ | HU Internships</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .login-brand { display: flex; flex-direction: column; align-items: center; gap: 10px; margin-bottom: 18px; }
    .login-brand img { width: 84px; height: 84px; object-fit: contain; filter: drop-shadow(0 4px 10px rgba(0,0,0,.1)); }
    .login-brand h1 { color: #c4122d; font-weight: 800; font-size: 22px; margin: 0; letter-spacing: .3px; }
    .login-brand .en { font-size: 11px; color: #888; font-weight: 600; letter-spacing: 1.5px; margin: 0; }
    .login-brand .sub { color: #666; font-size: 13.5px; margin-top: 4px; }
  </style>
</head>
<body class="login-body">
  <div class="login-card">
    <div class="login-brand">
      <img src="./img/swu_Logo.png" alt="SWU Logo">
      <h1>มหาวิทยาลัยศรีนครินทรวิโรฒ</h1>
      <p class="en">SRINAKHARINWIROT UNIVERSITY</p>
      <p class="sub">ระบบจัดการการฝึกงานสำหรับนิสิต</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><i class="fas fa-exclamation-circle me-2"></i><?= h($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="process_login.php" class="form">
      <label>
        <i class="fas fa-user-tag me-1"></i> บทบาท (Role)
        <select name="role" required>
          <option value="student" <?= $role==='student'?'selected':'' ?>>นิสิต (Student)</option>
          <option value="teacher" <?= $role==='teacher'?'selected':'' ?>>อาจารย์ (Teacher)</option>
          <option value="staff"   <?= $role==='staff'?'selected':'' ?>>เจ้าหน้าที่ (Staff)</option>
        </select>
      </label>
      <label>
        <i class="fas fa-user me-1"></i> Username
        <input type="text" name="username" required autofocus>
      </label>
      <label>
        <i class="fas fa-lock me-1"></i> Password
        <input type="password" name="password" required>
      </label>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-sign-in-alt me-1"></i> เข้าสู่ระบบ
      </button>
    </form>

    <details class="help">
      <summary><i class="fas fa-info-circle me-1"></i> ข้อมูลทดสอบ (Demo credentials)</summary>
      <ul>
        <?php if ($sample_students): ?>
          <li>นิสิต: <code><?= h($sample_students[0]['student_code']) ?></code> / <code>password123</code></li>
        <?php endif; ?>
        <?php if ($sample_teachers): ?>
          <li>อาจารย์: <code><?= h($sample_teachers[0]['username']) ?></code> / <code>password123</code></li>
        <?php endif; ?>
        <?php if ($sample_staff): ?>
          <li>เจ้าหน้าที่: <code><?= h($sample_staff[0]['username']) ?></code> / <code>password123</code></li>
        <?php endif; ?>
      </ul>
    </details>

    <div class="back-home">
      <a href="portal.php"><i class="fas fa-arrow-left me-1"></i> กลับสู่หน้าแรก</a>
    </div>
  </div>
  <style>
    .back-home { text-align: center; margin-top: 18px; }
    .back-home a {
      color: #c4122d; text-decoration: none; font-weight: 700; font-size: 14px;
      display: inline-flex; align-items: center; gap: 6px;
      padding: 8px 18px; border-radius: 999px;
      border: 1.5px solid #c4122d;
      transition: all .2s ease;
    }
    .back-home a:hover { background: #c4122d; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(196,18,45,.25); }
  </style>
</body>
</html>
