-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 24, 2026 at 03:47 AM
-- Server version: 8.0.44
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internships`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activity_id` int NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `day` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `month` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `title` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `sort_order` int DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activity_id`, `category`, `image`, `day`, `month`, `title`, `description`, `sort_order`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'showcase', 'pai online.jpg', '23', 'ก.พ. 69', 'กิจกรรมแข่งขันสร้างความตระหนักรู้ด้านคดีภัยออนไลน์ Cyber Guardians & Digital Art Challenge University', 'เมื่อวันที่ 23 กุมภาพันธ์ 2569 ที่ผ่านมา นิสิตชั้นปีที่ 4 สาขาวิชาสารสนเทศศึกษาได้เข้าร่วมกิจกรรมแข่งขันสร้างความตระหนักรู้ด้านคดีภัยออนไลน์ ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(2, 'academic', 'sin.jpg', '08', 'ส.ค. 68', 'ประชุมวิชาการ Digital Revolution: Moving Towards Developing Sustainability Libraries', 'วันที่ 8 สิงหาคม 2568 หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา คณะมนุษยศาสตร์ ได้จัดโครงการนำเสนอผลงานด้านสารสนเทศศึกษา ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(3, 'student', 'ISspot.jpg', '15', 'ก.พ. 69', 'IS DAY : โครงการสานสัมพันธ์สารสนเทศศึกษา', 'วันที่ 15 กุมภาพันธ์ 2569 ทางหลักสูตรได้จัดโครงการสานสัมพันธ์สารสนเทศ เป็นกิจกรรมที่จัดขึ้นเพื่อเสริมสร้างความสัมพันธ์อันดีระหว่างนิสิตในสาขาสารสนเทศศึกษาทุกชั้นปี ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(4, 'showcase', 'FF01.jpg', '2569', '', 'ทุนวิจัย Fundamental Fund (FF) ประจำปี 2569 ของคณาจารย์ประจำสาขาวิชาสารสนเทศศึกษา สังกัดกลุ่มสาขาวิชาพัฒนาศักยภาพมนุษย์', 'โครงการวิจัยที่ 1 \"การพัฒนาแพลตฟอร์มกลางมหาวิทยาลัยศรีนครินทรวิโรฒเพื่อเชื่อมโยงและแลกเปลี่ยนข้อมูลด้านการบริการวิชาการ\" ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(5, 'academic', 'sahagit.jpg', '28', 'เม.ย. 68', 'โครงการแลกเปลี่ยนเรียนรู้ประสบการณ์วิชาชีพและสหกิจศึกษา', 'วันที่ 28 เมษายน 2568 หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา ได้จัดโครงการแลกเปลี่ยนเรียนรู้ประสบการณ์วิชาชีพและสหกิจศึกษา ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(6, 'student', 'sho02.jpg', '23', 'ก.พ. 69', 'โครงการพัฒนาห้องสมุดโรงเรียนสู่ชุมชน', 'หลักสูตรสารสนเทศศึกษา ได้จัดโครงการพัฒนาห้องสมุดโรงเรียนสู่ชุมชน ในวันที่ 23 กุมภาพันธ์ 2569 โดยมีวัตถุประสงค์เพื่อพัฒนาแหล่งเรียนรู้สู่ชุมชน ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(7, 'showcase', 'FF02.jpg', '2569', '', 'ทุนวิจัย Fundamental Fund (FF) ประจำปี 2569 ของคณาจารย์ประจำสาขาวิชาสารสนเทศศึกษา สังกัดกลุ่มสาขาวิชาพัฒนาศักยภาพมนุษย์', 'โครงการวิจัยที่ 2 \"การพัฒนาแพลตฟอร์มดิจิทัลเพื่อให้บริการสารสนเทศในโรงเรียนมัธยมศึกษาขนาดกลางและขนาดเล็กในเขตกรุงเทพมหานคร\" ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(8, 'academic', 'TKpark.jpg', '12', 'พ.ย. 67', 'ศึกษาดูงานและแลกเปลี่ยนเรียนรู้ ณ TK Park', 'นิสิตหลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา ชั้นปีที่ 1 ทั้งภาคปกติและภาคพิเศษ ได้เข้าศึกษาดูงาน ณ อุทยานการเรียนรู้ TK Park ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(9, 'student', 'openHU.jpg', '1-2', 'พ.ย. 69', 'SWU Open House 2025', 'วันที่ 1-2 พฤศจิกายน 2568 มหาวิทยาลัยศรีนครินทรวิโรฒ ได้จัดกิจกรรม SWU Open House 2025 ทางคณะมนุษยศาสตร์ หลักสูตรสารสนเทศศึกษา ได้จัดบูธขึ้น ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(10, 'showcase', 'SPN o4 work.jpg', '27-28', 'พ.ย. 68', 'งานประชุมวิชาการ \"การจัดการศึกษาและวิจัยทางบรรณารักษศาสตร์และสารสนเทศศาสตร์เพื่อการพัฒนาที่ยั่งยืน ความท้าทายของ AI ในการสื่อสารทางวิชาการ\"', 'เมื่อวันที่ 27-28 พฤศจิกายน 2568 ที่ผ่านมา ทางหลักสูตร ศศ.บ.สาขาวิชาสารสนเทศศึกษา นำนิสิตไปนำเสนองานประชุมวิชาการ ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(11, 'academic', 'dit01.jpg', '24-25', 'ก.ค. 68', 'โครงการพัฒนาแหล่งเรียนรู้สู่ชุมชน ณ โรงเรียนวัดวังปลาจีด จ.นครนายก และโรงเรียนวัดท่าช้าง (แสงปัญญาวิทยาคาร) จ.นครนายก', 'วันที่ 24-25 กรกฎาคม 2568 หลักสูตรศิลปศาสตรบัณฑิต สาขาวิชาสารสนเทศศึกษา ได้จัดโครงการพัฒนาแหล่งเรียนรู้สู่ชุมชน ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(12, 'student', 'fristday.jpg', '21-22', 'ก.ค. 68', 'ปฐมนิเทศนิสิตชั้นปีที่ 1', 'วันที่ 21-22 กรกฎาคม 2568 หลักสูตรสารสนเทศศึกษาได้จัดโครงการปฐมนิเทศนิสิตชั้นปีที่ 1 เพื่อเตรียมความพร้อมให้นิสิตใหม่ ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(13, 'student', 'satapanaHU.jpg', '22', 'ส.ค. 68', 'งานสถาปนาคณะมนุษยศาสตร์ ครบรอบ 50 ปี', 'เมื่อวันที่ 22 สิงหาคม พ.ศ. 2568 ได้จัดงานสถาปนาคณะมนุษยศาสตร์ มหาวิทยาลัยศรีนครินทรวิโรฒ ครบรอบ 50 ปี ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(14, 'student', 'mss.jpg', '1', 'ก.พ. 68', 'โครงการสืบสานธรรมะศึกษาและศิลปวัฒนธรรมอย่างยั่งยืน กิจกรรมศึกษาดูงาน ณ มิวเซียมสยาม', 'กิจกรรมศึกษาดูงานที่จัดขึ้นเพื่อส่งเสริมให้นิสิตได้เรียนรู้และตระหนักถึงคุณค่าของศิลปวัฒนธรรมไทย ควบคู่ไปกับการปลูกฝังแนวคิดด้านคุณธรรมและจริยธรรม ...', 0, NULL, '2026-04-23 19:36:16', '2026-04-23 19:36:16'),
(15, 'showcase', '4604021ad01f3f89.jpg', '', '', 'sadf', 'asdf', 0, 1, '2026-04-23 20:43:53', '2026-04-23 20:43:53');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int NOT NULL COMMENT 'รหัสบริษัท',
  `company_name` varchar(200) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อบริษํท',
  `industry` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ประเภทอุตสาหกรรม / หมวดหมู่ธุรกิจ',
  `address` text COLLATE utf8mb4_general_ci COMMENT 'ที่อยู่',
  `province` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'จังหวัด',
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'เบอร์ติดต่อ',
  `email` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'อีเมล',
  `website` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'เว็บไซต์',
  `contact_person_name` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ชื่อผู้ติดต่อ (พี่เลี้ยง,HR)',
  `contact_person_phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'เบอร์ผู้ติดต่อ (พี่เลี้ยง,HR)',
  `contact_person_email` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'อีเมลผู้ติดต่อ (พี่เลี้ยง,HR)',
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'active' COMMENT 'สถานะการใช้งานของบริษัท',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างข้อมูล',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'วันที่อัปเดตข้อมูล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลบริษัท';

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `industry`, `address`, `province`, `phone`, `email`, `website`, `contact_person_name`, `contact_person_phone`, `contact_person_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tech Innovate Co., Ltd.', 'IT & Technology', '123 อาคารซอฟต์แวร์พาร์ค ชั้น 10 ถ.แจ้งวัฒนะ', 'กรุงเทพมหานคร', '02-111-2222', NULL, NULL, 'คุณวิภาวดี สมใจ (HR)', '081-111-2222', NULL, 'active', '2026-03-30 00:47:38', '2026-03-30 00:47:38'),
(2, 'Data Solutions Group', 'IT & Technology', '456 ตึกไซเบอร์เวิลด์ ชั้น 5 ถ.รัชดาภิเษก', 'กรุงเทพมหานคร', '02-333-4444', NULL, NULL, 'คุณสมพงษ์ ยอดเยี่ยม (Senior Dev)', '082-333-4444', NULL, 'active', '2026-03-30 00:47:38', '2026-03-30 00:47:38'),
(3, 'Fintech Future Bank', 'Banking & Finance', '789 สำนักงานใหญ่ ถ.สีลม', 'กรุงเทพมหานคร', '02-555-6666', NULL, NULL, 'คุณอารยา รักดี (HR)', '083-555-6666', NULL, 'active', '2026-03-30 00:47:38', '2026-03-30 00:47:38'),
(4, 'Creative Media Agency', 'Media & Communication', '321 ซอยสุขุมวิท 21', 'กรุงเทพมหานคร', '02-777-8888', NULL, NULL, 'คุณใจดี มีสุข (Manager)', '084-777-8888', NULL, 'inactive', '2026-03-30 00:47:38', '2026-03-30 00:47:38');

-- --------------------------------------------------------

--
-- Table structure for table `course_showcase`
--

CREATE TABLE `course_showcase` (
  `course_id` int NOT NULL COMMENT 'รหัสลำดับที่ในฐานข้อมูล',
  `course_code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสวิชาตามหลัสูตร',
  `course_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อรายวิชา',
  `description` text COLLATE utf8mb4_general_ci COMMENT 'คำอธิบายรายวิชา',
  `image_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ที่อยู่รูปภาพประกอบรายวิชา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='โชว์เคสรายวิชา ใช้ใน web frontend';

