---
description: "Gói Libtool chứa script hỗ trợ thư viện tổng quát của GNU. Nó giúp việc dùng thư viện chia sẻ đơn giản hơn nhờ một giao diện nhất quán, di động."
---

# 8.37. Libtool-2.5.4

Gói Libtool chứa script hỗ trợ thư viện tổng quát của GNU. Nó giúp việc dùng thư viện chia sẻ đơn giản hơn nhờ một giao diện nhất quán, di động.

* **Thời gian dựng ước tính:** 0.6 SBU
* **Dung lượng đĩa cần:** 44 MB

## 8.37.1. Cài đặt Libtool

Chuẩn bị biên dịch Libtool:

```bash
./configure --prefix=/usr
```

Biên dịch gói:

```bash
make
```

Để kiểm thử kết quả, chạy:

```bash
make check
```

Cài đặt gói:

```bash
make install
```

Xóa một thư viện tĩnh chỉ hữu ích cho bộ kiểm thử:

```bash
rm -fv /usr/lib/libltdl.a
```

## 8.37.2. Nội dung của Libtool

* **Chương trình được cài:** libtool và libtoolize
* **Thư viện được cài:** libltdl.so
* **Thư mục được cài:** /usr/include/libltdl và /usr/share/libtool

### Mô tả ngắn

* `libtool` — Cung cấp các dịch vụ hỗ trợ dựng thư viện tổng quát
* `libtoolize` — Cung cấp cách chuẩn để thêm hỗ trợ `libtool` vào một gói
* `libltdl` — Che đi các khó khăn khác nhau khi mở các thư viện nạp động

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/libtool.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/libtool.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/libtool.html)
