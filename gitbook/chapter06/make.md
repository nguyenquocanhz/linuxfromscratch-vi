---
description: "Gói Make chứa chương trình điều khiển việc tạo ra các tệp thực thi và các tệp không phải mã nguồn khác của một gói từ mã nguồn."
---

# 6.12. Make-4.4.1

Gói Make chứa chương trình điều khiển việc tạo ra các tệp thực thi và các tệp không phải mã nguồn khác của một gói từ mã nguồn.

* **Thời gian dựng ước tính:** dưới 0.1 SBU
* **Dung lượng đĩa cần:** 15 MB

## 6.12.1. Cài đặt Make

Chuẩn bị biên dịch Make:

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

Chi tiết về gói này nằm trong [Mục 8.69.2, “Nội dung của Make.”](../chapter08/make.md#contents-make)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/make.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/make.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/make.html)
