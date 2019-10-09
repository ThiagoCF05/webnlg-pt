-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 09, 2019 at 12:02 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `translation`
--

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Entry`
--

CREATE TABLE `Entry` (
  `id` int(11) NOT NULL,
  `eid` varchar(10) NOT NULL,
  `set` varchar(20) NOT NULL DEFAULT 'training',
  `size` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Lex`
--

CREATE TABLE `Lex` (
  `id` int(11) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `lid` varchar(10) NOT NULL,
  `comment` varchar(45) NOT NULL,
  `text` varchar(200) NOT NULL,
  `tokenized_text` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PosEditing`
--

CREATE TABLE `PosEditing` (
  `id` int(11) NOT NULL,
  `translation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `word_idx` int(11) NOT NULL,
  `word` varchar(45) NOT NULL,
  `action` varchar(45) NOT NULL,
  `updated_word` varchar(45) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Rewriting`
--

CREATE TABLE `Rewriting` (
  `id` int(11) NOT NULL,
  `translation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Translation`
--

CREATE TABLE `Translation` (
  `id` int(11) NOT NULL,
  `lex_id` int(11) NOT NULL,
  `engine_id` int(11) NOT NULL,
  `text` varchar(200) NOT NULL,
  `tokenized_text` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `TranslationEngine`
--

CREATE TABLE `TranslationEngine` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `age` varchar(45) NOT NULL,
  `sex` varchar(45) NOT NULL,
  `english_proficiency_level` varchar(45) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Entry`
--
ALTER TABLE `Entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id_idx` (`category_id`);

--
-- Indexes for table `Lex`
--
ALTER TABLE `Lex`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entry_key_idx` (`entry_id`);

--
-- Indexes for table `PosEditing`
--
ALTER TABLE `PosEditing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posedit_translation_key_idx` (`translation_id`),
  ADD KEY `posedit_user_key_idx` (`user_id`);

--
-- Indexes for table `Rewriting`
--
ALTER TABLE `Rewriting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rewriting_translation_key_idx` (`translation_id`),
  ADD KEY `rewriting_user_key_idx` (`user_id`);

--
-- Indexes for table `Translation`
--
ALTER TABLE `Translation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translation_lex_key_idx` (`lex_id`),
  ADD KEY `translation_engine_key_idx` (`engine_id`);

--
-- Indexes for table `TranslationEngine`
--
ALTER TABLE `TranslationEngine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Entry`
--
ALTER TABLE `Entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Lex`
--
ALTER TABLE `Lex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PosEditing`
--
ALTER TABLE `PosEditing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Rewriting`
--
ALTER TABLE `Rewriting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Translation`
--
ALTER TABLE `Translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TranslationEngine`
--
ALTER TABLE `TranslationEngine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Entry`
--
ALTER TABLE `Entry`
  ADD CONSTRAINT `entry_category_key` FOREIGN KEY (`category_id`) REFERENCES `Category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Lex`
--
ALTER TABLE `Lex`
  ADD CONSTRAINT `lex_entry_key` FOREIGN KEY (`entry_id`) REFERENCES `Entry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PosEditing`
--
ALTER TABLE `PosEditing`
  ADD CONSTRAINT `posedit_translation_key` FOREIGN KEY (`translation_id`) REFERENCES `Translation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posedit_user_key` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Rewriting`
--
ALTER TABLE `Rewriting`
  ADD CONSTRAINT `rewriting_translation_key` FOREIGN KEY (`translation_id`) REFERENCES `Translation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rewriting_user_key` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Translation`
--
ALTER TABLE `Translation`
  ADD CONSTRAINT `translation_engine_key` FOREIGN KEY (`engine_id`) REFERENCES `TranslationEngine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `translation_lex_key` FOREIGN KEY (`lex_id`) REFERENCES `Lex` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
