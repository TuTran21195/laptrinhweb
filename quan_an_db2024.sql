-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 23, 2024 lúc 05:08 PM
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
-- Cơ sở dữ liệu: `quan_an_db2024`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `ten_mon` varchar(255) NOT NULL,
  `gia` int(10) NOT NULL,
  `loai` varchar(255) NOT NULL,
  `hien_thi` tinyint(1) DEFAULT 1,
  `mo_ta` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `menu`
--

INSERT INTO `menu` (`id`, `ten_mon`, `gia`, `loai`, `hien_thi`, `mo_ta`, `hinh_anh`) VALUES
(1, 'Bánh cá', 100000, 'Bánh', 0, 'Bánh cá x5 cái', '../uploads/banhca.png'),
(4, 'Bánh Mì Thịt Nướng', 25000, 'Bánh', 1, 'Bánh mì thịt nướng x1 ổ', '../uploads/banhMyThitNuong.png'),
(5, 'Gỏi cuốn', 1234354, 'Khác', 1, '352345264', '../uploads/goiCuon3.png'),
(6, 'Bánh quy kẹo dẻo', 20000, 'Bánh', 1, 'Bánh quy kẹo dẻo. \r\nKhối lượng: 500g.', '../uploads/banhQuykeoDeo.png'),
(7, 'Bánh giày', 10000, 'Bánh', 1, 'Bánh dày x2 cái', '../uploads/banhDay.png'),
(8, 'món ăn 2', 1243254, 'Bánh', 1, 'eatrw', '../uploads/banhKep.png'),
(9, 'món ăn 3', 123543, 'banh', 1, '145346357dssgfs', '../uploads/canhNgao.png'),
(10, 'món ăn 4', 24132, 'banh', 1, 'zfsagfs', '../uploads/canhNam.png'),
(13, 'món ăn 4', 13225, 'Nước', 1, '3257dgf', '../uploads/traSuaDauTay.png'),
(14, 'Trà việt quất', 100000, 'Nước', 1, 'Trà việt quất x1 Ly', '../uploads/traVietQuat.png'),
(15, 'Bún đậu', 35000, 'Bún', 1, 'Bún đậu', '../uploads/bunDau.png'),
(16, 'Bún real', 30000, 'Khác', 1, 'Bún real HN', '../uploads/myThitVien.png'),
(17, 'Phở gà', 40000, 'Bún', 1, 'Phở gà HN', '../uploads/phoGa.png'),
(18, 'Mẹt bún', 45000, 'Bún', 1, 'Mẹt bún x1', '../uploads/metBun.png'),
(19, 'Bánh rán mini', 10000, 'Bánh', 1, 'Bánh rán mini. Khối Lượng: 200g', '../uploads/banhRanMini.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ngay_dat` datetime NOT NULL,
  `tong_tien` int(10) NOT NULL,
  `trang_thai` enum('unconfirmed','confirmed','done') NOT NULL DEFAULT 'unconfirmed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `ngay_dat`, `tong_tien`, `trang_thai`) VALUES
(1, 1, '2024-11-30 04:16:37', 1419354, 'unconfirmed'),
(2, 1, '2024-11-30 04:26:07', 45000, 'unconfirmed');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `don_gia` int(10) NOT NULL,
  `tong_tien` int(10) GENERATED ALWAYS AS (`so_luong` * `don_gia`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `food_id`, `so_luong`, `don_gia`) VALUES
(1, 1, 4, 5, 0),
(2, 1, 6, 3, 0),
(3, 1, 5, 1, 0),
(4, 2, 4, 1, 25000),
(5, 2, 6, 1, 20000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `hoten` varchar(255) DEFAULT NULL,
  `sdt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `hoten`, `sdt`) VALUES
(1, 'khachhang1', '123', 'customer', 'khach hang 1', '09125465576'),
(2, 'chuquan', '123', 'manager', 'chu quan', '012435677'),
(3, 'nhanvien1', '123', 'sales', 'Nhan vien 1', '09745363542'),
(4, 'khachhang2', '123', 'customer', 'Khach hang 2', '0868575895'),
(5, 'doanthitramy', '123', 'customer', NULL, '231743091'),
(6, 'doanthitramt', '123', 'customer', NULL, ''),
(7, 'doanthitramt', '123', 'customer', NULL, ''),
(8, 'test', '123', 'customer', NULL, '1232432'),
(9, 'test', '123', 'customer', NULL, '01232432'),
(10, 'test', '123', 'customer', NULL, '11232432'),
(11, 'test', '1234', 'customer', NULL, '21232432'),
(12, 'test', '12345', 'customer', NULL, '31232432');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Chỉ mục cho bảng `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `food_id` (`food_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `menu` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Các ràng buộc cho bảng `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
