-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2025 at 08:09 PM
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
-- Database: `db_bookinghomestay`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_account`
--

CREATE TABLE `db_account` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sodienthoai` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_account`
--

INSERT INTO `db_account` (`id`, `email`, `sodienthoai`, `password`, `role`) VALUES
(1, 'cvquyet0103@gmail.com', 945613218, '123456', 'admin'),
(2, 'hehe@gmai.com', 816516513, '12345', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `db_chuhomestay`
--

CREATE TABLE `db_chuhomestay` (
  `machuhomestay` varchar(25) NOT NULL,
  `tenchuhomestay` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sodienthoai` int(15) NOT NULL,
  `diachi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_chuhomestay`
--

INSERT INTO `db_chuhomestay` (`machuhomestay`, `tenchuhomestay`, `email`, `sodienthoai`, `diachi`) VALUES
('0', 'Lê Thị Thúy', 'lethuy2025@gmail.com', 912345678, 'Số 18, đường Lý Thường Kiệt, Quận 5, TP. Hồ Chí Minh'),
('CHS01', 'Lê Thị Thúy', 'lethuy2025@gmail.com', 912345678, 'Số 18, đường Lý Thường Kiệt, Quận 5, TP. Hồ Chí Minh'),
('CHS02', 'Phan Văn Hưng', 'phanhung1990@gmail.com', 987654321, 'Số 77, đường Hàng Bài, Hoàn Kiếm, Hà Nội'),
('CHS03', 'Trương Thu Hà', 'truongha1999@gmail.com', 901122334, 'Số 12A, đường Phan Châu Trinh, Hải Châu, Đà Nẵng'),
('CHS04', 'Cao Văn Việt', 'caoviet2001@gmail.com', 976543210, 'Số 3B, đường Trần Phú, Phường 4, Đà Lạt, Lâm Đồng'),
('CHS05', 'Đặng Thanh Nga', 'dangnga1988@gmail.com', 934567890, 'Số 50, đường Thống Nhất, Quận Gò Vấp, TP. Hồ Chí Minh'),
('CHS06', 'Lương Văn Kiệt', 'luongkiet2003@gmail.com', 965432198, 'Số 88, đường Bà Triệu, Phường 9, Vũng Tàu'),
('CHS07', 'Võ Thị Lan Anh', 'voanh1995@gmail.com', 943210987, 'Số 99, đường 3 Tháng 2, Quận 10, TP. Hồ Chí Minh'),
('CHS08', 'Nguyễn Minh Hải', 'nguyenhai1987@gmail.com', 921098765, 'Số 10, đường Hàm Nghi, Quận 1, TP. Hồ Chí Minh'),
('CHS09', 'Trần Đình Lực', 'tranluc1992@gmail.com', 956789012, 'Số 21, đường Hùng Vương, P. Bến Nghé, Quận 1, TP. Hồ Chí Minh'),
('CHS10', 'Tạ Phương Uyên', 'taoyen1998@gmail.com', 998877665, 'Số 456, đường Lê Lợi, P. Bến Thành, Quận 1, TP. Hồ Chí Minh');

-- --------------------------------------------------------

--
-- Table structure for table `db_danhgia`
--

