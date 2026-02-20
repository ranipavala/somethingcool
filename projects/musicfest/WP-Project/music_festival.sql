-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 13, 2025 at 07:07 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music_festival`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
CREATE TABLE IF NOT EXISTS `administrators` (
  `adminID` int NOT NULL AUTO_INCREMENT,
  `admin_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`adminID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`adminID`, `admin_email`, `password`) VALUES
(1, 'khirtynamala@gmail.com', '12345'),
(2, 'john@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

DROP TABLE IF EXISTS `event_registrations`;
CREATE TABLE IF NOT EXISTS `event_registrations` (
  `event_ID` int NOT NULL AUTO_INCREMENT,
  `ticket_id` varchar(255) NOT NULL,
  `ticket_type` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `seating_zone` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `userID` int NOT NULL,
  PRIMARY KEY (`event_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event_registrations`
--

INSERT INTO `event_registrations` (`event_ID`, `ticket_id`, `ticket_type`, `category`, `seating_zone`, `quantity`, `total_price`, `userID`) VALUES
(1, '3EARLY BIRD-266-326ZONE A - RM 100-4', 'Early Bird-266-326', 'malaysian', 'Zone A - RM 100', 4, 1464.00, 3);

-- --------------------------------------------------------

--
-- Table structure for table `subevent`
--

DROP TABLE IF EXISTS `subevent`;
CREATE TABLE IF NOT EXISTS `subevent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subevent_name` varchar(255) NOT NULL,
  `event_day` date NOT NULL,
  `event_time` time NOT NULL,
  `place` varchar(255) NOT NULL,
  `organizer` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subevent`
--

INSERT INTO `subevent` (`id`, `subevent_name`, `event_day`, `event_time`, `place`, `organizer`, `description`) VALUES
(1, 'chua\'s singing', '2026-03-31', '09:30:00', 'uniten', 'tnb', 'u better sing well');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contact` varchar(50) NOT NULL,
  `ic` varchar(50) NOT NULL,
  `password` varchar(155) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `fullname`, `username`, `email`, `contact`, `ic`, `password`) VALUES
(1, 'Damon Salvatore', 'tvd', 'tcd21@gmail.com', '17652148', '214585693', ''),
(2, 'MiaThermopolis', 'mia', 'mia@gmail.com', '0199853177', '040521050406', '12345'),
(3, 'Thevamurugan', 'theva', 'theva@gmail.com', '0196206205', '021231050708', '2131777');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
