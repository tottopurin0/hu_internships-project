<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$IMG = '/assets/img';

$committee = [
  [
    'id' => 1,
    'name' => 'อาจารย์ ดร. ดิษฐ์ สุทธิวงศ์',
    'role' => 'ประธานกรรมการบริหารหลักสูตร',
    'role_class' => 'text-danger',
    'eng'  => 'Lecturer Dit Suthiwong, Ph.D.',
    'img'  => 't_Dit.jpg',
    'edu'  => ['วท.บ. วิทยาการคอมพิวเตอร์', 'วท.ม. การจัดการเทคโนโลยีสารสนเทศ', 'Ph.D. Information Technology'],
    'exp'  => [
      'ประสบการณ์ด้าน Project Management Skill สิบปีในธุรกิจ Banking/Finance/Insurance',
      'บริหารจัดการเทคโนโลยีสารสนเทศธุรกิจ Media Broadcast การจัดการ digital media, media asset management, digital censorship system',
      'บริหารจัดการ IT Infrastructure ด้วย ITIL Standard ให้กับอุตสาหกรรม และโรงงานผลิตอาหาร',
    ],
    'email' => 'dit.suthi@gmail.com',
    'phone' => '081-5550581',
    'office' => 'คณะมนุษยศาสตร์ มศว ประสานมิตร',
  ],
  [
    'id' => 2,
    'name' => 'อาจารย์ ดร. ฐิติ อติชาติชยากร',
    'role' => 'เลขานุการหลักสูตร',
    'role_class' => 'text-danger',
    'eng'  => 'Lecturer Thiti Atichartchayakorn, Ph.D.',
    'img'  => 't_thiti.jpg',
    'edu'  => ['ศศ.บ. บรรณารักษศาสตร์และสารสนเทศศาสตร์', 'อ.ม. บรรณารักษศาสตร์และสารนิเทศศาสตร์', 'ค.ด. เทคโนโลยีและสื่อสารการศึกษา'],
    'exp'  => ['การพัฒนาห้องสมุดดิจิทัล', 'การรู้สารสนเทศ', 'การคิดเชิงออกแบบ', 'การสร้างผลงานนวัตกรรมการบริการในห้องสมุด', 'เทคโนโลยีสารสนเทศ'],
    'email' => 'thitik@g.swu.ac.th',
    'phone' => '02-649-5000 ต่อ 16087',
    'office' => 'คณะมนุษยศาสตร์ มศว ประสานมิตร',
  ],
  [
    'id' => 3,
    'name' => 'ผู้ช่วยศาสตราจารย์ ดร. วิภากร วัฒนสินธุ์',
    'role' => 'อาจารย์ประจำหลักสูตร',
    'role_class' => 'text-danger',
    'eng'  => 'Assistant Professor Vipakorn Vadhanasin, Ph.D., PMP, FHEA',
    'img'  => 't_Vipakorn.jpg',
    'edu'  => ['บธ.บ. การตลาด', 'น.บ. นิติศาสตร์', 'MBA Finance', 'MS Computer Information System', 'วท.ด. ธุรกิจเทคโนโลยีและการจัดการนวัตกรรม'],
    'exp'  => ['การจัดการโครงการ', 'การออกแบบระบบ', 'ฐานข้อมูล', 'การวิเคราะห์ข้อมูล', 'เทคโนโลยีสารสนเทศ'],
    'email' => 'vipakorn@g.swu.ac.th',
    'phone' => '02-649-5000 ต่อ 16508',
    'office' => 'คณะมนุษยศาสตร์ มศว ประสานมิตร',
  ],
  [
    'id' => 4,
    'name' => 'อาจารย์ ดร. โชคธำรงค์ จงจอหอ',
    'role' => 'อาจารย์ประจำหลักสูตร',
    'role_class' => 'text-danger',
    'eng'  => 'Lecturer Chokthamrong Chongchorhor, Ph.D.',
    'img'  => 't_Chokthamrong.jpg',
    'edu'  => ['ศศ.บ. สารสนเทศศาสตร์', 'ศศ.ม. การจัดการทรัพยากรชีวภาพ', 'วท.ม. เทคโนโลยีผู้ประกอบการและการจัดการนวัตกรรม', 'ปร.ด. สารสนเทศศึกษา'],
    'exp'  => ['การจัดระบบความรู้', 'การสอนสารสนเทศศึกษา', 'ดรรชนีและสาระสังเขป', 'พฤติกรรมสารสนเทศของมนุษย์'],
    'email' => 'chokthamrong@g.swu.ac.th',
    'phone' => '0-2649-5000 ต่อ 16292',
    'office' => 'คณะมนุษยศาสตร์ มศว ประสานมิตร',
  ],
  [
    'id' => 5,
    'name' => 'อาจารย์โชติมา วัฒนะ',
    'role' => 'อาจารย์ประจำหลักสูตร',
    'role_class' => 'text-danger',
    'eng'  => 'Lecturer Chotima Watana',
    'img'  => 't_Chotima.jpg',
    'edu'  => ['B.A. Information Science', 'M.A. Information Management', 'Ph.D. Candidate, Doctor of Philosophy Information Science'],
    'exp'  => ['Library Management', 'Library Service', 'Information Behavior'],
    'email' => 'chotimaw@g.swu.ac.th',
    'phone' => '-',
    'office' => 'คณะมนุษยศาสตร์ มศว ประสานมิตร',
  ],
];

