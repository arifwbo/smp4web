-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 05, 2026 at 04:20 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smpn4_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_settings`
--

CREATE TABLE `academic_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `hero_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_description` text COLLATE utf8mb4_unicode_ci,
  `hero_points` json DEFAULT NULL,
  `cta_teacher_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_teacher_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_ppdb_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_ppdb_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `curriculum_highlights` json DEFAULT NULL,
  `subject_allocations` json DEFAULT NULL,
  `support_points` json DEFAULT NULL,
  `programs` json DEFAULT NULL,
  `extracurriculars` json DEFAULT NULL,
  `timelines` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_settings`
--

INSERT INTO `academic_settings` (`id`, `hero_title`, `hero_subtitle`, `hero_description`, `hero_points`, `cta_teacher_label`, `cta_teacher_link`, `cta_ppdb_label`, `cta_ppdb_link`, `curriculum_highlights`, `subject_allocations`, `support_points`, `programs`, `extracurriculars`, `timelines`, `created_at`, `updated_at`) VALUES
(1, 'Ekosistem Belajar Unggul', 'Program Akademik', 'Kami menerapkan Kurikulum Merdeka dengan kombinasi pembelajaran berbasis proyek dan asesmen autentik.', '[\"Integrasi Proyek Profil Pelajar Pancasila\", \"Laboratorium sains, komputer, dan bahasa\", \"Monitoring belajar berbasis aplikasi\"]', NULL, NULL, NULL, NULL, NULL, NULL, '[\"Klinik Matematika & Literasi membaca\", \"Tryout Asesmen Nasional Berbasis Komputer\", \"Konseling belajar personal untuk kelas IX\"]', NULL, NULL, NULL, '2026-02-02 20:02:49', '2026-02-02 20:02:49');

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'auth.login', 'Login berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 15:39:50', '2026-02-02 15:39:50'),
(2, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 16:52:28', '2026-02-02 16:52:28'),
(3, 1, 'ppdb.updated', 'Memperbarui info PPDB: PPDB Jalur Zonasi 2025', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 16:53:49', '2026-02-02 16:53:49'),
(4, 1, 'ppdb.updated', 'Memperbarui info PPDB: PPDB Jalur Zonasi 2025', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 16:53:57', '2026-02-02 16:53:57'),
(5, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 17:04:06', '2026-02-02 17:04:06'),
(6, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 17:32:08', '2026-02-02 17:32:08'),
(7, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 17:33:41', '2026-02-02 17:33:41'),
(8, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 17:35:37', '2026-02-02 17:35:37'),
(9, 1, 'post.created', 'Menambahkan berita: Pelaksanaan MPLS Ramah 2025', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 17:57:30', '2026-02-02 17:57:30'),
(10, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 18:43:57', '2026-02-02 18:43:57'),
(11, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 18:44:09', '2026-02-02 18:44:09'),
(12, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 19:00:53', '2026-02-02 19:00:53'),
(13, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 19:00:59', '2026-02-02 19:00:59'),
(14, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 19:04:15', '2026-02-02 19:04:15'),
(15, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 19:06:57', '2026-02-02 19:06:57'),
(16, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 19:23:46', '2026-02-02 19:23:46'),
(17, NULL, 'auth.logout', 'Logout berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 20:58:22', '2026-02-02 20:58:22'),
(18, 1, 'auth.login', 'Login berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 21:30:47', '2026-02-02 21:30:47'),
(19, 1, 'slider.created', 'Menambahkan slider beranda baru', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 21:37:54', '2026-02-02 21:37:54'),
(20, 1, 'slider.created', 'Menambahkan slider beranda baru', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 21:38:55', '2026-02-02 21:38:55'),
(21, 1, 'post.deleted', 'Menghapus berita: Juara 1 Lomba Sains Kota Samarinda', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 23:04:48', '2026-02-02 23:04:48'),
(22, 1, 'post.updated', 'Memperbarui berita: Agenda Rapat Guru', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-02 23:05:35', '2026-02-02 23:05:35'),
(23, 1, 'auth.login', 'Login berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:39:10', '2026-02-03 15:39:10'),
(24, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:40:16', '2026-02-03 15:40:16'),
(25, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:43:16', '2026-02-03 15:43:16'),
(26, 1, 'post.updated', 'Memperbarui berita: Jadwal Libur Semester Ganjil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:44:59', '2026-02-03 15:44:59'),
(27, 1, 'post.created', 'Menambahkan berita: Kementerian Komunikasi dan Digital (Komdigi) menyebut Peraturan Presiden (Perpres) terkait kecerdasan buatan (AI) akan segera ditandatangani oleh Presiden Prabowo Subianto pada awal 2026.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:49:46', '2026-02-03 15:49:46'),
(28, 1, 'post.updated', 'Memperbarui berita: Kementerian Komunikasi dan Digital (Komdigi) menyebut Peraturan Presiden (Perpres) terkait kecerdasan buatan (AI) akan segera ditandatangani oleh Presiden Prabowo Subianto pada awal 2026.', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:50:09', '2026-02-03 15:50:09'),
(29, 1, 'post.created', 'Menambahkan berita: Wamenpora Taufik Harap Carabao International Open Lahirkan Atlet Biliar Indonesia yang Mendunia', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 15:52:26', '2026-02-03 15:52:26'),
(30, 1, 'principal.created', 'Menambahkan data kepala sekolah terdahulu: Ibu Hj. Hadijah, S.Pd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 18:32:25', '2026-02-03 18:32:25'),
(31, 1, 'principal.created', 'Menambahkan data kepala sekolah terdahulu: Mohammad Karim, S.Pd., M.Psi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 18:35:45', '2026-02-03 18:35:45'),
(32, 1, 'principal.created', 'Menambahkan data kepala sekolah terdahulu: Dr. Barlin Hady Kesuma, S.Pd., M.Ed', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 18:40:17', '2026-02-03 18:40:17'),
(33, 1, 'principal.created', 'Menambahkan data kepala sekolah terdahulu: Syahrani, S.Pd., M.Psi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 18:41:17', '2026-02-03 18:41:17'),
(34, 1, 'principal.updated', 'Memperbarui data kepala sekolah terdahulu: Syahrani, S.Pd., M.Psi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 18:41:25', '2026-02-03 18:41:25'),
(35, 1, 'gallery_video.created', 'Menambah video galeri: LAUNCING !!! Media Digital SMP Negeri 4 Samarinda', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 20:27:58', '2026-02-03 20:27:58'),
(36, 1, 'gallery_video.created', 'Menambah video galeri: Kegiatan Praktik IPA SMP Negeri 4 Samarinda', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 20:29:01', '2026-02-03 20:29:01'),
(37, 1, 'gallery_video.created', 'Menambah video galeri: SIMULASI PELAKSANAAN UJI COBA BELAJAR MENGAJAR TATAP MUKA | SMP NEGERI 4 SAMARINDA', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 20:30:24', '2026-02-03 20:30:24'),
(38, 1, 'gallery_video.created', 'Menambah video galeri: SEKOLAH RAMAH ANAK SMP NEGERI 4 SAMARINDA', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 20:31:20', '2026-02-03 20:31:20'),
(39, 1, 'gallery_video.created', 'Menambah video galeri: SERTIJAB KEPALA SEKOLAH SMP NEGERI 4 SAMARINDA', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 20:31:54', '2026-02-03 20:31:54'),
(40, 1, 'post.created', 'Menambahkan berita: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 21:06:54', '2026-02-03 21:06:54'),
(41, 1, 'post.created', 'Menambahkan berita: PPDB Jalur Zonasi 2025', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 21:07:55', '2026-02-03 21:07:55'),
(42, 1, 'post.created', 'Menambahkan berita: Lorem ipsum dolor sit amet', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 21:08:57', '2026-02-03 21:08:57'),
(43, NULL, 'auth.logout', 'Logout berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 22:51:10', '2026-02-03 22:51:10'),
(44, 1, 'auth.login', 'Login berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-03 22:51:25', '2026-02-03 22:51:25'),
(45, 1, 'auth.login', 'Login berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 16:48:27', '2026-02-04 16:48:27'),
(46, NULL, 'auth.logout', 'Logout berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 16:53:17', '2026-02-04 16:53:17'),
(47, 1, 'auth.login', 'Login berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 16:53:31', '2026-02-04 16:53:31'),
(48, NULL, 'auth.logout', 'Logout berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 17:23:22', '2026-02-04 17:23:22'),
(49, 1, 'auth.login', 'Login berhasil', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 17:25:53', '2026-02-04 17:25:53'),
(50, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 18:19:07', '2026-02-04 18:19:07'),
(51, 1, 'profile.updated', 'Memperbarui profil sekolah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 18:20:06', '2026-02-04 18:20:06'),
(52, 1, 'users.create', 'Menambahkan akun user@user.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 18:46:00', '2026-02-04 18:46:00'),
(53, 1, 'users.toggle_status', 'Menonaktifkan akun user@user.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 18:46:18', '2026-02-04 18:46:18'),
(54, 1, 'users.delete', 'Menghapus akun user@user.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 18:51:11', '2026-02-04 18:51:11'),
(55, 1, 'teacher.deleted', 'Menghapus guru: Drs. Ahmad', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 19:33:55', '2026-02-04 19:33:55'),
(56, 1, 'teacher.deleted', 'Menghapus guru: Siti Aminah, S.Pd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 20:01:39', '2026-02-04 20:01:39'),
(57, 1, 'teacher.deleted', 'Menghapus guru: Budi Santoso', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 20:01:41', '2026-02-04 20:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('smp4-cache-home_sliders', 'O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;a:5:{s:5:\"title\";s:40:\"Selamat Datang di SMP Negeri 4 Samarinda\";s:8:\"subtitle\";s:72:\"Mewujudkan Generasi Berprestasi, Berkarakter, dan Berwawasan Lingkungan.\";s:12:\"button_label\";s:14:\"Profil Sekolah\";s:11:\"button_link\";s:28:\"http://127.0.0.1:8000/profil\";s:9:\"image_url\";s:97:\"http://127.0.0.1:8000/storage/media/home-sliders/2026/02/eb0fd1ac-46e1-423b-a27e-ca406737c6d6.png\";}i:1;a:5:{s:5:\"title\";s:40:\"Selamat Datang di SMP Negeri 4 Samarinda\";s:8:\"subtitle\";s:72:\"Mewujudkan Generasi Berprestasi, Berkarakter, dan Berwawasan Lingkungan.\";s:12:\"button_label\";s:14:\"Profil Sekolah\";s:11:\"button_link\";s:28:\"http://127.0.0.1:8000/profil\";s:9:\"image_url\";s:97:\"http://127.0.0.1:8000/storage/media/home-sliders/2026/02/b047491d-949d-431b-bcb8-9090e5134a4e.png\";}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1770265076),
('smp4-cache-school_profile_favicon', 's:20:\"branding/favicon.ico\";', 1770265076),
('smp4-cache-school_profile_full', 'O:24:\"App\\Models\\SchoolProfile\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"school_profiles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:12:\"nama_sekolah\";s:22:\"SMP Negeri 4 Samarinda\";s:9:\"logo_path\";s:67:\"media/logo-sekolah/2026/02/fdbe7717-3f9b-4946-bd74-e96c176fa902.png\";}s:11:\"\0*\0original\";a:2:{s:12:\"nama_sekolah\";s:22:\"SMP Negeri 4 Samarinda\";s:9:\"logo_path\";s:67:\"media/logo-sekolah/2026/02/fdbe7717-3f9b-4946-bd74-e96c176fa902.png\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:13:\"struktur_guru\";s:5:\"array\";s:11:\"struktur_tu\";s:5:\"array\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}', 1770265012),
('smp4-cache-school_profile_public', 'O:24:\"App\\Models\\SchoolProfile\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"school_profiles\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:10:{s:12:\"nama_sekolah\";s:22:\"SMP Negeri 4 Samarinda\";s:6:\"alamat\";s:111:\"Jl. Ir. H. Juanda RT. 17 No. 14, Kelurahan Air Putih, Kecamatan Samarinda Ulu, Kota Samarinda, Kalimantan Timur\";s:5:\"email\";s:23:\"smp4samarinda@gmail.com\";s:7:\"telepon\";s:14:\"(0541) 7774016\";s:18:\"footer_description\";s:25:\"Tiada Hari Tanpa Prestasi\";s:12:\"facebook_url\";s:45:\"https://www.facebook.com/SMPNegeri4Samarinda/\";s:13:\"instagram_url\";s:41:\"https://www.instagram.com/smpn4samarinda/\";s:11:\"youtube_url\";s:52:\"https://www.youtube.com/@smpnegeri4samarindaofficial\";s:9:\"logo_path\";s:67:\"media/logo-sekolah/2026/02/fdbe7717-3f9b-4946-bd74-e96c176fa902.png\";s:15:\"whatsapp_number\";N;}s:11:\"\0*\0original\";a:10:{s:12:\"nama_sekolah\";s:22:\"SMP Negeri 4 Samarinda\";s:6:\"alamat\";s:111:\"Jl. Ir. H. Juanda RT. 17 No. 14, Kelurahan Air Putih, Kecamatan Samarinda Ulu, Kota Samarinda, Kalimantan Timur\";s:5:\"email\";s:23:\"smp4samarinda@gmail.com\";s:7:\"telepon\";s:14:\"(0541) 7774016\";s:18:\"footer_description\";s:25:\"Tiada Hari Tanpa Prestasi\";s:12:\"facebook_url\";s:45:\"https://www.facebook.com/SMPNegeri4Samarinda/\";s:13:\"instagram_url\";s:41:\"https://www.instagram.com/smpn4samarinda/\";s:11:\"youtube_url\";s:52:\"https://www.youtube.com/@smpnegeri4samarindaofficial\";s:9:\"logo_path\";s:67:\"media/logo-sekolah/2026/02/fdbe7717-3f9b-4946-bd74-e96c176fa902.png\";s:15:\"whatsapp_number\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:13:\"struktur_guru\";s:5:\"array\";s:11:\"struktur_tu\";s:5:\"array\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}', 1770265076);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Laboratorium Komputer', 'Dilengkapi 40 PC terbaru.', '2026-02-01 23:32:33', '2026-02-01 23:32:33'),
(2, 'Perpustakaan', 'Ruang baca nyaman ber-AC.', '2026-02-01 23:32:33', '2026-02-01 23:32:33'),
(3, 'Ruang Kelas', 'Kelas yang bersih dan nyaman.', '2026-02-01 23:32:33', '2026-02-01 23:32:33');

-- --------------------------------------------------------

--
-- Table structure for table `former_principals`
--

CREATE TABLE `former_principals` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `former_principals`
--

INSERT INTO `former_principals` (`id`, `name`, `period`, `sort_order`, `photo_path`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Ibu Hj. Hadijah, S.Pd', '2019 - 2022', 12, 'media/former-principals/2026/02/65e5c5be-9c08-4756-b35d-2ffd85ad25cb.png', NULL, '2026-02-03 18:32:25', '2026-02-03 18:32:25'),
(2, 'Mohammad Karim, S.Pd., M.Psi', '2016 - 2019', 11, 'media/former-principals/2026/02/8995d53e-d039-46e7-894f-4242fa0df0e1.png', NULL, '2026-02-03 18:35:45', '2026-02-03 18:35:45'),
(3, 'Dr. Barlin Hady Kesuma, S.Pd., M.Ed', '2014 - 2016', 10, 'media/former-principals/2026/02/94dc7c3e-9eee-4dc6-990d-da3d513946c6.png', NULL, '2026-02-03 18:40:17', '2026-02-03 18:40:17'),
(4, 'Syahrani, S.Pd., M.Psi', '2012 - 2014', 9, 'media/former-principals/2026/02/eb26a6e3-1007-4fd7-99e8-ae50540ce8ec.png', NULL, '2026-02-03 18:41:17', '2026-02-03 18:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_videos`
--

CREATE TABLE `gallery_videos` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_videos`
--

INSERT INTO `gallery_videos` (`id`, `judul`, `deskripsi`, `youtube_url`, `youtube_id`, `created_at`, `updated_at`) VALUES
(1, 'LAUNCING !!! Media Digital SMP Negeri 4 Samarinda', 'Media ini sebagai bentuk informasi kegitan SMP N 4 samarinda dari media belajar sampai pengumuman sekolah. Kami harapkan bantuan warga sekolah untuk membagikan informasi yang kami sajikan melalui media ini, terima kasih', 'https://www.youtube.com/watch?v=pwHJt4zcqcU', 'pwHJt4zcqcU', '2026-02-03 20:27:58', '2026-02-03 20:27:58'),
(2, 'Kegiatan Praktik IPA SMP Negeri 4 Samarinda', 'Praktik pengukuran masa benda oleh ibu Hj. Titik Suparti, S.Pd', 'https://youtu.be/lKRZR4MNtIo?si=iGzmF6ay-t0tA1cj', 'lKRZR4MNtIo', '2026-02-03 20:29:01', '2026-02-03 20:29:01'),
(3, 'SIMULASI PELAKSANAAN UJI COBA BELAJAR MENGAJAR TATAP MUKA | SMP NEGERI 4 SAMARINDA', NULL, 'https://youtu.be/wbocMzYroik?si=V7evUDHEXlEftKb_', 'wbocMzYroik', '2026-02-03 20:30:24', '2026-02-03 20:30:24'),
(4, 'SEKOLAH RAMAH ANAK SMP NEGERI 4 SAMARINDA', 'Kegiatan sekolah ramah anak', 'https://youtu.be/5dolQBwIEVU?si=ySDmveTa9QuTXEDB', '5dolQBwIEVU', '2026-02-03 20:31:20', '2026-02-03 20:31:20'),
(5, 'SERTIJAB KEPALA SEKOLAH SMP NEGERI 4 SAMARINDA', 'Serah terima jabatan kepala sekolah SMP Negeri 4 samarinda dari Ibu Hadijah kepada Bapak Darminto yang disaksikan oleh Kepada Dinas Pendidikan kota Samarinda yang dilaksanakan pada tanggal 21 Februari 2022', 'https://youtu.be/PW2g_WifPpM?si=vooYU5WiLwWrz55w', 'PW2g_WifPpM', '2026-02-03 20:31:54', '2026-02-03 20:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `home_sliders`
--

CREATE TABLE `home_sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_sliders`
--

INSERT INTO `home_sliders` (`id`, `title`, `subtitle`, `button_label`, `button_link`, `image_path`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Selamat Datang di SMP Negeri 4 Samarinda', 'Mewujudkan Generasi Berprestasi, Berkarakter, dan Berwawasan Lingkungan.', 'Profil Sekolah', 'http://127.0.0.1:8000/profil', 'media/home-sliders/2026/02/eb0fd1ac-46e1-423b-a27e-ca406737c6d6.png', 1, 1, '2026-02-02 21:37:54', '2026-02-02 21:37:54'),
(2, 'Selamat Datang di SMP Negeri 4 Samarinda', 'Mewujudkan Generasi Berprestasi, Berkarakter, dan Berwawasan Lingkungan.', 'Profil Sekolah', 'http://127.0.0.1:8000/profil', 'media/home-sliders/2026/02/b047491d-949d-431b-bcb8-9090e5134a4e.png', 2, 1, '2026-02-02 21:38:55', '2026-02-02 21:38:55');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_01_01_000001_create_all_tables', 1),
(2, '2026_02_02_073133_create_cache_table', 1),
(3, '2026_02_03_000001_add_role_to_users_table', 2),
(4, '2026_02_03_000002_create_activity_logs_table', 2),
(5, '2026_02_03_000004_create_galleries_table', 3),
(6, '2026_02_03_000005_add_read_at_to_messages_table', 3),
(7, '2026_02_03_000006_add_foto_kepsek_to_school_profiles_table', 4),
(8, '2026_02_03_000007_add_logo_path_to_school_profiles_table', 5),
(9, '2026_02_03_000008_add_footer_fields_to_school_profiles_table', 6),
(10, '2026_02_03_000009_create_academic_settings_table', 7),
(11, '2026_02_03_000010_create_home_sliders_table', 8),
(12, '2026_02_04_000020_create_former_principals_table', 9),
(13, '2026_02_04_000009_add_whatsapp_to_school_profiles_table', 10),
(14, '2026_02_04_000010_create_gallery_videos_table', 11),
(15, '2026_02_04_000040_add_structures_to_school_profiles_table', 12),
(16, '2026_02_04_000041_add_structure_images_to_school_profiles_table', 13),
(17, '2026_02_05_000050_add_admin_fields_to_users_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` enum('berita','pengumuman','agenda','prestasi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'berita',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `judul`, `slug`, `isi`, `gambar`, `kategori`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Jadwal Libur Semester Ganjil', 'jadwal-libur-semester-ganjil', '<p>Diberitahukan kepada seluruh siswa...dsdsdsd</p>', 'media/posts/2026/02/4bdf714d-137d-4227-91d9-2d4d72609624.jpeg', 'pengumuman', 1, '2026-02-01 23:32:33', '2026-02-03 15:44:59'),
(3, 'Agenda Rapat Guru', 'agenda-rapat-guru', '<p>Rapat evaluasi bulanan akan diadakan...</p>', 'media/posts/2026/02/cabcdeb9-ed67-4ecd-aaef-f970dba4165f.png', 'agenda', 1, '2026-02-01 23:32:33', '2026-02-02 23:05:35'),
(4, 'Pelaksanaan MPLS Ramah 2025', 'pelaksanaan-mpls-ramah-2025', 'SMP Negeri 4 Samarinda didirikan pada tahun 1979 dan mulai beroperasi pada tahun 1980.\r\n\r\nSeiring berjalannya waktu, sekolah ini terus berkembang menjadi salah satu sekolah favorit di Samarinda.', 'media/posts/2026/02/27e8fb1f-edfb-4bdb-a5e8-6cde1c30fa85.jpg', 'berita', 1, '2026-02-02 17:57:30', '2026-02-02 17:57:30'),
(5, 'Kementerian Komunikasi dan Digital (Komdigi) menyebut Peraturan Presiden (Perpres) terkait kecerdasan buatan (AI) akan segera ditandatangani oleh Presiden Prabowo Subianto pada awal 2026.', 'kementerian-komunikasi-dan-digital-komdigi-menyebut-peraturan-presiden-perpres-terkait-kecerdasan-buatan-ai-akan-segera-ditandatangani-oleh-presiden-prabowo-subianto-pada-awal-2026', '<p>Jakarta, CNN Indonesia -- Kementerian Komunikasi dan Digital (Komdigi) menyebut Peraturan Presiden (Perpres) terkait&nbsp;kecerdasan buatan (AI) akan segera ditandatangani oleh Presiden Prabowo Subianto pada awal 2026.<br>\"Untuk industri teknologi baru telah disusun jadi ada 2 PP, terkait buku putih peta jalan kecerdasan artifisial dan juga etika kecerdasan artifisial. Penting sekali peraturan ini dilahirkan dan Indonesia telah membuat di 2025, insya Allah menjadi prioritas ditandatangani Bapak Presiden di tahun 2026,\" ujar Menkomdigi Meutya Hafid dalam Raker Komisi I DPR bersama Komdigi yang disiarkan secara daring, Senin (26/1).<br>Jakarta, CNN Indonesia -- Kementerian Komunikasi dan Digital (Komdigi) menyebut Peraturan Presiden (Perpres) terkait&nbsp;kecerdasan buatan (AI) akan segera ditandatangani oleh Presiden Prabowo Subianto pada awal 2026.<br>\"Untuk industri teknologi baru telah disusun jadi ada 2 PP, terkait buku putih peta jalan kecerdasan artifisial dan juga etika kecerdasan artifisial. Penting sekali peraturan ini dilahirkan dan Indonesia telah membuat di 2025, insya Allah menjadi prioritas ditandatangani Bapak Presiden di tahun 2026,\" ujar Menkomdigi Meutya Hafid dalam Raker Komisi I DPR bersama Komdigi yang disiarkan secara daring, Senin (26/1).</p><p>Jakarta, CNN Indonesia -- Kementerian Komunikasi dan Digital (Komdigi) menyebut Peraturan Presiden (Perpres) terkait&nbsp;kecerdasan buatan (AI) akan segera ditandatangani oleh Presiden Prabowo Subianto pada awal 2026.<br>\"Untuk industri teknologi baru telah disusun jadi ada 2 PP, terkait buku putih peta jalan kecerdasan artifisial dan juga etika kecerdasan artifisial. Penting sekali peraturan ini dilahirkan dan Indonesia telah membuat di 2025, insya Allah menjadi prioritas ditandatangani Bapak Presiden di tahun 2026,\" ujar Menkomdigi Meutya Hafid dalam Raker Komisi I DPR bersama Komdigi yang disiarkan secara daring, Senin (26/1).</p><p>Jakarta, CNN Indonesia -- Kementerian Komunikasi dan Digital (Komdigi) menyebut Peraturan Presiden (Perpres) terkait&nbsp;kecerdasan buatan (AI) akan segera ditandatangani oleh Presiden Prabowo Subianto pada awal 2026.<br>\"Untuk industri teknologi baru telah disusun jadi ada 2 PP, terkait buku putih peta jalan kecerdasan artifisial dan juga etika kecerdasan artifisial. Penting sekali peraturan ini dilahirkan dan Indonesia telah membuat di 2025, insya Allah menjadi prioritas ditandatangani Bapak Presiden di tahun 2026,\" ujar Menkomdigi Meutya Hafid dalam Raker Komisi I DPR bersama Komdigi yang disiarkan secara daring, Senin (26/1).<br>&nbsp;</p>', 'media/posts/2026/02/f0dac3ff-b1be-4f65-80b5-4f179e5278df.jpeg', 'berita', 1, '2026-02-03 15:49:46', '2026-02-03 15:50:09'),
(6, 'Wamenpora Taufik Harap Carabao International Open Lahirkan Atlet Biliar Indonesia yang Mendunia', 'wamenpora-taufik-harap-carabao-international-open-lahirkan-atlet-biliar-indonesia-yang-mendunia', '<p>angerang: Wakil Menteri Pemuda dan Olahraga (Wamenpora) Taufik Hidayat menghadiri Press Conference &amp; Gala Dinner Carabao International Open, Carabao Junior Open, Carabao International Celebrity Billiards di kawasan PIK 2, Kecamatan Kosambi, Kabupaten Tangerang, Banten, Selasa (3/2) sore.</p><p>Menjadi narasumber dalam kegiatan ini, Wamenpora menyambut baik diselenggarakannya turnamen biliar berskala internasional Carabao International Open. Menurut Wamenpora Taufik, sebagaimana event dunia lainnya, penyelenggaraan turnamen ini juga ikut mendukung sport tourism yang tengah gencar didorong Kemenpora.</p><p>“Yang pasti event internasional di Indonesia bertambah satu. Dengan event ini juga bisa menyumbang devisa yang besar, dari tiket pesawat, hunian hotel, hingga pengeluaran di makanan,” ungkap Wamenpora.</p><p>Wamenpora Taufik menerangkan, saat ini olahraga biliar tengah kembali populer di Tanah Air. Maka dengan adanya event ini diharapkan anak-anak muda Indonesia bisa tertarik dan berminat menjadi atlet biliar yang bisa mengharumkan nama bangsa. Di satu sisi, juga menghilangkan kesan negatif masyarakat atas olahraga biliar.</p><p>“Mudah-mudahan turnamen ini bisa menjadi salah satu fasilitas bagi atlet-atlet kita, terutama yang junior bisa melihat bahwa biliar ini bisa mendunia, kita bisa menjadi yang terbaik dalam event ini,” sebut Wamenpora.</p><p>Kemenpora, lanjut Wamenpora Taufik, bukan hanya mendukung turnamen ini dari sisi prestasi, melainkan juga dari sisi pengembangan olahraga biliar, termasuk sportainment. Apalagi dalam rangkaian Carabao International Open ini juga diselenggarakan pertandingan biliar antarselebritis bertajuk Carabao International Celebrity Billiards.</p><p>“Sekarang ini kita banyak dibantu para selebritis dalam mempopulerkan olahraga di masyarakat. Karena itu saya harap event ini tidak hanya digelar sekali, tetapi bisa menjadi rutinitas setiap tahun, menjadi salah satu fasilitas untuk atlet bisa bertanding dengan pemain-pemain dunia yang datang ke Indonesia,” urai Wamenpora Taufik.</p><p>“Kami dari Pemerintah sangat mendukung, mudah-mudahan ini menjadi salah satu pintu masuk untuk event besar lainnya di Indonesia,” sambung Wamenpora.&nbsp;</p><p>Diketahui, turnamen bertaraf internasional World Nineball Tour (WNT) pertama di Indonesia ini diselenggarakan di NICE, PIK 2, Banten, pada 4–8 Februari 2026 yang diikuti para pebiliar profesional dari seluruh dunia. Sejumlah nama yang akan tampil dalam turnamen ini di antaranya juara dunia tiga kali dari Amerika Serikat Thorsten Hohmann, juara European Open 2024 dari Denmark Mickey Krause, hingga juara Kejuaraan Dunia Biliar Junior 2025 dari Indonesia Albert Januarta. (luk)</p>', 'media/posts/2026/02/43a42f95-3435-4721-8b7e-10c49a38ec16.jpeg', 'prestasi', 1, '2026-02-03 15:52:26', '2026-02-03 15:52:26'),
(7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor', 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-sed-do-eiusmod-tempor', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.&nbsp;<br>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.&nbsp;<br>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.&nbsp;<br>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><p>&nbsp;</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.&nbsp;<br>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.&nbsp;<br>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.&nbsp;<br>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br>&nbsp;</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.&nbsp;<br>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.&nbsp;<br>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.&nbsp;<br>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>&nbsp;</p>', 'media/posts/2026/02/1a821974-3dd0-4216-8495-8105a4633bc3.jpeg', 'berita', 1, '2026-02-03 21:06:54', '2026-02-03 21:06:54'),
(8, 'PPDB Jalur Zonasi 2025', 'ppdb-jalur-zonasi-2025', '<p>masih di tutup</p>', 'media/posts/2026/02/304bc9a1-dec4-43f2-9ff2-aef979a53cef.jpg', 'pengumuman', 1, '2026-02-03 21:07:55', '2026-02-03 21:07:55'),
(9, 'Lorem ipsum dolor sit amet', 'lorem-ipsum-dolor-sit-amet', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisi vel consectetur interdum, nisl nisi aliquet nunc,&nbsp;<br>vitae egestas nunc nisl sit amet lorem. Vivamus non justo nec lorem feugiat tincidunt.</p><p>Curabitur vitae magna vel massa luctus varius. Suspendisse potenti. Integer dignissim,&nbsp;<br>libero id consequat fermentum, nisi lorem posuere purus, sed facilisis sem urna in sapien.</p><p>&nbsp;</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisi vel consectetur interdum, nisl nisi aliquet nunc,&nbsp;<br>vitae egestas nunc nisl sit amet lorem. Vivamus non justo nec lorem feugiat tincidunt.</p><p>Curabitur vitae magna vel massa luctus varius. Suspendisse potenti. Integer dignissim,&nbsp;<br>libero id consequat fermentum, nisi lorem posuere purus, sed facilisis sem urna in sapien.</p><p>&nbsp;</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisi vel consectetur interdum, nisl nisi aliquet nunc,&nbsp;<br>vitae egestas nunc nisl sit amet lorem. Vivamus non justo nec lorem feugiat tincidunt.</p><p>Curabitur vitae magna vel massa luctus varius. Suspendisse potenti. Integer dignissim,&nbsp;<br>libero id consequat fermentum, nisi lorem posuere purus, sed facilisis sem urna in sapien.<br>&nbsp;</p>', 'media/posts/2026/02/26dfc8a0-268c-47ab-9cbb-25bba4788a7e.jpeg', 'berita', 1, '2026-02-03 21:08:57', '2026-02-03 21:08:57');

-- --------------------------------------------------------

--
-- Table structure for table `ppdbs`
--

CREATE TABLE `ppdbs` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci,
  `status` enum('buka','tutup') COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_daftar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ppdbs`
--

INSERT INTO `ppdbs` (`id`, `judul`, `konten`, `status`, `link_daftar`, `created_at`, `updated_at`) VALUES
(1, 'PPDB Jalur Zonasi 2025', NULL, 'tutup', 'https://forms.google.com/example', '2026-02-01 23:32:33', '2026-02-02 16:53:57');

-- --------------------------------------------------------

--
-- Table structure for table `school_profiles`
--

CREATE TABLE `school_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SMP Negeri 4 Samarinda',
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npsn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akreditasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepala_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sejarah` text COLLATE utf8mb4_unicode_ci,
  `visi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `misi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` text COLLATE utf8mb4_unicode_ci,
  `struktur_organisasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `struktur_guru` json DEFAULT NULL,
  `struktur_guru_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `struktur_tu` json DEFAULT NULL,
  `struktur_tu_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sambutan_kepsek` text COLLATE utf8mb4_unicode_ci,
  `foto_kepsek` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maps_embed` text COLLATE utf8mb4_unicode_ci,
  `footer_description` text COLLATE utf8mb4_unicode_ci,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_profiles`
--

INSERT INTO `school_profiles` (`id`, `nama_sekolah`, `logo_path`, `npsn`, `akreditasi`, `kepala_sekolah`, `alamat`, `email`, `telepon`, `whatsapp_number`, `sejarah`, `visi`, `misi`, `tujuan`, `struktur_organisasi`, `struktur_guru`, `struktur_guru_image`, `struktur_tu`, `struktur_tu_image`, `sambutan_kepsek`, `foto_kepsek`, `maps_embed`, `footer_description`, `facebook_url`, `instagram_url`, `youtube_url`, `created_at`, `updated_at`) VALUES
(1, 'SMP Negeri 4 Samarinda', 'media/logo-sekolah/2026/02/fdbe7717-3f9b-4946-bd74-e96c176fa902.png', '30401032', 'A (Unggul)', 'Erhamsyah, S.Pd., M.Pd', 'Jl. Ir. H. Juanda RT. 17 No. 14, Kelurahan Air Putih, Kecamatan Samarinda Ulu, Kota Samarinda, Kalimantan Timur', 'smp4samarinda@gmail.com', '(0541) 7774016', NULL, '<p>SMP Negeri 4 Samarinda pertama kali menerima peserta didik baru pada bulan Januari tahun 1977. Pada masa awal berdirinya, kegiatan pembelajaran belum memiliki gedung sendiri dan sementara menumpang di Universitas 17 Agustus (UNTAG) Samarinda, dengan fasilitas yang sangat terbatas, yaitu hanya satu ruang kelas. Meskipun dengan sarana prasarana yang sederhana, semangat belajar mengajar tetap berjalan dengan baik berkat dukungan para pendidik, peserta didik, serta masyarakat sekitar. Setahun kemudian, tepatnya pada tahun 1978, SMP Negeri 4 Samarinda mulai memiliki gedung sendiri yang beralamat di Jalan Ir. H. Juanda No. 14 RT. 17, Kelurahan Air Putih, Kecamatan Samarinda Ulu. Pada tanggal 16 Januari 1978, sekolah ini secara resmi diresmikan oleh Menteri Pendidikan dan Kebudayaan Republik Indonesia, Bapak Daud Yusuf. Peresmian tersebut menjadi tonggak penting dalam sejarah berdirinya SMP Negeri 4 Samarinda sebagai salah satu lembaga pendidikan negeri di Kota Samarinda. Dalam perjalanannya, SMP Negeri 4 Samarinda juga menghadapi berbagai tantangan. Salah satu peristiwa besar yang pernah terjadi adalah kebakaran hebat pada bulan Ramadhan tahun 1990, yang mengakibatkan seluruh gedung sekolah terbakar habis. Akibat kejadian tersebut, kegiatan belajar mengajar terpaksa dipindahkan sementara dengan menumpang di gedung SPG di Jalan Banggeris, Samarinda, demi memastikan proses pendidikan tetap berjalan dan tidak terhenti. Setelah melalui masa sulit tersebut, pada tahun 1994, gedung SMP Negeri 4 Samarinda akhirnya selesai dibangun kembali. Para siswa dan tenaga pendidik kemudian kembali menempati lokasi semula di Jalan Ir. H. Juanda, dengan bangunan baru yang lebih layak dan bertingkat, yang terus digunakan hingga saat ini. Sejak saat itu, SMP Negeri 4 Samarinda terus berkembang dan berkomitmen meningkatkan kualitas pendidikan, sarana prasarana, serta pelayanan pendidikan bagi masyarakat. Hingga sekarang, SMP Negeri 4 Samarinda tetap berdiri sebagai institusi pendidikan yang berperan penting dalam mencetak generasi muda yang berprestasi, berkarakter, dan berdaya saing, sejalan dengan visi dan misi pendidikan nasional.</p>', '<p>Terwujudnya Generasi Sesuai dengan Pendidikan Karakter Berdasarkan Profil Pelajar Pancasila yang Inovatif, Bermutu, Berprestasi, Profesional, Berdaya Saing, Berwawasan Lingkungan dan Global</p>', '<ol><li>Mengimplementasikan dan mewujudkan generasi sesuai dengan pendidikan karakter berdasarkan Profil Pelajar Pancasila melalui berbagai bidang ilmu pengetahuan dan teknologi.</li><li>Menerapkan kegiatan tata kelola lingkungan sekolah atau taman belajar peserta didik dan seluruh warga sekolah meliputi program 9K (Keamanan, Kebersihan, Keindahan, Kesehatan, Ketertiban, Kenyamanan, Kerindangan, Keindahan, Kesejahteraan), Hijau Bersih, Sehat, Rindang, Penuh Buah (HBSRPB) sebagai edukasi di sekolah menuju Samarinda kota peradaban.</li><li>Menciptakan suasana pembelajaran yang aktif, inovatif, efektif, kreatif, komunikatif, dan menyenangkan.</li><li>Membina, mengembangkan, mengimplementasikan GTK dan peserta didik yang inovatif, bermutu, berprestasi di bidang akademik maupun nonakademik, profesional, serta memiliki daya saing.</li><li>Meningkatkan pemenuhan kebutuhan infrastruktur delapan (8) standar nasional pendidikan.</li><li>Menyelenggarakan dan mengimplementasikan pengembangan keprofesian berkelanjutan (PKB) melalui kegiatan workshop IHT, seminar, webinar, dan lain-lain.</li><li>Mengembangkan dan melaksanakan fungsi manajerial, supervisi atau penilaian GTK, serta kewirausahaan.</li><li>Memberikan penghargaan dan meningkatkan kesejahteraan peserta didik dan GTK berdasarkan prestasi dan kinerja.</li><li>Menjalin hubungan kerja sama dengan peserta didik, orang tua peserta didik atau wali peserta didik, pengurus komite, GTK, instansi terkait, dan stakeholder.</li><li>Menyelenggarakan dan mengimplementasikan pendidikan yang berwawasan lingkungan dan global.</li></ol>', '<p>1. Menghasilkan lulusan yang berkualitas. 2. Meraih prestasi di tingkat nasional.</p>', NULL, '{\"waka_sarpras\": null, \"kepala_sekolah\": null, \"komite_sekolah\": null, \"waka_kerjasama\": null, \"waka_kesiswaan\": null, \"waka_kurikulum\": null, \"pimpinan_manajemen\": null}', 'media/struktur-organisasi/2026/02/19ee8520-135e-4e7b-bbc8-7e7b132b46cb.jpeg', '{\"kepegawaian\": null, \"perpustakaan\": null, \"penjaga_malam\": null, \"bendahara_bosp\": null, \"staf_tata_usaha\": null, \"bendahara_barang\": null, \"laboratorium_ipa\": null, \"petugas_keamanan\": null, \"petugas_kebersihan\": null, \"lab_komputer_teknisi\": null, \"sapras_surat_menyurat\": null, \"staf_kepsek_kurikulum\": null, \"koordinator_media_bosda\": null, \"petugas_taman_kebersihan\": null, \"pengantar_surat_kesiswaan\": null, \"operator_dapodik_kesiswaan\": null}', 'media/struktur-organisasi/2026/02/c659c499-03c3-45d9-b01a-2dbd2d2a0913.jpeg', '<p>Assalamu’alaikum warahmatullahi wabarakatuh, Salam sejahtera bagi kita semua, Puji syukur ke hadirat Tuhan Yang Maha Esa, atas limpahan rahmat dan karunia-Nya sehingga Website Resmi SMP Negeri 4 Samarinda dapat hadir sebagai media informasi dan komunikasi bagi seluruh warga sekolah serta masyarakat luas. Website ini kami hadirkan sebagai wujud komitmen SMP Negeri 4 Samarinda dalam mendukung transparansi informasi, pelayanan publik, serta pemanfaatan teknologi informasi di bidang pendidikan, sejalan dengan kebijakan dan standar yang ditetapkan oleh Dinas Pendidikan. Melalui media ini, kami berharap seluruh informasi terkait profil sekolah, kegiatan akademik, prestasi, pengumuman, hingga program sekolah dapat diakses dengan mudah, cepat, dan akurat. SMP Negeri 4 Samarinda senantiasa berupaya memberikan layanan pendidikan yang berkualitas dengan menanamkan nilai-nilai disiplin, integritas, tanggung jawab, serta karakter peserta didik agar mampu berkembang secara optimal, baik dalam aspek akademik maupun nonakademik. Kami percaya bahwa pendidikan bukan hanya tentang pencapaian prestasi, tetapi juga tentang pembentukan karakter dan kepribadian generasi penerus bangsa. Kami mengajak seluruh warga sekolah, orang tua peserta didik, alumni, dan masyarakat untuk bersama-sama mendukung kemajuan SMP Negeri 4 Samarinda. Kritik dan saran yang membangun sangat kami harapkan demi peningkatan mutu pendidikan dan pelayanan di sekolah kami. Akhir kata, semoga kehadiran website ini dapat memberikan manfaat yang sebesar-besarnya dan menjadi sarana yang efektif dalam mendukung visi dan misi SMP Negeri 4 Samarinda. Wassalamu’alaikum warahmatullahi wabarakatuh. Kepala SMP Negeri 4 Samarinda</p>', 'media/kepala-sekolah/2026/02/1027a58b-7f51-4c2b-b839-a6b71e92e40f.png', '<iframe src=\"[https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.691712285191!2d117.1471!3d-0.4916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMjknMjkuOCJTIDExN8KwMDgnNDkuNiJF!5e0!3m2!1sen!2sid!4v1625000000000!5m2!1sen!2sid](https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.691712285191!2d117.1471!3d-0.4916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMjknMjkuOCJTIDExN8KwMDgnNDkuNiJF!5e0!3m2!1sen!2sid!4v1625000000000!5m2!1sen!2sid)\" width=\"100%\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', 'Tiada Hari Tanpa Prestasi', 'https://www.facebook.com/SMPNegeri4Samarinda/', 'https://www.instagram.com/smpn4samarinda/', 'https://www.youtube.com/@smpnegeri4samarindaofficial', '2026-02-01 23:32:33', '2026-02-04 18:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('i1yE5ouZ6os5ZQ8tFoCAEjzuoPNr25Q5mJ8X9Omu', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNmFUeDdwanNKVHhSUDhtTUhYVEQ0MHFGYkk4TGVwc2tvZWU3c2xSMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NzAyNTQ3NTM7fX0=', 1770265016),
('NTYsFntvIomIFvIRGkyeuv4h5ndSnfZzjHO3JZEu', NULL, '127.0.0.1', 'curl/8.13.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVU5IQThzTnBTZm83bFhNTHNQdkRoT3JYbEpJV1ZYTkZlY1phcEZTWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWwiO3M6NToicm91dGUiO3M6NjoicHJvZmlsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770258811);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` enum('pendidik','tendik') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendidik',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `is_active`, `profile_photo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin SMPN 4', 'admin@smpn4samarinda.sch.id', NULL, '$2y$12$1CqX7U8dGCA7SJPrdpyD2uefVab1vSM52B7.dNSMZ.8FX3OER14Qy', 'admin', 1, NULL, NULL, '2026-02-01 23:32:33', '2026-02-02 15:39:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_settings`
--
ALTER TABLE `academic_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `former_principals`
--
ALTER TABLE `former_principals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_videos`
--
ALTER TABLE `gallery_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_sliders`
--
ALTER TABLE `home_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `ppdbs`
--
ALTER TABLE `ppdbs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_profiles`
--
ALTER TABLE `school_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_settings`
--
ALTER TABLE `academic_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `former_principals`
--
ALTER TABLE `former_principals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_videos`
--
ALTER TABLE `gallery_videos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `home_sliders`
--
ALTER TABLE `home_sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ppdbs`
--
ALTER TABLE `ppdbs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_profiles`
--
ALTER TABLE `school_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
