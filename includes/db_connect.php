<?php
// =====================================================
// Database Connection (MySQLi)
// ห้ามลบ/ย้ายไฟล์นี้
// =====================================================

// macOS defaults:
//   - MAMP:     user=root pass=root port=8889
//   - Homebrew: user=root pass=''   port=3306
//   - XAMPP:    user=root pass=''   port=3306
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';     // <-- MAMP default; เปลี่ยนเป็น '' ถ้าใช้ Homebrew/XAMPP
$DB_NAME = 'internships';
$DB_PORT = 3307;       // <-- MAMP default; เปลี่ยนเป็น 3306 ถ้าใช้ Homebrew/XAMPP

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper: safely escape output
function h($str) {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// Helper: map status_id -> Thai label + CSS class
function status_label($id) {
    $map = [
        1 => ['รออนุมัติ', 'badge-pending'],
        2 => ['อนุมัติแล้ว', 'badge-approved'],
        3 => ['ออกใบส่งตัวแล้ว', 'badge-issued'],
        4 => ['เสร็จสิ้น', 'badge-completed'],
        9 => ['ไม่ผ่าน/ยกเลิก', 'badge-rejected'],
    ];
    return $map[(int)$id] ?? ['ไม่ทราบสถานะ', 'badge-unknown'];
}

// Helper: insert a status change log row
function log_status_change(mysqli $conn, int $request_id, ?int $old_status, int $new_status, ?string $changed_by = null, ?string $changer_role = null, ?string $remark = null) {
    $stmt = $conn->prepare(
        'INSERT INTO status_log (request_id, old_status_id, new_status_id, changed_by, changer_role, remark)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->bind_param('iiisss', $request_id, $old_status, $new_status, $changed_by, $changer_role, $remark);
    $stmt->execute();
    $stmt->close();
}
