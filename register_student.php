<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/db_connect.php';

// ฟังก์ชันสำหรับป้องกัน XSS
if (!function_exists('h')) {
    function h($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }
}

$errors = [];
$msg = '';
$old = [
    'student_code' => '', 'first_name' => '', 'last_name' => '',
    'email' => '', 'phone' => '', 'faculty' => '', 'major' => '',
    'program_type' => '', 'year_level' => '', 'gpa' => '', 'advisor_id' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($old as $k => $_) $old[$k] = trim($_POST[$k] ?? '');
    $password  = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    // ตรวจสอบข้อมูล
    if (!preg_match('/^\d{5,20}$/', $old['student_code'])) $errors[] = 'รหัสนิสิตต้องเป็นตัวเลข 5–20 หลัก';
    if ($old['first_name'] === '' || $old['last_name'] === '') $errors[] = 'กรุณากรอกชื่อ-นามสกุล';
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'อีเมลไม่ถูกต้อง';
    if (strlen($password) < 6) $errors[] = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร';
    if ($password !== $password2) $errors[] = 'รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน';
    if ($old['year_level'] !== '' && !ctype_digit($old['year_level'])) $errors[] = 'ชั้นปีไม่ถูกต้อง';
    if ($old['gpa'] !== '' && !is_numeric($old['gpa'])) $errors[] = 'GPA ไม่ถูกต้อง';

    // เช็ครหัสนิสิตซ้ำในระบบ
    if (!$errors) {
        $stmt = $conn->prepare('SELECT 1 FROM student WHERE student_code = ?');
        if ($stmt) {
            $stmt->bind_param('s', $old['student_code']);
            $stmt->execute();
            if ($stmt->get_result()->fetch_row()) $errors[] = 'รหัสนิสิตนี้ลงทะเบียนในระบบแล้ว';
            $stmt->close();
        }
    }

    // บันทึกลง Database
    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $gpa  = $old['gpa'] !== '' ? (float)$old['gpa'] : null;
        $adv  = $old['advisor_id'] !== '' ? (int)$old['advisor_id'] : null;
        
        $stmt = $conn->prepare(
            'INSERT INTO student (student_code, password, first_name, last_name, email, phone, faculty, major, gpa, advisor_id)
             VALUES (?,?,?,?,?,?,?,?,?,?)'
        );
        if ($stmt) {
            $stmt->bind_param(
                'ssssssssdi',
                $old['student_code'], $hash, $old['first_name'], $old['last_name'],
                $old['email'], $old['phone'], $old['faculty'], $old['major'],
                $gpa, $adv
            );
            if ($stmt->execute()) {
                $msg = 'สมัครสมาชิกสำเร็จ! ใช้รหัสนิสิต ' . h($old['student_code']) . ' เข้าสู่ระบบได้ทันที';
                $old = array_fill_keys(array_keys($old), ''); // ล้างฟอร์ม
            } else {
                $errors[] = 'เกิดข้อผิดพลาดในการบันทึก: ' . $conn->error;
            }
            $stmt->close();
        }
    }
}

