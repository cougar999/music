-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2018 at 01:31 AM
-- Server version: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music`
--

-- --------------------------------------------------------

--
-- Table structure for table `genre_likes`
--

CREATE TABLE `genre_likes` (
  `id` int(11) NOT NULL,
  `owner_user_id` int(11) NOT NULL COMMENT 'This is the owner''s id, maybe album_id or track_id',
  `genre_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL COMMENT 'album or track',
  `order` tinyint(4) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genre_likes`
--

INSERT INTO `genre_likes` (`id`, `owner_user_id`, `genre_id`, `type`, `order`, `active`) VALUES
(50, 42, 36, '', NULL, 1),
(49, 42, 6, '', NULL, 1),
(48, 42, 1, '', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genre_likes`
--
ALTER TABLE `genre_likes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `genre_likes`
--
ALTER TABLE `genre_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
