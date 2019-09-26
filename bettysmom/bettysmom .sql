-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2019-09-25 07:50:14
-- 伺服器版本: 5.7.14
-- PHP 版本： 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `bettysmom`
--

-- --------------------------------------------------------

--
-- 資料表結構 `bill`
--

CREATE TABLE `bill` (
  `bill_id` int(20) NOT NULL,
  `date` date NOT NULL,
  `account` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phonenumber` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shipping` int(11) NOT NULL,
  `subprice` int(11) NOT NULL,
  `totalprice` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `billdetail`
--

CREATE TABLE `billdetail` (
  `billdetail_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `member_id` int(20) NOT NULL,
  `account` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phonenumber` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `member`
--

INSERT INTO `member` (`member_id`, `account`, `password`, `name`, `gender`, `phonenumber`, `email`, `birthday`, `address`) VALUES
(1, 'terry', '1234', 'tery', 'f', '0939123456', 'rrrrrwwwww@gmail.com', '2019-09-10', 'taichung'),
(2, 'hihibe', '0000', '王栗婷', 'f', '091234567', 'hihibe@gmail.com', '2019-09-09', '北區派出所'),
(15, 'littlebear', '00000', '小熊', 'm', '11001100', 'bear@gmail.com', '2019-09-07', '小熊溫暖的洞');

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `product_id` int(20) NOT NULL,
  `product_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `spec` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_price` int(20) NOT NULL,
  `product_pic` varchar(20) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `spec`, `product_price`, `product_pic`) VALUES
(1, '堅果塔', '盒裝8入', 320, 'p1.JPG'),
(2, '雪Q餅', '300g /包', 180, 'p2.JPG'),
(3, '土鳳梨酥', '盒裝10入', 350, 'p3.JPG'),
(4, '蛋黃酥', '盒裝10入', 380, 'p4.JPG'),
(5, '鮮奶吐司', '1條', 70, 'p5.JPG'),
(6, '葡萄乾吐司', '1條', 100, 'p6.JPG'),
(7, '核桃吐司', '1條', 120, 'p7.JPG'),
(8, '芋香吐司', '1條', 120, 'p8.JPG'),
(9, '抹茶戚風蛋糕', '8吋', 180, 'p9.JPG'),
(10, '乳酪戚風蛋糕', '8吋', 200, 'p10.JPG'),
(11, '莓果歐包', '1個', 40, 'p11.JPG'),
(12, '巧克歐包', '1個', 40, 'p12.JPG');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_id`);

--
-- 資料表索引 `billdetail`
--
ALTER TABLE `billdetail`
  ADD PRIMARY KEY (`billdetail_id`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- 使用資料表 AUTO_INCREMENT `billdetail`
--
ALTER TABLE `billdetail`
  MODIFY `billdetail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- 使用資料表 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
