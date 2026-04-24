<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/includes/auth.php';
if (is_logged_in()) {
    switch (current_role()) {
        case 'student': header('Location: student/dashboard.php'); exit;
        case 'teacher':
        case 'staff':   header('Location: staff/dashboard.php'); exit;
    }
}

// Fetch real statistics from database
$teacher_count = $conn->query('SELECT COUNT(*) as cnt FROM teacher')->fetch_assoc()['cnt'] ?? 0;
$company_count = $conn->query('SELECT COUNT(*) as cnt FROM company')->fetch_assoc()['cnt'] ?? 0;
$student_count = $conn->query('SELECT COUNT(*) as cnt FROM student')->fetch_assoc()['cnt'] ?? 0;
$years_of_service = 15; // Default value
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>หน้าแรก | IS SWU — ระบบจัดการการฝึกงาน</title>
  <?php include __DIR__ . '/includes/public_head.php'; ?>
  <style>
    body { background: linear-gradient(180deg, #fafafa 0%, #f3f3f5 100%); }

    .hero-slider {
      display: block !important;
      position: relative !important; width: 100%; overflow: hidden;
      height: clamp(380px, 68vh, 620px) !important;
      min-height: 380px !important;
      background: #0a0a0a;
    }
    .hero-slider .carousel { position: relative !important; width: 100% !important; height: 100% !important; }
    .hero-slider .carousel-inner {
      position: relative !important;
      width: 100% !important; height: 100% !important;
      overflow: hidden !important;
    }
    .hero-slider .carousel-item {
      position: absolute !important; top: 0 !important; left: 0 !important;
      width: 100% !important; height: 100% !important;
      margin: 0 !important; float: none !important;
      display: block !important;
      opacity: 0; visibility: hidden;
      transition: opacity .8s ease;
    }
    .hero-slider .carousel-item.active {
      opacity: 1 !important; visibility: visible !important; z-index: 1;
    }
    .hero-slider .carousel-item-next, .hero-slider .carousel-item-prev {
      opacity: 1 !important; visibility: visible !important; z-index: 1;
    }
    .hero-slider .carousel-item img {
      width: 100% !important; height: 100% !important;
      object-fit: cover; display: block;
      animation: heroZoom 12s ease-out infinite alternate;
    }
    @keyframes heroZoom {
      from { transform: scale(1); }
      to   { transform: scale(1.06); }
    }
    .hero-slider::before {
      content: ''; position: absolute; inset: 0; z-index: 2;
      background: linear-gradient(180deg, rgba(0,0,0,0) 55%, rgba(0,0,0,.45) 100%);
      pointer-events: none;
    }
    .carousel-control-prev, .carousel-control-next {
      width: 56px; height: 56px; top: 50%; transform: translateY(-50%);
      background: rgba(0,0,0,.28); border-radius: 50%;
      margin: 0 22px; z-index: 5; opacity: .9;
      transition: all .25s ease;
    }
    .carousel-control-prev { left: 0; }
    .carousel-control-next { right: 0; }
    .carousel-control-prev:hover, .carousel-control-next:hover {
      background: #c4122d; opacity: 1; transform: translateY(-50%) scale(1.08);
    }
    .carousel-control-prev-icon, .carousel-control-next-icon { width: 22px; height: 22px; }
    .carousel-indicators { z-index: 5; margin-bottom: 26px; gap: 6px; }
    .carousel-indicators [data-bs-target] {
      background: #fff; opacity: .5;
      width: 34px; height: 4px; border-radius: 2px; border: none;
      transition: all .25s ease;
    }
    .carousel-indicators .active { opacity: 1; background: #c4122d; width: 48px; }
    @media (max-width: 768px) {
      .hero-slider { height: 44vh; min-height: 260px; }
      .carousel-control-prev, .carousel-control-next { width: 44px; height: 44px; margin: 0 10px; }
    }
    @media (max-width: 480px) {
      .hero-slider { height: 38vh; min-height: 220px; }
      .carousel-control-prev, .carousel-control-next { width: 36px; height: 36px; margin: 0 6px; }
      .carousel-indicators { margin-bottom: 14px; }
      .carousel-indicators [data-bs-target] { width: 22px; }
      .carousel-indicators .active { width: 34px; }
    }
    @media (max-width: 360px) {
      .hero-slider { height: 34vh; min-height: 200px; }
    }

    .page-intro {
      padding: 70px 16px 30px;
      text-align: center;
      position: relative;
    }
    .page-intro .eyebrow {
      display: inline-block;
      background: #fff0f2;
      color: #c4122d;
      padding: 6px 18px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 2px;
      margin-bottom: 16px;
      border: 1px solid #fddfe3;
    }
    .page-intro h1 {
      font-weight: 800;
      font-size: 36px;
      color: #1a1a1a;
      margin-bottom: 10px;
    }
    .page-intro h1 .accent { color: #c4122d; }
    .page-intro p {
      color: #666;
      font-size: 15.5px;
      max-width: 700px;
      margin: 0 auto;
      line-height: 1.75;
    }
    .page-intro .divider {
      width: 60px; height: 3px;
      background: linear-gradient(90deg, #c4122d, #9b111e);
      margin: 20px auto 0;
      border-radius: 2px;
    }

    .section { padding: 70px 40px; }
    .section .wide { max-width: 1600px; margin: 0 auto; }
    .section .row { align-items: stretch; }
    .section .row > [class*="col"] { display: flex; }
    .section .row > [class*="col"] > * { width: 100%; }
    @media (max-width: 768px) { .section { padding: 50px 18px; } }

    .card-rail-wrap { position: relative; }
    .card-rail {
      display: flex; gap: 22px;
      overflow-x: auto; overflow-y: visible;
      scroll-snap-type: x mandatory; scroll-behavior: smooth;
      padding: 8px 4px 18px;
      scrollbar-width: none;
    }
    .card-rail::-webkit-scrollbar { display: none; }
    .card-rail > .rail-item {
      flex: 0 0 calc((100% - 22px * 3) / 4);
      scroll-snap-align: start;
      display: flex;
    }
    .card-rail.rail-3 > .rail-item { flex-basis: calc((100% - 22px * 2) / 3); }
    @media (max-width: 1100px) {
      .card-rail > .rail-item { flex-basis: calc((100% - 22px * 1) / 2); }
      .card-rail.rail-3 > .rail-item { flex-basis: calc((100% - 22px * 1) / 2); }
    }
    @media (max-width: 640px) {
      .card-rail > .rail-item, .card-rail.rail-3 > .rail-item { flex-basis: 88%; }
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

    .banner-section { display: block !important; padding: 70px 40px; background: #fff; border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
    @media (max-width: 768px) { .banner-section { padding: 36px 12px; } }
    @media (max-width: 480px) { .banner-section { padding: 24px 8px; } }
    .banner-carousel {
      display: block !important;
      position: relative; max-width: 1400px; margin: 0 auto;
      border-radius: 22px; overflow: hidden;
      box-shadow: 0 18px 40px rgba(0,0,0,.14);
      background: #111;
    }
    .banner-carousel .carousel, .banner-carousel .carousel-inner { width: 100%; height: auto; position: relative; }
    .banner-carousel .carousel-item { position: relative; width: 100%; }
    .banner-carousel .carousel-item.active,
    .banner-carousel .carousel-item-next,
    .banner-carousel .carousel-item-prev { display: block; }
    .banner-carousel .carousel-item img {
      width: 100%; height: auto; max-height: 560px;
      object-fit: contain; display: block;
      background: #111;
    }
    .banner-carousel .carousel-item::after {
      content: ''; position: absolute; left: 0; right: 0; bottom: 0; height: 55%;
      background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,.75) 100%);
      pointer-events: none;
    }
    .banner-carousel .banner-caption {
      position: absolute; bottom: 30px; left: 40px; right: 40px;
      color: #fff; max-width: 560px; z-index: 3;
    }
    .banner-carousel .banner-caption .tag {
      display: inline-block; background: #c4122d; padding: 5px 14px;
      border-radius: 999px; font-size: 11.5px; font-weight: 800; letter-spacing: 1.2px; margin-bottom: 14px;
    }
    .banner-carousel .banner-caption h3 {
      font-weight: 800; font-size: 32px; line-height: 1.3; margin-bottom: 10px;
      text-shadow: 0 2px 10px rgba(0,0,0,.35);
    }
    .banner-carousel .banner-caption p { opacity: .92; font-size: 15px; margin-bottom: 16px; }
    .banner-carousel .banner-caption .btn-banner {
      background: #fff; color: #c4122d; padding: 10px 22px; border-radius: 999px;
      font-weight: 800; text-decoration: none; font-size: 14px;
      display: inline-flex; align-items: center; gap: 8px;
      transition: all .2s ease;
    }
    .banner-carousel .banner-caption .btn-banner:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(0,0,0,.25); }
    .banner-carousel .carousel-control-prev, .banner-carousel .carousel-control-next {
      width: 48px; height: 48px; margin: 0 18px;
      background: rgba(255,255,255,.18); border-radius: 50%;
    }
    .banner-carousel .carousel-control-prev:hover, .banner-carousel .carousel-control-next:hover { background: #c4122d; }
    .banner-carousel .carousel-indicators { margin-bottom: 18px; gap: 6px; }
    .banner-carousel .carousel-indicators [data-bs-target] {
      width: 28px; height: 4px; border-radius: 2px; background: #fff; opacity: .5; border: none;
    }
    .banner-carousel .carousel-indicators .active { background: #c4122d; opacity: 1; width: 40px; }
    @media (max-width: 640px) {
      .banner-carousel .banner-caption { left: 16px; right: 16px; bottom: 18px; max-width: none; }
      .banner-carousel .banner-caption h3 { font-size: 18px; margin-bottom: 6px; }
      .banner-carousel .banner-caption p { font-size: 12.5px; margin-bottom: 10px; }
      .banner-carousel .banner-caption .tag { font-size: 10px; padding: 4px 10px; margin-bottom: 8px; }
      .banner-carousel .banner-caption .btn-banner { padding: 8px 16px; font-size: 12.5px; }
      .banner-carousel .carousel-control-prev, .banner-carousel .carousel-control-next { width: 38px; height: 38px; margin: 0 8px; }
    }
    @media (max-width: 380px) {
      .banner-carousel .banner-caption h3 { font-size: 17px; }
      .banner-carousel .banner-caption p { display: none; }
    }
    .section-title-wrap { text-align: center; margin-bottom: 50px; }
    .section-title {
      display: inline-flex; align-items: center; gap: 14px;
      font-weight: 800; color: #1a1a1a; font-size: 30px;
      margin: 0;
    }
    .section-title .icon {
      width: 48px; height: 48px; border-radius: 50%;
      background: linear-gradient(135deg, #c4122d, #9b111e);
      color: #fff; display:inline-flex; align-items:center; justify-content:center;
      font-size: 20px;
      box-shadow: 0 6px 16px rgba(196,18,45,.25);
    }
    .section-sub { color: #666; margin-top: 12px; font-size: 15.5px; }

    .feature-card {
      background: #fff; border-radius: 20px; padding: 40px 28px;
      width: 100%; display: flex; flex-direction: column;
      text-align: center;
      box-shadow: 0 4px 18px rgba(0,0,0,.04);
      transition: transform .3s ease, box-shadow .3s ease;
      border: 1px solid #eee;
      position: relative;
      overflow: hidden;
    }
    .feature-card p { margin-top: auto; }
    .feature-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 4px;
      background: linear-gradient(90deg, #c4122d, #9b111e);
      transform: scaleX(0);
      transform-origin: left;
      transition: transform .35s ease;
    }
    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 22px 44px rgba(196,18,45,.14);
      border-color: #fddfe3;
    }
    .feature-card:hover::before { transform: scaleX(1); }
    .feature-icon {
      width: 84px; height: 84px; border-radius: 24px;
      background: linear-gradient(135deg, #fff0f2, #fdd8dd);
      color: #c4122d;
      display: flex; align-items: center; justify-content: center;
      font-size: 34px;
      margin: 0 auto 22px;
      transition: all .3s ease;
    }
    .feature-card:hover .feature-icon {
      background: linear-gradient(135deg, #c4122d, #9b111e);
      color: #fff;
      transform: rotate(-6deg) scale(1.05);
      box-shadow: 0 12px 26px rgba(196,18,45,.34);
    }
    .feature-card h5 { font-weight: 800; color: #1a1a1a; margin-bottom: 10px; font-size: 18px; }
    .feature-card p { color: #666; font-size: 14.5px; line-height: 1.75; margin: 0; }

    .news-section { background: #fff; border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
    .news-card {
      background: #fff; border-radius: 18px; overflow: hidden;
      width: 100%;
      box-shadow: 0 4px 18px rgba(0,0,0,.05);
      transition: transform .3s ease, box-shadow .3s ease;
      display: flex; flex-direction: column;
      border: 1px solid #eee;
    }
    .news-section a.text-decoration-none { display: flex; width: 100%; }
    .news-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 22px 42px rgba(0,0,0,.12);
    }
    .news-thumb {
      height: 240px;
      overflow: hidden;
      position: relative;
    }
    .news-thumb img {
      width: 100%; height: 100%; object-fit: cover;
      transition: transform .5s ease;
    }
    .news-card:hover .news-thumb img { transform: scale(1.08); }
    .news-thumb::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,.35) 100%);
    }
    .news-tag {
      position: absolute; top: 14px; left: 14px; z-index: 2;
      background: #c4122d; color: #fff;
      padding: 5px 14px; border-radius: 999px;
      font-size: 11.5px; font-weight: 700; letter-spacing: .5px;
    }
    .news-tag.b2 { background: #0d6efd; }
    .news-tag.b3 { background: #198754; }
    .news-card .body { padding: 20px 22px 22px; flex: 1; display: flex; flex-direction: column; }
    .news-card h6 { font-weight: 800; color: #1a1a1a; line-height: 1.5; font-size: 15.5px; margin-bottom: 8px; }
    .news-card p { color: #666; font-size: 13.5px; flex: 1; line-height: 1.65; margin-bottom: 12px; }
    .news-link {
      color: #c4122d; font-weight: 700; font-size: 13px;
      display: inline-flex; align-items: center; gap: 6px;
      transition: gap .25s ease;
    }
    .news-card:hover .news-link { gap: 10px; }
    .news-link.b2 { color: #0d6efd; }
    .news-link.b3 { color: #198754; }

    .stats-band {
      background: #fff;
      padding: 40px 16px;
      border-top: 1px solid #eee;
    }
    .stats-band .row {
      display: flex !important;
      flex-wrap: nowrap !important;
      gap: 0 !important;
    }
    .stats-band .col-3 {
      display: flex !important;
      flex: 1 1 25% !important;
      min-width: 0 !important;
      flex-basis: 25% !important;
    }
    .stat-item {
      text-align: center;
      padding: 16px 8px;
      width: 100%;
    }
    .stat-number {
      font-size: 38px; font-weight: 800;
      color: #c4122d;
      line-height: 1;
      margin-bottom: 8px;
    }
    .stat-label {
      color: #666; font-size: 13.5px; font-weight: 600;
      letter-spacing: .3px;
    }
    .stat-divider {
      width: 1px; background: #eee;
    }

    .cta-band {
      position: relative;
      background: linear-gradient(135deg, #c4122d 0%, #9b111e 55%, #7a0d18 100%);
      color: #fff;
      padding: 140px 20px;
      overflow: visible;
    }
    .cta-band::before {
      content: '';
      position: absolute; inset: 0;
      background:
        radial-gradient(circle at 12% 18%, rgba(255,255,255,.09) 0, transparent 28%),
        radial-gradient(circle at 88% 80%, rgba(255,255,255,.07) 0, transparent 30%);
      pointer-events: none;
    }
    .cta-band::after {
      content: '';
      position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.05) 1px, transparent 1px);
      background-size: 48px 48px;
      opacity: .35; pointer-events: none;
    }
    .cta-band .cta-wrap {
      position: relative; z-index: 2;
      max-width: 1200px; margin: 0 auto;
      display: grid; grid-template-columns: 1fr; gap: 48px;
      align-items: center;
    }

    .cta-left .cta-eyebrow {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(255,255,255,.12);
      border: 1px solid rgba(255,255,255,.25);
      padding: 7px 16px; border-radius: 999px;
      font-size: 12px; font-weight: 700; letter-spacing: 2px;
      margin-bottom: 18px; backdrop-filter: blur(6px);
    }
    .cta-left .cta-eyebrow i { color: #ffd56b; font-size: 11px; }
    .cta-left h3 {
      font-weight: 800; font-size: 40px; line-height: 1.2;
      margin-bottom: 14px; letter-spacing: -.3px;
    }
    .cta-left h3 .highlight {
      background: linear-gradient(90deg, #ffd56b, #ffb347);
      -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .cta-left p { opacity: .92; font-size: 16px; line-height: 1.75; margin-bottom: 28px; max-width: 520px; }
    .cta-benefits { list-style: none; padding: 0; margin: 0 0 30px; display: grid; gap: 10px; }
    .cta-benefits li {
      display: flex; align-items: center; gap: 12px;
      font-size: 14.5px; font-weight: 500;
    }
    .cta-benefits li i {
      width: 26px; height: 26px; border-radius: 50%;
      background: rgba(255,255,255,.18);
      display: inline-flex; align-items: center; justify-content: center;
      font-size: 11px; color: #fff; flex-shrink: 0;
      border: 1px solid rgba(255,255,255,.3);
    }
    .cta-actions { display: flex; gap: 14px; flex-wrap: wrap; }
    .btn-cta {
      background: #fff; color: #c4122d;
      padding: 14px 30px; border-radius: 999px;
      font-weight: 800; text-decoration: none;
      display: inline-flex; align-items: center; gap: 10px;
      transition: all .25s ease;
      box-shadow: 0 12px 28px rgba(0,0,0,.22);
      font-size: 15px;
    }
    .btn-cta:hover {
      transform: translateY(-3px);
      box-shadow: 0 18px 34px rgba(0,0,0,.3);
      color: #9b111e;
    }
    .btn-cta-ghost {
      background: transparent; color: #fff;
      padding: 14px 28px; border-radius: 999px;
      font-weight: 700; text-decoration: none;
      border: 1.5px solid rgba(255,255,255,.5);
      display: inline-flex; align-items: center; gap: 10px;
      transition: all .25s ease; font-size: 15px;
    }
    .btn-cta-ghost:hover { background: rgba(255,255,255,.12); color: #fff; border-color: #fff; transform: translateY(-3px); }

    .cta-right {
      position: relative;
      background: rgba(255,255,255,.08);
      border: 1px solid rgba(255,255,255,.2);
      border-radius: 24px;
      padding: 32px;
      backdrop-filter: blur(10px);
    }
    .cta-right h4 {
      font-size: 17px; font-weight: 800; margin-bottom: 22px;
      display: flex; align-items: center; gap: 10px;
    }
    .cta-right h4 i { color: #ffd56b; }
    .cta-steps { display: grid; gap: 16px; }
    .cta-step {
      display: flex; gap: 14px; align-items: flex-start;
      padding: 14px; border-radius: 14px;
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.1);
      transition: all .25s ease;
    }
    .cta-step:hover { background: rgba(255,255,255,.14); transform: translateX(4px); }
    .cta-step .num {
      width: 36px; height: 36px; border-radius: 12px;
      background: #fff; color: #c4122d;
      display: flex; align-items: center; justify-content: center;
      font-weight: 800; font-size: 15px; flex-shrink: 0;
      box-shadow: 0 6px 14px rgba(0,0,0,.2);
    }
    .cta-step .txt strong { display: block; font-size: 14.5px; font-weight: 700; margin-bottom: 2px; }
    .cta-step .txt span { font-size: 12.5px; opacity: .82; }
  </style>
</head>
<body>
<?php include __DIR__ . '/includes/public_nav.php'; ?>

<div class="banner-section">
  <div class="banner-carousel">
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="/assets/img/openHU.jpg" alt="Open House">
          <div class="banner-caption">
            <span class="tag">OPEN HOUSE</span>
            <h3>เปิดบ้านสารสนเทศศึกษา</h3>
            <p>รู้จักหลักสูตร พบอาจารย์ รุ่นพี่ และโอกาสการฝึกงานในบริษัทชั้นนำ</p>
            <a href="activities.php" class="btn-banner">ดูรายละเอียด <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/assets/img/fristday.jpg" alt="First Day">
          <div class="banner-caption">
            <span class="tag">ปฐมนิเทศ</span>
            <h3>ต้อนรับนิสิตใหม่ IS SWU</h3>
            <p>เตรียมพร้อมก้าวแรกสู่ชีวิตมหาวิทยาลัยกับหลักสูตรสารสนเทศศึกษา</p>
            <a href="activities.php" class="btn-banner">อ่านต่อ <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/assets/img/SPN o4 work.jpg" alt="Workshop">
          <div class="banner-caption">
            <span class="tag">WORKSHOP</span>
            <h3>อบรมทักษะก่อนฝึกงาน</h3>
            <p>เสริมความพร้อมด้านเทคนิคและ Soft Skills ให้นิสิตก่อนออกสู่สนามจริง</p>
            <a href="activities.php" class="btn-banner">ดูกิจกรรม <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/assets/img/satapanaHU.jpg" alt="HU Day">
          <div class="banner-caption">
            <span class="tag">สถาปนาคณะ</span>
            <h3>ครบรอบวันสถาปนาคณะมนุษยศาสตร์</h3>
            <p>ร่วมเป็นส่วนหนึ่งของประวัติศาสตร์และกิจกรรมอันทรงคุณค่า</p>
            <a href="activities.php" class="btn-banner">เพิ่มเติม <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</div>

<div class="hero-slider">
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4500">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="/assets/img/welcome.jpg" alt="Welcome">
      </div>
      <div class="carousel-item">
        <img src="/assets/img/sirigit.jpg" alt="SWU Campus">
      </div>
      <div class="carousel-item">
        <img src="/assets/img/sornkran.jpg" alt="Festival">
      </div>
      <div class="carousel-item">
        <img src="/assets/img/berner.jpg" alt="Banner">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</div>

<div class="page-intro">
  <div class="container">
    <span class="eyebrow">WELCOME TO IS SWU</span>
    <h1>ระบบจัดการ<span class="accent">การฝึกงาน</span></h1>
    <p>หลักสูตรสารสนเทศศึกษา คณะมนุษยศาสตร์ มหาวิทยาลัยศรีนครินทรวิโรฒ<br>ให้บริการจัดการการฝึกงานของนิสิตแบบครบวงจรในรูปแบบออนไลน์</p>
    <div class="divider"></div>
  </div>
</div>

<div class="section">
  <div class="wide">
    <div class="section-title-wrap">
      <h2 class="section-title"><span class="icon"><i class="fas fa-cogs"></i></span> ฟังก์ชันหลักของระบบ</h2>
      <p class="section-sub">ครอบคลุมทุกขั้นตอนของการฝึกงาน ตั้งแต่ยื่นคำขอจนถึงประเมินผล</p>
    </div>
    <div class="card-rail-wrap">
      <button class="rail-nav prev" data-rail="features" aria-label="prev"><i class="fas fa-chevron-left"></i></button>
      <button class="rail-nav next" data-rail="features" aria-label="next"><i class="fas fa-chevron-right"></i></button>
      <div class="card-rail" id="rail-features">
        <div class="rail-item">
          <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-file-signature"></i></div>
            <h5>ยื่นคำขอออนไลน์</h5>
            <p>นิสิตยื่นคำขอฝึกงาน เลือกบริษัท ตำแหน่ง และอาจารย์ที่ปรึกษาได้ทุกที่ทุกเวลา</p>
          </div>
        </div>
        <div class="rail-item">
          <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-check-double"></i></div>
            <h5>อนุมัติโดยอาจารย์</h5>
            <p>อาจารย์ที่ปรึกษาตรวจสอบและอนุมัติคำขอ พร้อมระบุหมายเหตุได้</p>
          </div>
        </div>
        <div class="rail-item">
          <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-envelope-open-text"></i></div>
            <h5>ออกใบส่งตัว</h5>
            <p>เจ้าหน้าที่ออกใบส่งตัวอิเล็กทรอนิกส์ พร้อมพิมพ์เอกสารทางการได้ทันที</p>
          </div>
        </div>
        <div class="rail-item">
          <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-clipboard-check"></i></div>
            <h5>บันทึกนิเทศ</h5>
            <p>อาจารย์บันทึกการนิเทศและประเมินผลการฝึกงาน พร้อมสรุปสถิติผ่านรายงาน</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="stats-band">
  <div class="wide" style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
    <div class="row align-items-center">
      <div class="col-3">
        <div class="stat-item">
          <div class="stat-number"><?= $teacher_count ?>+</div>
          <div class="stat-label">อาจารย์ผู้สอน</div>
        </div>
      </div>
      <div class="col-3">
        <div class="stat-item">
          <div class="stat-number"><?= $company_count ?>+</div>
          <div class="stat-label">บริษัทพันธมิตร</div>
        </div>
      </div>
      <div class="col-3">
        <div class="stat-item">
          <div class="stat-number"><?= $student_count ?>+</div>
          <div class="stat-label">นิสิตฝึกงาน</div>
        </div>
      </div>
      <div class="col-3">
        <div class="stat-item">
          <div class="stat-number"><?= $years_of_service ?>+</div>
          <div class="stat-label">ปีที่ให้บริการ</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="section news-section">
  <div class="wide">
    <div class="section-title-wrap">
      <h2 class="section-title"><span class="icon"><i class="fas fa-bullhorn"></i></span> ข่าวสารและกิจกรรมล่าสุด</h2>
      <p class="section-sub">ติดตามข่าวและกิจกรรมของหลักสูตรได้ที่นี่</p>
    </div>
    <div class="card-rail-wrap">
      <button class="rail-nav prev" data-rail="news" aria-label="prev"><i class="fas fa-chevron-left"></i></button>
      <button class="rail-nav next" data-rail="news" aria-label="next"><i class="fas fa-chevron-right"></i></button>
      <div class="card-rail rail-3" id="rail-news">
        <div class="rail-item">
          <a href="activities.php" class="text-decoration-none" style="width:100%">
            <div class="news-card">
              <div class="news-thumb">
                <span class="news-tag">ผลงาน</span>
                <img src="/assets/img/sho02.jpg" alt="Cyber Guardians">
              </div>
              <div class="body">
                <h6>Cyber Guardians & Digital Art Challenge</h6>
                <p>กิจกรรมแข่งขันสร้างความตระหนักรู้ด้านคดีภัยออนไลน์ สำหรับนิสิตปี 4</p>
                <span class="news-link">อ่านเพิ่มเติม <i class="fas fa-arrow-right"></i></span>
              </div>
            </div>
          </a>
        </div>
        <div class="rail-item">
          <a href="activities.php" class="text-decoration-none" style="width:100%">
            <div class="news-card">
              <div class="news-thumb">
                <span class="news-tag b2">วิชาการ</span>
                <img src="/assets/img/TKpark.jpg" alt="Learning Center">
              </div>
              <div class="body">
                <h6>โครงการพัฒนาแหล่งเรียนรู้สู่ชุมชน</h6>
                <p>ณ โรงเรียนวัดวังปลาจีด และโรงเรียนวัดท่าช้าง จ.นครนายก</p>
                <span class="news-link b2">อ่านเพิ่มเติม <i class="fas fa-arrow-right"></i></span>
              </div>
            </div>
          </a>
        </div>
        <div class="rail-item">
          <a href="activities.php" class="text-decoration-none" style="width:100%">
            <div class="news-card">
              <div class="news-thumb">
                <span class="news-tag b3">กิจกรรมนิสิต</span>
                <img src="/assets/img/ISspot.jpg" alt="IS Day">
              </div>
              <div class="body">
                <h6>IS DAY: โครงการสานสัมพันธ์สารสนเทศศึกษา</h6>
                <p>กิจกรรมเสริมสร้างความสัมพันธ์อันดีระหว่างนิสิตทุกชั้นปี</p>
                <span class="news-link b3">อ่านเพิ่มเติม <i class="fas fa-arrow-right"></i></span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="text-center mt-5">
      <a href="activities.php" class="btn btn-danger rounded-pill px-4 py-2 fw-bold">ดูข่าวสารทั้งหมด <i class="fas fa-angle-right ms-1"></i></a>
    </div>
  </div>
</div>

<div class="cta-band">
  <div class="cta-wrap">
    <div class="cta-left">
      <span class="cta-eyebrow"><i class="fas fa-bolt"></i> START YOUR JOURNEY</span>
      <h3>พร้อมเริ่ม<span class="highlight">ฝึกงาน</span>หรือยัง?</h3>
      <p>เริ่มต้นเส้นทางฝึกงานของคุณวันนี้ ระบบช่วยจัดการทุกขั้นตอน ตั้งแต่ยื่นคำขอ อนุมัติ ไปจนถึงการประเมินผล ทำได้ครบจบในที่เดียว</p>
      <ul class="cta-benefits">
        <li><i class="fas fa-check"></i> ยื่นคำขอออนไลน์ สะดวก รวดเร็ว ทุกที่ทุกเวลา</li>
        <li><i class="fas fa-check"></i> ติดตามสถานะคำขอแบบเรียลไทม์</li>
        <li><i class="fas fa-check"></i> มีอาจารย์ที่ปรึกษาดูแลตลอดการฝึกงาน</li>
      </ul>
      <div class="cta-actions">
        <a href="/portal.php" class="btn-cta"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</a>
        <a href="/register_student.php" class="btn-cta-ghost"><i class="fas fa-user-plus"></i> สมัครสมาชิก</a>
      </div>
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
<?php include __DIR__ . '/includes/public_footer.php'; ?>
</body>
</html>
