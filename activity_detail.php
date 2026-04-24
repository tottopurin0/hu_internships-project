<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/db_connect.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: /activities.php');
    exit;
}

$stmt = $conn->prepare('SELECT * FROM activities WHERE activity_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$activity = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$activity) {
    header('Location: /activities.php');
    exit;
}

$IMG = '/assets/img';
$categories = [
  'showcase' => ['label' => 'ผลงาน',       'color' => '#c4122d'],
  'academic' => ['label' => 'วิชาการ',     'color' => '#0d6efd'],
  'student'  => ['label' => 'กิจกรรมนิสิต', 'color' => '#198754'],
];
$cat = $categories[$activity['category']] ?? ['label' => 'อื่น', 'color' => '#6c757d'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= h($activity['title']) ?> | IS SWU</title>
  <?php include __DIR__ . '/includes/public_head.php'; ?>
  <style>
    .detail-hero {
      background: linear-gradient(135deg, rgba(196,18,45,.9), rgba(33,37,41,.9)),
                  url('<?= $IMG ?>/berner.jpg') center/cover;
      padding: 80px 0; color: #fff !important; text-align: center; margin-bottom: 40px;
    }
    .detail-hero * { color: #fff !important; }
    .detail-hero h1 { font-weight: 800; font-size: 34px; margin: 12px 0 6px; color: #fff !important; }
    .detail-hero p  { opacity: .95; font-size: 15px; margin: 0; color: #fff !important; }

    .detail-image {
      width: 100%; max-height: 500px; object-fit: cover; border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,.1); margin-bottom: 30px;
    }

    .detail-date-box {
      display: inline-block; background: #fff; padding: 12px 20px; border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,.15); margin-bottom: 20px;
    }
    .detail-date-box .day { display: inline; font-size: 24px; font-weight: 800; color: #111; margin-right: 8px; }
    .detail-date-box .month { display: inline; font-size: 14px; font-weight: 600; color: #666; }

    .detail-badge {
      display: inline-block; padding: 8px 16px; border-radius: 8px; font-weight: 700; margin-bottom: 20px;
      color: #fff; background-color: <?= h($cat['color']) ?>;
    }

    .detail-content { font-size: 16px; line-height: 1.8; color: #333; }
    .detail-content p { margin-bottom: 16px; }
  </style>
</head>
<body style="background-color: #f8f9fa;">
<?php include __DIR__ . '/includes/public_nav.php'; ?>

<div class="detail-hero">
  <div class="container py-4">
    <h1><i class="fas fa-newspaper"></i><br>รายละเอียดกิจกรรม</h1>
    <p>ข่าวสารและกิจกรรมจากศรีนครินทรวิโรฒ</p>
  </div>
</div>

<div class="container pb-5 mb-5">
  <div style="max-width: 800px; margin: 0 auto;">
    <?php if (!empty($activity['image'])): ?>
      <img src="<?= h($IMG) ?>/<?= h($activity['image']) ?>" alt="" class="detail-image">
    <?php endif; ?>

    <div class="detail-date-box">
      <span class="day"><?= h($activity['day'] ?? '') ?></span>
      <span class="month"><?= h($activity['month'] ?? '') ?></span>
    </div>

    <div class="detail-badge"><?= h($cat['label']) ?></div>

    <h1 style="font-weight: 800; margin-bottom: 20px; font-size: 32px; line-height: 1.3;">
      <?= h($activity['title']) ?>
    </h1>

    <div class="detail-content">
      <?php
        $paragraphs = explode("\n\n", $activity['description']);
        foreach ($paragraphs as $para):
          if (trim($para)):
      ?>
        <p><?= nl2br(h(trim($para))) ?></p>
      <?php
          endif;
        endforeach;
      ?>
    </div>

    <hr style="margin: 40px 0;">

    <div style="text-align: center;">
      <a href="/activities.php" class="btn btn-primary btn-lg">
        <i class="fas fa-arrow-left me-2"></i> กลับไปยังหน้ากิจกรรม
      </a>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/public_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
