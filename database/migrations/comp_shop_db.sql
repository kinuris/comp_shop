-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2024 at 01:44 AM
-- Server version: 8.3.0
-- PHP Version: 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comp_shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicable_discounts`
--

CREATE TABLE `applicable_discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `fk_product` bigint UNSIGNED NOT NULL,
  `fk_discount` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applicable_discounts`
--

INSERT INTO `applicable_discounts` (`id`, `fk_product`, `fk_discount`, `created_at`, `updated_at`) VALUES
(1, 15, 3, '2024-06-21 02:39:54', '2024-06-21 02:39:54'),
(2, 14, 3, '2024-06-21 02:39:54', '2024-06-21 02:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `fk_product` bigint UNSIGNED NOT NULL,
  `fk_product_snapshot` bigint UNSIGNED NOT NULL,
  `fk_payment_transaction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_discount` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `fk_product`, `fk_product_snapshot`, `fk_payment_transaction`, `fk_discount`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '619423b9-8248-478b-9af1-f0a1b2903749', NULL, '2024-06-21 02:29:08', '2024-06-21 02:29:08'),
(2, 2, 3, '619423b9-8248-478b-9af1-f0a1b2903749', NULL, '2024-06-21 02:29:08', '2024-06-21 02:29:08'),
(3, 1, 2, '619423b9-8248-478b-9af1-f0a1b2903749', 1, '2024-06-21 02:29:08', '2024-06-21 02:29:08'),
(4, 3, 4, '619423b9-8248-478b-9af1-f0a1b2903749', NULL, '2024-06-21 02:29:08', '2024-06-21 02:29:08'),
(5, 3, 4, '619423b9-8248-478b-9af1-f0a1b2903749', NULL, '2024-06-21 02:29:08', '2024-06-21 02:29:08'),
(6, 15, 18, 'b5f21300-2f6f-49a4-80be-6ee5e987fc03', 3, '2024-06-21 02:40:58', '2024-06-21 02:40:58'),
(7, 14, 16, 'b5f21300-2f6f-49a4-80be-6ee5e987fc03', 3, '2024-06-21 02:40:58', '2024-06-21 02:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Laptops', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(2, 'Monitors', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(3, 'Power Supply', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(4, 'Storage', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(5, 'Memory', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(6, 'Motherboard', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(7, 'CPU', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(8, 'GPU', '2024-06-20 15:38:06', '2024-06-20 15:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `absolute_discount` int UNSIGNED DEFAULT NULL,
  `percentage_discount` tinyint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `name`, `type`, `disabled`, `absolute_discount`, `percentage_discount`, `created_at`, `updated_at`) VALUES
(1, 'Senior\'s Discount', 'percentage', 0, NULL, 20, '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(2, 'PWD Discount', 'percentage', 0, NULL, 20, '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(3, 'Limited Promo 100 PHP Off', 'absolute', 0, 100, NULL, '2024-06-21 02:39:54', '2024-06-21 02:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` bigint UNSIGNED NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'Male', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(2, 'Female', '2024-06-20 15:38:06', '2024-06-20 15:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `general_discounts`
--

CREATE TABLE `general_discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `fk_discount` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_discounts`
--

INSERT INTO `general_discounts` (`id`, `fk_discount`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(2, 2, '2024-06-20 15:38:06', '2024-06-20 15:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(113, '0001_01_01_000001_create_cache_table', 1),
(114, '2024_05_07_011615_create_genders_table', 1),
(115, '2024_05_07_011731_create_roles_table', 1),
(116, '2024_05_07_011747_create_categories_table', 1),
(117, '2024_05_07_011800_create_users_table', 1),
(118, '2024_05_07_011808_create_suppliers_table', 1),
(119, '2024_05_07_011818_create_products_table', 1),
(120, '2024_05_07_011828_create_payment_methods_table', 1),
(121, '2024_05_07_011857_create_discounts_table', 1),
(122, '2024_05_07_011910_create_payment_transactions_table', 1),
(123, '2024_05_14_015652_create_product_snapshots_table', 1),
(124, '2024_05_14_020135_create_product_image_links_table', 1),
(125, '2024_05_15_011917_create_carts_table', 1),
(126, '2024_05_18_132439_create_applicable_discounts', 1),
(127, '2024_06_02_093121_create_general_discounts_table', 1),
(128, '2024_06_17_085858_create_product_restocks_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `method_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `method_name`, `available`, `created_at`, `updated_at`) VALUES
(1, 'Credit Card', 1, '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(2, 'Debit Card', 1, '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(3, 'Cash', 1, '2024-06-20 15:38:06', '2024-06-20 15:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_user` bigint UNSIGNED NOT NULL,
  `fk_payment_method` bigint UNSIGNED NOT NULL,
  `fk_discount` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_transactions`
--

INSERT INTO `payment_transactions` (`id`, `fk_user`, `fk_payment_method`, `fk_discount`, `created_at`, `updated_at`) VALUES
('619423b9-8248-478b-9af1-f0a1b2903749', 2, 3, NULL, '2024-06-21 02:29:08', '2024-06-21 02:29:08'),
('b5f21300-2f6f-49a4-80be-6ee5e987fc03', 2, 3, NULL, '2024-06-21 02:40:58', '2024-06-21 02:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fk_category` bigint UNSIGNED NOT NULL,
  `fk_supplier` bigint UNSIGNED NOT NULL,
  `stock_quantity` int UNSIGNED NOT NULL,
  `price` int UNSIGNED NOT NULL,
  `available` tinyint(1) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `barcode`, `image_link`, `fk_category`, `fk_supplier`, `stock_quantity`, `price`, `available`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Apple M2 Air 8g 256gb', '610807953320', '9be00e2b555e94fb1f15723b53f8dac0ef75958a.png', 1, 4, 34, 65999, 1, 'The MacBook Air M2 is a powerful laptop with an Apple M2 chip, offering impressive performance, long battery life, and a vibrant 13.6-inch Liquid Retina display.', '2024-06-20 15:40:36', '2024-06-21 02:34:29'),
(2, 'Asus ROG Zephyrus G14 16g 1tb', '665759658973', NULL, 1, 1, 1, 54889, 1, 'The ASUS ROG Zephyrus G14 is an excellent gaming laptop, impressively powered by AMD’s newest Ryzen Mobile CPU and Nvidia GeForce RTX graphics in a compact 14-inch body.', '2024-06-21 01:07:21', '2024-06-21 02:33:18'),
(3, 'Samsung Odyssey G70A', '859715164467', NULL, 2, 10, 10, 14999, 1, 'The Samsung Odyssey G70A is equipped with a 1ms response time, UHD 4K resolution, 144Hz refresh rate, and support for G-Sync and FreeSync Premium.', '2024-06-21 01:09:38', '2024-06-21 02:29:08'),
(4, 'MSI MPG 321URX QD-OLED', '590960092271', NULL, 1, 2, 6, 24999, 1, 'The MSI MPG 321URX QD-OLED is a top-tier gaming monitor with stunning visuals, rapid response time, and thoughtful features.', '2024-06-21 01:12:05', '2024-06-21 01:12:05'),
(5, 'Seasonic Prime Titanium TX-1000', '403418257676', NULL, 3, 11, 9, 5999, 1, 'The TX-1000 is rated to Titanium, hence the name, and is the best 1KW power supply around today.', '2024-06-21 01:15:20', '2024-06-21 01:15:20'),
(6, 'EVGA SuperNova 750GT', '519011574738', NULL, 3, 12, 3, 3549, 1, 'The EVGA SuperNOVA 750 GT is a high-quality power supply designed for long-term usage and durability.', '2024-06-21 01:17:10', '2024-06-21 01:17:10'),
(7, 'Samsung 980 Pro NVME', '344447837820', NULL, 4, 10, 24, 6199, 1, 'The Samsung 980 PRO is an impressive PCIe 4.0 NVMe SSD designed to elevate your computing experience.', '2024-06-21 01:19:24', '2024-06-21 01:19:26'),
(8, 'Samsung 990 Pro 4TB', '944648534932', NULL, 4, 10, 10, 12999, 1, 'The Samsung 990 PRO 4TB PCIE 4.0 is an impressive SSD that brings ultimate performance and capacity for gamers and creators.', '2024-06-21 01:22:36', '2024-06-21 01:22:36'),
(9, 'AORUS RGB Memory DDR5 32gb (2x16) 6000MT/s', '534990868776', NULL, 5, 13, 45, 10849, 1, 'AORUS DDR5 RGB memory adopts a new copper-aluminum composite material heat spreader.', '2024-06-21 01:26:19', '2024-06-21 01:27:51'),
(10, 'AORUS RGB Memory DDR4 16GB (2x8GB) 3733MT/s', '331094673330', NULL, 5, 13, 60, 2899, 1, 'The AORUS RGB Memory kit is engineered to be the best and to deliver absolute performance.', '2024-06-21 01:27:46', '2024-06-21 01:27:46'),
(11, 'LG 27GR95QE-B 27\" 240hz', '467457660842', NULL, 2, 9, 5, 16999, 1, 'The LG 27GR95QE has a fantastic response time. There isn\'t much blur trail behind fast-moving objects, but it has overshoot, leading to inverse ghosting.', '2024-06-21 01:29:26', '2024-06-21 01:29:26'),
(12, 'Gigabyte Z790 Aorus Xtreme', '718420933260', NULL, 6, 13, 6, 12999, 1, 'Gigabyte’s Z790 Aorus Xtreme presents the best value among Z790 flagship boards.', '2024-06-21 01:30:29', '2024-06-21 01:30:58'),
(13, 'Gigabyte X670E Aorus Pro X', '468340573828', NULL, 6, 13, 13, 14999, 1, 'Gigabyte’s X670E Aorus Pro X is a mid-cycle update board that brings striking white / silver looks, Wi-Fi 7, and  two PCIe 5.0 x4 M.2 sockets.', '2024-06-21 01:32:01', '2024-06-21 01:32:01'),
(14, 'Intel 14700K 14th-gen 5.6 GHz', '676870244598', NULL, 7, 6, 23, 21999, 1, 'The Intel Core i7-14700K is a desktop processor with 20 cores, launched in October 2023, at an MSRP of $409.', '2024-06-21 01:34:18', '2024-06-21 02:40:58'),
(15, 'AMD Ryzen 7 7800X3D', '424132672631', NULL, 7, 5, 48, 19999, 1, 'Whatever the setting, whatever the resolution, lead your team to victory with this incredible gaming processor. Enjoy the benefits of next-gen AMD 3D V-Cache™.', '2024-06-21 01:35:36', '2024-06-21 02:40:58'),
(16, 'RTX 4090 24gb', '191608495584', NULL, 8, 15, 16, 84999, 1, 'The NVIDIA® GeForce RTX™ 4090 is the ultimate GeForce GPU. It brings an enormous leap in performance, efficiency, and AI-powered graphics.', '2024-06-21 01:39:13', '2024-06-21 01:39:13'),
(17, 'AMD Radeon RX 7900 XT', '783781713838', NULL, 1, 1, 13, 57999, 1, 'The Radeon RX 7900 XT is an enthusiast-class graphics card by AMD, launched on November 3rd, 2022. Built on the 5 nm process.', '2024-06-21 01:43:46', '2024-06-21 01:43:46'),
(18, 'Aorus 8g (2 x 4) 3200MT/s', '718317220672', '49bb99ec3509ab72c7e811b27f4fd89f7cc4c214.png', 5, 13, 40, 2599, 0, 'Some ramsticks aksldjflkasdfjioqwehifl;aslkdjflk;asdjf', '2024-06-21 02:34:09', '2024-06-23 01:43:29');

-- --------------------------------------------------------

--
-- Table structure for table `product_image_links`
--

CREATE TABLE `product_image_links` (
  `id` bigint UNSIGNED NOT NULL,
  `fk_product` bigint UNSIGNED NOT NULL,
  `image_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_restocks`
--

CREATE TABLE `product_restocks` (
  `id` bigint UNSIGNED NOT NULL,
  `fk_product` bigint UNSIGNED NOT NULL,
  `fk_user` bigint UNSIGNED NOT NULL,
  `amount` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_restocks`
--

INSERT INTO `product_restocks` (`id`, `fk_product`, `fk_user`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 5, '2024-06-21 02:31:54', '2024-06-21 02:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_snapshots`
--

CREATE TABLE `product_snapshots` (
  `id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_category` bigint UNSIGNED NOT NULL,
  `fk_supplier` bigint UNSIGNED NOT NULL,
  `fk_product` bigint UNSIGNED NOT NULL,
  `fk_user` bigint UNSIGNED NOT NULL,
  `price` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_snapshots`
--

INSERT INTO `product_snapshots` (`id`, `product_name`, `fk_category`, `fk_supplier`, `fk_product`, `fk_user`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Apple M2 Air 8g 256gb', 1, 4, 1, 7, 68000, '2024-06-20 15:40:36', '2024-06-20 15:40:36'),
(2, 'Apple M2 Air 8g 256gb', 1, 4, 1, 7, 68890, '2024-06-20 15:51:26', '2024-06-20 15:51:26'),
(3, 'Asus ROG Zephyrus G14 16g 1tb', 1, 1, 2, 4, 54889, '2024-06-21 01:07:21', '2024-06-21 01:07:21'),
(4, 'Samsung Odyssey G70A', 2, 10, 3, 4, 14999, '2024-06-21 01:09:38', '2024-06-21 01:09:38'),
(5, 'MSI MPG 321URX QD-OLED', 1, 2, 4, 4, 24999, '2024-06-21 01:12:05', '2024-06-21 01:12:05'),
(6, 'Seasonic Prime Titanium TX-1000', 3, 11, 5, 4, 5999, '2024-06-21 01:15:20', '2024-06-21 01:15:20'),
(7, 'EVGA SuperNova 750GT', 3, 12, 6, 4, 3549, '2024-06-21 01:17:10', '2024-06-21 01:17:10'),
(8, 'Samsung 980 Pro NVME', 4, 10, 7, 4, 6199, '2024-06-21 01:19:24', '2024-06-21 01:19:24'),
(9, 'Samsung 990 Pro 4TB', 4, 10, 8, 4, 12999, '2024-06-21 01:22:36', '2024-06-21 01:22:36'),
(10, 'AORUS RGB Memory DDR5 32gb (2x16) 6000MT/s', 5, 13, 9, 4, 10849, '2024-06-21 01:26:19', '2024-06-21 01:26:19'),
(11, 'AORUS RGB Memory DDR4 16GB (2x8GB) 3733MT/s', 5, 13, 10, 4, 2899, '2024-06-21 01:27:46', '2024-06-21 01:27:46'),
(12, 'LG 27GR95QE-B 27\" 240hz', 2, 9, 11, 4, 16999, '2024-06-21 01:29:26', '2024-06-21 01:29:26'),
(13, 'Gigabyte Z790 Aorus Xtreme', 6, 1, 12, 4, 12999, '2024-06-21 01:30:29', '2024-06-21 01:30:29'),
(14, 'Gigabyte Z790 Aorus Xtreme', 6, 13, 12, 4, 12999, '2024-06-21 01:30:50', '2024-06-21 01:30:50'),
(15, 'Gigabyte X670E Aorus Pro X', 6, 13, 13, 4, 14999, '2024-06-21 01:32:01', '2024-06-21 01:32:01'),
(16, 'Intel 14700K 14th-gen 5.6 GHz', 7, 6, 14, 4, 21999, '2024-06-21 01:34:18', '2024-06-21 01:34:18'),
(17, 'AMD Ryzen™ 7 7800X3D', 7, 5, 15, 4, 19999, '2024-06-21 01:35:36', '2024-06-21 01:35:36'),
(18, 'AMD Ryzen 7 7800X3D', 7, 5, 15, 4, 19999, '2024-06-21 01:36:08', '2024-06-21 01:36:08'),
(19, 'RTX 4090 24gb', 8, 15, 16, 4, 84999, '2024-06-21 01:39:13', '2024-06-21 01:39:13'),
(20, 'AMD Radeon RX 7900 XT', 1, 1, 17, 4, 57999, '2024-06-21 01:43:46', '2024-06-21 01:43:46'),
(21, 'Apple M2 Air 8g 256gb', 1, 4, 1, 6, 65999, '2024-06-21 02:32:15', '2024-06-21 02:32:15'),
(22, 'Aorus 8g (2 x 4) 3200MT/s', 5, 13, 18, 6, 2599, '2024-06-21 02:34:09', '2024-06-21 02:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Employee', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(2, 'Manager', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(3, 'Admin', '2024-06-20 15:38:06', '2024-06-20 15:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('VIVzg4zfOuBtdnKdlesc2EAWumUAWXi7grdcPfsS', 7, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoick9QQ0VobjlMU250eUE2SnIxUk0yVUV4TnhLTHI5ZEpyTHRqUFplaiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAxIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9wcm9kdWN0P3BhZ2U9MSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NToiaXRlbXMiO2E6MDp7fXM6OToiZGlzY291bnRzIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O30=', 1719107026);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `company_name`, `created_at`, `updated_at`) VALUES
(1, 'Asus', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(2, 'MSI', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(3, 'HP', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(4, 'Apple', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(5, 'AMD', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(6, 'Intel', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(7, 'Logitech', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(8, 'Lenovo', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(9, 'LG', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(10, 'Samsung', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(11, 'Seasonic', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(12, 'EVGA', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(13, 'Gigabyte', '2024-06-20 15:38:06', '2024-06-20 15:38:06'),
(15, 'Nvidia', '2024-06-21 01:37:49', '2024-06-21 01:37:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_gender` bigint UNSIGNED NOT NULL,
  `fk_role` bigint UNSIGNED NOT NULL,
  `company_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` datetime NOT NULL,
  `suspended` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `contact_number` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `middle_name`, `last_name`, `fk_gender`, `fk_role`, `company_id`, `password`, `birthdate`, `suspended`, `created_at`, `updated_at`, `contact_number`) VALUES
(1, 'Charity', 'Friesen', 'Champlin', 1, 3, 'HP-1183', '$2y$10$pmS.5Gqqsig1T2XCbObnT.iEq5IdxIhHktH1sINJO0RtyEpaktCku', '1988-09-20 00:00:00', 0, '2024-06-20 15:38:07', '2024-06-20 15:38:07', '10653401967'),
(2, 'Corine', 'Schowalter', 'Price', 2, 1, 'HP-0959', '$2y$12$3M6AtfUNodinsWBneRfyr.VQX3DijW0lTki.NSBmjCRkMRZc45kd6', '2018-10-02 00:00:00', 0, '2024-06-20 15:38:07', '2024-06-21 02:30:19', '10173277388'),
(3, 'Enrico', 'Bahringer', 'Wyman', 2, 3, 'HP-0441', '$2y$10$M.MaIY6nAbAJpfwr9N.aeudO3BV1mtXv1IGuJqZrPiTqTwmaqpoO6', '2004-11-07 00:00:00', 0, '2024-06-20 15:38:07', '2024-06-20 15:38:07', '75900691916'),
(4, 'Harmony', 'Littel', 'Hickle', 1, 2, 'HP-1274', '$2y$12$6kIdTetuuYY2LcbRt2kLTe6CxnYLnc0LdeY./X2vE3HlNS8.Jo2Ku', '1995-03-03 00:00:00', 0, '2024-06-20 15:38:07', '2024-06-21 01:03:42', '44160810745'),
(5, 'Martine', 'Kreiger', 'Roberts', 2, 3, 'HP-1039', '$2y$10$NRhC.76Zi6UnBKuCV5FyS.IdDjHSRm6L.dx1Erp3.Ml8UHdjdWO66', '2003-07-04 00:00:00', 0, '2024-06-20 15:38:07', '2024-06-20 15:38:07', '41763079871'),
(6, 'Reta', 'Gutkowski', 'Emard', 2, 2, 'HP-0358', '$2y$12$DnwX9OJ8./v41rFGeKVDue6o41qoi3Djav75QhVNhnlTDGK7zU9oK', '2012-08-14 00:00:00', 0, '2024-06-20 15:38:07', '2024-06-21 02:37:08', '56060720980'),
(7, 'Aniya', 'Terry', 'O\'Hara', 1, 3, 'HP-1177', '$2y$12$G3yF0HqQRc5x9LLeBDxcBux4Msv9QjrlOdFsroUOZO3Z4Izsshd3a', '1987-06-03 00:00:00', 0, '2024-06-20 15:38:07', '2024-06-20 15:38:22', '23555299712'),
(8, 'Casey', 'Kunze', 'Hodkiewicz', 2, 3, 'HP-0798', '$2y$10$9DAjc40Tdb/NbBBHlY9uyuMP48ykvz34g5e8QRycM3hW9DoYmpdwq', '1979-03-14 00:00:00', 0, '2024-06-20 15:38:07', '2024-06-20 15:38:07', '19512041367'),
(9, 'Amelie', 'Pfeffer', 'Schaefer', 2, 2, 'HP-0971', '$2y$10$nsMKQEchCeEBcRzxqVcQxOVYgva2EzO8TFdBSyU3.NObMl/1MxsWG', '2000-10-28 00:00:00', 0, '2024-06-20 15:38:07', '2024-06-20 15:38:07', '66921951532'),
(10, 'Chesley', 'Frami', 'Conroy', 1, 3, 'HP-0032', '$2y$10$5OGyrNv/UA7tlJPw8V/qCO/mjfC5/5J5BTJP0NQW1uAhZTw3to4DW', '1983-01-02 00:00:00', 0, '2024-06-20 15:38:07', '2024-06-20 15:38:07', '80328167896');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicable_discounts`
--
ALTER TABLE `applicable_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicable_discounts_fk_product_foreign` (`fk_product`),
  ADD KEY `applicable_discounts_fk_discount_foreign` (`fk_discount`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_fk_product_snapshot_foreign` (`fk_product_snapshot`),
  ADD KEY `carts_fk_product_foreign` (`fk_product`),
  ADD KEY `carts_fk_payment_transaction_foreign` (`fk_payment_transaction`),
  ADD KEY `carts_fk_discount_foreign` (`fk_discount`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_discounts`
--
ALTER TABLE `general_discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `general_discounts_fk_discount_unique` (`fk_discount`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_transactions_fk_user_foreign` (`fk_user`),
  ADD KEY `payment_transactions_fk_payment_method_foreign` (`fk_payment_method`),
  ADD KEY `payment_transactions_fk_discount_foreign` (`fk_discount`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_barcode_unique` (`barcode`),
  ADD KEY `products_fk_category_foreign` (`fk_category`),
  ADD KEY `products_fk_supplier_foreign` (`fk_supplier`);

--
-- Indexes for table `product_image_links`
--
ALTER TABLE `product_image_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_image_links_fk_product_foreign` (`fk_product`);

--
-- Indexes for table `product_restocks`
--
ALTER TABLE `product_restocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_restocks_fk_product_foreign` (`fk_product`),
  ADD KEY `product_restocks_fk_user_foreign` (`fk_user`);

--
-- Indexes for table `product_snapshots`
--
ALTER TABLE `product_snapshots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_snapshots_fk_product_foreign` (`fk_product`),
  ADD KEY `product_snapshots_fk_category_foreign` (`fk_category`),
  ADD KEY `product_snapshots_fk_supplier_foreign` (`fk_supplier`),
  ADD KEY `product_snapshots_fk_user_foreign` (`fk_user`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_company_id_unique` (`company_id`),
  ADD KEY `users_fk_gender_foreign` (`fk_gender`),
  ADD KEY `users_fk_role_foreign` (`fk_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicable_discounts`
--
ALTER TABLE `applicable_discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `general_discounts`
--
ALTER TABLE `general_discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_image_links`
--
ALTER TABLE `product_image_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_restocks`
--
ALTER TABLE `product_restocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_snapshots`
--
ALTER TABLE `product_snapshots`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicable_discounts`
--
ALTER TABLE `applicable_discounts`
  ADD CONSTRAINT `applicable_discounts_fk_discount_foreign` FOREIGN KEY (`fk_discount`) REFERENCES `discounts` (`id`),
  ADD CONSTRAINT `applicable_discounts_fk_product_foreign` FOREIGN KEY (`fk_product`) REFERENCES `products` (`id`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_fk_discount_foreign` FOREIGN KEY (`fk_discount`) REFERENCES `discounts` (`id`),
  ADD CONSTRAINT `carts_fk_payment_transaction_foreign` FOREIGN KEY (`fk_payment_transaction`) REFERENCES `payment_transactions` (`id`),
  ADD CONSTRAINT `carts_fk_product_foreign` FOREIGN KEY (`fk_product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `carts_fk_product_snapshot_foreign` FOREIGN KEY (`fk_product_snapshot`) REFERENCES `product_snapshots` (`id`);

--
-- Constraints for table `general_discounts`
--
ALTER TABLE `general_discounts`
  ADD CONSTRAINT `general_discounts_fk_discount_foreign` FOREIGN KEY (`fk_discount`) REFERENCES `discounts` (`id`);

--
-- Constraints for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD CONSTRAINT `payment_transactions_fk_discount_foreign` FOREIGN KEY (`fk_discount`) REFERENCES `discounts` (`id`),
  ADD CONSTRAINT `payment_transactions_fk_payment_method_foreign` FOREIGN KEY (`fk_payment_method`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `payment_transactions_fk_user_foreign` FOREIGN KEY (`fk_user`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_fk_category_foreign` FOREIGN KEY (`fk_category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_fk_supplier_foreign` FOREIGN KEY (`fk_supplier`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `product_image_links`
--
ALTER TABLE `product_image_links`
  ADD CONSTRAINT `product_image_links_fk_product_foreign` FOREIGN KEY (`fk_product`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_restocks`
--
ALTER TABLE `product_restocks`
  ADD CONSTRAINT `product_restocks_fk_product_foreign` FOREIGN KEY (`fk_product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_restocks_fk_user_foreign` FOREIGN KEY (`fk_user`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `product_snapshots`
--
ALTER TABLE `product_snapshots`
  ADD CONSTRAINT `product_snapshots_fk_category_foreign` FOREIGN KEY (`fk_category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `product_snapshots_fk_product_foreign` FOREIGN KEY (`fk_product`) REFERENCES `product_snapshots` (`id`),
  ADD CONSTRAINT `product_snapshots_fk_supplier_foreign` FOREIGN KEY (`fk_supplier`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `product_snapshots_fk_user_foreign` FOREIGN KEY (`fk_user`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_fk_gender_foreign` FOREIGN KEY (`fk_gender`) REFERENCES `genders` (`id`),
  ADD CONSTRAINT `users_fk_role_foreign` FOREIGN KEY (`fk_role`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
