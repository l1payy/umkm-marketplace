-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 22 Jan 2026 pada 06.19
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `laravel2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 6, '2026-01-19 07:23:31', '2026-01-19 07:23:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `offer_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `offer_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(9, 1, NULL, 2, 1, 200000.00, '2026-01-21 02:43:16', '2026-01-21 02:43:16'),
(10, 1, 163, NULL, 1, 17805520.00, '2026-01-21 12:07:33', '2026-01-21 12:07:33'),
(11, 1, 168, NULL, 1, 21097520.00, '2026-01-21 12:08:37', '2026-01-21 12:08:37'),
(12, 1, NULL, 11, 1, 427335.00, '2026-01-21 12:43:09', '2026-01-21 12:43:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `partner_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `conversations`
--

INSERT INTO `conversations` (`id`, `user_id`, `partner_id`, `created_at`, `updated_at`) VALUES
(1, 7, 8, '2026-01-19 07:26:04', '2026-01-19 07:26:04'),
(2, 6, 12, '2026-01-21 01:59:50', '2026-01-21 01:59:50'),
(3, 6, 9, '2026-01-21 02:43:14', '2026-01-21 02:43:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `body`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 1, 8, 'Halo! Ada yang bisa dibantu untuk kebutuhan UMKM kamu?', NULL, '2026-01-19 07:26:04', '2026-01-19 07:26:04'),
(2, 1, 8, 'Halo! Ada yang bisa dibantu untuk kebutuhan UMKM kamu?', NULL, '2026-01-20 02:39:57', '2026-01-20 02:39:57'),
(3, 1, 8, 'Halo! Ada yang bisa dibantu untuk kebutuhan UMKM kamu?', NULL, '2026-01-21 11:50:54', '2026-01-21 11:50:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_15_172606_create_needs_table', 1),
(6, '2026_01_15_172606_create_offers_table', 1),
(7, '2026_01_15_172606_create_products_table', 1),
(8, '2026_01_15_172607_create_cart_items_table', 1),
(9, '2026_01_15_172607_create_carts_table', 1),
(10, '2026_01_15_172607_create_order_items_table', 1),
(11, '2026_01_15_172607_create_orders_table', 1),
(12, '2026_01_16_000001_create_conversations_table', 1),
(13, '2026_01_16_000002_create_messages_table', 1),
(14, '2026_01_16_120000_remove_eta_days_from_offers_table', 1),
(15, '2026_01_18_120100_add_category_city_to_products', 1),
(16, '2026_01_18_120200_create_reviews_table', 1),
(17, '2026_01_19_000001_add_payment_columns_to_orders_table', 1),
(18, '2026_01_19_000002_add_payout_fields_to_users_table', 1),
(19, '2026_01_20_160100_add_eta_days_to_offers_table', 2),
(20, '2026_01_20_173000_create_payments_table', 3),
(21, '2026_01_21_010000_create_product_details_table', 4),
(22, '2026_01_21_120000_add_profile_fields_to_users_table', 5),
(23, '2026_01_21_130000_create_product_images_table', 6),
(24, '2026_01_21_140000_add_image_path_to_offers_table', 7),
(25, '2026_01_22_120000_add_payment_fields_to_users_table', 8),
(26, '2026_01_22_121500_add_provider_fields_to_users_table', 9),
(27, '2026_01_22_123000_create_user_payouts_table', 10),
(28, '2026_01_22_124000_add_seller_payout_id_to_payments_table', 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `needs`
--

CREATE TABLE `needs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `budget_min` decimal(12,2) DEFAULT NULL,
  `budget_max` decimal(12,2) DEFAULT NULL,
  `reference_image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('open','closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `needs`
--

INSERT INTO `needs` (`id`, `user_id`, `title`, `description`, `budget_min`, `budget_max`, `reference_image_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 7, 'Quia a quo et corrupti.', 'Voluptatem qui consequuntur modi labore ducimus quas rem. Molestiae explicabo perspiciatis eligendi possimus vel odit. Repellendus expedita quidem enim odio autem doloribus nihil. Consequuntur sapiente recusandae itaque. Aut et quod at pariatur et sapiente asperiores incidunt.', 1641738.78, 4955910.63, NULL, 'open', '2026-01-19 07:26:04', '2026-01-19 07:26:04'),
(2, 7, 'Non facere eos.', 'Est minus dolorum iste aut sit ullam. Dolorem tempora eos dolorem et veritatis. Ut ut sed sint sint recusandae maiores in qui.', 1357996.16, 5459776.16, NULL, 'open', '2026-01-19 07:26:04', '2026-01-19 07:26:04'),
(3, 6, 'saya butuh lotion badan', 'lotion pelembab badan', 10000.00, 100000.00, 'references/yFuXtRkdINr5PueagZdRu8rAAj28Oc7nQktGxjLk.jpg', 'open', '2026-01-20 00:10:32', '2026-01-20 00:10:32'),
(4, 7, 'Facilis omnis quis laudantium.', 'Sunt maxime quia a dolor rerum vitae rerum. Officia amet ea saepe nobis quia. Dolores voluptatum voluptas ut non maiores occaecati temporibus et.', 1786376.14, 3270466.11, NULL, 'open', '2026-01-20 02:39:57', '2026-01-20 02:39:57'),
(5, 7, 'Nihil qui ducimus qui ea.', 'Voluptate cumque dolor fugiat laudantium ea asperiores perspiciatis. Fugit quia quibusdam quam enim sapiente laudantium molestiae maiores. Unde rerum non quibusdam magni qui et aut. Distinctio non nam reiciendis magnam.', 1676065.82, 4063623.33, NULL, 'open', '2026-01-20 02:39:57', '2026-01-20 02:39:57'),
(6, 6, 'bang gua butuh laptop murah', 'laptop murah untuk kuliah', 2000000.00, 3000000.00, 'references/ert6ibLTLWA31jcxAiiNEvTvc5X8H1ACeq7cDyfh.png', 'open', '2026-01-20 02:42:57', '2026-01-20 02:42:57'),
(7, 6, 'aku butuh hp murah', 'lokasi medan harga murahh seperti foto', 200000.00, 500000.00, 'references/aSsqaPU1Bqus8zlfAIijjvTJZGnevXh4DdwemfYJ.jpg', 'open', '2026-01-20 05:35:15', '2026-01-20 05:35:15'),
(8, 19, 'Jam tangan kasual pria', 'Cari produk berkualitas dengan harga terjangkau. Prioritas yang ready stock.', 995000.00, 1834103.00, 'references/ref-6970adde555a2.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(9, 9, 'Kaos polos bahan nyaman', 'Fokus pada performa dan kenyamanan penggunaan harian.', 679406.00, 1000958.00, 'references/ref-6970adde68b19.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(10, 7, 'Sepatu lari anti selip', 'Butuh segera, bisa COD atau kirim cepat. Garansi diutamakan.', 800310.00, 1678467.00, 'references/ref-6970adde6b90f.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(11, 19, 'Laptop untuk desain grafis', 'Cari produk berkualitas dengan harga terjangkau. Prioritas yang ready stock.', 226445.00, 872889.00, 'references/ref-6970adde6e9c4.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(12, 19, 'Sepatu lari anti selip', 'Fokus pada performa dan kenyamanan penggunaan harian.', 635289.00, 1428720.00, 'references/ref-6970adde713fa.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(13, 10, 'Jasa servis AC panggilan', 'Butuh segera, bisa COD atau kirim cepat. Garansi diutamakan.', 996262.00, 1790760.00, 'references/ref-6970adde737b1.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(14, 8, 'Kamera mirrorless untuk konten', 'Tolong rekomendasikan yang awet dan sesuai kebutuhan.', 526413.00, 704288.00, 'references/ref-6970adde75cba.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(15, 14, 'Meja kerja minimalis', 'Fokus pada performa dan kenyamanan penggunaan harian.', 495343.00, 1006322.00, 'references/ref-6970adde77a50.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(16, 16, 'Laptop untuk desain grafis', 'Fokus pada performa dan kenyamanan penggunaan harian.', 163197.00, 492865.00, 'references/ref-6970adde79953.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(17, 18, 'Jasa servis AC panggilan', 'Fokus pada performa dan kenyamanan penggunaan harian.', 731471.00, 1569857.00, 'references/ref-6970adde7b713.webp', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(18, 20, 'Jasa servis AC panggilan', 'Fokus pada performa dan kenyamanan penggunaan harian.', 530345.00, 1262376.00, 'references/ref-6970adde7dfcb.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(19, 17, 'Jam tangan kasual pria', 'Cari produk berkualitas dengan harga terjangkau. Prioritas yang ready stock.', 756697.00, 1042036.00, 'references/ref-6970adde80025.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(20, 14, 'Laptop untuk desain grafis', 'Fokus pada performa dan kenyamanan penggunaan harian.', 983831.00, 1675549.00, 'references/ref-6970adde820e3.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(21, 6, 'Speaker Bluetooth untuk acara', 'Tolong rekomendasikan yang awet dan sesuai kebutuhan.', 189504.00, 398886.00, 'references/ref-6970adde8407d.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(22, 15, 'Jasa servis AC panggilan', 'Fokus pada performa dan kenyamanan penggunaan harian.', 995632.00, 1635235.00, 'references/ref-6970adde861f5.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(23, 7, 'Meja kerja minimalis', 'Tolong rekomendasikan yang awet dan sesuai kebutuhan.', 735826.00, 1177243.00, 'references/ref-6970adde88243.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(24, 19, 'Laptop untuk desain grafis', 'Fokus pada performa dan kenyamanan penggunaan harian.', 956482.00, 1137175.00, 'references/ref-6970adde89f84.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(25, 12, 'Sepatu lari anti selip', 'Fokus pada performa dan kenyamanan penggunaan harian.', 942004.00, 1581148.00, 'references/ref-6970adde8c713.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(26, 12, 'Meja kerja minimalis', 'Butuh segera, bisa COD atau kirim cepat. Garansi diutamakan.', 372413.00, 558886.00, 'references/ref-6970adde8e81f.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(27, 12, 'Speaker Bluetooth untuk acara', 'Tolong rekomendasikan yang awet dan sesuai kebutuhan.', 374413.00, 1086722.00, 'references/ref-6970adde90985.jpg', 'open', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(28, 7, 'Qui minima molestiae doloremque sunt.', 'Ut id velit ducimus sed. Qui qui similique impedit et. Corporis quasi qui tenetur architecto temporibus.', 2831138.36, 5159529.76, NULL, 'open', '2026-01-21 11:50:54', '2026-01-21 11:50:54'),
(29, 7, 'Et non cumque corporis repellendus porro.', 'Ea ut aliquid est numquam. Et qui perspiciatis animi sint sed et voluptatem.', 2519694.26, 4593191.80, NULL, 'open', '2026-01-21 11:50:54', '2026-01-21 11:50:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `offers`
--

CREATE TABLE `offers` (
  `id` bigint UNSIGNED NOT NULL,
  `need_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `eta_days` int UNSIGNED NOT NULL DEFAULT '1',
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `offers`
--

INSERT INTO `offers` (`id`, `need_id`, `user_id`, `description`, `price`, `eta_days`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'nihhh ada bg', 10000.00, 1, NULL, '2026-01-20 02:27:27', '2026-01-20 02:27:27'),
(2, 7, 9, 'nihhh coyy ada hp yg abang mau murah aja', 200000.00, 300000, NULL, '2026-01-20 05:36:18', '2026-01-20 05:36:18'),
(3, 8, 13, 'Unit siap pakai, free ongkir area terdekat.', 1476362.00, 2, 'offers/offer-6970adde67023.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(4, 9, 18, 'Stok terbatas, bisa pesan warna. Pengiriman kilat.', 724890.00, 1, 'offers/offer-6970adde69925.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(5, 10, 12, 'Produk original bergaransi resmi. Siap kirim hari ini.', 1543540.00, 7, 'offers/offer-6970adde6ce27.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(6, 11, 14, 'Kualitas terjamin, ada bonus aksesoris. Harga boleh nego.', 294346.00, 6, 'offers/offer-6970adde6fa38.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(7, 12, 12, 'Kualitas terjamin, ada bonus aksesoris. Harga boleh nego.', 1380673.00, 4, 'offers/offer-6970adde7217e.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(8, 13, 7, 'Produk original bergaransi resmi. Siap kirim hari ini.', 1296497.00, 6, 'offers/offer-6970adde74664.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(9, 14, 15, 'Produk original bergaransi resmi. Siap kirim hari ini.', 561217.00, 2, 'offers/offer-6970adde769b7.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(10, 15, 10, 'Unit siap pakai, free ongkir area terdekat.', 809309.00, 5, 'offers/offer-6970adde78537.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(11, 16, 12, 'Unit siap pakai, free ongkir area terdekat.', 427335.00, 1, 'offers/offer-6970adde7a6d2.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(12, 17, 10, 'Unit siap pakai, free ongkir area terdekat.', 1425133.00, 2, 'offers/offer-6970adde7cf4f.webp', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(13, 18, 12, 'Stok terbatas, bisa pesan warna. Pengiriman kilat.', 753698.00, 2, 'offers/offer-6970adde7efee.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(14, 19, 7, 'Stok terbatas, bisa pesan warna. Pengiriman kilat.', 881594.00, 5, 'offers/offer-6970adde80fe4.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(15, 20, 21, 'Produk original bergaransi resmi. Siap kirim hari ini.', 1002198.00, 1, 'offers/offer-6970adde82e4e.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(16, 21, 18, 'Kualitas terjamin, ada bonus aksesoris. Harga boleh nego.', 299091.00, 6, 'offers/offer-6970adde84fa2.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(17, 22, 7, 'Kualitas terjamin, ada bonus aksesoris. Harga boleh nego.', 1616543.00, 3, 'offers/offer-6970adde8717b.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(18, 23, 8, 'Produk original bergaransi resmi. Siap kirim hari ini.', 934451.00, 4, 'offers/offer-6970adde89131.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(19, 24, 15, 'Stok terbatas, bisa pesan warna. Pengiriman kilat.', 974114.00, 5, 'offers/offer-6970adde8b48b.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(20, 25, 6, 'Kualitas terjamin, ada bonus aksesoris. Harga boleh nego.', 990616.00, 4, 'offers/offer-6970adde8d81b.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(21, 26, 8, 'Produk original bergaransi resmi. Siap kirim hari ini.', 558121.00, 1, 'offers/offer-6970adde8f817.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(22, 27, 15, 'Unit siap pakai, free ongkir area terdekat.', 1055316.00, 5, 'offers/offer-6970adde91996.jpg', '2026-01-21 03:43:42', '2026-01-21 03:43:42'),
(23, 17, 6, 'NIHHH BANG ADA SESUAI KEMAUAN ABANG', 100000.00, 200000, 'offers/jpnygY2JRJeLToDnOOmdWGJA5KkJX3XOrdbCf1Wk.jpg', '2026-01-21 03:59:18', '2026-01-21 03:59:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_channel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `payment_reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `total`, `payment_method`, `payment_channel`, `payment_status`, `payment_reference`, `created_at`, `updated_at`) VALUES
(1, 6, 'completed', 4775571.47, NULL, NULL, 'pending', NULL, '2026-01-20 02:37:21', '2026-01-20 02:37:21'),
(2, 6, 'pending', 3000000.00, NULL, NULL, 'pending', NULL, '2026-01-20 04:27:25', '2026-01-20 04:27:25'),
(3, 6, 'completed', 16464992.00, NULL, NULL, 'pending', NULL, '2026-01-20 10:30:13', '2026-01-20 10:30:19'),
(4, 6, 'completed', 93466.00, NULL, NULL, 'pending', NULL, '2026-01-20 11:28:19', '2026-01-20 11:28:27'),
(5, 6, 'pending', 200000.00, NULL, NULL, 'pending', NULL, '2026-01-21 02:43:18', '2026-01-21 02:43:18'),
(6, 6, 'completed', 1842132.00, NULL, NULL, 'pending', NULL, '2026-01-21 08:41:00', '2026-01-21 08:41:25'),
(7, 6, 'completed', 1000.00, NULL, NULL, 'pending', NULL, '2026-01-21 10:17:52', '2026-01-21 10:18:03'),
(8, 6, 'pending', 7564371.00, NULL, NULL, 'pending', NULL, '2026-01-21 12:07:37', '2026-01-21 12:07:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `offer_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` int UNSIGNED NOT NULL DEFAULT '1',
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `offer_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 1, 4775571.47, '2026-01-20 02:37:21', '2026-01-20 02:37:21'),
(2, 2, NULL, NULL, 1, 3000000.00, '2026-01-20 04:27:25', '2026-01-20 04:27:25'),
(3, 3, NULL, NULL, 1, 16464992.00, '2026-01-20 10:30:13', '2026-01-20 10:30:13'),
(4, 4, NULL, NULL, 1, 93466.00, '2026-01-20 11:28:19', '2026-01-20 11:28:19'),
(5, 5, NULL, 2, 1, 200000.00, '2026-01-21 02:43:18', '2026-01-21 02:43:18'),
(6, 6, NULL, NULL, 1, 1842132.00, '2026-01-21 08:41:00', '2026-01-21 08:41:00'),
(7, 7, NULL, NULL, 1, 1000.00, '2026-01-21 10:17:52', '2026-01-21 10:17:52'),
(8, 8, 161, NULL, 1, 7564371.00, '2026-01-21 12:07:37', '2026-01-21 12:07:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `method` enum('bank_transfer','e_wallet','qris') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `va_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qris_payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seller_payout_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `method`, `provider`, `amount`, `status`, `va_number`, `qris_payload`, `reference`, `paid_at`, `created_at`, `updated_at`, `seller_payout_id`) VALUES
(1, 2, 'qris', 'DANA', 3000000.00, 'pending', NULL, 'QRIS|ORDER#2|AMOUNT=3000000.00', 'INV-2-20260120112733', NULL, '2026-01-20 04:27:33', '2026-01-20 04:27:33', NULL),
(2, 3, 'bank_transfer', 'BCA', 16464992.00, 'paid', '6860000000003', NULL, 'INV-3-20260120173017', '2026-01-20 10:30:19', '2026-01-20 10:30:17', '2026-01-20 10:30:19', NULL),
(3, 4, 'bank_transfer', 'Mandiri', 93466.00, 'paid', '8960000000004', NULL, 'INV-4-20260120182826', '2026-01-20 11:31:45', '2026-01-20 11:28:26', '2026-01-20 11:31:45', NULL),
(4, 4, 'bank_transfer', 'BCA', 93466.00, 'paid', '6860000000004', NULL, 'INV-4-20260120183234', '2026-01-20 11:32:35', '2026-01-20 11:32:34', '2026-01-20 11:32:35', NULL),
(5, 4, 'bank_transfer', 'BNI', 93466.00, 'paid', '9880000000004', NULL, 'INV-4-20260120183240', '2026-01-20 11:32:41', '2026-01-20 11:32:40', '2026-01-20 11:32:41', NULL),
(6, 4, 'bank_transfer', 'BRI', 93466.00, 'pending', '8880000000004', NULL, 'INV-4-20260120183247', NULL, '2026-01-20 11:32:47', '2026-01-20 11:32:47', NULL),
(7, 4, 'bank_transfer', 'DANA', 93466.00, 'paid', '9990000000004', NULL, 'INV-4-20260120183259', '2026-01-20 11:33:01', '2026-01-20 11:32:59', '2026-01-20 11:33:01', NULL),
(8, 4, 'bank_transfer', 'QRIS', 93466.00, 'paid', '9990000000004', NULL, 'INV-4-20260120183305', '2026-01-20 11:33:07', '2026-01-20 11:33:05', '2026-01-20 11:33:07', NULL),
(9, 4, 'qris', 'QRIS', 93466.00, 'paid', NULL, 'QRIS|ORDER#4|AMOUNT=93466.00', 'INV-4-20260120183310', '2026-01-20 11:33:15', '2026-01-20 11:33:10', '2026-01-20 11:33:15', NULL),
(10, 6, 'bank_transfer', 'BCA', 1842132.00, 'pending', '6860000000006', NULL, 'INV-6-20260121154114', NULL, '2026-01-21 08:41:14', '2026-01-21 08:41:14', NULL),
(11, 6, 'bank_transfer', 'BCA', 1842132.00, 'paid', '6860000000006', NULL, 'INV-6-20260121154117', '2026-01-21 08:41:27', '2026-01-21 08:41:17', '2026-01-21 08:41:27', NULL),
(12, 7, 'qris', 'Mandiri', 1000.00, 'paid', NULL, 'QRIS|ORDER#7|AMOUNT=1000.00|REF=INV-7-20260121171757', 'INV-7-20260121171757', '2026-01-21 10:18:14', '2026-01-21 10:17:57', '2026-01-21 10:18:14', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `user_id`, `name`, `description`, `category`, `city`, `price`, `image_path`, `created_at`, `updated_at`) VALUES
(160, 9, 'iPhone seri performa tinggi', 'Handphone berkualitas dengan performa stabil, cocok untuk komunikasi, hiburan, dan produktivitas harian.', NULL, NULL, 3933114.00, 'products/handphone-bKQCSlEq.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(161, 9, 'Handphone kamera jernih untuk konten', 'Handphone berkualitas dengan performa stabil, cocok untuk komunikasi, hiburan, dan produktivitas harian.', NULL, NULL, 7564371.00, 'products/handphone-5bB6HpcK.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(162, 9, 'HP baterai besar tahan lama', 'Handphone berkualitas dengan performa stabil, cocok untuk komunikasi, hiburan, dan produktivitas harian.', NULL, NULL, 9036768.00, 'products/handphone-cqrmIToZ.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(163, 9, 'Smartphone Android layar luas', 'Handphone berkualitas dengan performa stabil, cocok untuk komunikasi, hiburan, dan produktivitas harian.', NULL, NULL, 17805520.00, 'products/handphone-jOVC0Sfi.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(164, 9, 'iPhone seri performa tinggi', 'Handphone berkualitas dengan performa stabil, cocok untuk komunikasi, hiburan, dan produktivitas harian.', NULL, NULL, 2126320.00, 'products/handphone-kfTZq5li.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(165, 10, 'Laptop gaming grafis mantap', 'Laptop handal untuk berbagai kebutuhan, dilengkapi prosesor cepat dan penyimpanan luas.', NULL, NULL, 11156275.00, 'products/laptop-D1mWZ80a.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(166, 10, 'Ultrabook profesional ringan', 'Laptop handal untuk berbagai kebutuhan, dilengkapi prosesor cepat dan penyimpanan luas.', NULL, NULL, 32927241.00, 'products/laptop-1lUAySZq.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(167, 10, 'Laptop bisnis dengan keamanan tinggi', 'Laptop handal untuk berbagai kebutuhan, dilengkapi prosesor cepat dan penyimpanan luas.', NULL, NULL, 3848038.00, 'products/laptop-Uyuas2vG.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(168, 10, 'Laptop tipis untuk kerja dan kuliah', 'Laptop handal untuk berbagai kebutuhan, dilengkapi prosesor cepat dan penyimpanan luas.', NULL, NULL, 21097520.00, 'products/laptop-zeztuW2J.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(169, 10, 'Laptop gaming grafis mantap', 'Laptop handal untuk berbagai kebutuhan, dilengkapi prosesor cepat dan penyimpanan luas.', NULL, NULL, 6638038.00, 'products/laptop-0aitoenH.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(170, 10, 'Ultrabook profesional ringan', 'Laptop handal untuk berbagai kebutuhan, dilengkapi prosesor cepat dan penyimpanan luas.', NULL, NULL, 6324023.00, 'products/laptop-5xnc2GUd.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(171, 11, 'Speaker Bluetooth bass mantap', 'Produk elektronik untuk meningkatkan kenyamanan dan hiburan di rumah.', NULL, NULL, 7738986.00, 'products/elektronik-SBpYy3tg.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(172, 11, 'Kamera digital hasil tajam', 'Produk elektronik untuk meningkatkan kenyamanan dan hiburan di rumah.', NULL, NULL, 2588622.00, 'products/elektronik-5CuoyXS0.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(173, 11, 'Perangkat rumah pintar', 'Produk elektronik untuk meningkatkan kenyamanan dan hiburan di rumah.', NULL, NULL, 3968477.00, 'products/elektronik-BKxxwop8.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(174, 11, 'Smart TV resolusi tinggi', 'Produk elektronik untuk meningkatkan kenyamanan dan hiburan di rumah.', NULL, NULL, 8561064.00, 'products/elektronik-QZmNhWPW.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(175, 11, 'Speaker Bluetooth bass mantap', 'Produk elektronik untuk meningkatkan kenyamanan dan hiburan di rumah.', NULL, NULL, 3690407.00, 'products/elektronik-sPjptfV4.webp', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(176, 11, 'Kamera digital hasil tajam', 'Produk elektronik untuk meningkatkan kenyamanan dan hiburan di rumah.', NULL, NULL, 3715125.00, 'products/elektronik-osdpU6MU.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(177, 12, 'Headset ergonomis noise-cancelling', 'Aksesoris pelengkap yang fungsional dan stylish untuk perangkat Anda.', NULL, NULL, 1475637.00, 'products/aksesoris-RdFqB5GI.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(178, 12, 'Charger cepat resmi', 'Aksesoris pelengkap yang fungsional dan stylish untuk perangkat Anda.', NULL, NULL, 814489.00, 'products/aksesoris-3c8ho3Ig.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(179, 12, 'Strap smartwatch nyaman', 'Aksesoris pelengkap yang fungsional dan stylish untuk perangkat Anda.', NULL, NULL, 150778.00, 'products/aksesoris-3cd9UamH.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(180, 12, 'Casing handphone premium', 'Aksesoris pelengkap yang fungsional dan stylish untuk perangkat Anda.', NULL, NULL, 1861808.00, 'products/aksesoris-DZK5aCG7.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(181, 12, 'Headset ergonomis noise-cancelling', 'Aksesoris pelengkap yang fungsional dan stylish untuk perangkat Anda.', NULL, NULL, 881710.00, 'products/aksesoris-AjXUY99r.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(182, 15, 'Sepatu lari breathable', 'Sepatu berkualitas dengan dukungan kaki yang baik dan tampilan menawan.', NULL, NULL, 629242.00, 'products/sepatu-rOJF2jDR.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(183, 16, 'Kue premium lembut', 'Produk makanan lezat yang diolah higienis, cocok untuk teman bekerja dan bersantai.', NULL, NULL, 69282.00, 'products/makanan-61BXGHNk.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(184, 16, 'Masakan rumahan beku', 'Produk makanan lezat yang diolah higienis, cocok untuk teman bekerja dan bersantai.', NULL, NULL, 348700.00, 'products/makanan-cxcT5nlC.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(185, 17, 'Teh wangi menyegarkan', 'Minuman berkualitas untuk menyegarkan hari Anda, dibuat dari bahan pilihan.', NULL, NULL, 349245.00, 'products/minuman-wbEElUoh.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(186, 17, 'Minuman herbal sehat', 'Minuman berkualitas untuk menyegarkan hari Anda, dibuat dari bahan pilihan.', NULL, NULL, 54656.00, 'products/minuman-q0N21s2I.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(187, 19, 'Sparepart mobil original', 'Produk otomotif berkualitas untuk perawatan dan peningkatan performa kendaraan.', NULL, NULL, 1034644.00, 'products/otomotif-dBVzxixb.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(188, 19, 'Helm standar SNI', 'Produk otomotif berkualitas untuk perawatan dan peningkatan performa kendaraan.', NULL, NULL, 2554472.00, 'products/otomotif-443LD7Eu.jpg', '2026-01-21 11:51:53', '2026-01-21 11:51:53'),
(189, 6, 'Vape', 'Pod Vape murah dan enak', 'Elektronik', NULL, 50000.00, 'products/U2iATRImMe8WX5tlROtE5QTGvMTmYnwUnz9IeiYU.jpg', '2026-01-21 20:50:01', '2026-01-21 20:50:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_details`
--

CREATE TABLE `product_details` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `material` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `care_label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specs` json DEFAULT NULL,
  `long_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `sku`, `material`, `care_label`, `specs`, `long_description`, `created_at`, `updated_at`) VALUES
(31, 189, '7878780780', 'Karbon', '20-3424-123', '{\"Vapegacor\": \"murah banget\"}', 'vape adalah rokok elektrik atau elektronik cigaret (e-cigarette), dan sering disebut juga vaporizer (dari kata vapor, yang berarti uap), e-cig, atau pena vape, yang merupakan alat untuk menghirup uap nikotin atau zat lain tanpa membakar tembakau.', '2026-01-21 20:50:02', '2026-01-21 20:50:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `path`, `position`, `created_at`, `updated_at`) VALUES
(2, 189, 'products/U2iATRImMe8WX5tlROtE5QTGvMTmYnwUnz9IeiYU.jpg', 0, '2026-01-21 20:50:02', '2026-01-21 20:50:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ewallet_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ewallet_provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `address`, `location`, `phone`, `profile_photo_path`, `email_verified_at`, `password`, `bank_code`, `bank_account_name`, `bank_account_number`, `ewallet_number`, `bank_provider`, `ewallet_provider`, `remember_token`, `created_at`, `updated_at`) VALUES
(6, 'Vape Store', 'vape@vape.com', 'gg turang flamboyan 6, Kel. BANGUN SARI BARU, Kec. TANJUNG MORAWA, Kode Pos 2014, Kel. BANGUN SARI BARU, Kec. TANJUNG MORAWA, Kode Pos 2014, Kel. BANGUN SARI BARU, Kec. TANJUNG MORAWA, Kode Pos 20143, Kel. BANGUN SARI BARU, Kec. TANJUNG MORAWA', 'KABUPATEN DELI SERDANG, SUMATERA UTARA', '083129915186', 'profiles/sf35DPghAUtAvV4C1yPvkHdzzAvmbeu7QMJimk0U.jpg', NULL, '$2y$12$J.SsG5aW2rPail1E4oRP9.3xpB8PWK4PjFczidVJb14Q/717CduS2', NULL, NULL, '342423343242', '4234525243434', 'BCA', 'DANA', NULL, '2026-01-19 07:10:11', '2026-01-21 20:41:50'),
(7, 'Demo User', 'demo@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:53', '$2y$12$lEbf0AbTC4K4VyZtJr/jtOaPnN63UNAv23xOUJF6y3Jq6wT4i606e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-19 07:26:03', '2026-01-21 11:50:53'),
(8, 'Seller UMKM', 'seller@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:53', '$2y$12$kG68qMKfgohiVqdrCBE4PO7mCiBpPJUZ9NB9Tdk0T5LFhkS60HvEy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-19 07:26:03', '2026-01-21 11:50:53'),
(9, 'Handphone', 'handphone@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:50', '$2y$12$yydpXfjjnpG3issCT.8PmeychvLU9OisvKPTb4OIxt7q/OAgzYeQ2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:53', '2026-01-21 11:50:50'),
(10, 'Laptop', 'laptop@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:51', '$2y$12$mAuxrtXRKHvQuWGmrDO8BOBvlLw2iePG3ky/qCOHwV9AvsmEnPBum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:53', '2026-01-21 11:50:51'),
(11, 'Elektronik', 'elektronik@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:51', '$2y$12$Bh95QAHbslo9k/RVygaZYemEta5OBpMFvPifOWNcHJ47YmaEJLkS.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:53', '2026-01-21 11:50:51'),
(12, 'Aksesoris', 'aksesoris@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:51', '$2y$12$0ziJcNOYG7mQtoTQMEQ0PO.kxJXQoiDrYiyCaeX77N6/vJeGv263K', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:54', '2026-01-21 11:50:51'),
(13, 'Baju', 'baju@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:51', '$2y$12$N9heJI.Y0zmBJ.6TGhvEdOWyAbwFHgbYBpP9GS8zJ79m4O3nJV3pW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:54', '2026-01-21 11:50:51'),
(14, 'Celana', 'celana@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:51', '$2y$12$e25oDptxOlxFr63TcnMbL.1F.FrIYGWOg3b2gMfAELvluxZQJ6Mxa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:54', '2026-01-21 11:50:51'),
(15, 'Sepatu', 'sepatu@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:52', '$2y$12$xbtdNJ0NDJFsRp77.2ExVeFt0O3cLPauItdwTNTj0pJQ2gDdR7dgm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:54', '2026-01-21 11:50:52'),
(16, 'Makanan', 'makanan@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:52', '$2y$12$6ujGcRP7dkiGfUaM4GQC6.Y3ss9wa.nYrmYK4aNmhWE3Cx6mFCmHq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:54', '2026-01-21 11:50:52'),
(17, 'Minuman', 'minuman@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:52', '$2y$12$67vG5.sQBPDFqsRz0t5Jc.Is1eeg88mTzs99PG59f3HK/zm4fX4be', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:55', '2026-01-21 11:50:52'),
(18, 'Jasa', 'jasa@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:52', '$2y$12$HOPbzh.dc2BSJ0S9OmRLKuh4T4B7IBuub0Tv/18eh4oJz.N5HJyzO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:55', '2026-01-21 11:50:52'),
(19, 'Otomotif', 'otomotif@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:52', '$2y$12$SpjMtxiYX1hXdklqdaOPe.Ic4lpqtahaBTfjL2M/94vzfLx0jNnyy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:55', '2026-01-21 11:50:52'),
(20, 'Alat Musik', 'alat-musik@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:53', '$2y$12$MAdDr1B6pdA493SJwzLBjuaukpRE6O.H1qNmKAJTo.dwRhudi3VCu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:55', '2026-01-21 11:50:53'),
(21, 'Jam Tangan', 'jam-tangan@example.com', NULL, NULL, NULL, NULL, '2026-01-21 11:50:53', '$2y$12$fLEF86KQpJn.zuxsM1NP2eoXfp7YIkFePmnESLIMypV4h42lm3HOC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-20 02:39:55', '2026-01-21 11:50:53'),
(22, 'Toko Cihuahua', 'hua@hua.com', 'Medan', 'Deli Serdang', '083129915186', 'profiles/hiQnLpBItu3MOEnFxZPcNm136KE3cJH6iBXvPV6S.png', NULL, '$2y$12$IaIeIuw505A1qHHrP.QfC.DNRNheq3NiVaj/JPCvgIDUXithoR.Q2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-21 09:30:52', '2026-01-21 10:13:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_payouts`
--

CREATE TABLE `user_payouts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` enum('bank','ewallet','qris') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_payouts`
--

INSERT INTO `user_payouts` (`id`, `user_id`, `type`, `provider`, `account_number`, `label`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 6, 'bank', 'BCA', '342423343242', NULL, 1, '2026-01-21 20:41:50', '2026-01-21 20:41:50'),
(2, 6, 'ewallet', 'DANA', '4234525243434', NULL, 0, '2026-01-21 20:41:50', '2026-01-21 20:41:50');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_unique` (`user_id`);

--
-- Indeks untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`),
  ADD KEY `cart_items_offer_id_foreign` (`offer_id`);

--
-- Indeks untuk tabel `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conversations_user_id_partner_id_unique` (`user_id`,`partner_id`),
  ADD KEY `conversations_partner_id_foreign` (`partner_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_conversation_id_foreign` (`conversation_id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `needs`
--
ALTER TABLE `needs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `needs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offers_need_id_foreign` (`need_id`),
  ADD KEY `offers_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_offer_id_foreign` (`offer_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_seller_payout_id_foreign` (`seller_payout_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_details_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `user_payouts`
--
ALTER TABLE `user_payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_payouts_user_id_type_provider_index` (`user_id`,`type`,`provider`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `needs`
--
ALTER TABLE `needs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT untuk tabel `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `user_payouts`
--
ALTER TABLE `user_payouts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `needs`
--
ALTER TABLE `needs`
  ADD CONSTRAINT `needs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_need_id_foreign` FOREIGN KEY (`need_id`) REFERENCES `needs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_seller_payout_id_foreign` FOREIGN KEY (`seller_payout_id`) REFERENCES `user_payouts` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_payouts`
--
ALTER TABLE `user_payouts`
  ADD CONSTRAINT `user_payouts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
