-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 23, 2026 lúc 11:35 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `kinhmat_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Gọng Kính Kim Loại', 'gong-kim-loai', 'Thanh lịch, nhẹ, phù hợp dân văn phòng', '2026-04-13 03:58:33', '2026-04-13 03:58:33'),
(2, 'Kính Râm Thời Trang', 'kinh-ram', 'Chống UV, thời trang cao cấp', '2026-04-13 03:58:33', '2026-04-13 03:58:33'),
(3, 'Gọng Kính Nhựa Dẻo', 'gong-nhua', 'Trẻ trung, giá tốt, dễ phối đồ', '2026-04-13 03:58:33', '2026-04-13 03:58:33'),
(4, 'Tròng Kính & Phụ Kiện', 'trong-kinh', 'Bảo vệ mắt, chống ánh sáng xanh', '2026-04-13 03:58:33', '2026-04-13 03:58:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_07_053943_create_categories_table', 1),
(5, '2026_04_07_054116_create_products_table', 1),
(6, '2026_04_13_080554_create_orders_table', 1),
(7, '2026_04_13_080556_create_order_items_table', 1),
(8, '2026_04_13_180225_add_phone_address_to_users_table', 2),
(9, '2026_04_21_135207_create_stores_table', 3),
(10, '2026_04_21_192727_add_likes_count_to_products_table', 4),
(11, '2026_04_21_194326_force_add_likes_count_to_products', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `total_amount` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `phone`, `address`, `notes`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(14, 'ANNA2QMPYMZF', 3, '0989310104', '123', NULL, 337500, 'cancelled', '2026-04-13 06:21:36', '2026-04-13 11:59:03'),
(15, 'ANNALABDKEZ1', 3, '0989310104', '123', NULL, 5123000, 'cancelled', '2026-04-13 06:27:45', '2026-04-13 11:57:43'),
(16, 'ANNALK6ZKBGC', 3, '0989310104', '320 xuân phương', '12h', 2359000, 'cancelled', '2026-04-13 11:59:28', '2026-04-13 12:08:51'),
(17, 'ANNARDA8CU1R', 3, '0989310104', '320 xuân phương', NULL, 5055500, 'completed', '2026-04-13 12:27:33', '2026-04-23 02:21:13'),
(18, 'ANNAAYBHLDH4', 3, '0989310104', '320 xuân phương', NULL, 450000, 'cancelled', '2026-04-14 03:56:16', '2026-04-23 02:05:56'),
(19, 'ANNAUFYZML2C', 3, '0989310104', '320 xuân phương', 'giao sieu toc', 1971500, 'cancelled', '2026-04-16 17:46:39', '2026-04-23 02:05:52'),
(20, 'ANNANJPIGNAX', 3, '0989310104', '320 xuân phương', NULL, 697000, 'cancelled', '2026-04-16 18:42:37', '2026-04-22 06:54:29'),
(21, 'ANNAZFPMGWMU', 4, '0989310104', '320 xuân phương', NULL, 296997, 'cancelled', '2026-04-22 09:46:44', '2026-04-22 10:39:52'),
(22, 'ANNAN88QVEKN', 4, '0989310104', '320 xuân phương', NULL, 98999, 'refunded', '2026-04-22 09:51:09', '2026-04-22 14:31:46'),
(23, 'ANNAJHFNUFV5', 4, '0989310104', '320 xuân phương', NULL, 98999, 'cancelled', '2026-04-22 10:09:47', '2026-04-23 02:06:44'),
(24, 'ANNA5UBQWOGW', 3, '0989310104', '320 xuân phương', NULL, 98999, 'cancelled', '2026-04-22 14:50:16', '2026-04-23 02:05:46'),
(25, 'ANNASN4AQXHL', 3, '0989310104', '320 xuân phương', NULL, 98999, 'cancelled', '2026-04-22 14:58:20', '2026-04-23 02:05:40'),
(26, 'ANNAGZ8DHY1T', 3, '0989310104', '320 xuân phương', NULL, 697000, 'cancelled', '2026-04-22 15:02:05', '2026-04-23 02:04:57'),
(27, 'ANNAAP2FTBDE', 3, '0989310104', '320 xuân phương', NULL, 337500, 'completed', '2026-04-22 15:04:54', '2026-04-23 02:21:01'),
(28, 'ANNAH34YDVDC', 3, '0989310104', '320 xuân phương', NULL, 300000, 'refunded', '2026-04-22 15:05:09', '2026-04-23 02:19:22'),
(29, 'ANNAYG0YJUFB', 3, '0989310104', '320 xuân phương', NULL, 1100000, 'cancelled', '2026-04-23 01:58:51', '2026-04-23 02:00:31'),
(30, 'ANNAW7A1MG6Y', 3, '0989310104', '320 xuân phương', NULL, 98999, 'refunded', '2026-04-23 02:00:56', '2026-04-23 02:13:44'),
(31, 'ANNANDD6TIGC', 4, '0989310104', '320 xuân phương', NULL, 2083499, 'cancelled', '2026-04-23 02:06:28', '2026-04-23 02:09:54'),
(32, 'ANNA2IZGT8YN', 4, '0989310104', 'Đường Km11 - Thị Trấn Hợp Châu - Tam Đảo - Vĩnh Phúc', NULL, 98999, 'completed', '2026-04-23 02:10:08', '2026-04-23 02:19:38'),
(33, 'ANNA5P6B2OLK', 4, '0989310104', 'Đường Km11 - Thị Trấn Hợp Châu - Tam Đảo - Vĩnh Phúc', NULL, 1133499, 'cancelled', '2026-04-23 02:10:30', '2026-04-23 02:13:30'),
(34, 'ANNAN40SME6L', 4, '0989310104', 'Đường Km11 - Thị Trấn Hợp Châu - Tam Đảo - Vĩnh Phúc', NULL, 1783499, 'cancelled', '2026-04-23 02:12:34', '2026-04-23 02:12:38'),
(35, 'ANNAI9NY0N1N', 4, '0989310104', 'Đường Km11 - Thị Trấn Hợp Châu - Tam Đảo - Vĩnh Phúc', '12h đêm', 1783499, 'shipped', '2026-04-23 02:22:21', '2026-04-23 02:26:27'),
(36, 'ANNA2NUZSATM', 4, '0989310104', 'Đường Km11 - Thị Trấn Hợp Châu - Tam Đảo - Vĩnh Phúc', '12h', 593994, 'pending_payment', '2026-04-23 02:28:36', '2026-04-23 02:28:36'),
(37, 'ANNAR1KATBHW', 4, '0989310104', 'Đường Km11 - Thị Trấn Hợp Châu - Tam Đảo - Vĩnh Phúc', NULL, 98999, 'cancelled', '2026-04-23 02:30:35', '2026-04-23 02:31:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 14, 2, 1, 337500, '2026-04-13 06:21:36', '2026-04-13 06:21:36'),
(2, 15, 1, 1, 697000, '2026-04-13 06:27:45', '2026-04-13 06:27:45'),
(3, 15, 2, 1, 337500, '2026-04-13 06:27:45', '2026-04-13 06:27:45'),
(4, 15, 3, 1, 650000, '2026-04-13 06:27:45', '2026-04-13 06:27:45'),
(5, 15, 4, 1, 674500, '2026-04-13 06:27:45', '2026-04-13 06:27:45'),
(6, 15, 5, 1, 984000, '2026-04-13 06:27:45', '2026-04-13 06:27:45'),
(7, 15, 6, 1, 1100000, '2026-04-13 06:27:45', '2026-04-13 06:27:45'),
(8, 15, 7, 1, 300000, '2026-04-13 06:27:45', '2026-04-13 06:27:45'),
(9, 15, 8, 1, 380000, '2026-04-13 06:27:45', '2026-04-13 06:27:45'),
(10, 16, 1, 1, 697000, '2026-04-13 11:59:28', '2026-04-13 11:59:28'),
(11, 16, 2, 1, 337500, '2026-04-13 11:59:28', '2026-04-13 11:59:28'),
(12, 16, 3, 1, 650000, '2026-04-13 11:59:28', '2026-04-13 11:59:28'),
(13, 16, 4, 1, 674500, '2026-04-13 11:59:28', '2026-04-13 11:59:28'),
(14, 17, 1, 2, 697000, '2026-04-13 12:27:33', '2026-04-13 12:27:33'),
(15, 17, 2, 3, 337500, '2026-04-13 12:27:33', '2026-04-13 12:27:33'),
(16, 17, 3, 2, 650000, '2026-04-13 12:27:33', '2026-04-13 12:27:33'),
(17, 17, 4, 2, 674500, '2026-04-13 12:27:33', '2026-04-13 12:27:33'),
(18, 18, 2, 1, 450000, '2026-04-14 03:56:16', '2026-04-14 03:56:16'),
(19, 19, 2, 1, 337500, '2026-04-16 17:46:39', '2026-04-16 17:46:39'),
(20, 19, 3, 1, 650000, '2026-04-16 17:46:39', '2026-04-16 17:46:39'),
(21, 19, 5, 1, 984000, '2026-04-16 17:46:39', '2026-04-16 17:46:39'),
(22, 20, 1, 1, 697000, '2026-04-16 18:42:38', '2026-04-16 18:42:38'),
(23, 21, 13, 3, 98999, '2026-04-22 09:46:44', '2026-04-22 09:46:44'),
(24, 22, 13, 1, 98999, '2026-04-22 09:51:09', '2026-04-22 09:51:09'),
(25, 23, 13, 1, 98999, '2026-04-22 10:09:47', '2026-04-22 10:09:47'),
(26, 24, 13, 1, 98999, '2026-04-22 14:50:16', '2026-04-22 14:50:16'),
(27, 25, 13, 1, 98999, '2026-04-22 14:58:20', '2026-04-22 14:58:20'),
(28, 26, 1, 1, 697000, '2026-04-22 15:02:05', '2026-04-22 15:02:05'),
(29, 27, 2, 1, 337500, '2026-04-22 15:04:54', '2026-04-22 15:04:54'),
(30, 28, 7, 1, 300000, '2026-04-22 15:05:09', '2026-04-22 15:05:09'),
(31, 29, 6, 1, 1100000, '2026-04-23 01:58:51', '2026-04-23 01:58:51'),
(32, 30, 13, 1, 98999, '2026-04-23 02:00:56', '2026-04-23 02:00:56'),
(33, 31, 13, 1, 98999, '2026-04-23 02:06:28', '2026-04-23 02:06:28'),
(34, 31, 1, 1, 697000, '2026-04-23 02:06:28', '2026-04-23 02:06:28'),
(35, 31, 2, 1, 337500, '2026-04-23 02:06:28', '2026-04-23 02:06:28'),
(36, 31, 3, 1, 650000, '2026-04-23 02:06:28', '2026-04-23 02:06:28'),
(37, 31, 7, 1, 300000, '2026-04-23 02:06:28', '2026-04-23 02:06:28'),
(38, 32, 13, 1, 98999, '2026-04-23 02:10:08', '2026-04-23 02:10:08'),
(39, 33, 13, 1, 98999, '2026-04-23 02:10:30', '2026-04-23 02:10:30'),
(40, 33, 1, 1, 697000, '2026-04-23 02:10:30', '2026-04-23 02:10:30'),
(41, 33, 2, 1, 337500, '2026-04-23 02:10:30', '2026-04-23 02:10:30'),
(42, 34, 13, 1, 98999, '2026-04-23 02:12:34', '2026-04-23 02:12:34'),
(43, 34, 1, 1, 697000, '2026-04-23 02:12:34', '2026-04-23 02:12:34'),
(44, 34, 2, 1, 337500, '2026-04-23 02:12:34', '2026-04-23 02:12:34'),
(45, 34, 3, 1, 650000, '2026-04-23 02:12:34', '2026-04-23 02:12:34'),
(46, 35, 13, 1, 98999, '2026-04-23 02:22:21', '2026-04-23 02:22:21'),
(47, 35, 1, 1, 697000, '2026-04-23 02:22:21', '2026-04-23 02:22:21'),
(48, 35, 2, 1, 337500, '2026-04-23 02:22:21', '2026-04-23 02:22:21'),
(49, 35, 3, 1, 650000, '2026-04-23 02:22:21', '2026-04-23 02:22:21'),
(50, 36, 13, 6, 98999, '2026-04-23 02:28:36', '2026-04-23 02:28:36'),
(51, 37, 13, 1, 98999, '2026-04-23 02:30:35', '2026-04-23 02:30:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `likes_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `sale_price` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sold` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(2,1) NOT NULL DEFAULT 5.0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `likes_count`, `image`, `stock`, `sale_price`, `is_featured`, `sold`, `rating`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gọng Titan CTY Siêu Nhẹ T100', 'gong-titan-cty-sieu-nhe-t100-1', 'Gọng titan cao cấp siêu nhẹ, chống gỉ, phù hợp dân văn phòng.', 850000, 3, 'products/XsejtaxxAwacO4yKwMFJh0ZkPDTIJ4Y0bYSciZ8d.png', 45, 697000, 0, 863, 4.5, '2026-04-13 03:58:33', '2026-04-23 02:13:30'),
(2, 1, 'Gọng Tròn Vintage Classic', 'gong-tron-vintage-classic', 'Phong cách cổ điển, phù hợp học sinh sinh viên.', 450000, 3, 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=500', 34, 337500, 0, 255, 4.2, '2026-04-13 03:58:33', '2026-04-23 02:13:30'),
(3, 1, 'Gọng Kim Loại Hàn Quốc Slim', 'gong-kim-loai-han-quoc-slim-3', 'Thiết kế mảnh, nhẹ, phong cách Hàn Quốc.', 650000, 4, 'products/dDPNqNuWIr5lF7fasHdFW9xXacwmtjmNX9XNsQyJ.webp', 96, NULL, 0, 1275, 4.3, '2026-04-13 03:58:33', '2026-04-23 02:12:38'),
(4, 2, 'Kính Râm Chống UV400 R05', 'kinh-ram-chong-uv400-r05-4', 'Chống tia UV400, thiết kế thời thượng, phù hợp đi biển, du lịch.', 950000, 2, 'products/SeL7CPGHnSlOr0LAzu0bseFmlT8rOtE9FfnmdXqB.jpg', 80, 674500, 0, 804, 4.9, '2026-04-13 03:58:33', '2026-04-22 06:21:00'),
(5, 2, 'Kính Mát Thời Trang Oversize', 'kinh-mat-thoi-trang-oversize-5', 'Form lớn, phong cách thời trang cao cấp che khuyết điểm khuôn mặt.', 1200000, 2, 'products/f74TTvSKqxYyRedZ0Gk8Ig133BdUHwb7j3hyryAh.jpg', 77, 984000, 1, 444, 4.1, '2026-04-13 03:58:33', '2026-04-23 02:05:52'),
(6, 2, 'Kính Râm Nam Polarized', 'kinh-ram-nam-polarized-6', 'Tròng kính phân cực chống chói, phù hợp lái xe đường dài.', 1100000, 2, 'products/PUDGDy9sKxWuAfRRGMIBhrVYkKdhrgNtHslV6m7n.jpg', 72, NULL, 0, 786, 4.6, '2026-04-13 03:58:33', '2026-04-23 02:00:31'),
(7, 3, 'Gọng Nhựa Dẻo Basic Đen', 'gong-nhua-deo-basic-den', 'Giá rẻ, siêu bền, chịu va đập tốt, phù hợp học sinh.', 300000, 2, 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=500', 26, NULL, 0, 79, 4.0, '2026-04-13 03:58:33', '2026-04-23 02:19:22'),
(8, 3, 'Gọng Nhựa Trong Suốt HQ', 'gong-nhua-trong-suot-hq-8', 'Phong cách trong suốt trẻ trung, đang là hot trend hiện nay.', 380000, 2, 'products/ADhq9G49MqD4iX1hID0blcoSywlqt9UiYIG97nik.jpg', 84, NULL, 1, 319, 5.0, '2026-04-13 03:58:33', '2026-04-22 06:23:43'),
(9, 3, 'Gọng Nhựa Vuông Cá Tính', 'gong-nhua-vuong-ca-tinh-9', 'Form vuông cá tính, dễ phối đồ, phù hợp mặt tròn.', 350000, 2, 'products/exPbEOqwdphiWp02JWt4sXAj88O3ihXMt4fXuZCl.jpg', 32, NULL, 1, 957, 4.1, '2026-04-13 03:58:33', '2026-04-22 09:12:12'),
(10, 4, 'Tròng Chống Ánh Sáng Xanh', 'trong-chong-anh-sang-xanh-10', 'Bảo vệ mắt tối đa khi dùng máy tính, điện thoại thời gian dài.', 650000, 1, 'products/mxzsZCYEyGyiVRXGMt5LILiKAIv5geAocG7I7rqd.jpg', 80, 585000, 1, 1176, 5.0, '2026-04-13 03:58:33', '2026-04-22 06:25:25'),
(11, 4, 'Tròng Đổi Màu Đi Nắng', 'trong-doi-mau-di-nang-11', 'Ra nắng tự đổi màu thành kính râm, chống UV tuyệt đối.', 1100000, 1, 'products/32AcGHlIvfPGIMhGtvaRc6jxMC2EU9i7EA9w2DdW.jpg', 64, 957000, 0, 1147, 5.0, '2026-04-13 03:58:33', '2026-04-22 06:26:21'),
(12, 4, 'Tròng Cận Siêu Mỏng 1.67', 'trong-can-sieu-mong-167-12', 'Dành cho người cận nặng, siêu mỏng nhẹ, hạn chế tăng độ.', 1500000, 1, 'products/5Dd3nh5sUvCjOPvvHiJgZS2sw0SHmJWxFslmmCqO.png', 57, NULL, 1, 1270, 4.0, '2026-04-13 03:58:33', '2026-04-22 06:27:28'),
(13, 1, 'Gọng kính viền kim loại ANKL014', 'gong-kinh-vien-kim-loai-ankl014-1776865225', 'Gọng kim loại phù hợp mọi lứa tuổi', 1599999, 0, 'products/SneiRdbPTLOxZpAfdLOjBXNNHOXP4dDtDPAhJbhY.jpg', 111, 98999, 1, 0, 5.0, '2026-04-22 06:40:25', '2026-04-23 02:31:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('P6eVa5tfbG0QzmhY4pqFfXW8YAxDRo5548zqmopO', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNHBSSDh6WXlmY1pINWxmRHh1OHRHdkZodVg4bjJtbUprVEY5VjZ2MCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWxlIjtzOjU6InJvdXRlIjtzOjEzOiJwcm9maWxlLmluZGV4Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1776936705);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `open_time` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `map_url` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `stores`
--

INSERT INTO `stores` (`id`, `name`, `address`, `phone`, `open_time`, `city`, `map_url`, `created_at`, `updated_at`) VALUES
(2, 'Kính Mắt Anna - Tam Đảo', 'Đường Km11 - Thị Trấn Hợp Châu - Tam Đảo - Vĩnh Phúc', '0989310104', '09:00 - 22:00', 'Vĩnh Phúc', 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d596.4113187966999!2d105.6192922406174!3d21.399440300669884!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1776796594186!5m2!1svi!2s', '2026-04-21 11:40:38', '2026-04-21 11:40:38'),
(3, 'Kính Mắt Anna - Chùa Bộc', 'Số 15 Chùa Bộc - Đống Đa', '0989310104', '09:00 - 22:00', 'Hà Nội', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.6520449274235!2d105.8301528!3d21.0065806!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ad00020f171b%3A0xcf192ab76c376f50!2sBlanc%20Boutique!5e0!3m2!1svi!2s!4v1776797387501!5m2!1svi!2s', '2026-04-21 11:50:15', '2026-04-21 11:50:15'),
(4, 'Kính Mắt Anna - Phan Văn Hớn', 'Số 90 Phan Văn Hớn - Phường Đông Hưng Thuận', '0989310104', '09:00 - 22:00', 'TP.HCM', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d244.9238441346936!2d106.62172509472535!3d10.828025981459344!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752b69aaee591b%3A0xb26169b99dfa976b!2sAnna%20Hair%20Salon!5e0!3m2!1svi!2s!4v1776797475766!5m2!1svi!2s', '2026-04-21 11:52:04', '2026-04-21 11:52:04'),
(5, 'Kính Mắt Anna - Xuân Phương', 'Số 320 Xuân Phương - Phường Từ Liêm', '0989310104', '09:00 - 22:00', 'Hà Nội', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.0682495299616!2d105.7391514!3d21.029954999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455004caf2c0d%3A0x7e86eb53fc3c5253!2zTmjDoCB0cuG7jQ!5e0!3m2!1svi!2s!4v1776798065074!5m2!1svi!2s', '2026-04-21 11:54:32', '2026-04-21 12:01:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Tổng Tài', 'admin@gmail.com', NULL, NULL, NULL, '$2y$12$jK6WILrIHwnPiS/jcisCKuAqxJnSEsIrEspr9sr4p3FPPkV8s30oO', 'admin', NULL, '2026-04-13 04:03:14', '2026-04-13 04:03:14'),
(3, 'Nguyễn Văn A', 'NguyenVanA@gmail.com', '0989310104', '320 xuân phương', NULL, '$2y$12$d48B2u81Ghrn/QdAUYotI.AO9zeeOX9KbLjAbkuul97QP08rwaGYW', 'user', NULL, '2026-04-13 04:04:36', '2026-04-13 11:31:02'),
(4, 'Trần Văn B', 'TranVanB@gmail.com', '0989310104', 'Đường Km11 - Thị Trấn Hợp Châu - Tam Đảo - Vĩnh Phúc', NULL, '$2y$12$A5Rzqs8frRX1931IzIOXLusf8akbM9TTVz8ieF./stMpYU172Izuy', 'user', 'ACE0rLRQ0o3GbFH9JmfrfhJVi2N13zxLEulm33QWwUPRkHCTWvqU7IN8fTTO', '2026-04-22 06:55:36', '2026-04-23 02:08:27');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
