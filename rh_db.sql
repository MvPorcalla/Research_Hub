-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2024 at 04:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rh_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `entry_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `repliedto_user_id` int(11) DEFAULT NULL,
  `comment_content` varchar(256) NOT NULL,
  `comment_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `comment_likes` int(11) NOT NULL DEFAULT 0,
  `comment_status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A = Active / I = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_entry`
--

CREATE TABLE `forum_entry` (
  `entry_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `entry_content` varchar(2048) NOT NULL,
  `entry_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `entry_likes` int(11) NOT NULL DEFAULT 0,
  `entry_status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A = Active / I = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `history_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `history_timestamp` datetime NOT NULL,
  `history_status` char(1) NOT NULL COMMENT 'A = Active / I = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `entry_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `like_timestamp` datetime NOT NULL,
  `like_status` char(1) NOT NULL COMMENT 'A = Active / I = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lrn`
--

CREATE TABLE `lrn` (
  `lrn_id` int(11) NOT NULL,
  `lrn_student` varchar(256) NOT NULL,
  `lrn_lrnid` varchar(12) NOT NULL,
  `lrn_status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A = Active / I = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `record_id` int(11) NOT NULL,
  `record_title` varchar(256) NOT NULL,
  `record_authors` varchar(256) NOT NULL,
  `record_year` smallint(6) NOT NULL,
  `record_month` tinyint(4) NOT NULL,
  `record_filedir` varchar(256) NOT NULL,
  `record_trackstrand` varchar(5) NOT NULL COMMENT 'ABM / HUMMS / STEM',
  `record_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `record_status` char(1) NOT NULL COMMENT 'A = Active / I = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `lrn_id` int(11) DEFAULT NULL,
  `user_lastname` varchar(64) NOT NULL,
  `user_firstname` varchar(64) NOT NULL,
  `user_mi` varchar(4) DEFAULT NULL,
  `user_username` varchar(64) NOT NULL,
  `user_emailadd` varchar(64) NOT NULL,
  `user_trackstrand` varchar(5) DEFAULT NULL COMMENT 'ABM / HUMMS / STEM',
  `user_idpicture_imgdir` varchar(256) NOT NULL,
  `user_school` varchar(128) DEFAULT NULL,
  `user_reason` varchar(512) DEFAULT NULL,
  `user_pwdhash` varchar(128) NOT NULL,
  `user_reset_token` varchar(255) DEFAULT NULL,
  `user_reset_token_expire` datetime DEFAULT NULL,
  `user_type` char(1) NOT NULL COMMENT 'A = Admin / S = Student / G = Guest',
  `user_status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A = Active / P = Pending / I = Inactive',
  `user_registration_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `user_lastlogin_timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `record_id` (`record_id`),
  ADD KEY `entry_id` (`entry_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `repliedto_user_id` (`repliedto_user_id`);

--
-- Indexes for table `forum_entry`
--
ALTER TABLE `forum_entry`
  ADD PRIMARY KEY (`entry_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `record_id` (`record_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `record_id` (`record_id`),
  ADD KEY `likes_ibfk_3` (`entry_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `lrn`
--
ALTER TABLE `lrn`
  ADD PRIMARY KEY (`lrn_id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `lrn_id` (`lrn_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_entry`
--
ALTER TABLE `forum_entry`
  MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lrn`
--
ALTER TABLE `lrn`
  MODIFY `lrn_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `records` (`record_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`entry_id`) REFERENCES `forum_entry` (`entry_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_4` FOREIGN KEY (`repliedto_user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `forum_entry`
--
ALTER TABLE `forum_entry`
  ADD CONSTRAINT `forum_entry_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `histories`
--
ALTER TABLE `histories`
  ADD CONSTRAINT `histories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `histories_ibfk_2` FOREIGN KEY (`record_id`) REFERENCES `records` (`record_id`) ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`record_id`) REFERENCES `records` (`record_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`entry_id`) REFERENCES `forum_entry` (`entry_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_4` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`lrn_id`) REFERENCES `lrn` (`lrn_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
