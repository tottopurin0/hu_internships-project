<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$role     = trim($_POST['role']     ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password']      ?? '';

$_SESSION['login_role'] = $role;

if ($role === '' || $username === '' || $password === '') {
    $_SESSION['login_error'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    header('Location: login.php');
    exit;
}

$user_row = null;
$display_name = '';

switch ($role) {
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

if (!$user_row) {
    $_SESSION['login_error'] = 'Username หรือ Password ไม่ถูกต้อง';
    
    // เช็ค role ว่าเป็นใคร แล้วให้เด้งกลับไปหน้าของคนนั้น
    if ($role === 'student') {
        header('Location: login_student.php');
    } elseif ($role === 'staff') {
        header('Location: login_staff.php');
    } elseif ($role === 'teacher') {
        header('Location: login_teacher.php');
    } else { // <--- เติม } ปิดตรงนี้ให้เรียบร้อยครับ!
        header('Location: portal.php'); 
    }
    exit;
}
session_regenerate_id(true);
$_SESSION['user'] = $user_row;
$_SESSION['role'] = $role;
unset($_SESSION['login_error'], $_SESSION['login_role']);

if ($role === 'student') {
    header('Location: student/dashboard.php');
} else {
    header('Location: staff/dashboard.php');
}
exit;
