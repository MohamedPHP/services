-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2018 at 06:10 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `services`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'programming', 'images/cats/pro.jpg', 'programming programming programming programming programming programming programming programming', '2017-07-28 19:57:42', '2017-07-28 19:57:42'),
(2, 'design', 'images/cats/design.jpg', 'design design design design design design design design design design design design design design design ', '2017-07-28 19:57:42', '2017-07-28 19:57:42');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment` varchar(255) NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `seen` tinyint(4) NOT NULL,
  `user_message_you` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2017_06_10_014211_create_categories_table', 1),
('2017_06_10_014233_create_orders_table', 1),
('2017_06_10_014324_create_notifications_table', 1),
('2017_06_10_014342_create_messages_table', 1),
('2017_06_10_014412_create_services_table', 1),
('2017_06_10_014644_create_comments_table', 1),
('2017_06_10_014658_create_votes_table', 1),
('2017_06_12_101327_create_views_table', 1),
('2017_07_03_003548_create_wishlists_table', 1),
('2017_07_10_021739_create_paypals_table', 1),
('2017_07_11_022707_create_payments_table', 1),
('2017_07_20_083137_create_profits_table', 1),
('2017_07_21_200835_create_siteprofits_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `notify_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `seen` tinyint(4) NOT NULL,
  `url` varchar(255) NOT NULL,
  `user_notify_you` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `user_order` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `receiver_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `price` varchar(255) NOT NULL,
  `isfinished` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `paypal`
--

CREATE TABLE `paypal` (
  `id` int(10) UNSIGNED NOT NULL,
  `pay_id` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profits`
--

