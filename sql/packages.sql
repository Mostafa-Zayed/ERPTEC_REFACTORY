-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 28, 2023 at 05:43 PM
-- Server version: 10.5.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u521976387_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `location_count` int(11) NOT NULL COMMENT 'No. of Business Locations, 0 = infinite option.',
  `user_count` int(11) NOT NULL,
  `product_count` int(11) NOT NULL,
  `bookings` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Enable/Disable bookings',
  `kitchen` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Enable/Disable kitchen',
  `order_screen` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Enable/Disable order_screen',
  `tables` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Enable/Disable tables',
  `invoice_count` int(11) NOT NULL,
  `interval` enum('days','months','years') NOT NULL,
  `interval_count` int(11) NOT NULL,
  `trial_days` int(11) NOT NULL,
  `price` decimal(22,4) NOT NULL,
  `custom_permissions` longtext NOT NULL,
  `created_by` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT 0,
  `is_one_time` tinyint(1) NOT NULL DEFAULT 0,
  `enable_custom_link` tinyint(1) NOT NULL DEFAULT 0,
  `custom_link` varchar(191) DEFAULT NULL,
  `custom_link_text` varchar(191) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `location_count`, `user_count`, `product_count`, `bookings`, `kitchen`, `order_screen`, `tables`, `invoice_count`, `interval`, `interval_count`, `trial_days`, `price`, `custom_permissions`, `created_by`, `sort_order`, `is_active`, `is_private`, `is_one_time`, `enable_custom_link`, `custom_link`, `custom_link_text`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin Package', 'description', 0, 0, 0, 0, 0, 0, 0, 0, 'years', 2, 8, '0.0000', '{\"accounting_module\":\"1\",\"assetmanagement_module\":\"1\",\"connector_module\":\"1\",\"crm_module\":\"1\",\"essentials_module\":\"1\",\"garage_module\":\"1\",\"manufacturing_module\":\"1\",\"productcatalogue_module\":\"1\",\"project_module\":\"1\",\"repair_module\":\"1\",\"shipment_module\":\"1\",\"shop_module\":\"1\",\"shopify_module\":\"1\",\"spreadsheet_module\":\"1\",\"woocommerce_module\":\"1\",\"youcan_module\":\"1\"}', 1, 1, 1, 1, 0, 0, '', '', NULL, '2022-06-17 15:06:33', '2023-05-07 04:31:34'),
(2, '3 شهور مجانيه', 'حزمه لمده ثلاثه شهور مجانيه', 1, 1, 300, 0, 0, 0, 0, 300, 'months', 2, 5, '0.0000', '{\"accounting_module\":\"1\",\"assetmanagement_module\":\"1\",\"crm_module\":\"1\",\"essentials_module\":\"1\",\"manufacturing_module\":\"1\",\"productcatalogue_module\":\"1\",\"project_module\":\"1\",\"repair_module\":\"1\",\"woocommerce_module\":\"1\"}', 1, 3, 1, 0, 1, 0, '', '', NULL, '2023-01-12 21:15:39', '2023-05-18 18:52:14'),
(3, 'Start', 'For small business', 5, 5, 500, 0, 0, 0, 0, 500, 'months', 1, 5, '0.0000', '', 1, 0, 1, 0, 0, 0, '', '', '2023-04-09 00:05:37', '2023-03-11 01:09:31', '2023-04-09 00:05:37'),
(4, 'Free For 6 Months', 'Free For 6 Months', 1, 1, 100, 0, 0, 0, 0, 100, 'months', 6, 0, '0.0000', '{\"crm_module\":\"1\",\"essentials_module\":\"1\",\"manufacturing_module\":\"1\",\"productcatalogue_module\":\"1\",\"project_module\":\"1\",\"repair_module\":\"1\",\"woocommerce_module\":\"1\"}', 1, 2, 0, 0, 1, 0, '', '', NULL, '2023-04-09 00:23:23', '2023-05-07 04:30:54'),
(5, 'Free for 1 Year', 'Free for 1 Year', 1, 1, 100, 0, 0, 0, 0, 100, 'years', 1, 0, '0.0000', '{\"crm_module\":\"1\",\"essentials_module\":\"1\",\"manufacturing_module\":\"1\",\"productcatalogue_module\":\"1\",\"project_module\":\"1\",\"repair_module\":\"1\",\"woocommerce_module\":\"1\"}', 1, 3, 0, 0, 1, 0, '', '', NULL, '2023-04-09 00:24:27', '2023-05-07 04:31:05'),
(6, 'Free for 2 Years', 'Free for 2 Years', 1, 1, 80, 0, 0, 0, 0, 80, 'years', 2, 0, '0.0000', '{\"crm_module\":\"1\",\"essentials_module\":\"1\",\"manufacturing_module\":\"1\",\"productcatalogue_module\":\"1\",\"project_module\":\"1\",\"repair_module\":\"1\",\"woocommerce_module\":\"1\"}', 1, 4, 0, 0, 1, 0, '', '', NULL, '2023-04-09 00:25:30', '2023-05-07 04:30:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
