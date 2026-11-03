---
description: "Gói Expat chứa một thư viện C hướng luồng (stream) để phân tích cú pháp XML."
---

# 8.40. Expat-2.7.1

Gói Expat chứa một thư viện C hướng luồng (stream) để phân tích cú pháp XML.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 14 MB

## 8.40.1. Cài đặt Expat

Chuẩn bị biên dịch Expat:

```bash
./configure --prefix=/usr    \
            --disable-static \
            --docdir=/usr/share/doc/expat-2.7.1
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

Nếu muốn, hãy cài đặt tài liệu:

```bash
install -v -m644 doc/*.{html,css} /usr/share/doc/expat-2.7.1
```

## 8.40.2. Nội dung của Expat

* **Chương trình được cài:** xmlwf
* **Thư viện được cài:** libexpat.so
* **Thư mục được cài:** /usr/share/doc/expat-2.7.1

### Mô tả ngắn

* `xmlwf` — Là tiện ích không kiểm tra hợp lệ (non-validating), dùng để xem tài liệu XML có đúng cấu trúc (well-formed) hay không
* `libexpat` — Chứa các hàm API để phân tích cú pháp XML

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/expat.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/expat.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/expat.html)
