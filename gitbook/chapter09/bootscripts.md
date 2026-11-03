---
description: "Gói LFS-Bootscripts chứa một bộ script để khởi động\/dừng hệ thống LFS lúc bật\/tắt máy. Các tệp cấu hình và quy trình cần thiết để tùy biến quá trình khởi đ"
---

# 9.2. LFS-Bootscripts-20250827

Gói LFS-Bootscripts chứa một bộ script để khởi động/dừng hệ thống LFS lúc bật/tắt máy. Các tệp cấu hình và quy trình cần thiết để tùy biến quá trình khởi động được mô tả trong các mục sau.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 238 KB

## 9.2.1. Cài đặt LFS-Bootscripts

Cài đặt gói:

```bash
make install
```

## 9.2.2. Nội dung của LFS-Bootscripts

* **Script được cài:** checkfs, cleanfs, console, functions, halt, ifdown, ifup, localnet, modules, mountfs, mountvirtfs, network, rc, reboot, sendsignals, setclock, ipv4-static, swap, sysctl, sysklogd, template, udev và udev\_retry
* **Thư mục được cài:** /etc/rc.d, /etc/init.d (liên kết mềm), /etc/sysconfig, /lib/services, /lib/lsb (liên kết mềm)

### Mô tả ngắn

* `checkfs` — Kiểm tra tính toàn vẹn của các hệ thống tệp trước khi mount (trừ các hệ thống tệp journaling và hệ thống tệp qua mạng)
* `cleanfs` — Xóa các tệp không nên giữ lại giữa các lần khởi động lại, chẳng hạn các tệp trong `/run/` và `/var/lock/`; nó tạo lại `/run/utmp` và xóa các tệp `/etc/nologin`, `/fastboot` và `/forcefsck` nếu có
* `console` — Nạp bảng keymap đúng cho bố cục bàn phím mong muốn; đồng thời đặt phông chữ màn hình
* `functions` — Chứa các hàm dùng chung, như kiểm tra lỗi và trạng thái, được nhiều bootscript sử dụng
* `halt` — Dừng hệ thống
* `ifdown` — Dừng một thiết bị mạng
* `ifup` — Khởi tạo một thiết bị mạng
* `localnet` — Thiết lập tên máy (hostname) và thiết bị loopback cục bộ của hệ thống
* `modules` — Nạp các module kernel được liệt kê trong `/etc/sysconfig/modules`, với các đối số cũng được khai báo ở đó
* `mountfs` — Mount tất cả hệ thống tệp, trừ những hệ thống được đánh dấu *noauto* hoặc dựa trên mạng
* `mountvirtfs` — Mount các hệ thống tệp ảo của kernel, như `proc`
* `network` — Thiết lập các giao diện mạng, như card mạng, và đặt gateway mặc định (nếu có)
* `rc` — Script điều khiển run-level chính; nó chịu trách nhiệm chạy lần lượt tất cả các bootscript khác, theo thứ tự xác định bởi tên các liên kết mềm trỏ tới những bootscript đó
* `reboot` — Khởi động lại hệ thống
* `sendsignals` — Đảm bảo mọi tiến trình đã kết thúc trước khi hệ thống khởi động lại hoặc dừng
* `setclock` — Đặt lại đồng hồ hệ thống theo giờ địa phương nếu đồng hồ phần cứng không đặt theo UTC
* `ipv4-static` — Cung cấp chức năng cần thiết để gán địa chỉ Internet Protocol (IP) tĩnh cho một giao diện mạng
* `swap` — Bật và tắt các tệp và phân vùng swap
* `sysctl` — Nạp các giá trị cấu hình hệ thống từ `/etc/sysctl.conf`, nếu tệp đó tồn tại, vào kernel đang chạy
* `sysklogd` — Khởi động và dừng các daemon nhật ký của hệ thống và kernel
* `template` — Một mẫu để tạo bootscript tùy chỉnh cho các daemon khác
* `udev` — Chuẩn bị thư mục `/dev` và khởi động daemon udev
* `udev_retry` — Thử lại các uevent udev đã thất bại, và sao chép các tệp quy tắc được tạo từ `/run/udev` sang `/etc/udev/rules.d` nếu cần

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter09/bootscripts.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter09/bootscripts.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter09/bootscripts.html)
