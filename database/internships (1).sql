-- =====================================================
-- Internship Management System - MySQL Schema
-- =====================================================

-- สร้างและเลือกฐานข้อมูล
CREATE DATABASE IF NOT EXISTS `internships`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `internships`;

SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- 1. Master Data Tables (ข้อมูลหลัก)
-- =====================================================

-- 1.1 ข้อมูลบริษัท
CREATE TABLE IF NOT EXISTS `company` (
  `company_id` INT NOT NULL AUTO_INCREMENT COMMENT 'รหัสบริษัท',
  `company_name` VARCHAR(200) NOT NULL COMMENT 'ชื่อบริษัท',
  `industry` VARCHAR(100) DEFAULT NULL COMMENT 'ประเภทอุตสาหกรรม / หมวดหมู่ธุรกิจ',
  `address` TEXT COMMENT 'ที่อยู่',
  `province` VARCHAR(100) DEFAULT NULL COMMENT 'จังหวัด',
  `phone` VARCHAR(20) DEFAULT NULL COMMENT 'เบอร์ติดต่อบริษัท',
  `email` VARCHAR(150) DEFAULT NULL COMMENT 'อีเมลบริษัท',
  `website` VARCHAR(200) DEFAULT NULL COMMENT 'เว็บไซต์',
  `contact_person_name` VARCHAR(150) DEFAULT NULL COMMENT 'ชื่อผู้ติดต่อ (พี่เลี้ยง, HR)',
  `contact_person_phone` VARCHAR(20) DEFAULT NULL COMMENT 'เบอร์ผู้ติดต่อ (พี่เลี้ยง, HR)',
  `contact_person_email` VARCHAR(150) DEFAULT NULL COMMENT 'อีเมลผู้ติดต่อ (พี่เลี้ยง, HR)',
  `status` VARCHAR(20) DEFAULT 'active' COMMENT 'สถานะการใช้งาน (active/inactive)',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างข้อมูล',
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'วันที่อัปเดตข้อมูล',
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลบริษัทสถานประกอบการ';

-- 1.2 สถานะคำร้อง
CREATE TABLE IF NOT EXISTS `status_master` (
  `Status_ID` INT NOT NULL COMMENT 'รหัสสถานะ',
  `Status_Name` VARCHAR(100) NOT NULL COMMENT 'ชื่อสถานะ (เช่น รับเรื่อง, อนุมัติแล้ว)',
  PRIMARY KEY (`Status_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตารางเก็บข้อมูลชื่อสถานะคำร้อง';

-- =====================================================
-- 2. User Tables (ข้อมูลผู้ใช้งาน)
-- =====================================================

-- 2.1 เจ้าหน้าที่คณะ
CREATE TABLE IF NOT EXISTS `faculty_staff` (
  `faculty_staff_id` INT NOT NULL AUTO_INCREMENT COMMENT 'รหัสเจ้าหน้าที่',
  `username` VARCHAR(50) NOT NULL UNIQUE COMMENT 'ชื่อผู้ใช้งาน (Username)',
  `password` VARCHAR(255) NOT NULL COMMENT 'รหัสผ่าน (Hashed)',
  `first_name` VARCHAR(100) NOT NULL COMMENT 'ชื่อจริง',
  `last_name` VARCHAR(100) NOT NULL COMMENT 'นามสกุล',
  `faculty` VARCHAR(100) DEFAULT NULL COMMENT 'คณะ',
  `position` VARCHAR(100) DEFAULT NULL COMMENT 'ตำแหน่งการทำงาน',
  `email` VARCHAR(150) NOT NULL COMMENT 'อีเมล',
  `phone` VARCHAR(15) DEFAULT NULL COMMENT 'เบอร์ติดต่อ',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างข้อมูล',
  PRIMARY KEY (`faculty_staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลเจ้าหน้าที่คณะ';

-- 2.2 ข้อมูลอาจารย์
CREATE TABLE IF NOT EXISTS `teacher` (
  `teacher_id` INT NOT NULL AUTO_INCREMENT COMMENT 'รหัสอาจารย์',
  `username` VARCHAR(50) NOT NULL UNIQUE COMMENT 'ชื่อผู้ใช้งาน',
  `password` VARCHAR(255) NOT NULL COMMENT 'รหัสผ่าน (Hashed)',
  `first_name` VARCHAR(100) NOT NULL COMMENT 'ชื่อจริง',
  `last_name` VARCHAR(100) NOT NULL COMMENT 'นามสกุล',
  `department` VARCHAR(100) DEFAULT NULL COMMENT 'ภาควิชา',
  `email` VARCHAR(150) NOT NULL COMMENT 'อีเมล',
  `phone` VARCHAR(15) DEFAULT NULL COMMENT 'เบอร์ติดต่อ',
  `academic_position` VARCHAR(100) DEFAULT NULL COMMENT 'ตำแหน่งทางวิชาการ',
  `expertise` TEXT COMMENT 'ความเชี่ยวชาญ',
  `profile_image` VARCHAR(255) DEFAULT NULL COMMENT 'รูปโปรไฟล์',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างข้อมูล',
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลอาจารย์';

-- 2.3 ข้อมูลนิสิต
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` INT NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับที่นิสิตในระบบ',
  `student_code` VARCHAR(20) NOT NULL UNIQUE COMMENT 'รหัสนิสิตประจำตัว',
  `password` VARCHAR(255) NOT NULL COMMENT 'รหัสผ่าน (Hashed)',
  `first_name` VARCHAR(100) NOT NULL COMMENT 'ชื่อจริง',
  `last_name` VARCHAR(100) NOT NULL COMMENT 'นามสกุล',
  `email` VARCHAR(150) NOT NULL COMMENT 'อีเมล',
  `phone` VARCHAR(15) DEFAULT NULL COMMENT 'เบอร์ติดต่อ',
  `faculty` VARCHAR(100) DEFAULT NULL COMMENT 'คณะ',
  `major` VARCHAR(100) DEFAULT NULL COMMENT 'สาขาวิชา',
  `advisor_id` INT DEFAULT NULL COMMENT 'รหัสอาจารย์ที่ปรึกษา',
  `gpa` DECIMAL(3,2) DEFAULT NULL COMMENT 'เกรดเฉลี่ยสะสม',
  `enrollment_date` DATE DEFAULT NULL COMMENT 'วันที่เข้าศึกษา',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างข้อมูล',
  PRIMARY KEY (`student_id`),
  FOREIGN KEY (`advisor_id`) REFERENCES `teacher`(`teacher_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ข้อมูลนิสิต';

-- =====================================================
-- 3. Transaction Tables (ข้อมูลการดำเนินงาน)
-- =====================================================

-- 3.1 คำร้องขอฝึกงาน
CREATE TABLE IF NOT EXISTS `internships_request` (
  `request_id` INT NOT NULL AUTO_INCREMENT COMMENT 'รหัสใบคำร้องขอฝึกงาน',
  `student_id` INT NOT NULL COMMENT 'รหัสนิสิตผู้ยื่นเรื่อง',
  `company_id` INT NOT NULL COMMENT 'รหัสบริษัทที่ขอฝึก',
  `advisor_id` INT DEFAULT NULL COMMENT 'รหัสอาจารย์ที่ปรึกษาดูแล',
  `start_date` DATE DEFAULT NULL COMMENT 'วันที่เริ่มต้นฝึกงาน',
  `end_date` DATE DEFAULT NULL COMMENT 'วันที่สิ้นสุดฝึกงาน',
  `position` VARCHAR(150) DEFAULT NULL COMMENT 'ตำแหน่งที่ฝึกงาน',
  `remarks` TEXT COMMENT 'หมายเหตุ / คำอธิบายเพิ่มเติม',
  `status_id` INT DEFAULT 1 COMMENT 'สถานะปัจจุบันของคำร้อง',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างคำร้อง',
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'วันที่อัปเดตล่าสุด',
  PRIMARY KEY (`request_id`),
  FOREIGN KEY (`student_id`) REFERENCES `student`(`student_id`) ON DELETE CASCADE,
  FOREIGN KEY (`company_id`) REFERENCES `company`(`company_id`),
  FOREIGN KEY (`advisor_id`) REFERENCES `teacher`(`teacher_id`),
  FOREIGN KEY (`status_id`) REFERENCES `status_master`(`Status_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ใบคำร้องขอฝึกงานของนิสิต';

-- 3.2 ประวัติการเปลี่ยนสถานะ (Log)
CREATE TABLE IF NOT EXISTS `status_log` (
  `log_id` INT NOT NULL AUTO_INCREMENT COMMENT 'รหัสบันทึกเหตุการณ์',
  `request_id` INT NOT NULL COMMENT 'รหัสใบคำร้องขอฝึกงาน',
  `faculty_staff_id` INT DEFAULT NULL COMMENT 'รหัสเจ้าหน้าที่ (ผู้เปลี่ยนสถานะ)',
  `teacher_id` INT DEFAULT NULL COMMENT 'รหัสอาจารย์ (ผู้เปลี่ยนสถานะ)',
  `changed_by` VARCHAR(50) DEFAULT NULL COMMENT 'ชื่อหรือรหัสผู้ทำรายการทั่วไป',
  `changer_role` VARCHAR(20) DEFAULT NULL COMMENT 'บทบาทผู้ทำรายการ (Student/Teacher/Admin)',
  `remark` TEXT COMMENT 'หมายเหตุการเปลี่ยนสถานะ',
  `old_status_id` INT DEFAULT NULL COMMENT 'สถานะก่อนหน้า',
  `new_status_id` INT DEFAULT 1 COMMENT 'สถานะใหม่ที่เปลี่ยน',
  `changed_at` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'วัน-เวลาที่ทำการเปลี่ยน',
  PRIMARY KEY (`log_id`),
  FOREIGN KEY (`request_id`) REFERENCES `internships_request`(`request_id`) ON DELETE CASCADE,
  FOREIGN KEY (`faculty_staff_id`) REFERENCES `faculty_staff`(`faculty_staff_id`) ON DELETE SET NULL,
  FOREIGN KEY (`teacher_id`) REFERENCES `teacher`(`teacher_id`) ON DELETE SET NULL,
  FOREIGN KEY (`old_status_id`) REFERENCES `status_master`(`Status_ID`),
  FOREIGN KEY (`new_status_id`) REFERENCES `status_master`(`Status_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตารางเก็บประวัติการเปลี่ยนสถานะคำร้อง';

-- 3.3 บันทึกการนิเทศ
CREATE TABLE IF NOT EXISTS `supervision_record` (
  `supervision_id` INT NOT NULL AUTO_INCREMENT COMMENT 'รหัสบันทึกการนิเทศ',
  `request_id` INT NOT NULL COMMENT 'อ้างอิงรหัสใบคำร้อง',
  `teacher_id` INT NOT NULL COMMENT 'รหัสอาจารย์ผู้นิเทศ',
  `supervision_date` DATE DEFAULT NULL COMMENT 'วันที่ดำเนินการนิเทศ',
  `score` DECIMAL(5,2) DEFAULT NULL COMMENT 'คะแนนประเมินการฝึกงาน',
  `remarks` TEXT COMMENT 'ความคิดเห็น/หมายเหตุจากการนิเทศ',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่บันทึกข้อมูล',
  PRIMARY KEY (`supervision_id`),
  FOREIGN KEY (`request_id`) REFERENCES `internships_request`(`request_id`) ON DELETE CASCADE,
  FOREIGN KEY (`teacher_id`) REFERENCES `teacher`(`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='บันทึกผลการนิเทศการฝึกงาน';

SET FOREIGN_KEY_CHECKS = 1;


-- =====================================================
-- 4. Sample Seed Data (ข้อมูลทดสอบระบบ)
-- =====================================================

-- ข้อมูลสถานะพื้นฐาน
INSERT IGNORE INTO `status_master` (`Status_ID`, `Status_Name`) VALUES
(1, 'รับเรื่องเข้าระบบ / รออนุมัติ'),
(2, 'อาจารย์ที่ปรึกษาอนุมัติแล้ว'),
(3, 'ออกใบส่งตัวแล้ว'),
(4, 'ฝึกงานเสร็จสิ้น'),
(9, 'ยกเลิก / ไม่ผ่าน');

-- ข้อมูลบริษัททดสอบ
INSERT IGNORE INTO `company` (`company_id`, `company_name`, `industry`, `address`, `province`, `contact_person_name`, `contact_person_phone`, `status`) VALUES
(1, 'Tech Innovate Co., Ltd.', 'IT & Technology', '123 ถ.แจ้งวัฒนะ', 'กรุงเทพมหานคร', 'คุณวิภาวดี สมใจ', '081-111-2222', 'active'),
(2, 'Data Solutions Group', 'IT & Technology', '456 ถ.รัชดาภิเษก', 'กรุงเทพมหานคร', 'คุณสมพงษ์ ยอดเยี่ยม', '082-333-4444', 'active');

-- ข้อมูลอาจารย์ทดสอบ (รหัสผ่านใช้ 123456)
INSERT IGNORE INTO `teacher` (`teacher_id`, `username`, `password`, `first_name`, `last_name`, `email`, `department`) VALUES
(1, 'teacher01', '$2y$10$2p/qUwhEBq1JCRHy/1jY/uPUaG30W2amvu/hPXItYA3BLSsWhP5RC', 'สมเกียรติ', 'สอนดี', 'teacher01@faculty.ac.th', 'วิทยาการคอมพิวเตอร์');

-- ข้อมูลนิสิตทดสอบ (รหัสผ่านใช้ 123456)
INSERT IGNORE INTO `student` (`student_id`, `student_code`, `password`, `first_name`, `last_name`, `email`, `advisor_id`, `major`) VALUES
(1, '6610500001', '$2y$10$2p/qUwhEBq1JCRHy/1jY/uPUaG30W2amvu/hPXItYA3BLSsWhP5RC', 'นภัสสร', 'เรียนเก่ง', 'student01@email.com', 1, 'เทคโนโลยีสารสนเทศ'),
(2, '6610500002', '$2y$10$2p/qUwhEBq1JCRHy/1jY/uPUaG30W2amvu/hPXItYA3BLSsWhP5RC', 'พีรพล', 'โค้ดไว', 'student02@email.com', 1, 'วิทยาการคอมพิวเตอร์');

-- ข้อมูลสตาฟ/เจ้าหน้าที่คณะทดสอบ (รหัสผ่านคือ 123456 ทุกคน)
INSERT IGNORE INTO `faculty_staff` 
(`username`, `password`, `first_name`, `last_name`, `faculty`, `position`, `email`, `phone`) 
VALUES
('staff01', '$2y$10$2p/qUwhEBq1JCRHy/1jY/uPUaG30W2amvu/hPXItYA3BLSsWhP5RC', 'สมบูรณ์', 'บริหารงาน', 'มนุษยศาสตร์', 'เจ้าหน้าที่ประสานงานการศึกษา', 'somboon.b@faculty.ac.th', '02-111-2222'),
('staff02', '$2y$10$2p/qUwhEBq1JCRHy/1jY/uPUaG30W2amvu/hPXItYA3BLSsWhP5RC', 'วนิดา', 'ประเสริฐศรี', 'วิทยาศาสตร์', 'นักวิชาการศึกษา', 'wanida.p@faculty.ac.th', '02-111-3333'),
('staff03', '$2y$10$2p/qUwhEBq1JCRHy/1jY/uPUaG30W2amvu/hPXItYA3BLSsWhP5RC', 'กิตติ', 'นำชัย', 'วิศวกรรมศาสตร์', 'เจ้าหน้าที่บริหารงานทั่วไป', 'kitti.n@faculty.ac.th', '02-111-4444');

-- สร้างตารางเก็บข้อมูลนิสิต
CREATE TABLE `students` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `student_id` VARCHAR(15) NOT NULL COMMENT 'รหัสนิสิต',
  `full_name` VARCHAR(100) NOT NULL COMMENT 'ชื่อ-นามสกุล',
  `year_level` INT(1) NOT NULL COMMENT 'ชั้นปี (1, 2, 3, 4)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- เพิ่มข้อมูลรายชื่อนิสิตปี1-4
INSERT INTO students (student_id, full_name, year_level) VALUES
('68105010018', 'อคิราห์ เลิศวรากร', 1),
('68105010019', 'ลลิลพัทธ์ อัศวเมธี', 1),
('68105010020', 'พราวด์ฟ้า นิรันดร์กาล', 1),
('68105010021', 'คีรินทร์ โชติธนากุล', 1),
('68105010022', 'ฌาร์ม สิริสกุล', 1),
('68105010023', 'ธามม์ เทพจินดา', 1),
('68105010024', 'มิรา วงศ์วิวัฒน์', 1),
('68105010025', 'สกาย รัตนโกสินทร์', 1),
('68105010026', 'ณดล พิชิตทรัพย์', 1),
('68105010027', 'เฌอเอม กิจพาณิชย์', 1),
('67105010013', 'โรม มหานคร', 2),
('67105010014', 'ธิชา อารียา', 2),
('67105010015', 'นาวา ธนทรัพย์', 2),
('67105010016', 'เจด้า ศรีสมุทร', 2),
('67105010017', 'พีค วิวัฒน์วงศ์', 2),
('67105010018', 'วินเทอร์ บริบูรณ์', 2),
('67105010019', 'ชิชา นันทพิวัฒน์', 2),
('66105010020', 'เอพริล สุขเกษม', 3),
('66105010021', 'ซีเจย์ เกียรติภูมิ', 3),
('66105010022', 'ปุณณ์ ปุณณวิช', 3),
('66105010023', 'มิลิน กิตติวรา', 3),
('66105010024', 'ธัญญ์ เลิศล้ำพงศ์', 3),
('66105010025', 'อชิระ ศิลป์ชัย', 3),
('65105010011', 'ญาณิน ศิริโชค', 4),
('65105010012', 'พอร์ช พงษ์พัฒนา', 4),
('65105010013', 'จินเจอร์ รัตนไกร', 4),
('65105010014', 'ไนน์ นพเก้า', 4),
('65105010015', 'ไทก้า วีรกิจ', 4);