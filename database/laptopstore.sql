-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 04, 2022 lúc 11:21 AM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `laptopstore`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `image` text COLLATE utf8_vietnamese_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `created_by`, `created_at`, `updated_at`) VALUES
(8, 'DELL', '1653968485dell.webp', 21, '2022-05-30 09:55:54', '2022-06-01 10:30:48'),
(9, 'ACER', '1653968513acer.webp', 21, '2022-05-31 10:41:53', '2022-05-31 10:41:53'),
(10, 'ASUS', '1653968528asus.webp', 21, '2022-05-31 10:42:08', '2022-05-31 10:42:08'),
(11, 'GIGABYTE', '1653968550gigabyte.webp', 21, '2022-05-31 10:42:30', '2022-05-31 10:42:30'),
(12, 'LENOVO', '1653968567lenovo.webp', 21, '2022-05-31 10:42:47', '2022-05-31 10:42:47'),
(13, 'MSI', '1653968577msi.webp', 21, '2022-05-31 10:42:57', '2022-05-31 10:42:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `capacity_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model` text COLLATE utf8_vietnamese_ci NOT NULL,
  `screen` text COLLATE utf8_vietnamese_ci NOT NULL,
  `RAM` text COLLATE utf8_vietnamese_ci NOT NULL,
  `hardware` text COLLATE utf8_vietnamese_ci NOT NULL,
  `OS` text COLLATE utf8_vietnamese_ci NOT NULL,
  `CPU` text COLLATE utf8_vietnamese_ci NOT NULL,
  `VGA` text COLLATE utf8_vietnamese_ci NOT NULL,
  `background` text COLLATE utf8_vietnamese_ci NOT NULL,
  `warranty` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `discount` float NOT NULL DEFAULT 0,
  `color` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `brand_id`, `model`, `screen`, `RAM`, `hardware`, `OS`, `CPU`, `VGA`, `background`, `warranty`, `discount`, `color`, `created_by`, `created_at`, `updated_at`) VALUES
