---
description: "Gói IPRoute2 chứa các chương trình dành cho mạng cơ bản và nâng cao dựa trên IPv4."
---

# 8.66. IPRoute2-6.16.0

Gói IPRoute2 chứa các chương trình dành cho mạng cơ bản và nâng cao dựa trên IPv4.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 17 MB

## 8.66.1. Cài đặt IPRoute2

Chương trình `arpd` trong gói này sẽ không được dựng vì nó phụ thuộc vào Berkeley DB, thứ không có trong LFS. Tuy vậy, một thư mục và một trang man của `arpd` vẫn sẽ được cài. Hãy ngăn điều đó bằng các lệnh dưới đây.

```bash
sed -i /ARPD/d Makefile
rm -fv man/man8/arpd.8
```

Biên dịch gói:

```bash
make NETNS_RUN_DIR=/run/netns
```

Gói này không có bộ kiểm thử dùng được.

Cài đặt gói:

```bash
make SBINDIR=/usr/sbin install
```

Nếu muốn, cài tài liệu:

```bash
install -vDm644 COPYING README* -t /usr/share/doc/iproute2-6.16.0
```

## 8.66.2. Nội dung của IPRoute2

* **Chương trình được cài:** bridge, ctstat (liên kết tới lnstat), genl, ifstat, ip, lnstat, nstat, routel, rtacct, rtmon, rtpr, rtstat (liên kết tới lnstat), ss và tc
* **Thư mục được cài:** /etc/iproute2, /usr/lib/tc và /usr/share/doc/iproute2-6.16.0

### Mô tả ngắn

* `bridge` — Cấu hình các cầu nối mạng (network bridge)
* `ctstat` — Tiện ích xem trạng thái kết nối
* `genl` — Giao diện front end cho tiện ích netlink tổng quát
* `ifstat` — Hiển thị thống kê giao diện mạng, gồm số gói đã gửi và nhận, theo từng giao diện
* `ip` — Tệp thực thi chính. Nó có nhiều chức năng, trong đó có: `ip link <device>` cho phép xem trạng thái của thiết bị và thay đổi chúng `ip addr` cho phép xem địa chỉ và thuộc tính của chúng, thêm địa chỉ mới và xóa địa chỉ cũ `ip neighbor` cho phép xem các liên kết láng giềng và thuộc tính của chúng, thêm mục láng giềng mới và xóa mục cũ `ip rule` cho phép xem và thay đổi các chính sách định tuyến `ip route` cho phép xem bảng định tuyến và thay đổi các quy tắc trong đó `ip tunnel` cho phép xem các đường hầm IP và thuộc tính của chúng, cũng như thay đổi chúng `ip maddr` cho phép xem các địa chỉ multicast và thuộc tính của chúng, cũng như thay đổi chúng `ip mroute` cho phép thiết lập, thay đổi hoặc xóa định tuyến multicast `ip monitor` cho phép theo dõi liên tục trạng thái của thiết bị, địa chỉ và các tuyến đường
* `lnstat` — Cung cấp thống kê mạng của Linux; đây là bản thay thế tổng quát và đầy đủ tính năng hơn cho chương trình `rtstat` cũ
* `nstat` — Hiển thị thống kê mạng
* `routel` — Một thành phần của `ip route`, dùng để liệt kê các bảng định tuyến
* `rtacct` — Hiển thị nội dung của `/proc/net/rt_acct`
* `rtmon` — Tiện ích theo dõi tuyến đường
* `rtpr` — Chuyển đầu ra của `ip -o` sang dạng dễ đọc
* `rtstat` — Tiện ích xem trạng thái tuyến đường
* `ss` — Tương tự lệnh `netstat`; hiển thị các kết nối đang hoạt động
* `tc` — Điều khiển lưu lượng cho các triển khai Quality of Service (QoS) và Class of Service (CoS) `tc qdisc` cho phép thiết lập queueing discipline (cách xếp hàng đợi) `tc class` cho phép thiết lập các lớp dựa trên cách lập lịch của queueing discipline `tc filter` cho phép thiết lập bộ lọc gói QoS/CoS `tc monitor` có thể dùng để xem các thay đổi đã áp dụng cho Traffic Control trong kernel.

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/iproute2.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/iproute2.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/iproute2.html)
