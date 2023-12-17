-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 17, 2023 at 11:53 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studybuddy`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `auth` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `auth`) VALUES
(1, 1234567890);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_grade_level`
--

DROP TABLE IF EXISTS `tbl_grade_level`;
CREATE TABLE IF NOT EXISTS `tbl_grade_level` (
  `id` int NOT NULL AUTO_INCREMENT,
  `grade_level` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_grade_level`
--

INSERT INTO `tbl_grade_level` (`id`, `grade_level`) VALUES
(1, '11th grade'),
(2, '12th grade'),
(3, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invite_practice`
--

DROP TABLE IF EXISTS `tbl_invite_practice`;
CREATE TABLE IF NOT EXISTS `tbl_invite_practice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invite_from` int NOT NULL,
  `invite_to` int NOT NULL,
  `invite_status_id` int NOT NULL,
  `topic_id` int NOT NULL,
  `practice_status_id` int NOT NULL,
  `room_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `invite_from` (`invite_from`),
  KEY `invite_to` (`invite_to`),
  KEY `invite_status_id` (`invite_status_id`),
  KEY `topic_id` (`topic_id`),
  KEY `practice_status_id` (`practice_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invite_status`
--

DROP TABLE IF EXISTS `tbl_invite_status`;
CREATE TABLE IF NOT EXISTS `tbl_invite_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `invite_status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_invite_status`
--

INSERT INTO `tbl_invite_status` (`id`, `invite_status`) VALUES
(1, 'Pending'),
(2, 'On-progress'),
(3, 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_practice`
--

DROP TABLE IF EXISTS `tbl_practice`;
CREATE TABLE IF NOT EXISTS `tbl_practice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `item_number` int NOT NULL,
  `question` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice1` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice2` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice3` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice4` text COLLATE utf8mb4_general_ci NOT NULL,
  `correct_answer` text COLLATE utf8mb4_general_ci NOT NULL,
  `teacher_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`),
  KEY `teacher_id` (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_practice_duo`
--

DROP TABLE IF EXISTS `tbl_practice_duo`;
CREATE TABLE IF NOT EXISTS `tbl_practice_duo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `item_number` int NOT NULL,
  `question` text NOT NULL,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text NOT NULL,
  `choice4` text NOT NULL,
  `correct_answer` text NOT NULL,
  `student_answer` text NOT NULL,
  `student_id` int NOT NULL,
  `room_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=494 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_practice_status`
--

DROP TABLE IF EXISTS `tbl_practice_status`;
CREATE TABLE IF NOT EXISTS `tbl_practice_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `practice_status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_practice_status`
--

INSERT INTO `tbl_practice_status` (`id`, `practice_status`) VALUES
(1, 'Undone'),
(2, 'Done');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_practice_student`
--

DROP TABLE IF EXISTS `tbl_practice_student`;
CREATE TABLE IF NOT EXISTS `tbl_practice_student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `item_number` int NOT NULL,
  `question` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice1` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice2` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice3` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice4` text COLLATE utf8mb4_general_ci NOT NULL,
  `student_answer` text COLLATE utf8mb4_general_ci NOT NULL,
  `correct_answer` text COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz`
--

DROP TABLE IF EXISTS `tbl_quiz`;
CREATE TABLE IF NOT EXISTS `tbl_quiz` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quiz_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `direction` text COLLATE utf8mb4_general_ci NOT NULL,
  `topic_title` text COLLATE utf8mb4_general_ci NOT NULL,
  `item_number` int NOT NULL,
  `question` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice1` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice2` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice3` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice4` text COLLATE utf8mb4_general_ci NOT NULL,
  `correct_answer` text COLLATE utf8mb4_general_ci NOT NULL,
  `teacher_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `teacher_id` (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz_student`
--

DROP TABLE IF EXISTS `tbl_quiz_student`;
CREATE TABLE IF NOT EXISTS `tbl_quiz_student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quiz_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `topic_title` text COLLATE utf8mb4_general_ci NOT NULL,
  `item_number` int NOT NULL,
  `question` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice1` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice2` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice3` text COLLATE utf8mb4_general_ci NOT NULL,
  `choice4` text COLLATE utf8mb4_general_ci NOT NULL,
  `student_answer` text COLLATE utf8mb4_general_ci NOT NULL,
  `correct_answer` text COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

DROP TABLE IF EXISTS `tbl_section`;
CREATE TABLE IF NOT EXISTS `tbl_section` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`id`, `section`) VALUES
(1, 'Hope'),
(2, 'Faith'),
(3, 'Love'),
(4, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

DROP TABLE IF EXISTS `tbl_student`;
CREATE TABLE IF NOT EXISTS `tbl_student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `middlename` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `grade_level` int NOT NULL,
  `section` int NOT NULL,
  `img_url` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `grade_level` (`grade_level`),
  KEY `section` (`section`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `firstname`, `middlename`, `lastname`, `email`, `username`, `password`, `age`, `grade_level`, `section`, `img_url`) VALUES
(23, 'empty-fn', 'empty-mn', 'empty-ln', 'jethel@gmail.com', 'jethel', 'e97a498a57fbd2ff3579faa4ab09d187', 1, 3, 4, 'default.png'),
(24, 'empty-fn', 'empty-mn', 'empty-ln', 'wea@gmail.com', 'wea', 'f3fa311af48b5a2adb1e6b0321d2f213', 1, 3, 4, 'default.png'),
(25, 'empty-fn', 'empty-mn', 'empty-ln', 'jacque@gmail.com', 'jacque', '3b84db5a4e0526805b8f1e98b78de5fa', 1, 3, 4, 'default.png'),
(26, 'empty-fn', 'empty-mn', 'empty-ln', 'analiza@gmail.com', 'analiza', '76fa7d28313f9422cbde182a810c630e', 1, 3, 4, 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_topics`
--

DROP TABLE IF EXISTS `tbl_sub_topics`;
CREATE TABLE IF NOT EXISTS `tbl_sub_topics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `lesson_number` int NOT NULL,
  `sub_topic_title` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

DROP TABLE IF EXISTS `tbl_teacher`;
CREATE TABLE IF NOT EXISTS `tbl_teacher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `img_url` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `middlename` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_topics`
--

DROP TABLE IF EXISTS `tbl_topics`;
CREATE TABLE IF NOT EXISTS `tbl_topics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_title` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `teacher_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `teacher_id` (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_invite_practice`
--
ALTER TABLE `tbl_invite_practice`
  ADD CONSTRAINT `tbl_invite_practice_ibfk_1` FOREIGN KEY (`invite_from`) REFERENCES `tbl_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_invite_practice_ibfk_2` FOREIGN KEY (`invite_to`) REFERENCES `tbl_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_invite_practice_ibfk_3` FOREIGN KEY (`invite_status_id`) REFERENCES `tbl_invite_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_invite_practice_ibfk_4` FOREIGN KEY (`topic_id`) REFERENCES `tbl_topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_invite_practice_ibfk_5` FOREIGN KEY (`practice_status_id`) REFERENCES `tbl_practice_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_practice`
--
ALTER TABLE `tbl_practice`
  ADD CONSTRAINT `tbl_practice_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `tbl_topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_practice_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `tbl_teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_practice_student`
--
ALTER TABLE `tbl_practice_student`
  ADD CONSTRAINT `tbl_practice_student_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tbl_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_practice_student_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `tbl_topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  ADD CONSTRAINT `tbl_quiz_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `tbl_teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_quiz_student`
--
ALTER TABLE `tbl_quiz_student`
  ADD CONSTRAINT `tbl_quiz_student_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tbl_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD CONSTRAINT `tbl_student_ibfk_1` FOREIGN KEY (`grade_level`) REFERENCES `tbl_grade_level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_student_ibfk_2` FOREIGN KEY (`section`) REFERENCES `tbl_section` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_sub_topics`
--
ALTER TABLE `tbl_sub_topics`
  ADD CONSTRAINT `tbl_sub_topics_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `tbl_topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_topics`
--
ALTER TABLE `tbl_topics`
  ADD CONSTRAINT `tbl_topics_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `tbl_teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
