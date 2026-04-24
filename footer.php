<style>
/* ================= ตกแต่งเฉพาะ Footer ================= */
.swu-footer-custom {
    background-color: #c4122d;
    color: white;
    padding-top: 60px;
}

.footer-title {
    font-weight: 800;
    font-size: 16px;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 12px;
}

.footer-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 1px;
    background-color: rgba(255, 255, 255, 0.2);
}

.footer-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-list li {
    margin-bottom: 15px;
}

.footer-list a {
    color: white;
    text-decoration: none;
    font-size: 14.5px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}

.footer-list a:hover {
    color: #ffcccc;
    transform: translateX(5px);
}

.contact-info-text {
    font-size: 14px;
    line-height: 1.9;
    font-weight: 500;
}

/* โซเชียลไอคอน เฟสบุ๊ค & ไอจี */
.social-icon-box {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.social-icon-box>a.social-link {
    color: white;
    font-size: 28px;
    transition: 0.3s;
    text-decoration: none;
}

.social-icon-box>a.social-link:hover {
    transform: translateY(-4px);
    color: #ffcccc;
}

.footer-bottom {
    background-color: #a60f26;
    padding: 15px 0;
    font-size: 12.5px;
    font-weight: 500;
    text-align: center;
    margin-top: 50px;
}

/* ================= E-MAIL แบบไม่มีกรอบ (ไอคอนซองจดหมาย) ================= */
.simple-email-box {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: white;
    margin-left: 10px;
    transition: transform 0.3s ease;
}

.simple-email-box:hover {
    transform: translateY(-3px);
    /* ลอยขึ้นตอนชี้เมาส์ */
}

/* แก้ไขไอคอนเป็นรูปซองจดหมาย */
.simple-email-box .email-icon {
    font-size: 32px;
    /* ปรับขนาดให้พอดีกับซองจดหมาย */
    color: rgba(255, 255, 255, 0.8);
    /* สีขาวโปร่งแสง */
    margin-right: 12px;
    line-height: 1;
}

.simple-email-box .email-text-small {
    display: block;
    color: rgba(255, 255, 255, 0.7);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 2px;
}

.simple-email-box .email-text-main {
    color: white;
    font-size: 16px;
    /* ปรับให้พอดีกับความสวยงาม */
    font-weight: 700;
}
</style>
<footer class="swu-footer-custom mt-auto">
    <div class="container px-lg-5">
        <div class="row justify-content-between g-5">

            <!-- ================= คอลัมน์ที่ 1 : โลโก้และที่อยู่ ================= -->
            <div class="col-lg-4 col-md-12">
                <!-- โลโก้ มศว สีขาวล้วนพื้นใส -->
                <img src="./img/swuLogo2.png" width="100" class="mb-4" alt="SWU Logo">

                <div class="contact-info-text mb-4">
                    114 สุขุมวิท 23, กรุงเทพ 10110<br>
                    โทรศัพท์: +66 2-649-5000<br>
                    แฟกซ์: +66 2 258 4007
                </div>
            </div>

            <!-- ================= คอลัมน์ที่ 2 : ข้อมูลทั่วไป ================= -->
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-title">ข้อมูลทั่วไป</h6>
                <ul class="footer-list">
                    <li><a href="https://www.swu.ac.th/" target="_blank">มหาวิทยาลัยศรีนครินทรวิโรฒ</a></li>
                    <li><a href="https://admission.swu.ac.th/admissions2/" target="_blank">Admission</a></li>
                    <li><a href="https://hpd.hu.swu.ac.th/" target="_blank">คณะมนุษยศาสตร์</a></li>
                </ul>
            </div>

            <!-- ================= คอลัมน์ที่ 3 : ติดตามเรา (โซเชียล + อีเมลลอยตัว) ================= -->
            <div class="col-lg-5 col-md-6">
                <h6 class="footer-title">ติดตามเรา</h6>

                <div class="social-icon-box mt-3">

                    <!-- โซเชียล Facebook -->
                    <a href="https://www.facebook.com/isswuofficial" target="_blank" title="Facebook IS SWU"
                        class="social-link">
                        <i class="fab fa-facebook"></i>
                    </a>

                    <!-- โซเชียล Instagram (ใส่เส้นคั่นด้านขวาไว้แบ่งโซนกับอีเมล) -->
                    <a href="https://www.instagram.com/is.hmswu?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                        target="_blank" title="Instagram IS SWU" class="social-link border-end pe-4"
                        style="border-color: rgba(255,255,255,0.3) !important;">
                        <i class="fab fa-instagram"></i>
                    </a>

                    <!-- อีเมล (เปลี่ยนเป็นไอคอนซองจดหมาย) -->
                    <a href="mailto:is@g.swu.ac.th" class="simple-email-box ps-2">
                        <div class="email-icon">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div style="line-height: 1.1;">
                            <span class="email-text-small">E-MAIL</span>
                            <span class="email-text-main">is@g.swu.ac.th</span>
                        </div>
                    </a>
                    <div class="mt-2">
                        <ul class="footer-list ">
                            <a href="developers.php" class="developer-link fw-bold"
                                style="color: white; text-decoration: none; font-size: 16px; transition: all 0.3s ease;">
                                <i class="fas fa-laptop-code me-2"></i>คณะผู้จัดทำ (Developers)
                            </a>
                        </ul>
                    </div>





                </div>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            คณะมนุษยศาสตร์ หลักสูตรฯ สารสนเทศศึกษา |  Faculty of Humanities, Information Studies
        </div>
    </div>
</footer>