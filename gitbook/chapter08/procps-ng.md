---
description: "Tùy chọn này tắt việc dựng lệnh kill; lệnh này sẽ được cài từ gói Util-linux."
---

# 8.78. Procps-ng-4.0.5

Gói Procps-ng chứa các chương trình để giám sát tiến trình.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 28 MB

## 8.78.1. Cài đặt Procps-ng

Chuẩn bị biên dịch Procps-ng:

```bash
./configure --prefix=/usr                           \
            --docdir=/usr/share/doc/procps-ng-4.0.5 \
            --disable-static                        \
            --disable-kill                          \
            --enable-watch8bit
```

**Ý nghĩa của tùy chọn configure:**

**`--disable-kill`**

> Tùy chọn này tắt việc dựng lệnh `kill`; lệnh này sẽ được cài từ gói Util-linux.

**`--enable-watch8bit`**

> Tùy chọn này bật hỗ trợ ncursesw cho lệnh `watch`, để nó xử lý được các ký tự 8-bit.

Biên dịch gói:

```bash
make
```

Để chạy bộ kiểm thử, chạy:

```bash
chown -R tester .
su tester -c "PATH=$PATH make check"
```

Có một bài kiểm thử tên `ps with output flag bsdtime,cputime,etime,etimes` được biết là sẽ thất bại nếu kernel của máy host không được dựng với `CONFIG_BSD_PROCESS_ACCT` bật. Ngoài ra, một bài kiểm thử pgrep có thể thất bại trong môi trường chroot.

Cài đặt gói:

```bash
make install
```

## 8.78.2. Nội dung của Procps-ng

* **Chương trình được cài:** free, pgrep, pidof, pkill, pmap, ps, pwdx, slabtop, sysctl, tload, top, uptime, vmstat, w và watch
* **Thư viện được cài:** libproc-2.so
* **Thư mục được cài:** /usr/include/procps và /usr/share/doc/procps-ng-4.0.5

### Mô tả ngắn

* `free` — Báo cáo lượng bộ nhớ trống và đang dùng (cả bộ nhớ vật lý lẫn swap) trong hệ thống
* `pgrep` — Tìm các tiến trình dựa trên tên và các thuộc tính khác
* `pidof` — Báo cáo PID của các chương trình được chỉ định
* `pkill` — Gửi tín hiệu đến các tiến trình dựa trên tên và các thuộc tính khác
* `pmap` — Báo cáo bản đồ bộ nhớ của tiến trình được chỉ định
* `ps` — Liệt kê các tiến trình đang chạy
* `pwdx` — Báo cáo thư mục làm việc hiện tại của một tiến trình
* `slabtop` — Hiển thị thông tin chi tiết về slab cache của kernel theo thời gian thực
* `sysctl` — Chỉnh các tham số kernel lúc đang chạy
* `tload` — In biểu đồ tải trung bình hiện tại của hệ thống
* `top` — Hiển thị danh sách các tiến trình tốn CPU nhất; cho cái nhìn liên tục về hoạt động của bộ xử lý theo thời gian thực
* `uptime` — Báo cáo hệ thống đã chạy được bao lâu, có bao nhiêu người dùng đang đăng nhập và tải trung bình của hệ thống
* `vmstat` — Báo cáo thống kê bộ nhớ ảo, cho biết thông tin về tiến trình, bộ nhớ, paging, vào/ra khối (IO), trap và hoạt động của CPU
* `w` — Cho biết những người dùng nào đang đăng nhập, ở đâu và từ khi nào
* `watch` — Chạy một lệnh lặp đi lặp lại, hiển thị trang đầu tiên của đầu ra; cho phép người dùng quan sát đầu ra thay đổi theo thời gian
* `libproc-2` — Chứa các hàm được hầu hết chương trình trong gói này sử dụng

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/procps-ng.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/procps-ng.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/procps-ng.html)
