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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `order_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Mohamed Zayed', 5, 1, '2017-08-08 22:39:47', '2017-08-08 22:39:47'),
(2, 'Mohamed Zayed \r\n', 5, 1, '2017-08-08 22:39:55', '2017-08-08 22:39:55'),
(3, 'wedaewfearwfersfersfesrf\r\n', 5, 1, '2017-08-08 22:40:00', '2017-08-08 22:40:00'),
(4, 'Mohaed Zayed Mohaed Zayed ', 6, 1, '2017-10-13 21:47:44', '2017-10-13 21:47:44'),
(5, 'Mohaed Zayed Mohaed Zayed ', 6, 1, '2017-10-13 21:47:52', '2017-10-13 21:47:52'),
(6, 'sdefsdfsdf', 5, 1, '2017-10-31 11:15:04', '2017-10-31 11:15:04'),
(7, 'sdfsdfssdfsdfsdf', 5, 1, '2017-10-31 11:15:09', '2017-10-31 11:15:09'),
(8, 'alaaewfwefwefwef', 5, 1, '2018-02-13 05:03:52', '2018-02-13 05:03:52');

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

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `title`, `content`, `seen`, `user_message_you`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'w4tfw4', '45wf4w5f4w5f4w5fw45f4w5fw45', 0, 1, 2, '2017-08-08 22:40:35', '2017-08-08 22:40:35'),
(2, 'werwe', 'rwerwerewrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 0, 1, 2, '2018-02-13 05:03:22', '2018-02-13 05:03:22');

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

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notify_id`, `type`, `seen`, `url`, `user_notify_you`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:36', '2017-08-08 01:41:39'),
(2, 2, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:38', '2017-08-08 01:41:39'),
(3, 3, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:40', '2017-08-08 01:41:39'),
(4, 4, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:42', '2017-08-08 01:41:39'),
(5, 5, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:43', '2017-08-08 01:41:39'),
(6, 6, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:44', '2017-08-08 01:41:39'),
(7, 7, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:45', '2017-08-08 01:41:39'),
(8, 8, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:46', '2017-08-08 01:41:39'),
(9, 9, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:48', '2017-08-08 01:41:39'),
(10, 10, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:49', '2017-08-08 01:41:39'),
(11, 11, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:51', '2017-08-08 01:41:27'),
(12, 12, 'AcceptService', 1, '', 1, 1, '2017-08-08 01:12:52', '2017-08-08 01:41:19'),
(13, 21, 'AcceptService', 1, '', 1, 2, '2017-08-08 01:18:57', '2017-08-08 01:49:15'),
(14, 20, 'AcceptService', 1, '', 1, 2, '2017-08-08 01:18:59', '2017-08-08 01:49:15'),
(15, 19, 'AcceptService', 1, '', 1, 2, '2017-08-08 01:19:02', '2017-08-08 01:49:15'),
(16, 13, 'AcceptService', 1, '', 1, 2, '2017-08-08 01:19:05', '2017-08-08 01:49:15'),
(17, 14, 'AcceptService', 1, '', 1, 2, '2017-08-08 01:19:07', '2017-08-08 01:49:15'),
(18, 15, 'AcceptService', 1, '', 1, 2, '2017-08-08 01:19:08', '2017-08-08 01:49:15'),
(19, 16, 'AcceptService', 1, '', 1, 2, '2017-08-08 01:19:10', '2017-08-08 01:49:15'),
(20, 17, 'AcceptService', 1, '', 1, 2, '2017-08-08 01:19:11', '2017-08-08 01:49:15'),
(21, 18, 'AcceptService', 1, '', 1, 2, '2017-08-08 01:19:13', '2017-08-08 01:49:15'),
(22, 1, 'ReceiveOrder', 1, '', 1, 2, '2017-08-08 01:41:53', '2017-08-08 01:48:56'),
(23, 1, 'AcceptedOrder', 1, '', 2, 1, '2017-08-08 01:49:09', '2017-08-08 01:51:32'),
(24, 1, 'CompletedOrder', 1, '', 1, 2, '2017-08-08 01:51:34', '2017-08-08 01:52:09'),
(25, 2, 'ReceiveOrder', 1, '', 1, 2, '2017-08-08 03:43:13', '2017-08-08 03:45:53'),
(26, 2, 'AcceptedOrder', 1, '', 2, 1, '2017-08-08 03:46:10', '2017-08-08 05:02:48'),
(27, 3, 'ReceiveOrder', 1, '', 1, 2, '2017-08-08 04:12:25', '2017-08-08 04:13:15'),
(28, 3, 'AcceptedOrder', 1, '', 2, 1, '2017-08-08 04:16:30', '2017-08-08 04:57:24'),
(29, 4, 'ReceiveOrder', 0, '', 1, 2, '2017-08-08 04:17:13', '2017-08-08 04:17:13'),
(30, 3, 'CompletedOrder', 0, '', 1, 2, '2017-08-08 04:57:25', '2017-08-08 04:57:25'),
(31, 5, 'ReceiveOrder', 1, '', 1, 2, '2017-08-08 12:26:09', '2017-08-08 12:28:12'),
(32, 5, 'AcceptedOrder', 1, '', 2, 1, '2017-08-08 12:28:14', '2017-08-08 12:28:21'),
(33, 5, 'CompletedOrder', 0, '', 1, 2, '2017-08-08 12:28:23', '2017-08-08 12:28:23'),
(34, 5, 'NewComment', 0, '', 1, 2, '2017-08-08 22:39:47', '2017-08-08 22:39:47'),
(35, 5, 'NewComment', 0, '', 1, 2, '2017-08-08 22:39:55', '2017-08-08 22:39:55'),
(36, 5, 'NewComment', 0, '', 1, 2, '2017-08-08 22:40:00', '2017-08-08 22:40:00'),
(37, 1, 'ReceiveMessage', 0, '', 1, 2, '2017-08-08 22:40:35', '2017-08-08 22:40:35'),
(38, 6, 'ReceiveOrder', 0, '', 1, 2, '2017-08-26 16:48:59', '2017-08-26 16:48:59'),
(39, 6, 'NewComment', 0, '', 1, 2, '2017-10-13 21:47:44', '2017-10-13 21:47:44'),
(40, 6, 'NewComment', 0, '', 1, 2, '2017-10-13 21:47:53', '2017-10-13 21:47:53'),
(41, 5, 'NewComment', 0, '', 1, 2, '2017-10-31 11:15:04', '2017-10-31 11:15:04'),
(42, 5, 'NewComment', 0, '', 1, 2, '2017-10-31 11:15:09', '2017-10-31 11:15:09'),
(43, 2, 'ReceiveMessage', 0, '', 1, 2, '2018-02-13 05:03:22', '2018-02-13 05:03:22'),
(44, 5, 'NewComment', 0, '', 1, 2, '2018-02-13 05:03:52', '2018-02-13 05:03:52'),
(45, 7, 'ReceiveOrder', 0, '', 1, 2, '2018-02-13 05:04:07', '2018-02-13 05:04:07');

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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `type`, `status`, `user_order`, `service_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 0, 4, 1, 21, 2, '2017-08-08 04:12:25', '2017-08-08 04:57:25'),
(5, 0, 4, 1, 21, 2, '2017-08-08 12:26:09', '2017-08-08 12:28:23'),
(6, 0, 0, 1, 20, 2, '2017-08-26 16:48:59', '2017-08-26 16:48:59'),
(7, 0, 0, 1, 13, 2, '2018-02-13 05:04:07', '2018-02-13 05:04:07');

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

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `receiver_id`, `order_id`, `price`, `isfinished`, `created_at`, `updated_at`) VALUES
(3, 1, 2, 3, '50', 1, '2017-08-08 04:12:25', '2017-08-08 04:57:25'),
(5, 1, 2, 5, '50', 1, '2017-08-08 12:26:09', '2017-08-08 12:28:22'),
(6, 1, 2, 6, '50', 0, '2017-08-26 16:48:59', '2017-08-26 16:48:59'),
(7, 1, 2, 7, '5', 0, '2018-02-13 05:04:07', '2018-02-13 05:04:07');

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

--
-- Dumping data for table `paypal`
--

INSERT INTO `paypal` (`id`, `pay_id`, `state`, `price`, `payment_method`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'PAY-9XF42460299884454LGERNFA', 'approved', '200.00', 'paypal', 1, '2017-08-08 01:41:13', '2017-08-08 01:41:13'),
(2, 'PAY-2JN06833N0224561CLH4FVNA', 'approved', '500.00', 'paypal', 1, '2017-10-31 11:13:21', '2017-10-31 11:13:21');

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

--
-- Dumping data for table `profits`
--

INSERT INTO `profits` (`id`, `price`, `status`, `time`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '50', 1, 1502168257, 2, '2017-08-08 04:57:37', '2017-08-08 04:58:57'),
(2, '50', 1, 1502195344, 2, '2017-08-08 12:29:04', '2018-02-13 05:02:44');

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

--
-- Dumping data for table `siteprofits`
--

INSERT INTO `siteprofits` (`id`, `profit`, `created_at`, `updated_at`) VALUES
(4, '2.5', '2017-08-08 04:58:57', '2017-08-08 04:58:57'),
(5, '2.5', '2018-02-13 05:02:44', '2018-02-13 05:02:44');

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

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `user_id`, `service_id`, `ip`, `created_at`, `updated_at`) VALUES
(1, 1, 21, '127.0.0.1', '2017-08-08 01:25:11', '2017-08-08 01:25:11'),
(2, 1, 13, '127.0.0.1', '2017-08-08 01:25:21', '2017-08-08 01:25:21'),
(3, 1, 16, '127.0.0.1', '2017-08-08 01:25:31', '2017-08-08 01:25:31'),
(4, 1, 12, '127.0.0.1', '2017-08-08 01:41:19', '2017-08-08 01:41:19'),
(5, 1, 11, '127.0.0.1', '2017-08-08 01:41:27', '2017-08-08 01:41:27'),
(6, 2, 5, '127.0.0.1', '2017-08-08 01:49:55', '2017-08-08 01:49:55'),
(7, 2, 3, '127.0.0.1', '2017-08-08 01:50:21', '2017-08-08 01:50:21'),
(8, 1, 20, '127.0.0.1', '2017-08-26 16:48:49', '2017-08-26 16:48:49'),
(9, 1, 9, '127.0.0.1', '2017-10-13 21:46:47', '2017-10-13 21:46:47'),
(10, 1, 7, '127.0.0.1', '2018-02-13 05:00:55', '2018-02-13 05:00:55');

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

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `vote`, `service_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 5, 13, 1, '2017-08-08 01:25:26', '2017-08-08 01:25:26'),
(2, 5, 5, 2, '2017-08-08 01:49:58', '2017-08-08 01:49:58'),
(3, 5, 3, 1, '2017-08-11 00:17:12', '2017-08-11 00:17:12'),
(4, 5, 9, 1, '2017-10-13 21:46:58', '2017-10-13 21:46:58');

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
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `service_id`, `user_id`, `own_user`, `created_at`, `updated_at`) VALUES
(3, 5, 2, 1, '2017-08-08 01:50:04', '2017-08-08 01:50:04'),
(4, 3, 2, 1, '2017-08-08 01:50:08', '2017-08-08 01:50:08'),
(5, 2, 2, 1, '2017-08-08 01:50:10', '2017-08-08 01:50:10'),
(6, 8, 2, 1, '2017-08-08 01:50:12', '2017-08-08 01:50:12'),
(8, 14, 1, 2, '2018-02-13 05:04:10', '2018-02-13 05:04:10');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `paypal`
--
ALTER TABLE `paypal`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `profits`
--
ALTER TABLE `profits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `siteprofits`
--
ALTER TABLE `siteprofits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
