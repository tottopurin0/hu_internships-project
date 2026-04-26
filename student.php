<?php include('includes/db_connect.php'); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คณาจารย์ประจำหลักสูตร - IS SWU</title>
    <!-- ไฟล์ CSS Bootstrap และ FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
    .student-hero {
        background: linear-gradient(135deg, rgba(196, 18, 45, 0.9), rgba(33, 37, 41, 0.9)), url('./img/berner.jpg') center/cover;
        padding: 80px 0;
        color: white;
        text-align: center;
        margin-top: 0;
        /* <--- เปลี่ยนตรงนี้เป็น 0 (แบนเนอร์จะชิดขอบพอดี) */
        margin-bottom: 40px;
    }

    /* สไตล์ปุ่ม Tab แบบหน้า Studyplan */
    .custom-tabs { display: flex; justify-content: center; gap: 15px; margin-bottom: 50px; flex-wrap: wrap; }
    .custom-btn {
        border: 2px solid #ddd;
        background: white;
        color: #333;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 700;
        transition: 0.3s;
        cursor: pointer;
    }
    .custom-btn.active {
        background: #c4122d;
        color: white;
        border-color: #c4122d;
        box-shadow: 0 10px 20px rgba(196, 18, 45, 0.2);
    }
    .custom-btn:hover:not(.active) { border-color: #c4122d; color: #c4122d; }

    /* ส่วนแสดงเนื้อหา */
    .custom-tab-pane { display: none; animation: fadeIn 0.4s ease; }
    .custom-tab-pane.active { display: block; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* การ์ดตารางรายชื่อ */
    .student-list-card {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: 0 15px 40px rgba(0,0,0,0.06);
        padding: 30px;
        border-top: 8px solid #c4122d;
    }
    .table thead th { border: none; color: #c4122d; font-weight: 700; background: #fff5f5; }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="student-hero">
        <div class="container">
            <h1 class="fw-bold mb-3"><i class="fas fa-users-viewfinder mb-2"></i><br>รายชื่อนิสิต</h1>
            <h5 class="fw-light">หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา</h5>
        </div>
    </div>

    <div class="container my-5">
        <div class="custom-tabs">
            <button class="custom-btn active" onclick="switchTab('year1')">ชั้นปีที่ 1</button>
            <button class="custom-btn" onclick="switchTab('year2')">ชั้นปีที่ 2</button>
            <button class="custom-btn" onclick="switchTab('year3')">ชั้นปีที่ 3</button>
            <button class="custom-btn" onclick="switchTab('year4')">ชั้นปีที่ 4</button>
        </div>

        <?php for($y=1; $y<=4; $y++): ?>
        <div id="year<?php echo $y; ?>" class="custom-tab-pane <?php echo ($y==1)?'active':''; ?>">
            <div class="student-list-card mx-auto" style="max-width: 900px;">
                <h4 class="fw-bold mb-4 text-center">
                    <i class="fas fa-graduation-cap me-2 text-danger"></i> รายชื่อนิสิตชั้นปีที่ <?php echo $y; ?>
                </h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="text-center" width="15%">ลำดับ</th>
                                <th width="30%">รหัสนิสิต</th>
                                <th width="55%">ชื่อ-นามสกุล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // ดึงข้อมูลจากตาราง students
                            $sql = "SELECT * FROM students WHERE year_level = $y ORDER BY student_id ASC";
                            $result = mysqli_query($conn, $sql);
                            
                            if ($result && mysqli_num_rows($result) > 0) {
                                $count = 1;
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td class='text-center text-muted'>".$count++."</td>
                                            <td class='fw-bold'>".h($row['student_id'])."</td>
                                            <td>".h($row['full_name'])."</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center py-5 text-muted'>ยังไม่มีข้อมูลรายชื่อนิสิตชั้นปีนี้</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>


    <script>
    function switchTab(tabId) {
        // ซ่อนเนื้อหาทั้งหมด
        let tabs = document.querySelectorAll('.custom-tab-pane');
        let btns = document.querySelectorAll('.custom-btn');

        tabs.forEach(tab => tab.classList.remove('active'));
        btns.forEach(btn => btn.classList.remove('active'));

        // แสดงเนื้อหาที่เลือก
        document.getElementById(tabId).classList.add('active');
        // ทำให้ปุ่มที่กดกลายเป็นสีแดง (active)
        event.currentTarget.classList.add('active');
    }
    </script>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>