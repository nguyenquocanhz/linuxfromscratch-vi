---
description: "Gói Tar cho phép tạo các kho lưu trữ tar cũng như thực hiện nhiều thao tác khác trên kho lưu trữ. Tar có thể dùng trên kho đã tạo trước đó để giải nén tệp,"
---

# 6.15. Tar-1.35

Gói Tar cho phép tạo các kho lưu trữ tar cũng như thực hiện nhiều thao tác khác trên kho lưu trữ. Tar có thể dùng trên kho đã tạo trước đó để giải nén tệp, thêm tệp mới vào, hoặc cập nhật và liệt kê các tệp đã lưu.

* **Thời gian dựng ước tính:** 0.1 SBU
* **Dung lượng đĩa cần:** 42 MB

## 6.15.1. Cài đặt Tar

Chuẩn bị biên dịch Tar:

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

Chi tiết về gói này nằm trong [Mục 8.71.2, “Nội dung của Tar.”](../chapter08/tar.md#contents-tar)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/tar.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/tar.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/tar.html)