// ดึงรายชื่ออาจารย์จากฐานข้อมูล
$teachers = [];
$res = $conn->query('SELECT teacher_id, first_name, last_name, department FROM teacher ORDER BY first_name');
if ($res) {
    $teachers = $res->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ลงทะเบียนนิสิตใหม่ - IS SWU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Kanit', sans-serif; background-color: #f6f7f9; 
            display: flex; align-items: center; justify-content: center; 
            min-height: 100vh; margin: 0; padding: 40px 15px; 
        }
        
        .reg-card { 
            background: white; padding: 45px; border-radius: 15px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.06); width: 100%; max-width: 800px; 
        }
        .reg-icon { 
            width: 75px; height: 75px; border-radius: 50%; display: flex; 
            align-items: center; justify-content: center; font-size: 32px; 
            color: white; margin: 0 auto 15px auto; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4); 
            background-color: #ffc107; 
        }
        
        .custom-input { 
            border: 1px solid #ced4da; border-radius: 8px; overflow: hidden; margin-bottom: 18px; display: flex; align-items: center; 
        }
        .custom-input .input-group-text { background: transparent; border: none; color: #ffc107; padding-left: 15px; width: 45px; justify-content: center;}
        .custom-input .form-control { border: none; font-size: 14.5px; padding: 11px 10px 11px 0; box-shadow: none; outline: none; }
        .custom-input select.form-control { color: #495057; cursor: pointer; }
        
        .reg-label { text-align: left; display: block; font-size: 13.5px; font-weight: 700; margin-bottom: 6px; color: #444; }
        
        .btn-reg { background-color: #212529; color: white; border: none; font-size: 16px; font-weight: bold; letter-spacing: 0.5px; transition: 0.3s; padding: 12px 0;}
        .btn-reg:hover { background-color: #ffc107; color: black; box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3); }
        
        .section-title { font-size: 16px; color: #c4122d; font-weight: 800; border-bottom: 2px solid #f0f0f0; padding-bottom: 8px; margin-bottom: 20px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="reg-card">
        
        <div class="reg-icon">
            <i class="fas fa-user-plus"></i>
        </div>
        
        <h3 class="fw-bold text-dark text-center mb-1">ลงทะเบียนบัญชีนิสิต</h3>
        <p class="text-muted small text-center mb-4">ระบบบันทึกคำร้องขอฝึกงาน (Internships System)</p>
        
        <?php if ($msg): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= $msg ?>
            </div>
        <?php endif; ?>
        
        <?php if ($errors): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><strong>พบข้อผิดพลาด:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            
            <div class="section-title">1. ข้อมูลการเข้าสู่ระบบ</div>
            <div class="row">
                <div class="col-md-12">
                    <label class="reg-label">รหัสนิสิต / Username <span class="text-danger">*</span></label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                        <input type="text" name="student_code" class="form-control" value="<?= h($old['student_code']) ?>" placeholder="รหัสนิสิต 11 หลัก" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="reg-label">รหัสผ่าน / Password <span class="text-danger">*</span></label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="ตั้งรหัสผ่าน" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="reg-label">ยืนยันรหัสผ่าน / Confirm <span class="text-danger">*</span></label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password2" class="form-control" placeholder="ยืนยันรหัสผ่านอีกครั้ง" required>
                    </div>
                </div>
            </div>

            <div class="section-title">2. ข้อมูลส่วนตัวพื้นฐาน</div>
            <div class="row">
                <div class="col-md-6">
                    <label class="reg-label">ชื่อจริง (First Name) <span class="text-danger">*</span></label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="first_name" class="form-control" value="<?= h($old['first_name']) ?>" placeholder="ระบุชื่อจริง" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="reg-label">นามสกุล (Last Name) <span class="text-danger">*</span></label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="last_name" class="form-control" value="<?= h($old['last_name']) ?>" placeholder="ระบุนามสกุล" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label class="reg-label">อีเมล (E-Mail) <span class="text-danger">*</span></label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" value="<?= h($old['email']) ?>" placeholder="example@g.swu.ac.th" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="reg-label">เบอร์โทรศัพท์ (Phone)</label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                        <input type="text" name="phone" class="form-control" value="<?= h($old['phone']) ?>" placeholder="08X-XXX-XXXX">
                    </div>
                </div>
            </div>

            <div class="section-title">3. ข้อมูลการศึกษา</div>
            <div class="row">
                <div class="col-md-6">
                    <label class="reg-label">คณะ (Faculty)</label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                        <input type="text" name="faculty" class="form-control" value="<?= h($old['faculty']) ?>" placeholder="ระบุชื่อคณะ">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="reg-label">สาขาวิชา (Major)</label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                        <input type="text" name="major" class="form-control" value="<?= h($old['major']) ?>" placeholder="ระบุชื่อสาขา">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="reg-label">ภาคการศึกษา (Program Type)</label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        <select name="program_type" class="form-control" style="appearance: auto;">
                            <option value="" disabled <?= $old['program_type'] == '' ? 'selected' : '' ?>>เลือกภาคการศึกษา</option>
                            <option value="ปกติ" <?= $old['program_type'] == 'ปกติ' ? 'selected' : '' ?>>ภาคปกติ</option>
                            <option value="พิเศษ" <?= $old['program_type'] == 'พิเศษ' ? 'selected' : '' ?>>ภาคพิเศษ</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="reg-label">ชั้นปี (Year Level)</label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                        <select name="year_level" class="form-control" style="appearance: auto;">
                            <option value="" disabled <?= $old['year_level'] == '' ? 'selected' : '' ?>>เลือกชั้นปี</option>
                            <?php for($i=1; $i<=4; $i++): ?>
                                <option value="<?= $i ?>" <?= $old['year_level']==(string)$i ? 'selected' : '' ?>>ชั้นปีที่ <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label class="reg-label">เกรดเฉลี่ยสะสม (GPA)</label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        <input type="number" step="0.01" min="0" max="4" name="gpa" class="form-control" value="<?= h($old['gpa']) ?>" placeholder="เช่น 3.50">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="reg-label">อาจารย์ที่ปรึกษา</label>
                    <div class="custom-input">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        <select name="advisor_id" class="form-control" style="appearance: auto;">
                            <option value="" disabled <?= $old['advisor_id'] == '' ? 'selected' : '' ?>>เลือกอาจารย์ที่ปรึกษา</option>
                            <?php foreach ($teachers as $t): ?>
                                <option value="<?= (int)$t['teacher_id'] ?>" <?= $old['advisor_id'] == (string)$t['teacher_id'] ? 'selected' : '' ?>>
                                    อาจารย์ <?= h($t['first_name'] . ' ' . $t['last_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-reg w-100 rounded-5 mt-4"><i class="fas fa-save me-2"></i> สร้างบัญชีผู้ใช้นิสิต</button>
        </form>
        
        <div class="text-center mt-4">
            <a href="portal.php" class="text-muted small fw-bold text-decoration-none"><i class="fas fa-arrow-left"></i> กลับไปหน้าเลือกระบบ</a>
        </div>
    </div>
</body>
</html>