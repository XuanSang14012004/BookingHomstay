-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2025 at 01:39 PM
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
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_account`
--

INSERT INTO `db_account` (`fullname`, `email`, `phone`, `password`, `role`) VALUES
('Cao Văn Quyết', 'cvquyet0103@gmail.com', 975456878, '12345', 'user'),
('CaoVanQuyet', 'NVA13@gmail.com', 945561241, '12345', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `db_booking`
--

CREATE TABLE `db_booking` (
  `madondatphong` varchar(10) NOT NULL,
  `makhachhang` varchar(10) NOT NULL,
  `maphong` varchar(10) NOT NULL,
  `tenkhachhang` varchar(255) NOT NULL,
  `ngaydatphong` date NOT NULL,
  `ngaynhanphong` date NOT NULL,
  `ngaytraphong` date NOT NULL,
  `songuoi` int(10) NOT NULL,
  `tongtien` decimal(10,0) NOT NULL,
  `trangthai` varchar(255) NOT NULL,
  `chuthich` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_booking`
--

INSERT INTO `db_booking` (`madondatphong`, `makhachhang`, `maphong`, `tenkhachhang`, `ngaydatphong`, `ngaynhanphong`, `ngaytraphong`, `songuoi`, `tongtien`, `trangthai`, `chuthich`) VALUES
('B_001', 'KH001', 'P_01', 'Nguyễn Văn An', '2024-10-18', '2024-10-20', '2024-10-23', 2, 3600000, 'Đã xác nhận', 'Yêu cầu phòng tầng cao, view đẹp.'),
('B_002', 'KH002', 'P_02', 'Trần Thị Bình', '2024-11-03', '2024-11-05', '2024-11-07', 4, 3000000, 'Đang chờ thanh toán', 'Cần thêm một chiếc nệm phụ.'),
('B_003', 'KH003', 'P_03', 'Lê Văn Cường', '2024-12-08', '2024-12-10', '2024-12-12', 1, 1600000, 'Đã hoàn tất', 'Không có yêu cầu đặc biệt.'),
('B_004', 'KH004', 'P_04', 'Phạm Thị Dung', '2024-10-23', '2024-10-25', '2024-10-28', 2, 7500000, 'Đã xác nhận', 'Đặt thêm dịch vụ đưa đón sân bay.'),
('B_005', 'KH005', 'P_05', 'Hoàng Văn Giang', '2024-11-13', '2024-11-15', '2024-11-18', 2, 9000000, 'Đã xác nhận', 'Cần chuẩn bị một chai rượu vang và hoa hồng.'),
('B_006', 'KH006', 'P_06', 'Đỗ Thị Hương', '2024-11-29', '2024-12-01', '2024-12-03', 8, 1500000, 'Đã hủy', 'Hủy do thay đổi lịch trình cá nhân.'),
('B_007', 'KH007', 'P_07', 'Vũ Văn Khang', '2024-11-18', '2024-11-20', '2024-11-21', 3, 1000000, 'Đã hoàn tất', 'Không có yêu cầu đặc biệt.'),
('B_008', 'KH008', 'P_08', 'Bùi Thị Lan', '2024-12-23', '2024-12-25', '2024-12-28', 2, 5400000, 'Đang chờ thanh toán', 'Sẽ thanh toán sau khi đến nơi.'),
('B_009', 'KH009', 'P_09', 'Lý Văn Minh', '2024-10-28', '2024-10-30', '2024-11-05', 2, 9600000, 'Đã xác nhận', 'Cần được hỗ trợ mang hành lý.'),
('B_010', 'KH010', 'P_10', 'Ngô Thị Oanh', '2024-11-20', '2024-11-22', '2024-11-25', 10, 30000000, 'Đã xác nhận', 'Chuẩn bị tiệc BBQ ngoài trời.');

-- --------------------------------------------------------

--
-- Table structure for table `db_danhgia`
--

