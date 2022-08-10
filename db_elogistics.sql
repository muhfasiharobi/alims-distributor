-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2021 at 09:34 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_elogistics`
--
CREATE DATABASE IF NOT EXISTS `db_elogistics` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_elogistics`;

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(100) NOT NULL,
  `bank_update` datetime NOT NULL,
  `bank_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`bank_id`, `bank_name`, `bank_update`, `bank_active`) VALUES
(1, 'BNI', '2021-01-16 00:00:00', '1'),
(2, 'BRI', '2021-01-16 00:00:00', '1'),
(3, 'BTN', '2021-01-16 00:00:00', '1'),
(4, 'Mandiri', '2021-01-16 00:00:00', '1'),
(5, 'BNI Syariah', '2021-01-16 00:00:00', '1'),
(6, 'Bukopin', '2021-01-16 00:00:00', '1'),
(7, 'Bumi Artha', '2021-01-16 00:00:00', '1'),
(8, 'BCA', '2021-01-16 00:00:00', '1'),
(9, 'CIMB Niaga', '2021-01-16 00:00:00', '1'),
(10, 'Danamon', '2021-02-05 16:07:06', '1'),
(11, 'Mega', '2021-01-09 00:00:00', '1'),
(12, 'Syariah Mandiri', '2021-01-16 00:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE IF NOT EXISTS `barang_keluar` (
  `barang_keluar_id` int(11) NOT NULL AUTO_INCREMENT,
  `barang_keluar_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `barang_keluar_quantity` int(11) NOT NULL,
  `barang_keluar_description` varchar(250) NOT NULL,
  `barang_keluar_datetime` datetime NOT NULL,
  `user_activity_id` int(11) NOT NULL,
  `barang_keluar_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`barang_keluar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  `company_address` varchar(100) NOT NULL,
  `company_village` varchar(100) NOT NULL,
  `company_districts` varchar(100) NOT NULL,
  `company_city` varchar(100) NOT NULL,
  `company_phone` varchar(20) NOT NULL,
  `company_email` varchar(50) NOT NULL,
  `company_account_bank` varchar(25) NOT NULL,
  `company_account_number` varchar(50) NOT NULL,
  `company_account_name` varchar(50) NOT NULL,
  `company_logo` varchar(250) NOT NULL,
  `company_datetime` datetime NOT NULL,
  `company_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`, `company_address`, `company_village`, `company_districts`, `company_city`, `company_phone`, `company_email`, `company_account_bank`, `company_account_number`, `company_account_name`, `company_logo`, `company_datetime`, `company_active`) VALUES
(1, 'PT JUAL BELI', 'Jl Cendrawasih no 09', 'slawu', 'patrang', 'jember', '0331 422777', 'jualbeli@gmail.com', 'BCA', '777777', 'PT JUAL BELI', 'logo.png', '2020-12-08 16:22:04', '1');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `reseller_id` int(11) NOT NULL,
  `customer_code` varchar(20) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_address` varchar(100) NOT NULL,
  `customer_village` varchar(50) NOT NULL,
  `customer_districts` varchar(250) NOT NULL,
  `customer_city` varchar(250) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `customer_create` datetime NOT NULL,
  `customer_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `customer_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `reseller_id`, `customer_code`, `customer_name`, `customer_address`, `customer_village`, `customer_districts`, `customer_city`, `customer_phone`, `customer_create`, `customer_update`, `user_activity_id`, `customer_active`) VALUES
(1, 1, '1', 'pelanggan', 'perum arjasa asri', 'darsono', 'arjasa', 'jember', '08989230204', '2021-03-22 18:59:31', '2021-03-22 18:59:31', 1, '1'),
(2, 3, '1', 'tes', 'tes', 'tes', 'tes', 'tes', '93492', '2021-03-24 08:39:15', '2021-03-24 08:39:15', 3, '1'),
(3, 3, 'C00', 'kode', 'kode', 'kode', 'kode', 'kode', '8392342', '2021-03-24 08:44:52', '2021-03-24 08:44:52', 3, '1'),
(4, 3, 'C001', 'kode', 'kode', 'kode', 'kode', 'kode', '342431', '2021-03-24 08:46:43', '2021-03-24 08:46:43', 3, '1'),
(5, 3, 'C002', 'kode', 'kode', 'kode', 'kode', 'kode', '927398', '2021-03-24 08:47:40', '2021-03-24 08:47:40', 3, '1'),
(6, 4, 'C003', 'lemonwati', 'lemonwati', 'lemonwati', 'lemonwati', 'lemonwati', '9879232', '2021-03-24 14:37:39', '2021-03-24 14:37:39', 4, '1');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_service`
--

