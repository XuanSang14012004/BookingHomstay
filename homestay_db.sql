-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 16, 2025 lúc 07:40 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `homestay_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nameHomestay` varchar(100) DEFAULT NULL,
  `typeRooms` varchar(100) DEFAULT NULL,
  `numberRooms` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `prices` decimal(12,2) DEFAULT NULL,
  `imgs` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `nameHomestay`, `typeRooms`, `numberRooms`, `status`, `prices`, `imgs`, `description`) VALUES
(1, 'khuA', '12s1', '5', 'trống', 3000.00, 'ddddddddddd', 'dddddddddddddddddddddd'),
(4, 'khuB', 'phòng đôi', '3', 'trống', 44000.00, 'ssss', 'ddddddddd'),
(9, 'khuB', 'đơn', '7', 'trống', 500000.00, '', 'đẹp tiện nghị'),
(10, 'khuB', 'đơn', '1', 'hết', 300000.00, '', 'đẹp tiện nghị cute'),
(11, 'khuB', 'đơn', '1', 'hết', 300000.00, '1758036638_1.jpg', 'đẹp tiện nghị cute');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `customerName` varchar(100) DEFAULT NULL,
  `customerEmail` varchar(100) DEFAULT NULL,
  `customerNumber` varchar(20) DEFAULT NULL,
  `homestayName` varchar(100) DEFAULT NULL,
  `bookingDate` date DEFAULT NULL,
  `bookingStatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking`
--

INSERT INTO `booking` (`id`, `customerName`, `customerEmail`, `customerNumber`, `homestayName`, `bookingDate`, `bookingStatus`) VALUES
(1, 'Nguyễn Xuân Sáng', 'nguyenxuansang@gmail.com', '09360055475', 'khuB', '2025-09-17', 'Chờ xác nhận'),
(2, 'Nguyễn Xuân Sáng', 'nguyenxuansang14012004@gmail.com', '0936005547', 'khuB', '2025-09-19', 'Đã xác nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `customerName` varchar(100) DEFAULT NULL,
  `bookingID` int(11) NOT NULL,
  `money` decimal(18,2) NOT NULL,
  `datesPayments` date NOT NULL,
  `method` varchar(50) DEFAULT NULL,
  `statusPayment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `customerName`, `bookingID`, `money`, `datesPayments`, `method`, `statusPayment`) VALUES
(1, 'Nguyễn Xuân Sáng', 2, 6000000.00, '2025-09-18', '0', 'Đã thanh toán'),
(2, 'Nguyễn Xuân Sáng', 1, 30000000.00, '2025-09-19', 'Tiền mặt', 'Đã thanh toán');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `custommerName` varchar(100) DEFAULT NULL,
  `homestayName` varchar(50) DEFAULT NULL,
  `reviews` text DEFAULT NULL,
  `dateReview` date DEFAULT NULL,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `review`
--

INSERT INTO `review` (`id`, `custommerName`, `homestayName`, `reviews`, `dateReview`, `feedback`) VALUES
(1, 'Nguyễn Xuân Sáng', 'khuB', 'đẹp ,sạch sẽ', '2025-09-04', 'cảm ơn bạn đã hài lòng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `prices` decimal(12,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `statusRooms` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `prices`, `quantity`, `statusRooms`) VALUES
(1, 'A101', 600000.00, 2, 'Còn trống'),
(2, 'A10', 600000.00, 3, 'Đã xác nhận'),
(3, 'a123', 300000.00, 3, 'Chờ xác nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `support`
--

CREATE TABLE `support` (
  `id` int(11) NOT NULL,
  `customerName` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `titel` varchar(256) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `dateSupport` date DEFAULT NULL,
  `statusSupport` varchar(50) DEFAULT NULL,
  `feedbacksp` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `support`
--

INSERT INTO `support` (`id`, `customerName`, `email`, `titel`, `content`, `dateSupport`, `statusSupport`, `feedbacksp`) VALUES
(1, 'Nguyễn Xuân Sáng', 'Abc@gmail.com', 'phòng hơi bẩn', 'Cần vệ sinh phòng sạch sẽ hơn, gối thủng', '2025-09-16', 'Đã phản hồi', 'mình sẽ cố gắng hoàn thiện ạ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role`) VALUES
(1, 'admin', '123456', 'Sang', 'ADmin'),
(5, 'admin1', '$2y$10$ZbjmBhptuYA.CTn554n/2eAuYJneBjgKzuCW8u4tH0HthbfWY7u6O', 'Nguyễn Xuân Sáng', ''),
(9, 'admin3', '$2y$10$lIEcht929tHIXal1xsFBWu1tGjM/nog4y1vxZzt/xPaetP6GOKzGe', 'sssss', 'Khách hàng'),
(10, 'nguensa', '123456', 'nguyen ssang', 'Admin');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_booking` (`bookingID`);

--
-- Chỉ mục cho bảng `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `support`
--
ALTER TABLE `support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_booking` FOREIGN KEY (`bookingID`) REFERENCES `booking` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
