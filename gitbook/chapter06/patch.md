---
description: "Gói Patch chứa một chương trình để sửa đổi hoặc tạo tệp bằng cách áp dụng tệp “patch” (bản vá), thường được tạo bởi chương trình diff."
---

# 6.13. Patch-2.8

Gói Patch chứa một chương trình để sửa đổi hoặc tạo tệp bằng cách áp dụng tệp “patch” (bản vá), thường được tạo bởi chương trình `diff`.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 14 MB

## 6.13.1. Cài đặt Patch

Chuẩn bị biên dịch Patch:

```bash
./configure --prefix=/usr   \
            --host=$LFS_TGT \
            --build=$(build-aux/config.guess)
```

Biên dịch gói:

```bash
make
```

Cài đặt gói:

```bash
make DESTDIR=$LFS install
```

Chi tiết về gói này nằm trong [Mục 8.70.2, “Nội dung của Patch.”](../chapter08/patch.md#contents-patch)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/patch.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/patch.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/patch.html)
