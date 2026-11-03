---
description: "Gói Zlib chứa các hàm nén và giải nén được một số chương trình sử dụng."
---

# 8.6. Zlib-1.3.1

Gói Zlib chứa các hàm nén và giải nén được một số chương trình sử dụng.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 6.4 MB

## 8.6.1. Cài đặt Zlib

Chuẩn bị biên dịch Zlib:

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

Xóa một thư viện tĩnh vô dụng:

```bash
rm -fv /usr/lib/libz.a
```

## 8.6.2. Nội dung của Zlib

* **Thư viện được cài:** libz.so

### Mô tả ngắn

* `libz` — Chứa các hàm nén và giải nén được một số chương trình sử dụng

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/zlib.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/zlib.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/zlib.html)
