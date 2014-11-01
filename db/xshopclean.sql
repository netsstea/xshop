-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 01, 2014 at 06:37 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `customername` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `zone_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`address_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute`
--

CREATE TABLE IF NOT EXISTS `attribute` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_group_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(3) NOT NULL,
  `text_default` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_display`
--

CREATE TABLE IF NOT EXISTS `attribute_display` (
  `attribute_display_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ashow` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `attribute_data` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`attribute_display_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_group`
--

CREATE TABLE IF NOT EXISTS `attribute_group` (
  `attribute_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`attribute_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cshow` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `phukien_status` int(1) NOT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_menu` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon_mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=456 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `image`, `parent_id`, `sort_order`, `date_added`, `date_modified`, `cshow`, `phukien_status`, `banner`, `icon_menu`, `icon_mobile`) VALUES
(454, 'data/pbo45011-front.png', 0, 2, '2014-11-01 23:36:24', '2014-11-01 23:38:40', 'thuonghieu=1', 0, 'data/pbo45011-back.png', 'data/pbo45011-aset.png', 'data/pbo45011-aset.png'),
(455, 'data/gaastra-trainers-garboard-kids-navy-1.jpg', 0, 3, '2014-11-01 23:38:27', '2014-11-01 23:38:47', 'thuonghieu=1', 0, 'data/gaastra-trainers-garboard-kids-navy-2.jpg', 'data/gaastra-trainers-garboard-kids-navy-4.jpg', 'data/gaastra-trainers-garboard-kids-navy-3.jpg'),
(453, 'data/giay-hieu-size_-41.42.43-1.jpg', 0, 1, '2014-11-01 23:31:31', '2014-11-01 23:31:31', 'thuonghieu=1', 0, 'data/giay-hieu-size_-41.42.43-2.jpg', 'data/giay-hieu-size_-41.42.43-2.jpg', 'data/giay-hieu-size_-41.42.43-2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category_description`
--

CREATE TABLE IF NOT EXISTS `category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `name_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category_description`
--

INSERT INTO `category_description` (`category_id`, `language_id`, `name`, `meta_description`, `description`, `name_seo`, `keywords`) VALUES
(453, 5, 'Gi&agrave;y Cruyff', '', '&lt;div&gt;\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;Brand: Johan Cruyff&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;Model: Cruyff Recopa Classics&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;Country: H&amp;agrave; Lan&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;-------------------------------------------------------&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;Gia c&amp;ocirc;ng tại Việt Nam theo đơn đặt h&amp;agrave;ng của Cruyff shoes.&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;Gender: Man shoes&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;Upper: Leather ( Chất liệu da ở phần tr&amp;ecirc;n gi&amp;agrave;y ).&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;Outsole: Rubber ( Chất liệu cao su cho đế gi&amp;agrave;y ).&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;------------------------------------------------------&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;Gi&amp;aacute; Ch&amp;iacute;nh H&amp;atilde;ng: &amp;euro; 69 - &amp;euro;&amp;nbsp;129,95 ( Khoảng 2.100.000 - 3.800.000 VND )&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;span style=&quot;font-size:large&quot;&gt;&lt;span style=&quot;font-family:book antiqua,palatino&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;Tham Khảo&amp;nbsp; www.cruyffclassics.com &lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;cruyff&quot; src=&quot;http://xshop.local/image/data/giay-hieu-size_-41.42.43-0.jpg&quot; style=&quot;height:374px; width:564px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/giay-hieu-size_-41.42.43-0-new.jpg&quot; style=&quot;height:374px; width:564px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/giay-hieu-size_-41.42.43-1.jpg&quot; style=&quot;height:374px; width:564px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/giay-hieu-size_-41.42.43-2.jpg&quot; style=&quot;height:374px; width:564px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/giay-hieu-size_-41.42.43-3.jpg&quot; style=&quot;height:374px; width:564px&quot; /&gt;&lt;/p&gt;\r\n&lt;/div&gt;\r\n', '', ''),
(454, 5, 'Gi&agrave;y PME Legend', '', '&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/pbo45011-aset.png&quot; style=&quot;height:90px; width:90px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/pbo45011-back.png&quot; style=&quot;height:90px; width:90px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/pbo45011-front.png&quot; style=&quot;height:90px; width:90px&quot; /&gt;&lt;/p&gt;\r\n', '', ''),
(455, 5, 'Gi&agrave;y GAASTAR', '', '&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/gaastra-trainers-garboard-kids-navy-1.jpg&quot; style=&quot;height:520px; width:520px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/gaastra-trainers-garboard-kids-navy-2.jpg&quot; style=&quot;height:520px; width:520px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/gaastra-trainers-garboard-kids-navy-3.jpg&quot; style=&quot;height:520px; width:520px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/gaastra-trainers-garboard-kids-navy-4.jpg&quot; style=&quot;height:520px; width:520px&quot; /&gt;&lt;/p&gt;\r\n', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `category_to_manufacturer`
--

CREATE TABLE IF NOT EXISTS `category_to_manufacturer` (
  `category_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name_seo` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL,
  `ex_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`,`manufacturer_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chome`
--

CREATE TABLE IF NOT EXISTS `chome` (
  `chome_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`chome_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `chome`
--

INSERT INTO `chome` (`chome_id`, `sort_order`, `image`, `link`) VALUES
(13, 0, 'no_image.jpg', 'http://xshop.local/image/cache/data/t317n_4701.jpg-100x100.png');

-- --------------------------------------------------------

--
-- Table structure for table `chome_description`
--

CREATE TABLE IF NOT EXISTS `chome_description` (
  `chome_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`chome_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `chome_description`
--

INSERT INTO `chome_description` (`chome_id`, `language_id`, `name`) VALUES
(13, 5, 'Gi&agrave;y thể thao');

-- --------------------------------------------------------

--
-- Table structure for table `cinformation`
--

CREATE TABLE IF NOT EXISTS `cinformation` (
  `cinformation_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL,
  `cshow` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cinformation_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cinformation`
--

INSERT INTO `cinformation` (`cinformation_id`, `sort_order`, `cshow`) VALUES
(1, 1, 'footer'),
(2, 0, 'footer'),
(3, 0, 'header'),
(4, 0, 'product'),
(5, 0, 'sidebar');

-- --------------------------------------------------------

--
-- Table structure for table `cinformation_description`
--

CREATE TABLE IF NOT EXISTS `cinformation_description` (
  `cinformation_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cinformation_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cinformation_description`
--

INSERT INTO `cinformation_description` (`cinformation_id`, `language_id`, `name`) VALUES
(1, 5, 'Hỗ trợ kh&aacute;ch h&agrave;ng'),
(2, 5, 'Th&ocirc;ng tin c&ocirc;ng ty'),
(3, 5, 'Th&ocirc;ng tin Header'),
(4, 5, 'Hiển thị ở chi tiết sản phẩm'),
(5, 5, 'Hiển thị thanh b&ecirc;n phải');

-- --------------------------------------------------------

--
-- Table structure for table `cnews`
--

CREATE TABLE IF NOT EXISTS `cnews` (
  `cnews_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cshow` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cnews_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `cnews_description`
--

CREATE TABLE IF NOT EXISTS `cnews_description` (
  `cnews_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cnews_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE IF NOT EXISTS `color` (
  `color_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`color_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`color_id`, `language_id`, `name`, `code`) VALUES
(1, 5, 'M&agrave;u trắng', 'FFF'),
(2, 5, 'M&agrave;u v&agrave;ng', 'FFFF00'),
(3, 5, 'M&agrave;u Đen', 'AAAAAA'),
(4, 5, 'M&agrave;u Xanh', '00FF00'),
(5, 5, 'M&agrave;u Đỏ', 'FF0000'),
(6, 5, 'M&agrave;u T&iacute;m', '660066'),
(7, 5, 'Xanh dương', '0000CC');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `iso_code_2` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `iso_code_3` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address_format` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=240 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`) VALUES
(230, 'Việt Nam', 'VN', 'VNM', '');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE IF NOT EXISTS `coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `type` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `logged` int(1) NOT NULL,
  `shipping` int(1) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `uses_total` int(11) NOT NULL,
  `uses_customer` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`coupon_id`, `code`, `type`, `discount`, `logged`, `shipping`, `total`, `date_start`, `date_end`, `uses_total`, `uses_customer`, `status`, `date_added`) VALUES
(7, '011', 'P', 10.0000, 0, 1, 0.0000, '2011-12-24', '2012-02-29', 100, '100', 1, '2011-12-24 16:49:01');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_description`
--

CREATE TABLE IF NOT EXISTS `coupon_description` (
  `coupon_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`coupon_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `coupon_description`
--

INSERT INTO `coupon_description` (`coupon_id`, `language_id`, `name`, `description`) VALUES
(7, 5, 'Giảm gi&aacute; phụ kiện', 'Giảm gi&aacute; phụ kiện');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_product`
--

CREATE TABLE IF NOT EXISTS `coupon_product` (
  `coupon_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`coupon_product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `csupport`
--

CREATE TABLE IF NOT EXISTS `csupport` (
  `csupport_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`csupport_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `csupport_description`
--

CREATE TABLE IF NOT EXISTS `csupport_description` (
  `csupport_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`csupport_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `symbol_left` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `symbol_right` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `decimal_place` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `value` float(15,8) NOT NULL,
  `status` int(1) NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`currency_id`, `title`, `code`, `symbol_left`, `symbol_right`, `decimal_place`, `value`, `status`, `date_modified`) VALUES
(2, 'US Dollar', 'USD', '', ' USD', '0', 1.00000000, 1, '2011-11-05 11:49:24'),
(3, 'VN Đồng', 'VND', '', 'đ', '0', 1.00000000, 1, '2014-03-29 11:27:17');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customername` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(96) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `telephone` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cart` text COLLATE utf8_unicode_ci,
  `newsletter` int(1) NOT NULL DEFAULT '0',
  `address_id` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gender` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=231 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_group`
--

CREATE TABLE IF NOT EXISTS `customer_group` (
  `customer_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `cg_status` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`customer_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `customer_group`
--

INSERT INTO `customer_group` (`customer_group_id`, `name`, `cg_status`) VALUES
(8, 'Mặc định', ''),
(9, 'Admin', 'admin'),
(10, 'Vip', 'vip'),
(11, 'Mod', 'mod');

-- --------------------------------------------------------

--
-- Table structure for table `download`
--

CREATE TABLE IF NOT EXISTS `download` (
  `download_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mask` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `remaining` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`download_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `download_description`
--

CREATE TABLE IF NOT EXISTS `download_description` (
  `download_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`download_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extension`
--

CREATE TABLE IF NOT EXISTS `extension` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`extension_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=284 ;

--
-- Dumping data for table `extension`
--

INSERT INTO `extension` (`extension_id`, `type`, `key`) VALUES
(23, 'payment', 'cod'),
(22, 'total', 'shipping'),
(57, 'total', 'sub_total'),
(58, 'total', 'tax'),
(59, 'total', 'total'),
(280, 'module', 'background'),
(244, 'module', 'news'),
(215, 'feed', 'google_base'),
(128, 'total', 'coupon'),
(184, 'shipping', 'free'),
(211, 'feed', 'google_sitemap'),
(216, 'module', 'category_news'),
(217, 'module', 'hotrotructuyen'),
(228, 'module', 'google_analytics'),
(240, 'module', 'google_talk'),
(223, 'module', 'footer'),
(225, 'module', 'header'),
(248, 'module', 'khuyenmaihotro'),
(234, 'module', 'hotkeyword'),
(256, 'module', 'product'),
(267, 'module', 'header_banner'),
(276, 'module', 'bannergocphai'),
(262, 'module', 'icon_share'),
(265, 'module', 'khuyenmai'),
(269, 'module', 'lienket2'),
(277, 'module', 'camketmuahang'),
(281, 'module', 'support'),
(274, 'module', 'lienket'),
(278, 'module', 'lienket1'),
(282, 'module', 'popup');

-- --------------------------------------------------------

--
-- Table structure for table `geo_zone`
--

CREATE TABLE IF NOT EXISTS `geo_zone` (
  `geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`geo_zone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `geo_zone`
--

INSERT INTO `geo_zone` (`geo_zone_id`, `name`, `description`, `date_modified`, `date_added`) VALUES
(5, 'Thuế GTGT Việt Nam', 'Việt Nam VAT', '2011-09-19 16:42:44', '2009-10-20 17:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `generic` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`history_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`history_id`, `user_id`, `generic`, `code`, `date_added`, `username`) VALUES
(1, 20, 'category_add', 'category_id=447', '2014-11-01 00:56:07', 'netsstea'),
(2, 20, 'cinformation_delete', 'cinformation_id=list_9', '2014-11-01 01:37:35', 'netsstea'),
(3, 20, 'cinformation_delete', 'cinformation_id=list_10', '2014-11-01 01:37:38', 'netsstea'),
(4, 20, 'information_add', 'information_id=78', '2014-11-01 01:39:24', 'netsstea'),
(5, 20, 'information_add', 'information_id=79', '2014-11-01 01:40:03', 'netsstea'),
(6, 20, 'product_add', 'product_id=2695', '2014-11-01 19:41:42', 'netsstea'),
(7, 20, 'product_updateprice', 'product_id=2695', '2014-11-01 19:41:52', 'netsstea'),
(8, 20, 'product_updateprice', 'product_id=2695', '2014-11-01 19:41:59', 'netsstea'),
(9, 20, 'category_add', 'category_id=448', '2014-11-01 19:48:50', 'netsstea'),
(10, 20, 'category_add', 'category_id=449', '2014-11-01 19:49:21', 'netsstea'),
(11, 20, 'category_edit', 'category_id=449', '2014-11-01 19:49:55', 'netsstea'),
(12, 20, 'category_add', 'category_id=450', '2014-11-01 19:50:21', 'netsstea'),
(13, 20, 'category_add', 'category_id=451', '2014-11-01 19:50:57', 'netsstea'),
(14, 20, 'category_add', 'category_id=452', '2014-11-01 19:51:25', 'netsstea'),
(15, 20, 'product_edit', 'product_id=2695', '2014-11-01 19:53:12', 'netsstea'),
(16, 20, 'product_edit', 'product_id=2695', '2014-11-01 19:54:32', 'netsstea'),
(17, 20, 'product_add', 'product_id=2696', '2014-11-01 19:56:04', 'netsstea'),
(18, 20, 'product_delete', 'product_id=list_2695', '2014-11-01 19:56:10', 'netsstea'),
(19, 20, 'product_edit', 'product_id=2696', '2014-11-01 19:57:35', 'netsstea'),
(20, 20, 'manufacturer_add', 'manufacturer_id=1', '2014-11-01 19:58:09', 'netsstea'),
(21, 20, 'manufacturer_add', 'manufacturer_id=2', '2014-11-01 19:58:38', 'netsstea'),
(22, 20, 'manufacturer_add', 'manufacturer_id=3', '2014-11-01 19:58:59', 'netsstea'),
(23, 20, 'manufacturer_edit', 'manufacturer_id=1', '2014-11-01 20:01:26', 'netsstea'),
(24, 20, 'manufacturer_edit', 'manufacturer_id=2', '2014-11-01 20:01:35', 'netsstea'),
(25, 20, 'manufacturer_edit', 'manufacturer_id=3', '2014-11-01 20:01:39', 'netsstea'),
(26, 20, 'product_add', 'product_id=2697', '2014-11-01 20:03:16', 'netsstea'),
(27, 20, 'product_updateprice', 'product_id=list_2697_2696', '2014-11-01 20:04:39', 'netsstea'),
(28, 20, 'category_delete', 'category_id=list_449_448_450_451_452_447', '2014-11-01 23:23:46', 'netsstea'),
(29, 20, 'product_delete', 'product_id=list_2697_2696', '2014-11-01 23:23:52', 'netsstea'),
(30, 20, 'category_add', 'category_id=453', '2014-11-01 23:31:31', 'netsstea'),
(31, 20, 'category_add', 'category_id=454', '2014-11-01 23:36:24', 'netsstea'),
(32, 20, 'category_add', 'category_id=455', '2014-11-01 23:38:27', 'netsstea'),
(33, 20, 'category_edit', 'category_id=454', '2014-11-01 23:38:40', 'netsstea'),
(34, 20, 'category_edit', 'category_id=455', '2014-11-01 23:38:47', 'netsstea'),
(35, 20, 'product_add', 'product_id=2698', '2014-11-01 23:44:47', 'netsstea'),
(36, 20, 'product_edit', 'product_id=2698', '2014-11-01 23:45:58', 'netsstea'),
(37, 20, 'review_add', 'review_id=1', '2014-11-01 23:52:58', 'netsstea'),
(38, 20, 'product_edit', 'product_id=2698', '2014-11-01 23:56:15', 'netsstea'),
(39, 20, 'slideshow_add', 'slideshow_id=1', '2014-11-02 00:07:47', 'netsstea'),
(40, 20, 'slideshow_add', 'slideshow_id=2', '2014-11-02 00:08:11', 'netsstea');

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE IF NOT EXISTS `information` (
  `information_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `cinformation_id` int(11) NOT NULL DEFAULT '0',
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`information_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=80 ;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`information_id`, `sort_order`, `cinformation_id`, `link`, `image`) VALUES
(79, 0, 1, '', ''),
(78, 0, 2, '', 'data/t317n_4701.jpg.png');

-- --------------------------------------------------------

--
-- Table structure for table `information_description`
--

CREATE TABLE IF NOT EXISTS `information_description` (
  `information_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `name_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`information_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `information_description`
--

INSERT INTO `information_description` (`information_id`, `language_id`, `name`, `description`, `name_seo`, `meta_description`, `keywords`) VALUES
(78, 5, 'Giới thiệu X-Shop', '&lt;p&gt;X-Shop l&amp;agrave; của h&amp;agrave;ng chuy&amp;ecirc;n b&amp;aacute;n bu&amp;ocirc;n b&amp;aacute;n lẻ gi&amp;agrave;y thể thao xuất khẩu, với c&amp;aacute;c thương hiệu đến từ ch&amp;acirc;u &amp;acirc;u&lt;/p&gt;\r\n', '', '', ''),
(79, 5, 'Hỗ trợ kh&aacute;ch h&agrave;ng', '&lt;p&gt;Đường d&amp;acirc;y n&amp;oacute;ng : 0977946017&lt;br /&gt;\r\n&amp;nbsp;&lt;/p&gt;\r\n', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `directory` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `filename` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL,
  PRIMARY KEY (`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`language_id`, `name`, `code`, `locale`, `image`, `directory`, `filename`, `sort_order`, `status`) VALUES
(5, 'Tiếng Việt', 'vn', 'en_US.UTF-8,en_US,en-gb,vietnamese', 'vn.png', 'vietnamese', 'vietnamese', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE IF NOT EXISTS `manufacturer` (
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(3) NOT NULL,
  `menu_status` int(1) NOT NULL DEFAULT '0',
  `icon_menu` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`manufacturer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`manufacturer_id`, `image`, `sort_order`, `menu_status`, `icon_menu`, `banner`) VALUES
(1, 'data/cc143004203993.jpg', 1, 0, 'data/cc143004203993.jpg', 'data/cc143004203993.jpg'),
(2, 'data/gaastra-trainers-regiment-men-greybue-2.jpg', 2, 0, 'data/gaastra-trainers-regiment-men-greybue-2.jpg', 'data/gaastra-trainers-regiment-men-greybue-2.jpg'),
(3, 'data/templatelisterouterglow1.jpg', 3, 0, 'data/templatelisterouterglow1.jpg', 'data/templatelisterouterglow1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer_description`
--

CREATE TABLE IF NOT EXISTS `manufacturer_description` (
  `manufacturer_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`manufacturer_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `manufacturer_description`
--

INSERT INTO `manufacturer_description` (`manufacturer_id`, `language_id`, `name`) VALUES
(3, 5, 'PME Legend'),
(2, 5, 'GAASTAR'),
(1, 5, 'Cruyff');

-- --------------------------------------------------------

--
-- Table structure for table `measurement_class`
--

CREATE TABLE IF NOT EXISTS `measurement_class` (
  `measurement_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`measurement_class_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `measurement_class`
--

INSERT INTO `measurement_class` (`measurement_class_id`, `language_id`, `title`, `unit`) VALUES
(3, 5, 'Millimeter', 'mm'),
(2, 5, 'Inch', 'in'),
(1, 5, 'Centimetre', 'cm');

-- --------------------------------------------------------

--
-- Table structure for table `measurement_rule`
--

CREATE TABLE IF NOT EXISTS `measurement_rule` (
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `rule` decimal(15,4) NOT NULL DEFAULT '0.0000'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `measurement_rule`
--

INSERT INTO `measurement_rule` (`from_id`, `to_id`, `rule`) VALUES
(2, 1, 2.5400),
(1, 2, 0.3937),
(3, 2, 0.0394),
(3, 1, 0.1000),
(1, 3, 10.0000),
(2, 3, 25.4000);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cnews_id` int(11) NOT NULL,
  `viewed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `newsletter_id` int(11) NOT NULL AUTO_INCREMENT,
  `gender` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`newsletter_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `news_description`
--

CREATE TABLE IF NOT EXISTS `news_description` (
  `news_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`news_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_to_cnews`
--

CREATE TABLE IF NOT EXISTS `news_to_cnews` (
  `news_id` int(11) NOT NULL,
  `cnews_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`cnews_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `customername` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `telephone` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(96) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `zone` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `zone_id` int(11) NOT NULL,
  `country` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `shipping_method` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `payment_method` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `order_status_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(15,8) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=293 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE IF NOT EXISTS `order_history` (
  `order_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_status_id` int(5) NOT NULL,
  `notify` int(1) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`order_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_option`
--

CREATE TABLE IF NOT EXISTS `order_option` (
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `product_option_value_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `prefix` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`order_option_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE IF NOT EXISTS `order_product` (
  `order_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `quantity` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE IF NOT EXISTS `order_status` (
  `order_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`order_status_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`order_status_id`, `language_id`, `name`) VALUES
(5, 5, 'Đ&atilde; ho&agrave;n tất'),
(1, 5, 'Đang chờ duyệt'),
(2, 5, 'Đang xử l&yacute;'),
(7, 5, 'Đ&atilde; hủy bỏ'),
(10, 5, 'Đang chờ thanh to&aacute;n'),
(11, 5, 'Đ&atilde; thanh to&aacute;n'),
(12, 5, 'Chờ chuyển h&agrave;ng');

-- --------------------------------------------------------

--
-- Table structure for table `order_total`
--

CREATE TABLE IF NOT EXISTS `order_total` (
  `order_total_id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`order_total_id`),
  KEY `idx_orders_total_orders_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `phanloai`
--

CREATE TABLE IF NOT EXISTS `phanloai` (
  `phanloai_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`phanloai_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `phanloai_info`
--

CREATE TABLE IF NOT EXISTS `phanloai_info` (
  `phanloai_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`phanloai_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phanloai_to_category`
--

CREATE TABLE IF NOT EXISTS `phanloai_to_category` (
  `phanloai_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`phanloai_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `stock_status_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `shipping` int(1) NOT NULL DEFAULT '1',
  `price` decimal(15,0) NOT NULL DEFAULT '0',
  `tax_class_id` int(11) NOT NULL,
  `date_available` date NOT NULL,
  `weight` decimal(5,2) NOT NULL DEFAULT '0.00',
  `weight_class_id` int(11) NOT NULL DEFAULT '0',
  `length` decimal(5,2) NOT NULL DEFAULT '0.00',
  `width` decimal(5,2) NOT NULL DEFAULT '0.00',
  `height` decimal(5,2) NOT NULL DEFAULT '0.00',
  `measurement_class_id` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `viewed` int(5) NOT NULL DEFAULT '0',
  `warranty` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `chome_id` int(11) NOT NULL DEFAULT '0',
  `sku` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `location` decimal(15,0) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `total_promotion` decimal(15,0) NOT NULL DEFAULT '0',
  `360do` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `price_hc` decimal(15,0) NOT NULL DEFAULT '0',
  `stock_status_id_hc` int(11) NOT NULL,
  `total_promotion_hc` decimal(15,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2699 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `model`, `quantity`, `stock_status_id`, `image`, `manufacturer_id`, `shipping`, `price`, `tax_class_id`, `date_available`, `weight`, `weight_class_id`, `length`, `width`, `height`, `measurement_class_id`, `status`, `date_added`, `date_modified`, `viewed`, `warranty`, `chome_id`, `sku`, `location`, `sort_order`, `category_id`, `total_promotion`, `360do`, `template`, `price_hc`, `stock_status_id_hc`, `total_promotion_hc`) VALUES
(2698, '1', 10, 1, 'data/giay-hieu-size_-41.42.43-3.jpg', 0, 1, 500000, 0, '2014-11-01', 0.00, 1, 0.00, 0.00, 0.00, 1, 1, '2014-11-01 23:44:47', '2014-11-01 23:56:15', 28, '0', 0, '', 0, 0, 453, 0, NULL, '', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute`
--

CREATE TABLE IF NOT EXISTS `product_attribute` (
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`product_id`,`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_description`
--

CREATE TABLE IF NOT EXISTS `product_description` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` text COLLATE utf8_unicode_ci NOT NULL,
  `brief_description` text COLLATE utf8_unicode_ci NOT NULL,
  `technical_description` text COLLATE utf8_unicode_ci NOT NULL,
  `promotion` text COLLATE utf8_unicode_ci NOT NULL,
  `name_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `promotion_hc` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`product_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2699 ;

--
-- Dumping data for table `product_description`
--

INSERT INTO `product_description` (`product_id`, `language_id`, `name`, `meta_description`, `description`, `tags`, `brief_description`, `technical_description`, `promotion`, `name_seo`, `promotion_hc`) VALUES
(2698, 5, 'Cruyff Recopa Classics', 'H&agrave;ng Việt Nam Xuất Khẩu\r\n\r\nBrand: Johan Cruyff\r\n\r\nModel: Cruyff Recopa Classics\r\n\r\nCountry: H&agrave; Lan', '<p><strong><span style="font-size:large"><span style="font-family:book antiqua,palatino"><span style="color:#000000">Gia c&ocirc;ng tại Việt Nam theo đơn đặt h&agrave;ng của Cruyff shoes.</span></span></span></strong></p>\r\n\r\n<p><strong><span style="font-size:large"><span style="font-family:book antiqua,palatino"><span style="color:#000000">Gender: Man shoes</span></span></span></strong></p>\r\n\r\n<p><strong><span style="font-size:large"><span style="font-family:book antiqua,palatino"><span style="color:#000000">Upper: Leather ( Chất liệu da ở phần tr&ecirc;n gi&agrave;y ).</span></span></span></strong></p>\r\n\r\n<p><strong><span style="font-size:large"><span style="font-family:book antiqua,palatino"><span style="color:#000000">Outsole: Rubber ( Chất liệu cao su cho đế gi&agrave;y ).</span></span></span></strong></p>\r\n\r\n<p><strong><span style="font-size:large"><span style="font-family:book antiqua,palatino">------------------------------------------------------</span></span></strong></p>\r\n\r\n<p><strong><span style="font-size:large"><span style="font-family:book antiqua,palatino"><span style="color:#000000">Gi&aacute; Ch&iacute;nh H&atilde;ng: &euro;&nbsp;129,95 ( Khoảng 3.800.000 VND )</span></span></span></strong></p>\r\n\r\n<p><strong><span style="font-size:large"><span style="font-family:book antiqua,palatino"><span style="color:#000000">Tham Khảo&nbsp; www.cruyffclassics.com </span></span></span></strong></p>\r\n\r\n<p><strong><span style="font-size:large"><span style="font-family:book antiqua,palatino"><span style="color:#000000">Gi&aacute; Web X-Shop : 500.000 VND.</span></span></span></strong></p>\r\n\r\n<p><strong><span style="font-size:large"><span style="font-family:book antiqua,palatino">-------------------------------------------------------</span></span></strong></p>\r\n\r\n<p><strong><span style="font-size:large"><span style="font-family:book antiqua,palatino"><span style="color:#000000">* Ch&uacute;ng t&ocirc;i chỉ c&oacute; size như tr&ecirc;n website ngo&agrave;i ra kh&ocirc;ng c&oacute; size kh&aacute;c.</span></span></span></strong></p>\r\n', 'cruyff, johan cruyff,shoes,giay', '', '', '', 'Gi&agrave;y Cruyff Recopa Classics', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_discount`
--

CREATE TABLE IF NOT EXISTS `product_discount` (
  `product_discount_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`product_discount_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
  `product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color_id` int(11) NOT NULL,
  `title_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slide_status` int(1) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`product_image_id`, `product_id`, `image`, `color_id`, `title_image`, `description_image`, `slide_status`, `sort_order`) VALUES
(8, 2698, 'data/giay-hieu-size_-41.42.43-1.jpg', 1, 'Logo thương hiệu cruyff', '', 1, 3),
(7, 2698, 'data/giay-hieu-size_-41.42.43-0.jpg', 1, 'Mặt ch&eacute;o', '', 1, 2),
(6, 2698, 'data/giay-hieu-size_-41.42.43-0-new.jpg', 1, 'Mặt trước', 'Chất liệu da cực đẹp v&agrave; bền', 1, 1),
(9, 2698, 'data/giay-hieu-size_-41.42.43-3.jpg', 1, 'Nh&igrave;n tổng thể', '', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_option`
--

CREATE TABLE IF NOT EXISTS `product_option` (
  `product_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `color_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_option_description`
--

CREATE TABLE IF NOT EXISTS `product_option_description` (
  `product_option_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`product_option_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_option_value`
--

CREATE TABLE IF NOT EXISTS `product_option_value` (
  `product_option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `subtract` int(1) NOT NULL DEFAULT '0',
  `price` decimal(15,4) NOT NULL,
  `prefix` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(3) NOT NULL,
  `color_id` int(11) NOT NULL,
  PRIMARY KEY (`product_option_value_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_option_value_description`
--

CREATE TABLE IF NOT EXISTS `product_option_value_description` (
  `product_option_value_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`product_option_value_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_phukien`
--

CREATE TABLE IF NOT EXISTS `product_phukien` (
  `product_id` int(11) NOT NULL,
  `phukien_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`phukien_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_related`
--

CREATE TABLE IF NOT EXISTS `product_related` (
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`related_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_search_phanloai`
--

CREATE TABLE IF NOT EXISTS `product_search_phanloai` (
  `product_id` int(11) NOT NULL,
  `plid` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_special`
--

CREATE TABLE IF NOT EXISTS `product_special` (
  `product_special_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`product_special_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_to_category`
--

CREATE TABLE IF NOT EXISTS `product_to_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_to_category`
--

INSERT INTO `product_to_category` (`product_id`, `category_id`) VALUES
(2698, 453);

-- --------------------------------------------------------

--
-- Table structure for table `product_to_chome`
--

CREATE TABLE IF NOT EXISTS `product_to_chome` (
  `product_id` int(11) NOT NULL,
  `chome_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`chome_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_to_chome`
--

INSERT INTO `product_to_chome` (`product_id`, `chome_id`) VALUES
(2698, 13);

-- --------------------------------------------------------

--
-- Table structure for table `product_to_download`
--

CREATE TABLE IF NOT EXISTS `product_to_download` (
  `product_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_to_phanloai`
--

CREATE TABLE IF NOT EXISTS `product_to_phanloai` (
  `product_id` int(11) NOT NULL,
  `phanloai_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`phanloai_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_video`
--

CREATE TABLE IF NOT EXISTS `product_video` (
  `product_video_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`product_video_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `redirect_url`
--

CREATE TABLE IF NOT EXISTS `redirect_url` (
  `redirect_url_id` int(11) NOT NULL AUTO_INCREMENT,
  `url_goc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url_dich` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`redirect_url_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE IF NOT EXISTS `review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `author` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `rating` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`review_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `product_id`, `customer_id`, `author`, `text`, `rating`, `status`, `date_added`, `date_modified`) VALUES
(1, 2698, 0, 'Bodoicuho', 'Gi&agrave;y rất tốt\r\nCảm ơn shop rất nhiều :D', 5, 1, '2014-11-01 23:52:58', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=53798 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`setting_id`, `group`, `key`, `value`) VALUES
(21900, 'coupon', 'coupon_sort_order', '4'),
(21910, 'shipping', 'shipping_sort_order', '3'),
(21909, 'shipping', 'shipping_status', '1'),
(18569, 'cod', 'cod_sort_order', '1'),
(21912, 'sub_total', 'sub_total_sort_order', '1'),
(18568, 'cod', 'cod_status', '1'),
(18567, 'cod', 'cod_geo_zone_id', '0'),
(21899, 'coupon', 'coupon_status', '1'),
(21911, 'sub_total', 'sub_total_status', '1'),
(18566, 'cod', 'cod_order_status_id', '1'),
(21913, 'tax', 'tax_status', '1'),
(21914, 'tax', 'tax_sort_order', '5'),
(21916, 'total', 'total_sort_order', '6'),
(21915, 'total', 'total_status', '1'),
(53787, 'news', 'news_sort_order', '1'),
(53786, 'news', 'news_status', '0'),
(53785, 'news', 'news_position', 'left'),
(22316, 'google_base', 'google_base_status', '1'),
(21809, 'free', 'free_status', '1'),
(21808, 'free', 'free_geo_zone_id', '0'),
(21807, 'free', 'free_total', ''),
(22317, 'google_sitemap', 'google_sitemap_status', '1'),
(21810, 'free', 'free_sort_order', '1'),
(45715, 'category_news', 'category_news_status', '0'),
(53565, 'google_analytics', 'google_analytics_code', '&lt;script&gt;\r\n  (function(i,s,o,g,r,a,m){i[&#039;GoogleAnalyticsObject&#039;]=r;i[r]=i[r]||function(){\r\n  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\r\n  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\r\n  })(window,document,&#039;script&#039;,&#039;//www.google-analytics.com/analytics.js&#039;,&#039;ga&#039;);\r\n\r\n  ga(&#039;create&#039;, &#039;UA-43488629-1&#039;, &#039;xshophanoi.com&#039;);\r\n  ga(&#039;send&#039;, &#039;pageview&#039;);\r\n\r\n&lt;/script&gt;'),
(45714, 'category_news', 'category_news_position', 'left'),
(49726, 'header_banner', 'header_banner_status', '1'),
(51584, 'hotkeyword', 'hotkeyword_status', '1'),
(39166, 'google_talk', 'google_talk_status', '0'),
(39167, 'google_talk', 'google_talk_sort_order', '1'),
(39164, 'google_talk', 'google_talk_code', '&lt;iframe src=&quot;http://www.google.com/talk/service/badge/Show?tk=z01q6amlqmi3kv5vepf3oer5dn0c85vq4aegt67ndu6mb5smsdnjcj4kdfv51p4b8hj6c2gvv43d65i5qupp2577p9k7foi68nidnkfgop9rpoufnrnfh4ote5nktp9lsjcr1c5lfg6gaebekgje6ie7tcksuu8puqdfbsdfp13jsao8veankk7crk5mcb0s15ekpbfc2c3af5peg90cp043o2jea0unvl5ntinho35mpn47oslkge&amp;amp;w=300&amp;amp;h=18&quot; frameborder=&quot;0&quot; allowtransparency=&quot;true&quot; width=&quot;300&quot; height=&quot;18&quot;&gt;&lt;/iframe&gt;'),
(51583, 'hotkeyword', 'hotkeyword_code', '&lt;p&gt;iphone 4, iphone 4s, iphone 5&lt;/p&gt;\r\n'),
(39165, 'google_talk', 'google_talk_position', 'left'),
(48386, 'camketmuahang', 'camketmuahang_code', '&lt;p&gt;\r\n	&lt;span _fck_bookmark=&quot;1&quot; style=&quot;display: none;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/p&gt;\r\n&lt;div class=&quot;l2 bold orange big fLeft maxWidth&quot;&gt;\r\n	&lt;span style=&quot;font-size:12px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span style=&quot;color: rgb(255, 0, 0);&quot;&gt;&lt;strong&gt;Cam kết chung&lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;l2 bold orange big fLeft maxWidth&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;Gi&amp;aacute; lu&amp;ocirc;n lu&amp;ocirc;n rẻ nhất so với thị trường, cập nhật li&amp;ecirc;n tục h&amp;agrave;ng giờ.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;Dịch vụ c&amp;agrave;i đặt miễn ph&amp;iacute; 100% trong suốt qu&amp;aacute; tr&amp;igrave;nh sử dụng.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;Hệ thống cửa h&amp;agrave;ng trải rộng đến gần nh&amp;agrave; Qu&amp;yacute; kh&amp;aacute;ch h&amp;agrave;ng nhất.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:12px;&quot;&gt;&lt;strong style=&quot;color: rgb(255, 0, 0); font-family: &#039;times new roman&#039;, times, serif;&quot;&gt;H&amp;agrave;ng TechOne&lt;/strong&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;l2 bold orange big fLeft maxWidth&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;Cam kết ho&amp;agrave;n tiền 200% nếu m&amp;aacute;y b&amp;aacute;n ra l&amp;agrave; h&amp;agrave;ng Trung Quốc &amp;quot;nh&amp;aacute;i&amp;quot;.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;Cam kết H&amp;agrave;ng mới, nguồn gốc r&amp;otilde; r&amp;agrave;ng, đầy đủ linh kiện theo m&amp;aacute;y.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;Bảo h&amp;agrave;nh đ&amp;uacute;ng v&amp;agrave; đủ 12 th&amp;aacute;ng cho m&amp;aacute;y tại cửa h&amp;agrave;ng.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;Cho đổi lại m&amp;aacute;y mới trong 15 ng&amp;agrave;y nếu m&amp;aacute;y c&amp;oacute; lỗi phần cứng do nh&amp;agrave; SX.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:12px;&quot;&gt;&lt;strong style=&quot;font-family: &#039;times new roman&#039;, times, serif;&quot;&gt;&lt;span style=&quot;color: rgb(255, 0, 0);&quot;&gt;H&amp;agrave;ng C&amp;ocirc;ng ty&lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;H&amp;agrave;ng nhập khẩu ch&amp;iacute;nh h&amp;atilde;ng, nguồn gốc r&amp;otilde; r&amp;agrave;ng, bảo h&amp;agrave;nh ch&amp;iacute;nh h&amp;atilde;ng.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;M&amp;aacute;y trưng b&amp;agrave;y sẵn tại Showroom, Fullbox hộp tr&amp;ugrave;ng Imei m&amp;aacute;y.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;Cam k&amp;ecirc;́t gi&amp;aacute; thấp nhất. Gi&amp;aacute; đ&amp;atilde; bao gồm 10% thuế VAT. C&amp;oacute; ho&amp;aacute; đơn.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;div class=&quot;fLeft l12&quot;&gt;\r\n	&lt;span style=&quot;font-size:11px;&quot;&gt;&lt;span style=&quot;font-family:times new roman,times,serif;&quot;&gt;&lt;span class=&quot;bold orange big&quot;&gt;&amp;bull;&amp;nbsp;&lt;/span&gt;Cho đổi lại m&amp;aacute;y mới trong 24H kể từ khi mua nếu m&amp;aacute;y c&amp;oacute; lỗi do nh&amp;agrave; ph&amp;acirc;n phối.&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n&lt;p&gt;\r\n	&lt;span _fck_bookmark=&quot;1&quot; style=&quot;display: none;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/p&gt;\r\n'),
(48387, 'camketmuahang', 'camketmuahang_status', '1'),
(53165, 'khuyenmai', 'khuyenmai_status', '1'),
(53792, 'lienket', 'lienket_position', 'left'),
(53793, 'lienket', 'lienket_status', '1'),
(53711, 'popup', 'popup_code', '&lt;p&gt;&lt;a href=&quot;http://xshop.local/image/data/brand_cruyff.jpg&quot;&gt;&lt;img alt=&quot;Chuy&ecirc;n gi&agrave;y xuất khẩu&quot; src=&quot;http://xshop.local/image/data/brand_cruyff.jpg&quot; style=&quot;height:200px; width:784px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:36px&quot;&gt;X-SHOP chuy&amp;ecirc;n giầy xuất khẩu&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;h2&gt;Cam đoan h&amp;agrave;ng xịn 100%&lt;/h2&gt;\r\n\r\n&lt;h2&gt;Địa chỉ 465 Đội cấn - Ba Đ&amp;igrave;nh - H&amp;agrave; Nội&lt;/h2&gt;\r\n\r\n&lt;p&gt;fanpage:&lt;a href=&quot;http://facebook.com/xshophanoi&quot;&gt;http://facebook.com/xshophanoi&lt;/a&gt;&lt;/p&gt;\r\n'),
(53791, 'lienket', 'lienket_code', '&lt;h3&gt;&lt;strong&gt;C&amp;aacute;c h&amp;atilde;ng gi&amp;agrave;y của shop&lt;/strong&gt;&lt;/h3&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;color:#FF0000&quot;&gt;&lt;strong&gt;PME Legend&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://shop.pme-legend.com/pme-legend-collection/shoes.html&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;Gi&agrave;y PME Legend&quot; src=&quot;http://justbrands.scene7.com/is/image/JustBrands/Templatelisterouterglow1?$JB220JPEG$&amp;amp;$layer_2_src=JustBrands/empty1&amp;amp;$layer_1_src=JustBrands/PBO45036&amp;amp;defaultImage=no_image&quot; style=&quot;height:240px; width:220px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;color:#FF0000&quot;&gt;&lt;strong&gt;Cruyff Classic&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/giay-hieu-size_-41.42.43-3.jpg&quot; style=&quot;height:146px; width:223px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;color:#FF0000&quot;&gt;&lt;strong&gt;Gaastra Trainers&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://xshop.local/image/data/gaastra-trainers-garboard-kids-navy-2.jpg&quot; style=&quot;height:226px; width:226px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;color:#FF0000&quot;&gt;&lt;strong&gt;Lacoste&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://www.lacoste.com/us/lacoste/men/shoes/&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;Gi&agrave;y Lacoste&quot; src=&quot;http://imagena2.lacoste.com/dw/image/v2/AAUP_PRD/on/demandware.static/Sites-FlagShip-Site/Sites-master/en_US/v1414687627377/11_28SPM0045_2E9_01.jpg?sw=358&amp;amp;sh=495&quot; style=&quot;height:240px; width:220px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n'),
(53164, 'khuyenmai', 'khuyenmai_code', '&lt;p&gt;Coming soon&lt;/p&gt;\r\n'),
(53712, 'popup', 'popup_status', '0'),
(53566, 'google_analytics', 'google_analytics_status', '1'),
(53784, 'config', 'config_error_filename', 'error.txt'),
(53783, 'config', 'config_error_log', '0'),
(53782, 'config', 'config_error_display', '1'),
(53163, 'header', 'header_status', '1'),
(53781, 'config', 'config_compression', '4'),
(53780, 'config', 'config_seo_url', '1'),
(53779, 'config', 'config_encryption', 'zxcv'),
(53778, 'config', 'config_ssl', '0'),
(53777, 'config', 'config_smtp_timeout', '5'),
(53776, 'config', 'config_smtp_port', '465'),
(53775, 'config', 'config_smtp_password', '20082049'),
(53774, 'config', 'config_smtp_username', 'netstea@gmail.com'),
(53773, 'config', 'config_smtp_host', 'smtp.gmail.com'),
(53772, 'config', 'config_mail_protocol', 'smtp'),
(53771, 'config', 'config_image_cart_height', '75'),
(53770, 'config', 'config_image_cart_width', '75'),
(53769, 'config', 'config_image_related_height', '150'),
(53768, 'config', 'config_image_related_width', '150'),
(53767, 'config', 'config_image_additional_height', '600'),
(53763, 'config', 'config_image_category_height', '25'),
(53764, 'config', 'config_image_product_width', '150'),
(53765, 'config', 'config_image_product_height', '150'),
(53766, 'config', 'config_image_additional_width', '600'),
(53759, 'config', 'config_image_thumb_height', '300'),
(53760, 'config', 'config_image_popup_width', '600'),
(53761, 'config', 'config_image_popup_height', '600'),
(53762, 'config', 'config_image_category_width', '25'),
(53757, 'config', 'config_link_banner_footer', 'http://xshophanoi.com'),
(53758, 'config', 'config_image_thumb_width', '300'),
(53756, 'config', 'config_banner_footer', 'data/t317n_4701.jpg.png'),
(53755, 'config', 'config_logofooter', 'data/t317n_4701.jpg.png'),
(53754, 'config', 'config_icon', 'data/t317n_4701.jpg.png'),
(53753, 'config', 'config_logo', 'data/t317n_4701.jpg.png'),
(53752, 'config', 'config_download_status', '5'),
(53751, 'config', 'config_download', '1'),
(53750, 'config', 'config_order_status_id', '1'),
(53749, 'config', 'config_stock_subtract', '0'),
(53748, 'config', 'config_stock_checkout', '1'),
(53747, 'config', 'config_stock_check', '1'),
(53746, 'config', 'config_stock_display', '0'),
(53745, 'config', 'config_checkout', '0'),
(53744, 'config', 'config_account', '0'),
(53743, 'config', 'config_guest_checkout', '1'),
(53742, 'config', 'config_customer_approval', '0'),
(53741, 'config', 'config_customer_price', '0'),
(53739, 'config', 'config_alert_mail', '0'),
(53740, 'config', 'config_customer_group_id', '8'),
(53738, 'config', 'config_weight_class_id', '1'),
(53737, 'config', 'config_measurement_class_id', '1'),
(53736, 'config', 'config_tax', '1'),
(53735, 'config', 'config_currency_auto', '1'),
(53734, 'config', 'config_currency', 'VND'),
(53723, 'config', 'config_welcome_5', '&lt;p&gt;&lt;span style=&quot;color:#f00&quot;&gt;&lt;span style=&quot;font-size:24px&quot;&gt;&lt;em&gt;&lt;strong&gt;GI&amp;Agrave;Y XUẤT KHẨU X-SHOP&lt;/strong&gt;&lt;/em&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;&lt;em&gt;- Địa chỉ: 465&lt;/em&gt;&lt;/span&gt;&lt;/span&gt; Đội Cấn - Ba Đ&amp;igrave;nh - H&amp;agrave; Nội&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;&lt;em&gt;- Điện thoại : 0977946017&lt;/em&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;&lt;em&gt;- Email : support@xshophanoi.com &amp;nbsp; &amp;nbsp; - &amp;nbsp; &amp;nbsp; netstea@gmail.com&lt;/em&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;&lt;em&gt;- Website : www.xshophanoi.com&lt;/em&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n'),
(53733, 'config', 'config_admin_language', 'vn'),
(53732, 'config', 'config_language', 'vn'),
(53731, 'config', 'config_zone_code', 'HI'),
(53730, 'config', 'config_country_id', '230'),
(53729, 'config', 'config_special', '52'),
(53728, 'config', 'config_related', '8'),
(53727, 'config', 'config_search', '52'),
(53726, 'config', 'config_manufacturer', '8'),
(53725, 'config', 'config_category', '52'),
(53724, 'config', 'config_lienhe_5', '&lt;p&gt;&lt;span style=&quot;color:#f00&quot;&gt;&lt;span style=&quot;font-size:24px&quot;&gt;&lt;em&gt;&lt;strong&gt;GI&amp;Agrave;Y XUẤT KHẨU X-SHOP&lt;/strong&gt;&lt;/em&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;&lt;em&gt;- Địa chỉ: 465&lt;/em&gt;&lt;/span&gt;&lt;/span&gt; Đội Cấn - Ba Đ&amp;igrave;nh - H&amp;agrave; Nội&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;&lt;em&gt;- Điện thoại : 0977946017&lt;/em&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;&lt;em&gt;- Email : support@xshophanoi.com &amp;nbsp; &amp;nbsp; - &amp;nbsp; &amp;nbsp; netstea@gmail.com&lt;/em&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;&lt;em&gt;- Website : www.xshophanoi.com&lt;/em&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n'),
(53796, 'khuyenmaihotro', 'khuyenmaihotro_code', '&lt;p&gt;&lt;strong&gt;Hỗ trợ mua h&amp;agrave;ng&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;- Miễn ph&amp;iacute; vẫn chuyển trong phạm vi b&amp;aacute;n k&amp;iacute;nh 3km&lt;/p&gt;\r\n\r\n&lt;p&gt;- Giảm 5% cho đơn h&amp;agrave;ng lần 2 hoặc được giới thiệu&lt;/p&gt;\r\n'),
(53797, 'khuyenmaihotro', 'khuyenmaihotro_status', '1'),
(53795, 'khuyenmaihotro', 'khuyenmaihotro_title', 'Mua gi&agrave;y, d&acirc;y lưng, v&iacute; da tại X-Shop c&aacute;c bạn sẽ được hỗ trợ:'),
(50364, 'icon_share', 'icon_share_code', '&lt;p&gt;\r\n	&lt;img alt=&quot;&quot; height=&quot;30&quot; src=&quot;http://techone.vn/image/data/icon forum.jpg&quot; width=&quot;30&quot; /&gt;&lt;a href=&quot;https://www.facebook.com/TechOneVN&quot;&gt;&lt;img alt=&quot;&quot; height=&quot;30&quot; src=&quot;http://techone.vn/image/data/facebook.jpg&quot; width=&quot;30&quot; /&gt;&lt;/a&gt;&lt;img alt=&quot;&quot; height=&quot;30&quot; src=&quot;http://techone.vn/image/data/twitter.jpg&quot; width=&quot;30&quot; /&gt;&lt;a href=&quot;https://www.youtube.com/techonevn&quot;&gt;&lt;img alt=&quot;&quot; height=&quot;30&quot; src=&quot;http://techone.vn/image/data/youtube.jpg&quot; width=&quot;30&quot; /&gt;&lt;/a&gt;&lt;img alt=&quot;&quot; height=&quot;30&quot; id=&quot;bttop&quot; src=&quot;http://techone.vn/catalog/view/theme/default/image/backtop.jpg&quot; width=&quot;30&quot; /&gt;&lt;/p&gt;\r\n'),
(50365, 'icon_share', 'icon_share_status', '1'),
(53162, 'header', 'header_code', '&lt;p&gt;&lt;span style=&quot;background-color:#000&quot;&gt;&lt;span style=&quot;color:rgb(255, 255, 255)&quot;&gt;&lt;span style=&quot;font-size:16px&quot;&gt;&lt;span style=&quot;color:#f00&quot;&gt;Hotline&amp;nbsp; 0977946017&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n'),
(50934, 'background', 'background_status', '1'),
(49725, 'header_banner', 'banner_bottom_2_href', 'http://www.techone.vn/san-pham/8/iphone-4-16gb-den-95-98.html'),
(53788, 'footer', 'footer_title', 'Đặt h&agrave;ng ngay h&ocirc;m nay'),
(53789, 'footer', 'footer_code', '&lt;p&gt;&lt;strong&gt;Tư vấn trực tiếp&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;color:#FF0000&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;strong&gt;0977946017&lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;465 Đội Cấn - Ba Đ&amp;igrave;nh - H&amp;agrave; Nội&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#FF0000&quot;&gt;&amp;nbsp; &lt;/span&gt;&lt;/span&gt;&lt;a href=&quot;http://facebook.com/xshophanoi.com&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.techone.vn/image/upload/data/baner/banner/facebook.jpg&quot; style=&quot;color:rgb(255, 0, 0); font-size:14px; height:30px; opacity:0.9; width:30px&quot; /&gt;&lt;/a&gt;&amp;nbsp;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#FF0000&quot;&gt;&lt;a href=&quot;http://youtube.com/xshophanoi&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.techone.vn/image/upload/data/baner/banner/youtube.jpg&quot; style=&quot;height:30px; width:30px&quot; /&gt;&amp;nbsp;&lt;/a&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n'),
(53790, 'footer', 'footer_status', '1'),
(51597, 'support', 'support_status', '1'),
(51596, 'support', 'support_position', 'left'),
(49724, 'header_banner', 'banner_bottom_2_image', 'data/02/baner 2.jpg'),
(49723, 'header_banner', 'banner_bottom_1_href', ''),
(50902, 'bannergocphai', 'bannergocphai_status', '1'),
(50901, 'bannergocphai', 'bannergocphai_code', '&lt;p&gt;\r\n	&lt;img alt=&quot;&quot; height=&quot;126&quot; src=&quot;http://www.techone.vn/image/data/0000/banner-corner.jpg&quot; width=&quot;393&quot; /&gt;&lt;/p&gt;\r\n'),
(50900, 'bannergocphai', 'bannergocphai_title', 'Th&ocirc;ng tin khuyến mại'),
(45716, 'category_news', 'category_news_sort_order', '1'),
(50932, 'background', 'config_backgroundheader_color', ''),
(50933, 'background', 'config_backgroundheader_repeat', ''),
(50931, 'background', 'config_backgroundheader_image', ''),
(50928, 'background', 'banner_left_href', '#'),
(50929, 'background', 'banner_right_href', 'http://www.techone.vn/san-pham/371/golden-one/'),
(50930, 'background', 'config_background_container_color', ''),
(50927, 'background', 'config_background_position', 'top center'),
(50926, 'background', 'config_background_attachment', 'fixed'),
(50925, 'background', 'config_background_repeat', 'no-repeat'),
(50924, 'background', 'config_background_color', ''),
(50923, 'background', 'config_background_image', 'data/bg-techone2.png'),
(49722, 'header_banner', 'banner_bottom_1_image', 'data/DN VA DU AN.jpg'),
(49721, 'header_banner', 'banner_right_2_href', 'http://www.techone.vn/san-pham/1639/lenovo-a390-2-sim-2-song.html'),
(49720, 'header_banner', 'banner_right_2_image', 'data/lenovo-a390.jpg'),
(49719, 'header_banner', 'banner_right_1_href', 'http://www.techone.vn/thong-tin/34/huong-dan-mua-tra-gop.html'),
(49718, 'header_banner', 'banner_right_1_image', 'data/banhangtragop.jpg'),
(48385, 'camketmuahang', 'camketmuahang_title', 'Bạn được g&igrave; khi mua h&agrave;ng tại TechOne?'),
(51595, 'support', 'support_code', ''),
(51598, 'support', 'support_sort_order', '2'),
(53794, 'lienket', 'lienket_sort_order', '77'),
(53722, 'config', 'config_template', 'default'),
(53721, 'config', 'config_fax', ''),
(53720, 'config', 'config_telephone', '0977946017'),
(53719, 'config', 'config_hotline', '0977946017'),
(53718, 'config', 'config_email', 'support@xshophanoi.com'),
(53717, 'config', 'config_address', '465 Đội Cấn - Ba Đ&igrave;nh - H&agrave; Nội'),
(53716, 'config', 'config_owner', 'X-Shop'),
(53713, 'config', 'config_store', 'X-Shop'),
(53714, 'config', 'config_title', 'Gi&agrave;y xuất kh&acirc;u ch&iacute;nh h&atilde;ng'),
(53715, 'config', 'config_meta_description', 'Cửa h&agrave;ng gi&agrave;y X-Shop\r\n465 Đội Cấn - Ba Đ&igrave;nh -  H&agrave; Nội\r\nChuy&ecirc;n gi&agrave;y thể thao xuất khẩu, ch&iacute;nh h&atilde;ng 100%');

-- --------------------------------------------------------

--
-- Table structure for table `showroom`
--

CREATE TABLE IF NOT EXISTS `showroom` (
  `showroom_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hotline` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `zone_id` int(11) NOT NULL DEFAULT '0',
  `google_maps` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`showroom_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `slideshow`
--

CREATE TABLE IF NOT EXISTS `slideshow` (
  `slideshow_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL,
  `sshow` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`slideshow_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `slideshow`
--

INSERT INTO `slideshow` (`slideshow_id`, `sort_order`, `sshow`, `image`, `link`) VALUES
(1, 1, 'tlh', 'data/giay-hieu-size_-41.42.43-3.jpg', '/cruyff-recopa-classics-2698.html'),
(2, 0, 'trh1', 'data/gaastra-trainers-garboard-kids-navy-1.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `slideshow_description`
--

CREATE TABLE IF NOT EXISTS `slideshow_description` (
  `slideshow_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`slideshow_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slideshow_description`
--

INSERT INTO `slideshow_description` (`slideshow_id`, `language_id`, `name`) VALUES
(1, 5, 'Gi&agrave;y Cruyff'),
(2, 5, 'Gi&agrave;y GAASTAR');

-- --------------------------------------------------------

--
-- Table structure for table `stock_status`
--

CREATE TABLE IF NOT EXISTS `stock_status` (
  `stock_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`stock_status_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `stock_status`
--

INSERT INTO `stock_status` (`stock_status_id`, `language_id`, `name`) VALUES
(1, 5, 'C&ograve;n h&agrave;ng'),
(2, 5, 'Hết h&agrave;ng'),
(3, 5, 'Sắp c&oacute; h&agrave;ng');

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE IF NOT EXISTS `support` (
  `support_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL,
  `csupport_id` int(11) NOT NULL,
  PRIMARY KEY (`support_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `support_description`
--

CREATE TABLE IF NOT EXISTS `support_description` (
  `support_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `yahoo_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `skype_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`support_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_class`
--

CREATE TABLE IF NOT EXISTS `tax_class` (
  `tax_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tax_class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rate`
--

CREATE TABLE IF NOT EXISTS `tax_rate` (
  `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `geo_zone_id` int(11) NOT NULL DEFAULT '0',
  `tax_class_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `rate` decimal(7,4) NOT NULL DEFAULT '0.0000',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tax_rate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=102 ;

--
-- Dumping data for table `tax_rate`
--

INSERT INTO `tax_rate` (`tax_rate_id`, `geo_zone_id`, `tax_class_id`, `priority`, `rate`, `description`, `date_modified`, `date_added`) VALUES
(100, 5, 10, 5000, 0.0000, 'VAT 2.5%', '0000-00-00 00:00:00', '2014-02-25 08:56:19'),
(101, 5, 9, 1, 0.0000, 'Gi&aacute; đ&atilde; bao gồm 10% VAT', '0000-00-00 00:00:00', '2014-03-13 08:56:19'),
(96, 5, 11, 3, 0.0000, 'Gi&aacute; chưa c&oacute; VAT', '0000-00-00 00:00:00', '2013-06-06 08:49:44');

-- --------------------------------------------------------

--
-- Table structure for table `url_alias`
--

CREATE TABLE IF NOT EXISTS `url_alias` (
  `url_alias_id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`url_alias_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `firstname` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastname` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(96) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` int(1) NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_group_id`, `username`, `password`, `firstname`, `lastname`, `email`, `status`, `ip`, `date_added`) VALUES
(20, 1, 'netsstea', '0e32f4c96203f8922bbe66be973c3ed6', 'admin', 'admin', 'admin', 1, '127.0.0.1', '2011-09-11 14:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `permission` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`user_group_id`, `name`, `permission`) VALUES
(1, 'Top Administrator', 'a:2:{s:6:"access";a:104:{i:0;s:17:"catalog/attribute";i:1;s:25:"catalog/attribute_display";i:2;s:23:"catalog/attribute_group";i:3;s:16:"catalog/category";i:4;s:13:"catalog/chome";i:5;s:20:"catalog/cinformation";i:6;s:13:"catalog/color";i:7;s:16:"catalog/csupport";i:8;s:16:"catalog/download";i:9;s:19:"catalog/information";i:10;s:20:"catalog/manufacturer";i:11;s:16:"catalog/phanloai";i:12;s:15:"catalog/product";i:13;s:20:"catalog/redirect_url";i:14;s:14:"catalog/review";i:15;s:16:"catalog/showroom";i:16;s:17:"catalog/slideshow";i:17;s:15:"catalog/support";i:18;s:13:"common/upload";i:19;s:14:"extension/feed";i:20;s:16:"extension/module";i:21;s:17:"extension/payment";i:22;s:18:"extension/shipping";i:23;s:15:"extension/total";i:24;s:16:"feed/google_base";i:25;s:19:"feed/google_sitemap";i:26;s:20:"localisation/country";i:27;s:21:"localisation/currency";i:28;s:21:"localisation/geo_zone";i:29;s:21:"localisation/language";i:30;s:30:"localisation/measurement_class";i:31;s:25:"localisation/order_status";i:32;s:25:"localisation/stock_status";i:33;s:22:"localisation/tax_class";i:34;s:25:"localisation/weight_class";i:35;s:17:"localisation/zone";i:36;s:17:"module/bestseller";i:37;s:15:"module/category";i:38;s:12:"module/cnews";i:39;s:13:"module/footer";i:40;s:23:"module/google_analytics";i:41;s:13:"module/header";i:42;s:17:"module/hotkeyword";i:43;s:18:"module/information";i:44;s:16:"module/khuyenmai";i:45;s:21:"module/khuyenmaihotro";i:46;s:14:"module/lienket";i:47;s:19:"module/manufacturer";i:48;s:11:"module/news";i:49;s:12:"module/popup";i:50;s:14:"module/support";i:51;s:10:"news/cnews";i:52;s:9:"news/news";i:53;s:16:"payment/alertpay";i:54;s:24:"payment/authorizenet_aim";i:55;s:21:"payment/bank_transfer";i:56;s:14:"payment/cheque";i:57;s:11:"payment/cod";i:58;s:14:"payment/liqpay";i:59;s:20:"payment/moneybookers";i:60;s:17:"payment/nganluong";i:61;s:15:"payment/paymate";i:62;s:16:"payment/paypoint";i:63;s:26:"payment/perpetual_payments";i:64;s:14:"payment/pp_pro";i:65;s:17:"payment/pp_pro_uk";i:66;s:19:"payment/pp_standard";i:67;s:15:"payment/sagepay";i:68;s:22:"payment/sagepay_direct";i:69;s:18:"payment/sagepay_us";i:70;s:19:"payment/twocheckout";i:71;s:16:"payment/worldpay";i:72;s:16:"report/purchased";i:73;s:11:"report/sale";i:74;s:13:"report/viewed";i:75;s:12:"sale/contact";i:76;s:11:"sale/coupon";i:77;s:13:"sale/customer";i:78;s:19:"sale/customer_group";i:79;s:15:"sale/newsletter";i:80;s:10:"sale/order";i:81;s:15:"setting/setting";i:82;s:16:"shipping/auspost";i:83;s:17:"shipping/citylink";i:84;s:13:"shipping/flat";i:85;s:13:"shipping/free";i:86;s:13:"shipping/item";i:87;s:23:"shipping/parcelforce_48";i:88;s:19:"shipping/royal_mail";i:89;s:13:"shipping/usps";i:90;s:15:"shipping/weight";i:91;s:11:"tool/backup";i:92;s:14:"tool/error_log";i:93;s:12:"total/coupon";i:94;s:14:"total/handling";i:95;s:19:"total/low_order_fee";i:96;s:14:"total/shipping";i:97;s:15:"total/sub_total";i:98;s:9:"total/tax";i:99;s:11:"total/total";i:100;s:12:"user/history";i:101;s:9:"user/user";i:102;s:20:"user/user_permission";i:103;s:15:"module/category";}s:6:"modify";a:104:{i:0;s:17:"catalog/attribute";i:1;s:25:"catalog/attribute_display";i:2;s:23:"catalog/attribute_group";i:3;s:16:"catalog/category";i:4;s:13:"catalog/chome";i:5;s:20:"catalog/cinformation";i:6;s:13:"catalog/color";i:7;s:16:"catalog/csupport";i:8;s:16:"catalog/download";i:9;s:19:"catalog/information";i:10;s:20:"catalog/manufacturer";i:11;s:16:"catalog/phanloai";i:12;s:15:"catalog/product";i:13;s:20:"catalog/redirect_url";i:14;s:14:"catalog/review";i:15;s:16:"catalog/showroom";i:16;s:17:"catalog/slideshow";i:17;s:15:"catalog/support";i:18;s:13:"common/upload";i:19;s:14:"extension/feed";i:20;s:16:"extension/module";i:21;s:17:"extension/payment";i:22;s:18:"extension/shipping";i:23;s:15:"extension/total";i:24;s:16:"feed/google_base";i:25;s:19:"feed/google_sitemap";i:26;s:20:"localisation/country";i:27;s:21:"localisation/currency";i:28;s:21:"localisation/geo_zone";i:29;s:21:"localisation/language";i:30;s:30:"localisation/measurement_class";i:31;s:25:"localisation/order_status";i:32;s:25:"localisation/stock_status";i:33;s:22:"localisation/tax_class";i:34;s:25:"localisation/weight_class";i:35;s:17:"localisation/zone";i:36;s:17:"module/bestseller";i:37;s:15:"module/category";i:38;s:12:"module/cnews";i:39;s:13:"module/footer";i:40;s:23:"module/google_analytics";i:41;s:13:"module/header";i:42;s:17:"module/hotkeyword";i:43;s:18:"module/information";i:44;s:16:"module/khuyenmai";i:45;s:21:"module/khuyenmaihotro";i:46;s:14:"module/lienket";i:47;s:19:"module/manufacturer";i:48;s:11:"module/news";i:49;s:12:"module/popup";i:50;s:14:"module/support";i:51;s:10:"news/cnews";i:52;s:9:"news/news";i:53;s:16:"payment/alertpay";i:54;s:24:"payment/authorizenet_aim";i:55;s:21:"payment/bank_transfer";i:56;s:14:"payment/cheque";i:57;s:11:"payment/cod";i:58;s:14:"payment/liqpay";i:59;s:20:"payment/moneybookers";i:60;s:17:"payment/nganluong";i:61;s:15:"payment/paymate";i:62;s:16:"payment/paypoint";i:63;s:26:"payment/perpetual_payments";i:64;s:14:"payment/pp_pro";i:65;s:17:"payment/pp_pro_uk";i:66;s:19:"payment/pp_standard";i:67;s:15:"payment/sagepay";i:68;s:22:"payment/sagepay_direct";i:69;s:18:"payment/sagepay_us";i:70;s:19:"payment/twocheckout";i:71;s:16:"payment/worldpay";i:72;s:16:"report/purchased";i:73;s:11:"report/sale";i:74;s:13:"report/viewed";i:75;s:12:"sale/contact";i:76;s:11:"sale/coupon";i:77;s:13:"sale/customer";i:78;s:19:"sale/customer_group";i:79;s:15:"sale/newsletter";i:80;s:10:"sale/order";i:81;s:15:"setting/setting";i:82;s:16:"shipping/auspost";i:83;s:17:"shipping/citylink";i:84;s:13:"shipping/flat";i:85;s:13:"shipping/free";i:86;s:13:"shipping/item";i:87;s:23:"shipping/parcelforce_48";i:88;s:19:"shipping/royal_mail";i:89;s:13:"shipping/usps";i:90;s:15:"shipping/weight";i:91;s:11:"tool/backup";i:92;s:14:"tool/error_log";i:93;s:12:"total/coupon";i:94;s:14:"total/handling";i:95;s:19:"total/low_order_fee";i:96;s:14:"total/shipping";i:97;s:15:"total/sub_total";i:98;s:9:"total/tax";i:99;s:11:"total/total";i:100;s:12:"user/history";i:101;s:9:"user/user";i:102;s:20:"user/user_permission";i:103;s:15:"module/category";}}'),
(10, 'Demonstration', 'a:2:{s:6:"access";a:5:{i:0;s:15:"catalog/product";i:1;s:13:"common/upload";i:2;s:9:"news/news";i:3;s:9:"user/user";i:4;s:20:"user/user_permission";}s:6:"modify";a:5:{i:0;s:15:"catalog/product";i:1;s:13:"common/upload";i:2;s:15:"setting/setting";i:3;s:9:"user/user";i:4;s:20:"user/user_permission";}}');

-- --------------------------------------------------------

--
-- Table structure for table `weight_class`
--

CREATE TABLE IF NOT EXISTS `weight_class` (
  `weight_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`weight_class_id`,`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `weight_class`
--

INSERT INTO `weight_class` (`weight_class_id`, `language_id`, `title`, `unit`) VALUES
(1, 5, 'Kilograms', 'kg'),
(3, 5, 'Pounds', 'lb'),
(4, 5, 'Ounces', 'oz'),
(2, 5, 'Grams', 'g');

-- --------------------------------------------------------

--
-- Table structure for table `weight_rule`
--

CREATE TABLE IF NOT EXISTS `weight_rule` (
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `rule` decimal(15,4) NOT NULL DEFAULT '0.0000'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `weight_rule`
--

INSERT INTO `weight_rule` (`from_id`, `to_id`, `rule`) VALUES
(2, 4, 0.0353),
(1, 4, 35.2740),
(3, 1, 0.4536),
(3, 2, 453.5924),
(4, 3, 0.0625),
(4, 1, 0.0283),
(4, 2, 28.3495),
(1, 3, 2.2046),
(1, 2, 1000.0000),
(2, 3, 0.0022),
(2, 1, 0.0010),
(3, 4, 16.0000);

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE IF NOT EXISTS `zone` (
  `zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `showroom_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`zone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3981 ;

--
-- Dumping data for table `zone`
--

INSERT INTO `zone` (`zone_id`, `country_id`, `code`, `name`, `showroom_status`) VALUES
(3751, 230, 'AG', 'An Giang', 0),
(3752, 230, 'BG', 'Bắc Giang', 0),
(3753, 230, 'BK', 'Bắc Kạn', 0),
(3754, 230, 'BL', 'Bạc Li&ecirc;u', 0),
(3755, 230, 'BC', 'Bắc Ninh', 0),
(3756, 230, 'BR', 'B&agrave; Rịa - Vũng T&agrave;u', 0),
(3757, 230, 'BN', 'Bến Tre', 0),
(3758, 230, 'BH', 'B&igrave;nh Định', 0),
(3759, 230, 'BU', 'B&igrave;nh Dương', 0),
(3760, 230, 'BP', 'B&igrave;nh Phước', 0),
(3761, 230, 'BT', 'B&igrave;nh Thuận', 0),
(3762, 230, 'CM', 'C&agrave; Mau', 0),
(3763, 230, 'CT', 'Cần Thơ', 0),
(3764, 230, 'CB', 'Cao Bằng', 0),
(3765, 230, 'DL', 'Đắk Lắk', 0),
(3766, 230, 'DG', 'Đắk N&ocirc;ng', 0),
(3767, 230, 'DN', 'Đ&agrave; Nẵng', 0),
(3768, 230, 'DB', 'Điện Bi&ecirc;n', 0),
(3769, 230, 'DI', 'Đồng Nai', 0),
(3770, 230, 'DT', 'Đồng Th&aacute;p', 0),
(3771, 230, 'GL', 'Gia Lai', 0),
(3772, 230, 'HG', 'H&agrave; Giang', 0),
(3773, 230, 'HD', 'Hải Dương', 0),
(3774, 230, 'HP', 'Hải Ph&ograve;ng', 0),
(3775, 230, 'HM', 'H&agrave; Nam', 0),
(3776, 230, 'HI', 'H&agrave; Nội', 1),
(3949, 230, 'KH', 'Kh&aacute;nh H&ograve;a', 0),
(3778, 230, 'HH', 'H&agrave; Tĩnh', 0),
(3779, 230, 'HB', 'H&ograve;a B&igrave;nh', 0),
(3780, 230, 'HC', 'Hồ Ch&iacute; Minh', 1),
(3781, 230, 'HU', 'Hậu Giang', 0),
(3782, 230, 'HY', 'Hưng Y&ecirc;n', 0),
(3980, 230, 'YB', 'Y&ecirc;n B&aacute;i', 0),
(3979, 230, 'VP', 'Vĩnh Ph&uacute;c', 0),
(3978, 230, 'VL', 'Vĩnh Long', 0),
(3977, 230, 'TQ', 'Tuy&ecirc;n Quang', 0),
(3976, 230, 'TV', 'Tr&agrave; Vinh', 0),
(3975, 230, 'TG', 'Tiền Giang', 0),
(3974, 230, 'TT', 'Thừa Thi&ecirc;n - Huế', 0),
(3973, 230, 'TH', 'Thanh H&oacute;a', 0),
(3972, 230, 'TG', 'Th&aacute;i Nguy&ecirc;n', 0),
(3971, 230, 'TB', 'Th&aacute;i B&igrave;nh', 0),
(3970, 230, 'TN', 'T&acirc;y Ninh', 0),
(3969, 230, 'SL', 'Sơn La', 0),
(3968, 230, 'ST', 'S&oacute;c Trăng', 0),
(3967, 230, 'QT', 'Quảng Trị', 0),
(3966, 230, 'QH', 'Quảng Ninh', 0),
(3965, 230, 'QI', 'Quảng Ng&atilde;i', 0),
(3964, 230, 'QN', 'Quảng Nam', 0),
(3963, 230, 'QB', 'Quảng B&igrave;nh', 0),
(3962, 230, 'PY', 'Ph&uacute; Y&ecirc;n', 0),
(3961, 230, 'PT', 'Ph&uacute; Thọ', 0),
(3960, 230, 'NT', 'Ninh Thuận', 0),
(3959, 230, 'NB', 'Ninh B&igrave;nh', 0),
(3958, 230, 'NA', 'Nghệ An', 0),
(3957, 230, 'ND', 'Nam Định', 0),
(3956, 230, 'LA', 'Long An', 0),
(3955, 230, 'LD', 'L&acirc;m Đồng', 0),
(3954, 230, 'LS', 'Lạng Sơn', 0),
(3953, 230, 'LI', 'L&agrave;o Cai', 0),
(3952, 230, 'LC', 'Lai Ch&acirc;u', 0),
(3951, 230, 'KT', 'Kon Tum', 0),
(3950, 230, 'KG', 'Ki&ecirc;n Giang', 0);

-- --------------------------------------------------------

--
-- Table structure for table `zone_to_geo_zone`
--

CREATE TABLE IF NOT EXISTS `zone_to_geo_zone` (
  `zone_to_geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL DEFAULT '0',
  `geo_zone_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`zone_to_geo_zone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=52 ;

--
-- Dumping data for table `zone_to_geo_zone`
--

INSERT INTO `zone_to_geo_zone` (`zone_to_geo_zone_id`, `country_id`, `zone_id`, `geo_zone_id`, `date_added`, `date_modified`) VALUES
(8, 222, 0, 3, '2009-07-04 17:04:28', '0000-00-00 00:00:00'),
(15, 222, 0, 4, '2009-08-22 23:56:27', '0000-00-00 00:00:00'),
(51, 230, 0, 5, '2011-09-19 16:42:44', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
