-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 12:07 PM
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
-- Database: `poseidon`
--

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_accounts`
--

CREATE TABLE `chart_of_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chart_of_accounts`
--

INSERT INTO `chart_of_accounts` (`id`, `account_name`, `account_number`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'الاصول', '1', NULL, '2025-04-09 07:02:20', '2025-04-09 07:02:20'),
(2, 'الإلتزامات وصافي الأصول', '2', NULL, '2025-04-09 07:04:22', '2025-04-09 07:04:22'),
(3, 'الإيرادات والتبرعات', '3', NULL, '2025-04-09 07:05:00', '2025-04-09 07:05:00'),
(4, 'المصروفات', '4', NULL, '2025-04-09 07:05:55', '2025-04-09 07:05:55'),
(5, 'الاصول المتداوله', '11', '1', '2025-04-09 07:06:25', '2025-04-09 07:06:25'),
(6, 'الاصول غير المتداوله', '12', '1', '2025-04-09 07:07:08', '2025-04-09 07:07:08'),
(7, 'اصول الاوقاف', '13', '1', '2025-04-09 07:07:25', '2025-04-09 07:07:25'),
(8, 'النقدية وما في حكمها', '111', '5', '2025-04-09 07:07:52', '2025-04-09 07:07:52'),
(9, 'نقدية وودائع في البنوك', '1111', '8', '2025-04-09 07:08:23', '2025-04-09 07:08:23'),
(10, 'حسابات جارية - مصرف الراجحي', '11111', '9', '2025-04-09 07:08:54', '2025-04-09 07:08:54'),
(11, 'مصرف الراجحي-فرع السادة- ح/العام 510000', '111111', '10', '2025-04-09 07:10:21', '2025-04-09 07:10:21'),
(12, 'احد', '121', '6', '2025-04-09 07:11:31', '2025-04-09 07:11:31'),
(13, 'ءئؤ', '6548', '12', '2025-04-09 07:15:10', '2025-04-09 07:15:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_number_parent_unique` (`account_number`,`parent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