CREATE TABLE `db_danhgia` (
  `madanhgia` varchar(25) NOT NULL,
  `noidung` varchar(255) NOT NULL,
  `diemso` int(5) NOT NULL,
  `ngaydanhgia` date NOT NULL,
  `makhachhang` varchar(25) NOT NULL,
  `mahomestay` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_danhgia`
--

INSERT INTO `db_danhgia` (`madanhgia`, `noidung`, `diemso`, `ngaydanhgia`, `makhachhang`, `mahomestay`) VALUES
('DG001', 'Homestay rất sạch sẽ và tiện nghi.', 5, '2025-05-12', 'KH001', 'HS001'),
('DG002', 'Phòng rộng rãi nhưng view không đẹp lắm.', 4, '2025-05-16', 'KH002', 'HS002'),
('DG003', 'Chủ nhà thân thiện, phòng ấm cúng.', 5, '2025-05-19', 'KH003', 'HS003'),
('DG004', 'Dịch vụ rất tốt, giá cả hợp lý.', 4, '2025-05-24', 'KH004', 'HS004'),
('DG005', 'Vị trí thuận tiện, dễ tìm.', 5, '2025-05-26', 'KH005', 'HS005'),
('DG006', 'Nội thất hơi cũ, cần nâng cấp.', 3, '2025-05-30', 'KH006', 'HS006'),
('DG007', 'Rất hài lòng với kỳ nghỉ, sẽ quay lại.', 5, '2025-06-02', 'KH007', 'HS007'),
('DG008', 'Phòng ồn, cách âm kém.', 2, '2025-06-05', 'KH008', 'HS008'),
('DG009', 'Bữa sáng ngon, không gian yên tĩnh.', 5, '2025-06-10', 'KH009', 'HS009'),
('DG010', 'Phòng sạch, nhưng chăn ga hơi bẩn.', 3, '2025-06-14', 'KH010', 'HS010'),
('DG011', 'Gần trung tâm, tiện đi lại.', 4, '2025-06-17', 'KH011', 'HS011'),
('DG012', 'Mọi thứ đều tuyệt vời, không có gì để phàn nàn.', 5, '2025-06-21', 'KH012', 'HS012'),
('DG013', 'Phòng tắm nhỏ và nước nóng không ổn định.', 3, '2025-06-25', 'KH013', 'HS013'),
('DG014', 'Giá hơi cao so với chất lượng.', 3, '2025-06-28', 'KH014', 'HS014'),
('DG015', 'Nhân viên hỗ trợ nhiệt tình.', 5, '2025-07-01', 'KH015', 'HS015'),
('DG016', 'Cảnh quan đẹp, không khí trong lành.', 5, '2025-07-05', 'KH016', 'HS016'),
('DG017', 'Bữa tối tại homestay rất ngon.', 5, '2025-07-09', 'KH017', 'HS017'),
('DG018', 'Phòng không được dọn dẹp thường xuyên.', 2, '2025-07-14', 'KH018', 'HS018'),
('DG019', 'Tiện nghi đầy đủ, đúng như mô tả.', 4, '2025-07-17', 'KH019', 'HS019'),
('DG020', 'Wifi yếu, rất khó sử dụng.', 2, '2025-07-20', 'KH020', 'HS020'),
('DG021', 'Vị trí không quá đẹp.', 3, '2025-07-25', 'KH021', 'HS021'),
('DG022', 'Homestay rất đáng tiền.', 5, '2025-07-28', 'KH022', 'HS022'),
('DG023', 'Dịch vụ giặt là chậm.', 3, '2025-08-01', 'KH023', 'HS023'),
('DG024', 'Rất thoải mái và thư giãn.', 5, '2025-08-04', 'KH024', 'HS024'),
('DG025', 'Bể bơi nhỏ hơn trong ảnh.', 4, '2025-08-09', 'KH025', 'HS025'),
('DG026', 'Sẽ giới thiệu cho bạn bè.', 5, '2025-08-12', 'KH026', 'HS026'),
('DG027', 'Phòng có mùi ẩm mốc.', 2, '2025-08-17', 'KH027', 'HS027'),
('DG028', 'Phù hợp cho chuyến đi ngắn.', 4, '2025-08-19', 'KH028', 'HS028'),
('DG029', 'Chủ nhà dễ tính.', 5, '2025-08-23', 'KH029', 'HS029'),
('DG030', 'Thức ăn không đa dạng.', 3, '2025-08-27', 'KH030', 'HS030'),
('DG031', 'Giá cả hợp lí, tiện nghi đầy đủ.', 4, '2025-08-31', 'KH031', 'HS031'),
('DG032', 'View đẹp, phòng sạch sẽ.', 5, '2025-09-03', 'KH032', 'HS032'),
('DG033', 'Rất gần với các điểm tham quan.', 5, '2025-09-07', 'KH033', 'HS033'),
('DG034', 'Chăn ga cũ và bẩn.', 2, '2025-09-12', 'KH034', 'HS034'),
('DG035', 'Phòng yên tĩnh, thoải mái.', 5, '2025-09-15', 'KH035', 'HS035'),
('DG036', 'Phòng có mùi lạ.', 2, '2025-09-18', 'KH036', 'HS036'),
('DG037', 'Không gian đẹp và lãng mạn.', 5, '2025-09-22', 'KH037', 'HS037'),
('DG038', 'Rất hài lòng về chất lượng.', 5, '2025-09-25', 'KH038', 'HS038'),
('DG039', 'Giao thông hơi khó khăn.', 3, '2025-09-30', 'KH039', 'HS039'),
('DG040', 'Phòng có view tuyệt đẹp.', 5, '2025-10-03', 'KH040', 'HS040'),
('DG041', 'Phòng không sạch sẽ.', 2, '2025-10-07', 'KH041', 'HS041'),
('DG042', 'Dịch vụ rất chậm.', 2, '2025-10-10', 'KH042', 'HS042'),
('DG043', 'Homestay dễ thương.', 5, '2025-10-14', 'KH043', 'HS043'),
('DG044', 'Bãi đậu xe quá xa.', 3, '2025-10-18', 'KH044', 'HS044'),
('DG045', 'Giá cả hợp lí, rất đáng để thử.', 5, '2025-10-22', 'KH045', 'HS045'),
('DG046', 'Mọi thứ đều đúng như mong đợi.', 5, '2025-10-26', 'KH046', 'HS046'),
('DG047', 'Dịch vụ ăn uống tốt.', 4, '2025-10-28', 'KH047', 'HS047'),
('DG048', 'Phòng tắm bị tắc.', 2, '2025-11-01', 'KH048', 'HS048'),
('DG049', 'Không gian yên tĩnh, rất phù hợp để nghỉ ngơi.', 5, '2025-11-06', 'KH049', 'HS049'),
('DG050', 'Bữa sáng đơn điệu, không đa dạng.', 3, '2025-11-08', 'KH050', 'HS050');

-- --------------------------------------------------------

--
-- Table structure for table `db_dondatphong`
--

CREATE TABLE `db_dondatphong` (
  `madatphong` varchar(25) NOT NULL,
  `ngaydat` date NOT NULL,
  `ngaynhanphong` date NOT NULL,
  `ngaytraphong` date NOT NULL,
  `sokhach` int(10) NOT NULL,
  `trangthai` varchar(50) NOT NULL,
  `makhachhang` varchar(50) NOT NULL,
  `maphong` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_dondatphong`
--

INSERT INTO `db_dondatphong` (`madatphong`, `ngaydat`, `ngaynhanphong`, `ngaytraphong`, `sokhach`, `trangthai`, `makhachhang`, `maphong`) VALUES
('DP001', '2025-05-01', '2025-05-09', '2025-05-11', 2, 'Đã xác nhận', 'KH001', 'P001'),
('DP002', '2025-05-03', '2025-05-12', '2025-05-15', 4, 'Chờ xử lí', 'KH002', 'P002'),
('DP003', '2025-05-08', '2025-05-16', '2025-05-19', 2, 'Đã xác nhận', 'KH003', 'P003'),
('DP004', '2025-05-11', '2025-05-21', '2025-05-24', 4, 'Đã xác nhận', 'KH004', 'P004'),
('DP005', '2025-05-15', '2025-05-23', '2025-05-26', 2, 'Chờ xử lí', 'KH005', 'P005'),
('DP006', '2025-05-18', '2025-05-28', '2025-05-30', 4, 'Đã xác nhận', 'KH006', 'P006'),
('DP007', '2025-05-22', '2025-05-30', '2025-06-02', 2, 'Đã xác nhận', 'KH007', 'P007'),
('DP008', '2025-05-25', '2025-06-03', '2025-06-05', 2, 'Chờ xử lí', 'KH008', 'P008'),
('DP009', '2025-05-29', '2025-06-08', '2025-06-10', 2, 'Đã xác nhận', 'KH009', 'P009'),
('DP010', '2025-06-02', '2025-06-11', '2025-06-14', 4, 'Đã xác nhận', 'KH010', 'P010'),
('DP011', '2025-06-06', '2025-06-15', '2025-06-17', 2, 'Chờ xử lí', 'KH011', 'P011'),
('DP012', '2025-06-09', '2025-06-19', '2025-06-21', 2, 'Đã xác nhận', 'KH012', 'P012'),
('DP013', '2025-06-13', '2025-06-22', '2025-06-25', 4, 'Đã xác nhận', 'KH013', 'P013'),
('DP014', '2025-06-16', '2025-06-26', '2025-06-28', 2, 'Chờ xử lí', 'KH014', 'P014'),
('DP015', '2025-06-20', '2025-06-28', '2025-07-01', 4, 'Đã xác nhận', 'KH015', 'P015'),
('DP016', '2025-06-23', '2025-07-03', '2025-07-05', 6, 'Đã xác nhận', 'KH016', 'P016'),
('DP017', '2025-06-28', '2025-07-07', '2025-07-09', 10, 'Chờ xử lí', 'KH017', 'P017'),
('DP018', '2025-07-01', '2025-07-11', '2025-07-14', 2, 'Đã xác nhận', 'KH018', 'P018'),
('DP019', '2025-07-05', '2025-07-15', '2025-07-17', 2, 'Đã xác nhận', 'KH019', 'P019'),
('DP020', '2025-07-09', '2025-07-18', '2025-07-20', 4, 'Chờ xử lí', 'KH020', 'P020'),
('DP021', '2025-07-12', '2025-07-22', '2025-07-25', 2, 'Đã xác nhận', 'KH021', 'P021'),
('DP022', '2025-07-15', '2025-07-25', '2025-07-28', 2, 'Đã xác nhận', 'KH022', 'P022'),
('DP023', '2025-07-19', '2025-07-29', '2025-08-01', 4, 'Chờ xử lí', 'KH023', 'P023'),
('DP024', '2025-07-23', '2025-08-02', '2025-08-04', 2, 'Đã xác nhận', 'KH024', 'P024'),
('DP025', '2025-07-27', '2025-08-06', '2025-08-09', 2, 'Chờ xử lí', 'KH025', 'P025'),
('DP026', '2025-07-31', '2025-08-10', '2025-08-12', 2, 'Đã xác nhận', 'KH026', 'P026'),
('DP027', '2025-08-04', '2025-08-14', '2025-08-17', 2, 'Đã xác nhận', 'KH027', 'P027'),
('DP028', '2025-08-07', '2025-08-17', '2025-08-19', 1, 'Chờ xử lí', 'KH028', 'P028'),
('DP029', '2025-08-11', '2025-08-21', '2025-08-23', 2, 'Đã xác nhận', 'KH029', 'P029'),
('DP030', '2025-08-15', '2025-08-25', '2025-08-27', 4, 'Đã xác nhận', 'KH030', 'P030'),
('DP031', '2025-08-18', '2025-08-28', '2025-08-31', 2, 'Chờ xử lí', 'KH031', 'P031'),
('DP032', '2025-08-22', '2025-09-01', '2025-09-03', 2, 'Đã xác nhận', 'KH032', 'P032'),
('DP033', '2025-08-26', '2025-09-05', '2025-09-07', 2, 'Đã xác nhận', 'KH033', 'P033'),
('DP034', '2025-08-30', '2025-09-09', '2025-09-12', 2, 'Chờ xử lí', 'KH034', 'P034'),
('DP035', '2025-09-03', '2025-09-13', '2025-09-15', 2, 'Đã xác nhận', 'KH035', 'P035'),
('DP036', '2025-09-07', '2025-09-16', '2025-09-18', 4, 'Đã xác nhận', 'KH036', 'P036'),
('DP037', '2025-09-10', '2025-09-19', '2025-09-22', 2, 'Chờ xử lí', 'KH037', 'P037'),
('DP038', '2025-09-14', '2025-09-23', '2025-09-25', 2, 'Đã xác nhận', 'KH038', 'P038'),
('DP039', '2025-09-18', '2025-09-27', '2025-09-30', 2, 'Chờ xử lí', 'KH039', 'P039'),
('DP040', '2025-09-21', '2025-10-01', '2025-10-03', 2, 'Đã xác nhận', 'KH040', 'P040'),
('DP041', '2025-09-25', '2025-10-04', '2025-10-07', 2, 'Đã xác nhận', 'KH041', 'P041'),
('DP042', '2025-09-28', '2025-10-08', '2025-10-10', 2, 'Chờ xử lí', 'KH042', 'P042'),
('DP043', '2025-10-02', '2025-10-12', '2025-10-14', 2, 'Đã xác nhận', 'KH043', 'P043'),
('DP044', '2025-10-06', '2025-10-16', '2025-10-18', 2, 'Đã xác nhận', 'KH044', 'P044'),
('DP045', '2025-10-09', '2025-10-19', '2025-10-22', 2, 'Chờ xử lí', 'KH045', 'P045'),
('DP046', '2025-10-13', '2025-10-23', '2025-10-26', 2, 'Đã xác nhận', 'KH046', 'P046'),
('DP047', '2025-10-16', '2025-10-26', '2025-10-28', 4, 'Đã xác nhận', 'KH047', 'P047'),
('DP048', '2025-10-20', '2025-10-30', '2025-11-01', 2, 'Chờ xử lí', 'KH048', 'P048'),
('DP049', '2025-10-24', '2025-11-03', '2025-11-06', 2, 'Đã xác nhận', 'KH049', 'P049'),
('DP050', '2025-10-27', '2025-11-06', '2025-11-08', 2, 'Đã xác nhận', 'KH050', 'P050');

-- --------------------------------------------------------

--
-- Table structure for table `db_giaodich`
--

CREATE TABLE `db_giaodich` (
  `magiaodich` varchar(25) NOT NULL,
  `sotien` decimal(10,0) NOT NULL,
  `phuongthucthanhtoan` varchar(50) NOT NULL,
  `ngaygiaodich` datetime NOT NULL,
  `trangthai` varchar(50) NOT NULL,
  `madatphong` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_giaodich`
--

INSERT INTO `db_giaodich` (`magiaodich`, `sotien`, `phuongthucthanhtoan`, `ngaygiaodich`, `trangthai`, `madatphong`) VALUES
('GD001', 1850000, 'Chuyển khoản', '2025-05-08 10:30:00', 'Đã thanh toán', 'DP001'),
('GD002', 2250000, 'Thẻ tín dụng', '2025-05-24 14:15:00', 'Chờ thanh toán', 'DP002'),
('GD003', 2500000, 'Chuyển khoản', '2025-05-15 11:00:00', 'Đã thanh toán', 'DP003'),
('GD004', 1900000, 'Tiền mặt', '2025-06-01 09:45:00', 'Chờ thanh toán', 'DP004'),
('GD005', 1400000, 'Thẻ tín dụng', '2025-05-22 16:20:00', 'Đã thanh toán', 'DP005'),
('GD006', 5000000, 'Chuyển khoản', '2025-06-17 13:10:00', 'Chờ thanh toán', 'DP006'),
('GD007', 1600000, 'Tiền mặt', '2025-06-29 08:50:00', 'Đã thanh toán', 'DP007'),
('GD008', 1800000, 'Thẻ tín dụng', '2025-06-04 17:30:00', 'Chờ thanh toán', 'DP008'),
('GD009', 1500000, 'Chuyển khoản', '2025-07-08 10:15:00', 'Đã thanh toán', 'DP009'),
('GD010', 3600000, 'Tiền mặt', '2025-06-27 15:00:00', 'Chờ thanh toán', 'DP010'),
('GD011', 1700000, 'Thẻ tín dụng', '2025-07-14 11:45:00', 'Đã thanh toán', 'DP011'),
('GD012', 2400000, 'Chuyển khoản', '2025-07-28 12:30:00', 'Chờ thanh toán', 'DP012'),
('GD013', 4400000, 'Tiền mặt', '2025-07-22 14:00:00', 'Đã thanh toán', 'DP013'),
('GD014', 2600000, 'Thẻ tín dụng', '2025-08-08 16:50:00', 'Chờ thanh toán', 'DP014'),
('GD015', 2500000, 'Chuyển khoản', '2025-08-06 09:00:00', 'Đã thanh toán', 'DP015'),
('GD016', 4800000, 'Tiền mặt', '2025-08-22 11:20:00', 'Chờ thanh toán', 'DP016'),
('GD017', 500000, 'Thẻ tín dụng', '2025-08-14 13:40:00', 'Đã thanh toán', 'DP017'),
('GD018', 1600000, 'Chuyển khoản', '2025-08-28 10:00:00', 'Chờ thanh toán', 'DP018'),
('GD019', 1500000, 'Tiền mặt', '2025-08-19 15:30:00', 'Đã thanh toán', 'DP019'),
('GD020', 1900000, 'Thẻ tín dụng', '2025-09-04 12:55:00', 'Chờ thanh toán', 'DP020'),
('GD021', 1760000, 'Chuyển khoản', '2025-09-10 14:10:00', 'Đã thanh toán', 'DP021'),
('GD022', 1840000, 'Tiền mặt', '2025-09-25 09:20:00', 'Chờ thanh toán', 'DP022'),
('GD023', 2900000, 'Thẻ tín dụng', '2025-09-16 16:45:00', 'Đã thanh toán', 'DP023'),
('GD024', 1500000, 'Chuyển khoản', '2025-10-01 10:05:00', 'Chờ thanh toán', 'DP024'),
('GD025', 1800000, 'Tiền mặt', '2025-09-23 13:15:00', 'Đã thanh toán', 'DP025'),
('GD026', 2100000, 'Thẻ tín dụng', '2025-10-09 11:00:00', 'Chờ thanh toán', 'DP026'),
('GD027', 1400000, 'Chuyển khoản', '2025-09-27 08:30:00', 'Đã thanh toán', 'DP027'),
('GD028', 1000000, 'Tiền mặt', '2025-10-15 17:00:00', 'Chờ thanh toán', 'DP028'),
('GD029', 2200000, 'Thẻ tín dụng', '2025-10-05 10:45:00', 'Đã thanh toán', 'DP029'),
('GD030', 3700000, 'Chuyển khoản', '2025-10-23 14:50:00', 'Chờ thanh toán', 'DP030'),
('GD031', 1700000, 'Tiền mặt', '2025-10-12 11:30:00', 'Đã thanh toán', 'DP031'),
('GD032', 2400000, 'Thẻ tín dụng', '2025-10-31 16:00:00', 'Chờ thanh toán', 'DP032'),
('GD033', 1700000, 'Chuyển khoản', '2025-10-29 09:40:00', 'Đã thanh toán', 'DP033'),
('GD034', 1900000, 'Tiền mặt', '2025-11-05 15:25:00', 'Chờ thanh toán', 'DP034'),
('GD035', 2000000, 'Thẻ tín dụng', '2025-11-13 12:15:00', 'Đã thanh toán', 'DP035'),
('GD036', 3000000, 'Chuyển khoản', '2025-11-20 14:35:00', 'Chờ thanh toán', 'DP036'),
('GD037', 2200000, 'Tiền mặt', '2025-11-18 10:50:00', 'Đã thanh toán', 'DP037'),
('GD038', 1800000, 'Thẻ tín dụng', '2025-11-27 16:10:00', 'Chờ thanh toán', 'DP038'),
('GD039', 2200000, 'Chuyển khoản', '2025-11-25 11:00:00', 'Đã thanh toán', 'DP039'),
('GD040', 2000000, 'Tiền mặt', '2025-12-08 14:40:00', 'Chờ thanh toán', 'DP040'),
('GD041', 2400000, 'Thẻ tín dụng', '2025-12-02 09:25:00', 'Đã thanh toán', 'DP041'),
('GD042', 1900000, 'Chuyển khoản', '2025-12-16 12:00:00', 'Chờ thanh toán', 'DP042'),
('GD043', 2200000, 'Tiền mặt', '2025-12-10 15:15:00', 'Đã thanh toán', 'DP043'),
('GD044', 2200000, 'Thẻ tín dụng', '2025-12-25 13:50:00', 'Chờ thanh toán', 'DP044'),
('GD045', 1500000, 'Chuyển khoản', '2025-12-17 10:20:00', 'Đã thanh toán', 'DP045'),
('GD046', 2600000, 'Tiền mặt', '2025-12-30 11:40:00', 'Chờ thanh toán', 'DP046'),
('GD047', 2200000, 'Thẻ tín dụng', '2025-12-23 15:00:00', 'Đã thanh toán', 'DP047'),
('GD048', 1500000, 'Chuyển khoản', '2026-01-02 12:45:00', 'Chờ thanh toán', 'DP048'),
('GD049', 1600000, 'Tiền mặt', '2025-12-29 09:10:00', 'Đã thanh toán', 'DP049'),
('GD050', 1900000, 'Thẻ tín dụng', '2026-01-13 14:30:00', 'Chờ thanh toán', 'DP050');

-- --------------------------------------------------------

--
-- Table structure for table `db_homestay`
--

CREATE TABLE `db_homestay` (
  `mahomestay` varchar(25) NOT NULL,
  `tenhomestay` varchar(50) NOT NULL,
  `diachi` varchar(50) NOT NULL,
  `mota` varchar(255) NOT NULL,
  `hinhanh` varchar(50) NOT NULL,
  `tiennghi` varchar(255) NOT NULL,
  `machuhomestay` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_homestay`
--

INSERT INTO `db_homestay` (`mahomestay`, `tenhomestay`, `diachi`, `mota`, `hinhanh`, `tiennghi`, `machuhomestay`) VALUES
('HS011', 'The Secret Garden Homestay', 'Đà Nẵng', 'Một không gian riêng tư, yên tĩnh với khu vườn xanh mát.', 'secret_garden.png', 'Sân thượng, bếp chung, chỗ đậu xe miễn phí', 'CH011'),
('HS012', 'Cozy Nest Homestay', 'Hà Nội', 'Căn hộ nhỏ nhắn, ấm cúng, phù hợp cho những chuyến đi ngắn ngày.', 'cozy_nest.jpg', 'TV thông minh, máy sưởi, khu vực làm việc', 'CH012'),
('HS013', 'Green Farmstay & Camping', 'Lâm Đồng', 'Trải nghiệm cuộc sống nông trại, cắm trại và thưởng thức không khí trong lành.', 'green_farmstay.jpeg', 'Lều cắm trại, bếp nướng, tour hái rau', 'CH013'),
('HS014', 'Mui Ne Ocean Cottage', 'Mũi Né', 'Nhà gỗ ven biển, gần các bãi tắm nổi tiếng.', 'ocean_cottage.jpg', 'Sân hiên, võng, cho thuê xe đạp', 'CH014'),
('HS015', 'Da Lat Pine Hill', 'Đà Lạt', 'Ngôi nhà trên đồi thông, view săn mây lý tưởng.', 'pine_hill.png', 'Lò sưởi, nhà kính, trà chiều miễn phí', 'CH015'),
('HS016', 'City View Loft', 'TP.HCM', 'Căn hộ gác mái với tầm nhìn toàn cảnh thành phố.', 'city_view_loft.jpg', 'Bếp đầy đủ, hồ bơi trên sân thượng, gym', 'CH016'),
('HS017', 'Tam Coc River Retreat', 'Ninh Bình', 'Homestay ven sông, yên bình, gần các điểm tham quan.', 'river_retreat.jpeg', 'Thuyền, xe đạp, bữa ăn địa phương', 'CH017'),
('HS018', 'Ha Giang Mountain Lodge', 'Hà Giang', 'Nằm giữa núi non hùng vĩ, trải nghiệm văn hóa dân tộc.', 'mountain_lodge.png', 'Lửa trại, bữa tối chung, tour đi bộ đường dài', 'CH018'),
('HS019', 'Can Tho Floating House', 'Cần Thơ', 'Ngôi nhà nổi trên sông, độc đáo và gần chợ nổi.', 'floating_house.jpg', 'Chèo xuồng, tour chợ nổi, bữa sáng miễn phí', 'CH019'),
('HS020', 'Phu Quoc Palm Tree Villa', 'Phú Quốc', 'Biệt thự có hồ bơi riêng, nằm gần bãi biển.', 'palm_tree_villa.jpeg', 'Hồ bơi, bãi đậu xe riêng, nhà hàng', 'CH020'),
('HS021', 'Quy Nhon Bay House', 'Quy Nhơn', 'Ngôi nhà bên vịnh, thiết kế tối giản, gần gũi với thiên nhiên.', 'bay_house.png', 'Bếp chung, ban công, cho thuê xe máy', 'CH021'),
('HS022', 'The Hoi An Hideaway', 'Hội An', 'Một nơi ẩn mình, yên tĩnh, cách phố cổ không xa.', 'hoian_hideaway.jpg', 'Sân vườn, hồ bơi, trà miễn phí', 'CH022'),
('HS023', 'Hue Ancient Garden', 'Huế', 'Thiết kế sân vườn mang phong cách Huế, gần chùa Thiên Mụ.', 'ancient_garden.jpeg', 'Hồ cá, chòi nghỉ, cho thuê áo dài', 'CH023'),
('HS024', 'Con Dao Island Escape', 'Côn Đảo', 'Tận hưởng vẻ đẹp hoang sơ của đảo, homestay gần bãi tắm.', 'island_escape.png', 'Cho thuê xe máy, bữa sáng, xe đưa đón sân bay', 'CH024'),
('HS025', 'Ha Noi Old Quarter Nest', 'Hà Nội', 'Nằm sâu trong khu phố cổ, thuận tiện đi lại.', 'old_quarter_nest.jpg', 'Bếp nhỏ, máy giặt, dịch vụ phòng', 'CH025'),
('HS026', 'Sapa Terrace Fields', 'Sapa', 'Homestay với view ruộng bậc thang, trải nghiệm văn hóa dân tộc.', 'terrace_fields.jpeg', 'Tour đi bộ, bữa ăn địa phương, lửa trại', 'CH026'),
('HS027', 'Dalat City Center House', 'Đà Lạt', 'Vị trí trung tâm thành phố, gần chợ và các điểm tham quan.', 'city_center_house.png', 'Bếp chung, máy sưởi, ban công', 'CH027'),
('HS028', 'Saigon Art House', 'TP.HCM', 'Căn hộ có thiết kế nghệ thuật, độc đáo.', 'art_house.jpg', 'Sách, tranh vẽ, khu vực làm việc', 'CH028'),
('HS029', 'Mui Ne Sand Dune Lodge', 'Mũi Né', 'Homestay gần đồi cát, phù hợp cho người thích khám phá.', 'sand_dune_lodge.jpeg', 'Cho thuê ván trượt cát, bữa sáng miễn phí', 'CH029'),
('HS030', 'Nha Trang Island Retreat', 'Nha Trang', 'Nằm trên đảo nhỏ, yên tĩnh, riêng tư.', 'island_retreat.png', 'Tắm biển, lặn, chèo thuyền kayak', 'CH030'),
('HS031', 'Da Nang Beachfront Villa', 'Đà Nẵng', 'Biệt thự hướng biển, có hồ bơi riêng.', 'beachfront_villa.jpg', 'Bếp đầy đủ, hồ bơi riêng, bãi đậu xe', 'CH031'),
('HS032', 'Ha Noi West Lake House', 'Hà Nội', 'Ngôi nhà ven Hồ Tây, không gian thoáng đãng.', 'west_lake_house.jpeg', 'Sân thượng, ban công, view hồ', 'CH032'),
('HS033', 'Can Tho Eco Lodge', 'Cần Thơ', 'Khu nghỉ dưỡng sinh thái, trải nghiệm cuộc sống miền sông nước.', 'eco_lodge.png', 'Tắm nắng, thuyền, vườn trái cây', 'CH033'),
('HS034', 'Hoi An Riverside Homestay', 'Hội An', 'Nằm bên bờ sông Hoài, gần phố cổ.', 'riverside_homestay.jpg', 'Bữa sáng, xe đạp miễn phí, ban công', 'CH034'),
('HS035', 'Dalat Flower Garden', 'Đà Lạt', 'Homestay nằm trong khu vườn hoa rực rỡ.', 'flower_garden.jpeg', 'Vườn hoa, khu vực nướng BBQ, trà chiều', 'CH035'),
('HS036', 'Hue Garden House', 'Huế', 'Nhà vườn truyền thống, yên tĩnh và thanh bình.', 'garden_house.png', 'Vườn cây, ao cá, bữa ăn địa phương', 'CH036'),
('HS037', 'Vung Tau Lighthouse View', 'Vũng Tàu', 'Căn hộ có tầm nhìn ra ngọn hải đăng và biển.', 'lighthouse_view.jpg', 'Bếp đầy đủ, TV, bãi đậu xe', 'CH037'),
('HS038', 'Ha Long Bay Island Lodge', 'Hạ Long', 'Nằm trên hòn đảo, độc đáo và riêng tư.', 'island_lodge.jpeg', 'Thuyền, cho thuê kayak, bữa ăn hải sản', 'CH038'),
('HS039', 'Phu Quoc Starfish Beach House', 'Phú Quốc', 'Gần bãi Sao, không gian mở và thoáng đãng.', 'starfish_beach.png', 'Bếp, võng, dịch vụ cho thuê xe', 'CH039'),
('HS040', 'Quy Nhon City Center', 'Quy Nhơn', 'Homestay ở trung tâm thành phố, gần chợ đêm.', 'city_center_quynhon.jpg', 'Bếp chung, máy giặt, điều hòa', 'CH040'),
('HS041', 'Mui Ne Red Sand Hill Villa', 'Mũi Né', 'Gần đồi cát đỏ, phù hợp cho các hoạt động ngoài trời.', 'red_sand_hill.jpeg', 'Hồ bơi, sân hiên, cho thuê ván trượt', 'CH041'),
('HS042', 'Can Tho River View Villa', 'Cần Thơ', 'Biệt thự ven sông, có khu vực nướng BBQ.', 'river_view_villa.png', 'Bếp, bàn ăn ngoài trời, view sông', 'CH042'),
('HS043', 'Tam Dao Hillside Homestay', 'Tam Đảo', 'Nằm trên sườn đồi, view thung lũng.', 'hillside_homestay.jpg', 'Bếp chung, ban công, lò sưởi', 'CH043'),
('HS044', 'Sapa Rice Field Retreat', 'Sapa', 'Homestay nhìn ra ruộng bậc thang, trải nghiệm văn hóa bản địa.', 'rice_field_retreat.jpeg', 'Tour đi bộ, bữa ăn địa phương, lửa trại', 'CH044'),
('HS045', 'The Ha Noi Rooftop', 'Hà Nội', 'Căn hộ có sân thượng rộng, view thành phố.', 'rooftop_hanoi.png', 'Bếp, khu vực nướng BBQ, máy giặt', 'CH045'),
('HS046', 'Dalat Lake House', 'Đà Lạt', 'Ngôi nhà bên hồ, yên bình và lãng mạn.', 'lake_house.jpg', 'Bếp, thuyền kayak, sân vườn', 'CH046'),
('HS047', 'Hoi An Lantern House', 'Hội An', 'Homestay có nhiều đèn lồng, mang đậm nét phố cổ.', 'lantern_house.jpeg', 'Đèn lồng, xe đạp, bữa sáng', 'CH047'),
('HS048', 'Saigon Old Apartment', 'TP.HCM', 'Căn hộ trong chung cư cũ, phong cách hoài cổ.', 'old_apartment.png', 'Bếp nhỏ, máy giặt, khu vực làm việc', 'CH048'),
('HS049', 'Ninh Binh Eco Garden', 'Ninh Bình', 'Khu nghỉ dưỡng sinh thái, gần Tam Cốc Bích Động.', 'eco_garden.jpg', 'Vườn cây, chòi nghỉ, cho thuê xe đạp', 'CH049'),
('HS050', 'Ha Giang Rocky Plateau', 'Hà Giang', 'Nằm giữa cao nguyên đá, trải nghiệm cuộc sống người dân tộc.', 'rocky_plateau.jpeg', 'Bếp lửa, bữa tối chung, tour xe máy', 'CH050');

-- --------------------------------------------------------

--
-- Table structure for table `db_khachhang`
--

CREATE TABLE `db_khachhang` (
  `makhachhang` varchar(25) NOT NULL,
  `tenkhachhang` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sodienthoai` int(11) NOT NULL,
  `ngaysinh` date NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `gioitinh` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_khachhang`
--

INSERT INTO `db_khachhang` (`makhachhang`, `tenkhachhang`, `email`, `sodienthoai`, `ngaysinh`, `diachi`, `gioitinh`) VALUES
('KH001', 'Lê Gia Bảo', 'legiabao1995@gmail.com', 912345678, '1995-03-20', '123 Nguyễn Trãi, Quận 1, TP. Hồ Chí Minh', 'Nam'),
('KH002', 'Hoàng Mỹ Linh', 'hoangmylinh1988@gmail.com', 987654321, '1988-07-15', '456 Lê Lợi, Hải Châu, Đà Nẵng', 'Nữ'),
('KH003', 'Nguyễn Minh Khang', 'nguyenminhkhang1990@gmail.com', 901122334, '1990-01-05', '789 Trần Phú, Quận Ba Đình, Hà Nội', 'Nam'),
('KH004', 'Trần Thị Mai', 'tranthimai1992@gmail.com', 976543210, '1992-11-20', '101 Võ Văn Kiệt, Quận 1, TP. Hồ Chí Minh', 'Nữ'),
('KH005', 'Phạm Văn Hùng', 'phamvanhung1987@gmail.com', 934567890, '1987-09-10', '202 Phan Bội Châu, Hoàn Kiếm, Hà Nội', 'Nam'),
('KH006', 'Vũ Thị Thanh', 'vuthithanh1993@gmail.com', 965432198, '1993-05-08', '303 Lý Thường Kiệt, Quận 5, TP. Hồ Chí Minh', 'Nữ'),
('KH007', 'Đỗ Văn Tùng', 'dovantung1991@gmail.com', 943210987, '1991-04-22', '404 Cầu Giấy, Quận Cầu Giấy, Hà Nội', 'Nam'),
('KH008', 'Bùi Thanh Hiền', 'buithanhhien1989@gmail.com', 921098765, '1989-12-30', '505 Nguyễn Văn Linh, Hải An, Hải Phòng', 'Nữ'),
('KH009', 'Mai Trọng Kiên', 'maitrongkien1994@gmail.com', 956789012, '1994-08-18', '606 Hùng Vương, Quận Ninh Kiều, Cần Thơ', 'Nam'),
('KH010', 'Đinh Thu Hương', 'đinhthuhuong1996@gmail.com', 998877665, '1996-02-25', '707 Lê Duẩn, Quận 1, TP. Hồ Chí Minh', 'Nữ'),
('KH011', 'Cao Việt Anh', 'caovietanh1997@gmail.com', 912345679, '1997-06-12', '808 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh', 'Nam'),
('KH012', 'Nguyễn Thị Lan', 'nguyenthilan1985@gmail.com', 987654322, '1985-10-01', '909 Hai Bà Trưng, Quận 3, TP. Hồ Chí Minh', 'Nữ'),
('KH013', 'Huỳnh Quốc Bảo', 'huynhquocbao1989@gmail.com', 901122335, '1989-03-09', '110 Trường Chinh, Quận Thanh Xuân, Hà Nội', 'Nam'),
('KH014', 'Lê Thanh Thúy', 'lethanhthuy1990@gmail.com', 976543211, '1990-07-28', '120 Bạch Đằng, Quận Bình Thạnh, TP. Hồ Chí Minh', 'Nữ'),
('KH015', 'Trịnh Quang Minh', 'trinhquangminh1993@gmail.com', 934567891, '1993-01-15', '130 Hàng Bông, Hoàn Kiếm, Hà Nội', 'Nam'),
('KH016', 'Phạm Hồng Ngọc', 'phamhongngoc1995@gmail.com', 965432199, '1995-06-03', '140 Nguyễn Đình Chiểu, Quận 3, TP. Hồ Chí Minh', 'Nữ'),
('KH017', 'Nguyễn Văn Trọng', 'nguyenvantrong1991@gmail.com', 943210988, '1991-09-17', '150 Láng Hạ, Đống Đa, Hà Nội', 'Nam'),
('KH018', 'Đặng Thị Kim', 'dangthikim1994@gmail.com', 921098766, '1994-02-05', '160 Phan Văn Trị, Quận Gò Vấp, TP. Hồ Chí Minh', 'Nữ'),
('KH019', 'Tạ Đình Hùng', 'tadihnhung1988@gmail.com', 956789013, '1988-11-29', '170 Hồ Tùng Mậu, Quận 1, TP. Hồ Chí Minh', 'Nam'),
('KH020', 'Lương Thị Hoa', 'luongthihoa1996@gmail.com', 998877666, '1996-03-14', '180 Nguyễn Thị Minh Khai, Quận 3, TP. Hồ Chí Minh', 'Nữ'),
('KH021', 'Huỳnh Văn Dũng', 'huynhvandung1990@gmail.com', 912345680, '1990-07-07', '190 Cách Mạng Tháng Tám, Quận 3, TP. Hồ Chí Minh', 'Nam'),
('KH022', 'Phan Diệu Linh', 'phandieulinh1995@gmail.com', 987654323, '1995-12-01', '200 Tràng Tiền, Quận Hoàn Kiếm, Hà Nội', 'Nữ'),
('KH023', 'Trần Đức Anh', 'tranducanh1987@gmail.com', 901122336, '1987-04-18', '210 Điện Biên Phủ, Quận Ba Đình, Hà Nội', 'Nam'),
('KH024', 'Nguyễn Thị Phương', 'nguyenthiphuong1993@gmail.com', 976543212, '1993-09-25', '220 Thụy Khuê, Quận Tây Hồ, Hà Nội', 'Nữ'),
('KH025', 'Bùi Thế Quân', 'buithequan1988@gmail.com', 934567892, '1988-06-08', '230 Sương Nguyệt Ánh, Quận 1, TP. Hồ Chí Minh', 'Nam'),
('KH026', 'Lê Thị Ánh', 'lethiainh1991@gmail.com', 965432200, '1991-02-14', '240 Nguyễn Văn Cừ, Quận 5, TP. Hồ Chí Minh', 'Nữ'),
('KH027', 'Võ Trọng Nam', 'votrongnam1994@gmail.com', 943210989, '1994-08-19', '250 Nguyễn Tri Phương, Quận 10, TP. Hồ Chí Minh', 'Nam'),
('KH028', 'Đinh Thị Ngân', 'đinhthingan1996@gmail.com', 921098767, '1996-04-28', '260 Phạm Văn Đồng, Quận Gò Vấp, TP. Hồ Chí Minh', 'Nữ'),
('KH029', 'Tôn Thất Việt', 'tonthatviet1990@gmail.com', 956789014, '1990-11-09', '270 Phan Đình Phùng, Quận Ba Đình, Hà Nội', 'Nam'),
('KH030', 'Phan Thị Hoài', 'phanthihoai1985@gmail.com', 998877667, '1985-05-27', '280 Lê Thánh Tôn, Quận 1, TP. Hồ Chí Minh', 'Nữ'),
('KH031', 'Cao Minh Đức', 'caominhduc1989@gmail.com', 912345681, '1989-01-16', '290 Bà Triệu, Quận Hai Bà Trưng, Hà Nội', 'Nam'),
('KH032', 'Nguyễn Thúy Vân', 'nguyenthuyvan1992@gmail.com', 987654324, '1992-06-22', '300 Cầu Ông Lãnh, Quận 1, TP. Hồ Chí Minh', 'Nữ'),
('KH033', 'Đặng Văn Tiến', 'dangvantien1987@gmail.com', 901122337, '1987-10-05', '310 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh', 'Nam'),
('KH034', 'Dương Thị Thảo', 'duongthithao1993@gmail.com', 976543213, '1993-03-09', '320 Lê Văn Sỹ, Quận 3, TP. Hồ Chí Minh', 'Nữ'),
('KH035', 'Bùi Văn Lộc', 'buivanloc1991@gmail.com', 934567893, '1991-09-17', '330 Hoàng Hoa Thám, Quận Tân Bình, TP. Hồ Chí Minh', 'Nam'),
('KH036', 'Lê Thị Kim Chi', 'lethikimchi1994@gmail.com', 965432201, '1994-02-14', '340 Hai Bà Trưng, Hoàn Kiếm, Hà Nội', 'Nữ'),
('KH037', 'Trần Quang Tùng', 'trankuangtung1989@gmail.com', 943210990, '1989-08-28', '350 Sài Gòn, Quận 1, TP. Hồ Chí Minh', 'Nam'),
('KH038', 'Nguyễn Thanh Thảo', 'nguyenthanhthao1995@gmail.com', 921098768, '1995-11-05', '360 Trường Sơn, Quận Tân Bình, TP. Hồ Chí Minh', 'Nữ'),
('KH039', 'Huỳnh Văn Bách', 'huynhvanbach1992@gmail.com', 956789015, '1992-01-20', '370 Nguyễn Đình Chiểu, Quận 3, TP. Hồ Chí Minh', 'Nam'),
('KH040', 'Võ Thị Thảo', 'vothithao1988@gmail.com', 998877668, '1988-06-16', '380 Lý Tự Trọng, Quận 1, TP. Hồ Chí Minh', 'Nữ'),
('KH041', 'Phan Duy Anh', 'phanduyanh1993@gmail.com', 912345682, '1993-10-02', '390 Phan Kế Bính, Quận 1, TP. Hồ Chí Minh', 'Nam'),
('KH042', 'Đỗ Thanh Trúc', 'dothanhtruc1990@gmail.com', 987654325, '1990-04-11', '400 Lương Ngọc Quyến, Hoàn Kiếm, Hà Nội', 'Nữ'),
('KH043', 'Hoàng Anh Tú', 'hoanganhtu1994@gmail.com', 901122338, '1994-09-29', '410 Lý Thái Tổ, Hoàn Kiếm, Hà Nội', 'Nam'),
('KH044', 'Trương Thị Hoa', 'truongthihoa1987@gmail.com', 976543214, '1987-12-19', '420 Hai Bà Trưng, Quận 1, TP. Hồ Chí Minh', 'Nữ'),
('KH045', 'Lê Văn Hùng', 'levanhung1991@gmail.com', 934567894, '1991-02-28', '430 Pasteur, Quận 1, TP. Hồ Chí Minh', 'Nam'),
('KH046', 'Nguyễn Thu Hằng', 'nguyenthuhang1995@gmail.com', 965432202, '1995-07-07', '440 Nam Kỳ Khởi Nghĩa, Quận 3, TP. Hồ Chí Minh', 'Nữ'),
('KH047', 'Trần Văn Phúc', 'tranvanphuc1990@gmail.com', 943210991, '1990-11-20', '450 Trần Hưng Đạo, Quận 5, TP. Hồ Chí Minh', 'Nam'),
('KH048', 'Đặng Thu Huyền', 'dangthuhuyen1996@gmail.com', 921098769, '1996-05-15', '460 An Dương Vương, Quận 5, TP. Hồ Chí Minh', 'Nữ'),
('KH049', 'Bùi Hữu Lộc', 'buihuucloc1988@gmail.com', 956789016, '1988-08-24', '470 Hàm Nghi, Quận 1, TP. Hồ Chí Minh', 'Nam'),
('KH050', 'Mai Anh Thư', 'maianhthu1991@gmail.com', 998877669, '1991-03-03', '480 Lê Duẩn, Quận 1, TP. Hồ Chí Minh', 'Nữ');

-- --------------------------------------------------------

--
-- Table structure for table `db_phong`
--

CREATE TABLE `db_phong` (
  `maphong` varchar(25) NOT NULL,
  `tenphong` varchar(50) NOT NULL,
  `loaiphong` varchar(50) NOT NULL,
  `sogiuong` int(50) NOT NULL,
  `succhua` int(50) NOT NULL,
  `gia` decimal(10,0) NOT NULL,
  `trangthai` varchar(50) NOT NULL,
  `mahomestay` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_phong`
--

INSERT INTO `db_phong` (`maphong`, `tenphong`, `loaiphong`, `sogiuong`, `succhua`, `gia`, `trangthai`, `mahomestay`) VALUES
('P001', 'Phòng Hướng Phố', 'Đôi', 1, 2, 850000, 'Đã cho thuê', 'HS001'),
('P002', 'Phòng Deluxe Hướng Vườn', 'Đôi', 2, 4, 1200000, 'Chưa cho thuê', 'HS002'),
('P003', 'Phòng Executive', 'Đôi', 1, 2, 1500000, 'Đã cho thuê', 'HS003'),
('P004', 'Phòng Gia Đình', 'Gia đình', 2, 4, 950000, 'Chưa cho thuê', 'HS004'),
('P005', 'Phòng Standard', 'Đôi', 1, 2, 700000, 'Đã cho thuê', 'HS005'),
('P006', 'Phòng Suite Hướng Biển', 'Đôi', 2, 4, 2500000, 'Chưa cho thuê', 'HS006'),
('P007', 'Phòng Superior', 'Đôi', 1, 2, 800000, 'Đã cho thuê', 'HS007'),
('P008', 'Phòng Twin', 'Đôi', 2, 2, 900000, 'Chưa cho thuê', 'HS008'),
('P009', 'Phòng Double', 'Đôi', 1, 2, 750000, 'Đã cho thuê', 'HS009'),
('P010', 'Phòng View Vịnh', 'Đôi', 2, 4, 1800000, 'Chưa cho thuê', 'HS010'),
('P011', 'Phòng Hướng Vườn', 'Đôi', 1, 2, 850000, 'Đã cho thuê', 'HS011'),
('P012', 'Phòng Đôi Nhỏ', 'Đôi', 1, 2, 600000, 'Chưa cho thuê', 'HS012'),
('P013', 'Phòng Twin Cao Cấp', 'Đôi', 2, 4, 1100000, 'Đã cho thuê', 'HS013'),
('P014', 'Phòng Bungalow', 'Đôi', 1, 2, 1300000, 'Chưa cho thuê', 'HS014'),
('P015', 'Phòng Deluxe', 'Đôi', 2, 4, 1250000, 'Đã cho thuê', 'HS015'),
('P016', 'Phòng Gia Đình Lớn', 'Gia đình', 3, 6, 1600000, 'Chưa cho thuê', 'HS016'),
('P017', 'Phòng Ngủ Tập Thể', 'Tập thể', 5, 10, 250000, 'Đã cho thuê', 'HS017'),
('P018', 'Phòng Hướng Núi', 'Đôi', 1, 2, 800000, 'Chưa cho thuê', 'HS018'),
('P019', 'Phòng Standard', 'Đôi', 1, 2, 750000, 'Đã cho thuê', 'HS019'),
('P020', 'Phòng View Cánh Đồng', 'Đôi', 2, 4, 950000, 'Chưa cho thuê', 'HS020'),
('P021', 'Phòng Hướng Hồ', 'Đôi', 1, 2, 880000, 'Đã cho thuê', 'HS021'),
('P022', 'Phòng Hướng Sông', 'Đôi', 1, 2, 920000, 'Chưa cho thuê', 'HS022'),
('P023', 'Phòng Hạng Sang', 'Đôi', 2, 4, 1450000, 'Đã cho thuê', 'HS023'),
('P024', 'Phòng Tiêu Chuẩn', 'Đôi', 1, 2, 750000, 'Chưa cho thuê', 'HS024'),
('P025', 'Phòng View Thành Phố', 'Đôi', 1, 2, 900000, 'Đã cho thuê', 'HS025'),
('P026', 'Phòng Tầng Mái', 'Đôi', 1, 2, 1050000, 'Chưa cho thuê', 'HS026'),
('P027', 'Phòng Khép Kín', 'Đôi', 1, 2, 700000, 'Đã cho thuê', 'HS027'),
('P028', 'Phòng Đơn', 'Đơn', 1, 1, 500000, 'Chưa cho thuê', 'HS028'),
('P029', 'Phòng Lãng Mạn', 'Đôi', 1, 2, 1100000, 'Đã cho thuê', 'HS029'),
('P030', 'Phòng Gia Đình Hướng Biển', 'Gia đình', 2, 4, 1850000, 'Chưa cho thuê', 'HS030'),
('P031', 'Phòng Double Có Ban Công', 'Đôi', 1, 2, 900000, 'Đã cho thuê', 'HS031'),
('P032', 'Phòng Nhìn Ra Hồ Tây', 'Đôi', 1, 2, 1200000, 'Chưa cho thuê', 'HS032'),
('P033', 'Phòng Ngủ Riêng', 'Đôi', 1, 2, 850000, 'Đã cho thuê', 'HS033'),
('P034', 'Phòng Hướng Sông', 'Đôi', 1, 2, 950000, 'Chưa cho thuê', 'HS034'),
('P035', 'Phòng View Vườn Hoa', 'Đôi', 1, 2, 1000000, 'Đã cho thuê', 'HS035'),
('P036', 'Phòng Gia Đình Truyền Thống', 'Gia đình', 2, 4, 1500000, 'Chưa cho thuê', 'HS036'),
('P037', 'Phòng Đôi Có Bếp', 'Đôi', 1, 2, 1300000, 'Đã cho thuê', 'HS037'),
('P038', 'Phòng Tiêu Chuẩn', 'Đôi', 1, 2, 900000, 'Chưa cho thuê', 'HS038'),
('P039', 'Phòng Bungalow Gần Biển', 'Đôi', 1, 2, 1600000, 'Đã cho thuê', 'HS039'),
('P040', 'Phòng Đôi Nhìn Ra Thành Phố', 'Đôi', 1, 2, 1000000, 'Chưa cho thuê', 'HS040'),
('P041', 'Phòng View Đồi Cát', 'Đôi', 1, 2, 1200000, 'Đã cho thuê', 'HS041'),
('P042', 'Phòng View Sông', 'Đôi', 1, 2, 950000, 'Chưa cho thuê', 'HS042'),
('P043', 'Phòng Superior View Đồi', 'Đôi', 1, 2, 1100000, 'Đã cho thuê', 'HS043'),
('P044', 'Phòng View Ruộng Bậc Thang', 'Đôi', 1, 2, 800000, 'Chưa cho thuê', 'HS044'),
('P045', 'Phòng Trên Sân Thượng', 'Đôi', 1, 2, 1250000, 'Đã cho thuê', 'HS045'),
('P046', 'Phòng Hướng Hồ', 'Đôi', 1, 2, 900000, 'Chưa cho thuê', 'HS046'),
('P047', 'Phòng Gia Đình', 'Gia đình', 2, 4, 1100000, 'Đã cho thuê', 'HS047'),
('P048', 'Phòng Tiêu Chuẩn', 'Đôi', 1, 2, 750000, 'Chưa cho thuê', 'HS048'),
('P049', 'Phòng View Vườn', 'Đôi', 1, 2, 800000, 'Đã cho thuê', 'HS049'),
('P050', 'Phòng Riêng', 'Đôi', 1, 2, 950000, 'Chưa cho thuê', 'HS050');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_account`
--
ALTER TABLE `db_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `db_chuhomestay`
--
ALTER TABLE `db_chuhomestay`
  ADD PRIMARY KEY (`machuhomestay`);

--
-- Indexes for table `db_danhgia`
--
ALTER TABLE `db_danhgia`
  ADD PRIMARY KEY (`madanhgia`),
  ADD UNIQUE KEY `mahomestay` (`mahomestay`),
  ADD UNIQUE KEY `makhachhang` (`makhachhang`);

--
-- Indexes for table `db_dondatphong`
--
ALTER TABLE `db_dondatphong`
  ADD PRIMARY KEY (`madatphong`),
  ADD UNIQUE KEY `maphong` (`maphong`),
  ADD UNIQUE KEY `makhachhang` (`makhachhang`);

--
-- Indexes for table `db_giaodich`
--
ALTER TABLE `db_giaodich`
  ADD PRIMARY KEY (`magiaodich`),
  ADD UNIQUE KEY `madatphong` (`madatphong`);

--
-- Indexes for table `db_homestay`
--
ALTER TABLE `db_homestay`
  ADD PRIMARY KEY (`mahomestay`),
  ADD UNIQUE KEY `machuhomestay` (`machuhomestay`);

--
-- Indexes for table `db_khachhang`
--
ALTER TABLE `db_khachhang`
  ADD PRIMARY KEY (`makhachhang`);

--
-- Indexes for table `db_phong`
--
ALTER TABLE `db_phong`
  ADD PRIMARY KEY (`maphong`),
  ADD UNIQUE KEY `mahomestay` (`mahomestay`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `db_account`
--
ALTER TABLE `db_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
