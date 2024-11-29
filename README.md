<h1 align="center"> Hệ thống quản lý quán ăn </h1>
<div align="center">

|           |     |                   |
| --------- | --- | ----------------- |
| Sinh viên | :   | Đoàn Thị Trà My   |
| MSSV      | :   | B21DCAT134        |
| Môn học   | :   | Lập trình web     |
| GVHD      | :   | Nguyễn Quang Hưng |
|           |     |
</div>


# Tổng quan
## Giới thiệu
Đây là một ứng dụng web giúp quản lý quán ăn, bao gồm các chức năng như quản lý thực đơn, đặt món, và theo dõi tình trạng đơn đặt.

## Mô tả các chức năng hệ thống bằng ngôn ngữ tự nhiên
Hệ thống quản lý quán ăn sẽ có ...


## Các ngôn ngữ, công nghệ, kỹ thuật đã sử dụng

- PHP
- Boostrap
- jQuery
- AJAX
- WebSocket

## Các Use Case toàn hệ thống
UC chung cho các user: 
1. Đăng ký tài khoản, đăng nhập, đăng xuẩt.
2. Quản lý thông tin cá nhân (Đổi mật khẩu)
3. Xem menu món ăn.
4. Tìm kiếm món ăn trong menu

UC dành cho khách hàng:
1. Đặt món ăn online
2. Hủy đơn online/thêm bớt món nếu như nhân viên chưa xác nhận.

UC dành cho nhân viên:
1. Xem đơn đặt online của khách và xử lý: xác nhận đơn → báo bếp làm → (bếp làm xong) click xong đơn → (khách thanh toán) in hóa đơn
2. Nhận khách tại quầy (nhân viên thao tác đặt món cho khách): một số khách vãng lai không đặt đơn trên web thì có thể gọi món trực tiếp với nhân viên

UC dành cho quản lý (Chủ quán, nhân viên quản lý cấp cao,...):
1. Lên combo
2. Thêm, sửa, xóa món ăn
3. Ẩn/hiện món trong menu (Không phải mùa nào cũng có món đó để phục vụ → ẩn món ăn đi, đến mùa lại hiện lên $\neq$ UC xóa món ăn)
4. Thống kê doanh thu (ngày,tháng,quý,năm)

<div align = "center" style="color: yellow; font-size: 16px;"> → Như vậy tổng cộng có 12 UC.</div>

# Thiết kế chi tiết
## Các giao diện
Cố định các giao diện sẽ bao gồm navigation bar và footer là thông tin của nhà hàng.

Khi người dùng chưa đăng nhập, giao diện sẽ bao gồm:
- Navigation bar: Nút đăng nhập
- Một danh sách món ăn
- Form nhập từ khóa và nút tìm kiếm món ăn.

Khi người dùng đăng nhập thành công với vai trò là:


## CSDL
`quan_an_db2024`
- bảng `user`:
  - Cột `id`
  - Cột `username`
  - cột `password`
  - Cột `role`: 0- user thường (customer); 1- nhân viên; 2- quản lý (chủ quán)

- Bảng `cart`: lưu thông tin về giỏ hàng của các KH(vớ các user_id khác nhau)
- Bảng `order`: lưu thông tin về các đơn đặt hàng khác nhau
  - Lưu ý rằng `cart` chỉ là giỏ hàng, người dùng thích thêm bao nhiêu sp cũng được và họ chưa đặt mua, cũng chẳng cần lưu lại tổng tiền.
  - Còn `order` là những đơn hàng đã được đặt rồi, nó có trường đó là order_id, user_id(khóa ngoại đến bảng `user`), ngay_dat, tong_tien, trang_thai.
  - Vì 1 đơn hàng thì có thể có nhiều món(mà mỗi món thì có thể đặt số lượng nhiều) → cần thêm một bảng `order_item` có các trường: order_item_id, order_id(khóa ngoại đến bảng `order`), food_id (khóa ngoại đến bảng `menu`), so_luong, don_gia (chú thích *), tong_tien(this.tong_tien = this.don_gia\*this.so_luong chứ không phải là tổng tiền của tất cả các món trong đơn hàng đâu)
  
  (chú thích *: cần lưu 1 cái don_gia riêng ra thay vì dùng khóa ngoại food_id để truy xuất đến giá trong menu là vì nếu trong bảng menu mà thay đổi giá, như thế thì đơn giá cũng thay đổi, điều này sẽ làm khó khăn, nhầm lẫn trong việc truy xuất lịch sử đơn hàng về sau nếu như có thêm các chức năng thống kê. Các chức năng thống kê này thường sẽ yêu cầu xem lịch sử đơn hàng của khách, nếu như giá ở bảng menu đã thay đổi mà ta không có đơn giá cũ tại thời điểm đơn hàng được đặt, vậy khi truy xuất đơn hàng thì giá của món đó sẽ là giá mới nhất của món ăn, điều này sẽ khiến việc tổng tiền cả đơn hàng bị sẽ không ăn khớp với đơn giá)



## API