$instructors = [
  [
    'id' => 6,
    'name' => 'ผู้ช่วยศาสตราจารย์ ดร. ดุษฎี สีวังคำ',
    'role' => 'อาจารย์ผู้สอน',
    'role_class' => 'text-danger',
    'eng'  => 'Assistant Professor Dussadee Seewungkum, Ph.D.',
    'img'  => 't_Dussadee.jpg',
    'edu'  => [
      'Ph.D., King Mongkut’s University of Technology North Bangkok (Technical Education Technology)',
      'M.S., King Mongkut’s University of Technology North Bangkok (Information Technology)',
      'B.S., Rajabhat Institute Phetchabun (Computer Science)',
    ],
    'exp'  => ['Information Technology', 'Computer Technology', 'Communication Technology', 'Education Technology', 'Computer Programming', 'Multimedia Technology'],
    'email' => 'dussadee@g.swu.ac.th',
    'phone' => '02-649-5000 ต่อ 16292',
    'office' => 'คณะมนุษยศาสตร์ มศว ประสานมิตร',
  ],
  [
    'id' => 7,
    'name' => 'ผู้ช่วยศาสตราจารย์ ดร. ศศิพิมล ประพินพงศกร',
    'role' => 'อาจารย์ผู้สอน',
    'role_class' => 'text-danger',
    'eng'  => 'Assistant Professor Sasipimol Prapinpongsakorn, Ph.D., FHEA',
    'img'  => 't_Sasipimol.jpg',
    'edu'  => ['ค.ด. เทคโนโลยีและสื่อสารการศึกษา'],
    'exp'  => [
      'การรู้สารสนเทศ, การรู้ดิจิทัล, พฤติกรรมสารสนเทศ, การออกแบบบริการ (service design), การศึกษาผู้ใช้, การจัดระบบทรัพยากรสารสนเทศอิเล็กทรอนิกส์/คลังสารสนเทศดิจิทัล, การวิจัยทางด้านสารสนเทศศึกษา',
      'การแก้ปัญหาเชิงสร้างสรรค์, การคิดเชิงออกแบบ, การคิดเชิงนวัตกรรม',
      'การออกแบบกิจกรรมการเรียนรู้แบบเชิงรุกและด้านเทคโนโลยีและสื่อสารการศึกษา',
    ],
    'email' => 'sasipimol@g.swu.ac.th',
    'phone' => '-',
    'office' => 'คณะมนุษยศาสตร์ มศว ประสานมิตร',
  ],
  [
    'id' => 8,
    'name' => 'อาจารย์ ดร. ศุมรรษตรา แสนวา',
    'role' => 'อาจารย์ผู้สอน',
    'role_class' => 'text-danger',
    'eng'  => 'Lecturer Sumattra Saenwa, Ph.D., FHEA',
    'img'  => 't_Sumattra.jpg',
    'edu'  => ['ศศ.บ. ภาษาอังกฤษ (เกียรตินิยมอันดับ 2)', 'ศศ.ม. บรรณารักษศาสตร์และสารสนเทศศาสตร์', 'ปร.ด. สารสนเทศศึกษา'],
    'exp'  => ['การจัดการสารสนเทศ', 'การบริหารและจัดการองค์กรสารสนเทศ', 'การจัดการความรู้'],
    'email' => 'sumattra@g.swu.ac.th',
    'phone' => '(085) 617-9617',
    'office' => 'คณะมนุษยศาสตร์ มศว ประสานมิตร',
  ],
];

