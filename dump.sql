-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2019 at 02:27 AM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `questionnaire`
--
CREATE DATABASE IF NOT EXISTS `questionnaire` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `questionnaire`;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `answers`:
--   `question_id`
--       `questions` -> `id`
--

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `answer`, `question_id`, `created_at`, `updated_at`) VALUES
(1, 'answer1', 1, '2019-06-19 22:25:17', '2019-06-19 22:25:17'),
(2, 'answer2', 1, '2019-06-19 22:25:17', '2019-06-19 22:25:17'),
(3, 'answer3', 1, '2019-06-19 22:25:17', '2019-06-19 22:25:17'),
(4, 'answer1', 2, '2019-06-19 23:44:07', '2019-06-19 23:44:07'),
(5, 'answer2', 2, '2019-06-19 23:44:07', '2019-06-19 23:44:07'),
(6, 'answer1', 8, '2019-06-19 22:25:17', '2019-06-19 22:25:17'),
(7, 'answer2', 8, '2019-06-19 22:25:17', '2019-06-19 22:25:17'),
(8, 'answer3', 8, '2019-06-19 22:25:17', '2019-06-19 22:25:17'),
(9, 'answer1', 9, '2019-06-19 22:25:17', '2019-06-19 22:25:17'),
(10, 'answer2', 9, '2019-06-19 22:25:17', '2019-06-19 22:25:17'),
(11, 'answer3', 9, '2019-06-19 22:25:17', '2019-06-19 22:25:17'),
(12, 'answer1', 10, '2019-06-19 22:25:17', '2019-06-19 22:25:17'),
(13, 'answer3', 10, '2019-06-19 22:25:17', '2019-06-19 22:25:17');

-- --------------------------------------------------------

--
-- Table structure for table `correct_answers`
--

CREATE TABLE `correct_answers` (
  `id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `correct_answers`:
--   `answer_id`
--       `answers` -> `id`
--   `question_id`
--       `questions` -> `id`
--

--
-- Dumping data for table `correct_answers`
--

INSERT INTO `correct_answers` (`id`, `answer_id`, `question_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2019-06-19 23:43:41', '2019-06-19 23:43:41'),
(2, 5, 2, '2019-06-19 23:44:18', '2019-06-19 23:44:18'),
(3, 7, 8, '2019-06-19 23:43:41', '2019-06-19 23:43:41'),
(4, 9, 9, '2019-06-19 23:43:41', '2019-06-19 23:43:41'),
(5, 12, 10, '2019-06-19 23:43:41', '2019-06-19 23:43:41');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `test_id` int(11) NOT NULL,
  `sequence` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `questions`:
--   `test_id`
--       `tests` -> `id`
--

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `test_id`, `sequence`, `created_at`, `updated_at`) VALUES
(1, 'Question 1?', 1, 0, '2019-06-16 17:45:56', '2019-06-16 17:45:56'),
(2, 'Question 2?', 1, 1, '2019-06-16 17:45:56', '2019-06-16 17:45:56'),
(5, 'Question 3?', 1, 2, '2019-06-16 17:46:19', '2019-06-16 17:46:19'),
(6, 'Question 4?', 1, 3, '2019-06-16 17:46:19', '2019-06-16 17:46:19'),
(7, 'Question 5?', 1, 4, '2019-06-16 17:46:19', '2019-06-16 17:46:19'),
(8, 'Question 1?', 2, 0, '2019-06-16 17:45:56', '2019-06-16 17:45:56'),
(9, 'Question 2?', 2, 1, '2019-06-16 17:45:56', '2019-06-16 17:45:56'),
(10, 'Question 3?', 2, 2, '2019-06-16 17:46:19', '2019-06-16 17:46:19'),
(11, 'Question 4?', 2, 3, '2019-06-16 17:46:19', '2019-06-16 17:46:19'),
(12, 'Question 5?', 2, 4, '2019-06-16 17:46:19', '2019-06-16 17:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `tests`:
--

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Test 1', '2019-06-16 17:45:23', '2019-06-16 17:45:23'),
(2, 'Test 2', '2019-06-16 17:45:23', '2019-06-16 17:45:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `users`:
--

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `user_answers`:
--   `answer_id`
--       `answers` -> `id`
--   `question_id`
--       `questions` -> `id`
--   `user_id`
--       `users` -> `id`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `correct_answers`
--
ALTER TABLE `correct_answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `answer_id` (`answer_id`),
  ADD UNIQUE KEY `question_id` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `correct_answers`
--
ALTER TABLE `correct_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
