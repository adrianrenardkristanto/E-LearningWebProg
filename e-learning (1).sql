-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 06:38 PM
-- Server version: 11.5.0-MariaDB
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
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `modul_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `title`, `author`, `description`, `cover`, `modul_id`) VALUES
(1, 'Diari si Bocah Tengil', 'John Smith', 'Buku ini membahas prinsip dasar seni dan desain secara komprehensif untuk pemula.', 'cover_683a66b7c00e74.91952856.jpg', 1),
(4, 'Practical Design Thinking', 'Anna Kim', 'Membahas aplikasi design thinking dalam berbagai bidang bisnis dan teknologi.', 'cover_683a66f006dbf1.71974951.jpg', 2),
(6, 'Responsive Web Design Bu Ken', 'Sarah Williams', 'Buku ini fokus pada teknik desain web yang responsif dan ramah perangkat mobile.', 'cover_683a657350d505.66277995.jpg', NULL),
(7, 'buku 4', NULL, NULL, '683a6fbe5fb12.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_modul`
--

CREATE TABLE `kategori_modul` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `detail_page` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`modul_id`, `title`, `description`, `is_premium`, `category_id`) VALUES
(1, 'Art & Design Web Ken', 'Modul ini membahas prinsip dasar seni rupa dan elemen visual yang penting dalam desain. Tapi boong, yahahahaha', 1, 1),
(2, 'Desain Thinking', 'Pelajari pendekatan kreatif dalam memecahkan masalah dengan metode desain thinking secara sistematis.', 1, 2),
(5, 'modul', 'deskripsi', 1, 1),
(6, 'Modul kesekian', 'ga tau ah', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `modul_book`
--

CREATE TABLE `modul_book` (
  `modul_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modul_book`
--

INSERT INTO `modul_book` (`modul_id`, `book_id`) VALUES
(1, 1),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` varchar(50) DEFAULT NULL,
  `is_verified` enum('Unverified','Verified') DEFAULT 'Unverified',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`transaction_id`, `user_id`, `price`, `is_verified`, `created_at`) VALUES
(3, 10, '900000', 'Verified', '2025-05-31 12:00:00');

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
  `profile_pic` varchar(255) DEFAULT NULL,
  `role` enum('Learner','Tutor','Admin') NOT NULL,
  `isVerified` enum('Unverified','Verified') DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone_number`, `profile_pic`, `role`, `isVerified`, `created_at`) VALUES
(10, 'mm94', 'mmarquez@gmail.com', '$2y$10$sL/sN3MNA9sjoSr7OrBHzOXQDrl2SVLGMzQulBXHjeBVmtWsGC/Ry', NULL, 'Kwon Minju (Han Junhee)2.jpg', 'Learner', NULL, '2025-05-01'),
(14, 'adrian', 'adrian@gmail.com', '$2y$10$it9wWMdlnvfe24td6SqxT.8RltlhrLWcW34H0BP43sY4KL5nb7jnm', NULL, NULL, 'Admin', NULL, '2025-05-15'),
(15, 'Jesha', 'jesha@gmail.com', '$2y$10$o91Wh4GA6fznu67O2MBE8OeE8MKOpYLc4Puans0sydTcyCZKSOFM.', NULL, NULL, 'Admin', NULL, '2025-05-27'),
(17, 'tes', 'tes@gmail.com', '$2y$10$Hi1FFh7ttUmguwP0Fj6fGuYi91DjBaCdmta6niY.YTEfS4bountZ.', NULL, NULL, 'Learner', NULL, '2025-05-28'),
(18, 'John Doe', 'jd@gmail.com', '$2y$10$3qoJs1nehEvrvhSkc5hAAeTeX666exuNAX4Ang3niqnQs/GG/qaKS', NULL, NULL, 'Tutor', 'Verified', '2025-05-30'),
(19, 'richi', 'wijawa@gmail.com', '$2y$10$awP4JciwGwouHZPizRbzievFvabSvBwXJh6Nlj01UhRMkzSPSvuAe', NULL, NULL, 'Tutor', 'Unverified', '2025-05-31'),
(20, 'siapapun', 'siapapun@gmail.com', '$2y$10$i5BoYu9HkRzGtbpeJ5F99u2AvDvRkLMAz2gmOFT5aC/xFjKGMyVkC', NULL, NULL, 'Admin', NULL, '2025-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `user_kategori`
--

CREATE TABLE `user_kategori` (
  `user_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_kategori`
--

INSERT INTO `user_kategori` (`user_id`, `kategori_id`) VALUES
(18, 1),
(19, 1),
(19, 2);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`video_id`, `title`, `description`, `modul_id`, `url`, `upload_date`) VALUES
(2, 'Desain Thinking 1', 'Pendahuluan Design Thinking', 2, 'https://www.youtube.com/embed/yfoY53QXEnI', '2024-01-02'),
(3, 'Desain Thinking 2', 'Langkah Design Thinking', 2, 'https://www.youtube.com/embed/Q33KBiDriJY', '2024-01-03'),
(7, '1', '1', 5, 'https://www.youtube.com/embed/4K8vGd6PHCc', '2025-05-31');

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
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_kategori`
--
ALTER TABLE `user_kategori`
  ADD KEY `fk_user_course` (`user_id`),
  ADD KEY `user_course_ibfk_2` (`kategori_id`);

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
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori_modul`
--
ALTER TABLE `kategori_modul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `modul_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_kategori`
--
ALTER TABLE `user_kategori`
  ADD CONSTRAINT `fk_user_course` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_kategori_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_kategori_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_modul` (`id`);

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`modul_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
