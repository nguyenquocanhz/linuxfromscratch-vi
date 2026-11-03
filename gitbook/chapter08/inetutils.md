---
description: "Tùy chọn này ngăn Inetutils cài chương trình logger, vốn được các script dùng để gửi thông điệp đến System Log Daemon. Không cần cài nó vì Util-linux đã cà"
---

# 8.41. Inetutils-2.6

Gói Inetutils chứa các chương trình mạng cơ bản.

* **Thời gian dựng ước tính:** 0.3 SBU
* **Dung lượng đĩa cần:** 36 MB

## 8.41.1. Cài đặt Inetutils

Trước tiên, chỉnh để gói dựng được với gcc-14.1 trở lên:

```bash
sed -i 's/def HAVE_TERMCAP_TGETENT/ 1/' telnet/telnet.c
```

Chuẩn bị biên dịch Inetutils:

```bash
./configure --prefix=/usr        \
            --bindir=/usr/bin    \
            --localstatedir=/var \
            --disable-logger     \
            --disable-whois      \
            --disable-rcp        \
            --disable-rexec      \
            --disable-rlogin     \
            --disable-rsh        \
            --disable-servers
```

**Ý nghĩa các tùy chọn configure:**

**`--disable-logger`**

> Tùy chọn này ngăn Inetutils cài chương trình `logger`, vốn được các script dùng để gửi thông điệp đến System Log Daemon. Không cần cài nó vì Util-linux đã cài một phiên bản mới hơn.

**`--disable-whois`**

> Tùy chọn này tắt việc dựng client `whois` của Inetutils, vốn đã lỗi thời. Hướng dẫn cài một client `whois` tốt hơn có trong sách BLFS.

**`--disable-r*`**

> Các tham số này tắt việc dựng những chương trình lỗi thời, không nên dùng vì vấn đề bảo mật. Chức năng của chúng có thể được thay thế bằng gói `openssh` trong sách BLFS.

**`--disable-servers`**

> Tùy chọn này tắt việc cài các máy chủ mạng đi kèm gói Inetutils. Những máy chủ này được coi là không phù hợp với một hệ thống LFS cơ bản. Một số vốn không an toàn và chỉ được xem là an toàn trên mạng tin cậy. Lưu ý rằng với nhiều máy chủ trong số này đã có các lựa chọn thay thế tốt hơn.

Biên dịch gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
make check
```

Có một bài kiểm thử tên `libls.sh` thỉnh thoảng bị lỗi, đây là chuyện đã biết.

Cài đặt gói:

```bash
make install
```

Chuyển một chương trình về đúng vị trí:

```bash
mv -v /usr/{,s}bin/ifconfig
```

## 8.41.2. Nội dung của Inetutils

* **Chương trình được cài:** dnsdomainname, ftp, ifconfig, hostname, ping, ping6, talk, telnet, tftp và traceroute

### Mô tả ngắn

* `dnsdomainname` — Hiển thị tên miền DNS của hệ thống
* `ftp` — Chương trình giao thức truyền tệp (FTP)
* `hostname` — Hiển thị hoặc đặt tên của máy
* `ifconfig` — Quản lý các giao diện mạng
* `ping` — Gửi các gói echo-request và báo cáo thời gian nhận phản hồi
* `ping6` — Phiên bản của `ping` dành cho mạng IPv6
* `talk` — Dùng để trò chuyện với người dùng khác
* `telnet` — Giao diện cho giao thức TELNET
* `tftp` — Chương trình truyền tệp đơn giản (TFTP)
* `traceroute` — Dò đường đi của các gói tin từ máy bạn đang dùng đến một máy khác trên mạng, hiển thị mọi chặng trung gian (gateway) trên đường đi

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/inetutils.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/inetutils.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/inetutils.html)
