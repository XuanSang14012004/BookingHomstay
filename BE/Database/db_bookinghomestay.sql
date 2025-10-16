-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 13, 2025 lúc 04:44 PM
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
-- Cơ sở dữ liệu: `db_bookinghomestay`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `db_account`
--

CREATE TABLE `db_account` (
  `account_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','user','owner') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `db_account`
--

INSERT INTO `db_account` (`account_id`, `fullname`, `email`, `phone`, `password`, `role`, `created_at`) VALUES
(1, 'Cao Văn Quyết', 'NVA13@gmail.com', '0944724089', '12345', 'admin', '2025-10-08 01:44:56'),
(5, 'Cao Văn Quyết', 'user01@gmail.com', '5465612131', '12345', 'user', '2025-10-08 01:44:56'),
(7, 'Khúc Trường Giang', 'Truonggiang01@gmail.com', '0945781245', '123456', 'admin', '2025-10-01 05:02:34'),
(8, 'Khúc Trường Giang', 'truonggiang02@gmail.com', '0954721548', '012345', 'user', '2025-10-09 05:12:14'),
(9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '12345', 'user', '2025-10-11 18:22:42'),
(10, 'Nguyễn Xuân Sáng', '1234@gmail.com', '0328947360', '12345', 'user', '2025-10-11 18:51:12'),
(11, 'Nguyễn Xuân Sáng', 'xuansang@gmail.com', '093741874018', '12345', 'admin', '2025-10-13 11:19:51'),
(12, 'Nguyễn Xuân Sáng', 'nguyenxuansang@gmail.com', '0973026671', '12345', 'user', '2025-10-13 11:24:49'),
(13, 'Nguyễn Văn Hùng', 'hungnguyen@gmail.com', '0912738495', '12345', 'user', '2025-10-15 18:02:10'),
(14, 'Trịnh Quốc Thái', 'quocthai@gmail.com', '0973156824', '12345', 'user', '2025-10-15 18:35:44'),
(15, 'Hoàng Đức Anh', 'ducanh@gmail.com', '0947852146', '12345', 'user', '2025-10-15 19:12:30'),
(16, 'Vũ Thị Yến', 'yenvu@gmail.com', '0938541279', '12345', 'user', '2025-10-15 19:55:00'),
(17, 'Phạm Anh Tuấn', 'tuanpham@gmail.com', '0901245789', '12345', 'user', '2025-10-15 20:30:45'),
(18, 'Nguyễn Thị Hoa', 'hoanguyen@gmail.com', '0964785123', '12345', 'user', '2025-10-15 21:02:11'),
(19, 'Trần Văn Minh', 'minhtran@gmail.com', '0978456123', '12345', 'user', '2025-10-15 21:41:39'),
(20, 'Đặng Quỳnh Chi', 'quynhchi@gmail.com', '0958741256', '12345', 'user', '2025-10-15 22:10:58'),
(21, 'Phạm Quang Huy', 'huypham@gmail.com', '0978412365', '12345', 'user', '2025-10-16 12:10:00'),
(22, 'Nguyễn Thị Mai', 'mainguyen@gmail.com', '0912347896', '12345', 'user', '2025-10-16 12:20:00'),
(23, 'Trần Đức Anh', 'ducanh@gmail.com', '0987412563', '12345', 'user', '2025-10-16 12:25:00'),
(24, 'Lê Thị Thu', 'thule@gmail.com', '0957841236', '12345', 'user', '2025-10-16 12:30:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `db_admin`
--

CREATE TABLE `db_admin` (
  `admin_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `db_admin`
--

INSERT INTO `db_admin` (`admin_id`, `account_id`, `image`, `fullname`, `birthday`, `gender`, `email`, `phone`, `address`) VALUES
(1, 1, 'user.jpg', 'Cao Văn Quyết', '2004-03-01', 'Nam', 'cvquyet0103@gmail.com', '0944724089', 'Nam Định'),
(2, 7, 'doctor2.jpg\r\n', 'Khúc Trường Giang', '2004-02-15', 'Nam', 'truonggiang01@gmail.com', '0945124875', 'Long biên'),
(6, 7, 'user.jpg', 'Nguyễn Xuân Sáng', '2004-01-01', 'Nam', 'xuansang@gmail.com', '093741874018', 'Nghệ An');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `db_booking`
--

CREATE TABLE `db_booking` (
  `booking_id` int(11) NOT NULL,
  `homestay_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `guests` int(11) DEFAULT 1,
  `payment_method` varchar(50) NOT NULL,
  `total_price` decimal(12,0) NOT NULL DEFAULT 0,
  `payment_date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `status` enum('Đã hủy','Đã xác nhận','Chờ xác nhận') NOT NULL DEFAULT 'Chờ xác nhận',
  `payment_status` enum('Đã thanh toán','Đã đặt cọc','Chờ thanh toán') NOT NULL DEFAULT 'Chờ thanh toán',
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `db_booking`
--

INSERT INTO `db_booking` (`booking_id`, `homestay_id`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `created_at`, `checkin_date`, `checkout_date`, `guests`, `payment_method`, `total_price`, `payment_date`, `status`, `payment_status`, `note`) VALUES
(10, 7, 1, 'Khúc Trường Giang', 'truonggiang02@gmail.com', '0948174672', '2025-09-26 02:50:27', '2025-10-03', '2025-10-05', 4, 'Momo', 1500000, '2025-10-11 20:43:00', 'Đã xác nhận', 'Đã thanh toán', 'tôi muốn có xe đưa đón'),
(13, 16, 5, 'Cao Văn Quyết', 'user01@gmail.com', '0945127846', '2025-10-02 01:25:00', '2025-10-03', '2025-10-05', 5, 'Đặt cọc', 1752000, '2025-10-13 12:22:12', 'Đã xác nhận', 'Đã thanh toán', 'Yêu cầu phòng tầng cao, view đẹp.'),
(14, 1, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-10-11 13:26:32', '2025-10-12', '2025-10-13', 8, 'Thanh toán khi trả phòng', 910000, '2025-10-11 21:42:00', 'Đã xác nhận', 'Đã thanh toán', 'Yêu cầu phòng tầng cao, view đẹp.'),
(16, 1, 5, 'Cao Văn Quyết', 'user01@gmail.com', '0973026671', '2025-10-11 13:44:39', '2025-10-19', '2025-10-20', 1, 'Thanh toán khi trả phòng', 910000, '2025-10-11 21:44:00', 'Đã xác nhận', 'Đã thanh toán', 'Tôi muốn có xe đưa đón'),
(17, 17, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-10-12 01:39:32', '2025-10-12', '2025-10-13', 1, 'VNPay', 1120000, '2025-10-11 20:43:00', 'Đã xác nhận', 'Đã thanh toán', 'Yêu cầu phòng tầng cao, view đẹp.'),
(18, 1, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-10-12 11:26:11', '2025-10-12', '2025-10-13', 1, 'Thanh toán khi trả phòng', 910000, '2025-10-11 17:36:00', 'Đã xác nhận', 'Đã thanh toán', 'Tôi muốn có xe đưa đón'),
(19, 1, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-10-12 12:52:26', '2025-10-19', '2025-10-20', 1, 'Thanh toán khi trả phòng', 910000, '2025-10-13 08:07:00', 'Đã xác nhận', 'Đã thanh toán', 'Yêu cầu phòng tầng cao, view đẹp.'),
(20, 1, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-10-12 13:04:33', '2025-10-13', '2025-10-14', 1, 'Thanh toán khi trả phòng', 910000, '2025-10-13 08:08:00', 'Đã xác nhận', 'Đã thanh toán', 'Yêu cầu phòng tầng cao, view đẹp.'),
(21, 29, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-10-12 13:05:39', '2025-10-18', '2025-10-26', 1, 'Thanh toán khi trả phòng', 8800000, '2025-10-13 09:09:00', 'Đã xác nhận', 'Đã thanh toán', 'Tôi muốn có xe đưa đón'),
(22, 1, 8, 'Khúc Trường Giang', 'truonggiang02@gmail.com', '0328947360', '2025-10-13 06:33:06', '2025-10-14', '2025-10-15', 7, 'Thanh toán khi trả phòng', 910000, '2025-10-17 01:36:00', 'Đã xác nhận', 'Đã thanh toán', 'Yêu cầu phòng tầng cao, view đẹp.'),

(23, 3, 5, 'Cao Văn Quyết', 'user01@gmail.com', '0945127846', '2025-05-05 09:10:00', '2025-05-10', '2025-05-12', 2, 'Momo', 1800000, '2025-05-06 10:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Cần thêm 1 gối phụ.'),
(24, 4, 8, 'Khúc Trường Giang', 'truonggiang02@gmail.com', '0954721548', '2025-05-15 11:22:00', '2025-05-20', '2025-05-22', 3, 'VNPay', 2750000, '2025-05-16 09:30:00', 'Đã xác nhận', 'Đã thanh toán', 'Muốn ở phòng gần hồ bơi.'),
(25, 5, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-05-20 15:10:00', '2025-05-25', '2025-05-27', 4, 'Đặt cọc', 3200000, '2025-05-21 08:00:00', 'Đã xác nhận', 'Đã đặt cọc', 'Mang theo thú cưng nhỏ.'),
(26, 4, 5, 'Cao Văn Quyết', 'user01@gmail.com', '0945127846', '2025-05-05 09:10:00', '2025-05-10', '2025-05-12', 2, 'Momo', 1800000, '2025-05-06 10:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Cần thêm 1 gối phụ.'),
(27, 5, 5, 'Cao Văn Quyết', 'user01@gmail.com', '0945127846', '2025-05-05 09:10:00', '2025-05-10', '2025-05-12', 2, 'Momo', 1800000, '2025-05-06 10:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Cần thêm 1 gối phụ.'),
(28, 6, 5, 'Cao Văn Quyết', 'user01@gmail.com', '0945127846', '2025-05-05 09:10:00', '2025-05-10', '2025-05-12', 2, 'Momo', 1800000, '2025-05-06 10:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Cần thêm 1 gối phụ.'),
-- Tháng 6
(1, 6, 10, 'Nguyễn Xuân Sáng', '1234@gmail.com', '0328947360', '2025-06-01 14:30:00', '2025-06-10', '2025-06-15', 5, 'Thanh toán khi trả phòng', 4500000, NULL, 'Chờ xác nhận', 'Chờ thanh toán', 'Đi cùng gia đình.'),
(2, 7, 5, 'Cao Văn Quyết', 'user01@gmail.com', '0945127846', '2025-06-05 09:00:00', '2025-06-09', '2025-06-11', 2, 'Momo', 1900000, '2025-06-06 09:30:00', 'Đã xác nhận', 'Đã thanh toán', 'Yêu cầu check-in sớm.'),
(3, 9, 11, 'Nguyễn Xuân Sáng', 'nguyenxuansang@gmail.com', '0973026671', '2025-06-20 08:00:00', '2025-06-25', '2025-06-27', 6, 'VNPay', 6000000, '2025-06-21 09:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng rộng, có bếp riêng.'),
-- Tháng 6
(29, 1, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-6-10 09:15:00', '2025-6-15', '2025-6-17', 2, 'VNPAY', 1200000, '2025-10-10 09:16:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng đôi, tầng 2'),
(30, 2, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-6-12 14:30:00', '2025-6-20', '2025-6-22', 4, 'VNPAY', 2500000, '2025-10-12 14:31:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng gia đình view biển'),
(31, 3, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-6-14 10:05:00', '2025-6-18', '2025-6-19', 1, 'VNPAY', 800000, '2025-10-14 10:06:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng đơn, gần hồ bơi'),
(32, 4, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-6-15 08:45:00', '2025-6-25', '2025-6-28', 3, 'VNPAY', 2100000, '2025-10-15 08:46:00', 'Chờ xác nhận', 'Đã đặt cọc', 'Phòng 3 người, giường lớn'),
(33, 5, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-6-16 12:10:00', '2025-6-29', '2025-6-31', 2, 'VNPAY', 1700000, NULL, 'Chờ xác nhận', 'Chờ thanh toán', 'Phòng tiêu chuẩn, hướng vườn'),
(34, 6, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-6-17 15:00:00', '2025-7-01', '2025-7-03', 2, 'VNPAY', 2200000, '2025-10-17 15:01:00', 'Đã xác nhận', 'Đã thanh toán', 'Có ban công riêng'),
(35, 7, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-6-18 09:45:00', '2025-7-05', '2025-7-07', 5, 'VNPAY', 3500000, '2025-10-18 09:46:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng lớn, có bếp riêng'),
-- Tháng 7
(36, 8, 1, 'Khúc Trường Giang', 'user02@gmail.com', '0954721548', '2025-07-02 09:00:00', '2025-07-05', '2025-07-08', 3, 'Momo', 2500000, '2025-07-03 10:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Muốn phòng gần hồ bơi.'),
(37, 9, 5, 'Cao Văn Quyết', 'user01@gmail.com', '0328947360', '2025-07-10 08:30:00', '2025-07-15', '2025-07-18', 2, 'Thanh toán khi trả phòng', 1800000, NULL, 'Chờ xác nhận', 'Chờ thanh toán', 'Check-in trễ lúc 9h tối.'),
(38, 10, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-07-20 11:15:00', '2025-07-25', '2025-07-28', 4, 'VNPay', 3200000, '2025-07-21 09:30:00', 'Đã xác nhận', 'Đã thanh toán', 'Cần thêm nệm phụ.'),
(39, 5, 10, 'Nguyễn Xuân Sáng', '1234@gmail.com', '0328947360', '2025-07-25 10:00:00', '2025-07-30', '2025-08-01', 3, 'Đặt cọc', 2100000, '2025-07-26 12:00:00', 'Đã xác nhận', 'Đã đặt cọc', 'Đi công tác, cần yên tĩnh.'),

-- Tháng 8
(40, 6, 11, 'Nguyễn Xuân Sáng', 'nguyenxuansang@gmail.com', '0973026671', '2025-08-02 09:00:00', '2025-08-05', '2025-08-07', 2, 'VNPay', 1700000, '2025-08-03 10:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng có cửa sổ lớn.'),
(41, 2, 5, 'Cao Văn Quyết', 'user01@gmail.com', '0328947360', '2025-08-08 15:00:00', '2025-08-10', '2025-08-12', 4, 'Momo', 2500000, '2025-08-09 09:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng có view biển.'),
(42, 3, 8, 'Khúc Trường Giang', 'truonggiang02@gmail.com', '0328947360', '2025-08-15 14:30:00', '2025-08-18', '2025-08-20', 2, 'Thanh toán khi trả phòng', 1600000, NULL, 'Chờ xác nhận', 'Chờ thanh toán', 'Mang theo thú cưng nhỏ.'),
(43, 4, 1, 'Khúc Trường Giang', 'user02@gmail.com', '0954721548', '2025-08-20 09:00:00', '2025-08-22', '2025-08-24', 5, 'VNPay', 3000000, '2025-08-21 08:30:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng tầng cao, có ban công.'),

-- Tháng 9
(44, 1, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-09-02 10:10:00', '2025-09-05', '2025-09-07', 2, 'VNPay', 1800000, '2025-09-03 09:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Check-out sớm lúc 7h sáng.'),
(45, 7, 10, 'Nguyễn Xuân Sáng', '1234@gmail.com', '0328947360', '2025-09-08 11:45:00', '2025-09-12', '2025-09-14', 6, 'Momo', 4200000, '2025-09-09 12:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Cần xe đưa đón.'),
(46, 9, 6, 'Cao Văn Quyết', 'user05@gmail.com', '0945725842', '2025-09-15 08:30:00', '2025-09-18', '2025-09-20', 1, 'Đặt cọc', 1300000, '2025-09-16 09:00:00', 'Đã xác nhận', 'Đã đặt cọc', 'Phòng đơn nhỏ.'),
(47, 8, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-09-22 09:00:00', '2025-09-25', '2025-09-27', 3, 'VNPay', 2100000, '2025-09-23 08:30:00', 'Đã xác nhận', 'Đã thanh toán', 'Yêu cầu thêm gối và chăn.'),

-- Tháng 10
(48, 3, 5, 'Cao Văn Quyết', 'user01@gmail.com', '0328947360', '2025-10-01 09:00:00', '2025-10-03', '2025-10-05', 2, 'Thanh toán khi trả phòng', 1900000, NULL, 'Chờ xác nhận', 'Chờ thanh toán', 'Muốn ở phòng tầng 3.'),
(49, 5, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-10-08 08:00:00', '2025-10-10', '2025-10-12', 2, 'VNPay', 1700000, '2025-10-09 08:30:00', 'Đã xác nhận', 'Đã thanh toán', 'Có chỗ đỗ xe.'),
(50, 9, 1, 'Khúc Trường Giang', 'user02@gmail.com', '0954721548', '2025-10-14 09:00:00', '2025-10-16', '2025-10-18', 1, 'Momo', 1200000, '2025-10-15 08:45:00', 'Đã xác nhận', 'Đã thanh toán', 'Cần hóa đơn đỏ.'),
(51, 6, 10, 'Nguyễn Xuân Sáng', '1234@gmail.com', '0328947360', '2025-10-20 10:00:00', '2025-10-23', '2025-10-25', 5, 'Đặt cọc', 3100000, NULL, 'Chờ xác nhận', 'Đã đặt cọc', 'Gia đình có trẻ nhỏ.'),
(52, 2, 11, 'Nguyễn Xuân Sáng', 'nguyenxuansang@gmail.com', '0973026671', '2025-10-27 08:00:00', '2025-10-30', '2025-11-01', 2, 'VNPay', 2100000, '2025-10-28 09:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng gần thang máy.'),
(53, 4, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-10-29 09:30:00', '2025-10-31', '2025-11-02', 3, 'Momo', 2200000, '2025-10-30 09:45:00', 'Đã xác nhận', 'Đã thanh toán', 'View biển, phòng rộng.'),
(54, 1, 9, 'Khúc Trường Giang', 'khucgiang58@gmail.com', '0328947360', '2025-10-30 10:00:00', '2025-10-31', '2025-11-02', 4, 'Thanh toán khi trả phòng', 2500000, NULL, 'Chờ xác nhận', 'Chờ thanh toán', 'Mang theo vật nuôi nhỏ.'),

(55, 1, 13, 'Nguyễn Văn Hùng', 'hungnguyen@gmail.com', '0912738495', '2025-10-16 08:00:00', '2025-10-20', '2025-10-22', 2, 'Momo', 1500000, '2025-10-17 09:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng tầng 2, gần hồ bơi.'),
(56, 2, 14, 'Trịnh Quốc Thái', 'quocthai@gmail.com', '0973156824', '2025-10-16 08:15:00', '2025-10-22', '2025-10-25', 3, 'VNPay', 1900000, '2025-10-17 10:30:00', 'Đã xác nhận', 'Đã thanh toán', 'Yêu cầu check-in sớm.'),
(57, 3, 15, 'Hoàng Đức Anh', 'ducanh@gmail.com', '0947852146', '2025-10-16 09:00:00', '2025-10-23', '2025-10-25', 2, 'Thanh toán khi trả phòng', 1600000, NULL, 'Chờ xác nhận', 'Chờ thanh toán', 'Phòng gần cửa sổ lớn.'),
(58, 4, 16, 'Vũ Thị Yến', 'yenvu@gmail.com', '0938541279', '2025-10-16 09:20:00', '2025-10-24', '2025-10-26', 4, 'Đặt cọc', 2200000, '2025-10-17 11:00:00', 'Đã xác nhận', 'Đã đặt cọc', 'Phòng view núi, yên tĩnh.'),
(59, 5, 17, 'Phạm Anh Tuấn', 'tuanpham@gmail.com', '0901245789', '2025-10-16 10:00:00', '2025-10-25', '2025-10-27', 3, 'VNPay', 1800000, '2025-10-17 12:30:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng có ban công.'),
(60, 6, 18, 'Nguyễn Thị Hoa', 'hoanguyen@gmail.com', '0964785123', '2025-10-16 10:30:00', '2025-10-26', '2025-10-28', 2, 'Momo', 1700000, '2025-10-17 13:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Cần thêm gối phụ.'),
(61, 7, 19, 'Trần Văn Minh', 'minhtran@gmail.com', '0978456123', '2025-10-16 11:00:00', '2025-10-27', '2025-10-29', 4, 'VNPay', 2100000, '2025-10-18 09:30:00', 'Đã xác nhận', 'Đã thanh toán', 'Đi cùng gia đình.'),
(62, 8, 20, 'Đặng Quỳnh Chi', 'quynhchi@gmail.com', '0958741256', '2025-10-16 11:20:00', '2025-10-28', '2025-10-30', 2, 'Thanh toán khi trả phòng', 1400000, NULL, 'Chờ xác nhận', 'Chờ thanh toán', 'Phòng có bồn tắm.'),
(63, 9, 21, 'Phạm Quang Huy', 'huypham@gmail.com', '0978412365', '2025-10-16 12:00:00', '2025-10-29', '2025-10-31', 3, 'VNPay', 2000000, '2025-10-18 09:00:00', 'Đã xác nhận', 'Đã thanh toán', 'Phòng hướng ra biển.'),
(64, 10, 22, 'Nguyễn Thị Mai', 'mainguyen@gmail.com', '0912347896', '2025-10-16 12:15:00', '2025-10-30', '2025-11-01', 4, 'Momo', 2300000, '2025-10-18 09:30:00', 'Đã xác nhận', 'Đã thanh toán', 'Muốn ở gần hồ bơi.'),
(65, 11, 23, 'Trần Đức Anh', 'ducanh@gmail.com', '0987412563', '2025-10-16 12:30:00', '2025-11-01', '2025-11-03', 2, 'Thanh toán khi trả phòng', 1500000, NULL, 'Chờ xác nhận', 'Chờ thanh toán', 'Phòng tầng cao.'),
(66, 12, 24, 'Lê Thị Thu', 'thule@gmail.com', '0957841236', '2025-10-16 13:00:00', '2025-11-02', '2025-11-04', 2, 'VNPay', 1600000, '2025-10-18 09:45:00', 'Đã xác nhận', 'Đã thanh toán', 'Đi cùng bạn bè.');



-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `db_customer`
--

CREATE TABLE `db_customer` (
  `customer_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT '../images/user.jpg',
  `fullname` varchar(100) NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `db_customer`
--

INSERT INTO `db_customer` (`customer_id`, `account_id`, `avatar`, `fullname`, `birthday`, `gender`, `email`, `phone`, `address`) VALUES
(1, 1, '../images/user.jpg', 'Khúc Trường Giang', '2004-03-18', 'Nam', 'user02@gmail.com', '0954721548', 'Long Biên'),
(5, 5, '../images/user.jpg', 'Cao Văn Quyết', '2000-01-01', 'Nam', 'user01@gmail.com', '0328947360', 'Nam Định'),
(6, NULL, '../images/user.jpg', 'Cao Văn Quyết', '2000-03-01', 'Nam', 'user05@gmail.com', '0945725842', 'Nam Định'),
(8, 9, '../images/user_9_1760285774.jpg', 'Khúc Trường Giang', '2025-10-18', 'Nam', 'khucgiang58@gmail.com', '0328947360', 'Hà Nội'),
(9, 8, '../images/user.jpg', 'Khúc Trường Giang', '2000-01-01', 'Nam', 'khucgiang58@gmail.com', '0328947360', 'Long Biên,Hà Nội'),
(10, 10, '../images/user.jpg', 'Nguyễn Xuân Sáng', '2025-05-16', 'Nam', '1234@gmail.com', '0328947360', 'Nghệ An'),
(11, NULL, '../images/user.jpg', 'Nguyễn Xuân Sáng', '2004-05-02', 'Nam', 'nguyenxuansang@gmail.com', '0973026671', 'Nghệ An'),
(13, 13, '../images/user.jpg', 'Nguyễn Văn Hùng', '2001-04-12', 'Nam', 'hungnguyen@gmail.com', '0912738495', 'Hà Nội'),
(14, 14, '../images/user.jpg', 'Trịnh Quốc Thái', '2000-11-23', 'Nam', 'quocthai@gmail.com', '0973156824', 'Hải Phòng'),
(15, 15, '../images/user.jpg', 'Hoàng Đức Anh', '2002-05-08', 'Nam', 'ducanh@gmail.com', '0947852146', 'Nam Định'),
(16, 16, '../images/user.jpg', 'Vũ Thị Yến', '2003-09-18', 'Nữ', 'yenvu@gmail.com', '0938541279', 'Hà Nội'),
(17, 17, '../images/user.jpg', 'Phạm Anh Tuấn', '2001-07-10', 'Nam', 'tuanpham@gmail.com', '0901245789', 'Thái Bình'),
(18, 18, '../images/user.jpg', 'Nguyễn Thị Hoa', '2003-02-14', 'Nữ', 'hoanguyen@gmail.com', '0964785123', 'Bắc Giang'),
(19, 19, '../images/user.jpg', 'Trần Văn Minh', '2000-12-05', 'Nam', 'minhtran@gmail.com', '0978456123', 'Hải Dương'),
(20, 20, '../images/user.jpg', 'Đặng Quỳnh Chi', '2001-08-09', 'Nữ', 'quynhchi@gmail.com', '0958741256', 'Bắc Ninh'),
(21, 21, '../images/user.jpg', 'Phạm Quang Huy', '1999-03-12', 'Nam', 'huypham@gmail.com', '0978412365', 'Ba Vì, Hà Nội'),
(22, 22, '../images/user.jpg', 'Nguyễn Thị Mai', '1999-06-22', 'Nữ', 'mainguyen@gmail.com', '0912347896', 'Tam Đảo, Vĩnh Phúc'),
(23, 23, '../images/user.jpg', 'Trần Đức Anh', '2002-08-15', 'Nam', 'ducanh@gmail.com', '0987412563', 'Hà Nội'),
(24, 24, '../images/user.jpg', 'Lê Thị Thu', '2003-05-28', 'Nữ', 'thule@gmail.com', '0957841236', 'Bắc Ninh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `db_homestay`
--

CREATE TABLE `db_homestay` (
  `homestay_id` int(11) NOT NULL,
  `homestay_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'còn phòng',
  `description` text DEFAULT NULL,
  `room_type` varchar(50) NOT NULL,
  `policy` text NOT NULL,
  `price` decimal(12,0) NOT NULL,
  `guests` int(11) DEFAULT 2,
  `img` varchar(255) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `img3` varchar(255) DEFAULT NULL,
  `checkin` varchar(50) DEFAULT '14:00 - 22:00',
  `checkout` varchar(50) DEFAULT 'Trước 12:00 trưa',
  `owner_id` int(11) DEFAULT NULL,
  `homestay_email` varchar(50) NOT NULL,
  `homestay_phone` varchar(15) NOT NULL,
  `rating` decimal(3,0) DEFAULT 5,
  `reviews_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `db_homestay`
--

INSERT INTO `db_homestay` (`homestay_id`, `homestay_name`, `address`, `status`, `description`, `room_type`, `policy`, `price`, `guests`, `img`, `img1`, `img2`, `img3`, `checkin`, `checkout`, `owner_id`, `homestay_email`, `homestay_phone`, `rating`, `reviews_count`) VALUES
(1, 'Amaya Home Deluxe', 'Sóc Sơn, Hà Nội', 'Còn phòng', 'Homestay yên tĩnh, gần rừng thông, thích hợp nghỉ dưỡng.', 'Deluxe', '', 1300000, 8, '../images/SS1.jpg', '../images/Amayahome-deluxe1.jpg', '../images/amayahome-deluxe2.jpg', '../images/amayahome-deluxe3.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(2, 'Amaya Home Family', 'Sóc Sơn, Hà Nội', 'Còn phòng', 'Phòng tiêu chuẩn, đầy đủ tiện nghi.', 'Family', '', 950000, 6, '../images/SS1.1.webp', '../images/amaya-family1.jpg', '../images/amaya-family2.jpg', '../images/amaya-family3.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(3, 'Cerf Volant Soc Son Deluxe', 'Sóc Sơn, Hà Nội', 'Còn phòng', 'Khu nghỉ dưỡng với view núi.', 'Deluxe', '', 1500000, 5, '../images/SS2.jpg', '../images/CerfVolantSocSonResort-deluxe1.jpg', '../images/CerfVolantSocSonResort-deluxe2.jpg', '../images/CerfVolantSocSonResort-deluxe3.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(4, 'Cerf Volant Soc Son Standard', 'Sóc Sơn, Hà Nội', 'Còn phòng', 'Phòng standard gần hồ.', 'Standard', '', 1100000, 4, '../images/Cerf Volant Soc Son Resort-standard3.jpg', '../images/Cerf Volant Soc Son Resort-standard1.jpg', '../images/Cerf Volant Soc Son Resort-standard2.jpg', '../images/SS2.1.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(5, 'Debay Retreat Deluxe', 'Sóc Sơn, Hà Nội', 'Còn phòng', 'Phong cách hiện đại, gần hồ nước.', 'Deluxe', '', 1200000, 7, '../images/SS3.jpg', '../images/Debay Retreat-deluxe1.webp', '../images/Debay Retreat-deluxe2.webp', '../images/Debay Retreat-deluxe3.webp', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(6, 'Debay Retreat Standard', 'Sóc Sơn, Hà Nội', 'Còn phòng', 'Phòng standard giá rẻ.', 'Standard', '', 850000, 5, '../images/Debay Retreat-Standard1.webp', '../images/Debay Retreat-Standar2.webp', '../images/Debay Retreat-Standard3.webp', '../images/SS3.1.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 3, 0),
(7, 'Amaya Retreat Family', 'Sóc Sơn, Hà Nội', 'Còn phòng', 'Biệt thự nghỉ dưỡng sang trọng.', 'Family', '', 1400000, 6, '../images/SS5.jpg', '../images/Amaya Retreat-Family1.jpg', '../images/Amaya Retreat-Family2.jpg', '../images/Amaya Retreat-Family3.webp', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(8, 'Amaya Retreat Standard', 'Sóc Sơn, Hà Nội', 'Còn phòng', 'Phòng tiêu chuẩn tiện nghi.', 'Standard', '', 1000000, 4, '../images/SS5.1.webp', '../images/Amaya Retreat-Standard1.webp', '../images/Amaya Retreat-Standard3.webp', '../images/Amaya Retreat-Standard2.webp', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(9, 'BaVi Padme Deluxe', 'Ba Vì, Hà Nội', 'Còn phòng', 'Homestay gần vườn quốc gia Ba Vì.', 'Deluxe', '', 1250000, 6, '../images/BV1.jpg', '../images/BV1.1.jpg', '../images/BV1.3.jpg', '../images/BV1.4.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(10, 'BaVi Padme Standard', 'Ba Vì, Hà Nội', 'Còn phòng', 'Phòng standard đầy đủ tiện nghi.', 'Standard', '', 900000, 5, '../images/BV1.5.jpg', '../images/BV1.6.jpg', '../images/BV1.7.jpg', '../images/BV1.8.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(11, 'Melia Bavi Mountain Retreat Deluxe', 'Ba Vì, Hà Nội', 'Còn phòng', 'Resort cao cấp giữa núi rừng.', 'Deluxe', '', 1350000, 8, '../images/BV2.jpg', '../images/BV2.1.jpg', '../images/BV2.3.jpg', '../images/BV2.4.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(12, 'Melia Bavi Mountain Retreat Standard', 'Ba Vì, Hà Nội', 'Còn phòng', 'Phòng nghỉ đơn giản, thoáng mát.', 'Standard', '', 950000, 6, '../images/BV2.5.jpg', '../images/BV2.6.jpg', '../images/BV2.7.jpg', '../images/BV2.8.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(13, 'Mely Farm Standard', 'Ba Vì, Hà Nội', 'Còn phòng', 'Trải nghiệm nông trại độc đáo.', 'Standard', '', 950000, 6, '../images/BV3.jpg', '../images/3.1.jpg', '../images/3.3.jpg', '../images/3.4.webp', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(14, 'Mely Farm Deluxe', 'Ba Vì, Hà Nội', 'Còn phòng', 'Phòng deluxe rộng rãi.', 'Deluxe', '', 1250000, 7, '../images/BV3.8.jpg', '../images/BV3.6.jpg', '../images/BV3.7.jpg', '../images/3.5.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(15, 'Family Homestay Deluxe', 'Ba Vì, Hà Nội', 'Còn phòng', 'Thích hợp cho gia đình.', 'Deluxe', '', 1450000, 6, '../images/BV4.jpg', '../images/BV4.1.jpg', '../images/BV4.3.jpg', '../images/BV4.4.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(16, 'Family Homestay Standard', 'Ba Vì, Hà Nội', 'Còn phòng', 'Phòng gia đình tiêu chuẩn.', 'Standard', '', 1050000, 5, '../images/BV4.5.jpg', '../images/BV4.6.jpg', '../images/BV4.7.jpg', '../images/BV4.8.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(17, 'Dream House Deluxe', 'Tam Đảo, Vĩnh Phúc', 'Còn phòng', 'View núi đẹp, không khí mát mẻ.', 'Deluxe', '', 1600000, 7, '../images/TD1.jpg', '../images/TD1.4.jpg', '../images/TD1.5.png', '../images/TD1.3.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(18, 'Dream House Standard', 'Tam Đảo, Vĩnh Phúc', 'Còn phòng', 'Phòng tiêu chuẩn, tiện nghi.', 'Standard', '', 1150000, 5, '../images/Dream1.webp', '../images/dream1.1.webp', '../images/Dream2.jpg', '../images/dream2.1.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(19, 'Le Bleu Floating Cloud Deluxe', 'Tam Đảo, Vĩnh Phúc', 'Còn phòng', 'Homestay nổi tiếng view mây.', 'Deluxe', '', 1450000, 6, '../images/TD2.jpg', '../images/Le_Bleu_Tam_Dao_1.jpg', '../images/Le_Bleu_Tam_Dao_2.jpg', '../images/Le_Bleu_Tam_Dao_3.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(20, 'Le Bleu Floating Cloud Standard', 'Tam Đảo, Vĩnh Phúc', 'Còn phòng', 'Phòng standard xinh xắn.', 'Standard', '', 1000000, 4, '../images/Dream3.jpg', '../images/Le_Bleu_Tam_Dao_5.jpg', '../images/Le_Bleu_Tam_Dao_6.jpg', '../images/Le_Bleu_Tam_Dao_7.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(21, 'Up In The Air Homestay Deluxe', 'Tam Đảo, Vĩnh Phúc', 'Còn phòng', 'Phòng cao tầng nhìn toàn cảnh.', 'Deluxe', '', 1550000, 7, '../images/TD3.jpg', '../images/up6.jpg', '../images/up5.jpg', '../images/up4.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(22, 'Up In The Air Homestay Family', 'Tam Đảo, Vĩnh Phúc', 'Còn phòng', 'Phòng family tiện nghi.', 'Family', '', 1050000, 5, '../images/up7.jpg', '../images/up1.jpg', '../images/up2.jpg', '../images/up3.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(23, 'Cloudy Garden Deluxe', 'Tam Đảo, Vĩnh Phúc', 'Còn phòng', 'Homestay giữa vườn hoa.', 'Deluxe', '', 1500000, 6, '../images/TD4.jpg', '../images/cl3.jpg', '../images/cl1.jpg', '../images/cl2.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(24, 'Cloudy Garden Standard', 'Tam Đảo, Vĩnh Phúc', 'Còn phòng', 'Phòng standard gần vườn.', 'Standard', '', 1100000, 5, '../images/cl6.jpeg', '../images/cl7.jpg', '../images/cl4.jpg', '../images/cl8.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(25, 'Phoenix Bungalow Family', 'Mộc Châu, Sơn La', 'Còn phòng', 'Bungalow đẹp, view vườn.', 'Family', '', 1400000, 6, '../images/MC.jpg', '../images/MC1.1.jpg', '../images/MC1.2.webp', '../images/MC1.3.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(26, 'Phoenix Bungalow Standard', 'Mộc Châu, Sơn La', 'Còn phòng', 'Phòng standard ấm cúng.', 'Standard', '', 950000, 5, '../images/MC1.8.jpg', '../images/MC1.4.jpeg', '../images/MC1.5.jpeg', '../images/MC1.6.jpeg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0),
(27, 'Mộc Châu Eco-garden Deluxe', 'Mộc Châu, Sơn La', 'Còn phòng', 'Homestay giữa vườn cây.', 'Deluxe', '', 1550000, 7, '../images/mcc2.webp', '../images/MC2.1.jpg', '../images/MC2.2.webp', '../images/MC2.3.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(28, 'Mộc HomeStay Family', 'Mộc Châu, Sơn La', 'Còn phòng', 'Không gian ấm áp, gần thiên nhiên.', 'Family', '', 1500000, 6, '../images/MC3.webp', '../images/mcc.webp', '../images/mcc1.webp', '../images/mcc2.webp', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 5, 0),
(29, 'Mama House Standard', 'Mộc Châu, Sơn La', 'Còn phòng', 'Phòng standard tiện nghi.', 'Standard', '', 1100000, 5, '../images/MC4.webp', '../images/MC4.1.jpg', '../images/MC4.3.jpg', '../images/MC4.4.jpg', '14:00 - 22:00', 'Trước 12:00 trưa', NULL, '', '', 4, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `db_owner`
--

CREATE TABLE `db_owner` (
  `owner_id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `db_owner`
--

INSERT INTO `db_owner` (`owner_id`, `account_id`, `fullname`, `birthday`, `gender`, `email`, `phone`, `address`) VALUES
(3, 1, 'Khúc Trường Giang', '2000-01-01', 'Nam', '12345678@gmail.com', '0964645393', 'Hà Nội'),
(4, 10, 'Nguyễn Xuân Sáng', '2000-01-02', 'Nam', '2345678@gmail.com', '0945725842', 'Nghệ An'),
(6, 5, 'Cao Văn Quyết', '2000-01-13', 'Nam', '3456789@gmail.com', '0397282143', 'Nam Định');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `db_review`
--

CREATE TABLE `db_review` (
  `review_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `homestay_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `rating` decimal(3,0) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `content_feedback` text DEFAULT NULL,
  `status_review` enum('Đã phản hồi','Chưa phản hồi') DEFAULT 'Chưa phản hồi',
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `db_review`
--

INSERT INTO `db_review` (`review_id`, `booking_id`, `homestay_id`, `customer_id`, `review`, `rating`, `created_at`, `content_feedback`, `status_review`, `update_at`, `updated_at`) VALUES
(3, 10, NULL, NULL, 'Tôi đã có một trải nghiệm rất thú vị tại đây', 5, '2025-10-08 07:30:57', 'Tôi cảm ơn bạn khi đã để lại đánh giá này cho chúng tôi', 'Đã phản hồi', '2025-10-09 08:15:28', NULL),
(4, 10, NULL, NULL, 'Tôi đã có một trải nghiệm tệ hại tại homestay', 1, '2025-10-08 08:02:35', NULL, 'Chưa phản hồi', '2025-10-09 08:03:17', NULL),
(6, 13, NULL, NULL, 'tôi không thích dịch vụ ở đây', 3, '2025-10-07 08:24:49', '', 'Chưa phản hồi', '2025-10-09 08:27:53', NULL),
(7, 10, NULL, NULL, 'jdlakjsldkals', 4, '2025-10-06 08:26:09', NULL, 'Chưa phản hồi', NULL, NULL),
(8, 21, 29, 9, 'Đẹp tuyệt vời!', 5, '2025-10-13 15:01:38', NULL, 'Chưa phản hồi', '2025-10-14 14:21:34', '2025-10-14 14:21:34'),
(9, 20, 1, 9, 'Đẹp lắm mọi người nên thử ạ!', 5, '2025-10-13 15:04:08', NULL, 'Chưa phản hồi', '2025-10-14 14:21:54', '2025-10-14 14:21:54'),
(10, 17, 17, 9, '', 5, '2025-10-13 18:11:57', NULL, 'Chưa phản hồi', NULL, NULL),
(11, 22, 1, 8, '', 5, '2025-10-13 18:12:31', NULL, 'Chưa phản hồi', NULL, NULL),
(12, 16, 1, 5, 'Nơi đây rất tuyệt cho các cặp đôi!!!!', 5, '2025-10-14 14:23:17', NULL, 'Chưa phản hồi', NULL, NULL),
(13, 13, 16, 5, 'Rất tệ!!', 1, '2025-10-14 14:23:38', NULL, 'Chưa phản hồi', NULL, NULL),
(14, 31, 1, 9, 'Phòng sạch sẽ, nhân viên thân thiện.', 5, '2025-10-17 09:30:00', 'Cảm ơn bạn đã đánh giá tích cực!', 'Đã phản hồi', '2025-10-18 10:00:00', '2025-10-18 10:00:00'),
(15, 32, 2, 9, 'View biển rất đẹp, nhưng wifi hơi yếu.', 4, '2025-10-22 08:40:00', NULL, 'Chưa phản hồi', NULL, NULL),
(16, 33, 3, 9, 'Giá hợp lý, phòng nhỏ gọn và sạch.', 5, '2025-10-23 11:22:00', 'Chúng tôi rất vui vì bạn hài lòng!', 'Đã phản hồi', '2025-10-23 13:00:00', '2025-10-23 13:00:00'),
(17, 34, 4, 9, 'Phòng ổn, nhưng lễ tân xử lý hơi chậm.', 3, '2025-10-28 14:15:00', NULL, 'Chưa phản hồi', NULL, NULL),
(18, 35, 5, 9, 'Không gian yên tĩnh, phù hợp nghỉ dưỡng.', 5, '2025-10-31 09:05:00', 'Rất vui khi bạn hài lòng!', 'Đã phản hồi', '2025-10-31 09:30:00', '2025-10-31 09:30:00'),
(19, 36, 6, 9, 'Phòng rộng, có ban công, rất tuyệt!', 5, '2025-11-03 10:45:00', NULL, 'Chưa phản hồi', NULL, NULL),
(20, 37, 7, 9, 'Giá hơi cao nhưng dịch vụ xứng đáng.', 4, '2025-11-08 16:20:00', 'Cảm ơn góp ý của bạn!', 'Đã phản hồi', '2025-11-09 08:00:00', '2025-11-09 08:00:00'),
(21, 38, 8, 9, 'Phòng nhỏ, không cách âm tốt.', 2, '2025-11-11 18:10:00', NULL, 'Chưa phản hồi', NULL, NULL),
(22, 39, 9, 9, 'Phòng đẹp, nhân viên chu đáo.', 5, '2025-11-16 19:40:00', 'Cảm ơn bạn đã chọn homestay của chúng tôi!', 'Đã phản hồi', '2025-11-17 08:45:00', '2025-11-17 08:45:00'),
(23, 40, 10, 9, 'Mọi thứ đều ổn, nhưng checkin hơi lâu.', 4, '2025-11-22 20:15:00', NULL, 'Chưa phản hồi', NULL, NULL),
(30, 55, 1, 13, 'Phòng sạch sẽ, thoáng mát và nhân viên rất thân thiện.', 5, '2025-10-22 09:00:00', 'Cảm ơn bạn Hùng đã đánh giá tích cực!', 'Đã phản hồi', '2025-10-23 10:00:00', '2025-10-23 10:00:00'),
(31, 56, 2, 14, 'Homestay đẹp, tiện nghi, nhưng hơi xa trung tâm.', 4, '2025-10-22 09:15:00', NULL, 'Chưa phản hồi', NULL, NULL),
(32, 57, 3, 15, 'Phòng nhỏ gọn, đủ tiện nghi, giá hợp lý.', 5, '2025-10-23 08:40:00', 'Cảm ơn bạn Đức Anh đã tin tưởng đặt phòng!', 'Đã phản hồi', '2025-10-23 11:20:00', '2025-10-23 11:20:00'),
(33, 58, 4, 16, 'Không gian yên tĩnh, phù hợp nghỉ dưỡng.', 5, '2025-10-24 10:05:00', 'Rất vui vì bạn Yến hài lòng!', 'Đã phản hồi', '2025-10-24 12:00:00', '2025-10-24 12:00:00'),
(34, 59, 5, 17, 'Phòng có view đẹp, nhưng điều hòa hơi yếu.', 3, '2025-10-25 09:30:00', NULL, 'Chưa phản hồi', NULL, NULL),
(35, 60, 6, 18, 'Nhân viên phục vụ chu đáo, phòng sạch sẽ.', 5, '2025-10-26 08:45:00', 'Cảm ơn bạn Hoa đã đánh giá!', 'Đã phản hồi', '2025-10-26 10:15:00', '2025-10-26 10:15:00'),
(36, 61, 7, 19, 'Phòng rộng, tiện nghi, rất phù hợp cho gia đình.', 5, '2025-10-27 09:20:00', 'Cảm ơn anh Minh và gia đình đã nghỉ tại homestay!', 'Đã phản hồi', '2025-10-27 11:00:00', '2025-10-27 11:00:00'),
(37, 62, 8, 20, 'Phòng đẹp nhưng hơi nhỏ, wifi yếu.', 3, '2025-10-28 08:50:00', NULL, 'Chưa phản hồi', NULL, NULL),
(38, 63, 9, 21, 'Homestay gần biển, phong cảnh rất đẹp.', 5, '2025-10-29 10:10:00', 'Cảm ơn bạn Huy đã chia sẻ cảm nhận tuyệt vời!', 'Đã phản hồi', '2025-10-29 12:00:00', '2025-10-29 12:00:00'),
(39, 64, 10, 22, 'Mọi thứ đều ổn, nhân viên thân thiện.', 4, '2025-10-30 09:30:00', NULL, 'Chưa phản hồi', NULL, NULL),
(40, 65, 11, 23, 'Phòng tầng cao, tầm nhìn đẹp, nhưng hơi ồn.', 4, '2025-10-31 10:15:00', 'Chúng tôi sẽ cải thiện tốt hơn, cảm ơn bạn Đức Anh!', 'Đã phản hồi', '2025-10-31 11:30:00', '2025-10-31 11:30:00'),
(41, 66, 12, 24, 'Không gian thoải mái, giá hợp lý, sẽ quay lại!', 5, '2025-11-01 09:00:00', 'Cảm ơn bạn Thu đã tin tưởng đặt phòng!', 'Đã phản hồi', '2025-11-01 10:45:00', '2025-11-01 10:45:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `db_review_backup`
--

CREATE TABLE `db_review_backup` (
  `review_id` int(11) NOT NULL DEFAULT 0,
  `booking_id` int(11) DEFAULT NULL,
  `content_review` text DEFAULT NULL,
  `rating` decimal(3,0) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `content_feedback` text DEFAULT NULL,
  `status_review` enum('Đã phản hồi','Chưa phản hồi') DEFAULT 'Chưa phản hồi',
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `db_review_backup`
--

INSERT INTO `db_review_backup` (`review_id`, `booking_id`, `content_review`, `rating`, `created_at`, `content_feedback`, `status_review`, `update_at`) VALUES
(3, 10, 'Tôi đã có một trải nghiệm rất thú vị tại đây', 5, '2025-10-08 07:30:57', 'Tôi cảm ơn bạn khi đã để lại đánh giá này cho chúng tôi', 'Đã phản hồi', '2025-10-09 08:15:28'),
(4, 10, 'Tôi đã có một trải nghiệm tệ hại tại homestay', 1, '2025-10-08 08:02:35', NULL, 'Chưa phản hồi', '2025-10-09 08:03:17'),
(6, 13, 'tôi không thích dịch vụ ở đây', 3, '2025-10-07 08:24:49', '', 'Chưa phản hồi', '2025-10-09 08:27:53'),
(7, 10, 'jdlakjsldkals', 4, '2025-10-06 08:26:09', NULL, 'Chưa phản hồi', NULL),
(14, 31, 'Phòng sạch sẽ, nhân viên thân thiện.', 5, '2025-10-17 09:30:00', 'Cảm ơn bạn đã đánh giá tích cực!', 'Đã phản hồi', '2025-10-18 10:00:00'),
(15, 32, 'View biển rất đẹp, nhưng wifi hơi yếu.', 4, '2025-10-22 08:40:00', NULL, 'Chưa phản hồi', NULL),
(16, 33, 'Giá hợp lý, phòng nhỏ gọn và sạch.', 5, '2025-10-23 11:22:00', 'Chúng tôi rất vui vì bạn hài lòng!', 'Đã phản hồi', '2025-10-23 13:00:00'),
(17, 34, 'Phòng ổn, nhưng lễ tân xử lý hơi chậm.', 3, '2025-10-28 14:15:00', NULL, 'Chưa phản hồi', NULL),
(18, 35, 'Không gian yên tĩnh, phù hợp nghỉ dưỡng.', 5, '2025-10-31 09:05:00', 'Rất vui khi bạn hài lòng!', 'Đã phản hồi', '2025-10-31 09:30:00'),
(19, 36, 'Phòng rộng, có ban công, rất tuyệt!', 5, '2025-11-03 10:45:00', NULL, 'Chưa phản hồi', NULL),
(20, 37, 'Giá hơi cao nhưng dịch vụ xứng đáng.', 4, '2025-11-08 16:20:00', 'Cảm ơn góp ý của bạn!', 'Đã phản hồi', '2025-11-09 08:00:00'),
(21, 38, 'Phòng nhỏ, không cách âm tốt.', 2, '2025-11-11 18:10:00', 'Cảm ơn đã ghé!', 'Đã phản hồi','2025-11-12 09:00:00'),
(22, 39, 'Phòng đẹp, nhân viên chu đáo.', 5, '2025-11-16 19:40:00', 'Cảm ơn bạn đã chọn homestay của chúng tôi!', 'Đã phản hồi', '2025-11-17 08:45:00'),
(23, 40, 'Mọi thứ đều ổn, nhưng checkin hơi lâu.', 4, '2025-11-22 20:15:00', 'Cảm ơn bạn đã tới đây!', 'Đã phản hồi', '2025-11-23 08:00:00'),
(30, 55, 'Phòng sạch sẽ, thoáng mát và nhân viên rất thân thiện.', 5, '2025-10-22 09:00:00', 'Cảm ơn bạn Hùng đã đánh giá tích cực!', 'Đã phản hồi', '2025-10-23 10:00:00'),
(31, 56, 'Homestay đẹp, tiện nghi, nhưng hơi xa trung tâm.', 4, '2025-10-22 09:15:00', NULL, 'Chưa phản hồi', NULL),
(32, 57, 'Phòng nhỏ gọn, đủ tiện nghi, giá hợp lý.', 5, '2025-10-23 08:40:00', 'Cảm ơn bạn Đức Anh đã tin tưởng đặt phòng!', 'Đã phản hồi', '2025-10-23 11:20:00'),
(33, 58, 'Không gian yên tĩnh, phù hợp nghỉ dưỡng.', 5, '2025-10-24 10:05:00', 'Rất vui vì bạn Yến hài lòng!', 'Đã phản hồi', '2025-10-24 12:00:00'),
(34, 59, 'Phòng có view đẹp, nhưng điều hòa hơi yếu.', 3, '2025-10-25 09:30:00', NULL, 'Chưa phản hồi', NULL),
(35, 60, 'Nhân viên phục vụ chu đáo, phòng sạch sẽ.', 5, '2025-10-26 08:45:00', 'Cảm ơn bạn Hoa đã đánh giá!', 'Đã phản hồi', '2025-10-26 10:15:00'),
(36, 61, 'Phòng rộng, tiện nghi, rất phù hợp cho gia đình.', 5, '2025-10-27 09:20:00', 'Cảm ơn anh Minh và gia đình đã nghỉ tại homestay!', 'Đã phản hồi', '2025-10-27 11:00:00'),
(37, 62, 'Phòng đẹp nhưng hơi nhỏ, wifi yếu.', 3, '2025-10-28 08:50:00', NULL, 'Chưa phản hồi', NULL),
(38, 63, 'Homestay gần biển, phong cảnh rất đẹp.', 5, '2025-10-29 10:10:00', 'Cảm ơn bạn Huy đã chia sẻ cảm nhận tuyệt vời!', 'Đã phản hồi', '2025-10-29 12:00:00'),
(39, 64, 'Mọi thứ đều ổn, nhân viên thân thiện.', 4, '2025-10-30 09:30:00', NULL, 'Chưa phản hồi', NULL),
(40, 65, 'Phòng tầng cao, tầm nhìn đẹp, nhưng hơi ồn.', 4, '2025-10-31 10:15:00', 'Chúng tôi sẽ cải thiện tốt hơn, cảm ơn bạn Đức Anh!', 'Đã phản hồi', '2025-10-31 11:30:00'),
(41, 66, 'Không gian thoải mái, giá hợp lý, sẽ quay lại!', 5, '2025-11-01 09:00:00', 'Cảm ơn bạn Thu đã tin tưởng đặt phòng!', 'Đã phản hồi', '2025-11-01 10:45:00');
--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `db_account`
--
ALTER TABLE `db_account`
  ADD PRIMARY KEY (`account_id`);

--
-- Chỉ mục cho bảng `db_admin`
--
ALTER TABLE `db_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Chỉ mục cho bảng `db_booking`
--
ALTER TABLE `db_booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `homestay_id` (`homestay_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Chỉ mục cho bảng `db_customer`
--
ALTER TABLE `db_customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Chỉ mục cho bảng `db_homestay`
--
ALTER TABLE `db_homestay`
  ADD PRIMARY KEY (`homestay_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Chỉ mục cho bảng `db_owner`
--
ALTER TABLE `db_owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Chỉ mục cho bảng `db_review`
--
ALTER TABLE `db_review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `db_account`
--
ALTER TABLE `db_account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `db_admin`
--
ALTER TABLE `db_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `db_booking`
--
ALTER TABLE `db_booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `db_customer`
--
ALTER TABLE `db_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `db_homestay`
--
ALTER TABLE `db_homestay`
  MODIFY `homestay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `db_owner`
--
ALTER TABLE `db_owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `db_review`
--
ALTER TABLE `db_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `db_admin`
--
ALTER TABLE `db_admin`
  ADD CONSTRAINT `db_admin_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `db_account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `db_booking`
--
ALTER TABLE `db_booking`
  ADD CONSTRAINT `db_booking_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `db_customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db_booking_ibfk_2` FOREIGN KEY (`homestay_id`) REFERENCES `db_homestay` (`homestay_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `db_customer`
--
ALTER TABLE `db_customer`
  ADD CONSTRAINT `db_customer_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `db_account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `db_homestay`
--
ALTER TABLE `db_homestay`
  ADD CONSTRAINT `db_homestay_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `db_owner` (`owner_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `db_owner`
--
ALTER TABLE `db_owner`
  ADD CONSTRAINT `db_owner_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `db_account` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `db_review`
--
ALTER TABLE `db_review`
  ADD CONSTRAINT `db_review_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `db_booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
