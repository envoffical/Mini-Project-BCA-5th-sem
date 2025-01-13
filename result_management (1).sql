-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 13, 2025 at 08:57 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `result_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch_tab`
--

DROP TABLE IF EXISTS `batch_tab`;
CREATE TABLE IF NOT EXISTS `batch_tab` (
  `batch` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `semester` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`batch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch_tab`
--

INSERT INTO `batch_tab` (`batch`, `semester`) VALUES
('2022-25', '5'),
('2023-26', '3'),
('2024-27', '4'),
('2025-28', '2'),
('2026-29', '1');

-- --------------------------------------------------------

--
-- Table structure for table `exam_tab`
--

DROP TABLE IF EXISTS `exam_tab`;
CREATE TABLE IF NOT EXISTS `exam_tab` (
  `exam_id` int NOT NULL AUTO_INCREMENT,
  `exam_name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `exam_date` date NOT NULL,
  `batch` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `subject_code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `total_mark` int NOT NULL,
  `publish` int NOT NULL,
  PRIMARY KEY (`exam_id`),
  KEY `subject_code` (`subject_code`),
  KEY `batch` (`batch`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_tab`
--

INSERT INTO `exam_tab` (`exam_id`, `exam_name`, `exam_date`, `batch`, `subject_code`, `total_mark`, `publish`) VALUES
(34, 'Internals 1', '2024-09-26', '2025-28', 'CA1CRT04', 10, 1),
(35, 'Internal 1', '2024-10-01', '2024-27', 'MM2CRT04', 20, 1),
(36, 'Internal 2', '2024-10-28', '2022-25', 'CA3CRT6333', 15, 0),
(44, 'Internal 3', '2024-10-16', '2022-25', 'CA4CKW2578', 20, 1),
(46, 'Model exam 1', '2024-10-30', '2023-26', 'CA4CKW2580', 20, 0),
(48, 'Internal 1', '2024-10-28', '2024-27', 'CA6CRX3764', 20, 0),
(51, 'Internal 3', '2024-11-07', '2022-25', 'CA3CRS5866', 25, 0),
(52, 'Internal 3', '2025-01-03', '2023-26', 'CA1CRT04', 20, 0),
(54, 'Christmas exam', '2025-01-02', '2022-25', 'CA6CRX3764', 25, 0),
(55, 'Internal 5', '2025-01-02', '2022-25', 'CA4CKW2578', 22, 0),
(56, 'Internal Exam 7', '2024-12-31', '2022-25', 'ER7EX2233', 15, 0),
(57, 'Lab 1 ', '2025-01-07', '2022-25', 'ER7EX2233', 30, 0),
(58, 'PHP Internal exam 1', '2025-01-01', '2024-27', 'CV76R8977', 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_tab`
--

DROP TABLE IF EXISTS `login_tab`;
CREATE TABLE IF NOT EXISTS `login_tab` (
  `login_id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staff_id` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`login_id`),
  KEY `student_id` (`student_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_tab`
--

INSERT INTO `login_tab` (`login_id`, `student_id`, `staff_id`, `password`, `role`, `status`) VALUES
(87, NULL, 'SGC101', '﻿SGC101', 'Faculty', 1),
(137, NULL, 'Admin', 'admin123', 'Admin', 1),
(167, NULL, 'SGC103', 'SGC103', 'Faculty', 1),
(168, NULL, 'SGC102', 'SGC102', 'Faculty', 1),
(169, '1003', NULL, '1003', 'Student', 1),
(170, NULL, 'SGC104', 'SGC104', 'Faculty', 1),
(171, '1004', NULL, '1004', 'Student', 1),
(173, '1005', NULL, '1005', 'Student', 1),
(174, '1006', NULL, '1006', 'Student', 1),
(175, '1007', NULL, '1007', 'Student', 1),
(176, '1006', NULL, '1006', 'Student', 1),
(177, NULL, 'SGC105', 'SGC105', 'Faculty', 1),
(178, NULL, 'SGC106', 'SGC106', 'Faculty', 1),
(180, '1011', NULL, '180', 'Student', 1),
(181, '1012', NULL, '1012', 'Student', 1),
(182, '1013', NULL, '182', 'Student', 1),
(183, '1014', NULL, '1014', 'Student', 1),
(184, NULL, 'SGC107', 'SGC107', 'Faculty', 1),
(185, '1015', NULL, '1015', 'Student', 1),
(186, NULL, 'SGC108', 'SGC108', 'Faculty', 1),
(187, NULL, 'SGC109', 'SGC109', 'Faculty', 1),
(188, NULL, 'SGC110', 'SGC110', 'Faculty', 1),
(189, NULL, 'SGC111', 'SGC111', 'Faculty', 1),
(190, NULL, 'SGC112', 'SGC112', 'Faculty', 1),
(191, NULL, 'SGC113', 'SGC113', 'Faculty', 1),
(192, NULL, 'SGC114', 'SGC114', 'Faculty', 1),
(193, NULL, 'SGC115', 'SGC115', 'Faculty', 1),
(194, NULL, 'SGC116', 'SGC116', 'Faculty', 1),
(195, NULL, 'SGC117', 'SGC117', 'Faculty', 1),
(196, NULL, 'SGC118', 'SGC118', 'Faculty', 1),
(197, NULL, 'SGC119', 'SGC119', 'Faculty', 1),
(198, NULL, 'SGC120', 'SGC120', 'Faculty', 1),
(200, NULL, 'SGC121', 'SGC121', 'Faculty', 1),
(201, '1016', NULL, '1016', 'Student', 1),
(202, '1017', NULL, '1017', 'Student', 1),
(204, '1018', NULL, '1018', 'Student', 1),
(205, '1019', NULL, '1019', 'Student', 1),
(207, '1021', NULL, '1021', 'Student', 1),
(208, '1022', NULL, '$2y$10$K6p', 'Student', 1),
(209, '1023', NULL, '$2y$10$3QF', 'Student', 1),
(210, '1024', NULL, '1024', 'Student', 1),
(211, '1025', NULL, '1025', 'Student', 1),
(212, '1026', NULL, '1026', 'Student', 1),
(213, '1027', NULL, '1027', 'Student', 1),
(214, '1028', NULL, '1028', 'Student', 1),
(215, '1029', NULL, '1029', 'Student', 1),
(216, '1030', NULL, '1030', 'Student', 1),
(217, '1031', NULL, '1031', 'Student', 1),
(218, '1032', NULL, '1032', 'Student', 1),
(219, '1033', NULL, '1033', 'Student', 1),
(220, '1034', NULL, '1034', 'Student', 1),
(221, '1001', NULL, '1001', 'Student', 1),
(222, '1000', NULL, '1000', 'Student', 1),
(223, NULL, 'SGC122', 'SGC122', 'Faculty', 1),
(224, '1035', NULL, '1035', 'Student', 1),
(225, NULL, 'SGC123', 'SGC123', 'Faculty', 1),
(226, '1036', NULL, '1036', 'Student', 1),
(227, NULL, 'SGC124', 'SGC124', 'Faculty', 1),
(228, NULL, 'SGC125', 'SGC125', 'Faculty', 1),
(229, '1037', NULL, '1037', 'Student', 1),
(230, NULL, 'SGC126', 'SGC126', 'Faculty', 1),
(231, '1038', NULL, '1038', 'Student', 1);

-- --------------------------------------------------------

--
-- Table structure for table `marks_tab`
--

DROP TABLE IF EXISTS `marks_tab`;
CREATE TABLE IF NOT EXISTS `marks_tab` (
  `mark_id` int NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `exam_id` int NOT NULL,
  `student_id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `mark_obtained` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`mark_id`),
  KEY `subject_code` (`subject_code`),
  KEY `exam_id` (`exam_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks_tab`
--

INSERT INTO `marks_tab` (`mark_id`, `subject_code`, `exam_id`, `student_id`, `mark_obtained`) VALUES
(65, 'CA1CRT04', 34, '1004', '5'),
(68, 'CA1CRT04', 34, '1005', 'Absent'),
(69, 'MM2CRT04', 35, '1003', '9'),
(70, 'CA1CRT04', 34, '1000', '8'),
(71, 'CA1CRT04', 34, '1033', '7'),
(72, 'CA4CKW2578', 44, '1007', '17'),
(73, 'CA4CKW2578', 44, '1011', '15'),
(74, 'CA4CKW2578', 44, '1028', '9'),
(75, 'CA4CKW2578', 44, '1029', '11'),
(76, 'CA4CKW2578', 44, '1030', '7'),
(77, 'CA4CKW2578', 44, '1034', '4'),
(78, 'CA4CKW2580', 46, '1001', '10'),
(79, 'CA3CRS5866', 35, '1003', '10'),
(80, 'CA4CKW2578', 55, '1004', '12'),
(81, 'CA4CKW2578', 55, '1034', '7'),
(82, 'ER7EX2233', 56, '1038', '11'),
(83, 'ER7EX2233', 56, '1004', '10'),
(84, 'ER7EX2233', 56, '1007', '11');

-- --------------------------------------------------------

--
-- Table structure for table `staff_tab`
--

DROP TABLE IF EXISTS `staff_tab`;
CREATE TABLE IF NOT EXISTS `staff_tab` (
  `staff_code` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `staff_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`staff_code`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_tab`
--

INSERT INTO `staff_tab` (`staff_code`, `staff_name`, `status`, `email`) VALUES
('Admin', 'Admin', 0, NULL),
('SGC101', 'John Samuel', 1, 'sjohn@gmail.com'),
('SGC102', 'Jiann Jose Tom', 1, 'jiannnj@gmail.com'),
('SGC103', 'Akshay Thomas', 1, 'akshay@gmail.com'),
('SGC104', 'Emily Jackson', 1, 'emilykuttan@gmail.com'),
('SGC105', 'Harikuttan', 0, 'harimwon@gmail.com'),
('SGC106', 'Tomy Kurian', 1, 'tomysir@gmail.com'),
('SGC107', 'Gibruttan', 0, 'itsmegibru@gmail.com'),
('SGC108', 'Ancy George', 1, 'ancyg123@gmail.com'),
('SGC109', 'Ancy George', 1, 'ancymwolu@gmail.com'),
('SGC110', 'Joe V Joseph', 1, 'joe123@gmail.com'),
('SGC111', '﻿Jestin Joy', 1, 'jestinjose@gmail.com'),
('SGC112', 'Soumya George', 1, 'soumyagsgc@gmail.com'),
('SGC113', 'Gemini George', 1, 'geminigeorgesgc@gmail.com'),
('SGC114', 'Sini Alby', 1, 'sinialby@gmail.com'),
('SGC115', 'Anu Thomas', 1, 'anuthomas@gmail.com'),
('SGC116', 'Sibil ', 1, 'sibilthemathslover@gmail.com'),
('SGC117', 'Anet Joseph', 1, 'anetjsgc@gmail.com'),
('SGC118', 'Harikrishnan', 1, 'harikrish@gmail.com'),
('SGC119', 'Tony Chacko', 1, 'tonychacko@gmail.com'),
('SGC120', 'Roy Issac Tomy', 1, 'royissac@gmail.com'),
('SGC121', 'Sasi Kokku 1122', 0, 'sasi@gmail.com'),
('SGC122', 'Sagar Alias Jacy', 1, 'sagaraliasjacky@gmail.com'),
('SGC123', 'Rajesh Kumar', 1, 'rajeshk97@gmail.com'),
('SGC124', 'Regi Thomas', 1, 'regithomas@gmail.com'),
('SGC125', 'Ruzel Isaac Tony', 1, 'ruzelizack@gmail.com'),
('SGC126', 'Alex Junia', 1, 'alexjmathew@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `student_tab`
--

DROP TABLE IF EXISTS `student_tab`;
CREATE TABLE IF NOT EXISTS `student_tab` (
  `student_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `student_name` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `batch` varchar(7) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `email` (`email`),
  KEY `batch` (`batch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_tab`
--

INSERT INTO `student_tab` (`student_id`, `student_name`, `batch`, `status`, `email`) VALUES
('1000', 'Adarsh Binoy', '2025-28', 1, 'adarsh@gmail.com'),
('1001', 'Isha Khan', '2023-26', 1, 'ishakhan@gmail.com'),
('1002', 'Kiara', '2023-26', 1, 'k4ukiara@gmail.com'),
('1003', 'Shifana', '2024-27', 1, 'shifux@gmail.com'),
('1004', 'Aswin Gopal', '2022-25', 1, 'aswingopal@gmail.com'),
('1005', 'Karthik Subaraj', '2022-25', 0, 'karthik@gmail.com'),
('1006', 'Rajesh Pramod', '2023-26', 0, 'coolstarrajesh@gmail.com'),
('1007', 'Edwin Vincent', '2022-25', 1, 'edwinnv123@gmail.com'),
('1008', 'Sasi Kooku', '2023-26', 0, 'sasikuttan@gmail.com'),
('1009', 'Justin Jose', '2023-26', 1, 'justinkuttan@gmail.com'),
('1010', 'Vinny Siby', '2023-26', 1, 'vinnysiby26@gmail.com'),
('1011', 'Eric Melona', '2022-25', 1, 'ericakoppa@gmaail.com'),
('1012', 'Parthip ', '2023-26', 1, 'parthipakasonu@gmail.com'),
('1013', 'Hashiree', '2023-26', 1, 'hashiree@gmail.com'),
('1014', 'Alan Deva', '2023-26', 1, 'alandeva@gmail.com'),
('1015', 'Balu Menon', '2024-27', 1, 'balukuttan@gmail.com'),
('1016', 'Kuruvilla Sebastin', '2026-29', 1, 'kuruthefly@gmail.com'),
('1017', 'Abraham Koshi', '2023-26', 1, 'abraham@gmail.com'),
('1018', 'Roger', '2023-26', 1, 'roger@gmail.com'),
('1019', 'Saniya', '2024-27', 1, 'saniyaaro12@gmail.com'),
('1020', 'Chappa Chappa', '2023-26', 0, 'chappachappa@gmail.com'),
('1021', 'Chappru', '2023-26', 0, 'chappru@gmail.com'),
('1022', 'hsbbr', '2023-26', 0, 'dfdsf@gmail.com'),
('1023', 'grsg', '2023-26', 0, 'afafaf@gmail.com'),
('1024', 'Prr', '2023-26', 0, 'prr@gmail.com'),
('1025', '﻿Krishnadas K K', '2023-26', 1, 'krishnadas@gmail.com'),
('1026', 'Justin Joby', '2023-26', 1, 'justin@gmail.com'),
('1027', 'Alfina Noushasd', '2023-26', 1, 'alfina@gmail.com'),
('1028', 'Aiedah Nazar', '2022-25', 1, 'aiedah@gmail.com'),
('1029', 'Anu Mathew', '2022-25', 1, 'anu@gmail.com'),
('1030', 'Gouri krishna S', '2022-25', 1, 'gouri@gmail.com'),
('1031', 'Anjaly MAry Jose', '2023-26', 1, 'anjaly@gmail.com'),
('1032', 'Akshay Satheesh', '2024-27', 1, 'akshay@gmail.com'),
('1033', 'Rohith Raj', '2025-28', 1, 'rohith@gmail.com'),
('1034', 'Pishu', '2022-25', 1, 'pishkuttan@gmail.com'),
('1035', 'Pookie Rohith', '2024-27', 1, 'rohiththecutipe@gmail.com'),
('1036', 'Rohith Rajesh', '2024-27', 1, 'rohu@gmail.com'),
('1037', '123', '2024-27', 0, 'prabhu@gmail.com'),
('1038', 'Tony Chacko', '2022-25', 1, 'tonyjames@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `subject_tab`
--

DROP TABLE IF EXISTS `subject_tab`;
CREATE TABLE IF NOT EXISTS `subject_tab` (
  `subject_code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `subject_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `semester` int NOT NULL,
  `staff_id` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`subject_code`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_tab`
--

INSERT INTO `subject_tab` (`subject_code`, `subject_name`, `semester`, `staff_id`, `status`) VALUES
('CA1CRT04', 'Cyber Ethics and Law', 2, 'SGC102', 1),
('CA3CRS5866', 'Syriac', 3, 'SGC103', 1),
('CA3CRT6333', 'Physical Education', 2, 'SGC104', 1),
('CA4CKW2578', 'Social Networks', 2, 'SGC104', 1),
('CA4CKW2579', 'Genetics', 3, 'SGC105', 1),
('CA4CKW2580', 'Behaviorism', 3, 'SGC104', 1),
('CA4CKW2581', 'Philosophy of Science', 2, 'SGC105', 1),
('CA4CKW2582', 'Philosophy of Art', 2, 'SGC106', 0),
('CA4CKW2583', 'Attachment Theory', 1, 'SGC107', 0),
('CA4CKW2584', 'Psychoanalysis', 5, 'SGC108', 1),
('CA4CKW2585', 'Anthropology', 6, 'SGC109', 1),
('CA4CKW2586', 'Game Theory', 4, 'SGC110', 1),
('CA4CRT01', 'Software Engineering', 4, 'SGC101', 1),
('CA5CRZ5223', 'Economic', 3, 'SGC106', 1),
('CA6CRX3764', 'English', 3, 'SGC103', 1),
('CAP4CRX453', 'Socialogy', 2, 'SGC102', 1),
('CAR45CRT32', 'Chemistry', 3, 'SGC104', 1),
('CFD68CHT74', 'Media Studies', 4, 'SGC104', 1),
('CFD76XR908', 'Electronics ', 4, 'SGC110', 1),
('CGR98FU274', 'EVS', 4, 'SGC106', 1),
('CJQ84CWS67', 'Artsz', 5, 'SGC106', 1),
('CR1CBV1232', 'Action Science', 2, 'SGC108', 1),
('CR34HY2356', 'Home Science ', 4, 'SGC106', 1),
('CRZ3CRT356', 'Astrophysics', 2, 'SGC107', 0),
('CU45W9100', 'IT and Science ', 5, 'SGC116', 1),
('CV76R8977', 'PHP ', 1, 'SGC126', 1),
('ER7EX2233', 'Delta ', 5, 'SGC126', 1),
('EXC3RDT5', 'Matrixz', 5, 'SGC107', 1),
('HRX002323', 'Risk Management', 4, NULL, 1),
('MM2CRT04', 'Operational Research', 2, 'SGC123', 1),
('MM3CRT17', 'Statistics', 3, 'SGC108', 1),
('MMTCRT05', 'Pharmacology', 5, 'SGC107', 1),
('NNS123', 'pathology', 1, 'SGC107', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam_tab`
--
ALTER TABLE `exam_tab`
  ADD CONSTRAINT `exam_tab_ibfk_1` FOREIGN KEY (`subject_code`) REFERENCES `subject_tab` (`subject_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_tab_ibfk_2` FOREIGN KEY (`batch`) REFERENCES `batch_tab` (`batch`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login_tab`
--
ALTER TABLE `login_tab`
  ADD CONSTRAINT `login_tab_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student_tab` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `login_tab_ibfk_3` FOREIGN KEY (`staff_id`) REFERENCES `staff_tab` (`staff_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `marks_tab`
--
ALTER TABLE `marks_tab`
  ADD CONSTRAINT `marks_tab_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student_tab` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `marks_tab_ibfk_3` FOREIGN KEY (`subject_code`) REFERENCES `subject_tab` (`subject_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `marks_tab_ibfk_4` FOREIGN KEY (`exam_id`) REFERENCES `exam_tab` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_tab`
--
ALTER TABLE `student_tab`
  ADD CONSTRAINT `student_tab_ibfk_1` FOREIGN KEY (`batch`) REFERENCES `batch_tab` (`batch`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject_tab`
--
ALTER TABLE `subject_tab`
  ADD CONSTRAINT `subject_tab_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff_tab` (`staff_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
