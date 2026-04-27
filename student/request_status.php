<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../includes/auth.php';
require_role('student');

$user = current_user();
$student_code = $user['student_code'];
$student_id   = (int)$user['student_id'];
$request_id = (int)($_GET['id'] ?? 0);

$detail = null;
$logs = [];
$supervision = [];

if ($request_id > 0) {
    $stmt = $conn->prepare(
        'SELECT r.*, r.position AS position_title, r.remarks AS description, r.created_at AS submitted_at,
                c.company_name, c.province,
                c.contact_person_name AS contact_person, c.contact_person_phone AS contact_phone,
                t.first_name AS t_fn, t.last_name AS t_ln, t.department AS t_dept
         FROM internships_request r
         JOIN company c ON c.company_id = r.company_id
         LEFT JOIN teacher t ON t.teacher_id = r.advisor_id
         WHERE r.request_id = ? AND r.student_id = ?'
    );
    $stmt->bind_param('ii', $request_id, $student_id);
    $stmt->execute();
    $detail = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($detail) {
        $stmt = $conn->prepare(
            'SELECT l.log_id, l.request_id, l.old_status_id, l.new_status_id,
                    l.remark AS remark, l.changed_at,
                    l.teacher_id, l.faculty_staff_id,
                    sm.Status_Name AS status_name_th,
                    COALESCE(CONCAT("อ.", t.first_name, " ", t.last_name),
                             CONCAT(fs.first_name, " ", fs.last_name),
                             "ระบบ") AS changed_by,
                    CASE
                      WHEN l.teacher_id IS NOT NULL THEN "teacher"
                      WHEN l.faculty_staff_id IS NOT NULL THEN "staff"
                      ELSE "system"
                    END AS changer_role
             FROM status_log l
             JOIN status_master sm ON sm.Status_ID = l.new_status_id
             LEFT JOIN teacher t ON t.teacher_id = l.teacher_id
             LEFT JOIN faculty_staff fs ON fs.faculty_staff_id = l.faculty_staff_id
             WHERE l.request_id = ?
             ORDER BY l.changed_at DESC'
        );
        $stmt->bind_param('i', $request_id);
        $stmt->execute();
        $logs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $stmt = $conn->prepare(
            'SELECT sv.supervision_id, sv.request_id, sv.teacher_id,
                    sv.supervision_date AS visit_date, sv.score, sv.remarks AS notes,
                    "" AS visit_type, "" AS grade,
                    t.first_name AS t_fn, t.last_name AS t_ln
             FROM supervision_record sv
             JOIN teacher t ON t.teacher_id = sv.teacher_id
             WHERE sv.request_id = ? ORDER BY sv.supervision_date DESC'
        );
        $stmt->bind_param('i', $request_id);
        $stmt->execute();
        $supervision = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}

// Fallback: list of all my requests
$all = null;
if (!$detail) {
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
    $all = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$page_title = 'สถานะคำขอ';
require '../includes/header.php';
?>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?? 'สถานะคำขอ' ?></title>
    <link rel="stylesheet" href="/hu_internships-project/assets/css/style.css">
    <!-- เริ่มส่วน style -->
    <style>
    .progress-tracker {
        display: flex !important;
        justify-content: space-between;
        align-items: flex-start;
        background: #fff;
        padding: 30px 10px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
        width: 100%;
    }

    .progress-step {
        flex: 1;
        text-align: center;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* เส้นเชื่อมระหว่างวงกลม */
    .progress-step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 20px;
        left: 50%;
        width: 100%;
        height: 3px;
        background-color: #e0e0e0;
        z-index: 0;
    }

    /* สีเส้นเมื่อผ่านแล้ว */
    .progress-step.completed:not(:last-child)::after {
        background-color: #4caf50;
    }

    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e0e0e0;
        color: #757575;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .step-label {
        font-size: 0.85rem;
        font-weight: bold;
        color: #888;
    }

    /* 1. สีสถานะ กำลังดำเนินการ (แดง SWU) */
    .progress-step.active .step-icon {
        background-color: var(--swu-red, #d32f2f);
        color: #fff;
        transform: scale(1.1);
        box-shadow: 0 0 0 5px rgba(211, 47, 47, 0.15);
    }

    .progress-step.active .step-label {
        color: var(--swu-red, #d32f2f);
    }

    /* 2. สีสถานะ ผ่านแล้ว (เขียว) */
    .progress-step.completed .step-icon {
        background-color: #4caf50;
        color: #fff;
    }

    .progress-step.completed .step-label {
        color: #4caf50;
    }

    /* 3. สีสถานะ ไม่ผ่าน/ยกเลิก (แดงเข้ม) */
    .progress-step.cancelled .step-icon {
        background-color: #dc3545;
        color: #fff;
    }

    .progress-step.cancelled .step-label {
        color: #dc3545;
    }

    ul.timeline {
        margin-top: 20px !important;
        padding: 0 20px 20px 20px !important;
    }

    ul.timeline li {
        margin-bottom: 15px !important;
    }

    .card-form dl.kv {
        padding: 25px 20px !important;
        margin: 0 !important;
    }

    /* แถมให้ครับ: ขยับช่องไฟระหว่างบรรทัดในกล่องให้ดูโปร่งขึ้นนิดนึง */
    .card-form dl.kv dt,
    .card-form dl.kv dd {
        margin-bottom: 12px !important;
    }
    </style>
</head>
<!-- จบ style -->

<body>
<!-- ส่วนติดตามสถานะ -->
    <h1><i class="fas fa-tasks" style="color:var(--swu-red); margin-right: 10px;"></i>สถานะคำขอฝึกงาน</h1>

    <?php if ($detail):
    [$lbl, $cls] = status_label($detail['status_id']);
?>
    <?php
    $current_status = (int)$detail['status_id'];
    $s1 = $s2 = $s3 = $s4 = "";

    if ($current_status == 1) {
        $s1 = "active";
    } elseif ($current_status == 2 || $current_status == 3) {
        $s1 = "completed";
        $s2 = "active";
    } elseif ($current_status == 4) {
        $s1 = "completed";
        $s2 = "completed";
        $s3 = "completed"; 
    } else {
        $s4 = "cancelled";
    }
    ?>
    <!-- ส่วนกล่องแสดงผล -->
    <div class="progress-tracker">
        <div class="progress-step <?= $s1 ?>">
            <div class="step-icon"><i class="fas fa-file-signature"></i></div>
            <div class="step-label">รออนุมัติ</div>
        </div>
        <div class="progress-step <?= $s2 ?>">
            <div class="step-icon"><i class="fas fa-check-double"></i></div>
            <div class="step-label">อนุมัติ/ออกใบ</div>
        </div>
        <div class="progress-step <?= $s3 ?>">
            <div class="step-icon"><i class="fas fa-graduation-cap"></i></div>
            <div class="step-label">เสร็จสิ้น</div>
        </div>
        <div class="progress-step <?= $s4 ?>">
            <div class="step-icon">
                <i class="<?= $s4 == 'cancelled' ? 'fas fa-times-circle' : 'fas fa-ban' ?>"></i>
            </div>
            <div class="step-label">ไม่ผ่าน/ยกเลิก</div>
        </div>
    </div>
    <!-- จบส่วนกล่องแสดงผล -->
    <!-- จบ ส่วนติดตามสถานะ -->

    <!-- ส่วนแสดงผลการกรอกข้อมูล -->
    <div class="card card-form">
        <div class="card-header">
            <h2><i class="fas fa-file-alt me-2" style="margin-right: 10px;"></i>คำขอ #<?= (int)$detail['request_id'] ?></h2>
            <span class="badge <?= h($cls) ?>"><?= h($lbl) ?></span>
        </div>
        <dl class="kv">
            <dt>บริษัท</dt>
            <dd><?= h($detail['company_name']) ?> (<?= h($detail['province']) ?>)</dd>
            <dt>ตำแหน่ง</dt>
            <dd><?= h($detail['position_title']) ?></dd>
            <dt>ช่วงฝึกงาน</dt>
            <dd><?= h($detail['start_date']) ?> ถึง <?= h($detail['end_date']) ?></dd>
            <dt>อาจารย์ที่ปรึกษา</dt>
            <dd><?= $detail['t_fn'] ? 'อ.'.h($detail['t_fn'].' '.$detail['t_ln']).' — '.h($detail['t_dept']) : '-' ?>
            </dd>
            <dt>ผู้ติดต่อบริษัท</dt>
            <dd><?= h($detail['contact_person'] ?: '-') ?> <?= h($detail['contact_phone']) ?></dd>
            <dt>รายละเอียด</dt>
            <dd><?= nl2br(h($detail['description'] ?: '-')) ?></dd>
            <dt>วันที่ยื่น</dt>
            <dd><?= h($detail['submitted_at']) ?></dd>
        </dl>
    </div>
    <div class="card card-accent">
        <div class="card-header">
            <h3><i class="fas fa-stream me-2" style="margin-right: 10px;"></i>ประวัติการเปลี่ยนสถานะ</h3>
        </div>
        <?php if (!$logs): ?><p class="muted">ยังไม่มีประวัติ</p>
        <?php else: ?>
        <ul class="timeline">
            <?php foreach ($logs as $l): ?>
            <li>
                <strong><?= h($l['status_name_th']) ?></strong>
                <span class="muted"><?= h($l['changed_at']) ?></span>
                <?php if ($l['remark']): ?><div><?= h($l['remark']) ?></div><?php endif; ?>
                <small class="muted">โดย: <?= h($l['changed_by']) ?> (<?= h($l['changer_role']) ?>)</small>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
    <!-- จบ ส่วนแสดงผลการกรอกข้อมูล -->

    <!-- ส่วนบันทึกการนิเทศ -->
    <div class="card card-table">
        <div class="card-header">
            <h3><i class="fas fa-clipboard-check me-2" style="margin-right: 10px;"></i>บันทึกการนิเทศ</h3>
        </div>
        <?php if (!$supervision): ?><p class="muted">ยังไม่มีการนิเทศ</p>
        <?php else: ?>
        <table class="tbl">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>ประเภท</th>
                    <th>อาจารย์</th>
                    <th>คะแนน</th>
                    <th>บันทึก</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supervision as $s): ?>
                <tr>
                    <td><?= h($s['visit_date']) ?></td>
                    <td><?= h($s['visit_type']) ?></td>
                    <td>อ.<?= h($s['t_fn'].' '.$s['t_ln']) ?></td>
                    <td><?= h($s['score'] ?: '-') ?> <?= $s['grade'] ? '('.h($s['grade']).')' : '' ?></td>
                    <td><?= nl2br(h($s['notes'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <!-- จบ ส่วนบันทึกการนิเทศ -->

    <!-- เริ่ม ส่วนคำขอการฝึกงาน -->
    <?php else: ?>
    <div class="card card-table">
        <div class="card-header">
            <h3><i class="fas fa-list me-2" style="margin-right: 10px;"></i>คำขอของฉัน</h3>
        </div>
        <?php if (!$all): ?>
        <p class="muted">ยังไม่มีคำขอ — <a href="request_new.php">ยื่นคำขอใหม่</a></p>
        <?php else: ?>
        <table class="tbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>บริษัท</th>
                    <th>ตำแหน่ง</th>
                    <th>ช่วง</th>
                    <th>สถานะ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all as $r): [$l,$c] = status_label($r['status_id']); ?>
                <tr>
                    <td>#<?= (int)$r['request_id'] ?></td>
                    <td><?= h($r['company_name']) ?></td>
                    <td><?= h($r['position_title']) ?></td>
                    <td><?= h($r['start_date']) ?> → <?= h($r['end_date']) ?></td>
                    <td><span class="badge <?= h($c) ?>"><?= h($l) ?></span></td>
                    <td><a href="request_status.php?id=<?= (int)$r['request_id'] ?>">ดู</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <!-- จบ ส่วนคำขอการฝึกงาน -->

</body>

</html>