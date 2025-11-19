-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2025 at 05:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `Category` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `Category`, `Date`) VALUES
(1, 'Category One', '2022-12-07 18:04:16'),
(2, 'Category Two', '2022-12-07 18:04:20'),
(3, 'Category Three', '2022-12-07 18:04:24'),
(4, 'Category Four', '2022-12-07 18:04:27'),
(5, 'Category Five', '2022-12-07 18:04:31'),
(6, 'Category Six', '2022-12-07 18:04:36'),
(7, 'Category Seven', '2022-12-07 18:04:41'),
(8, 'Furniture', '2025-10-18 19:42:02');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `idDocument` int(11) NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `purchases` int(11) NOT NULL,
  `lastPurchase` datetime NOT NULL,
  `registerDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `idDocument`, `email`, `phone`, `address`, `birthdate`, `purchases`, `lastPurchase`, `registerDate`) VALUES
(1, 'David Cullison', 123456, 'davidc@mail.com', '(555)567-9999', '27 Joseph Street', '1986-01-05', 15, '2018-12-03 00:01:21', '2022-12-10 13:41:42'),
(2, 'Mary Yaeger', 121212, 'maryy@mail.com', '(555) 789-9045', '71 Highland Drive', '1983-06-22', 3, '2022-12-08 12:20:28', '2022-12-10 13:41:27'),
(3, 'Robert Zimmerman', 122458, 'robert@mail.com', '(305) 455-6677', '27 Joseph Street', '1989-04-12', 0, '2022-12-08 12:18:43', '2022-12-10 13:40:27'),
(4, 'Randall Williams', 103698, 'randalw@mail.com', '(305) 256-6541', '31 Romines Mill Road', '1989-08-15', 5, '2022-12-10 08:42:36', '2022-12-10 13:42:36'),
(6, 'Christine Moore', 852100, 'christine@mail.com', '(785) 458-7888', '44 Down Lane', '1990-10-16', 36, '2022-12-07 13:17:31', '2022-12-08 18:11:56'),
(7, 'Nicole Young', 100254, 'nicole@mail.com', '(101) 222-1145', '44 Sycamore Fork Road', '1989-12-12', 4, '2022-12-10 08:38:47', '2022-12-10 13:38:47'),
(8, 'Grace Moore', 178500, 'gracem@mail.com', '(100) 124-5896', '39 Cambridge Drive', '1990-12-07', 7, '2022-12-10 12:40:02', '2022-12-10 17:40:02'),
(9, 'Reed Campbell', 178500, 'reedc@mail.com', '(100) 245-7866', '87 Lang Avenue', '1988-04-16', 18, '2022-12-10 08:43:42', '2022-12-10 13:43:42'),
(10, 'Lynn', 101014, 'lynn@mail.com', '(100) 145-8966', '90 Roosevelt Road', '1992-02-22', 0, '0000-00-00 00:00:00', '2022-12-10 17:12:55'),
(11, 'Will Williams', 100147, 'williams@mail.com', '(774) 145-8888', '114 Test Address', '1985-04-19', 13, '2022-12-10 12:35:52', '2022-12-10 17:35:52'),
(12, 'ahmed', 231, 'ahmed@gmail.com', '(316) 396-6419', 'Flat No. 35-B Hasnain Square Plaza Liberty Market', '2003-04-02', 10, '2025-10-26 08:03:23', '2025-10-26 13:03:23'),
(13, 'shujat', 4212, 'ahmed@gmail.com', '(031) 639-6641', '27 Joseph Street', '2000-03-02', 0, '0000-00-00 00:00:00', '2025-11-16 21:31:21');

-- --------------------------------------------------------

--
-- Table structure for table `customer_notes`
--

CREATE TABLE `customer_notes` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `note_text` text NOT NULL,
  `note_type` enum('info','warning','reminder') NOT NULL DEFAULT 'info',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `customer_notes`
--

INSERT INTO `customer_notes` (`id`, `customer_id`, `note_text`, `note_type`, `created_by`, `created_at`) VALUES
(1, 1, 'Payment reminder', 'info', 1, '2025-10-24 16:45:33'),
(2, 2, 'Date exceed', 'warning', 1, '2025-10-24 16:46:14');

-- --------------------------------------------------------

--
-- Table structure for table `partial_payments`
--

CREATE TABLE `partial_payments` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `amount_paid` float NOT NULL,
  `balance_remaining` float NOT NULL DEFAULT 0,
  `payment_method` enum('cash','online','card','cheque') NOT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `paid_by` int(11) NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `partial_payments`
--

INSERT INTO `partial_payments` (`id`, `sale_id`, `amount_paid`, `balance_remaining`, `payment_method`, `reference_no`, `notes`, `paid_by`, `paid_at`) VALUES
(1, 9, 250, 0, 'cash', '', NULL, 1, '2025-10-24 16:13:23'),
(2, 9, 250, 0, 'cash', '', NULL, 1, '2025-10-24 16:14:18'),
(3, 11, 2000, 0, 'cash', '', NULL, 1, '2025-10-24 16:16:24'),
(4, 11, 2000, 0, 'cash', '', NULL, 1, '2025-10-24 16:19:54'),
(5, 9, 72, 0, 'cash', '', NULL, 1, '2025-10-24 16:20:13'),
(6, 26, 100000, 28320.4, 'cash', '', '', 1, '2025-10-26 13:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `payment_audit`
--

CREATE TABLE `payment_audit` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `old_status` enum('Paid','Unpaid','Partial') NOT NULL,
  `new_status` enum('Paid','Unpaid','Partial') NOT NULL,
  `changed_by` int(11) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `payment_audit`
--

INSERT INTO `payment_audit` (`id`, `sale_id`, `customer_id`, `old_status`, `new_status`, `changed_by`, `changed_at`, `remarks`) VALUES
(1, 9, 2, 'Paid', 'Partial', 1, '2025-10-24 15:16:28', ''),
(2, 11, 3, 'Paid', 'Unpaid', 1, '2025-10-24 15:16:52', ''),
(3, 11, 3, 'Unpaid', 'Paid', 1, '2025-10-24 16:19:54', 'Partial payment recorded: $2000'),
(4, 9, 2, 'Partial', 'Paid', 1, '2025-10-24 16:20:13', 'Partial payment recorded: $72.00'),
(5, 24, 12, 'Paid', 'Partial', 1, '2025-10-24 16:24:49', ''),
(6, 11, 3, 'Unpaid', 'Paid', 1, '2025-10-26 11:43:39', ''),
(7, 24, 12, 'Partial', 'Unpaid', 1, '2025-10-26 11:44:04', '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL,
  `code` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `stock` int(11) NOT NULL,
  `buyingPrice` float NOT NULL,
  `sellingPrice` float NOT NULL,
  `sales` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `idCategory`, `code`, `description`, `image`, `stock`, `buyingPrice`, `sellingPrice`, `sales`, `date`) VALUES
(18, 2, '201', 'Product Sample One', 'views/img/products/default/anonymous.png', 11, 56, 78, 20, '2025-10-24 14:41:29'),
(25, 3, '301', 'Product Sample Two', 'views/img/products/default/anonymous.png', 19, 144, 185, 23, '2025-10-26 13:33:11'),
(36, 4, '401', 'Product Sample Three', 'views/img/products/default/anonymous.png', 56, 98, 125, 22, '2025-10-24 14:41:29'),
(44, 5, '501', 'Product Sample Four', 'views/img/products/default/anonymous.png', 9, 350, 490, 21, '2025-10-24 14:41:29'),
(61, 7, '518', 'Test Product', 'views/img/products/518/204.jpg', 19, 20, 28, 41, '2022-12-07 18:19:13'),
(62, 4, '519', 'Product Sample Five', 'views/img/products/default/anonymous.png', 95, 120, 156, 0, '2022-12-10 17:12:55'),
(63, 7, '520', 'Product Sample Six', 'views/img/products/default/anonymous.png', 53, 70, 98, 0, '2022-12-10 17:12:55'),
(64, 1, '521', 'Product Sample Seven', 'views/img/products/default/anonymous.png', 32, 50, 70, 0, '2022-12-08 17:31:25'),
(65, 3, '522', 'Product Sample Eight', 'views/img/products/default/anonymous.png', 6, 100, 140, 5, '2025-10-26 13:44:04'),
(66, 4, '523', 'Product Sample Nine', 'views/img/products/default/anonymous.png', 38, 25, 35, 23, '2025-10-26 13:44:04'),
(67, 5, '524', 'Product Sample Ten', 'views/img/products/default/anonymous.png', 131, 65, 91, 6, '2025-10-26 13:33:17'),
(68, 4, '525', 'Product Sample Eleven', 'views/img/products/default/anonymous.png', 18, 120, 168, 10, '2025-10-26 13:42:36'),
(69, 1, 'TEST001', 'Test Product', 'views/img/products/default/anonymous.png', 10, 100, 140, 1, '2025-10-26 13:33:14'),
(70, 1, 'TEST002', 'Test Product 2', 'views/img/products/default/anonymous.png', 18, 50, 70, 1, '2025-10-26 13:44:43'),
(71, 2, '431', 'table-21', 'views/img/products/default/anonymous.png', 32, 245, 343, 1, '2025-11-16 21:11:35'),
(72, 2, '431', 'table-21', 'views/img/products/default/anonymous.png', 32, 245, 343, 7, '2025-11-16 21:11:35'),
(73, 1, '6318', 'bhakdik', 'views/img/products/6318/912.jpg', 50, 40000, 48000, 0, '2025-11-16 11:12:59'),
(74, 2, '431', 'table-21', 'views/img/products/default/anonymous.png', 32, 245, 343, 0, '2025-11-16 21:11:35'),
(75, 7, 't2432', 'bhavdea iei', 'views/img/products/default/anonymous.png', 51, 9000, 12600, 0, '2025-11-18 10:37:32'),
(76, 8, '67g', 'cghk  kbj', 'views/img/products/default/anonymous.png', 786, 9888, 13843.2, 0, '2025-11-18 11:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_slip_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_slip_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(2, 2, 71, 1, 3452, 3452),
(3, 2, 70, 1, 50, 50),
(4, 3, 71, 1, 3452, 3452),
(5, 3, 69, 1, 100, 100),
(6, 4, 72, 1, 21332, 21332),
(7, 4, 68, 1, 120, 120),
(8, 4, 67, 66, 65, 4290),
(20, 11, 72, 1, 21332, 21332),
(21, 11, 71, 1, 3452, 3452),
(22, 11, 68, 1, 120, 120),
(23, 12, 70, 1, 50, 50),
(24, 12, 71, 1, 3452, 3452),
(25, 12, 72, 1, 21332, 21332),
(26, 13, 65, 1, 100, 100),
(27, 13, 66, 1, 25, 25),
(28, 13, 70, 1, 50, 50),
(29, 14, 72, 1, 21332, 21332),
(30, 14, 71, 1, 3452, 3452),
(31, 14, 70, 1, 50, 50),
(32, 15, 72, 1, 21332, 21332),
(33, 15, 71, 1, 3452, 3452);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_partial_payments`
--