(11, 10, 'Laptop gaming ASUS ROG Zephyrus Duo 16 GX650RW LO999W', '                                                                                                                                 16\" WQXGA (2560 x 1600) 16:10, 165Hz, 3ms, anti-glare display, DCI-P3:100%, Pantone Validated, FreeSync Premium Pro, Support Dolby Vision HDR, Mini LED, 1100 Nits, ROG Nebula HDR Display. \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                ', '32GB (16x2) DDR5 4800MHz (2x SO-DIMM socket, up to 64GB SDRAM)', '1TB M.2 NVMe™ PCIe® 4.0 Performance SSD (2 slots)', 'Windows 11 Home', 'AMD Ryzen 9 6900HX 3.3GHz up to 4.9GHz 16MB', '                                                                                                                                 NVIDIA® GeForce RTX™ 3070Ti 8GB GDDR6 With ROG Boost: 1460MHz* at 150W (1410MHz Boost Clock+50MHz OC, 125W + 25W Dynamic Boost) \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                \r\n                ', '1654074008test3.webp', 'Bảo hành chính hãng 12 tháng. ', 0, 'Black', 21, '2022-06-01 09:58:04', '2022-06-01 04:05:53'),
(12, 10, 'Laptop gaming ASUS ROG Zephyrus Duo 16 GX650RX LO156W', '                16\" WQXGA (2560 x 1600) 16:10, 165Hz, 3ms, anti-glare display, DCI-P3:100%, Pantone Validated, FreeSync Premium Pro, Support Dolby Vision HDR, Mini LED, 1100 Nits, ROG Nebula HDR Display.\r\n                ', '32GB (16x2) DDR5 4800MHz  (2x SO-DIMM socket, up to 64GB SDRAM)', '2TB M.2 NVMe™ PCIe® 4.0 Performance SSD (2 slots)', 'Windows 11 Home', 'AMD Ryzen 9 6900HX 3.3GHz up to 4.9GHz 16MB', '                NVIDIA® GeForce RTX™ 3080Ti 16GB GDDR6 With ROG Boost: 1445 MHz* at 165W (1395MHz Boost Clock+50MHz OC, 140W + 10W Dynamic Boost, 140W+25W Manual)\r\n                ', '1654074049test1.webp', 'Bảo hành chính hãng 24 tháng. ', 0, 'Black', 21, '2022-06-01 10:50:49', '2022-06-01 04:00:49'),
(13, 12, 'Laptop Lenovo IdeaPad Gaming 3 15ACH6 82K201BCVN', '15.6\" FHD (1920x1080) IPS 250nits Anti-glare, 120Hz, 45% NTSC, DC dimmer', '8GB (8x1) DDR4 3200MHz (2x SO-DIMM socket, up to 16GB SDRAM)', '256GB SSD M.2 2242 PCIe 3.0x4 NVMe', 'Windows 11 Home', 'AMD Ryzen 5 5600H 3.3GHz up to 4.2GHz 16MB', 'NVIDIA GeForce GTX 1650 4GB GDDR6                ', '1654074319test4.webp', 'Bảo hành chính hãng 24 tháng. ', 13, 'Shadow Black', 21, '2022-06-01 04:05:19', '2022-06-01 04:05:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_capacities`
--

CREATE TABLE `product_capacities` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `capacity_name` text COLLATE utf8_vietnamese_ci NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `product_capacities`
--

INSERT INTO `product_capacities` (`id`, `product_id`, `capacity_name`, `price`, `quantity`) VALUES
(3, 11, '32GB/SSD 1TB', 24500000, 1),
(4, 12, '32GB/2T SSD', 25000000, 4),
(5, 11, '16GB/SSD 500GB', 20000000, 5),
(6, 13, '8GB/ 256GB SSD', 16490000, 3),
(7, 13, '16GB/ 256GB SSD', 18000000, 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Chờ xác nhận'),
(2, 'Chờ shop xác nhận'),
(3, 'Shop đã xác nhận'),
(4, 'Shop đang chuẩn bị hàng'),
(5, 'Đơn vị đang vận chuyển'),
(6, 'Đang giao hàng'),
(7, 'Giao hàng thành công'),
(8, 'Trả hàng'),
(9, 'Shop xác nhận trả hàng'),
(10, 'Trả hàng thành công');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `account` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `phone_number` int(20) DEFAULT NULL,
  `address` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `avatar` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `role_id`, `account`, `password`, `name`, `phone_number`, `address`, `avatar`, `email`, `created_at`, `updated_at`) VALUES
(21, 2, 'admin', '25d55ad283aa400af464c76d713c07ad', 'tô văn tài', 973867269, 'Xóm 4, thôn Gia Lễ, xã Đông Mỹ, thành phố Thái Bình, tỉnh Thái Bình', '1653793675sexygirl.jpg', 'tovantaidz2001@gmail.com', '2022-05-29 10:06:46', '2022-06-04 11:14:33'),
(22, 1, 'account1', '827ccb0eea8a706c4c34a16891f84e7b', 'userTest', 9234723, 'xóm 4, thôn Gia lễ, xã Đông Mỹ, thành phố Thái Bình', '1653794119cuteness.jpg', 'tovantaidz2001@gmail.com', '2022-05-29 10:13:06', '2022-05-29 10:15:59'),
(23, 1, 'account2', '827ccb0eea8a706c4c34a16891f84e7b', 'account2', 28470234, '', '1653837972hotgirl.jpg', 'tovantaidz2001@gmail.com', '2022-05-29 10:25:32', '2022-05-29 10:26:12');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `capacity_id` (`capacity_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Chỉ mục cho bảng `product_capacities`
--
ALTER TABLE `product_capacities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `product_capacities`
--
ALTER TABLE `product_capacities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`capacity_id`) REFERENCES `product_capacities` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `product_capacities`
--
ALTER TABLE `product_capacities`
  ADD CONSTRAINT `product_capacities_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
