<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/db_connect.php';

$IMG = '/assets/img';

$categories = [
  'showcase' => ['label' => 'ผลงาน',       'color' => '#c4122d'],
  'academic' => ['label' => 'วิชาการ',     'color' => '#0d6efd'],
  'student'  => ['label' => 'กิจกรรมนิสิต', 'color' => '#198754'],
];

$activities = $conn->query('SELECT * FROM activities ORDER BY sort_order DESC, created_at DESC')->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ข่าวสารและกิจกรรม | IS SWU</title>
  <?php include __DIR__ . '/includes/public_head.php'; ?>
  <style>
    .activity-hero {
      background: linear-gradient(135deg, rgba(196,18,45,.9), rgba(33,37,41,.9)),
                  url('<?= $IMG ?>/berner.jpg') center/cover;
      padding: 80px 0; color: #fff !important; text-align: center; margin-bottom: 40px;
    }
    .activity-hero * { color: #fff !important; }
    .activity-hero h1 { font-weight: 800; font-size: 34px; margin: 12px 0 6px; color: #fff !important; }
    .activity-hero p  { opacity: .95; font-size: 15px; margin: 0; color: #fff !important; }
    .activity-hero i  { color: #fff !important; }

    .filter-btn-group { text-align: center; margin-bottom: 30px; }
    .filter-btn-group .btn {
      background: #fff; border-radius: 50px; padding: 6px 20px;
      font-size: 14px; font-weight: 700; margin: 5px;
      transition: all .3s; border: 1.5px solid transparent;
    }
    .filter-btn-group .btn[data-filter="all"]      { border-color:#6f42c1; color:#6f42c1; }
    .filter-btn-group .btn[data-filter="all"].active,
    .filter-btn-group .btn[data-filter="all"]:hover{ background:#6f42c1; color:#fff; box-shadow:0 4px 10px rgba(111,66,193,.2); }
    .filter-btn-group .btn[data-filter="showcase"] { border-color:#c4122d; color:#c4122d; }
    .filter-btn-group .btn[data-filter="showcase"].active,
    .filter-btn-group .btn[data-filter="showcase"]:hover { background:#c4122d; color:#fff; box-shadow:0 4px 10px rgba(196,18,45,.2); }
    .filter-btn-group .btn[data-filter="academic"] { border-color:#0d6efd; color:#0d6efd; }
    .filter-btn-group .btn[data-filter="academic"].active,
    .filter-btn-group .btn[data-filter="academic"]:hover { background:#0d6efd; color:#fff; box-shadow:0 4px 10px rgba(13,110,253,.2); }
    .filter-btn-group .btn[data-filter="student"]  { border-color:#198754; color:#198754; }
    .filter-btn-group .btn[data-filter="student"].active,
    .filter-btn-group .btn[data-filter="student"]:hover { background:#198754; color:#fff; box-shadow:0 4px 10px rgba(25,135,84,.2); }

    .slider-wrapper { position: relative; padding: 0 30px; }
    #activity-grid {
      display: flex; flex-wrap: nowrap; gap: 24px;
      overflow-x: auto; overflow-y: hidden;
      scroll-behavior: smooth;
      -ms-overflow-style: none; scrollbar-width: none;
      padding-bottom: 15px;
      scroll-snap-type: x mandatory;
    }
    #activity-grid::-webkit-scrollbar { display: none; }
    #activity-grid .a-item {
      flex: 0 0 320px; max-width: 320px; width: 320px;
      scroll-snap-align: start;
    }
    @media (min-width: 768px) {
      #activity-grid .a-item { flex-basis: 340px; max-width: 340px; width: 340px; }
    }

    .slide-btn {
      position: absolute; top: 50%; transform: translateY(-50%);
      width: 45px; height: 45px;
      background: #fff; border: 1px solid #e0e0e0; border-radius: 50%;
      box-shadow: 0 4px 10px rgba(0,0,0,.1); z-index: 10; cursor: pointer;
      display:flex; align-items:center; justify-content:center;
      color:#6c757d; font-size: 18px; transition: all .3s;
    }
    .slide-btn:hover { background:#f8f9fa; color:#c4122d; box-shadow: 0 6px 15px rgba(0,0,0,.15); }
    .slide-btn-prev { left: -20px; }
    .slide-btn-next { right: -20px; }
    @media (max-width: 768px) { .slide-btn { display: none; } }

    .activity-card-item {
      border: 1px solid #f0f0f0; border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,.04);
      height: 100%; display:flex; flex-direction:column;
      background: #fff; transition: .3s;
    }
    .activity-card-item:hover { transform: translateY(-8px); box-shadow: 0 12px 25px rgba(0,0,0,.1); }

    .activity-date-box {
      position: absolute; top: 15px; left: 15px;
      background: #fff; padding: 6px 12px; border-radius: 8px;
      text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,.15);
    }
    .activity-date-box .day   { display:block; font-size: 18px; font-weight: 800; color:#111; line-height: 1; }
    .activity-date-box .month { display:block; font-size: 11px; font-weight: 600; color:#666; }

    .pagination-dots { display:flex; justify-content:center; align-items:center; gap:8px; margin-top: 20px; }
    .pagination-dots .dot { width:12px; height:12px; background:#e0e0e0; border-radius:50%; cursor:pointer; transition: all .3s; }
    .pagination-dots .dot.active { width:32px; background:#c8102e; border-radius:10px; }
  </style>
</head>
<body style="background-color: #f8f9fa;">
<?php include __DIR__ . '/includes/public_nav.php'; ?>

<div class="activity-hero">
  <div class="container py-4">
    <h1><i class="fas fa-camera-retro"></i><br>ข่าวสารกิจกรรม & IS Showcase</h1>
    <p>ผลงานนวัตกรรม โครงการ และชีวิตนิสิตในรั้วมหาวิทยาลัยศรีนครินทรวิโรฒ</p>
  </div>
</div>

<div class="container pb-5 mb-5">

  <div class="filter-btn-group">
    <button class="btn active" data-filter="all">ทั้งหมด</button>
    <button class="btn" data-filter="showcase"><i class="fas fa-star"></i> ผลงาน</button>
    <button class="btn" data-filter="academic"><i class="fas fa-book-open"></i> วิชาการ</button>
    <button class="btn" data-filter="student"><i class="fas fa-users"></i> กิจกรรมนิสิต</button>
  </div>

  <div class="slider-wrapper position-relative">
    <button class="slide-btn slide-btn-prev" id="slidePrev"><i class="fas fa-chevron-left"></i></button>

    <div id="activity-grid">
      <?php foreach ($activities as $a):
        $c = $categories[$a['category']];
      ?>
        <div class="a-item <?= htmlspecialchars($a['category']) ?>">
          <div class="activity-card-item overflow-hidden position-relative">
            <img src="<?= $IMG ?>/<?= htmlspecialchars($a['image']) ?>" class="img-fluid w-100" style="height: 220px; object-fit: cover;" alt="">
            <div class="activity-date-box">
              <span class="day"><?= htmlspecialchars($a['day'] ?? '') ?></span>
              <span class="month"><?= htmlspecialchars($a['month'] ?? '') ?></span>
            </div>
            <div class="card-body p-4 d-flex flex-column h-100">
              <div class="mb-3">
                <span class="badge px-3 py-2 fw-bold rounded-1"
                      style="background-color: <?= $c['color'] ?>; font-size: 13px;">
                  <?= htmlspecialchars($c['label']) ?>
                </span>
              </div>
              <h5 class="fw-bold text-dark mt-1" style="font-size: 16px; line-height: 1.45;"><?= htmlspecialchars($a['title']) ?></h5>
              <p class="small text-muted mt-2 mb-4" style="line-height: 1.6;"><?= htmlspecialchars($a['description']) ?></p>
              <a href="/activity_detail.php?id=<?= (int)$a['activity_id'] ?>" class="btn w-100 mt-auto py-2 fw-bold" style="text-decoration: none; border: 1px solid <?= $c['color'] ?>; color: <?= $c['color'] ?>; display: block;"
                      onmouseover="this.style.backgroundColor='<?= $c['color'] ?>'; this.style.color='#fff';"
                      onmouseout="this.style.backgroundColor='transparent'; this.style.color='<?= $c['color'] ?>';">
                อ่านเพิ่มเติม <i class="fas fa-arrow-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <button class="slide-btn slide-btn-next" id="slideNext"><i class="fas fa-chevron-right"></i></button>
  </div>

  <div class="pagination-dots"></div>
</div>

<?php include __DIR__ . '/includes/public_footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const filterBtns = document.querySelectorAll('.filter-btn-group .btn');
  const activityItems = document.querySelectorAll('.a-item');
  const gridContainer = document.getElementById('activity-grid');
  const btnPrev = document.getElementById('slidePrev');
  const btnNext = document.getElementById('slideNext');
  const dotsContainer = document.querySelector('.pagination-dots');

  const getVisibleCards = () => Array.from(activityItems).filter(i => i.style.display !== 'none');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const f = btn.getAttribute('data-filter');
      activityItems.forEach(i => {
        i.style.display = (f === 'all' || i.classList.contains(f)) ? 'block' : 'none';
      });
      setTimeout(generateDots, 50);
    });
  });

  const scrollStep = () => {
    const vc = getVisibleCards();
    return vc.length ? vc[0].offsetWidth + 24 : 0;
  };

  btnNext.addEventListener('click', () => {
    const step = scrollStep();
    const maxLeft = gridContainer.scrollWidth - gridContainer.clientWidth;
    if (Math.ceil(gridContainer.scrollLeft) >= maxLeft - 10)
      gridContainer.scrollTo({ left: 0, behavior: 'smooth' });
    else
      gridContainer.scrollBy({ left: step, behavior: 'smooth' });
  });

  btnPrev.addEventListener('click', () => {
    const step = scrollStep();
    const maxLeft = gridContainer.scrollWidth - gridContainer.clientWidth;
    if (gridContainer.scrollLeft <= 10)
      gridContainer.scrollTo({ left: maxLeft, behavior: 'smooth' });
    else
      gridContainer.scrollBy({ left: -step, behavior: 'smooth' });
  });

  function generateDots() {
    if (!dotsContainer) return;
    dotsContainer.innerHTML = '';
    const step = scrollStep();
    const maxLeft = gridContainer.scrollWidth - gridContainer.clientWidth;
    if (!step || maxLeft <= 0) return;
    const n = Math.ceil(maxLeft / step) + 1;
    for (let i = 0; i < n; i++) {
      const dot = document.createElement('span');
      dot.classList.add('dot');
      dot.addEventListener('click', () => gridContainer.scrollTo({ left: step * i, behavior: 'smooth' }));
      dotsContainer.appendChild(dot);
    }
    gridContainer.scrollTo({ left: 0, behavior: 'smooth' });
    setTimeout(updatePagination, 50);
  }

  function updatePagination() {
    const dots = document.querySelectorAll('.pagination-dots .dot');
    if (!dots.length) return;
    const step = scrollStep();
    const maxLeft = gridContainer.scrollWidth - gridContainer.clientWidth;
    let idx = Math.ceil(gridContainer.scrollLeft) >= maxLeft - 10
      ? dots.length - 1
      : Math.round(gridContainer.scrollLeft / step);
    idx = Math.max(0, Math.min(idx, dots.length - 1));
    dots.forEach(d => d.classList.remove('active'));
    dots[idx] && dots[idx].classList.add('active');
  }

  gridContainer.addEventListener('scroll', () => window.requestAnimationFrame(updatePagination));
  window.addEventListener('resize', generateDots);
  generateDots();
</script>
</body>
</html>
