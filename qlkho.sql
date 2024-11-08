-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 08, 2024 lúc 01:54 AM
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
-- Cơ sở dữ liệu: `qlkho`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisp`
--

CREATE TABLE `loaisp` (
  `Maloai` varchar(5) NOT NULL,
  `Tenloai` varchar(50) NOT NULL,
  `Mota` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisp`
--

INSERT INTO `loaisp` (`Maloai`, `Tenloai`, `Mota`) VALUES
('L001', 'Vòng cổ ', ''),
('L002', 'Vòng tay', ''),
('L003', 'Nhẫn ', ''),
('L004', 'Hoa tai ', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `Mahang` varchar(5) NOT NULL,
  `Tenhang` varchar(50) NOT NULL,
  `Soluong` int(11) NOT NULL,
  `Hinhanh` varchar(30) NOT NULL,
  `Mota` varchar(100) NOT NULL,
  `Giahang` decimal(10,1) NOT NULL,
  `Maloai` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Lưu tên file ảnh ';

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`Mahang`, `Tenhang`, `Soluong`, `Hinhanh`, `Mota`, `Giahang`, `Maloai`) VALUES
('SP001', 'Dây Chuyền Bạc Pandora Moments Dạng Dây Xích Nhỏ', 100, '1.jpg', 'Tạo một diện mạo độc nhất cho bạn, sử dụng dây chuyền cổ điển này làm điểm khởi đầu. Chiếc vòng cổ đ', 1253000.0, 'L001'),
('SP002', 'Dây Chuyền Bạc Pandora Moments Dạng Dây Xích', 50, '1.2.jpg', 'Khám phá cách hoàn hảo để trưng bày các mặt dây chuyền Pandora yêu thích của bạn và các món đồ quyến', 1253000.0, 'L001'),
('SP003', 'Dây Chuyền Bạc Pandora Moments Vô Cực', 70, '1.3.jpg', 'Một dây chuyền thanh lịch với sự tinh tế của biểu tượng hình vô cực, Dây Chuyền Infinity là đối tác ', 1300000.0, 'L001'),
('SP004', 'Dây Chuyền Bạc Pandora Moments Dạng Xích Lớn', 65, '1.4.jpg', 'Tạo một diện mạo độc nhất cho bạn, sử dụng dây chuyền cổ điển này làm điểm khởi đầu. Chiếc vòng cổ đ', 1453000.0, 'L001'),
('SP005', 'Dây Chuyền Pandora Moments Dạng Xích Nút Thắt Dài', 75, '1.5.jpg', 'Không có BST đồ trang sức nào được hoàn thành mà không có một chiếc vòng cổ linh hoạt đơn giản có th', 1673000.0, 'L001'),
('SP101', 'Vòng Bạc Pandora Moments Với Khóa Trái Tim', 90, '2.1.jpg', 'Làm trái tim bạn rung động với phiên bản lãng mạn của chiếc vòng tay charm bán chạy nhất của Pandora', 2303000.0, 'L002'),
('SP102', 'Vòng Bạc Pandora Khóa Trái Tim Vô Tận Trong Suốt', 100, '2.2.jpg', 'Đại diện cho tình yêu vĩnh cửu kết nối gia đình, vòng tay dây rắn Pandora Moments Sparkling Infinity', 2513000.0, 'L002'),
('SP103', 'Vòng Bạc Pandora Khóa Crown O', 50, '2.3.jpg', 'Lấp lánh trong từng khoảng khắc với chiếc vòng Pandora Moments Sparkling Crown O Snake Chain Bracele', 2513000.0, 'L002'),
('SP201', 'Nhẫn Pandora Timeless Bạc Gợn Sóng', 100, '3.1.jpg', 'Được chế tác từ bạc sterling, chiếc Nhẫn Polished Wave của chúng tôi uốn cong để giống như sự chuyển', 1043000.0, 'L003'),
('SP202', 'Nhẫn Bạc Pandora ME Tráng Men Đỏ', 55, '3.2.jpg', 'Một phiên bản nâng cấp của dòng nhẫn Pandora Me vốn đã khá quen thuộc trên thị trường. Sử dụng chất ', 1253000.0, 'L003'),
('SP203', 'Nhẫn Pandora Timeless Bạc Gợn Sóng Đính Đá', 35, '3.3.jpg', 'Với thiết kế uốn cong như đỉnh của những con sóng vỗ, nó mang đến 1 hình dánh mới cho những thiết kế', 1300000.0, 'L003'),
('SP301', 'Hoa Tai Pandora Moments Ngôi Sao Đính Đá Bất Đối X', 45, '4.1.jpg', 'Phân loại sản phẩm: Hoa tai\r\nChất liệu: Bạc\r\nMàu sắc: Không màu', 1200000.0, 'L004'),
('SP302', 'Hoa Tai Pandora Moments Hình Que Kẹo Màu Đỏ', 65, '4.2.jpg', 'Hãy khám phá tinh thần của mùa này với Bông Tai Nút Que Kẹo Màu Đỏ Lấp Lánh. Những bông tai bạc ster', 1250000.0, 'L004'),
('SP303', 'Hoa Tai Bạc Pandora Moments Hình Mặt Trăng Lưỡi Li', 45, '4.3.jpg', 'Hãy tận hưởng sự đơn giản mượt mà với Bông Tai Mặt Trăng. Có hình dáng giống với hình dáng của một m', 1250000.0, 'L004');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `loaisp`
--
ALTER TABLE `loaisp`
  ADD UNIQUE KEY `Maloai` (`Maloai`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`Mahang`),
  ADD KEY `fk_maloai` (`Maloai`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_maloai` FOREIGN KEY (`Maloai`) REFERENCES `loaisp` (`Maloai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
