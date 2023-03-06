-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 05, 2022 at 03:41 PM
-- Server version: 10.3.34-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zynqojsi_db21`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `block` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `avenue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `house_apartment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_address` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `full_name`, `country`, `area`, `city`, `block`, `street`, `avenue`, `house_apartment`, `floor`, `lat`, `lng`, `country_id`, `city_id`, `area_id`, `address`, `phone`, `mobile`, `default_address`, `created_at`, `updated_at`) VALUES
(34, 2, 'address1', 'kuwait', 'fsdfHawalli', 'Hawalli Governorate', '1', 'test', 'test', 'test', 'test', 'test', 'test', 2, 3, 5, 'test', '09307199929', '09307199929', 0, '2022-02-23 06:05:43', '2022-02-23 06:05:43'),
(35, 44, 'Umar K', 'kuwait', 'Hawalli', 'Hawalli Governorate', '1', 'Bin khaldoon', 'avenue 1', '222', '4', '00', '00', 2, 3, 5, 'Office', '98819591', '98819591', 0, '2022-02-24 16:28:14', '2022-02-24 16:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`value`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `value`, `created_at`, `updated_at`) VALUES
(2, '{\"en\":\"size\",\"fa\":\"\\u0633\\u0627\\u06cc\\u0632\"}', '2021-09-15 10:39:45', '2021-09-15 10:39:45'),
(3, '{\"en\":\"color\",\"fa\":\"\\u0631\\u0646\\u06af\"}', '2021-09-15 10:40:07', '2021-09-15 10:40:07'),
(4, '{\"en\":\"weight\",\"fa\":\"\\u0648\\u0632\\u0646\"}', '2021-09-15 10:40:32', '2021-09-15 10:40:32');

-- --------------------------------------------------------

--
-- Table structure for table `attr_groups`
--

CREATE TABLE `attr_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`value`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attr_groups`
--

INSERT INTO `attr_groups` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(2, 'یشسی', '[{\"en\":\"size\",\"fa\":\"\\u0633\\u0627\\u06cc\\u0632\"},{\"en\":\"color\",\"fa\":\"\\u0631\\u0646\\u06af\"}]', '2021-09-15 10:57:29', '2021-09-15 10:57:29'),
(3, 'sefsef', '[{\"en\":\"size\",\"fa\":\"\\u0633\\u0627\\u06cc\\u0632\"},{\"en\":\"color\",\"fa\":\"\\u0631\\u0646\\u06af\"}]', '2021-09-16 04:48:48', '2021-09-16 04:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `blocked_user_freelancer`
--

CREATE TABLE `blocked_user_freelancer` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `popular` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_translations`
--

CREATE TABLE `blog_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_desc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `image`, `slug`, `parent_id`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(8, 'categories-image-f29c8fa6e572a8ee649ffc9b8205bc89.png', 'Makeup', NULL, 6, 1, '2021-09-25 07:34:56', '2021-11-13 07:52:06'),
(12, 'categories-image-1c307a61bf9e394d0835a05e95f330a7.png', 'Photo-/-Video', NULL, 5, 1, '2021-09-25 07:45:45', '2021-11-13 07:51:56'),
(13, '/uploads/categories//uploads/categories/categories-image-97e33e4c14a39646cb5611a8980d128b.png', 'Bloggers', NULL, 1, 1, '2021-09-25 07:46:12', '2022-02-01 11:10:38'),
(14, 'categories-image-bb500978cd2ade1dd57a569dd18c52bc.png', 'Event-Planners', 13, 2, 1, '2021-09-25 07:46:46', '2021-11-13 07:51:34'),
(15, 'categories-image-9c3f9fe307bc73263754bab8a7da5fbe.png', 'Personal-Trainers', 12, 3, 1, '2021-09-25 07:47:11', '2021-11-13 07:51:42'),
(16, 'categories-image-23809218e2f5f21110013ade6b1c57a3.png', 'Designer', 12, 4, 1, '2021-09-25 07:47:31', '2021-11-13 07:51:49');

-- --------------------------------------------------------

--
-- Table structure for table `category_blogs`
--

CREATE TABLE `category_blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `picture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_blog_translations`
--

CREATE TABLE `category_blog_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_blog_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_freelancer`
--

CREATE TABLE `category_freelancer` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_freelancer`
--

INSERT INTO `category_freelancer` (`category_id`, `freelancer_id`) VALUES
(14, 25),
(15, 25),
(12, 25),
(13, 25),
(12, 32),
(13, 32),
(14, 32),
(15, 32);

-- --------------------------------------------------------

--
-- Table structure for table `category_translations`
--

CREATE TABLE `category_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_translations`
--

INSERT INTO `category_translations` (`id`, `category_id`, `locale`, `title`, `meta_desc`) VALUES
(15, 8, 'en', 'Makeup', NULL),
(16, 8, 'ar', 'ميك اب', NULL),
(17, 12, 'en', 'Photo / Video', NULL),
(18, 12, 'ar', 'فوتوغرافي', NULL),
(19, 13, 'en', 'Bloggers', NULL),
(20, 13, 'ar', 'بلوغرز', NULL),
(21, 14, 'en', 'Event Planners', NULL),
(22, 14, 'ar', 'منسق حفلات', NULL),
(23, 15, 'en', 'Personal Trainers', NULL),
(24, 15, 'ar', 'مدرب شخصي', NULL),
(25, 16, 'en', 'Designer', NULL),
(26, 16, 'ar', 'مصمم', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `change_password_otps`
--

CREATE TABLE `change_password_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email_mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `change_password_otps`
--

INSERT INTO `change_password_otps` (`id`, `email_mobile`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, '09307199929', '97315', 0, '2022-01-24 08:40:18', '2022-01-24 08:40:18'),
(2, '09307199929', '29189', 0, '2022-01-24 08:42:28', '2022-01-24 08:42:28'),
(3, '09307199929', '91137', 0, '2022-01-24 08:42:46', '2022-01-24 08:42:46'),
(4, '09307199929', '55066', 0, '2022-01-24 08:42:54', '2022-01-24 08:42:54'),
(5, '09307199929', '79425', 0, '2022-01-24 08:43:40', '2022-01-24 08:43:40'),
(6, '09307199929', '28677', 0, '2022-01-24 08:44:15', '2022-01-24 08:44:15'),
(7, '09307199929', '67865', 0, '2022-01-24 08:44:30', '2022-01-24 08:44:30'),
(8, '09307199929', '96143', 0, '2022-01-24 08:45:11', '2022-01-24 08:45:11'),
(9, '09307199929', '16985', 0, '2022-01-24 08:46:32', '2022-01-24 08:46:32'),
(10, '09307199929', '98743', 0, '2022-01-24 08:47:08', '2022-01-24 08:47:08'),
(11, '09307199929', '91716', 0, '2022-01-24 08:47:16', '2022-01-24 08:47:16'),
(12, '09307199929', '52742', 0, '2022-01-24 08:47:22', '2022-01-24 08:47:22'),
(13, '09307199929', '3471', 0, '2022-01-24 08:47:45', '2022-01-24 08:47:45'),
(14, '09307199929', '74578', 0, '2022-01-24 09:06:10', '2022-01-24 09:06:10'),
(15, '09307199929', '10369', 0, '2022-01-24 09:06:49', '2022-01-24 09:06:49'),
(16, '09307199929', '45775', 0, '2022-01-24 09:07:47', '2022-01-24 09:07:47'),
(17, '09307199929', '77043', 0, '2022-01-24 09:09:44', '2022-01-24 09:09:44'),
(18, '09307199929', '87642', 0, '2022-01-24 09:10:28', '2022-01-24 09:10:28'),
(19, '09307199929', '42553', 0, '2022-01-24 09:10:43', '2022-01-24 09:10:43'),
(20, '09307199929', '8854', 0, '2022-01-24 09:10:57', '2022-01-24 09:10:57'),
(21, '09307199929', '19751', 0, '2022-01-24 09:11:34', '2022-01-24 09:11:34'),
(22, '09307199929', '50491', 0, '2022-01-24 09:11:39', '2022-01-24 09:11:39'),
(23, '09307199929', '44614', 0, '2022-01-24 09:19:35', '2022-01-24 09:19:35'),
(24, '09307199929', '51467', 0, '2022-01-24 09:20:40', '2022-01-24 09:20:40'),
(25, '09307199929', '3495', 0, '2022-01-24 09:20:57', '2022-01-24 09:20:57'),
(26, '09307199929', '83818', 0, '2022-01-24 09:21:47', '2022-01-24 09:21:47'),
(27, '09307199929', '90396', 0, '2022-01-24 09:22:20', '2022-01-24 09:22:20'),
(28, '09307199929', '23213', 0, '2022-01-24 09:23:14', '2022-01-24 09:23:14'),
(29, '09307199929', '43742', 0, '2022-01-24 09:23:37', '2022-01-24 09:23:37'),
(30, '09307199929', '6162', 0, '2022-01-24 09:24:25', '2022-01-24 09:24:25'),
(31, '09307199929', '77677', 0, '2022-01-24 09:24:53', '2022-01-24 09:24:53'),
(32, '09307199929', '61731', 0, '2022-01-24 09:24:59', '2022-01-24 09:24:59'),
(33, '09307199929', '7085', 0, '2022-01-24 09:25:05', '2022-01-24 09:25:05'),
(34, '09307199929', '13765', 0, '2022-01-24 09:25:15', '2022-01-24 09:25:15'),
(35, '09307199929', '26297', 0, '2022-01-24 09:26:31', '2022-01-24 09:26:31'),
(36, '09307199929', '48366', 0, '2022-01-24 09:26:39', '2022-01-24 09:26:39'),
(37, '09307199929', '75169', 0, '2022-01-24 09:27:22', '2022-01-24 09:27:22'),
(38, '09307199929', '65405', 0, '2022-01-24 09:28:16', '2022-01-24 09:28:16'),
(39, '09307199929', '86521', 0, '2022-01-24 09:36:48', '2022-01-24 09:36:48'),
(40, '09307199929', '93604', 0, '2022-01-24 09:38:45', '2022-01-24 09:38:45'),
(41, '09307199929', '72781', 0, '2022-01-24 09:39:29', '2022-01-24 09:39:29'),
(42, '09307199929', '17820', 0, '2022-01-24 09:39:40', '2022-01-24 09:39:40'),
(43, '09307199929', '72850', 0, '2022-01-24 09:40:34', '2022-01-24 09:40:34'),
(44, '09307199929', '5042', 0, '2022-01-24 09:41:05', '2022-01-24 09:41:05'),
(45, '09307199929', '63830', 0, '2022-01-24 09:41:21', '2022-01-24 09:41:21'),
(46, '09307199929', '21160', 0, '2022-01-24 09:42:13', '2022-01-24 09:42:13'),
(47, '09307199929', '33438', 0, '2022-01-24 09:42:22', '2022-01-24 09:42:22'),
(48, '09307199929', '65601', 0, '2022-01-24 09:42:35', '2022-01-24 09:42:35'),
(49, '09307199929', '94608', 0, '2022-01-24 09:43:09', '2022-01-24 09:43:09'),
(50, '09307199929', '67784', 0, '2022-01-24 09:43:24', '2022-01-24 09:43:24'),
(51, '09307199929', '55460', 0, '2022-01-24 09:43:34', '2022-01-24 09:43:34'),
(52, '09307199929', '83514', 0, '2022-01-24 09:43:51', '2022-01-24 09:43:51'),
(53, '09307199929', '93601', 0, '2022-01-24 09:44:11', '2022-01-24 09:44:11'),
(54, '09307199929', '77277', 0, '2022-01-24 09:44:18', '2022-01-24 09:44:18'),
(55, '09307199929', '76271', 0, '2022-01-24 09:44:42', '2022-01-24 09:44:42'),
(56, '09307199929', '39866', 0, '2022-01-24 09:44:58', '2022-01-24 09:44:58'),
(57, '09307199929', '23333', 0, '2022-01-24 09:46:02', '2022-01-24 09:46:02'),
(58, '09307199929', '75268', 0, '2022-01-24 09:46:31', '2022-01-24 09:46:31'),
(59, '09307199929', '12554', 0, '2022-01-24 09:49:12', '2022-01-24 09:49:12'),
(60, '09307199929', '55569', 0, '2022-01-24 09:49:30', '2022-01-24 09:49:30'),
(61, '09307199929', '51078', 0, '2022-01-24 09:49:57', '2022-01-24 09:49:57'),
(62, '09307199929', '60902', 0, '2022-01-24 09:50:24', '2022-01-24 09:50:24'),
(63, '09307199929', '24088', 0, '2022-01-24 09:50:51', '2022-01-24 09:50:51'),
(64, '09307199929', '69865', 0, '2022-01-24 09:51:05', '2022-01-24 09:51:05'),
(65, '09307199929', '97307', 0, '2022-01-24 09:51:13', '2022-01-24 09:51:13'),
(66, '09307199929', '60778', 0, '2022-01-24 09:51:25', '2022-01-24 09:51:25'),
(67, '09307199929', '98146', 0, '2022-01-24 09:51:34', '2022-01-24 09:51:34'),
(68, '09307199929', '21688', 0, '2022-01-24 09:51:55', '2022-01-24 09:51:55'),
(69, '09307199929', '11034', 0, '2022-01-24 09:52:04', '2022-01-24 09:52:04'),
(70, '09307199929', '81735', 0, '2022-01-24 09:52:23', '2022-01-24 09:52:23'),
(71, '09307199929', '26044', 0, '2022-01-24 09:52:45', '2022-01-24 09:52:45'),
(72, '09307199929', '32132', 0, '2022-01-24 09:52:55', '2022-01-24 09:52:55'),
(73, '09307199929', '54983', 0, '2022-01-24 09:53:09', '2022-01-24 09:53:09'),
(74, '09307199929', '89900', 0, '2022-01-24 09:53:19', '2022-01-24 09:53:19'),
(75, '09307199929', '41630', 0, '2022-01-24 09:54:02', '2022-01-24 09:54:02'),
(76, '09307199929', '92645', 0, '2022-01-24 09:54:23', '2022-01-24 09:54:23'),
(77, '09307199929', '34240', 0, '2022-01-24 09:54:32', '2022-01-24 09:54:32'),
(78, '09307199929', '64765', 0, '2022-01-24 09:55:07', '2022-01-24 09:55:07'),
(79, '09307199929', '5169', 0, '2022-01-24 09:55:20', '2022-01-24 09:55:20'),
(80, '09307199929', '37110', 0, '2022-01-24 09:55:36', '2022-01-24 09:55:36'),
(81, '09307199929', '50705', 0, '2022-01-24 09:55:46', '2022-01-24 09:55:46'),
(82, '09307199929', '79031', 0, '2022-01-24 09:56:02', '2022-01-24 09:56:02'),
(83, '09307199929', '16197', 0, '2022-01-24 09:56:15', '2022-01-24 09:56:15'),
(84, '09307199929', '65063', 0, '2022-01-24 09:57:02', '2022-01-24 09:57:02'),
(85, '09307199929', '1388', 0, '2022-01-24 09:57:23', '2022-01-24 09:57:23'),
(86, '09307199929', '48214', 0, '2022-01-24 09:57:43', '2022-01-24 09:57:43'),
(87, '09307199929', '11866', 0, '2022-01-24 09:58:01', '2022-01-24 09:58:01'),
(88, '09307199929', '30151', 0, '2022-01-24 09:58:08', '2022-01-24 09:58:08'),
(89, '09307199929', '29908', 0, '2022-01-24 09:58:17', '2022-01-24 09:58:17'),
(90, '09307199929', '22802', 0, '2022-01-24 10:00:16', '2022-01-24 10:00:16'),
(91, '09307199929', '23510', 0, '2022-01-24 10:00:29', '2022-01-24 10:00:29'),
(92, '09307199929', '42893', 0, '2022-01-24 10:01:01', '2022-01-24 10:01:01'),
(93, '09307199929', '16383', 0, '2022-01-24 10:01:06', '2022-01-24 10:01:06'),
(94, '09307199929', '71519', 0, '2022-01-24 10:14:41', '2022-01-24 10:14:41'),
(95, '09307199929', '57921', 0, '2022-01-24 10:19:57', '2022-01-24 10:19:57'),
(96, '09307199929', '43816', 0, '2022-01-24 10:20:33', '2022-01-24 10:20:33'),
(97, '09307199929', '30689', 0, '2022-01-24 12:04:33', '2022-01-24 12:04:33'),
(98, '09307199929', '20898', 0, '2022-01-24 12:06:48', '2022-01-24 12:06:48'),
(99, '09307199929', '88173', 0, '2022-01-24 12:44:19', '2022-01-24 12:44:19'),
(100, '09307199929', '95547', 0, '2022-01-24 12:45:02', '2022-01-24 12:45:02'),
(101, '96567772237', '4166', 0, '2022-01-24 12:46:26', '2022-01-24 12:46:26'),
(102, '96567772237', '88614', 0, '2022-01-24 12:46:36', '2022-01-24 12:46:36'),
(103, '96567772237', '3223', 0, '2022-01-24 12:47:08', '2022-01-24 12:47:08'),
(104, '96567772237', '31981', 0, '2022-01-24 12:48:20', '2022-01-24 12:48:20'),
(105, '96567772237', '17999', 0, '2022-01-24 12:49:20', '2022-01-24 12:49:20'),
(106, '96567772237', '4728', 0, '2022-01-24 12:50:00', '2022-01-24 12:50:00'),
(107, '96567772237', '8351', 0, '2022-01-24 12:50:14', '2022-01-24 12:50:14'),
(108, '96567772237', '32435', 0, '2022-01-24 13:10:17', '2022-01-24 13:10:17'),
(109, '96567772237', '36005', 0, '2022-01-29 11:37:25', '2022-01-29 11:37:25'),
(110, '96567772237', '31138', 0, '2022-01-29 11:39:59', '2022-01-29 11:39:59'),
(111, '96567772237', '31387', 0, '2022-01-29 13:06:38', '2022-01-29 13:06:38'),
(112, '96567772237', '55577', 0, '2022-01-29 13:28:11', '2022-01-29 13:28:11'),
(113, '96567772237', '12077', 0, '2022-01-30 06:06:12', '2022-01-30 06:06:12'),
(114, '96567772237', '42446', 0, '2022-01-30 06:07:52', '2022-01-30 06:07:52'),
(115, '96567772237', '77207', 0, '2022-01-31 13:06:28', '2022-01-31 13:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question_en`, `question_ar`, `answer_en`, `answer_ar`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'English question1', 'Arabic question1', 'English answer1', 'Arabic answer1', '1', NULL, NULL),
(2, 'English question2', 'Arabic question2', 'English answer2', 'Arabic answer2', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `filters`
--

CREATE TABLE `filters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`value`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `freelancers`
--

CREATE TABLE `freelancers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Male',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate_id` bigint(20) UNSIGNED DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `offline` tinyint(1) NOT NULL DEFAULT 1,
  `quotation` tinyint(4) NOT NULL DEFAULT 0,
  `set_a_meeting` tinyint(4) NOT NULL DEFAULT 0,
  `location_type` enum('my','any','both') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_commission_price` int(11) NOT NULL DEFAULT 0,
  `service_commission_percent` int(11) NOT NULL DEFAULT 0,
  `service_commission_type` enum('price','percent','plus','min','max') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'min',
  `workshop_commission_price` int(11) NOT NULL DEFAULT 0,
  `workshop_commission_percent` int(11) NOT NULL DEFAULT 0,
  `workshop_commission_type` enum('price','percent','plus','min','max') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'min',
  `bill_commission_price` int(11) NOT NULL DEFAULT 0,
  `bill_commission_percent` int(11) NOT NULL DEFAULT 0,
  `bill_commission_type` enum('price','percent','plus','min','max') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'min',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `freelancers`
--

INSERT INTO `freelancers` (`id`, `package_id`, `expiration_date`, `name`, `image`, `birthday`, `gender`, `phone`, `username`, `email`, `link`, `bio`, `rate_id`, `password`, `is_active`, `offline`, `quotation`, `set_a_meeting`, `location_type`, `service_commission_price`, `service_commission_percent`, `service_commission_type`, `workshop_commission_price`, `workshop_commission_percent`, `workshop_commission_type`, `bill_commission_price`, `bill_commission_percent`, `bill_commission_type`, `created_at`, `updated_at`) VALUES
(20, NULL, NULL, 'شسیسش', '/uploads/freelancers/freelancers-image-921aa4a3daf61f665df273ada2fe9bdb.jpg', NULL, 'Male', '66666666', NULL, 'Sdasdoheil@gmail.com', 'یشسی', 'شسیش', 8, NULL, 1, 1, 1, 1, NULL, 0, 0, 'min', 0, 0, 'min', 0, 0, 'min', '2021-10-18 06:12:34', '2022-02-01 11:12:41'),
(22, NULL, NULL, 'fasf', '/uploads/freelancers/freelancers-image-4ae78c649fe91f784db25e6258bb4aad.jpg', NULL, 'Male', '09307199929', NULL, 'fsdfsda@sdfsd.fgghdg', 'hfgh', 'asfaf', 13, NULL, 1, 1, 1, 1, NULL, 0, 0, 'min', 0, 0, 'min', 0, 0, 'min', '2021-11-10 07:51:22', '2021-11-10 07:51:22'),
(23, NULL, NULL, 'یسشی', 'freelancers-image-62d96f69c84cf2a88f7e1847dc2def15.jpg', NULL, 'Male', '66666666', NULL, 'یسشی@بشسیب.یبلیل', 'fdgdfg', 'سبسی', 9, NULL, 1, 1, 1, 0, NULL, 0, 0, 'min', 0, 0, 'min', 0, 0, 'min', '2021-11-09 09:38:51', '2021-12-20 07:41:47'),
(25, 1, '2022-01-24', 'test api update', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(32, NULL, NULL, 'Mohammad Umar', NULL, NULL, 'Male', '98819591', NULL, 'mohd.umar@gulfclick.net', NULL, NULL, 16, '$2y$10$2lzoPdM0x6yG.2c/bna3IOUJJwAhsPkooZ4/9/KVcHXkPe2SWZ0tG', 0, 1, 0, 0, NULL, 0, 0, 'min', 0, 0, 'min', 0, 0, 'min', '2022-02-15 07:00:13', '2022-02-15 07:00:13'),
(34, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil1@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(35, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil2@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(36, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil3@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(37, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil4@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(38, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil5@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(39, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil6@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(40, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil7@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(41, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil8@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(42, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil9@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(43, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil10@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(44, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil11@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(45, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil12@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(46, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil13@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(47, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil14@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52'),
(48, 1, '2022-01-24', 'fake api', '/uploads/freelancers/freelancers-image-99a3da9fb9672729c10109ed701a7737.jpg', '2022-10-25', 'female', '939393939', NULL, 'soheil15@gmail.com', 'http://google.com', 'bio text', 11, '$2y$10$d1ha3KatDxOBuHUAhycBQOkREybhUEV5cjn6zzSJ.2cTkkz0fBIGq', 1, 0, 1, 1, 'any', 10, 0, 'price', 0, 0, 'price', 0, 0, 'price', '2021-11-10 07:48:06', '2022-02-14 07:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_addresses`
--

CREATE TABLE `freelancer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `block` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avenue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `house_apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `floor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disposable` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `freelancer_addresses`
--

INSERT INTO `freelancer_addresses` (`id`, `freelancer_id`, `full_name`, `country`, `area`, `city`, `block`, `street`, `avenue`, `house_apartment`, `floor`, `lat`, `lng`, `country_id`, `city_id`, `area_id`, `address`, `phone`, `mobile`, `disposable`, `created_at`, `updated_at`) VALUES
(11, 23, 'address1', 'kuwait', 'fsdf', 'hawalli', '1', 'test', 'test', 'test', 'test', 'test', 'test', 2, 3, 5, 'test', '09307199929', '09307199929', 0, '2022-01-19 09:58:22', '2022-01-19 09:58:22'),
(12, 25, 'test api update', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'address', 'phone', 'mobile', 0, '2022-01-29 06:34:21', '2022-01-31 06:12:19'),
(16, 25, 'test api', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'address', 'phone', 'mobile', 0, '2022-01-31 06:12:15', '2022-01-31 06:12:15'),
(17, 25, 'test api', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'address', 'phone', 'mobile', 0, '2022-01-31 13:02:34', '2022-01-31 13:02:34'),
(18, 20, 'Home', 'kuwait', 'fsdf', 'hawalli', '1', '2', '2', '2', '2', '29.331305180453327', '48.02742004394532', 2, 3, 5, '', NULL, '', 0, '2022-02-01 11:13:41', '2022-02-01 11:13:41'),
(20, 25, 'test api', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'address', 'phone', 'mobile', 0, '2022-02-08 06:58:26', '2022-02-08 06:58:26'),
(21, 25, 'test api', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'address', 'phone', 'mobile', 0, '2022-02-08 06:59:16', '2022-02-08 06:59:16'),
(22, 25, 'test api', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'address', 'phone', 'mobile', 0, '2022-02-08 07:05:26', '2022-02-08 07:05:26'),
(23, 25, 'test api', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'address', 'phone', 'mobile', 0, '2022-02-14 07:57:27', '2022-02-14 07:57:27'),
(24, 25, 'test api', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'address', 'phone', 'mobile', 0, '2022-02-14 08:08:25', '2022-02-14 08:08:25'),
(25, 25, 'test api', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'address', 'phone', 'mobile', 0, '2022-02-14 08:10:51', '2022-02-14 08:10:51'),
(26, 25, 'test api', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'address', 'phone', 'mobile', 0, '2022-02-14 08:33:24', '2022-02-14 08:33:24'),
(27, 32, 'test api', 'kuwait', 'fsdf', 'hawalli', '1', 'street', 'avenue', 'house', '10', '10.0', '10.0', 2, 3, 5, 'Hawally address', '98819591', '98819591', 0, '2022-02-19 07:51:25', '2022-02-19 07:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_areas`
--

CREATE TABLE `freelancer_areas` (
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `freelancer_areas`
--

INSERT INTO `freelancer_areas` (`freelancer_id`, `area_id`) VALUES
(25, 5),
(25, 7);

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_highlights`
--

CREATE TABLE `freelancer_highlights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `freelancer_highlights`
--

INSERT INTO `freelancer_highlights` (`id`, `freelancer_id`, `title`, `created_at`, `updated_at`) VALUES
(2, 25, 'test api update', '2022-02-08 09:27:10', '2022-02-08 09:29:28');

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_highlight_images`
--

CREATE TABLE `freelancer_highlight_images` (
  `highlight_id` bigint(20) UNSIGNED NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `freelancer_highlight_images`
--

INSERT INTO `freelancer_highlight_images` (`highlight_id`, `image`) VALUES
(2, 'highlights-file.0-283b9a9ffcc8f5ed4574faf550565723.png'),
(2, 'highlights-file.1-283b9a9ffcc8f5ed4574faf550565723.png'),
(2, 'highlights-file.2-283b9a9ffcc8f5ed4574faf550565723.png');

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_notifications`
--

CREATE TABLE `freelancer_notifications` (
  `id` int(11) NOT NULL,
  `freelancer_id` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_quotations`
--

CREATE TABLE `freelancer_quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_quotation_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `payment_type` enum('Full Payment','Half') COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pay_first_part` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_second_part` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_services`
--

CREATE TABLE `freelancer_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `short_desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highlight` tinyint(4) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `freelancer_services`
--

INSERT INTO `freelancer_services` (`id`, `freelancer_id`, `category_id`, `name`, `price`, `short_desc`, `images`, `image`, `highlight`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(18, 20, 12, 'gdfgdg', 33, 'fdgdfgdg', 'cb351477459188fff0adc9ca43bbaa164410633.png', NULL, 0, 0, NULL, '2021-10-13 06:56:04', '2021-11-09 10:25:57'),
(19, 20, 12, 'gdfgdg', 33, 'fdgdfgdg', 'cb351477459188fff0adc9ca43bbaa164410633.png', NULL, 0, 0, NULL, '2021-10-13 06:56:04', '2021-11-09 10:25:57'),
(20, 20, 12, 'fasf', 20000, 'asdfsd', '', NULL, 1, 1, NULL, '2021-10-13 06:57:35', '2021-12-19 07:07:57'),
(21, 25, 12, 'dsad', 3242, 'asdsad', '59ef7021e6e9607e4afb935f51a4b981179090.jpg,59ef7021e6e9607e4afb935f51a4b9811543186.jpg', 'freelancer_services-image-08661f6bbc2becccbcdcb7aaa8c0364b.jpg', 0, 0, NULL, '2021-11-09 10:18:31', '2021-11-09 10:18:31'),
(23, 20, 12, 'لیلی', 20000, 'لیبل', 'fac4909cda9eca5111debca1153399e32943913.jpg', '', 1, 0, NULL, '2021-12-19 07:08:31', '2021-12-19 07:08:31'),
(24, 20, 12, 'لیبل', 44, 'یبلب', '15abcf4531c6186e980ca473c379cb942407645.jpg', '', 0, 1, NULL, '2021-12-19 07:08:58', '2021-12-19 07:08:58'),
(25, 22, 12, 'aa', 100, 'asf', '612b387de8fabf5be97ada070eb8aa933424669.jpg,612b387de8fabf5be97ada070eb8aa934468054.jpg,612b387de8fabf5be97ada070eb8aa938501262.jpg', 'freelancer_services-image-0a862f6fab9103efb2b364b549ead5e4.jpg', 1, 1, NULL, '2021-12-26 10:26:40', '2021-12-26 10:26:40'),
(26, 23, 12, 'bb', 90, 'asd', '5911007ae4d7f6093ba2002c1b01d740346478.jpg', 'freelancer_services-image-3de340b8257f263c21fad25e97b4e932.jpg', 1, 1, NULL, '2021-12-26 10:27:24', '2021-12-26 10:27:24'),
(29, 25, 16, 'test api update', 1000, 'short description update', '', NULL, 0, 0, NULL, '2022-01-30 09:11:10', '2022-01-31 13:02:25'),
(30, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 1, NULL, '2022-01-31 06:11:44', '2022-01-31 06:11:44'),
(31, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 1, NULL, '2022-01-31 13:02:24', '2022-01-31 13:02:24'),
(32, 23, NULL, 'fsef', 20000, 'sdfsd', 'b1cd549d327ddccb739108aa94d39648449724.jpg', 'freelancer_services-image-704fffda4ecee60342b6e1d39fc85f45.jpg', 1, 1, NULL, '2022-02-01 08:52:03', '2022-02-01 08:52:03'),
(33, 20, NULL, 'service12', 1000, 'service12', 'ba8d081bb69bac966c6f71125451e5149674945.jpg', '/uploads/freelancer_services/freelancer_services-image-857b1e67df07060a28d1a103d45e73c9.jpg', 1, 1, NULL, '2022-02-01 11:16:54', '2022-02-01 11:25:38'),
(35, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 0, NULL, '2022-02-08 06:58:21', '2022-02-08 06:58:21'),
(36, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 0, NULL, '2022-02-08 06:59:10', '2022-02-08 06:59:10'),
(37, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 0, NULL, '2022-02-08 07:05:21', '2022-02-08 07:05:21'),
(38, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 1, NULL, '2022-02-14 07:48:23', '2022-02-14 07:48:23'),
(39, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 1, NULL, '2022-02-14 07:48:43', '2022-02-14 07:48:43'),
(40, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 1, NULL, '2022-02-14 07:54:44', '2022-02-14 07:54:44'),
(41, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 1, NULL, '2022-02-14 07:56:10', '2022-02-14 07:56:10'),
(42, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 1, NULL, '2022-02-14 07:57:16', '2022-02-14 07:57:16'),
(43, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 1, NULL, '2022-02-14 08:08:15', '2022-02-14 08:08:15'),
(44, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 1, NULL, '2022-02-14 08:10:36', '2022-02-14 08:10:36'),
(45, 25, 16, 'test api', 1000, 'short description', '', NULL, 0, 1, NULL, '2022-02-14 08:33:13', '2022-02-14 08:33:13'),
(46, 32, 16, 'Test Service', 1000, 'short description for services', '', NULL, 0, 1, NULL, '2022-02-16 10:16:16', '2022-02-16 10:16:16'),
(47, 32, 16, 'Test Service 2', 500, 'short description for services adasdfa', '', NULL, 0, 1, NULL, '2022-02-16 10:16:33', '2022-02-16 10:16:33'),
(48, 32, 13, 'Test Service 2', 500, 'short description for services adasdfa', '', NULL, 0, 1, NULL, '2022-02-20 14:39:54', '2022-02-20 14:39:54'),
(49, 32, 13, 'Test Service 3', 300, 'short description for services adasdfa asdfasdf as df asd f asd f asdf a sd fa sdf asfasdfa sdf as df as df as f', '', NULL, 0, 1, NULL, '2022-02-20 14:40:47', '2022-02-20 14:40:47'),
(50, 32, 12, 'Test Service 1', 300, 'short description for services adasdfa asdfasdf as df asd f asd f asdf a sd fa sdf asfasdfa sdf as df as df as f', 'services-file-9df1b6a6d94a7a0c56ff49f1109ea1c0.jpeg', 'services-file-9df1b6a6d94a7a0c56ff49f1109ea1c0.jpeg', 0, 1, NULL, '2022-02-20 14:43:13', '2022-02-20 14:43:13'),
(51, 32, 12, 'Test Service 2', 100, 'short description for services adasdfa asdfasdf as df asd f asd f asdf a sd fa sdf asfasdfa sdf as df as df as f', 'services-file-37b7d988499abdf06f48a3fefc39a5e5.png', 'services-file-37b7d988499abdf06f48a3fefc39a5e5.png', 0, 1, NULL, '2022-02-20 14:45:12', '2022-02-20 14:45:12'),
(52, 32, 12, 'Test Service 5', 1000, 'short description for services adasdfa asdfasdf as df asd f asd f asdf a sd fa sdf asfasdfa sdf as df as df as f', 'services-file-a805350fc20e0ffcd9aa5b4242e12614.png', 'services-file-a805350fc20e0ffcd9aa5b4242e12614.png', 0, 1, NULL, '2022-02-20 14:54:36', '2022-02-20 14:54:36');

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_user_messages`
--

CREATE TABLE `freelancer_user_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('user','freelancer') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message_type` int(11) DEFAULT NULL,
  `freelancer_delete` tinyint(4) NOT NULL DEFAULT 0,
  `user_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `freelancer_user_messages`
--

INSERT INTO `freelancer_user_messages` (`id`, `user_id`, `freelancer_id`, `type`, `message`, `status`, `lat`, `long`, `file`, `message_type`, `freelancer_delete`, `user_delete`, `created_at`, `updated_at`) VALUES
(24, 2, 23, 'user', 'Test Message', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-20 07:06:11', '2022-01-20 07:06:11'),
(25, 2, 23, 'user', 'Test Message', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-20 07:06:13', '2022-01-20 07:06:13'),
(26, 2, 25, 'user', 'Test Message', 0, NULL, NULL, NULL, 1, 1, 0, '2022-01-20 07:06:13', '2022-02-14 08:11:01'),
(27, 2, 25, 'user', 'Test Message', 0, NULL, NULL, NULL, 1, 1, 0, '2022-01-20 07:06:13', '2022-02-14 08:11:01'),
(28, 27, 23, 'user', 'Test Message1111', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-20 08:07:15', '2022-01-20 08:07:15'),
(29, 2, 23, 'user', 'Test Message3', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-23 20:57:00', '2022-01-23 20:57:00'),
(30, 2, 23, 'user', 'Test Message3', 0, '324234', '4234324', NULL, 2, 0, 0, '2022-01-23 20:57:15', '2022-01-23 20:57:15'),
(31, 2, 23, 'user', 'Test Message', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-25 08:16:12', '2022-01-25 08:16:12'),
(32, 2, 23, 'user', 'Test Message', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-25 08:16:18', '2022-01-25 08:16:18'),
(33, 2, 23, 'user', 'Test Message', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-25 08:25:49', '2022-01-25 08:25:49'),
(34, 2, 23, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-5125bcd94298acebee4057c95e0c4b89.jpg', 4, 0, 0, '2022-01-25 10:58:49', '2022-01-25 10:58:49'),
(35, 2, 25, 'user', 'hshs', 0, NULL, NULL, NULL, 1, 1, 0, '2022-01-25 12:21:42', '2022-02-14 08:11:01'),
(36, 2, 25, 'user', 'hiiiii', 0, NULL, NULL, NULL, 1, 1, 0, '2022-01-25 12:23:15', '2022-02-14 08:11:01'),
(37, 2, 23, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-47fc77928ee29f5779539baa8ecec264.png', 4, 0, 0, '2022-01-25 12:39:25', '2022-01-25 12:39:25'),
(38, 2, 25, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-787b13c7cfc5aa4825f29e48bc7a1eda.', 4, 1, 0, '2022-01-25 12:44:34', '2022-02-14 08:11:01'),
(39, 2, 25, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-e70cdb958b9288c0553e67a4e4bc40b9.', 3, 1, 0, '2022-01-25 12:45:16', '2022-02-14 08:11:01'),
(40, 2, 25, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-26538718681998527c3fe5cec937c44d.', 3, 1, 0, '2022-01-25 12:59:24', '2022-02-14 08:11:01'),
(41, 27, 23, 'user', 'hi noob', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-27 09:10:28', '2022-01-27 09:10:28'),
(42, 27, 23, 'user', ';la sjdf;lasj fas', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-27 09:20:32', '2022-01-27 09:20:32'),
(43, 27, 23, 'user', 'hi dude', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-27 09:21:52', '2022-01-27 09:21:52'),
(44, 27, 23, 'user', 'how you doin?', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-27 09:22:01', '2022-01-27 09:22:01'),
(45, 2, 25, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-47673043d65dc453d966b18703948cee.', 3, 1, 0, '2022-01-27 09:24:45', '2022-02-14 08:11:01'),
(46, 2, 25, 'user', 'hiii', 0, NULL, NULL, NULL, 1, 1, 0, '2022-01-27 09:24:51', '2022-02-14 08:11:01'),
(47, 2, 25, 'user', 'hchchcjchchc', 0, NULL, NULL, NULL, 1, 1, 0, '2022-01-27 09:26:40', '2022-02-14 08:11:01'),
(48, 2, 25, 'user', 'kvkvkvvkvkvb', 0, NULL, NULL, NULL, 1, 1, 0, '2022-01-27 09:31:43', '2022-02-14 08:11:01'),
(49, 2, 25, 'user', 'z. z z', 0, NULL, NULL, NULL, 1, 1, 0, '2022-01-27 09:37:23', '2022-02-14 08:11:01'),
(50, 2, 25, 'user', 'hi', 0, NULL, NULL, NULL, 1, 1, 0, '2022-01-27 09:39:33', '2022-02-14 08:11:01'),
(51, 2, 25, 'user', 'chcjcjv', 0, NULL, NULL, NULL, 1, 1, 0, '2022-01-27 09:40:47', '2022-02-14 08:11:01'),
(52, 2, 25, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-a689a4f4e9f1d9d52a367c37c879cd18.', 3, 1, 0, '2022-01-27 09:41:05', '2022-02-14 08:11:01'),
(53, 2, 25, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-2f177a5deb07a520755d8343309f6230.', 4, 1, 0, '2022-01-27 09:57:46', '2022-02-14 08:11:01'),
(54, 2, 25, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-0e662c72d30f31109bb45f97333f545e.', 4, 1, 0, '2022-01-27 09:58:25', '2022-02-14 08:11:01'),
(55, 2, 23, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-ecac3903ff0469a5716894b563204cbe.xlsx', 4, 0, 0, '2022-01-29 07:17:15', '2022-01-29 07:17:15'),
(56, 2, 23, 'user', NULL, 0, NULL, NULL, '/uploads/messages/messages-file-f9ca7f10666f01bdcfe816d5adff722e.xlsx', 4, 0, 0, '2022-01-29 11:35:26', '2022-01-29 11:35:26'),
(57, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: \nDate & Time: 2022 Jan 29 10:22\nDescription: desc', 0, '', '', NULL, NULL, 0, 0, '2022-01-29 12:05:31', '2022-01-29 12:05:31'),
(58, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: \nDate & Time: 2022 Jan 29 10:22\nDescription: desc', 0, '', '', NULL, NULL, 0, 0, '2022-01-29 12:07:17', '2022-01-29 12:07:17'),
(59, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: \nDate & Time: 2022 Jan 29 10:22\nDescription: desc', 0, '', '', NULL, NULL, 0, 0, '2022-01-29 12:07:33', '2022-01-29 12:07:33'),
(60, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: \nDate & Time: 2022 Jan 29 10:22\nDescription: desc', 0, '', '', NULL, NULL, 0, 0, '2022-01-29 12:07:46', '2022-01-29 12:07:46'),
(61, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: \nDate & Time: 2022 Jan 29 10:22\nDescription: desc', 0, '', '', NULL, NULL, 0, 0, '2022-01-29 12:10:09', '2022-01-29 12:10:09'),
(62, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: place\nDate & Time: 2022 Jan 29 10:22\nDescription: desc', 0, '', '', NULL, NULL, 0, 0, '2022-01-29 12:20:44', '2022-01-29 12:20:44'),
(63, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: place\nDate & Time: 2022 Jan 29 10:22\nDescription: desc', 0, '', '', NULL, NULL, 0, 0, '2022-01-29 12:23:07', '2022-01-29 12:23:07'),
(64, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: place\nDate & Time: 2022 Jan 29 10:22\nDescription: desc', 0, '', '', NULL, NULL, 0, 0, '2022-01-29 12:24:30', '2022-01-29 12:24:30'),
(65, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: place\nDate & Time: 2022 Jan 29 10:22\nDescription: desc', 0, '', '', NULL, NULL, 0, 0, '2022-01-29 12:25:24', '2022-01-29 12:25:24'),
(66, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: place\nDate & Time: 2022 Jan 29 10:22\nDescription: desc', 0, '', '', NULL, NULL, 0, 0, '2022-01-29 12:25:32', '2022-01-29 12:25:32'),
(67, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: place\nDate & Time: 2022 Jan 30 10:30\nDescription: description', 0, '', '', NULL, NULL, 0, 0, '2022-01-30 09:37:46', '2022-01-30 09:37:46'),
(68, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: place\nDate & Time: 2022 Jan 30 10:30\nDescription: description', 0, '', '', NULL, NULL, 0, 0, '2022-01-30 09:38:23', '2022-01-30 09:38:23'),
(69, 2, 25, 'freelancer', 'ddddddddddddddddddddddddd', 0, NULL, NULL, NULL, 0, 1, 0, '2022-01-31 06:12:58', '2022-02-14 08:11:01'),
(70, 2, 23, 'user', 'Test Message1', 0, NULL, NULL, NULL, 1, 0, 0, '2022-01-31 12:08:26', '2022-01-31 12:08:26'),
(71, 2, 23, 'user', 'Test Message1', 0, NULL, NULL, '/uploads/messages/messages-file-ae87975797dadabbf38360359f813803.jpg', 4, 0, 0, '2022-01-31 12:09:32', '2022-01-31 12:09:32'),
(72, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-01-31 13:02:26', '2022-02-14 08:11:01'),
(73, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-01-31 13:11:35', '2022-02-14 08:11:01'),
(74, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: dasda\nDate & Time: 2022 Jan 31 10:00\nDescription: mehrandish', 0, '', '', NULL, NULL, 0, 0, '2022-01-31 13:12:21', '2022-01-31 13:12:21'),
(75, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-01-31 13:12:53', '2022-02-14 08:11:01'),
(76, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: dasda\nDate & Time: 2022 Jan 31 10:00\nDescription: mehrandish', 0, '', '', NULL, NULL, 0, 0, '2022-01-31 13:27:02', '2022-01-31 13:27:02'),
(77, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: \nDate & Time: 2022 Jan 31 10:00\nDescription: mehrandish', 0, '', '', NULL, NULL, 0, 0, '2022-01-31 13:27:23', '2022-01-31 13:27:23'),
(78, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: \nDate & Time: 2022 Jan 31 16:27\nDescription: mehrandish', 0, '', '', NULL, NULL, 0, 0, '2022-01-31 13:27:31', '2022-01-31 13:27:31'),
(79, 2, 25, 'freelancer', '5', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-08 06:58:22', '2022-02-14 08:11:01'),
(80, 2, 25, 'freelancer', '6', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-08 06:59:11', '2022-02-14 08:11:01'),
(81, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-08 07:04:51', '2022-02-14 08:11:01'),
(82, 2, 25, 'freelancer', '7', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-08 07:05:22', '2022-02-14 08:11:01'),
(83, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-08 07:05:22', '2022-02-14 08:11:01'),
(84, 2, 23, 'user', 'New quotation receive.\nBudget: 10\nPlace: home\nDate & Time: 2022 Oct 25 10:20\nDescription: mehrandish', 0, '', '', NULL, NULL, 0, 0, '2022-02-09 07:40:15', '2022-02-09 07:40:15'),
(85, 2, 25, 'freelancer', '8', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-12 07:25:07', '2022-02-14 08:11:01'),
(86, 2, 25, 'freelancer', '9', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 07:48:49', '2022-02-14 08:11:01'),
(87, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 07:48:50', '2022-02-14 08:11:01'),
(88, 2, 25, 'freelancer', '10', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 07:54:53', '2022-02-14 08:11:01'),
(89, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 07:54:57', '2022-02-14 08:11:01'),
(90, 2, 25, 'freelancer', '11', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 07:56:26', '2022-02-14 08:11:01'),
(91, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 07:56:27', '2022-02-14 08:11:01'),
(92, 2, 25, 'freelancer', '12', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 07:57:22', '2022-02-14 08:11:01'),
(93, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 07:57:23', '2022-02-14 08:11:01'),
(94, 2, 25, 'freelancer', '13', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 08:08:21', '2022-02-14 08:11:01'),
(95, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 08:08:21', '2022-02-14 08:11:01'),
(96, 2, 25, 'freelancer', '14', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 08:10:44', '2022-02-14 08:11:01'),
(97, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 1, 0, '2022-02-14 08:10:45', '2022-02-14 08:11:01'),
(98, 2, 25, 'freelancer', '15', 0, NULL, NULL, NULL, 6, 0, 0, '2022-02-14 08:33:19', '2022-02-14 08:33:19'),
(99, 2, 25, 'freelancer', '4', 0, NULL, NULL, NULL, 6, 0, 0, '2022-02-14 08:33:20', '2022-02-14 08:33:20'),
(100, 2, 23, 'user', 'Test Message1', 0, NULL, NULL, NULL, 4, 0, 0, '2022-02-16 06:22:53', '2022-02-16 06:22:53'),
(101, 2, 23, 'user', 'Test Message1', 0, NULL, NULL, NULL, 4, 0, 0, '2022-02-16 06:40:33', '2022-02-16 06:40:33'),
(102, 2, 23, 'user', 'Test Message1', 0, NULL, NULL, NULL, 4, 0, 0, '2022-02-23 06:05:35', '2022-02-23 06:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_workshops`
--

CREATE TABLE `freelancer_workshops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `block` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apartment_no` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` bigint(20) UNSIGNED NOT NULL,
  `total_persons` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reserved` int(11) DEFAULT 0,
  `available` int(11) DEFAULT 20,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `freelancer_workshops`
--

INSERT INTO `freelancer_workshops` (`id`, `freelancer_id`, `images`, `date`, `from_time`, `to_time`, `street`, `area_id`, `block`, `building_name`, `floor`, `apartment_no`, `price`, `total_persons`, `reserved`, `available`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 23, '', '2022-01-29', '12:08:29', '12:08:32', 'awdadad dawdwa dawd', 5, '', '', NULL, NULL, 4234, '20', -24, 0, 1, NULL, '2022-02-10 08:52:31'),
(8, 25, '', '2022-01-28', '20:00:00', '21:00:00', 'sdasd', 5, '', '', NULL, NULL, 1000, '16', 0, 20, 1, '2022-01-31 06:12:00', '2022-01-31 06:12:00'),
(9, 25, '', '2022-01-28', '20:00:00', '21:00:00', 'sdasd', 5, '', '', NULL, NULL, 1000, '16', 0, 20, 1, '2022-01-31 13:02:32', '2022-01-31 13:02:32'),
(10, 22, 'c54af761e59dd6d9cc80c4254b2b59a48711481.jpg', '2022-02-01', '14:56:00', '14:56:00', 'afsaf fasfa asf aff', 5, '', '', NULL, NULL, 10, '20', 0, 20, 1, '2022-02-01 11:27:11', '2022-02-01 11:27:16'),
(12, 25, '', '2022-01-28', '20:00:00', '21:00:00', 'sdasd', 5, '', '', NULL, NULL, 1000, '16', 0, 20, 1, '2022-02-08 06:58:25', '2022-02-08 06:58:25'),
(13, 25, '', '2022-01-28', '20:00:00', '21:00:00', 'sdasd', 5, '', '', NULL, NULL, 1000, '16', 0, 20, 1, '2022-02-08 06:59:14', '2022-02-08 06:59:14'),
(14, 25, '', '2022-03-18', '20:00:00', '21:00:00', 'sdasd', 5, '', '', NULL, NULL, 1000, '16', -20, 16, 1, '2022-02-08 07:05:25', '2022-02-23 06:05:27'),
(15, 25, '', '2022-05-28', '20:00:00', '21:00:00', 'street', 5, 'block', 'bulding_name', '1', 'ten', 1000, '16', 0, 20, 1, '2022-02-09 06:49:59', '2022-02-09 06:49:59'),
(16, 25, '', '2022-05-28', '20:00:00', '21:00:00', 'street', 5, 'block', 'bulding_name', '1', 'ten', 1000, '16', 0, 20, 1, '2022-02-14 07:56:31', '2022-02-14 07:56:31'),
(17, 25, '', '2022-05-28', '20:00:00', '21:00:00', 'street', 5, 'block', 'bulding_name', '1', 'ten', 1000, '16', 0, 20, 1, '2022-02-14 07:57:25', '2022-02-14 07:57:25'),
(18, 25, '', '2022-05-28', '20:00:00', '21:00:00', 'street', 5, 'block', 'bulding_name', '1', 'ten', 1000, '16', 0, 20, 1, '2022-02-14 08:08:23', '2022-02-14 08:08:23'),
(19, 25, '', '2022-05-28', '20:00:00', '21:00:00', 'street', 5, 'block', 'bulding_name', '1', 'ten', 1000, '16', 0, 20, 1, '2022-02-14 08:10:47', '2022-02-14 08:10:47'),
(20, 25, '', '2022-05-28', '20:00:00', '21:00:00', 'street', 5, 'block', 'bulding_name', '1', 'ten', 1000, '16', 0, 20, 1, '2022-02-14 08:33:21', '2022-02-14 08:33:21'),
(21, 32, '', '2022-01-28', '20:00:00', '21:00:00', 'street', 5, '2nd block', 'Albassam complex', '2', '14', 1000, '16', 0, 20, 1, '2022-02-19 07:59:28', '2022-02-19 07:59:28'),
(22, 32, '', '2022-01-28', '20:00:00', '21:00:00', 'street', 5, '3nd block', 'Xpress Building', '5', '22', 1000, '16', 0, 20, 1, '2022-02-19 08:00:11', '2022-02-19 08:00:11'),
(23, 32, 'workshop-file-25a5458bcb9847bf5fa090ad57b0829b.jpeg', '2022-02-28', '20:00:00', '21:00:00', 'Bin khaldoon', 5, '2nd block', 'Xpress Building', '5', '22', 1100, '10', 0, 20, 1, '2022-02-20 14:56:32', '2022-02-20 14:56:32'),
(24, 32, 'workshop-file-838f17e84be7f2aeb3397e2fd52e3658.jpeg', '2022-02-28', '20:00:00', '21:00:00', 'Bin khaldoon', 5, '2nd block', 'Xpress Building', '5', '22', 1100, '10', 0, 20, 1, '2022-02-20 14:57:04', '2022-02-20 14:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `freelancer_workshop_translations`
--

CREATE TABLE `freelancer_workshop_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_workshop_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `freelancer_workshop_translations`
--

INSERT INTO `freelancer_workshop_translations` (`id`, `freelancer_workshop_id`, `locale`, `name`, `description`) VALUES
(8, 8, 'en', 'test api', 'short description'),
(9, 9, 'en', 'test api', 'short description'),
(10, 10, 'en', 'test1', '<p>test1</p>'),
(11, 10, 'ar', 'test1', '<p>test1</p>'),
(14, 12, 'en', 'test api', 'short description'),
(15, 13, 'en', 'test api', 'short description'),
(16, 14, 'en', 'test api', 'short description'),
(17, 15, 'en', 'test api', 'short description'),
(18, 16, 'en', 'test api', 'short description'),
(19, 17, 'en', 'test api', 'short description'),
(20, 18, 'en', 'test api', 'short description'),
(21, 19, 'en', 'test api', 'short description'),
(22, 20, 'en', 'test api', 'short description'),
(23, 21, 'en', 'test api', 'short description'),
(24, 22, 'en', 'test api', 'short description'),
(25, 23, 'en', 'Testing workshop for ios app', 'short description'),
(26, 24, 'en', 'Testing workshop for ios app 1', 'short description short description short description short description short description short description short description short description short description short description short description');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_aboutus`
--

CREATE TABLE `gwc_aboutus` (
  `id` bigint(20) NOT NULL,
  `details_en` text NOT NULL,
  `details_ar` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_aboutus`
--

INSERT INTO `gwc_aboutus` (`id`, `details_en`, `details_ar`, `image`, `created_at`, `updated_at`) VALUES
(1, '<p><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span><span style=\"background-color: #ffffff; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px;\">Details (en)&nbsp;</span></p>', '<p><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span><label style=\"box-sizing: border-box; display: inline-block; margin-bottom: 0.5rem; font-size: 13px; color: #646c9a; font-family: Poppins, Helvetica, sans-serif; background-color: #ffffff;\">Details (ar)</label><span style=\"color: #646c9a; font-family: Poppins, Helvetica, sans-serif; font-size: 13px; background-color: #ffffff;\">&nbsp;</span></p>', 'aboutus-image-abaab804fdc9ef7ef18c2f7550b313b8.jpg', '2021-06-09 06:56:47', '2021-07-04 07:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_admins`
--

CREATE TABLE `gwc_admins` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `password_token` varchar(255) NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_admins`
--

INSERT INTO `gwc_admins` (`id`, `name`, `email`, `mobile`, `username`, `password`, `image`, `is_active`, `created_by`, `password_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'soheilmehrandish@gmail.com', '09307199929', 'admin', '$2y$10$dBk.ebd0DSyQS/vyhPR5uO/anQFMB1gxoseGt6sQxFUENkkzKItHC', 'no-image.png', 1, 1, '10e39fb7-1a15-4b10-accc-61b3f0cdb3c7', '6JEILYUnxHtuWjN6iySNin22KkWeqeW80eEH0RBSTIdc5iDsDCrWDLCajojV', '2021-12-25 08:42:13', '2021-07-12 09:34:12'),
(4, 'taghi', 'ss@gmail.com', '66666666', 'taghi', '$2y$10$lT/s7QT5I/Nd8SFbG2ES0.Ap20c0khZee5Olov9dpXBUKx5R5WrZC', 'admins-image-7fc8119384a0d1ece49e6a4815d7ecd7.png', 1, 0, '', '', '2021-11-16 12:25:09', '2021-11-16 12:25:09');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_areas`
--

CREATE TABLE `gwc_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `city_id` int(20) NOT NULL,
  `fee` double NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_areas`
--

INSERT INTO `gwc_areas` (`id`, `title_en`, `title_ar`, `city_id`, `fee`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'Hawalli', 'حولي', 3, 4, 1, '2021-10-12 10:36:17', '2021-10-12 10:36:17'),
(7, 'Bayan', 'بيان', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(8, 'Mishref', 'مشرف', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(9, 'Maidan Hawalli', 'ميدان حولي', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(10, 'Jabriya', 'الجابرية', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(11, 'Rumaithiya', 'الرميثية', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(12, 'Salmiya', 'السالمية', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(13, 'Salwa', 'سلوى', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(14, 'Shaab', 'الشعب', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(15, 'Al-salam', 'السلام', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(16, 'Hattin', 'حطين', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(17, 'Al-Zahra', 'الزهراء', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(18, 'Mubarak Al Abdullah (West Mishref)', 'مبارك العبدالله (غرب مشرف)', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(19, 'Al-shuhada', 'الشهداء', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(20, 'Al-badae', 'البدع', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(21, 'Al-Siddiq', 'الصديق', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(22, 'Surra', 'السرة', 3, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(23, 'Abrag Khitan', 'أبرق خيطان', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(24, 'Al Andalus', 'الأندلس', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(25, 'Ishbilia', 'اشبيلية', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(26, 'Jleeb Al Shouyouk', 'جليب الشيوخ', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(27, 'Omariya', 'العمرية', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(28, 'Ardiya', 'العارضية', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(29, 'Industrial Ardiya', 'العارضية الصناعية', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(30, 'Fordus', 'الفردوس', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(31, 'Farwaniya', 'الفروانية', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(32, 'Shadadiya', 'الشدادية', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(33, 'Rihab', 'الرحاب', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(34, 'Rabiya', 'الرابية', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(35, 'Industrial Rai', 'الري الصناعية', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(36, 'Abdullah Al Mubarak', 'عبد الله المبارك', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(37, 'Dajeej', 'الضجيج', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(38, 'Khaitan', 'خيطان', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(39, 'Al Riqai', 'الرقعي', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(40, 'Sabah Al Nasser', 'صباح الناصر', 6, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(41, 'Dasman', 'دسمان', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(42, 'Sharq', 'الشرق', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(43, 'Abdullah Al-Salem', 'عبدالله السالم', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(44, 'Adiliya', 'العديلية', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(45, 'Bneid Al-Qar', 'بنيد القار', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(46, 'Al Da\'iya', 'الدعية', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(47, 'Al Dasma', 'الدسمة', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(48, 'Al Faiha', 'الفيحاء', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(49, 'Kaifan', 'كيفان', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(50, 'Khaldiya', 'الخالدية', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(51, 'Kuwait City', 'مدينة الكويت', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(52, 'Al Mansouriah', 'المنصورية', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(53, 'Murgab', 'المرقاب', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(54, 'Al-Nuzha', 'النزهة', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(55, 'Al Qadsiya', 'القادسية', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(56, 'Qurtoba', 'قرطبة', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(57, 'Rawdah', 'الروضة', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(58, 'Al Shamiya', 'الشامية', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(59, 'Al Shuwaikh', 'الشويخ', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(60, 'Sulaibikhat', 'الصليبيخات', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(61, 'Al Yarmouk', 'اليرموك', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(62, 'North West Sulaibikhat', 'شمال غرب صليبخات', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(63, 'Salhiya', 'الصالحية', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(64, 'Al Doha', 'الدوحة', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(65, 'Al Watia', 'الوطية', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(66, 'Granada', 'غرناطة', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(67, 'Al Nahda', 'النهضة', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(68, 'Qairawan', 'قيروان', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(69, 'Al Rai', 'الري', 4, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(70, 'Abu Al Hasaniya', 'ابو الحصانية', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(71, 'Abu Fatira', 'ابو فطيرة', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(72, 'Al Adan', 'العدان', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(73, 'Al Qurain', 'القرين', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(74, 'Al-Qusour', 'القصور', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(75, 'Al Funaitis', 'الفنيطيس', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(76, 'Al Messila', 'المسيلة', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(77, 'Mubarak Al-Kabeer', 'مبارك الكبير', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(78, 'Sabah Al-Salem', 'صباح السالم', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(79, 'Al Mesayel', 'المسايل', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(80, 'Sabhan', 'صبحان', 16, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(81, 'Abu Halifa', 'أبو حليفة', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(82, 'Al-Ahmadi', 'الأحمدي', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(83, 'Al-Eqaila', 'العقيلة', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(84, 'Daher', 'الظهر', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(85, 'Fahaheel', 'الفحيحيل', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(86, 'Fintas', 'الفنطاس', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(87, 'Hadyia', 'هدية', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(88, 'Jaber Al Ali', 'ضاحية جابر العلي', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(89, 'Mahboula', 'المهبولة', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(90, 'Mangaf', 'المنقف', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(91, 'Riqqa', 'الرقه', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(92, 'Subahiya', 'الصباحية', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(93, 'Al Julaia\'a Chalet', 'شاليهات الجليعة', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(94, 'Al Dubaiya Chalet', 'شاليهات الضباعية', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(95, 'Faad Al Ahmad', 'ضاحية فهد الأحمد', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(96, 'Sabah Al Ahmad', 'مدينة صباح الأحمد', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(97, 'Ali Sabah Al Salem', 'علي صباح السالم', 17, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(98, 'Alnaeem', 'النعيم', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(99, 'Alqaser', 'القصر', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(100, 'Alwaha', 'الواحة', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(101, 'Taimaa', 'تيماء', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(102, 'Alnaseem', 'النسيم', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(103, 'Aloyoon', 'العيون', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(104, 'Al Jahra', 'الجهراء', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(105, 'New Jahra', 'الجهراء الجديدة', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(106, 'Saad Al Abdullah', 'سعد العبد الله', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(107, 'Jaber Al Ahmad', 'جابر الأحمد', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(108, 'Al Sulaibiya', 'الصليبية', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24'),
(109, 'Chabd', 'كبد', 18, 5, 1, '2021-11-09 05:24:24', '2021-11-09 05:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_cities`
--

CREATE TABLE `gwc_cities` (
  `id` bigint(20) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `country_id` int(20) NOT NULL,
  `fee` double NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_cities`
--

INSERT INTO `gwc_cities` (`id`, `title_en`, `title_ar`, `country_id`, `fee`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'Hawalli Governorate', 'محافظة حولي', 2, 0, 1, '2022-02-19 13:13:48', '2021-10-03 12:15:40'),
(4, 'Al Asimah Governorate', 'محافظة العاصمة', 2, 0, 1, '2022-02-19 13:14:29', '2021-07-12 04:02:48'),
(6, 'Farwniya Governorate', 'محافظة الفروانية', 2, 0, 1, '2022-02-19 13:14:07', '2021-07-18 07:40:47'),
(16, 'Mubarak Al-Kabeer Governorate', 'محافظة مبارك الكبير', 2, 0, 1, '2022-02-19 13:14:07', '2021-07-18 07:40:47'),
(17, 'Ahmadi Governorate', 'محافظة الأحمدي', 2, 0, 1, '2022-02-19 13:14:07', '2021-07-18 07:40:47'),
(18, 'Jahra Governorate', 'محافظة الجهراء', 2, 0, 1, '2022-02-19 13:14:07', '2021-07-18 07:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_countries`
--

CREATE TABLE `gwc_countries` (
  `id` bigint(20) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_countries`
--

INSERT INTO `gwc_countries` (`id`, `title_en`, `title_ar`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'kuwait', 'kuwait', 'countries-image-8774c08b4f3463b2ad892ee06ad14ce3.png', 1, '2021-07-12 04:01:41', '2021-07-18 07:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_coupons`
--

CREATE TABLE `gwc_coupons` (
  `id` bigint(20) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `coupon_type` varchar(255) NOT NULL,
  `coupon_value` double NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `price_start` double NOT NULL,
  `price_end` double NOT NULL,
  `usage_limit` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_free` tinyint(1) NOT NULL,
  `is_for` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_coupons`
--

INSERT INTO `gwc_coupons` (`id`, `title_en`, `title_ar`, `coupon_code`, `coupon_type`, `coupon_value`, `date_start`, `date_end`, `price_start`, `price_end`, `usage_limit`, `is_active`, `is_free`, `is_for`, `created_at`, `updated_at`) VALUES
(1, 'dfadsd', 'dfsafsdf', 'dsfsd', 'amount', 656.66, '2021-07-24', '2021-07-31', 200, 400, 545, 1, 0, 'web', '2021-07-19 07:54:14', '2021-07-19 08:04:05'),
(2, 'fdsfsf', 'sdfsdfsf', 'dsfsd3', 'amount', 3213, '2021-07-24', '2021-07-25', 432, 424324, 33, 1, 0, 'web', '2021-07-19 08:13:11', '2021-07-19 08:13:11'),
(3, 'qqqqqqqqq', 'wwwwwww', 'ddfsfdsf', 'amount', 7, '2021-07-21', '2021-07-22', 7777, 88888, 999, 1, 1, 'web', '2021-07-19 08:14:34', '2021-07-19 08:29:53');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_directors`
--

CREATE TABLE `gwc_directors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `display_order` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gwc_durations`
--

CREATE TABLE `gwc_durations` (
  `id` bigint(20) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_durations`
--

INSERT INTO `gwc_durations` (`id`, `title_en`, `title_ar`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '1 month', '1 month', 1, '2021-07-12 10:35:46', '2021-07-12 10:35:46'),
(2, '3 month', '3 month', 1, '2021-07-12 10:36:03', '2021-07-12 10:36:03'),
(3, '1 year', '1 year', 1, '2021-07-12 10:36:20', '2021-07-12 10:37:31');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_featured_projects`
--

CREATE TABLE `gwc_featured_projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `display_order` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gwc_home_about_info`
--

CREATE TABLE `gwc_home_about_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `top_title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `top_title_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gwc_ideas`
--

CREATE TABLE `gwc_ideas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_details_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_details_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_details_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_details_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `display_order` int(11) NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gwc_logs`
--

CREATE TABLE `gwc_logs` (
  `id` int(11) NOT NULL,
  `key_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gwc_logs`
--

INSERT INTO `gwc_logs` (`id`, `key_name`, `key_id`, `message`, `created_at`, `updated_at`, `created_by`) VALUES
(5, 'setting', 1, 'Website settings are updated', '2021-06-26 11:55:51', '2021-06-26 11:55:51', 1),
(6, 'setting', 1, 'Website settings are updated', '2021-06-26 12:11:20', '2021-06-26 12:11:20', 1),
(7, 'setting', 1, 'Website settings are updated', '2021-06-26 12:39:45', '2021-06-26 12:39:45', 1),
(8, 'setting', 1, 'Website settings are updated', '2021-06-26 12:43:30', '2021-06-26 12:43:30', 1),
(9, 'login', 1, 'Administrator(admin) is logged in to Admin Panel.', '2021-06-27 12:11:17', '2021-06-27 12:11:17', 1),
(11, 'globalPresence', 1, 'information updated', '2021-06-27 12:19:38', '2021-06-27 12:19:38', 1),
(12, 'setting', 1, 'Website settings are updated', '2021-06-27 12:45:06', '2021-06-27 12:45:06', 1),
(13, 'setting', 1, 'Website settings are updated', '2021-06-27 12:54:08', '2021-06-27 12:54:08', 1),
(14, 'developments', 1, 'A new record for developments is added. (1)', '2021-06-27 14:05:40', '2021-06-27 14:05:40', 1),
(15, 'developments', 1, 'Image is removed. (1)', '2021-06-27 14:05:48', '2021-06-27 14:05:48', 1),
(16, 'login', 1, 'Administrator(admin) is logged in to Admin Panel.', '2021-06-30 10:58:37', '2021-06-30 10:58:37', 1),
(17, 'ourservices', 1, 'A new record for ourservices is added. (fdsfd)', '2021-06-30 11:05:57', '2021-06-30 11:05:57', 1),
(18, 'ourservices', 2, 'A new record for ourservices is added. (dasa)', '2021-06-30 11:32:01', '2021-06-30 11:32:01', 1),
(19, 'ourservices', 2, 'Record for ourservices is edited. (dasa)', '2021-06-30 11:32:24', '2021-06-30 11:32:24', 1),
(20, 'privacy', 1, 'information updated', '2021-06-30 12:04:45', '2021-06-30 12:04:45', 1),
(21, 'privacy', 1, 'information updated', '2021-06-30 12:04:59', '2021-06-30 12:04:59', 1),
(22, 'role', 1, 'Role is edited to Admin', '2021-06-30 14:43:57', '2021-06-30 14:43:57', 1),
(23, 'role', 1, 'Role name is updated to Admin', '2021-06-30 14:44:02', '2021-06-30 14:44:02', 1),
(24, 'role', 1, 'Role is edited to Admin', '2021-06-30 14:44:06', '2021-06-30 14:44:06', 1),
(25, 'role', 1, 'Role is edited to Admin', '2021-06-30 14:47:47', '2021-06-30 14:47:47', 1),
(26, 'login', 1, 'Administrator(admin) is logged in to Admin Panel.', '2021-07-01 08:13:56', '2021-07-01 08:13:56', 1),
(27, 'menuTitles', 1, 'information updated', '2021-07-01 08:44:47', '2021-07-01 08:44:47', 1),
(28, 'menuTitles', 1, 'information updated', '2021-07-01 09:05:37', '2021-07-01 09:05:37', 1),
(29, 'menuTitles', 1, 'information updated', '2021-07-01 09:11:44', '2021-07-01 09:11:44', 1),
(30, 'menuTitles', 1, 'information updated', '2021-07-01 09:14:24', '2021-07-01 09:14:24', 1),
(31, 'user', 1, 'Profile is updated for Administrator', '2021-07-01 10:13:05', '2021-07-01 10:13:05', 1),
(32, 'user', 1, 'Profile is updated for Administrator', '2021-07-01 10:13:25', '2021-07-01 10:13:25', 1),
(33, 'about us', 1, 'information updated', '2021-07-01 10:58:00', '2021-07-01 10:58:00', 1),
(34, 'subjects', 1, 'A new subject is added.(General)', '2021-07-01 11:12:16', '2021-07-01 11:12:16', 1),
(35, 'subject', 1, 'Subject status is changed to 0.(General)', '2021-07-01 11:12:24', '2021-07-01 11:12:24', 1),
(36, 'subjects', 2, 'A new subject is added.(Agency)', '2021-07-01 11:12:55', '2021-07-01 11:12:55', 1),
(37, 'subject', 1, 'Subject status is changed to 1.(General)', '2021-07-01 11:13:04', '2021-07-01 11:13:04', 1),
(38, 'subject', 2, 'Subject status is changed to 1.(Agency)', '2021-07-01 11:13:05', '2021-07-01 11:13:05', 1),
(39, 'subjects', 3, 'A new subject is added.(11112222222)', '2021-07-01 11:13:18', '2021-07-01 11:13:18', 1),
(40, 'subjects', 4, 'A new subject is added.(Agency1)', '2021-07-01 11:16:30', '2021-07-01 11:16:30', 1),
(41, 'subjects', 4, 'A subject is removed.(Agency1)', '2021-07-01 11:16:35', '2021-07-01 11:16:35', 1),
(42, 'subjects', 3, 'A subject is removed.(11112222222)', '2021-07-01 11:16:38', '2021-07-01 11:16:38', 1),
(43, 'subjects', 2, 'A subject is removed.(Agency)', '2021-07-01 11:16:41', '2021-07-01 11:16:41', 1),
(44, 'subjects', 1, 'A subject is removed.(General)', '2021-07-01 11:16:44', '2021-07-01 11:16:44', 1),
(45, 'login', 1, 'Administrator(admin) is logged in to Admin Panel.', '2021-07-03 07:58:44', '2021-07-03 07:58:44', 1),
(46, 'ideas', 1, 'A new record for ideas is added. (1)', '2021-07-03 08:57:38', '2021-07-03 08:57:38', 1),
(47, 'Ideas', 2, 'A new record is added. (2)', '2021-07-03 12:55:36', '2021-07-03 12:55:36', 1),
(48, 'Ideas', 3, 'A new record is added. (3)', '2021-07-03 13:18:45', '2021-07-03 13:18:45', 1),
(49, 'Ideas', 4, 'A new record is added. (4)', '2021-07-03 13:53:23', '2021-07-03 13:53:23', 1),
(50, 'ideas', 1, 'Image is removed. (1)', '2021-07-03 14:08:35', '2021-07-03 14:08:35', 1),
(51, 'Ideas', 1, 'Record is edited. (1)', '2021-07-03 14:29:40', '2021-07-03 14:29:40', 1),
(52, 'ideas', 1, 'Image is removed. (1)', '2021-07-03 14:42:37', '2021-07-03 14:42:37', 1),
(53, 'Ideas', 1, 'Record is edited. (1)', '2021-07-03 14:42:56', '2021-07-03 14:42:56', 1),
(54, 'Ideas', 1, 'Record is edited. (1)', '2021-07-03 14:43:14', '2021-07-03 14:43:14', 1),
(55, 'Ideas', 1, 'Record is edited. (1)', '2021-07-03 14:45:48', '2021-07-03 14:45:48', 1),
(56, 'Ideas', 1, 'Record is edited. (1)', '2021-07-03 14:46:03', '2021-07-03 14:46:03', 1),
(57, 'ideas', 1, 'Image is removed. (1)', '2021-07-03 14:46:13', '2021-07-03 14:46:13', 1),
(58, 'Ideas', 1, 'Record is edited. (1)', '2021-07-03 14:46:24', '2021-07-03 14:46:24', 1),
(59, 'Ideas', 4, 'status is changed to 0 (4)', '2021-07-03 15:00:25', '2021-07-03 15:00:25', 1),
(60, 'Ideas', 3, 'status is changed to 0 (3)', '2021-07-03 15:00:46', '2021-07-03 15:00:46', 1),
(61, 'Ideas', 2, 'status is changed to 0 (2)', '2021-07-03 15:00:47', '2021-07-03 15:00:47', 1),
(62, 'Ideas', 1, 'status is changed to 0 (1)', '2021-07-03 15:00:47', '2021-07-03 15:00:47', 1),
(63, 'Ideas', 4, 'A record is removed. (4)', '2021-07-03 15:01:05', '2021-07-03 15:01:05', 1),
(64, 'Ideas', 3, 'A record is removed. (3)', '2021-07-03 15:03:39', '2021-07-03 15:03:39', 1),
(65, 'Ideas', 2, 'A record is removed. (2)', '2021-07-03 15:03:44', '2021-07-03 15:03:44', 1),
(66, 'Ideas', 1, 'A record is removed. (1)', '2021-07-03 15:03:49', '2021-07-03 15:03:49', 1),
(67, 'Ideas', 5, 'A new record is added. (5)', '2021-07-03 15:05:13', '2021-07-03 15:05:13', 1),
(68, 'Ideas', 6, 'A new record is added. (6)', '2021-07-03 15:05:46', '2021-07-03 15:05:46', 1),
(69, 'Ideas', 7, 'A new record is added. (7)', '2021-07-03 15:24:57', '2021-07-03 15:24:57', 1),
(70, 'Ideas', 8, 'A new record is added. (8)', '2021-07-03 15:30:22', '2021-07-03 15:30:22', 1),
(71, 'Ideas', 9, 'A new record is added. (9)', '2021-07-04 08:05:29', '2021-07-04 08:05:29', 1),
(72, 'Ideas', 9, 'status is changed to 1 (9)', '2021-07-04 08:05:32', '2021-07-04 08:05:32', 1),
(73, 'Ideas', 9, 'Record is edited. (9)', '2021-07-04 08:05:56', '2021-07-04 08:05:56', 1),
(74, 'Ideas', 9, 'Record is edited. (9)', '2021-07-04 08:06:07', '2021-07-04 08:06:07', 1),
(75, 'ideas', 9, 'Image is removed. (9)', '2021-07-04 08:06:16', '2021-07-04 08:06:16', 1),
(76, 'Ideas', 9, 'Record is edited. (9)', '2021-07-04 08:06:25', '2021-07-04 08:06:25', 1),
(77, 'Ideas', 9, 'A record is removed. (9)', '2021-07-04 08:06:52', '2021-07-04 08:06:52', 1),
(78, 'Aboutus', 1, 'information updated', '2021-07-04 10:17:21', '2021-07-04 10:17:21', 1),
(79, 'Aboutus', 1, 'information updated', '2021-07-04 10:17:35', '2021-07-04 10:17:35', 1),
(80, 'Aboutus', 1, 'information updated', '2021-07-04 10:17:46', '2021-07-04 10:17:46', 1),
(81, 'Aboutus', 1, 'Image is removed', '2021-07-04 10:19:03', '2021-07-04 10:19:03', 1),
(82, 'Aboutus', 1, 'information updated', '2021-07-04 10:19:26', '2021-07-04 10:19:26', 1),
(83, 'Settings', 1, 'Image is removed', '2021-07-04 11:11:01', '2021-07-04 11:11:01', 1),
(84, 'Settings', 1, 'Image is removed', '2021-07-04 11:11:05', '2021-07-04 11:11:05', 1),
(85, 'Settings', 1, 'Image is removed', '2021-07-04 11:11:08', '2021-07-04 11:11:08', 1),
(86, 'Settings', 1, 'information updated', '2021-07-04 11:22:05', '2021-07-04 11:22:05', 1),
(87, 'Settings', 1, 'information updated', '2021-07-04 12:03:27', '2021-07-04 12:03:27', 1),
(88, 'Settings', 1, 'information updated', '2021-07-04 12:04:24', '2021-07-04 12:04:24', 1),
(89, 'Settings', 1, 'Image is removed', '2021-07-04 12:04:32', '2021-07-04 12:04:32', 1),
(90, 'Settings', 1, 'information updated', '2021-07-04 12:04:47', '2021-07-04 12:04:47', 1),
(91, 'Settings', 1, 'information updated', '2021-07-04 12:05:04', '2021-07-04 12:05:04', 1),
(92, 'Aboutus', 1, 'information updated', '2021-07-04 12:05:44', '2021-07-04 12:05:44', 1),
(93, 'Aboutus', 1, 'Image is removed', '2021-07-04 12:05:50', '2021-07-04 12:05:50', 1),
(94, 'Aboutus', 1, 'information updated', '2021-07-04 12:05:58', '2021-07-04 12:05:58', 1),
(95, 'Ideas', 10, 'A new record is added. (10)', '2021-07-04 12:06:40', '2021-07-04 12:06:40', 1),
(96, 'Ideas', 10, 'Image is removed. (10)', '2021-07-04 12:07:08', '2021-07-04 12:07:08', 1),
(97, 'Ideas', 10, 'Record is edited. (10)', '2021-07-04 12:07:19', '2021-07-04 12:07:19', 1),
(98, 'Ideas', 10, 'A record is removed. (10)', '2021-07-04 12:07:34', '2021-07-04 12:07:34', 1),
(99, 'Ideas', 8, 'A record is removed. (8)', '2021-07-04 12:07:38', '2021-07-04 12:07:38', 1),
(100, 'Ideas', 7, 'A record is removed. (7)', '2021-07-04 12:07:42', '2021-07-04 12:07:42', 1),
(101, 'Ideas', 6, 'A record is removed. (6)', '2021-07-04 12:07:46', '2021-07-04 12:07:46', 1),
(102, 'Ideas', 5, 'A record is removed. (5)', '2021-07-04 12:07:50', '2021-07-04 12:07:50', 1),
(103, 'logout', 1, 'Administrator(admin) is logged out from Admin Panel.', '2021-07-04 12:12:17', '2021-07-04 12:12:17', 1),
(104, 'login', 1, 'Administrator(admin) is logged in to Admin Panel.', '2021-07-04 12:53:58', '2021-07-04 12:53:58', 1),
(105, 'role', 1, 'Role is edited to Admin', '2021-07-04 13:11:56', '2021-07-04 13:11:56', 1),
(106, 'role', 1, 'Role name is updated to Admin', '2021-07-04 13:12:04', '2021-07-04 13:12:04', 1),
(107, 'role', 1, 'Role is edited to Admin', '2021-07-04 13:12:04', '2021-07-04 13:12:04', 1),
(108, 'role', 1, 'Role is edited to Admin', '2021-07-04 13:16:11', '2021-07-04 13:16:11', 1),
(109, 'Notify Emails', 2, 'A new record is added. (2)', '2021-07-04 13:25:22', '2021-07-04 13:25:22', 1),
(110, 'Notify Emails', 3, 'A new record is added. (3)', '2021-07-04 13:25:40', '2021-07-04 13:25:40', 1),
(111, 'Notify Emails', 3, 'Record is edited. (3)', '2021-07-04 13:29:21', '2021-07-04 13:29:21', 1),
(112, 'Notify Emails', 3, 'Record is edited. (3)', '2021-07-04 13:31:03', '2021-07-04 13:31:03', 1),
(113, 'Notify Emails', 3, 'status is changed to 0 (3)', '2021-07-04 13:32:42', '2021-07-04 13:32:42', 1),
(114, 'Notify Emails', 3, 'status is changed to 1 (3)', '2021-07-04 13:32:44', '2021-07-04 13:32:44', 1),
(115, 'Notify Emails', 3, 'A record is removed. (3)', '2021-07-04 13:32:49', '2021-07-04 13:32:49', 1),
(116, 'Logs', 10, 'A record is removed. (10)', '2021-07-04 13:54:57', '2021-07-04 13:54:57', 1),
(117, 'Logs', 2, 'A record is removed. (2)', '2021-07-04 13:55:03', '2021-07-04 13:55:03', 1),
(118, 'Logs', 3, 'A record is removed. (3)', '2021-07-04 13:55:56', '2021-07-04 13:55:56', 1),
(119, 'user', 1, 'Status is changed to 0 for Administrator', '2021-07-04 14:10:29', '2021-07-04 14:10:29', 1),
(120, 'user', 1, 'Status is changed to 1 for Administrator', '2021-07-04 14:10:45', '2021-07-04 14:10:45', 1),
(121, 'role', 2, 'New Role is created as  role1', '2021-07-04 14:11:39', '2021-07-04 14:11:39', 1),
(122, 'user', 3, 'Account is created for name', '2021-07-04 14:12:53', '2021-07-04 14:12:53', 1),
(123, 'user', 3, 'Status is changed to 0 for name', '2021-07-04 14:12:59', '2021-07-04 14:12:59', 1),
(124, 'user', 3, 'Profile is updated for name', '2021-07-04 14:13:10', '2021-07-04 14:13:10', 1),
(125, 'user', 3, 'Password is changed for name1', '2021-07-04 14:13:55', '2021-07-04 14:13:55', 1),
(126, 'user', 3, 'Account is deleted for name1', '2021-07-04 14:14:06', '2021-07-04 14:14:06', 1),
(127, 'role', 1, 'Role is edited to Admin', '2021-07-04 14:14:21', '2021-07-04 14:14:21', 1),
(128, 'role', 2, 'Role is edited to role1', '2021-07-04 14:14:28', '2021-07-04 14:14:28', 1),
(129, 'role', 2, 'Role name is updated to role2', '2021-07-04 14:14:35', '2021-07-04 14:14:35', 1),
(130, 'role', 2, 'Role is edited to role2', '2021-07-04 14:14:35', '2021-07-04 14:14:35', 1),
(131, 'role', 3, 'New Role is created as  role 3', '2021-07-04 14:15:03', '2021-07-04 14:15:03', 1),
(132, 'role', 4, 'New Role is created as  role 4', '2021-07-04 14:16:45', '2021-07-04 14:16:45', 1),
(133, 'role', 5, 'New Role is created as  role6', '2021-07-04 14:17:25', '2021-07-04 14:17:25', 1),
(134, 'role', 1, 'Role is edited to Admin', '2021-07-04 14:37:27', '2021-07-04 14:37:27', 1),
(135, 'Subjects', 5, 'A new record is added. (5)', '2021-07-04 14:39:13', '2021-07-04 14:39:13', 1),
(136, 'Subjects', 6, 'A new record is added. (6)', '2021-07-04 14:39:31', '2021-07-04 14:39:31', 1),
(137, 'Subjects', 6, 'status is changed to 1 (6)', '2021-07-04 14:39:39', '2021-07-04 14:39:39', 1),
(138, 'Subjects', 6, 'status is changed to 0 (6)', '2021-07-04 14:39:42', '2021-07-04 14:39:42', 1),
(139, 'Subjects', 6, 'Record is edited. (6)', '2021-07-04 14:39:55', '2021-07-04 14:39:55', 1),
(140, 'Ideas', 11, 'A new record is added. (11)', '2021-07-04 14:40:53', '2021-07-04 14:40:53', 1),
(141, 'Subjects', 6, 'status is changed to 0 (6)', '2021-07-04 14:46:22', '2021-07-04 14:46:22', 1),
(142, 'Subjects', 6, 'A record is removed. (6)', '2021-07-04 14:46:28', '2021-07-04 14:46:28', 1),
(143, 'role', 1, 'Role is edited to Admin', '2021-07-04 15:02:59', '2021-07-04 15:02:59', 1),
(144, 'role', 1, 'Role name is updated to Admin', '2021-07-04 15:03:07', '2021-07-04 15:03:07', 1),
(145, 'role', 1, 'Role is edited to Admin', '2021-07-04 15:03:07', '2021-07-04 15:03:07', 1),
(146, 'Messages', 1, 'A record is removed. (1)', '2021-07-04 15:18:45', '2021-07-04 15:18:45', 1),
(147, 'role', 1, 'Role is edited to Admin', '2021-07-05 07:54:00', '2021-07-05 07:54:00', 1),
(148, 'role', 1, 'Role is edited to Admin', '2021-07-05 07:54:45', '2021-07-05 07:54:45', 1),
(149, 'role', 1, 'Role name is updated to Admin', '2021-07-05 07:54:51', '2021-07-05 07:54:51', 1),
(150, 'role', 1, 'Role is edited to Admin', '2021-07-05 07:54:51', '2021-07-05 07:54:51', 1),
(151, 'role', 1, 'Role is edited to Admin', '2021-07-05 07:56:53', '2021-07-05 07:56:53', 1),
(152, 'FAQ', 1, 'information updated', '2021-07-05 08:02:33', '2021-07-05 08:02:33', 1),
(153, 'FAQ', 1, 'information updated', '2021-07-05 08:02:48', '2021-07-05 08:02:48', 1),
(154, 'role', 1, 'Role is edited to Admin', '2021-07-05 08:14:47', '2021-07-05 08:14:47', 1),
(155, 'role', 1, 'Role name is updated to Admin', '2021-07-05 08:14:51', '2021-07-05 08:14:51', 1),
(156, 'role', 1, 'Role is edited to Admin', '2021-07-05 08:14:51', '2021-07-05 08:14:51', 1),
(157, 'Returns', 1, 'information updated', '2021-07-05 08:20:11', '2021-07-05 08:20:11', 1),
(158, 'role', 1, 'Role is edited to Admin', '2021-07-05 08:21:45', '2021-07-05 08:21:45', 1),
(159, 'role', 1, 'Role name is updated to Admin', '2021-07-05 08:21:50', '2021-07-05 08:21:50', 1),
(160, 'role', 1, 'Role is edited to Admin', '2021-07-05 08:21:50', '2021-07-05 08:21:50', 1),
(161, 'role', 1, 'Role is edited to Admin', '2021-07-05 08:24:51', '2021-07-05 08:24:51', 1),
(162, 'Our Mission', 1, 'information updated', '2021-07-05 08:30:13', '2021-07-05 08:30:13', 1),
(163, 'role', 1, 'Role is edited to Admin', '2021-07-05 08:31:50', '2021-07-05 08:31:50', 1),
(164, 'role', 1, 'Role name is updated to Admin', '2021-07-05 08:31:59', '2021-07-05 08:31:59', 1),
(165, 'role', 1, 'Role is edited to Admin', '2021-07-05 08:31:59', '2021-07-05 08:31:59', 1),
(166, 'Terms And Condition', 1, 'information updated', '2021-07-05 08:37:59', '2021-07-05 08:37:59', 1),
(167, 'role', 1, 'Role is edited to Admin', '2021-07-05 08:39:32', '2021-07-05 08:39:32', 1),
(168, 'role', 1, 'Role name is updated to Admin', '2021-07-05 08:39:36', '2021-07-05 08:39:36', 1),
(169, 'role', 1, 'Role is edited to Admin', '2021-07-05 08:39:37', '2021-07-05 08:39:37', 1),
(170, 'Giving back', 1, 'information updated', '2021-07-05 08:46:12', '2021-07-05 08:46:12', 1),
(171, 'Slideshows', 1, 'A new record is added. (1)', '2021-07-05 14:57:07', '2021-07-05 14:57:07', 1),
(172, 'Slideshows', 1, 'status is changed to 0 (1)', '2021-07-05 14:57:23', '2021-07-05 14:57:23', 1),
(173, 'Slideshows', 1, 'status is changed to 1 (1)', '2021-07-05 14:57:58', '2021-07-05 14:57:58', 1),
(174, 'Slideshows', 1, 'Record is edited. (1)', '2021-07-05 14:58:59', '2021-07-05 14:58:59', 1),
(175, 'Slideshows', 1, 'Image is removed. (1)', '2021-07-05 14:59:23', '2021-07-05 14:59:23', 1),
(176, 'Slideshows', 1, 'Record is edited. (1)', '2021-07-05 14:59:36', '2021-07-05 14:59:36', 1),
(177, 'Slideshows', 1, 'Record is edited. (1)', '2021-07-05 14:59:48', '2021-07-05 14:59:48', 1),
(178, 'Slideshows', 1, 'A record is removed. (1)', '2021-07-05 14:59:53', '2021-07-05 14:59:53', 1),
(179, 'role', 1, 'Role is edited to Admin', '2021-07-06 08:22:11', '2021-07-06 08:22:11', 1),
(180, 'role', 1, 'Role name is updated to Admin', '2021-07-06 08:22:18', '2021-07-06 08:22:18', 1),
(181, 'role', 1, 'Role is edited to Admin', '2021-07-06 08:22:18', '2021-07-06 08:22:18', 1),
(182, 'Single Pages', 1, 'A new record is added. (1)', '2021-07-06 08:23:31', '2021-07-06 08:23:31', 1),
(183, 'Single Pages', 2, 'A new record is added. (2)', '2021-07-06 08:23:54', '2021-07-06 08:23:54', 1),
(184, 'Single Pages', 3, 'A new record is added. (3)', '2021-07-06 08:24:22', '2021-07-06 08:24:22', 1),
(185, 'Single Pages', 3, 'Image is removed. (3)', '2021-07-06 08:25:14', '2021-07-06 08:25:14', 1),
(186, 'Single Pages', 3, 'Record is edited. (3)', '2021-07-06 08:25:18', '2021-07-06 08:25:18', 1),
(187, 'Single Pages', 3, 'Record is edited. (3)', '2021-07-06 08:25:45', '2021-07-06 08:25:45', 1),
(188, 'Single Pages', 3, 'Record is edited. (3)', '2021-07-06 08:26:13', '2021-07-06 08:26:13', 1),
(189, 'Single Pages', 3, 'A record is removed. (3)', '2021-07-06 08:30:49', '2021-07-06 08:30:49', 1),
(190, 'Single Pages', 2, 'A record is removed. (2)', '2021-07-06 08:30:53', '2021-07-06 08:30:53', 1),
(191, 'Single Pages', 1, 'A record is removed. (1)', '2021-07-06 08:30:57', '2021-07-06 08:30:57', 1),
(192, 'Single Pages', 4, 'A new record is added. (4)', '2021-07-06 08:31:36', '2021-07-06 08:31:36', 1),
(193, 'Single Pages', 5, 'A new record is added. (5)', '2021-07-06 08:32:01', '2021-07-06 08:32:01', 1),
(194, 'Single Pages', 6, 'A new record is added. (6)', '2021-07-06 08:32:35', '2021-07-06 08:32:35', 1),
(195, 'Single Pages', 6, 'Record is edited. (6)', '2021-07-06 08:32:59', '2021-07-06 08:32:59', 1),
(196, 'Single Pages', 7, 'A new record is added. (7)', '2021-07-06 08:33:28', '2021-07-06 08:33:28', 1),
(197, 'Single Pages', 8, 'A new record is added. (8)', '2021-07-06 08:33:54', '2021-07-06 08:33:54', 1),
(198, 'role', 1, 'Role is edited to Admin', '2021-07-06 09:19:57', '2021-07-06 09:19:57', 1),
(199, 'role', 1, 'Role is edited to Admin', '2021-07-06 14:41:42', '2021-07-06 14:41:42', 1),
(200, 'role', 1, 'Role is edited to Admin', '2021-07-06 14:53:58', '2021-07-06 14:53:58', 1),
(201, 'role', 1, 'Role name is updated to Admin', '2021-07-06 14:54:05', '2021-07-06 14:54:05', 1),
(202, 'role', 1, 'Role is edited to Admin', '2021-07-06 14:54:05', '2021-07-06 14:54:05', 1),
(203, 'Areas', 1, 'A new record is added. (1)', '2021-07-06 14:55:23', '2021-07-06 14:55:23', 1),
(204, 'Areas', 2, 'A new record is added. (2)', '2021-07-06 14:56:25', '2021-07-06 14:56:25', 1),
(205, 'Areas', 2, 'status is changed to 0 (2)', '2021-07-06 14:56:29', '2021-07-06 14:56:29', 1),
(206, 'Areas', 2, 'status is changed to 1 (2)', '2021-07-06 14:56:30', '2021-07-06 14:56:30', 1),
(207, 'Areas', 2, 'Record is edited. (2)', '2021-07-06 14:56:38', '2021-07-06 14:56:38', 1),
(208, 'Areas', 2, 'Record is edited. (2)', '2021-07-06 14:56:48', '2021-07-06 14:56:48', 1),
(209, 'Areas', 2, 'status is changed to 1 (2)', '2021-07-06 14:56:51', '2021-07-06 14:56:51', 1),
(210, 'Areas', 3, 'A new record is added. (3)', '2021-07-06 14:56:58', '2021-07-06 14:56:58', 1),
(211, 'Areas', 3, 'A record is removed. (3)', '2021-07-06 14:57:24', '2021-07-06 14:57:24', 1),
(212, 'Areas', 4, 'A new record is added. (4)', '2021-07-06 14:57:32', '2021-07-06 14:57:32', 1),
(213, 'role', 1, 'Role is edited to Admin', '2021-07-07 07:46:52', '2021-07-07 07:46:52', 1),
(214, 'role', 1, 'Role name is updated to Admin', '2021-07-07 07:46:58', '2021-07-07 07:46:58', 1),
(215, 'role', 1, 'Role is edited to Admin', '2021-07-07 07:46:58', '2021-07-07 07:46:58', 1),
(216, 'Areas', 5, 'A new record is added. (5)', '2021-07-07 07:52:05', '2021-07-07 07:52:05', 1),
(217, 'Areas', 6, 'A new record is added. (6)', '2021-07-07 08:21:54', '2021-07-07 08:21:54', 1),
(218, 'Areas', 6, 'status is changed to 1 (6)', '2021-07-07 08:21:59', '2021-07-07 08:21:59', 1),
(219, 'Areas', 6, 'Record is edited. (6)', '2021-07-07 08:23:06', '2021-07-07 08:23:06', 1),
(220, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-07-10 08:51:25', '2021-07-10 08:51:25', 1),
(221, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-07-10 09:01:10', '2021-07-10 09:01:10', 1),
(222, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-07-10 09:01:27', '2021-07-10 09:01:27', 1),
(223, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-07-10 09:01:37', '2021-07-10 09:01:37', 1),
(224, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-07-10 09:08:19', '2021-07-10 09:08:19', 1),
(225, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-07-10 09:09:24', '2021-07-10 09:09:24', 1),
(226, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-07-10 09:09:32', '2021-07-10 09:09:32', 1),
(227, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-07-10 11:12:11', '2021-07-10 11:12:11', 1),
(228, 'role', 1, 'Role is edited to Admin', '2021-07-10 12:24:03', '2021-07-10 12:24:03', 1),
(229, 'role', 1, 'Role name is updated to Admin', '2021-07-10 12:24:18', '2021-07-10 12:24:18', 1),
(230, 'role', 1, 'Role is edited to Admin', '2021-07-10 12:24:18', '2021-07-10 12:24:18', 1),
(231, 'role', 1, 'Role name is updated to Admin', '2021-07-10 12:24:32', '2021-07-10 12:24:32', 1),
(232, 'role', 1, 'Role is edited to Admin', '2021-07-10 12:24:32', '2021-07-10 12:24:32', 1),
(233, 'role', 1, 'Role is edited to Admin', '2021-07-10 14:01:31', '2021-07-10 14:01:31', 1),
(234, 'role', 1, 'Role name is updated to Admin', '2021-07-10 14:01:36', '2021-07-10 14:01:36', 1),
(235, 'role', 1, 'Role is edited to Admin', '2021-07-10 14:01:36', '2021-07-10 14:01:36', 1),
(236, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-07-11 08:01:33', '2021-07-11 08:01:33', 1),
(237, 'Admins', 2, 'A new record is added. (2)', '2021-07-11 08:17:52', '2021-07-11 08:17:52', 1),
(238, 'Admins', 2, 'status is changed to 0 (2)', '2021-07-11 08:18:15', '2021-07-11 08:18:15', 1),
(239, 'Admins', 2, 'status is changed to 1 (2)', '2021-07-11 08:18:45', '2021-07-11 08:18:45', 1),
(240, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-07-11 08:19:14', '2021-07-11 08:19:14', 1),
(241, 'login', 2, 'admin 1 is logged in to Admin Panel.', '2021-07-11 08:19:31', '2021-07-11 08:19:31', 2),
(242, 'Admins', 2, 'Record is edited. (2)', '2021-07-11 08:34:41', '2021-07-11 08:34:41', 2),
(243, 'Admins', 2, 'Record is edited. (2)', '2021-07-11 08:35:20', '2021-07-11 08:35:20', 2),
(244, 'admins', 2, 'Password is changed for admin 1', '2021-07-11 08:38:03', '2021-07-11 08:38:03', 2),
(245, 'admins', 2, 'Password is changed for admin 1', '2021-07-11 08:38:59', '2021-07-11 08:38:59', 2),
(246, 'logout', 2, 'admin 1 is logged out from Admin Panel.', '2021-07-11 08:39:25', '2021-07-11 08:39:25', 2),
(247, 'login', 2, 'admin 1 is logged in to Admin Panel.', '2021-07-11 08:39:57', '2021-07-11 08:39:57', 2),
(248, 'Admins', 2, 'Record is edited. (2)', '2021-07-11 17:32:06', '2021-07-11 17:32:06', 2),
(249, 'Admins', 2, 'Record is edited. (2)', '2021-07-11 17:32:36', '2021-07-11 17:32:36', 2),
(250, 'admins', 2, 'Password is changed for admin 1', '2021-07-11 17:33:47', '2021-07-11 17:33:47', 2),
(251, 'admins', 2, 'Password is changed for admin 1', '2021-07-11 17:35:14', '2021-07-11 17:35:14', 2),
(252, 'Admins', 2, 'A record is removed. (2)', '2021-07-11 17:39:30', '2021-07-11 17:39:30', 2),
(253, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-07-11 17:39:41', '2021-07-11 17:39:41', 1),
(254, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-07-12 07:52:10', '2021-07-12 07:52:10', 1),
(255, 'role', 1, 'Role is edited to Admin', '2021-07-12 08:05:36', '2021-07-12 08:05:36', 1),
(256, 'role', 1, 'Role name is updated to Admin', '2021-07-12 08:05:46', '2021-07-12 08:05:46', 1),
(257, 'role', 1, 'Role is edited to Admin', '2021-07-12 08:05:46', '2021-07-12 08:05:46', 1),
(258, 'role', 1, 'Role is edited to Admin', '2021-07-12 08:06:35', '2021-07-12 08:06:35', 1),
(259, 'Countries', 1, 'A new record is added. (1)', '2021-07-12 08:31:27', '2021-07-12 08:31:27', 1),
(260, 'Countries', 2, 'A new record is added. (2)', '2021-07-12 08:31:41', '2021-07-12 08:31:41', 1),
(261, 'Cities', 1, 'A new record is added. (1)', '2021-07-12 08:31:59', '2021-07-12 08:31:59', 1),
(262, 'Cities', 2, 'A new record is added. (2)', '2021-07-12 08:32:15', '2021-07-12 08:32:15', 1),
(263, 'Cities', 3, 'A new record is added. (3)', '2021-07-12 08:32:29', '2021-07-12 08:32:29', 1),
(264, 'Cities', 4, 'A new record is added. (4)', '2021-07-12 08:32:48', '2021-07-12 08:32:48', 1),
(265, 'Areas', 1, 'A new record is added. (1)', '2021-07-12 08:33:35', '2021-07-12 08:33:35', 1),
(266, 'Areas', 1, 'status is changed to 0 (1)', '2021-07-12 08:33:40', '2021-07-12 08:33:40', 1),
(267, 'Areas', 1, 'status is changed to 1 (1)', '2021-07-12 08:33:42', '2021-07-12 08:33:42', 1),
(268, 'Countries', 1, 'Record is edited. (1)', '2021-07-12 08:34:00', '2021-07-12 08:34:00', 1),
(269, 'Cities', 2, 'Record is edited. (2)', '2021-07-12 08:34:20', '2021-07-12 08:34:20', 1),
(270, 'Areas', 1, 'Record is edited. (1)', '2021-07-12 08:34:40', '2021-07-12 08:34:40', 1),
(271, 'Cities', 5, 'A new record is added. (5)', '2021-07-12 08:43:20', '2021-07-12 08:43:20', 1),
(272, 'Cities', 6, 'A new record is added. (6)', '2021-07-12 08:51:18', '2021-07-12 08:51:18', 1),
(273, 'Cities', 6, 'Record is edited. (6)', '2021-07-12 08:52:08', '2021-07-12 08:52:08', 1),
(274, 'Cities', 6, 'Record is edited. (6)', '2021-07-12 08:52:45', '2021-07-12 08:52:45', 1),
(275, 'Cities', 6, 'Record is edited. (6)', '2021-07-12 08:56:39', '2021-07-12 08:56:39', 1),
(276, 'Cities', 6, 'Record is edited. (6)', '2021-07-12 08:56:47', '2021-07-12 08:56:47', 1),
(277, 'Cities', 6, 'Record is edited. (6)', '2021-07-12 08:56:56', '2021-07-12 08:56:56', 1),
(278, 'Areas', 1, 'Record is edited. (1)', '2021-07-12 08:57:14', '2021-07-12 08:57:14', 1),
(279, 'Areas', 1, 'Record is edited. (1)', '2021-07-12 08:57:24', '2021-07-12 08:57:24', 1),
(280, 'Users', 1, 'A new record is added. (1)', '2021-07-12 12:32:34', '2021-07-12 12:32:34', 1),
(281, 'Users', 1, 'Record is edited. (1)', '2021-07-12 13:45:23', '2021-07-12 13:45:23', 1),
(282, 'Users', 1, 'status is changed to 0 (1)', '2021-07-12 13:59:33', '2021-07-12 13:59:33', 1),
(283, 'Users', 1, 'status is changed to 1 (1)', '2021-07-12 13:59:50', '2021-07-12 13:59:50', 1),
(284, 'Users', 1, 'status is changed to 0 (1)', '2021-07-12 14:00:11', '2021-07-12 14:00:11', 1),
(285, 'Users', 1, 'status is changed to 1 (1)', '2021-07-12 14:00:30', '2021-07-12 14:00:30', 1),
(286, 'Users', 1, 'status is changed to 0 (1)', '2021-07-12 14:01:17', '2021-07-12 14:01:17', 1),
(287, 'Users', 1, 'status is changed to 1 (1)', '2021-07-12 14:02:36', '2021-07-12 14:02:36', 1),
(288, 'Users', 1, 'newsletter status is changed to 0 (1)', '2021-07-12 14:02:44', '2021-07-12 14:02:44', 1),
(289, 'Users', 1, 'status is changed to 0 (1)', '2021-07-12 14:02:53', '2021-07-12 14:02:53', 1),
(290, 'Users', 1, 'newsletter status is changed to 1 (1)', '2021-07-12 14:03:04', '2021-07-12 14:03:04', 1),
(291, 'Users', 1, 'status is changed to 1 (1)', '2021-07-12 14:03:05', '2021-07-12 14:03:05', 1),
(292, 'admins', 1, 'Password is changed for Administrator', '2021-07-12 14:03:44', '2021-07-12 14:03:44', 1),
(293, 'admins', 1, 'Password is changed for Administrator', '2021-07-12 14:04:12', '2021-07-12 14:04:12', 1),
(294, 'Users', 1, 'Record is edited. (1)', '2021-07-12 14:04:33', '2021-07-12 14:04:33', 1),
(295, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-07-12 14:04:43', '2021-07-12 14:04:43', 1),
(296, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-07-12 14:04:59', '2021-07-12 14:04:59', 1),
(297, 'Users', 1, 'Record is edited. (1)', '2021-07-12 14:05:40', '2021-07-12 14:05:40', 1),
(298, 'Users', 1, 'A record is removed. (1)', '2021-07-12 14:06:02', '2021-07-12 14:06:02', 1),
(299, 'role', 2, 'New Role is created as  editor', '2021-07-12 14:09:39', '2021-07-12 14:09:39', 1),
(300, 'role', 2, 'Role is edited to editor', '2021-07-12 14:09:51', '2021-07-12 14:09:51', 1),
(301, 'role', 2, 'Role name is updated to editor', '2021-07-12 14:09:59', '2021-07-12 14:09:59', 1),
(302, 'role', 2, 'Role is edited to editor', '2021-07-12 14:09:59', '2021-07-12 14:09:59', 1),
(303, 'Admins', 3, 'A new record is added. (3)', '2021-07-12 14:10:44', '2021-07-12 14:10:44', 1),
(304, 'Admins', 3, 'A record is removed. (3)', '2021-07-12 14:12:04', '2021-07-12 14:12:04', 1),
(305, 'Admins', 1, 'Record is edited. (1)', '2021-07-12 14:12:21', '2021-07-12 14:12:21', 1),
(306, 'Admins', 1, 'Record is edited. (1)', '2021-07-12 14:12:47', '2021-07-12 14:12:47', 1),
(307, 'role', 1, 'Role is edited to Admin', '2021-07-12 14:18:46', '2021-07-12 14:18:46', 1),
(308, 'role', 1, 'Role name is updated to Admin', '2021-07-12 14:18:51', '2021-07-12 14:18:51', 1),
(309, 'role', 1, 'Role is edited to Admin', '2021-07-12 14:18:52', '2021-07-12 14:18:52', 1),
(310, 'Durations', 1, 'A new record is added. (1)', '2021-07-12 15:05:46', '2021-07-12 15:05:46', 1),
(311, 'Durations', 2, 'A new record is added. (2)', '2021-07-12 15:06:03', '2021-07-12 15:06:03', 1),
(312, 'Durations', 3, 'A new record is added. (3)', '2021-07-12 15:06:20', '2021-07-12 15:06:20', 1),
(313, 'Durations', 3, 'status is changed to 1 (3)', '2021-07-12 15:06:23', '2021-07-12 15:06:23', 1),
(314, 'Durations', 3, 'status is changed to 0 (3)', '2021-07-12 15:06:39', '2021-07-12 15:06:39', 1),
(315, 'Durations', 3, 'status is changed to 1 (3)', '2021-07-12 15:06:56', '2021-07-12 15:06:56', 1),
(316, 'Durations', 3, 'Record is edited. (3)', '2021-07-12 15:07:18', '2021-07-12 15:07:18', 1),
(317, 'Durations', 3, 'Record is edited. (3)', '2021-07-12 15:07:31', '2021-07-12 15:07:31', 1),
(318, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-07-13 07:51:09', '2021-07-13 07:51:09', 1),
(319, 'Countries', 3, 'A new record is added. (3)', '2021-07-13 08:03:39', '2021-07-13 08:03:39', 1),
(320, 'Cities', 7, 'A new record is added. (7)', '2021-07-13 08:04:10', '2021-07-13 08:04:10', 1),
(321, 'Areas', 2, 'A new record is added. (2)', '2021-07-13 08:04:37', '2021-07-13 08:04:37', 1),
(322, 'role', 1, 'Role is edited to Admin', '2021-07-13 08:49:20', '2021-07-13 08:49:20', 1),
(323, 'role', 1, 'Role name is updated to Admin', '2021-07-13 08:49:23', '2021-07-13 08:49:23', 1),
(324, 'role', 1, 'Role is edited to Admin', '2021-07-13 08:49:23', '2021-07-13 08:49:23', 1),
(325, 'role', 1, 'Role is edited to Admin', '2021-07-13 08:56:18', '2021-07-13 08:56:18', 1),
(326, 'role', 1, 'Role is edited to Admin', '2021-07-13 08:57:03', '2021-07-13 08:57:03', 1),
(327, 'SMS', 1, 'information updated', '2021-07-13 09:45:20', '2021-07-13 09:45:20', 1),
(328, 'SMS', 1, 'information updated', '2021-07-13 09:45:57', '2021-07-13 09:45:57', 1),
(329, 'SMS', 1, 'information updated', '2021-07-13 09:46:01', '2021-07-13 09:46:01', 1),
(330, 'SMS', 1, 'information updated', '2021-07-13 09:46:19', '2021-07-13 09:46:19', 1),
(331, 'SMS', 1, 'information updated', '2021-07-13 09:49:21', '2021-07-13 09:49:21', 1),
(332, 'SMS', 1, 'information updated', '2021-07-13 09:49:32', '2021-07-13 09:49:32', 1),
(333, 'Notify Emails', 2, 'status is changed to 0 (2)', '2021-07-13 09:50:07', '2021-07-13 09:50:07', 1),
(334, 'Notify Emails', 4, 'A new record is added. (4)', '2021-07-13 09:50:35', '2021-07-13 09:50:35', 1),
(335, 'Notify Emails', 4, 'status is changed to 1 (4)', '2021-07-13 09:50:52', '2021-07-13 09:50:52', 1),
(336, 'Notify Emails', 2, 'status is changed to 1 (2)', '2021-07-13 09:50:53', '2021-07-13 09:50:53', 1),
(337, 'Notify Emails', 4, 'Record is edited. (4)', '2021-07-13 09:51:03', '2021-07-13 09:51:03', 1),
(338, 'Notify Emails', 4, 'Record is edited. (4)', '2021-07-13 09:51:20', '2021-07-13 09:51:20', 1),
(339, 'Settings', 1, 'information updated', '2021-07-13 10:02:54', '2021-07-13 10:02:54', 1),
(340, 'Settings', 1, 'information updated', '2021-07-13 10:10:33', '2021-07-13 10:10:33', 1),
(341, 'Settings', 1, 'information updated', '2021-07-13 10:11:05', '2021-07-13 10:11:05', 1),
(342, 'Settings', 1, 'information updated', '2021-07-13 10:13:20', '2021-07-13 10:13:20', 1),
(343, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-07-14 08:53:49', '2021-07-14 08:53:49', 1),
(344, 'Roles', 4, 'A new record is added. (4)', '2021-07-14 11:23:39', '2021-07-14 11:23:39', 1),
(345, 'Roles', 4, 'A record is removed. (4)', '2021-07-14 11:24:06', '2021-07-14 11:24:06', 1),
(346, 'Admins', 1, 'Record is edited. (1)', '2021-07-14 12:44:59', '2021-07-14 12:44:59', 1),
(347, 'Roles', 3, 'A record is removed. (3)', '2021-07-14 12:53:17', '2021-07-14 12:53:17', 1),
(348, 'Roles', 5, 'A new record is added. (5)', '2021-07-14 12:55:03', '2021-07-14 12:55:03', 1),
(349, 'Admins', 1, 'Record is edited. (1)', '2021-07-14 12:55:21', '2021-07-14 12:55:21', 1),
(350, 'Admins', 1, 'Record is edited. (1)', '2021-07-14 12:56:32', '2021-07-14 12:56:32', 1),
(351, 'Roles', 5, 'Record is edited. (5)', '2021-07-14 12:56:50', '2021-07-14 12:56:50', 1),
(352, 'Admins', 1, 'Record is edited. (1)', '2021-07-14 12:57:04', '2021-07-14 12:57:04', 1),
(353, 'Admins', 1, 'Record is edited. (1)', '2021-07-14 12:57:23', '2021-07-14 12:57:23', 1),
(354, 'Roles', 5, 'A record is removed. (5)', '2021-07-14 12:58:05', '2021-07-14 12:58:05', 1),
(355, 'Roles', 1, 'Record is edited. (1)', '2021-07-17 08:11:59', '2021-07-17 08:11:59', 1),
(356, 'Packages', 1, 'A new record is added. (1)', '2021-07-17 09:29:29', '2021-07-17 09:29:29', 1),
(357, 'Packages', 1, 'status is changed to 0 (1)', '2021-07-17 09:31:00', '2021-07-17 09:31:00', 1),
(358, 'Packages', 1, 'Record is edited. (1)', '2021-07-17 09:31:24', '2021-07-17 09:31:24', 1),
(359, 'Countries', 1, 'Record is edited. (1)', '2021-07-18 11:06:11', '2021-07-18 11:06:11', 1),
(360, 'Countries', 2, 'Record is edited. (2)', '2021-07-18 11:06:24', '2021-07-18 11:06:24', 1),
(361, 'Countries', 3, 'Record is edited. (3)', '2021-07-18 11:06:34', '2021-07-18 11:06:34', 1),
(362, 'Countries', 2, 'Record is edited. (2)', '2021-07-18 11:06:44', '2021-07-18 11:06:44', 1),
(363, 'Countries', 2, 'Record is edited. (2)', '2021-07-18 11:06:52', '2021-07-18 11:06:52', 1),
(364, 'Countries', 2, 'Image is removed. (2)', '2021-07-18 11:06:58', '2021-07-18 11:06:58', 1),
(365, 'Countries', 2, 'Record is edited. (2)', '2021-07-18 11:07:05', '2021-07-18 11:07:05', 1),
(366, 'Cities', 2, 'Record is edited. (2)', '2021-07-18 11:20:46', '2021-07-18 11:20:46', 1),
(367, 'Cities', 1, 'Record is edited. (1)', '2021-07-18 11:21:27', '2021-07-18 11:21:27', 1),
(368, 'Cities', 1, 'Record is edited. (1)', '2021-07-18 11:21:54', '2021-07-18 11:21:54', 1),
(369, 'Areas', 1, 'Record is edited. (1)', '2021-07-18 11:27:23', '2021-07-18 11:27:23', 1),
(370, 'Areas', 2, 'Record is edited. (2)', '2021-07-18 11:27:38', '2021-07-18 11:27:38', 1),
(371, 'Cities', 2, 'Record is edited. (2)', '2021-07-18 11:28:00', '2021-07-18 11:28:00', 1),
(372, 'Countries', 1, 'Record is edited. (1)', '2021-07-18 12:09:22', '2021-07-18 12:09:22', 1),
(373, 'Countries', 2, 'Record is edited. (2)', '2021-07-18 12:09:36', '2021-07-18 12:09:36', 1),
(374, 'Countries', 3, 'Record is edited. (3)', '2021-07-18 12:09:45', '2021-07-18 12:09:45', 1),
(375, 'Cities', 6, 'Record is edited. (6)', '2021-07-18 12:10:38', '2021-07-18 12:10:38', 1),
(376, 'Cities', 6, 'Record is edited. (6)', '2021-07-18 12:10:47', '2021-07-18 12:10:47', 1),
(377, 'Cities', 2, 'Record is edited. (2)', '2021-07-18 12:11:03', '2021-07-18 12:11:03', 1),
(378, 'Cities', 5, 'Record is edited. (5)', '2021-07-18 12:11:19', '2021-07-18 12:11:19', 1),
(379, 'Cities', 5, 'Record is edited. (5)', '2021-07-18 12:11:56', '2021-07-18 12:11:56', 1),
(380, 'Roles', 1, 'Record is edited. (1)', '2021-07-18 15:12:25', '2021-07-18 15:12:25', 1),
(381, 'Roles', 1, 'Record is edited. (1)', '2021-07-19 08:03:04', '2021-07-19 08:03:04', 1),
(382, 'Packages', 2, 'A new record is added. (2)', '2021-07-19 08:13:54', '2021-07-19 08:13:54', 1),
(383, 'Package Galleries', 1, 'A new record is added. (1)', '2021-07-19 08:34:52', '2021-07-19 08:34:52', 1),
(384, 'Package Galleries', 1, 'status is changed to 0 (1)', '2021-07-19 08:39:00', '2021-07-19 08:39:00', 1),
(385, 'Package Galleries', 1, 'status is changed to 1 (1)', '2021-07-19 08:39:05', '2021-07-19 08:39:05', 1),
(386, 'Package Galleries', 1, 'Record is edited. (1)', '2021-07-19 08:40:01', '2021-07-19 08:40:01', 1),
(387, 'Package Galleries', 1, 'Record is edited. (1)', '2021-07-19 08:40:38', '2021-07-19 08:40:38', 1),
(388, 'Package Galleries', 1, 'Image is removed. (1)', '2021-07-19 08:41:03', '2021-07-19 08:41:03', 1),
(389, 'Package Galleries', 1, 'Record is edited. (1)', '2021-07-19 08:41:10', '2021-07-19 08:41:10', 1),
(390, 'Package Galleries', 2, 'A new record is added. (2)', '2021-07-19 08:42:13', '2021-07-19 08:42:13', 1),
(391, 'Package Galleries', 2, 'Record is edited. (2)', '2021-07-19 08:42:34', '2021-07-19 08:42:34', 1),
(392, 'Packages', 1, 'status is changed to 1 (1)', '2021-07-19 08:59:26', '2021-07-19 08:59:26', 1),
(393, 'Roles', 1, 'Record is edited. (1)', '2021-07-19 10:25:51', '2021-07-19 10:25:51', 1),
(394, 'Coupons', 1, 'A new record is added. (1)', '2021-07-19 12:24:14', '2021-07-19 12:24:14', 1),
(395, 'Coupons', 1, 'status is changed to 1 (1)', '2021-07-19 12:34:05', '2021-07-19 12:34:05', 1),
(396, 'Coupons', 2, 'A new record is added. (2)', '2021-07-19 12:43:11', '2021-07-19 12:43:11', 1),
(397, 'Coupons', 3, 'A new record is added. (3)', '2021-07-19 12:44:34', '2021-07-19 12:44:34', 1),
(398, 'Coupons', 3, 'Record is edited. (3)', '2021-07-19 12:59:53', '2021-07-19 12:59:53', 1),
(399, 'Single Pages', 8, 'A record is removed. (8)', '2021-07-19 14:16:56', '2021-07-19 14:16:56', 1),
(400, 'Single Pages', 1, 'A new record is added. (1)', '2021-07-19 14:18:25', '2021-07-19 14:18:25', 1),
(401, 'Notify Emails', 4, 'A record is removed. (4)', '2021-07-19 14:18:48', '2021-07-19 14:18:48', 1),
(402, 'Settings', 1, 'information updated', '2021-07-19 14:27:43', '2021-07-19 14:27:43', 1),
(403, 'Roles', 1, 'Record is edited. (1)', '2021-07-20 08:36:58', '2021-07-20 08:36:58', 1),
(404, 'Roles', 1, 'Record is edited. (1)', '2021-07-31 08:05:19', '2021-07-31 08:05:19', 1),
(405, 'Packages', 3, 'A new record is added. (3)', '2021-08-11 10:49:27', '2021-08-11 10:49:27', 1),
(406, 'Packages', 3, 'Record is edited. (3)', '2021-08-11 10:49:45', '2021-08-11 10:49:45', 1),
(407, 'Packages', 3, 'Record is edited. (3)', '2021-08-11 10:49:57', '2021-08-11 10:49:57', 1),
(408, 'Packages', 1, 'Record is edited. (1)', '2021-08-11 11:13:37', '2021-08-11 11:13:37', 1),
(409, 'Packages', 2, 'Record is edited. (2)', '2021-08-11 11:14:52', '2021-08-11 11:14:52', 1),
(410, 'Packages', 3, 'A record is removed. (3)', '2021-08-11 11:15:16', '2021-08-11 11:15:16', 1),
(411, 'Single Pages', 1, 'Record is edited. (1)', '2021-08-14 14:56:29', '2021-08-14 14:56:29', 1),
(412, 'Single Pages', 1, 'Record is edited. (1)', '2021-08-14 14:58:18', '2021-08-14 14:58:18', 1),
(413, 'Single Pages', 1, 'Record is edited. (1)', '2021-08-14 15:08:02', '2021-08-14 15:08:02', 1),
(414, 'Roles', 1, 'Record is edited. (1)', '2021-08-16 07:41:08', '2021-08-16 07:41:08', 1),
(415, 'Settings', 1, 'information updated', '2021-08-16 15:11:45', '2021-08-16 15:11:45', 1),
(416, 'Cities', 5, 'Record is edited. (5)', '2021-08-16 16:15:48', '2021-08-16 16:15:48', 1),
(417, 'Cities', 1, 'Record is edited. (1)', '2021-08-16 16:16:02', '2021-08-16 16:16:02', 1),
(418, 'Cities', 2, 'Record is edited. (2)', '2021-08-16 16:16:12', '2021-08-16 16:16:12', 1),
(419, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-08-21 12:20:19', '2021-08-21 12:20:19', 1),
(420, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-11 10:06:20', '2021-09-11 10:06:20', 1),
(421, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-09-12 10:05:07', '2021-09-12 10:05:07', 1),
(422, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-12 10:05:12', '2021-09-12 10:05:12', 1),
(423, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-13 07:57:24', '2021-09-13 07:57:24', 1),
(424, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-13 13:50:55', '2021-09-13 13:50:55', 1),
(425, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-14 10:51:21', '2021-09-14 10:51:21', 1),
(426, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-15 08:31:06', '2021-09-15 08:31:06', 1),
(427, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-16 08:06:42', '2021-09-16 08:06:42', 1),
(428, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-16 10:56:00', '2021-09-16 10:56:00', 1),
(429, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-18 08:41:39', '2021-09-18 08:41:39', 1),
(430, 'Users', 2, 'A new record is added. (2)', '2021-09-18 10:50:40', '2021-09-18 10:50:40', 1),
(431, 'Users', 2, 'Record is edited. (2)', '2021-09-18 11:11:09', '2021-09-18 11:11:09', 1),
(432, 'Users', 2, 'Record is edited. (2)', '2021-09-18 11:11:27', '2021-09-18 11:11:27', 1),
(433, 'Users', 2, 'Record is edited. (2)', '2021-09-18 11:12:18', '2021-09-18 11:12:18', 1),
(434, 'users', 2, 'Password is changed for ', '2021-09-18 11:46:54', '2021-09-18 11:46:54', 1),
(435, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-19 08:08:36', '2021-09-19 08:08:36', 1),
(436, 'Users', 2, 'A new record is added. (2)', '2021-09-19 09:19:07', '2021-09-19 09:19:07', 1),
(437, 'Users', 3, 'A new record is added. (3)', '2021-09-19 09:19:46', '2021-09-19 09:19:46', 1),
(438, 'Users', 4, 'A new record is added. (4)', '2021-09-19 09:20:59', '2021-09-19 09:20:59', 1),
(439, 'Users', 5, 'A new record is added. (5)', '2021-09-19 09:22:38', '2021-09-19 09:22:38', 1),
(440, 'Users', 6, 'A new record is added. (6)', '2021-09-19 09:32:30', '2021-09-19 09:32:30', 1),
(441, 'Users', 4, 'A record is removed. (4)', '2021-09-19 09:50:13', '2021-09-19 09:50:13', 1),
(442, 'Users', 7, 'A new record is added. (7)', '2021-09-19 09:50:24', '2021-09-19 09:50:24', 1),
(443, 'Users', 7, 'Record is edited. (7)', '2021-09-19 11:46:20', '2021-09-19 11:46:20', 1),
(444, 'Users', 7, 'Record is edited. (7)', '2021-09-19 11:46:51', '2021-09-19 11:46:51', 1),
(445, 'Users', 7, 'Record is edited. (7)', '2021-09-19 11:47:44', '2021-09-19 11:47:44', 1),
(446, 'Users', 7, 'Record is edited. (7)', '2021-09-19 11:48:31', '2021-09-19 11:48:31', 1),
(447, 'Users', 7, 'Record is edited. (7)', '2021-09-19 11:48:49', '2021-09-19 11:48:49', 1),
(448, 'Users', 7, 'Record is edited. (7)', '2021-09-19 12:05:33', '2021-09-19 12:05:33', 1),
(449, 'Users', 7, 'Record is edited. (7)', '2021-09-19 12:09:20', '2021-09-19 12:09:20', 1),
(450, 'Users', 8, 'A new record is added. (8)', '2021-09-19 12:12:49', '2021-09-19 12:12:49', 1),
(451, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-19 14:25:53', '2021-09-19 14:25:53', 1),
(452, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-20 08:16:36', '2021-09-20 08:16:36', 1),
(453, 'Slideshows', 1, 'A new record is added. (1)', '2021-09-20 11:29:23', '2021-09-20 11:29:23', 1),
(454, 'Slideshows', 1, 'Record is edited. (1)', '2021-09-20 13:33:52', '2021-09-20 13:33:52', 1),
(455, 'Slideshows', 1, 'A record is removed. (1)', '2021-09-20 13:37:04', '2021-09-20 13:37:04', 1),
(456, 'Slideshows', 2, 'A new record is added. (2)', '2021-09-20 13:38:17', '2021-09-20 13:38:17', 1),
(457, 'Slideshows', 2, 'Record is edited. (2)', '2021-09-20 13:39:12', '2021-09-20 13:39:12', 1),
(458, 'Slideshows', 2, 'Record is edited. (2)', '2021-09-20 13:39:36', '2021-09-20 13:39:36', 1),
(459, 'Slideshows', 2, 'Record is edited. (2)', '2021-09-20 14:08:18', '2021-09-20 14:08:18', 1),
(460, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-21 08:42:49', '2021-09-21 08:42:49', 1),
(461, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-22 11:12:49', '2021-09-22 11:12:49', 1),
(462, 'Single Pages', 2, 'A new record is added. (2)', '2021-09-22 16:23:25', '2021-09-22 16:23:25', 1),
(463, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-23 09:02:55', '2021-09-23 09:02:55', 1),
(464, 'Single Pages', 2, 'Record is edited. (2)', '2021-09-23 10:40:02', '2021-09-23 10:40:02', 1),
(465, 'Single Pages', 2, 'Record is edited. (2)', '2021-09-23 10:40:37', '2021-09-23 10:40:37', 1),
(466, 'Single Pages', 2, 'Record is edited. (2)', '2021-09-23 10:50:23', '2021-09-23 10:50:23', 1),
(467, 'Single Pages', 2, 'Record is edited. (2)', '2021-09-23 10:58:54', '2021-09-23 10:58:54', 1),
(468, 'Single Pages', 2, 'Record is edited. (2)', '2021-09-23 10:59:38', '2021-09-23 10:59:38', 1),
(469, 'Single Pages', 2, 'Record is edited. (2)', '2021-09-23 11:31:31', '2021-09-23 11:31:31', 1),
(470, 'Single Pages', 2, 'Record is edited. (2)', '2021-09-23 11:38:35', '2021-09-23 11:38:35', 1),
(471, 'Single Pages', 1, 'Record is edited. (1)', '2021-09-23 11:51:31', '2021-09-23 11:51:31', 1),
(472, 'Single Pages', 1, 'Record is edited. (1)', '2021-09-23 11:53:06', '2021-09-23 11:53:06', 1),
(473, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-25 09:09:28', '2021-09-25 09:09:28', 1),
(474, 'Single Pages', 1, 'Record is edited. (1)', '2021-09-25 09:14:27', '2021-09-25 09:14:27', 1),
(475, 'Single Pages', 1, 'Record is edited. (1)', '2021-09-25 10:02:07', '2021-09-25 10:02:07', 1),
(476, 'Single Pages', 3, 'A new record is added. (3)', '2021-09-25 11:22:47', '2021-09-25 11:22:47', 1),
(477, 'Single Pages', 4, 'A new record is added. (4)', '2021-09-25 14:48:34', '2021-09-25 14:48:34', 1),
(478, 'Single Pages', 4, 'Record is edited. (4)', '2021-09-25 14:52:34', '2021-09-25 14:52:34', 1),
(479, 'Single Pages', 5, 'A new record is added. (5)', '2021-09-25 14:54:39', '2021-09-25 14:54:39', 1),
(480, 'Settings', 1, 'information updated', '2021-09-25 14:59:28', '2021-09-25 14:59:28', 1),
(481, 'Settings', 1, 'information updated', '2021-09-25 15:10:52', '2021-09-25 15:10:52', 1),
(482, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-26 09:08:16', '2021-09-26 09:08:16', 1),
(483, 'Single Pages', 1, 'Record is edited. (1)', '2021-09-26 09:18:05', '2021-09-26 09:18:05', 1),
(484, 'Single Pages', 2, 'Record is edited. (2)', '2021-09-26 09:18:32', '2021-09-26 09:18:32', 1),
(485, 'Single Pages', 3, 'Record is edited. (3)', '2021-09-26 09:20:19', '2021-09-26 09:20:19', 1),
(486, 'Single Pages', 4, 'Record is edited. (4)', '2021-09-26 10:42:43', '2021-09-26 10:42:43', 1),
(487, 'Single Pages', 5, 'Record is edited. (5)', '2021-09-26 10:44:00', '2021-09-26 10:44:00', 1),
(488, 'Settings', 1, 'information updated', '2021-09-26 12:15:33', '2021-09-26 12:15:33', 1),
(489, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-28 11:12:45', '2021-09-28 11:12:45', 1),
(490, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-09-28 11:26:46', '2021-09-28 11:26:46', 1),
(491, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-09-28 12:45:58', '2021-09-28 12:45:58', 1),
(492, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-09-28 13:49:45', '2021-09-28 13:49:45', 1),
(493, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-02 16:05:03', '2021-10-02 16:05:03', 1),
(494, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-10-02 16:16:33', '2021-10-02 16:16:33', 1),
(495, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-03 11:32:29', '2021-10-03 11:32:29', 1),
(496, 'Users', 7, 'A record is removed. (7)', '2021-10-03 12:22:56', '2021-10-03 12:22:56', 1),
(497, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-03 14:33:45', '2021-10-03 14:33:45', 1),
(498, 'Single Pages', 1, 'status is changed to 0 (1)', '2021-10-03 15:45:10', '2021-10-03 15:45:10', 1),
(499, 'Single Pages', 2, 'status is changed to 0 (2)', '2021-10-03 15:45:18', '2021-10-03 15:45:18', 1),
(500, 'Single Pages', 3, 'status is changed to 0 (3)', '2021-10-03 15:45:21', '2021-10-03 15:45:21', 1),
(501, 'Single Pages', 3, 'status is changed to 1 (3)', '2021-10-03 15:45:24', '2021-10-03 15:45:24', 1),
(502, 'Single Pages', 2, 'status is changed to 1 (2)', '2021-10-03 15:45:25', '2021-10-03 15:45:25', 1),
(503, 'Single Pages', 1, 'status is changed to 1 (1)', '2021-10-03 15:45:25', '2021-10-03 15:45:25', 1),
(504, 'Cities', 1, 'status is changed to 0 (1)', '2021-10-03 15:45:34', '2021-10-03 15:45:34', 1),
(505, 'Cities', 2, 'status is changed to 0 (2)', '2021-10-03 15:45:35', '2021-10-03 15:45:35', 1),
(506, 'Cities', 3, 'status is changed to 0 (3)', '2021-10-03 15:45:35', '2021-10-03 15:45:35', 1),
(507, 'Cities', 3, 'status is changed to 1 (3)', '2021-10-03 15:45:40', '2021-10-03 15:45:40', 1),
(508, 'Cities', 2, 'status is changed to 1 (2)', '2021-10-03 15:45:40', '2021-10-03 15:45:40', 1),
(509, 'Cities', 1, 'status is changed to 1 (1)', '2021-10-03 15:45:41', '2021-10-03 15:45:41', 1),
(510, 'Single Pages', 1, 'status is changed to 0 (1)', '2021-10-03 16:09:04', '2021-10-03 16:09:04', 1),
(511, 'Single Pages', 1, 'status is changed to 1 (1)', '2021-10-03 16:09:11', '2021-10-03 16:09:11', 1),
(512, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-04 08:57:37', '2021-10-04 08:57:37', 1),
(513, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-10-04 11:03:13', '2021-10-04 11:03:13', 1),
(514, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-04 11:11:44', '2021-10-04 11:11:44', 1);
INSERT INTO `gwc_logs` (`id`, `key_name`, `key_id`, `message`, `created_at`, `updated_at`, `created_by`) VALUES
(515, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-10-04 11:12:38', '2021-10-04 11:12:38', 1),
(516, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-07 12:56:15', '2021-10-07 12:56:15', 1),
(517, 'Single Pages', 6, 'A new record is added. (6)', '2021-10-07 12:56:33', '2021-10-07 12:56:33', 1),
(518, 'Single Pages', 6, 'Record is edited. (6)', '2021-10-07 12:56:57', '2021-10-07 12:56:57', 1),
(519, 'Single Pages', 6, 'A record is removed. (6)', '2021-10-07 12:57:51', '2021-10-07 12:57:51', 1),
(520, 'Single Pages', 7, 'A new record is added. (7)', '2021-10-07 12:58:48', '2021-10-07 12:58:48', 1),
(521, 'Single Pages', 7, 'Record is edited. (7)', '2021-10-07 12:59:05', '2021-10-07 12:59:05', 1),
(522, 'Single Pages', 7, 'A record is removed. (7)', '2021-10-07 12:59:13', '2021-10-07 12:59:13', 1),
(523, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-10-07 13:08:23', '2021-10-07 13:08:23', 1),
(524, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-07 14:38:21', '2021-10-07 14:38:21', 1),
(525, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-10-07 15:41:02', '2021-10-07 15:41:02', 1),
(526, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-12 10:56:14', '2021-10-12 10:56:14', 1),
(527, 'Countries', 4, 'A new record is added. (4)', '2021-10-12 11:22:25', '2021-10-12 11:22:25', 1),
(528, 'Countries', 5, 'A new record is added. (5)', '2021-10-12 11:22:48', '2021-10-12 11:22:48', 1),
(529, 'Countries', 5, 'A record is removed. (5)', '2021-10-12 11:23:05', '2021-10-12 11:23:05', 1),
(530, 'Countries', 4, 'A record is removed. (4)', '2021-10-12 11:27:43', '2021-10-12 11:27:43', 1),
(531, 'Cities', 8, 'A new record is added. (8)', '2021-10-12 12:19:58', '2021-10-12 12:19:58', 1),
(532, 'Cities', 9, 'A new record is added. (9)', '2021-10-12 12:20:57', '2021-10-12 12:20:57', 1),
(533, 'Cities', 9, 'A record is removed. (9)', '2021-10-12 12:21:27', '2021-10-12 12:21:27', 1),
(534, 'Cities', 8, 'A record is removed. (8)', '2021-10-12 12:21:32', '2021-10-12 12:21:32', 1),
(535, 'Cities', 1, 'Record is edited. (1)', '2021-10-12 12:36:41', '2021-10-12 12:36:41', 1),
(536, 'Cities', 1, 'Record is edited. (1)', '2021-10-12 12:41:33', '2021-10-12 12:41:33', 1),
(537, 'Cities', 1, 'Record is edited. (1)', '2021-10-12 12:42:32', '2021-10-12 12:42:32', 1),
(538, 'Cities', 1, 'Record is edited. (1)', '2021-10-12 12:43:06', '2021-10-12 12:43:06', 1),
(539, 'Cities', 10, 'A new record is added. (10)', '2021-10-12 12:45:27', '2021-10-12 12:45:27', 1),
(540, 'Cities', 11, 'A new record is added. (11)', '2021-10-12 12:46:32', '2021-10-12 12:46:32', 1),
(541, 'Cities', 12, 'A new record is added. (12)', '2021-10-12 12:46:48', '2021-10-12 12:46:48', 1),
(542, 'Cities', 12, 'A record is removed. (12)', '2021-10-12 12:52:04', '2021-10-12 12:52:04', 1),
(543, 'Cities', 11, 'A record is removed. (11)', '2021-10-12 12:52:10', '2021-10-12 12:52:10', 1),
(544, 'Cities', 13, 'A new record is added. (13)', '2021-10-12 12:52:41', '2021-10-12 12:52:41', 1),
(545, 'Cities', 1, 'Record is edited. (1)', '2021-10-12 12:59:53', '2021-10-12 12:59:53', 1),
(546, 'Cities', 1, 'Record is edited. (1)', '2021-10-12 13:00:27', '2021-10-12 13:00:27', 1),
(547, 'Cities', 13, 'Record is edited. (13)', '2021-10-12 13:00:58', '2021-10-12 13:00:58', 1),
(548, 'Cities', 10, 'Record is edited. (10)', '2021-10-12 13:02:01', '2021-10-12 13:02:01', 1),
(549, 'Cities', 14, 'A new record is added. (14)', '2021-10-12 13:02:42', '2021-10-12 13:02:42', 1),
(550, 'Cities', 14, 'Record is edited. (14)', '2021-10-12 13:03:50', '2021-10-12 13:03:50', 1),
(551, 'Cities', 14, 'A record is removed. (14)', '2021-10-12 13:03:56', '2021-10-12 13:03:56', 1),
(552, 'Areas', 3, 'A new record is added. (3)', '2021-10-12 13:54:57', '2021-10-12 13:54:57', 1),
(553, 'Areas', 3, 'Record is edited. (3)', '2021-10-12 14:01:52', '2021-10-12 14:01:52', 1),
(554, 'Areas', 4, 'A new record is added. (4)', '2021-10-12 14:03:50', '2021-10-12 14:03:50', 1),
(555, 'Areas', 4, 'Record is edited. (4)', '2021-10-12 14:04:01', '2021-10-12 14:04:01', 1),
(556, 'Areas', 4, 'Record is edited. (4)', '2021-10-12 14:04:11', '2021-10-12 14:04:11', 1),
(557, 'Areas', 4, 'A record is removed. (4)', '2021-10-12 14:05:52', '2021-10-12 14:05:52', 1),
(558, 'Areas', 5, 'A new record is added. (5)', '2021-10-12 14:06:17', '2021-10-12 14:06:17', 1),
(559, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-13 09:14:15', '2021-10-13 09:14:15', 1),
(560, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-13 10:04:03', '2021-10-13 10:04:03', 1),
(561, 'Countries', 6, 'A new record is added. (6)', '2021-10-13 10:12:22', '2021-10-13 10:12:22', 1),
(562, 'Cities', 15, 'A new record is added. (15)', '2021-10-13 10:12:34', '2021-10-13 10:12:34', 1),
(563, 'Areas', 6, 'A new record is added. (6)', '2021-10-13 10:12:44', '2021-10-13 10:12:44', 1),
(564, 'Areas', 6, 'A record is removed. (6)', '2021-10-13 10:12:59', '2021-10-13 10:12:59', 1),
(565, 'Cities', 15, 'A record is removed. (15)', '2021-10-13 10:13:11', '2021-10-13 10:13:11', 1),
(566, 'Countries', 6, 'A record is removed. (6)', '2021-10-13 10:13:19', '2021-10-13 10:13:19', 1),
(567, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-13 13:45:04', '2021-10-13 13:45:04', 1),
(568, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-13 14:01:48', '2021-10-13 14:01:48', 1),
(569, 'Countries', 3, 'A record is removed. (3)', '2021-10-13 14:07:58', '2021-10-13 14:07:58', 1),
(570, 'Countries', 1, 'A record is removed. (1)', '2021-10-13 14:08:17', '2021-10-13 14:08:17', 1),
(571, 'Single Pages', 8, 'A new record is added. (8)', '2021-10-13 14:16:52', '2021-10-13 14:16:52', 1),
(572, 'Single Pages', 9, 'A new record is added. (9)', '2021-10-13 14:17:22', '2021-10-13 14:17:22', 1),
(573, 'Single Pages', 10, 'A new record is added. (10)', '2021-10-13 14:18:20', '2021-10-13 14:18:20', 1),
(574, 'Single Pages', 11, 'A new record is added. (11)', '2021-10-13 14:19:35', '2021-10-13 14:19:35', 1),
(575, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-13 14:56:08', '2021-10-13 14:56:08', 1),
(576, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-10-13 15:53:28', '2021-10-13 15:53:28', 1),
(577, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-14 09:21:36', '2021-10-14 09:21:36', 1),
(578, 'Single Pages', 10, 'Record is edited. (10)', '2021-10-14 09:28:50', '2021-10-14 09:28:50', 1),
(579, 'Single Pages', 10, 'Record is edited. (10)', '2021-10-14 09:29:56', '2021-10-14 09:29:56', 1),
(580, 'Single Pages', 10, 'Record is edited. (10)', '2021-10-14 09:33:55', '2021-10-14 09:33:55', 1),
(581, 'Single Pages', 11, 'Record is edited. (11)', '2021-10-14 09:37:30', '2021-10-14 09:37:30', 1),
(582, 'Single Pages', 10, 'Record is edited. (10)', '2021-10-14 09:37:53', '2021-10-14 09:37:53', 1),
(583, 'Single Pages', 10, 'Record is edited. (10)', '2021-10-14 09:38:21', '2021-10-14 09:38:21', 1),
(584, 'Single Pages', 11, 'Record is edited. (11)', '2021-10-14 09:38:57', '2021-10-14 09:38:57', 1),
(585, 'Single Pages', 10, 'Record is edited. (10)', '2021-10-14 09:39:13', '2021-10-14 09:39:13', 1),
(586, 'Single Pages', 11, 'Record is edited. (11)', '2021-10-14 09:55:39', '2021-10-14 09:55:39', 1),
(587, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-17 08:59:33', '2021-10-17 08:59:33', 1),
(588, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-17 11:01:50', '2021-10-17 11:01:50', 1),
(589, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-17 11:23:05', '2021-10-17 11:23:05', 1),
(590, 'Slideshows', 3, 'A new record is added. (3)', '2021-10-17 12:54:44', '2021-10-17 12:54:44', 1),
(591, 'Slideshows', 2, 'Record is edited. (2)', '2021-10-17 13:11:03', '2021-10-17 13:11:03', 1),
(592, 'Users', 2, 'Record is edited. (2)', '2021-10-17 16:02:41', '2021-10-17 16:02:41', 1),
(593, 'Users', 2, 'Record is edited. (2)', '2021-10-17 16:02:55', '2021-10-17 16:02:55', 1),
(594, 'Users', 3, 'A new record is added. (3)', '2021-10-17 16:03:21', '2021-10-17 16:03:21', 1),
(595, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-18 09:04:10', '2021-10-18 09:04:10', 1),
(596, 'Freelancers', 20, 'status is changed to 1 (20)', '2021-10-18 09:57:04', '2021-10-18 09:57:04', 1),
(597, 'Freelancers', 7, 'status is changed to 1 (7)', '2021-10-18 09:57:11', '2021-10-18 09:57:11', 1),
(598, 'Freelancers', 7, 'status is changed to 0 (7)', '2021-10-18 09:57:15', '2021-10-18 09:57:15', 1),
(599, 'Freelancers', 19, 'status is changed to 1 (19)', '2021-10-18 09:59:35', '2021-10-18 09:59:35', 1),
(600, 'Freelancers', 7, 'status is changed to 1 (7)', '2021-10-18 09:59:36', '2021-10-18 09:59:36', 1),
(601, 'Freelancers', 22, 'status is changed to 1 (22)', '2021-10-18 09:59:37', '2021-10-18 09:59:37', 1),
(602, 'Slideshows', 3, 'Record is edited. (3)', '2021-10-18 10:00:01', '2021-10-18 10:00:01', 1),
(603, 'Slideshows', 3, 'status is changed to 1 (3)', '2021-10-18 10:01:31', '2021-10-18 10:01:31', 1),
(604, 'Slideshows', 2, 'status is changed to 1 (2)', '2021-10-18 10:01:41', '2021-10-18 10:01:41', 1),
(605, 'Packages', 4, 'status is changed to 1 (4)', '2021-10-18 10:04:06', '2021-10-18 10:04:06', 1),
(606, 'Packages', 2, 'status is changed to 1 (2)', '2021-10-18 10:04:08', '2021-10-18 10:04:08', 1),
(607, 'Packages', 2, 'status is changed to 0 (2)', '2021-10-18 10:04:11', '2021-10-18 10:04:11', 1),
(608, 'Categories', 8, 'status is changed to 1 (8)', '2021-10-18 10:07:16', '2021-10-18 10:07:16', 1),
(609, 'Categories', 8, 'status is changed to 0 (8)', '2021-10-18 10:07:16', '2021-10-18 10:07:16', 1),
(610, 'Categories', 8, 'status is changed to 1 (8)', '2021-10-18 10:07:18', '2021-10-18 10:07:18', 1),
(611, 'Categories', 15, 'status is changed to 1 (15)', '2021-10-18 10:07:23', '2021-10-18 10:07:23', 1),
(612, 'Categories', 16, 'status is changed to 1 (16)', '2021-10-18 10:07:24', '2021-10-18 10:07:24', 1),
(613, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-18 21:42:32', '2021-10-18 21:42:32', 1),
(614, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-21 12:50:38', '2021-10-21 12:50:38', 1),
(615, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-22 12:37:32', '2021-10-22 12:37:32', 1),
(616, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-23 09:47:09', '2021-10-23 09:47:09', 1),
(617, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-10-23 15:33:48', '2021-10-23 15:33:48', 1),
(618, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-08 09:41:17', '2021-11-08 09:41:17', 1),
(619, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-08 13:18:18', '2021-11-08 13:18:18', 1),
(620, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-09 08:49:22', '2021-11-09 08:49:22', 1),
(621, 'Areas', 7, 'A new record is added. (7)', '2021-11-09 08:54:24', '2021-11-09 08:54:24', 1),
(622, 'Users', 9, 'A new record is added. (9)', '2021-11-09 09:47:18', '2021-11-09 09:47:18', 1),
(623, 'Users', 10, 'A new record is added. (10)', '2021-11-09 09:50:25', '2021-11-09 09:50:25', 1),
(624, 'Users', 10, 'Record is edited. (10)', '2021-11-09 10:51:55', '2021-11-09 10:51:55', 1),
(625, 'Users', 10, 'Record is edited. (10)', '2021-11-09 10:54:10', '2021-11-09 10:54:10', 1),
(626, 'Users', 10, 'Record is edited. (10)', '2021-11-09 10:54:42', '2021-11-09 10:54:42', 1),
(627, 'Users', 10, 'Record is edited. (10)', '2021-11-09 10:56:36', '2021-11-09 10:56:36', 1),
(628, 'Users', 10, 'Record is edited. (10)', '2021-11-09 11:05:11', '2021-11-09 11:05:11', 1),
(629, 'Users', 9, 'A record is removed. (9)', '2021-11-09 11:17:09', '2021-11-09 11:17:09', 1),
(630, 'Users', 8, 'A record is removed. (8)', '2021-11-09 11:17:15', '2021-11-09 11:17:15', 1),
(631, 'Users', 11, 'A new record is added. (11)', '2021-11-09 11:24:05', '2021-11-09 11:24:05', 1),
(632, 'Users', 11, 'A record is removed. (11)', '2021-11-09 11:24:11', '2021-11-09 11:24:11', 1),
(633, 'Users', 10, 'Record is edited. (10)', '2021-11-09 11:24:42', '2021-11-09 11:24:42', 1),
(634, 'Users', 10, 'A record is removed. (10)', '2021-11-09 11:24:48', '2021-11-09 11:24:48', 1),
(635, 'Freelancers', 7, 'status is changed to 0 (7)', '2021-11-09 13:35:50', '2021-11-09 13:35:50', 1),
(636, 'Freelancers', 7, 'status is changed to 1 (7)', '2021-11-09 13:35:52', '2021-11-09 13:35:52', 1),
(637, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-10 09:39:37', '2021-11-10 09:39:37', 1),
(638, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-11-10 10:47:11', '2021-11-10 10:47:11', 1),
(639, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-10 10:47:44', '2021-11-10 10:47:44', 1),
(640, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-11 08:58:09', '2021-11-11 08:58:09', 1),
(641, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-13 09:09:37', '2021-11-13 09:09:37', 1),
(642, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-14 08:50:51', '2021-11-14 08:50:51', 1),
(643, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-14 12:04:16', '2021-11-14 12:04:16', 1),
(644, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-15 09:08:04', '2021-11-15 09:08:04', 1),
(645, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-15 12:09:08', '2021-11-15 12:09:08', 1),
(646, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-16 15:53:03', '2021-11-16 15:53:03', 1),
(647, 'Roles', 2, 'A new record is added. (2)', '2021-11-16 15:54:01', '2021-11-16 15:54:01', 1),
(648, 'Admins', 4, 'A new record is added. (4)', '2021-11-16 15:55:09', '2021-11-16 15:55:09', 1),
(649, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-11-16 15:55:15', '2021-11-16 15:55:15', 1),
(650, 'login', 4, 'taghi is logged in to Admin Panel.', '2021-11-16 15:55:22', '2021-11-16 15:55:22', 4),
(651, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-28 21:08:05', '2021-11-28 21:08:05', 1),
(652, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-11-29 20:12:34', '2021-11-29 20:12:34', 1),
(653, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-07 12:39:01', '2021-12-07 12:39:01', 1),
(654, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-07 16:00:46', '2021-12-07 16:00:46', 1),
(655, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-07 16:00:56', '2021-12-07 16:00:56', 1),
(656, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-07 16:15:49', '2021-12-07 16:15:49', 1),
(657, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-07 16:15:52', '2021-12-07 16:15:52', 1),
(658, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-07 16:15:53', '2021-12-07 16:15:53', 1),
(659, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-07 16:15:57', '2021-12-07 16:15:57', 1),
(660, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-07 16:26:48', '2021-12-07 16:26:48', 1),
(661, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-07 16:26:49', '2021-12-07 16:26:49', 1),
(662, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-08 09:24:47', '2021-12-08 09:24:47', 1),
(663, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-08 09:27:47', '2021-12-08 09:27:47', 1),
(664, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-08 09:27:48', '2021-12-08 09:27:48', 1),
(665, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-16 22:34:05', '2021-12-16 22:34:05', 1),
(666, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-16 23:50:05', '2021-12-16 23:50:05', 1),
(667, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-16 23:50:11', '2021-12-16 23:50:11', 1),
(668, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-17 00:16:35', '2021-12-17 00:16:35', 1),
(669, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-17 00:16:42', '2021-12-17 00:16:42', 1),
(670, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-17 00:16:45', '2021-12-17 00:16:45', 1),
(671, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-17 00:17:02', '2021-12-17 00:17:02', 1),
(672, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-17 00:17:08', '2021-12-17 00:17:08', 1),
(673, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-17 00:17:17', '2021-12-17 00:17:17', 1),
(674, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-17 00:17:18', '2021-12-17 00:17:18', 1),
(675, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-17 00:17:19', '2021-12-17 00:17:19', 1),
(676, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-17 00:17:26', '2021-12-17 00:17:26', 1),
(677, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-17 00:17:33', '2021-12-17 00:17:33', 1),
(678, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-17 00:18:01', '2021-12-17 00:18:01', 1),
(679, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-17 00:18:40', '2021-12-17 00:18:40', 1),
(680, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-17 00:18:58', '2021-12-17 00:18:58', 1),
(681, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-17 00:22:12', '2021-12-17 00:22:12', 1),
(682, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-17 00:22:17', '2021-12-17 00:22:17', 1),
(683, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-17 00:22:21', '2021-12-17 00:22:21', 1),
(684, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-17 00:22:25', '2021-12-17 00:22:25', 1),
(685, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-18 00:06:53', '2021-12-18 00:06:53', 1),
(686, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-18 09:05:17', '2021-12-18 09:05:17', 1),
(687, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-18 13:21:54', '2021-12-18 13:21:54', 1),
(688, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-18 13:22:01', '2021-12-18 13:22:01', 1),
(689, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-19 09:14:54', '2021-12-19 09:14:54', 1),
(690, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-19 09:17:18', '2021-12-19 09:17:18', 1),
(691, 'Freelancer Address', 1, 'A new record is added. (1)', '2021-12-19 09:31:01', '2021-12-19 09:31:01', 1),
(692, 'Freelancer Address', 2, 'A new record is added. (2)', '2021-12-19 09:32:48', '2021-12-19 09:32:48', 1),
(693, 'Freelancer Address', 1, 'Record is edited. (1)', '2021-12-19 09:38:21', '2021-12-19 09:38:21', 1),
(694, 'Freelancer Address', 1, 'Record is edited. (1)', '2021-12-19 09:38:47', '2021-12-19 09:38:47', 1),
(695, 'Freelancer Address', 1, 'Record is edited. (1)', '2021-12-19 09:39:22', '2021-12-19 09:39:22', 1),
(696, 'Freelancer Address', 1, 'Record is edited. (1)', '2021-12-19 09:39:42', '2021-12-19 09:39:42', 1),
(697, 'Freelancer Address', 1, 'A record is removed. (1)', '2021-12-19 09:42:35', '2021-12-19 09:42:35', 1),
(698, 'Free lancer service', 20, 'highlight is changed', '2021-12-19 10:36:29', '2021-12-19 10:36:29', 1),
(699, 'Free lancer service', 20, 'Free lancer service status is changed', '2021-12-19 10:36:30', '2021-12-19 10:36:30', 1),
(700, 'Free lancer service', 20, 'highlight is changed', '2021-12-19 10:36:35', '2021-12-19 10:36:35', 1),
(701, 'Free lancer service', 20, 'Free lancer service status is changed', '2021-12-19 10:36:36', '2021-12-19 10:36:36', 1),
(702, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-19 14:42:58', '2021-12-19 14:42:58', 1),
(703, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-19 14:42:59', '2021-12-19 14:42:59', 1),
(704, 'freelancer Workshops', 4, 'status is changed to 0 (4)', '2021-12-19 14:43:00', '2021-12-19 14:43:00', 1),
(705, 'freelancer Workshops', 4, 'status is changed to 1 (4)', '2021-12-19 14:43:01', '2021-12-19 14:43:01', 1),
(706, 'WebPushs', 1, 'A new WebPush is added.()', '2021-12-19 16:10:04', '2021-12-19 16:10:04', 1),
(707, 'Freelancers', 20, 'status is changed to 0 (20)', '2021-12-19 16:12:57', '2021-12-19 16:12:57', 1),
(708, 'Freelancers', 20, 'status is changed to 1 (20)', '2021-12-19 16:12:57', '2021-12-19 16:12:57', 1),
(709, 'Logs', 4, 'A record is removed. (4)', '2021-12-19 16:13:18', '2021-12-19 16:13:18', 1),
(710, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-20 09:10:34', '2021-12-20 09:10:34', 1),
(711, 'Quotation Orders', 1, 'A record is removed. (1)', '2021-12-20 10:53:33', '2021-12-20 10:53:33', 1),
(712, 'Freelancers', 22, 'status is changed to 0 (22)', '2021-12-20 11:08:40', '2021-12-20 11:08:40', 1),
(713, 'Freelancers', 22, 'status is changed to 1 (22)', '2021-12-20 11:08:46', '2021-12-20 11:08:46', 1),
(714, 'Categories', 13, 'status is changed to 0 (13)', '2021-12-20 15:14:46', '2021-12-20 15:14:46', 1),
(715, 'Categories', 13, 'status is changed to 1 (13)', '2021-12-20 15:14:48', '2021-12-20 15:14:48', 1),
(716, 'Single Pages', 1, 'status is changed to 0 (1)', '2021-12-20 15:15:02', '2021-12-20 15:15:02', 1),
(717, 'Single Pages', 1, 'status is changed to 1 (1)', '2021-12-20 15:15:03', '2021-12-20 15:15:03', 1),
(718, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-21 10:03:42', '2021-12-21 10:03:42', 1),
(719, 'WebPushs', 1, 'A WebPush token is removed.(42ea16ad4eed74539157a5)', '2021-12-22 13:06:01', '2021-12-22 13:06:01', 1),
(720, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-22 16:02:56', '2021-12-22 16:02:56', 1),
(721, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-23 11:17:12', '2021-12-23 11:17:12', 1),
(722, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-25 09:02:07', '2021-12-25 09:02:07', 1),
(723, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-25 09:48:00', '2021-12-25 09:48:00', 1),
(724, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-12-25 10:41:42', '2021-12-25 10:41:42', 1),
(725, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-25 10:56:16', '2021-12-25 10:56:16', 1),
(726, 'logout', 1, 'Administrator is logged out from Admin Panel.', '2021-12-25 11:42:13', '2021-12-25 11:42:13', 1),
(727, 'login', 1, 'Administrator is logged in to Admin Panel.', '2021-12-26 13:54:57', '2021-12-26 13:54:57', 1),
(728, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-02 10:40:52', '2022-01-02 10:40:52', 1),
(729, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-04 12:03:50', '2022-01-04 12:03:50', 1),
(730, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-08 09:06:13', '2022-01-08 09:06:13', 1),
(731, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-10 10:30:11', '2022-01-10 10:30:11', 1),
(732, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-11 09:22:09', '2022-01-11 09:22:09', 1),
(733, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-11 12:09:38', '2022-01-11 12:09:38', 1),
(734, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-12 09:38:15', '2022-01-12 09:38:15', 1),
(735, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-12 10:16:00', '2022-01-12 10:16:00', 1),
(736, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-12 15:04:26', '2022-01-12 15:04:26', 1),
(737, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-13 09:20:00', '2022-01-13 09:20:00', 1),
(738, 'Meetings', 2, 'A new record is added. (2)', '2022-01-13 12:00:01', '2022-01-13 12:00:01', 1),
(739, 'Meetings', 3, 'A new record is added. (3)', '2022-01-13 12:00:50', '2022-01-13 12:00:50', 1),
(740, 'Meetings', 4, 'A new record is added. (4)', '2022-01-13 12:26:45', '2022-01-13 12:26:45', 1),
(741, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-15 09:24:01', '2022-01-15 09:24:01', 1),
(742, 'Meetings', 5, 'A new record is added. (5)', '2022-01-15 10:13:19', '2022-01-15 10:13:19', 1),
(743, 'Meetings', 6, 'A new record is added. (6)', '2022-01-15 12:41:08', '2022-01-15 12:41:08', 1),
(744, 'Meetings', 2, 'Record is edited. (2)', '2022-01-15 13:03:00', '2022-01-15 13:03:00', 1),
(745, 'Meetings', 2, 'Record is edited. (2)', '2022-01-15 13:03:56', '2022-01-15 13:03:56', 1),
(746, 'Meetings', 2, 'Record is edited. (2)', '2022-01-15 13:04:16', '2022-01-15 13:04:16', 1),
(747, 'Meetings', 2, 'Record is edited. (2)', '2022-01-15 13:05:44', '2022-01-15 13:05:44', 1),
(748, 'Meetings', 2, 'Record is edited. (2)', '2022-01-15 13:05:59', '2022-01-15 13:05:59', 1),
(749, 'Meetings', 2, 'Record is edited. (2)', '2022-01-15 13:07:39', '2022-01-15 13:07:39', 1),
(750, 'Meetings', 2, 'Record is edited. (2)', '2022-01-15 13:09:17', '2022-01-15 13:09:17', 1),
(751, 'Meetings', 7, 'A new record is added. (7)', '2022-01-15 13:16:54', '2022-01-15 13:16:54', 1),
(752, 'Meetings', 2, 'Record is edited. (2)', '2022-01-15 13:23:35', '2022-01-15 13:23:35', 1),
(753, 'Meetings', 2, 'Record is edited. (2)', '2022-01-15 13:23:54', '2022-01-15 13:23:54', 1),
(754, 'Meetings', 2, 'Record is edited. (2)', '2022-01-15 13:24:11', '2022-01-15 13:24:11', 1),
(755, 'Meetings', 8, 'A new record is added. (8)', '2022-01-15 13:24:27', '2022-01-15 13:24:27', 1),
(756, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-16 09:04:34', '2022-01-16 09:04:34', 1),
(757, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-17 09:22:22', '2022-01-17 09:22:22', 1),
(758, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-17 14:24:50', '2022-01-17 14:24:50', 1),
(759, 'Freelancer Address', 6, 'A new record is added. (6)', '2022-01-17 17:15:27', '2022-01-17 17:15:27', 1),
(760, 'Freelancer Address', 6, 'A record is removed. (6)', '2022-01-17 17:15:32', '2022-01-17 17:15:32', 1),
(761, 'Meetings', 13, 'A new record is added. (13)', '2022-01-17 17:16:05', '2022-01-17 17:16:05', 1),
(762, 'freelancer Workshops', 6, 'status is changed to 1 (6)', '2022-01-17 17:19:24', '2022-01-17 17:19:24', 1),
(763, 'Users', 21, 'Record is edited. (21)', '2022-01-17 17:34:30', '2022-01-17 17:34:30', 1),
(764, 'Subjects', 2, 'A new record is added. (2)', '2022-01-17 17:34:49', '2022-01-17 17:34:49', 1),
(765, 'Subjects', 2, 'A record is removed. (2)', '2022-01-17 17:34:54', '2022-01-17 17:34:54', 1),
(766, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-18 11:08:31', '2022-01-18 11:08:31', 1),
(767, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-19 11:55:50', '2022-01-19 11:55:50', 1),
(768, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-23 11:17:11', '2022-01-23 11:17:11', 1),
(769, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-24 09:33:35', '2022-01-24 09:33:35', 1),
(770, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-25 11:28:10', '2022-01-25 11:28:10', 1),
(771, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-26 15:15:22', '2022-01-26 15:15:22', 1),
(772, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-01-29 10:53:00', '2022-01-29 10:53:00', 1),
(773, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-01 10:49:18', '2022-02-01 10:49:18', 1),
(774, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-01 11:38:51', '2022-02-01 11:38:51', 1),
(775, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-01 11:47:00', '2022-02-01 11:47:00', 1),
(776, 'Single Pages', 12, 'A new record is added. (12)', '2022-02-01 12:18:52', '2022-02-01 12:18:52', 1),
(777, 'Single Pages', 12, 'Record is edited. (12)', '2022-02-01 12:19:38', '2022-02-01 12:19:38', 1),
(778, 'Slideshows', 3, 'Record is edited. (3)', '2022-02-01 12:49:14', '2022-02-01 12:49:14', 1),
(779, 'Slideshows', 3, 'Record is edited. (3)', '2022-02-01 12:53:10', '2022-02-01 12:53:10', 1),
(780, 'Packages', 2, 'status is changed to 1 (2)', '2022-02-01 14:12:02', '2022-02-01 14:12:02', 1),
(781, 'Freelancer Address', 18, 'A new record is added. (18)', '2022-02-01 14:13:41', '2022-02-01 14:13:41', 1),
(782, 'freelancer Workshops', 10, 'status is changed to 1 (10)', '2022-02-01 14:27:16', '2022-02-01 14:27:16', 1),
(783, 'Users', 28, 'Record is edited. (28)', '2022-02-01 14:33:15', '2022-02-01 14:33:15', 1),
(784, 'Users', 24, 'A record is removed. (24)', '2022-02-01 14:33:40', '2022-02-01 14:33:40', 1),
(785, 'Users', 26, 'A record is removed. (26)', '2022-02-01 14:33:46', '2022-02-01 14:33:46', 1),
(786, 'Users', 27, 'Record is edited. (27)', '2022-02-01 14:36:19', '2022-02-01 14:36:19', 1),
(787, 'Users', 30, 'A new record is added. (30)', '2022-02-01 14:45:50', '2022-02-01 14:45:50', 1),
(788, 'Users', 30, 'Record is edited. (30)', '2022-02-01 14:46:08', '2022-02-01 14:46:08', 1),
(789, 'Users', 25, 'A record is removed. (25)', '2022-02-01 14:48:08', '2022-02-01 14:48:08', 1),
(790, 'Users', 26, 'A record is removed. (26)', '2022-02-01 14:48:13', '2022-02-01 14:48:13', 1),
(791, 'Users', 27, 'A record is removed. (27)', '2022-02-01 14:48:18', '2022-02-01 14:48:18', 1),
(792, 'Users', 28, 'A record is removed. (28)', '2022-02-01 14:48:23', '2022-02-01 14:48:23', 1),
(793, 'Users', 29, 'A record is removed. (29)', '2022-02-01 14:48:29', '2022-02-01 14:48:29', 1),
(794, 'Roles', 2, 'A record is removed. (2)', '2022-02-01 16:10:42', '2022-02-01 16:10:42', 1),
(795, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-01 16:25:04', '2022-02-01 16:25:04', 1),
(796, 'Single Pages', 13, 'A new record is added. (13)', '2022-02-01 16:25:40', '2022-02-01 16:25:40', 1),
(797, 'Single Pages', 13, 'Record is edited. (13)', '2022-02-01 16:25:48', '2022-02-01 16:25:48', 1),
(798, 'Single Pages', 13, 'A record is removed. (13)', '2022-02-01 16:25:55', '2022-02-01 16:25:55', 1),
(799, 'Slideshows', 4, 'A new record is added. (4)', '2022-02-01 16:28:10', '2022-02-01 16:28:10', 1),
(800, 'Slideshows', 4, 'Record is edited. (4)', '2022-02-01 16:28:20', '2022-02-01 16:28:20', 1),
(801, 'Slideshows', 4, 'Record is edited. (4)', '2022-02-01 16:28:38', '2022-02-01 16:28:38', 1),
(802, 'Slideshows', 4, 'Record is edited. (4)', '2022-02-01 16:28:45', '2022-02-01 16:28:45', 1),
(803, 'Slideshows', 4, 'A record is removed. (4)', '2022-02-01 16:29:06', '2022-02-01 16:29:06', 1),
(804, 'Slideshows', 3, 'Record is edited. (3)', '2022-02-01 16:30:03', '2022-02-01 16:30:03', 1),
(805, 'Freelancer Address', 19, 'A new record is added. (19)', '2022-02-01 16:33:00', '2022-02-01 16:33:00', 1),
(806, 'Freelancer Address', 19, 'Record is edited. (19)', '2022-02-01 16:33:13', '2022-02-01 16:33:13', 1),
(807, 'freelancer Workshops', 11, 'status is changed to 1 (11)', '2022-02-01 16:36:43', '2022-02-01 16:36:43', 1),
(808, 'freelancer Workshops', 11, 'status is changed to 0 (11)', '2022-02-01 16:36:44', '2022-02-01 16:36:44', 1),
(809, 'Users', 46, 'A new record is added. (46)', '2022-02-01 16:42:02', '2022-02-01 16:42:02', 1),
(810, 'Users', 46, 'Record is edited. (46)', '2022-02-01 16:42:38', '2022-02-01 16:42:38', 1),
(811, 'Users', 31, 'A new record is added. (31)', '2022-02-01 16:43:18', '2022-02-01 16:43:18', 1),
(812, 'Users', 46, 'A record is removed. (46)', '2022-02-01 16:44:09', '2022-02-01 16:44:09', 1),
(813, 'Subjects', 3, 'A new record is added. (3)', '2022-02-01 16:44:29', '2022-02-01 16:44:29', 1),
(814, 'Subjects', 3, 'Record is edited. (3)', '2022-02-01 16:44:35', '2022-02-01 16:44:35', 1),
(815, 'Subjects', 3, 'A record is removed. (3)', '2022-02-01 16:44:39', '2022-02-01 16:44:39', 1),
(816, 'Slideshows', 3, 'A record is removed. (3)', '2022-02-01 16:48:46', '2022-02-01 16:48:46', 1),
(817, 'Slideshows', 5, 'A new record is added. (5)', '2022-02-01 16:49:06', '2022-02-01 16:49:06', 1),
(818, 'Slideshows', 5, 'Record is edited. (5)', '2022-02-01 16:49:22', '2022-02-01 16:49:22', 1),
(819, 'Slideshows', 5, 'Record is edited. (5)', '2022-02-01 16:49:34', '2022-02-01 16:49:34', 1),
(820, 'Slideshows', 5, 'A record is removed. (5)', '2022-02-01 16:49:41', '2022-02-01 16:49:41', 1),
(821, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-01 16:52:22', '2022-02-01 16:52:22', 1),
(822, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-02 09:19:07', '2022-02-02 09:19:07', 1),
(823, 'Slideshows', 2, 'Record is edited. (2)', '2022-02-02 09:25:17', '2022-02-02 09:25:17', 1),
(824, 'Slideshows', 2, 'Record is edited. (2)', '2022-02-02 09:42:21', '2022-02-02 09:42:21', 1),
(825, 'Slideshows', 2, 'Record is edited. (2)', '2022-02-02 09:42:51', '2022-02-02 09:42:51', 1),
(826, 'Single Pages', 10, 'Record is edited. (10)', '2022-02-02 10:12:19', '2022-02-02 10:12:19', 1),
(827, 'Single Pages', 10, 'Record is edited. (10)', '2022-02-02 10:13:25', '2022-02-02 10:13:25', 1),
(828, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-08 12:13:06', '2022-02-08 12:13:06', 1),
(829, 'Settings', 1, 'information updated', '2022-02-08 12:14:26', '2022-02-08 12:14:26', 1),
(830, 'Settings', 1, 'information updated', '2022-02-08 12:14:36', '2022-02-08 12:14:36', 1),
(831, 'Settings', 1, 'information updated', '2022-02-08 12:15:15', '2022-02-08 12:15:15', 1),
(832, 'Settings', 1, 'information updated', '2022-02-08 12:15:59', '2022-02-08 12:15:59', 1),
(833, 'Settings', 1, 'information updated', '2022-02-08 12:16:21', '2022-02-08 12:16:21', 1),
(834, 'Settings', 1, 'information updated', '2022-02-08 12:17:49', '2022-02-08 12:17:49', 1),
(835, 'Settings', 1, 'information updated', '2022-02-08 12:22:17', '2022-02-08 12:22:17', 1),
(836, 'Settings', 1, 'information updated', '2022-02-08 12:22:24', '2022-02-08 12:22:24', 1),
(837, 'Settings', 1, 'information updated', '2022-02-08 12:55:04', '2022-02-08 12:55:04', 1),
(838, 'Settings', 1, 'information updated', '2022-02-08 12:56:03', '2022-02-08 12:56:03', 1),
(839, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-09 09:01:43', '2022-02-09 09:01:43', 1),
(840, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-09 11:44:15', '2022-02-09 11:44:15', 1),
(841, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-14 11:01:46', '2022-02-14 11:01:46', 1),
(842, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-14 11:06:54', '2022-02-14 11:06:54', 1),
(843, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-19 10:18:13', '2022-02-19 10:18:13', 1),
(844, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-21 11:05:15', '2022-02-21 11:05:15', 1),
(845, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-21 19:16:27', '2022-02-21 19:16:27', 1),
(846, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-02-23 17:28:38', '2022-02-23 17:28:38', 1),
(847, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-03-03 09:30:21', '2022-03-03 09:30:21', 1),
(848, 'login', 1, 'Administrator is logged in to Admin Panel.', '2022-03-03 09:54:22', '2022-03-03 09:54:22', 1),
(849, 'Users', 44, 'Record is edited. (44)', '2022-03-03 09:57:38', '2022-03-03 09:57:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gwc_menus`
--

CREATE TABLE `gwc_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `display_order` int(11) DEFAULT NULL,
  `is_active` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `gwc_menus`
--

INSERT INTO `gwc_menus` (`id`, `name`, `link`, `icon`, `parent_id`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'home', 'flaticon-squares', 0, 1, 1, '2020-01-15 14:00:21', '2020-01-28 14:00:37'),
(3, 'Components', 'javascript:;', 'flaticon2-information', 0, 2, 1, '2020-01-15 14:07:33', '2020-04-03 14:42:20'),
(11, 'System', 'javascript:;', 'flaticon2-gear', 0, 8, 1, '2020-01-16 06:47:21', '2020-01-16 06:47:25'),
(12, 'General Settings', 'settings', 'flaticon2-gear', 11, 1, 1, '2020-01-16 06:48:00', '2020-02-17 04:45:13'),
(15, 'Roles', 'roles', 'test', 11, 9, 1, '2020-01-30 13:22:49', '2020-07-09 04:08:28'),
(16, 'Contact us', 'javascript:;', 'flaticon-email', 0, 5, 1, '2020-02-26 03:49:10', '2020-02-29 03:50:50'),
(17, 'Subjects', 'subjects', 'list', 16, 1, 1, '2020-02-29 03:51:51', '2020-02-29 04:15:16'),
(18, 'Messages', 'messages', 'list', 16, 2, 1, '2020-02-29 03:52:18', '2020-02-29 04:15:30'),
(22, 'Slideshows', 'slideshows', 'flaticon2-information', 3, 3, 0, '2020-03-03 04:03:04', '2020-04-03 14:47:08'),
(26, 'Logs', 'logs', 'logs', 11, 6, 1, '2020-03-16 12:54:42', '2020-07-09 04:07:52'),
(36, 'Notify Emails', 'notifyemails', '1', 11, 1, 1, '2020-04-27 05:56:19', '2020-09-21 15:02:45'),
(38, 'Notification', 'javascript:;', 'flaticon2-notification', 0, 6, 1, '2020-06-08 07:55:03', '2021-02-08 07:00:31'),
(39, 'Send Notifications', 'webpush', 'list', 38, 1, 1, '2020-06-08 07:59:54', '2021-02-08 07:00:32'),
(40, 'Device Tokens', 'webpush/devicetokens', 'li', 38, 2, 1, '2020-06-08 13:26:49', '2021-02-08 07:00:32'),
(57, 'Menus', 'menus', 'flaticon-more-1', 0, 5, 0, '2021-05-16 05:33:02', '2021-05-16 05:33:02'),
(58, 'Career', 'career', '', 3, 8, 0, '2021-05-17 09:19:12', '2021-05-17 09:19:12'),
(71, 'About Us', 'aboutus', '', 67, 1, 0, '2021-06-09 06:48:20', '2021-06-09 06:48:20'),
(80, 'Pages', 'singlepages', '', 3, 1, 1, '2021-07-05 12:02:28', '2021-07-05 12:02:28'),
(81, 'Areas', 'areas', '', 3, 7, 0, '2021-07-06 11:39:39', '2021-07-06 11:39:39'),
(82, 'Countries', 'countries', '', 11, 2, 1, '2021-07-06 11:40:10', '2021-07-06 11:40:10'),
(84, 'Users', 'admins', '', 11, 6, 1, '2021-07-10 08:26:33', '2021-07-10 08:26:33'),
(86, 'SMS Settings', 'sms', '', 11, 4, 0, '2021-07-13 05:56:15', '2021-07-13 05:56:15'),
(88, 'Package Galleries', 'packagegalleries', '', 3, 10, 0, '2021-07-18 12:11:45', '2021-07-18 12:11:45'),
(89, 'Coupons', 'coupons', '', 3, 11, 0, '2021-07-19 06:07:35', '2021-07-19 06:07:35'),
(90, 'Freelancer Subscriptions', 'orders', '', 108, 2, 1, '2021-07-20 05:34:30', '2021-07-20 05:34:30'),
(93, 'Categories', 'categories', '', 3, 4, 1, NULL, NULL),
(101, 'Users', 'users', '', 111, 3, 1, '2021-07-06 11:40:10', '2021-07-06 11:40:10'),
(102, 'Freelancers', 'freelancers', '', 111, 1, 1, '2021-07-06 11:40:10', '2021-07-06 11:40:10'),
(103, 'Slideshow', 'slideshows', '', 3, 3, 1, '2021-07-06 11:40:10', '2021-07-06 11:40:10'),
(104, 'Package', 'packages', '', 3, 12, 1, '2021-07-06 11:40:10', '2021-07-06 11:40:10'),
(105, 'How It Works', 'howitworks', '', 3, 2, 1, '2021-07-06 11:40:10', '2021-07-06 11:40:10'),
(107, 'Payment Logs', 'user-payments', '', 108, 5, 0, '2021-07-06 11:40:10', '2021-07-06 11:40:10'),
(108, 'Sales', 'javascript:;', 'flaticon2-shopping-cart', 0, 7, 1, NULL, NULL),
(109, 'Services Orders', 'services-orders', '', 108, 1, 1, NULL, NULL),
(110, 'Workshops', 'workshops', '', 115, 2, 1, NULL, NULL),
(111, 'Users', 'javascript:;', 'flaticon-users-1', 0, 4, 1, NULL, NULL),
(112, 'Workshop Orders', 'workshop-orders', '', 108, 4, 1, NULL, NULL),
(113, 'Quotation Orders', 'quotation-orders', '', 108, 3, 0, NULL, NULL),
(115, 'Freelancers components', 'javascript:;', 'flaticon-safe-shield-protection', 0, 5, 1, '2021-07-06 11:40:10', '2021-07-06 11:40:10'),
(116, 'services', 'services', '', 115, 2, 1, '2022-02-14 11:09:14', '2022-02-14 11:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_messages`
--

CREATE TABLE `gwc_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(190) CHARACTER SET utf8 DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `mobile` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `subject` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `message` text CHARACTER SET utf8 DEFAULT NULL,
  `is_read` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gwc_messages`
--

INSERT INTO `gwc_messages` (`id`, `first_name`, `last_name`, `email`, `mobile`, `subject`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'soheil', 'mehrandish', 'so@gmail.com', '0930719992', 'asdsadas', 'test1', 0, '2022-01-25 11:27:01', '2022-01-25 11:27:01'),
(2, 'sadegh', 'doroudi', 'almas', '0917936669', 'hi', 'Bye', 0, '2022-01-25 11:39:19', '2022-01-25 11:39:19'),
(3, 'soheil', 'mehrandish', 'so@gmail.com', '0930719992', 'asdsadas', 'test1', 0, '2022-01-29 14:37:34', '2022-01-29 14:37:34'),
(4, 'soheil', 'mehrandish', 'so@gmail.com', '0930719992', 'asdsadas', 'test1', 0, '2022-01-29 14:40:09', '2022-01-29 14:40:09'),
(5, 'soheil', 'mehrandish', 'so@gmail.com', '0930719992', 'asdsadas', 'test1', 0, '2022-01-29 16:06:47', '2022-01-29 16:06:47'),
(6, 'soheil', 'mehrandish', 'so@gmail.com', '0930719992', 'asdsadas', 'test1', 0, '2022-01-29 16:28:20', '2022-01-29 16:28:20'),
(7, 'soheil', 'mehrandish', 'so@gmail.com', '0930719992', 'asdsadas', 'test1', 0, '2022-01-30 09:06:21', '2022-01-30 09:06:21'),
(8, 'soheil', 'mehrandish', 'so@gmail.com', '0930719992', 'asdsadas', 'test1', 0, '2022-01-30 09:08:01', '2022-01-30 09:08:01'),
(9, 'soheil', 'mehrandish', 'so@gmail.com', '0930719992', 'asdsadas', 'test1', 0, '2022-01-31 16:07:07', '2022-01-31 16:07:07'),
(10, 'umar', 'k', 'm@m.com', '98819591', 'test ios', 'Hshshs shsksd dhdjd dhdjd', 0, '2022-02-01 10:57:40', '2022-02-01 10:57:40'),
(11, 'umar', 'k', 'm@m.com', '98819591', 'test ios', 'Hshshs shsksd dhdjd dhdjd bdhd', 0, '2022-02-01 10:58:05', '2022-02-01 10:58:05'),
(12, 'soheil', 'mehrandish', 'so@gmail.com', '0930719992', 'asdsadas', 'test1', 0, '2022-02-01 11:07:22', '2022-02-01 11:07:22'),
(13, 'soheil', 'mehrandish', 'so@gmail.com', '0930719992', 'asdsadas', 'test1', 0, '2022-02-14 11:02:38', '2022-02-14 11:02:38');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_newsevents`
--

CREATE TABLE `gwc_newsevents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_details_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_details_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_details_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_details_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_keywords_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_keywords_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_description_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_description_ar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `display_order` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ntype` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `news_date` date NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gwc_notify_emails`
--

CREATE TABLE `gwc_notify_emails` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL,
  `is_active` tinyint(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_notify_emails`
--

INSERT INTO `gwc_notify_emails` (`id`, `name`, `email`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'alireza', 'mr.wrestlemania1@gmail.com', 1, 1, '2021-07-04 08:55:22', '2021-07-13 05:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_package_galleries`
--

CREATE TABLE `gwc_package_galleries` (
  `id` bigint(20) NOT NULL,
  `package_id` bigint(20) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL,
  `is_active` tinyint(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_package_galleries`
--

INSERT INTO `gwc_package_galleries` (`id`, `package_id`, `title_en`, `title_ar`, `image`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Generall', 'Generall', 'packagegalleries-image-440c8950429cb5ee1df7eb7460c41c4b.png', 1, 1, '2021-07-19 04:04:52', '2021-07-19 04:11:10'),
(2, 1, 'gallery 2', 'gallery 2', 'packagegalleries-image-0c298a87b32df8fcc8837c33ecd789b6.png', 2, 1, '2021-07-19 04:12:13', '2021-07-19 04:12:34');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_resumes`
--

CREATE TABLE `gwc_resumes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gwc_settings`
--

CREATE TABLE `gwc_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `keyname` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'setting',
  `name_en` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description_en` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description_ar` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords_en` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords_ar` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_en` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_ar` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_logo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_analytics` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_per_page_front` int(11) NOT NULL DEFAULT 0,
  `item_per_page_back` int(11) NOT NULL DEFAULT 0,
  `default_sort` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ID',
  `social_google_plus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `social_facebook` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_twitter` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_linkedin` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_lang` tinyint(1) NOT NULL DEFAULT 0,
  `from_email` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_screen` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `register_screen` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_server_key` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pushy_api_token` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highlightNum` smallint(6) DEFAULT 5,
  `service_commission_price` int(11) NOT NULL DEFAULT 0,
  `service_commission_percent` int(11) NOT NULL DEFAULT 0,
  `service_commission_type` enum('price','percent','plus','min','max') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'min',
  `workshop_commission_price` int(11) NOT NULL DEFAULT 0,
  `workshop_commission_percent` int(11) NOT NULL DEFAULT 0,
  `workshop_commission_type` enum('price','percent','plus','min','max') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'min',
  `bill_commission_price` int(11) NOT NULL DEFAULT 0,
  `bill_commission_percent` int(11) NOT NULL DEFAULT 0,
  `bill_commission_type` enum('price','percent','plus','min','max') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'min'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gwc_settings`
--

INSERT INTO `gwc_settings` (`id`, `keyname`, `name_en`, `name_ar`, `seo_description_en`, `seo_description_ar`, `seo_keywords_en`, `seo_keywords_ar`, `address_en`, `address_ar`, `email`, `phone`, `mobile`, `fax`, `logo`, `email_logo`, `favicon`, `google_analytics`, `item_per_page_front`, `item_per_page_back`, `default_sort`, `social_google_plus`, `social_facebook`, `social_instagram`, `social_twitter`, `social_linkedin`, `created_at`, `updated_at`, `is_lang`, `from_email`, `from_name`, `login_screen`, `register_screen`, `web_server_key`, `pushy_api_token`, `highlightNum`, `service_commission_price`, `service_commission_percent`, `service_commission_type`, `workshop_commission_price`, `workshop_commission_percent`, `workshop_commission_type`, `bill_commission_price`, `bill_commission_percent`, `bill_commission_type`) VALUES
(1, 'setting', 'Deals', 'Deals', 'Deals', 'Deals', 'Deals', 'Deals', 'Deals', 'Deals', 'Info@dealsco.app', '+965 67772237', '(+965) 24829937', '(+965) 24829927', 'settings-logo-84ba7685e0e4402198a69945be89ea04.png', 'settings-email_logo-d90c54c6679a14168c349819054ec27a.png', 'settings-favicon-d90c54c6679a14168c349819054ec27a.png', '<!-- Global site tag (gtag.js) - Google Analytics -->\r\n<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-189104010-1\"></script>\r\n<script>\r\n  window.dataLayer = window.dataLayer || [];\r\n  function gtag(){dataLayer.push(arguments);}\r\n  gtag(\'js\', new Date());\r\n\r\n  gtag(\'config\', \'UA-189104010-1\');\r\n</script>', 50, 50, 'ASC', 'https://plus.google.com/', 'https://www.facebook.com/', 'https://instagram.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '2020-02-17 04:19:31', '2022-02-08 09:26:03', 1, 'Info@dealsco.app', 'Deals', 'login-527d7b7b749c9e5b35c13e9ca68ed93e.jpg', 'reg-527d7b7b749c9e5b35c13e9ca68ed93e.jpg', 'AAAA4tbNJRE:APA91bF7bgn3X2ZiyrLl07ITWlM3ynpnflZO1nMDiJxI172Eu9Py6JnzjHqWnisslsk6-RBRdrcY7pMhWczWe5RKeiKoCD5CF7ms6qGzIcg0M8uHXsvLPSt2OXH3t5xX986cFEFZ0B9X', NULL, 5, 0, 0, 'min', 0, 0, 'min', 0, 0, 'min');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_single_pages`
--

CREATE TABLE `gwc_single_pages` (
  `id` bigint(20) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ar` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `details_en` text NOT NULL,
  `details_ar` text NOT NULL,
  `images` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_single_pages`
--

INSERT INTO `gwc_single_pages` (`id`, `title_en`, `title_ar`, `slug`, `details_en`, `details_ar`, `images`, `display_order`, `is_active`, `name`, `created_at`, `updated_at`) VALUES
(1, 'What is Deals?', 'نبذة عن ديلز', 'what-is-deals', '<p>Deals is the first online platform of its own in the region. It is an application that brings freelancers and artists under one roof to facilitate the communication with their clients. Through Deals, clients can search their desired freelancer based on their name, category and pricing range.</p>', '<p style=\"text-align: right;\">ديلز&nbsp; أول منصة على الإنترنت من نوعها تُدشن في المنطقة، فهو تطبيق يضم من يعمل بالمجال الحر والفنانين تحت سقف واحد من أجل تيسير عملية التواصل بينهم وبين عملائهم، من خلاله يُمكن للعملاء البحث عمن يرغبون به بناءً على الاسم والفئة ومعدل السعر.</p>', '3fc7224e7faa5d768fc183fe8c786b104395568.png', 1, 1, 'about', '2021-07-19 09:48:25', '2021-12-20 11:45:03'),
(3, 'features', 'features', 'features', '<p>Deals is a two-division application on iOS and Android. The first division of the application is booking appointments or requesting services. There are five categories of&nbsp;freelancers in the application:&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;On the other hand, the second division is registering for workshops of fields related to&nbsp;the mentioned category above. Workshops are planned to be given by the registered&nbsp;freelancers on Deals.</p>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>', '<p style=\"text-align: right;\">ديلز هو تطبيق ذو قسمين على أنظمة الأندرويد و IOS. القسم الأول من التطبيق هو حجز موعد أو طلب خدمة، ويوجد خمس فئات من الأعمال الحرة في هذا التطبيق.</p>\r\n<p style=\"text-align: right;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; وعلى الجانب الآخر، القسم الثاني ويتضمن التسجيل في ورش العمل الميدانية المتعلقة بالفئة المذكورة أعلاه، يتم التخطيط لورش العمل ليقوم بإلقائها أحد أصحاب المهنة المسجلون على ديلز.</p>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>', '', 3, 1, 'features', '2021-09-25 07:52:47', '2021-10-03 12:15:24'),
(2, 'The first online platform of its own in the region', 'أول منصة من نوعها على الإنترنت في المنطقة', 'the-first-online-platform-of-its-own-in-the-region', '<p>The first online</p>\r\n<p>platform of its own</p>\r\n<p>in the region</p>', '<p>أول منصة من نوعها على الإنترنت في المنطقة</p>', 'bc4dbaef3348468e8772e9223f50b93f3414844.png,bc4dbaef3348468e8772e9223f50b93f1762882.png', 2, 1, 'slider', '2021-09-22 12:53:25', '2021-10-03 12:15:25'),
(4, 'Deals saves time and effort for both parties', 'يوفر الوقت والجهد لكلا الطرفين.', 'deals-saves-time-and-effort-for-both-parties', '<p>Deals saves time and effort for both parties: freelancers and clients. Bookings will be done on the spot, keeping&nbsp;them hassle-free of long negotiations and wait. According to the marketing plan, our guaranteed services to our clients will be promoted on social media.</p>\r\n<p>&nbsp;As a start, our advertising will mainly be on social media, as it is where our&nbsp;target audience can be found, and it is cost-effective. Instagram, Snapchat and&nbsp;Twitter are the platforms that the plan will include. In addition, there will be&nbsp;a launching event to announce the official establishment of the application.</p>', '<p style=\"text-align: right;\">يوفر Deals الوقت والجهد لكلا الطرفين: صاحب العمل الحر والعملاء. يتم الحجز على الفور، مما يمنع حدوث أي مفاوضات طويلة المدى ودون أي مشاحنات أو انتظار. حسب خطة التسويق، سيتم الترويج لخدماتنا المضمونة المقدمة لعملائنا عبر وسائل التواصل الاجتماعي.</p>\r\n<p style=\"text-align: right;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; في البداية، ستتركز الحملات الإعلانية لنا على مواقع التواصل الاجتماعي حيث يوجد جمهورنا المستهدف كما أنها فعالة من جانب التكلفة. وتتضمن الخطة مواقع الانستغرام وسناب شات وتويتر، علاوة على ذلك، سيتم إجراء حدث افتتاح للإعلان عن التأسيس الرسمي وتدشين التطبيق.</p>', '', 5, 1, 'benefits', '2021-09-25 11:18:34', '2021-09-26 07:12:43'),
(5, 'Expansion', 'Expansion', 'expansion', '<p>Our expansion is aimed to be vertical and horizontal. Vertical in the sense of increasing categories in the application, and it will be determined based on the turnout of the audience and&nbsp; their needs. As for the horizontal expansion, it is planned to take place after two years of the establishment in Kuwait, starting with UAE as a first&nbsp;country.</p>', '<p style=\"text-align: right;\">&nbsp;نهدف إلى التوسع الأفقي والرأسي. أفقيًا حيث سيتم زيادة الفئات والتصنيفات الموجودة بالتطبيق، وسيُحدد ذلك بناءً على معدل مشاركة الجمهور وحاجاتهم، أما من ناحية التوسع الرأسي، فتم التخطيط بأخذ مقر بعد مرور عامين من التأسيس في الكويت، بدءًا من الإمارات عربى&nbsp; المتحدة في المقام الأول.</p>', '', 6, 1, 'expansion', '2021-09-25 11:24:39', '2021-09-26 07:14:00'),
(8, 'FAQ', 'FAQ', 'faq', '<p><span style=\"color: #172b4d; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Noto Sans\', Ubuntu, \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 14px; background-color: #ffffff;\">FAQ</span></p>', '<p><span style=\"color: #172b4d; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Noto Sans\', Ubuntu, \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 14px; background-color: #ffffff;\">FAQ</span></p>', '', 7, 1, 'faq', '2021-10-13 11:16:52', '2021-10-13 11:16:52'),
(9, 'About us', 'About us', 'about-us', '<p><span style=\"color: #172b4d; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Noto Sans\', Ubuntu, \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 14px; background-color: #ffffff;\">About us</span></p>', '<p><span style=\"color: #172b4d; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Noto Sans\', Ubuntu, \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 14px; background-color: #ffffff;\">About us</span></p>', '', 8, 1, 'aboutus', '2021-10-13 11:17:22', '2021-10-13 11:17:22');
INSERT INTO `gwc_single_pages` (`id`, `title_en`, `title_ar`, `slug`, `details_en`, `details_ar`, `images`, `display_order`, `is_active`, `name`, `created_at`, `updated_at`) VALUES
(10, 'Terms & Conditions', 'Terms & Conditions', 'terms-conditions', '<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: center; line-height: 150%; mso-outline-level: 4; background: white; direction: ltr; unicode-bidi: embed;\" align=\"center\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\';\">Deals Website Use Agreement and Terms </span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; color: #0b0b0b; mso-bidi-language: AR-EG;\">Company and App Definition:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Deals Advertising &amp; Marketing Company LLC is a company established under the provisions of Kuwait laws and its head office is located in Kuwait. Deals is a specialized company in the field of electronic network marketing and provides marketing services through its Deals App on iPhone, iPad and android devices as well as all the devices connected with internet.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Description of services:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">According to this agreement, the Company provides marketing services to its members by presenting their works on the app and transmitting promotional advertisement through which these services are offered to the clients who have the desire to obtain such services. Especially if such services are characterized by creative work aiming to establish a new idea and enticing offers. The Company informs the user of these distinguished services, which the member can provide and the user can benefit from through the app for a commission to be paid according to an agreement between the parties in accordance with all the applicable laws regulating on-line commerce in Kuwait. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">The purpose of this website is to provide a simple and comforting service to users and link them with premium members in different fields with innovative and new services and ideas. Therefore, this app is designed to fit with all the options available for the users on the internet. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">In addition, the Company/ the App does not interfere, in any manner whatsoever, with the preparation, production or making of any of the materials used in the service provided by the member through the app, as the member is solely responsible for such process. Furthermore, the member shall organize his obligations and schedules and update them periodically and constantly as the app principally aims to provide the search feature to find such services in an easy and quick manner to the app user who will immediately and directly become a party in this agreement once they download and installs the app on his internet-connected device.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Agreement Terms:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">This agreement shall be legally binding and shall act as an official acknowledgment of legal eligibility of its users once it is accepted and the Company may keep the information included here in and reject any visitor or user deemed unfit for the website&rsquo;s general policy.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\"><span style=\"text-decoration: none;\">&nbsp;</span></span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">First: Definitions:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">When interpreting this agreement, the following expressions shall have the meanings below unless the context requires otherwise:</span></u></strong></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Deals Company</span></u></strong><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">: herein after referred to as &ldquo;the Company&rdquo;.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Member</span></u></strong><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">: the person/ entity offering the service and owner of the creative work aiming to establish a new thing or highlighting an idea.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">App</span></u></strong><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">: the app of Deals Company.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Use Agreement</span></u></strong><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">: the agreement related to using the website.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Service or product</span></u></strong><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">: anything including services and consumptive and non-consumptive goods offered by the member on the app. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Service or operation: the marketing operation performed by the Company to market the services or products of a member on the website. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">User</span></u></strong><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">: any natural or legal person benefiting from the provided services.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Second: How to obtain Service or Product:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">When a user chooses a service offered by a member, the Company through its app presents a confirming page to assure acceptance of the offered service. Then, the user and the member agree together upon the time and place for providing the agreed service. The user and member shall comply with such agreement (photography studio, saloon, user&rsquo;s home, outdoor location, etc.) as agreed with the user without any responsibility on the Company in this regard. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">After the user confirms the selected service and agree with the member upon the place and time to implement the transaction, the Company presented to both, the user and the member a notification or reminder of the time and place one day before the transaction. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">In case the user cancels the transaction agreed upon with the member in the same day of the transaction, the paid amount will be refunded after deducting 2.500 KD (two Kuwaiti Dinars and 500 fils only) due to failure to fulfill the agreement. In case the member cancels the appointment the amount of the service will be fully refunded to the user. In case the member cancels the previously booked and paid appointment with sending the user reschedule the appointment request; the option will be in the user behavior to accept and reschedule or reject the request. A- if the user accepts, He or She must select another date, and time; and the paid amount will be saved. B- if the user rejected the request the paid amount will be fully refunded. </span></strong></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Third: Eligibility:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">The user gets a &ldquo;username&rdquo; and &ldquo;password&rdquo; to be determined by him and known only to him as the company is not responsible for any problems arising out of using the password. The user shall be fully responsible for his uses and all the transactions made by him. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Fourth: Users&rsquo; Obligations and Behavior:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Besides the personal information that the app shall comply with its confidentiality in the privacy policy, the user shall not, under this agreement, use the app for any illegal or unauthorized purposes including but not limited to transmitting any illegal, libelous, defamatory, threatening, harmful or obscene materials, sending any materials violating the law, religions, doctrines, faiths or morals, purchasing prohibited, suspicious or stolen exhibits or those violating the laws applicable in local government ministries, agencies and establishments, or the intellectual property rights of third parties or causing damages to the app. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">The user is solely responsible for all the ideas, opinions and personal information provided during using the app, as well as for all the files uploaded to the app or the personal information sent to the app. In addition, the Company will not be responsible, in any manner whatsoever, for such files. The user shall not also misuse the website (including through piracy), cause disturbance and/or threaten other users, or violate the privacy of others. Furthermore, the user shall not provide wrong information about his connection with another person and act in a manner affecting the use of the services by other users or provide any information that might cause damages to the names of any persons or establishments, or advertise or participate in any harmful actions.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Fifth: User&rsquo;s Undertakings:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">The user acknowledges that he reviewed all the terms included herein with due diligence and undertakes to comply therewith and the provisions thereof at all times when using the app. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Sixth: Company Rights:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">The Company shall solely and exclusively have the rights indicated below without any legal obligations towards the user or any other party for providing any reason at any time or in any manner. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">The Company shall have the right to use, reproduce, disclose, present, share, distribute, amend or make copies of works, or improve or amend any content created by the user and provided for any reason, whatsoever, without any restrictions, obligations, notifications or compensation.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">The Company shall also have the right to install cookies or similar app or information on all the devices on which the portal is installed in relation to the user and change the installed elements. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">The Company shall have the right not to engage the user in some tasks and activities, amend, restrict, suspend, terminate, cancel or take similar procedures in relation to this agreement, portal, user account, task and activity. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Seventh: Company&rsquo;s Authority:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">The Company may temporarily suspend or completely stop the system at any time and will not be responsible towards any member or third party for such suspension or stoppage. In addition, the Company alone has the rights of property and publication arising of ownership of information, documents, software, designs, charts, etc. produced by itself and/ or purchased from external sources. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Furthermore, all the comments published on the app belong to the Company, which shall have the right to reproduce, amend, translate, transfer, and/or distribute all the materials related to the comments. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Eighth: Duration and Termination of the Agreement:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Without prejudice to the content of the agreement, the duration of this agreement shall be determined as the user requires. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">This agreement shall be deemed as it has lost all its terms and conditions in case of end of subscription during the agreed time period without any responsibility on the Company.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">This agreement shall be deemed terminated by force of the law without any need for excuse, warning or court order if the user violated any of the obligations stipulated herein. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Ninth: Confidentiality:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">According to this agreement, the Company undertakes to maintain confidentiality of all the information received by the Company in its capacity as a party hereof and undertakes to do its best to maintain and cause its employees and affiliates to maintain confidentiality of such information and not to disclose or use any of the secrets it might review under this agreement. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Tenth: General Provisions:</span></u></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">This agreement does not grant any right or benefit to any other party. Other parties are not entitled to impose any clause or enter as a party in this agreement. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Invalidity</span></u></strong><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">: invalidity or inapplicability of any clause hereof shall not affect other clauses and provisions herein. This agreement shall be interpreted, in all respects, as if the invalid or inapplicable provisions are not stipulated in this agreement, unless this makes continuity of the agreement burdensome.</span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Assignment</span></u></strong><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">: this agreement shall neither be assigned nor transferred by any party to any other party without a prior written consent from the other party. </span></p>\r\n<p class=\"MsoNormal\" style=\"margin-bottom: .0001pt; text-align: justify; line-height: 150%; background: white; direction: ltr; unicode-bidi: embed;\"><strong><u><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">Partnership</span></u></strong><span style=\"font-size: 13.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-bidi-language: AR-EG;\">: this agreement does not form or represent any kind of partnership, agency or legal representation, and each party shall be responsible for his own actions. In addition, the user may not prevent the Company from enabling another party to use the app. </span></p>', '<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: center; line-height: 150%; mso-outline-level: 4; background: white; margin: 0cm -16.5pt .0001pt 0cm;\" align=\"center\"><u><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">اتفاقية وشروط الزائر في استخدام الموقع الالكتروني </span></u><u><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">Deals</span></u><u></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">التعريف بالشركة والبرنامج </span></u><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">:- </span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><span dir=\"LTR\" lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\"><span style=\"mso-spacerun: yes;\">&nbsp;</span></span><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\">شركة الصفقات للدعاية والتسويق ش.ذ.م.م</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\"> خاضعة لأحكام قوانين دولة الكويت، ومقرها الكويت</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\"> من الشركات المتخصصة في مجال التسويق الشبكي الإلكتروني</span> <span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">وتقوم بتقديم خدمات تسويقية</span><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\"> من خلال تطبيق</span><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">Deals </span><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\"><span style=\"mso-spacerun: yes;\">&nbsp;</span>الالكتروني</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\"> على أجهزة الآيفون والآيباد والأندرويد وجميع الهواتف المتصل بالإنترنت</span> <span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">وصف الخدمات :-</span></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\">بموجب هذه الاتفاقية </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">تقوم الشركة بتقديم خدمات تسويقية للعضو بعرض أعماله على البرنامج </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">من خلال بث إعلانات ترويجه لها</span> <span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">على البرنامج الإلكتروني و التي يمكن من خلالها عرض تلك </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">الخدمات </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">للجمهور الراغبين في الحصول عليها</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\"> <span style=\"background: white;\">لاسيما إن كانت هذه الخدمات تتميز بالعمل الإبداعي الذي يهدفُ إلى إنشاءِ فكره جديدة </span>وذات<span style=\"background: white;\"> عروض مغرية وتقوم الشركة بإبلاغ المستخدم عن هذه الخدمات المتميزة التي يقوم العضو بعرضها والتي يمكن للمستخدم الاستفادة منها عن طريق البرنامج </span>في مقابل عمولة يتم سدادها وفقا للاتفاق بينهم</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\"> وفقاً لكافة القوانين المعمول بها لتنظيم التجارة عبر الانترنت</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\"> .</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">إن غرض هذا الموقع هو تقديم خدمة بسيطة ومريحة للمستخدم وربطهم بالأعضاء المتميزين في مختلف المجالات يمكنها تقديم خدمات إبداعية وأفكار جديدة في مختلف المجالات لذلك تم تصميم البرنامج ليناسب جميع اختيارات المستخدمين من خلال شبكة المعلومات العالمية (الانترنت)</span><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white; mso-bidi-language: AR-EG;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">كما أن الشركة أو البرنامج لا يتدخل بأي شكل من الأشكال في إعداد أو أنتاج أو تصنيع أي من المواد المستخدمة في الخدمة المقدمة من العضو من خلال البرنامج وإن العضو هو المسئول بمفرده، كما يلتزم العضو بتنظيم التزاماته وتحديد المواعيد وتحديثهم بشكل دوري ومستمر لاسيما ان غرض البرنامج هو توفير إمكانية البحث والعثور على هذه الخدمات بطريقة سهلة وسريعة لمستخدم البرنامج </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">الذي سيصبح طرفاً في هذه الاتفاقية حالاً ومباشرةً حال تنزيل وتثبيت البرنامج على الجهاز المتصل بالأنترنت.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">بنود الاتفاقية</span></u><u></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">تعتبر هذه الاتفاقية ملزمة قانوناً بمجرد الموافقة عليها وتعتبر إقرار رسمي بالأهلية القانونية لمستخدميها والموافقة على بنودها حسب ما ذكر فيها من شروط وعليه يحق للشركة الاحتفاظ بالبيانات المذكورة فيها ورفض إي زائر أو مستخدم يراه غير مناسباً للسياسة العامة للموقع</span><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white; mso-bidi-language: AR-EG;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">أولاً :- التعريفات :-</span></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt 10.0pt -7.1pt;\"><strong><u style=\"text-underline: thick;\"><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\">عند تفسير أو تأويل هذه الاتفاقية يقصد بالتعبيرات الآتية المعانى الموجودة قرين كل منهما مالم يتطلب سياق النص غير ذلك :</span></u></strong></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; mso-pagination: none; page-break-after: avoid; tab-stops: -9.4pt 189.0pt 207.0pt; margin: 0cm -16.5pt .0001pt -7.1pt;\"><strong><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\">شركة الصفقات</span></u></strong> <strong><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">:</span></strong><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\">- </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Arial Unicode MS\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">يشار اليها في </span><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\">هذه الاتفاقية بـ الشركة .</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; mso-pagination: none; page-break-after: avoid; tab-stops: -9.4pt 189.0pt 207.0pt; margin: 0cm -16.5pt .0001pt -7.1pt;\"><strong><u><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">العضو:</span></u></strong><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\"> - عارض الخدمة و</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">صاحب العملُ الإبداعي الذي يهدفُ إلى إنشاءِ شيءٍ جديدة أو تسليط الضوء على فكرة</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; tab-stops: -2.3pt; margin: 0cm -16.5pt .0001pt -7.1pt;\"><strong><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; mso-bidi-language: AR-EG;\">البرنامج </span></u></strong><strong><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">:-</span></strong><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\"> التطبيق الإلكتروني (</span><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">Deals</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">) على الانترنت والخاص بالشركة<span style=\"mso-spacerun: yes;\">&nbsp; </span>.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><strong><u><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">اتفاقية الاستخدام</span></u></strong><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">: - </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">ما يتعلق باستخدام المستخدم للموقع الإلكتروني.<u style=\"text-underline: thick;\"></u></span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; tab-stops: -2.3pt; margin: 0cm -16.5pt .0001pt -7.1pt;\"><strong><u><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">الخدمة أو المنتج</span></u></strong><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: black;\">: - </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">جميع ما يتم عرضه من خدمات وسلع استهلاكية وغير استهلاكية من العضو على البرنامج الإلكتروني.<span style=\"color: black;\"><span style=\"mso-spacerun: yes;\">&nbsp; </span></span></span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><strong><u style=\"text-underline: thick;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">الخدمة أو العملية:</span></u></strong><strong><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\"> - </span></strong><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\"><span style=\"mso-spacerun: yes;\">&nbsp;</span></span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">العملية التسويقية التي تقوم بها الشركة لتسويق خدمة أو منتجات العضو على البرنامج الإلكتروني.<u style=\"text-underline: thick;\"></u></span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><strong><u><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">المستخدم:</span></u></strong><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\"> - </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">أي شخصٍ طبيعي أو اعتباري </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">مستفيد من الخدمة </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">المُقدمة.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">ثانياً : طريقة الحصول على الخدمة أو المنتج :-</span></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: black;\">عند اختيار المستخدم للخدمة المعروضة من العضو تظهر الشركة للمستخدم عبر البرنامج واجهه تأكيد؛ للتأكد من موافقة المستخدم في اختيار الخدمة المعلنة ومن ثم يقوم المستخدم والعضو معاً بالاتفاق على تحديد موعد ومكان تنفيذ الخدمة المتفق عليها ويلتزم المستخدم والعضو معاً بالمكان والموعد المحددان (استديو التصوير، الصالون، بيت المستخدم، مكان خارجي، غيره) الذي اتفق عليهما مع المستخدم دون أدنى مسئولية للشركة في ذلك.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: black;\">عند تأكيد المستخدم على اختيار الخدمة واتفاقه مع العضو على المكان والزمان لتنفيذ العملية تظهر الشركة للمستخدم والعضو معاً رسالة أو إشعار للتذكير بالموعد والاتفاق قبل أتمام العملية بيوم.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><strong><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">في حالة قيام المستخدم بإلغاء العملية المتفق عليها مع العضو لتوفير الخدمة <span style=\"color: #31849b; mso-themecolor: accent5; mso-themeshade: 191;\">في نفس اليوم</span> يتم إعادة المبلغ المسدد للمستخدم بعد خصم مبلغ 2,500 د.ك (فقط اثنان دينار كويتي وخمسمائة فلس) منها بسبب هذا الإخلال. في حالة ألغي الموعد من قبل العضو سوف يتم استرداد قيمة الخدمة كاملة للمستخدم. في حالة تم إلغاء موعد محجوز ومدفوع مع إرسال طلب إعادة جدولة من قبل العضو؛ سوف يكون الخيار للمستخدم سواء كان بالقبول أو الرفض، في حالة قبول طلب إعادة الجدولة: يتم تغير اليوم، التاريخ، والوقت مع الاحتفاظ بالمبلغ المدفوع، في حالة رفض طلب إعادة الجدولة: يتم إعادة المبلغ كامل للمستخدم.<span style=\"mso-spacerun: yes;\">&nbsp;&nbsp;&nbsp; </span></span></strong></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm 0cm .0001pt -7.1pt;\"><strong><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">&nbsp;</span></strong></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">ثالثاً : الأهلية</span></u><u> </u><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\"><span style=\"mso-spacerun: yes;\">&nbsp;</span>:-</span></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">ويحصل المستخدم على \"اسم مستخدم\" و\"كلمة سر\" يتم تحديدها بواسطته تكون معلومة له فقط لاسيما ان </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">الشركة <span style=\"background: white;\">غير مسئوله عن أي مشاكل قد تنشأ عن استخدام كلمة السر و</span></span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">يُعتبر المُستخدم مسئولاً مسئوليةً كاملةً عن استخداماته وعن كافة المُعاملات التي تتم من خلالها.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\"><span style=\"text-decoration: none;\">&nbsp;</span></span></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; tab-stops: 269.65pt; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">رابعاً: التزامات وسلوك الزائرين :-</span></u><u></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt 0cm;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: black;\">بخلاف المعلومات الشخصية، التي يلتزم بها البرنامج في سياسة الخصوصية<span style=\"mso-spacerun: yes;\">&nbsp; </span>يلتزم المستخدم بموجب هذه الاتفاقية </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">استخدام </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Arial Unicode MS\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">البرنامج</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\"> لأي غرض غير مشروع أو غير مصرح به على سبيل المثال وليس الحصر نشر أي مواد غير قانونية ، تشهيرية ،<span style=\"mso-spacerun: yes;\">&nbsp; </span>مسيئة ، تهديديه ، ضارة، خليعة أو مواد معترضة للموقع</span> <span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white; mso-bidi-language: AR-EG;\">أو </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">إرسال مواد تشكل مخالفة للقانون أو الأديان أو العقائد والمذاهب أو الأخلاق، أو </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">شراء معروضات ممنوعة أو مشبوهة أو مسروقة أو مخالفة القوانين المعمول بها بوزارات و هيئات مؤسسات التجارة المحلية الحكومية ، أو انتهاك الحقوق الملكية الفكرية للغير </span><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white; mso-bidi-language: AR-EG;\">أو </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">التسبب في الإضرار بالبرنامج أو أعاقة .</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">ان المستخدم هو وحده المسئول عن كافة الأفكار والآراء والبيانات الشخصية التي يذكرها أثناء استخدامه ل</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Arial Unicode MS\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">لبرنامج</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\"> وكذلك مسئولا عن كافة الملفات التي يتم تحميلها الى </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Arial Unicode MS\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">البرنامج</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\"> والمعلومات الشخصية المرسلة، وإن الشركة لن تكون مسئولة بأي شكل من الأشكال عن تلك الملفات،</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: black;\"> ولا يجوز لمستخدم إساءة استخدام الموقع (بما في ذلك بواسطة القرصنة)</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\"> ويلتزم المستخدم بعدم مضايقة و/أو تهديد المستخدمين الآخرين،</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: black;\"> او تخترق خصوصية الآخر</span> <span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: black;\">او</span> <span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: black;\">يتم استخدامها لتقمص شخصية شخص آخر او تقديم معلومات خاطئة عن ارتباطك بشخص آخر</span> <span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">وعدم التصرف</span> <span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\"><span style=\"mso-spacerun: yes;\">&nbsp;</span>بطريقة تؤثر على استخدام الخدمات من قبل المستخدمين الآخرين، أو معلومات قد تسبب ضررا بأسماء أي أشخاص أو مؤسسات، أو الإعلان أو المشاركة في أي أفعال ضارة .</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 115%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">خامساً: تعهدات المستخدم :-</span></u><u></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">يُقر المُستخدم بأنه قد اطلع بعناية نافية للجهالة على جميع البنود المُدرجة بهده الاتفاقية ويتعهد بالالتزام بها وبأحكامها الواردة فيها في جميع الأوقات عند استخدام البرنامج.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">سادساً : حقوق الشركة </span></u><u><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">:</span></u><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">-</span></u><u></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">تتمتع الشركة بالحق الوحيد والحصري بالحقوق المبينة أدناه، دون أن يكون عليه أي التزام قانوني تجاه المُستخدم أو أي طرف أخر بتقديم أي سبب في أي وقت وبأي شكل من الأشكال</span><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">للشركة حق استغلال أو نسخ أو كشف أو عرض أو مشاركة أو توزيع أو تعديل أو إنشاء نسخ إنشاء أعمال مشتقة أو تحسين أو تعديل أي محتوي من إنشاء المستخدم يقوم المستخدم بتقديمه لأي غرض أو أسباب أياً كانت، دون أي قيود، دون أي التزام، إخطار أو تعويض</span><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">كما يحق للشركة أن تقوم بتثبيت ملف تعريف ارتباط أو برنامج أو بيانات مماثلة في جميع الأجهزة، التي تم تثبيت البوابة الإلكترونية لها، والتي تخص المستخدم وتغيير العناصر المثبتة</span><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">وللشركة وحدها الحق في عدم إشراك المستخدم في بعض المهام والأنشطة وتعديل أو تقييد أو وقف أو إنهاء أو إلغاء أو اتخاذ إجراءات مماثلة بخصوص هذه الاتفاقية وبوابة الويب وحساب المستخدم والمهام والأنشطة</span><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">سابعاً : سلطة الشركة :-</span></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">يجوز ان تقوم الشركة بشكل مؤقت بتوقيف او التوقف تماما عن تشغيل النظام في أي وقت</span> <span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">لن تكون على الشركة أية مسؤوليات تجاه العضو او أي طرف ثالث بسبب التوقيف المؤقت او التوقف الكامل لتشغيل النظام </span><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white; mso-bidi-language: AR-EG;\">كما </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; background: white;\">تمتلك الشركة وحدها حقوق الملكية والنشر الناشئة عن ملكية المعلومات والمستندات والبرمجيات والتصميمات والرسوم البيانية الخ، التي تقوم بإنتاجها بنفسها و/او يتم شراءها من الخارج</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">جميع التعليقات المنشورة على </span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Arial Unicode MS\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">البرنامج</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\"> هي ملك للشركة ولها الحق في إعادة إنتاج وتعديل وترجمة ونقل و/أو توزيع جميع المواد المتعلقة بالتعليقات. </span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm 0cm .0001pt -7.1pt;\"><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">ثامناً : مُدة الاتفاقية والإنهاء</span></u><u><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">:</span></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">مع عدم الإخلال بما جاء بالاتفاقية تم تحديد مدة هذه الاتفاقية وفقاً لما يحتاجه المستخدم.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt -7.1pt;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: black;\">وتعتبر هذه الاتفاقية فاقده لجميع شروطها وبنودها في حالة انتهاء الاشتراك في الفترة الزمنية المتفق عليها دون أدني مسئولية على الشركة.</span></p>\r\n<p class=\"MsoBodyText\" dir=\"RTL\" style=\"margin-right: -16.5pt; text-align: justify; line-height: 150%; background: white;\"><span lang=\"AR-SA\" style=\"mso-bidi-font-size: 15.0pt; line-height: 150%; mso-ascii-font-family: \'Times New Roman\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Arial Unicode MS\'; mso-hansi-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-font-family: \'Times New Roman\'; mso-bidi-theme-font: major-bidi; color: black; background: white;\">ويعتبر هذا العقد منتهياً بقوة القانون دون حاجة الى اعذر او إنذار أو حكم إذا ما أخل المستخدم بأي التزام من التزاماته المنصوص عليها بالاتفاقية.</span></p>\r\n<p class=\"MsoBodyText\" dir=\"RTL\" style=\"margin-right: -16.5pt; text-align: justify; line-height: 150%; background: white;\"><span dir=\"LTR\" style=\"mso-bidi-font-size: 15.0pt; line-height: 150%; mso-ascii-font-family: \'Times New Roman\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Arial Unicode MS\'; mso-hansi-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-font-family: \'Times New Roman\'; mso-bidi-theme-font: major-bidi; color: black; background: white;\">&nbsp;</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">تاسعاً : السرية :-</span></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; margin: 0cm -16.5pt .0001pt 0cm;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Arial Unicode MS\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: black; background: white; mso-fareast-language: AR-SA;\">بموجب هذه الاتفاقية تتعهد الشركة بالمحافظة على سرية جميع المعلومات التي تصل إليها بصفته طرفا في هذه الاتفاقية وتتعهد بأن تبذل قصارى جهدها لكي تحافظ هو موظفيها والأشخاص التابعين لها على سرية هذه المعلومات وعدم إفشاء أو استخدام أي من الأسرار التي قد يطلع عليها بموجب هذا الاتفاقية.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><u><span lang=\"AR-EG\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b; mso-bidi-language: AR-EG;\">عاشراً : أحكام عامة :-</span></u></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"text-align: justify; line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">لا تمنح هذه الاتفاقية أي حق او منفعة لأي طرف آخر ولا يحق لأي طرف آخر فرض أي بند أو الدخول كطرف في هذه الاتفاقية</span><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><strong><u><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">البطلان</span></u></strong><strong><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">:</span></strong> <span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">لا يؤثر بطلان أو عدم قابلية تطبيق أي بند من أحكام هذه الاتفاقية على الأحكام الأخرى المنصوص عليها في هذه الاتفاقية، ويجب تفسير هذه الاتفاقية من جميع النواحي كما لو أن الأحكام غير الصالحة أو غير القابلة للتنفيذ غير واردة في هذه الوثيقة، ما لم يجعل استمرار الاتفاقية مرهقًا للغاية. </span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><strong><u><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">التنازُل</span></u></strong><strong><u><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">:</span></u></strong> <span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">لا يتم التنازل عن هذه الاتفاقية أو نقلها من قبل أي طرف إلى أي طرفٍ أخر دون موافقة خطية مسبقة من الطرف الآخر</span><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">.</span></p>\r\n<p class=\"MsoNormal\" dir=\"RTL\" style=\"line-height: 150%; background: white; margin: 0cm -16.5pt .0001pt 0cm;\"><strong><u><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">الشراكة</span></u></strong><strong><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">:</span></strong><span dir=\"LTR\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">&nbsp;</span><span lang=\"AR-SA\" style=\"font-size: 15.0pt; line-height: 150%; font-family: \'Times New Roman\',\'serif\'; mso-ascii-theme-font: major-bidi; mso-fareast-font-family: \'Times New Roman\'; mso-hansi-theme-font: major-bidi; mso-bidi-theme-font: major-bidi; color: #0b0b0b;\">لا تُمثل هذه الاتفاقية أي نوع من أنواع الشراكة أو الوكالة أو التمثيل القانوني ويُعتبر كُل طرف مسؤولاً عن أعماله الخاصة، كما لا يجوز للمُستخدم منع الشركة من تمكين أي طرف أخر من استخدام البرنامج.</span></p>', '', 9, 1, 'TermsConditions', '2021-10-13 11:18:20', '2022-02-02 07:13:25');
INSERT INTO `gwc_single_pages` (`id`, `title_en`, `title_ar`, `slug`, `details_en`, `details_ar`, `images`, `display_order`, `is_active`, `name`, `created_at`, `updated_at`) VALUES
(11, 'Refund Policy', 'Refund Policy', 'refund-policy', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '', 10, 1, 'RefundPolicy', '2021-10-13 11:19:35', '2021-10-14 06:08:57'),
(12, 'test1', 'test1', 'test1', '<p>test1</p>', '<p>test1</p>', '0c2fb4a93ab1640a6f1c64fab764b8542550252.jpg', 11, 1, 'test', '2022-02-01 09:18:52', '2022-02-01 09:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_sms`
--

CREATE TABLE `gwc_sms` (
  `id` bigint(20) NOT NULL,
  `user_id` int(8) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `knet_en` text NOT NULL,
  `knet_ar` text NOT NULL,
  `knet_active` tinyint(1) NOT NULL,
  `cod_en` text NOT NULL,
  `cod_ar` text NOT NULL,
  `cod_active` tinyint(1) NOT NULL,
  `track_order_en` text NOT NULL,
  `track_order_ar` text NOT NULL,
  `track_order_active` tinyint(1) NOT NULL,
  `outofstock_en` text NOT NULL,
  `outofstock_ar` text NOT NULL,
  `outofstock_active` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gwc_sms`
--

INSERT INTO `gwc_sms` (`id`, `user_id`, `api_key`, `sender_name`, `knet_en`, `knet_ar`, `knet_active`, `cod_en`, `cod_ar`, `cod_active`, `track_order_en`, `track_order_ar`, `track_order_active`, `outofstock_en`, `outofstock_ar`, `outofstock_active`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 66444569, '4df40a67851392d1c00820118049c6ac', 'theboxlab', 'Thank you.\r\nYour order has been received. Your order will be delivered within 24 hours - 48 hours', 'شكرا لقد تم استلام طلبك.\r\nسيتم توصيل طلبك خلال 24 ساعة -48 ساعة', 1, 'Thank you.\r\nYour order has been received. Your order will be delivered within 24 hours - 48 hours', 'شكرا لقد تم استلام طلبك.\r\nسيتم توصيل طلبك خلال 24 ساعة -48 ساعة', 1, 'Your order status is updated . \r\nwww.kash5astore.com', 'تم تحديث حالة طلبك.\r\nwww.kash5astore.com', 1, 'We have updated the quantity of the item which was not available.\r\nvisit kash5astore.com to view updated items', 'We have updated the quantity of the item which was not available.\r\nvisit kash5astore.com to view updated items', 1, 1, '2021-07-13 05:51:47', '2021-07-13 05:19:32');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_subjects`
--

CREATE TABLE `gwc_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gwc_subjects`
--

INSERT INTO `gwc_subjects` (`id`, `title_ar`, `title_en`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'subject 1', 'subject 1', 1, 1, '2021-07-04 14:39:13', '2021-07-04 14:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_transactions`
--

CREATE TABLE `gwc_transactions` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `paymentid` varchar(255) NOT NULL,
  `presult` varchar(25) NOT NULL,
  `postdate` varchar(15) NOT NULL,
  `tranid` varchar(50) NOT NULL,
  `auth` varchar(50) NOT NULL,
  `ref` varchar(50) NOT NULL,
  `trackid` varchar(50) NOT NULL,
  `udf1` varchar(255) NOT NULL,
  `udf2` varchar(255) NOT NULL,
  `udf3` varchar(255) NOT NULL,
  `udf4` varchar(255) NOT NULL,
  `udf5` varchar(255) NOT NULL,
  `error_text` varchar(50) NOT NULL,
  `error` varchar(50) NOT NULL,
  `avr` varchar(50) NOT NULL,
  `amount` varchar(50) NOT NULL,
  `pay_type` varchar(20) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'notpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gwc_users`
--

CREATE TABLE `gwc_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `block` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avenue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `house_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `newsletter` tinyint(4) DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL DEFAULT 1,
  `password_token` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gwc_web_device_register`
--

CREATE TABLE `gwc_web_device_register` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `device_token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_push_active` tinyint(1) NOT NULL DEFAULT 0,
  `device_type` enum('web','ios','android') COLLATE utf8mb4_unicode_ci DEFAULT 'web',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gwc_web_device_register`
--

INSERT INTO `gwc_web_device_register` (`id`, `user_id`, `device_token`, `is_push_active`, `device_type`, `created_at`, `updated_at`) VALUES
(2, NULL, '42ea16ad4eed74539157a5', 0, 'web', '2021-12-22 13:06:10', '2021-12-22 13:06:10'),
(3, NULL, '97133b24e6812b603609f5', 0, 'web', '2022-02-01 19:18:20', '2022-02-01 19:18:20');

-- --------------------------------------------------------

--
-- Table structure for table `gwc_web_push_message`
--

CREATE TABLE `gwc_web_push_message` (
  `id` int(11) NOT NULL,
  `title` varchar(192) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `large_image_url` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_image_url` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge_image_url` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_url` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alignment` enum('auto','rtl','ltr') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message_for` enum('mobile','web') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gwc_web_push_message`
--

INSERT INTO `gwc_web_push_message` (`id`, `title`, `message`, `large_image_url`, `logo_image_url`, `badge_image_url`, `action_url`, `alignment`, `message_for`, `created_at`, `updated_at`) VALUES
(1, 'dawdawdad', 'dawdadad', NULL, NULL, NULL, NULL, 'auto', 'web', '2021-12-19 16:10:04', '2021-12-19 16:10:04'),
(2, 'dfsdfd', 'fsdfsdf', NULL, NULL, NULL, NULL, 'auto', 'web', '2021-12-22 13:04:49', '2021-12-22 13:04:49'),
(3, 'salam all', 'this is a message', 'v1.dealsco.app/uploads/freelancers/thumb/freelancers-image-300448c0f453ac18db1f4bfbc0e00798.jpg', 'v1.dealsco.app/uploads/freelancers/thumb/freelancers-image-300448c0f453ac18db1f4bfbc0e00798.jpg', 'v1.dealsco.app/uploads/freelancers/thumb/freelancers-image-62d96f69c84cf2a88f7e1847dc2def15.jpg', 'v1.dealsco.app/uploads/freelancers/thumb/freelancers-image-4ae78c649fe91f784db25e6258bb4aad.jpg', 'auto', 'web', '2021-12-22 13:23:40', '2021-12-22 13:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `how_it_works`
--

CREATE TABLE `how_it_works` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `display_number` int(11) DEFAULT NULL,
  `step` int(11) DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `how_it_works`
--

INSERT INTO `how_it_works` (`id`, `display_number`, `step`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'howitworks-image-9f597675ad97f5a2d07f6feee08b981a.png', '2021-09-25 08:59:19', '2021-09-25 11:11:17'),
(2, 1, 2, 'howitworks-image-0451f60744ffabf466e01717ba7ce3b6.png', '2021-09-25 09:00:14', '2021-09-25 11:11:03');

-- --------------------------------------------------------

--
-- Table structure for table `how_it_work_translations`
--

CREATE TABLE `how_it_work_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `how_it_work_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `how_it_work_translations`
--

INSERT INTO `how_it_work_translations` (`id`, `how_it_work_id`, `locale`, `title`, `sub_title`, `description`) VALUES
(1, 1, 'en', 'How can I book a service?', 'First STEP', 'Go to the home page\r\nselect category.'),
(2, 1, 'ar', 'یشسیشی', 'شسیشسی', 'شسیش'),
(3, 2, 'en', 'How can I book a service?', 'Second STEP', 'Choose freelancer name\r\nand service name.'),
(4, 2, 'ar', 'یشسی', 'یشسی', 'شسیسشی');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `key`, `dir`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'ltr', '', NULL, NULL),
(2, 'Arabic', 'ar', 'rtl', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `time_piece_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `user_id`, `freelancer_id`, `time_piece_id`, `location_id`, `date`, `time`, `area_id`, `created_at`, `updated_at`) VALUES
(25, 2, 25, 45, NULL, '2022-02-19', '12:25:00', 30, '2022-02-12 07:01:39', '2022-02-12 07:01:39'),
(26, 44, 25, 45, NULL, '2022-03-10', '12:25:00', 30, '2022-02-12 07:01:39', '2022-02-12 07:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(190, '2014_10_12_000000_create_users_table', 1),
(196, '2021_07_06_065629_create_categories_table', 1),
(197, '2021_08_23_142237_create_category_translations_table', 1),
(198, '2021_08_24_062746_create_languages_table', 1),
(199, '2021_08_24_080823_create_blogs_table', 1),
(200, '2021_08_24_091004_create_blog_categories_table', 1),
(201, '2021_08_24_133225_create_blog_translations_table', 1),
(202, '2021_09_08_125941_create_attributes_table', 1),
(203, '2021_09_08_140830_create_attr_groups_table', 1),
(204, '2021_09_08_140925_create_products_table', 1),
(205, '2021_09_08_163004_create_product_translations_table', 1),
(206, '2021_09_08_163327_create_category_product_table', 1),
(207, '2021_09_12_114401_create_category_blogs_table', 1),
(208, '2021_09_12_115641_create_category_blog_translations_table', 1),
(209, '2021_09_20_063005_create_filters_table', 1),
(210, '2021_09_20_063211_create_filter_product_table', 1),
(211, '2021_09_27_082217_create_addresses_table', 1),
(212, '2021_10_05_081237_create_shippings_table', 1),
(213, '2021_10_05_093441_create_shipping_translations_table', 1),
(215, '2021_07_10_140925_create_products_table', 2),
(216, '2021_10_05_093442_create_rates_table', 2),
(217, '2021_10_05_093443_create_freelancers_table', 2),
(218, '2021_09_20_102703_create_slideshows_table', 3),
(219, '2021_10_06_102703_create_slideshows_table', 4),
(220, '2021_09_20_141727_create_freelancer_services_table', 5),
(221, '2021_09_22_125630_create_packages_table', 6),
(224, '2021_09_25_115117_create_how_it_works_table', 7),
(225, '2021_09_25_115330_create_how_it_work_translations_table', 7),
(226, '2021_10_03_130138_user_freelancer', 8),
(227, '2021_10_04_090339_create_user_orders_table', 9),
(228, '2021_10_04_093401_create_user_payments_table', 9),
(229, '2021_10_17_123955_create_freelancer_workshops_table', 10),
(230, '2021_10_18_103350_create_freelancer_workshop_translations_table', 10),
(231, '2021_10_21_131150_create_freelancer_user_messages_table', 11),
(233, '2021_11_11_095908_create_freelancer_quotations_table', 12),
(234, '2016_06_01_000001_create_oauth_auth_codes_table', 13),
(235, '2016_06_01_000002_create_oauth_access_tokens_table', 13),
(236, '2016_06_01_000003_create_oauth_refresh_tokens_table', 13),
(237, '2016_06_01_000004_create_oauth_clients_table', 13),
(238, '2016_06_01_000005_create_oauth_personal_access_clients_table', 13),
(239, '2021_12_18_161154_create_freelancer_addresses_table', 14),
(240, '2021_12_19_113452_create_user_quotations_table', 15),
(241, '2021_12_19_124925_create_workshop_orders_table', 16),
(242, '2021_12_20_093301_create_quotation_orders_table', 17),
(243, '2021_12_23_094807_update_rate_and_service_id_for_user_orders', 18),
(244, '2022_01_02_120604_create_jobs_table', 19),
(245, '2022_01_02_120624_create_failed_jobs_table', 19),
(251, '2022_01_10_113411_create_date_calenders_table', 20),
(252, '2022_01_12_136821_create_time_calenders_table', 20),
(253, '2022_01_12_137458_create_time_pieces_table', 20),
(254, '2022_01_12_155102_create_meetings_table', 21);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('113ef53fc60b582f303b2bfafcd5b542f62f734f463d3200571fb74e69da2e2bbc4359e7abc4e48c', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-19 16:47:48', '2022-02-19 16:47:48', '2023-02-19 19:47:48'),
('137ea7638cf9538963f72d5da6249f51883158bc756986e422ba92afd62fd90e69b356db4722c281', 2, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-22 07:12:52', '2022-02-22 07:12:52', '2023-02-22 10:12:52'),
('14e24ccb8c6897ad3f9a78766ce824387190696fae9db370ea213c6259a28e51feaa3f36f536778e', 44, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-23 16:38:44', '2022-02-23 16:38:44', '2023-02-23 19:38:44'),
('1d17981c40570e181680b6c9255b70d0e160c165b7988eb396578db2e13163b125d48ce6f929b5cd', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-19 16:38:31', '2022-02-19 16:38:31', '2023-02-19 19:38:31'),
('1eb789739e0a8076fc3df9658dc86d318a4b6b3dee114e8c083704b1c9528fe7a2fa51e21ad052ff', 44, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-16 14:44:29', '2022-02-16 14:44:29', '2023-02-16 17:44:29'),
('31937493ee74da9c1a221ed31384b2204dca40b3666710675e923e95268ec854ca7cac0eee4c50f8', 2, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-14 07:59:40', '2022-02-14 07:59:40', '2023-02-14 10:59:40'),
('31fb790854fe93d819fcbf06de5712e6b67407f9a946f8b4bc2825115c8063ad3715f97513860cef', 2, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-23 06:04:49', '2022-02-23 06:04:49', '2023-02-23 09:04:49'),
('38f7e76d9c7321b700264d40a93576873b968aa9123c798f8de74269e4836c016813b4ba77501d74', 2, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-14 06:46:01', '2022-02-14 06:46:01', '2023-02-14 10:16:01'),
('5346061f1c6045f20d82ddbcb4e492f480ea7048270f97c0915d37b246b02fb7e409af1de0e737a2', 27, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-16 09:46:01', '2022-02-16 09:46:01', '2023-02-16 12:46:01'),
('606f31275c5696463438c1d2681bb4f390cfbfb12d7eaac4673391f2c7212dfe879fb08d00c83ea8', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-16 07:04:06', '2022-02-16 07:04:06', '2023-02-16 10:04:06'),
('607862e0c1e14ce28073011d498689bf950534d0279e24ad372bd6ce1b4ac897c7c449c7802dbd7d', 2, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-14 08:00:08', '2022-02-14 08:00:08', '2023-02-14 11:00:08'),
('6b2daaed2c9f841557d2d64706417dbbf5659f7ef72221cac98e84118b1c584c3b0f42e6f6f31ec2', 2, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-14 08:02:02', '2022-02-14 08:02:02', '2023-02-14 11:02:02'),
('7561983f789d9cbe41d66761e055209e8618934e46280cd7ea9cccdd16285833d3d7ce72c5af4d0b', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-15 07:00:31', '2022-02-15 07:00:31', '2023-02-15 10:00:31'),
('7a1a58fcd8f6f6686148c32e659ab67da9382f475a8a655e321f7b15b3e62211b798564792fccbfa', 44, 5, 'freelancer Personal Access Token', '[]', 0, '2022-03-03 06:59:37', '2022-03-03 06:59:37', '2023-03-03 09:59:37'),
('7d1dcb04374f16be89df8e8459c69354a6b19b6f4916671f2fefa860f9c718269809596d930e13a6', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-20 15:59:49', '2022-02-20 15:59:49', '2023-02-20 18:59:49'),
('8442e4250e2d5c902ba11a8091c723d1e54d10293905475187061fd7d9a5a5423d09157f1b186846', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-15 09:07:45', '2022-02-15 09:07:45', '2023-02-15 12:07:45'),
('8702c7e9399b0a4a7f2295ed07bdeae23aae3743a0f5716508ef301fb8839f32d8ce20461df8b67d', 25, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-14 08:32:56', '2022-02-14 08:32:56', '2023-02-14 11:32:56'),
('895ab14b44ab01dca640b5d066747fe04b7ff99f472618aac3c17c07e964446ea48bf5d867b9520a', 2, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-16 07:13:27', '2022-02-16 07:13:27', '2023-02-16 10:13:27'),
('8e4e3ca680b07041ca8cd6033a47b931c995337a11ef9e9a4c23052b872a52451d6d6d7a7b23ac50', 27, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-15 20:26:17', '2022-02-15 20:26:17', '2023-02-15 23:26:17'),
('9655d00c4e8fc47b25607ed782946eb7b487ff7874cde382f2b003c214c6721245f4550ee682a827', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-15 09:07:45', '2022-02-15 09:07:45', '2023-02-15 12:07:45'),
('a1470401117f1d82218cdf2dc6cd34127214575013d9bb66ecbb8ee87b256e5b70a06bde25c80654', 2, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-16 10:49:10', '2022-02-16 10:49:10', '2023-02-16 13:49:10'),
('ab43324c1918f3733973746c000c2907673d5cc4a7f9b03d6d825c632a08c55368db0fced9ad1293', 2, 5, 'freelancer Personal Access Token', '[]', 0, '2022-03-03 07:29:10', '2022-03-03 07:29:10', '2023-03-03 10:29:10'),
('ae917748f48974f3204ef7e57e100762c25bdcf91e09f0b9e36371d6b0cfc1afa323ca28d95f015f', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-15 09:06:09', '2022-02-15 09:06:09', '2023-02-15 12:06:09'),
('b6c10270a365011517742d28e37598e9c64720ab96603d8242bf91c7d65759550d5a7340eb4a76f6', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-15 08:52:09', '2022-02-15 08:52:09', '2023-02-15 11:52:09'),
('d14b4599a02c9436c4d8c25b67568268d96ff34d810c57942f7a854ea8b6b245eefce852bf9f122a', 2, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-14 08:01:31', '2022-02-14 08:01:31', '2023-02-14 11:01:31'),
('d9c8a8f12c4499477999fdd79cce2f0114576b8f94b138834baadd314e9a409ba1f33f88eb335434', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-20 15:59:48', '2022-02-20 15:59:48', '2023-02-20 18:59:48'),
('f25c382261d3d3bb402eaf79aa94931e22df1637bdf044d8497ab8b345c3ce89b463e77b50fa3678', 44, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-17 07:44:48', '2022-02-17 07:44:48', '2023-02-17 10:44:48'),
('f347015264a0d2010a744585e08668781b36ad6b97d5a97d2a5b85fe32a231b29fd26120652d8742', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-16 07:04:05', '2022-02-16 07:04:05', '2023-02-16 10:04:05'),
('f6fabb02858385bf400ad32978420cbcaf365da554a563a0a974866415fdd23e90e53fb3b5a4a262', 32, 5, 'freelancer Personal Access Token', '[]', 0, '2022-02-15 09:04:01', '2022-02-15 09:04:01', '2023-02-15 12:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'frelancer Personal Access Client', 'sKHfBugQRAJZyDqGqLUUJb2AABOt7FjSHY2FR5fs', 'http://localhost', 1, 0, 0, '2021-11-14 07:43:43', '2021-11-14 07:43:43'),
(2, NULL, 'frelancer Password Grant Client', 'BaL1BcxUDq2NblmpSvq4VCQe84MrEhUTmA8DYhRr', 'http://localhost', 0, 1, 0, '2021-11-14 07:43:43', '2021-11-14 07:43:43'),
(3, NULL, 'frelancer Personal Access Client', 'p2w2P12cDzOwGLmMgZpiC1MNgyAdMGzYZkaRxcZF', 'http://localhost', 1, 0, 0, '2021-11-14 08:01:28', '2021-11-14 08:01:28'),
(4, NULL, 'frelancer Password Grant Client', 'bjHr5OV0a3R4cQOTFgbYn8tKTQR0LNME2p4r6utJ', 'http://localhost', 0, 1, 0, '2021-11-14 08:01:28', '2021-11-14 08:01:28'),
(5, NULL, 'frelancer Personal Access Client', '83nwqcfyxWskPMf7AyX4cYPhpEhMnioMj4EruNsw', 'http://localhost', 1, 0, 0, '2021-11-14 08:09:11', '2021-11-14 08:09:11'),
(6, NULL, 'frelancer Password Grant Client', 'FPdQuJTr7Bmt0oXraKj1Noj0nKRJ2qcusHS6BU3o', 'http://localhost', 0, 1, 0, '2021-11-14 08:09:11', '2021-11-14 08:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-11-14 07:43:43', '2021-11-14 07:43:43'),
(2, 3, '2021-11-14 08:01:28', '2021-11-14 08:01:28'),
(3, 5, '2021-11-14 08:09:11', '2021-11-14 08:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `order_track` varchar(255) NOT NULL,
  `package_id` bigint(20) NOT NULL,
  `freelancer_id` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `error` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_track`, `package_id`, `freelancer_id`, `amount`, `payment_status`, `status`, `payment_id`, `result`, `error`, `order_status`, `created_at`, `updated_at`) VALUES
(22, '29558392', 1, '25', 100, 'paid', '1', '100202135985220024', 'CAPTURED', 'Transaction Success', NULL, '2021-12-25 10:53:47', '2021-12-25 10:23:47');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(191,2) NOT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `duration_title`, `price`, `duration`, `description`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'plan A', '1 MONTH', 100.00, '30', '1 MONTH', 3, NULL, '2021-09-22 10:08:14', '2021-10-17 11:40:47'),
(2, 'Plan B', '2 Month', 150.00, '60', 'test2', 2, 1, '2021-09-22 10:14:03', '2022-02-01 11:12:02'),
(4, 'test', '1 MONTH', 100.00, '345', 'test', 1, 1, '2021-10-17 10:19:49', '2022-02-01 11:11:36');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_id`, `created_at`, `updated_at`) VALUES
(1, 'roles-list', 'admin', 3, '2020-02-03 12:35:28', '2020-02-03 12:35:28'),
(2, 'roles-create', 'admin', 3, '2020-02-03 12:35:28', '2020-02-03 12:35:28'),
(3, 'roles-edit', 'admin', 3, '2020-02-03 12:35:28', '2020-02-03 12:35:28'),
(4, 'roles-delete', 'admin', 3, '2020-02-03 12:35:28', '2020-02-03 12:35:28'),
(5, 'menu-list', 'admin', 0, '2020-02-03 12:35:29', '2020-02-03 12:35:29'),
(6, 'menu-create', 'admin', 0, '2020-02-03 12:35:29', '2020-02-03 12:35:29'),
(7, 'menu-edit', 'admin', 0, '2020-02-03 12:35:29', '2020-02-03 12:35:29'),
(8, 'menu-delete', 'admin', 0, '2020-02-03 12:35:29', '2020-02-03 12:35:29'),
(15, 'settings-edit', 'admin', 5, '2020-03-30 12:51:18', '2020-03-30 12:51:18'),
(17, 'logs-list', 'admin', 4, '2020-03-16 12:45:05', '2020-03-16 12:45:05'),
(18, 'logs-list-self-only', 'admin', 4, '2020-03-16 12:45:56', '2020-03-16 12:45:56'),
(19, 'logs-delete', 'admin', 4, '2020-03-16 12:45:13', '2020-03-16 12:45:13'),
(20, 'aboutus-edit', 'admin', 17, '2021-05-18 05:36:37', '2021-05-18 05:36:37'),
(25, 'webpush-list', 'admin', 9, '2021-02-08 07:03:49', '2021-02-08 07:03:49'),
(26, 'webpush-create', 'admin', 9, '2021-02-08 07:03:49', '2021-02-08 07:03:49'),
(27, 'webpush-edit', 'admin', 9, '2021-02-08 07:04:04', '2021-02-08 07:04:04'),
(28, 'webpush-delete', 'admin', 9, '2021-02-08 07:04:04', '2021-02-08 07:04:04'),
(37, 'slideshows-list', 'admin', 12, '2020-04-04 05:44:14', '2020-04-04 05:44:14'),
(38, 'slideshows-create', 'admin', 12, '2021-05-26 09:43:44', '2021-05-26 09:43:44'),
(39, 'slideshows-edit', 'admin', 12, '2020-04-04 05:44:18', '2020-04-04 05:44:18'),
(40, 'slideshows-delete', 'admin', 12, '2020-04-04 05:44:09', '2020-04-04 05:44:09'),
(69, 'subjects-list', 'admin', 8, '2020-02-29 04:56:11', '2020-02-29 04:56:11'),
(70, 'subjects-create', 'admin', 8, '2020-02-29 04:56:01', '2020-02-29 04:56:01'),
(71, 'subjects-edit', 'admin', 8, '2021-05-26 10:28:20', '2021-05-26 10:28:20'),
(72, 'subjects-delete', 'admin', 8, '2020-02-29 04:56:21', '2020-02-29 04:56:21'),
(76, 'career-list', 'admin', 0, '2021-05-17 11:09:17', '2021-05-17 11:09:17'),
(77, 'career-view', 'admin', 0, '2021-05-17 11:09:17', '2021-05-17 11:09:17'),
(78, 'career-delete', 'admin', 0, '2021-05-17 11:09:33', '2021-05-17 11:09:33'),
(241, 'notifyemails-list', 'admin', 6, '2021-07-04 10:08:34', '2021-07-04 10:08:34'),
(242, 'notifyemails-create', 'admin', 6, '2021-07-04 10:08:34', '2021-07-04 10:08:34'),
(243, 'notifyemails-edit', 'admin', 6, '2021-07-04 10:08:51', '2021-07-04 10:08:51'),
(244, 'notifyemails-delete', 'admin', 6, '2021-07-04 10:08:51', '2021-07-04 10:08:51'),
(245, 'messages-list', 'admin', 7, '2021-07-04 12:02:25', '2021-07-04 12:02:25'),
(246, 'messages-view', 'admin', 7, '2021-07-04 12:02:35', '2021-07-04 12:02:35'),
(247, 'messages-delete', 'admin', 7, '2021-07-04 12:02:47', '2021-07-04 12:02:47'),
(253, 'singlepages-list', 'admin', 11, '2021-07-05 12:00:53', '2021-07-05 12:00:53'),
(254, 'singlepages-create', 'admin', 11, '2021-07-05 12:01:09', '2021-07-05 12:01:09'),
(255, 'singlepages-edit', 'admin', 11, '2021-07-05 12:01:23', '2021-07-05 12:01:23'),
(256, 'singlepages-delete', 'admin', 11, '2021-07-05 12:01:38', '2021-07-05 12:01:38'),
(257, 'areas-list', 'admin', 15, '2021-07-06 11:40:52', '2021-07-06 11:40:52'),
(258, 'areas-create', 'admin', 15, '2021-07-06 11:41:06', '2021-07-06 11:41:06'),
(259, 'areas-edit', 'admin', 15, '2021-07-06 11:41:18', '2021-07-06 11:41:18'),
(260, 'areas-delete', 'admin', 15, '2021-07-06 11:41:33', '2021-07-06 11:41:33'),
(261, 'cities-list', 'admin', 14, '2021-07-06 11:58:13', '2021-07-06 11:58:13'),
(262, 'cities-create', 'admin', 14, '2021-07-06 11:58:26', '2021-07-06 11:58:26'),
(263, 'cities-edit', 'admin', 14, '2021-07-06 11:58:38', '2021-07-06 11:58:38'),
(264, 'cities-delete', 'admin', 14, '2021-07-06 11:58:51', '2021-07-06 11:58:51'),
(265, 'countries-list', 'admin', 13, '2021-07-10 09:05:04', '2021-07-10 09:05:04'),
(266, 'countries-create', 'admin', 13, '2021-07-10 09:05:15', '2021-07-10 09:05:15'),
(267, 'countries-edit', 'admin', 13, '2021-07-10 09:05:27', '2021-07-10 09:05:27'),
(268, 'countries-delete', 'admin', 13, '2021-07-10 09:05:38', '2021-07-10 09:05:38'),
(269, 'admins-list', 'admin', 1, '2021-07-10 09:06:00', '2021-07-10 09:06:00'),
(270, 'admins-view', 'admin', 1, '2021-07-10 09:06:17', '2021-07-10 09:06:17'),
(271, 'admins-create', 'admin', 1, '2021-07-10 09:06:30', '2021-07-10 09:06:30'),
(272, 'admins-edit', 'admin', 1, '2021-07-10 09:06:44', '2021-07-10 09:06:44'),
(273, 'admins-delete', 'admin', 1, '2021-07-10 09:07:01', '2021-07-10 09:07:01'),
(274, 'admins-changepass', 'admin', 1, '2021-07-10 11:01:19', '2021-07-10 11:01:19'),
(275, 'users-list', 'admin', 2, '2021-07-12 05:00:38', '2021-07-12 05:00:38'),
(276, 'users-create', 'admin', 2, '2021-07-12 05:00:50', '2021-07-12 05:00:50'),
(277, 'users-view', 'admin', 2, '2021-07-12 05:01:04', '2021-07-12 05:01:04'),
(278, 'users-edit', 'admin', 2, '2021-07-12 05:01:14', '2021-07-12 05:01:14'),
(279, 'users-delete', 'admin', 2, '2021-07-12 05:01:25', '2021-07-12 05:01:25'),
(280, 'users-changepass', 'admin', 2, '2021-07-12 05:01:37', '2021-07-12 05:01:37'),
(281, 'durations-list', 'admin', 16, '2021-07-12 11:17:27', '2021-07-12 11:17:27'),
(282, 'durations-create', 'admin', 16, '2021-07-12 11:17:40', '2021-07-12 11:17:40'),
(283, 'durations-edit', 'admin', 16, '2021-07-12 11:17:56', '2021-07-12 11:17:56'),
(284, 'durations-delete', 'admin', 16, '2021-07-12 11:18:23', '2021-07-12 11:18:23'),
(285, 'sms-edit', 'admin', 10, '2021-07-13 05:49:07', '2021-07-13 05:49:07'),
(286, 'packages-list', 'admin', 18, '2021-07-17 05:10:55', '2021-07-17 05:10:55'),
(287, 'packages-create', 'admin', 18, '2021-07-17 05:11:13', '2021-07-17 05:11:13'),
(288, 'packages-edit', 'admin', 18, '2021-07-17 05:11:28', '2021-07-17 05:11:28'),
(289, 'packages-delete', 'admin', 18, '2021-07-17 05:11:45', '2021-07-17 05:11:45'),
(290, 'packagegalleries-list', 'admin', 19, '2021-07-18 12:09:06', '2021-07-18 12:09:06'),
(291, 'packagegalleries-create', 'admin', 19, '2021-07-18 12:10:08', '2021-07-18 12:10:08'),
(292, 'packagegalleries-edit', 'admin', 19, '2021-07-18 12:10:21', '2021-07-18 12:10:21'),
(293, 'packagegalleries-delete', 'admin', 19, '2021-07-18 12:10:33', '2021-07-18 12:10:33'),
(294, 'coupons-list', 'admin', 20, '2021-07-19 06:02:36', '2021-07-19 06:02:36'),
(295, 'coupons-create', 'admin', 20, '2021-07-19 06:03:35', '2021-07-19 06:03:35'),
(296, 'coupons-edit', 'admin', 20, '2021-07-19 06:05:05', '2021-07-19 06:05:05'),
(297, 'coupons-delete', 'admin', 20, '2021-07-19 06:05:19', '2021-07-19 06:05:19'),
(298, 'orders-list', 'admin', 21, '2021-07-20 05:36:43', '2021-07-20 05:36:43'),
(299, 'orders-view', 'admin', 21, '2021-07-20 05:36:43', '2021-07-20 05:36:43'),
(300, 'orders-print', 'admin', 21, '2021-07-31 05:04:25', '2021-07-31 05:04:25'),
(301, 'orders-edit', 'admin', 21, '2021-07-31 05:04:43', '2021-07-31 05:04:43'),
(302, 'orders-delete', 'admin', 21, '2021-07-31 05:05:00', '2021-07-31 05:05:00'),
(303, 'transactions-list', 'admin', 22, '2021-08-15 12:30:07', '2021-08-15 12:30:07'),
(304, 'transactions-view', 'admin', 22, '2021-08-15 12:30:20', '2021-08-15 12:30:20'),
(305, 'transactions-print', 'admin', 22, '2021-08-15 12:30:37', '2021-08-15 12:30:37'),
(306, 'transactions-edit', 'admin', 22, '2021-08-15 12:31:00', '2021-08-15 12:31:00'),
(307, 'transactions-delete', 'admin', 22, '2021-08-15 12:31:13', '2021-08-15 12:31:13'),
(308, 'categories-list', 'admin', 23, '2021-09-11 10:37:06', '2021-09-11 10:37:06'),
(309, 'categories-create', 'admin', 23, '2021-09-11 10:38:14', '2021-09-11 10:38:14'),
(310, 'categories-edit', 'admin', 23, '2021-09-11 10:38:27', '2021-09-11 10:38:27'),
(311, 'categories-delete', 'admin', 23, '2021-09-11 10:38:42', '2021-09-11 10:38:42'),
(312, 'attributes-list', 'admin', 24, '2021-09-11 10:37:06', '2021-09-11 10:37:06'),
(313, 'attributes-create', 'admin', 24, '2021-09-11 10:38:14', '2021-09-11 10:38:14'),
(314, 'attributes-edit', 'admin', 24, '2021-09-11 10:38:27', '2021-09-11 10:38:27'),
(315, 'attributes-delete', 'admin', 24, '2021-09-11 10:38:42', '2021-09-11 10:38:42'),
(316, 'attribute-groups-list', 'admin', 25, '2021-09-13 05:42:40', '2021-09-13 05:42:40'),
(317, 'attribute-groups-edit', 'admin', 25, '2021-09-13 05:42:45', '2021-09-13 05:42:45'),
(318, 'attribute-groups-create', 'admin', 25, '2021-09-13 05:43:40', '2021-09-13 05:42:45'),
(319, 'attribute-groups-delete', 'admin', 25, '2021-09-13 05:43:40', '2021-09-13 05:42:45'),
(320, 'products-list', 'admin', 26, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(321, 'products-edit', 'admin', 26, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(322, 'products-create', 'admin', 26, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(323, 'products-delete', 'admin', 26, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(324, 'address-list', 'admin', 26, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(325, 'address-edit', 'admin', 26, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(326, 'address-create', 'admin', 26, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(327, 'address-delete', 'admin', 26, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(328, 'freelancers-list', 'admin', 27, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(329, 'freelancers-edit', 'admin', 27, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(330, 'freelancers-create', 'admin', 27, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(331, 'freelancers-delete', 'admin', 27, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(332, 'slideshows-list', 'admin', 28, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(333, 'slideshows-edit', 'admin', 28, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(334, 'slideshows-create', 'admin', 28, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(335, 'slideshows-delete', 'admin', 28, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(336, 'packages-list', 'admin', 29, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(337, 'packages-edit', 'admin', 29, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(338, 'packages-create', 'admin', 29, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(339, 'packages-delete', 'admin', 29, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(340, 'howitworks-list', 'admin', 29, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(341, 'howitworks-edit', 'admin', 29, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(342, 'howitworks-create', 'admin', 29, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(343, 'howitworks-delete', 'admin', 29, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(344, 'wishlist-list', 'admin', 30, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(345, 'wishlist-edit', 'admin', 30, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(346, 'wishlist-delete', 'admin', 30, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(347, 'wishlist-create', 'admin', 30, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(348, 'user-orders-create', 'admin', 31, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(349, 'user-orders-edit', 'admin', 31, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(350, 'user-orders-delete', 'admin', 31, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(351, 'user-orders-list', 'admin', 31, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(352, 'user-payments-create', 'admin', 32, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(353, 'user-payments-edit', 'admin', 32, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(354, 'user-payments-delete', 'admin', 32, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(355, 'user-payments-list', 'admin', 32, '2021-09-13 11:00:07', '2021-09-13 11:00:07'),
(356, 'workshops-list', 'admin', 33, '2021-12-07 13:04:59', '2021-12-07 13:04:59'),
(357, 'workshops-edit', 'admin', 34, '2021-12-07 13:05:04', '2021-12-07 13:05:04'),
(358, 'workshops-delete', 'admin', 34, '2021-12-07 13:05:04', '2021-12-07 13:05:04'),
(360, 'quotation-orders-list', 'admin', 35, '2021-12-20 06:52:40', '2021-12-20 06:52:40'),
(361, 'quotation-orders-delete', 'admin', 35, '2021-12-20 06:52:58', '2021-12-20 06:52:58'),
(363, 'quotation-orders-view', 'admin', 35, '2021-12-20 06:53:42', '2021-12-20 06:53:42'),
(364, 'meetings-list', 'admin', 36, '2022-01-12 12:59:18', '2022-01-12 12:59:18'),
(365, 'meetings-edit', 'admin', 36, '2022-01-12 12:59:18', '2022-01-12 12:59:18'),
(366, 'meetings-create', 'admin', 36, '2022-01-12 12:59:18', '2022-01-12 12:59:18'),
(367, 'meetings-delete', 'admin', 36, '2022-01-12 12:59:18', '2022-01-12 12:59:18');

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `title`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'Admins', 1, '2021-07-14 06:35:32', '2021-07-14 06:35:32'),
(2, 'Users', 2, '2021-07-14 06:36:07', '2021-07-14 06:36:07'),
(3, 'Roles', 3, '2021-07-14 06:38:07', '2021-07-14 06:38:07'),
(4, 'Logs', 4, '2021-07-14 06:39:26', '2021-07-14 06:39:26'),
(5, 'Settings', 5, '2021-07-14 06:42:45', '2021-07-14 06:42:45'),
(6, 'Notify Emails', 6, '2021-07-14 06:43:48', '2021-07-14 06:43:48'),
(7, 'Messages', 7, '2021-07-14 06:44:49', '2021-07-14 06:44:49'),
(8, 'Subjects', 8, '2021-07-14 06:45:35', '2021-07-14 06:45:35'),
(9, 'WebPush', 9, '2021-07-14 06:47:06', '2021-07-14 06:47:06'),
(10, 'SMS', 10, '2021-07-14 06:47:57', '2021-07-14 06:47:57'),
(11, 'Single Pages', 11, '2021-07-14 06:49:42', '2021-07-14 06:49:42'),
(12, 'SlideShows', 12, '2021-07-14 06:50:30', '2021-07-14 06:50:30'),
(13, 'Countries', 13, '2021-07-14 06:51:58', '2021-07-14 06:51:58'),
(14, 'Cities', 14, '2021-07-14 06:52:37', '2021-07-14 06:52:37'),
(15, 'Areas', 15, '2021-07-14 06:53:21', '2021-07-14 06:53:21'),
(16, 'Package Durations', 16, '2021-07-14 06:54:30', '2021-07-14 06:54:30'),
(17, 'About us', 17, '2021-07-14 06:55:14', '2021-07-14 06:55:14'),
(18, 'Packages', 18, '2021-07-17 05:10:45', '2021-07-17 05:10:45'),
(19, 'Package Galleries', 19, '2021-07-18 12:08:53', '2021-07-18 12:08:53'),
(20, 'Coupons', 20, '2021-07-19 06:02:28', '2021-07-19 06:02:28'),
(21, 'Orders', 21, '2021-07-20 05:36:00', '2021-07-20 05:36:00'),
(22, 'Transactions', 22, '2021-08-15 12:29:08', '2021-08-15 12:29:08'),
(23, 'Categories', 23, '2021-09-11 10:37:45', '2021-09-11 10:37:45'),
(24, 'Attributes', 24, '2021-09-12 11:35:27', '2021-09-12 11:35:27'),
(25, 'Attribute Groups', 25, '2021-09-13 05:44:53', '2021-09-13 05:44:53'),
(26, 'Products', 26, '2021-09-13 11:03:47', '2021-09-13 11:03:47'),
(27, 'Freelancer', 27, '2021-09-20 07:34:02', '2021-09-20 07:34:02'),
(28, 'Slideshows', 28, '2021-09-20 07:34:13', '2021-09-20 07:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `price` bigint(20) NOT NULL,
  `final_price` bigint(20) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL,
  `new` tinyint(1) NOT NULL DEFAULT 0,
  `best` tinyint(1) NOT NULL DEFAULT 0,
  `special_discount` tinyint(1) NOT NULL DEFAULT 0,
  `attr_id` int(10) UNSIGNED NOT NULL,
  `attr` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`attr`)),
  `count_existing` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `payment_type` enum('Full Payment','Half') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Full Payment',
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `latitude` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `user_id`, `freelancer_id`, `date`, `payment_type`, `address_id`, `latitude`, `longitude`, `area`, `address`, `client_name`, `location_type`, `created_at`, `updated_at`) VALUES
(4, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-01-31 13:02:26', '2022-02-14 08:33:20'),
(5, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-02-08 06:58:22', '2022-02-08 06:58:22'),
(7, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-02-08 07:05:22', '2022-02-08 07:05:22'),
(8, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-02-12 07:25:07', '2022-02-12 07:25:07'),
(9, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-02-14 07:48:49', '2022-02-14 07:48:49'),
(10, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-02-14 07:54:53', '2022-02-14 07:54:53'),
(11, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-02-14 07:56:26', '2022-02-14 07:56:26'),
(12, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-02-14 07:57:22', '2022-02-14 07:57:22'),
(13, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-02-14 08:08:21', '2022-02-14 08:08:21'),
(14, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-02-14 08:10:44', '2022-02-14 08:10:44'),
(15, 2, 25, '2022-01-25', '', 12, '10.0', '20.0', 'test area', 'test address', 'client name', 'Home', '2022-02-14 08:33:19', '2022-02-14 08:33:19');

-- --------------------------------------------------------

--
-- Table structure for table `quotations_installment`
--

CREATE TABLE `quotations_installment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED NOT NULL,
  `number` int(11) DEFAULT NULL,
  `percent` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations_installment`
--

INSERT INTO `quotations_installment` (`id`, `quotation_id`, `number`, `percent`, `price`, `created_at`, `updated_at`) VALUES
(13, 5, 1, 20, 400, '2022-02-08 06:58:22', '2022-02-08 06:58:22'),
(14, 5, 2, 20, 400, '2022-02-08 06:58:22', '2022-02-08 06:58:22'),
(15, 5, 3, 60, 1200, '2022-02-08 06:58:22', '2022-02-08 06:58:22'),
(22, 7, 1, 20, 400, '2022-02-08 07:05:22', '2022-02-08 07:05:22'),
(23, 7, 2, 20, 400, '2022-02-08 07:05:22', '2022-02-08 07:05:22'),
(24, 7, 3, 60, 1200, '2022-02-08 07:05:22', '2022-02-08 07:05:22'),
(28, 8, 1, 1, 20, '2022-02-12 07:25:07', '2022-02-12 07:25:07'),
(29, 8, 2, 1, 20, '2022-02-12 07:25:07', '2022-02-12 07:25:07'),
(30, 8, 3, 3, 60, '2022-02-12 07:25:07', '2022-02-12 07:25:07'),
(31, 9, 1, 1, 20, '2022-02-14 07:48:49', '2022-02-14 07:48:49'),
(32, 9, 2, 1, 20, '2022-02-14 07:48:49', '2022-02-14 07:48:49'),
(33, 9, 3, 3, 60, '2022-02-14 07:48:49', '2022-02-14 07:48:49'),
(37, 10, 1, 1, 20, '2022-02-14 07:54:53', '2022-02-14 07:54:53'),
(38, 10, 2, 1, 20, '2022-02-14 07:54:53', '2022-02-14 07:54:53'),
(39, 10, 3, 3, 60, '2022-02-14 07:54:53', '2022-02-14 07:54:53'),
(43, 11, 1, 1, 20, '2022-02-14 07:56:26', '2022-02-14 07:56:26'),
(44, 11, 2, 1, 20, '2022-02-14 07:56:26', '2022-02-14 07:56:26'),
(45, 11, 3, 3, 60, '2022-02-14 07:56:26', '2022-02-14 07:56:26'),
(49, 12, 1, 1, 20, '2022-02-14 07:57:22', '2022-02-14 07:57:22'),
(50, 12, 2, 1, 20, '2022-02-14 07:57:22', '2022-02-14 07:57:22'),
(51, 12, 3, 3, 60, '2022-02-14 07:57:22', '2022-02-14 07:57:22'),
(55, 13, 1, 1, 20, '2022-02-14 08:08:21', '2022-02-14 08:08:21'),
(56, 13, 2, 1, 20, '2022-02-14 08:08:21', '2022-02-14 08:08:21'),
(57, 13, 3, 3, 60, '2022-02-14 08:08:21', '2022-02-14 08:08:21'),
(61, 14, 1, 1, 20, '2022-02-14 08:10:44', '2022-02-14 08:10:44'),
(62, 14, 2, 1, 20, '2022-02-14 08:10:44', '2022-02-14 08:10:44'),
(63, 14, 3, 3, 60, '2022-02-14 08:10:44', '2022-02-14 08:10:44'),
(67, 15, 1, 1, 20, '2022-02-14 08:33:19', '2022-02-14 08:33:19'),
(68, 15, 2, 1, 20, '2022-02-14 08:33:19', '2022-02-14 08:33:19'),
(69, 15, 3, 3, 60, '2022-02-14 08:33:19', '2022-02-14 08:33:19'),
(70, 4, 1, 20, 400, '2022-02-14 08:33:20', '2022-02-14 08:33:20'),
(71, 4, 2, 20, 400, '2022-02-14 08:33:20', '2022-02-14 08:33:20'),
(72, 4, 3, 60, 1200, '2022-02-14 08:33:20', '2022-02-14 08:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `quotations_service`
--

CREATE TABLE `quotations_service` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations_service`
--

INSERT INTO `quotations_service` (`id`, `quotation_id`, `name`, `description`, `quantity`, `price`, `attachment`, `created_at`, `updated_at`) VALUES
(10, 5, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-08 06:58:22', '2022-02-08 06:58:22'),
(11, 5, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-08 06:58:22', '2022-02-08 06:58:22'),
(16, 7, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-08 07:05:22', '2022-02-08 07:05:22'),
(17, 7, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-08 07:05:22', '2022-02-08 07:05:22'),
(20, 8, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-12 07:25:07', '2022-02-12 07:25:07'),
(21, 8, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-12 07:25:07', '2022-02-12 07:25:07'),
(22, 9, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-14 07:48:49', '2022-02-14 07:48:49'),
(23, 9, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-14 07:48:49', '2022-02-14 07:48:49'),
(26, 10, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-14 07:54:53', '2022-02-14 07:54:53'),
(27, 10, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-14 07:54:53', '2022-02-14 07:54:53'),
(30, 11, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-14 07:56:26', '2022-02-14 07:56:26'),
(31, 11, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-14 07:56:26', '2022-02-14 07:56:26'),
(34, 12, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-14 07:57:22', '2022-02-14 07:57:22'),
(35, 12, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-14 07:57:22', '2022-02-14 07:57:22'),
(38, 13, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-14 08:08:21', '2022-02-14 08:08:21'),
(39, 13, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-14 08:08:21', '2022-02-14 08:08:21'),
(42, 14, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-14 08:10:44', '2022-02-14 08:10:44'),
(43, 14, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-14 08:10:44', '2022-02-14 08:10:44'),
(46, 15, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-14 08:33:19', '2022-02-14 08:33:19'),
(47, 15, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-14 08:33:19', '2022-02-14 08:33:19'),
(48, 4, 'name service 1', 'description service 1', 10, 1000, NULL, '2022-02-14 08:33:20', '2022-02-14 08:33:20'),
(49, 4, 'name service 2', 'description service 2', 10, 1000, NULL, '2022-02-14 08:33:20', '2022-02-14 08:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_orders`
--

CREATE TABLE `quotation_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED NOT NULL,
  `order_track` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `result` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `error` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number_people` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `rate` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `number_people`, `rate`, `created_at`, `updated_at`) VALUES
(1, 0, 3.00, '2021-09-20 04:56:19', '2021-09-20 04:56:19'),
(2, 0, 3.00, '2021-09-21 04:38:07', '2021-09-21 04:38:07'),
(3, 0, 3.00, '2021-09-21 07:39:04', '2021-09-21 07:39:04'),
(4, 0, 2.00, '2021-10-13 06:56:52', '2021-10-13 06:56:52'),
(5, 0, 2.00, '2021-10-13 06:57:12', '2021-10-13 06:57:12'),
(6, 1, 1.00, '2021-10-18 06:03:51', '2021-12-28 06:52:05'),
(7, 0, 3.00, '2021-10-18 06:12:04', '2021-10-18 06:12:04'),
(8, 0, 4.00, '2021-10-18 06:12:34', '2021-10-18 06:12:34'),
(9, 1, 5.00, '2021-11-09 09:38:51', '2022-01-18 12:05:44'),
(10, 0, 4.00, '2021-11-10 07:35:03', '2021-11-10 07:35:03'),
(11, 0, 4.00, '2021-11-10 07:48:06', '2021-11-10 07:48:06'),
(12, 0, 5.00, '2021-11-10 07:49:00', '2021-11-10 07:49:00'),
(13, 0, 5.00, '2021-11-10 07:51:22', '2021-11-10 07:51:22'),
(14, 0, 5.00, '2021-11-10 07:52:39', '2021-11-10 07:52:39'),
(15, 0, 5.00, '2021-11-10 07:53:28', '2021-11-10 07:53:28'),
(16, 0, 0.00, '2022-02-01 13:32:14', '2022-02-01 13:32:14');

-- --------------------------------------------------------

--
-- Table structure for table `report_messages`
--

CREATE TABLE `report_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `freelancer_id` bigint(20) NOT NULL,
  `sendFrom` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `report_messages`
--

INSERT INTO `report_messages` (`id`, `user_id`, `freelancer_id`, `sendFrom`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 25, 'Freelancer', 0, '2022-01-31 13:02:41', '2022-01-31 13:02:41'),
(2, 2, 25, 'Freelancer', 0, '2022-02-08 06:59:20', '2022-02-08 06:59:20'),
(3, 2, 25, 'Freelancer', 0, '2022-02-08 07:05:30', '2022-02-08 07:05:30'),
(4, 2, 25, 'Freelancer', 0, '2022-02-14 07:57:47', '2022-02-14 07:57:47'),
(5, 2, 25, 'Freelancer', 0, '2022-02-14 08:11:01', '2022-02-14 08:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', '2020-02-03 12:35:44', '2020-02-03 12:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(269, 1),
(270, 1),
(271, 1),
(272, 1),
(273, 1),
(274, 1),
(275, 1),
(276, 1),
(277, 1),
(278, 1),
(279, 1),
(280, 1),
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(17, 1),
(18, 1),
(19, 1),
(15, 1),
(241, 1),
(242, 1),
(243, 1),
(244, 1),
(245, 1),
(246, 1),
(247, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(285, 1),
(253, 1),
(254, 1),
(255, 1),
(256, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(265, 1),
(266, 1),
(267, 1),
(268, 1),
(261, 1),
(262, 1),
(263, 1),
(264, 1),
(257, 1),
(258, 1),
(259, 1),
(260, 1),
(281, 1),
(282, 1),
(283, 1),
(284, 1),
(20, 1),
(286, 1),
(287, 1),
(288, 1),
(289, 1),
(290, 1),
(291, 1),
(292, 1),
(293, 1),
(294, 1),
(295, 1),
(296, 1),
(297, 1),
(298, 1),
(299, 1),
(300, 1),
(301, 1),
(302, 1),
(303, 1),
(304, 1),
(305, 1),
(306, 1),
(307, 1),
(308, 1),
(309, 1),
(310, 1),
(311, 1),
(312, 1),
(313, 1),
(314, 1),
(315, 1),
(316, 1),
(317, 1),
(318, 1),
(319, 1),
(320, 1),
(321, 1),
(322, 1),
(323, 1),
(324, 1),
(325, 1),
(326, 1),
(327, 1),
(328, 1),
(329, 1),
(330, 1),
(331, 1),
(332, 1),
(333, 1),
(334, 1),
(335, 1),
(336, 1),
(337, 1),
(338, 1),
(339, 1),
(340, 1),
(341, 1),
(342, 1),
(343, 1),
(344, 1),
(345, 1),
(346, 1),
(347, 1),
(348, 1),
(349, 1),
(350, 1),
(351, 1),
(352, 1),
(353, 1),
(354, 1),
(355, 1),
(356, 1),
(357, 1),
(358, 1),
(360, 1),
(361, 1),
(363, 1),
(364, 1),
(365, 1),
(366, 1),
(367, 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_user_orders`
--

CREATE TABLE `service_user_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `rate` double(8,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `people` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` float NOT NULL DEFAULT 0,
  `earn` float NOT NULL DEFAULT 0,
  `commission` float NOT NULL DEFAULT 0,
  `freelancer_location_id` bigint(20) DEFAULT NULL,
  `user_location_id` bigint(20) DEFAULT NULL,
  `status` enum('preorder','booked','freelancer_reschedule','freelancer_cancel','freelancer_not_available','user_reschedule','user_cancel','user_not_available','admin_reschedule','admin_cancel','completed','not_pay') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'preorder',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_user_orders`
--

INSERT INTO `service_user_orders` (`id`, `order_id`, `service_id`, `freelancer_id`, `rate`, `date`, `time`, `people`, `price`, `earn`, `commission`, `freelancer_location_id`, `user_location_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(91, 79, 31, 25, NULL, '2022-02-28', '10:10:00', '1', 1000, 990, 10, 21, NULL, 'booked', NULL, '2022-02-10 07:41:37', '2022-02-10 07:41:37'),
(92, 79, 30, 25, NULL, '2022-12-28', '10:22:06', '1', 1000, 990, 10, NULL, 30, 'booked', NULL, '2022-02-10 07:41:37', '2022-02-10 07:41:37'),
(93, 81, 31, 25, NULL, '2022-03-12', '10:10:00', '1', 1000, 990, 10, 21, NULL, 'booked', NULL, '2022-02-10 07:41:37', '2022-02-10 07:41:37'),
(94, 81, 30, 25, NULL, '2022-03-11', '10:22:06', '1', 1000, 990, 10, NULL, 30, 'booked', NULL, '2022-02-10 07:41:37', '2022-02-10 07:41:37');

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_translations`
--

CREATE TABLE `shipping_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slideshows`
--

CREATE TABLE `slideshows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_or_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slideshows`
--

INSERT INTO `slideshows` (`id`, `title_en`, `title_ar`, `link`, `type`, `link_or_id`, `image`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'قلث', 'لقل', 'لیقلیقل', 'Category', '456456', 'slideshows-image-2ac8b819e531936d884eb5cc89496ed0.jpg', 14, 1, '2021-09-20 09:08:17', '2022-02-02 06:42:51');

-- --------------------------------------------------------

--
-- Table structure for table `time_calenders`
--

CREATE TABLE `time_calenders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `buffer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_buffer` time DEFAULT NULL,
  `status` enum('free','booked','preorder') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bookedable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bookedable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_calenders`
--

INSERT INTO `time_calenders` (`id`, `freelancer_id`, `date`, `start_time`, `end_time`, `buffer`, `end_buffer`, `status`, `created_at`, `updated_at`, `bookedable_id`, `bookedable_type`) VALUES
(44, 25, '2022-02-19', '10:10:00', '12:10:00', '15', '12:25:00', 'booked', '2022-02-08 11:38:41', '2022-02-10 07:41:37', 91, 'App\\ServiceUserOrders'),
(45, 25, '2022-03-10', '12:25:00', '14:30:00', '60', '15:30:00', 'booked', '2022-02-08 11:38:41', '2022-02-12 07:01:39', 25, 'App\\Meeting'),
(46, 25, '2022-02-20', '10:10:00', '12:10:00', '0', '12:10:00', 'free', '2022-02-08 11:38:41', '2022-02-08 11:38:41', NULL, NULL),
(47, 25, '2022-02-20', '12:10:00', '15:10:00', '10', '15:20:00', 'free', '2022-02-08 11:38:41', '2022-02-08 11:38:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `mobile`, `email`, `birthday`, `image`, `gender`, `password`, `is_active`, `remember_token`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(2, 'soheil', 'mehramdish', '09307199929', 'so@gmail.com', '2021-09-18', 'users-image-0dd64537cb487f478055e6f374ee28c3.jpg', 'male', '$2y$10$YVvHiMtFaFcmr17X2lRqQu6XJ/otysMGeKaztBkIlazcvCPCZPKRW', 1, NULL, NULL, '2021-09-18 06:20:40', '2022-01-24 12:15:12'),
(3, 'یشسی', 'یشسی', '96566444569', 'admin@gmail.com', NULL, 'users-image-0dd64537cb487f478055e6f374ee28c3.jpg', NULL, '$2y$10$YkPqU34nFBffw5M6tWnkeuwvD0FlvRdZR7K9wRN0FyOJMAEdsY0va', 1, NULL, NULL, '2021-10-17 12:33:21', '2021-10-17 12:33:21'),
(21, 'mehdi', 'jahandide', '96566444569', 'sa@gmail.comm', '2022-01-17', 'users-image-e0737a7f4b3505f62e8bb9f5460ae90b.jpg', 'male', '$2y$10$ByOJI7att4iyv0VNiO2Ho.9/ihOcM5CitJUqnD21rvgUdRRlvYF5u', 1, NULL, NULL, '2021-11-14 10:35:27', '2022-01-17 14:34:30'),
(27, 'Sadegh', 'Doroudi', '09366696893', 'sddm10@yahoo.com', '2022-02-01', 'users-image-01ebef9eb3f5abe37679175050bcd538.jpg', 'male', '$2y$10$91wwcEOUMFcY2C0R3zZqyecP67z56Mh3Lmt6hLqM2yrTfLANsEuKG', 1, NULL, NULL, '2022-01-17 12:26:43', '2022-02-01 11:36:19'),
(28, 'Sadegh', 'Doroudi', '09366696893', 'sddm20@yahoo.com', '2022-02-01', 'users-image-4f20e886f53c8b7abbd7b19787e6a9ec.jpg', 'male', '$2y$10$SdKEFJhoKFlA/OuNzYrdNO8VC.W8td2npgM9pvwGlurt7ppzVbDwq', 1, NULL, NULL, '2022-01-17 12:30:50', '2022-02-01 11:33:15'),
(29, 'test', 'user', '12345678', 'test@test.com', NULL, NULL, 'male', '$2y$10$QXawrvN0m6LZZ31lOvMtAulJ0jHMijQ7qIZh4G37L49Zw/ucY1cjS', 1, NULL, NULL, '2022-01-17 17:49:06', '2022-01-17 17:49:06'),
(30, 'anfal', 'alsamhan', '67772237', 'aalsamhan@dealsco.app', NULL, NULL, 'female', '$2y$10$IqVpNRFfGEDi4nW1UZZLbu3dYSSUReqcpq/SjIBvPzERXaIu2WGAW', 1, NULL, NULL, '2022-01-18 19:24:27', '2022-01-18 19:24:27'),
(31, 'ss', 'ss', '093071999299', 'soheiildd@gmail.com', NULL, NULL, 'male', '$2y$10$vbKUIhg.4s.ue0e0ouulueZdd2FNjzDFLW9DkR7sWyOm2SZvRfXJS', 1, NULL, NULL, '2022-01-19 09:35:54', '2022-01-19 09:35:54'),
(32, 'ss', 'ss', '093071999299', 'soheiilddd@gmail.com', NULL, NULL, 'male', '$2y$10$hUGR.D/2UtXnf58u8DBEdemHH0bmaVUNfv9j9HSMSUoiuRR7P1uOq', 1, NULL, NULL, '2022-01-19 09:38:05', '2022-01-19 09:38:05'),
(33, 'ss', 'ss', '093071999299', 'soheiilddfd@gmail.com', NULL, NULL, 'male', '$2y$10$ol3VfmMEPrL/t1p7McXZUOxVR3q9q8FbaMUH2/N6aNUAzYWzvmRPa', 1, NULL, NULL, '2022-01-19 09:46:35', '2022-01-19 09:46:35'),
(34, 'ss', 'ss', '093071999299', 'soheiilfddfd@gmail.com', NULL, NULL, 'male', '$2y$10$Oab6nKtsllYKFXhNlIsb2ePoRqwikB/.Am95yWww2p4MsJ4PHTklu', 1, NULL, NULL, '2022-01-19 09:47:35', '2022-01-19 09:47:35'),
(35, 'ss', 'ss', '093071999299', 'soheiilfddfsd@gmail.com', NULL, NULL, 'male', '$2y$10$I2ZWabIYqFaYxOvqRHRzjO9szizMnn1/ZkD8LJ.KYb/tAMKLsAIly', 1, NULL, NULL, '2022-01-19 09:54:16', '2022-01-19 09:54:16'),
(36, 'ss', 'ss', '093071999299', NULL, NULL, NULL, 'male', '$2y$10$OpYUJcmhO6y0i8hFys0mi.MwzfyOmXv0s0JTQbhdm3iMh1h7YQwj2', 1, NULL, NULL, '2022-01-19 10:09:58', '2022-01-19 10:09:58'),
(37, 'Reza', 'Doroudi', '09366696893', NULL, NULL, NULL, 'male', '$2y$10$iJ8jEIspQhcVRDNO68p53eYvRlJYOgrrB1oxIz1F.eSrF/SWmAlwu', 1, NULL, NULL, '2022-01-19 10:13:14', '2022-01-19 10:13:14'),
(38, 'ss', 'ss', '093071999299', NULL, NULL, NULL, 'male', '$2y$10$gTTQ2OPxldaFx83VI9f9z.FEO2XPO2EWk2qDYJtt6y24U0OJ0J2ty', 1, NULL, NULL, '2022-01-19 10:13:41', '2022-01-19 10:13:41'),
(39, 'Saber', 'Doroudi', '09366696893', NULL, NULL, NULL, 'male', '$2y$10$TxOBIOvnMC9mlD.SCcpP3ees7t3HZeG8VWiZpWY/AfFOyccXPS4bW', 1, NULL, NULL, '2022-01-19 10:19:02', '2022-01-19 10:19:02'),
(40, 'ss', 'ss', '0930741999299', 'ssoheiilfddfsd@gmail.com', NULL, NULL, 'male', '$2y$10$Y1HNe48m5v0Kqye5C9laKeqiO.CXb26UdUvEfCs2Y3IANjkq73UG2', 1, NULL, NULL, '2022-01-19 10:51:50', '2022-01-19 10:51:50'),
(41, 'mohd', 'umar', '12345679', 'm@m.com', NULL, NULL, 'male', '$2y$10$Sks4Xh7jqBqNzEOATrxId.GV7cibg9rXNmiG7lEWMYqvSts.LoUrS', 1, NULL, NULL, '2022-01-22 09:37:58', '2022-01-22 09:37:58'),
(42, 'ss', 'ss', '96567772237', 'ssoheiilfddfsdd@gmail.com', NULL, NULL, 'male', '$2y$10$iD9dm2mSpUoeJDttBN4jKuONZC9dNq32u2OWUVR36TxNkYiCkvB16', 1, NULL, NULL, '2022-01-24 12:46:08', '2022-01-24 12:46:08'),
(43, 'ss', 'ss', '965677722537', 'ssoheiiilfddfsdd@gmail.com', NULL, NULL, 'male', '$2y$10$rrdbpnxRyxBgRY6xza2n3uqJNnZP8k9jjcjzozdB9SqvKWgd2Z3UC', 1, NULL, NULL, '2022-01-29 13:02:17', '2022-01-29 13:02:17'),
(44, 'mohd', 'umar', '98819591', 'mohd.umar@gulfclick.net', '1980-01-01', 'users-image-731cbfac971e957b6c31489af3ca89c2.png', 'male', '$2y$10$CtnBruZOIC1no.vgv6BsrerF5FuF079g8g8l398Y3oYZpFMKUifaG', 1, NULL, NULL, '2022-02-01 07:54:26', '2022-03-03 06:57:38'),
(45, 'ss', 'ss', '965677722237', 'ssoheiilfdddfsdd@gmail.com', NULL, NULL, 'male', '$2y$10$ChsjL0FFN7RrjxhyMYxGc.JlfFH2qoj0Cz.27G.LLzZK9wvsKb1X.', 1, NULL, NULL, '2022-02-01 08:03:44', '2022-02-01 08:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `user_freelancer`
--

CREATE TABLE `user_freelancer` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_freelancer`
--

INSERT INTO `user_freelancer` (`user_id`, `freelancer_id`) VALUES
(28, 23),
(29, 20),
(27, 23),
(2, 44),
(44, 44),
(44, 25);

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `user_id`, `image`, `description`, `freelancer_id`, `data`, `created_at`, `updated_at`) VALUES
(1, 44, 'example.png', 'this is <b>for test</b>. fileds you should get just image and description and created_at.', 34, '{\"some_important_data\":\"test\"}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(2, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(3, 44, 'example.png', 'New <b>booking meeting</b> from this user.', 34, '{\"meeting_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(4, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(5, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(6, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(7, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(8, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(9, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(10, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(11, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(12, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(13, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(14, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(15, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(16, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(17, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(18, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(19, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(20, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(21, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(22, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(23, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(24, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(25, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(26, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(27, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(28, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(29, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(30, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(31, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(32, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(33, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(34, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(35, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(36, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(37, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(38, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(39, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(40, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(41, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(42, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(43, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(44, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(45, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(46, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(47, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(48, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(49, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(50, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(51, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(52, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(53, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(54, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(55, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(56, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(57, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(58, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(59, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(60, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(61, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(62, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(63, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(64, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(65, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(66, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(67, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(68, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(69, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(70, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(71, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(72, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(73, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(74, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(75, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(76, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(77, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(78, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(79, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(80, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(81, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(82, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(83, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(84, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(85, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(86, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(87, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(88, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(89, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(90, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(91, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(92, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(93, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(94, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(95, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(96, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(97, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(98, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(99, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(100, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(101, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(102, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(103, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(104, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(105, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(106, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(107, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(108, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(109, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(110, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(111, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(112, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(113, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(114, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(115, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(116, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(117, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(118, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(119, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22'),
(120, 44, 'example.png', 'New <b>booking service</b> from this user.', 34, '{\"service_id\":44}', '2022-03-03 03:30:22', '2022-03-03 03:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_track` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` enum('waiting','cancel','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `error` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`id`, `user_id`, `order_track`, `amount`, `payment_status`, `payment_id`, `result`, `error`, `created_at`, `updated_at`) VALUES
(79, 2, '80692467', '2000', 'paid', '100202204140356822', 'CANCELED', 'Transaction Failed', '2022-02-10 07:41:37', '2022-02-10 07:47:45'),
(81, 44, '80692467', '2000', 'paid', '100202204140356822', 'CANCELED', 'Transaction Failed', '2022-02-10 07:41:37', '2022-02-10 07:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `user_payments`
--

CREATE TABLE `user_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `gateway` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `track_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_quotations`
--

CREATE TABLE `user_quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `payment_type` enum('Full Payment','Half') COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_quotations`
--

INSERT INTO `user_quotations` (`id`, `user_id`, `freelancer_id`, `description`, `budget`, `place`, `time`, `date`, `payment_type`, `attachment`, `created_at`, `updated_at`) VALUES
(2, 2, 25, 'ffsfsfsdfsf', '10', 'adasdad', '11:22:39', '2022-01-04', 'Full Payment', '', '2022-01-03 10:18:23', '2022-01-03 10:18:23'),
(3, 2, 23, 'desc', '10', '', '10:22:00', NULL, 'Full Payment', '', '2022-01-29 12:05:31', '2022-01-29 12:05:31'),
(4, 2, 23, 'desc', '10', '', '10:22:00', NULL, 'Full Payment', '/tmp/php4zmcTP', '2022-01-29 12:07:17', '2022-01-29 12:07:17'),
(5, 2, 23, 'desc', '10', '', '10:22:00', NULL, 'Full Payment', '/tmp/phpLtB8uS', '2022-01-29 12:07:33', '2022-01-29 12:07:33'),
(6, 2, 23, 'desc', '10', '', '10:22:00', NULL, 'Full Payment', '/tmp/php0CX6TJ', '2022-01-29 12:07:46', '2022-01-29 12:07:46'),
(7, 2, 23, 'desc', '10', '', '10:22:00', NULL, 'Full Payment', '/tmp/phpwQnw4i', '2022-01-29 12:10:09', '2022-01-29 12:10:09'),
(8, 2, 23, 'desc', '10', 'place', '10:22:00', NULL, 'Full Payment', 'quotation-attachment-e838ff63b41bcfaf36d72b5ea26a4d6f.jpg', '2022-01-29 12:20:44', '2022-01-29 12:20:44'),
(9, 2, 23, 'desc', '10', 'place', '10:22:00', NULL, 'Full Payment', 'quotation-attachment-21730c83aeb42694db3d6e48147e4c05.jpg', '2022-01-29 12:23:07', '2022-01-29 12:23:07'),
(10, 2, 23, 'desc', '10', 'place', '10:22:00', NULL, 'Full Payment', '', '2022-01-29 12:24:30', '2022-01-29 12:24:30'),
(11, 2, 23, 'desc', '10', 'place', '10:22:00', NULL, 'Full Payment', '', '2022-01-29 12:25:24', '2022-01-29 12:25:24'),
(12, 2, 23, 'desc', '10', 'place', '10:22:00', NULL, 'Full Payment', 'quotation-attachment-849fd35b1a74f9795d2000505c627018.jpg', '2022-01-29 12:25:32', '2022-01-29 12:25:32'),
(13, 2, 23, 'description', '10', 'place', '10:30:00', NULL, 'Full Payment', '', '2022-01-30 09:37:46', '2022-01-30 09:37:46'),
(14, 2, 23, 'description', '10', 'place', '10:30:00', NULL, 'Full Payment', 'quotation-attachment-91561bc2851425c6dc2cece6c167139a.jpg', '2022-01-30 09:38:23', '2022-01-30 09:38:23'),
(15, 2, 23, 'mehrandish', '10', 'dasda', '10:00:00', NULL, 'Full Payment', '', '2022-01-31 13:12:21', '2022-01-31 13:12:21'),
(16, 2, 23, 'mehrandish', '10', 'dasda', '10:00:00', NULL, 'Full Payment', '', '2022-01-31 13:27:02', '2022-01-31 13:27:02'),
(17, 2, 23, 'mehrandish', '10', NULL, '10:00:00', NULL, 'Full Payment', '', '2022-01-31 13:27:23', '2022-01-31 13:27:23'),
(18, 2, 23, 'mehrandish', '10', NULL, NULL, NULL, 'Full Payment', '', '2022-01-31 13:27:31', '2022-01-31 13:27:31'),
(19, 2, 23, 'mehrandish', '10', 'home', '10:20:00', '2022-10-25', 'Full Payment', '', '2022-02-09 07:40:15', '2022-02-09 07:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `workshop_orders`
--

CREATE TABLE `workshop_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `workshop_id` bigint(20) UNSIGNED NOT NULL,
  `freelancer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `people_count` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_track` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `earn` float NOT NULL DEFAULT 0,
  `commission` float NOT NULL DEFAULT 0,
  `payment_status` enum('waiting','cancel','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `payment_id` varchar(65) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workshop_orders`
--

INSERT INTO `workshop_orders` (`id`, `user_id`, `workshop_id`, `freelancer_id`, `people_count`, `order_track`, `amount`, `earn`, `commission`, `payment_status`, `payment_id`, `result`, `error`, `created_at`, `updated_at`) VALUES
(30, 2, 14, 25, '10', '86369138', '10000', 9900, 100, 'cancel', '100202204156806791', 'CAPTURED', 'Transaction Success', '2022-02-10 09:16:09', '2022-02-14 08:07:09'),
(31, 2, 14, 25, '10', '86369138', '10000', 9900, 100, 'paid', '100202204156806791', 'CAPTURED', 'Transaction Success', '2022-02-10 09:16:09', '2022-02-10 09:17:06'),
(32, 44, 14, 25, '10', '86369138', '10000', 9900, 100, 'paid', '100202204156806791', 'CAPTURED', 'Transaction Success', '2022-03-03 09:49:58', '2022-02-10 09:17:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attr_groups`
--
ALTER TABLE `attr_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blocked_user_freelancer`
--
ALTER TABLE `blocked_user_freelancer`
  ADD KEY `user_service_user_id_foreign` (`user_id`),
  ADD KEY `user_service_service_id_foreign` (`freelancer_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_sku_unique` (`sku`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`),
  ADD KEY `blogs_user_id_foreign` (`user_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD KEY `blog_categories_blog_id_foreign` (`blog_id`),
  ADD KEY `blog_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `blog_translations`
--
ALTER TABLE `blog_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_translations_blog_id_locale_unique` (`blog_id`,`locale`),
  ADD KEY `blog_translations_locale_index` (`locale`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `category_blogs`
--
ALTER TABLE `category_blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_blog_translations`
--
ALTER TABLE `category_blog_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_blog_translations_category_blog_id_locale_unique` (`category_blog_id`,`locale`),
  ADD KEY `category_blog_translations_locale_index` (`locale`);

--
-- Indexes for table `category_freelancer`
--
ALTER TABLE `category_freelancer`
  ADD KEY `category_freelancer_category_id_foreign` (`category_id`),
  ADD KEY `category_freelancer_freelancer_id_foreign` (`freelancer_id`);

--
-- Indexes for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_translations_category_id_locale_unique` (`category_id`,`locale`),
  ADD KEY `category_translations_locale_index` (`locale`);

--
-- Indexes for table `change_password_otps`
--
ALTER TABLE `change_password_otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `filters`
--
ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `freelancers`
--
ALTER TABLE `freelancers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD KEY `freelancers_rate_id_foreign` (`rate_id`),
  ADD KEY `freelancers_package_id_foreign` (`package_id`) USING BTREE;

--
-- Indexes for table `freelancer_addresses`
--
ALTER TABLE `freelancer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freelancer_addresses_freelancer_id_foreign` (`freelancer_id`);

--
-- Indexes for table `freelancer_areas`
--
ALTER TABLE `freelancer_areas`
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `freelancer_highlights`
--
ALTER TABLE `freelancer_highlights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `freelancer_highlight_images`
--
ALTER TABLE `freelancer_highlight_images`
  ADD KEY `highlight_id` (`highlight_id`);

--
-- Indexes for table `freelancer_notifications`
--
ALTER TABLE `freelancer_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `freelancer_quotations`
--
ALTER TABLE `freelancer_quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freelancer_quotations_user_id_foreign` (`user_id`),
  ADD KEY `freelancer_quotations_freelancer_id_foreign` (`freelancer_id`);

--
-- Indexes for table `freelancer_services`
--
ALTER TABLE `freelancer_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freelancer_services_freelancer_id_foreign` (`freelancer_id`);

--
-- Indexes for table `freelancer_user_messages`
--
ALTER TABLE `freelancer_user_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freelancer_user_messages_user_id_foreign` (`user_id`),
  ADD KEY `freelancer_user_messages_freelancer_id_foreign` (`freelancer_id`);

--
-- Indexes for table `freelancer_workshops`
--
ALTER TABLE `freelancer_workshops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `freelancer_workshops_freelancer_id_foreign` (`freelancer_id`);

--
-- Indexes for table `freelancer_workshop_translations`
--
ALTER TABLE `freelancer_workshop_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `freelancer_workshop_translations_workshop_id_locale_unique` (`freelancer_workshop_id`,`locale`),
  ADD KEY `freelancer_workshop_translations_locale_index` (`locale`);

--
-- Indexes for table `gwc_aboutus`
--
ALTER TABLE `gwc_aboutus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_admins`
--
ALTER TABLE `gwc_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_areas`
--
ALTER TABLE `gwc_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_cities`
--
ALTER TABLE `gwc_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_countries`
--
ALTER TABLE `gwc_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_coupons`
--
ALTER TABLE `gwc_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_directors`
--
ALTER TABLE `gwc_directors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_durations`
--
ALTER TABLE `gwc_durations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_featured_projects`
--
ALTER TABLE `gwc_featured_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_home_about_info`
--
ALTER TABLE `gwc_home_about_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_ideas`
--
ALTER TABLE `gwc_ideas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gwc_newsevents_author_id_foreign` (`author_id`);

--
-- Indexes for table `gwc_logs`
--
ALTER TABLE `gwc_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_menus`
--
ALTER TABLE `gwc_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_messages`
--
ALTER TABLE `gwc_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_newsevents`
--
ALTER TABLE `gwc_newsevents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_notify_emails`
--
ALTER TABLE `gwc_notify_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_package_galleries`
--
ALTER TABLE `gwc_package_galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_resumes`
--
ALTER TABLE `gwc_resumes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_settings`
--
ALTER TABLE `gwc_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_single_pages`
--
ALTER TABLE `gwc_single_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_sms`
--
ALTER TABLE `gwc_sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_subjects`
--
ALTER TABLE `gwc_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_transactions`
--
ALTER TABLE `gwc_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_users`
--
ALTER TABLE `gwc_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_web_device_register`
--
ALTER TABLE `gwc_web_device_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gwc_web_push_message`
--
ALTER TABLE `gwc_web_push_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `how_it_works`
--
ALTER TABLE `how_it_works`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `how_it_work_translations`
--
ALTER TABLE `how_it_work_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `how_it_work_translations_how_it_work_id_locale_unique` (`how_it_work_id`,`locale`),
  ADD KEY `how_it_work_translations_locale_index` (`locale`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meetings_user_id_foreign` (`user_id`),
  ADD KEY `meetings_freelancer_id_foreign` (`freelancer_id`),
  ADD KEY `meetings_time_piece_id_foreign` (`time_piece_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotations_user_id_foreign` (`user_id`),
  ADD KEY `quotations_freelancer_id_foreign` (`freelancer_id`),
  ADD KEY `quotations_address_id_foreign` (`address_id`);

--
-- Indexes for table `quotations_installment`
--
ALTER TABLE `quotations_installment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotations_installment_quotation_id_foreign` (`quotation_id`);

--
-- Indexes for table `quotations_service`
--
ALTER TABLE `quotations_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotations_service_quotation_id_foreign` (`quotation_id`);

--
-- Indexes for table `quotation_orders`
--
ALTER TABLE `quotation_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_orders_quotation_id_foreign` (`quotation_id`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_messages`
--
ALTER TABLE `report_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD KEY `role_has_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `service_user_orders`
--
ALTER TABLE `service_user_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_translations`
--
ALTER TABLE `shipping_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shipping_translations_shipping_id_locale_unique` (`shipping_id`,`locale`),
  ADD KEY `shipping_translations_locale_index` (`locale`);

--
-- Indexes for table `slideshows`
--
ALTER TABLE `slideshows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_calenders`
--
ALTER TABLE `time_calenders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time_calenders_date_id_foreign` (`freelancer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_freelancer`
--
ALTER TABLE `user_freelancer`
  ADD KEY `user_service_user_id_foreign` (`user_id`),
  ADD KEY `user_service_service_id_foreign` (`freelancer_id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `user_quotations`
--
ALTER TABLE `user_quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_quotations_user_id_foreign` (`user_id`),
  ADD KEY `user_quotations_freelancer_id_foreign` (`freelancer_id`);

--
-- Indexes for table `workshop_orders`
--
ALTER TABLE `workshop_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workshop_orders_user_id_foreign` (`user_id`),
  ADD KEY `workshop_orders_workshop_id_foreign` (`workshop_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attr_groups`
--
ALTER TABLE `attr_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_translations`
--
ALTER TABLE `blog_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `category_blogs`
--
ALTER TABLE `category_blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_blog_translations`
--
ALTER TABLE `category_blog_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_translations`
--
ALTER TABLE `category_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `change_password_otps`
--
ALTER TABLE `change_password_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `filters`
--
ALTER TABLE `filters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `freelancers`
--
ALTER TABLE `freelancers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `freelancer_addresses`
--
ALTER TABLE `freelancer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `freelancer_highlights`
--
ALTER TABLE `freelancer_highlights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `freelancer_notifications`
--
ALTER TABLE `freelancer_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `freelancer_quotations`
--
ALTER TABLE `freelancer_quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `freelancer_services`
--
ALTER TABLE `freelancer_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `freelancer_user_messages`
--
ALTER TABLE `freelancer_user_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `freelancer_workshops`
--
ALTER TABLE `freelancer_workshops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `freelancer_workshop_translations`
--
ALTER TABLE `freelancer_workshop_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `gwc_aboutus`
--
ALTER TABLE `gwc_aboutus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gwc_admins`
--
ALTER TABLE `gwc_admins`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gwc_areas`
--
ALTER TABLE `gwc_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `gwc_cities`
--
ALTER TABLE `gwc_cities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `gwc_countries`
--
ALTER TABLE `gwc_countries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gwc_coupons`
--
ALTER TABLE `gwc_coupons`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gwc_directors`
--
ALTER TABLE `gwc_directors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gwc_durations`
--
ALTER TABLE `gwc_durations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gwc_featured_projects`
--
ALTER TABLE `gwc_featured_projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gwc_home_about_info`
--
ALTER TABLE `gwc_home_about_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gwc_ideas`
--
ALTER TABLE `gwc_ideas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gwc_logs`
--
ALTER TABLE `gwc_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=850;

--
-- AUTO_INCREMENT for table `gwc_menus`
--
ALTER TABLE `gwc_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `gwc_messages`
--
ALTER TABLE `gwc_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `gwc_newsevents`
--
ALTER TABLE `gwc_newsevents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gwc_notify_emails`
--
ALTER TABLE `gwc_notify_emails`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gwc_package_galleries`
--
ALTER TABLE `gwc_package_galleries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gwc_resumes`
--
ALTER TABLE `gwc_resumes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gwc_settings`
--
ALTER TABLE `gwc_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gwc_single_pages`
--
ALTER TABLE `gwc_single_pages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `gwc_sms`
--
ALTER TABLE `gwc_sms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gwc_subjects`
--
ALTER TABLE `gwc_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gwc_transactions`
--
ALTER TABLE `gwc_transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gwc_users`
--
ALTER TABLE `gwc_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gwc_web_device_register`
--
ALTER TABLE `gwc_web_device_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gwc_web_push_message`
--
ALTER TABLE `gwc_web_push_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `how_it_works`
--
ALTER TABLE `how_it_works`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `how_it_work_translations`
--
ALTER TABLE `how_it_work_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quotations_installment`
--
ALTER TABLE `quotations_installment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `quotations_service`
--
ALTER TABLE `quotations_service`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `quotation_orders`
--
ALTER TABLE `quotation_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `report_messages`
--
ALTER TABLE `report_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_user_orders`
--
ALTER TABLE `service_user_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_translations`
--
ALTER TABLE `shipping_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slideshows`
--
ALTER TABLE `slideshows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `time_calenders`
--
ALTER TABLE `time_calenders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_quotations`
--
ALTER TABLE `user_quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `workshop_orders`
--
ALTER TABLE `workshop_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blocked_user_freelancer`
--
ALTER TABLE `blocked_user_freelancer`
  ADD CONSTRAINT `blocked_user_freelancer_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blocked_user_freelancer_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD CONSTRAINT `blog_categories_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_translations`
--
ALTER TABLE `blog_translations`
  ADD CONSTRAINT `blog_translations_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category_blog_translations`
--
ALTER TABLE `category_blog_translations`
  ADD CONSTRAINT `category_blog_translations_category_blog_id_foreign` FOREIGN KEY (`category_blog_id`) REFERENCES `category_blogs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_freelancer`
--
ALTER TABLE `category_freelancer`
  ADD CONSTRAINT `category_freelancer_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_freelancer_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelancers`
--
ALTER TABLE `freelancers`
  ADD CONSTRAINT `freelancers_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `freelancers_rate_id_foreign` FOREIGN KEY (`rate_id`) REFERENCES `rates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelancer_addresses`
--
ALTER TABLE `freelancer_addresses`
  ADD CONSTRAINT `freelancer_addresses_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelancer_areas`
--
ALTER TABLE `freelancer_areas`
  ADD CONSTRAINT `freelancer_areas_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelancer_highlights`
--
ALTER TABLE `freelancer_highlights`
  ADD CONSTRAINT `freelancer_highlights_ibfk_1` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelancer_highlight_images`
--
ALTER TABLE `freelancer_highlight_images`
  ADD CONSTRAINT `freelancer_highlight_images_ibfk_1` FOREIGN KEY (`highlight_id`) REFERENCES `freelancer_highlights` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelancer_quotations`
--
ALTER TABLE `freelancer_quotations`
  ADD CONSTRAINT `freelancer_quotations_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `freelancer_quotations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelancer_user_messages`
--
ALTER TABLE `freelancer_user_messages`
  ADD CONSTRAINT `freelancer_user_messages_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `freelancer_user_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelancer_workshops`
--
ALTER TABLE `freelancer_workshops`
  ADD CONSTRAINT `freelancer_workshops_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `freelancer_workshop_translations`
--
ALTER TABLE `freelancer_workshop_translations`
  ADD CONSTRAINT `freelancer_workshop_translations_freelancer_workshop_id_foreign` FOREIGN KEY (`freelancer_workshop_id`) REFERENCES `freelancer_workshops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gwc_ideas`
--
ALTER TABLE `gwc_ideas`
  ADD CONSTRAINT `gwc_newsevents_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `gwc_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `how_it_work_translations`
--
ALTER TABLE `how_it_work_translations`
  ADD CONSTRAINT `how_it_work_translations_how_it_work_id_foreign` FOREIGN KEY (`how_it_work_id`) REFERENCES `how_it_works` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meetings_time_piece_id_foreign` FOREIGN KEY (`time_piece_id`) REFERENCES `time_calenders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meetings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `freelancer_addresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotations_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotations_installment`
--
ALTER TABLE `quotations_installment`
  ADD CONSTRAINT `quotations_installment_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotations_service`
--
ALTER TABLE `quotations_service`
  ADD CONSTRAINT `quotations_service_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotation_orders`
--
ALTER TABLE `quotation_orders`
  ADD CONSTRAINT `quotation_orders_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `freelancer_quotations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_user_orders`
--
ALTER TABLE `service_user_orders`
  ADD CONSTRAINT `service_user_orders_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `user_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_translations`
--
ALTER TABLE `shipping_translations`
  ADD CONSTRAINT `shipping_translations_shipping_id_foreign` FOREIGN KEY (`shipping_id`) REFERENCES `shippings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_freelancer`
--
ALTER TABLE `user_freelancer`
  ADD CONSTRAINT `user_freelancer_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_freelancer_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_notifications_ibfk_2` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD CONSTRAINT `user_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_payments`
--
ALTER TABLE `user_payments`
  ADD CONSTRAINT `user_payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `user_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_quotations`
--
ALTER TABLE `user_quotations`
  ADD CONSTRAINT `user_quotations_freelancer_id_foreign` FOREIGN KEY (`freelancer_id`) REFERENCES `freelancers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_quotations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `workshop_orders`
--
ALTER TABLE `workshop_orders`
  ADD CONSTRAINT `workshop_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workshop_orders_workshop_id_foreign` FOREIGN KEY (`workshop_id`) REFERENCES `freelancer_workshops` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
