<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role('student');

$user = current_user();
$student_code = $user['student_code'];
$student_id   = (int)$user['student_id'];

$stmt = $conn->prepare(
    'SELECT r.request_id, r.start_date, r.end_date, r.status_id, r.position AS position_title,
            c.company_name
     FROM internships_request r
     JOIN company c ON c.company_id = r.company_id
     WHERE r.student_id = ?
     ORDER BY r.created_at DESC'
);
$stmt->bind_param('i', $student_id);
$stmt->execute();
$requests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$counts = ['total'=>0,'pending'=>0,'approved'=>0,'completed'=>0];
foreach ($requests as $r) {
    $counts['total']++;
    if ($r['status_id'] == 1) $counts['pending']++;
    if ($r['status_id'] == 2 || $r['status_id'] == 3) $counts['approved']++;
    if ($r['status_id'] == 4) $counts['completed']++;
}

$page_title = 'หน้าหลักนิสิต';
require '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?? 'ระบบฝึกงาน' ?></title>
    <link rel="stylesheet" href="/hu_internships-project/assets/css/style.css">
<body>



    </div>
        [$label, $class] = status_label($r['status_id']); ?>
</body>

