-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2014 at 03:09 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2014_job_doan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `Username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Password` varchar(50) CHARACTER SET utf8 NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Username`, `Password`, `level`) VALUES
('admin', 'truongmai', 1);

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE IF NOT EXISTS `donhang` (
  `Sodon` int(11) NOT NULL AUTO_INCREMENT,
  `Ngaydathang` date NOT NULL,
  `Makhachhang` int(11) NOT NULL,
  `Nguoinhan` varchar(30) NOT NULL,
  `Diachi` varchar(100) NOT NULL,
  `Dienthoai` varchar(20) NOT NULL,
  `Masanpham` varchar(255) NOT NULL,
  `Dongia` int(11) NOT NULL DEFAULT '0',
  `Soluong` varchar(255) NOT NULL,
  `Thanhtien` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`Sodon`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`Sodon`, `Ngaydathang`, `Makhachhang`, `Nguoinhan`, `Diachi`, `Dienthoai`, `Masanpham`, `Dongia`, `Soluong`, `Thanhtien`) VALUES
(1, '2014-07-20', 18, 'Truong mai', 'dfgdfgdg', '45654656', '3:4', 0, ':1:1', 0),
(2, '2014-07-20', 18, 'Truong mai', 'hungyen', '18789398', '3:4:6', 0, ':3:1:1', 0),
(3, '2014-07-23', 19, 'mai', 'hungyen', '012234456', '3:5', 0, ':1:1', 0),
(4, '2014-07-31', 20, 'truongthithuy', 'hungyen', '0123456123', '3:5', 0, ':2:1', 0),
(5, '2014-07-31', 20, '', '', '', '3:5', 0, ':2:2', 0),
(20, '2014-08-06', 20, 'fgfdg', '54h45htht', '4645646', '', 0, '', 0),
(9, '2014-08-04', 20, '', '', '', '3:5:6', 0, ':8:1:1', 0),
(21, '2014-08-06', 20, 'fgfdg', '54h45htht', '4645646', '', 0, '', 0),
(22, '2014-08-06', 20, 'fgfdg', '54h45htht', '4645646', '1:2', 0, '::', 0),
(23, '2014-08-06', 20, 'fgfdg', '54h45htht', '4645646', '5:6', 0, ':1:2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hangsanxuat`
--

