---
description: "Gói Attr chứa các tiện ích để quản lý thuộc tính mở rộng của các đối tượng hệ thống tệp."
---

# 8.24. Attr-2.5.2

Gói Attr chứa các tiện ích để quản lý thuộc tính mở rộng của các đối tượng hệ thống tệp.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 4.1 MB

## 8.24.1. Cài đặt Attr

Chuẩn bị biên dịch Attr:

```bash
./configure --prefix=/usr     \
            --disable-static  \
            --sysconfdir=/etc \
            --docdir=/usr/share/doc/attr-2.5.2
```

Biên dịch gói:

```bash
make
```

Các bài kiểm thử phải chạy trên hệ thống tệp hỗ trợ thuộc tính mở rộng như ext2, ext3 hoặc ext4. Để kiểm tra kết quả, chạy:

```bash
make check
```

Cài đặt gói:

```bash
make install
```

## 8.24.2. Nội dung của Attr

* **Chương trình được cài:** attr, getfattr và setfattr
* **Thư viện được cài:** libattr.so
* **Thư mục được cài:** /usr/include/attr và /usr/share/doc/attr-2.5.2

### Mô tả ngắn

* `attr` — Mở rộng thuộc tính trên các đối tượng hệ thống tệp
* `getfattr` — Lấy thuộc tính mở rộng của các đối tượng hệ thống tệp
* `setfattr` — Đặt thuộc tính mở rộng của các đối tượng hệ thống tệp
* `libattr` — Chứa các hàm thư viện để thao tác thuộc tính mở rộng

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/attr.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/attr.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/attr.html)
