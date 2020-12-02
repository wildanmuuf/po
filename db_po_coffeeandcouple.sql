-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2020 at 09:47 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_po_coffeeandcouple`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_account`
--

CREATE TABLE `tb_account` (
  `id_account` int(11) NOT NULL,
  `behalf` varchar(20) NOT NULL,
  `account` varchar(25) NOT NULL,
  `account_bank` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_account`
--

INSERT INTO `tb_account` (`id_account`, `behalf`, `account`, `account_bank`, `created`, `last_modified`, `created_by`, `modified_by`) VALUES
(1, 'Wildan', '12345678', 'BCA', '2020-11-27 09:51:12', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `id_category` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `group_category` int(1) NOT NULL,
  `active` varchar(1) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`id_category`, `category_name`, `group_category`, `active`, `created`, `last_modified`, `created_by`, `modified_by`) VALUES
(1, 'COFFEE BASED WITH SUGAR', 2, 'Y', '2020-10-10 14:22:06', '2020-10-13 16:26:00', 0, 0),
(2, 'RICEBOX', 1, 'Y', '2020-10-11 15:20:54', '2020-10-13 16:25:10', 0, 0),
(3, 'DESSERT BOX', 1, 'Y', '2020-10-13 16:24:49', NULL, 0, 0),
(4, 'FROZEN FOOD', 1, 'Y', '2020-10-13 16:26:28', NULL, 0, 0),
(5, 'COFFEE BASED NON SUGAR', 2, 'Y', '2020-10-13 16:26:57', NULL, 0, 0),
(6, 'NON COFFEE', 2, 'Y', '2020-10-13 16:27:16', NULL, 0, 0),
(7, 'MINI DESSERT BOX', 1, 'Y', '2020-10-14 12:04:37', NULL, 0, 0),
(10, 'SOFT DRINK', 2, 'Y', '2020-11-13 08:23:57', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_pr_item`
--

CREATE TABLE `tb_detail_pr_item` (
  `id_detail_pr_item` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `id_purchase_requition` varchar(25) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_goods` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_detail_pr_item`
--

INSERT INTO `tb_detail_pr_item` (`id_detail_pr_item`, `quantity`, `id_purchase_requition`, `id_supplier`, `id_goods`) VALUES
(1, 10, 'CC-1-20201118-0001', 1, 1),
(4, 200, 'CC-2-20201113-0002', 1, 2),
(5, 10, 'CC-1-20201118-0001', 2, 2),
(13, 10, 'CC-1-20201118-0003', 2, 2),
(14, 100, 'CC-1-20201118-0003', 1, 1),
(20, 10, 'CC-2-20201113-0002', 2, 1),
(21, 100, 'CC-2-20201128-0003', 2, 3),
(22, 100, 'CC-2-20201128-0003', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_entry_goods`
--

CREATE TABLE `tb_entry_goods` (
  `id_entry_goods` int(11) NOT NULL,
  `quantity_receive` int(11) NOT NULL,
  `price_update` int(20) NOT NULL,
  `last_price` int(20) NOT NULL,
  `info` text NOT NULL,
  `id_detail_pr_item` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_entry_goods`
--

INSERT INTO `tb_entry_goods` (`id_entry_goods`, `quantity_receive`, `price_update`, `last_price`, `info`, `id_detail_pr_item`, `created`, `last_modified`, `created_by`, `modified_by`) VALUES
(1, 8, 0, 0, 'Barang rusak 2', 1, '2020-11-27 17:01:28', NULL, 1, 0),
(2, 10, 0, 0, '', 5, '2020-11-27 17:01:28', NULL, 1, 0),
(3, 80, 0, 0, '', 14, '2020-11-28 05:05:08', NULL, 1, 0),
(4, 10, 0, 0, '', 13, '2020-11-28 05:05:08', NULL, 1, 0),
(5, 100, 8000, 0, '', 22, '2020-11-28 07:56:36', NULL, 1, 0),
(6, 100, 1440, 0, '', 21, '2020-11-28 07:56:36', NULL, 1, 0),
(7, 200, 9000, 9000, '', 4, '2020-11-28 08:59:16', NULL, 1, 0),
(8, 10, 8000, 8000, '', 20, '2020-11-28 08:59:16', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_goods`
--

CREATE TABLE `tb_goods` (
  `id_goods` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `quantity_unit` int(11) NOT NULL,
  `price_estimate` int(15) NOT NULL,
  `fixed_price` int(15) NOT NULL DEFAULT 0,
  `active` varchar(1) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_goods`
--

INSERT INTO `tb_goods` (`id_goods`, `name`, `stock`, `quantity_unit`, `price_estimate`, `fixed_price`, `active`, `created`, `last_modified`, `created_by`, `modified_by`, `id_role`, `id_unit`) VALUES
(1, 'Susu', 198, 1000, 10000, 8000, 'Y', '2020-11-09 06:57:44', '2020-11-28 08:59:16', 1, 1, 3, 4),
(2, 'Kopi', 220, 1000, 12000, 9000, 'Y', '2020-11-10 07:56:40', '2020-11-28 08:59:16', 1, 1, 1, 1),
(3, 'Aren Sirup', 100, 100, 5000, 1440, 'Y', '2020-11-17 06:56:00', '2020-11-28 07:56:36', 1, 1, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_goods_receipt`
--

CREATE TABLE `tb_goods_receipt` (
  `id_goods_receipt` int(11) NOT NULL,
  `parent_id_goods` int(11) NOT NULL,
  `child_id_goods` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` int(15) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_goods_receipt`
--

INSERT INTO `tb_goods_receipt` (`id_goods_receipt`, `parent_id_goods`, `child_id_goods`, `quantity`, `cost`, `created`, `last_modified`, `created_by`, `modified_by`) VALUES
(1, 3, 2, 120, 1440, '2020-11-17 15:16:18', '2020-11-17 15:34:12', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_history_login`
--

CREATE TABLE `tb_history_login` (
  `id_history` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_menu`
--

CREATE TABLE `tb_menu` (
  `id_menu` varchar(20) NOT NULL,
  `sequence` int(11) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `parent_id` varchar(15) NOT NULL,
  `module` varchar(30) NOT NULL,
  `path` varchar(100) NOT NULL,
  `url` varchar(50) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `aktif` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_menu`
--

INSERT INTO `tb_menu` (`id_menu`, `sequence`, `menu_name`, `parent_id`, `module`, `path`, `url`, `icon`, `aktif`) VALUES
('ENTRY_GOODS', 1, 'Barang Masuk', 'PUR_REQ', 'hist_entry_goods', 'hist_entry_goods/index.php', '?m=hist_entry_goods', 'fa fa-donation', 'Y'),
('GOODS', 3, 'Bahan Baku', 'PRODUCT', 'goods', 'goods/index.php', '?m=goods\r\n', 'fa fa-product-hunt', 'Y'),
('HOME', 1, 'Beranda', '*', 'awal', 'home/index.php', 'index.php\r\n', 'fas fa-home', 'Y'),
('PR', 1, 'Purchase Request', '*', 'prequest', 'prequest/index.php', '?m=prequest', 'fas fa-file-invoice-dollar', 'Y'),
('PRODUCT', 2, 'Produk', '*', '#\r\n', '*', '#', 'fas fa-utensils', 'Y'),
('PRODUCT_LIST', 4, 'Daftar Produk', 'PRODUCT', 'product', 'product/index.php', '?m=product', 'fas fa-shopping-basket', 'Y'),
('PROD_CATEGORY', 2, 'Kategori', 'PRODUCT', 'category', 'category/index.php', '?m=category', 'fa fa-tag', 'Y'),
('PUR_REQ', 4, 'Purchase Requition', '*', '*', '*', '#', 'fa fa-paper-plane', 'Y'),
('PUR_REQUEST', 1, 'Purchase Request', 'PUR_REQ', 'purchase_requition', 'purchase_requition/index.php', '?m=purchase_requition', 'fa fa-donation', 'Y'),
('SUPPLIER', 3, 'Suplier', '*', 'suppliers', 'suppliers/index.php', '?m=suppliers\r\n', 'fas fa-user-friends', 'Y'),
('SUPPLIER_GOODS', 1, 'Bahan Suplier', 'SUPPLIER', 'supplier_goods', 'supplier_goods/index.php', '?m=supplier_goods\r\n', 'fa fa-dropbox', 'T'),
('UNIT', 1, 'Satuan', 'PRODUCT', 'unit', 'unit/index.php', '?m=unit\r\n', 'fas fa-tag', 'Y'),
('USERS', 4, 'Users', '*', 'users', 'users/index.php', '?m=users\r\n', 'fas fa-users', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tb_payment`
--

CREATE TABLE `tb_payment` (
  `id_payment` int(11) NOT NULL,
  `method` int(11) NOT NULL,
  `id_purchase_requition` varchar(25) NOT NULL,
  `id_account` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_payment`
--

INSERT INTO `tb_payment` (`id_payment`, `method`, `id_purchase_requition`, `id_account`, `created`, `last_modified`, `created_by`, `modified_by`) VALUES
(3, 1, 'CC-2-20201113-0002', 0, '2020-11-27 11:45:20', NULL, 1, 0),
(4, 2, 'CC-1-20201118-0003', 1, '2020-11-27 11:52:31', NULL, 1, 0),
(5, 1, 'CC-1-20201118-0001', 0, '2020-11-27 15:45:14', NULL, 1, 0),
(6, 2, 'CC-1-20201118-0003', 0, '2020-11-28 04:55:12', NULL, 1, 0),
(7, 2, 'CC-2-20201128-0003', 0, '2020-11-28 05:34:13', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_permission`
--

CREATE TABLE `tb_permission` (
  `id_permission` int(11) NOT NULL,
  `id_menu` varchar(20) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_permission`
--

INSERT INTO `tb_permission` (`id_permission`, `id_menu`, `id_role`) VALUES
(1, 'HOME', 1),
(2, 'HOME', 2),
(3, 'HOME', 3),
(4, 'HOME', 4),
(5, 'THINGS', 1),
(6, 'THINGS', 2),
(7, 'THINGS', 3),
(8, 'THINGS', 4),
(9, 'USERS', 1),
(10, 'SUPPLIER', 1),
(11, 'SUPPLIER', 2),
(12, 'SUPPLIER', 3),
(13, 'SUPPLIER', 4),
(14, 'UNIT', 1),
(15, 'GOODS', 1),
(16, 'GOODS', 2),
(17, 'GOODS', 3),
(18, 'GOODS', 4),
(19, 'SUPPLIER_GOODS', 1),
(20, 'SUPPLIER_GOODS', 2),
(21, 'SUPPLIER_GOODS', 3),
(22, 'SUPPLIER_GOODS', 4),
(23, 'PRODUCT', 1),
(24, 'PRODUCT_LIST', 1),
(25, 'PROD_CATEGORY', 1),
(26, 'PUR_REQ', 1),
(27, 'PUR_REQ', 2),
(28, 'PUR_REQ', 3),
(29, 'PUR_REQ', 4),
(30, 'PUR_REQUEST', 1),
(31, 'PUR_REQUEST', 2),
(32, 'PUR_REQUEST', 3),
(33, 'PUR_REQUEST', 4),
(34, 'ENTRY_GOODS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_product`
--

CREATE TABLE `tb_product` (
  `id_product` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` int(20) NOT NULL,
  `hpp` int(15) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `active` varchar(1) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `group_product` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_product`
--

INSERT INTO `tb_product` (`id_product`, `product_name`, `price`, `hpp`, `total_cost`, `active`, `created`, `last_modified`, `created_by`, `modified_by`, `id_category`, `group_product`) VALUES
(1, 'BEEF TERIYAKI', 45000, 0, 0, 'Y', '2020-10-11 15:21:52', '2020-10-13 16:30:23', 0, 0, 2, 1),
(2, 'KOPI JOMBLO', 18000, 0, 1488, 'Y', '2020-10-11 15:24:57', '2020-10-19 13:01:40', 0, 0, 5, 1),
(3, 'CHICKEN TERIYAKI', 35000, 0, 0, 'Y', '2020-10-13 16:33:05', '2020-10-14 03:13:39', 0, 0, 2, 1),
(4, 'SPICY CHICKEN WINGS', 30000, 0, 0, 'Y', '2020-10-13 16:35:06', NULL, 0, 0, 4, 1),
(5, 'AYAM BAKAR (1 EKOR)', 80000, 0, 0, 'Y', '2020-10-14 03:14:43', '2020-10-14 03:51:05', 0, 0, 4, 1),
(6, 'RAWON IGA', 80000, 0, 0, 'Y', '2020-10-14 03:33:24', NULL, 0, 0, 4, 1),
(7, 'CHCKEN KUNG PAU', 45000, 0, 0, 'Y', '2020-10-14 03:37:59', NULL, 0, 0, 4, 1),
(8, 'CHICKEN SALTED EGG', 35000, 0, 0, 'Y', '2020-10-14 03:53:58', '2020-10-19 13:13:09', 0, 0, 2, 1),
(9, 'DORI MATAH', 35000, 0, 0, 'Y', '2020-10-14 03:55:23', '2020-10-19 13:08:59', 0, 0, 2, 1),
(11, 'TIRAMISU', 65000, 0, 0, 'Y', '2020-10-14 04:05:47', NULL, 0, 0, 3, 1),
(12, 'CHOCO SOIL', 60000, 0, 0, 'Y', '2020-10-14 04:08:36', NULL, 0, 0, 3, 1),
(13, 'OREO CHEESE CAKE', 60000, 0, 0, 'Y', '2020-10-14 05:48:23', NULL, 0, 0, 3, 1),
(14, 'CARAMEL REGAL', 60000, 0, 0, 'Y', '2020-10-14 05:49:53', '2020-10-19 13:00:25', 0, 0, 3, 1),
(15, 'GREEN TEA', 70000, 0, 0, 'Y', '2020-10-14 12:01:12', '2020-10-19 12:58:19', 0, 0, 3, 1),
(16, 'RED VELVET', 65000, 0, 0, 'Y', '2020-10-14 12:01:58', NULL, 0, 0, 3, 1),
(17, 'MINI TIRAMISU', 25000, 0, 0, 'Y', '2020-10-14 12:05:19', NULL, 0, 0, 7, 1),
(18, 'MINI CHOCO SOIL', 25000, 0, 0, 'Y', '2020-10-14 12:06:49', NULL, 0, 0, 7, 1),
(19, 'MINI OREO CHEESE CAKE', 25000, 0, 0, 'Y', '2020-10-14 12:30:12', NULL, 0, 0, 7, 1),
(20, 'MINI CARAMEL REGAL', 25000, 0, 0, 'Y', '2020-10-15 02:17:57', NULL, 0, 0, 7, 1),
(21, 'MINI GREEN TEA', 25000, 0, 0, 'Y', '2020-10-15 02:18:48', NULL, 0, 0, 7, 1),
(22, 'KOPI RINDU', 22000, 0, 2900, 'Y', '2020-10-15 02:39:52', '2020-10-19 13:02:56', 0, 0, 5, 1),
(23, 'KOPI PEDEKATE', 20000, 0, 0, 'Y', '2020-10-15 02:49:56', '2020-10-19 13:03:48', 0, 0, 1, 1),
(24, 'KOPI KENCAN PERTAMA', 25000, 0, 0, 'Y', '2020-10-15 02:53:11', '2020-10-19 13:05:04', 0, 0, 1, 1),
(25, 'HUZELNUT CHOCO', 25000, 0, 0, 'Y', '2020-10-15 03:09:46', NULL, 0, 0, 6, 1),
(26, 'MATCHA LATTE', 25000, 0, 0, 'Y', '2020-10-15 03:11:31', NULL, 0, 0, 6, 1),
(27, 'THAI TEA', 25000, 0, 0, 'Y', '2020-10-15 03:13:12', NULL, 0, 0, 6, 1),
(28, 'LYCHEE YAKULT', 25000, 0, 0, 'Y', '2020-10-15 03:15:41', NULL, 0, 0, 6, 1),
(29, 'RED VELVET', 25000, 0, 0, 'Y', '2020-10-15 03:18:12', NULL, 0, 0, 6, 1),
(30, 'TEH PUCUK HARUM', 5000, 0, 0, 'Y', '2020-11-13 08:52:41', NULL, 1, 0, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_purchase_requition`
--

CREATE TABLE `tb_purchase_requition` (
  `id_purchase_requition` varchar(25) NOT NULL,
  `trx_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `category` int(11) NOT NULL,
  `total` int(20) NOT NULL,
  `status` int(1) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_purchase_requition`
--

INSERT INTO `tb_purchase_requition` (`id_purchase_requition`, `trx_date`, `due_date`, `category`, `total`, `status`, `created`, `last_modified`, `created_by`, `modified_by`) VALUES
('CC-1-20201118-0001', '2020-11-18', NULL, 1, 220, 8, '2020-11-22 14:44:49', '2020-11-28 11:56:00', 2, 0),
('CC-1-20201118-0003', '2020-11-18', NULL, 1, 1120, 7, '2020-11-24 18:13:40', '2020-11-28 05:05:08', 1, 1),
('CC-2-20201113-0002', '2020-11-13', '2020-11-24', 2, 2400, 7, '2020-11-23 07:45:47', '2020-11-28 08:59:16', 1, 0),
('CC-2-20201128-0003', '2020-11-28', '2020-11-29', 2, 2240, 7, '2020-11-28 05:27:45', '2020-11-28 07:56:36', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_receipt`
--

CREATE TABLE `tb_receipt` (
  `id_receipt` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_goods` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` int(15) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_receipt`
--

INSERT INTO `tb_receipt` (`id_receipt`, `id_product`, `id_goods`, `quantity`, `cost`, `created`, `last_modified`, `created_by`, `modified_by`) VALUES
(1, 22, 2, 200, 2400, '2020-11-14 13:52:34', '2020-11-17 15:19:01', 1, 1),
(2, 2, 2, 100, 1200, '2020-11-15 03:00:08', NULL, 1, 0),
(3, 22, 1, 50, 500, '2020-11-17 07:27:38', NULL, 1, 0),
(4, 0, 1, 200, 2000, '2020-11-17 15:08:02', NULL, 1, 0),
(5, 2, 3, 20, 288, '2020-11-19 00:38:23', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_roles`
--

CREATE TABLE `tb_roles` (
  `id_role` int(11) NOT NULL,
  `rolename` varchar(15) NOT NULL,
  `active` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_roles`
--

INSERT INTO `tb_roles` (`id_role`, `rolename`, `active`) VALUES
(1, 'Administrator', 'Y'),
(2, 'Bar', 'Y'),
(3, 'Kitchen', 'Y'),
(4, 'Pastry', 'Y'),
(13, 'Owner', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tb_security_password`
--

CREATE TABLE `tb_security_password` (
  `id_security_password` int(11) NOT NULL,
  `security_password` text NOT NULL,
  `aktif` varchar(1) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_suppliers`
--

CREATE TABLE `tb_suppliers` (
  `id_supplier` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `active` varchar(1) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_suppliers`
--

INSERT INTO `tb_suppliers` (`id_supplier`, `name`, `address`, `phone_number`, `active`, `created`, `last_modified`, `created_by`, `modified_by`) VALUES
(1, 'WILDAN', '-', '999999995', 'Y', '2020-11-08 20:48:20', '2020-11-08 21:09:45', 1, 1),
(2, 'MUFID', '-', '08888888', 'Y', '2020-11-09 20:01:10', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit`
--

CREATE TABLE `tb_unit` (
  `id_unit` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` varchar(1) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_unit`
--

INSERT INTO `tb_unit` (`id_unit`, `name`, `active`, `created`, `last_modified`, `created_by`, `modified_by`) VALUES
(1, 'gr', 'Y', '2020-11-08 23:12:05', '2020-11-14 07:52:05', 1, 1),
(2, 'kg', 'Y', '2020-11-08 23:12:27', '2020-11-14 07:52:00', 1, 1),
(3, 'ons', 'Y', '2020-11-08 23:12:35', '2020-11-14 07:54:43', 1, 1),
(4, 'ml', 'Y', '2020-11-14 07:51:48', '2020-11-14 07:51:54', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(500) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id_user`, `name`, `username`, `password`, `status`, `created`, `last_modified`, `id_role`) VALUES
(1, 'Eva Oktaviani', 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'Y', '0000-00-00 00:00:00', '2020-11-08 13:48:42', 1),
(2, 'Ompong', 'kitchen', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Y', '2020-11-08 13:52:16', '2020-11-08 21:07:23', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_account`
--
ALTER TABLE `tb_account`
  ADD PRIMARY KEY (`id_account`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `tb_detail_pr_item`
--
ALTER TABLE `tb_detail_pr_item`
  ADD PRIMARY KEY (`id_detail_pr_item`);

--
-- Indexes for table `tb_entry_goods`
--
ALTER TABLE `tb_entry_goods`
  ADD PRIMARY KEY (`id_entry_goods`);

--
-- Indexes for table `tb_goods`
--
ALTER TABLE `tb_goods`
  ADD PRIMARY KEY (`id_goods`);

--
-- Indexes for table `tb_goods_receipt`
--
ALTER TABLE `tb_goods_receipt`
  ADD PRIMARY KEY (`id_goods_receipt`);

--
-- Indexes for table `tb_history_login`
--
ALTER TABLE `tb_history_login`
  ADD PRIMARY KEY (`id_history`);

--
-- Indexes for table `tb_menu`
--
ALTER TABLE `tb_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `tb_payment`
--
ALTER TABLE `tb_payment`
  ADD PRIMARY KEY (`id_payment`);

--
-- Indexes for table `tb_permission`
--
ALTER TABLE `tb_permission`
  ADD PRIMARY KEY (`id_permission`);

--
-- Indexes for table `tb_product`
--
ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`id_product`);

--
-- Indexes for table `tb_purchase_requition`
--
ALTER TABLE `tb_purchase_requition`
  ADD PRIMARY KEY (`id_purchase_requition`);

--
-- Indexes for table `tb_receipt`
--
ALTER TABLE `tb_receipt`
  ADD PRIMARY KEY (`id_receipt`);

--
-- Indexes for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `tb_security_password`
--
ALTER TABLE `tb_security_password`
  ADD PRIMARY KEY (`id_security_password`);

--
-- Indexes for table `tb_suppliers`
--
ALTER TABLE `tb_suppliers`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `tb_unit`
--
ALTER TABLE `tb_unit`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_account`
--
ALTER TABLE `tb_account`
  MODIFY `id_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_detail_pr_item`
--
ALTER TABLE `tb_detail_pr_item`
  MODIFY `id_detail_pr_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_entry_goods`
--
ALTER TABLE `tb_entry_goods`
  MODIFY `id_entry_goods` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_goods`
--
ALTER TABLE `tb_goods`
  MODIFY `id_goods` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_goods_receipt`
--
ALTER TABLE `tb_goods_receipt`
  MODIFY `id_goods_receipt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_history_login`
--
ALTER TABLE `tb_history_login`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_payment`
--
ALTER TABLE `tb_payment`
  MODIFY `id_payment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_permission`
--
ALTER TABLE `tb_permission`
  MODIFY `id_permission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tb_product`
--
ALTER TABLE `tb_product`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tb_receipt`
--
ALTER TABLE `tb_receipt`
  MODIFY `id_receipt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_security_password`
--
ALTER TABLE `tb_security_password`
  MODIFY `id_security_password` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_suppliers`
--
ALTER TABLE `tb_suppliers`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `id_unit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
