-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 28, 2023 at 05:06 PM
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
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) UNSIGNED NOT NULL,
  `country_name` text NOT NULL,
  `name_ar` text DEFAULT NULL,
  `country_code` char(10) DEFAULT NULL,
  `nicename` varchar(100) DEFAULT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`, `name_ar`, `country_code`, `nicename`, `iso3`, `numcode`, `phonecode`, `photo`, `status`) VALUES
(1, 'Afghanistan', NULL, 'AF', NULL, NULL, NULL, 93, NULL, 1),
(3, 'Algeria', NULL, 'DZ', NULL, NULL, NULL, 213, NULL, 1),
(4, 'American Samoa', NULL, 'AS', NULL, NULL, NULL, 1684, NULL, 1),
(5, 'Andorra', NULL, 'AD', NULL, NULL, NULL, 376, NULL, 1),
(6, 'Angola', NULL, 'AO', NULL, NULL, NULL, 244, NULL, 1),
(8, 'Antarctica', NULL, 'AQ', NULL, NULL, NULL, 0, NULL, 1),
(9, 'Antigua And Barbuda', NULL, 'AG', NULL, NULL, NULL, 1268, NULL, 1),
(10, 'Argentina', NULL, 'AR', NULL, NULL, NULL, 54, NULL, 1),
(11, 'Armenia', NULL, 'AM', NULL, NULL, NULL, 374, NULL, 1),
(12, 'Aruba', NULL, 'AW', NULL, NULL, NULL, 297, NULL, 1),
(13, 'Australia', NULL, 'AU', NULL, NULL, NULL, 61, NULL, 1),
(14, 'Austria', NULL, 'AT', NULL, NULL, NULL, 43, NULL, 1),
(15, 'Azerbaijan', NULL, 'AZ', NULL, NULL, NULL, 994, NULL, 1),
(16, 'Bahamas The', NULL, 'BS', NULL, NULL, NULL, 1242, NULL, 1),
(17, 'Bahrain', NULL, 'BH', NULL, NULL, NULL, 973, NULL, 1),
(18, 'Bangladesh', NULL, 'BD', NULL, NULL, NULL, 880, NULL, 1),
(19, 'Barbados', NULL, 'BB', NULL, NULL, NULL, 1246, NULL, 1),
(21, 'Belgium', NULL, 'BE', NULL, NULL, NULL, 32, NULL, 1),
(22, 'Belize', NULL, 'BZ', NULL, NULL, NULL, 501, NULL, 1),
(23, 'Benin', NULL, 'BJ', NULL, NULL, NULL, 229, NULL, 1),
(24, 'Bermuda', NULL, 'BM', NULL, NULL, NULL, 1441, NULL, 1),
(25, 'Bhutan', NULL, 'BT', NULL, NULL, NULL, 975, NULL, 1),
(26, 'Bolivia', NULL, 'BO', NULL, NULL, NULL, 591, NULL, 1),
(27, 'Bosnia and Herzegovina', NULL, 'BA', NULL, NULL, NULL, 387, NULL, 1),
(28, 'Botswana', NULL, 'BW', NULL, NULL, NULL, 267, NULL, 1),
(29, 'Bouvet Island', NULL, 'BV', NULL, NULL, NULL, 0, NULL, 1),
(30, 'Brazil', NULL, 'BR', NULL, NULL, NULL, 55, NULL, 1),
(31, 'British Indian Ocean Territory', NULL, 'IO', NULL, NULL, NULL, 246, NULL, 1),
(32, 'Brunei', NULL, 'BN', NULL, NULL, NULL, 673, NULL, 1),
(33, 'Bulgaria', NULL, 'BG', NULL, NULL, NULL, 359, NULL, 1),
(34, 'Burkina Faso', NULL, 'BF', NULL, NULL, NULL, 226, NULL, 1),
(35, 'Burundi', NULL, 'BI', NULL, NULL, NULL, 257, NULL, 1),
(36, 'Cambodia', NULL, 'KH', NULL, NULL, NULL, 855, NULL, 1),
(37, 'Cameroon', NULL, 'CM', NULL, NULL, NULL, 237, NULL, 1),
(38, 'Canada', NULL, 'CA', NULL, NULL, NULL, 1, NULL, 1),
(39, 'Cape Verde', NULL, 'CV', NULL, NULL, NULL, 238, NULL, 1),
(40, 'Cayman Islands', NULL, 'KY', NULL, NULL, NULL, 1345, NULL, 1),
(41, 'Central African Republic', NULL, 'CF', NULL, NULL, NULL, 236, NULL, 1),
(42, 'Chad', NULL, 'TD', NULL, NULL, NULL, 235, NULL, 1),
(43, 'Chile', NULL, 'CL', NULL, NULL, NULL, 56, NULL, 1),
(44, 'China', NULL, 'CN', NULL, NULL, NULL, 86, NULL, 1),
(45, 'Christmas Island', NULL, 'CX', NULL, NULL, NULL, 61, NULL, 1),
(46, 'Cocos (Keeling) Islands', NULL, 'CC', NULL, NULL, NULL, 672, NULL, 1),
(47, 'Colombia', NULL, 'CO', NULL, NULL, NULL, 57, NULL, 1),
(48, 'Comoros', NULL, 'KM', NULL, NULL, NULL, 269, NULL, 1),
(49, 'Republic Of The Congo', NULL, 'CG', NULL, NULL, NULL, 242, NULL, 1),
(50, 'Democratic Republic Of The Congo', NULL, 'CD', NULL, NULL, NULL, 242, NULL, 1),
(51, 'Cook Islands', NULL, 'CK', NULL, NULL, NULL, 682, NULL, 1),
(52, 'Costa Rica', NULL, 'CR', NULL, NULL, NULL, 506, NULL, 1),
(53, 'Cote D\'Ivoire (Ivory Coast)', NULL, 'CI', NULL, NULL, NULL, 225, NULL, 1),
(54, 'Croatia (Hrvatska)', NULL, 'HR', NULL, NULL, NULL, 385, NULL, 1),
(55, 'Cuba', NULL, 'CU', NULL, NULL, NULL, 53, NULL, 1),
(56, 'Cyprus', NULL, 'CY', NULL, NULL, NULL, 357, NULL, 1),
(57, 'Czech Republic', NULL, 'CZ', NULL, NULL, NULL, 420, NULL, 1),
(58, 'Denmark', NULL, 'DK', NULL, NULL, NULL, 45, NULL, 1),
(59, 'Djibouti', NULL, 'DJ', NULL, NULL, NULL, 253, NULL, 1),
(60, 'Dominica', NULL, 'DM', NULL, NULL, NULL, 1767, NULL, 1),
(61, 'Dominican Republic', NULL, 'DO', NULL, NULL, NULL, 1809, NULL, 1),
(62, 'East Timor', NULL, 'TP', NULL, NULL, NULL, 670, NULL, 1),
(63, 'Ecuador', NULL, 'EC', NULL, NULL, NULL, 593, NULL, 1),
(64, 'Egypt', 'مصر', 'EG', NULL, NULL, NULL, 2, NULL, 1),
(65, 'El Salvador', NULL, 'SV', NULL, NULL, NULL, 503, NULL, 1),
(66, 'Equatorial Guinea', NULL, 'GQ', NULL, NULL, NULL, 240, NULL, 1),
(67, 'Eritrea', NULL, 'ER', NULL, NULL, NULL, 291, NULL, 1),
(68, 'Estonia', NULL, 'EE', NULL, NULL, NULL, 372, NULL, 1),
(69, 'Ethiopia', NULL, 'ET', NULL, NULL, NULL, 251, NULL, 1),
(70, 'External Territories of Australia', NULL, 'XA', NULL, NULL, NULL, 61, NULL, 1),
(71, 'Falkland Islands', NULL, 'FK', NULL, NULL, NULL, 500, NULL, 1),
(72, 'Faroe Islands', NULL, 'FO', NULL, NULL, NULL, 298, NULL, 1),
(73, 'Fiji Islands', NULL, 'FJ', NULL, NULL, NULL, 679, NULL, 1),
(74, 'Finland', NULL, 'FI', NULL, NULL, NULL, 358, NULL, 1),
(75, 'France', NULL, 'FR', NULL, NULL, NULL, 33, NULL, 1),
(76, 'French Guiana', NULL, 'GF', NULL, NULL, NULL, 594, NULL, 1),
(77, 'French Polynesia', NULL, 'PF', NULL, NULL, NULL, 689, NULL, 1),
(78, 'French Southern Territories', NULL, 'TF', NULL, NULL, NULL, 0, NULL, 1),
(79, 'Gabon', NULL, 'GA', NULL, NULL, NULL, 241, NULL, 1),
(80, 'Gambia The', NULL, 'GM', NULL, NULL, NULL, 220, NULL, 1),
(81, 'Georgia', NULL, 'GE', NULL, NULL, NULL, 995, NULL, 1),
(82, 'Germany', NULL, 'DE', NULL, NULL, NULL, 49, NULL, 1),
(83, 'Ghana', NULL, 'GH', NULL, NULL, NULL, 233, NULL, 1),
(84, 'Gibraltar', NULL, 'GI', NULL, NULL, NULL, 350, NULL, 1),
(85, 'Greece', NULL, 'GR', NULL, NULL, NULL, 30, NULL, 1),
(86, 'Greenland', NULL, 'GL', NULL, NULL, NULL, 299, NULL, 1),
(87, 'Grenada', NULL, 'GD', NULL, NULL, NULL, 1473, NULL, 1),
(88, 'Guadeloupe', NULL, 'GP', NULL, NULL, NULL, 590, NULL, 1),
(89, 'Guam', NULL, 'GU', NULL, NULL, NULL, 1671, NULL, 1),
(90, 'Guatemala', NULL, 'GT', NULL, NULL, NULL, 502, NULL, 1),
(91, 'Guernsey and Alderney', NULL, 'XU', NULL, NULL, NULL, 44, NULL, 1),
(92, 'Guinea', NULL, 'GN', NULL, NULL, NULL, 224, NULL, 1),
(93, 'Guinea-Bissau', NULL, 'GW', NULL, NULL, NULL, 245, NULL, 1),
(94, 'Guyana', NULL, 'GY', NULL, NULL, NULL, 592, NULL, 1),
(95, 'Haiti', NULL, 'HT', NULL, NULL, NULL, 509, NULL, 1),
(96, 'Heard and McDonald Islands', NULL, 'HM', NULL, NULL, NULL, 0, NULL, 1),
(97, 'Honduras', NULL, 'HN', NULL, NULL, NULL, 504, NULL, 1),
(98, 'Hong Kong S.A.R.', NULL, 'HK', NULL, NULL, NULL, 852, NULL, 1),
(99, 'Hungary', NULL, 'HU', NULL, NULL, NULL, 36, NULL, 1),
(100, 'Iceland', NULL, 'IS', NULL, NULL, NULL, 354, NULL, 1),
(101, 'India', NULL, 'IN', NULL, NULL, NULL, 91, NULL, 1),
(102, 'Indonesia', NULL, 'ID', NULL, NULL, NULL, 62, NULL, 1),
(103, 'Iran', NULL, 'IR', NULL, NULL, NULL, 98, NULL, 1),
(104, 'Iraq', 'العراق', 'IQ', NULL, NULL, NULL, 964, NULL, 1),
(105, 'Ireland', NULL, 'IE', NULL, NULL, NULL, 353, NULL, 1),
(106, 'Israel', NULL, 'IL', NULL, NULL, NULL, 972, NULL, 1),
(107, 'Italy', NULL, 'IT', NULL, NULL, NULL, 39, NULL, 1),
(108, 'Jamaica', NULL, 'JM', NULL, NULL, NULL, 1876, NULL, 1),
(109, 'Japan', NULL, 'JP', NULL, NULL, NULL, 81, NULL, 1),
(110, 'Jersey', NULL, 'XJ', NULL, NULL, NULL, 44, NULL, 1),
(111, 'Jordan', NULL, 'JO', NULL, NULL, NULL, 962, NULL, 1),
(112, 'Kazakhstan', NULL, 'KZ', NULL, NULL, NULL, 7, NULL, 1),
(113, 'Kenya', NULL, 'KE', NULL, NULL, NULL, 254, NULL, 1),
(114, 'Kiribati', NULL, 'KI', NULL, NULL, NULL, 686, NULL, 1),
(115, 'Korea North', NULL, 'KP', NULL, NULL, NULL, 850, NULL, 1),
(116, 'Korea South', NULL, 'KR', NULL, NULL, NULL, 82, NULL, 1),
(117, 'Kuwait', NULL, 'KW', NULL, NULL, NULL, 965, NULL, 1),
(118, 'Kyrgyzstan', NULL, 'KG', NULL, NULL, NULL, 996, NULL, 1),
(119, 'Laos', NULL, 'LA', NULL, NULL, NULL, 856, NULL, 1),
(120, 'Latvia', NULL, 'LV', NULL, NULL, NULL, 371, NULL, 1),
(121, 'Lebanon', NULL, 'LB', NULL, NULL, NULL, 961, NULL, 1),
(122, 'Lesotho', NULL, 'LS', NULL, NULL, NULL, 266, NULL, 1),
(123, 'Liberia', NULL, 'LR', NULL, NULL, NULL, 231, NULL, 1),
(124, 'Libya', NULL, 'LY', NULL, NULL, NULL, 218, NULL, 1),
(125, 'Liechtenstein', NULL, 'LI', NULL, NULL, NULL, 423, NULL, 1),
(126, 'Lithuania', NULL, 'LT', NULL, NULL, NULL, 370, NULL, 1),
(127, 'Luxembourg', NULL, 'LU', NULL, NULL, NULL, 352, NULL, 1),
(128, 'Macau S.A.R.', NULL, 'MO', NULL, NULL, NULL, 853, NULL, 1),
(129, 'Macedonia', NULL, 'MK', NULL, NULL, NULL, 389, NULL, 1),
(130, 'Madagascar', NULL, 'MG', NULL, NULL, NULL, 261, NULL, 1),
(131, 'Malawi', NULL, 'MW', NULL, NULL, NULL, 265, NULL, 1),
(132, 'Malaysia', NULL, 'MY', NULL, NULL, NULL, 60, NULL, 1),
(133, 'Maldives', NULL, 'MV', NULL, NULL, NULL, 960, NULL, 1),
(134, 'Mali', NULL, 'ML', NULL, NULL, NULL, 223, NULL, 1),
(135, 'Malta', NULL, 'MT', NULL, NULL, NULL, 356, NULL, 1),
(136, 'Man (Isle of)', NULL, 'XM', NULL, NULL, NULL, 44, NULL, 1),
(137, 'Marshall Islands', NULL, 'MH', NULL, NULL, NULL, 692, NULL, 1),
(138, 'Martinique', NULL, 'MQ', NULL, NULL, NULL, 596, NULL, 1),
(139, 'Mauritania', NULL, 'MR', NULL, NULL, NULL, 222, NULL, 1),
(140, 'Mauritius', NULL, 'MU', NULL, NULL, NULL, 230, NULL, 1),
(141, 'Mayotte', NULL, 'YT', NULL, NULL, NULL, 269, NULL, 1),
(142, 'Mexico', NULL, 'MX', NULL, NULL, NULL, 52, NULL, 1),
(143, 'Micronesia', NULL, 'FM', NULL, NULL, NULL, 691, NULL, 1),
(144, 'Moldova', NULL, 'MD', NULL, NULL, NULL, 373, NULL, 1),
(145, 'Monaco', NULL, 'MC', NULL, NULL, NULL, 377, NULL, 1),
(146, 'Mongolia', NULL, 'MN', NULL, NULL, NULL, 976, NULL, 1),
(147, 'Montserrat', NULL, 'MS', NULL, NULL, NULL, 1664, NULL, 1),
(148, 'Morocco', NULL, 'MA', NULL, NULL, NULL, 212, NULL, 1),
(149, 'Mozambique', NULL, 'MZ', NULL, NULL, NULL, 258, NULL, 1),
(150, 'Myanmar', NULL, 'MM', NULL, NULL, NULL, 95, NULL, 1),
(151, 'Namibia', NULL, 'NA', NULL, NULL, NULL, 264, NULL, 1),
(152, 'Nauru', NULL, 'NR', NULL, NULL, NULL, 674, NULL, 1),
(153, 'Nepal', NULL, 'NP', NULL, NULL, NULL, 977, NULL, 1),
(154, 'Netherlands Antilles', NULL, 'AN', NULL, NULL, NULL, 599, NULL, 1),
(155, 'Netherlands The', NULL, 'NL', NULL, NULL, NULL, 31, NULL, 1),
(156, 'New Caledonia', NULL, 'NC', NULL, NULL, NULL, 687, NULL, 1),
(157, 'New Zealand', NULL, 'NZ', NULL, NULL, NULL, 64, NULL, 1),
(158, 'Nicaragua', NULL, 'NI', NULL, NULL, NULL, 505, NULL, 1),
(159, 'Niger', NULL, 'NE', NULL, NULL, NULL, 227, NULL, 1),
(160, 'Nigeria', NULL, 'NG', NULL, NULL, NULL, 234, NULL, 1),
(161, 'Niue', NULL, 'NU', NULL, NULL, NULL, 683, NULL, 1),
(162, 'Norfolk Island', NULL, 'NF', NULL, NULL, NULL, 672, NULL, 1),
(163, 'Northern Mariana Islands', NULL, 'MP', NULL, NULL, NULL, 1670, NULL, 1),
(164, 'Norway', NULL, 'NO', NULL, NULL, NULL, 47, NULL, 1),
(165, 'Oman', NULL, 'OM', NULL, NULL, NULL, 968, NULL, 1),
(166, 'Pakistan', NULL, 'PK', NULL, NULL, NULL, 92, NULL, 1),
(167, 'Palau', NULL, 'PW', NULL, NULL, NULL, 680, NULL, 1),
(168, 'Palestinian Territory Occupied', NULL, 'PS', NULL, NULL, NULL, 970, NULL, 1),
(169, 'Panama', NULL, 'PA', NULL, NULL, NULL, 507, NULL, 1),
(170, 'Papua new Guinea', NULL, 'PG', NULL, NULL, NULL, 675, NULL, 1),
(171, 'Paraguay', NULL, 'PY', NULL, NULL, NULL, 595, NULL, 1),
(172, 'Peru', NULL, 'PE', NULL, NULL, NULL, 51, NULL, 1),
(173, 'Philippines', NULL, 'PH', NULL, NULL, NULL, 63, NULL, 1),
(174, 'Pitcairn Island', NULL, 'PN', NULL, NULL, NULL, 0, NULL, 1),
(175, 'Poland', NULL, 'PL', NULL, NULL, NULL, 48, NULL, 1),
(176, 'Portugal', NULL, 'PT', NULL, NULL, NULL, 351, NULL, 1),
(177, 'Puerto Rico', NULL, 'PR', NULL, NULL, NULL, 1787, NULL, 1),
(178, 'Qatar', NULL, 'QA', NULL, NULL, NULL, 974, NULL, 1),
(179, 'Reunion', NULL, 'RE', NULL, NULL, NULL, 262, NULL, 1),
(180, 'Romania', NULL, 'RO', NULL, NULL, NULL, 40, NULL, 1),
(181, 'Russia', NULL, 'RU', NULL, NULL, NULL, 70, NULL, 1),
(182, 'Rwanda', NULL, 'RW', NULL, NULL, NULL, 250, NULL, 1),
(183, 'Saint Helena', NULL, 'SH', NULL, NULL, NULL, 290, NULL, 1),
(184, 'Saint Kitts And Nevis', NULL, 'KN', NULL, NULL, NULL, 1869, NULL, 1),
(185, 'Saint Lucia', NULL, 'LC', NULL, NULL, NULL, 1758, NULL, 1),
(186, 'Saint Pierre and Miquelon', NULL, 'PM', NULL, NULL, NULL, 508, NULL, 1),
(187, 'Saint Vincent And The Grenadines', NULL, 'VC', NULL, NULL, NULL, 1784, NULL, 1),
(188, 'Samoa', NULL, 'WS', NULL, NULL, NULL, 684, NULL, 1),
(189, 'San Marino', NULL, 'SM', NULL, NULL, NULL, 378, NULL, 1),
(190, 'Sao Tome and Principe', NULL, 'ST', NULL, NULL, NULL, 239, NULL, 1),
(191, 'Saudi Arabia', NULL, 'SA', NULL, NULL, NULL, 966, NULL, 1),
(192, 'Senegal', 'سنغال', 'SN', NULL, NULL, NULL, 221, NULL, 1),
(193, 'Serbia', NULL, 'RS', NULL, NULL, NULL, 381, NULL, 1),
(194, 'Seychelles', NULL, 'SC', NULL, NULL, NULL, 248, NULL, 1),
(195, 'Sierra Leone', NULL, 'SL', NULL, NULL, NULL, 232, NULL, 1),
(196, 'Singapore', NULL, 'SG', NULL, NULL, NULL, 65, NULL, 1),
(197, 'Slovakia', NULL, 'SK', NULL, NULL, NULL, 421, NULL, 1),
(198, 'Slovenia', NULL, 'SI', NULL, NULL, NULL, 386, NULL, 1),
(199, 'Smaller Territories of the UK', NULL, 'XG', NULL, NULL, NULL, 44, NULL, 1),
(200, 'Solomon Islands', NULL, 'SB', NULL, NULL, NULL, 677, NULL, 1),
(201, 'Somalia', NULL, 'SO', NULL, NULL, NULL, 252, NULL, 1),
(202, 'South Africa', NULL, 'ZA', NULL, NULL, NULL, 27, NULL, 1),
(203, 'South Georgia', NULL, 'GS', NULL, NULL, NULL, 0, NULL, 1),
(204, 'South Sudan', NULL, 'SS', NULL, NULL, NULL, 211, NULL, 1),
(205, 'Spain', NULL, 'ES', NULL, NULL, NULL, 34, NULL, 1),
(206, 'Sri Lanka', NULL, 'LK', NULL, NULL, NULL, 94, NULL, 1),
(207, 'Sudan', NULL, 'SD', NULL, NULL, NULL, 249, NULL, 1),
(208, 'Suriname', NULL, 'SR', NULL, NULL, NULL, 597, NULL, 1),
(209, 'Svalbard And Jan Mayen Islands', NULL, 'SJ', NULL, NULL, NULL, 47, NULL, 1),
(210, 'Swaziland', NULL, 'SZ', NULL, NULL, NULL, 268, NULL, 1),
(211, 'Sweden', NULL, 'SE', NULL, NULL, NULL, 46, NULL, 1),
(212, 'Switzerland', NULL, 'CH', NULL, NULL, NULL, 41, NULL, 1),
(213, 'Syria', NULL, 'SY', NULL, NULL, NULL, 963, NULL, 1),
(214, 'Taiwan', NULL, 'TW', NULL, NULL, NULL, 886, NULL, 1),
(215, 'Tajikistan', NULL, 'TJ', NULL, NULL, NULL, 992, NULL, 1),
(216, 'Tanzania', NULL, 'TZ', NULL, NULL, NULL, 255, NULL, 1),
(217, 'Thailand', NULL, 'TH', NULL, NULL, NULL, 66, NULL, 1),
(218, 'Togo', NULL, 'TG', NULL, NULL, NULL, 228, NULL, 1),
(219, 'Tokelau', NULL, 'TK', NULL, NULL, NULL, 690, NULL, 1),
(220, 'Tonga', NULL, 'TO', NULL, NULL, NULL, 676, NULL, 1),
(221, 'Trinidad And Tobago', NULL, 'TT', NULL, NULL, NULL, 1868, NULL, 1),
(222, 'Tunisia', NULL, 'TN', NULL, NULL, NULL, 216, NULL, 1),
(223, 'Turkey', NULL, 'TR', NULL, NULL, NULL, 90, NULL, 1),
(224, 'Turkmenistan', NULL, 'TM', NULL, NULL, NULL, 7370, NULL, 1),
(225, 'Turks And Caicos Islands', NULL, 'TC', NULL, NULL, NULL, 1649, NULL, 1),
(226, 'Tuvalu', NULL, 'TV', NULL, NULL, NULL, 688, NULL, 1),
(227, 'Uganda', NULL, 'UG', NULL, NULL, NULL, 256, NULL, 1),
(228, 'Ukraine', NULL, 'UA', NULL, NULL, NULL, 380, NULL, 1),
(229, 'United Arab Emirates', NULL, 'AE', NULL, NULL, NULL, 971, NULL, 1),
(230, 'United Kingdom', NULL, 'GB', NULL, NULL, NULL, 44, NULL, 1),
(231, 'United States', NULL, 'US', NULL, NULL, NULL, 1, NULL, 1),
(232, 'United States Minor Outlying Islands', NULL, 'UM', NULL, NULL, NULL, 1, NULL, 1),
(233, 'Uruguay', NULL, 'UY', NULL, NULL, NULL, 598, NULL, 1),
(234, 'Uzbekistan', NULL, 'UZ', NULL, NULL, NULL, 998, NULL, 1),
(235, 'Vanuatu', NULL, 'VU', NULL, NULL, NULL, 678, NULL, 1),
(236, 'Vatican City State (Holy See)', NULL, 'VA', NULL, NULL, NULL, 39, NULL, 1),
(237, 'Venezuela', NULL, 'VE', NULL, NULL, NULL, 58, NULL, 1),
(238, 'Vietnam', NULL, 'VN', NULL, NULL, NULL, 84, NULL, 1),
(239, 'Virgin Islands (British)', NULL, 'VG', NULL, NULL, NULL, 1284, NULL, 1),
(240, 'Virgin Islands (US)', NULL, 'VI', NULL, NULL, NULL, 1340, NULL, 1),
(241, 'Wallis And Futuna Islands', NULL, 'WF', NULL, NULL, NULL, 681, NULL, 1),
(242, 'Western Sahara', NULL, 'EH', NULL, NULL, NULL, 212, NULL, 1),
(243, 'Yemen', NULL, 'YE', NULL, NULL, NULL, 967, NULL, 1),
(244, 'Yugoslavia', NULL, 'YU', NULL, NULL, NULL, 38, NULL, 1),
(245, 'Zambia', NULL, 'ZM', NULL, NULL, NULL, 260, NULL, 1),
(246, 'Zimbabwe', NULL, 'ZW', NULL, NULL, NULL, 263, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