CREATE TABLE IF NOT EXISTS `hangsanxuat` (
  `Mahang` varchar(11) NOT NULL,
  `Tenhang` varchar(100) NOT NULL,
  PRIMARY KEY (`Mahang`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE IF NOT EXISTS `hoadon` (
  `Sodon` int(11) NOT NULL,
  `Ngayban` date NOT NULL,
  `Makhachhang` int(11) NOT NULL,
  `Masanpham` int(20) NOT NULL,
  `Soluong` int(11) NOT NULL,
  `Dongia` int(11) NOT NULL,
  `Thanhtien` int(11) NOT NULL,
  PRIMARY KEY (`Sodon`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE IF NOT EXISTS `khachhang` (
  `Makhachhang` int(20) NOT NULL AUTO_INCREMENT,
  `Username` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Password` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Email` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Hoten` varchar(20) CHARACTER SET utf8 NOT NULL,
  `SoCMND` int(11) NOT NULL,
  `Ngaysinh` date NOT NULL,
  `Diachi` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Dienthoai` int(11) NOT NULL,
  `level` int(10) NOT NULL,
  PRIMARY KEY (`Makhachhang`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`Makhachhang`, `Username`, `Password`, `Email`, `Hoten`, `SoCMND`, `Ngaysinh`, `Diachi`, `Dienthoai`, `level`) VALUES
(16, 'hungthtb911', '123456', 'hungthtb1012@yahoo.c', 'Tạ Văn Hùng', 151820306, '1991-10-12', 'Thái bình', 1649702196, 0),
(17, 'vanhung911', 'vanhung91', 'hungthtb9191@yahoo.c', 'Tạ Văn Hùng', 151820306, '1991-10-12', 'Thái bình', 1649702196, 0),
(18, 'vanhung1', '123', 'hungthtb9119@yahoo.c', 'Tạ Văn Hùng', 151820306, '1991-10-12', 'Thái bình', 124343434, 0),
(19, 'mai', '1234', 'maixanh.ctv@gmail.co', 'Truong thi mai', 145482970, '1991-08-08', 'hung yen', 1662445112, 0),
(20, 'anh', '12345', 'hantinhtta@yahoo.com', 'vananh', 123456789, '1990-09-09', 'hung yen', 123132145, 0),
(21, 'Nam', '123', 'Nam@gmail.com', 'Hải Nam', 145482973, '1985-07-09', 'Ân Thi- Hưng yên', 978321678, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE IF NOT EXISTS `sanpham` (
  `Masanpham` int(20) NOT NULL AUTO_INCREMENT,
  `Tensanpham` varchar(100) CHARACTER SET utf8 NOT NULL,
  `Mahang` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Baohanh` varchar(10) CHARACTER SET utf8 NOT NULL,
  `Mausac` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Khoiluong` varchar(10) CHARACTER SET utf8 NOT NULL,
  `Mota` text CHARACTER SET utf8 NOT NULL,
  `Dongia` int(11) NOT NULL,
  `Hinhanh` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Soluong` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Masanpham`),
  UNIQUE KEY `Masanpham` (`Masanpham`),
  KEY `Tensanpham` (`Tensanpham`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`Masanpham`, `Tensanpham`, `Mahang`, `Baohanh`, `Mausac`, `Khoiluong`, `Mota`, `Dongia`, `Hinhanh`, `Soluong`) VALUES
(3, 'Terrazzo 121', 'TR', '6 tháng', 'Xám Đá', '3kg', 'Gạch lát Terrazzo Đơn màu\r\n- Độ hút nước 6,21 %\r\n- Kích thước: 400 x 400 (6 viên/m2 )\r\n- Cường độ chịu uốn : 52,8 daN/cm2\r\n- Cường Độ chịu nén : 216 daN/cm2', 59000, 'Hinhanh/tera1.jpg', 100),
(5, 'Bột Đá Xây(Bao 50kg)', 'DA', 'Không', 'Xám', '50kg', 'Chất lượng tốt,phù hợp với người dùng.', 200000, 'Hinhanh/botdaxay.jpg', 100),
(6, 'Đá Xô Bồ(Khối)', 'DA', 'Không', 'Đá', 'Khối', 'Chất lượng tốt,phù hợp với người dùng,gạch không thấm nước', 200000, 'Hinhanh/daxobo.jpg', 100),
(7, 'Thép Vằn D12(cây)', 'TMN', 'Không', 'Xám', '20kg', 'Chất lượng tốt,được người tiêu dùng ưa chuộng.', 200000, 'Hinhanh/thepcayvan.jpg', 100),
(8, 'Thép Vằn D14(cây)', 'TMN', 'Không', 'Xám', '30kg', 'Chất lượng tốt,giá cả hợ lý,được người tiêu dùng ưa chuộng.', 300000, 'Hinhanh/thepcayvan1.jpg', 100),
(9, 'Cát Vàng(Khối)', 'CSH', 'Không', 'Vàng', 'Khối', 'Chất lượng tốt. Giá cả hợp lý được nhìu người sử dụng.', 150000, 'Hinhanh/catvang.jpg', 100),
(10, 'Gạch Block Chèn', 'GTB', 'Không', 'Màu đỏ thẫm', '3kg', 'Chất lượng tốt, khách hàng ưa chuộng.', 20000, 'Hinhanh/gachblockchen.jpg', 100),
(11, 'Ngói màu', 'GTB', 'Không', 'Đỏ', '2kg', 'Chất lượng tốt.', 25000, 'Hinhanh/ngoimau.jpg', 100),
(12, 'Gạch Block Xây', 'GTB', 'Không', 'Xám', '2kg', 'Chất lượng tốt, phù hợp với các công trình.', 30000, 'Hinhanh/gachblockxay.jpg', 100),
(13, 'Xi Măng Hải Phòng', 'XHP', 'Không', 'Xám Đá', 'Bao 50kg', 'Chất lượng tốt, giá thành rẻ.', 150000, 'Hinhanh/ximanghaiphong.jpg', 100),
(14, 'Xi Măng Hoàng Thạch', 'XHT', 'Không', 'Xám Đá', 'Bao 50kg', 'Chất lượng tốt, giá thành rẻ.', 150000, 'Hinhanh/ximanghoangthach.jpg', 100),
(15, 'Xi Măng Trắng', 'XMT', 'Không', 'Trắng Xám', 'Bao 50kg', 'Chất lượng tốt.', 180000, 'Hinhanh/ximangtrang.jpg', 100),
(1, 'Thép Việt Nhật', 'TVN', '1thang', 'Xám', '50kg', 'Chất lượng tốt', 150000, 'Hinhanh/thepvietnhat.jpg', 100),
(37, 'Gạch Nato', 'TTT', 'Không', 'Xanh Xám', '1kg/v', 'Chất lượng tốt, sản phẩm bóng đẹp!\n\n', 2, 'Hinhanh/85125256093e.jpg', 100),
(39, 'Thép ALA', 'TMN', 'Không', 'Xanh xám', '50kg', 'Thép có chất lượng tốt, đáp ứng được yêu cầu người dùng VN.\n', 300000, 'Hinhanh/1.jpg', 100),
(38, 'gach nato', 'MH1', 'khong', 'Xam xanh', '1kg/v', 'san pham chat luong', 2000, 'Hinhanh/85125256093e.jpg', 100),
(40, 'Thép Vằn D21', 'TMN', '2 Tháng', 'Xám nâu', '40kg', 'Sản phẩm đạt chất lượng ISO về chất lượng.', 400000, 'Hinhanh/2.jpg', 100),
(41, 'Thép BALA', 'TJ', '3 tháng', 'Xanh lục', '20kg', 'Sản phẩm nhập khẩu từ Mỹ. chất lượng tốt.\n\n\n\n', 350000, 'Hinhanh/3.jpg', 1),
(42, 'Thép TUYP', 'APY', '5 tháng', 'trăng bạc', '20kg', 'Sản phẩm chất lượng tốt được khách hàng tin dùng.\n', 250000, 'Hinhanh/5.jpg', 100),
(43, 'Gạch Ý', 'GA', 'Không', 'Xám đất', '1,5kg(v)', 'Sản phẩm nhập khẩu', 15000, 'Hinhanh/4.jpg', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tintuc`
--

CREATE TABLE IF NOT EXISTS `tintuc` (
  `IDtintuc` int(11) NOT NULL AUTO_INCREMENT,
  `tintuc` varchar(255) CHARACTER SET utf8 NOT NULL,
  `gioithieu` text CHARACTER SET utf8,
  `chitiet` text CHARACTER SET utf8,
  `hinhanh` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `nguon` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `hienthi` tinyint(1) NOT NULL DEFAULT '1',
  `sapxep` int(11) NOT NULL DEFAULT '0',
  `soluot` int(11) NOT NULL DEFAULT '0',
  `ngaydang` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`IDtintuc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tintuc`
--

INSERT INTO `tintuc` (`IDtintuc`, `tintuc`, `gioithieu`, `chitiet`, `hinhanh`, `nguon`, `hienthi`, `sapxep`, `soluot`, `ngaydang`) VALUES
(1, 'Thị trường vật liệu xây dựng đang khởi sắc', '<p><span style="font-family: Arial, Helvetica, sans-serif; line-height: 16px;">Nh&acirc;n dịp chiếc xe thứ 2 triệu được b&aacute;n ra tr&ecirc;n thị trường, Honda Việt Nam đ&atilde; thực hiện 2 đợt khuyến mại d&agrave;nh cho xe Air Blade như một m&oacute;n qu&agrave; tri &acirc;n d&hellip;...</span> [...]</p>', '<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Lu&ocirc;n gi&agrave;nh được ưu thế về c&ocirc;ng nghệ ti&ecirc;n tiến v&agrave; thiết kế thể thao hiện đại từ những ng&agrave;y đầu ra mắt v&agrave;o th&aacute;ng 4/2007 tại Việt Nam, xe Air Blade do Honda Việt Nam sản xuất đ&atilde;, đang v&agrave; sẽ giữ vững được vị thế của m&igrave;nh cũng như chiếm trọn l&ograve;ng tin của kh&aacute;ch h&agrave;ng y&ecirc;u th&iacute;ch d&ograve;ng xe tay ga thể thao n&agrave;y. Sau hơn 6 năm c&oacute; mặt tr&ecirc;n thị trường với 7 lần thay đổi phi&ecirc;n bản mới từ động cơ 110cc chế h&ograve;a kh&iacute; đến động cơ phun xăng điện tử v&agrave; hiện tại l&agrave; động cơ 125cc phun xăng điện tử, Air Blade thực sự l&agrave; một trong những mẫu xe th&agrave;nh c&ocirc;ng nhất của Honda tại thị trường Việt Nam với tổng sản lượng b&aacute;n h&agrave;ng đạt 2 triệu xe t&iacute;nh từ khi ra mắt đến nay.</p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Nh&acirc;n dịp chiếc xe thứ 2 triệu được b&aacute;n ra tr&ecirc;n thị trường, Honda Việt Nam đ&atilde; thực hiện 2 đợt khuyến mại d&agrave;nh cho xe Air Blade như một m&oacute;n qu&agrave; tri &acirc;n d&agrave;nh cho Qu&yacute; kh&aacute;ch h&agrave;ng y&ecirc;u mến d&ograve;ng xe n&agrave;y, đợt 1 đ&atilde; diễn ra từ ng&agrave;y 15/08/2013 đến 15/09/2013 v&agrave; đợt 2 từ 20/09/2013 đến hết 31/10/2013.</p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Nhận thức r&otilde; nhu cầu cũng như sự đ&aacute;nh gi&aacute; cao m&agrave; kh&aacute;ch h&agrave;ng gi&agrave;nh cho d&ograve;ng sản phẩm ưu việt n&agrave;y, sau th&agrave;nh c&ocirc;ng của 2 chiến dịch khuyến mại đợt 1 v&agrave; đợt 2, Honda Việt Nam tiếp tục thực hiện đợt 3 của chương tr&igrave;nh khuyến mại n&agrave;y từ ng&agrave;y 20/12/2013 đến hết ng&agrave;y 31/01/2014 như một m&oacute;n qu&agrave; d&agrave;nh cho Qu&yacute; kh&aacute;ch h&agrave;ng nh&acirc;n dịp năm mới. Theo đ&oacute;, Qu&yacute; kh&aacute;ch h&agrave;ng khi mua xe Air Blade 125cc (kh&ocirc;ng &aacute;p dụng cho phi&ecirc;n bản sơn từ t&iacute;nh) do Honda Việt Nam sản xuất tại c&aacute;c Cửa H&agrave;ng B&aacute;n Xe v&agrave; Dịch Vụ do Honda Ủy Nhiệm (HEAD) tr&ecirc;n to&agrave;n quốc trong thời gian từ ng&agrave;y 20/12/2013 đến hết ng&agrave;y 31/01/2014, sẽ nhận được 01 Phiếu Qu&agrave; Tặng trị gi&aacute; 1.000.000 đồng để sử dụng ngay trong lần mua xe đ&oacute;. Phiếu Qu&agrave; Tặng đ&atilde; bao gồm thuế GTGT, kh&ocirc;ng được quy đổi th&agrave;nh tiền mặt hoặc mua phụ t&ugrave;ng hay l&agrave;m dịch vụ tại HEAD.</p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Mọi chi tiết về chương tr&igrave;nh khuyến mại&nbsp;<strong>&ldquo;1.000.000 đồng tri &acirc;n nh&acirc;n dịp 2 triệu xe lăn b&aacute;nh&rdquo;</strong>được đăng tải tr&ecirc;n website của Honda Việt Nam:&nbsp;<a href="http://www.honda.com.vn/" style="color: rgb(0, 0, 0); text-decoration: none; cursor: pointer;">www.honda.com.vn</a>&nbsp;hoặc Qu&yacute; kh&aacute;ch h&agrave;ng c&oacute; thể li&ecirc;n hệ đến HEAD gần nhất hoặc số điện thoại miễn ph&iacute;:</p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">&uuml;&nbsp;&nbsp;&nbsp;&nbsp;<strong>1800</strong><strong>.</strong><strong>5555</strong><strong>.</strong><strong>48 (d&agrave;nh cho kh&aacute;ch</strong>&nbsp;<strong>h&agrave;ng</strong><strong>&nbsp;sử dụng&nbsp;</strong><strong>mạng&nbsp;</strong><strong>Mobi</strong><strong>fone</strong><strong>, Vina</strong><strong>phone</strong><strong>&nbsp;hoặc VNPT)</strong></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">&uuml;&nbsp;&nbsp;&nbsp;&nbsp;<strong>1800.8001 (d&agrave;nh cho kh&aacute;ch</strong>&nbsp;<strong>h&agrave;ng</strong><strong>&nbsp;sử dụng mạng Viettel)</strong></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Thời gian: Từ 07:30 đến 16:30 h&agrave;ng ng&agrave;y trong tuần, trừ thứ Bảy, Chủ Nhật v&agrave; ng&agrave;y lễ.</p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Honda Việt Nam mong rằng chương tr&igrave;nh khuyến mại sẽ mang mẫu xe Air Blade đến gần với kh&aacute;ch h&agrave;ng Việt Nam hơn nữa.</p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;"><strong>Xin tr&acirc;n trọng cảm ơn.</strong></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;"><strong>C&ocirc;ng ty Honda Việt Nam</strong></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;"><strong>&nbsp;</strong></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;"><strong>&nbsp;</strong></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;"><strong>Hồ Mạnh Tuấn</strong></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;"><strong>Ph&oacute; Tổng Gi&aacute;m đốc Thứ nhất</strong></p>', '1.jpg', 'honda.com.vn', 1, 1, 20, '2013-12-24 09:29:59'),
(2, 'Sàn nhẹ panen - công nghệ mới cho xây dựng hiện đại', '<p><span style="font-family: Arial, Helvetica, sans-serif; line-height: 16px;">Được ch&iacute;nh thức giới thiệu tại thị trường Việt Nam v&agrave;o năm 2009, với thiết kế theo phong c&aacute;ch Ch&acirc;u &Acirc;u lịch l&atilde;m kết hợp với c&ocirc;ng nghệ Nhật Bản ti&ecirc;n tiế&hellip;...</span></p>', '<p style="text-align: justify;"><span style="font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Được ch&iacute;nh thức giới thiệu tại thị trường Việt Nam v&agrave;o năm 2009, với thiết kế theo phong c&aacute;ch Ch&acirc;u &Acirc;u lịch l&atilde;m kết hợp với c&ocirc;ng nghệ Nhật Bản ti&ecirc;n tiến, d&ograve;ng xe SH125i/150i đ&atilde; nhận được sự đ&aacute;nh gi&aacute; cao của người ti&ecirc;u d&ugrave;ng Việt Nam. Sau đ&oacute;, mẫu xe được cải tiến với một số thay đổi nhỏ v&agrave;o năm 2010 v&agrave; 2011 v&agrave; thay đổi ho&agrave;n to&agrave;n về thiết kế v&agrave; c&ocirc;ng nghệ v&agrave;o năm 2012. Với người Việt Nam, Honda SH trở th&agrave;nh một biểu tượng của d&ograve;ng xe dẫn đầu m&agrave; ai cũng mong ước sở hữu.</span></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Đặc biệt, Honda lu&ocirc;n ch&uacute; &yacute; lựa chọn m&agrave;u sắc cho Honda SH 125i/150i kỹ c&agrave;ng nhằm l&agrave;m nổi bật vẻ đẹp mặt ngo&agrave;i của th&acirc;n xe v&agrave; t&ocirc;n l&ecirc;n chất lượng cao cấp của xe. Sau hơn 1 năm ra mắt với những t&igrave;m hiểu kỹ lưỡng về nhu cầu v&agrave; thị hiếu của người ti&ecirc;u d&ugrave;ng cũng như mong muốn mang đến cho kh&aacute;ch h&agrave;ng nhiều lựa chọn hơn, Honda Việt Nam bổ sung th&ecirc;m m&agrave;u Xanh Đen v&agrave; Đỏ Đen cho Honda SH 125i/150i với gi&aacute; b&aacute;n lẻ đề xuất kh&ocirc;ng thay đổi như sau:</p>\r\n<table width="540" border="1" cellpadding="1" cellspacing="1">\r\n    <tbody>\r\n        <tr>\r\n            <td style="text-align: center;"><strong>STT</strong></td>\r\n            <td style="text-align: center;"><strong>Mẫu xe</strong></td>\r\n            <td style="text-align: center;"><strong>M&agrave;u sắc</strong></td>\r\n            <td style="text-align: center;"><strong style="line-height: 16px;">Gi&aacute; b&aacute;n lẻ để xuất</strong><strong style="line-height: 16px;"><br />\r\n            </strong><br />\r\n            <strong style="line-height: 16px;">(đ&atilde; bao gồm thuế GTGT)</strong><strong style="line-height: 16px;"><br />\r\n            </strong></td>\r\n        </tr>\r\n        <tr>\r\n            <td style="text-align: center;">1</td>\r\n            <td style="text-align: center;"><span style="line-height: 16px; text-align: start;">SH 125i</span></td>\r\n            <td style="text-align: center;" rowspan="2"><br type="_moz" />\r\n            <strong style="line-height: 16px;">Xanh Đen, Đỏ Đen,</strong><span style="line-height: 16px;">&nbsp;Đen, X&aacute;m Đen, Đỏ Đậm Đen, Trắng Đen</span><br />\r\n            &nbsp;</td>\r\n            <td style="text-align: center;"><span style="line-height: 16px;">65.990.000 đồng</span></td>\r\n        </tr>\r\n        <tr>\r\n            <td style="text-align: center;">2</td>\r\n            <td style="text-align: center;"><span style="line-height: 16px;">SH 150i</span></td>\r\n            <td style="text-align: center;"><span style="line-height: 16px; text-align: -webkit-center;">79.990.000 đồng</span></td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p style="text-align: center;"><img src="http://www.honda.com.vn/files/cache/e382916621410765ee271ff3f3c7ed81.jpg" alt="Xanh_Den_PB390.jpg" width="481" height="528" style="margin: 0px 10px 0px 0px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: center;" /></p>\r\n<p style="text-align: center;"><img src="http://www.honda.com.vn/files/cache/25eb66cba997745d35870129a17d57a6.jpg" alt="Do_Den_R340.jpg" width="494" height="557" style="margin: 0px 10px 0px 0px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: center;" /></p>\r\n<p style="text-align: justify;"><span style="font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Honda SH được thiết kế dựa theo những xu hướng mới v&agrave; hiện đại nhất, mang đậm phong c&aacute;ch Ch&acirc;u &Acirc;u đồng thời đạt được những t&iacute;nh năng c&oacute; độ tin cậy cao nhất. Để đ&aacute;p ứng nhu cầu của kh&aacute;ch h&agrave;ng, d&ograve;ng xe n&agrave;y được thiết kế với k&iacute;ch thước vừa gọn ph&ugrave; hợp với đặc điểm của v&ugrave;ng đ&ocirc; thị với thiết kế sang trọng v&agrave; trang nh&atilde;. Ngo&agrave;i ra, xe kh&ocirc;ng những được thiết kế tinh tế tr&ecirc;n từng chi tiết m&agrave; c&ograve;n đạt được sự h&agrave;i h&ograve;a về mặt tổng thể. Về mặt c&ocirc;ng nghệ, Honda SH đột ph&aacute; với eSP (enhanced Smart Power) - động cơ th&ocirc;ng minh thế hệ mới 125/150cc 4 chu kỳ, xy-lanh đơn, l&agrave;m m&aacute;t bằng dung dịch. Động cơ thế hệ mới n&agrave;y được thiết kế nhỏ gọn, vận h&agrave;nh &ecirc;m &aacute;i, th&acirc;n thiện m&ocirc;i trường với mức ti&ecirc;u hao nhi&ecirc;n liệu tối ưu v&agrave; được t&iacute;ch hợp những c&ocirc;ng nghệ ti&ecirc;n tiến nhất. Đồng thời, Honda SH &nbsp;mang đến những tiện nghi cao cấp nhất, gi&uacute;p người l&aacute;i ho&agrave;n to&agrave;n thoải m&aacute;i ngay cả tr&ecirc;n những chặng đường d&agrave;i.</span></p>\r\n<p>&nbsp;</p>', '32.jpg', 'honda.com.vn', 1, 2, 27, '2013-11-25 09:35:02'),
(5, 'Việt Nam khởi động dự án các đô thị thông minh', '<p><span style="font-family: Arial, Helvetica, sans-serif; line-height: 16px;">Với mong muốn chia sẻ niềm vui hơn nữa cho kh&aacute;ch h&agrave;ng mua xe Wave Alpha v&agrave; Wave 110RSX trong dịp Gi&aacute;ng sinh sắp tới, Honda Việt Nam mang tới chương tr&igrave;nh khuyến mại &ldquo;Qu&agrave; Honda cho Gi&aacute;ng sinh rộn r&atilde;!&rdquo; với tổng...</span></p>', '<p style="text-align: justify;"><span style="font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Sớm c&oacute; mặt tại thị trường Việt Nam từ cuối năm 2001, mẫu xe Wave Alpha đ&atilde; gắn b&oacute; v&agrave; đồng h&agrave;nh với người ti&ecirc;u d&ugrave;ng Việt trong nhiều năm qua nhờ kiểu d&aacute;ng trẻ trung, năng động c&ugrave;ng động cơ mạnh mẽ. Sau nhiều lần n&acirc;ng cấp, động cơ 100cc ch&iacute;nh hiệu với hệ thống kiểm so&aacute;t hơi xăng EVAPO gi&uacute;p giảm thiểu tối đa sự ph&aacute;t t&aacute;n hơi xăng ra b&ecirc;n ngo&agrave;i đ&atilde; khẳng định ưu thế về một d&ograve;ng xe c&oacute; chế độ vận h&agrave;nh ổn định, bền bỉ, tiết kiệm nhi&ecirc;n liệu v&agrave; th&acirc;n thiện với m&ocirc;i trường.</span></p>\r\n<p style="text-align: center;"><img src="http://www.honda.com.vn/files/cache/275ae347331d181784464268d5e10af8.jpg" alt="cc_red-500x500.jpg" width="387" height="387" style="margin: 0px 10px 0px 0px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: center;" /></p>\r\n<p style="text-align: justify;"><span style="font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Trong khi đ&oacute;, mẫu xe Wave 110RSX lại kho&aacute;c l&ecirc;n m&igrave;nh thiết kế đậm chất thể thao c&ugrave;ng động cơ 110cc mạnh mẽ. Hơn thế, chiếc xe c&agrave;ng trở n&ecirc;n nổi bật hơn với đ&egrave;n Halogen phản xạ đa chiều, kh&oacute;a từ an to&agrave;n v&agrave; hộc đựng đồ U-box tiện lợi cho ph&eacute;p chứa vừa một mũ bảo hiểm nửa đầu.</span></p>\r\n<p style="text-align: center;"><img src="http://www.honda.com.vn/files/cache/bc7c0adea678d700b1915343f8a059ab.jpg" alt="do-den.jpg" width="413" height="274" style="margin: 0px 10px 0px 0px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: center;" /></p>\r\n<p style="text-align: justify;"><span style="font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Với h&agrave;ng triệu xe được b&aacute;n ra từ khi ra mắt đến nay, Wave Alpha v&agrave; Wave 110RSX &nbsp;l&agrave; hai mẫu xe số được ưa th&iacute;ch của nhiều người ti&ecirc;u d&ugrave;ng Việt Nam. Với mong muốn chia sẻ niềm vui hơn nữa cho kh&aacute;ch h&agrave;ng mua xe Wave Alpha v&agrave; Wave 110RSX trong dịp Gi&aacute;ng sinh sắp tới, Honda Việt Nam mang tới chương tr&igrave;nh khuyến mại&nbsp;</span><strong style="font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">&ldquo;Qu&agrave; Honda cho Gi&aacute;ng sinh rộn r&atilde;!&rdquo;</strong><span style="font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">&nbsp;với tổng qu&agrave; tặng dự kiến l&ecirc;n đến 35,7 tỷ đồng (đ&atilde; bao gồm thuế GTGT).</span></p>\r\n<p style="text-align: center;"><img src="http://www.honda.com.vn/files/5713/8387/4394/Keyvisual0811.jpg" alt="Keyvisual0811.jpg" width="400" height="524" style="margin: 0px 10px 0px 0px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: center;" /></p>\r\n<p style="text-align: justify;"><span style="font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Cụ thể, với mỗi đơn h&agrave;ng mua xe Wave Alpha hoặc Wave RSX do Honda Việt Nam sản xuất v&agrave; b&aacute;n tại c&aacute;c Cửa H&agrave;ng B&aacute;n Xe v&agrave; Dịch Vụ do Honda Ủy Nhiệm (HEAD) tr&ecirc;n to&agrave;n quốc, kh&aacute;ch h&agrave;ng sẽ nhận được phiếu Qu&agrave; tặng trị gi&aacute; 500.000 đồng (đ&atilde; bao gồm thuế GTGT), &aacute;p dụng ngay tại lần mua xe đ&oacute;. Phiếu Qu&agrave; Tặng kh&ocirc;ng được cộng dồn, kh&ocirc;ng quy đổi sang mua Phụ t&ugrave;ng hoặc l&agrave;m dịch vụ tại HEAD. Chương tr&igrave;nh k&eacute;o d&agrave;i từ ng&agrave;y 08/11/2013 đến hết ng&agrave;y 31/12/2013.</span></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;">Mọi chi tiết về chương tr&igrave;nh khuyến mại&nbsp;<strong>&ldquo;Qu&agrave; Honda cho Gi&aacute;ng sinh rộn r&atilde;&rdquo;</strong>&nbsp;được đăng tải tr&ecirc;n website của Honda Việt Nam:&nbsp;<a href="http://www.honda.com.vn/" style="color: rgb(0, 0, 0); text-decoration: none; cursor: pointer;">www.honda.com.vn</a>&nbsp;hoặc kh&aacute;ch h&agrave;ng c&oacute; thể li&ecirc;n hệ số điện thoại miễn ph&iacute;:</p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;"><strong>1800</strong><strong>.</strong><strong>5555</strong><strong>.</strong><strong>48 (d&agrave;nh cho kh&aacute;ch</strong>&nbsp;<strong>h&agrave;ng</strong><strong>&nbsp;sử dụng&nbsp;</strong><strong>mạng&nbsp;</strong><strong>Mobi</strong><strong>fone</strong><strong>, Vina</strong><strong>phone</strong><strong>&nbsp;hoặc VNPT)</strong></p>\r\n<p style="margin: 0px 0px 10px; padding: 0px; border: 0px; list-style: none; font-family: Arial, Helvetica, sans-serif; line-height: 16px; text-align: justify;"><strong>1800.8001 (d&agrave;nh cho kh&aacute;ch</strong>&nbsp;<strong>h&agrave;ng</strong><strong>&nbsp;sử dụng mạng Viettel)</strong></p>\r\n<p>&nbsp;</p>', 'download.jpg', 'honda.com.vn', 1, 3, 15, '2013-12-25 15:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `ykienkhachhang`
--

CREATE TABLE IF NOT EXISTS `ykienkhachhang` (
  `Maykien` int(11) NOT NULL,
  `Makhachhang` int(11) NOT NULL,
  `Noidung` text NOT NULL,
  PRIMARY KEY (`Maykien`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
