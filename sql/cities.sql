-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 28, 2023 at 05:04 PM
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
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` text DEFAULT NULL,
  `name_ar` text DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `zone_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `name_ar`, `country_id`, `zone_id`) VALUES
(1, 'Cairo', 'القاهرة', 64, 5),
(2, 'Alexandria', 'الأسكندرية', 64, 5),
(3, 'Aswan', 'أسوان', 64, NULL),
(4, 'Giza', 'الجيزة', 64, NULL),
(5, 'Albuhayra', 'البحيرة', 64, NULL),
(6, 'Dakahlia', 'الدقهلية', 64, NULL),
(7, 'Fayoum', 'الفيوم', 64, NULL),
(8, 'Al gharbia', 'الغربية', 64, NULL),
(9, 'Minya', 'المنيا', 64, NULL),
(10, 'Al Monufia', 'المنوفية', 64, NULL),
(11, 'Al Sharqia', 'الشرقية', 64, NULL),
(12, 'Asyut', 'أسيوط', 64, NULL),
(13, 'Bani Sweif', 'بني سويف', 64, NULL),
(14, 'Kafr El Sheikh', 'كفر الشيخ', 64, NULL),
(15, 'Luxor', 'الأقصر', 64, NULL),
(16, 'Marsa Matrouh', 'مرسى مطروح', 64, NULL),
(17, 'Alwadi Aljadid', 'الوادي الجديد', 64, NULL),
(18, 'PortSaid', 'بورسعيد', 64, NULL),
(19, 'Qalyubia', 'القليوبية', 64, NULL),
(21, 'The Red Sea', 'البحر الأحمر', 64, NULL),
(22, 'Souhag', 'سوهاج', 64, NULL),
(23, 'south sinai', 'جنوب سيناء', 64, NULL),
(24, 'Suez', 'السويس', 64, NULL),
(25, 'Damietta', 'دمياط', 64, NULL),
(26, 'Ismailia', 'الإسماعيلية', 64, NULL),
(27, 'Qana', 'قنا', 64, NULL),
(28, 'North Sinai', 'شمال سيناء', 64, NULL),
(30, 'Riyadh', 'الرياض', 191, NULL),
(32, 'Mecca', 'مكة المكرمة', 191, NULL),
(33, 'Madina El Monawara', 'المدينة المنورة', 191, NULL),
(34, 'Dammam', 'الدمام', 191, NULL),
(35, 'Eastern District', 'منطقة الشرقية', 191, NULL),
(36, 'Al-Qassim', 'القصيم', 191, NULL),
(37, 'Asir', 'عسير', 191, NULL),
(38, 'Tabuk', 'تبوك', 191, NULL),
(39, 'Hail', 'حائل', 191, NULL),
(40, 'Northern Border District', 'منطقة الحدود الشمالية', 191, NULL),
(41, 'jazan', 'جازان', 191, NULL),
(42, 'Najran', 'نجران', 191, NULL),
(43, 'albaha', 'الباحة', 191, NULL),
(44, 'aljawf', 'الجوف', 191, NULL),
(45, 'Taif', 'الطائف', 191, NULL),
(46, 'Qatif', 'القطيف', 191, NULL),
(47, 'Saudi Arabia', 'السعودية', 191, NULL),
(48, 'Dubai', 'دبي', 229, NULL),
(49, 'Abu Dhabi', 'ابوظبي', 229, NULL),
(50, 'Sharjah', 'الشارقة', 229, NULL),
(51, 'Ajman', 'عجمان', 229, NULL),
(52, 'Ras Al Khaimah', 'رأس الخيمة', 229, NULL),
(53, 'Fujairah', 'الفجيرة', 229, NULL),
(54, 'Umm Quwain', 'ام قيوين', 229, NULL),
(55, 'Al Easima', 'العاصمة', 117, NULL),
(56, 'Ahmadi', 'الأحمدي', 117, NULL),
(57, 'Al Farwaniyah', 'الفروانية', 117, NULL),
(58, 'Jahra', 'الجهراء', 117, NULL),
(59, 'Hawli', 'حولي', 117, NULL),
(60, 'Mubarak Al Kabir', 'مبارك الكبير', 117, NULL),
(61, 'Masqat', 'مسقط', 165, NULL),
(62, 'Dhofar', 'ظفار', 165, NULL),
(63, 'Musanadum', 'مسندم', 165, NULL),
(64, 'Al Barimi', 'البريمي', 165, NULL),
(65, 'Al Daakhilia', 'الداخلية', 165, NULL),
(66, 'Shamal Al Batina', 'شمال الباطنة', 165, NULL),
(67, 'Janub Al Batina', 'جنوب الباطنة', 165, NULL),
(68, 'Janub Al Sharqia', 'جنوب الشرقية', 165, NULL),
(69, 'Al Zaahira', 'الظاهرة', 165, NULL),
(70, 'Shamal Al Sharqia', 'شمال الشرقية', 165, NULL),
(71, 'Al Wustaa', 'الوسطى', 165, NULL),
(72, 'Capital', 'العاصمة', 17, NULL),
(73, 'Muharraq', 'المحرق', 17, NULL),
(74, 'Al Shamalia', 'الشمالية', 17, NULL),
(75, 'Southern', 'الجنوبية', 17, NULL),
(76, 'Beirut', 'بيروت', 121, NULL),
(77, 'Lebanon mountain', 'جبل لبنان', 121, NULL),
(78, 'North Lebanon', 'لبنان الشمالي', 121, NULL),
(79, 'South Lebanon', 'لبنان الجنوبي', 121, NULL),
(80, 'Al Biqae', 'البقاع', 121, NULL),
(81, 'Nabatieh', 'النبطية', 121, NULL),
(82, 'Baalbek-Hermel', 'بعلبك الهرمل', 121, NULL),
(83, 'Akkar', 'عكار', 121, NULL),
(84, 'Irbid', 'إربد', 111, NULL),
(85, 'Balqa', 'البلقاء', 111, NULL),
(86, 'Jerash', 'جرش', 111, NULL),
(87, 'Zarqa', 'الزرقاء', 111, NULL),
(88, 'Tafila', 'الطفيلة', 111, NULL),
(89, 'Ajloun', 'عجلون', 111, NULL),
(90, 'Al Eaqaba', 'العقبة', 111, NULL),
(91, 'Amman', 'عمان', 111, NULL),
(92, 'Karak', 'الكرك', 111, NULL),
(93, 'Madaba', 'مادبا', 111, NULL),
(95, 'Maean', 'معان', 111, NULL),
(96, 'Mafraq', 'المفرق', 111, NULL),
(2116, 'UAE', 'UAE', 229, NULL),
(2117, 'United kingdom', 'United kingdom', 230, NULL),
(2118, 'Kuwait', 'الكويت', 117, NULL),
(2119, 'Oman', 'عمان', 165, NULL),
(2120, 'Bahrain', 'البحرين', 17, NULL),
(2121, 'Lebanon', 'لبنان', 121, NULL),
(2122, 'Jordan', 'الاردن', 111, NULL),
(2123, 'Germany', 'المانيا', 82, NULL),
(2124, 'Turkey', 'تركيا', 223, NULL),
(2125, 'United States', 'الولايات المتحدة الامريكية', 231, NULL),
(2126, 'Canada', 'كندا', 38, NULL),
(2129, 'Qatar', 'قطر', 178, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2130;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
