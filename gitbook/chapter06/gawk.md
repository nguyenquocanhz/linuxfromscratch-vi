---
description: "Trước tiên, đảm bảo một số tệp không cần thiết sẽ không được cài đặt:"
---

# 6.9. Gawk-5.3.2

Gói Gawk chứa các chương trình để xử lý tệp văn bản.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 49 MB

## 6.9.1. Cài đặt Gawk

Trước tiên, đảm bảo một số tệp không cần thiết sẽ không được cài đặt:

```bash
sed -i 's/extras//' Makefile.in
```

Chuẩn bị biên dịch Gawk:

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

Chi tiết về gói này nằm trong [Mục 8.61.2, “Nội dung của Gawk.”](../chapter08/gawk.md#contents-gawk)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/gawk.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/gawk.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/gawk.html)
