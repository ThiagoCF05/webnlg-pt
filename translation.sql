-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 11, 2019 at 06:19 PM
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

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`id`, `name`, `created_at`) VALUES
(1, 'Airport', '2019-10-07 18:32:12');

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

--
-- Dumping data for table `Entry`
--

INSERT INTO `Entry` (`id`, `eid`, `set`, `size`, `category_id`, `created_at`) VALUES
(1, 'Id1', 'train', 1, 1, '2019-10-07 18:34:34');

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

--
-- Dumping data for table `Lex`
--

INSERT INTO `Lex` (`id`, `entry_id`, `lid`, `comment`, `text`, `tokenized_text`, `created_at`) VALUES
(1, 1, 'Id1', 'good', 'Aarhus Airport serves the city of Aarhus, Denmark.', 'Aarhus Airport serves the city of Aarhus , Denmark .', '2019-10-07 18:36:52'),
(2, 1, 'Id2', 'good', 'The Aarhus is the airport of Aarhus, Denmark.', 'The Aarhus is the airport of Aarhus , Denmark .', '2019-10-08 13:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `LinearPosEditing`
--

CREATE TABLE `LinearPosEditing` (
  `id` int(11) NOT NULL,
  `translation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(200) NOT NULL,
  `isPosEdited` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LinearPosEditing`
--

INSERT INTO `LinearPosEditing` (`id`, `translation_id`, `user_id`, `text`, `isPosEdited`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '.', 1, '2019-10-11 16:08:40', '2019-10-11 16:09:01'),
(2, 2, 1, 'Aarhus é o aeroporto principal da Dinamarca .', 1, '2019-10-11 16:12:02', '2019-10-11 16:12:36'),
(3, 1, 1, 'Aeroporto de Aarhus serve a cidade de , .', 1, '2019-10-11 16:16:02', '2019-10-11 16:16:30'),
(4, 2, 1, 'Aarhus é o aeroporto de Aarhus .', 1, '2019-10-11 16:16:49', '2019-10-11 16:17:08'),
(5, 1, 1, 'Aeroporto de Aarhus serve a cidade de Aarhus , Dinamarca .', 0, '2019-10-11 16:18:19', '2019-10-11 16:18:38');

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

--
-- Dumping data for table `PosEditing`
--

INSERT INTO `PosEditing` (`id`, `translation_id`, `user_id`, `word_idx`, `word`, `action`, `updated_word`, `updated_at`, `created_at`) VALUES
(21, 1, 1, 1, 'Aeroporto', 'original', '', NULL, '2019-10-08 21:42:29'),
(22, 1, 1, 2, 'de Congonhas', 'added', '', '2019-10-08 21:42:09', '2019-10-08 21:42:29'),
(23, 1, 1, 3, 'de', 'deleted', '', '2019-10-08 21:42:10', '2019-10-08 21:42:29'),
(24, 1, 1, 4, 'Aarhus', 'deleted', '', '2019-10-08 21:42:12', '2019-10-08 21:42:29'),
(25, 1, 1, 5, 'serve', 'original', '', NULL, '2019-10-08 21:42:29'),
(26, 1, 1, 6, 'a', 'original', '', NULL, '2019-10-08 21:42:29'),
(27, 1, 1, 7, 'cidade', 'original', '', NULL, '2019-10-08 21:42:29'),
(28, 1, 1, 8, 'de', 'original', '', NULL, '2019-10-08 21:42:29'),
(29, 1, 1, 9, 'Aarhus', 'updated', 'São Paulo', '2019-10-08 21:42:17', '2019-10-08 21:42:29'),
(30, 1, 1, 10, ',', 'original', '', NULL, '2019-10-08 21:42:29'),
(31, 1, 1, 11, 'Dinamarca', 'updated', 'Brazil', '2019-10-08 21:42:21', '2019-10-08 21:42:29'),
(32, 1, 1, 12, '.', 'original', '', NULL, '2019-10-08 21:42:29'),
(33, 2, 1, 1, 'Aarhus', 'original', '', NULL, '2019-10-09 12:22:59'),
(34, 2, 1, 2, 'é', 'original', '', NULL, '2019-10-09 12:22:59'),
(35, 2, 1, 3, 'o', 'original', '', NULL, '2019-10-09 12:22:59'),
(36, 2, 1, 4, 'aeroporto', 'deleted', '', '2019-10-09 12:22:51', '2019-10-09 12:22:59'),
(37, 2, 1, 5, 'de', 'original', '', NULL, '2019-10-09 12:22:59'),
(38, 2, 1, 6, 'Aarhus', 'original', '', NULL, '2019-10-09 12:22:59'),
(39, 2, 1, 7, ',', 'original', '', NULL, '2019-10-09 12:22:59'),
(40, 2, 1, 8, 'na', 'original', '', NULL, '2019-10-09 12:22:59'),
(41, 2, 1, 9, 'Dinamarca', 'original', '', NULL, '2019-10-09 12:22:59'),
(42, 2, 1, 10, '.', 'original', '', NULL, '2019-10-09 12:22:59'),
(43, 1, 4, 1, 'Aeroporto', 'original', '', NULL, '2019-10-11 14:52:28'),
(44, 1, 4, 2, 'de', 'original', '', NULL, '2019-10-11 14:52:28'),
(45, 1, 4, 3, 'Aarhus', 'original', '', NULL, '2019-10-11 14:52:28'),
(46, 1, 4, 4, 'serve', 'original', '', NULL, '2019-10-11 14:52:28'),
(47, 1, 4, 5, 'a', 'original', '', NULL, '2019-10-11 14:52:28'),
(48, 1, 4, 6, 'cidade', 'original', '', NULL, '2019-10-11 14:52:28'),
(49, 1, 4, 7, 'de', 'original', '', NULL, '2019-10-11 14:52:28'),
(50, 1, 4, 8, 'Aarhus', 'original', '', NULL, '2019-10-11 14:52:28'),
(51, 1, 4, 9, ',', 'original', '', NULL, '2019-10-11 14:52:28'),
(52, 1, 4, 10, 'Dinamarca', 'original', '', NULL, '2019-10-11 14:52:28'),
(53, 1, 4, 11, '.', 'original', '', NULL, '2019-10-11 14:52:28'),
(54, 1, 4, 1, 'Aeroporto', 'original', '', NULL, '2019-10-11 14:52:34'),
(55, 1, 4, 2, 'de', 'original', '', NULL, '2019-10-11 14:52:34'),
(56, 1, 4, 3, 'Aarhus', 'original', '', NULL, '2019-10-11 14:52:34'),
(57, 1, 4, 4, 'serve', 'original', '', NULL, '2019-10-11 14:52:34'),
(58, 1, 4, 5, 'a', 'original', '', NULL, '2019-10-11 14:52:34'),
(59, 1, 4, 6, 'cidade', 'deleted', '', '2019-10-11 14:52:40', '2019-10-11 14:52:34'),
(60, 1, 4, 7, 'de', 'original', '', NULL, '2019-10-11 14:52:34'),
(61, 1, 4, 8, 'Aarhus', 'original', '', NULL, '2019-10-11 14:52:34'),
(62, 1, 4, 9, ',', 'original', '', NULL, '2019-10-11 14:52:34'),
(63, 1, 4, 10, 'Dinamarca', 'original', '', NULL, '2019-10-11 14:52:34'),
(64, 1, 4, 11, '.', 'original', '', NULL, '2019-10-11 14:52:34'),
(65, 2, 1, 1, 'Aarhus', 'original', '', NULL, '2019-10-11 16:00:55'),
(66, 2, 1, 2, 'é', 'original', '', NULL, '2019-10-11 16:00:55'),
(67, 2, 1, 3, 'o', 'original', '', NULL, '2019-10-11 16:00:55'),
(68, 2, 1, 4, 'aeroporto', 'original', '', NULL, '2019-10-11 16:00:55'),
(69, 2, 1, 5, 'de', 'deleted', '', '2019-10-11 16:01:01', '2019-10-11 16:00:55'),
(70, 2, 1, 6, 'Aarhus', 'deleted', '', '2019-10-11 16:00:58', '2019-10-11 16:00:55'),
(71, 2, 1, 7, ',', 'original', '', NULL, '2019-10-11 16:00:55'),
(72, 2, 1, 8, 'na', 'original', '', NULL, '2019-10-11 16:00:55'),
(73, 2, 1, 9, 'Dinamarca', 'original', '', NULL, '2019-10-11 16:00:55'),
(74, 2, 1, 10, '.', 'original', '', NULL, '2019-10-11 16:00:55'),
(75, 1, 1, 1, 'Aeroporto', 'original', '', NULL, '2019-10-11 16:02:02'),
(76, 1, 1, 2, 'de', 'original', '', NULL, '2019-10-11 16:02:02'),
(77, 1, 1, 3, 'Aarhus', 'original', '', NULL, '2019-10-11 16:02:02'),
(78, 1, 1, 4, 'serve', 'original', '', NULL, '2019-10-11 16:02:02'),
(79, 1, 1, 5, 'a', 'original', '', NULL, '2019-10-11 16:02:02'),
(80, 1, 1, 6, 'cidade', 'original', '', NULL, '2019-10-11 16:02:02'),
(81, 1, 1, 7, 'de', 'deleted', '', '2019-10-11 16:02:05', '2019-10-11 16:02:02'),
(82, 1, 1, 8, 'Aarhus', 'deleted', '', '2019-10-11 16:02:03', '2019-10-11 16:02:02'),
(83, 1, 1, 9, ',', 'deleted', '', '2019-10-11 16:02:08', '2019-10-11 16:02:02'),
(84, 1, 1, 10, 'Dinamarca', 'original', '', NULL, '2019-10-11 16:02:02'),
(85, 1, 1, 11, '.', 'original', '', NULL, '2019-10-11 16:02:02'),
(86, 2, 1, 1, 'Aarhus', 'original', '', NULL, '2019-10-11 16:08:40'),
(87, 2, 1, 2, 'é', 'original', '', NULL, '2019-10-11 16:08:40'),
(88, 2, 1, 3, 'o', 'original', '', NULL, '2019-10-11 16:08:40'),
(89, 2, 1, 4, 'aeroporto', 'original', '', NULL, '2019-10-11 16:08:40'),
(90, 2, 1, 5, 'de', 'original', '', NULL, '2019-10-11 16:08:40'),
(91, 2, 1, 6, 'Aarhus', 'original', '', NULL, '2019-10-11 16:08:40'),
(92, 2, 1, 7, ',', 'deleted', '', '2019-10-11 16:08:43', '2019-10-11 16:08:40'),
(93, 2, 1, 8, 'na', 'deleted', '', '2019-10-11 16:08:44', '2019-10-11 16:08:40'),
(94, 2, 1, 9, 'Dinamarca', 'deleted', '', '2019-10-11 16:08:45', '2019-10-11 16:08:40'),
(95, 2, 1, 10, '.', 'original', '', NULL, '2019-10-11 16:08:40'),
(96, 2, 1, 1, 'Aarhus', 'original', '', NULL, '2019-10-11 16:12:02'),
(97, 2, 1, 2, 'é', 'original', '', NULL, '2019-10-11 16:12:02'),
(98, 2, 1, 3, 'o', 'original', '', NULL, '2019-10-11 16:12:02'),
(99, 2, 1, 4, 'aeroporto', 'deleted', '', '2019-10-11 16:12:04', '2019-10-11 16:12:02'),
(100, 2, 1, 5, 'de', 'deleted', '', '2019-10-11 16:12:05', '2019-10-11 16:12:02'),
(101, 2, 1, 6, 'Aarhus', 'deleted', '', '2019-10-11 16:12:06', '2019-10-11 16:12:02'),
(102, 2, 1, 7, 'aeroporto principal', 'added', '', '2019-10-11 16:12:18', '2019-10-11 16:12:02'),
(103, 2, 1, 8, ',', 'deleted', '', '2019-10-11 16:12:19', '2019-10-11 16:12:02'),
(104, 2, 1, 9, 'na', 'updated', 'da', '2019-10-11 16:12:21', '2019-10-11 16:12:02'),
(105, 2, 1, 10, 'Dinamarca', 'original', '', NULL, '2019-10-11 16:12:02'),
(106, 2, 1, 11, '.', 'original', '', NULL, '2019-10-11 16:12:02'),
(107, 1, 1, 1, 'Aeroporto', 'original', '', NULL, '2019-10-11 16:16:02'),
(108, 1, 1, 2, 'de', 'original', '', NULL, '2019-10-11 16:16:02'),
(109, 1, 1, 3, 'Aarhus', 'original', '', NULL, '2019-10-11 16:16:02'),
(110, 1, 1, 4, 'serve', 'original', '', NULL, '2019-10-11 16:16:02'),
(111, 1, 1, 5, 'a', 'original', '', NULL, '2019-10-11 16:16:02'),
(112, 1, 1, 6, 'cidade', 'original', '', NULL, '2019-10-11 16:16:02'),
(113, 1, 1, 7, 'de', 'original', '', NULL, '2019-10-11 16:16:02'),
(114, 1, 1, 8, 'Aarhus', 'deleted', '', '2019-10-11 16:16:15', '2019-10-11 16:16:02'),
(115, 1, 1, 9, ',', 'original', '', NULL, '2019-10-11 16:16:02'),
(116, 1, 1, 10, 'Dinamarca', 'deleted', '', '2019-10-11 16:16:14', '2019-10-11 16:16:02'),
(117, 1, 1, 11, '.', 'original', '', NULL, '2019-10-11 16:16:02'),
(118, 2, 1, 1, 'Aarhus', 'original', '', NULL, '2019-10-11 16:16:49'),
(119, 2, 1, 2, 'é', 'original', '', NULL, '2019-10-11 16:16:49'),
(120, 2, 1, 3, 'o', 'original', '', NULL, '2019-10-11 16:16:49'),
(121, 2, 1, 4, 'aeroporto', 'original', '', NULL, '2019-10-11 16:16:49'),
(122, 2, 1, 5, 'de', 'original', '', NULL, '2019-10-11 16:16:49'),
(123, 2, 1, 6, 'Aarhus', 'original', '', NULL, '2019-10-11 16:16:49'),
(124, 2, 1, 7, ',', 'deleted', '', '2019-10-11 16:16:53', '2019-10-11 16:16:49'),
(125, 2, 1, 8, 'na', 'deleted', '', '2019-10-11 16:16:52', '2019-10-11 16:16:49'),
(126, 2, 1, 9, 'Dinamarca', 'deleted', '', '2019-10-11 16:16:51', '2019-10-11 16:16:49'),
(127, 2, 1, 10, '.', 'original', '', NULL, '2019-10-11 16:16:49'),
(128, 1, 1, 1, 'Aeroporto', 'original', '', NULL, '2019-10-11 16:18:19'),
(129, 1, 1, 2, 'de', 'original', '', NULL, '2019-10-11 16:18:19'),
(130, 1, 1, 3, 'Aarhus', 'original', '', NULL, '2019-10-11 16:18:19'),
(131, 1, 1, 4, 'serve', 'original', '', NULL, '2019-10-11 16:18:19'),
(132, 1, 1, 5, 'a', 'original', '', NULL, '2019-10-11 16:18:19'),
(133, 1, 1, 6, 'cidade', 'original', '', NULL, '2019-10-11 16:18:19'),
(134, 1, 1, 7, 'de', 'original', '', NULL, '2019-10-11 16:18:19'),
(135, 1, 1, 8, 'Aarhus', 'original', '', NULL, '2019-10-11 16:18:19'),
(136, 1, 1, 9, ',', 'original', '', NULL, '2019-10-11 16:18:19'),
(137, 1, 1, 10, 'Dinamarca', 'original', '', NULL, '2019-10-11 16:18:19'),
(138, 1, 1, 11, '.', 'original', '', NULL, '2019-10-11 16:18:19');

-- --------------------------------------------------------

--
-- Table structure for table `Rewriting`
--

CREATE TABLE `Rewriting` (
  `id` int(11) NOT NULL,
  `translation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(200) NOT NULL,
  `isRewritten` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Rewriting`
--

INSERT INTO `Rewriting` (`id`, `translation_id`, `user_id`, `text`, `isRewritten`, `created_at`, `updated_at`) VALUES
(23, 1, 1, 'Aeroporto de Aarhus serve a cidade de Aarhus, Dinamarca.', 0, '2019-10-08 21:40:58', '2019-10-08 21:42:29'),
(24, 2, 1, 'Aarhus é o aeroporto de Aarhus, na Dinamarca.', 0, '2019-10-09 12:22:42', '2019-10-09 12:22:59'),
(26, 2, 1, 'Aarhus é o aeroporto de Aarhus.', 1, '2019-10-11 14:39:39', '2019-10-11 14:40:01'),
(28, 1, 4, 'Aeroporto de Aarhus serve a cidade de Aarhus.', 1, '2019-10-11 14:52:28', '2019-10-11 14:52:47'),
(29, 1, 4, 'Aeroporto de Aarhus serve a cidade de Aarhus, Dinamarca.', 0, '2019-10-11 14:52:34', '2019-10-11 14:52:54'),
(30, 2, 1, 'Aarhus é o aeroporto de Aarhus, na Dinamarca.', 0, '2019-10-11 16:00:55', '2019-10-11 16:01:17'),
(31, 1, 1, 'Aeroporto de Aarhus serve a cidade de Aarhus, Dinamarca.', 0, '2019-10-11 16:02:02', '2019-10-11 16:02:23'),
(32, 2, 1, 'Aarhus é o aeroporto de Aarhus, na Dinamarca.', 0, '2019-10-11 16:08:40', '2019-10-11 16:09:01'),
(33, 2, 1, 'Aarhus é o aeroporto de Aarhus, na Dinamarca.', 0, '2019-10-11 16:12:02', '2019-10-11 16:12:36'),
(34, 1, 1, 'Aeroporto de Aarhus serve a cidade de Aarhus, Dinamarca.', 0, '2019-10-11 16:16:02', '2019-10-11 16:16:30'),
(35, 2, 1, 'Aarhus é o aeroporto de Aarhus, na Dinamarca.', 0, '2019-10-11 16:16:49', '2019-10-11 16:17:08'),
(36, 1, 1, 'Aeroporto de Aarhus serve a cidade de Aarhus,.', 1, '2019-10-11 16:18:19', '2019-10-11 16:18:38');

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

--
-- Dumping data for table `Translation`
--

INSERT INTO `Translation` (`id`, `lex_id`, `engine_id`, `text`, `tokenized_text`, `created_at`) VALUES
(1, 1, 1, 'Aeroporto de Aarhus serve a cidade de Aarhus, Dinamarca.', 'Aeroporto de Aarhus serve a cidade de Aarhus , Dinamarca .', '2019-10-07 18:38:34'),
(2, 2, 1, 'Aarhus é o aeroporto de Aarhus, na Dinamarca.', 'Aarhus é o aeroporto de Aarhus , na Dinamarca .', '2019-10-08 13:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `TranslationEngine`
--

CREATE TABLE `TranslationEngine` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TranslationEngine`
--

INSERT INTO `TranslationEngine` (`id`, `name`, `created_at`) VALUES
(1, 'Google', '2019-10-07 18:37:36');

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
  `educational_level` varchar(45) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `name`, `email`, `age`, `sex`, `english_proficiency_level`, `educational_level`, `ip_address`, `created_at`) VALUES
(1, 'Thiago Castro Ferreira', 'thiago.castro.ferreira@gmail.com', '29', 'M', 'fluent', 'postgraduate', '127.0.0.1', '2019-10-08 13:19:10'),
(4, 'Angela Maria Castro Ferreira', 'angela.castro.ferreira@gmail.com', '60', 'F', 'basic', 'high_school', '127.0.0.1', '2019-10-11 14:52:41');

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
-- Indexes for table `LinearPosEditing`
--
ALTER TABLE `LinearPosEditing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translation_id` (`translation_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Entry`
--
ALTER TABLE `Entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Lex`
--
ALTER TABLE `Lex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `LinearPosEditing`
--
ALTER TABLE `LinearPosEditing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `PosEditing`
--
ALTER TABLE `PosEditing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `Rewriting`
--
ALTER TABLE `Rewriting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `Translation`
--
ALTER TABLE `Translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `TranslationEngine`
--
ALTER TABLE `TranslationEngine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `LinearPosEditing`
--
ALTER TABLE `LinearPosEditing`
  ADD CONSTRAINT `linear_translation` FOREIGN KEY (`translation_id`) REFERENCES `Translation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `linear_user` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
