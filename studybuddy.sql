-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2023 at 03:20 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
-- Table structure for table `tbl_grade_level`
--

CREATE TABLE `tbl_grade_level` (
  `id` int(11) NOT NULL,
  `grade_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_grade_level`
--

INSERT INTO `tbl_grade_level` (`id`, `grade_level`) VALUES
(1, '11th grade'),
(2, '12th grade');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invite_practice`
--

CREATE TABLE `tbl_invite_practice` (
  `id` int(11) NOT NULL,
  `invite_from` int(11) NOT NULL,
  `invite_to` int(11) NOT NULL,
  `invite_status_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `practice_status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_invite_practice`
--

INSERT INTO `tbl_invite_practice` (`id`, `invite_from`, `invite_to`, `invite_status_id`, `topic_id`, `practice_status_id`) VALUES
(1, 1, 3, 1, 62, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invite_status`
--

CREATE TABLE `tbl_invite_status` (
  `id` int(11) NOT NULL,
  `invite_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `tbl_practice` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `item_number` int(11) NOT NULL,
  `question` text NOT NULL,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text NOT NULL,
  `choice4` text NOT NULL,
  `correct_answer` text NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_practice`
--

INSERT INTO `tbl_practice` (`id`, `topic_id`, `item_number`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `correct_answer`, `teacher_id`) VALUES
(23, 62, 1, 'HTML stands for?', 'Hypertext Maskup Language', 'Hypertext Marchup Language', 'Hypertext Markup Language', 'Hypertext Makeup Language', 'Hypertext Markup Language', 1),
(24, 62, 2, 'HTML in short term', 'Web Architecture', 'Web Structure', 'Web Engineering', 'Web Building', 'Web Structure', 1),
(25, 62, 3, 'What language is HTML belong', 'Scripting Language', 'Speaking Language', 'Computer Language', 'Programming Language', 'Computer Language', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_practice_status`
--

CREATE TABLE `tbl_practice_status` (
  `id` int(11) NOT NULL,
  `practice_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `tbl_practice_student` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `item_number` int(11) NOT NULL,
  `question` text NOT NULL,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text NOT NULL,
  `choice4` text NOT NULL,
  `student_answer` text NOT NULL,
  `correct_answer` text NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_practice_student`
--

INSERT INTO `tbl_practice_student` (`id`, `topic_id`, `item_number`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `student_answer`, `correct_answer`, `student_id`) VALUES
(110, 62, 1, 'HTML stands for?', 'Hypertext Maskup Language', 'Hypertext Marchup Language', 'Hypertext Markup Language', 'Hypertext Makeup Language', 'Hypertext Markup Language', 'Hypertext Markup Language', 4),
(111, 62, 2, 'HTML in short term', 'Web Architecture', 'Web Structure', 'Web Engineering', 'Web Building', 'Web Architecture', 'Web Structure', 4),
(112, 62, 3, 'What language is HTML belong', 'Scripting Language', 'Speaking Language', 'Computer Language', 'Programming Language', 'Programming Language', 'Computer Language', 4),
(113, 62, 1, 'HTML stands for?', 'Hypertext Maskup Language', 'Hypertext Marchup Language', 'Hypertext Markup Language', 'Hypertext Makeup Language', 'Hypertext Markup Language', 'Hypertext Markup Language', 1),
(114, 62, 2, 'HTML in short term', 'Web Architecture', 'Web Structure', 'Web Engineering', 'Web Building', 'Web Architecture', 'Web Structure', 1),
(115, 62, 3, 'What language is HTML belong', 'Scripting Language', 'Speaking Language', 'Computer Language', 'Programming Language', 'Programming Language', 'Computer Language', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz`
--

CREATE TABLE `tbl_quiz` (
  `id` int(11) NOT NULL,
  `quiz_code` varchar(50) NOT NULL,
  `direction` text NOT NULL,
  `topic_title` text NOT NULL,
  `item_number` int(11) NOT NULL,
  `question` text NOT NULL,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text NOT NULL,
  `choice4` text NOT NULL,
  `correct_answer` text NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quiz`
--

INSERT INTO `tbl_quiz` (`id`, `quiz_code`, `direction`, `topic_title`, `item_number`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `correct_answer`, `teacher_id`, `student_id`) VALUES
(7, '12345', 'Please read the question carefully and answer it wisely. Once this quiz submitted, it can not be undone.', 'HTML', 1, 'qwertyuiop ?', 'aaaaa', 'bbbbb', 'cccccc', 'ddddd', 'bbbbb', 1, 1),
(8, '12345', 'Please read the question carefully and answer it wisely. Once this quiz submitted, it can not be undone.', 'HTML', 2, 'asdfghjkl ?', '1111111', '22222222222', '3333333333', '44444444444', '3333333333', 1, 1),
(9, '12345', 'Please read the question carefully and answer it wisely. Once this quiz submitted, it can not be undone.', 'HTML', 3, 'zxcvbnm ?', '...............', ',,,,,,,,,,,,,,,,,,,,', ',///////////////////////', ']]]]]]]]]]]]]]]]]]]', ']]]]]]]]]]]]]]]]]]]', 1, 1),
(10, '1111', 'Basta direction ni', 'qwertyuiop', 1, 'poiuytrewq ?', 'aaaaaa', 'bbbbbb', 'cccccc', 'dddddd', 'bbbbbb', 1, 1),
(11, '1111', 'Basta direction ni', 'qwertyuiop', 2, 'lkjhgfdsa ?', '1111111', '22222222', '33333333', '4444444', '4444444', 1, 1),
(12, '0000', 'qwertyuio asdfghjkl zxcvbnm', 'Parts of the Body', 1, 'Question 1', '11111', '22222', '3333', '44444', '44444', 1, 1),
(13, '0000', 'qwertyuio asdfghjkl zxcvbnm', 'Parts of the Body', 2, 'Question 2 ni siya', 'aaaaa', 'bbbb', 'cccc', 'dddd', 'bbbb', 1, 1),
(14, '0000', 'qwertyuio asdfghjkl zxcvbnm', 'Parts of the Body', 3, 'Number three question', '....', ',,,,', '////', '\'\'\'\'', '....', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz_student`
--

CREATE TABLE `tbl_quiz_student` (
  `id` int(11) NOT NULL,
  `quiz_code` varchar(50) NOT NULL,
  `topic_title` text NOT NULL,
  `item_number` int(11) NOT NULL,
  `question` text NOT NULL,
  `choice1` text NOT NULL,
  `choice2` text NOT NULL,
  `choice3` text NOT NULL,
  `choice4` text NOT NULL,
  `student_answer` text NOT NULL,
  `correct_answer` text NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_quiz_student`
--

INSERT INTO `tbl_quiz_student` (`id`, `quiz_code`, `topic_title`, `item_number`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `student_answer`, `correct_answer`, `student_id`) VALUES
(67, '12345', 'HTML', 3, 'zxcvbnm ?', '...............', ',,,,,,,,,,,,,,,,,,,,', ',///////////////////////', ']]]]]]]]]]]]]]]]]]]', ']]]]]]]]]]]]]]]]]]]', ']]]]]]]]]]]]]]]]]]]', 1),
(68, '12345', 'HTML', 2, 'asdfghjkl ?', '1111111', '22222222222', '3333333333', '44444444444', '44444444444', '3333333333', 1),
(69, '12345', 'HTML', 1, 'qwertyuiop ?', 'aaaaa', 'bbbbb', 'cccccc', 'ddddd', 'bbbbb', 'bbbbb', 1),
(70, '12345', 'HTML', 3, 'zxcvbnm ?', '...............', ',,,,,,,,,,,,,,,,,,,,', ',///////////////////////', ']]]]]]]]]]]]]]]]]]]', ']]]]]]]]]]]]]]]]]]]', ']]]]]]]]]]]]]]]]]]]', 4),
(71, '12345', 'HTML', 2, 'asdfghjkl ?', '1111111', '22222222222', '3333333333', '44444444444', '44444444444', '3333333333', 4),
(72, '12345', 'HTML', 1, 'qwertyuiop ?', 'aaaaa', 'bbbbb', 'cccccc', 'ddddd', 'bbbbb', 'bbbbb', 4),
(73, '0000', 'Parts of the Body', 1, 'Question 1', '11111', '22222', '3333', '44444', '3333', '44444', 1),
(74, '0000', 'Parts of the Body', 2, 'Question 2 ni siya', 'aaaaa', 'bbbb', 'cccc', 'dddd', 'bbbb', 'bbbb', 1),
(75, '0000', 'Parts of the Body', 3, 'Number three question', '....', ',,,,', '////', '\'\'\'\'', '////', '....', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE `tbl_section` (
  `id` int(11) NOT NULL,
  `section` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`id`, `section`) VALUES
(1, 'Hope'),
(2, 'Faith'),
(3, 'Love');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `birthdate` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `grade_level` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  `img_url` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `firstname`, `middlename`, `lastname`, `email`, `username`, `password`, `age`, `birthdate`, `phone_number`, `grade_level`, `section`, `img_url`) VALUES
(1, 'Toto', 'A', 'Engbino', 'test@test.com', '12345', '827ccb0eea8a706c4c34a16891f84e7b', 12, '1995-07-04', '1234567890', 2, 1, 'profile.jpg'),
(3, 'Inday', 'G', 'Beauty', 'wew@wew.com', '23456', 'adcaec3805aa912c0d0b14a81bedb6ff', 15, '1974-03-04', '0987654321', 1, 1, 'img1.jpg'),
(4, 'Teya', 'E', 'Gwapa', 'hello@hello.com', '34567', '992a6d18b2a148cf20d9014c3524aa11', 11, '2005-02-04', '6789054321', 2, 1, 'img2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_topics`
--

CREATE TABLE `tbl_sub_topics` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `lesson_number` int(11) NOT NULL,
  `sub_topic_title` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sub_topics`
--

INSERT INTO `tbl_sub_topics` (`id`, `topic_id`, `lesson_number`, `sub_topic_title`, `description`) VALUES
(65, 62, 1, 'qwertyuiop', 'poiuytrewq lkjhgfdsa mnbvcxz'),
(66, 62, 2, 'asdfghjkl', 'zxcvbnm qwertyuiop qwertyuio'),
(67, 62, 3, 'zxcvbnm', 'mbvcxz lhgfds poiuytrew'),
(68, 63, 1, 'qwertyuio', 'sdfghjk fghjk vbnm, fghjkl'),
(69, 63, 2, 'lkjhgfds', 'asdfghjk dfghjk rtyuio ,gfd hgf'),
(70, 63, 3, 'mnbvcx', 'sdfghjkl rtyuiop fghjkl fghjk \r\n fghjkl fghjk');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE `tbl_teacher` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_teacher`
--

INSERT INTO `tbl_teacher` (`id`, `username`, `password`, `email`) VALUES
(1, '54321', '01cfcd4f6b8770febfb40cb906715822', 'test@test.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_topics`
--

CREATE TABLE `tbl_topics` (
  `id` int(11) NOT NULL,
  `topic_title` varchar(50) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_topics`
--

INSERT INTO `tbl_topics` (`id`, `topic_title`, `teacher_id`) VALUES
(62, 'HTML', 1),
(63, 'Parts of the head', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_grade_level`
--
ALTER TABLE `tbl_grade_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_invite_practice`
--
ALTER TABLE `tbl_invite_practice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invite_from` (`invite_from`),
  ADD KEY `invite_to` (`invite_to`),
  ADD KEY `invite_status_id` (`invite_status_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `practice_status_id` (`practice_status_id`);

--
-- Indexes for table `tbl_invite_status`
--
ALTER TABLE `tbl_invite_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_practice`
--
ALTER TABLE `tbl_practice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `tbl_practice_status`
--
ALTER TABLE `tbl_practice_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_practice_student`
--
ALTER TABLE `tbl_practice_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `tbl_quiz_student`
--
ALTER TABLE `tbl_quiz_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grade_level` (`grade_level`),
  ADD KEY `section` (`section`);

--
-- Indexes for table `tbl_sub_topics`
--
ALTER TABLE `tbl_sub_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_topics`
--
ALTER TABLE `tbl_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_grade_level`
--
ALTER TABLE `tbl_grade_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_invite_practice`
--
ALTER TABLE `tbl_invite_practice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_invite_status`
--
ALTER TABLE `tbl_invite_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_practice`
--
ALTER TABLE `tbl_practice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_practice_status`
--
ALTER TABLE `tbl_practice_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_practice_student`
--
ALTER TABLE `tbl_practice_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_quiz_student`
--
ALTER TABLE `tbl_quiz_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbl_section`
--
ALTER TABLE `tbl_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_sub_topics`
--
ALTER TABLE `tbl_sub_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_topics`
--
ALTER TABLE `tbl_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

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
  ADD CONSTRAINT `tbl_quiz_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `tbl_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
