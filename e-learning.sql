-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 07:36 AM
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
-- Database: `e-learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `title`, `author`, `description`) VALUES
(1, 'Eloquent JavaScript', 'Marijn Haverbeke', 'Buku lengkap untuk belajar JavaScript dari dasar hingga lanjutan.'),
(2, 'Clean Code', 'Robert C. Martin', 'Panduan menulis kode yang bersih, rapi dan mudah dipahami oleh developer.');

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `modul_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `upload_date` date DEFAULT NULL,
  `is_premium` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`modul_id`, `title`, `description`, `category`, `created_by`, `upload_date`, `is_premium`) VALUES
(1, 'Dasar HTML', 'Modul pengenalan HTML dari struktur dasar hingga form.', 'Frontend', 1, '2025-05-01', 0),
(2, 'Dasar CSS', 'Modul pembelajaran CSS seperti styling dan layout.', 'Frontend', 1, '2025-05-02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `profile_picture` mediumblob DEFAULT NULL,
  `role` enum('Learner','Tutor','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone_number`, `profile_picture`, `role`) VALUES
(3, 'mm93', 'mmarquez@gmail.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, 'Learner'),
(4, 'roin ganteng', 'callmepecco@gmail.com', '$2y$10$cNlfUutv0Go9M0ZDqeplYukTGsXZZVwjkspPyoWFphMtl4B6sbN8G', NULL, NULL, 'Learner'),
(5, 'roin', 'aaa@gmail.com', '$2y$10$4f0/VRsPY/qGkThhlqIOk.SktzS1O3H4ppbqeho0pHpBm5HV7M.uu', NULL, NULL, 'Learner'),
(6, 'John Doe', 'tes@gmail.com', '$2y$10$7IDqh1F7EK87ffXay4ljeOeRzL1sxUPPv3qO6M.i.yF6y3X8BYkbi', NULL, NULL, 'Learner');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `video_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `modul_id` int(11) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `upload_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_id`, `title`, `description`, `modul_id`, `url`, `upload_date`) VALUES
(3, 'Belajar HTML Dasar', 'Video pengantar HTML untuk pemula.', 1, 'https://www.youtube.com/embed/pQN-pnXPaVg', '2025-05-01'),
(4, 'Belajar CSS Flexbox', 'Dasar-dasar layout Flexbox di CSS.', 2, 'https://www.youtube.com/embed/fYq5PXgSsbE', '2025-05-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`modul_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `modul_id` (`modul_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `modul_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`modul_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
