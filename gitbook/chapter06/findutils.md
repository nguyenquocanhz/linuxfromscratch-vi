---
description: "Gói Findutils chứa các chương trình để tìm tệp. Có chương trình tìm kiếm trong toàn bộ cây thư mục, cũng như tạo, duy trì và tìm trong một cơ sở dữ liệu (t"
---

# 6.8. Findutils-4.10.0

Gói Findutils chứa các chương trình để tìm tệp. Có chương trình tìm kiếm trong toàn bộ cây thư mục, cũng như tạo, duy trì và tìm trong một cơ sở dữ liệu (thường nhanh hơn find đệ quy, nhưng không đáng tin nếu cơ sở dữ liệu chưa được cập nhật gần đây). Findutils còn cung cấp chương trình `xargs`, dùng để chạy một lệnh chỉ định trên từng tệp được chọn qua tìm kiếm.

* **Thời gian dựng ước tính:** 0.2 SBU
* **Dung lượng đĩa cần:** 48 MB

## 6.8.1. Cài đặt Findutils

Chuẩn bị biên dịch Findutils:

```bash
./configure --prefix=/usr                   \
            --localstatedir=/var/lib/locate \
            --host=$LFS_TGT                 \
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

Chi tiết về gói này nằm trong [Mục 8.62.2, “Nội dung của Findutils.”](../chapter08/findutils.md#contents-findutils)

---

[Bản gốc tiếng Anh](https://www.linuxfromscratch.org/lfs/view/12.4/chapter06/findutils.html) · [Sửa bản dịch](https://github.com/nguyenquocanhz/linuxfromscratch-vi/blob/main/i18n/vi/chapter06/findutils.json) · [Đọc trên web](https://linuxfromscratch.wrenevil.tech/12.4/chapter06/findutils.html)