CREATE TABLE `profits` (
  `id` int(10) UNSIGNED NOT NULL,
  `price` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `dis` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `cat_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `year` varchar(255) NOT NULL,
  `month` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `dis`, `image`, `price`, `views`, `status`, `cat_id`, `user_id`, `year`, `month`, `created_at`, `updated_at`) VALUES
(1, 'sdfewfwefrewf', 'efwefwefwefwefwefwefwefwefwef', 'images/services/2017-07-30-06-04-35_a274f6b6308e98da7688e6b8b813dfa883c275c8.jpeg', 5, 0, 1, 2, 1, '2017', 1, '2017-07-30 16:04:35', '2017-08-08 02:46:58'),
(2, 'Mohamed 1', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-10-56_92a89e3e3872a7dd71b6830a59db6106fff84dc7.jpg', 5, 0, 1, 1, 1, '2017', 2, '2017-08-08 01:10:56', '2017-08-08 02:47:00'),
(3, 'Mohamed 1', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-11-00_92a89e3e3872a7dd71b6830a59db6106fff84dc7.jpg', 10, 0, 1, 1, 1, '2017', 3, '2017-08-08 01:11:00', '2017-08-08 02:47:01'),
(4, 'Mohamed 1', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-11-03_92a89e3e3872a7dd71b6830a59db6106fff84dc7.jpg', 15, 0, 1, 1, 1, '2017', 4, '2017-08-08 01:11:03', '2017-08-08 02:47:03'),
(5, 'Mohamed 1', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-11-08_92a89e3e3872a7dd71b6830a59db6106fff84dc7.jpg', 20, 0, 1, 1, 1, '2017', 5, '2017-08-08 01:11:08', '2017-08-08 02:47:05'),
(6, 'Mohamed 1', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-11-14_92a89e3e3872a7dd71b6830a59db6106fff84dc7.jpg', 25, 0, 1, 1, 1, '2017', 6, '2017-08-08 01:11:14', '2017-08-08 02:47:06'),
(7, 'Mohamed 2', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-11-21_92a89e3e3872a7dd71b6830a59db6106fff84dc7.jpg', 30, 0, 1, 1, 1, '2017', 7, '2017-08-08 01:11:21', '2017-08-08 02:47:09'),
(8, 'Mohamed 2', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-11-24_92a89e3e3872a7dd71b6830a59db6106fff84dc7.jpg', 40, 0, 1, 1, 1, '2017', 8, '2017-08-08 01:11:24', '2017-08-08 02:47:11'),
(9, 'Mohamed 2', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-11-28_92a89e3e3872a7dd71b6830a59db6106fff84dc7.jpg', 50, 0, 1, 1, 1, '2017', 9, '2017-08-08 01:11:28', '2017-08-08 02:47:12'),
(10, 'Mohamed 2', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-11-32_25e7e39a50c475f0a0fd40714943c22b882fc84b.jpg', 50, 0, 1, 1, 1, '2017', 10, '2017-08-08 01:11:32', '2017-08-08 02:47:14'),
(11, 'Mohamed 2', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-11-41_e340c56e6d6f104b6d6f1367de8907d70466243f.jpg', 50, 0, 1, 1, 1, '2017', 11, '2017-08-08 01:11:41', '2017-08-08 02:47:15'),
(12, 'Mohamed 2', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-11-42_e340c56e6d6f104b6d6f1367de8907d70466243f.jpg', 50, 0, 1, 1, 1, '2017', 12, '2017-08-08 01:11:42', '2017-08-08 02:47:17'),
(13, 'Luffy 1', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-17-43_7d178a90e06b2a9667700fec94cfa0cf878cf01c.jpg', 5, 0, 1, 2, 2, '2017', 9, '2017-08-08 01:17:43', '2017-08-08 03:06:08'),
(14, 'Luffy 2', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-17-48_7d178a90e06b2a9667700fec94cfa0cf878cf01c.jpg', 10, 0, 1, 2, 2, '2017', 9, '2017-08-08 01:17:48', '2017-08-08 03:06:05'),
(15, 'Luffy 2', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-17-55_68f9bbd3a38ef06b2940ff5663848c5105a74eaa.jpg', 15, 0, 1, 2, 2, '2017', 9, '2017-08-08 01:17:55', '2017-08-08 03:06:12'),
(16, 'Luffy 3', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-17-58_68f9bbd3a38ef06b2940ff5663848c5105a74eaa.jpg', 15, 0, 1, 2, 2, '2017', 2, '2017-08-08 01:17:58', '2017-08-08 02:47:30'),
(17, 'Luffy 3', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-18-11_d68d0aab1f285d6819fa584777cb51d25f672ef5.jpg', 40, 0, 1, 2, 2, '2017', 3, '2017-08-08 01:18:11', '2017-08-08 02:47:31'),
(18, 'Luffy 4', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-18-14_d68d0aab1f285d6819fa584777cb51d25f672ef5.jpg', 40, 0, 1, 2, 2, '2017', 4, '2017-08-08 01:18:14', '2017-08-08 02:47:40'),
(19, 'Luffy 5', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-18-16_d68d0aab1f285d6819fa584777cb51d25f672ef5.jpg', 40, 0, 1, 2, 2, '2017', 4, '2017-08-08 01:18:16', '2017-08-08 02:47:42'),
(20, 'Luffy 6', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-18-22_d68d0aab1f285d6819fa584777cb51d25f672ef5.jpg', 50, 0, 1, 2, 2, '2017', 4, '2017-08-08 01:18:22', '2017-08-08 03:05:18'),
(21, 'Luffy 6', 'Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category Mohamed One Is Very Good Category ', 'images/services/2017-08-08-03-18-24_d68d0aab1f285d6819fa584777cb51d25f672ef5.jpg', 50, 0, 1, 2, 2, '2017', 4, '2017-08-08 01:18:24', '2017-08-08 03:05:21');

-- --------------------------------------------------------

--
-- Table structure for table `siteprofits`
--

CREATE TABLE `siteprofits` (
  `id` int(10) UNSIGNED NOT NULL,
  `profit` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mohamed Zayed', 'mohamedzayed709@yahoo.com', '$2y$10$6hHO6b8tArHu.wPlzD62Y..nys0IXY80aFLRSNbVlq0dE/wuitET6', '', 1, 'clQdgx2l39umAO26sxYlSqGVV19Qfg20grHjEXdmVdoxSmWDY2CTvVqd3Oef', '2017-07-28 19:57:41', '2017-10-31 11:15:53'),
(2, 'Mohamed', 'mohamedluffy@yahoo.com', '$2y$10$yWWmUMxnG05iJEoSLjbIZ.uYPfSAsP9umjip2MuvL3Sv8anjzyyze', '', 0, 'p8Br5xQZ6hFQawcnJAyIRgObxrBVT5wDQ9rCP43fvREj14pYwQqUJJVaWqVK', '2017-08-08 01:16:08', '2017-08-08 03:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(10) UNSIGNED NOT NULL,
  `vote` int(11) NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `own_user` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_order_id_foreign` (`order_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_user_message_you_foreign` (`user_message_you`),
  ADD KEY `messages_user_id_foreign` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_notify_you_foreign` (`user_notify_you`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_order_foreign` (`user_order`),
  ADD KEY `orders_service_id_foreign` (`service_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_receiver_id_foreign` (`receiver_id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `paypal`
--
ALTER TABLE `paypal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paypal_user_id_foreign` (`user_id`);

--
-- Indexes for table `profits`
--
ALTER TABLE `profits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profits_user_id_foreign` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_cat_id_foreign` (`cat_id`),
  ADD KEY `services_user_id_foreign` (`user_id`);

--
-- Indexes for table `siteprofits`
--
ALTER TABLE `siteprofits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `views_service_id_foreign` (`service_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `votes_service_id_foreign` (`service_id`),
  ADD KEY `votes_user_id_foreign` (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlist_service_id_foreign` (`service_id`),
  ADD KEY `wishlist_user_id_foreign` (`user_id`),
  ADD KEY `wishlist_own_user_foreign` (`own_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paypal`
--
ALTER TABLE `paypal`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profits`
--
ALTER TABLE `profits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `siteprofits`
--
ALTER TABLE `siteprofits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_user_message_you_foreign` FOREIGN KEY (`user_message_you`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_user_notify_you_foreign` FOREIGN KEY (`user_notify_you`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_user_order_foreign` FOREIGN KEY (`user_order`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paypal`
--
ALTER TABLE `paypal`
  ADD CONSTRAINT `paypal_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profits`
--
ALTER TABLE `profits`
  ADD CONSTRAINT `profits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `services_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_own_user_foreign` FOREIGN KEY (`own_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
