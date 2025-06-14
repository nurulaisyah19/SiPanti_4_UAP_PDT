-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2025 at 04:59 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipanti`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `tambah_penyaluran` (IN `nama` VARCHAR(100), IN `jenis` VARCHAR(50), IN `jumlah` DOUBLE, IN `ket` TEXT)   BEGIN
    INSERT INTO penyaluran (nama_penerima, jenis_bantuan, jumlah, keterangan)
    VALUES (nama, jenis, jumlah, ket);
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `get_total_donasi` (`uid` INT) RETURNS DOUBLE DETERMINISTIC BEGIN
    DECLARE total DOUBLE;
    SELECT SUM(amount) INTO total FROM donations WHERE user_id = uid;
    RETURN IFNULL(total, 0);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_donasi` (`uid` INT) RETURNS DOUBLE DETERMINISTIC BEGIN
  DECLARE total DOUBLE;
  SELECT SUM(amount) INTO total FROM donations WHERE user_id = uid;
  RETURN IFNULL(total, 0);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `user_id`, `amount`, `description`, `created_at`) VALUES
(1, 1, 12000, 'ff', '2025-06-14 04:26:35'),
(4, 2, 5000, 'yaa', '2025-06-14 04:57:17');

--
-- Triggers `donations`
--
DELIMITER $$
CREATE TRIGGER `after_donation_insert` AFTER INSERT ON `donations` FOR EACH ROW BEGIN
  INSERT INTO log_donasi (user_id, amount, log_message)
  VALUES (NEW.user_id, NEW.amount, CONCAT('Donasi sebesar Rp ', NEW.amount, ' ditambahkan.'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `log_donasi`
--

CREATE TABLE `log_donasi` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `log_message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `log_donasi`
--

INSERT INTO `log_donasi` (`id`, `user_id`, `amount`, `log_message`, `created_at`) VALUES
(1, 2, 5000, 'Donasi sebesar Rp 5000 ditambahkan.', '2025-06-14 04:57:17');

-- --------------------------------------------------------

--
-- Table structure for table `penyaluran`
--

CREATE TABLE `penyaluran` (
  `id` int NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `jenis_bantuan` varchar(100) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penyaluran`
--

INSERT INTO `penyaluran` (`id`, `nama_penerima`, `jenis_bantuan`, `jumlah`, `keterangan`, `created_at`) VALUES
(1, 'mira', 'uang', 1000, 'ya', '2025-06-13 16:45:13'),
(2, 'ilham', 'uang', 10000, 'buat jajan', '2025-06-14 04:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Nurul Aisyah', 'nurul.aisah3000@gmail.com', '$2y$10$6u79hYOlysm33dU2vs77iuRA1YhpELpLSuRnQLLfpq591ZhZkTRC2', 'user'),
(2, 'mira', 'mira@gmail.com', '$2y$10$TclF659UhrYctGSguvLy6eVD41GpFlrQhG2GkhPdie76t.nmbdV8W', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `log_donasi`
--
ALTER TABLE `log_donasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penyaluran`
--
ALTER TABLE `penyaluran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log_donasi`
--
ALTER TABLE `log_donasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penyaluran`
--
ALTER TABLE `penyaluran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