CREATE TABLE IF NOT EXISTS `delivery_service` (
  `delivery_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_service_name` varchar(50) NOT NULL,
  `delivery_service_datetime` datetime NOT NULL,
  `user_activity_id` int(11) NOT NULL,
  `delivery_service_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`delivery_service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `delivery_service`
--

INSERT INTO `delivery_service` (`delivery_service_id`, `delivery_service_name`, `delivery_service_datetime`, `user_activity_id`, `delivery_service_active`) VALUES
(1, 'JNE', '2020-12-30 00:00:00', 1, '1'),
(2, 'J&T', '2020-12-30 00:00:00', 1, '1'),
(3, 'Tiki', '2021-01-18 00:00:00', 1, '1'),
(4, 'POS Indonesia', '2021-01-18 00:00:00', 1, '1'),
(5, 'Sicepat', '2021-01-18 00:00:00', 1, '1'),
(6, 'Ninja Express', '2021-01-18 00:00:00', 1, '1'),
(7, 'First Logistik', '2021-01-18 00:00:00', 1, '1'),
(8, 'Wahana Logistik', '2021-01-18 00:00:00', 1, '1'),
(9, 'Bukalapak', '2021-02-05 14:54:08', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_date` date NOT NULL,
  `no_invoice` varchar(25) NOT NULL,
  `reseller_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `reseller_code` varchar(20) NOT NULL,
  `reseller_name` varchar(50) NOT NULL,
  `reseller_address` varchar(100) NOT NULL,
  `reseller_village` varchar(50) NOT NULL,
  `reseller_districts` varchar(50) NOT NULL,
  `reseller_city` varchar(50) NOT NULL,
  `reseller_phone` varchar(20) NOT NULL,
  `reseller_bank_name` varchar(25) NOT NULL,
  `reseller_account_number` varchar(25) NOT NULL,
  `reseller_account_name` varchar(50) NOT NULL,
  `selling_date_from` date NOT NULL,
  `selling_date_to` date NOT NULL,
  `selling_quantity` int(11) NOT NULL,
  `commission` varchar(11) NOT NULL,
  `reward` varchar(20) NOT NULL,
  `invoice_status` enum('Pending','Done') NOT NULL,
  `invoice_datetime` datetime NOT NULL,
  `invoice_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `invoice_date`, `no_invoice`, `reseller_id`, `month`, `reseller_code`, `reseller_name`, `reseller_address`, `reseller_village`, `reseller_districts`, `reseller_city`, `reseller_phone`, `reseller_bank_name`, `reseller_account_number`, `reseller_account_name`, `selling_date_from`, `selling_date_to`, `selling_quantity`, `commission`, `reward`, `invoice_status`, `invoice_datetime`, `invoice_active`) VALUES
(1, '2021-03-30', 'INVOICE/AGT-01/30032021', 3, 3, 'AGT-01', 'agen', 'jl cendrawasih', 'patrang', 'patrang', 'jember', '08989230204', 'BNI', '1231419', 'agen', '2021-03-27', '2021-03-27', 30, '30000', '0', 'Done', '2021-03-30 09:49:12', '1');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE IF NOT EXISTS `invoice_detail` (
  `invoice_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `item_selling_id` int(11) NOT NULL,
  `invoice_detail_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`invoice_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `invoice_detail`
--

INSERT INTO `invoice_detail` (`invoice_detail_id`, `invoice_id`, `item_selling_id`, `invoice_detail_active`) VALUES
(1, 1, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_transfer`
--

CREATE TABLE IF NOT EXISTS `invoice_transfer` (
  `invoice_transfer_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `bank_id` int(11) NOT NULL,
  `account_number` varchar(25) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `transfer_value` varchar(25) NOT NULL,
  `transfer_photo` varchar(100) NOT NULL,
  `invoice_transfer_datetime` date NOT NULL,
  `invoice_transfer_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`invoice_transfer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `invoice_transfer`
--

INSERT INTO `invoice_transfer` (`invoice_transfer_id`, `invoice_id`, `transfer_date`, `bank_id`, `account_number`, `account_name`, `transfer_value`, `transfer_photo`, `invoice_transfer_datetime`, `invoice_transfer_active`) VALUES
(1, 1, '2021-03-05', 1, '1231419', 'agen', '50000', '1-SOP-Murobahah.jpg', '2021-03-30', '1');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `item_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `item_category_id` tinyint(4) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_create` datetime NOT NULL,
  `item_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `item_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_category_id`, `item_name`, `item_create`, `item_update`, `user_activity_id`, `item_active`) VALUES
(1, 2, 'bunny lemon', '2021-03-22 10:23:32', '2021-03-22 10:23:32', 1, '1'),
(2, 2, 'bunny orange', '2021-03-22 10:23:49', '2021-03-22 10:23:49', 1, '1'),
(3, 3, 'lemona orange', '2021-03-22 10:25:17', '2021-03-22 10:25:17', 1, '1'),
(4, 1, 'lemonwati orange', '2021-03-22 10:25:37', '2021-03-22 10:25:37', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE IF NOT EXISTS `item_category` (
  `item_category_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `item_category_name` varchar(50) NOT NULL,
  `id_label` int(11) NOT NULL,
  `item_category_create` datetime NOT NULL,
  `item_category_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `item_category_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`item_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`item_category_id`, `item_category_name`, `id_label`, `item_category_create`, `item_category_update`, `user_activity_id`, `item_category_active`) VALUES
(1, 'lemonwati', 1, '2021-03-22 10:22:23', '2021-03-22 10:22:23', 1, '1'),
(2, 'bunny', 2, '2021-03-22 10:22:42', '2021-03-22 10:22:42', 1, '1'),
(3, 'lemona', 3, '2021-03-22 10:22:59', '2021-03-22 10:22:59', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `item_commission`
--

CREATE TABLE IF NOT EXISTS `item_commission` (
  `item_commission_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `item_commission_date` date NOT NULL,
  `item_id` tinyint(4) NOT NULL,
  `item_commission_value` mediumint(9) NOT NULL,
  `item_commission_create` datetime NOT NULL,
  `item_commission_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `item_commission_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`item_commission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `item_commission`
--

INSERT INTO `item_commission` (`item_commission_id`, `item_commission_date`, `item_id`, `item_commission_value`, `item_commission_create`, `item_commission_update`, `user_activity_id`, `item_commission_active`) VALUES
(1, '2021-03-22', 1, 1000, '2021-03-22 15:40:13', '2021-03-22 15:40:13', 1, '1'),
(2, '2021-03-24', 1, 1000, '2021-03-24 08:29:21', '2021-03-24 08:29:21', 1, '1'),
(3, '2021-03-24', 4, 1000, '2021-03-24 10:33:21', '2021-03-24 10:33:21', 1, '1'),
(4, '2021-03-24', 1, 1000, '2021-03-24 10:38:09', '2021-03-24 10:38:09', 1, '1'),
(5, '2021-03-24', 1, 1000, '2021-03-24 13:44:44', '2021-03-24 13:44:44', 1, '1'),
(6, '2021-03-24', 4, 1000, '2021-03-24 14:36:33', '2021-03-24 14:36:33', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `item_price`
--

CREATE TABLE IF NOT EXISTS `item_price` (
  `item_price_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_price_date` date NOT NULL,
  `item_id` tinyint(4) NOT NULL,
  `item_price_value` mediumint(9) NOT NULL,
  `item_price_create` datetime NOT NULL,
  `item_price_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `item_price_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`item_price_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `item_price`
--

INSERT INTO `item_price` (`item_price_id`, `item_price_date`, `item_id`, `item_price_value`, `item_price_create`, `item_price_update`, `user_activity_id`, `item_price_active`) VALUES
(1, '2021-03-22', 1, 10000, '2021-03-22 15:40:13', '2021-03-22 15:40:13', 1, '1'),
(2, '2021-03-24', 1, 10000, '2021-03-24 08:29:21', '2021-03-24 08:29:21', 1, '1'),
(3, '2021-03-24', 4, 10000, '2021-03-24 10:33:21', '2021-03-24 10:33:21', 1, '1'),
(4, '2021-03-24', 1, 10, '2021-03-24 10:38:09', '2021-03-24 10:38:09', 1, '1'),
(5, '2021-03-24', 1, 10000, '2021-03-24 13:44:44', '2021-03-24 13:44:44', 1, '1'),
(6, '2021-03-24', 4, 10000, '2021-03-24 14:36:33', '2021-03-24 14:36:33', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `item_purchase`
--

CREATE TABLE IF NOT EXISTS `item_purchase` (
  `item_purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_purchase_date` date NOT NULL,
  `item_purchase_due_date` date NOT NULL,
  `item_category_id` tinyint(4) NOT NULL,
  `supplier_id` tinyint(4) NOT NULL,
  `item_purchase_create` datetime NOT NULL,
  `item_purchase_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `item_purchase_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`item_purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `item_selling`
--

CREATE TABLE IF NOT EXISTS `item_selling` (
  `item_selling_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_selling_code` varchar(20) NOT NULL,
  `item_selling_date` date NOT NULL,
  `reseller_id` smallint(6) NOT NULL,
  `reseller_code` varchar(100) NOT NULL,
  `reseller_name` varchar(250) NOT NULL,
  `reseller_address` varchar(500) NOT NULL,
  `reseller_phone` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_code` varchar(100) NOT NULL,
  `customer_name` varchar(250) NOT NULL,
  `customer_address` varchar(250) NOT NULL,
  `customer_village` varchar(250) NOT NULL,
  `customer_districts` varchar(250) NOT NULL,
  `customer_city` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `order_via_id` int(11) NOT NULL,
  `item_selling_delivery_id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `kategori_promo` varchar(20) NOT NULL,
  `promo_value` int(11) NOT NULL,
  `item_selling_status` enum('Belum Diproses','Sudah Diproses','Menunggu Bukti Pembayaran') NOT NULL,
  `invoice_status` enum('Belum Cair','Cair') NOT NULL,
  `item_selling_create` datetime NOT NULL,
  `item_selling_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `item_selling_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`item_selling_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `item_selling`
--

INSERT INTO `item_selling` (`item_selling_id`, `item_selling_code`, `item_selling_date`, `reseller_id`, `reseller_code`, `reseller_name`, `reseller_address`, `reseller_phone`, `customer_id`, `customer_code`, `customer_name`, `customer_address`, `customer_village`, `customer_districts`, `customer_city`, `customer_phone`, `order_via_id`, `item_selling_delivery_id`, `promo_id`, `kategori_promo`, `promo_value`, `item_selling_status`, `invoice_status`, `item_selling_create`, `item_selling_update`, `user_activity_id`, `item_selling_active`) VALUES
(1, 'INV10321', '2021-03-27', 3, 'AGT-01', 'agen', 'jl cendrawasih,patrang-patrang-jember', '08989230204', 4, 'C001', 'kode', 'kode', 'kode', 'kode', 'kode', '342431', 1, 1, 0, '', 0, 'Sudah Diproses', 'Cair', '2021-03-30 09:21:47', '2021-03-30 09:21:47', 3, '1'),
(2, 'INV20321', '2021-03-01', 1, '', '', '', '', 3, '', '', '', '', '', '', '', 1, 2, 0, '', 0, 'Belum Diproses', 'Belum Cair', '2021-03-30 09:55:01', '2021-03-30 10:01:07', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `item_selling_delivery`
--

CREATE TABLE IF NOT EXISTS `item_selling_delivery` (
  `item_selling_delivery_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_selling_id` int(11) NOT NULL,
  `item_selling_delivery_date` date NOT NULL,
  `delivery_service_id` int(11) NOT NULL,
  `delivery_service_name` varchar(100) NOT NULL,
  `no_resi` varchar(50) NOT NULL,
  `delivery_cost` varchar(50) NOT NULL,
  `delivery_address` varchar(500) NOT NULL,
  `payment` varchar(250) NOT NULL,
  `item_selling_delivery_update` datetime NOT NULL,
  `user_activity_id` int(11) NOT NULL,
  `item_selling_delivery_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`item_selling_delivery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `item_selling_delivery`
--

INSERT INTO `item_selling_delivery` (`item_selling_delivery_id`, `item_selling_id`, `item_selling_delivery_date`, `delivery_service_id`, `delivery_service_name`, `no_resi`, `delivery_cost`, `delivery_address`, `payment`, `item_selling_delivery_update`, `user_activity_id`, `item_selling_delivery_active`) VALUES
(1, 1, '2021-03-27', 1, 'JNE', '7777777', '21000', 'kode, kode - kode - kode', '1-SOP-Murobahah.jpg', '2021-03-30 09:22:05', 3, '1'),
(2, 2, '0000-00-00', 1, '', '7777777', '21000', 'kode, kode - kode - kode', '2-SOP-Murobahah.jpg', '2021-03-30 09:55:21', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `label`
--

CREATE TABLE IF NOT EXISTS `label` (
  `id_label` int(11) NOT NULL AUTO_INCREMENT,
  `nama_label` varchar(50) NOT NULL,
  `gambar_label` varchar(100) NOT NULL,
  `label_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`id_label`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `label`
--

INSERT INTO `label` (`id_label`, `nama_label`, `gambar_label`, `label_active`) VALUES
(1, 'Desain 1', 'label_1.jpg', '1'),
(2, 'Desain 2', 'label_2.jpg', '1'),
(3, 'Desain 3', 'label_3.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_purchase`
--

CREATE TABLE IF NOT EXISTS `order_item_purchase` (
  `order_item_purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_purchase_id` int(11) NOT NULL,
  `item_id` tinyint(4) NOT NULL,
  `order_item_purchase_quantity` mediumint(9) NOT NULL,
  `order_item_purchase_price` mediumint(11) NOT NULL,
  `order_item_purchase_create` datetime NOT NULL,
  `order_item_purchase_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `order_item_purchase_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`order_item_purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_item_selling`
--

CREATE TABLE IF NOT EXISTS `order_item_selling` (
  `order_item_selling_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_selling_id` int(11) NOT NULL,
  `item_id` tinyint(4) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `order_item_selling_quantity` mediumint(9) NOT NULL,
  `item_price_id` int(11) NOT NULL,
  `item_price_value` varchar(20) NOT NULL,
  `item_commission_id` smallint(6) NOT NULL,
  `item_commission_value` varchar(20) NOT NULL,
  `order_item_selling_create` datetime NOT NULL,
  `order_item_selling_update` datetime NOT NULL,
  `user_activity_id` smallint(6) NOT NULL,
  `order_item_selling_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`order_item_selling_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `order_item_selling`
--

INSERT INTO `order_item_selling` (`order_item_selling_id`, `item_selling_id`, `item_id`, `item_name`, `order_item_selling_quantity`, `item_price_id`, `item_price_value`, `item_commission_id`, `item_commission_value`, `order_item_selling_create`, `order_item_selling_update`, `user_activity_id`, `order_item_selling_active`) VALUES
(1, 1, 1, 'bunny lemon', 30, 5, '10000', 5, '1000', '2021-03-30 09:22:20', '2021-03-30 09:22:20', 3, '1');

-- --------------------------------------------------------

--
-- Table structure for table `order_retur_item_purchase`
--

CREATE TABLE IF NOT EXISTS `order_retur_item_purchase` (
  `order_retur_item_purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `retur_item_purchase_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_retur_item_purchase_quantity` int(11) NOT NULL,
  PRIMARY KEY (`order_retur_item_purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_retur_item_selling`
--

CREATE TABLE IF NOT EXISTS `order_retur_item_selling` (
  `order_retur_item_selling_id` int(11) NOT NULL AUTO_INCREMENT,
  `retur_item_selling_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_retur_item_selling_quantity` int(11) NOT NULL,
  PRIMARY KEY (`order_retur_item_selling_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_via`
--

CREATE TABLE IF NOT EXISTS `order_via` (
  `order_via_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_via_name` varchar(100) NOT NULL,
  `order_via_create` datetime NOT NULL,
  `order_via_update` datetime NOT NULL,
  `user_activity_id` int(11) NOT NULL,
  `order_via_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`order_via_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `order_via`
--

INSERT INTO `order_via` (`order_via_id`, `order_via_name`, `order_via_create`, `order_via_update`, `user_activity_id`, `order_via_active`) VALUES
(1, 'Shopee', '2020-12-30 00:00:00', '2020-12-30 00:00:00', 1, '1'),
(2, 'Tokopedia', '2020-12-30 00:00:00', '2020-12-30 00:00:00', 1, '1'),
(3, 'Whatsapp', '2020-12-30 00:00:00', '2020-12-30 00:00:00', 1, '1'),
(4, 'Blibli', '2021-02-11 00:00:00', '2021-02-11 11:56:21', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `paket_produk`
--

CREATE TABLE IF NOT EXISTS `paket_produk` (
  `id_paket_produk` int(11) NOT NULL AUTO_INCREMENT,
  `item_category_id` int(11) NOT NULL,
  `nama_paket_produk` varchar(100) NOT NULL,
  `harga_paket_produk` varchar(50) NOT NULL,
  `paket_produk_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`id_paket_produk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `paket_produk`
--

INSERT INTO `paket_produk` (`id_paket_produk`, `item_category_id`, `nama_paket_produk`, `harga_paket_produk`, `paket_produk_active`) VALUES
(1, 1, 'paket combo', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `paket_produk_detail`
--

CREATE TABLE IF NOT EXISTS `paket_produk_detail` (
  `id_paket_produk_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_paket_produk` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  PRIMARY KEY (`id_paket_produk_detail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `paket_produk_detail`
--

INSERT INTO `paket_produk_detail` (`id_paket_produk_detail`, `id_paket_produk`, `item_id`, `item_quantity`) VALUES
(3, 1, 1, 1),
(4, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penyesuaian_stok`
--

CREATE TABLE IF NOT EXISTS `penyesuaian_stok` (
  `penyesuaian_stok_id` int(11) NOT NULL AUTO_INCREMENT,
  `penyesuaian_stok_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `penyesuaian_stok_operation` varchar(10) NOT NULL,
  `penyesuaian_stok_quantity` int(11) NOT NULL,
  `penyesuaian_stok_update` datetime NOT NULL,
  `user_activity_id` int(11) NOT NULL,
  `penyesuaian_stok_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`penyesuaian_stok_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE IF NOT EXISTS `promo` (
  `promo_id` int(11) NOT NULL AUTO_INCREMENT,
  `promo_name` varchar(100) NOT NULL,
  `promo_from_date` date NOT NULL,
  `promo_to_date` date NOT NULL,
  `kategori_promo` varchar(50) NOT NULL,
  `item_category_id` int(11) NOT NULL,
  `promo_value` int(11) NOT NULL,
  `promo_update` datetime NOT NULL,
  `user_activity_id` int(11) NOT NULL,
  `promo_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`promo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`promo_id`, `promo_name`, `promo_from_date`, `promo_to_date`, `kategori_promo`, `item_category_id`, `promo_value`, `promo_update`, `user_activity_id`, `promo_active`) VALUES
(1, 'tes', '2021-03-01', '2021-03-31', 'prosentase', 1, 10, '2021-03-24 09:23:18', 1, '1'),
(2, 'tes', '2021-03-01', '2021-03-03', 'prosentase', 3, 99, '2021-03-24 11:07:41', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `reseller`
--

CREATE TABLE IF NOT EXISTS `reseller` (
  `reseller_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reseller_code` varchar(50) NOT NULL,
  `reseller_name` varchar(50) NOT NULL,
  `reseller_address` varchar(100) NOT NULL,
  `reseller_village` varchar(50) NOT NULL,
  `reseller_districts` varchar(50) NOT NULL,
  `reseller_city` varchar(50) NOT NULL,
  `reseller_phone` varchar(50) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `reseller_account_number` varchar(50) NOT NULL,
  `reseller_account_name` varchar(50) NOT NULL,
  `reseller_create` datetime NOT NULL,
  `reseller_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `reseller_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`reseller_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `reseller`
--

INSERT INTO `reseller` (`reseller_id`, `user_id`, `reseller_code`, `reseller_name`, `reseller_address`, `reseller_village`, `reseller_districts`, `reseller_city`, `reseller_phone`, `bank_id`, `reseller_account_number`, `reseller_account_name`, `reseller_create`, `reseller_update`, `user_activity_id`, `reseller_active`) VALUES
(1, 1, 'AGT-01', 'pusat', 'jl cendrawasih no 09', 'slawu', 'patrang', 'jember', '08989230204', 4, '14241764', 'pusat', '2021-03-22 15:39:41', '2021-03-22 15:39:41', 1, '1'),
(2, 2, 'Admin Penjualan', 'admin lemonwati', '', '', '', '', '08989230204', 0, '', '', '2021-03-22 18:30:06', '2021-03-22 18:30:06', 1, '1'),
(3, 3, 'AGT-01', 'agen', 'jl cendrawasih', 'patrang', 'patrang', 'jember', '08989230204', 1, '1231419', 'agen', '2021-03-24 08:28:58', '2021-03-24 08:28:58', 1, '1'),
(4, 4, 'AGT-02', 'agen lemonwati', 'agen', 'agen', 'agen', 'agen', '9724198', 1, '897987', 'agen', '2021-03-24 14:36:07', '2021-03-24 14:36:07', 1, '1'),
(5, 5, 'Admin Penjualan', 'admin lemonwati', '', '', '', '', '08989230204', 0, '', '', '2021-03-29 09:56:11', '2021-03-29 09:56:11', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `reseller_item_sell`
--

CREATE TABLE IF NOT EXISTS `reseller_item_sell` (
  `reseller_item_sell_id` int(11) NOT NULL AUTO_INCREMENT,
  `reseller_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_price_id` int(11) NOT NULL,
  `item_commission_id` int(11) NOT NULL,
  `reseller_item_sell_update` datetime NOT NULL,
  `user_activity_id` int(11) NOT NULL,
  `reseller_item_sell_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`reseller_item_sell_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `reseller_item_sell`
--

INSERT INTO `reseller_item_sell` (`reseller_item_sell_id`, `reseller_id`, `item_id`, `item_price_id`, `item_commission_id`, `reseller_item_sell_update`, `user_activity_id`, `reseller_item_sell_active`) VALUES
(1, 2, 4, 0, 0, '2021-03-22 18:30:06', 1, '1'),
(2, 3, 1, 2, 2, '2021-03-24 10:32:48', 1, '0'),
(3, 3, 1, 3, 3, '2021-03-24 10:37:56', 1, '0'),
(4, 3, 1, 4, 4, '2021-03-24 13:44:24', 1, '0'),
(5, 3, 1, 5, 5, '2021-03-24 13:44:44', 1, '1'),
(6, 4, 4, 6, 6, '2021-03-24 14:36:33', 1, '1'),
(7, 5, 4, 0, 0, '2021-03-29 09:56:11', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `retur_item_purchase`
--

CREATE TABLE IF NOT EXISTS `retur_item_purchase` (
  `retur_item_purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `retur_item_purchase_date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `retur_item_purchase_datetime` datetime NOT NULL,
  `retur_item_purchase_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`retur_item_purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `retur_item_selling`
--

CREATE TABLE IF NOT EXISTS `retur_item_selling` (
  `retur_item_selling_id` int(11) NOT NULL AUTO_INCREMENT,
  `retur_item_selling_date` date NOT NULL,
  `reseller_id` int(11) NOT NULL,
  `retur_item_selling_datetime` datetime NOT NULL,
  `retur_item_selling_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`retur_item_selling_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reward`
--

CREATE TABLE IF NOT EXISTS `reward` (
  `reward_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_category_id` int(11) NOT NULL,
  `selling_quantity` int(11) NOT NULL,
  `reward_value` varchar(20) NOT NULL,
  `reward_update` datetime NOT NULL,
  `user_activity_id` int(11) NOT NULL,
  `reward_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`reward_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `reward`
--

INSERT INTO `reward` (`reward_id`, `item_category_id`, `selling_quantity`, `reward_value`, `reward_update`, `user_activity_id`, `reward_active`) VALUES
(1, 2, 10, '20000', '2021-03-24 10:49:55', 1, '1'),
(2, 2, 25, '60000', '2021-03-30 08:46:48', 1, '1'),
(3, 2, 50, '130000', '2021-03-30 08:47:28', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `selling_commission`
--

CREATE TABLE IF NOT EXISTS `selling_commission` (
  `selling_commission_id` int(11) NOT NULL AUTO_INCREMENT,
  `minimal_selling` int(11) NOT NULL,
  `maximal_selling` int(11) NOT NULL,
  `selling_commission_value` varchar(11) NOT NULL,
  `selling_commission_datetime` datetime NOT NULL,
  `selling_commission_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`selling_commission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(50) NOT NULL,
  `supplier_create` datetime NOT NULL,
  `supplier_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `supplier_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `user_category_id` tinyint(4) NOT NULL,
  `item_category_id` int(11) NOT NULL,
  `user_photo` varchar(150) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_phone` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_confirm_password` varchar(50) NOT NULL,
  `user_original_password` varchar(50) NOT NULL,
  `user_create` datetime NOT NULL,
  `user_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `user_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_category_id`, `item_category_id`, `user_photo`, `user_name`, `user_phone`, `user_email`, `user_username`, `user_password`, `user_confirm_password`, `user_original_password`, `user_create`, `user_update`, `user_activity_id`, `user_active`) VALUES
(1, 1, 0, '', 'admin', '', '', 'admin', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', '', '2021-02-15 00:00:00', '2021-02-16 00:00:00', 0, '1'),
(2, 3, 1, '', 'admin penjualan', '08989230204', 'penjualan@gmail.com', 'penjualan', '13bf2c8effae21d17a277520aa9b9277', '13bf2c8effae21d17a277520aa9b9277', '22032021penjualan182926', '2021-03-22 18:29:26', '2021-03-22 18:29:26', 1, '1'),
(3, 2, 2, '', 'agen', '08989230204', 'agen@gmail.com', 'agen', '941730a7089d81c58c743a7577a51640', '941730a7089d81c58c743a7577a51640', 'agen', '2021-03-24 08:28:58', '2021-03-24 08:28:58', 1, '1'),
(4, 2, 1, '', 'agen lemonwati', '9724198', 'agen@gmail.com', 'lemonwati', 'e62231841b158b3557791c3ef10a7708', 'e62231841b158b3557791c3ef10a7708', 'lemonwati', '2021-03-24 14:36:07', '2021-03-24 14:36:07', 1, '1'),
(5, 3, 1, '', 'admin lemonwati', '08989230204', 'adminlemonwati@gmail.com', 'adminlemonwati', '90b4d52a294f134be56e50fc3eb22bb2', '90b4d52a294f134be56e50fc3eb22bb2', '29032021adminlemonwati095545', '2021-03-29 09:55:45', '2021-03-29 09:55:45', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_category`
--

CREATE TABLE IF NOT EXISTS `user_category` (
  `user_category_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `user_category_name` varchar(50) NOT NULL,
  `user_category_create` datetime NOT NULL,
  `user_category_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `user_category_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`user_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_category`
--

INSERT INTO `user_category` (`user_category_id`, `user_category_name`, `user_category_create`, `user_category_update`, `user_activity_id`, `user_category_active`) VALUES
(1, 'Administrator', '2020-08-23 22:19:10', '2020-08-23 22:19:10', 1, '1'),
(2, 'Agen', '2020-12-30 00:00:00', '2020-12-30 00:00:00', 1, '1'),
(3, 'Admin Penjualan', '2021-01-27 00:00:00', '2021-02-11 11:41:49', 1, '1'),
(4, 'Finance', '2021-01-27 00:00:00', '2021-01-27 00:00:00', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_history`
--

CREATE TABLE IF NOT EXISTS `user_history` (
  `user_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_history_ip` varchar(50) NOT NULL,
  `user_history_os` varchar(50) NOT NULL,
  `user_history_browser` varchar(50) NOT NULL,
  `user_history_create` datetime NOT NULL,
  `user_history_update` datetime NOT NULL,
  `user_activity_id` tinyint(4) NOT NULL,
  `user_history_active` enum('1','0') NOT NULL,
  PRIMARY KEY (`user_history_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `user_history`
--

INSERT INTO `user_history` (`user_history_id`, `user_history_ip`, `user_history_os`, `user_history_browser`, `user_history_create`, `user_history_update`, `user_activity_id`, `user_history_active`) VALUES
(1, '::1', 'Windows', 'Google Chrome', '2021-03-22 18:43:58', '2021-03-22 18:43:58', 2, '1'),
(2, '::1', 'Windows', 'Google Chrome', '2021-03-22 18:44:51', '2021-03-22 18:44:51', 1, '1'),
(3, '::1', 'Windows', 'Google Chrome', '2021-03-24 08:03:10', '2021-03-24 08:03:10', 1, '1'),
(4, '::1', 'Windows', 'Google Chrome', '2021-03-24 08:30:25', '2021-03-24 08:30:25', 3, '1'),
(5, '::1', 'Windows', 'Google Chrome', '2021-03-24 08:55:39', '2021-03-24 08:55:39', 1, '1'),
(6, '::1', 'Windows', 'Google Chrome', '2021-03-24 10:30:52', '2021-03-24 10:30:52', 3, '1'),
(7, '::1', 'Windows', 'Google Chrome', '2021-03-24 10:32:23', '2021-03-24 10:32:23', 1, '1'),
(8, '::1', 'Windows', 'Google Chrome', '2021-03-24 10:34:07', '2021-03-24 10:34:07', 3, '1'),
(9, '::1', 'Windows', 'Google Chrome', '2021-03-24 10:35:09', '2021-03-24 10:35:09', 3, '1'),
(10, '::1', 'Windows', 'Google Chrome', '2021-03-24 10:37:02', '2021-03-24 10:37:02', 3, '1'),
(11, '::1', 'Windows', 'Google Chrome', '2021-03-24 10:37:29', '2021-03-24 10:37:29', 1, '1'),
(12, '::1', 'Windows', 'Google Chrome', '2021-03-24 10:38:35', '2021-03-24 10:38:35', 3, '1'),
(13, '::1', 'Windows', 'Google Chrome', '2021-03-24 10:39:51', '2021-03-24 10:39:51', 1, '1'),
(14, '::1', 'Windows', 'Google Chrome', '2021-03-24 13:25:31', '2021-03-24 13:25:31', 3, '1'),
(15, '::1', 'Windows', 'Google Chrome', '2021-03-24 13:30:28', '2021-03-24 13:30:28', 1, '1'),
(16, '::1', 'Windows', 'Google Chrome', '2021-03-24 14:36:54', '2021-03-24 14:36:54', 4, '1'),
(17, '::1', 'Windows', 'Google Chrome', '2021-03-24 14:38:32', '2021-03-24 14:38:32', 1, '1'),
(18, '::1', 'Windows', 'Google Chrome', '2021-03-25 08:56:34', '2021-03-25 08:56:34', 4, '1'),
(19, '::1', 'Windows', 'Google Chrome', '2021-03-25 09:01:45', '2021-03-25 09:01:45', 1, '1'),
(20, '::1', 'Windows', 'Google Chrome', '2021-03-25 09:13:13', '2021-03-25 09:13:13', 4, '1'),
(21, '::1', 'Windows', 'Google Chrome', '2021-03-25 09:17:43', '2021-03-25 09:17:43', 1, '1'),
(22, '::1', 'Windows', 'Google Chrome', '2021-03-25 09:42:02', '2021-03-25 09:42:02', 4, '1'),
(23, '::1', 'Windows', 'Google Chrome', '2021-03-25 09:45:44', '2021-03-25 09:45:44', 1, '1'),
(24, '::1', 'Windows', 'Google Chrome', '2021-03-29 09:14:36', '2021-03-29 09:14:36', 1, '1'),
(25, '::1', 'Windows', 'Google Chrome', '2021-03-29 09:56:35', '2021-03-29 09:56:35', 5, '1'),
(26, '::1', 'Windows', 'Google Chrome', '2021-03-29 10:04:06', '2021-03-29 10:04:06', 3, '1'),
(27, '::1', 'Windows', 'Google Chrome', '2021-03-29 10:25:47', '2021-03-29 10:25:47', 1, '1'),
(28, '::1', 'Windows', 'Google Chrome', '2021-03-29 10:28:00', '2021-03-29 10:28:00', 3, '1'),
(29, '::1', 'Windows', 'Google Chrome', '2021-03-29 10:31:59', '2021-03-29 10:31:59', 1, '1'),
(30, '::1', 'Windows', 'Google Chrome', '2021-03-29 11:07:39', '2021-03-29 11:07:39', 3, '1'),
(31, '::1', 'Windows', 'Google Chrome', '2021-03-29 13:34:12', '2021-03-29 13:34:12', 1, '1'),
(32, '::1', 'Windows', 'Google Chrome', '2021-03-30 08:30:54', '2021-03-30 08:30:54', 1, '1'),
(33, '::1', 'Windows', 'Google Chrome', '2021-03-30 08:59:02', '2021-03-30 08:59:02', 3, '1'),
(34, '::1', 'Windows', 'Google Chrome', '2021-03-30 09:18:32', '2021-03-30 09:18:32', 1, '1'),
(35, '::1', 'Windows', 'Google Chrome', '2021-03-30 09:21:25', '2021-03-30 09:21:25', 3, '1'),
(36, '::1', 'Windows', 'Google Chrome', '2021-03-30 09:24:10', '2021-03-30 09:24:10', 1, '1'),
(37, '::1', 'Windows', 'Google Chrome', '2021-03-30 10:02:04', '2021-03-30 10:02:04', 3, '1'),
(38, '::1', 'Windows', 'Google Chrome', '2021-03-30 10:17:22', '2021-03-30 10:17:22', 1, '1'),
(39, '::1', 'Windows', 'Google Chrome', '2021-03-31 10:23:53', '2021-03-31 10:23:53', 1, '1'),
(40, '::1', 'Windows', 'Google Chrome', '2021-04-03 09:18:25', '2021-04-03 09:18:25', 1, '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
