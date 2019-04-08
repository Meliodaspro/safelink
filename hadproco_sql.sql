-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 15, 2017 lúc 08:05 AM
-- Phiên bản máy phục vụ: 10.1.24-MariaDB-cll-lve
-- Phiên bản PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `hadproco_sql`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `link`
--

CREATE TABLE `link` (
  `id` int(11) NOT NULL,
  `FBID` bigint(20) NOT NULL,
  `PostID` bigint(20) NOT NULL,
  `Hash` text NOT NULL,
  `Password` text NOT NULL,
  `Url` text NOT NULL,
  `SUrl` text NOT NULL,
  `Time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `link`
--

INSERT INTO `link` (`id`, `FBID`, `PostID`, `Hash`, `Password`, `Url`, `SUrl`, `Time`) VALUES
(1, 756974261179878, 0, 'fpsWlY2Eto', '53f7bd2f8314443b98b412b5301621a4', 'http://yeoutube.com', 'https://goo.gl/vcWmQQ', '2017-12-05 11:47:00'),
(2, 134927283949821, 136808133696425, '3qY3pS0jIl', '53f7bd2f8314443b98b412b5301621a4', 'http://youtube.com', 'https://goo.gl/4yb3ZJ', '2017-12-05 12:15:05'),
(3, 134927283949821, 137058940338011, '0CZUx0Tc6e', '53f7bd2f8314443b98b412b5301621a4', 'http://youtube.com', 'https://goo.gl/vHTWRz', '2017-12-06 12:10:29'),
(4, 134927283949821, 137087720335133, 'BOcWm4wpo0', 'd41d8cd98f00b204e9800998ecf8427e', 'http://hadpro.co', 'https://goo.gl/zPS5qS', '2017-12-06 14:30:01'),
(5, 101799750612078, 0, 'APBQLr5k0g', 'c4ca4238a0b923820dcc509a6f75849b', '1', 'https://goo.gl/J99ve7', '2017-12-10 07:15:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `manager`
--

CREATE TABLE `manager` (
  `id` int(11) NOT NULL,
  `fbid` bigint(20) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `manager`
--

INSERT INTO `manager` (`id`, `fbid`, `username`, `password`, `name`) VALUES
(1, 0, 'vynghia', 'nghiabestgay2k2', 'Vy Nghia');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `link`
--
ALTER TABLE `link`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `link`
--
ALTER TABLE `link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT cho bảng `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
