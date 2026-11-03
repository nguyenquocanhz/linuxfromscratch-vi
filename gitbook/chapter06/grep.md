---
description: "Gói Grep chứa các chương trình để tìm kiếm trong nội dung tệp."
---

# 6.10. Grep-3.12

Gói Grep chứa các chương trình để tìm kiếm trong nội dung tệp.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 32 MB

## 6.10.1. Cài đặt Grep

Chuẩn bị biên dịch Grep:

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

Chi tiết về gói này nằm trong [Mục 8.35.2, “Nội dung của Grep.”](../chapter08/grep.md#contents-grep)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/grep.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/grep.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/grep.html)
