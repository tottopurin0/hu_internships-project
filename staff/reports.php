<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role(['staff','teacher']);

$by_status = $conn->query(
    'SELECT r.status_id, sm.Status_Name AS status_name_th, COUNT(*) AS n
     FROM internships_request r
     JOIN status_master sm ON sm.Status_ID = r.status_id
     GROUP BY r.status_id, sm.Status_Name
     ORDER BY r.status_id'
)->fetch_all(MYSQLI_ASSOC);

$by_company = $conn->query(
    'SELECT c.company_name, COUNT(*) AS n
     FROM internships_request r
     JOIN company c ON c.company_id = r.company_id
     GROUP BY c.company_id ORDER BY n DESC LIMIT 10'
)->fetch_all(MYSQLI_ASSOC);

$by_advisor = $conn->query(
    'SELECT t.first_name, t.last_name, COUNT(*) AS n
     FROM internships_request r
     JOIN teacher t ON t.teacher_id = r.advisor_id
     WHERE r.advisor_id IS NOT NULL
     GROUP BY t.teacher_id ORDER BY n DESC'
)->fetch_all(MYSQLI_ASSOC);

$recent = $conn->query(
    'SELECT r.request_id, r.status_id, r.created_at AS submitted_at,
            s.student_code, s.first_name, s.last_name, c.company_name
     FROM internships_request r
     JOIN student s ON s.student_id = r.student_id
     JOIN company c ON c.company_id = r.company_id
     ORDER BY r.created_at DESC LIMIT 20'
)->fetch_all(MYSQLI_ASSOC);

$page_title = 'รายงานภาพรวม';
require '../includes/header.php';
?>

<h1>
  <i class="fas fa-chart-bar me-2" style="color:var(--swu-red); margin-right: 10px;"></i>รายงานภาพรวมระบบ
</h1>

<div class="card card-table">
    <div class="card-header">
        <h2>
          <i class="fas fa-tasks me-2" style="margin-right: 10px;"></i>สรุปตามสถานะ
        </h2>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>สถานะ</th>
                <th>จำนวน</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($by_status as $s): ?>
            <tr>
                <td><?= h($s['status_name_th']) ?></td>
                <td><?= (int)$s['n'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="grid-2">
    <div class="card card-table">
        <div class="card-header">
            <h2>
              <i class="fas fa-trophy me-2" style="margin-right: 10px;"></i>Top 10 บริษัท (จำนวนนิสิต)
            </h2>
        </div>
        <?php if (!$by_company): ?>
        <p class="muted">ไม่มีข้อมูล</p>
        <?php else: ?>
        <table class="tbl">
            <thead>
                <tr>
                    <th>บริษัท</th>
                    <th>จำนวน</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($by_company as $c): ?>
                <tr>
                    <td><?= h($c['company_name']) ?></td>
                    <td><?= (int)$c['n'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <div class="card card-table">
        <div class="card-header">
            <h2>
              <i class="fas fa-chalkboard-teacher me-2" style="margin-right: 10px;"></i>จำนวนเคสต่ออาจารย์ที่ปรึกษา
            </h2>
        </div>
        <?php if (!$by_advisor): ?>
        <p class="muted">ไม่มีข้อมูล</p>
        <?php else: ?>
        <table class="tbl">
            <thead>
                <tr>
                    <th>อาจารย์</th>
                    <th>จำนวน</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($by_advisor as $a): ?>
                <tr>
                    <td>อ.<?= h($a['first_name'].' '.$a['last_name']) ?></td>
                    <td><?= (int)$a['n'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<div class="card card-table">
    <div class="card-header">
        <h2>
          <i class="fas fa-history me-2" style="margin-right: 10px;"></i>คำขอล่าสุด (20 รายการ)
        </h2>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>#</th>
                <th>นิสิต</th>
                <th>บริษัท</th>
                <th>ยื่นเมื่อ</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent as $r): [$l,$c] = status_label($r['status_id']); ?>
            <tr>
                <td>#<?= (int)$r['request_id'] ?></td>
                <td><?= h($r['student_code'].' '.$r['first_name'].' '.$r['last_name']) ?></td>
                <td><?= h($r['company_name']) ?></td>
                <td><?= h($r['submitted_at']) ?></td>
                <td>
                  <span class="badge <?= h($c) ?>"><?= h($l) ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>