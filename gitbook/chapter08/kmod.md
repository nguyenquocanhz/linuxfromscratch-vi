---
description: "Gói Kmod chứa các thư viện và tiện ích để nạp các module kernel"
---

# 8.58. Kmod-34.2

Gói Kmod chứa các thư viện và tiện ích để nạp các module kernel

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 6.7 MB

## 8.58.1. Cài đặt Kmod

Chuẩn bị biên dịch Kmod:

```bash
mkdir -p build
cd       build

meson setup --prefix=/usr ..    \
            --buildtype=release \
            -D manpages=false
```

**Ý nghĩa các tùy chọn configure:**

**`-D manpages=false`**

> Tùy chọn này tắt việc tạo các trang man, vì việc đó cần một chương trình bên ngoài.

Biên dịch gói:

```bash
ninja
```

Bộ kiểm thử của gói này cần các header kernel thô (không phải các header kernel đã được “làm sạch” cài trước đó), điều nằm ngoài phạm vi của LFS.

Giờ hãy cài đặt gói:

```bash
ninja install
```

## 8.58.2. Nội dung của Kmod

* **Chương trình được cài:** depmod (liên kết tới kmod), insmod (liên kết tới kmod), kmod, lsmod (liên kết tới kmod), modinfo (liên kết tới kmod), modprobe (liên kết tới kmod) và rmmod (liên kết tới kmod)
* **Thư viện được cài:** libkmod.so

### Mô tả ngắn

* `depmod` — Tạo tệp phụ thuộc dựa trên các symbol tìm thấy trong tập module hiện có; tệp phụ thuộc này được `modprobe` dùng để tự động nạp các module cần thiết
* `insmod` — Cài một module nạp được vào kernel đang chạy
* `kmod` — Nạp và gỡ các module kernel
* `lsmod` — Liệt kê các module đang được nạp
* `modinfo` — Kiểm tra một tệp đối tượng gắn với module kernel và hiển thị mọi thông tin có thể thu được
* `modprobe` — Dùng tệp phụ thuộc do `depmod` tạo ra để tự động nạp các module liên quan
* `rmmod` — Gỡ các module khỏi kernel đang chạy
* `libkmod` — Thư viện này được các chương trình khác dùng để nạp và gỡ module kernel

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/kmod.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/kmod.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/kmod.html)
