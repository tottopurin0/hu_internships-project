<?php
// 1. ตรวจสอบว่าระบบเปิด Session หรือยัง ถ้ายังให้เปิดใช้งาน (เอาไว้เก็บสถานะการล็อกอิน) และดึงไฟล์ auth.php เข้ามา [cite: 1]
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/auth.php';
// 2. ดักทางเข้า: ถ้าไม่ได้เข้ามาหน้านี้ด้วยการกดปุ่ม Submit จากฟอร์ม (POST) ให้เด้งกลับไปหน้า login [cite: 1]
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}
// 3. รับค่าจากฟอร์ม: ตัดช่องว่างหน้า-หลังทิ้งด้วย trim() ถ้ารับค่าไม่ได้ให้ตั้งเป็นค่าว่างไว้ก่อน [cite: 2]
$role     = trim($_POST['role']     ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password']      ?? '';
// จำ Role (สถานะผู้ใช้) เอาไว้ใน Session ก่อน เผื่อล็อกอินไม่ผ่านจะได้รู้ว่าส่งกลับไปหน้าไหน [cite: 3]
$_SESSION['login_role'] = $role;
// 4. เช็คความเรียบร้อย: ถ้าผู้ใช้กรอกข้อมูลมาไม่ครบช่อง ให้เซ็ตข้อความแจ้งเตือน [cite: 4
if ($role === '' || $username === '' || $password === '') {
    $_SESSION['login_error'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    header('Location: login.php');
    exit;
}

$user_row = null;
$display_name = '';
// 5. ตรวจสอบบัญชีผู้ใช้: แยกหาข้อมูลในฐานข้อมูลตาม Role ที่เลือกมา [cite: 5]
switch ($role) {
    // กรณีนิสิต
    case 'student':
        $stmt = $conn->prepare(
            'SELECT student_id, student_code, password, first_name, last_name, advisor_id, faculty, major
             FROM student WHERE student_code = ? LIMIT 1'
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        if ($row && password_verify($password, $row['password'])) {
            $user_row = [
                'id'            => $row['student_id'],
                'student_id'    => (int)$row['student_id'],
                'student_code'  => $row['student_code'],
                'advisor_id'    => $row['advisor_id'] !== null ? (int)$row['advisor_id'] : null,
                'display_name'  => $row['first_name'] . ' ' . $row['last_name'],
                'faculty'       => $row['faculty'],
                'major'         => $row['major'],
            ];
        }
        break;
// กรณีอาจารย์
    case 'teacher':
        $stmt = $conn->prepare(
            'SELECT teacher_id, username, password, first_name, last_name, department
             FROM teacher WHERE username = ? LIMIT 1'
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        if ($row && password_verify($password, $row['password'])) {
            $user_row = [
                'id'           => $row['teacher_id'],
                'teacher_id'   => $row['teacher_id'],
                'username'     => $row['username'],
                'display_name' => 'อ.' . $row['first_name'] . ' ' . $row['last_name'],
                'department'   => $row['department'],
            ];
        }
        break;
// กรณีเจ้าหน้าที่
    case 'staff':
        $stmt = $conn->prepare(
            'SELECT faculty_staff_id AS staff_id, username, password, first_name, last_name, position
             FROM faculty_staff WHERE username = ? LIMIT 1'
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        if ($row && password_verify($password, $row['password'])) {
            $user_row = [
                'id'           => $row['staff_id'],
                'staff_id'     => $row['staff_id'],
                'username'     => $row['username'],
                'display_name' => $row['first_name'] . ' ' . $row['last_name'],
                'position'     => $row['position'],
            ];
        }
        break;
}
// 6. จัดการกรณีล็อกอิน "ไม่ผ่าน" (ตัวแปร $user_row ยังเป็น null อยู่) [cite: 21]
if (!$user_row) {
    $_SESSION['login_error'] = 'Username หรือ Password ไม่ถูกต้อง';
    
    // เช็ค role ว่าเป็นใคร แล้วให้เด้งกลับไปหน้าของคนนั้น
    if ($role === 'student') {
        header('Location: login/login_student.php');
    } elseif ($role === 'staff') {
        header('Location: login/login_staff.php');
    } elseif ($role === 'teacher') {
        header('Location: login/login_teacher.php');
    } else { // <--- เติม } ปิดตรงนี้ให้เรียบร้อยครับ!
        header('Location: portal.php'); 
    }
    exit;
}
// 7. จัดการกรณีล็อกอิน "ผ่าน" [cite: 25]
session_regenerate_id(true);
$_SESSION['user'] = $user_row;
$_SESSION['role'] = $role;
unset($_SESSION['login_error'], $_SESSION['login_role']);
// 8. พาผู้ใช้ไปยังหน้า Dashboard ของตัวเอง [cite: 26]
if ($role === 'student') {
    header('Location: student/dashboard.php');
} else {
    header('Location: staff/dashboard.php');
}
exit;
