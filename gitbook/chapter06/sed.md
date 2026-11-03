---
description: "Chi tiết về gói này nằm trong Mục 8.31.2, “Nội dung của Sed.”"
---

# 6.14. Sed-4.9

Gói Sed chứa một trình soạn thảo luồng (stream editor).

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 21 MB

## 6.14.1. Cài đặt Sed

Chuẩn bị biên dịch Sed:

```bash
./configure --prefix=/usr   \
            --host=$LFS_TGT \
            --build=$(./build-aux/config.guess)
```

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
```

Chi tiết về gói này nằm trong [Mục 8.31.2, “Nội dung của Sed.”](../chapter08/sed.md#contents-sed)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/sed.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/sed.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/sed.html)