--
-- Dumping data for table `course_showcase`
--

INSERT INTO `course_showcase` (`course_id`, `course_code`, `course_name`, `description`, `image_path`) VALUES
(1, 'IS222', 'ระบบฐานข้อมูล (Database Systems)', 'เรียนรู้การออกแบบและจัดการฐานข้อมูลเชิงสัมพันธ์ด้วย SQL, การทำ ER-Diagram และ Normalization', 'assets/img/courses/is222.jpg'),
(2, 'IS223', 'การพัฒนาเว็บแอปพลิเคชัน (Web Development)', 'การสร้างเว็บไซต์แบบโต้ตอบด้วย HTML, CSS, JavaScript, Bootstrap และ PHP', 'assets/img/courses/is223.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_staff`
--

CREATE TABLE `faculty_staff` (
  `faculty_staff_id` int NOT NULL COMMENT 'รหัสเจ้าหน้าที่',
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ชื่อผู้ใช้ของเจ้าหน้าที่ (admin)',
  `first_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อ',
  `last_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'นามสกุล',
  `faculty` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'คณะ',
  `position` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ตำแหน่ง',
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'อีเมล',
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสผ่าน',
  `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'เบอร์ติดต่อ',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างข้อมุล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลเจ้าหน้าที่คณะ';

--
-- Dumping data for table `faculty_staff`
--

INSERT INTO `faculty_staff` (`faculty_staff_id`, `username`, `first_name`, `last_name`, `faculty`, `position`, `email`, `password`, `phone`, `created_at`) VALUES
(1, 'admin', 'สมศรี', 'ใจดี', NULL, NULL, 'admin@faculty.swu.ac.th', '$2y$10$pQuO7E9E56YiKj9ytEiSeeDM0hEmiwM9KJ.66//Xsw58iIXoioDYm', NULL, '2026-03-28 01:29:03'),
(2, 'admin1', 'สมหญิง', 'งานเนี๊ยบ', NULL, NULL, 'admin1@email.com', '$2y$10$mdWMLOd3fwxLz26Srb39c.fKjPBvDy4Ql3vJRyALKQXfJCq0knurC', NULL, '2026-03-30 00:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `internships_request`
--

CREATE TABLE `internships_request` (
  `request_id` int NOT NULL COMMENT 'รหัสใบขอฝึกงาน',
  `student_id` int NOT NULL COMMENT 'รหัสนิสิต',
  `company_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสบริษัท',
  `advisor_id` int DEFAULT NULL COMMENT 'รหัสอาจารย์ที่ปรึกษา',
  `start_date` date DEFAULT NULL COMMENT 'วันเริ่มฝึกงาน',
  `end_date` date DEFAULT NULL COMMENT 'วันสิ้นสุดฝึกงาน',
  `position` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ตำแหน่ง',
  `remarks` text COLLATE utf8mb4_general_ci COMMENT 'หมายเหตุ',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างข้อมูล',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'วันที่อัพเดตข้อมูล',
  `status_id` int DEFAULT '1' COMMENT 'เลขสถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ใบคำร้องขอการฝึกงาน';

--
-- Dumping data for table `internships_request`
--

INSERT INTO `internships_request` (`request_id`, `student_id`, `company_id`, `advisor_id`, `start_date`, `end_date`, `position`, `remarks`, `created_at`, `updated_at`, `status_id`) VALUES
(1, 1, '1', NULL, '2026-06-01', '2026-09-30', 'Web Developer', 'เกรดถึงเกณฑ์ อาจารย์อนุมัติแล้ว', '2026-03-30 00:47:48', '2026-03-30 00:47:48', 2),
(2, 2, '2', NULL, '2026-06-01', '2026-09-30', 'Database Admin', 'รออาจารย์ที่ปรึกษาตรวจสอบ', '2026-03-30 00:47:48', '2026-03-30 00:47:48', 1),
(3, 3, '3', NULL, '2026-06-01', '2026-09-30', 'IT Support', 'บริษัทแจ้งว่าปีนี้ไม่รับเด็กฝึกงานเพิ่มแล้ว', '2026-03-30 00:47:48', '2026-03-30 00:47:48', 9),
(19, 1, '1', NULL, '2026-04-23', '2027-04-23', 'Pro', NULL, '2026-04-23 17:59:25', '2026-04-23 17:59:25', 1),
(20, 1, '1', NULL, '2026-04-01', '2026-05-01', 'UX/UI', NULL, '2026-04-23 18:14:14', '2026-04-23 18:14:14', 1),
(21, 1, '2', NULL, '2026-04-30', '2026-12-30', 'Web Developer', NULL, '2026-04-23 18:15:08', '2026-04-23 18:15:08', 1),
(24, 1, '3', NULL, '2026-04-23', '2026-04-30', ' Web Dev', '', '2026-04-23 22:02:27', '2026-04-23 22:02:27', 1),
(25, 5, '2', 3, '2026-04-23', '2026-05-01', ' Web Dev', '', '2026-04-24 00:27:17', '2026-04-24 00:28:25', 4);

-- --------------------------------------------------------

--
-- Table structure for table `news_events`
--

CREATE TABLE `news_events` (
  `event_id` int NOT NULL COMMENT 'รหัสกิจกรรม',
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อเรื่องกิจกรรม',
  `content` text COLLATE utf8mb4_general_ci COMMENT 'เนื้อหา/รายละเอียดกิจกรรม',
  `event_date` date DEFAULT NULL COMMENT 'วันที่จัดกิจกรรม',
  `category` enum('Project','Activity','General') COLLATE utf8mb4_general_ci DEFAULT 'General' COMMENT 'หมวดหมู่กิจกรรม',
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ที่อยู่ลิงก์รูปภาพกิจกรรม'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลประชาสัมพันธ์กิจกรรมต่าง ๆ';

-- --------------------------------------------------------

--
-- Table structure for table `status_log`
--

CREATE TABLE `status_log` (
  `log_id` int NOT NULL COMMENT 'รหัสลำดับเหตุการณ์',
  `request_id` int NOT NULL COMMENT 'รหัสใบขอฝึกงาน',
  `faculty_staff_id` int DEFAULT NULL COMMENT 'รหัสเจ้าหน้าที่',
  `teacher_id` int DEFAULT NULL COMMENT 'รหัสอาจารย์',
  `remarks` text COLLATE utf8mb4_general_ci COMMENT 'หมายเหตุ',
  `changed_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'เวลาลำดับเหตุการณ์',
  `old_status_id` int DEFAULT NULL COMMENT 'สถานะเก่า',
  `new_status_id` int DEFAULT '1' COMMENT 'สถานะใหม่'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลการดำเนินรายการ';

--
-- Dumping data for table `status_log`
--

INSERT INTO `status_log` (`log_id`, `request_id`, `faculty_staff_id`, `teacher_id`, `remarks`, `changed_at`, `old_status_id`, `new_status_id`) VALUES
(1, 1, NULL, NULL, 'นิสิตยื่นคำขอเข้าระบบ', '2026-03-30 00:47:51', NULL, 1),
(2, 1, NULL, 1, 'ตรวจสอบเอกสารครบถ้วน อนุมัติให้ฝึกงานได้', '2026-03-30 00:47:51', 1, 2),
(3, 24, NULL, NULL, 'ยื่นคำขอใหม่ โดยนิสิต 6610501234', '2026-04-23 22:02:27', NULL, 1),
(4, 25, NULL, NULL, 'ยื่นคำขอใหม่ โดยนิสิต 67101010641', '2026-04-24 00:27:17', NULL, 1),
(5, 25, NULL, 3, '', '2026-04-24 00:27:52', 1, 2),
(6, 25, NULL, 3, 'ปิดเคสหลังนิเทศ', '2026-04-24 00:28:25', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `status_master`
--

CREATE TABLE `status_master` (
  `Status_ID` int NOT NULL COMMENT 'รหัสสถานะ',
  `Status_Name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อสถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ตารางเก็บข้อมูลชื่อสถานะ';

--
-- Dumping data for table `status_master`
--

INSERT INTO `status_master` (`Status_ID`, `Status_Name`) VALUES
(1, 'รับเรื่องเข้าระบบ'),
(2, 'อาจารย์ที่ปรึกษาอนุมัติ'),
(3, 'ออกใบส่งตัวแล้ว'),
(4, 'ฝึกงานเสร็จสิ้น'),
(9, 'ยกเลิก');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int NOT NULL COMMENT 'รหัสลำดับที่ของนิสิต',
  `student_code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสประจำตัว',
  `first_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อจริง',
  `last_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'นามสกุล',
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'อีเมล',
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสผ่าน',
  `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'เบอร์ติดต่อ',
  `faculty` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'คณะ',
  `major` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'สาขา',
  `advisor_id` int DEFAULT NULL COMMENT 'รหัสอาจารย์ที่ปรึกษา',
  `gpa` decimal(3,2) DEFAULT NULL COMMENT 'เกรดเฉลี่ย',
  `enrollment_date` date DEFAULT NULL COMMENT 'วันที่เข้าเรียน',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างข้อมูล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลนิสิต';

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_code`, `first_name`, `last_name`, `email`, `password`, `phone`, `faculty`, `major`, `advisor_id`, `gpa`, `enrollment_date`, `created_at`) VALUES
(1, '6610501234', 'สมชาย', 'เรียนดี', 'somchai@student.swu.ac.th', '$2y$10$thAVOylotiucpoi3KH.D/u3gk6TXvXNzaJWsohCiAQNGxOc.5AlxK', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-28 01:29:01'),
(2, '6610500001', 'นภัสสร', 'เรียนเก่ง', 'napasorn@email.com', '$2y$10$mdWMLOd3fwxLz26Srb39c.fKjPBvDy4Ql3vJRyALKQXfJCq0knurC', '089-000-1111', 'วิทยาศาสตร์', 'เทคโนโลยีสารสนเทศ', NULL, 3.85, NULL, '2026-03-30 00:47:43'),
(3, '6610500002', 'พีรพล', 'โค้ดไว', 'peerapol@email.com', '$2y$10$mdWMLOd3fwxLz26Srb39c.fKjPBvDy4Ql3vJRyALKQXfJCq0knurC', '089-000-2222', 'วิทยาศาสตร์', 'วิทยาการคอมพิวเตอร์', NULL, 3.42, NULL, '2026-03-30 00:47:43'),
(4, '6610500003', 'สุดาพร', 'นอนน้อย', 'sudaporn@email.com', '$2y$10$mdWMLOd3fwxLz26Srb39c.fKjPBvDy4Ql3vJRyALKQXfJCq0knurC', '089-000-3333', 'วิทยาศาสตร์', 'เทคโนโลยีสารสนเทศ', NULL, 2.95, NULL, '2026-03-30 00:47:43'),
(5, '67101010641', 'Purin', 'Goonmanoon', 'purin.goonmanoon@g.swu.ac.th', '$2y$10$GANkJMWMPaFvrXQu4fCD8eCDtRM0QSJtW26T8S99nHkznti7dUHm6', '0625403481', 'HM', 'IS', 3, 3.00, NULL, '2026-04-23 22:05:48');

-- --------------------------------------------------------

--
-- Table structure for table `supervision_record`
--

CREATE TABLE `supervision_record` (
  `supervision_id` int NOT NULL COMMENT 'รหัสลำดับการนิเทศ',
  `request_id` int NOT NULL COMMENT 'รหัสใบคำขอฝึกงาน',
  `teacher_id` int NOT NULL COMMENT 'รหัสลำดับอาจารย์',
  `supervision_date` date DEFAULT NULL COMMENT 'วันที่ลงพื้นที่นิเทศ',
  `score` decimal(5,2) DEFAULT NULL COMMENT 'คะแนนประเมิน',
  `remarks` text COLLATE utf8mb4_general_ci COMMENT 'หมายเหตุ',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างข้อมูล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลบันทึกการนิเทศ';

--
-- Dumping data for table `supervision_record`
--

INSERT INTO `supervision_record` (`supervision_id`, `request_id`, `teacher_id`, `supervision_date`, `score`, `remarks`, `created_at`) VALUES
(1, 25, 3, '2026-04-17', 43.00, '[Online] ดี\nเกรด: A', '2026-04-24 00:28:25'),
(2, 25, 3, '2026-04-24', NULL, '[On-site] \nเกรด: A', '2026-04-24 00:33:26');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int NOT NULL COMMENT 'รหัสลำดับที่อาจารย์',
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ชื่อผู้ใช้ (teacher)',
  `first_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อจริง',
  `last_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'นามสกุล',
  `department` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ภาควิชา',
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'อีเมล',
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสผ่าน',
  `phone` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'เบอร์ติดต่อ',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่สร้างข้อมูล',
  `academic_position` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ตำแหน่งทางวิชาการ',
  `expertise` text COLLATE utf8mb4_general_ci COMMENT 'ประสบการณ์',
  `profile_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'รูปโปรไฟล์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลอาจารย์';

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `username`, `first_name`, `last_name`, `department`, `email`, `password`, `phone`, `created_at`, `academic_position`, `expertise`, `profile_image`) VALUES
(1, 'teacher', 'สมเกียรติ', 'สอนดี', NULL, 'teacher@faculty.swu.ac.th', '$2y$10$mdWMLOd3fwxLz26Srb39c.fKjPBvDy4Ql3vJRyALKQXfJCq0knurC', NULL, '2026-03-28 01:29:07', NULL, NULL, NULL),
(2, 'teacher1', 'สมเกียรติ', 'สอนดี', 'วิทยาการคอมพิวเตอร์', 'somkiat@email.com', '$2y$10$.JhyN/1Rs7onoXGEOF0FcON4oucvoU3qQmwFLVDif65/4uKEelgEu', '', '2026-03-30 00:47:41', 'ผศ.ดร.', 'Database Management, SQL, NoSQL', 'assets/img/teachers/t1.jpg'),
(3, 'teacher2', 'วิไลวรรณ', 'ใจเย็น', 'เทคโนโลยีสารสนเทศ', 'wilaiwan@email.com', '$2y$10$0I4d6WQnaV3DgzHVRy4AceOpKaeg27khGJaKiU5m34CMTQwaZaZaS', NULL, '2026-03-30 00:47:41', 'รศ.', 'Web Development, UX/UI Design', 'assets/img/teachers/t2.jpg'),
(4, 'teacher3', 'ธนากร', 'มุ่งมั่น', 'วิทยาการคอมพิวเตอร์', 'thanakorn@email.com', '$2y$10$mdWMLOd3fwxLz26Srb39c.fKjPBvDy4Ql3vJRyALKQXfJCq0knurC', NULL, '2026-03-30 00:47:41', 'อ.', 'Artificial Intelligence, Python', 'assets/img/teachers/t3.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`),
  ADD UNIQUE KEY `company_name` (`company_name`);

--
-- Indexes for table `course_showcase`
--
ALTER TABLE `course_showcase`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `faculty_staff`
--
ALTER TABLE `faculty_staff`
  ADD PRIMARY KEY (`faculty_staff_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `internships_request`
--
ALTER TABLE `internships_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `idx_advisor_id` (`advisor_id`);

--
-- Indexes for table `news_events`
--
ALTER TABLE `news_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `status_log`
--
ALTER TABLE `status_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `faculty_staff_id` (`faculty_staff_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `old_status_id` (`old_status_id`),
  ADD KEY `new_status_id` (`new_status_id`);

--
-- Indexes for table `status_master`
--
ALTER TABLE `status_master`
  ADD PRIMARY KEY (`Status_ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_code` (`student_code`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `supervision_record`
--
ALTER TABLE `supervision_record`
  ADD PRIMARY KEY (`supervision_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activity_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสบริษัท', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course_showcase`
--
ALTER TABLE `course_showcase`
  MODIFY `course_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับที่ในฐานข้อมูล', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faculty_staff`
--
ALTER TABLE `faculty_staff`
  MODIFY `faculty_staff_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสเจ้าหน้าที่', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `internships_request`
--
ALTER TABLE `internships_request`
  MODIFY `request_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสใบขอฝึกงาน', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `news_events`
--
ALTER TABLE `news_events`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสกิจกรรม';

--
-- AUTO_INCREMENT for table `status_log`
--
ALTER TABLE `status_log`
  MODIFY `log_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับเหตุการณ์', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `status_master`
--
ALTER TABLE `status_master`
  MODIFY `Status_ID` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสสถานะ', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับที่ของนิสิต', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `supervision_record`
--
ALTER TABLE `supervision_record`
  MODIFY `supervision_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับการนิเทศ', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสลำดับที่อาจารย์', AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `internships_request`
--
ALTER TABLE `internships_request`
  ADD CONSTRAINT `internships_request_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `internships_request_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status_master` (`Status_ID`);

--
-- Constraints for table `status_log`
--
ALTER TABLE `status_log`
  ADD CONSTRAINT `status_log_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `internships_request` (`request_id`),
  ADD CONSTRAINT `status_log_ibfk_2` FOREIGN KEY (`faculty_staff_id`) REFERENCES `faculty_staff` (`faculty_staff_id`),
  ADD CONSTRAINT `status_log_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`),
  ADD CONSTRAINT `status_log_ibfk_4` FOREIGN KEY (`old_status_id`) REFERENCES `status_master` (`Status_ID`),
  ADD CONSTRAINT `status_log_ibfk_5` FOREIGN KEY (`new_status_id`) REFERENCES `status_master` (`Status_ID`);

--
-- Constraints for table `supervision_record`
--
ALTER TABLE `supervision_record`
  ADD CONSTRAINT `supervision_record_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `internships_request` (`request_id`),
  ADD CONSTRAINT `supervision_record_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
