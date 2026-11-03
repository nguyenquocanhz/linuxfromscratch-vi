---
description: "Chi tiết về gói này nằm trong Mục 8.65.2, “Nội dung của Gzip.”"
---

# 6.11. Gzip-1.14

Gói Gzip chứa các chương trình để nén và giải nén tệp.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 12 MB

## 6.11.1. Cài đặt Gzip

Chuẩn bị biên dịch Gzip:

```bash
./configure --prefix=/usr --host=$LFS_TGT
```

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
```

Chi tiết về gói này nằm trong [Mục 8.65.2, “Nội dung của Gzip.”](../chapter08/gzip.md#contents-gzip)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/gzip.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/gzip.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/gzip.html)