function render_teacher_card($t, $IMG) {
  $e = htmlspecialchars_decode('');
  ?>
  <div class="rail-item">
    <div class="teacher-card" data-bs-toggle="modal" data-bs-target="#modalTeacher<?= $t['id'] ?>">
      <div class="profile-img-wrapper">
        <img src="<?= $IMG ?>/<?= htmlspecialchars($t['img']) ?>" alt="<?= htmlspecialchars($t['name']) ?>">
      </div>
      <h6 class="teacher-name"><?= htmlspecialchars($t['name']) ?></h6>
      <div class="teacher-role"><?= htmlspecialchars($t['role']) ?></div>
      <p class="teacher-eng"><?= htmlspecialchars($t['eng']) ?></p>
      <div class="click-hint"><i class="fas fa-mouse-pointer"></i> คลิกดูข้อมูลเพิ่มเติม</div>
    </div>
  </div>
  <?php
}

function render_teacher_modal($t, $IMG) {
  ?>
  <div class="modal fade" id="modalTeacher<?= $t['id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
        <div class="modal-header text-white" style="background-color: #c4122d;">
          <h5 class="modal-title fw-bold fs-6"><i class="fas fa-info-circle"></i> ข้อมูลคณาจารย์</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 bg-white">
          <div class="row align-items-center">
            <div class="col-md-5 text-center mb-4 mb-md-0">
              <img src="<?= $IMG ?>/<?= htmlspecialchars($t['img']) ?>" class="modal-profile-img bg-light p-3" alt="<?= htmlspecialchars($t['name']) ?>">
              <h5 class="fw-bold mt-2 mb-0 text-dark"><?= htmlspecialchars($t['name']) ?></h5>
              <p class="<?= htmlspecialchars($t['role_class']) ?> fw-bold small"><?= htmlspecialchars($t['role']) ?></p>
            </div>
            <div class="col-md-7 border-start ps-md-4">
              <ul class="info-list mb-0">
                <li>
                  <i class="fas fa-graduation-cap"></i> <b>วุฒิการศึกษา:</b>
                  <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                    <?php foreach ($t['edu'] as $ed): ?>
                      <li><?= htmlspecialchars($ed) ?></li>
                    <?php endforeach; ?>
                  </ul>
                </li>
                <li>
                  <i class="fas fa-brain"></i> <b>ความเชี่ยวชาญ:</b>
                  <ul class="mt-0 text-muted" style="list-style-type: disc; padding-left: 25px; line-height: 1.6;">
                    <?php foreach ($t['exp'] as $ex): ?>
                      <li><?= htmlspecialchars($ex) ?></li>
                    <?php endforeach; ?>
                  </ul>
                </li>
                <li><i class="fas fa-envelope"></i> <b>อีเมล:</b> <?= htmlspecialchars($t['email']) ?></li>
                <li><i class="fas fa-phone-alt"></i> <b>เบอร์ติดต่อ:</b> <?= htmlspecialchars($t['phone']) ?></li>
                <li><i class="fas fa-map-marker-alt"></i> <b>ที่ทำงาน:</b> <?= htmlspecialchars($t['office']) ?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>คณาจารย์ประจำหลักสูตร | IS SWU</title>
  <?php include __DIR__ . '/includes/public_head.php'; ?>
  <style>
    body { background: linear-gradient(180deg, #fafafa 0%, #f3f3f5 100%); }

    .page-intro {
      text-align: center; padding: 50px 16px 10px;
    }
    .page-intro .eyebrow {
      display: inline-block; background: #fff0f2; color: #c4122d;
      padding: 6px 14px; border-radius: 999px; font-size: 12px;
      font-weight: 700; letter-spacing: 1px; margin-bottom: 14px;
    }
    .page-intro h1 {
      font-weight: 800; color: #222; font-size: 34px; margin: 0 0 8px;
    }
    .page-intro h1 .accent { color: #c4122d; }
    .page-intro p { color: #777; font-size: 15px; margin: 0; }
    .page-intro .divider {
      width: 60px; height: 4px; background: #c4122d;
      border-radius: 2px; margin: 16px auto 0;
    }

    .section-title {
      font-weight: 700; color: #c4122d; font-size: 22px;
      display: flex; align-items: center; gap: 12px;
      margin: 0 0 30px; padding-left: 16px;
      border-left: 5px solid #c4122d;
    }
    .section-title .count {
      background: #fff0f2; color: #c4122d; font-size: 13px;
      padding: 3px 12px; border-radius: 999px; font-weight: 700;
      margin-left: auto;
    }

    .teacher-card {
      position: relative;
      background: #fff; border: 1px solid #eee; border-radius: 18px;
      box-shadow: 0 6px 20px rgba(0,0,0,.04);
      padding: 56px 22px 28px; text-align: center; height: 100%;
      transition: all .35s cubic-bezier(.2,.8,.2,1); cursor: pointer;
      overflow: hidden;
    }
    .teacher-card::before {
      content: ''; position: absolute; inset: 0 0 auto 0; height: 6px;
      background: linear-gradient(90deg, #c4122d, #9b111e);
      opacity: 0; transition: opacity .3s;
    }
    .teacher-card:hover {
      transform: translateY(-10px);
      border-color: transparent;
      box-shadow: 0 22px 45px rgba(196,18,45,.18);
    }
    .teacher-card:hover::before { opacity: 1; }

    .profile-img-wrapper {
      position: relative;
      width: 150px; height: 150px; border-radius: 50%;
      margin: 0 auto 22px; overflow: hidden;
      background: #f8f9fa;
      padding: 5px;
      background-image: linear-gradient(135deg, #fbe1e5, #fff);
      box-shadow: 0 8px 18px rgba(196,18,45,.15), inset 0 0 0 1px rgba(255,255,255,.9);
      transition: transform .35s ease;
    }
    .teacher-card:hover .profile-img-wrapper { transform: scale(1.04); }
    .profile-img-wrapper img {
      width: 100%; height: 100%; border-radius: 50%;
      object-fit: cover;
      border: 3px solid #fff;
    }

    .teacher-name {
      font-weight: 700; color: #222; font-size: 15.5px;
      line-height: 1.45; margin: 0 0 4px; min-height: 44px;
    }
    .teacher-role {
      display: inline-block;
      color: #c4122d; font-size: 12px; font-weight: 700;
      padding: 4px 12px; border-radius: 999px;
      background: #fff0f2; margin-bottom: 12px;
    }
    .teacher-eng {
      color: #888; font-size: 12.5px; line-height: 1.55;
      min-height: 42px; margin: 0 0 14px;
    }
    .click-hint {
      display: inline-flex; align-items: center; gap: 6px;
      font-size: 11.5px; color: #c4122d; font-weight: 700;
      padding: 6px 14px; border-radius: 999px;
      border: 1px dashed rgba(196,18,45,.4);
      transition: all .2s;
    }
    .teacher-card:hover .click-hint {
      background: #c4122d; color: #fff; border-color: #c4122d;
    }

    .modal-content { border-radius: 16px !important; }
    .modal-profile-img {
      width: 100%; max-width: 220px; border-radius: 16px;
      box-shadow: 0 8px 22px rgba(0,0,0,.12); margin-bottom: 12px;
    }
    .info-list { list-style: none; padding-left: 0; font-size: 14px; line-height: 2; color: #444; text-align: left; }
    .info-list > li { margin-bottom: 8px; }
    .info-list i { color: #c4122d; width: 25px; text-align: center; }

    .card-rail-wrap { position: relative; }
    .card-rail {
      display: flex; gap: 22px;
      overflow-x: auto; overflow-y: visible;
      scroll-snap-type: x mandatory; scroll-behavior: smooth;
      padding: 10px 4px 22px;
      scrollbar-width: none;
    }
    .card-rail::-webkit-scrollbar { display: none; }
    .card-rail > .rail-item {
      flex: 0 0 calc((100% - 22px * 4) / 5);
      scroll-snap-align: start;
      display: flex;
    }
    .card-rail > .rail-item > .teacher-card { width: 100%; }
    .card-rail.rail-3 > .rail-item { flex-basis: calc((100% - 22px * 2) / 3); }
    @media (max-width: 1200px) {
      .card-rail > .rail-item { flex-basis: calc((100% - 22px * 2) / 3); }
      .card-rail.rail-3 > .rail-item { flex-basis: calc((100% - 22px) / 2); }
    }
    @media (max-width: 768px) {
      .card-rail > .rail-item, .card-rail.rail-3 > .rail-item { flex-basis: calc((100% - 22px) / 2); }
    }
    @media (max-width: 560px) {
      .card-rail > .rail-item, .card-rail.rail-3 > .rail-item { flex-basis: 85%; }
    }
    .rail-nav {
      position: absolute; top: 50%; transform: translateY(-50%);
      width: 48px; height: 48px; border-radius: 50%;
      background: #fff; color: #c4122d; border: 1px solid #eee;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 10px 24px rgba(0,0,0,.12);
      cursor: pointer; z-index: 3; font-size: 16px;
      transition: all .2s ease;
    }
    .rail-nav:hover { background: #c4122d; color: #fff; transform: translateY(-50%) scale(1.08); }
    .rail-nav.prev { left: -20px; }
    .rail-nav.next { right: -20px; }
    .rail-nav:disabled { opacity: .35; cursor: not-allowed; transform: translateY(-50%); }
    @media (max-width: 768px) {
      .rail-nav.prev { left: 4px; }
      .rail-nav.next { right: 4px; }
    }
  </style>
</head>
<body>
<?php include __DIR__ . '/includes/public_nav.php'; ?>

<div class="page-intro">
  <span class="eyebrow"><i class="fas fa-chalkboard-teacher me-1"></i> OUR FACULTY</span>
  <h1>คณาจารย์<span class="accent">ประจำหลักสูตร</span></h1>
  <p>คณะอาจารย์ผู้สอน หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา</p>
  <div class="divider"></div>
</div>

<div class="container py-5" style="max-width: 1300px;">
  <h3 class="section-title">
    <i class="fa-solid fa-user-tie"></i> กรรมการสาขา
    <span class="count"><?= count($committee) ?> ท่าน</span>
  </h3>
  <div class="card-rail-wrap mb-5">
    <button class="rail-nav prev" data-rail="committee" aria-label="prev"><i class="fas fa-chevron-left"></i></button>
    <button class="rail-nav next" data-rail="committee" aria-label="next"><i class="fas fa-chevron-right"></i></button>
    <div class="card-rail" id="rail-committee">
      <?php foreach ($committee as $t) render_teacher_card($t, $IMG); ?>
    </div>
  </div>

  <h3 class="section-title mt-5">
    <i class="fa-solid fa-chalkboard-user"></i> อาจารย์ผู้สอน
    <span class="count"><?= count($instructors) ?> ท่าน</span>
  </h3>
  <div class="card-rail-wrap mb-5">
    <button class="rail-nav prev" data-rail="instructors" aria-label="prev"><i class="fas fa-chevron-left"></i></button>
    <button class="rail-nav next" data-rail="instructors" aria-label="next"><i class="fas fa-chevron-right"></i></button>
    <div class="card-rail rail-3" id="rail-instructors">
      <?php foreach ($instructors as $t) render_teacher_card($t, $IMG); ?>
    </div>
  </div>
</div>

<script>
  document.querySelectorAll('.rail-nav').forEach(btn => {
    btn.addEventListener('click', () => {
      const rail = document.getElementById('rail-' + btn.dataset.rail);
      if (!rail) return;
      const item = rail.querySelector('.rail-item');
      const step = item ? item.getBoundingClientRect().width + 22 : 300;
      rail.scrollBy({ left: btn.classList.contains('next') ? step : -step, behavior: 'smooth' });
    });
  });
  document.querySelectorAll('.card-rail').forEach(rail => {
    const update = () => {
      const id = rail.id.replace('rail-', '');
      const prev = document.querySelector(`.rail-nav.prev[data-rail="${id}"]`);
      const next = document.querySelector(`.rail-nav.next[data-rail="${id}"]`);
      if (prev) prev.disabled = rail.scrollLeft <= 2;
      if (next) next.disabled = rail.scrollLeft + rail.clientWidth >= rail.scrollWidth - 2;
    };
    rail.addEventListener('scroll', update);
    window.addEventListener('resize', update);
    update();
  });
</script>

<?php foreach ($committee as $t) render_teacher_modal($t, $IMG); ?>
<?php foreach ($instructors as $t) render_teacher_modal($t, $IMG); ?>

<?php include __DIR__ . '/includes/public_footer.php'; ?>
</body>
</html>