CREATE TABLE `purchase_partial_payments` (
  `id` int(11) NOT NULL,
  `purchase_slip_id` int(11) NOT NULL,
  `amount_paid` float NOT NULL,
  `balance_remaining` float NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `paid_by` int(11) NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `purchase_partial_payments`
--

INSERT INTO `purchase_partial_payments` (`id`, `purchase_slip_id`, `amount_paid`, `balance_remaining`, `payment_method`, `reference_no`, `notes`, `paid_by`, `paid_at`) VALUES
(1, 10, 28000, 376, 'Cash', '', '', 1, '2025-10-26 13:25:11'),
(6, 15, 20000, 7262.4, 'Cash', '', '', 1, '2025-10-26 13:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_slips`
--

CREATE TABLE `purchase_slips` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `tax_percent` float NOT NULL,
  `payment_status` enum('Paid','Unpaid','Partial') NOT NULL DEFAULT 'Unpaid',
  `payment_method` text NOT NULL,
  `reference_no` text NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `purchase_slips`
--

INSERT INTO `purchase_slips` (`id`, `vendor_id`, `total_amount`, `tax_percent`, `payment_status`, `payment_method`, `reference_no`, `notes`, `created_at`) VALUES
(2, 2, 4027.3, 15, 'Paid', 'Online', 'PUR-10002', '', '2025-10-19 10:25:00'),
(3, 2, 28376, 32, 'Paid', 'Cash', 'PUR-10003', '', '2025-10-26 11:53:30'),
(4, 2, 28376, 32, 'Paid', 'Cash', 'PUR-10003', '', '2025-10-26 11:57:59'),
(11, 3, 32873.3, 32, 'Paid', 'Cash', 'PUR-10003', '', '2025-10-26 13:42:36'),
(12, 2, 35512.6, 43, 'Paid', 'Online', 'PUR-10003', '', '2025-10-26 13:43:31'),
(13, 3, 250.25, 43, 'Paid', 'Cash', 'PUR-10003', '', '2025-10-26 13:44:04'),
(14, 2, 35512.6, 43, 'Paid', 'Online', 'PUR-10003', '', '2025-10-26 13:44:43'),
(15, 3, 27262.4, 10, 'Partial', 'Cash', 'PUR-10003', '', '2025-10-26 13:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `return_code` varchar(50) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_returned` int(11) NOT NULL,
  `return_type` enum('refund','exchange') NOT NULL,
  `reason` text NOT NULL,
  `refund_amount` float NOT NULL,
  `handled_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `return_code`, `sale_id`, `product_id`, `quantity_returned`, `return_type`, `reason`, `refund_amount`, `handled_by`, `created_at`) VALUES
(1, 'RET-10001', 9, 25, 1, 'refund', 'Other', 185, 1, '2025-10-24 14:41:12'),
(2, 'RET-10002', 12, 44, 1, 'exchange', 'Wrong Item', 490, 1, '2025-10-24 14:41:29'),
(3, 'RET-10002', 12, 36, 1, 'exchange', 'Wrong Item', 125, 1, '2025-10-24 14:41:29'),
(5, 'RET-10002', 12, 18, 1, 'exchange', 'Wrong Item', 78, 1, '2025-10-24 14:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `idSeller` int(11) NOT NULL,
  `products` text NOT NULL,
  `tax` int(11) NOT NULL,
  `netPrice` float NOT NULL,
  `totalPrice` float NOT NULL,
  `paymentMethod` text NOT NULL,
  `payment_status` enum('Paid','Unpaid','Partial') NOT NULL DEFAULT 'Paid',
  `saledate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `code`, `idCustomer`, `idSeller`, `products`, `tax`, `netPrice`, `totalPrice`, `paymentMethod`, `payment_status`, `saledate`) VALUES
(9, 10001, 2, 2, '[{\"id\":\"25\",\"description\":\"Product Sample Two\",\"quantity\":\"3\",\"stock\":\"29\",\"price\":\"185\",\"totalPrice\":\"555\"}]', 17, 555, 572, 'cash', 'Partial', '2025-10-24 15:16:28'),
(11, 10002, 3, 1, '[{\"id\":\"44\",\"description\":\"Product Sample Four\",\"quantity\":\"4\",\"stock\":\"16\",\"price\":\"490\",\"totalPrice\":\"1960\"},{\"id\":\"36\",\"description\":\"Product Sample Three\",\"quantity\":\"6\",\"stock\":\"14\",\"price\":\"125\",\"totalPrice\":\"750\"}]', 0, 2710, 2710, 'cash', 'Paid', '2025-10-26 11:43:39'),
(12, 10003, 3, 1, '[{\"id\":\"44\",\"description\":\"Product Sample Four\",\"quantity\":\"1\",\"stock\":\"2\",\"price\":\"490\",\"totalPrice\":\"490\"},{\"id\":\"36\",\"description\":\"Product Sample Three\",\"quantity\":\"1\",\"stock\":\"8\",\"price\":\"125\",\"totalPrice\":\"125\"},{\"id\":\"25\",\"description\":\"Product Sample Two\",\"quantity\":\"1\",\"stock\":\"23\",\"price\":\"185\",\"totalPrice\":\"185\"},{\"id\":\"18\",\"description\":\"Product Sample One\",\"quantity\":\"2\",\"stock\":\"114\",\"price\":\"78\",\"totalPrice\":\"156\"}]', 48, 956, 1004, 'cash', 'Paid', '2019-04-09 22:59:10'),
(14, 10005, 6, 1, '[{\"id\":\"61\",\"description\":\"Test Product\",\"quantity\":\"9\",\"stock\":\"31\",\"price\":\"28\",\"totalPrice\":\"252\"},{\"id\":\"44\",\"description\":\"Product Sample Four\",\"quantity\":\"3\",\"stock\":\"3\",\"price\":\"490\",\"totalPrice\":\"1470\"},{\"id\":\"36\",\"description\":\"Product Sample Three\",\"quantity\":\"5\",\"stock\":\"3\",\"price\":\"125\",\"totalPrice\":\"625\"}]', 117, 2347, 2464, 'cash', 'Paid', '2020-02-26 05:34:45'),
(15, 10006, 6, 1, '[{\"id\":\"61\",\"description\":\"Test Product\",\"quantity\":\"17\",\"stock\":\"19\",\"price\":\"28\",\"totalPrice\":\"476\"},{\"id\":\"25\",\"description\":\"Product Sample Two\",\"quantity\":\"2\",\"stock\":\"1\",\"price\":\"185\",\"totalPrice\":\"370\"}]', 25, 846, 871, 'cash', 'Paid', '2021-01-05 15:36:20'),
(17, 10008, 4, 1, '[{\"id\":\"67\",\"description\":\"Product Sample Ten\",\"quantity\":\"2\",\"stock\":\"69\",\"price\":\"91\",\"totalPrice\":\"182\"}]', 0, 182, 182, 'cash', 'Paid', '2021-09-28 05:18:53'),
(18, 10009, 7, 1, '[{\"id\":\"66\",\"description\":\"Product Sample Nine\",\"quantity\":\"3\",\"stock\":\"57\",\"price\":\"35\",\"totalPrice\":\"105\"},{\"id\":\"65\",\"description\":\"Product Sample Eight\",\"quantity\":\"1\",\"stock\":\"40\",\"price\":\"140\",\"totalPrice\":\"140\"}]', 5, 245, 250, 'cash', 'Paid', '2022-02-13 23:58:09'),
(19, 10010, 4, 1, '[{\"id\":\"36\",\"description\":\"Product Sample Three\",\"quantity\":\"3\",\"stock\":\"55\",\"price\":\"125\",\"totalPrice\":\"375\"}]', 4, 375, 379, 'cash', 'Paid', '2022-06-29 03:42:37'),
(20, 10011, 9, 1, '[{\"id\":\"67\",\"description\":\"Product Sample Ten\",\"quantity\":\"4\",\"stock\":\"65\",\"price\":\"91\",\"totalPrice\":\"364\"},{\"id\":\"66\",\"description\":\"Product Sample Nine\",\"quantity\":\"10\",\"stock\":\"47\",\"price\":\"35\",\"totalPrice\":\"350\"},{\"id\":\"65\",\"description\":\"Product Sample Eight\",\"quantity\":\"4\",\"stock\":\"36\",\"price\":\"140\",\"totalPrice\":\"560\"}]', 64, 1274, 1338, 'CC-110101458966', 'Paid', '2022-09-20 13:43:42'),
(21, 10012, 11, 1, '[{\"id\":\"68\",\"description\":\"Product Sample Eleven\",\"quantity\":\"3\",\"stock\":\"23\",\"price\":\"168\",\"totalPrice\":\"504\"},{\"id\":\"66\",\"description\":\"Product Sample Nine\",\"quantity\":\"10\",\"stock\":\"37\",\"price\":\"35\",\"totalPrice\":\"350\"}]', 68, 854, 922, 'CC-100000147850', 'Paid', '2022-12-10 17:35:52'),
(22, 10013, 8, 2, '[{\"id\":\"68\",\"description\":\"Product Sample Eleven\",\"quantity\":\"7\",\"stock\":\"16\",\"price\":\"168\",\"totalPrice\":\"1176\"}]', 0, 1176, 1176, 'cash', 'Paid', '2022-12-10 17:40:02'),
(23, 10014, 12, 1, '[{\"id\":\"72\",\"description\":\"3 door almirah\",\"quantity\":\"1\",\"stock\":\"531\",\"price\":\"29864.8\",\"totalPrice\":\"29864.8\"}]', 4480, 29864.8, 34344.8, 'CC-32425644231', 'Paid', '2025-10-19 15:11:37'),
(24, 10015, 12, 1, '[{\"id\":\"71\",\"description\":\"Table\",\"quantity\":\"1\",\"stock\":\"6352\",\"price\":\"52546\",\"totalPrice\":\"52546\"},{\"id\":\"70\",\"description\":\"Test Product 2\",\"quantity\":\"1\",\"stock\":\"15\",\"price\":\"70\",\"totalPrice\":\"70\"}]', 10523, 52616, 63139, 'cash', 'Unpaid', '2025-10-26 11:44:04'),
(25, 10016, 12, 1, '[{\"id\":\"72\",\"description\":\"3 door almirah\",\"quantity\":\"3\",\"stock\":\"1064\",\"price\":\"29864.8\",\"totalPrice\":\"89594.4\"}]', 40317, 89594.4, 129911, 'cash', 'Paid', '2025-10-26 13:16:19'),
(26, 10017, 12, 1, '[{\"id\":\"72\",\"description\":\"3 door almirah\",\"quantity\":\"3\",\"stock\":\"1061\",\"price\":\"29864.8\",\"totalPrice\":\"89594.4\"},{\"id\":\"69\",\"description\":\"Test Product\",\"quantity\":\"1\",\"stock\":\"10\",\"price\":\"140\",\"totalPrice\":\"140\"}]', 38586, 89734.4, 128320, 'cash', 'Paid', '2025-10-26 13:05:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `user` text NOT NULL,
  `password` text NOT NULL,
  `profile` text NOT NULL,
  `photo` text NOT NULL,
  `status` int(1) NOT NULL,
  `lastLogin` datetime NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user`, `password`, `profile`, `photo`, `status`, `lastLogin`, `date`) VALUES
(1, 'Administrator', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrator', 'views/img/users/admin/admin-icn.png', 1, '2025-11-18 05:37:09', '2025-11-18 10:37:09'),
(2, 'Jonathan Barbour', 'seller', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Seller', 'views/img/users/jonathan/239.jpg', 1, '2022-12-10 12:39:15', '2022-12-10 17:39:15'),
(3, 'Carmen McLeod', 'carmen', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Special', 'views/img/users/carmen/215.jpg', 1, '2022-12-10 12:17:55', '2022-12-10 17:17:55');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `phone`, `address`, `created_at`) VALUES
(2, 'Shaikh and co', '(316) 396-6419', 'XYZ Place', '2025-10-19 10:17:33'),
(3, 'Bilal and sons', '(316) 396-6419', 'bhask', '2025-10-19 10:19:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_notes`
--
ALTER TABLE `customer_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `note_type` (`note_type`);

--
-- Indexes for table `partial_payments`
--
ALTER TABLE `partial_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `paid_by` (`paid_by`);

--
-- Indexes for table `payment_audit`
--
ALTER TABLE `payment_audit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `changed_by` (`changed_by`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_slip_id` (`purchase_slip_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `purchase_partial_payments`
--
ALTER TABLE `purchase_partial_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_slip_id` (`purchase_slip_id`),
  ADD KEY `paid_by` (`paid_by`);

--
-- Indexes for table `purchase_slips`
--
ALTER TABLE `purchase_slips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `handled_by` (`handled_by`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customer_notes`
--
ALTER TABLE `customer_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `partial_payments`
--
ALTER TABLE `partial_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_audit`
--
ALTER TABLE `payment_audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `purchase_partial_payments`
--
ALTER TABLE `purchase_partial_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_slips`
--
ALTER TABLE `purchase_slips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
