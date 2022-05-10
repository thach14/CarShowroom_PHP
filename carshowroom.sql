-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 03, 2022 lúc 07:09 PM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `carshowroom`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `car`
--

CREATE TABLE `car` (
  `id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `make` varchar(20) NOT NULL,
  `model` varchar(20) NOT NULL,
  `year` int(4) NOT NULL,
  `seat` int(2) NOT NULL,
  `price` int(10) NOT NULL,
  `color` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Đang đổ dữ liệu cho bảng `car`
--

INSERT INTO `car` (`id`, `name`, `make`, `model`, `year`, `seat`, `price`, `color`, `status`) VALUES
(1, 'Yaris', 'Toyota', '1.5L Base', 2016, 4, 2995, 'red', 0),
(2, 'TUCSON', 'Hyundai', '2.0L Mid', 2014, 4, 3790, 'gray', 1),
(3, 'Sentra ', 'Nissan', '1.8L', 2013, 4, 2395, 'black', 1),
(4, 'GS8', 'GAC', '2.0L Full Option', 2018, 6, 6695, 'white', 1),
(5, 'SRX ', 'Cadillac', 'V6 Luxury', 2015, 5, 5795, 'light gold', 1),
(17, 'mazda 6', 'Mazda', '1.5L', 2006, 4, 2800, 'grey', 1),
(19, 'HIACE', 'Toyota', ' 2.7L Cargo', 2014, 15, 3200, 'white', 1),
(20, 'Corolla', 'Toyota', 'S', 2010, 4, 2700, 'black', 1),
(21, 'Silverado', 'Chevrolet', '1500 Work Truck', 2009, 2, 7000, 'black', 1),
(22, 'Elantra', 'Hyundai', 'Touring GLS ', 2012, 4, 4300, 'black', 1),
(23, 'Prius', 'Toyota', 'Three ', 2010, 4, 3800, 'Blue', 1),
(24, 'Jetta', 'Volkswagen', 'SE ', 2014, 4, 4200, 'grey', 1),
(25, 'Sentra', 'Nissan', ' ', 2012, 4, 2500, 'white', 1),
(26, 'Fusion', 'Ford', 'SE', 2015, 4, 5200, 'white', 1),
(27, ' Grand Caravan', 'Dodge', 'SE', 2013, 7, 7399, 'white', 1),
(28, 'Mustang Shelby', 'Ford', 'GT500', 2010, 2, 8250, 'black', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `id` int(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `first` varchar(20) NOT NULL,
  `last` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `tel` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`id`, `email`, `first`, `last`, `password`, `tel`) VALUES
(4, 'lechtue@gmail.com', 'Đình', 'Phúc', 'ce854f19a783c815c7bcabfac14e1531', 111111111);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `car` int(20) NOT NULL,
  `customer` int(20) NOT NULL,
  `date` date NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Đang đổ dữ liệu cho bảng `sales`
--

INSERT INTO `sales` (`id`, `car`, `customer`, `date`, `price`) VALUES
(11, 1, 4, '2022-01-03', 3295);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `first` varchar(20) NOT NULL,
  `last` varchar(20) NOT NULL,
  `tel` int(10) NOT NULL,
  `password` varchar(40) NOT NULL,
  `type` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Đang đổ dữ liệu cho bảng `staff`
--

INSERT INTO `staff` (`id`, `username`, `first`, `last`, `tel`, `password`, `type`) VALUES
(1, 'admin', 'Vu Dinh', 'Phuc', 1111111, 'afdd0b4ad2ec172c586e2150770fbf9e', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `testdrive`
--

CREATE TABLE `testdrive` (
  `id` int(20) NOT NULL,
  `customer` int(20) NOT NULL,
  `car` int(20) NOT NULL,
  `date` date NOT NULL,
  `time` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16le;

--
-- Đang đổ dữ liệu cho bảng `testdrive`
--

INSERT INTO `testdrive` (`id`, `customer`, `car`, `date`, `time`) VALUES
(19, 4, 28, '2022-01-05', 12);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `car` (`car`),
  ADD KEY `customer_S_F` (`customer`);

--
-- Chỉ mục cho bảng `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `testdrive`
--
ALTER TABLE `testdrive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer` (`customer`,`car`,`date`,`time`),
  ADD KEY `carF` (`car`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `car`
--
ALTER TABLE `car`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `testdrive`
--
ALTER TABLE `testdrive`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `car_S_F` FOREIGN KEY (`car`) REFERENCES `car` (`id`),
  ADD CONSTRAINT `customer_S_F` FOREIGN KEY (`customer`) REFERENCES `customer` (`id`);

--
-- Các ràng buộc cho bảng `testdrive`
--
ALTER TABLE `testdrive`
  ADD CONSTRAINT `carF` FOREIGN KEY (`car`) REFERENCES `car` (`id`),
  ADD CONSTRAINT `customerF` FOREIGN KEY (`customer`) REFERENCES `customer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