CREATE TABLE `db_danhgia` (
  `madanhgia` varchar(10) NOT NULL,
  `makhachhang` varchar(10) NOT NULL,
  `maphong` varchar(10) NOT NULL,
  `tieude` varchar(255) NOT NULL,
  `noidung` varchar(255) NOT NULL,
  `diemdanhgia` float NOT NULL,
  `ngaygui` date NOT NULL,
  `trangthai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_danhgia`
--

INSERT INTO `db_danhgia` (`madanhgia`, `makhachhang`, `maphong`, `tieude`, `noidung`, `diemdanhgia`, `ngaygui`, `trangthai`) VALUES
('DG_001', 'KH001', 'HST_001', 'Rất hài lòng', 'Căn hộ sạch sẽ, tiện nghi đầy đủ và vị trí rất thuận lợi để di chuyển.', 9.5, '2024-10-25', 'Đã duyệt'),
('DG_002', 'KH002', 'HST_002', 'Trải nghiệm tuyệt vời', 'Biệt thự rất đẹp, không gian lãng mạn, yên tĩnh, đúng như mong đợi.', 10, '2024-11-08', 'Đã duyệt'),
('DG_003', 'KH003', 'HST_003', 'Sạch sẽ và thoải mái', 'Mặc dù homestay tạm ngưng nhưng trải nghiệm trước đó rất tốt, sạch sẽ và thoải mái.', 8, '2024-12-15', 'Đã ẩn'),
('DG_004', 'KH004', 'HST_004', 'Tuyệt vời cho kỳ nghỉ', 'Bungalow rất dễ thương, gần gũi thiên nhiên, chủ nhà thân thiện.', 9, '2024-10-28', 'Đã duyệt'),
('DG_005', 'KH005', 'HST_005', 'Sang trọng và tiện nghi', 'Villa có bể bơi riêng, rất sang trọng và đẳng cấp.', 9.8, '2024-11-20', 'Đã duyệt'),
('DG_006', 'KH006', 'HST_006', 'Trải nghiệm đáng nhớ', 'Một nơi tuyệt vời để trốn khỏi cuộc sống ồn ào.', 8.5, '2024-12-05', 'Đã ẩn'),
('DG_007', 'KH007', 'HST_007', 'Vị trí đắc địa', 'Căn hộ nằm ở trung tâm, rất thuận tiện để đi lại, phòng ốc sạch sẽ.', 9.3, '2024-11-22', 'Đang chờ duyệt'),
('DG_008', 'KH008', 'HST_008', 'Đậm chất truyền thống', 'Homestay mang phong cách cổ xưa rất ấn tượng.', 8.8, '2024-12-27', 'Đã duyệt'),
('DG_009', 'KH009', 'HST_009', 'Rất thư giãn', 'Bungalow rất phù hợp cho những ai muốn hòa mình với thiên nhiên.', 9.6, '2024-11-02', 'Đã duyệt'),
('DG_010', 'KH010', 'HST_010', 'Độc đáo và xinh xắn', 'Ngôi nhà nhỏ nhưng đầy đủ tiện nghi, thiết kế rất độc đáo.', 9.4, '2024-11-25', 'Đang chờ duyệt');

-- --------------------------------------------------------

--
-- Table structure for table `db_feedback`
--

CREATE TABLE `db_feedback` (
  `maphanhoi` varchar(255) NOT NULL,
  `makhachhang` varchar(255) NOT NULL,
  `tenkhachhang` varchar(255) NOT NULL,
  `tieude` varchar(255) NOT NULL,
  `noidung` int(255) NOT NULL,
  `ngaygui` date NOT NULL,
  `trangthai` varchar(255) NOT NULL,
  `traloi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_feedback`
--

INSERT INTO `db_feedback` (`maphanhoi`, `makhachhang`, `tenkhachhang`, `tieude`, `noidung`, `ngaygui`, `trangthai`, `traloi`) VALUES
('PH_001', 'KH001', 'Nguyễn Văn An', 'Vấn đề Wifi', 0, '2024-10-23', 'Đã phản hồi', 'Chào anh/chị, chúng tôi rất tiếc về sự bất tiện này. Chúng tôi đã liên hệ với bộ phận kỹ thuật để kiểm tra và khắc phục ngay lập tức.'),
('PH_002', 'KH002', 'Trần Thị Bình', 'Thiếu chăn', 0, '2024-11-07', 'Đã phản hồi', 'Chào anh/chị, chúng tôi đã yêu cầu nhân viên mang thêm chăn lên phòng. Cảm ơn phản hồi kịp thời của bạn.'),
('PH_003', 'KH003', 'Lê Văn Cường', 'Dịch vụ tốt', 0, '2024-12-12', 'Đã phản hồi', 'Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi. Chúng tôi sẽ truyền đạt lời khen này đến đội ngũ nhân viên.'),
('PH_004', 'KH004', 'Phạm Thị Dung', 'Bồn tắm bị tắc', 0, '2024-10-28', 'Chờ xử lí', 'Vui lòng chờ phản hồi từ chủ Homestay'),
('PH_005', 'KH005', 'Hoàng Văn Giang', 'Phòng thiếu đồ', 0, '2024-11-18', 'Đã phản hồi', 'Chúng tôi xin lỗi về sự thiếu sót này và đã bổ sung khăn tắm cho phòng của bạn.'),
('PH_006', 'KH006', 'Đỗ Thị Hương', 'Hủy phòng', 0, '2024-12-01', 'Đã phản hồi', 'Chúng tôi đã hỗ trợ hủy đơn đặt phòng của bạn. Vui lòng kiểm tra email để biết chi tiết về chính sách hoàn tiền.'),
('PH_007', 'KH007', 'Vũ Văn Khang', 'Dịch vụ giặt ủi', 0, '2024-11-21', 'Chờ xử lí', 'Vui lòng chờ phản hồi từ chủ Homestay'),
('PH_008', 'KH008', 'Bùi Thị Lan', 'Tiếng ồn ban đêm', 0, '2024-12-28', 'Đã phản hồi', 'Chúng tôi rất tiếc về sự bất tiện này. Chúng tôi sẽ có biện pháp để giảm thiểu tiếng ồn và đảm bảo sự thoải mái cho khách hàng.'),
('PH_009', 'KH009', 'Lý Văn Minh', 'Hài lòng với dịch vụ', 0, '2024-11-05', 'Đã phản hồi', 'Chúng tôi rất vui khi bạn hài lòng với dịch vụ. Hy vọng được đón tiếp bạn lần tới.'),
('PH_010', 'KH010', 'Ngô Thị Oanh', 'Vấn đề vệ sinh', 0, '2024-11-25', 'Chờ xử lí', 'Vui lòng chờ phản hồi từ chủ Homestay');

-- --------------------------------------------------------

--
-- Table structure for table `db_homestay`
--

CREATE TABLE `db_homestay` (
  `mahomestay` varchar(10) NOT NULL,
  `tenhomestay` varchar(255) NOT NULL,
  `loaihinh` varchar(255) NOT NULL,
  `trangthaihoatdong` varchar(255) NOT NULL,
  `mota` varchar(255) NOT NULL,
  `sophong` int(10) NOT NULL,
  `tiennghi` varchar(255) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `sodienthoai` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `giathue` varchar(255) NOT NULL,
  `chinhsach` varchar(255) NOT NULL,
  `hinhanh` varchar(255) NOT NULL,
  `diemdanhgia` float NOT NULL,
  `soluotdanhgia` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_homestay`
--

INSERT INTO `db_homestay` (`mahomestay`, `tenhomestay`, `loaihinh`, `trangthaihoatdong`, `mota`, `sophong`, `tiennghi`, `diachi`, `sodienthoai`, `email`, `giathue`, `chinhsach`, `hinhanh`, `diemdanhgia`, `soluotdanhgia`) VALUES
('HST_001', 'Nhà của Bố', 'Căn hộ', 'Đang hoạt động', 'Một căn hộ ấm cúng, thoáng đãng, nằm trong khu vực yên tĩnh, rất phù hợp cho gia đình nhỏ.', 2, 'WiFi, điều hòa, bếp đầy đủ, máy giặt', '20 Nguyễn Thiện Thuật, Quận 3, TP.HCM', 2147483647, 'nhacuabo@gmail.com', '1.000.000 VND/đêm', 'Check-in 14:00, check-out 12:00, hủy phòng trước 48 giờ để được hoàn tiền.', 'https://example.com/images/nha-cua-bo-1.jpg', 5, 25),
('HST_002', 'Gác Mơ Đà Lạt', 'Biệt thự', 'Đang hoạt động', 'Biệt thự cổ kính giữa đồi thông, mang đến không gian lãng mạn, yên bình cho các cặp đôi và nhóm bạn.', 3, 'WiFi, máy sưởi, khu vực nướng BBQ, lò sưởi, sân vườn', '100 Yersin, TP. Đà Lạt', 2147483647, 'gacmoda@gmail.com', '2.500.000 VND/đêm', 'Cần đặt cọc 50% khi booking, không hoàn tiền nếu hủy trong vòng 24 giờ.', 'https://example.com/images/gac-mo-da-lat-1.jpg', 5, 40),
('HST_003', 'Ngôi Nhà Biển', 'Nhà riêng', 'Tạm ngưng', 'Ngôi nhà nhỏ xinh ven biển, cách bãi tắm chỉ 5 phút đi bộ. Sân hiên rộng rãi lý tưởng để ngắm bình minh.', 4, 'WiFi, điều hòa, bếp đầy đủ, vòi sen nước nóng, sân hiên', 'Thôn Cửa Dương, Phú Quốc', 2147483647, 'ngoinhathu@gmail.com', '1.800.000 VND/đêm', 'Check-in sau 15:00, check-out trước 11:00. Khách tự dọn dẹp sau khi trả phòng.', 'https://example.com/images/ngoi-nha-bien-1.jpg', 4, 15),
('HST_004', 'Bungalow Vườn Xanh', 'Bungalow', 'Đang hoạt động', 'Những bungalow gỗ mộc mạc ẩn mình trong vườn cây ăn trái, không gian riêng tư và gần gũi với thiên nhiên.', 1, 'WiFi, quạt trần, phòng tắm riêng, xe đạp miễn phí, sân vườn', 'Xã Tản Lĩnh, Ba Vì, Hà Nội', 2147483647, 'bungalowvuon@gmail.com', '1.200.000 VND/đêm', 'Yêu cầu đặt cọc 30%, hủy trước 3 ngày sẽ được hoàn lại tiền cọc.', 'https://example.com/images/bungalow-vuon-xanh-1.jpg', 5, 30),
('HST_005', 'Sun View Villa', 'Biệt thự', 'Đang hoạt động', 'Villa sang trọng, có bể bơi riêng, view thung lũng tuyệt đẹp. Thích hợp cho kỳ nghỉ dưỡng cao cấp.', 5, 'WiFi, điều hòa, bể bơi riêng, bếp đầy đủ, sân BBQ', '20 Vườn Đào, TP. Vũng Tàu', 2147483647, 'sunview@gmail.com', '4.000.000 VND/đêm', 'Không hoàn tiền khi hủy phòng. Đặt cọc 50% trước khi nhận phòng.', 'https://example.com/images/sun-view-villa-1.jpg', 5, 50),
('HST_006', 'The Forest House', 'Nhà riêng', 'Đã xóa', 'Ngôi nhà gỗ đơn giản nằm sâu trong rừng, dành cho những ai muốn tìm về sự bình yên.', 1, 'Không có WiFi, bếp củi, phòng tắm riêng, lều trại', 'Hòa Sơn, Hòa Vang, TP. Đà Nẵng', 2147483647, 'foresthouse@gmail.com', '800.000 VND/đêm', 'Chính sách đặc biệt do chủ nhà quy định.', 'https://example.com/images/the-forest-house-1.jpg', 4, 10),
('HST_007', 'Urban Escape', 'Căn hộ', 'Đang hoạt động', 'Căn hộ studio hiện đại, phong cách tối giản, tọa lạc ngay trung tâm thành phố, tiện lợi cho việc di chuyển.', 1, 'WiFi, TV thông minh, bếp nhỏ, máy giặt, phòng gym chung', '50 Lê Lợi, Quận 1, TP.HCM', 2147483647, 'urban@gmail.com', '1.500.000 VND/đêm', 'Không được phép hút thuốc trong phòng. Check-in tự động.', 'https://example.com/images/urban-escape-1.jpg', 5, 35),
('HST_008', 'Tâm An Homestay', 'Nhà riêng', 'Đang hoạt động', 'Ngôi nhà cổ kính mang đậm nét truyền thống, không gian tĩnh lặng, phù hợp cho những chuyến đi tìm về giá trị xưa cũ.', 3, 'WiFi, máy lạnh, bếp chung, sân hiên rộng, máy sưởi', 'Làng cổ Đường Lâm, Hà Nội', 2147483647, 'taman@gmail.com', '1.100.000 VND/đêm', 'Không nhận khách sau 22:00. Khách tự giữ gìn vệ sinh chung.', 'https://example.com/images/tam-an-homestay-1.jpg', 4, 20),
('HST_009', 'Tropical Nest', 'Bungalow', 'Đang hoạt động', 'Bungalow lợp lá dừa, nằm giữa khu vườn nhiệt đới, mang đến cảm giác thư giãn và gần gũi với thiên nhiên.', 2, 'WiFi, quạt trần, võng, bếp chung, xe đạp miễn phí', '150 Trần Hưng Đạo, Côn Đảo', 2147483647, 'tropicalnest@gmail.com', '1.700.000 VND/đêm', 'Không hoàn tiền cọc nếu hủy đặt phòng. Được phép mang theo thú cưng.', 'https://example.com/images/tropical-nest-1.jpg', 5, 18),
('HST_010', 'Hana\'s Tiny House', 'Nhà riêng', 'Đang hoạt động', 'Ngôi nhà nhỏ xinh xắn với phong cách Nhật Bản, không gian tối giản, lý tưởng cho các bạn trẻ và cặp đôi.', 1, 'WiFi, điều hòa, bếp nhỏ, máy pha cà phê, TV', '10 Phan Chu Trinh, TP. Hội An', 2147483647, 'hanatin@gmail.com', '950.000 VND/đêm', 'Đặt cọc 50% để giữ phòng. Hủy trước 24 giờ sẽ bị mất phí 30%.', 'https://example.com/images/hana-tiny-house-1.jpg', 4, 22);

-- --------------------------------------------------------

--
-- Table structure for table `db_khachhang`
--

CREATE TABLE `db_khachhang` (
  `makhachhang` varchar(10) NOT NULL,
  `tenkhachhang` varchar(255) NOT NULL,
  `ngaysinh` date NOT NULL,
  `gioitinh` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sodienthoai` int(11) NOT NULL,
  `diachi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_khachhang`
--

INSERT INTO `db_khachhang` (`makhachhang`, `tenkhachhang`, `ngaysinh`, `gioitinh`, `email`, `sodienthoai`, `diachi`) VALUES
('KH01', 'Nguyễn Văn An', '1990-05-15', 'Nam', 'nguyenvanan@gmail.com', 2147483647, 'Phường Bến Nghé, Quận 1, Thành phố Hồ Chí Minh'),
('KH02', 'Trần Thị Bình', '1985-11-20', 'Nữ', 'tranthibinh@gmail.com', 2147483647, 'Phường Quán Thánh, Quận Ba Đình, Thành phố Hà Nội'),
('KH03', 'Lê Văn Cường', '1992-03-10', 'Nam', 'levancuong@gmail.com', 2147483647, 'Phường Vĩnh Hải, Thành phố Nha Trang, Tỉnh Khánh Hòa'),
('KH04', 'Phạm Thị Dung', '1995-07-25', 'Nữ', 'phamthidung@gmail.com', 2147483647, 'Phường Thạc Gián, Quận Thanh Khê, Thành phố Đà Nẵng'),
('KH05', 'Hoàng Văn Giang', '1988-09-01', 'Nam', 'hoangvangiang@gmail.com', 2147483647, 'Xã Vĩnh Ngọc, Huyện Đông Anh, Thành phố Hà Nội'),
('KH06', 'Đỗ Thị Hương', '1993-02-14', 'Nữ', 'dothihuong@gmail.com', 2147483647, 'Xã Phước Kiển, Huyện Nhà Bè, Thành phố Hồ Chí Minh'),
('KH07', 'Vũ Văn Khang', '1991-06-30', 'Nam', 'vuvankhang@gmail.com', 2147483647, 'Phường Xuân Hòa, Thành phố Long Khánh, Tỉnh Đồng Nai'),
('KH08', 'Bùi Thị Lan', '1996-08-05', 'Nữ', 'buithilan@gmail.com', 2147483647, 'Xã Hòa Sơn, Huyện Hòa Vang, Thành phố Đà Nẵng'),
('KH09', 'Lý Văn Minh', '1987-12-18', 'Nam', 'lyvanminh@gmail.com', 2147483647, 'Phường Bến Thành, Quận 1, Thành phố Hồ Chí Minh'),
('KH10', 'Ngô Thị Oanh', '1994-04-22', 'Nữ', 'ngothioanh@gmail.com', 2147483647, 'Phường Ngô Quyền, Thành phố Vĩnh Yên, Tỉnh Vĩnh Phúc');

-- --------------------------------------------------------

--
-- Table structure for table `db_phong`
--

CREATE TABLE `db_phong` (
  `maphong` varchar(10) NOT NULL,
  `tenphong` varchar(255) NOT NULL,
  `loaiphong` varchar(255) NOT NULL,
  `tenhomestay` varchar(255) NOT NULL,
  `mota` varchar(255) NOT NULL,
  `succhua` int(10) NOT NULL,
  `trangthai` varchar(255) NOT NULL,
  `gia` int(10) NOT NULL,
  `hinhanh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_phong`
--

INSERT INTO `db_phong` (`maphong`, `tenphong`, `loaiphong`, `tenhomestay`, `mota`, `succhua`, `trangthai`, `gia`, `hinhanh`) VALUES
('P_01', 'Phòng Đôi View Biển', 'Deluxe', 'Nhà của Bố', 'Phòng rộng rãi với ban công hướng ra biển, đầy đủ tiện nghi, phù hợp cho cặp đôi.', 2, 'Đang trống', 1200000, 'https://example.com/images/phong-doi-bien-1.jpg, https://example.com/images/phong-doi-bien-2.jpg'),
('P_02', 'Phòng Gia Đình', 'Standard', 'Gác Mơ Đà Lạt', 'Phòng lớn có 2 giường đôi, phù hợp cho gia đình hoặc nhóm bạn.', 4, 'Đã đặt', 1500000, 'https://example.com/images/phong-gia-dinh-1.jpg, https://example.com/images/phong-gia-dinh-2.jpg'),
('P_03', 'Phòng Đơn Hướng Vườn', 'Standard', 'Ngôi Nhà Biển', 'Phòng nhỏ gọn, yên tĩnh, có cửa sổ nhìn ra khu vườn.', 1, 'Đang trống', 800000, 'https://example.com/images/phong-don-vuon-1.jpg'),
('P_04', 'Suite Tầm Nhìn Thành Phố', 'VIP', 'Bungalow Vườn Xanh', 'Phòng suite cao cấp, có phòng khách riêng, tầm nhìn toàn cảnh thành phố.', 2, 'Đang dọn dẹp', 2500000, 'https://example.com/images/phong-suite-1.jpg, https://example.com/images/phong-suite-2.jpg'),
('P_05', 'Bungalow Bể Bơi Riêng', 'VIP', 'Sun View Villa', 'Bungalow độc lập với bể bơi riêng, không gian riêng tư và sang trọng.', 2, 'Đang trống', 3000000, 'https://example.com/images/bungalow-be-boi-1.jpg'),
('P_06', 'Phòng Dorm Thập', 'Standard', 'The Forest House', 'Phòng tập thể với giường tầng, phù hợp cho khách du lịch bụi.', 8, 'Đã đặt', 250000, 'https://example.com/images/phong-dorm-1.jpg'),
('P_07', 'Phòng Ba Người', 'Standard', 'Urban Escape', 'Phòng có một giường đôi và một giường đơn, phù hợp cho nhóm 3 người.', 3, 'Đang trống', 1000000, 'https://example.com/images/phong-ba-nguoi-1.jpg'),
('P_08', 'Phòng Deluxe Sân Thượng', 'Deluxe', 'Tâm An Homestay', 'Phòng có sân thượng riêng, lý tưởng để thư giãn và ngắm sao.', 2, 'Đã đặt', 1800000, 'https://example.com/images/phong-deluxe-san-thuong-1.jpg'),
('P_09', 'Căn Hộ Một Phòng Ngủ', 'Standard', 'Tropical Nest', 'Căn hộ đầy đủ tiện nghi với bếp, phòng khách, thích hợp cho lưu trú dài ngày.', 2, 'Đang trống', 1600000, 'https://example.com/images/can-ho-mot-phong-ngu-1.jpg, https://example.com/images/can-ho-mot-phong-ngu-2.jpg'),
('P_10', 'Villa Tổng Thống', 'VIP', 'Hana\'s Tiny House', 'Villa có nhiều phòng ngủ, phòng khách rộng, bể bơi và khu vực ăn uống riêng.', 10, 'Đang bảo trì', 10000000, 'https://example.com/images/villa-tong-thong-1.jpg, https://example.com/images/villa-tong-thong-2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `db_thanhtoan`
--

CREATE TABLE `db_thanhtoan` (
  `mathanhtoan` varchar(10) NOT NULL,
  `madondatphong` varchar(10) NOT NULL,
  `hinhthucthanhtoan` varchar(255) NOT NULL,
  `sotien` decimal(10,0) NOT NULL,
  `ngaythanhtoan` date NOT NULL,
  `trangthai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `db_thanhtoan`
--

INSERT INTO `db_thanhtoan` (`mathanhtoan`, `madondatphong`, `hinhthucthanhtoan`, `sotien`, `ngaythanhtoan`, `trangthai`) VALUES
('TT_001', 'B_001', 'Thẻ tín dụng', 3600000, '2024-10-20', 'Đã thanh toán'),
('TT_002', 'B_002', 'Chuyển khoản ngân hàng', 1500000, '2024-11-05', 'Đang chờ'),
('TT_003', 'B_003', 'Tiền mặt', 1600000, '2024-12-10', 'Đã thanh toán'),
('TT_004', 'B_004', 'Thẻ tín dụng', 7500000, '2024-10-25', 'Đã thanh toán'),
('TT_005', 'B_005', 'Chuyển khoản ngân hàng', 9000000, '2024-11-15', 'Đã thanh toán'),
('TT_006', 'B_006', 'Tiền mặt', 1500000, '2024-12-01', 'Chưa thanh toán'),
('TT_007', 'B_007', 'Thẻ tín dụng', 1000000, '2024-11-20', 'Đã thanh toán'),
('TT_008', 'B_008', 'Chuyển khoản ngân hàng', 5400000, '2024-12-25', 'Đang chờ'),
('TT_009', 'B_009', 'Tiền mặt', 9600000, '2024-10-30', 'Đã thanh toán'),
('TT_010', 'B_010', 'Thẻ tín dụng', 30000000, '2024-11-22', 'Đã thanh toán');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_account`
--
ALTER TABLE `db_account`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `db_booking`
--
ALTER TABLE `db_booking`
  ADD PRIMARY KEY (`madondatphong`);

--
-- Indexes for table `db_danhgia`
--
ALTER TABLE `db_danhgia`
  ADD PRIMARY KEY (`madanhgia`);

--
-- Indexes for table `db_homestay`
--
ALTER TABLE `db_homestay`
  ADD PRIMARY KEY (`mahomestay`);

--
-- Indexes for table `db_khachhang`
--
ALTER TABLE `db_khachhang`
  ADD PRIMARY KEY (`makhachhang`);

--
-- Indexes for table `db_phong`
--
ALTER TABLE `db_phong`
  ADD PRIMARY KEY (`maphong`);

--
-- Indexes for table `db_thanhtoan`
--
ALTER TABLE `db_thanhtoan`
  ADD PRIMARY KEY (`mathanhtoan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
