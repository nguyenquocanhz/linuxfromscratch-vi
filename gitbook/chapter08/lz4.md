---
description: "Lz4 là thuật toán nén không mất dữ liệu, với tốc độ nén trên 500 MB\/s mỗi nhân. Nó có bộ giải nén cực nhanh, đạt tốc độ nhiều GB\/s mỗi nhân. Lz4 có thể kết"
---

# 8.9. Lz4-1.10.0

Lz4 là thuật toán nén không mất dữ liệu, với tốc độ nén trên 500 MB/s mỗi nhân. Nó có bộ giải nén cực nhanh, đạt tốc độ nhiều GB/s mỗi nhân. Lz4 có thể kết hợp với Zstandard để cả hai thuật toán nén dữ liệu nhanh hơn.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 4.2 MB

## 8.9.1. Cài đặt Lz4

Biên dịch gói:

```bash
make BUILD_STATIC=no PREFIX=/usr
```

Để kiểm thử kết quả, chạy:

```bash
make -j1 check
```

Cài đặt gói:

```bash
make BUILD_STATIC=no PREFIX=/usr install
```

## 8.9.2. Nội dung của Lz4

* **Chương trình được cài:** lz4, lz4c (liên kết tới lz4), lz4cat (liên kết tới lz4) và unlz4 (liên kết tới lz4)
* **Thư viện được cài:** liblz4.so

### Mô tả ngắn

* `lz4` — Nén hoặc giải nén tệp theo định dạng LZ4
* `lz4c` — Nén tệp theo định dạng LZ4
* `lz4cat` — Liệt kê nội dung của tệp đã nén theo định dạng LZ4
* `unlz4` — Giải nén tệp theo định dạng LZ4
* `liblz4` — Thư viện cài đặt việc nén dữ liệu không mất mát bằng thuật toán LZ4

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/lz4.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/lz4.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/lz4.html)
