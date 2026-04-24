<style>
  .public-footer { background: #c4122d; color: #fff; padding: 40px 0 0; margin-top: 60px; }
  .public-footer h5 { font-weight: 700; margin-bottom: 14px; font-size: 16px; }
  .public-footer a { color: #fff; opacity: .85; text-decoration: none; transition: opacity .2s; }
  .public-footer a:hover { opacity: 1; text-decoration: underline; }
  .public-footer .footer-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
  @media (max-width: 768px) { .public-footer .footer-grid { grid-template-columns: 1fr; } }
  .public-footer ul { list-style: none; padding: 0; margin: 0; }
  .public-footer ul li { padding: 4px 0; font-size: 14px; }
  .public-footer .socials a {
    display:inline-flex; width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,.15); align-items:center; justify-content:center;
    margin-right: 8px; transition: background .2s;
  }
  .public-footer .socials a:hover { background: rgba(255,255,255,.3); }
  .public-footer .footer-bottom {
    margin-top: 32px; padding: 14px 0;
    background: #9b111e; text-align: center; font-size: 13px;
  }
</style>
<footer class="public-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <h5><i class="fas fa-university me-2"></i>มหาวิทยาลัยศรีนครินทรวิโรฒ</h5>
        <p style="font-size: 14px; opacity: .9; line-height: 1.7;">
          หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา<br>
          คณะมนุษยศาสตร์ · ระบบจัดการการฝึกงาน
        </p>
        <p style="font-size: 13px; opacity: .85; margin: 0;">
          <i class="fas fa-map-marker-alt me-2"></i>114 สุขุมวิท 23 แขวงคลองเตยเหนือ<br>
          <span style="margin-left: 22px;">เขตวัฒนา กรุงเทพฯ 10110</span>
        </p>
      </div>
      <div>
        <h5><i class="fas fa-link me-2"></i>เมนูลัด</h5>
        <ul>
          <li><a href="/index.php">หน้าแรก</a></li>
          <li><a href="/activities.php">ข่าวสารกิจกรรม</a></li>
          <li><a href="/teachers.php">อาจารย์ผู้สอน</a></li>
          <li><a href="/flowchart.php">ขั้นตอนการฝึกงาน</a></li>
          <li><a href="/curriculum.php">เกี่ยวกับหลักสูตร</a></li>
        </ul>
      </div>
      <div>
        <h5><i class="fas fa-share-alt me-2"></i>ติดตามเรา</h5>
        <div class="socials">
          <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
          <a href="mailto:is@swu.ac.th" title="Email"><i class="fas fa-envelope"></i></a>
        </div>
        <p style="font-size: 13px; margin-top: 14px; opacity: .85;">
          <i class="fas fa-phone me-2"></i>02-649-5000<br>
          <i class="fas fa-envelope me-2"></i>is@swu.ac.th
        </p>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    &copy; <?= date('Y') ?> HU Internship Management System · SWU Information Studies
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
