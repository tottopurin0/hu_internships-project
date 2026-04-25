<?php
// เริ่มต้น Session และตรวจสอบการ Login แบบเดียวกับ login1.txt [cite: 1]
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/auth.php';

// ถ้า Login อยู่แล้วให้เด้งไปหน้า index 
if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

// ดึง Error Message (ถ้ามี) [cite: 2]
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Student Login - นิสิต</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <style>
        body { font-family: 'Kanit', sans-serif; }
        .clean-login-bg { background-color: #f6f6f6; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .clean-login-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); width: 100%; max-width: 400px; text-align: center; }
        
        /* สไตล์ไอคอนด้านบน */
        .login-icon-circle { width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; color: white; margin: 0 auto 15px auto; box-shadow: 0 4px 10px rgba(155, 17, 30, 0.3); background-color: #9b111e; }
        
        /* สไตล์ช่องกรอกรหัส */
        .custom-input-group { border: 1px solid #ced4da; border-radius: 6px; overflow: hidden; margin-bottom: 20px; display: flex; align-items: center; }
        .custom-input-group .input-group-text { background-color: transparent; border: none; color: #9b111e; padding-left: 15px; }
        .custom-input-group .form-control { border: none; font-size: 14.5px; padding: 10px; box-shadow: none; }
        .custom-input-group .form-control:focus { outline: none; }
        
        .login-label { text-align: left; display: block; font-size: 13px; font-weight: 700; margin-bottom: 5px; color: #333; }
        .btn-student { background-color: #9b111e; color: white; transition: 0.3s; }
        .btn-student:hover { background-color: #7a0c16; color: white; }
    </style>
</head>
<body class="clean-login-bg">

    <div class="clean-login-card">
        
        <div class="login-icon-circle">
            <i class="fas fa-user-graduate"></i>
        </div>
        
        <h3 class="fw-bold" style="color: #9b111e;">นิสิต Login</h3>
        <p class="text-muted small mb-4">เข้าสู่ระบบ Internship ด้วยบัญชีนิสิต</p>
        
        <?php if ($error): ?>
            <div class="alert alert-danger text-start py-2 px-3 mb-3" style="font-size: 13px; border-radius: 6px;">
                <i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="process_login.php">
            
            <input type="hidden" name="role" value="student">
            
            <label class="login-label">รหัสนิสิต (Username)</label>
            <div class="input-group custom-input-group">
                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                <input type="text" name="username" class="form-control" placeholder="เช่น 641010123" required autofocus>
            </div>
            
            <label class="login-label">รหัสผ่าน</label>
            <div class="input-group custom-input-group mb-1">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน" required>
            </div>
            
            <div class="text-start mb-4" style="font-size: 11.5px; color: #9b111e;">
                <i class="fas fa-info-circle"></i> ใช้รหัสนิสิตและรหัสผ่านเพื่อเข้าสู่ระบบ
            </div>
            
            <button type="submit" class="btn btn-student w-100 rounded-5 py-2 mt-1 fw-bold">เข้าสู่ระบบ</button>
        </form>

        <details class="help">
      <summary><i class="fas fa-info-circle me-1"></i> ข้อมูลทดสอบ (Demo credentials)</summary>
      <ul>
        <?php if ($sample_students): ?>
          <li>นิสิต: <code><?= h($sample_students[0]['student_code']) ?></code> / <code>password123</code></li>
        <?php endif; ?>
      </ul>
    </details>
        
        <div class="mt-4">
            <a href="portal.php" class="text-muted small fw-bold text-decoration-none"><i class="fas fa-arrow-left"></i> เลือกระบบอื่น</a>
        </div>
    </div>

</body>
</html>