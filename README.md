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
1. ✔ Đăng ký tài khoản
2. ✔ Đăng nhập, đăng xuẩt.
3. Quản lý thông tin cá nhân (Đổi mật khẩu)
4. ✔ Xem menu món ăn & Tìm kiếm món ăn trong menu

UC dành cho khách hàng:
1. ✔ Đặt món ăn online
2. Xem đơn đặt: click vào Theo dõi đơn hàng -> DS các đơn hàng đã đặt (từ mới nhất đến cũ nhất) -> click vào 1 đơn hàng -> đơn hàng chi tiết hiện ra: DS các món đặt trong đơn, số lượng, tổng tiền (same same hóa đơn)
3. Hủy đơn online nếu như trạng thái đơn hàng vẫn đang là chưa xác nhận.

UC dành cho nhân viên:
1. Xem đơn đặt online của khách và xử lý: click xác nhận đơn & báo bếp làm → (bếp làm xong) click xong đơn → (khách thanh toán) in hóa đơn
2. Nhận khách tại quầy (nhân viên thao tác đặt món cho khách): một số khách vãng lai không đặt đơn trên web thì có thể gọi món trực tiếp với nhân viên

UC dành cho quản lý (Chủ quán, nhân viên quản lý cấp cao,...):
1. ✔ Thêm, sửa, xóa món ăn & Ẩn/hiện món trong menu (Không phải mùa nào cũng có món đó để phục vụ → ẩn món ăn đi, đến mùa lại hiện lên $\neq$ UC xóa món ăn)
2. Thống kê doanh thu (ngày,tháng,quý,năm)

<div align = "center" style="color: yellow; font-size: 16px;"> → Như vậy tổng cộng có 10 UC.</div>

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
  - Còn `orders` là những đơn hàng đã được đặt rồi, nó có trường đó là order_id, user_id(khóa ngoại đến bảng `user`), ngay_dat, tong_tien, trang_thai. ('unconfirmed' - chưa được nhân viên xác nhận, 'confirmed' - đã được nhân viên xác nhận và đang tiến hành làm, 'done' - đơn hàng đã hoàn thành)
  - Vì 1 đơn hàng thì có thể có nhiều món(mà mỗi món thì có thể đặt số lượng nhiều) → cần thêm một bảng `order_item` có các trường: order_item_id, order_id(khóa ngoại đến bảng `order`), food_id (khóa ngoại đến bảng `menu`), so_luong, don_gia (chú thích *), tong_tien(this.tong_tien = this.don_gia\*this.so_luong chứ không phải là tổng tiền của tất cả các món trong đơn hàng đâu)
  
  (chú thích *: cần lưu 1 cái don_gia riêng ra thay vì dùng khóa ngoại food_id để truy xuất đến giá trong menu là vì nếu trong bảng menu mà thay đổi giá, như thế thì đơn giá cũng thay đổi, điều này sẽ làm khó khăn, nhầm lẫn trong việc truy xuất lịch sử đơn hàng về sau nếu như có thêm các chức năng thống kê. Các chức năng thống kê này thường sẽ yêu cầu xem lịch sử đơn hàng của khách, nếu như giá ở bảng menu đã thay đổi mà ta không có đơn giá cũ tại thời điểm đơn hàng được đặt, vậy khi truy xuất đơn hàng thì giá của món đó sẽ là giá mới nhất của món ăn, điều này sẽ khiến việc tổng tiền cả đơn hàng bị sẽ không ăn khớp với đơn giá)



```sql
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    food_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (food_id) REFERENCES menu(id)
);


CREATE TABLE `orders` (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    ngay_dat DATETIME NOT NULL,
    tong_tien INT(10) NOT NULL,
    trang_thai ENUM('unconfirmed', 'confirmed', 'done') NOT NULL DEFAULT 'unconfirmed',
    FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE order_item (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    food_id INT NOT NULL,
    so_luong INT NOT NULL,
    don_gia INT(10) NOT NULL,
    tong_tien INT(10) AS (so_luong * don_gia) STORED,
    FOREIGN KEY (order_id) REFERENCES `orders`(order_id),
    FOREIGN KEY (food_id) REFERENCES menu(id)
);

```
Bảng orders:

