---
description: "FHS khuyến nghị dùng thư mục \/var\/lib\/hwclock thay vì thư mục \/etc thông thường làm nơi đặt tệp adjtime. Tạo thư mục này bằng:"
---

# 7.12. Util-linux-2.41.1

Gói Util-linux chứa nhiều chương trình tiện ích khác nhau.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 192 MB

## 7.12.1. Cài đặt Util-linux

FHS khuyến nghị dùng thư mục `/var/lib/hwclock` thay vì thư mục `/etc` thông thường làm nơi đặt tệp `adjtime`. Tạo thư mục này bằng:

```bash
mkdir -pv /var/lib/hwclock
```

Chuẩn bị biên dịch Util-linux:

```bash
./configure --libdir=/usr/lib     \
            --runstatedir=/run    \
            --disable-chfn-chsh   \
            --disable-login       \
            --disable-nologin     \
            --disable-su          \
            --disable-setpriv     \
            --disable-runuser     \
            --disable-pylibmount  \
            --disable-static      \
            --disable-liblastlog2 \
            --without-python      \
            ADJTIME_PATH=/var/lib/hwclock/adjtime \
            --docdir=/usr/share/doc/util-linux-2.41.1
```

**Ý nghĩa các tùy chọn configure:**

**`ADJTIME_PATH=/var/lib/hwclock/adjtime`**

> Thiết lập vị trí tệp ghi thông tin đồng hồ phần cứng theo đúng FHS. Điều này không thật sự cần cho công cụ tạm này, nhưng nó ngăn việc tạo một tệp ở vị trí khác, tệp đó sẽ không bị ghi đè hay xóa khi dựng gói util-linux cuối cùng.

**`--libdir=/usr/lib`**

> Tùy chọn này đảm bảo các symlink `.so` trỏ trực tiếp tới tệp thư viện dùng chung trong cùng thư mục (`/usr/lib`).

**`--disable-*`**

> Các tùy chọn này ngăn cảnh báo về việc dựng các thành phần cần gói không có trong LFS hoặc chưa được cài.

**`--without-python`**

> Tùy chọn này tắt việc dùng `Python`. Nó tránh việc cố dựng các binding không cần thiết.

**`runstatedir=/run`**

> Tùy chọn này đặt đúng vị trí socket mà `uuidd` và `libuuid` sử dụng.

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make install
```

Chi tiết về gói này nằm trong [Mục 8.79.2, “Nội dung của Util-linux.”](../chapter08/util-linux.md#contents-utillinux)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter07/util-linux.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter07/util-linux.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter07/util-linux.html)
