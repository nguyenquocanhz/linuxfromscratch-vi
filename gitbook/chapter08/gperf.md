---
description: "Gperf sinh ra hàm băm hoàn hảo (perfect hash) từ một tập khóa."
---

# 8.39. Gperf-3.3

Gperf sinh ra hàm băm hoàn hảo (perfect hash) từ một tập khóa.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 12 MB

## 8.39.1. Cài đặt Gperf

Chuẩn bị biên dịch Gperf:

```bash
./configure --prefix=/usr --docdir=/usr/share/doc/gperf-3.3
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

## 8.39.2. Nội dung của Gperf

* **Chương trình được cài:** gperf
* **Thư mục được cài:** /usr/share/doc/gperf-3.3

### Mô tả ngắn

* `gperf` — Sinh ra hàm băm hoàn hảo từ một tập khóa

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter08/gperf.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter08/gperf.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter08/gperf.html)