- order_id: Khóa chính tự động tăng.
- user_id: ID của người dùng, liên kết với bảng user.
- ngay_dat: Ngày đặt hàng.
- tong_tien: Tổng tiền của đơn hàng.
- trang_thai: Trạng thái của đơn hàng, với các giá trị 'chưa xác nhận', 'đã xác nhận', 'đã hoàn thành'.

Bảng order_item:

- order_item_id: Khóa chính tự động tăng.
- order_id: ID của đơn hàng, liên kết với bảng order.
- food_id: ID của món ăn, liên kết với bảng menu.
- so_luong: Số lượng món ăn trong đơn hàng.
- don_gia: Đơn giá của món ăn.
- tong_tien: Tổng tiền cho mỗi món ăn trong đơn hàng, được tính bằng so_luong * don_gia.


## API


## WebSocket

<details> 
<summary> Cài đặt và triển trai Websocket cơ bản </summary>
Bạn có thể tận dụng Composer để cài đặt các thư viện cần thiết cho việc triển khai WebSocket trong dự án PHP của bạn trên XAMPP. Dưới đây là hướng dẫn chi tiết:

### Bước 1: Cài đặt Composer
Nếu bạn đã cài đặt Composer, bạn có thể bỏ qua bước này. Nếu chưa, bạn có thể tải Composer từ [trang web chính thức](https://getcomposer.org/download/) và cài đặt theo hướng dẫn.

### Bước 2: Tạo dự án PHP mới hoặc điều hướng đến dự án hiện tại
Mở Command Prompt và điều hướng đến thư mục dự án của bạn trong `htdocs` của XAMPP:

```bash
cd C:\xampp\htdocs\your_project
```

### Bước 3: Cài đặt thư viện WebSocket
Sử dụng Composer để cài đặt thư viện WebSocket. Một trong những thư viện phổ biến cho WebSocket trong PHP là `ratchet/pawl`. Bạn có thể cài đặt nó bằng lệnh sau:

```bash
composer require ratchet/pawl
```
Lúc này trong thư mục dự án sẽ xuất hiện folder vendor → thành công!

### Bước 4: Tạo máy chủ WebSocket
Tạo một tệp PHP mới, ví dụ `server.php`, và thêm mã sau để thiết lập một máy chủ WebSocket:

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    public function onOpen(ConnectionInterface $conn) {
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Message received: {$msg}\n";
        $from->send("Server received: {$msg}");
    }

    public function onClose(ConnectionInterface $conn) {
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

$server->run();
```

### Bước 5: Chạy máy chủ WebSocket
Chạy máy chủ WebSocket bằng lệnh:

```bash
php server.php
```

### Bước 6: Tạo máy khách WebSocket
Tạo một tệp HTML để làm máy khách WebSocket. Tạo một tệp `index.html` và thêm mã sau:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Client</title>
</head>
<body>
    <h1>WebSocket Client</h1>
    <input type="text" id="messageInput" placeholder="Enter message">
    <button onclick="sendMessage()">Send</button>
    <div id="messages"></div>

    <script>
        const ws = new WebSocket('ws://localhost:8080');

        ws.onopen = () => {
            console.log('Connected to server');
        };

        ws.onmessage = (event) => {
            const messagesDiv = document.getElementById('messages');
            const message = document.createElement('div');
            message.textContent = `Server: ${event.data}`;
            messagesDiv.appendChild(message);
        };

        ws.onclose = () => {
            console.log('Disconnected from server');
        };

        function sendMessage() {
            const input = document.getElementById('messageInput');
            ws.send(input.value);
            input.value = '';
        }
    </script>
</body>
</html>
```

### Bước 7: Kiểm tra kết nối
Mở tệp `index.html` trong trình duyệt của bạn. Bạn sẽ thấy một giao diện đơn giản để gửi và nhận tin nhắn qua WebSocket.

Với các bước trên, bạn đã thiết lập một máy chủ và máy khách WebSocket cơ bản sử dụng Composer và XAMPP. Nếu bạn có thêm câu hỏi nào khác hoặc cần hỗ trợ thêm, đừng ngần ngại hỏi nhé!

</details>