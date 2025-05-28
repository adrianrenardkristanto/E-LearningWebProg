-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 02:38 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

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
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `modul_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `title`, `author`, `description`, `cover`, `modul_id`) VALUES
(1, 'Fundamentals of Art & Design', 'John Smith', 'Buku ini membahas prinsip dasar seni dan desain secara komprehensif untuk pemula.', 'art.jpg', 1),
(2, 'Color Theory and Composition', 'Lisa Brown', 'Panduan lengkap teori warna dan komposisi dalam seni visual untuk menciptakan karya yang harmonis.', 'UIUX.jpg', 1),
(3, 'Introduction to Design Thinking', 'Michael Lee', 'Buku ini menjelaskan proses design thinking secara langkah demi langkah dengan studi kasus nyata.', 'eloquent-js.jpg', 2),
(4, 'Practical Design Thinking', 'Anna Kim', 'Membahas aplikasi design thinking dalam berbagai bidang bisnis dan teknologi.', 'marsha.jpg', 2),
(5, 'Web Development Basics', 'David Johnson', 'Tutorial lengkap belajar pengembangan web dari dasar hingga mahir menggunakan HTML, CSS, dan JS.', 'html.jpg', 3),
(6, 'Responsive Web Design', 'Sarah Williams', 'Buku ini fokus pada teknik desain web yang responsif dan ramah perangkat mobile.', 'web.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_modul`
--

CREATE TABLE `kategori_modul` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `detail_page` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_modul`
--

INSERT INTO `kategori_modul` (`id`, `nama`, `detail_page`) VALUES
(1, 'Art & Design', 'detail_art-design.php'),
(2, 'Desain Thinking', 'detail_desain-thinking.php'),
(3, 'Web Development', 'detail_web-dev.php');

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `modul_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_premium` tinyint(1) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`modul_id`, `title`, `description`, `is_premium`, `category_id`) VALUES
(1, 'Art & Design', 'Modul ini membahas prinsip dasar seni rupa dan elemen visual yang penting dalam desain.', 0, 1),
(2, 'Desain Thinking', 'Pelajari pendekatan kreatif dalam memecahkan masalah dengan metode desain thinking secara sistematis.', 1, 2),
(3, 'Web Development', 'Modul ini mengajarkan pembuatan situs web menggunakan HTML, CSS, dan pengantar JavaScript.', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `modul_book`
--

CREATE TABLE `modul_book` (
  `modul_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `modul_book`
--

INSERT INTO `modul_book` (`modul_id`, `book_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Learner','Tutor','Admin') DEFAULT 'Learner',
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `profile_pic`) VALUES
(1, 'Adrian Renard Kristianto', 'adrian@example.com', '$2y$10$JIMESaOkF0TV0OZoJsz8.OyF1rreY6OVU33V/MLqw7YCP1B6dAn/i', 'Learner', 'boy.jpg'),
(2, 'Jesha Alkeba', 'jesha@example.com', '$2y$10$/Ok9FGlxO3Kd5y8Zob/ppO32zQNz.B4qw6hdiEZR/uCOxjvKSi6xi', 'Learner', 'girl.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `video_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `modul_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `upload_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_id`, `title`, `description`, `modul_id`, `url`, `upload_date`) VALUES
(1, 'Intro to Art', 'Dasar seni dan prinsip desain', 1, 'https://www.youtube.com/embed/pQN-pnXPaVg', '2024-01-01'),
(2, 'Desain Thinking 1', 'Pendahuluan Design Thinking', 2, 'https://www.youtube.com/embed/yfoY53QXEnI', '2024-01-02'),
(3, 'Desain Thinking 2', 'Langkah Design Thinking', 2, 'https://www.youtube.com/embed/Q33KBiDriJY', '2024-01-03'),
(4, 'Web Dev HTML', 'Belajar HTML dasar', 3, 'https://www.youtube.com/embed/hdI2bqOjy3c', '2024-01-04'),
(5, 'Web Dev CSS', 'Pengantar CSS', 3, 'https://www.youtube.com/embed/4K8vGd6PHCc', '2024-01-05'),
(6, 'Web Dev JS', 'Dasar JavaScript', 3, 'https://www.youtube.com/embed/5Y2ZnVCHWfQ', '2024-01-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `modul_id` (`modul_id`);

--
-- Indexes for table `kategori_modul`
--
ALTER TABLE `kategori_modul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`modul_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `modul_book`
--
ALTER TABLE `modul_book`
  ADD PRIMARY KEY (`modul_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`modul_id`) ON DELETE SET NULL;

--
-- Constraints for table `modul`
--
ALTER TABLE `modul`
  ADD CONSTRAINT `modul_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `kategori_modul` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `modul_book`
--
ALTER TABLE `modul_book`
  ADD CONSTRAINT `modul_book_ibfk_1` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`modul_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `modul_book_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`modul_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
